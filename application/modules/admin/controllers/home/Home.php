<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Home extends ADMIN_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Orders_model', 'History_model', 'Home_admin_model'));
    }

    public function index()
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Home';
        $head['description'] = '';
        $head['keywords'] = '';
        $data['newOrdersCount']    = $this->Orders_model->ordersCount(true);
        $data['lowQuantity']       = $this->Home_admin_model->countLowQuantityProducts();
        $data['outOfStockCount']   = $this->Home_admin_model->getOutOfStockCount();
        $data['pendingOrders']     = $this->Home_admin_model->getPendingOrdersCount();
        $data['totalUsers']        = $this->Home_admin_model->getTotalUsersCount();
        $data['totalRevenue']      = $this->Home_admin_model->getTotalRevenue();
        $data['lastSubscribed']    = $this->Home_admin_model->lastSubscribedEmailsCount();
        $data['restockAlerts']     = $this->Home_admin_model->getRestockAlerts();
        $data['mostOrdered']       = $this->Home_admin_model->getMostOrderedProducts();
        $data['activity']          = $this->History_model->getHistory(10, 0);
        $data['mostSold']          = $this->Home_admin_model->getMostSoldProducts();
        $data['byReferral']        = $this->Home_admin_model->getReferralOrders();
        $data['ordersByPaymentType'] = $this->Home_admin_model->getOrdersByPaymentType();
        $data['ordersByMonth']     = $this->Home_admin_model->getOrdersByMonth();
        $this->load->view('_parts/header', $head);
        $this->load->view('home/home', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to home page');
    }

    /*
     * Called from ajax
     */

    public function changePass()
    {
        $this->login_check();
        $result = $this->Home_admin_model->changePass($_POST['new_pass'], $this->username);
        if ($result == true) {
            echo 1;
        } else {
            echo 0;
        }
        $this->saveHistory('Password change for user: ' . $this->username);
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('admin');
    }

}
