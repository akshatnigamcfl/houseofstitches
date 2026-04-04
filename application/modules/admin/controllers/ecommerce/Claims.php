<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Claims extends ADMIN_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->_ensure_claims_table();
    }

    private function _ensure_claims_table()
    {
        if (!$this->db->table_exists('claims')) {
            $this->db->query('CREATE TABLE IF NOT EXISTS `claims` (
                `id`           INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `claim_no`     VARCHAR(20)  NOT NULL DEFAULT \'\',
                `user_id`      INT UNSIGNED NOT NULL,
                `order_id`     INT UNSIGNED NULL,
                `type`         VARCHAR(50)  NOT NULL DEFAULT \'\',
                `amount`       DECIMAL(10,2) NOT NULL DEFAULT 0,
                `description`  TEXT NULL,
                `status`       ENUM(\'pending\',\'approved\',\'rejected\',\'paid\') NOT NULL DEFAULT \'pending\',
                `admin_remark` TEXT NULL,
                `created_at`   INT UNSIGNED NOT NULL DEFAULT 0,
                `updated_at`   INT UNSIGNED NULL,
                INDEX (`user_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');
        }
    }

    public function index()
    {
        $this->login_check();
        $head = ['title' => 'Administration - Claims', 'description' => '', 'keywords' => ''];

        $this->db->select('claims.*, users_public.name as user_name, users_public.company as user_company, users_public.phone as user_phone, orders.order_id as order_ref');
        $this->db->join('users_public', 'users_public.id = claims.user_id', 'left');
        $this->db->join('orders', 'orders.id = claims.order_id', 'left');
        $this->db->order_by('claims.id', 'DESC');
        $data['claims'] = $this->db->get('claims')->result_array();

        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/claims', $data);
        $this->load->view('_parts/footer');
    }

    public function updateStatus()
    {
        header('Content-Type: application/json');
        $id     = (int)$this->input->post('id');
        $status = $this->input->post('status');
        $remark = trim($this->input->post('remark') ?? '');

        $allowed = ['pending', 'approved', 'rejected', 'paid'];
        if (!$id || !in_array($status, $allowed)) {
            echo json_encode(['success' => false, 'error' => 'Invalid input']);
            exit();
        }

        // Fetch claim before update to check previous status
        $claim = $this->db->where('id', $id)->get('claims')->row();
        if (!$claim) {
            echo json_encode(['success' => false, 'error' => 'Claim not found']);
            exit();
        }

        $this->db->where('id', $id)->update('claims', [
            'status'       => $status,
            'admin_remark' => $remark ?: null,
            'updated_at'   => time(),
        ]);

        // When status changes to 'paid', credit the ledger — once only
        if ($status === 'paid' && $claim->status !== 'paid' && (float)$claim->amount > 0) {
            $this->load->helper('ledger_helper');

            $desc = 'Claim settled — ' . ($claim->claim_no ?: 'CLM-' . $id) . ($claim->type ? ' (' . $claim->type . ')' : '');
            $oid  = $claim->order_id ? (int)$claim->order_id : null;

            // Determine billed user (parent distributor/wholesaler) from the linked order
            $credit_user_id = (int)$claim->user_id;
            if ($oid) {
                $order = $this->db->select('billed_to_user_id')
                                   ->where('id', $oid)
                                   ->get('orders')->row();
                if ($order && !empty($order->billed_to_user_id)) {
                    $credit_user_id = (int)$order->billed_to_user_id;
                }
            }

            // Credit the billed user (parent distributor/wholesaler or self)
            add_ledger_entry($credit_user_id, 'credit', (float)$claim->amount, $desc, $oid);

            // Also credit the claimant if different from the billed user
            if ($credit_user_id !== (int)$claim->user_id) {
                add_ledger_entry((int)$claim->user_id, 'credit', (float)$claim->amount, $desc, $oid);
            }
        }

        echo json_encode(['success' => true]);
        exit();
    }
}
