<title>Checkout | House of Stitches – Wholesale Kidswear Orders</title>
<meta name="description"
    content="Complete your wholesale kidswear order with secure checkout. Provide billing, shipping, and GSTIN details.">
<meta name="keywords"
    content="checkout, wholesale kidswear checkout, bulk order kidswear, kids clothing wholesale India">
<?php include("header.php") ?>

<div class="account_header bg-dark py-4">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center text-white">
                <h1 class="h2_heading text-white">Checkout</h1>
                <nav class="mt-2">
                    <a class="text-light px-2" href="index.php">Home</a> |
                    <a class="text-light px-2" href="cart.php">Cart</a> |
                    <a class="text-light px-2" href="checkout.php">Checkout</a>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="checkout_page py-lg-5 py-2">
    <div class="container">
        <form>
            <div class="row gy-4">
                <div class="col-lg-7">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="mb-4 title">Billing & Shipping Information</h2>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" class="form-control" placeholder="John Doe" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" placeholder="+91 9876543210" required>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">Email Address</label>
                                    <input type="email" class="form-control" placeholder="email@example.com">
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">Company Name</label>
                                    <input type="text" class="form-control" placeholder="Company or Store Name">
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">GSTIN (Optional)</label>
                                    <input type="text" class="form-control" placeholder="22AAAAA0000A1Z5">
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">Full Address</label>
                                    <textarea class="form-control" rows="3" placeholder="Flat No, Street, Locality"
                                        required></textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">City</label>
                                    <input type="text" class="form-control" placeholder="City" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">State</label>
                                    <input type="text" class="form-control" placeholder="State" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Pincode</label>
                                    <input type="text" class="form-control" placeholder="123456" required>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">Order Notes (Optional)</label>
                                    <textarea class="form-control" rows="2"
                                        placeholder="Any special instructions..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h3 class="mb-4 title">Order Summary</h3>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal</span>
                                <span>₹14,970</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Shipping</span>
                                <span>₹500</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>GST (5%)</span>
                                <span>₹748.50</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-4">
                                <strong>Total</strong>
                                <strong>₹16,218.50</strong>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="terms" required>
                                <label class="form-check-label" for="terms">I agree to the <a href="#">Terms &
                                        Conditions</a></label>
                            </div>
                            <a type="submit" class="btn btn-dark w-100">Place Wholesale Order</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include("footer.php") ?>