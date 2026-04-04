<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Gr_returns extends ADMIN_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->login_check();
        $this->_ensure_gr_table();

        $data = [];
        $head = ['title' => 'Administration — GR Returns', 'description' => '', 'keywords' => ''];

        $data['gr_requests'] = $this->db->query(
            "SELECT g.*,
                    up_sub.name  AS submitter_name,
                    up_sub.phone AS submitter_phone,
                    up_sub.company AS submitter_company,
                    up_ret.name  AS retailer_name,
                    up_ret.company AS retailer_company
             FROM gr_requests g
             LEFT JOIN users_public up_sub ON up_sub.id = g.submitted_by
             LEFT JOIN users_public up_ret ON up_ret.id = g.retailer_id
             ORDER BY g.id DESC"
        )->result_array();

        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/gr_returns', $data);
        $this->load->view('_parts/footer');
    }

    public function updateStatus()
    {
        header('Content-Type: application/json');
        $this->login_check();
        $id            = (int)$this->input->post('id');
        $status        = $this->input->post('status');
        $admin_remark  = trim($this->input->post('admin_remark') ?? '');
        $credit_amount = (float)$this->input->post('credit_amount');
        $allowed       = ['pending', 'approved', 'rejected', 'processed'];
        if (!$id || !in_array($status, $allowed)) {
            echo json_encode(['success' => false, 'error' => 'Invalid input.']); exit();
        }

        // Fetch existing GR to check previous status and get user/order info
        $gr = $this->db->where('id', $id)->get('gr_requests')->row();
        if (!$gr) {
            echo json_encode(['success' => false, 'error' => 'GR not found.']); exit();
        }

        // Auto-add credit_amount column if missing
        if (!$this->db->field_exists('credit_amount', 'gr_requests')) {
            $this->db->query("ALTER TABLE `gr_requests` ADD COLUMN `credit_amount` DECIMAL(10,2) NULL DEFAULT NULL AFTER `admin_remark`");
        }

        $update = [
            'status'        => $status,
            'admin_remark'  => $admin_remark,
            'updated_at'    => time(),
        ];
        if ($status === 'processed' && $credit_amount > 0) {
            $update['credit_amount'] = $credit_amount;
        }
        $this->db->where('id', $id)->update('gr_requests', $update);

        // Add ledger credit entry when goods are received (processed) — only once
        if ($status === 'processed' && $gr->status !== 'processed' && $credit_amount > 0) {
            $this->load->helper('ledger_helper');

            // The original debit was posted to billed_to_user_id (parent distributor/wholesaler/agent).
            // Credit must go to the same user so the ledger balances correctly.
            $order = $this->db->select('billed_to_user_id, user_id')
                               ->where('id', (int)$gr->order_id)
                               ->get('orders')->row();

            $credit_user_id = ($order && !empty($order->billed_to_user_id))
                ? (int)$order->billed_to_user_id
                : (int)$gr->submitted_by;

            $desc = 'GR Return processed: ' . $gr->gr_no . ($admin_remark ? ' — ' . $admin_remark : '');

            // Credit the billed user (parent distributor/wholesaler or self)
            add_ledger_entry($credit_user_id, 'credit', $credit_amount, $desc, (int)$gr->order_id);

            // Also credit the retailer who submitted the GR if different from billed user
            if ($credit_user_id !== (int)$gr->submitted_by) {
                add_ledger_entry((int)$gr->submitted_by, 'credit', $credit_amount, $desc, (int)$gr->order_id);
            }

            // Adjust agent commission: reduce by (credit_amount × commission_rate / 100)
            // so commission is only earned on quantity the retailer actually kept
            if ($this->db->table_exists('commissions')) {
                $commission = $this->db->where('order_id', (int)$gr->order_id)
                                       ->where('status', 'pending')
                                       ->get('commissions')->row();
                if ($commission) {
                    $deduction        = round($credit_amount * (float)$commission->commission_rate / 100, 2);
                    $new_order_amount = max(0, round((float)$commission->order_amount - $credit_amount, 2));
                    $new_commission   = max(0, round((float)$commission->commission_amt - $deduction, 2));
                    $this->db->where('id', $commission->id)->update('commissions', [
                        'order_amount'   => $new_order_amount,
                        'commission_amt' => $new_commission,
                    ]);
                }
            }
        }

        echo json_encode(['success' => true]);
        exit();
    }

    private function _ensure_gr_table()
    {
        if (!$this->db->table_exists('gr_requests')) {
            $this->db->query('CREATE TABLE IF NOT EXISTS `gr_requests` (
                `id`           INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `gr_no`        VARCHAR(25)  NOT NULL DEFAULT \'\',
                `order_id`     INT UNSIGNED NOT NULL,
                `order_no`     VARCHAR(20)  NOT NULL DEFAULT \'\',
                `submitted_by` INT UNSIGNED NOT NULL,
                `retailer_id`  INT UNSIGNED NOT NULL,
                `return_type`  VARCHAR(60)  NOT NULL DEFAULT \'\',
                `items`        TEXT         NOT NULL,
                `remark`       TEXT         NULL,
                `proof_files`  TEXT         NULL,
                `status`       ENUM(\'pending\',\'approved\',\'rejected\',\'processed\') NOT NULL DEFAULT \'pending\',
                `admin_remark` TEXT         NULL,
                `created_at`   INT UNSIGNED NOT NULL DEFAULT 0,
                `updated_at`   INT UNSIGNED NULL,
                INDEX (`submitted_by`),
                INDEX (`order_id`),
                INDEX (`retailer_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');
        }
    }
}
