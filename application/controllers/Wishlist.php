<?php
class Wishlist extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('wishlist_model');
        $this->load->helper('developer_helper');
        //$this->load->library('session');
    }
    
    public function toggle() { 
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $product_id = $this->input->post('product_id');
        $info = $this->session->all_userdata();
        //print_r($info); die;
        $user_id = user_id(); // Assuming logged in
      
        if (!$user_id) {
            echo json_encode(['status' => 'error', 'message' => 'Please login']);
            return;
        }
        
        if ($this->wishlist_model->is_in_wishlist($user_id, $product_id)) {
            $this->wishlist_model->remove_wishlist($user_id, $product_id);
            echo json_encode([
                'status' => 'removed', 
                'message' => 'Removed from wishlist',
                'icon' => 'far fa-heart', // empty heart
                'count' => $this->wishlist_model->get_wishlist_count($user_id)
            ]);
        } else {
            $this->wishlist_model->add_wishlist($user_id, $product_id);
            echo json_encode([
                'status' => 'added', 
                'message' => 'Added to wishlist',
                'icon' => 'fas fa-heart', // filled heart
                'count' => $this->wishlist_model->get_wishlist_count($user_id)
            ]);
        }
    }
    
    public function get_wishlist() {
        $user_id = $this->session->userdata('user_id');
        $wishlist = $this->wishlist_model->get_wishlist_items($user_id);
        echo json_encode($wishlist);
    }
}
