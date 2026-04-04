<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Products extends ADMIN_Controller
{

    private $num_rows = 10;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Products_model', 'Languages_model', 'Categories_model'));
         $this->load->library('upload');
    }


    public function import() { 
        require_once APPPATH."/third_party/PHPExcel-1.8/Classes/PHPExcel.php";
        require_once APPPATH."/third_party/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php";

    //$this->load->library('excel');
    $path = $_FILES["file"]["tmp_name"];
    $object = PHPExcel_IOFactory::load($path);
   
    foreach($object->getWorksheetIterator() as $worksheet) {  //echo '<pre>'; print_r($worksheet); die;
        $highestRow = $worksheet->getHighestRow();
        $highestColumn = $worksheet->getHighestColumn();
        for($row=2; $row<=$highestRow; $row++) { // skip first row (headers)
                
            $title = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
              $des   = $worksheet->getCellByColumnAndRow(2, $row)->getValue(); 
             $images = $worksheet->getCellByColumnAndRow(24, $row)->getValue();
             $price = $worksheet->getCellByColumnAndRow(15, $row)->getValue();
             $cat = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
             $quantity = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
             $pcolor = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
             $color = $worksheet->getCellByColumnAndRow(7, $row)->getValue(); 
             $item_code = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
             $bar_code = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
             $brand = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
             $season = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
             $fabric = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
             $msp = $worksheet->getCellByColumnAndRow(15, $row)->getValue();
             $wsp = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
             $gender = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
            // $image = $worksheet->getCellByColumnAndRow(15, $row)->getValue();
             $sizeno = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
             $size_range = $worksheet->getCellByColumnAndRow(16, $row)->getValue();
             $set_pcs_qty = $worksheet->getCellByColumnAndRow(19, $row)->getValue();  
             $result = str_replace("BO-", "", $title);
             $img = $result.$pcolor.'.webp';
             $img = str_replace(" ", "", $img);
             //echo $img;  // Outputs: 3800A

            //$price ='';
            $supplier ='';
            //$fabric ='';
            //$gender ='1';
            //$brand ='BloomUp';
            $season ='SUMMER';
            $cat ='';
            // ... Read more fields as needed
            
             //$image = $title.'_'.'.png';
             //$newStr = str_replace(' ', '_', $image);

            $products = array(
                'image' => $img,
                'quantity' => 1000,
                'shop_categorie' => $cat,
                'visibility' => '1'
                //'vendor_id' => '1'
                );
         //echo '<pre>'; print_r($products);   
           $this->db->insert('products',$products);
           $id = $this->db->insert_id(); 
               
               $data = array(
                'title' => $title,
                'bar_code' => $bar_code,
                'description' => $des,
                'price' => $price,
                'item_code' => $item_code,
                'gender' => $gender,
                'color' => $color,
                'penton_color' => $pcolor,
                'brand' => $brand,
                'fabric' => $fabric,
                'season' => $season,
                'msp' => $msp,
                'wsp' => $wsp,
                'sizeno' => $sizeno,
                'size_range' => $size_range,
                'set_pcs_qty' => $set_pcs_qty,
                'supplier' => $supplier,
                'abbr' => MY_DEFAULT_LANGUAGE_ABBR,
                'for_id' => $id
                
            );  //echo '<pre>'; print_r($data);  die;
            $this->db->insert('products_translations',$data);    
        }

    }
        $this->session->set_flashdata('result_publish', 'product imported successfully');
        redirect('admin/products');
    //$this->your_model->insertBatch($data); // Use a batch insert for performance
}


