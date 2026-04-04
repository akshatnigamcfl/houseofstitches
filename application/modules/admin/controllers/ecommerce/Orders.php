<?php

/*
 * @Author:    
 *  Gitgub:    https://github.com/
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Orders extends ADMIN_Controller
{

    private $num_rows = 10;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('SendMail');
        $this->load->model(array('Orders_model', 'Home_admin_model'));
    }

    public function index($page = 0)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Orders';
        $head['description'] = '!';
        $head['keywords'] = '';

        $order_by = null;
        if (isset($_GET['order_by'])) {
            $order_by = $_GET['order_by'];
        }
        $rowscount = $this->Orders_model->ordersCount();
        $data['orders'] = $this->Orders_model->orders($this->num_rows, $page, $order_by);
        $data['links_pagination'] = pagination('admin/orders', $rowscount, $this->num_rows, 3);
        $data['count_all']       = $rowscount;
        $data['count_pending']   = $this->Orders_model->ordersCount(false, 0);
        $data['count_processed'] = $this->Orders_model->ordersCount(false, 1);
        $data['count_rejected']  = $this->Orders_model->ordersCount(false, 2);
        $data['count_rtd']       = $this->Orders_model->ordersCount(false, 3);
        if (isset($_POST['paypal_sandbox'])) {
            $this->Home_admin_model->setValueStore('paypal_sandbox', $_POST['paypal_sandbox']);
            if ($_POST['paypal_sandbox'] == 1) {
                $msg = 'Paypal sandbox mode activated';
            } else {
                $msg = 'Paypal sandbox mode disabled';
            }
            $this->session->set_flashdata('paypal_sandbox', $msg);
            $this->saveHistory($msg);
            redirect('admin/orders?settings');
        }
        if (isset($_POST['paypal_email'])) {
            $this->Home_admin_model->setValueStore('paypal_email', $_POST['paypal_email']);
            $this->session->set_flashdata('paypal_email', 'Public quantity visibility changed');
            $this->saveHistory('Change paypal business email to: ' . $_POST['paypal_email']);
            redirect('admin/orders?settings');
        }
        if (isset($_POST['cashondelivery_visibility'])) {
            $this->Home_admin_model->setValueStore('cashondelivery_visibility', $_POST['cashondelivery_visibility']);
            $this->session->set_flashdata('cashondelivery_visibility', 'Cash On Delivery Visibility Changed');
            $this->saveHistory('Change Cash On Delivery Visibility - ' . $_POST['cashondelivery_visibility']);
            redirect('admin/orders?settings');
        }
        if (isset($_POST['iban'])) {
            $this->Orders_model->setBankAccountSettings($_POST);
            $this->session->set_flashdata('bank_account', 'Bank account settings saved');
            $this->saveHistory('Bank account settings saved for : ' . $_POST['name']);
            redirect('admin/orders?settings');
        }
        $data['paypal_sandbox'] = $this->Home_admin_model->getValueStore('paypal_sandbox');
        $data['paypal_email'] = $this->Home_admin_model->getValueStore('paypal_email'); 
        $data['shippingAmount'] = $this->Home_admin_model->getValueStore('shippingAmount');
        $data['shippingOrder'] = $this->Home_admin_model->getValueStore('shippingOrder');
        $data['cashondelivery_visibility'] = $this->Home_admin_model->getValueStore('cashondelivery_visibility');
        $data['bank_account'] = $this->Orders_model->getBankAccountSettings();

        // GR request statuses per order (for badges on list)
        $data['gr_by_order'] = [];
        if ($this->db->table_exists('gr_requests')) {
            $gr_rows = $this->db->select('order_id, status')->get('gr_requests')->result_array();
            foreach ($gr_rows as $g) {
                $oid = (int)$g['order_id'];
                if (!isset($data['gr_by_order'][$oid])) $data['gr_by_order'][$oid] = [];
                $data['gr_by_order'][$oid][] = $g['status'];
            }
        }

        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/orders', $data);
        $this->load->view('_parts/footer');
        if ($page == 0) {
            $this->saveHistory('Go to orders page');
        }
    }

    public function deleteOrder($id)
    {
        $id = (int) $id;
        if($id == 0) {
            redirect('admin/orders');
        }
        
        $this->Orders_model->deleteOrder($id);
        redirect('admin/orders');
    }

    public function changeOrdersOrderStatus()
    {
        $this->login_check();

        $result = false;
        $sendedVirtualProducts = true;
        $virtualProducts = $this->Home_admin_model->getValueStore('virtualProducts');
        /*
         * If we want to use Virtual Products
         * Lets send email with download links to user email
         * In error logs will be saved if cant send email from PhpMailer
         */
        if ($virtualProducts == 1) {
            if ($_POST['to_status'] == 1) {
                $sendedVirtualProducts = $this->sendVirtualProducts();
            }
        }

        if ($sendedVirtualProducts == true) {
            $result = $this->Orders_model->changeOrderStatus($_POST['the_id'], $_POST['to_status']);
        }

        if ($result == true && $sendedVirtualProducts == true) {
            echo 1;
        } else {
            echo 0;
        }
        $this->saveHistory('Change status of Order Id ' . $_POST['the_id'] . ' to status ' . $_POST['to_status']);
    }

    /**
     * POST: order_id, dispatch[product_id] = qty
     * Sets per-product dispatch quantities and recalculates billing_amount.
     */
    public function setDispatchQty()
    {
        $this->login_check();
        header('Content-Type: application/json');
        $order_id = (int)$this->input->post('order_id');
        $dispatch = $this->input->post('dispatch') ?: [];
        if (!$order_id) { echo json_encode(['success' => false, 'msg' => 'Invalid order']); return; }
        $ok = $this->Orders_model->setDispatchQuantities($order_id, $dispatch);
        echo json_encode(['success' => (bool)$ok]);
        $this->saveHistory('Set dispatch quantities for Order DB id ' . $order_id);
    }

    /**
     * POST: order_id, courier, tracking_id
     */
    public function setTracking()
    {
        $this->login_check();
        header('Content-Type: application/json');
        $order_id   = (int)$this->input->post('order_id');
        $courier    = $this->input->post('courier');
        $tracking   = $this->input->post('tracking_id');
        if (!$order_id) { echo json_encode(['success' => false]); return; }
        $this->Orders_model->setTracking($order_id, $courier, $tracking);
        echo json_encode(['success' => true]);
        $this->saveHistory('Set tracking for Order DB id ' . $order_id . ': ' . $courier . ' / ' . $tracking);
    }

    /**
     * POST: order_id, amount, mode, reference, notes
     * Records a payment against an order and updates ledger.
     */
    public function recordPayment()
    {
        $this->login_check();
        header('Content-Type: application/json');
        $order_id  = (int)$this->input->post('order_id');
        $amount    = (float)$this->input->post('amount');
        $mode      = $this->input->post('mode') ?: 'bank';
        $reference = $this->input->post('reference') ?: '';
        $notes     = $this->input->post('notes') ?: '';
        if (!$order_id || $amount <= 0) { echo json_encode(['success' => false, 'msg' => 'Invalid data']); return; }

        $order = $this->Orders_model->getOrderById($order_id);
        $billed_user = !empty($order['billed_to_user_id']) ? (int)$order['billed_to_user_id'] : (int)$order['user_id'];
        $this->Orders_model->recordPayment($order_id, $billed_user, $amount, $mode, $reference, $notes);
        echo json_encode(['success' => true]);
        $this->saveHistory('Recorded payment of ' . $amount . ' for Order DB id ' . $order_id);
    }

    /**
     * GET: show a single order detail page
     */
    public function detail($id = 0)
    {
        $this->login_check();
        $id = (int)$id;
        if (!$id) redirect('admin/orders');

        $order = $this->Orders_model->getOrderById($id);
        if (!$order) redirect('admin/orders');

        // Mark as viewed
        if ($order['viewed'] == 0) {
            $this->db->where('id', $id)->update('orders', ['viewed' => 1]);
        }

        $head = ['title' => 'Order #' . $order['order_id'], 'description' => '', 'keywords' => ''];
        $data['order']    = $order;
        $data['products'] = @unserialize($order['products']) ?: [];
        $data['payments'] = $this->Orders_model->getPayments($id);

        // Billed-to user info
        $billed_uid = !empty($order['billed_to_user_id']) ? (int)$order['billed_to_user_id'] : (int)$order['user_id'];
        $data['billed_user'] = $this->db->select('id, name, phone, email, type, percent')
                                        ->where('id', $billed_uid)->get('users_public')->row_array();

        // Payment receipts submitted by user for this order
        if ($this->db->table_exists('payments')) {
            $this->db->select('payments.*, users_public.name as user_name, users_public.phone as user_phone');
            $this->db->join('users_public', 'users_public.id = payments.user_id', 'left');
            $this->db->where('payments.order_id', $id);
            $this->db->where_in('payments.status', ['pending', 'verified', 'rejected']);
            $this->db->order_by('payments.id', 'DESC');
            $data['receipts'] = $this->db->get('payments')->result_array();
        } else {
            $data['receipts'] = [];
        }

        // GR Return requests for this order
        if ($this->db->table_exists('gr_requests')) {
            $data['gr_requests'] = $this->db->query(
                "SELECT g.*, up_sub.name AS submitter_name, up_sub.phone AS submitter_phone, up_sub.company AS submitter_company
                 FROM gr_requests g
                 LEFT JOIN users_public up_sub ON up_sub.id = g.submitted_by
                 WHERE g.order_id = " . $id . "
                 ORDER BY g.id DESC"
            )->result_array();
        } else {
            $data['gr_requests'] = [];
        }

        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/order_detail', $data);
        $this->load->view('_parts/footer');
    }

    /**
     * GET: order_id — returns payment history JSON
     */
    public function getOrderPayments($order_id)
    {
        $this->login_check();
        header('Content-Type: application/json');
        $payments = $this->Orders_model->getPayments((int)$order_id);
        echo json_encode($payments);
    }

    private function sendVirtualProducts()
    {
        if(isset($_POST['products']) && $_POST['products'] != '') {
            $products = unserialize(html_entity_decode($_POST['products']));
            foreach ($products as $product_id => $product_quantity) {
                $productInfo = modules::run('admin/ecommerce/products/getProductInfo', $product_id);
                /*
                 * If is virtual product, lets send email to user
                 */
                if ($productInfo['virtual_products'] != null) {
                    if (!filter_var($_POST['userEmail'], FILTER_VALIDATE_EMAIL)) {
                        log_message('error', 'Ivalid customer email address! Cant send him virtual products!');
                        return false;
                    }
                    $result = $this->sendmail->sendTo($_POST['userEmail'], 'Dear Customer', 'Virtual products', $productInfo['virtual_products']);
                    return $result;
                }
            }
            return true;
        }
    }

}
