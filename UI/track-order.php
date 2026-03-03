<title>Track Your Order | House of Stitches Wholesale Kidswear</title>
<meta name="description"
    content="Track your House of Stitches order using your Order ID and registered contact. Stay updated on shipping and delivery status.">
<meta name="keywords"
    content="House of Stitches, order tracking, track order, kidswear order, order status, delivery status, shipping tracking">
<?php include("header.php") ?>

<div class="account_header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 px-0">
                <h1 class="h2_heading text-light">Track Your Order</h1>
            </div>
        </div>
    </div>
</div>

<div class="terms_seaction">
    <div class="container">
        <div class="row g-3 justify-content-center">
            <div class="col-lg-7 col-md-8 col-sm-10 col-12">
                <h2 class="text-center mb-4 fs-6">Enter your Order ID and the registered email or phone number to check the
                    status of your wholesale kidswear order.</h2>
                <div class="trackbox">
                    <form>
                        <div class="mb-3">
                            <label for="orderID" class="form-label">Order ID:</label>
                            <input type="text" class="form-control" placeholder="HS12345" required>
                        </div>
                        <div class="mb-3">
                            <label for="contactInfo" class="form-label">Registered Email or Phone:</label>
                            <input type="text" class="form-control" placeholder="john@example.com" required>
                        </div>
                        <a type="submit" class="btn btn-primary w-100">Track Order</a>
                    </form>
                </div>
                <h3 class="mt-3 text-center text-small text-muted fs-6">
                    Need help? <a href="https://wa.me/yourwhatsappnumber" target="_blank">Contact us on WhatsApp</a>
                </h3>
                <div class="mt-5">
                    <h4 class="mb-3 title">Example Tracking Status</h4>
                    <div class="trackbox">
                        <p><strong>Order ID:</strong> HS12345</p>
                        <p><strong>Status:</strong> In Transit</p>
                        <p><strong>Courier:</strong> Blue Dart</p>
                        <p><strong>Estimated Delivery:</strong> October 4, 2025</p>
                        <p><strong>Tracking Link:</strong> <a href="#" target="_blank">Track Shipment</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("footer.php") ?>