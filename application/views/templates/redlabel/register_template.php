<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Welcome to House of Stitches</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 30px auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            padding: 20px;
        }
        h1 {
            color: #e74c3c;
            text-align: center;
            margin-bottom: 30px;
        }
        p {
            font-size: 16px;
            line-height: 1.5;
        }
        .btn {
            display: inline-block;
            background-color: #e74c3c;
            color: #fff;
            padding: 12px 25px;
            margin: 25px 0;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            text-align: center;
        }
        footer {
            text-align: center;
            font-size: 13px;
            color: #999;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <h1>Welcome to House of Stitches!</h1>
        
        <p>Hi <strong><?= htmlspecialchars($user_name) ?></strong>,</p>
        <p>Thank you for registering at House of Stitches. We're thrilled to have you onboard.</p><br>
        <p><?= $msg; ?>.</p>
        
        <p>You can now explore our exclusive collection of stitching kits and designs.</p>
        
        <a class="btn" href="<?= base_url() ?>">Start Shopping</a>
        
        <p>If you have any questions, feel free to reply to this email or contact our support team.</p>
        
        <p>Happy Stitching! 🧵</p>
        
        <footer>
            House of Stitches | info@houseofstitches.in | +91 98765 43210
        </footer>
    </div>
</body>
</html>
