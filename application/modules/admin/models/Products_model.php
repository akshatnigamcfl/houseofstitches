<?php

class Products_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->_ensureProductColumns();
    }

    private function _ensureProductColumns()
    {
        if (!$this->db->field_exists('parent_id', 'products')) {
            $this->db->query("ALTER TABLE `products` ADD COLUMN `parent_id` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '0 = standalone/parent, >0 = child of that product id'");
        }
        $cols = ['season' => 'VARCHAR(100)', 'gender' => 'VARCHAR(50)', 'fabric' => 'VARCHAR(100)', 'brand' => 'VARCHAR(100)', 'sub_category' => 'VARCHAR(150)', 'fabric_category' => 'VARCHAR(150)', 'fabric_type' => 'VARCHAR(150)', 'fabric_composition' => 'VARCHAR(255)'];
        foreach ($cols as $col => $type) {
            if (!$this->db->field_exists($col, 'products_translations')) {
                $this->db->query("ALTER TABLE `products_translations` ADD COLUMN `$col` $type DEFAULT NULL");
            }
        }
        if (!$this->db->field_exists('article_number', 'products')) {
            $this->db->query("ALTER TABLE `products` ADD COLUMN `article_number` VARCHAR(100) DEFAULT NULL");
        }
        // Fix gender column if it exists as a numeric type (tinyint) instead of VARCHAR
        $genderInfo = $this->db->query("SHOW COLUMNS FROM `products_translations` LIKE 'gender'")->row_array();
        if ($genderInfo && stripos($genderInfo['Type'], 'int') !== false) {
            $this->db->query("ALTER TABLE `products_translations` MODIFY COLUMN `gender` VARCHAR(50) DEFAULT NULL");
            $this->db->query("UPDATE `products_translations` SET `gender` = NULL WHERE `gender` = '0' OR `gender` = ''");
        }
        // Fix folder column — was int, needs to be VARCHAR to store names like 'p12345'
        $folderInfo = $this->db->query("SHOW COLUMNS FROM `products` LIKE 'folder'")->row_array();
        if ($folderInfo && stripos($folderInfo['Type'], 'int') !== false) {
            $this->db->query("ALTER TABLE `products` MODIFY COLUMN `folder` VARCHAR(255) DEFAULT NULL");
        }
    }

    public function deleteProduct($id)
    {
        $this->db->trans_begin();
        $this->db->where('for_id', $id);
        if (!$this->db->delete('products_translations')) {
            log_message('error', print_r($this->db->error(), true));
        }

        $this->db->where('id', $id);
        if (!$this->db->delete('products')) {
            log_message('error', print_r($this->db->error(), true));
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            show_error(lang('database_error'));
        } else {
            $this->db->trans_commit();
        }
    }

    public function productsCount($search_title = null, $category = null)
    {
        if ($search_title != null) {
            $search_title = trim($this->db->escape_like_str($search_title));
            $this->db->where("(products_translations.title LIKE '%$search_title%' OR products.article_number LIKE '%$search_title%')");
        }
        if ($category != null) {
            $this->db->where('shop_categorie', $category);
        }
        if (isset($_GET['itm_synced']) && $_GET['itm_synced'] == '1') {
            $this->db->where('products.itm_synced', 1)->where('products.image', '');
        }
        // Exclude DB2 parent container products (they have no color and are not purchasable)
        $this->db->where("(products.itm_synced = 0 OR products.db2_color_no IS NOT NULL)");
        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'left');
        $this->db->where('products_translations.abbr', MY_DEFAULT_LANGUAGE_ABBR);
        return $this->db->count_all_results('products');
    }

    public function getProducts($limit, $page, $search_title = null, $orderby = null, $category = null, $vendor = null)
    {
        if ($search_title != null) {
            $search_title = trim($this->db->escape_like_str($search_title));
            $this->db->where("(products_translations.title LIKE '%$search_title%' OR products.article_number LIKE '%$search_title%')");
        }
        if ($orderby !== null) {
            $ord = explode('=', $orderby);
            if (isset($ord[0]) && isset($ord[1])) {
                $this->db->order_by('products.' . $ord[0], $ord[1]);
            }
        } else {
            $this->db->order_by('products.position', 'asc');
        }
        if ($category != null) {
            $this->db->where('shop_categorie', $category);
        }
        if ($vendor != null) {
            $this->db->where('vendor_id', $vendor);
        }
        if (isset($_GET['itm_synced']) && $_GET['itm_synced'] == '1') {
            $this->db->where('products.itm_synced', 1)->where('products.image', '');
        }
        // Exclude DB2 parent container products (they have no color and are not purchasable)
        $this->db->where("(products.itm_synced = 0 OR products.db2_color_no IS NOT NULL)");
        $this->db->join('vendors', 'vendors.id = products.vendor_id', 'left');
        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'left');
        $this->db->where('products_translations.abbr', MY_DEFAULT_LANGUAGE_ABBR);
        $query = $this->db->select('vendors.name as vendor_name, vendors.id as vendor_id, products.*, products_translations.title, products_translations.description, products_translations.price, products_translations.old_price,products_translations.wsp,products_translations.msp,products_translations.color,products_translations.size_range, products_translations.abbr, products.url, products_translations.for_id, products_translations.basic_description')->get('products', $limit, $page);
        
        return $query->result();
    }

    public function numShopProducts()
    {
        return $this->db->count_all_results('products');
    }

    public function getOneProduct($id)
    {
        $this->db->select('vendors.name as vendor_name, vendors.id as vendor_id, products.*,
        products_translations.price,
        products_translations.size_range,
        products_translations.msp,
        products_translations.wsp,
        products_translations.color,
        products_translations.season,
        products_translations.gender,
        products_translations.fabric,
        products_translations.brand,
        products_translations.sub_category,
        products_translations.fabric_category,
        products_translations.fabric_type,
        products_translations.fabric_composition');
        $this->db->where('products.id', $id);
        $this->db->join('vendors', 'vendors.id = products.vendor_id', 'left');
        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'inner');
        $this->db->where('products_translations.abbr', MY_DEFAULT_LANGUAGE_ABBR);
        $query = $this->db->get('products');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function productStatusChange($id, $to_status)
    {
        $this->db->where('id', $id);
        $result = $this->db->update('products', array('visibility' => $to_status));
        return $result;
    }

    public function setProduct($post, $id = 0)
    {
        if (!isset($post['brand_id'])) {
            $post['brand_id'] = null;
        }
        if (!isset($post['virtual_products'])) {
            $post['virtual_products'] = null;
        }
        $this->db->trans_begin();
        $is_update = false;
        if ($id > 0) {
            $is_update = true;
            if (!$this->db->where('id', $id)->update('products', array(
                        'image' => $post['image'] != null ? $_POST['image'] : $_POST['old_image'],
                        'shop_categorie' => $post['shop_categorie'],
                        'quantity' => $post['quantity'],
                        'in_slider' => $post['in_slider'],
                        'position' => $post['position'],
                        'virtual_products' => $post['virtual_products'],
                        'brand_id' => $post['brand_id'],
                        'article_number' => isset($post['article_number']) ? trim($post['article_number']) : null,
                        'time_update' => time()
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }
        } else {
            /*
             * Lets get what is default tranlsation number
             * in titles and convert it to url
             * We want our plaform public ulrs to be in default 
             * language that we use
             */
            $i = 0;
            foreach ($_POST['translations'] as $translation) {
                if ($translation == MY_DEFAULT_LANGUAGE_ABBR) {
                    $myTranslationNum = $i;
                }
                $i++;
            }
            if (!$this->db->insert('products', array(
                        'image' => $post['image'],
                        'shop_categorie' => $post['shop_categorie'],
                        'quantity' => $post['quantity'],
                        'in_slider' => $post['in_slider'],
                        'position' => $post['position'],
                        'virtual_products' => $post['virtual_products'],
                        'folder' => $post['folder'],
                        'brand_id' => $post['brand_id'],
                        'article_number' => isset($post['article_number']) ? trim($post['article_number']) : null,
                        'time' => time()
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }
            $id = $this->db->insert_id();

            $this->db->where('id', $id);
            if (!$this->db->update('products', array(
                        'url' => except_letters($_POST['title'][$myTranslationNum]) . '_' . $id
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }
        }
        $this->setProductTranslation($post, $id, $is_update);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            show_error(lang('database_error'));
        } else {
            $this->db->trans_commit();
        }
        return $id;
    }

    public function saveVariations($product_id, $colors, $sizes, $swatches = [], $hexes = [], $images = [])
    {
        $this->db->query("CREATE TABLE IF NOT EXISTS `product_variations` (
            `id` int NOT NULL AUTO_INCREMENT,
            `product_id` int NOT NULL,
            `color` varchar(100) DEFAULT NULL,
            `sizes` varchar(500) DEFAULT NULL,
            `swatch` varchar(200) DEFAULT NULL,
            `hex` varchar(20) DEFAULT NULL,
            `images` TEXT DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `product_id` (`product_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3");

        if (!$this->db->field_exists('swatch', 'product_variations')) {
            $this->db->query("ALTER TABLE `product_variations` ADD COLUMN `swatch` varchar(200) DEFAULT NULL");
        }
        if (!$this->db->field_exists('hex', 'product_variations')) {
            $this->db->query("ALTER TABLE `product_variations` ADD COLUMN `hex` varchar(20) DEFAULT NULL");
        }
        if (!$this->db->field_exists('images', 'product_variations')) {
            $this->db->query("ALTER TABLE `product_variations` ADD COLUMN `images` TEXT DEFAULT NULL");
        }

        // Preserve existing swatches/images for rows that don't have a new upload
        $existing = [];
        $rows = $this->db->where('product_id', $product_id)->get('product_variations')->result_array();
        foreach ($rows as $r) {
            $existing[] = ['swatch' => $r['swatch'], 'images' => $r['images'] ?? ''];
        }

        $this->db->where('product_id', $product_id)->delete('product_variations');

        foreach ($colors as $i => $color) {
            $color = trim($color);
            $size  = isset($sizes[$i]) ? trim($sizes[$i]) : '';
            $hex   = isset($hexes[$i]) ? trim($hexes[$i]) : '';
            if ($color === '' && $size === '' && empty($swatches[$i]) && empty($images[$i])) {
                continue;
            }
            $swatch = '';
            if (!empty($swatches[$i])) {
                $swatch = trim($swatches[$i]);
            } elseif (isset($existing[$i]['swatch']) && $existing[$i]['swatch'] !== '') {
                $swatch = $existing[$i]['swatch'];
            }
            $imgs = '';
            if (!empty($images[$i])) {
                $imgs = trim($images[$i]);
            } elseif (isset($existing[$i]['images']) && $existing[$i]['images'] !== '') {
                $imgs = $existing[$i]['images'];
            }
            $this->db->insert('product_variations', [
                'product_id' => $product_id,
                'color'      => $color,
                'sizes'      => $size,
                'swatch'     => $swatch,
                'hex'        => $hex,
                'images'     => $imgs,
            ]);
        }
    }

    public function getVariations($product_id)
    {
        if (!$this->db->table_exists('product_variations')) {
            return [];
        }
        if (!$this->db->field_exists('swatch', 'product_variations')) {
            $this->db->query("ALTER TABLE `product_variations` ADD COLUMN `swatch` varchar(200) DEFAULT NULL");
        }
        if (!$this->db->field_exists('hex', 'product_variations')) {
            $this->db->query("ALTER TABLE `product_variations` ADD COLUMN `hex` varchar(20) DEFAULT NULL");
        }
        if (!$this->db->field_exists('images', 'product_variations')) {
            $this->db->query("ALTER TABLE `product_variations` ADD COLUMN `images` TEXT DEFAULT NULL");
        }
        return $this->db->where('product_id', $product_id)
                        ->get('product_variations')
                        ->result_array();
    }

    // ── Parent / Child product methods ───────────────────────────────────────

    /**
     * Get all child products of a parent, with title + image.
     */
    public function getChildren($parent_id)
    {
        return $this->db
            ->select('products.id, products.image, products.quantity, products.visibility, products.article_number, products_translations.title, products_translations.color, products_translations.size_range, products_translations.wsp, products_translations.msp')
            ->join('products_translations', 'products_translations.for_id = products.id', 'left')
            ->where('products_translations.abbr', MY_DEFAULT_LANGUAGE_ABBR)
            ->where('products.parent_id', (int)$parent_id)
            ->get('products')
            ->result_array();
    }

    /**
     * Set a product as a child of $parent_id. Pass 0 to unlink.
     */
    public function setParentId($product_id, $parent_id)
    {
        return $this->db->where('id', (int)$product_id)
                        ->update('products', ['parent_id' => (int)$parent_id]);
    }

    /**
     * Search products by title or article_number for the link-child autocomplete.
     * Excludes the parent product itself and products that already have children (can't be children of something else and parents at the same time).
     */
    public function searchForLinking($q, $exclude_id)
    {
        $safe = $this->db->escape_like_str(trim($q));
        return $this->db
            ->select('products.id, products_translations.title, products.image, products.article_number, products.parent_id')
            ->join('products_translations', 'products_translations.for_id = products.id', 'left')
            ->where('products_translations.abbr', MY_DEFAULT_LANGUAGE_ABBR)
            ->where("products.id != " . (int)$exclude_id)
            ->where("(products_translations.title LIKE '%{$safe}%' OR products.article_number LIKE '%{$safe}%')")
            ->limit(10)
            ->get('products')
            ->result_array();
    }

    private function setProductTranslation($post, $id, $is_update)
    {   
        $i = 0;
        $current_trans = $this->getTranslations($id);
        foreach ($post['translations'] as $abbr) {
            $arr = array();
            $emergency_insert = false;
            if (!isset($current_trans[$abbr])) {
                $emergency_insert = true;
            }
            $post['title'][$i] = str_replace('"', "'", $post['title'][$i]);
            $post['price'][$i] = str_replace(' ', '', $post['price'][$i]);
            $post['price'][$i] = str_replace(',', '.', $post['price'][$i]);
            $post['price'][$i] = preg_replace("/[^0-9,.]/", "", $post['price'][$i]);
            $post['msp'][$i] = preg_replace("/[^0-9,.]/", "", $post['msp'][$i]);
            $post['wsp'][$i] = preg_replace("/[^0-9,.]/", "", $post['wsp'][$i]);
            $post['old_price'][$i] = str_replace(' ', '', $post['old_price'][$i]);
            $post['old_price'][$i] = str_replace(',', '.', $post['old_price'][$i]);
            $post['old_price'][$i] = preg_replace("/[^0-9,.]/", "", $post['old_price'][$i]);
            $arr = array(
                'title' => $post['title'][$i],
                'basic_description' => $post['basic_description'][$i],
                'description' => $post['description'][$i],
                'price' => $post['price'][$i],
                'msp' => $post['msp'][$i],
                'wsp' => $post['wsp'][$i],
                'old_price' => $post['old_price'][$i],
                'color' => isset($post['color']) ? $post['color'] : '',
                'size_range' => isset($post['size_range']) ? $post['size_range'] : '',
                'season' => isset($post['season']) ? $post['season'] : '',
                'gender' => isset($post['gender']) ? $post['gender'] : '',
                'fabric' => isset($post['fabric']) ? $post['fabric'] : '',
                'brand' => isset($post['brand']) ? $post['brand'] : '',
                'sub_category' => isset($post['sub_category']) ? $post['sub_category'] : '',
                'fabric_category' => isset($post['fabric_category']) ? $post['fabric_category'] : '',
                'fabric_type' => isset($post['fabric_type']) ? $post['fabric_type'] : '',
                'fabric_composition' => isset($post['fabric_composition']) ? $post['fabric_composition'] : '',
                'abbr' => $abbr,
                'for_id' => $id
            );
            
            if ($is_update === true && $emergency_insert === false) {
                $abbr = $arr['abbr'];
                unset($arr['for_id'], $arr['abbr'], $arr['url']);
                if (!$this->db->where('abbr', $abbr)->where('for_id', $id)->update('products_translations', $arr)) {
                    log_message('error', print_r($this->db->error(), true));
                }
            } else {
                if (!$this->db->insert('products_translations', $arr)) {
                    log_message('error', print_r($this->db->error(), true));
                }
            }
            $i++;
        }
    }

    public function getTranslations($id)
    {
        $this->db->where('for_id', $id);
        $query = $this->db->get('products_translations');
        $arr = array();
        foreach ($query->result() as $row) {
            $arr[$row->abbr]['title'] = $row->title;
            $arr[$row->abbr]['basic_description'] = $row->basic_description;
            $arr[$row->abbr]['description'] = $row->description;
            $arr[$row->abbr]['price'] = $row->price;
            $arr[$row->abbr]['old_price'] = $row->old_price;
        }
        return $arr;
    }

}
