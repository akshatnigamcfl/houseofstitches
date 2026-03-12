<?php

class Public_model extends CI_Model
{

    private $showOutOfStock;
    private $showInSliderProducts;
    private $multiVendor;

    public function __construct()
    {
        parent::__construct();
        
        $this->load->Model('Home_admin_model');
        $this->showOutOfStock = $this->Home_admin_model->getValueStore('outOfStock');
        $this->showInSliderProducts = $this->Home_admin_model->getValueStore('showInSlider');
        $this->multiVendor = $this->Home_admin_model->getValueStore('multiVendor');

        $this->load->library('encryption');
    }

    public function productsCount($big_get)
    {
        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'left');
        $this->db->where('products_translations.abbr', MY_LANGUAGE_ABBR);
        if (!empty($big_get)) {
            $this->getFilter($big_get);
        }
        $this->db->where('visibility', 1);
        if ($this->showOutOfStock == 0) {
            $this->db->where('quantity >', 0);
        }
        if ($this->showInSliderProducts == 0) {
            $this->db->where('in_slider', 0);
        }
        if ($this->multiVendor == 0) {
            $this->db->where('vendor_id', 0);
        }
        return $this->db->count_all_results('products');
    }

    public function getNewProducts()
    {
        $limit = $this->_getSectionLimit('new_arrivals');
        if ($this->db->table_exists('home_sections')) {
            $count = $this->db->where('section', 'new_arrivals')->count_all_results('home_sections');
            if ($count > 0) {
                return $this->_getSectionProducts('new_arrivals', $limit);
            }
        }
        $this->db->select('vendors.url as vendor_url, products.id, products.quantity, products.image, products.url, products_translations.price, products_translations.title, products_translations.old_price');
        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'left');
        $this->db->join('vendors', 'vendors.id = products.vendor_id', 'left');
        $this->db->where('products_translations.abbr', MY_LANGUAGE_ABBR);
        $this->db->where('products.in_slider', 0);
        $this->db->where('visibility', 1);
        if ($this->showOutOfStock == 0) {
            $this->db->where('quantity >', 0);
        }
        $this->db->order_by('products.id', 'desc');
        $this->db->limit($limit);
        $query = $this->db->get('products');
        return $query->result_array();
    }

    public function getFeaturedProducts()
    {
        $limit = $this->_getSectionLimit('featured');
        if ($this->db->table_exists('home_sections')) {
            $count = $this->db->where('section', 'featured')->count_all_results('home_sections');
            if ($count > 0) {
                return $this->_getSectionProducts('featured', $limit);
            }
        }
        return $this->getSliderProducts();
    }

    private function _getSectionLimit($section)
    {
        if ($this->db->table_exists('home_section_settings')) {
            $row = $this->db->get_where('home_section_settings', ['section' => $section])->row();
            if ($row) return (int)$row->item_limit;
        }
        return 8;
    }

    private function _getSectionProducts($section, $limit)
    {
        return $this->db->query("
            SELECT vendors.url AS vendor_url, p.id, p.quantity, p.image, p.url,
                   pt.price, pt.title, pt.old_price
            FROM home_sections hs
            JOIN products p ON p.id = hs.product_id
            JOIN products_translations pt ON pt.for_id = p.id AND pt.abbr = '" . MY_LANGUAGE_ABBR . "'
            LEFT JOIN vendors ON vendors.id = p.vendor_id
            WHERE hs.section = '" . $this->db->escape_str($section) . "'
            AND p.visibility = 1
            ORDER BY hs.sort_order ASC, hs.id ASC
            LIMIT " . (int)$limit . "
        ")->result_array();
    }

    public function getLastBlogs()
    {
        $this->db->limit(5);
        $this->db->join('blog_translations', 'blog_translations.for_id = blog_posts.id', 'left');
        $this->db->where('blog_translations.abbr', MY_LANGUAGE_ABBR);
        $query = $this->db->select('blog_posts.id, blog_translations.title, blog_translations.description, blog_posts.url, blog_posts.time, blog_posts.image')->get('blog_posts');
        return $query->result_array();
    }

    public function getPosts($limit, $page, $search = null, $month = null)
    {
        if ($search !== null) {
            $search = $this->db->escape_like_str($search);
            $this->db->where("(blog_translations.title LIKE '%$search%' OR blog_translations.description LIKE '%$search%')");
        }
        if ($month !== null) {
            $from = intval($month['from']);
            $to = intval($month['to']);
            $this->db->where("time BETWEEN $from AND $to");
        }
        $this->db->join('blog_translations', 'blog_translations.for_id = blog_posts.id', 'left');
        $this->db->where('blog_translations.abbr', MY_LANGUAGE_ABBR);
        $query = $this->db->select('blog_posts.id, blog_translations.title, blog_translations.description, blog_posts.url, blog_posts.time, blog_posts.image')->get('blog_posts', $limit, $page);
        return $query->result_array();
    }

    public function getProducts($limit = null, $start = null, $big_get = [], $vendor_id = false)
    {  //print_r($big_get); die;
        if ($limit !== null && $start !== null) {
            $this->db->limit($limit, $start);
        }
        if (!empty($big_get)) {
            $this->getFilter($big_get);
        }
        $this->db->select('vendors.url as vendor_url, products.id,products.image, products.quantity, 
        products_translations.title,
        products_translations.price, 
        products_translations.color, 
        products_translations.brand, 
        products_translations.season, 
        products_translations.description, 
        products_translations.fabric, 
        products_translations.msp, products_translations.wsp, products_translations.size_range, products_translations.size_range,
        products_translations.old_price, products.url');
        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'left');
        $this->db->join('vendors', 'vendors.id = products.vendor_id', 'left');
        $this->db->where('products_translations.abbr', MY_LANGUAGE_ABBR);
        $this->db->where('visibility', 1);
        if ($vendor_id !== false) {
            $this->db->where('vendor_id', $vendor_id);
        }
        if ($this->showOutOfStock == 0) {
            $this->db->where('quantity >', 0);
        }
        if ($this->showInSliderProducts == 0) {
            $this->db->where('in_slider', 0);
        }
        if ($this->multiVendor == 0) {
            $this->db->where('vendor_id', 0);
        }
        $this->db->order_by('position', 'asc');
        $query = $this->db->get('products'); 
         //echo $this->db->last_query(); die;
        return $query->result_array();
    }

    public function getOneLanguage($myLang)
    {
        $this->db->select('*');
        $this->db->where('abbr', $myLang);
        $result = $this->db->get('languages');
        return $result->row_array();
    }

    private function getFilter($big_get)
    {
        $big_get = array_merge([
            'category' => '', 'in_stock' => '', 'search_in_title' => '',
            'season' => '', 'gender' => '', 'search_in_brand' => '',
            'search_in_desc' => '', 'search_in_color' => '', 'search_in_size' => '',
            'search_in_body' => '', 'order_price' => '', 'order_procurement' => '',
            'order_new' => '', 'quantity_more' => '', 'brand_id' => '',
            'added_after' => '', 'added_before' => '', 'price_from' => '', 'price_to' => '',
        ], $big_get);

        if ($big_get['category'] != '') {
            $catIds = array_filter(array_map('intval', explode(',', $big_get['category'])));
            if (!empty($catIds)) {
                $findInIds = $catIds;
                foreach ($catIds as $cid) {
                    $q = $this->db->query('SELECT id FROM shop_categories WHERE sub_for = ' . (int)$cid);
                    foreach ($q->result() as $row) {
                        $findInIds[] = (int)$row->id;
                    }
                }
                $this->db->where_in('products.shop_categorie', array_unique($findInIds));
            }
        }
        if ($big_get['in_stock'] != '') {
            $sign = ($big_get['in_stock'] == 1) ? '>' : '=';
            $this->db->where('products.quantity ' . $sign, '0');
        }
        if ($big_get['search_in_title'] != '') {
            $this->db->like('products_translations.title', $big_get['search_in_title']);
        }
        if ($big_get['season'] != '') {
            $search = array_filter(array_unique(explode(',', $big_get['season'])));
            if (!empty($search)) {
                $this->db->group_start();
                foreach ($search as $i => $val) {
                    if ($i === 0) {
                        $this->db->like('products_translations.season', trim($val));
                    } else {
                        $this->db->or_like('products_translations.season', trim($val));
                    }
                }
                $this->db->group_end();
            }
        }
        if ($big_get['gender'] != '') {
            $this->db->like('products_translations.gender', $big_get['gender']);
        }
        if ($big_get['search_in_brand'] != '') {
            $this->db->where('products_translations.brand', $big_get['search_in_brand']);
        }   
        if ($big_get['search_in_desc'] != '') {  
            $clean = str_replace('+', '', $big_get['search_in_desc']);
            $this->db->like('products_translations.description', $big_get['search_in_desc']);
        } 
        if ($big_get['search_in_color'] != '') {  
            $clean = str_replace('+', '', $big_get['search_in_color']);
            $this->db->like('products_translations.color', $big_get['search_in_color']);
        } 
        if ($big_get['search_in_size'] != '') {  
            $clean = str_replace('+', '', $big_get['search_in_size']);
            $this->db->like('products_translations.size_range', $big_get['search_in_size']);
        }
        if ($big_get['search_in_body'] != '') {
            $this->db->like('products_translations.description', $big_get['search_in_body']);
        }
        if ($big_get['order_price'] != '') {
            $this->db->order_by('products_translations.price', $big_get['order_price']);
        }
        if ($big_get['order_procurement'] != '') {
            $this->db->order_by('products.procurement', $big_get['order_procurement']);
        }
        if ($big_get['order_new'] != '') {
            $this->db->order_by('products.id', $big_get['order_new']);
        } else {
            $this->db->order_by('products.id', 'DESC');
        }
        if ($big_get['quantity_more'] != '') {
            $this->db->where('products.quantity > ', $big_get['quantity_more']);
        }
        if ($big_get['quantity_more'] != '') {
            $this->db->where('products.quantity > ', $big_get['quantity_more']);
        }
        if ($big_get['brand_id'] != '') {
            $this->db->where('products.brand_id = ', $big_get['brand_id']);
        }
        if ($big_get['added_after'] != '') {
            $added_after = \DateTime::createFromFormat('d/m/Y', $big_get['added_after']);
            if($added_after) {
                $time = $added_after->getTimestamp();
                $this->db->where('products.time > ', $time);
            }
        }
       // echo $this->db->last_query(); die;
        if ($big_get['added_before'] != '') {
            $added_before = \DateTime::createFromFormat('d/m/Y', $big_get['added_before']);
            if($added_before) {
                $time = $added_before->getTimestamp();
                $this->db->where('products.time < ', $time);
            }
        }
        if ($big_get['price_from'] != '') {
            $this->db->where('products_translations.price >= ', $big_get['price_from']);
        }
        if ($big_get['price_to'] != '') {
            $this->db->where('products_translations.price <= ', $big_get['price_to']);
        }
        
    }

    /**
     * Returns sorted distinct non-empty values of a products_translations column.
     * Allowed fields: season, gender, fabric, brand, color, size_range
     */
    public function getDistinctFilterValues($field)
    {
        $allowed = ['season', 'gender', 'fabric', 'brand', 'color', 'size_range'];
        if (!in_array($field, $allowed)) return [];

        // Normalize legacy numeric gender values to text labels
        if ($field === 'gender') {
            $this->db->query("UPDATE products_translations SET gender='Girls'  WHERE gender='1'");
            $this->db->query("UPDATE products_translations SET gender='Boys'   WHERE gender='2'");
            $this->db->query("UPDATE products_translations SET gender='Infant' WHERE gender='3'");
            $this->db->query("UPDATE products_translations SET gender='Unisex' WHERE gender='4'");
        }

        $query = $this->db->query(
            "SELECT DISTINCT `$field` FROM products_translations
             WHERE `$field` IS NOT NULL AND `$field` != ''
             AND abbr = ? ORDER BY `$field` ASC",
            [MY_LANGUAGE_ABBR]
        );
        $values = [];
        foreach ($query->result_array() as $row) {
            // Season/gender may be stored as comma-separated; split them out
            foreach (array_map('trim', explode(',', $row[$field])) as $v) {
                if ($v !== '') $values[$v] = $v;
            }
        }
        return array_values($values);
    }

    public function getShopCategories()
    {
        $this->db->select('shop_categories.sub_for, shop_categories.id, shop_categories_translations.name');
        $this->db->where('shop_categories_translations.abbr', MY_LANGUAGE_ABBR);
        $this->db->where('shop_categories_translations.name IS NOT NULL');
        $this->db->where('shop_categories_translations.name !=', '');
        $this->db->order_by('shop_categories.position', 'asc');
        $this->db->join('shop_categories', 'shop_categories.id = shop_categories_translations.for_id', 'INNER');
        $query = $this->db->get('shop_categories_translations');
        $arr = array();
        if ($query !== false) {
            foreach ($query->result_array() as $row) {
                $arr[] = $row;
            }
        }
        return $arr;
    }

    public function getSeo($page)
    {
        $this->db->where('page_type', $page);
        $this->db->where('abbr', MY_LANGUAGE_ABBR);
        $query = $this->db->get('seo_pages_translations');
        $arr = array();
        if ($query !== false) {
            foreach ($query->result_array() as $row) {
                $arr['title'] = $row['title'];
                $arr['description'] = $row['description'];
            }
        }
        return $arr;
    }

    public function getOneProduct($id)
    {
        $this->db->where('products.id', $id);

        $this->db->select('vendors.url as vendor_url, products.*, products_translations.title, products_translations.description, products_translations.price, products_translations.old_price, products_translations.wsp, products_translations.msp, products_translations.color, products_translations.size_range, products_translations.fabric, products_translations.brand, products_translations.season, products.url, shop_categories_translations.name as categorie_name');

        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'left');
        $this->db->where('products_translations.abbr', MY_LANGUAGE_ABBR);

        $this->db->join('shop_categories_translations', 'shop_categories_translations.for_id = products.shop_categorie', 'inner');
        $this->db->where('shop_categories_translations.abbr', MY_LANGUAGE_ABBR);
        $this->db->join('vendors', 'vendors.id = products.vendor_id', 'left');
        $this->db->where('visibility', 1);
        $query = $this->db->get('products');
        return $query->row_array();
    }

    public function getCountQuantities()
    {
        $query = $this->db->query('SELECT SUM(IF(quantity<=0,1,0)) as out_of_stock, SUM(IF(quantity>0,1,0)) as in_stock FROM products WHERE visibility = 1');
        return $query->row_array();
    }

    public function getShopItems($array_items)
    {
        $this->db->select('products.id, products.image, products.url, products.quantity, products_translations.price, products_translations.title');
        $this->db->from('products');
        if (count($array_items) > 1) {
            $i = 1;
            $where = '';
            foreach ($array_items as $id) {
                $i == 1 ? $open = '(' : $open = '';
                $i == count($array_items) ? $or = '' : $or = ' OR ';
                $where .= $open . 'products.id = ' . $id . $or;
                $i++;
            }
            $where .= ')';
            $this->db->where($where);
        } else {
            $this->db->where('products.id =', current($array_items));
        }
        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'inner');
        $this->db->where('products_translations.abbr', MY_LANGUAGE_ABBR);
        $query = $this->db->get();
        return $query->result_array();
    }

    /*
     * Users for notification by email
     */

    public function getNotifyUsers()
    {
        $result = $this->db->query('SELECT email FROM users WHERE notify = 1');
        $arr = array();
        foreach ($result->result_array() as $email) {
            $arr[] = $email['email'];
        }
        return $arr;
    }

    public function setOrder($post)
    {    
        $q = $this->db->query('SELECT MAX(order_id) as order_id FROM orders');
        $rr = $q->row_array();
        if ($rr['order_id'] == 0) {
            $rr['order_id'] = 1233;
        }
        $post['order_id'] = $rr['order_id'] + 1;

        $i = 0;
        $post['products'] = array();
        foreach ($post['id'] as $product) {
            $post['products'][$product] = $post['quantity'][$i];
            $i++;
        }
        unset($post['id'], $post['quantity']);
        $post['date'] = time();
        $products_to_order = [];
        if(!empty($post['products'])) {
            foreach($post['products'] as $pr_id => $pr_qua) {
                $products_to_order[] = [
                    'product_info' => $this->getOneProductForSerialize($pr_id),
                    'product_quantity' => $pr_qua
                    ];
            }
        }
        $post['products'] = serialize($products_to_order);
        $this->db->trans_begin();
        $uid = !empty($post['user_id']['id']) ? $post['user_id']['id'] : user_id();
       /* echo '<pre>'; print_r(array(
                    'order_id' => $post['order_id'],
                    'products' => $post['products'],
                    'date' => $post['date'],
                    'referrer' => $post['referrer'],
                    'clean_referrer' => $post['clean_referrer'],
                    'payment_type' => $post['payment_type'],
                    'paypal_status' => @$post['paypal_status'],
                    'discount_code' => @$post['discountCode'],
                    'user_id' => $post['user_id']['id']
                )); die;*/
        if (!$this->db->insert('orders', array(
                    'order_id' => $post['order_id'],
                    'products' => $post['products'],
                    'date' => $post['date'],
                    'referrer' => $post['referrer'],
                    'clean_referrer' => $post['clean_referrer'],
                    'payment_type' => $post['payment_type'],
                    'paypal_status' => @$post['paypal_status'],
                    'discount_code' => @$post['discountCode'],
                    'user_id' => $uid
                ))) { 
            log_message('new error', print_r($this->db->error(), true));
        }else{
           // die('come in else');
        }
        $lastId = $this->db->insert_id();
        if(isset($post['last_name'])){
            $last_name = $this->encryption->encrypt($post['last_name']);
        }else{
            $last_name = '';
        } 
        if(isset($post['post_code'])){
            $post_code = $this->encryption->encrypt($post['post_code']);
        }else{
            $post_code = '';
        }
        if(isset($post['notes'])){
            $notes = $this->encryption->encrypt($post['notes']);
        }else{
            $notes = '';
        }
        // Ensure company/gst columns exist (added in v1.0.5)
        if (!$this->db->field_exists('company', 'orders_clients')) {
            $this->db->query('ALTER TABLE `orders_clients` ADD COLUMN `company` VARCHAR(200) NOT NULL DEFAULT \'\' AFTER `first_name`');
        }
        if (!$this->db->field_exists('gst', 'orders_clients')) {
            $this->db->query('ALTER TABLE `orders_clients` ADD COLUMN `gst` VARCHAR(50) NOT NULL DEFAULT \'\' AFTER `company`');
        }
        if (!$this->db->insert('orders_clients', array(
                    'for_id'     => $lastId,
                    'first_name' => $this->encryption->encrypt($post['first_name']),
                    'company'    => $this->encryption->encrypt($post['company'] ?? ''),
                    'gst'        => $this->encryption->encrypt($post['gst']     ?? ''),
                    'last_name'  => $last_name,
                    'email'      => $this->encryption->encrypt($post['email']),
                    'phone'      => $this->encryption->encrypt($post['phone']),
                    'address'    => $this->encryption->encrypt($post['address']),
                    'city'       => $this->encryption->encrypt($post['city']),
                    'post_code'  => $post_code,
                    'notes'      => $notes
                ))) {
            log_message('error', print_r($this->db->error(), true));
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return $post['order_id'];
        }
    }
    
    private function getOneProductForSerialize($id)
    {
        $this->db->select('vendors.name as vendor_name, vendors.id as vendor_id, products.*, products_translations.price');
        $this->db->where('products.id', $id);
        $this->db->join('vendors', 'vendors.id = products.vendor_id', 'left');
        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'inner');
        $this->db->where('products_translations.abbr', MY_DEFAULT_LANGUAGE_ABBR);
        $query = $this->db->get('products');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function setVendorOrder($post)
    {
        $i = 0;
        $post['products'] = array();
        foreach ($post['id'] as $product) {
            $post['products'][$product] = $post['quantity'][$i];
            $i++;
        }

        /*
         * Loop products and check if its from vendor - save order for him
         */
        foreach ($post['products'] as $product_id => $product_quantity) {
            $productInfo = $this->getOneProduct($product_id);
            if ($productInfo['vendor_id'] > 0) {

                $q = $this->db->query('SELECT MAX(order_id) as order_id FROM vendors_orders');
                $rr = $q->row_array();
                if ($rr['order_id'] == 0) {
                    $rr['order_id'] = 1233;
                }
                $post['order_id'] = $rr['order_id'] + 1;


                unset($post['id'], $post['quantity']);
                $post['date'] = time();
                $post['products'] = serialize(array($product_id => $product_quantity));
                $this->db->trans_begin();
                if (!$this->db->insert('vendors_orders', array(
                            'order_id' => $post['order_id'],
                            'products' => $post['products'],
                            'date' => $post['date'],
                            'referrer' => $post['referrer'],
                            'clean_referrer' => $post['clean_referrer'],
                            'payment_type' => $post['payment_type'],
                            'paypal_status' => @$post['paypal_status'],
                            'discount_code' => @$post['discountCode'],
                            'vendor_id' => $productInfo['vendor_id']
                        ))) {
                    log_message('error', print_r($this->db->error(), true));
                }
                $lastId = $this->db->insert_id();
                if (!$this->db->insert('vendors_orders_clients', array(
                            'for_id' => $lastId,
                            'first_name' => $this->encryption->encrypt($post['first_name']),
                            'last_name' => $this->encryption->encrypt($post['last_name']),
                            'email' => $this->encryption->encrypt($post['email']),
                            'phone' => $this->encryption->encrypt($post['phone']),
                            'address' => $this->encryption->encrypt($post['address']),
                            'city' => $this->encryption->encrypt($post['city']),
                            'post_code' => $this->encryption->encrypt($post['post_code']),
                            'notes' => $this->encryption->encrypt($post['notes'])
                        ))) {
                    log_message('error', print_r($this->db->error(), true));
                }
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    return false;
                } else {
                    $this->db->trans_commit();
                }
            }
        }
    }

    public function setActivationLink($link, $orderId)
    {
        $result = $this->db->insert('confirm_links', array('link' => $link, 'for_order' => $orderId));
        return $result;
    }

    public function getSliderProducts()
    {
        $this->db->select('vendors.url as vendor_url, products.id, products.quantity, products.image, products.url, products_translations.price, products_translations.title, products_translations.basic_description, products_translations.old_price');
        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'left');
        $this->db->join('vendors', 'vendors.id = products.vendor_id', 'left');
        $this->db->where('products_translations.abbr', MY_LANGUAGE_ABBR);
        $this->db->where('visibility', 1);
        $this->db->where('in_slider', 1);
        if ($this->showOutOfStock == 0) {
            $this->db->where('quantity >', 0);
        }
        $query = $this->db->get('products');
        return $query->result_array();
    }

    public function getbestSellers($categorie = 0, $noId = 0)
    {
        $limit = $this->_getSectionLimit('best_sellers');
        if ($this->db->table_exists('home_sections')) {
            $count = $this->db->where('section', 'best_sellers')->count_all_results('home_sections');
            if ($count > 0) {
                return $this->_getSectionProducts('best_sellers', $limit);
            }
        }
        $this->db->select('vendors.url as vendor_url, products.id, products.quantity, products.image, products.url, products_translations.price, products_translations.title, products_translations.old_price');
        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'left');
        $this->db->join('vendors', 'vendors.id = products.vendor_id', 'left');
        if ($noId > 0) {
            $this->db->where('products.id !=', $noId);
        }
        $this->db->where('products_translations.abbr', MY_LANGUAGE_ABBR);
        if ($categorie != 0) {
            $this->db->where('products.shop_categorie !=', $categorie);
        }
        $this->db->where('visibility', 1);
        if ($this->showOutOfStock == 0) {
            $this->db->where('quantity >', 0);
        }
        $this->db->order_by('products.procurement', 'desc');
        $this->db->limit($limit);
        $query = $this->db->get('products');
        return $query->result_array();
    }

    public function sameCagegoryProducts($categorie, $noId, $vendor_id = false)
    {
        $this->db->select('vendors.url as vendor_url, products.id, products.quantity, products.image, products.url, products_translations.price, products_translations.title, products_translations.old_price');
        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'left');
        $this->db->join('vendors', 'vendors.id = products.vendor_id', 'left');
        $this->db->where('products.id !=', $noId);
        if ($vendor_id !== false) {
            $this->db->where('vendor_id', $vendor_id);
        }
        $this->db->where('products.shop_categorie =', $categorie);
        $this->db->where('products_translations.abbr', MY_LANGUAGE_ABBR);
        $this->db->where('visibility', 1);
        if ($this->showOutOfStock == 0) {
            $this->db->where('quantity >', 0);
        }
        $this->db->order_by('products.id', 'desc');
        $this->db->limit(5);
        $query = $this->db->get('products');
        return $query->result_array();
    }

    public function getOnePost($id)
    {
        $this->db->select('blog_translations.title, blog_translations.description, blog_posts.image, blog_posts.time');
        $this->db->where('blog_posts.id', $id);
        $this->db->join('blog_translations', 'blog_translations.for_id = blog_posts.id', 'left');
        $this->db->where('blog_translations.abbr', MY_LANGUAGE_ABBR);
        $query = $this->db->get('blog_posts');
        return $query->row_array();
    }

    public function getArchives()
    {
        $result = $this->db->query("SELECT DATE_FORMAT(FROM_UNIXTIME(time), '%M %Y') as month, MAX(time) as maxtime, MIN(time) as mintime FROM blog_posts GROUP BY DATE_FORMAT(FROM_UNIXTIME(time), '%M %Y')");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        }
        return false;
    }

    public function getFooterCategories()
    {
        $this->db->select('shop_categories.id, shop_categories_translations.name');
        $this->db->where('abbr', MY_LANGUAGE_ABBR);
        $this->db->where('shop_categories.sub_for =', 0);
        $this->db->join('shop_categories', 'shop_categories.id = shop_categories_translations.for_id', 'INNER');
        $this->db->limit(10);
        $query = $this->db->get('shop_categories_translations');
        $arr = array();
        if ($query !== false) {
            foreach ($query->result_array() as $row) {
                $arr[$row['id']] = $row['name'];
            }
        }
        return $arr;
    }

    public function setSubscribe($array)
    {
        $num = $this->db->where('email', $array['email'])->count_all_results('subscribed');
        if ($num == 0) {
            $this->db->insert('subscribed', $array);
        }
    }

    public function getDynPagesLangs($dynPages)
    {
        if (!empty($dynPages)) {
            $this->db->join('textual_pages_tanslations', 'textual_pages_tanslations.for_id = active_pages.id', 'left');
            $this->db->where_in('active_pages.name', $dynPages);
            $this->db->where('textual_pages_tanslations.abbr', MY_LANGUAGE_ABBR);
            $result = $this->db->select('textual_pages_tanslations.name as lname, active_pages.name as pname')->get('active_pages');
            $ar = array();
            $i = 0;
            foreach ($result->result_array() as $arr) {
                $ar[$i]['lname'] = $arr['lname'];
                $ar[$i]['pname'] = $arr['pname'];
                $i++;
            }
            return $ar;
        } else
            return $dynPages;
    }

    public function getOnePage($page)
    {
        $this->db->join('textual_pages_tanslations', 'textual_pages_tanslations.for_id = active_pages.id', 'left');
        $this->db->where('textual_pages_tanslations.abbr', MY_LANGUAGE_ABBR);
        $this->db->where('active_pages.name', $page);
        $result = $this->db->select('textual_pages_tanslations.description as content, textual_pages_tanslations.name')->get('active_pages');
        return $result->row_array();
    }

    public function changePaypalOrderStatus($order_id, $status)
    {
        $processed = 0;
        if ($status == 'canceled') {
            $processed = 2;
        }
        $this->db->where('order_id', $order_id);
        if (!$this->db->update('orders', array(
                    'paypal_status' => $status,
                    'processed' => $processed
                ))) {
            log_message('error', print_r($this->db->error(), true));
        }
    }

    public function getCookieLaw()
    {
        $this->db->join('cookie_law_translations', 'cookie_law_translations.for_id = cookie_law.id', 'inner');
        $this->db->where('cookie_law_translations.abbr', MY_LANGUAGE_ABBR);
        $this->db->where('cookie_law.visibility', '1');
        $query = $this->db->select('link, theme, message, button_text, learn_more')->get('cookie_law');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function confirmOrder($md5)
    {
        $this->db->limit(1);
        $this->db->where('link', $md5);
        $result = $this->db->get('confirm_links');
        $row = $result->row_array();
        if (!empty($row)) {
            $orderId = $row['for_order'];
            $this->db->limit(1);
            $this->db->where('order_id', $orderId);
            $result = $this->db->update('orders', array('confirmed' => '1'));
            return $result;
        }
        return false;
    }

    public function getValidDiscountCode($code)
    {
        $time = time();
        $this->db->select('type, amount');
        $this->db->where('code', $code);
        $this->db->where($time . ' BETWEEN valid_from_date AND valid_to_date');
        $query = $this->db->get('discount_codes');
        return $query->row_array();
    }

    public function countPublicUsersWithEmail($email, $id = 0)
    {
        if ($id > 0) {
            $this->db->where('id !=', $id);
        }
        $this->db->where('email', $email);
        return $this->db->count_all_results('users_public');
    }

    public function registerUser($post)
    {  //echo '<pre>'; print_r($post); die;
        $this->db->insert('users_public', array(
            'name' => $post['name'],
            'phone' => $post['phone'],
            'email' => $post['email'],
            'address' => $post['address'],
            'pan' => $post['pan'],
            'gst' => $post['gst'],
            'type' => 'NA',
            //'type' => $post['user_type'],
            'agents' => $post['type'],
            'status' => '2',
            'password' => md5($post['pass'])
        ));
        return $this->db->insert_id();
    }

    public function updateProfile($post)
    {
        $array = array(
            'name' => $post['name'],
            'phone' => $post['phone'],
            'email' => $post['email']
        );
        if (trim($post['pass']) != '') {
            $array['password'] = md5($post['pass']);
        }
        $this->db->where('id', $post['id']);
        $this->db->update('users_public', $array);
    }

    public function checkPublicUserIsValid($post)
    {
        $this->db->where('email', $post['email']);
        $this->db->where('password', md5($post['pass']));
        $this->db->where('status', '1');
        $query = $this->db->get('users_public');
        $result = $query->row_array();
        if (empty($result)) {
            return false;
        } else {
            return $result;
        }
    }

    public function checkUserPendingApproval($post)
    {
        $this->db->where('email', $post['email']);
        $this->db->where('password', md5($post['pass']));
        $this->db->where('status', '2');
        $query = $this->db->get('users_public');
        return !empty($query->row_array());
    }

    public function getUserProfileInfo($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('users_public');
        return $query->row_array();
    }

    public function sitemap()
    {
        $query = $this->db->select('url')->get('products');
        return $query;
    }

    public function sitemapBlog()
    {
        $query = $this->db->select('url')->get('blog_posts');
        return $query;
    }

    public function getVariationsForProducts($product_ids)
    {
        if (empty($product_ids) || !$this->db->table_exists('product_variations')) {
            return [];
        }
        if (!$this->db->field_exists('swatch', 'product_variations')) {
            $this->db->query("ALTER TABLE `product_variations` ADD COLUMN `swatch` varchar(200) DEFAULT NULL");
        }
        if (!$this->db->field_exists('hex', 'product_variations')) {
            $this->db->query("ALTER TABLE `product_variations` ADD COLUMN `hex` varchar(20) DEFAULT NULL");
        }
        $this->db->where_in('product_id', $product_ids);
        $rows = $this->db->get('product_variations')->result_array();
        $result = [];
        foreach ($rows as $row) {
            $result[$row['product_id']][] = $row;
        }
        return $result;
    }

    public function getUserOrdersHistoryCount($userId)
    {
        $this->db->where('user_id', $userId);
        return $this->db->count_all_results('orders');
    }

    public function getUserOrdersHistory($userId, $limit, $page)
    {
        $this->db->where('user_id', $userId);
        $this->db->order_by('id', 'DESC');
        $this->db->select('orders.*, orders_clients.first_name,'
                . ' orders_clients.last_name, orders_clients.email, orders_clients.phone, '
                . 'orders_clients.address, orders_clients.city, orders_clients.post_code,'
                . ' orders_clients.notes, discount_codes.type as discount_type, discount_codes.amount as discount_amount');
        $this->db->join('orders_clients', 'orders_clients.for_id = orders.id', 'inner');
        $this->db->join('discount_codes', 'discount_codes.code = orders.discount_code', 'left');
        $result = $this->db->get('orders', $limit, $page);
        $result = $result->result_array();
        if(!count($result)) return $result;
        
        foreach($result as $k => $v) {
            $result[$k] = array_map(function($v) {
                $d = $this->encryption->decrypt($v);
                return $d !== false ? $d : $v;
            }, $v);
        }

        return $result;
    }

}
