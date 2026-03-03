<?php
class Cart extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Cart_model');
        $this->load->library('session');
    }
    
    // Add to cart
    public function add($product_id) {
        $session_id = $this->session->userdata('session_id') ?: session_id();
        $this->session->set_userdata('session_id', $session_id);
        
        $product = $this->Cart_model->get_product($product_id);
        if (!$product || $product->stock <= 0) {
            echo json_encode(['success' => false, 'message' => 'Out of stock']);
            return;
        }
        
        $cart_item = $this->Cart_model->get_cart_item($session_id, $product_id);
        if ($cart_item) {
            // Update quantity
            $new_qty = $cart_item->quantity + 1;
            if ($new_qty > $product->stock) {
                echo json_encode(['success' => false, 'message' => 'Stock limit exceeded']);
                return;
            }
            $this->Cart_model->update_cart($cart_item->id, $new_qty);
        } else {
            // Add new
            $this->Cart_model->add_to_cart($session_id, $product_id, $product->price);
        }
        
        echo json_encode([
            'success' => true, 
            'message' => 'Added to cart',
            'cart_count' => $this->Cart_model->get_cart_count($session_id)
        ]);
    }
    
    // Remove from cart
    public function remove($cart_id) {
        $session_id = $this->session->userdata('session_id');
        $this->Cart_model->remove_from_cart($session_id, $cart_id);
        echo json_encode(['success' => true]);
    }
    
    
    // Update quantity
    public function update($cart_id) {
        $quantity = $this->input->post('quantity');
        $session_id = $this->session->userdata('session_id');
        
        $cart_item = $this->Cart_model->get_cart_item_by_id($cart_id, $session_id);
        $product = $this->Cart_model->get_product($cart_item->product_id);
        
        if ($quantity > $product->stock) {
            echo json_encode(['success' => false, 'message' => 'Stock limit']);
            return;
        }
        
        $this->Cart_model->update_cart($cart_id, $quantity);
        echo json_encode(['success' => true]);
    }
    
    // Get cart contents
    public function get_cart() {
        $session_id = $this->session->userdata('session_id');
        $cart_items = $this->Cart_model->get_cart_items($session_id);
        $total = $this->Cart_model->get_cart_total($session_id);
        
        $data = [
            'items' => $cart_items,
            'total' => $total,
            'count' => count($cart_items)
        ];
        echo json_encode($data);
    }
    
    // Checkout
    public function checkout() {
        $session_id = $this->session->userdata('session_id');
        $cart_items = $this->Cart_model->get_cart_items($session_id);
        $total = $this->Cart_model->get_cart_total($session_id);
        
        if (empty($cart_items)) {
            redirect('shop');
        }
        
        $order_id = 'ORD-' . date('Ymd-His');
        $this->Cart_model->create_order($order_id, $session_id, $total);
        
        // Clear cart
        $this->Cart_model->clear_cart($session_id);
        echo json_encode(['success' => true, 'order_id' => $order_id]);
    }
}
