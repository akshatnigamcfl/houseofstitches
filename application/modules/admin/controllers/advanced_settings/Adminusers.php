<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Adminusers extends ADMIN_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Admin_users_model');
    }
   public function import_users_agent() { 
        require_once APPPATH."/third_party/PHPExcel-1.8/Classes/PHPExcel.php";
        require_once APPPATH."/third_party/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php";
        
        //$this->load->library('excel');
        $path = $_FILES["file"]["tmp_name"];
        $object = PHPExcel_IOFactory::load($path);
   
    foreach($object->getWorksheetIterator() as $worksheet) {  //echo '<pre>'; print_r($worksheet); die;
        $highestRow = $worksheet->getHighestRow();
        $highestColumn = $worksheet->getHighestColumn();
        for($row=2; $row<=$highestRow; $row++) { 
             $name = $worksheet->getCellByColumnAndRow(1, $row)->getValue(); 
             $agent  = $worksheet->getCellByColumnAndRow(11, $row)->getValue(); 
                $data = array('agents' => $agent);
                $this->db->where('name', $name);
                $this->db->update('users_public', $data);
                
                // Check if updated
                if ($this->db->affected_rows() > 0) {
                  echo $this->db->last_query().'<br>';
                } else {
                    echo $name."No rows updated".'<br>';
                }         
        
         }
        }
    }
    public function get_data(){
        $post_id = $this->input->post('option_id');
        $sql ='select id,agents from users_public';
        $result = $this->db->query($sql)->result();
        $labl = ($post_id=='1') ? 'Agent List' : 'Distributors';
       // print_r($result); die;
        $html = '<label for="regPhone" class="title fw-semibold fs-5" >'.$labl.'</label>
                        <select class="form-control agent-select" name="type">';
        foreach ($result as $row){
            $html .='<option value='.$row->agents.'>'.$row->agents.'</option>';
        }
        echo $html; die;
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

             $name = $worksheet->getCellByColumnAndRow(1, $row)->getValue(); 
             $email   = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
             $email = !empty($email) ? $email : 'gedewel821@feralrex.com';
             $phone = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
             $company = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
             $address = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
             $pan = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
             $gst = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
             $type = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
             $agents = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
             $password = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
            
            // ... Read more fields as needed
         
            $user = array(
                'name' => $name,
                'email' => $email,
                'phone' => $cat,
                'company' => $company,
                'pan' => $pan,
                'gst' => $gst,
                'address' => $address,
                'type' => $type,
                'status' => '1',
                'agents' => $agents,
                'status' => '1',
                'created' => date('Y-m-y h:i:s')
                //'vendor_id' => '1'
                );
            //echo '<pre>'; print_r($user);   die;
            $this->db->insert('users_public',$user);
        
  
        }

    }
        $this->session->set_flashdata('result_publish', 'product imported successfully');
        redirect('admin/adminusers');
    //$this->your_model->insertBatch($data); // Use a batch insert for performance
}
    public function index()
    { 
        $this->login_check();
        if (isset($_GET['delete'])) {
            $this->Admin_users_model->deleteAdminUser($_GET['delete']);
            $this->session->set_flashdata('result_delete', 'User is deleted!');
            redirect('admin/adminusers');
        }
        if (isset($_GET['edit']) && !isset($_POST['username'])) {
            $_POST = $this->Admin_users_model->getAdminUsers($_GET['edit']);
        }
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Admin Users';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['users'] = $this->Admin_users_model->getAdminUsers();
        $data['Allusers'] = $this->Admin_users_model->getUsers();
       // print_r($data['Allusers']); die;
        $this->form_validation->set_rules('username', 'User', 'trim|required');
        if (isset($_POST['edit']) && $_POST['edit'] == 0) {
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
        }
        if ($this->form_validation->run($this)) {
            $this->Admin_users_model->setAdminUser($_POST);
            $this->saveHistory('Create admin user - ' . $_POST['username']);
            redirect('admin/adminusers');
        }

        $this->load->view('_parts/header', $head);
        $this->load->view('advanced_settings/adminUsers', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to Admin Users');
    }
    
public function approve() {
     $id = $this->input->post('id');
     $role = $this->input->post('role'); 
     $pcent = $this->input->post('pcent'); 
     $remark = $this->input->post('rmark'); 
     $value = $this->input->post('agent'); 
    $this->db->where('id', $id)->update('users_public', ['status' => '1', 'type' => $role, 'percent' => $pcent, 'remark' => $remark, 'agents'=> $value]);
   if ($this->db->affected_rows() > 0) {
                echo json_encode(['success' => true, 'message' => 'Approved successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'No rows updated']);
            }
}

public function reject() {
     $id = $this->input->post('id');
    $this->db->where('id', $id)->update('users_public', ['status' => '3']);
    echo json_encode(['success' => true]);
}


    

}






