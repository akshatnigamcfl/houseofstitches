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
        // Build id → name map for resolving parent users from the agents field
        $all_for_map = $this->db->select('id, name, company, type')->get('users_public')->result();
        $user_map = [];
        foreach ($all_for_map as $u) {
            $user_map[(int)$u->id] = [
                'name'    => $u->name,
                'company' => $u->company,
                'type'    => (int)$u->type,
            ];
        }
        $data['user_map'] = $user_map;
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
    header('Content-Type: application/json');
    $id    = $this->input->post('id');
    $role  = $this->input->post('role');
    $pcent = $this->input->post('pcent');
    $rmark = $this->input->post('rmark');
    $agent = $this->input->post('agent');

    // Add missing columns on first run
    if (!$this->db->field_exists('percent', 'users_public')) {
        $this->db->query("ALTER TABLE users_public ADD COLUMN `percent` varchar(20) DEFAULT NULL");
    }
    if (!$this->db->field_exists('remark', 'users_public')) {
        $this->db->query("ALTER TABLE users_public ADD COLUMN `remark` varchar(255) DEFAULT NULL");
    }
    if (!$this->db->field_exists('agents', 'users_public')) {
        $this->db->query("ALTER TABLE users_public ADD COLUMN `agents` varchar(255) DEFAULT NULL");
    }

    $this->db->where('id', $id)->update('users_public', [
        'status'  => '1',
        'type'    => $role,
        'percent' => $pcent,
        'remark'  => $rmark,
        'agents'  => $agent,
    ]);
    echo json_encode(['success' => true, 'message' => 'Approved successfully']);
    exit();
}

public function reject() {
    header('Content-Type: application/json');
    $id = $this->input->post('id');
    $this->db->where('id', $id)->update('users_public', ['status' => '3']);
    echo json_encode(['success' => true]);
    exit();
}

public function editPublicUser() {
    $this->login_check();
    header('Content-Type: application/json');

    $id     = (int)$this->input->post('id');
    if (!$id) { echo json_encode(['success' => false, 'message' => 'Invalid ID']); exit(); }

    $name   = $this->input->post('name');
    $phone  = $this->input->post('phone');
    $email  = $this->input->post('email');
    $address= $this->input->post('address');
    $pan    = $this->input->post('pan');
    $gst    = $this->input->post('gst');
    $type   = (int)$this->input->post('type');
    $pcent  = $this->input->post('pcent');
    $remark = $this->input->post('remark');
    $status = (int)$this->input->post('status');
    $agents = $this->input->post('agents');

    // Ensure optional columns exist before updating them
    if (!$this->db->field_exists('remark', 'users_public')) {
        $this->db->query("ALTER TABLE `users_public` ADD COLUMN `remark` VARCHAR(255) DEFAULT NULL");
    }
    if (!$this->db->field_exists('percent', 'users_public')) {
        $this->db->query("ALTER TABLE `users_public` ADD COLUMN `percent` VARCHAR(20) DEFAULT NULL");
    }
    if (!$this->db->field_exists('agents', 'users_public')) {
        $this->db->query("ALTER TABLE `users_public` ADD COLUMN `agents` VARCHAR(255) DEFAULT NULL");
    }

    $data = [
        'name'    => $name,
        'phone'   => $phone,
        'email'   => $email,
        'address' => $address,
        'pan'     => $pan,
        'gst'     => $gst,
        'type'    => $type,
        'status'  => $status,
        'remark'  => $remark,
    ];
    if ($pcent !== '' && $pcent !== null) {
        $data['percent'] = $pcent;
    }
    // Only update agents for retailers (type=4), or when explicitly sent
    if ($agents !== null) {
        $data['agents'] = trim($agents);
    }

    $this->db->where('id', $id)->update('users_public', $data);
    echo json_encode(['success' => true]);
    exit();
}


    

}






