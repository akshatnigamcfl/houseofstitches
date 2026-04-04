<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Payments extends ADMIN_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Ensure order columns (billing_amount, paid_amount, billed_to_user_id, etc.) exist
        $this->load->model('Orders_model');
    }

    public function index()
    {
        $this->login_check();
        $head = ['title' => 'Administration - Payment Receipts', 'description' => '', 'keywords' => ''];

        $data = [];
        if ($this->db->table_exists('payments')) {
            $this->db->select('payments.*, orders.order_id as order_ref, users_public.name as user_name, users_public.phone as user_phone');
            $this->db->join('orders', 'orders.id = payments.order_id', 'left');
            $this->db->join('users_public', 'users_public.id = payments.user_id', 'left');
            $this->db->order_by('payments.id', 'DESC');
            $data['receipts'] = $this->db->get('payments')->result();
        } else {
            $data['receipts'] = [];
        }

        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/payments', $data);
        $this->load->view('_parts/footer');
    }

    public function verifyPayment()
    {
        $id = (int)$this->input->post('id');
        if (!$id) { echo json_encode(['success' => false]); exit(); }

        // Get the payment record
        $payment = $this->db->where('id', $id)->get('payments')->row();
        if (!$payment) { echo json_encode(['success' => false, 'message' => 'Not found']); exit(); }

        // Mark payment as verified
        $this->db->where('id', $id)->update('payments', [
            'status'      => 'verified',
            'verified_at' => time(),
        ]);

        // Update order's paid_amount and payment_status
        $order = $this->db->where('id', (int)$payment->order_id)->get('orders')->row();
        if ($order) {
            $new_paid   = (float)$order->paid_amount + (float)$payment->amount;
            $bill_amt   = (float)$order->billing_amount;
            $pay_status = ($bill_amt > 0 && $new_paid >= $bill_amt) ? 2 : ($new_paid > 0 ? 1 : 0);
            $this->db->where('id', (int)$order->id)->update('orders', [
                'paid_amount'    => round($new_paid, 2),
                'payment_status' => $pay_status,
            ]);

            // Credit the ledger of the billed user
            $ledger_uid = !empty($order->billed_to_user_id) ? (int)$order->billed_to_user_id : (int)$order->user_id;
            $this->load->helper('ledger_helper');
            add_ledger_entry(
                $ledger_uid,
                'credit',
                (float)$payment->amount,
                'Payment received for order #' . $order->order_id . ' (' . ($payment->mode ?? '') . ')',
                (int)$order->id
            );

            // When payment received, mark agent commission for this order as payable
            if ($this->db->table_exists('commissions')) {
                $this->db->where('order_id', (int)$order->id)
                         ->where('status', 'pending')
                         ->update('commissions', ['status' => 'payable']);
            }
        }

        echo json_encode(['success' => true]);
        exit();
    }

    public function rejectPayment()
    {
        $id = (int)$this->input->post('id');
        if (!$id) { echo json_encode(['success' => false]); exit(); }
        $this->db->where('id', $id)->update('payments', ['status' => 'rejected']);
        echo json_encode(['success' => true]);
        exit();
    }
}
