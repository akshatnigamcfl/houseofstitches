<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ShoppingCart {
    
    protected $CI;
    public $sumValues;
    
    public function __construct() {
        $this->CI = &get_instance();
        $this->CI->load->model('admin/Home_admin_model');
        $this->CI->load->database();
    }

    public function manageShoppingCart() { 
       $session_id = user_id();  // Generate/store unique session ID
        //$session_id =1;
        $mrp = isset($_POST['mrp']) ? $_POST['mrp'] :'';
        $wsp = isset($_POST['wsp']) ? $_POST['wsp'] :'';
        if ($_POST['action'] == 'add') {
            $this->addToCart($_POST['article_id'], $mrp, $wsp,$session_id);
        }
        
        if ($_POST['action'] == 'remove') {
            $this->removeFromCart($_POST['article_id'], $session_id);
        }
        
        $result = $this->getCartItems($session_id);
        
        // Your existing static call
        $loop = $this->CI->loop;
        $loop::getCartItems($result);
    }
    
    
    private function getSessionId() {
        $session_id = $this->CI->input->cookie('cart_session_id');
        if (!$session_id) {
            $session_id = uniqid('cart_', true);
            set_cookie('cart_session_id', $session_id, 2678400);  // 1 month
        }
        return $session_id;
    }

    private function addToCart($article_id, $mrp, $wsp, $session_id) {
        $set_qty = (int)get_product_quantity($article_id);
        if ($set_qty <= 0) $set_qty = 4;

        $existing = $this->CI->db->get_where('cart_items', [
            'session_id' => $session_id,
            'product_id' => $article_id,
        ])->row_array();

        if ($existing) {
            $new_quantity = (int)$existing['quantity'] + $set_qty;
            $new_sets     = (int)$existing['set_quantity'] + 1;
            $update = ['quantity' => $new_quantity, 'set_quantity' => $new_sets];
            if (!empty($wsp))  $update['wsp'] = $wsp;
            if (!empty($mrp))  $update['mrp'] = $mrp;
            $this->CI->db->where(['session_id' => $session_id, 'product_id' => $article_id])
                         ->update('cart_items', $update);
        } else {
            $this->CI->db->insert('cart_items', [
                'session_id'   => $session_id,
                'product_id'   => $article_id,
                'quantity'     => $set_qty,
                'price'        => 0,
                'mrp'          => $mrp,
                'wsp'          => $wsp,
                'set_quantity' => 1,
            ]);
        }

        echo json_encode(['success' => true]);
        exit();
    }


    private function removeFromCart($article_id, $session_id) {
        $this->CI->db->delete('cart_items', [
            'session_id' => user_id(),
            'product_id' => $article_id
        ]);
    }

    /*public function removeFromCart() {  // Legacy method for GET requests
        $session_id = $this->getSessionId();
        $this->removeFromCart($_GET['delete-product'], $session_id);
    }*/

    public function getCartItems($session_id = null) {
    if (!$session_id) {
        $session_id = $this->getSessionId();
    }
    
    // Build query safely
    $this->CI->db->select('ci.*, pt.title as name, p.image');
    $this->CI->db->from('cart_items ci');
    $this->CI->db->join('products p', 'p.id = ci.product_id', 'left');
    $this->CI->db->join('products_translations pt', 'pt.for_id = ci.product_id AND pt.abbr = \'' . MY_LANGUAGE_ABBR . '\'', 'left');
    $this->CI->db->where('ci.session_id', user_id());
    $this->CI->db->where('ci.set_quantity >', 0);
    // EXECUTE QUERY SAFELY
    $query = $this->CI->db->get();
    // CHECK IF QUERY FAILED
    if ($query === FALSE) {
        log_message('error', 'Cart query failed: ' . $this->CI->db->last_query());
        return 0;
    }
    
    // NOW SAFE TO USE num_rows()
    if ($query->num_rows() == 0) {
        return 0;
    }
    
    $result = ['array' => $query->result_array()];
    $finalSum = 0;
    
    foreach ($result['array'] as &$article) {
        $article['num_added'] = $article['quantity'];
        $article['sum_price'] = $article['wsp'] * $article['quantity'];
        $finalSum += $article['sum_price'];
        $article['sum_price'] = number_format($article['sum_price'], 2);
        $article['price'] = number_format($article['wsp'], 2);
    }
    
    $this->sumValues = count($result['array']);
    $result['finalSum'] = number_format($finalSum, 2);
    return $result;
}


    public function clearShoppingCart() {
        $this->CI->db->delete('cart_items', ['session_id' => user_id()]);

        if ($this->CI->input->is_ajax_request()) {
            echo 1;
        }
    }
}
