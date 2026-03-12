<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller
{

    private $num_rows = 20;

    public function __construct()
    {
        parent::__construct();
         
        $this->load->Model('admin/Brands_model');
        $this->load->Model('Wishlist_model');
        $this->load->helper('developer_helper');
    }
    
   
    public function deletFromCart($article_id, $session_id) {
        $this->db->delete('cart_items', [
            'session_id' => user_id(),
            'id' => $article_id
        ]); //echo $this->db->last_query(); die;
        redirect('shopping-cart');
    }
    public function prebooking(){
                $arrSeo = $this->Public_model->getSeo('home');
        $head['title'] = @$arrSeo['title'];
        $head['description'] = @$arrSeo['description'];
        $head['keywords'] = str_replace(" ", ",", $head['title']);

        $data['products'] = $this->Public_model->getProducts($this->num_rows, $page, $_GET);
        $rowscount = $this->Public_model->productsCount($_GET);
        $data['shippingOrder'] = $this->Home_admin_model->getValueStore('shippingOrder');
        $data['showOutOfStock'] = $this->Home_admin_model->getValueStore('outOfStock');
        $data['showBrands'] = $this->Home_admin_model->getValueStore('showBrands');
        $data['brands'] = $this->Brands_model->getBrands();
        $data['links_pagination'] = pagination('home', $rowscount, $this->num_rows);
        $this->render('prebooking', $head, $data);

    }
    
    public function get_image_diff_clr(){
        // In Controller Constructor OR autoload
$this->load->helper('url');
    $html ='';
$post = $this->input->post(); 
$this->db->select('p.*, pt.title, pt.*');
$this->db->from('products p');
$this->db->join('products_translations pt', 'p.id = pt.for_id');
$this->db->where('title',$post['title']);
$query = $this->db->get();
$results = $query->result(); //echo $this->db->last_query(); die;
 foreach ($results as $row){// echo $row->image; 
 
     $html .='<div class="color-thumb selected"><img src="'.base_url('attachments/shop_images').'/'.$row->image.'" width="60" height="80" class="gallery-thumb active"></div>';
 }
    echo $html; die;
    }
    public function minus_qty(){
        if (!is_logged_in()) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'login_required' => true]);
            exit();
        }
        $product_id = (int)$_POST['product_id'];
        $set_quanity = (int)get_product_quantity($product_id);
        if ($set_quanity <= 0) $set_quanity = 1;
        $row = $this->db->get_where('cart_items', ['product_id' => $product_id, 'session_id' => user_id()])->row();
        if (!$row) { echo json_encode(['success' => true]); exit(); }
        $new_qty = (int)$row->quantity - $set_quanity;
        if ($new_qty <= 0) {
            $this->db->delete('cart_items', ['product_id' => $product_id, 'session_id' => user_id()]);
        } else {
            $new_sets = (int)$row->set_quantity - 1;
            $this->db->where(['product_id' => $product_id, 'session_id' => user_id()])
                     ->update('cart_items', ['quantity' => $new_qty, 'set_quantity' => max(0, $new_sets)]);
        }
        echo json_encode(['success' => true]);


    }
    public function barcode_scan() {
                $data = array();
        $head = array();
        // Show ALL errors
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        ini_set('log_errors', 1);
        $this->render('barcode_scanner', $head, $data);
   // $this->load->view('templates/redlabel/barcode_scanner');
}

