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
                    <a class="text-light px-2" href="<?php echo base_url('home'); ?>">Home</a> |
                    <a class="text-light px-2" href="<?php echo base_url('shopping-cart'); ?>">Cart</a> |
                    <a class="text-light px-2" href="<?php echo base_url('checkout'); ?>">Checkout</a>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="checkout_page">
    <div class="container-fluid">
        <?php
        if ($this->session->flashdata('submit_error')) {
        ?>
            <hr>
            <div class="alert alert-danger">
                <h4><span class="glyphicon glyphicon-alert"></span> <?= lang('finded_errors') ?></h4>
                <?php
                foreach ($this->session->flashdata('submit_error') as $error) {
                    echo $error . '<br>';
                }
                ?>
            </div>
            <hr>
        <?php
        }
        ?>
        <form method="post">
            <div class="row g-lg-4 g-3">
                <div class="col-lg-7">
                    <div class="checkout_info">
                        <h2 class="mb-3 title">My information</h2>
                        <?php
                        $full_name = isset(get_loggedin_user_details()->name) ? get_loggedin_user_details()->name : '';
                        $phone = isset(get_loggedin_user_details()->phone) ? get_loggedin_user_details()->phone : '';
                        $email = isset(get_loggedin_user_details()->email) ? get_loggedin_user_details()->email : '';
                        $company = isset(get_loggedin_user_details()->company) ? get_loggedin_user_details()->company : '';
                        $gst = isset(get_loggedin_user_details()->gst) ? get_loggedin_user_details()->gst : '';
                        $pan = isset(get_loggedin_user_details()->pan) ? get_loggedin_user_details()->pan : '';
                        $address = isset(get_loggedin_user_details()->address) ? get_loggedin_user_details()->address : '';
                        ?>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Full Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control rounded-0" name="first_name" id="bill_name" value="<?php echo  $full_name; ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone Number<span class="text-danger">*</span></label>
                                <input type="tel" class="form-control rounded-0" name="phone" id="bill_phone" value="<?php echo  $phone; ?>" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Email Address<span class="text-danger">*</span></label>
                                <input type="email" class="form-control rounded-0" value="<?php echo  $email; ?>" name="email" required>
                            </div>
                            <h3 class="mt-4 mb-3 title">Billing Details</h3>
                            <div class="col-md-6 col-12 mb-3">
                                <label class="form-label">Company Name</label>
                                <input type="text" class="form-control rounded-0" value="<?php echo  $company; ?>" require>
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label class="form-label">GSTIN (Optional)</label>
                                <input type="text" class="form-control rounded-0" value="<?php echo  $gst; ?>">
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label class="form-label">City<span class="text-danger">*</span></label>
                                <input type="text" class="form-control rounded-0" id="bill_city" name="city" required>
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label class="form-label">State<span class="text-danger">*</span></label>
                                <input type="text" class="form-control rounded-0" id="bill_state" required>
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label class="form-label">Pincode<span class="text-danger">*</span></label>
                                <input type="text" class="form-control rounded-0" id="bill_pincode" required>
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label class="form-label">Attachments<span class="text-danger">*</span></label>
                                <input type="file" class="form-control rounded-0" name="bank_payment_receipt">
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Full Address<span class="text-danger">*</span></label>
                                <textarea class="form-control rounded-0" rows="3" name="address" id="bill_address" value="<?php echo  $address; ?>"
                                    required><?php echo  $address; ?></textarea>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Order Notes (Optional)</label>
                                <textarea class="form-control rounded-0" rows="2"></textarea>
                            </div>
                            <h3 class="mt-4 mb-3 title">Shipping Address</h3>
                            <div class="col-12">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="sameAsBilling">
                                    <label class="form-check-label" for="sameAsBilling">
                                        Same as Billing Address
                                    </label>
                                </div>
                                <div id="shippingAddressFields" class="row">
                                    <div class="col-md-6 col-12 mb-3">
                                        <label class="form-label">Full Name<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control rounded-0" id="ship_name" required>
                                    </div>
                                    <div class="col-md-12 col-12 mb-3">
                                        <label class="form-label">Address<span class="text-danger">*</span></label>
                                        <textarea class="form-control rounded-0" rows="2" id="ship_address" required></textarea>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label class="form-label">City<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control rounded-0" id="ship_city" required>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label class="form-label">State<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control rounded-0" id="ship_state" required>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label class="form-label">Pincode<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control rounded-0" id="ship_pincode" required>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label class="form-label">Phone<span class="text-danger">*</span></label>
                                        <input type="tel" class="form-control rounded-0" id="ship_phone" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 offset-lg-1">
                    <?php
                    $dis = calculate_discount($cartItems['finalSum'], '3');
                    $gst_breakdown = calculate_gst($dis['final'], 5);
                    ?>
                    <form method="post">
                        <div class="d-flex justify-content-between mb-3">
                            <span>Order value</span>
                            <span><?php echo $cartItems['finalSum']; ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Discount (3%)</span>
                            <?php
                            $dis = calculate_discount($cartItems['finalSum'], '3');
                            ?>
                            <span><?php echo $dis['discount']; ?>/-</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Tax</span>
                            <?php
                            $gst_breakdown = calculate_gst($dis['final'], 5);
                            ?>
                            <span>Rs. <?php echo $gst_breakdown['gst_amount']; ?></span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <strong>Total</strong>
                            <strong>Rs.<?php echo $gst_breakdown['total_with_gst']; ?></strong>
                        </div>
                        <div class="payment-type-box">
                            <?php if (!empty($cashondelivery_visibility) && $cashondelivery_visibility == 1) { ?>
                                <div class="form-check mb-2">
                                    <input class="form-check-input"
                                        type="radio"
                                        name="payment_type"
                                        id="payment_cod"
                                        value="cashOnDelivery"
                                        checked>
                                    <label class="form-check-label" for="payment_cod">
                                        Cash on Delivery
                                    </label>
                                </div>
                            <?php } ?>
                            <?php if (isset($bank_account['iban']) && !empty($bank_account['iban'])) { ?>
                                <div class="form-check mb-2">
                                    <input class="form-check-input payment-type"
                                        type="radio"
                                        name="payment_type"
                                        id="bank"
                                        value="Bank">
                                    <label class="form-check-label" for="bank">
                                        Bank Transfer
                                    </label>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="terms" required>
                            <label class="form-check-label" for="terms">I agree to the <a href="#">Terms &
                                    Conditions</a><span class="text-danger">*</span></label>
                        </div>
                        <div class="mb-3">
                            <?php
                            $minDate = date('Y-m-d', strtotime('+1 day'));
                            ?>
                            <label for="dispatch_date_<?= $item['id']; ?>" class="form-label fw-bold">Dispatch Date<span class="text-danger">*</span></label>
                            <input type="date"
                                name="dispatch_date[<?= $item['id']; ?>]"
                                id="dispatch_date_<?= $item['id']; ?>"
                                class="form-control rounded-0"
                                min="<?= $minDate ?>"
                                value="<?= !empty($item['dispatch_date']) ? date('Y-m-d', strtotime($item['dispatch_date'])) : ''; ?>"
                                required>
                        </div>
                    </form>
                    <form method="post" class="mb-3">
                        <h3 class="mb-2 title">Bank Details</h3>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <span>Party Name</span>
                            <span>SPANGLE CLOTHING PRIVATE LTD</span>
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                            <span>Bank Name</span>
                            <span>AXIS BANK</span>
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                            <span>Branch Address</span>
                            <span>Sukhliya, indore</span>
                        </div>

                        <div class="d-flex justify-content-between mb-4">
                            <strong>Bank Ac/no</strong>
                            <strong>922030050559554</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                            <strong>IFSC Code</strong>
                            <strong>UTIB0002661</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                            <strong>Mob. No</strong>
                            <strong>96446-64338</strong>
                        </div>
                    </form>
                    <button type="submit" class="btn_button w-100">COMPLETE PURCHASE</button>
                    <table class="table table-bordered table-products" style="display: none;">
                        <thead>
                            <tr>
                                <th><?= lang('product') ?></th>
                                <th><?= lang('title') ?></th>
                                <th><?= lang('quantity') ?></th>
                                <th><?= lang('price') ?></th>
                                <th><?= lang('total') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cartItems['array'] as $item) { ?>
                                <tr>
                                    <td class="relative">
                                        <input type="hidden" name="id[]" value="<?= $item['id'] ?>">
                                        <input type="hidden" name="quantity[]" value="<?= $item['num_added'] ?>">

                                        <?php
                                        $productImage = base_url('/attachments/no-image-frontend.png');
                                        if (is_file('attachments/shop_images/' . $item['image'])) {
                                            $productImage = base_url('/attachments/shop_images/' . $item['image']);
                                        }
                                        ?>
                                        <img class="product-image" src="<?= $productImage ?>" alt="">

                                        <a href="<?= base_url('home/removeFromCart?delete-product=' . $item['id'] . '&back-to=checkout') ?>" class="btn btn-xs btn-danger remove-product">
                                            <span class="glyphicon glyphicon-remove"></span>
                                        </a>
                                    </td>
                                    <td><a href="<?= LANG_URL . '/' . $item['url'] ?>"><?= $item['title'] ?></a></td>
                                    <td>
                                        <a class="btn btn-xs btn-primary refresh-me add-to-cart <?= $item['quantity'] <= $item['num_added'] ? 'disabled' : '' ?>" data-id="<?= $item['id'] ?>" href="javascript:void(0);">
                                            <span class="glyphicon glyphicon-plus"></span>
                                        </a>
                                        <span class="quantity-num">
                                            <?= $item['num_added'] ?>
                                        </span>
                                        <a class="btn  btn-xs btn-danger" onclick="removeProduct(<?= $item['id'] ?>, true)" href="javascript:void(0);">
                                            <span class="glyphicon glyphicon-minus"></span>
                                        </a>
                                    </td>
                                    <td><?= $item['price'] . CURRENCY ?></td>
                                    <td><?= $item['sum_price'] . CURRENCY ?></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="4" class="text-right"><?= lang('total') ?></td>
                                <td>
                                    <span class="final-amount"><?= $cartItems['finalSum'] ?></span><?= CURRENCY ?>
                                    <input type="hidden" class="final-amount" name="final_amount" value="<?= $cartItems['finalSum'] ?>">
                                    <input type="hidden" name="amount_currency" value="<?= CURRENCY ?>">
                                    <input type="hidden" name="discountAmount" value="">
                                </td>
                            </tr>
                            <?php
                            $total_parsed = str_replace(' ', '', str_replace(',', '', $cartItems['finalSum']));
                            if ((int)$shippingAmount > 0 && ((int)$shippingOrder > $total_parsed)) {
                            ?>
                                <tr>
                                    <td colspan="4" class="text-right"><?= lang('shipping') ?></td>
                                    <td>
                                        <span class="final-amount"><?= (int)$shippingAmount ?></span><?= CURRENCY ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
        </form>
    </div>
</div>
<script>
    document.getElementById('dispatch_date_<?= $item['id']; ?>').addEventListener('change', function() {
        const selected = new Date(this.value);
        const min = new Date();
        min.setDate(min.getDate() + 1);
        min.setHours(0, 0, 0, 0);

        if (selected < min) {
            alert('Please select a future date');
            this.value = '';
        }
    });
</script>

<script>
    const checkbox = document.getElementById('sameAsBilling');
    const fields = ['name', 'phone', 'address', 'city', 'state', 'pincode'];

    checkbox.addEventListener('change', () => {
        if (!checkbox.checked) return;

        fields.forEach(field => {
            const billField = document.getElementById('bill_' + field);
            const shipField = document.getElementById('ship_' + field);
            if (billField && shipField) {
                shipField.value = billField.value;
            }
        });
    });
</script>


<?php include("footer.php") ?>