<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends MY_Controller
{

    private $orderId;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/Orders_model');
        $this->load->helper('developer_helper');
        $this->load->library('email');
    }

    public function index()
    {  
      
        $data = array();
        $head = array();
        $arrSeo = $this->Public_model->getSeo('checkout');
        $head['title'] = @$arrSeo['title'];
        $head['description'] = @$arrSeo['description'];
        $head['keywords'] = str_replace(" ", ",", $head['title']);
             // echo '<pre>'; print_r($this->input->post());               die('Hello world');
        if (isset($_POST['payment_type'])) {
            // Prevent duplicate order on double-submit / browser retry
            $submitToken = $_POST['submit_token'] ?? '';
            $sessionToken = $this->session->userdata('checkout_token');
            if (empty($submitToken) || $submitToken !== $sessionToken) {
                $this->session->set_flashdata('submit_error', ['Invalid or duplicate submission. Please try again.']);
                redirect(LANG_URL . '/checkout');
            }
            $this->session->unset_userdata('checkout_token'); // consume token

            $errors = $this->userInfoValidate($_POST);
            if (!empty($errors)) {
                $this->session->set_flashdata('submit_error', $errors);
            } else {
                $_POST['referrer'] = $this->session->userdata('referrer');
                $_POST['clean_referrer'] = cleanReferral($_POST['referrer']);
                $_POST['user_id'] = user_id() ?: 0;
                 $orderId = $this->Public_model->setOrder($_POST); 
                if ($orderId != false) {
                    /*
                     * Save product orders in vendors profiles
                     */
                     
                    $this->setVendorOrders();
                    $this->orderId = $orderId;
                    $this->saveUserAddress($_POST);
                    $this->setActivationLink();
                    $this->sendNotifications();
                    $this->goToDestination();
                } else {
                    log_message('error', 'Cant save order!! ' . implode('::', $_POST));
                    $this->session->set_flashdata('order_error', true);
                    redirect(LANG_URL . '/checkout/order-error');
                } 
            }
        }  
        // Generate a fresh one-time submit token for the form
        $token = bin2hex(random_bytes(16));
        $this->session->set_userdata('checkout_token', $token);
        $data['submit_token'] = $token;

        $data['bank_account'] = $this->Orders_model->getBankAccountSettings();
        $data['cashondelivery_visibility'] = $this->Home_admin_model->getValueStore('cashondelivery_visibility');
        $data['paypal_email'] = $this->Home_admin_model->getValueStore('paypal_email');
        $data['shippingAmount'] = $this->Home_admin_model->getValueStore('shippingAmount');
        $data['bestSellers'] = $this->Public_model->getbestSellers();
        // Load saved addresses for checkout step 1
        $data['user_addresses'] = $this->_get_user_addresses();
        $this->render('checkout', $head, $data);
    }

    private function _get_user_addresses()
    {
        $uid = user_id();
        if (!$uid) return [];
        if (!$this->db->table_exists('user_addresses')) return [];
        return $this->db->where('user_id', $uid)->order_by('is_default DESC, id ASC')->get('user_addresses')->result();
    }

    private function setVendorOrders()
    {
        $this->Public_model->setVendorOrder($_POST);
    }

    /*
     * Send notifications to users that have nofify=1 in /admin/adminusers
     */

    private function sendNotifications()
    {
        $users = $this->Public_model->getNotifyUsers();
        $myDomain = $this->config->item('base_url');
        if (!empty($users)) {
            $this->sendmail->clearAddresses();
            foreach ($users as $user) {
                $this->sendmail->sendTo($user, 'Admin', 'New order in ' . $myDomain, 'Hello, you have new order. Can check it in /admin/orders');
            }
        }
    }

    private function setActivationLink()
    {           $this->load->library('email');
        

        if ($this->config->item('send_confirm_link') === true) {
            $link = md5($this->orderId . time());
            $result = $this->Public_model->setActivationLink($link, $this->orderId);
            if ($result == true) {
                $url = parse_url(base_url());
                $msg = lang('please_confirm') . '<a href="'.base_url('confirm/' . $link).'">Click here to confirm</a>';
               //$res = $this->sendmail->sendTo($_POST['email'], $_POST['first_name'] , lang('confirm_order_subj') . $url['host'], $msg);
               $res = $this->send_test($_POST['email'], $_POST['first_name'] , lang('confirm_order_subj') . $url['host'], $msg,$this->orderId);
                         
     

               
            }
        }
    }
    public function send_test($to_email, $to_name, $subject,$msg,$orderId) {
        $this->smtp_email($to_email, $to_name, $subject,$msg,$orderId);
    }
    
    public function smtp_email($to_email, $to_name, $subject, $msg, $orderId)
    {
        $order = $this->db->query('SELECT products FROM `orders` WHERE order_id = ' . (int)$orderId)->row();
        $this->load->library('email');
        $this->email->clear();

        $this->email->from('nitesh54546@gmail.com', 'House of Stitches');
        $this->email->to($to_email);
        $this->email->cc('admin@houseofstitches.in');
        $this->email->bcc('backup@houseofstitches.in');
        $this->email->subject('Order Confirmation - House of Stitches');

        $rows = '';
        if ($order && $order->products) {
            foreach (unserialize($order->products) as $val) {
                $item = get_product_details($val['product_info']['id'] ?? null);
                if (!$item) continue;
                $img = base_url('attachments/shop_images/' . $item->image);
                $rows .= '<tr>
                    <td style="padding:8px;"><img src="' . $img . '" style="width:60px;height:auto;"></td>
                    <td style="padding:8px;">' . htmlspecialchars($item->title) . '</td>
                    <td style="padding:8px;">&#8377; ' . $item->price . '</td>
                    <td style="padding:8px;">' . (int)$val['product_quantity'] . '</td>
                </tr>';
            }
        }

        $message = '<html><head><meta charset="UTF-8"></head>
        <body style="font-family:Arial,sans-serif;max-width:600px;margin:0 auto;">
            <div style="background:#f8f9fa;padding:40px 20px;">
                <h1 style="color:#e74c3c;text-align:center;">Order Confirmed!</h1>
                <p>Dear <strong>' . htmlspecialchars($to_name) . '</strong>,</p>
                <p>' . $msg . '</p>
                <p>Thank you for your purchase from <strong>House of Stitches</strong>!</p>
                <table style="width:100%;border-collapse:collapse;margin:20px 0;">
                    <tr style="background:#e74c3c;color:white;">
                        <th style="padding:12px;text-align:left;">Image</th>
                        <th style="padding:12px;text-align:left;">Product</th>
                        <th style="padding:12px;">Price</th>
                        <th style="padding:12px;">Qty</th>
                    </tr>' . $rows . '
                </table>
                <p>We\'ll ship your order within 2-3 business days.</p>
                <hr style="border:none;border-top:1px solid #eee;">
                <p style="font-size:12px;color:#666;text-align:center;">
                    House of Stitches | info@houseofstitches.in | +91 9876543210
                </p>
            </div>
        </body></html>';

        $this->email->message($message);

        if ($this->email->send()) {
            log_message('info', 'Order confirmation email sent to: ' . $to_email);
        } else {
            log_message('error', 'Order confirmation email failed: ' . $this->email->print_debugger(['headers' => FALSE]));
        }
    }
    private function goToDestination()
    {     
        if ($_POST['payment_type'] == 'cashOnDelivery' || $_POST['payment_type'] == 'Bank') {
            $this->shoppingcart->clearShoppingCart();
            $this->session->set_flashdata('success_order', true);
        }
        if ($_POST['payment_type'] == 'Bank') {
            $_SESSION['order_id'] = $this->orderId;
            $_SESSION['final_amount'] = $_POST['final_amount'] . $_POST['amount_currency'];
            redirect(LANG_URL . '/checkout/successbank');
        }
        if ($_POST['payment_type'] == 'cashOnDelivery') {
            $_SESSION['order_id'] = $this->orderId;
            redirect(LANG_URL . '/checkout/successcash');
        }
        if ($_POST['payment_type'] == 'PayPal') {
            @set_cookie('paypal', $this->orderId, 2678400);
            $_SESSION['discountAmount'] = $_POST['discountAmount'];
            redirect(LANG_URL . '/checkout/paypalpayment');
        }
    }

    private function saveUserAddress($post)
    {
        // No-op: user profile is managed only via Account Settings.
        // Checkout data is stored in orders_clients and user_addresses only.
    }

    private function userInfoValidate($post)
    {
        $errors = array();
        if (mb_strlen(trim($post['first_name'])) == 0) {
            $errors[] = lang('first_name_empty');
        }
       /* if (mb_strlen(trim($post['last_name'])) == 0) {
            $errors[] = lang('last_name_empty');
        }*/
        if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = lang('invalid_email');
        }
        $post['phone'] = preg_replace("/[^0-9]/", '', $post['phone']);
        if (mb_strlen(trim($post['phone'])) == 0) {
            $errors[] = lang('invalid_phone');
        }
        if (mb_strlen(trim($post['address'])) == 0) {
            $errors[] = lang('address_empty');
        }
        // city is optional — not collected as a separate field in the current checkout
        return $errors;
    }

    public function orderError()
    {
        if ($this->session->flashdata('order_error')) {
            $data = array();
            $head = array();
            $arrSeo = $this->Public_model->getSeo('checkout');
            $head['title'] = @$arrSeo['title'];
            $head['description'] = @$arrSeo['description'];
            $head['keywords'] = str_replace(" ", ",", $head['title']);
            $this->render('checkout_parts/order_error', $head, $data);
        } else {
            redirect(LANG_URL . '/checkout');
        }
    }

    public function paypalPayment()
    {
        $data = array();
        $head = array();
        $arrSeo = $this->Public_model->getSeo('checkout');
        $head['title'] = @$arrSeo['title'];
        $head['description'] = @$arrSeo['description'];
        $head['keywords'] = str_replace(" ", ",", $head['title']);
        $data['paypal_sandbox'] = $this->Home_admin_model->getValueStore('paypal_sandbox');
        $data['paypal_email'] = $this->Home_admin_model->getValueStore('paypal_email');
        $this->render('checkout_parts/paypal_payment', $head, $data);
    }

    public function successPaymentCashOnD()
    {  
        if ($this->session->flashdata('success_order')) {
            $data = array();
            $head = array();
            $this->orderId = $_SESSION['order_id'];
            $arrSeo = $this->Public_model->getSeo('checkout');
            $sql = 'SELECT
orders.order_id,orders.date,orders.user_id,orders.products,orders.processed,orders.payment_type,
    users_public.name,users_public.email,users_public.address,users_public.agents
FROM
    orders
LEFT JOIN
    users_public ON orders.user_id = users_public.id WHERE orders.order_id = '.$this->orderId.' ORDER BY orders.date DESC
        LIMIT 1 ';
            $head['order_details'] = $this->db->query($sql)->row();
            $data['total_with_gst'] = $this->input->post('total_with_gst');
            /*echo '<pre>'; print_r($data['order_details']['order_id']); die;*/
            $head['title'] = @$arrSeo['title'];
            $head['description'] = @$arrSeo['description'];
            $head['keywords'] = str_replace(" ", ",", $head['title']);
            $this->render('ordercompleted', $head, $data);
        } else {
            redirect(LANG_URL . '/home/shop');
        }
    }

    public function successPaymentBank()
    {
        if ($this->session->flashdata('success_order')) {
            $data = array();
            $head = array();
            $arrSeo = $this->Public_model->getSeo('checkout');
            $head['title'] = @$arrSeo['title'];
            $head['description'] = @$arrSeo['description'];
            $head['keywords'] = str_replace(" ", ",", $head['title']);
            $data['bank_account'] = $this->Orders_model->getBankAccountSettings();
            $this->render('checkout_parts/payment_success_bank', $head, $data);
        } else {
            redirect(LANG_URL . '/checkout');
        }
    }

    public function paypal_cancel()
    {
        if (get_cookie('paypal') == null) {
            redirect(base_url());
        }
        @delete_cookie('paypal');
        $orderId = get_cookie('paypal');
        $this->Public_model->changePaypalOrderStatus($orderId, 'canceled');
        $data = array();
        $head = array();
        $head['title'] = '';
        $head['description'] = '';
        $head['keywords'] = '';
        $this->render('checkout_parts/paypal_cancel', $head, $data);
    }

    public function paypal_success()
    {
        if (get_cookie('paypal') == null) {
            redirect(base_url());
        }
        @delete_cookie('paypal');
        $this->shoppingcart->clearShoppingCart();
        $orderId = get_cookie('paypal');
        $this->Public_model->changePaypalOrderStatus($orderId, 'payed');
        $data = array();
        $head = array();
        $head['title'] = '';
        $head['description'] = '';
        $head['keywords'] = '';
        $this->render('checkout_parts/paypal_success', $head, $data);
    }

}