public function scan_result() {
    $code = $this->input->post('barcode');
     //echo json_encode(['success' => true, 'product' => $code]); die;
    // Validate & process scanned code
    if ($code) {  // Your array
        $data = $this->db->get_where('products_translations', ['bar_code' => $code])->row_array();
                 $count = get_product_quantity($data['id']);
            $count = ($count=='') ? '4' : $count;
            for ($i = 0; $i < $count; $i++) {
                // code to run each time
            @$_SESSION['shopping_cart'][] = (int) $data['id'];
            }
        

        //print_r($data); echo $data['id']; die;
        echo json_encode(['success' => true, 'product' => $data['id']]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid barcode']);
    }
}
    public function update_product() {
        $barcode = $this->input->post('barcode');
        $sql = $this->db->query('SELECT * FROM `products_translations` where bar_code = '.$barcode.' ')->row();
        $data = array('fabric' => $brand);
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('products_translations', $data);
        
        echo json_encode(array('status' => 'success', 'message' => 'Brand shifted to fabric'));
    }


    public function index($page = 0)
    {   
        
        $data = array();
        $head = array();
        $arrSeo = $this->Public_model->getSeo('home');
        $head['title'] = @$arrSeo['title'];
        $head['description'] = @$arrSeo['description'];
        $head['keywords'] = str_replace(" ", ",", $head['title']);
        $all_categories = $this->Public_model->getShopCategories();
        $data['home_categories'] = $this->getHomeCategories($all_categories);
        $data['all_categories'] = $all_categories;
        $data['countQuantities'] = $this->Public_model->getCountQuantities();
        $data['bestSellers'] = $this->Public_model->getbestSellers();
        $data['newProducts'] = $this->Public_model->getNewProducts();
        $data['sliderProducts'] = $this->Public_model->getSliderProducts();
        $data['lastBlogs'] = $this->Public_model->getLastBlogs();
        $data['products'] = $this->Public_model->getProducts($this->num_rows, $page, $_GET);
        $rowscount = $this->Public_model->productsCount($_GET);
        $data['shippingOrder'] = $this->Home_admin_model->getValueStore('shippingOrder');
        $data['showOutOfStock'] = $this->Home_admin_model->getValueStore('outOfStock');
        $data['showBrands'] = $this->Home_admin_model->getValueStore('showBrands');
        $data['brands'] = $this->Brands_model->getBrands();
        $data['links_pagination'] = pagination('home', $rowscount, $this->num_rows);
        $this->render('home', $head, $data);
    }

  
    
    public function aboutus(){
        $data = array();
        $head = array();
        $arrSeo = $this->Public_model->getSeo('home');
        $head['title'] = @$arrSeo['title'];
        $this->render('about', $head, $data);
    }
    
    public function faq(){
        $data = array();
        $head = array();
        $arrSeo = $this->Public_model->getSeo('home');
        $head['title'] = @$arrSeo['title'];
        $this->render('faq', $head, $data);
    }  
    
    public function contact(){
        $data = array();
        $head = array();
        $arrSeo = $this->Public_model->getSeo('home');
        $head['title'] = @$arrSeo['title'];
        $this->render('contact', $head, $data);
    }
    
    public function shop($page = 0)
    {   
        $data = array();
        $head = array();
        $arrSeo = $this->Public_model->getSeo('shop');
        $head['title'] = @$arrSeo['title'];
        $head['description'] = @$arrSeo['description'];
        $head['keywords'] = str_replace(" ", ",", $head['title']);
        $all_categories = $this->Public_model->getShopCategories(); // print_r($all_categories); die;
        $data['home_categories'] = $this->getHomeCategories($all_categories);
        $data['countQuantities'] = $this->Public_model->getCountQuantities();
        $data['all_categories'] = $all_categories;
        $data['showBrands'] = $this->Home_admin_model->getValueStore('showBrands');
        $data['brands'] = $this->Brands_model->getBrands();
        $data['showOutOfStock'] = $this->Home_admin_model->getValueStore('outOfStock');
        $data['shippingOrder'] = $this->Home_admin_model->getValueStore('shippingOrder');
        $data['filter_seasons'] = $this->Public_model->getDistinctFilterValues('season');
        $data['filter_genders'] = $this->Public_model->getDistinctFilterValues('gender');
        $data['filter_sizes']   = $this->Public_model->getDistinctFilterValues('size_range');
        $data['products'] = $this->Public_model->getProducts($this->num_rows, $page, $_GET);
          //echo '<pre>'; print_r( $data['products']);
        $product_ids = array_column($data['products'], 'id');
        $data['variations'] = $this->Public_model->getVariationsForProducts($product_ids);
        $rowscount = $this->Public_model->productsCount($_GET);
        $data['links_pagination'] = pagination('home/shop', $rowscount, $this->num_rows);
        // Wishlist product IDs for the current user (to pre-mark hearts)
        $uid = user_id();
        if ($uid) {
            $wl_rows = $this->db->select('product_id')->where('user_id', $uid)->get('wishlists')->result_array();
            $data['wishlist_ids'] = array_column($wl_rows, 'product_id');
        } else {
            $data['wishlist_ids'] = [];
        }
        $this->render('shop', $head, $data);
    }
    public function new_arrivals($page = 0){
       
        $data = array();
        $head = array();
        $arrSeo = $this->Public_model->getSeo('shop');
        $head['title'] = @$arrSeo['title'];
        $head['description'] = @$arrSeo['description'];
        $head['keywords'] = str_replace(" ", ",", $head['title']);
        $all_categories = $this->Public_model->getShopCategories();
        $data['home_categories'] = $this->getHomeCategories($all_categories);
        $data['countQuantities'] = $this->Public_model->getCountQuantities();
        $data['all_categories'] = $all_categories;
        $data['showBrands'] = $this->Home_admin_model->getValueStore('showBrands');
        $data['brands'] = $this->Brands_model->getBrands();
        $data['showOutOfStock'] = $this->Home_admin_model->getValueStore('outOfStock');
        $data['shippingOrder'] = $this->Home_admin_model->getValueStore('shippingOrder');
        $data['products'] = $this->Public_model->getProducts($this->num_rows, $page, $_GET);       
        $rowscount = $this->Public_model->productsCount($_GET);
        $data['links_pagination'] = pagination('home', $rowscount, $this->num_rows);
        $this->render('new_arrivals', $head, $data);
        
    } 
    
    public function offer($page = 0){
       
        $data = array();
        $head = array();
        $arrSeo = $this->Public_model->getSeo('shop');
        $head['title'] = @$arrSeo['title'];
        $head['description'] = @$arrSeo['description'];
        $head['keywords'] = str_replace(" ", ",", $head['title']);
        $all_categories = $this->Public_model->getShopCategories();
        $data['home_categories'] = $this->getHomeCategories($all_categories);
        $data['countQuantities'] = $this->Public_model->getCountQuantities();
        $data['all_categories'] = $all_categories;
        $data['showBrands'] = $this->Home_admin_model->getValueStore('showBrands');
        $data['brands'] = $this->Brands_model->getBrands();
        $data['showOutOfStock'] = $this->Home_admin_model->getValueStore('outOfStock');
        $data['shippingOrder'] = $this->Home_admin_model->getValueStore('shippingOrder');
        $data['products'] = $this->Public_model->getProducts($this->num_rows, $page, $_GET);       
        $rowscount = $this->Public_model->productsCount($_GET);
        $data['links_pagination'] = pagination('home', $rowscount, $this->num_rows);
        $this->render('offer', $head, $data);
        
    }
    
    
    private function getHomeCategories($categories)
    {

        /*
         * Tree Builder for categories menu
         */

        function buildTree(array $elements, $parentId = 0)
        {
            $branch = array();
            foreach ($elements as $element) {
                if ($element['sub_for'] == $parentId) {
                    $children = buildTree($elements, $element['id']);
                    if ($children) {
                        $element['children'] = $children;
                    }
                    $branch[] = $element;
                }
            }
            return $branch;
        }

        return buildTree($categories);
    }

    /*
     * Called to add/remove quantity from cart
     * If is ajax request send POST'S to class ShoppingCart
     */

    public function manageShoppingCart()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        if (!is_logged_in()) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'login_required' => true]);
            exit();
        }
        $this->shoppingcart->manageShoppingCart();
    }

    /*
     * Called to remove product from cart
     * If is ajax request and send $_GET variable to the class
     */

    public function removeFromCart()
    {
        $backTo = $_GET['back-to'];
        $this->shoppingcart->removeFromCart();
        $this->session->set_flashdata('deleted', lang('deleted_product_from_cart'));
        redirect(LANG_URL . '/' . $backTo);
    }

    public function clearShoppingCart()
    {
        $this->shoppingcart->clearShoppingCart();
    }

    public function viewProduct($id)
    {
        $data = array();
        $head = array();
        $data['product'] = $this->Public_model->getOneProduct($id);
        if (empty($data['product'])) {
            show_404();
        }
        $data['sameCagegoryProducts'] = $this->Public_model->sameCagegoryProducts($data['product']['shop_categorie'], $id);
        // Load variations
        $variations_map = $this->Public_model->getVariationsForProducts([$id]);
        $data['variations'] = isset($variations_map[$id]) ? $variations_map[$id] : [];
        // Wishlist
        $uid = (int)user_id();
        $data['is_wishlisted'] = false;
        if ($uid) {
            $data['is_wishlisted'] = $this->db->where('user_id', $uid)->where('product_id', $id)->count_all_results('wishlists') > 0;
        }
        $head['title'] = $data['product']['title'];
        $description = url_title(character_limiter(strip_tags($data['product']['description']), 130));
        $description = str_replace("-", " ", $description) . '..';
        $head['description'] = $description;
        $head['keywords'] = str_replace(" ", ",", $data['product']['title']);
        $head['image'] = null;
        if (isset($data['product']['image'])) {
            $head['image'] = base_url('/attachments/shop_images/' . $data['product']['image']);
        }
        $this->render('view_product', $head, $data);
    }
    
    public function ajax_cart_filter() {
        header('Content-Type: application/json');
        $post = $this->input->post();

        // Tiered pricing: get logged-in user's discount percent
        $uid = user_id();
        $user_percent = 0;
        $ajax_wishlist_ids = [];
        if ($uid) {
            $user_row = $this->db->select('percent')->where('id', $uid)->get('users_public')->row();
            if ($user_row && !empty($user_row->percent)) {
                $user_percent = (float)$user_row->percent;
            }
            $wl_rows = $this->db->select('product_id')->where('user_id', $uid)->get('wishlists')->result_array();
            $ajax_wishlist_ids = array_column($wl_rows, 'product_id');
        }

        // Collect filter params from POST
        $filters = [
            'category'        => (string)($post['category'] ?? ''),
            'season'          => (string)($post['season'] ?? ''),
            'gender'          => (string)($post['gender'] ?? ''),
            'search_in_title' => (string)($post['search_in_title'] ?? ''),
            'search_in_brand' => (string)($post['search_in_brand'] ?? ''),
            'search_in_desc'  => (string)($post['search_in_desc'] ?? ''),
            'search_in_color' => (string)($post['search_in_color'] ?? ''),
            'search_in_size'  => (string)($post['search_in_size'] ?? ''),
            'order_new'       => (string)($post['order_new'] ?? ''),
            'order_price'     => (string)($post['order_price'] ?? ''),
            'price_from'      => (string)($post['price_from'] ?? ''),
            'price_to'        => (string)($post['price_to'] ?? ''),
            'brand_id'        => (string)($post['brand_id'] ?? ''),
            'in_stock'        => (string)($post['in_stock'] ?? ''),
        ];

        $products = $this->Public_model->getProducts($this->num_rows, 0, $filters);
        $count    = $this->Public_model->productsCount($filters);

        // Load variations
        $product_ids = array_column($products, 'id');
        $variations  = $this->Public_model->getVariationsForProducts($product_ids);

        $folderPath = $_SERVER['DOCUMENT_ROOT'] . '/attachments/shop_images/';
        $html = '';

        foreach ($products as $val) {
            $prod_url   = base_url($val['url'] . '_' . $val['id']);
            $imagePath  = $folderPath . trim($val['image']);
            $img_src    = base_url('attachments/shop_images/' . $val['image']);
            $fallback   = base_url('attachments/shop_images/spark_logo-06.jpg');
            $title_safe = htmlspecialchars($val['title'], ENT_QUOTES, 'UTF-8');
            $brand_safe = htmlspecialchars($val['brand'] ?? '', ENT_QUOTES, 'UTF-8');
            $desc_safe  = htmlspecialchars(mb_strimwidth(strip_tags($val['description'] ?? ''), 0, 60, '...'), ENT_QUOTES, 'UTF-8');

            // Apply tiered pricing
            $wsp = (float)($val['wsp'] ?? 0);
            $msp = (float)($val['msp'] ?? 0);
            if ($user_percent > 0) {
                $wsp = round($wsp * (1 - $user_percent / 100), 2);
            }

            // Heart icon
            $heart_class = in_array($val['id'], $ajax_wishlist_ids) ? 'bi bi-heart-fill text-danger' : 'bi bi-heart';

            // Image block
            if (is_file($imagePath)) {
                $img_html = '<div class="product-img-wrapper">'
                    . '<img alt="' . $title_safe . '" src="' . $img_src . '" style="object-fit:scale-down;" class="w-100 img_products" onload="this.parentElement.classList.remove(\'skeleton\')">'
                    . '<span class="brand-badge-animated">' . $brand_safe . '</span>'
                    . '</div>';
            } else {
                $img_html = '<img alt="' . $title_safe . '" src="' . $img_src . '" onerror="this.onerror=null;this.src=\'' . $fallback . '\';" style="object-fit:scale-down!important;" class="w-100 img_products">';
            }

            // Variation chips
            $color_chips = '';
            $size_chips  = '';
            if (!empty($variations[$val['id']])) {
                foreach ($variations[$val['id']] as $v) {
                    if (trim($v['color'])) {
                        $color_chips .= '<span class="var-tag-color">' . htmlspecialchars(trim($v['color']), ENT_QUOTES, 'UTF-8') . '</span>';
                    }
                }
                $uniq_sizes = [];
                foreach ($variations[$val['id']] as $v) {
                    foreach (array_map('trim', explode(',', $v['sizes'])) as $s) {
                        if ($s !== '') $uniq_sizes[$s] = $s;
                    }
                }
                foreach ($uniq_sizes as $s) {
                    $size_chips .= '<span class="var-tag-size">' . htmlspecialchars($s, ENT_QUOTES, 'UTF-8') . '</span>';
                }
            } else {
                $color_chips = '<span class="text-muted">' . htmlspecialchars($val['color'] ?? '', ENT_QUOTES, 'UTF-8') . '</span>';
                $size_chips  = '<span class="text-muted">' . htmlspecialchars($val['size_range'] ?? '', ENT_QUOTES, 'UTF-8') . '</span>';
            }

            $html .= '<div class="col-lg-3 col-md-4 col-6">'
                . '<div class="tb-product-item-inner">'
                . '<div class="card product-card border-0">'
                . '<a href="' . $prod_url . '">' . $img_html . '</a>'
                . '</div>'
                . '<div><a href="javascript:void(0);"><i data-product-id="' . (int)$val['id'] . '" class="' . $heart_class . ' wishlist-btn"></i></a></div>'
                . '<ul class="list-unstyled tb-content">'
                . '<li><a href="' . $prod_url . '">' . $title_safe . '</a></li>'
                . '<li><a href="' . $prod_url . '" class="text-muted small">' . $desc_safe . '</a></li>'
                . '<li class="small var-chips">' . $color_chips . '</li>'
                . '<li class="var-chips">' . $size_chips . '</li>'
                . '<li><ol class="price-list"><li>WSP ' . number_format($wsp, 0) . ' /-</li><li>MRP ' . number_format($msp, 0) . ' /-</li></ol></li>'
                . '<li><a href="javascript:void(0);" data-price="' . $wsp . '" data-mrp="' . $msp . '" class="btn btn-dark w-100 rounded-pill mt-2 add-to-cart_new" data-action="add" data-id="' . (int)$val['id'] . '">Add To Cart</a></li>'
                . '</ul>'
                . '</div>'
                . '</div>';
        }

        echo json_encode(['html' => $html, 'count' => (int)$count]);
        exit;
    }

    public function confirmLink($md5)
    {
        if (preg_match('/^[a-f0-9]{32}$/', $md5)) {
            $result = $this->Public_model->confirmOrder($md5);
            if ($result === true) {
                $data = array();
                $head = array();
                $head['title'] = '';
                $head['description'] = '';
                $head['keywords'] = '';
                $this->render('confirmed', $head, $data);
            } else {
                show_404();
            }
        } else {
            show_404();
        }
    }

    public function discountCodeChecker()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        $result = $this->Public_model->getValidDiscountCode($_POST['enteredCode']);
        if ($result == null) {
            echo 0;
        } else {
            echo json_encode($result);
        }
    }

    public function sitemap()
    {
        header("Content-Type:text/xml");
        echo '<?xml version="1.0" encoding="UTF-8"?>
                <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        $products = $this->Public_model->sitemap();
        $blogPosts = $this->Public_model->sitemapBlog();

        foreach ($blogPosts->result() as $row1) {
            echo '<url>

      <loc>' . base_url('blog/' . $row1->url) . '</loc>

      <changefreq>monthly</changefreq>

      <priority>0.1</priority>

   </url>';
        }

        echo '<url>

        <loc>' . base_url('/kirilkirkov-ecommerce-ci-b3-hcheck') . '</loc>

        <changefreq>monthly</changefreq>

        <priority>0.1</priority>

        </url>';

        foreach ($products->result() as $row) {
            echo '<url>

      <loc>' . base_url($row->url) . '</loc>

      <changefreq>monthly</changefreq>

      <priority>0.1</priority>

   </url>';
        }

        echo '</urlset>';
    }
    
    public function account()
    {
        $this->load->model(array('Orders_model'));
        $data = array();
        $head = array();
        $data['clients'] = $this->db->query('SELECT * FROM `users_public` WHERE FIND_IN_SET(?, agents)', [(string)user_id()])->result();
        $head['title'] = 'Administration - Orders';
        $head['description'] = '!';
        $head['keywords'] = '';

        $order_by = null;
        if (isset($_GET['order_by'])) {
            $order_by = $_GET['order_by'];
        }
        $data['orders'] = $this->Orders_model->orders($this->num_rows, $page=null, $order_by);

        // Current user's own orders (My Orders tab)
        $uid = (int)user_id();
        $this->db->select('orders.id, orders.order_id, orders.date, orders.processed, orders.products, orders.payment_type');
        $this->db->where('orders.user_id', $uid);
        $this->db->order_by('orders.id', 'DESC');
        $my_orders_raw = $this->db->get('orders')->result_array();
        $my_stats = ['total' => count($my_orders_raw), 'pending' => 0, 'shipped' => 0, 'delivered' => 0];
        foreach ($my_orders_raw as $mo) {
            if ($mo['processed'] == 0)     $my_stats['pending']++;
            elseif ($mo['processed'] == 1) $my_stats['shipped']++;
            elseif ($mo['processed'] == 2) $my_stats['delivered']++;
        }
        $data['my_orders'] = $my_orders_raw;
        $data['my_stats']  = $my_stats;

        // Current user's type for role-based tab visibility
        $user_row = $this->db->select('type')->where('id', $uid)->get('users_public')->row();
        $type_map = [1 => 'agent', 2 => 'distributor', 3 => 'wholesaler', 4 => 'retailer'];
        $data['user_role'] = isset($user_row->type) ? ($type_map[$user_row->type] ?? 'retailer') : 'retailer';

        $data['product'] = $this-> Wishlist_model->get_wishlist();
        $data['user_addresses'] = $this->_get_user_addresses();

        // Retailer orders: orders placed by retailers managed by this agent/distributor
        $client_ids = array_map(function($c) { return (int)$c->id; }, $data['clients']);
        $retailer_orders = [];
        $retailer_stats  = ['total' => 0, 'pending' => 0, 'shipped' => 0, 'delivered' => 0];
        if (!empty($client_ids)) {
            $this->db->select('orders.id, orders.order_id, orders.date, orders.processed, orders.products, orders.payment_type, users_public.name as retailer_name');
            $this->db->join('users_public', 'users_public.id = orders.user_id', 'left');
            $this->db->where_in('orders.user_id', $client_ids);
            $this->db->order_by('orders.id', 'DESC');
            $retailer_orders = $this->db->get('orders')->result_array();
            $retailer_stats['total'] = count($retailer_orders);
            foreach ($retailer_orders as $ro) {
                if ($ro['processed'] == 0)      $retailer_stats['pending']++;
                elseif ($ro['processed'] == 1)  $retailer_stats['shipped']++;
                elseif ($ro['processed'] == 2)  $retailer_stats['delivered']++;
            }
        }
        $data['retailer_orders'] = $retailer_orders;
        $data['retailer_stats']  = $retailer_stats;

        $this->load->view('templates/redlabel/_parts/header');
        $this->load->view('templates/redlabel/account',$data);
        $this->load->view('templates/redlabel/_parts/footer');
    }

    // ── user_addresses helpers ──────────────────────────────────

    private function _ensure_user_addresses_table()
    {
        if (!$this->db->table_exists('user_addresses')) {
            $this->db->query('CREATE TABLE IF NOT EXISTS `user_addresses` (
                `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `user_id`    INT UNSIGNED NOT NULL,
                `label`      VARCHAR(100) NOT NULL DEFAULT \'\',
                `company`    VARCHAR(200) NOT NULL DEFAULT \'\',
                `gst`        VARCHAR(50)  NOT NULL DEFAULT \'\',
                `name`       VARCHAR(200) NOT NULL DEFAULT \'\',
                `phone`      VARCHAR(30)  NOT NULL DEFAULT \'\',
                `address`    TEXT         NOT NULL,
                `is_default` TINYINT(1)   NOT NULL DEFAULT 0,
                `created_at` INT UNSIGNED NOT NULL DEFAULT 0,
                INDEX (`user_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');
        }
    }

    private function _get_user_addresses()
    {
        $uid = user_id();
        if (!$uid) return [];
        $this->_ensure_user_addresses_table();
        return $this->db->where('user_id', $uid)->order_by('is_default DESC, id ASC')->get('user_addresses')->result();
    }

    public function save_user_address()
    {
        header('Content-Type: application/json');
        if (!is_logged_in()) { echo json_encode(['success' => false]); exit(); }
        $uid = user_id();
        $this->_ensure_user_addresses_table();

        $id      = (int)$this->input->post('id');
        $label   = trim($this->input->post('label')   ?? '');
        $company = trim($this->input->post('company') ?? '');
        $gst     = trim($this->input->post('gst')     ?? '');
        $name    = trim($this->input->post('name')    ?? '');
        $phone   = trim($this->input->post('phone')   ?? '');
        $address = trim($this->input->post('address') ?? '');
        $isDefault = (int)(bool)$this->input->post('is_default');

        if ($isDefault) {
            $this->db->where('user_id', $uid)->update('user_addresses', ['is_default' => 0]);
        }

        $row = [
            'label'      => $label,
            'company'    => $company,
            'gst'        => $gst,
            'name'       => $name,
            'phone'      => $phone,
            'address'    => $address,
            'is_default' => $isDefault,
        ];

        if ($id > 0) {
            // Only update own record
            $this->db->where(['id' => $id, 'user_id' => $uid])->update('user_addresses', $row);
            $savedId = $id;
        } else {
            // Check if this is the first address — make it default automatically
            $count = $this->db->where('user_id', $uid)->count_all_results('user_addresses');
            if ($count === 0) $row['is_default'] = 1;
            $row['user_id']    = $uid;
            $row['created_at'] = time();
            $this->db->insert('user_addresses', $row);
            $savedId = $this->db->insert_id();
        }

        echo json_encode(['success' => true, 'id' => $savedId]);
        exit();
    }

    public function delete_user_address()
    {
        header('Content-Type: application/json');
        if (!is_logged_in()) { echo json_encode(['success' => false]); exit(); }
        $uid = user_id();
        $this->_ensure_user_addresses_table();
        $id = (int)$this->input->post('id');
        if ($id < 1) { echo json_encode(['success' => false]); exit(); }

        // Fetch before deleting to know if it was default
        $addr = $this->db->where(['id' => $id, 'user_id' => $uid])->get('user_addresses')->row();
        if (!$addr) { echo json_encode(['success' => false]); exit(); }

        $this->db->where(['id' => $id, 'user_id' => $uid])->delete('user_addresses');

        // If deleted address was default, promote the oldest remaining address
        if ($addr->is_default) {
            $next = $this->db->where('user_id', $uid)->order_by('id ASC')->limit(1)->get('user_addresses')->row();
            if ($next) {
                $this->db->where('id', $next->id)->update('user_addresses', ['is_default' => 1]);
            }
        }

        echo json_encode(['success' => true]);
        exit();
    }

    public function set_default_address()
    {
        header('Content-Type: application/json');
        if (!is_logged_in()) { echo json_encode(['success' => false]); exit(); }
        $uid = user_id();
        $this->_ensure_user_addresses_table();
        $id = (int)$this->input->post('id');
        if ($id < 1) { echo json_encode(['success' => false]); exit(); }

        $this->db->where('user_id', $uid)->update('user_addresses', ['is_default' => 0]);
        $this->db->where(['id' => $id, 'user_id' => $uid])->update('user_addresses', ['is_default' => 1]);

        echo json_encode(['success' => true]);
        exit();
    }
    
    public function wishlist()
    {   
        $data['product'] = $this-> Wishlist_model->get_wishlist();
        $this->load->view('templates/redlabel/_parts/header');
        $this->load->view('templates/redlabel/wishlist',$data);
        $this->load->view('templates/redlabel/_parts/footer');
    }
    
    public function platform()
    {
        $this->load->view('main/platform/index');
    }

    public function get_cart_html()
    {
        ob_start();
        $items = cart_item();
        $total = 0;
        foreach ($items as $item) {
            $total += (float)($item['wsp'] ?? 0) * (int)($item['quantity'] ?? 0);
        }
        $count = count($items);
        $fallback = base_url('attachments/shop_images/spark_logo-06.jpg');

        $html = '';
        if (empty($items)) {
            $html = '<div class="text-center py-5 text-muted"><i class="bi bi-bag fs-1"></i><p class="mt-3">Your cart is empty.</p></div>';
        } else {
            foreach ($items as $item) {
                $img     = base_url('attachments/shop_images/' . ($item['image'] ?? ''));
                $brand   = htmlspecialchars($item['brand'] ?? '', ENT_QUOTES);
                $title   = htmlspecialchars($item['title'] ?? '', ENT_QUOTES);
                $color   = htmlspecialchars($item['color'] ?? '', ENT_QUOTES);
                $size    = htmlspecialchars($item['size_range'] ?? '', ENT_QUOTES);
                $pid     = (int)$item['product_id'];
                $cid     = (int)$item['id'];
                $sets    = (int)$item['set_quantity'];
                $qty     = (int)$item['quantity'];
                $wsp     = (float)$item['wsp'];
                $mrp     = (float)$item['mrp'];
                $line    = number_format($wsp * $qty, 0);
                $uid     = (int)user_id();

                $html .= '<div class="cart-item-row d-flex gap-2 mb-3 pb-3 border-bottom align-items-start">';
                $html .=   '<img src="' . $img . '" onerror="this.src=\'' . $fallback . '\'" width="72" height="88" style="object-fit:cover;flex-shrink:0;">';
                $html .=   '<div class="flex-grow-1 min-w-0">';
                $html .=     '<div class="fw-semibold small">' . $brand . '</div>';
                $html .=     '<div class="small text-truncate">' . $title . '</div>';
                $html .=     '<div class="small text-muted">' . $color . ($size ? ' · ' . $size : '') . '</div>';
                $html .=     '<div class="d-flex align-items-center mt-2 gap-1">';
                $html .=       '<button type="button" class="btn btn-sm btn-outline-dark cart-offcanvas-minus px-2 py-0" data-id="' . $pid . '" style="line-height:1.6;">−</button>';
                $html .=       '<span class="fw-semibold small px-1">' . $sets . ' set' . ($sets > 1 ? 's' : '') . '</span>';
                $html .=       '<button type="button" class="btn btn-sm btn-outline-dark cart-offcanvas-plus px-2 py-0" data-id="' . $pid . '" data-wsp="' . $wsp . '" data-mrp="' . $mrp . '" style="line-height:1.6;">+</button>';
                $html .=       '<span class="ms-auto fw-bold small">₹' . $line . '</span>';
                $html .=     '</div>';
                $html .=   '</div>';
                $html .=   '<button type="button" class="cart-offcanvas-remove btn-close ms-1" style="font-size:.6rem;flex-shrink:0;margin-top:2px;" data-cart-id="' . $cid . '"></button>';
                $html .= '</div>';
            }
        }

        ob_clean();
        header('Content-Type: application/json');
        echo json_encode([
            'html'  => $html,
            'count' => $count,
            'total' => number_format($total, 0),
        ]);
        exit();
    }

    public function save_address()
    {
        if (!is_logged_in()) {
            echo json_encode(['success' => false]);
            exit();
        }
        $fields = ['company', 'gst', 'name', 'phone', 'address'];
        $update = [];
        foreach ($fields as $f) {
            $val = $this->input->post($f);
            if ($val !== null) {
                $update[$f] = $val;
            }
        }
        if (!empty($update)) {
            $this->db->where('id', user_id())->update('users_public', $update);
        }
        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
        exit();
    }

    public function save_settings()
    {
        header('Content-Type: application/json');
        if (!is_logged_in()) {
            echo json_encode(['success' => false, 'msg' => 'Not logged in']);
            exit();
        }
        $update = [];
        $allowed = ['name', 'company', 'gst', 'phone', 'address', 'pan'];
        foreach ($allowed as $f) {
            $val = $this->input->post($f);
            if ($val !== false) {
                $update[$f] = trim($val);
            }
        }
        // Email: only update if it looks valid and differs from current
        $email = trim($this->input->post('email'));
        if ($email && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $update['email'] = $email;
        }
        if (!empty($update)) {
            $ok = $this->db->where('id', user_id())->update('users_public', $update);
            echo json_encode(['success' => (bool)$ok]);
        } else {
            echo json_encode(['success' => true]);
        }
        exit();
    }

    public function ajax_remove_cart()
    {
        if (!is_logged_in()) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'login_required' => true]);
            exit();
        }
        $cart_id = (int)$this->input->post('cart_id');
        $this->db->delete('cart_items', [
            'session_id' => user_id(),
            'id'         => $cart_id,
        ]);
        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
        exit();
    }
}
