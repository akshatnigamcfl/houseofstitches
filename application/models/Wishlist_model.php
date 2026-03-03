<?php
class Wishlist_model extends CI_Model {
    
    public function add_wishlist($user_id, $product_id) {
        $data = array(
            'user_id' => $user_id,
            'product_id' => $product_id
        );
        $this->db->insert('wishlists', $data);
        return $this->db->insert_id();
    }
    
    public function remove_wishlist($user_id, $product_id) {
        $this->db->where('user_id', $user_id);
        $this->db->where('product_id', $product_id);
        return $this->db->delete('wishlists');
    }
    
    public function is_in_wishlist($user_id, $product_id) {
        $this->db->where('user_id', $user_id);
        $this->db->where('product_id', $product_id);
        $query = $this->db->get('wishlists');
        return $query->num_rows() > 0;
    }
    
    public function get_wishlist_count($user_id) {
        $this->db->where('user_id', $user_id);
        return $this->db->count_all_results('wishlists');
    }
    public function get_wishlist(){
        $result =$this->db->query('SELECT wishlists.id,wishlists.user_id,wishlists.product_id,wishlists.created_at, products.id,products.image,products_translations.title,products_translations.description,products_translations.wsp,products_translations.color FROM wishlists LEFT JOIN products ON wishlists.product_id = products.id LEFT JOIN products_translations ON wishlists.product_id = products_translations.for_id where wishlists.user_id='.user_id().' ')->result();
        return $result;
    }
}







