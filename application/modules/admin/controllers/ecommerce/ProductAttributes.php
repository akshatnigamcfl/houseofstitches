<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class ProductAttributes extends ADMIN_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Product_attributes_model', 'Brands_model']);
    }

    public function index()
    {
        $this->login_check();

        // Handle add
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $type = $this->input->post('attr_type');
            $name = trim($this->input->post('name'));
            if ($name !== '') {
                switch ($type) {
                    case 'fabric':          $this->Product_attributes_model->addFabric($name);          break;
                    case 'fabric_category': $this->Product_attributes_model->addFabricCategory($name);  break;
                    case 'fabric_type':     $this->Product_attributes_model->addFabricType($name);       break;
                    case 'brand':           $this->Brands_model->setBrand($name);                        break;
                }
            }
            redirect('admin/product-attributes?tab=' . $type);
        }

        // Handle delete
        if (isset($_GET['delete_fabric']))          { $this->Product_attributes_model->deleteFabric($_GET['delete_fabric']);                redirect('admin/product-attributes?tab=fabric'); }
        if (isset($_GET['delete_fabric_category'])) { $this->Product_attributes_model->deleteFabricCategory($_GET['delete_fabric_category']); redirect('admin/product-attributes?tab=fabric_category'); }
        if (isset($_GET['delete_fabric_type']))     { $this->Product_attributes_model->deleteFabricType($_GET['delete_fabric_type']);         redirect('admin/product-attributes?tab=fabric_type'); }
        if (isset($_GET['delete_brand']))           { $this->Brands_model->deleteBrand($_GET['delete_brand']);                               redirect('admin/product-attributes?tab=brand'); }

        $data = [];
        $head = ['title' => 'Administration - Product Attributes', 'description' => '', 'keywords' => ''];
        $data['fabrics']           = $this->Product_attributes_model->getFabrics();
        $data['fabric_categories'] = $this->Product_attributes_model->getFabricCategories();
        $data['fabric_types']      = $this->Product_attributes_model->getFabricTypes();
        $data['brands']            = $this->Brands_model->getBrands();
        $data['active_tab']        = isset($_GET['tab']) ? $_GET['tab'] : 'fabric';

        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/product_attributes', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Managed product attributes');
    }
}
