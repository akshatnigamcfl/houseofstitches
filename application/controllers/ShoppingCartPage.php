<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ShoppingCartPage extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->Model('Public_model');
    }

    public function index()
    {  
        
    if ($this->input->is_ajax_request()) {
        $post = $this->input->post();
        $qty = !empty($post['value']) ? $post['value'] : ''; 
        $pid = !empty($post['product_id']) ? $post['product_id'] : ''; 
        $id = !empty($post['id']) ? $post['id'] : ''; 
        $new_qty =  get_product_quantity($pid)*$qty;
        $data = array(
            'set_quantity' => $qty,
            'quantity' => $new_qty
            );
        
        $this->db->where('id', $id);
        $result = $this->db->update('cart_items', $data);  

    } 

    
        $data = array();
        $head = array();
        $arrSeo = $this->Public_model->getSeo('shoppingcart');
        $head['title'] = @$arrSeo['title'];
        $head['description'] = @$arrSeo['description'];
        $head['keywords'] = str_replace(" ", ",", $head['title']);
        $this->render('shopping_cart', $head, $data);
    }

}
