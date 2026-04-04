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
        if (!is_logged_in()) { redirect('login'); }
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
        if ($set_quanity <= 0) $set_quanity = 1; // fallback: treat as 1-piece set
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
        $this->render('barcode_scanner', $head, $data);
    }

public function scan_result() {
    $code = trim($this->input->post('barcode'));
    if (!$code) {
        echo json_encode(['success' => false, 'message' => 'No code provided']);
        return;
    }

    // 1. Try product_barcodes table (synced from Trn_ScanCode — most reliable)
    $product = null;
    if ($this->db->table_exists('product_barcodes')) {
        $pb = $this->db->get_where('product_barcodes', ['barcode' => $code])->row_array();
        if (!empty($pb)) {
            $product = $this->db
                ->select('products.id, products_translations.wsp, products_translations.msp')
                ->join('products_translations', 'products_translations.for_id = products.id', 'left')
                ->where('products.id', (int)$pb['product_id'])
                ->where('products.visibility', 1)
                ->get('products')
                ->row_array();
        }
    }

    // 2. Fall back to bar_code in products_translations
    if (empty($product)) {
        $product = $this->db
            ->select('products.id, products_translations.wsp, products_translations.msp')
            ->join('products_translations', 'products_translations.for_id = products.id', 'left')
            ->where('products_translations.bar_code', $code)
            ->where('products.visibility', 1)
            ->get('products')
            ->row_array();
    }

    // 3. Fall back to article_number
    if (empty($product)) {
        $product = $this->db
            ->select('products.id, products_translations.wsp, products_translations.msp')
            ->join('products_translations', 'products_translations.for_id = products.id', 'left')
            ->where('products.article_number', $code)
            ->where('products.visibility', 1)
            ->get('products')
            ->row_array();
    }

    if (empty($product)) {
        echo json_encode(['success' => false, 'message' => 'Product not found']);
        return;
    }

    $product_id = (int)$product['id'];
    $session_id = user_id();

    $set_qty = (int)get_product_quantity($product_id);
    if ($set_qty <= 0) $set_qty = 1;

    $existing = $this->db->get_where('cart_items', [
        'session_id' => $session_id,
        'product_id' => $product_id,
    ])->row_array();

    if ($existing) {
        $this->db->where(['session_id' => $session_id, 'product_id' => $product_id])
                 ->update('cart_items', [
                     'quantity'     => (int)$existing['quantity'] + $set_qty,
                     'set_quantity' => (int)$existing['set_quantity'] + 1,
                 ]);
    } else {
        $this->db->insert('cart_items', [
            'session_id'   => $session_id,
            'product_id'   => $product_id,
            'quantity'     => $set_qty,
            'price'        => 0,
            'mrp'          => $product['msp'] ?? 0,
            'wsp'          => $product['wsp'] ?? 0,
            'set_quantity' => 1,
        ]);
    }

    echo json_encode(['success' => true, 'product' => $product_id]);
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
        if (!is_logged_in()) { redirect('login'); }
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
        $data['filter_genders']          = $this->Public_model->getDistinctFilterValues('gender');
        $data['filter_sizes']            = $this->Public_model->getDistinctFilterValues('size_range');
        $data['filter_fabric_categories'] = $this->Public_model->getDistinctFilterValues('fabric_category');
        $data['filter_brands']           = $this->Public_model->getDistinctFilterValues('brand');
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
        if (!is_logged_in()) { redirect('login'); }
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
        if (!is_logged_in()) { redirect('login'); }
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
        if (!is_logged_in()) { redirect('login'); }
        $data = array();
        $head = array();
        $data['product'] = $this->Public_model->getOneProduct($id);
        if (empty($data['product'])) {
            show_404();
        }
        $data['sameCagegoryProducts'] = $this->Public_model->sameCagegoryProducts($data['product']['shop_categorie'], $id);
        // Load per-size barcodes for synced products
        $data['product_barcodes'] = [];
        if ($this->db->table_exists('product_barcodes')) {
            $data['product_barcodes'] = $this->db
                ->select('size, stock_qty, barcode')
                ->where('product_id', $id)
                ->order_by('size', 'ASC')
                ->get('product_barcodes')->result_array();
        }
        // Load color siblings (other colors of the same item code)
        $data['color_siblings'] = [];
        $parent_id = (int)($data['product']['parent_id'] ?? 0);
        if ($parent_id > 0) {
            $siblings = $this->db
                ->select('products.id, products.url, products.quantity, products_translations.color')
                ->join('products_translations', 'products_translations.for_id = products.id', 'left')
                ->where('products_translations.abbr', MY_DEFAULT_LANGUAGE_ABBR)
                ->where('products.parent_id', $parent_id)
                ->where('products.id !=', $id)
                ->where('products.itm_synced', 1)
                ->get('products')->result_array();
            $data['color_siblings'] = $siblings;
        }
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
        if (!is_logged_in()) { redirect('login'); }
        $data = array();
        $head = array();
        $uid = (int)user_id();
        $data['clients'] = $uid > 0
            ? $this->db->query("SELECT * FROM `users_public` WHERE FIND_IN_SET({$uid}, `agents`)")->result()
            : [];
        $head['title'] = 'My Account';
        $head['description'] = '';
        $head['keywords'] = '';

        // Current user's own orders (My Orders tab)
        $uid = (int)user_id();
        $this->db->select('orders.id, orders.order_id, orders.date, orders.processed, orders.products, orders.payment_type, orders.tracking_courier, orders.tracking_id, orders.billing_amount, orders.paid_amount, orders.payment_status, orders.dispatch_products');
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
        $user_row = $this->db->select('type, agents, percent')->where('id', $uid)->get('users_public')->row();
        $type_map = [1 => 'agent', 2 => 'distributor', 3 => 'wholesaler', 4 => 'retailer'];
        $data['user_role'] = isset($user_row->type) ? ($type_map[$user_row->type] ?? 'retailer') : 'retailer';

        // Retailers connected to a distributor/wholesaler don't see finance tabs (ledger/payments)
        $data['hide_finance_tabs'] = false;
        if ($data['user_role'] === 'retailer' && !empty($user_row->agents)) {
            $parent_ids = array_filter(array_map('intval', explode(',', $user_row->agents)));
            if (!empty($parent_ids)) {
                $parent = $this->db->select('type')->where('id', reset($parent_ids))->get('users_public')->row();
                if ($parent && in_array((int)$parent->type, [2, 3])) {
                    $data['hide_finance_tabs'] = true;
                }
            }
        }

        $data['product'] = $this-> Wishlist_model->get_wishlist();
        $data['user_addresses'] = $this->_get_user_addresses();

        // Retailer orders: orders placed by retailers managed by this agent/distributor
        $client_ids = array_map(function($c) { return (int)$c->id; }, $data['clients']);
        $retailer_orders = [];
        $retailer_stats  = ['total' => 0, 'pending' => 0, 'shipped' => 0, 'delivered' => 0];

        // Get current user's percent for billing recalculation
        $my_percent = (float)($user_row->percent ?? 0);
        $my_type    = (int)($user_row->type ?? 0);

        if (!empty($client_ids)) {
            $this->db->select('orders.id, orders.order_id, orders.date, orders.processed, orders.products, orders.dispatch_products, orders.payment_type, orders.billing_amount, orders.billed_to_user_id, users_public.name as retailer_name, users_public.id as retailer_id');
            $this->db->join('users_public', 'users_public.id = orders.user_id', 'left');
            $this->db->where_in('orders.user_id', $client_ids);
            $this->db->order_by('orders.id', 'DESC');
            $retailer_orders_raw = $this->db->get('orders')->result_array();
            $retailer_stats['total'] = count($retailer_orders_raw);
            foreach ($retailer_orders_raw as &$ro) {
                if ($ro['processed'] == 0)      $retailer_stats['pending']++;
                elseif ($ro['processed'] == 1)  $retailer_stats['shipped']++;
                elseif ($ro['processed'] == 2)  $retailer_stats['delivered']++;

                // Recalculate billing_amount for distributor/wholesaler if it was stored as full price
                if (in_array($my_type, [2, 3]) && $my_percent > 0) {
                    $raw_total = 0;
                    $prods = @unserialize($ro['products']);
                    if (is_array($prods)) {
                        foreach ($prods as $p) {
                            $wsp = (float)($p['product_info']['wsp'] ?? 0);
                            if ($wsp <= 0) $wsp = (float)($p['product_info']['price'] ?? 0);
                            $raw_total += $wsp * (int)($p['product_quantity'] ?? 1);
                        }
                    }
                    if ($raw_total > 0) {
                        $correct = round($raw_total * (1 - $my_percent / 100), 2);
                        // If stored billing_amount differs, update the record
                        if (abs((float)$ro['billing_amount'] - $correct) > 0.01 || (int)$ro['billed_to_user_id'] !== $uid) {
                            $this->db->where('id', (int)$ro['id'])->update('orders', [
                                'billing_amount'    => $correct,
                                'billed_to_user_id' => $uid,
                            ]);
                        }
                        $ro['billing_amount'] = $correct;
                    }
                }
            }
            unset($ro);
            $retailer_orders = $retailer_orders_raw;
        }
        $data['retailer_orders'] = $retailer_orders;
        $data['retailer_stats']  = $retailer_stats;

        // GR requests submitted by this user
        $this->_ensure_gr_table();
        $data['gr_requests'] = $this->db->table_exists('gr_requests')
            ? $this->db->where('submitted_by', $uid)->order_by('id', 'DESC')->get('gr_requests')->result_array()
            : [];
        // Index by order_id for quick lookup in view
        $data['gr_by_order'] = [];
        foreach ($data['gr_requests'] as $gr) {
            $data['gr_by_order'][(int)$gr['order_id']] = $gr;
        }

        // ── Payments tab data ──
        // Bills = user's own orders + orders placed by their clients (retailers)
        $bill_user_ids = array_unique(array_merge([$uid], $client_ids));
        $all_bills = $this->db
            ->select('orders.id, orders.order_id, orders.date, orders.billing_amount, orders.paid_amount, orders.payment_status, orders.processed, orders.products, users_public.name as placed_by')
            ->join('users_public', 'users_public.id = orders.user_id', 'left')
            ->where_in('orders.user_id', $bill_user_ids)
            ->order_by('orders.id', 'DESC')
            ->get('orders')->result_array();

        $pay_stats = ['total_bills' => count($all_bills), 'pending' => 0.0, 'cleared' => 0.0];
        $payment_bills = [];
        foreach ($all_bills as &$b) {
            // Recalculate billing_amount for distributor/wholesaler orders if stored at wrong amount
            if (in_array($my_type, [2, 3]) && $my_percent > 0) {
                $raw_total = 0;
                $prods = @unserialize($b['products']);
                if (is_array($prods)) {
                    foreach ($prods as $p) {
                        $wsp = (float)($p['product_info']['wsp'] ?? 0);
                        if ($wsp <= 0) $wsp = (float)($p['product_info']['price'] ?? 0);
                        $raw_total += $wsp * (int)($p['product_quantity'] ?? 1);
                    }
                }
                if ($raw_total > 0) {
                    $correct = round($raw_total * (1 - $my_percent / 100), 2);
                    if (abs((float)$b['billing_amount'] - $correct) > 0.01) {
                        $this->db->where('id', (int)$b['id'])->update('orders', ['billing_amount' => $correct, 'billed_to_user_id' => $uid]);
                    }
                    $b['billing_amount'] = $correct;
                }
            }
            $amt    = (float)($b['billing_amount'] ?? 0);
            $paid   = (float)($b['paid_amount']    ?? 0);
            $status = (int)($b['payment_status']   ?? 0);
            if ($status === 2) {
                $pay_stats['cleared'] += $amt;
            } else {
                $pay_stats['pending'] += max(0, $amt - $paid);
                $payment_bills[] = $b;
            }
        }
        unset($b);

        // Payment history from payments table (if it exists)
        // Include payments from all clients (their user_id or order belonging to them)
        $payment_history = [];
        $data['pending_receipt_order_ids'] = [];
        if ($this->db->table_exists('payments')) {
            // Build all_ids_str for payment history lookup (uid + client ids)
            $_ph_client_rows = $this->db->query(
                "SELECT id FROM `users_public` WHERE FIND_IN_SET({$uid}, `agents`)"
            )->result_array();
            $_ph_all_ids = array_unique(array_merge([$uid], array_map('intval', array_column($_ph_client_rows, 'id'))));
            $_ph_ids_str = implode(',', $_ph_all_ids);
            // Fetch all payments (pending + verified + rejected) on orders belonging to this user or their clients
            $payment_history = $this->db->query(
                "SELECT p.*, o.order_id as order_ref, up.name as submitted_by
                 FROM payments p
                 JOIN orders o ON o.id = p.order_id
                 LEFT JOIN users_public up ON up.id = p.user_id
                 WHERE o.user_id IN ({$_ph_ids_str})
                 ORDER BY p.id DESC
                 LIMIT 50"
            )->result_array();

            // Build set of order DB IDs that already have a pending receipt (to hide Submit button)
            $data['pending_receipt_order_ids'] = array_column(
                array_filter($payment_history, function($p) { return $p['status'] === 'pending'; }),
                'order_id'
            );
        }

        $data['payment_bills']   = $payment_bills;
        $data['payment_history'] = $payment_history;
        $data['pay_stats']       = $pay_stats;

        // ── Ledger: collect this user + all their clients ──
        $this->load->helper('ledger_helper');
        _ensure_ledger_table($this);

        // Get all client IDs (users whose agents field contains this user's ID)
        $client_rows = $this->db->query(
            "SELECT id FROM `users_public` WHERE FIND_IN_SET({$uid}, `agents`)"
        )->result_array();
        $client_ids  = array_column($client_rows, 'id');
        $all_ids     = array_merge([$uid], array_map('intval', $client_ids)); // [uid, c1, c2, ...]
        $all_ids_str = implode(',', $all_ids);

        // Backfill: orders placed by any of these users that have no ledger debit entry yet.
        // We recalculate billing_amount from serialized products using the current user's margin/percent
        // so that historic orders placed before percent was set are also correctly discounted.
        if ($this->db->table_exists('ledger') && $this->db->field_exists('billing_amount', 'orders')) {
            $unbilled = $this->db->query(
                "SELECT o.id, o.order_id, o.billing_amount, o.date, o.user_id, o.products
                 FROM orders o
                 WHERE o.user_id IN ({$all_ids_str})
                   AND NOT EXISTS (SELECT 1 FROM ledger l WHERE l.order_id = o.id AND l.type = 'debit' AND l.user_id = {$uid})
                 ORDER BY o.date ASC"
            )->result_array();

            $uid_percent = (float)($user_row->percent ?? 0);
            $uid_type    = (int)($user_row->type ?? 0);

            foreach ($unbilled as $ub) {
                // Compute raw total from serialized products (wsp → fallback to price)
                $raw_total = 0;
                $prods = @unserialize($ub['products']);
                if (is_array($prods)) {
                    foreach ($prods as $p) {
                        $wsp = (float)($p['product_info']['wsp'] ?? 0);
                        if ($wsp <= 0) $wsp = (float)($p['product_info']['price'] ?? 0);
                        $raw_total += $wsp * (int)($p['product_quantity'] ?? 1);
                    }
                }
                if ($raw_total <= 0) continue; // can't bill with no price data

                // Apply discount if this user is a distributor or wholesaler
                if (in_array($uid_type, [2, 3]) && $uid_percent > 0) {
                    $billing = round($raw_total * (1 - $uid_percent / 100), 2);
                } else {
                    $billing = round($raw_total, 2);
                }

                // Correct the order record if billing_amount is wrong
                if (abs((float)$ub['billing_amount'] - $billing) > 0.01) {
                    $this->db->where('id', (int)$ub['id'])->update('orders', [
                        'billing_amount'    => $billing,
                        'billed_to_user_id' => $uid,
                    ]);
                }

                add_ledger_entry($uid, 'debit', $billing, 'Order billed — Order #' . $ub['order_id'], (int)$ub['id'], (int)$ub['date']);
            }

            // Fix dates on existing debit entries: use the order's actual date
            $this->db->query(
                "UPDATE `ledger` l
                 JOIN `orders` o ON o.id = l.order_id
                 SET l.date = o.date
                 WHERE l.user_id = {$uid} AND l.type = 'debit' AND l.date != o.date"
            );

            // Backfill credits: verified payments on client orders not yet reflected in this user's ledger
            if ($this->db->table_exists('payments')) {
                $verified_payments = $this->db->query(
                    "SELECT p.id as pay_id, p.order_id, p.amount, p.mode, p.recorded_at, o.order_id as order_no
                     FROM payments p
                     JOIN orders o ON o.id = p.order_id
                     WHERE o.user_id IN ({$all_ids_str})
                       AND p.status = 'verified'
                     ORDER BY p.recorded_at ASC"
                )->result_array();
                foreach ($verified_payments as $vp) {
                    // Check if a credit for this payment amount already exists under uid for this order
                    $exists = $this->db->query(
                        "SELECT id FROM ledger WHERE user_id = {$uid} AND order_id = " . (int)$vp['order_id'] .
                        " AND type = 'credit' AND ABS(amount - " . round((float)$vp['amount'], 2) . ") < 0.01"
                    )->row();
                    if (!$exists) {
                        add_ledger_entry(
                            $uid, 'credit', (float)$vp['amount'],
                            'Payment received — Order #' . $vp['order_no'] . ($vp['mode'] ? ' (' . $vp['mode'] . ')' : ''),
                            (int)$vp['order_id'],
                            (int)$vp['recorded_at']
                        );
                    } else {
                        // Fix date on existing credit entry if it doesn't match payment's recorded_at
                        $this->db->query(
                            "UPDATE `ledger` SET `date` = " . (int)$vp['recorded_at'] .
                            " WHERE id = " . (int)$exists->id . " AND `date` != " . (int)$vp['recorded_at']
                        );
                    }
                }
            }
        }

        // Fetch ledger for this user, enriched with client name via orders
        $data['ledger'] = $this->db->table_exists('ledger')
            ? $this->db->query(
                "SELECT l.*, o.order_id as order_no, up.name as client_name, up.company as client_company
                 FROM ledger l
                 LEFT JOIN orders o ON o.id = l.order_id
                 LEFT JOIN users_public up ON up.id = o.user_id
                 WHERE l.user_id = {$uid}
                 ORDER BY l.id ASC"
              )->result_array()
            : [];

        // ── Commission (agent only) ──
        $data['commission_records'] = [];
        $data['commission_stats']   = ['total' => 0, 'paid' => 0, 'payable' => 0, 'pending' => 0];
        if ($data['user_role'] === 'agent' && $this->db->table_exists('commissions')) {
            $recs = $this->db->where('agent_id', $uid)->order_by('id', 'DESC')->get('commissions')->result_array();
            // Enrich with retailer name
            foreach ($recs as &$rec) {
                $r = $this->db->select('name, company')->where('id', (int)$rec['retailer_id'])->get('users_public')->row();
                $rec['retailer_name'] = $r ? ($r->company ?: $r->name) : 'Unknown';
                $data['commission_stats']['total'] += (float)$rec['commission_amt'];
                if ($rec['status'] === 'paid')         $data['commission_stats']['paid']    += (float)$rec['commission_amt'];
                elseif ($rec['status'] === 'payable')  $data['commission_stats']['payable'] += (float)$rec['commission_amt'];
                else                                   $data['commission_stats']['pending'] += (float)$rec['commission_amt'];
            }
            unset($rec);
            $data['commission_records'] = $recs;
        }

        // ── Claims ──
        $this->_ensure_claims_table();
        $raw_claims = $this->db
            ->where('user_id', $uid)
            ->order_by('id', 'DESC')
            ->get('claims')->result_array();
        // Enrich with order_ref
        foreach ($raw_claims as &$cl) {
            if (!empty($cl['order_id'])) {
                $o = $this->db->select('order_id')->where('id', (int)$cl['order_id'])->get('orders')->row();
                $cl['order_ref'] = $o ? '#' . $o->order_id : '—';
            } else {
                $cl['order_ref'] = '—';
            }
        }
        unset($cl);
        $data['claims'] = $raw_claims;

        $this->load->view('templates/redlabel/_parts/header');
        $this->load->view('templates/redlabel/account',$data);
        $this->load->view('templates/redlabel/_parts/footer');
    }

    // ── Claims helpers ──────────────────────────────────────────

    private function _ensure_claims_table()
    {
        if (!$this->db->table_exists('claims')) {
            $this->db->query('CREATE TABLE IF NOT EXISTS `claims` (
                `id`           INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `claim_no`     VARCHAR(20)  NOT NULL DEFAULT \'\',
                `user_id`      INT UNSIGNED NOT NULL,
                `order_id`     INT UNSIGNED NULL,
                `type`         VARCHAR(50)  NOT NULL DEFAULT \'\',
                `amount`       DECIMAL(10,2) NOT NULL DEFAULT 0,
                `description`  TEXT NULL,
                `status`       ENUM(\'pending\',\'approved\',\'rejected\',\'paid\') NOT NULL DEFAULT \'pending\',
                `admin_remark` TEXT NULL,
                `created_at`   INT UNSIGNED NOT NULL DEFAULT 0,
                `updated_at`   INT UNSIGNED NULL,
                INDEX (`user_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');
        }
    }

    private function _ensure_gr_table()
    {
        if (!$this->db->table_exists('gr_requests')) {
            $this->db->query('CREATE TABLE IF NOT EXISTS `gr_requests` (
                `id`           INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `gr_no`        VARCHAR(25)  NOT NULL DEFAULT \'\',
                `order_id`     INT UNSIGNED NOT NULL,
                `order_no`     VARCHAR(20)  NOT NULL DEFAULT \'\',
                `submitted_by` INT UNSIGNED NOT NULL,
                `retailer_id`  INT UNSIGNED NOT NULL,
                `return_type`  VARCHAR(60)  NOT NULL DEFAULT \'\',
                `items`        TEXT         NOT NULL,
                `remark`       TEXT         NULL,
                `proof_files`  TEXT         NULL,
                `status`       ENUM(\'pending\',\'approved\',\'rejected\',\'processed\') NOT NULL DEFAULT \'pending\',
                `admin_remark` TEXT         NULL,
                `created_at`   INT UNSIGNED NOT NULL DEFAULT 0,
                `updated_at`   INT UNSIGNED NULL,
                INDEX (`submitted_by`),
                INDEX (`order_id`),
                INDEX (`retailer_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');
        }
    }

    /**
     * POST: commission_id
     * Agent requests disbursement of a payable commission.
     */
    public function request_commission()
    {
        header('Content-Type: application/json');
        if (!is_logged_in()) { echo json_encode(['success' => false]); exit(); }
        $uid           = (int)user_id();
        $commission_id = (int)$this->input->post('commission_id');
        if (!$commission_id || !$this->db->table_exists('commissions')) {
            echo json_encode(['success' => false]); exit();
        }
        // Verify this commission belongs to this agent and is in 'payable' state
        $rec = $this->db->where('id', $commission_id)->where('agent_id', $uid)->where('status', 'payable')->get('commissions')->row();
        if (!$rec) { echo json_encode(['success' => false, 'error' => 'Not eligible']); exit(); }
        $this->db->where('id', $commission_id)->update('commissions', ['disbursement_requested_at' => time()]);
        echo json_encode(['success' => true]);
        exit();
    }

    public function submit_gr()
    {
        header('Content-Type: application/json');
        if (!is_logged_in()) { echo json_encode(['success' => false, 'error' => 'Not logged in']); exit(); }
        $uid         = (int)user_id();
        $order_id    = (int)$this->input->post('order_id');
        $retailer_id = (int)$this->input->post('retailer_id');
        $return_type = trim($this->input->post('return_type') ?? '');
        $items       = trim($this->input->post('items')       ?? '');
        $remark      = trim($this->input->post('remark')      ?? '');

        if (!$order_id || !$return_type || !$items) {
            echo json_encode(['success' => false, 'error' => 'Order, return type, and items are required.']); exit();
        }

        // Verify the order belongs to a client of this user
        $order = $this->db->select('id, order_id, user_id')->where('id', $order_id)->get('orders')->row();
        if (!$order) { echo json_encode(['success' => false, 'error' => 'Order not found.']); exit(); }
        $client_check = $this->db->query(
            "SELECT id FROM users_public WHERE id = {$order->user_id} AND FIND_IN_SET({$uid}, agents)"
        )->row();
        if (!$client_check && (int)$order->user_id !== $uid) {
            echo json_encode(['success' => false, 'error' => 'Unauthorized.']); exit();
        }

        // Handle proof file uploads
        $proof_files = [];
        $dir = './attachments/gr_proofs/';
        if (!is_dir($dir)) mkdir($dir, 0777, true);
        if (!empty($_FILES['proof']['name'][0])) {
            $this->load->library('upload');
            $files = $_FILES['proof'];
            $count = count($files['name']);
            for ($i = 0; $i < $count; $i++) {
                if (!$files['name'][$i]) continue;
                $_FILES['proof_single'] = [
                    'name'     => $files['name'][$i],
                    'type'     => $files['type'][$i],
                    'tmp_name' => $files['tmp_name'][$i],
                    'error'    => $files['error'][$i],
                    'size'     => $files['size'][$i],
                ];
                $this->upload->initialize(['upload_path' => $dir, 'allowed_types' => 'jpg|jpeg|png|pdf|webp', 'max_size' => 4096]);
                if ($this->upload->do_upload('proof_single')) {
                    $proof_files[] = $this->upload->data()['file_name'];
                }
            }
        }

        $this->_ensure_gr_table();
        $gr_no = 'GR-' . strtoupper(substr(uniqid(), -6));
        $this->db->insert('gr_requests', [
            'gr_no'        => $gr_no,
            'order_id'     => $order_id,
            'order_no'     => $order->order_id,
            'submitted_by' => $uid,
            'retailer_id'  => $retailer_id ?: (int)$order->user_id,
            'return_type'  => $return_type,
            'items'        => $items,
            'remark'       => $remark,
            'proof_files'  => implode(',', $proof_files),
            'status'       => 'pending',
            'created_at'   => time(),
        ]);

        echo json_encode(['success' => true, 'gr_no' => $gr_no]);
        exit();
    }

    public function submit_claim()
    {
        header('Content-Type: application/json');
        if (!is_logged_in()) { echo json_encode(['success' => false, 'error' => 'Not logged in']); exit(); }
        $uid      = (int)user_id();
        $type     = trim($this->input->post('type')        ?? '');
        $amount   = (float)$this->input->post('amount');
        $desc     = trim($this->input->post('description') ?? '');
        $order_id = (int)$this->input->post('order_id');

        if (!$type || $amount <= 0) {
            echo json_encode(['success' => false, 'error' => 'Claim type and a valid amount are required.']);
            exit();
        }
        $this->_ensure_claims_table();
        $this->db->insert('claims', [
            'claim_no'    => '',
            'user_id'     => $uid,
            'order_id'    => $order_id ?: null,
            'type'        => $type,
            'amount'      => $amount,
            'description' => $desc ?: null,
            'status'      => 'pending',
            'created_at'  => time(),
        ]);
        $new_id   = $this->db->insert_id();
        $claim_no = 'CLM-' . str_pad($new_id, 4, '0', STR_PAD_LEFT);
        $this->db->where('id', $new_id)->update('claims', ['claim_no' => $claim_no]);
        echo json_encode(['success' => true, 'claim_no' => $claim_no]);
        exit();
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
        if (!is_logged_in()) { redirect('login'); }
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

    /**
     * POST: company, email, password, phone, address
     * Creates a new retailer client attached to the current logged-in user.
     */
    public function add_client()
    {
        header('Content-Type: application/json');
        if (!is_logged_in()) { echo json_encode(['success' => false, 'error' => 'Not logged in']); exit(); }

        $uid     = (int)user_id();
        $company = trim($this->input->post('company'));
        $email   = trim($this->input->post('email'));
        $phone   = trim($this->input->post('phone'));
        $address = trim($this->input->post('address'));
        $pan     = trim($this->input->post('pan') ?? '');
        $gst     = trim($this->input->post('gst') ?? '');
        $pass    = $this->input->post('password');

        if (!$company || !$email || !$pass) {
            echo json_encode(['success' => false, 'error' => 'Company, email and password are required.']); exit();
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['success' => false, 'error' => 'Invalid email address.']); exit();
        }
        if ($this->db->where('email', $email)->count_all_results('users_public') > 0) {
            echo json_encode(['success' => false, 'error' => 'Email already registered.']); exit();
        }

        // Ensure agents column exists
        if (!$this->db->field_exists('agents', 'users_public')) {
            $this->db->query("ALTER TABLE `users_public` ADD COLUMN `agents` VARCHAR(255) DEFAULT NULL");
        }

        $row = [
            'name'     => $company,
            'email'    => $email,
            'phone'    => $phone,
            'company'  => $company,
            'address'  => $address,
            'pan'      => $pan,
            'gst'      => $gst,
            'password' => md5($pass),
            'type'     => 4,
            'status'   => 1,
            'agents'   => (string)$uid,
        ];
        // Only include 'created' if the column exists
        if ($this->db->field_exists('created', 'users_public')) {
            $row['created'] = date('Y-m-d H:i:s');
        }

        $inserted = $this->db->insert('users_public', $row);
        if (!$inserted || !$this->db->insert_id()) {
            echo json_encode(['success' => false, 'error' => 'Failed to save client. Please try again.']);
            exit();
        }

        echo json_encode(['success' => true]);
        exit();
    }

    public function edit_client()
    {
        header('Content-Type: application/json');
        if (!is_logged_in()) { echo json_encode(['success' => false, 'error' => 'Not logged in']); exit(); }

        $uid       = (int)user_id();
        $client_id = (int)$this->input->post('id');

        $client = $this->db->query(
            "SELECT id FROM `users_public` WHERE id = {$client_id} AND FIND_IN_SET({$uid}, `agents`)"
        )->row();
        if (!$client) {
            echo json_encode(['success' => false, 'error' => 'Client not found.']); exit();
        }

        $name    = trim($this->input->post('name'));
        $company = trim($this->input->post('company'));
        $pan     = trim($this->input->post('pan') ?? '');
        $gst     = trim($this->input->post('gst') ?? '');
        $address = trim($this->input->post('address') ?? '');
        $phone   = trim($this->input->post('phone') ?? '');
        $pass    = $this->input->post('password');

        if (!$name || !$company) {
            echo json_encode(['success' => false, 'error' => 'Name and company are required.']); exit();
        }

        $row = [
            'name'    => $name,
            'company' => $company,
            'phone'   => $phone,
            'pan'     => $pan,
            'gst'     => $gst,
            'address' => $address,
        ];
        if (!empty($pass)) {
            $row['password'] = md5($pass);
        }

        $this->db->where('id', $client_id)->update('users_public', $row);
        echo json_encode(['success' => true]);
        exit();
    }

    /**
     * GET: Returns total order count + billing total for a client.
     */
    public function get_client_stats($client_id)
    {
        header('Content-Type: application/json');
        if (!is_logged_in()) { echo json_encode(['orders' => 0, 'total' => 0]); exit(); }

        $client_id = (int)$client_id;
        $uid       = (int)user_id();

        // Verify this client actually belongs to this user
        $client = $this->db->where('id', $client_id)
                           ->where('agents', (string)$uid)
                           ->get('users_public')->row();
        // Allow FIND_IN_SET for multi-agent clients
        if (!$client) {
            $client = $this->db->query(
                'SELECT id FROM users_public WHERE id = ? AND FIND_IN_SET(?, agents)',
                [$client_id, (string)$uid]
            )->row();
        }
        if (!$client) { echo json_encode(['orders' => 0, 'total' => 0]); exit(); }

        $orders = $this->db->where('user_id', $client_id)->get('orders')->result_array();
        $total  = 0;
        foreach ($orders as $o) {
            $total += (float)($o['billing_amount'] ?? 0);
        }
        echo json_encode(['orders' => count($orders), 'total' => round($total, 2)]);
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

    public function submit_payment_receipt()
    {
        header('Content-Type: application/json');
        if (!is_logged_in()) { echo json_encode(['success' => false, 'message' => 'Not logged in']); exit(); }

        $uid      = (int)user_id();
        $order_id = (int)$this->input->post('order_id');
        $amount   = (float)$this->input->post('amount');
        $mode     = trim($this->input->post('mode') ?? '');
        $reference= trim($this->input->post('reference') ?? '');
        $notes    = trim($this->input->post('notes') ?? '');

        if (!$order_id || !$amount) {
            echo json_encode(['success' => false, 'message' => 'Order and amount are required.']);
            exit();
        }

        // Ensure payments table exists
        if (!$this->db->table_exists('payments')) {
            $this->db->query("CREATE TABLE IF NOT EXISTS `payments` (
                `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `order_id`    INT UNSIGNED NOT NULL,
                `user_id`     INT UNSIGNED NOT NULL,
                `amount`      DECIMAL(10,2) NOT NULL DEFAULT 0.00,
                `mode`        VARCHAR(50) NOT NULL DEFAULT '',
                `reference`   VARCHAR(100) NOT NULL DEFAULT '',
                `notes`       TEXT,
                `receipt_file`VARCHAR(255) NOT NULL DEFAULT '',
                `status`      ENUM('pending','verified','rejected') NOT NULL DEFAULT 'pending',
                `recorded_at` INT UNSIGNED NOT NULL DEFAULT 0,
                `verified_at` INT UNSIGNED NOT NULL DEFAULT 0,
                INDEX (`order_id`), INDEX (`user_id`), INDEX (`status`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
        } else {
            // Add missing columns if table existed before
            if (!$this->db->field_exists('receipt_file', 'payments')) {
                $this->db->query("ALTER TABLE `payments` ADD COLUMN `receipt_file` VARCHAR(255) NOT NULL DEFAULT ''");
            }
            if (!$this->db->field_exists('status', 'payments')) {
                $this->db->query("ALTER TABLE `payments` ADD COLUMN `status` ENUM('pending','verified','rejected') NOT NULL DEFAULT 'pending'");
            }
            if (!$this->db->field_exists('verified_at', 'payments')) {
                $this->db->query("ALTER TABLE `payments` ADD COLUMN `verified_at` INT UNSIGNED NOT NULL DEFAULT 0");
            }
        }

        // Handle file upload
        $receipt_file = '';
        if (!empty($_FILES['receipt']['name'])) {
            $upload_path = FCPATH . 'assets/uploads/payment_receipts/';
            if (!is_dir($upload_path)) { mkdir($upload_path, 0755, true); }
            $config = [
                'upload_path'   => $upload_path,
                'allowed_types' => 'jpg|jpeg|png|pdf|webp',
                'max_size'      => 5120, // 5MB
                'file_name'     => 'receipt_' . $uid . '_' . time(),
                'overwrite'     => false,
            ];
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('receipt')) {
                $receipt_file = $this->upload->data('file_name');
            } else {
                echo json_encode(['success' => false, 'message' => $this->upload->display_errors('', '')]);
                exit();
            }
        }

        $this->db->insert('payments', [
            'order_id'    => $order_id,
            'user_id'     => $uid,
            'amount'      => round($amount, 2),
            'mode'        => $mode,
            'reference'   => $reference,
            'notes'       => $notes,
            'receipt_file'=> $receipt_file,
            'status'      => 'pending',
            'recorded_at' => time(),
            'verified_at' => 0,
        ]);

        echo json_encode(['success' => true]);
        exit();
    }
}
