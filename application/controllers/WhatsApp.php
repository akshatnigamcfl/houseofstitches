<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WhatsApp extends CI_Controller {
    private $phone_number_id = 'YOUR_PHONE_NUMBER_ID';
    private $access_token = 'YOUR_PERMANENT_ACCESS_TOKEN';
    private $version = 'v19.0'; // Check latest API version
    
    public function __construct() {
        parent::__construct();
        $this->load->library('curl'); // Or use Guzzle
    }
    
    public function send_message() {
        $to = $this->input->post('phone'); // e.g., 917123456789
        $message = $this->input->post('message');
        
        $data = [
            'messaging_product' => 'whatsapp',
            'to' => $to,
            'type' => 'text',
            'text' => ['body' => $message]
        ];
        
        $url = "https://graph.facebook.com/{$this->version}/{$this->phone_number_id}/messages";
        
        $response = $this->curl->post($url, json_encode($data), [
            'headers' => [
                'Authorization: Bearer ' . $this->access_token,
                'Content-Type: application/json'
            ]
        ]);
        
        echo json_encode($response);
    }
}
