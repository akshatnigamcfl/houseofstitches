<?php

class Orders_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('encryption');
        $this->load->helper('ledger_helper');
        $this->_ensure_order_columns();
        $this->_ensure_payments_table();
        $this->_ensure_commissions_table();
    }

    private function _ensure_order_columns()
    {
        // orders_clients
        if (!$this->db->field_exists('company', 'orders_clients')) {
            $this->db->query('ALTER TABLE `orders_clients` ADD COLUMN `company` VARCHAR(200) NOT NULL DEFAULT \'\' AFTER `first_name`');
        }
        if (!$this->db->field_exists('gst', 'orders_clients')) {
            $this->db->query('ALTER TABLE `orders_clients` ADD COLUMN `gst` VARCHAR(50) NOT NULL DEFAULT \'\' AFTER `company`');
        }
        // orders: dispatch, tracking, billing, payment columns
        $add = [
            'dispatch_products'  => 'ALTER TABLE `orders` ADD COLUMN `dispatch_products` LONGBLOB NULL DEFAULT NULL',
            'tracking_courier'   => 'ALTER TABLE `orders` ADD COLUMN `tracking_courier` VARCHAR(100) NULL DEFAULT NULL',
            'tracking_id'        => 'ALTER TABLE `orders` ADD COLUMN `tracking_id` VARCHAR(100) NULL DEFAULT NULL',
            'billed_to_user_id'  => 'ALTER TABLE `orders` ADD COLUMN `billed_to_user_id` INT UNSIGNED NULL DEFAULT NULL',
            'billing_amount'     => 'ALTER TABLE `orders` ADD COLUMN `billing_amount` DECIMAL(10,2) NULL DEFAULT NULL',
            'payment_status'     => 'ALTER TABLE `orders` ADD COLUMN `payment_status` TINYINT NOT NULL DEFAULT 0',
            'paid_amount'        => 'ALTER TABLE `orders` ADD COLUMN `paid_amount` DECIMAL(10,2) NOT NULL DEFAULT 0.00',
        ];
        foreach ($add as $col => $sql) {
            if (!$this->db->field_exists($col, 'orders')) {
                $this->db->query($sql);
            }
        }
        // expected dispatch date entered by user at checkout
        if (!$this->db->field_exists('expected_dispatch_date', 'orders')) {
            $this->db->query("ALTER TABLE `orders` ADD COLUMN `expected_dispatch_date` VARCHAR(20) NULL DEFAULT NULL");
        }
        // Ensure article_number exists on products (used in order serialization)
        if ($this->db->table_exists('products') && !$this->db->field_exists('article_number', 'products')) {
            $this->db->query("ALTER TABLE `products` ADD COLUMN `article_number` VARCHAR(100) NULL DEFAULT NULL");
        }
    }

    private function _ensure_payments_table()
    {
        if (!$this->db->table_exists('payments')) {
            $this->db->query("CREATE TABLE `payments` (
                `id`           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `order_id`     INT UNSIGNED NOT NULL,
                `user_id`      INT UNSIGNED NOT NULL,
                `amount`       DECIMAL(10,2) NOT NULL DEFAULT 0.00,
                `mode`         VARCHAR(50)   NOT NULL DEFAULT 'bank',
                `reference`    VARCHAR(100)  NOT NULL DEFAULT '',
                `notes`        TEXT,
                `receipt_file` VARCHAR(255)  NOT NULL DEFAULT '',
                `status`       ENUM('pending','verified','rejected') NOT NULL DEFAULT 'pending',
                `verified_at`  INT UNSIGNED  NULL DEFAULT NULL,
                `recorded_at`  INT UNSIGNED  NOT NULL,
                INDEX `idx_order_id` (`order_id`),
                INDEX `idx_user_id`  (`user_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
        } else {
            // Add columns if payments table already exists from older schema
            if (!$this->db->field_exists('receipt_file', 'payments')) {
                $this->db->query("ALTER TABLE `payments` ADD COLUMN `receipt_file` VARCHAR(255) NOT NULL DEFAULT ''");
            }
            if (!$this->db->field_exists('status', 'payments')) {
                $this->db->query("ALTER TABLE `payments` ADD COLUMN `status` ENUM('pending','verified','rejected') NOT NULL DEFAULT 'pending'");
            }
            if (!$this->db->field_exists('verified_at', 'payments')) {
                $this->db->query("ALTER TABLE `payments` ADD COLUMN `verified_at` INT UNSIGNED NULL DEFAULT NULL");
            }
        }
    }

    private function _ensure_commissions_table()
    {
        if (!$this->db->table_exists('commissions')) {
            $this->db->query("CREATE TABLE `commissions` (
                `id`                          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `agent_id`                    INT UNSIGNED NOT NULL,
                `retailer_id`                 INT UNSIGNED NOT NULL,
                `order_id`                    INT UNSIGNED NOT NULL,
                `order_amount`                DECIMAL(10,2) NOT NULL DEFAULT 0.00,
                `commission_rate`             DECIMAL(5,2)  NOT NULL DEFAULT 0.00,
                `commission_amt`              DECIMAL(10,2) NOT NULL DEFAULT 0.00,
                `status`                      ENUM('pending','payable','paid') NOT NULL DEFAULT 'pending',
                `disbursement_requested_at`   INT UNSIGNED NULL DEFAULT NULL,
                `date`                        INT UNSIGNED NOT NULL,
                INDEX `idx_agent_id`  (`agent_id`),
                INDEX `idx_order_id`  (`order_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
        } else {
            // Upgrade existing table: add 'payable' to ENUM and disbursement_requested_at column
            $this->db->query("ALTER TABLE `commissions` MODIFY COLUMN `status` ENUM('pending','payable','paid') NOT NULL DEFAULT 'pending'");
            if (!$this->db->field_exists('disbursement_requested_at', 'commissions')) {
                $this->db->query("ALTER TABLE `commissions` ADD COLUMN `disbursement_requested_at` INT UNSIGNED NULL DEFAULT NULL");
            }
        }
    }

    public function ordersCount($onlyNew = false, $status = null)
    {
        if ($onlyNew == true) {
            $this->db->where('viewed', 0);
        }
        if ($status !== null) {
            $this->db->where('processed', $status);
        }
        return $this->db->count_all_results('orders');
    }

    public function orders($limit, $page, $order_by)
    {
        if ($order_by != null) {
            $this->db->order_by($order_by, 'DESC');
        } else {
            $this->db->order_by('id', 'DESC');
        }
        $this->db->select('orders.*, orders_clients.first_name, orders_clients.company, orders_clients.gst,'
                . ' orders_clients.last_name, orders_clients.email, orders_clients.phone, '
                . 'orders_clients.address, orders_clients.city, orders_clients.post_code,'
                . ' orders_clients.notes, discount_codes.type as discount_type, discount_codes.amount as discount_amount,'
                . ' users_public.company as buyer_company, users_public.name as buyer_contact, users_public.gst as buyer_gst');
        $this->db->join('orders_clients', 'orders_clients.for_id = orders.id AND orders_clients.id = (SELECT MAX(oc.id) FROM orders_clients oc WHERE oc.for_id = orders.id)', 'left');
        $this->db->join('discount_codes', 'discount_codes.code = orders.discount_code', 'left');
        $this->db->join('users_public', 'users_public.id = orders.user_id', 'left');
        $result = $this->db->get('orders', $limit, $page)->result_array();
        //$result = $result->result_array();
        if(!count($result)) return $result;
        
        foreach($result as $k => $v) {
            $result[$k] = array_map(function($v) {
                $d = $this->encryption->decrypt($v);
                return $d !== false ? $d : $v;
            }, $v);
        }

        return $result;
    }

    public function changeOrderStatus($id, $to_status)
    {
        $this->db->where('id', $id);
        $this->db->select('processed');
        $result1 = $this->db->get('orders');
        $res = $result1->row_array();
        $current = (int)$res['processed'];
        $to_status = (int)$to_status;

        $result = true;
        if ($current != $to_status) {
            $this->db->where('id', $id);
            $result = $this->db->update('orders', array('processed' => $to_status, 'viewed' => '1'));
            if ($result == true) {
                $this->manageQuantitiesAndProcurement($id, $to_status, $current);
                // When marked Processed: confirm any pending commission for this order
                if ($to_status === 1 && $this->db->table_exists('commissions')) {
                    $order = $this->db->select('billed_to_user_id, user_id')->where('id', $id)->get('orders')->row_array();
                    if (!empty($order['billed_to_user_id']) && (int)$order['billed_to_user_id'] !== (int)$order['user_id']) {
                        $parent = $this->db->select('type')->where('id', (int)$order['billed_to_user_id'])->get('users_public')->row();
                        if ($parent && (int)$parent->type === 1) {
                            // Parent is an agent — commission already exists, status stays 'pending' until paid
                        }
                    }
                }
                // Stock deduction/restoration for DB2-synced products is handled
                // inside manageQuantitiesAndProcurement() via Sync_model::deductStock()
            }
        }
        return $result;
    }

    private function manageQuantitiesAndProcurement($id, $to_status, $current)
    {
        // Restore DB1 stock when reverting FROM Ready to Dispatch (3)
        if (in_array($to_status, [0, 1, 2]) && $current == 3) {
            $operator = '+';
            $operator_pro = '-';
        }
        // Deduct DB1 stock when marking Ready to Dispatch (3)
        if ($to_status == 3) {
            $operator = '-';
            $operator_pro = '+';
        }

        if (!isset($operator)) return; // no stock change needed for other transitions

        $this->db->select('products, dispatch_products');
        $this->db->where('id', $id);
        $arr = $this->db->get('orders')->row_array();
        $products = @unserialize($arr['products']);
        $dispatch = @unserialize($arr['dispatch_products']) ?: [];

        if (!is_array($products)) return;

        foreach ($products as $product) {
            $pid = (int)($product['product_info']['id'] ?? 0);
            if (!$pid || !is_numeric($product['product_quantity'])) continue;

            $set_count = (int)($product['set_count'] ?? 1);
            if ($set_count <= 0) $set_count = 1;

            // Check if this is a DB2-synced product
            $p = $this->db->select('itm_synced')->where('id', $pid)->get('products')->row_array();
            $is_synced = !empty($p) && (int)$p['itm_synced'] === 1;

            if ($is_synced && $this->db->table_exists('product_barcodes')) {
                // DB2-synced: per-barcode deduction via Sync_model
                if ($to_status == 3) {
                    $this->load->model('Sync_model');
                    $this->Sync_model->deductStock($pid, $set_count);
                } elseif ($operator === '+') {
                    // Restoring — add back set_count to each in-stock barcode
                    $barcodes = $this->db->select('barcode, stock_qty')->where('product_id', $pid)->get('product_barcodes')->result_array();
                    foreach ($barcodes as $bc) {
                        $this->db->where('barcode', $bc['barcode'])
                                 ->update('product_barcodes', ['stock_qty' => (int)$bc['stock_qty'] + $set_count]);
                    }
                    // Recalculate product quantity as count of in-stock sizes
                    $new_qty = (int)$this->db->where('product_id', $pid)->where('stock_qty >', 0)->count_all_results('product_barcodes');
                    $this->db->where('id', $pid)->update('products', ['quantity' => $new_qty]);
                }
            } else {
                // Manual product: simple quantity adjustment
                $qty = isset($dispatch[$pid]) ? (int)$dispatch[$pid] : (int)$product['product_quantity'];
                if ($qty <= 0) continue;
                if (!$this->db->query('UPDATE products SET quantity=quantity' . $operator . $qty . ' WHERE id = ' . $pid)) {
                    log_message('error', print_r($this->db->error(), true));
                }
                if (!$this->db->query('UPDATE products SET procurement=procurement' . $operator_pro . $qty . ' WHERE id = ' . $pid)) {
                    log_message('error', print_r($this->db->error(), true));
                }
            }
        }
    }

    /**
     * Deduct dispatch quantities from DB2 (Trn_StockDetails) when order is marked Ready to Dispatch.
     * Greedy deduction: drains C05 stock first, then C08, row by row from highest qty.
     */
    private function _deductDB2Stock($order_id)
    {
        try {
            $db2 = $this->load->database('db2', TRUE);

            $arr = $this->db->select('products, dispatch_products')->where('id', $order_id)->get('orders')->row_array();
            if (!$arr) return;

            $products = @unserialize($arr['products']);
            $dispatch = @unserialize($arr['dispatch_products']) ?: [];
            if (!is_array($products)) return;

            foreach ($products as $product) {
                $pid = (int)($product['product_info']['id'] ?? 0);
                if (!$pid) continue;
                $qty = isset($dispatch[$pid]) ? (int)$dispatch[$pid] : (int)$product['product_quantity'];
                if ($qty <= 0) continue;

                $p = $this->db->select('article_number')->where('id', $pid)->get('products')->row_array();
                if (empty($p['article_number'])) continue;

                $itm = $db2->query(
                    "SELECT TOP 1 Itm_No FROM dbo.Mst_ItemMaster WHERE Itm_Code = ?",
                    [$p['article_number']]
                )->row_array();
                if (!$itm) continue;

                $stock_rows = $db2->query(
                    "SELECT Stk_No, Stk_StockQty FROM dbo.Trn_StockDetails
                     WHERE Stk_ItmNo = ? AND Stk_Cocode IN ('C05','C08') AND Stk_StockQty > 0
                     ORDER BY CASE Stk_Cocode WHEN 'C05' THEN 1 ELSE 2 END, Stk_StockQty DESC",
                    [(int)$itm['Itm_No']]
                )->result_array();

                $remaining = $qty;
                foreach ($stock_rows as $row) {
                    if ($remaining <= 0) break;
                    $deduct = min($remaining, (int)$row['Stk_StockQty']);
                    $db2->query(
                        "UPDATE dbo.Trn_StockDetails SET Stk_StockQty = Stk_StockQty - ? WHERE Stk_No = ?",
                        [$deduct, $row['Stk_No']]
                    );
                    $remaining -= $deduct;
                }
                if ($remaining > 0) {
                    log_message('error', "RTD DB2 stock deduction: could not fully deduct {$remaining} pcs for product {$pid} (article: {$p['article_number']})");
                }
            }
        } catch (Exception $e) {
            log_message('error', 'RTD DB2 deduction failed: ' . $e->getMessage());
        }
    }

    /**
     * Restore DB2 stock when an RTD order is reverted (back to Pending/Processed/Rejected).
     * Adds qty back to the first available stock row for each item.
     */
    private function _restoreDB2Stock($order_id)
    {
        try {
            $db2 = $this->load->database('db2', TRUE);

            $arr = $this->db->select('products, dispatch_products')->where('id', $order_id)->get('orders')->row_array();
            if (!$arr) return;

            $products = @unserialize($arr['products']);
            $dispatch = @unserialize($arr['dispatch_products']) ?: [];
            if (!is_array($products)) return;

            foreach ($products as $product) {
                $pid = (int)($product['product_info']['id'] ?? 0);
                if (!$pid) continue;
                $qty = isset($dispatch[$pid]) ? (int)$dispatch[$pid] : (int)$product['product_quantity'];
                if ($qty <= 0) continue;

                $p = $this->db->select('article_number')->where('id', $pid)->get('products')->row_array();
                if (empty($p['article_number'])) continue;

                $itm = $db2->query(
                    "SELECT TOP 1 Itm_No FROM dbo.Mst_ItemMaster WHERE Itm_Code = ?",
                    [$p['article_number']]
                )->row_array();
                if (!$itm) continue;

                // Add back to the first stock row for this item (C05 preferred)
                $row = $db2->query(
                    "SELECT TOP 1 Stk_No FROM dbo.Trn_StockDetails
                     WHERE Stk_ItmNo = ? AND Stk_Cocode IN ('C05','C08')
                     ORDER BY CASE Stk_Cocode WHEN 'C05' THEN 1 ELSE 2 END",
                    [(int)$itm['Itm_No']]
                )->row_array();

                if ($row) {
                    $db2->query(
                        "UPDATE dbo.Trn_StockDetails SET Stk_StockQty = Stk_StockQty + ? WHERE Stk_No = ?",
                        [$qty, $row['Stk_No']]
                    );
                }
            }
        } catch (Exception $e) {
            log_message('error', 'RTD DB2 restore failed: ' . $e->getMessage());
        }
    }

    public function setBankAccountSettings($post)
    {
        $query = $this->db->query('SELECT id FROM bank_accounts');
        if ($query->num_rows() == 0) {
            $id = 1;
        } else {
            $result = $query->row_array();
            $id = $result['id'];
        }
        $post['id'] = $id;
        if (!$this->db->replace('bank_accounts', $post)) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
    }

    public function getBankAccountSettings()
    {
        $result = $this->db->query("SELECT * FROM bank_accounts LIMIT 1");
        return $result->row_array();
    }

    public function deleteOrder($id)
    {
        $id = (int) $id;
        $this->db->trans_begin();
        $this->db->where('id', $id)->delete('orders');
        $this->db->where('for_id', $id)->delete('orders_clients');
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            show_error(lang('database_error'));
        } else {
            $this->db->trans_commit();
        }
    }

    /**
     * Save per-product dispatch quantities and recalculate billing_amount.
     * $dispatch_data: array of ['product_id' => qty, ...]
     */
    public function setDispatchQuantities($order_id, $dispatch_data)
    {
        $order_id = (int)$order_id;
        // Fetch order to get products + margin info
        $order = $this->db->select('products, billed_to_user_id, user_id')
                          ->where('id', $order_id)->get('orders')->row_array();
        if (!$order) return false;

        $products = unserialize($order['products']);
        if (!is_array($products)) return false;

        // Build dispatch as simple [pid => qty] map
        $dispatch = [];
        foreach ($products as $item) {
            $pid = (int)($item['product_info']['id'] ?? 0);
            if (!$pid) continue;
            $new_qty = isset($dispatch_data[$pid]) ? (int)$dispatch_data[$pid] : (int)$item['product_quantity'];
            if ($new_qty < 0) $new_qty = 0;
            $dispatch[$pid] = $new_qty;
        }

        // Recalculate billing_amount using dispatch quantities
        $billing_user_id = !empty($order['billed_to_user_id']) ? (int)$order['billed_to_user_id'] : (int)$order['user_id'];
        $parent = $this->db->select('type, percent')->where('id', $billing_user_id)->get('users_public')->row();
        $margin = ($parent && in_array((int)$parent->type, [2, 3])) ? (float)$parent->percent : 0;

        $raw_total = 0;
        foreach ($products as $item) {
            $pid = (int)($item['product_info']['id'] ?? 0);
            $wsp = (float)($item['product_info']['wsp'] ?? $item['product_info']['price'] ?? 0);
            $raw_total += $wsp * ($dispatch[$pid] ?? (int)$item['product_quantity']);
        }
        $billing_amount = round($raw_total * (1 - $margin / 100), 2);

        $this->db->where('id', $order_id)->update('orders', [
            'dispatch_products' => serialize($dispatch),
            'billing_amount'    => $billing_amount,
        ]);

        // Update ledger: find existing debit entry for this order and adjust amount + recalculate subsequent balances
        $ledger_entry = $this->db->where('order_id', $order_id)->where('type', 'debit')->get('ledger')->row_array();
        if ($ledger_entry) {
            $old_amount = (float)$ledger_entry['amount'];
            $diff       = $billing_amount - $old_amount;
            if (abs($diff) > 0.001) {
                // Update this entry's amount and balance
                $this->db->where('id', $ledger_entry['id'])->update('ledger', [
                    'amount'      => $billing_amount,
                    'balance'     => round((float)$ledger_entry['balance'] + $diff, 2),
                    'description' => 'Order billed (dispatched qty) — Order #' . $order_id,
                ]);
                // Shift all subsequent entries for this user
                $user_id = (int)$ledger_entry['user_id'];
                $this->db->query(
                    "UPDATE `ledger` SET `balance` = `balance` + ? WHERE `user_id` = ? AND `id` > ?",
                    [$diff, $user_id, (int)$ledger_entry['id']]
                );
            }
        }

        return true;
    }

    public function setTracking($order_id, $courier, $tracking_id)
    {
        return $this->db->where('id', (int)$order_id)->update('orders', [
            'tracking_courier' => $this->db->escape_str(trim($courier)),
            'tracking_id'      => $this->db->escape_str(trim($tracking_id)),
        ]);
    }

    public function recordPayment($order_id, $user_id, $amount, $mode, $reference, $notes = '')
    {
        $order_id = (int)$order_id;
        $user_id  = (int)$user_id;
        $amount   = round((float)$amount, 2);

        // Insert payment record
        $this->db->insert('payments', [
            'order_id'    => $order_id,
            'user_id'     => $user_id,
            'amount'      => $amount,
            'mode'        => $mode,
            'reference'   => $reference,
            'notes'       => $notes,
            'recorded_at' => time(),
        ]);

        // Update orders.paid_amount and payment_status
        $order = $this->db->select('paid_amount, billing_amount')
                          ->where('id', $order_id)->get('orders')->row_array();
        if ($order) {
            $new_paid = round((float)$order['paid_amount'] + $amount, 2);
            $billing  = (float)$order['billing_amount'];
            $status   = ($new_paid <= 0) ? 0 : (($new_paid >= $billing) ? 2 : 1);
            $this->db->where('id', $order_id)->update('orders', [
                'paid_amount'    => $new_paid,
                'payment_status' => $status,
            ]);
            // Ledger credit entry for billed user
            add_ledger_entry($user_id, 'credit', $amount, 'Payment received — Order #' . $order_id, $order_id);
        }
        return true;
    }

    public function getPayments($order_id)
    {
        return $this->db->where('order_id', (int)$order_id)
                        ->order_by('id', 'DESC')
                        ->get('payments')->result_array();
    }

    public function getOrderById($id)
    {
        $this->db->select('orders.*, orders_clients.first_name, orders_clients.last_name, orders_clients.email, orders_clients.phone, orders_clients.address, orders_clients.city, orders_clients.post_code, orders_clients.notes, orders_clients.company, orders_clients.gst, users_public.company as buyer_company, users_public.name as buyer_contact, users_public.gst as buyer_gst, users_public.phone as buyer_phone, users_public.email as buyer_email');
        $this->db->join('orders_clients', 'orders_clients.for_id = orders.id AND orders_clients.id = (SELECT MAX(oc.id) FROM orders_clients oc WHERE oc.for_id = orders.id)', 'left');
        $this->db->join('users_public', 'users_public.id = orders.user_id', 'left');
        $this->db->where('orders.id', (int)$id);
        $row = $this->db->get('orders')->row_array();
        if (!$row) return null;
        // Decrypt encrypted fields (same pattern as orders())
        return array_map(function($v) {
            $d = $this->encryption->decrypt($v);
            return $d !== false ? $d : $v;
        }, $row);
    }
}
