<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Smtp_test extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->library('email');
        $this->load->helper('url');
    }
    
    public function send_test($to_email, $to_name, $subject, $url,$msg) {
        $this->smtp_email($to_email, $to_name, $subject, $url,$msg);
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
        
        $this->email->subject('🧵 Order Confirmation - House of Stitches'.$subject);
        
        // HTML Email Body
        $message = '
        <html>
        <head><meta charset="UTF-8"></head>
        <body style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
            <div style="background: #f8f9fa; padding: 40px 20px;">
                <h1 style="color: #e74c3c; text-align: center;">Order Confirmed! 🎉</h1>
                <p>Dear <strong>' . $to_name . '</strong>,</p>
                <p <strong>' . $url . '</strong>,</p>
                <p>Dear <strong>' . $msg . '</strong>,</p>
                <p>Thank you for your purchase from <strong>House of Stitches</strong>!</p>
                
                <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
                    <tr style="background: #e74c3c; color: white;">
                        <th style="padding: 12px; text-align: left;">Product</th>
                        <th style="padding: 12px;">Price</th>
                        <th style="padding: 12px;">Qty</th>
                    </tr>
                    <tr style="background: white;">
                        <td style="padding: 12px;">Premium Stitching Kit</td>
                        <td style="padding: 12px;">₹599</td>
                        <td style="padding: 12px;">1</td>
                    </tr>
                </table>
                
                <div style="background: #fff3cd; padding: 15px; border-radius: 5px; margin: 20px 0;">
                    <strong>Total: ₹599</strong>
                </div>
                
                <p>We\'ll ship your order within 2-3 business days.</p>
                
                <hr style="border: none; border-top: 1px solid #eee;">
                <p style="font-size: 12px; color: #666; text-align: center;">
                    House of Stitches | info@houseofstitches.in | +91 9876543210
                </p>
            </div>
        </body>
        </html>';
        
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
