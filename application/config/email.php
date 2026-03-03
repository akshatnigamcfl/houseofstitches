<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/*$config['protocol']    = 'smtp';
$config['smtp_host']   = 'smtp.gmail.com';        // Your SMTP server
$config['smtp_port']   = 25;                       // SMTP port (Gmail uses 587 for TLS)
$config['smtp_user']   = 'nitesh54546@gmail.com';   // Your SMTP username (email)
$config['smtp_pass']   = 'jqmh yrkd tujt wldx';      // Your SMTP password or app password
$config['smtp_crypto'] = 'TLS/STARTTLS';                     // Encryption (tls or ssl)
$config['mailtype']    = 'html';                    // 'html' or 'text'
$config['charset']     = 'utf-8';
$config['wordwrap']    = TRUE;
$config['newline']     = "\r\n";  */                  // Important for SMTP


/*$config['protocol']    = 'smtp';
$config['smtp_host']   = 'smtp.hostinger.com';
$config['smtp_port']   = 587;           // or 465 with 'ssl'
$config['smtp_user']   = 'info@houseofstitches.in';
$config['smtp_pass']   = 'YOUR_HOSTINGER_EMAIL_PASSWORD';
$config['smtp_crypto'] = 'tls';         // exactly 'tls'
$config['mailtype']    = 'html';
$config['charset']     = 'utf-8';
$config['wordwrap']    = TRUE;
$config['newline']     = "\r\n";*/
$config['protocol'] = 'mail';      // ✅ NO SMTP NEEDED
$config['mailtype'] = 'html';      // HTML emails
$config['charset'] = 'utf-8';
$config['wordwrap'] = TRUE;
