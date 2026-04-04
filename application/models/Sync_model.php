<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Sync_model — pulls items from DB2 (SQL Server / SpangleDBnew) into DB1.
 *
 * DESIGN: Each (item + color) = 1 product in DB1.
 *         All sizes for that color are stored in product_barcodes.
 *
 * Unique sync key: article_number + db2_color_no (stored on products table)
 *
 * Mapping per color group:
 *   DB2  Mst_ItemMaster.Itm_Code        →  DB1  products.article_number
 *   DB2  Scn_CoNo                        →  DB1  products.db2_color_no  (sync key)
 *   DB2  Itm_Desc + color_name           →  DB1  products_translations.title
 *   DB2  Mst_Color.Co_Desc               →  DB1  products_translations.color
 *   DB2  MIN(Sss_StockQty) across sizes  →  DB1  products.quantity  (available complete sets)
 *   DB2  Scn_Code per size               →  DB1  product_barcodes.barcode
 *   DB2  Sss_StockQty per barcode        →  DB1  product_barcodes.stock_qty
 *   DB2  Scn_PkNoLocation               →  DB1  product_barcodes.scn_pk_no_location (for dispatch deduction)
 *
 * A "set" = 1 piece of every size in the color group.
 * Available sets = MIN stock across all sizes (limiting size determines how many sets can be sold).
 * Only sizes with active stock (Sss_StockQty > 0) in companies C05/C08 are included.
 * New products are created with visibility=0, itm_synced=1.
 */
class Sync_model extends CI_Model
{
    /** @var CI_DB_pdo_driver */
    private $db2;

    public function __construct()
    {
        parent::__construct();
        $this->_ensureColumns();
        $this->_ensureBarcodesTable();
    }

    // ── Schema helpers ────────────────────────────────────────────────────────

    private function _ensureColumns()
    {
        if (!$this->db->field_exists('itm_synced', 'products')) {
            $this->db->query("ALTER TABLE `products` ADD COLUMN `itm_synced` TINYINT(1) NOT NULL DEFAULT 0 COMMENT '1 = auto-synced from DB2, awaiting admin setup'");
        }
        if (!$this->db->field_exists('db2_color_no', 'products')) {
            $this->db->query("ALTER TABLE `products` ADD COLUMN `db2_color_no` BIGINT NULL DEFAULT NULL COMMENT 'DB2 Scn_CoNo — part of unique sync key with article_number'");
        }
    }

