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
         
        $set_quanity = get_product_quantity($_POST['product_id']);
        $sql = 'SELECT quantity FROM `cart_items` where `product_id` ='.$_POST['product_id'].' and session_id='.user_id().'';
        $cart_product_quantity = $this->db->query($sql)->row()->quantity;
        $new_qty = $cart_product_quantity-$set_quanity;
        $set_quanity_pcs = $new_qty/$set_quanity;
            $this->db->where(['product_id' => $_POST['product_id'], 'session_id' => user_id()])
             ->update('cart_items', ['quantity' => $new_qty,'set_quantity'=>$set_quanity_pcs]);
             //echo $this->db->last_query(); die;
                 echo json_encode([
        'success' => true,
        //'cart_count' => get_cart_count(),
        //'total' => get_cart_total_price()
    ]);


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
        $data['products'] = $this->Public_model->getProducts($this->num_rows, $page, $_GET); 
          //echo '<pre>'; print_r( $data['products']); 
        $rowscount = $this->Public_model->productsCount($_GET);
        $data['links_pagination'] = pagination('home/shop', $rowscount, $this->num_rows);
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
        $data['sameCagegoryProducts'] = $this->Public_model->sameCagegoryProducts($data['product']['shop_categorie'], $id);
        if ($data['product'] === null) {
            show_404();
        }
        $vars['publicDateAdded'] = $this->Home_admin_model->getValueStore('publicDateAdded');
        $this->load->vars($vars);
        $head['title'] = $data['product']['title'];
        $description = url_title(character_limiter(strip_tags($data['product']['description']), 130));
        $description = str_replace("-", " ", $description) . '..';
        $head['description'] = $description;
        $head['keywords'] = str_replace(" ", ",", $data['product']['title']);
        $head['image'] = null;
        if(isset($data['product']['image'])) {
            $head['image'] = base_url('/attachments/shop_images/' . $data['product']['image']);
        }
        $this->render('view_product', $head, $data);
    }
    
    public function ajax_cart_filter(){
        $post = $this->input->post();
       // print_r($post); die;
        $post['season'];
$this->db->select('p.*, pt.title, pt.description, pt.*');
$this->db->from('products p');
$this->db->join('products_translations pt', 
                'p.id = pt.for_id',  // ✅ Fixed join condition
                'left');

// ✅ CRITICAL: Check if season exists FIRST
if (!empty($post['season'])) {
    $this->db->where('pt.season', $post['season']);
} else {
    // No season filter OR handle NULL
    $this->db->group_start()
             ->where('pt.season IS NULL')
             ->or_where('pt.season =', '')
             ->group_end();
}

$query = $this->db->get();

if ($query === FALSE) {
    // Query failed
    log_message('error', 'SQL Error: ' . $this->db->error()['message']);
    log_message('error', 'Last Query: ' . $this->db->last_query());
    $result = [];
} else {
    $result = $query->result_array();
}
          foreach ($result as $val) {  
              
        $html .='  <div class="col-lg-3 col-md-4 col-6">
                          <div class="tb-product-item-inner">
                            <div class="card product-card position-relative" data-bs-toggle="modal" data-bs-target="#productModal" tabindex="0" onerror="this.onerror=null; this.src='.base_url('/attachments/shop_images/spark_logo-06.jpg').';"
                              data-title="'.$val['title'].'" data-brand="'.$val['brand'].'" data-sku="BUP-AUR-DRS-WHT"
                              data-price="'.$val['wsp'].'" data-mrp="'.$val['msp'].'"
                              data-desc="'.$val['description'].'"
                              data-fabric="'.$val['fabric'].'"
                              data-id="'.$val['id'].'"

                              data-images="'. base_url('attachments/shop_images/').$val['image'].'"
                              data-colors="'.$val['color'].'"
                              data-sizes="'.$val['size_range'].'">';

                             
                              // Path to the folder containing images
                              $folderPath = $_SERVER['DOCUMENT_ROOT'] . '/attachments/shop_images/';

                              // Image filename to check
                              $imageName = $val['image'];

                              // Full path to the image on server
                              $imagePath = $folderPath . trim($imageName);
                              //echo $img = base_url()."attachments/shop_images/".$val['image'];
                              if (is_file($imagePath)) {
                             
                           $html .= '<div class="product-img-wrapper">
                                  <img alt="product"
                                    src="'. base_url('attachments/shop_images/').$val['image'].'"
                                    style="object-fit:scale-down;"
                                    class="w-100 img_products"
                                    onload="this.parentElement.classList.remove("skeleton")">
                                  <span class="brand-badge-animated">
                                    '.htmlspecialchars($val['brand']).'
                                  </span>
                                </div>';
                               } else {
                              $html .='<img alt="product" src="'.base_url('attachments/shop_images/').$val['image'].'" onerror="this.onerror=null; this.src='.base_url('/attachments/shop_images/spark_logo-06.jpg').';" style="object-fit: scale-down!important;" class="w-100 img_products"
                                  onload="this.parentElement.classList.remove("skeleton")">';
                              } 
                          $html .=' </div>
                            <div><a href="#"><i data-product-id="'.$val['id'].'" class="bi bi-heart wishlist-btn"></i></a></div>
                            <ul class="list-unstyled tb-content">
                              <li><a href="#">'.$val['title'].'</a></li>
                              <li class="small"><a href="#" class="text-muted">'.$val['size_range'].'</a></li>
                              <li>'.$val['color'].'</li>
                              <li>
                                <ol class="price-list">
                                  <li>WSP '.$val['wsp'].' /-</li>
                                  <li>MRP '.$val['msp'].' /-</li>
                                </ol>
                              </li>
                              <li>
                                <a href="javascript:void(0);"  data-price="'.$val['wsp'].'" data-mrp="'.$val['msp'].'" class="btn btn-dark w-100 rounded-pill mt-2 add-to-cart_new" data-action="add"  data-id="'.$val['id'].'">Add To Cart</a>
                              </li>
                            </ul>
                            <!-- <div class="tb-beg">
                                <a href="#">'.$val['title'].'</a>
                              </div>
                              <div class="tb-beg">
                                <a href="#">'.$val['size_range'].'</a>
                              </div>
                              <div class="tb-product-price">
                                <span class="amount">'.$val['color'].'</span>
                              </div>
                              <div class="tb-product-price">
                                <span class="amount">MRP '.$val['msp'].' /-</span>
                              </div>
                              <div class="tb-product-price">
                                <span class="amount">WSP '.$val['wsp'].' /-</span>
                              </div> -->
                            <!-- <div class="add-to-cart">
                                <a href="javascript:void(0);" class="add-to-cart btn-add " data-goto="https://darkred-crane-589214.hostingersite.com/misberry/Ec/shopping-cart" data-id="1">
                                    <img class="loader" src="https://darkred-crane-589214.hostingersite.com/misberry/Ec/assets/imgs/ajax-loader.gif" alt="Loding">
                                    <span class="text-to-bg">Add to basket</span>
                                </a>
                            </div>-->
                          </div>
                        </div>
';

          }
          echo $html; die;
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
        $data['clients'] = $this->db->query('SELECT * FROM `users_public` where parent_id ='.user_id().' ')->result();
        $head['title'] = 'Administration - Orders';
        $head['description'] = '!';
        $head['keywords'] = '';

        $order_by = null;
        if (isset($_GET['order_by'])) {
            $order_by = $_GET['order_by'];
        }
        $data['orders'] = $this->Orders_model->orders($this->num_rows, $page=null, $order_by);
        $data['product'] = $this-> Wishlist_model->get_wishlist();
        $this->load->view('templates/redlabel/_parts/header');
        $this->load->view('templates/redlabel/account',$data);
        $this->load->view('templates/redlabel/_parts/footer');
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
}
