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

function cart_item() {
    $CI =& get_instance();
    $CI->db->select('
        ci.id as id,
        ci.product_id,
        ci.quantity,
        ci.set_quantity,
        p1.image,
        pt.title,
        pt.brand,
        pt.color,
        pt.size_range,
        pt.msp as mrp,
        pt.wsp
    ');

    $CI->db->from('cart_items ci');
    $CI->db->join('products p1', 'p1.id = ci.product_id', 'left');
    $CI->db->join('products_translations pt', 'pt.for_id = ci.product_id AND pt.abbr = \'' . MY_LANGUAGE_ABBR . '\'', 'left');
    $CI->db->where('ci.session_id', user_id());
    $CI->db->where('ci.set_quantity >', 0);
    $CI->db->order_by('ci.id', 'DESC');

    $query = $CI->db->get();

    // ✅ CRITICAL: Check if query succeeded
    if ($query === FALSE) {
        log_message('error', 'Cart query failed: ' . $CI->db->last_query());
        log_message('error', 'DB Error: ' . print_r($CI->db->error(), true));
        return [];
    }
    
    // ✅ NOW SAFE to use result_array()
    return $query->num_rows() > 0 ? $query->result_array() : [];
    
    
 }


function is_logged_in() {
    $CI =& get_instance();
    $logged_user = $CI->session->userdata('logged_user');
    return !empty($logged_user);
}

function user_id()
{
    $CI =& get_instance();
    $logged_user = $CI->session->userdata('logged_user');
    if (empty($logged_user)) {
        return null;
    }
    if (is_array($logged_user) && isset($logged_user['id'])) {
        return $logged_user['id'];
    }
    return $logged_user;
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

    // For DB2-synced products: set size = count of sizes currently in stock
    if ($CI->db->table_exists('product_barcodes')) {
        $p = $CI->db->select('itm_synced')->where('id', (int)$item_id)->get('products')->row();
        if ($p && (int)$p->itm_synced === 1) {
            $count = $CI->db->where('product_id', (int)$item_id)
                            ->where('stock_qty >', 0)
                            ->count_all_results('product_barcodes');
            return (int)$count;
        }
    }

    // Manual products: use set_pcs_qty from products_translations
    $query = $CI->db->query('SELECT set_pcs_qty FROM `products_translations` WHERE for_id = ' . (int)$item_id . ' LIMIT 1');
    if ($query && $query->num_rows() > 0 && $query->row()->set_pcs_qty > 0) {
        return (int)$query->row()->set_pcs_qty;
    }
    return 1; // default fallback
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
   if (empty($product_id)) return null;
   $CI =& get_instance();
   $query = $CI->db->query('SELECT p.*, pt.* FROM products AS p LEFT JOIN products_translations AS pt ON pt.for_id = p.id where p.id = ' . (int)$product_id);
   if ($query === FALSE) return null;
   return $query->num_rows() > 0 ? $query->row() : null;
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
