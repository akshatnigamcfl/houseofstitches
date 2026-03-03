<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/*
 * Clean query strings and protocols from urls
 * Returns only hostname
 */
function get_cart_count_fast() {
    $CI =& get_instance();
    $session_id = $CI->input->cookie('cart_session_id');
    if (!$session_id) return 0;
    
    return $CI->db->where('session_id', user_id())
                  ->count_all_results('cart_items');
}

 function cart_item(){
     // In controller, model, or helper
   $CI =& get_instance(); 
$CI->db->select('
    ci.id as id,
    ci.product_id,
    ci.quantity,
    ci.price as cart_price,
    ci.created_at,
    ci.set_quantity,
    p.id as product_id,
    p.title,
    p.description,
    p.brand,
    p.price ,
    p.color ,
    p.size_range ,
    p.set_pcs_qty ,
    p.msp as mrp,
    p.wsp ,
    p1.image,
    p1.shop_categorie,
    (p.price * ci.quantity) as subtotal
');

$CI->db->from('cart_items ci');
$CI->db->join('products_translations p', 'p.id = ci.product_id', 'left');
$CI->db->join('products p1', 'p.for_id = p1.id', 'left');
$CI->db->where('ci.session_id', user_id());
$CI->db->where('ci.set_quantity >', 0);           // quantity > 0
$CI->db->order_by('ci.created_at', 'DESC');

$query = $CI->db->get(); //echo $CI->db->last_query(); die;
    // ✅ CRITICAL: Check if query succeeded
    if ($query === FALSE) {
        log_message('error', 'Cart query failed: ' . $CI->db->last_query());
        log_message('error', 'DB Error: ' . print_r($CI->db->error(), true));
        return [];
    }
    
    // ✅ NOW SAFE to use result_array()
    return $query->num_rows() > 0 ? $query->result_array() : [];
    
    
 }
function user_id()
{   
   $CI =& get_instance(); 
   $info = $CI->session->all_userdata(); 
   $id = $info['logged_user']['id'];
    if(!empty($id)){
       $id = $info['logged_user']['id'];
   }else{
       $id = $info['logged_user'];
   } 
    return $id;
}
function get_loggedin_user_details()
{   
   $CI =& get_instance(); 
   $info = $CI->session->all_userdata(); 

   $id = $info['logged_user']['id'];
   if(!empty($id)){
       $id = $info['logged_user']['id'];
   }else{
       $id = $info['logged_user'];
   }
   $user = $CI->db->query('SELECT * FROM `users_public` where id = '.$id.'')->result();
    return $user['0'];
}
function get_product_quantity($item_id)
{   
$CI =& get_instance(); 

// ✅ FIXED: Safe query with error checking
$query = $CI->db->query('SELECT set_pcs_qty FROM `products_translations` WHERE id = ' . (int)$item_id);

if ($query === FALSE) {
    // Query failed - log error
    log_message('error', 'Query failed: ' . $CI->db->last_query());
    log_message('error', 'DB Error: ' . print_r($CI->db->error(), true));
    $qty = 4;  // Default fallback
} elseif ($query->num_rows() > 0) {
    $qty = $query->row()->set_pcs_qty;
} else {
    $qty = 4;  // No record found - default
}
   
    return $qty;
}
function get_loggedin_user_agent() {
    $CI =& get_instance(); 
    $info = $CI->session->all_userdata(); 
    
    // Fix: Handle array properly - get first agent ID or main user ID
    $id = null;
    if (isset($info['logged_user']['agents']) && is_array($info['logged_user']['agents'])) {
        $id = $info['logged_user']['agents'][0];  // First agent ID
    } elseif (isset($info['logged_user']) && is_numeric($info['logged_user'])) {
        $id = $info['logged_user'];  // Scalar user ID
    }
    
    if (!$id || !is_numeric($id)) {
        return null;  // No valid ID
    }
    
    $user = $CI->db->query('SELECT name FROM `users_public` WHERE id = ' . (int)$id)->row();
    return $user ? $user->name : null;
}
function get_product_details($product_id)
{   
   $CI =& get_instance(); 
   $info = $CI->session->all_userdata(); 
   
   $id = $info['logged_user']['id'];
   $product = $CI->db->query('SELECT p.*, pt.* FROM products AS p LEFT JOIN products_translations AS pt ON pt.for_id = p.id where p.id = '.$product_id.'')->row();
    return $product;
}
function get_current_user_info()
{   
   $CI =& get_instance(); 
   $info = $CI->session->all_userdata(); 
   
   $id = $info['logged_user']['id']; 
   $info = $CI->db->query('SELECT * FROM `users_public` where id = '.user_id().'')->row();
    return $info;
}
function get_order_received()
{   
   $CI =& get_instance(); 
   $info = $CI->session->all_userdata(); 
   
   $id = $info['logged_user']['id']; 
   $count = $CI->db->query('SELECT * FROM `orders` where processed = 0')->result();
    return count($count);
}

function calculate_discount($total, $percent) {
    // Remove commas and convert to float
    $total = (float) str_replace(',', '', $total);
    $percent = (float) $percent;
    
    $discount_amount = ($total * $percent) / 100;
    $final_amount = $total - $discount_amount;
    
    return [
        'discount' => round($discount_amount, 2),
        'final' => round($final_amount, 2)
    ];
}



function get_order()
{   
   $CI =& get_instance(); 
   $info = $CI->session->all_userdata(); 
   
   $userid = $info['logged_user']['id']; 
   $result = $CI->db->query('SELECT * FROM `orders` where user_id = '.$userid.' ')->result();
    return $result;
}