public function do_upload()
{
    $files = $_FILES;
    $count = count($_FILES['files']['name']);
    $uploadPath = './attachments/shop_images/';

    // Load upload library with config
    $config['upload_path'] = $uploadPath;
    $config['allowed_types'] = 'jpg|jpeg|png|gif';
    $config['max_size'] = 0; // no size limit or set as needed

    $this->load->library('upload');

    for($i = 0; $i < $count; $i++)
    {
        $_FILES['file']['name']     = $files['files']['name'][$i];
        $_FILES['file']['type']     = $files['files']['type'][$i];
        $_FILES['file']['tmp_name'] = $files['files']['tmp_name'][$i];
        $_FILES['file']['error']    = $files['files']['error'][$i];
        $_FILES['file']['size']     = $files['files']['size'][$i];

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('file'))
        {
            $error = $this->upload->display_errors();
            echo "Error uploading file " . $_FILES['file']['name'] . ": " . $error . "<br>";
        }
        else
        {
            $uploadData = $this->upload->data();
            // Here you can save $uploadData['file_name'] to DB if needed
            echo "Uploaded: " . $uploadData['file_name'] . "<br>";
        }
    }
}

    public function extract() {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'zip';
        $config['max_size'] = 2000000000000000; // Max 5MB
        
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('file')) {
            // Upload failed
            $error = $this->upload->display_errors(); print_r($error); die;
            $this->session->set_flashdata('msg', $error);
        } else {
            // Upload success
            $uploadData = $this->upload->data();
            $zip_path = $uploadData['full_path'];

            $extract_path = './extracted_images/';

            $zip = new ZipArchive;
            if ($zip->open($zip_path) === TRUE) {
                $zip->extractTo($extract_path);
                $zip->close();

                // Rename images by removing spaces
                $files = scandir($extract_path);
                /*foreach ($files as $file) {
                    if ($file != '.' && $file != '..') {
                        $file_path = $extract_path . $file;
                        if (is_file($file_path)) {
                            // Check for common image extensions
                            $ext = pathinfo($file_path, PATHINFO_EXTENSION);
                            $image_exts = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
                            if (in_array(strtolower($ext), $image_exts)) {
                                $new_name = str_replace(' ', '', $file);
                                if ($new_name != $file) {
                                    rename($file_path, $extract_path . $new_name);
                                }
                            }
                        }
                    }
                }*/
                $this->session->set_flashdata('msg', 'Upload and extraction successful. Image spaces removed.');
            } else {
                $this->session->set_flashdata('msg', 'Failed to extract zip file.');
            }
        }
        redirect('/');
    }
    public function rename_convert_images() {
        
    $this->load->library('image_lib');
    $folder_path = './attachments/shop_images/bloomup/';
    $files = scandir($folder_path);
    
    foreach ($files as $file) {
        if (preg_match('/\.(jpg|jpeg)$/i', $file)) {
            $old_path = $folder_path . $file;
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            $name = str_replace(' ', '_', pathinfo($file, PATHINFO_FILENAME));
            
            // Convert to PNG
            $config['image_library'] = 'gd2';
            $config['source_image'] = $old_path;
            $config['new_image'] = $folder_path . $name.'.png';
            $config['create_thumb'] = FALSE;
            
            $this->image_lib->initialize($config);
            if ($this->image_lib->resize()) {
                unlink($old_path);  // Delete original
                echo "Converted: $file → $name.png<br>";
            }
            $this->image_lib->clear();
        }
    }
}

    public function index($page = 0)
    {
        
         $zip = new ZipArchive;
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - View products';
        $head['description'] = '!';
        $head['keywords'] = '';

        if (isset($_GET['delete'])) {
            $this->Products_model->deleteProduct($_GET['delete']);
            $this->session->set_flashdata('result_delete', 'product is deleted!');
            $this->saveHistory('Delete product id - ' . $_GET['delete']);
            redirect('admin/products');
        }

        unset($_SESSION['filter']);
        $search_title = null;
        if ($this->input->get('search_title') !== NULL) {
            $search_title = $this->input->get('search_title');
            $page = 0; // reset pagination when searching
            $_SESSION['filter']['search_title'] = $search_title;
            $this->saveHistory('Search for product title - ' . $search_title);
        }
        $orderby = null;
        if ($this->input->get('order_by') !== NULL) {
            $orderby = $this->input->get('order_by');
            $_SESSION['filter']['order_by '] = $orderby;
        }
        $category = null;
        if ($this->input->get('category') !== NULL) {
            $category = $this->input->get('category');
            $_SESSION['filter']['category '] = $category;
            $this->saveHistory('Search for product code - ' . $category);
        }
        $vendor = null;
        if ($this->input->get('show_vendor') !== NULL) {
            $vendor = $this->input->get('show_vendor');
        }
          
        $data['products_lang'] = $products_lang = $this->session->userdata('admin_lang_products');
        $rowscount = $this->Products_model->productsCount($search_title, $category);
        $data['products'] = $this->Products_model->getproducts($this->num_rows, $page, $search_title, $orderby, $category, $vendor);
        //$data['products'] = $this->Products_model->getproducts('', $page, $search_title, $orderby, $category, $vendor);
        $data['links_pagination'] = pagination('admin/products', $rowscount, $this->num_rows, 3);

        // Fetch barcodes for listed products
        $data['barcode_map'] = [];
        if ($this->db->table_exists('product_barcodes') && !empty($data['products'])) {
            $product_ids = array_column((array)$data['products'], 'id');
            $bc_rows = $this->db->select('product_id, barcode, size, stock_qty')->where_in('product_id', $product_ids)->order_by('size', 'ASC')->get('product_barcodes')->result_array();
            foreach ($bc_rows as $r) {
                $data['barcode_map'][$r['product_id']][] = [
                    'barcode'   => $r['barcode'],
                    'size'      => $r['size'],
                    'stock_qty' => $r['stock_qty'],
                ];
            }
        }
        $data['num_shop_art'] = $this->Products_model->numShopproducts();
        $data['languages'] = $this->Languages_model->getLanguages();
        $data['shop_categories'] = $this->Categories_model->getShopCategories(null, null, 2);
        
        $this->saveHistory('Go to products');
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/products', $data);
        $this->load->view('_parts/footer');
    }

    public function getProductInfo($id, $noLoginCheck = false)
    {
        /* 
         * if method is called from public(template) page
         */
        if ($noLoginCheck == false) {
            $this->login_check();
        }
        return $this->Products_model->getOneProduct($id);
    }

    /*
     * called from ajax
     */

    public function productStatusChange()
    {
        $this->login_check();
        $result = $this->Products_model->productStatusChange($_POST['id'], $_POST['to_status']);
        if ($result == true) {
            echo 1;
        } else {
            echo 0;
        }
        $this->saveHistory('Change product id ' . $_POST['id'] . ' to status ' . $_POST['to_status']);
    }

}