    private function _ensureBarcodesTable()
    {
        if (!$this->db->table_exists('product_barcodes')) {
            $this->db->query("
                CREATE TABLE `product_barcodes` (
                    `id`                  INT UNSIGNED NOT NULL AUTO_INCREMENT,
                    `product_id`          INT UNSIGNED NOT NULL,
                    `barcode`             VARCHAR(100) NOT NULL,
                    `size`                VARCHAR(20)  NOT NULL DEFAULT '',
                    `stock_qty`           INT          NOT NULL DEFAULT 0,
                    `scn_pk_no_location`  BIGINT       NULL DEFAULT NULL,
                    PRIMARY KEY (`id`),
                    UNIQUE KEY `uq_barcode` (`barcode`),
                    KEY `idx_product_id` (`product_id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8
            ");
        } else {
            if (!$this->db->field_exists('stock_qty', 'product_barcodes')) {
                $this->db->query("ALTER TABLE `product_barcodes` ADD COLUMN `stock_qty` INT NOT NULL DEFAULT 0");
            }
            if (!$this->db->field_exists('scn_pk_no_location', 'product_barcodes')) {
                $this->db->query("ALTER TABLE `product_barcodes` ADD COLUMN `scn_pk_no_location` BIGINT NULL DEFAULT NULL");
            }
        }
    }

    // ── DB2 connection ────────────────────────────────────────────────────────

    private function _db2()
    {
        if (!$this->db2) {
            $this->db2 = $this->load->database('db2', TRUE);
        }
        return $this->db2;
    }

    // ── Settings ─────────────────────────────────────────────────────────────

    public function getSyncInterval()
    {
        $this->load->model('admin/Home_admin_model');
        $v = $this->Home_admin_model->getValueStore('db2_sync_interval');
        return ($v !== null) ? (int)$v : 10;
    }

    public function setSyncInterval($minutes)
    {
        $this->load->model('admin/Home_admin_model');
        $this->Home_admin_model->setValueStore('db2_sync_interval', (int)$minutes);
    }

    public function getLastSyncTime()
    {
        $this->load->model('admin/Home_admin_model');
        return $this->Home_admin_model->getValueStore('db2_last_sync');
    }

    private function _setLastSyncTime()
    {
        $this->load->model('admin/Home_admin_model');
        $this->Home_admin_model->setValueStore('db2_last_sync', time());
    }

    public function getLastSyncStats()
    {
        $this->load->model('admin/Home_admin_model');
        $raw = $this->Home_admin_model->getValueStore('db2_last_sync_stats');
        return $raw ? json_decode($raw, true) : null;
    }

    private function _saveStats($created, $updated, $skipped)
    {
        $this->load->model('admin/Home_admin_model');
        $this->Home_admin_model->setValueStore('db2_last_sync_stats', json_encode([
            'created' => $created,
            'updated' => $updated,
            'skipped' => $skipped,
        ]));
    }

    // ── Clear synced products ─────────────────────────────────────────────────

    /**
     * Delete all products synced from DB2 (itm_synced=1).
     * Manually uploaded products (itm_synced=0) are NOT touched.
     */
    public function clearSyncedProducts()
    {
        $ids = $this->db->select('id')->where('itm_synced', 1)->get('products')->result_array();
        if (empty($ids)) return 0;

        $id_list = implode(',', array_column($ids, 'id'));
        $this->db->query("DELETE FROM `products_translations` WHERE `for_id` IN ({$id_list})");
        if ($this->db->table_exists('product_variations')) {
            $this->db->query("DELETE FROM `product_variations` WHERE `product_id` IN ({$id_list})");
        }
        if ($this->db->table_exists('product_barcodes')) {
            $this->db->query("DELETE FROM `product_barcodes` WHERE `product_id` IN ({$id_list})");
        }
        $this->db->query("DELETE FROM `cart_items` WHERE `product_id` IN ({$id_list})");
        $this->db->query("DELETE FROM `products` WHERE `itm_synced` = 1");
        return count($ids);
    }

    // ── Main sync ─────────────────────────────────────────────────────────────

    /**
     * Each (item + color) from DB2 becomes one product in DB1.
     * All sizes for that color are stored as barcodes in product_barcodes.
     * Product quantity = MIN stock across all sizes (available complete sets).
     */
    public function runSync()
    {
        set_time_limit(0);

        $db2         = $this->_db2();
        $defaultLang = defined('MY_DEFAULT_LANGUAGE_ABBR') ? MY_DEFAULT_LANGUAGE_ABBR : 'en';

        // ── Step 1: Fetch all barcodes with stock from DB2 ────────────────────
        // One row per barcode. We group by (Itm_Code, Scn_CoNo) in PHP.
        $sql = "
            SELECT
                i.Itm_No,
                i.Itm_Code,
                i.Itm_Desc,
                i.Itm_Rate,
                i.Itm_MRP,
                s.Scn_Code,
                s.Scn_Size,
                s.Scn_CoNo,
                s.Scn_PkNoLocation,
                c.Co_Desc        AS color_name,
                sk.Sss_StockQty  AS stock_qty,
                sk.Sss_SzNo
            FROM dbo.Trn_ScanCode s
            JOIN dbo.Trn_StockSummarySKU sk
                ON  sk.Sss_ScnPkNoLocation = s.Scn_PkNoLocation
                AND sk.Sss_Cocode IN ('C05', 'C08')
                AND sk.Sss_StockQty > 0
            JOIN dbo.Mst_ItemMaster i
                ON  i.Itm_No = s.Scn_ItmNo
                AND i.Itm_InActiveItem = 0
            JOIN dbo.Mst_Color c
                ON  c.Co_No = s.Scn_CoNo
            WHERE s.Scn_Cocode IN ('C05', 'C08')
              AND s.Scn_Code  IS NOT NULL AND s.Scn_Code  <> ''
              AND s.Scn_Size  IS NOT NULL AND s.Scn_Size  <> ''
        ";
        $rows = $db2->query($sql)->result_array();

        // ── Step 2: Group rows by (Itm_Code + Scn_CoNo) ──────────────────────
        $groups = []; // key: "Itm_Code|Scn_CoNo"
        foreach ($rows as $row) {
            $key = trim($row['Itm_Code']) . '|' . $row['Scn_CoNo'];
            if (!isset($groups[$key])) {
                $groups[$key] = [
                    'itm_code'   => trim($row['Itm_Code']),
                    'itm_desc'   => trim($row['Itm_Desc']),
                    'wsp'        => (float)$row['Itm_Rate'],
                    'msp'        => (float)$row['Itm_MRP'],
                    'co_no'      => (int)$row['Scn_CoNo'],
                    'color_name' => trim($row['color_name']),
                    'barcodes'   => [],
                ];
            }
            $groups[$key]['barcodes'][] = [
                'barcode'            => trim($row['Scn_Code']),
                'size'               => trim($row['Scn_Size']),
                'scn_pk_no_location' => (int)$row['Scn_PkNoLocation'],
                'stock_qty'          => (int)$row['stock_qty'],
            ];
        }

        // ── Step 3: Load existing synced products from DB1 ───────────────────
        // parent_map: article_number => product_id  (db2_color_no IS NULL = parent)
        // product_map: "article_number|db2_color_no" => product_id  (color children)
        $parent_map  = [];
        $product_map = [];
        $qty_map     = [];
        $existing    = $this->db->select('id, article_number, db2_color_no, quantity')
                                 ->where('itm_synced', 1)
                                 ->get('products')->result_array();
        foreach ($existing as $r) {
            if ($r['db2_color_no'] === null || $r['db2_color_no'] === '') {
                $parent_map[$r['article_number']] = (int)$r['id'];
            } else {
                $k               = $r['article_number'] . '|' . $r['db2_color_no'];
                $product_map[$k] = (int)$r['id'];
            }
            $qty_map[(int)$r['id']] = (int)$r['quantity'];
        }

        // Load existing barcodes: barcode => {product_id, stock_qty}
        $barcode_map = [];
        if ($this->db->table_exists('product_barcodes')) {
            $pb_rows = $this->db->select('barcode, product_id, stock_qty')->get('product_barcodes')->result_array();
            foreach ($pb_rows as $r) {
                $barcode_map[$r['barcode']] = [
                    'product_id' => (int)$r['product_id'],
                    'stock_qty'  => (int)$r['stock_qty'],
                ];
            }
        }

        // Collect unique item codes so we can create parents first
        $itm_info = []; // article_number => [itm_desc, wsp, msp]
        foreach ($groups as $group) {
            $itm_info[$group['itm_code']] = [
                'itm_desc' => $group['itm_desc'],
                'wsp'      => $group['wsp'],
                'msp'      => $group['msp'],
            ];
        }

        // ── Step 3b: Ensure a parent product exists per item code ─────────────
        $now = time();
        foreach ($itm_info as $itm_code => $info) {
            if (!isset($parent_map[$itm_code])) {
                $this->db->insert('products', [
                    'article_number' => $itm_code,
                    'db2_color_no'   => null,
                    'parent_id'      => 0,
                    'quantity'       => 0,
                    'visibility'     => 0,
                    'itm_synced'     => 1,
                    'image'          => '',
                    'shop_categorie' => 0,
                    'in_slider'      => 0,
                    'position'       => 9999,
                    'time'           => $now,
                ]);
                $par_id = $this->db->insert_id();
                $this->db->where('id', $par_id)
                         ->update('products', ['url' => $this->_makeUrl($info['itm_desc']) . '_' . $par_id]);
                $this->db->insert('products_translations', [
                    'for_id'            => $par_id,
                    'abbr'              => $defaultLang,
                    'title'             => $info['itm_desc'],
                    'description'       => '',
                    'basic_description' => '',
                    'price'             => $info['msp'],
                    'wsp'               => $info['wsp'],
                    'msp'               => $info['msp'],
                    'old_price'         => 0,
                    'color'             => '',
                    'size_range'        => '',
                ]);
                $parent_map[$itm_code] = $par_id;
            }
        }

        // ── Step 4: Process each color group ─────────────────────────────────
        $created               = 0;
        $updated               = 0;
        $skipped               = 0;
        $qty_updates           = []; // product_id => new_qty
        $barcode_stock_updates = []; // barcode => new_stock_qty

        foreach ($groups as $key => $group) {
            if (empty($group['barcodes'])) { $skipped++; continue; }

            // Set size = count of sizes that have stock > 0
            $in_stock_barcodes = array_filter($group['barcodes'], fn($b) => $b['stock_qty'] > 0);
            $set_size = count($in_stock_barcodes);
            if ($set_size <= 0) { $skipped++; continue; }
            $title     = $group['itm_desc'] . ' ' . $group['color_name'];
            $parent_id = $parent_map[$group['itm_code']] ?? 0;

            if (isset($product_map[$key])) {
                // ── Existing color product ────────────────────────────────────
                $pid = $product_map[$key];

                // Ensure parent_id is set (may be missing on older rows)
                if ($parent_id) {
                    $this->db->where('id', $pid)->where('parent_id', 0)
                             ->update('products', ['parent_id' => $parent_id]);
                }

                if (($qty_map[$pid] ?? -1) !== $set_size) {
                    $qty_updates[$pid] = $set_size;
                }

                foreach ($group['barcodes'] as $bc) {
                    if (isset($barcode_map[$bc['barcode']])) {
                        if ($barcode_map[$bc['barcode']]['stock_qty'] !== $bc['stock_qty']) {
                            $barcode_stock_updates[$bc['barcode']] = $bc['stock_qty'];
                        }
                    } else {
                        $this->db->insert('product_barcodes', [
                            'product_id'         => $pid,
                            'barcode'            => $bc['barcode'],
                            'size'               => $bc['size'],
                            'stock_qty'          => $bc['stock_qty'],
                            'scn_pk_no_location' => $bc['scn_pk_no_location'],
                        ]);
                    }
                }
                $updated++;
            } else {
                // ── New color product ─────────────────────────────────────────
                $this->db->insert('products', [
                    'article_number' => $group['itm_code'],
                    'db2_color_no'   => $group['co_no'],
                    'parent_id'      => $parent_id,
                    'quantity'       => $set_size,
                    'visibility'     => 0,
                    'itm_synced'     => 1,
                    'image'          => '',
                    'shop_categorie' => 0,
                    'in_slider'      => 0,
                    'position'       => 9999,
                    'time'           => $now,
                ]);
                $product_id = $this->db->insert_id();

                $this->db->where('id', $product_id)
                         ->update('products', ['url' => $this->_makeUrl($title) . '_' . $product_id]);

                $size_labels = array_column($group['barcodes'], 'size');
                sort($size_labels);

                $this->db->insert('products_translations', [
                    'for_id'            => $product_id,
                    'abbr'              => $defaultLang,
                    'title'             => $title,
                    'description'       => '',
                    'basic_description' => '',
                    'price'             => $group['msp'],
                    'wsp'               => $group['wsp'],
                    'msp'               => $group['msp'],
                    'old_price'         => 0,
                    'color'             => $group['color_name'],
                    'size_range'        => implode(', ', $size_labels),
                ]);

                foreach ($group['barcodes'] as $bc) {
                    $this->db->insert('product_barcodes', [
                        'product_id'         => $product_id,
                        'barcode'            => $bc['barcode'],
                        'size'               => $bc['size'],
                        'stock_qty'          => $bc['stock_qty'],
                        'scn_pk_no_location' => $bc['scn_pk_no_location'],
                    ]);
                }

                $created++;
            }
        }

        // ── Step 5: Batch update product quantities ───────────────────────────
        foreach (array_chunk($qty_updates, 500, true) as $chunk) {
            $ids   = implode(',', array_keys($chunk));
            $cases = '';
            foreach ($chunk as $pid => $qty) {
                $cases .= " WHEN {$pid} THEN {$qty}";
            }
            $this->db->query(
                "UPDATE `products` SET `quantity` = CASE `id`{$cases} END WHERE `id` IN ({$ids})"
            );
        }

        // ── Step 6: Update individual barcode stocks ──────────────────────────
        foreach ($barcode_stock_updates as $barcode => $new_qty) {
            $this->db->where('barcode', $barcode)
                     ->update('product_barcodes', ['stock_qty' => $new_qty]);
        }

        $this->_setLastSyncTime();
        $this->_saveStats($created, $updated, $skipped);

        return ['created' => $created, 'updated' => $updated, 'skipped' => $skipped];
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    private function _makeUrl($str)
    {
        $str = strtolower(trim($str));
        $str = preg_replace('/[^a-z0-9]+/', '-', $str);
        return trim($str, '-');
    }

    public function getDB2ItemCount()
    {
        try {
            $db2 = $this->_db2();
            return (int)$db2->query("
                SELECT COUNT(*) AS cnt FROM (
                    SELECT DISTINCT s.Scn_ItmNo, s.Scn_CoNo
                    FROM dbo.Trn_ScanCode s
                    JOIN dbo.Trn_StockSummarySKU sk
                        ON  sk.Sss_ScnPkNoLocation = s.Scn_PkNoLocation
                        AND sk.Sss_Cocode IN ('C05', 'C08')
                        AND sk.Sss_StockQty > 0
                    JOIN dbo.Mst_ItemMaster i
                        ON  i.Itm_No = s.Scn_ItmNo
                        AND i.Itm_InActiveItem = 0
                    WHERE s.Scn_Cocode IN ('C05', 'C08')
                      AND s.Scn_Code IS NOT NULL AND s.Scn_Code <> ''
                      AND s.Scn_Size IS NOT NULL AND s.Scn_Size <> ''
                ) t
            ")->row_array()['cnt'];
        } catch (Exception) {
            return 0;
        }
    }

    public function getPendingSetupCount()
    {
        return (int)$this->db->where('itm_synced', 1)->where('image', '')->count_all_results('products');
    }

    // ── Stock deduction on dispatch ───────────────────────────────────────────

    /**
     * Deduct N sets from a product's stock in both DB1 and DB2.
     * Called when an order is marked dispatched.
     *
     * @param int $product_id  DB1 product id
     * @param int $sets        Number of sets dispatched
     * @return bool
     */
    public function deductStock($product_id, $sets)
    {
        if ($sets <= 0) return false;

        $barcodes = $this->db->select('barcode, stock_qty')
                             ->where('product_id', $product_id)
                             ->get('product_barcodes')->result_array();

        if (empty($barcodes)) return false;

        // Update DB1 only — DB2 stock is managed exclusively by the ERP (SpangleDBnew).
        // Trn_StockSummarySKU is recomputed by the ERP from its own transaction tables;
        // writing to it directly bypasses that accounting and breaks the ERP display.
        // The sync will pull the correct updated values from DB2 on the next run.
        foreach ($barcodes as $bc) {
            if ((int)$bc['stock_qty'] <= 0) continue;

            $new_qty = max(0, (int)$bc['stock_qty'] - $sets);
            $this->db->where('barcode', $bc['barcode'])
                     ->update('product_barcodes', ['stock_qty' => $new_qty]);
        }

        // Recalculate: set size = count of sizes still in stock after deduction
        $new_product_qty = (int)$this->db->where('product_id', $product_id)
                                         ->where('stock_qty >', 0)
                                         ->count_all_results('product_barcodes');
        $this->db->where('id', $product_id)->update('products', ['quantity' => $new_product_qty]);

        return true;
    }
}
