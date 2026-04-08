<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Publish extends ADMIN_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
            'Products_model',
            'Languages_model',
            'Brands_model',
            'Categories_model',
            'Product_attributes_model'
        ));
    }

    public function index($id = 0)
    {
        $this->login_check();
        $is_update = false;
        $trans_load = null;
        if ($id > 0 && $_POST == null) {
            $_POST = $this->Products_model->getOneProduct($id);
            //print_r($_POST); die;
            $trans_load = $this->Products_model->getTranslations($id);
        }
        
        
        if (isset($_POST['submit'])) {
            if (isset($_GET['to_lang'])) {
                $id = 0;
            }

            $_POST['image'] = $this->uploadImage();
            $product_id = $this->Products_model->setProduct($_POST, $id);
            $colors   = isset($_POST['variation_color'])  ? $_POST['variation_color']  : [];
            $sizes    = isset($_POST['variation_sizes'])   ? $_POST['variation_sizes']   : [];
            $swatches = isset($_POST['variation_swatch'])  ? $_POST['variation_swatch']  : [];
            $hexes    = isset($_POST['variation_hex'])     ? $_POST['variation_hex']     : [];
            $var_imgs = isset($_POST['variation_images'])  ? $_POST['variation_images']  : [];
            $this->Products_model->saveVariations($product_id, $colors, $sizes, $swatches, $hexes, $var_imgs);
            $this->session->set_flashdata('result_publish', 'Product is published!');
            if ($id == 0) {
                $this->saveHistory('Success published product');
            } else {
                $this->saveHistory('Success updated product');
            }
            if (isset($_SESSION['filter']) && $id > 0) {
                $get = '';
                foreach ($_SESSION['filter'] as $key => $value) {
                    $get .= trim($key) . '=' . trim($value) . '&';
                }
                redirect(base_url('admin/products?' . $get));
            } else {
                redirect('admin/products');
            }
        }
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Publish Product';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['id'] = $id;
        $data['trans_load'] = $trans_load;
        $data['languages'] = $this->Languages_model->getLanguages();
        $data['shop_categories'] = $this->Categories_model->getShopCategories();
        $data['brands']            = $this->Brands_model->getBrands();
        $data['attr_fabrics']      = $this->Product_attributes_model->getFabrics();
        $data['attr_fab_cats']     = $this->Product_attributes_model->getFabricCategories();
        $data['attr_fab_types']    = $this->Product_attributes_model->getFabricTypes();
        $data['otherImgs'] = $this->loadOthersImages();
        $data['variations'] = ($id > 0) ? $this->Products_model->getVariations($id) : [];
        $data['children']   = ($id > 0) ? $this->Products_model->getChildren($id) : [];
        $data['parent_id']  = ($id > 0 && isset($_POST['parent_id'])) ? (int)$_POST['parent_id'] : (($id > 0) ? (int)($this->db->select('parent_id')->where('id',$id)->get('products')->row_array()['parent_id'] ?? 0) : 0);
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/publish', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to publish product');
    }

    private function uploadImage()
    {
        // Determine the folder — use existing one or generate from timestamp
        $folder = isset($_POST['folder']) && $_POST['folder'] !== ''
            ? preg_replace('/[^a-zA-Z0-9_\-]/', '', $_POST['folder'])
            : (string)time();

        // Propagate folder so setProduct() saves it too
        $_POST['folder'] = $folder;

        $upath = './attachments/shop_images/' . $folder . '/';
        if (!is_dir($upath)) {
            mkdir($upath, 0777, true);
        }

        $config['upload_path']   = $upath;
        $config['allowed_types'] = $this->allowed_img_types;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('userfile')) {
            // No new cover image uploaded — keep the existing one
            return isset($_POST['old_image']) ? $_POST['old_image'] : '';
        }

        $img = $this->upload->data();
        // Return path relative to shop_images/ so all rendering still works
        return $folder . '/' . $img['file_name'];
    }

    /*
     * called from ajax — uploads a single variation product image, returns JSON {success, filename, url}
     */
    public function upload_variation_image()
    {
        header('Content-Type: application/json');
        $dir = './attachments/variation_images/';
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        $this->load->library('upload');
        $this->upload->initialize([
            'upload_path'   => $dir,
            'allowed_types' => 'gif|jpg|jpeg|png|webp',
            'max_size'      => 10240,
        ]);
        if (!$this->upload->do_upload('varimage')) {
            echo json_encode(['success' => false, 'error' => strip_tags($this->upload->display_errors())]);
            exit;
        }
        $img = $this->upload->data();
        echo json_encode([
            'success'  => true,
            'filename' => $img['file_name'],
            'url'      => base_url('attachments/variation_images/' . $img['file_name']),
        ]);
        exit;
    }

    /*
     * called from ajax — uploads a single swatch image, returns JSON {success, filename, url}
     */
    public function upload_swatch()
    {
        header('Content-Type: application/json');
        $dir = './attachments/product_swatches/';
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        $this->load->library('upload');
        $this->upload->initialize([
            'upload_path'   => $dir,
            'allowed_types' => 'gif|jpg|jpeg|png|webp',
            'max_size'      => 4096,
        ]);
        if (!$this->upload->do_upload('swatch')) {
            echo json_encode(['success' => false, 'error' => strip_tags($this->upload->display_errors())]);
            exit;
        }
        $img = $this->upload->data();
        echo json_encode([
            'success'  => true,
            'filename' => $img['file_name'],
            'url'      => base_url('attachments/product_swatches/' . $img['file_name']),
        ]);
        exit;
    }

    // ── Parent / Child AJAX endpoints ────────────────────────────────────────

    /**
     * POST: parent_id, child_id — link child to parent
     */
    public function linkChild()
    {
        header('Content-Type: application/json');
        $parent_id = (int)$this->input->post('parent_id');
        $child_id  = (int)$this->input->post('child_id');
        if (!$parent_id || !$child_id || $parent_id === $child_id) {
            echo json_encode(['success' => false, 'error' => 'Invalid IDs']);
            exit;
        }
        $this->Products_model->setParentId($child_id, $parent_id);
        $children = $this->Products_model->getChildren($parent_id);
        echo json_encode(['success' => true, 'children' => $children]);
        exit;
    }

    /**
     * POST: parent_id, child_id — unlink child from parent
     */
    public function unlinkChild()
    {
        header('Content-Type: application/json');
        $parent_id = (int)$this->input->post('parent_id');
        $child_id  = (int)$this->input->post('child_id');
        if (!$child_id) {
            echo json_encode(['success' => false]);
            exit;
        }
        $this->Products_model->setParentId($child_id, 0);
        $children = $this->Products_model->getChildren($parent_id);
        echo json_encode(['success' => true, 'children' => $children]);
        exit;
    }

    /**
     * GET: q, exclude — search products for linking
     */
    public function searchProducts()
    {
        header('Content-Type: application/json');
        $q       = $this->input->get('q');
        $exclude = (int)$this->input->get('exclude');
        if (strlen(trim($q)) < 1) {
            echo json_encode([]);
            exit;
        }
        $results = $this->Products_model->searchForLinking($q, $exclude);
        echo json_encode($results);
        exit;
    }

    /*
     * called from ajax (legacy modal - kept for compatibility)
     */
    public function do_upload_others_images()
    {
        $upath = '.' . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . 'shop_images' . DIRECTORY_SEPARATOR . $_POST['folder'] . DIRECTORY_SEPARATOR;
        if (!file_exists($upath)) {
            mkdir($upath, 0777);
        }

        $this->load->library('upload');
        $files = $_FILES;
        $cpt = count($_FILES['others']['name']);
        for ($i = 0; $i < $cpt; $i++) {
            unset($_FILES);
            $_FILES['others']['name']     = $files['others']['name'][$i];
            $_FILES['others']['type']     = $files['others']['type'][$i];
            $_FILES['others']['tmp_name'] = $files['others']['tmp_name'][$i];
            $_FILES['others']['error']    = $files['others']['error'][$i];
            $_FILES['others']['size']     = $files['others']['size'][$i];

            $this->upload->initialize([
                'upload_path'   => $upath,
                'allowed_types' => $this->allowed_img_types,
            ]);
            $this->upload->do_upload('others');
        }
    }

    /**
     * Upload a single additional image — returns JSON {success, filename, url}
     */
    public function upload_extra_image()
    {
        header('Content-Type: application/json');
        $folder    = trim($this->input->post('folder'));
        $product_id = (int)$this->input->post('product_id');

        // If folder is empty, generate one from product ID or timestamp (numeric only — folder column is int-compatible)
        if (empty($folder)) {
            $folder = $product_id > 0 ? (string)$product_id : (string)time();
        }
        // Prevent path traversal
        $folder = preg_replace('/[^a-zA-Z0-9_\-]/', '', $folder);
        // Always persist the folder to DB so the product page can find the images
        if ($product_id > 0) {
            $this->db->where('id', $product_id)->update('products', ['folder' => $folder]);
        }
        $upath  = './attachments/shop_images/' . $folder . '/';
        if (!is_dir($upath)) {
            mkdir($upath, 0777, true);
        }
        $this->load->library('upload');
        $this->upload->initialize([
            'upload_path'      => $upath,
            'allowed_types'    => 'gif|jpg|jpeg|png|webp',
            'max_size'         => 10240,
        ]);
        if (!$this->upload->do_upload('extra_image')) {
            echo json_encode(['success' => false, 'error' => strip_tags($this->upload->display_errors())]);
            exit;
        }
        $img = $this->upload->data();
        echo json_encode([
            'success'  => true,
            'folder'   => $folder,
            'filename' => $img['file_name'],
            'url'      => base_url('attachments/shop_images/' . $folder . '/' . $img['file_name']),
        ]);
        exit;
    }

    public function loadOthersImages()
    {
        $output = '';
        if (isset($_POST['folder']) && $_POST['folder'] != null) {
            $dir = 'attachments' . DIRECTORY_SEPARATOR . 'shop_images' . DIRECTORY_SEPARATOR . $_POST['folder'] . DIRECTORY_SEPARATOR;
            if (is_dir($dir)) {
                if ($dh = opendir($dir)) {
                    $i = 0;
                    while (($file = readdir($dh)) !== false) {
                        if (is_file($dir . $file)) {
                            $output .= '
                                <div class="other-img" id="image-container-' . $i . '">
                                    <img src="' . base_url('attachments/shop_images/' . htmlspecialchars($_POST['folder']) . '/' . $file) . '" style="width:100px; height: 100px;">
                                    <a href="javascript:void(0);" onclick="removeSecondaryProductImage(\'' . $file . '\', \'' . htmlspecialchars($_POST['folder']) . '\', ' . $i . ')">
                                        <span class="glyphicon glyphicon-remove"></span>
                                    </a>
                                </div>
                               ';
                        }
                        $i++;
                    }
                    closedir($dh);
                }
            }
        }
        if ($this->input->is_ajax_request()) {
            echo $output;
        } else {
            return $output;
        }
    }

    /*
     * called from ajax
     */
    public function removeSecondaryImage() {
        if ($this->input->is_ajax_request()) {
            $basePath = realpath('.' . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . 'shop_images' . DIRECTORY_SEPARATOR);
    
            $folder = realpath($basePath . DIRECTORY_SEPARATOR . $_POST['folder']);
            $image = $_POST['image'];
    
            if ($folder !== false && strpos($folder, $basePath) === 0 && is_file($folder . DIRECTORY_SEPARATOR . $image)) {
                unlink($folder . DIRECTORY_SEPARATOR . $image);
            }
        }
    }
}
