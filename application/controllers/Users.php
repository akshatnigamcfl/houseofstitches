<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller
{

    private $registerErrors = array();
    private $user_id;
    private $num_rows = 5;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('email');
    }

    public function index()
    {
        show_404();
    }

    public function login()
    {
        if (isset($_POST['login'])) {
            $result = $this->Public_model->checkPublicUserIsValid($_POST);
            if ($result !== false) {
                $_SESSION['logged_user'] = $result; //id of user
               // redirect(LANG_URL . '/checkout');
               redirect('home/shop');
            } elseif ($this->Public_model->checkUserPendingApproval($_POST)) {
                $this->session->set_flashdata('userError', 'Your account is pending admin approval. You will receive an email once approved.');
            } else {
                $this->session->set_flashdata('userError', lang('wrong_user'));
            }
        }
        $head = array();
        $data = array();
        $head['title'] = lang('user_login');
        $head['description'] = lang('user_login');
        $head['keywords'] = str_replace(" ", ",", $head['title']);
        $this->render('login', $head, $data);
    }

    public function register()
    {
        
        if (isset($_POST['signup'])) {
            $result = $this->registerValidate();
            
            if ($result == false) { //print_r($this->registerErrors); die;
                $this->session->set_flashdata('userError', $this->registerErrors[0]);
                redirect(LANG_URL . '/register');
            } else {
               // $_SESSION['logged_user'] = $this->user_id; //id of user
               $this->session->set_flashdata('success', 'You have registered successfully. Once Admin will approve you will receive an e-mail with login details. ');
                redirect(LANG_URL . '/register');
            }
        }
        $head = array();
        $data = array();
        $data['agents'] = $this->db->query('select agents from users_public')->result();
        $head['title'] = lang('user_register');
        $head['description'] = lang('user_register');
        $head['keywords'] = str_replace(" ", ",", $head['title']);
        $this->render('login', $head, $data);
    }

    public function myaccount($page = 0)
    {
        if (isset($_POST['update'])) {
            $_POST['id'] = $_SESSION['logged_user'];
            $count_emails = $this->Public_model->countPublicUsersWithEmail($_POST['email'], $_POST['id']);
            if ($count_emails == 0) {
                $this->Public_model->updateProfile($_POST);
            }
            redirect(LANG_URL . '/myaccount');
        }
        $head = array();
        $data = array();
        $head['title'] = lang('my_acc');
        $head['description'] = lang('my_acc');
        $head['keywords'] = str_replace(" ", ",", $head['title']);
        $data['userInfo'] = $this->Public_model->getUserProfileInfo($_SESSION['logged_user']);
        $rowscount = $this->Public_model->getUserOrdersHistoryCount($_SESSION['logged_user']);
        $data['orders_history'] = $this->Public_model->getUserOrdersHistory($_SESSION['logged_user'], $this->num_rows, $page);
        $data['links_pagination'] = pagination('myaccount', $rowscount, $this->num_rows, 2);
        $this->render('user', $head, $data);
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
    public function logout()
    {
        $this->load->helper('cookie');
foreach ($this->input->cookie() as $name => $value) {
    delete_cookie($name);
}

        unset($_SESSION['logged_user']);
         $this->session->sess_destroy();
        redirect(LANG_URL);
    }

    private function registerValidate()
    {
        $errors = array();
        if (mb_strlen(trim($_POST['name'])) == 0) {
            $errors[] = lang('please_enter_name');
        }
        if (mb_strlen(trim($_POST['phone'])) == 0) {
            $errors[] = lang('please_enter_phone');
        }
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = lang('invalid_email');
        }
        if (mb_strlen(trim($_POST['pass'])) == 0) {
            $errors[] = lang('enter_password');
        }
        /*if (mb_strlen(trim($_POST['pass_repeat'])) == 0) {
            $errors[] = lang('repeat_password');
        }
        if ($_POST['pass'] != $_POST['pass_repeat']) {
            $errors[] = lang('passwords_dont_match');
        }*/

        $count_emails = $this->Public_model->countPublicUsersWithEmail($_POST['email']);
        if ($count_emails > 0) {
            $errors[] = lang('user_email_is_taken');
        }
        if (!empty($errors)) {
            $this->registerErrors = $errors;
            return false;
        }
        $this->user_id = $this->Public_model->registerUser($_POST);
        $msg = 'Your login Credential Are <br> <b>Email</b>: '.$_POST['email'].' <br> <b>Password</b>: '.$_POST['pass'].' ';
        $this->smtp_email($to_email=$_POST['email'], $to_name=$_POST['name'], $subject='', $url='www.houseofstitches.in',$msg);
        return true;
    }
        public function add_client(){
        $post = $this->input->post();
        $insert_arr = array(
            'name' => $post['companyName'],
            'company' => $post['companyName'],
            'email' => $post['email'],
            'phone' => $post['phone'],
            'password' => md5($post['pass']),
            'address' => $post['address'],
            'type' => $post['userType'],
            'parent_id' => user_id()
            );
        $this->db->insert('users_public',$insert_arr); //echo $this->db->last_query(); die;
       echo $last_id = $this->db->insert_id(); die;

    }
     public function smtp_email($to_email, $to_name, $subject, $url,$msg ) {
         $this->load->library('email');
        $this->load->helper('url');
        // Clear any previous emails
        $this->email->clear();
        
        // SMTP Settings (loaded from config/email.php)
        $this->email->from('nitesh54546@gmail.com', 'House of Stitches');
        $this->email->to($to_email);
        $this->email->cc('admin@houseofstitches.in');  // Optional
        $this->email->bcc('backup@houseofstitches.in'); // Optional
        
        $this->email->subject('🧵 Registration Confirmation - House of Stitches'.$subject);
        
      $data['user_name'] = $to_name; // Pass from controller
      $data['msg'] = $msg; // Pass from controller
      $message = $this->load->view('templates/redlabel/register_template', $data, TRUE);

        
        $this->email->message($message);
        
        // SEND EMAIL ✅
        if ($this->email->send()) {
            echo "<h2>✅ SMTP Email Sent Successfully!</h2>";
            echo "<p>To: <strong>" . $to_email . "</strong></p>";
            echo "<p>Check your inbox/spam folder!</p>";
        } else {
            echo "<h2>❌ SMTP Email Failed!</h2>";
            echo "<pre>" . $this->email->print_debugger(['headers' => FALSE]) . "</pre>";
        }
    }

}
