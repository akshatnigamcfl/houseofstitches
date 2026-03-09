<title>Checkout | House of Stitches – Wholesale Kidswear Orders</title>
<meta name="description" content="Complete your wholesale kidswear order with secure checkout. Provide billing, shipping, and GSTIN details.">
<meta name="keywords" content="checkout, wholesale kidswear checkout, bulk order kidswear, kids clothing wholesale India">
<?php include("header.php") ?>

<?php
$tax     = get_tax_breakdown($cartItems['finalSum']);
$user    = get_loggedin_user_details();
$full_name = $user->name    ?? '';
$phone     = $user->phone   ?? '';
$email     = $user->email   ?? '';
$company   = $user->company ?? '';
$gst       = $user->gst     ?? '';
$address   = $user->address ?? '';
$minDate   = date('Y-m-d', strtotime('+1 day'));
?>

<style>
.checkout-steps { display:flex; align-items:center; justify-content:center; gap:0; margin-bottom:2.5rem; }
.step-item { display:flex; flex-direction:column; align-items:center; position:relative; }
.step-circle { width:40px; height:40px; border-radius:50%; border:2px solid #dee2e6; background:#fff; display:flex; align-items:center; justify-content:center; font-weight:600; font-size:.95rem; color:#adb5bd; transition:.3s; }
.step-item.active .step-circle  { border-color:#111; background:#111; color:#fff; }
.step-item.done   .step-circle  { border-color:#198754; background:#198754; color:#fff; }
.step-label { font-size:.75rem; margin-top:.35rem; color:#adb5bd; font-weight:500; }
.step-item.active .step-label,
.step-item.done   .step-label   { color:#111; }
.step-line { flex:1; height:2px; background:#dee2e6; min-width:60px; max-width:120px; margin-bottom:1.4rem; transition:.3s; }
.step-line.done { background:#198754; }

.checkout-panel { display:none; }
.checkout-panel.active { display:block; }

.checkout-wrap { max-width:960px; margin:0 auto; }
.co-card { background:#fff; border:1px solid #e9ecef; border-radius:12px; padding:1.75rem; margin-bottom:1.25rem; }
.co-card h5 { font-size:1rem; font-weight:700; margin-bottom:1.25rem; padding-bottom:.75rem; border-bottom:1px solid #f0f0f0; }

/* summary sidebar */
.order-summary-sticky { position:sticky; top:1.5rem; }
.summary-item-row { display:flex; align-items:center; gap:.75rem; padding:.6rem 0; border-bottom:1px solid #f5f5f5; }
.summary-item-row:last-child { border-bottom:none; }
.summary-item-img { width:52px; height:52px; object-fit:cover; border-radius:6px; flex-shrink:0; background:#f8f9fa; }
.summary-item-title { font-size:.85rem; font-weight:600; line-height:1.3; }
.summary-item-meta  { font-size:.78rem; color:#6c757d; }

.coupon-applied { background:#d1e7dd; border-radius:8px; padding:.6rem 1rem; font-size:.85rem; color:#0a3622; }

.payment-option { border:2px solid #e9ecef; border-radius:10px; padding:1rem 1.25rem; cursor:pointer; transition:.2s; margin-bottom:.75rem; }
.payment-option:has(input:checked) { border-color:#111; background:#fafafa; }
.payment-option label { cursor:pointer; margin:0; font-weight:600; }

.bank-info-grid { display:grid; grid-template-columns:1fr 1fr; gap:.5rem .75rem; font-size:.85rem; }
.bank-info-grid dt { color:#6c757d; }
.bank-info-grid dd { font-weight:600; margin:0; }

.overview-row { display:flex; justify-content:space-between; padding:.45rem 0; font-size:.9rem; }
.overview-row.total { font-size:1.05rem; font-weight:700; border-top:2px solid #111; padding-top:.75rem; margin-top:.25rem; }

/* step-nav buttons */
.btn-next { background:#111; color:#fff; border:none; padding:.65rem 2rem; border-radius:8px; font-weight:600; }
.btn-next:hover { background:#333; color:#fff; }
.btn-back { background:transparent; border:1.5px solid #dee2e6; padding:.65rem 1.5rem; border-radius:8px; font-weight:600; color:#555; }
.btn-back:hover { border-color:#aaa; }
.btn-place { background:#111; color:#fff; border:none; padding:.8rem 2.5rem; border-radius:8px; font-weight:700; font-size:1rem; width:100%; }
.btn-place:hover { background:#333; color:#fff; }

/* address option cards */
.addr-option { border:2px solid #e9ecef; border-radius:10px; padding:1rem 1.25rem; cursor:pointer; transition:.2s; }
.addr-option.selected { border-color:#111; background:#fafafa; }
.addr-option:hover:not(.selected) { border-color:#adb5bd; }
.addr-radio svg { color:#dee2e6; transition:.2s; }
.addr-option.selected .addr-radio svg { color:#111; }
</style>

<div class="account_header bg-dark py-4">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center text-white">
                <h1 class="h2_heading text-white">Checkout</h1>
                <!-- <nav class="mt-2">
                    <a class="text-light px-2" href="<?= base_url('home') ?>">Home</a> |
                    <a class="text-light px-2" href="<?= base_url('shopping-cart') ?>">Cart</a> |
                    <a class="text-light px-2" href="<?= base_url('checkout') ?>">Checkout</a>
                </nav> -->
            </div>
        </div>
    </div>
</div>

<div class="checkout_page py-5">
    <div class="container checkout-wrap">

        <?php if ($this->session->flashdata('submit_error')): ?>
        <div class="alert alert-danger mb-4">
            <?php foreach ($this->session->flashdata('submit_error') as $err): ?>
                <div><?= $err ?></div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- Step Indicator -->
        <div class="checkout-steps">
            <div class="step-item active" id="si-1">
                <div class="step-circle" id="sc-1">1</div>
                <div class="step-label">Address</div>
            </div>
            <div class="step-line" id="sl-1"></div>
            <div class="step-item" id="si-2">
                <div class="step-circle" id="sc-2">2</div>
                <div class="step-label">Payment</div>
            </div>
            <div class="step-line" id="sl-2"></div>
            <div class="step-item" id="si-3">
                <div class="step-circle" id="sc-3">3</div>
                <div class="step-label">Overview</div>
            </div>
        </div>

        <form method="post" enctype="multipart/form-data" id="checkoutForm">
            <input type="hidden" name="submit_token" value="<?= $submit_token ?>">
            <input type="hidden" name="discountCode"   id="h_discount_code">
            <input type="hidden" name="discountAmount"  id="h_discount_amount" value="0">
            <input type="hidden" name="final_amount"    id="h_final_amount"    value="<?= htmlspecialchars($cartItems['finalSum']) ?>">
            <input type="hidden" name="amount_currency" value="<?= CURRENCY ?>">
            <?php foreach ($cartItems['array'] as $item): ?>
                <input type="hidden" name="id[]"       value="<?= $item['product_id'] ?>">
                <input type="hidden" name="quantity[]" value="<?= $item['num_added'] ?>">
            <?php endforeach; ?>

            <div class="row g-4">
                <!-- LEFT COLUMN: steps -->
                <div class="col-lg-8">

                    <!-- ── STEP 1: ADDRESS ── -->
                    <div class="checkout-panel active" id="step-1">

                        <?php $hasSavedAddresses = !empty($user_addresses); ?>

                        <!-- Saved addresses list -->
                        <div class="co-card" id="addressChoiceCard">
                            <h5>Delivery Address</h5>

                            <?php if ($hasSavedAddresses): ?>
                                <?php foreach ($user_addresses as $idx => $ua): ?>
                                <div class="addr-option <?= $idx === 0 ? 'selected' : '' ?> co-addr-saved"
                                    data-idx="<?= $idx ?>"
                                    data-name="<?= htmlspecialchars($ua->name) ?>"
                                    data-phone="<?= htmlspecialchars($ua->phone) ?>"
                                    data-email="<?= htmlspecialchars($email) ?>"
                                    data-company="<?= htmlspecialchars($ua->company) ?>"
                                    data-gst="<?= htmlspecialchars($ua->gst) ?>"
                                    data-address="<?= htmlspecialchars($ua->address) ?>"
                                    onclick="selectSavedAddress(this)">
                                    <div class="d-flex align-items-start gap-3">
                                        <div class="addr-radio">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                <circle cx="8" cy="8" r="4" class="co-addr-dot" <?= $idx !== 0 ? 'style="display:none"' : '' ?>/>
                                            </svg>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="fw-semibold">
                                                <?= htmlspecialchars($ua->name) ?>
                                                <?php if (!empty($ua->label)): ?>
                                                <span class="text-muted fw-normal small"> — <?= htmlspecialchars($ua->label) ?></span>
                                                <?php endif; ?>
                                                <?php if ($ua->is_default): ?>
                                                <span class="badge bg-success ms-1" style="font-size:.65rem;">Default</span>
                                                <?php endif; ?>
                                            </div>
                                            <?php if (!empty($ua->company)): ?>
                                            <div class="text-muted small"><?= htmlspecialchars($ua->company) ?><?php if (!empty($ua->gst)): ?> · GST: <?= htmlspecialchars($ua->gst) ?><?php endif; ?></div>
                                            <?php endif; ?>
                                            <div class="text-muted small mt-1"><?= nl2br(htmlspecialchars($ua->address)) ?></div>
                                            <?php if (!empty($ua->phone)): ?>
                                            <div class="small mt-1"><i class="bi bi-telephone me-1"></i><?= htmlspecialchars($ua->phone) ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <!-- Fallback: single address from users_public -->
                                <?php $hasFallback = !empty($address) || !empty($full_name); ?>
                                <?php if ($hasFallback): ?>
                                <div class="addr-option selected co-addr-saved"
                                    data-idx="0"
                                    data-name="<?= htmlspecialchars($full_name) ?>"
                                    data-phone="<?= htmlspecialchars($phone) ?>"
                                    data-email="<?= htmlspecialchars($email) ?>"
                                    data-company="<?= htmlspecialchars($company) ?>"
                                    data-gst="<?= htmlspecialchars($gst) ?>"
                                    data-address="<?= htmlspecialchars($address) ?>"
                                    onclick="selectSavedAddress(this)">
                                    <div class="d-flex align-items-start gap-3">
                                        <div class="addr-radio">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                <circle cx="8" cy="8" r="4" class="co-addr-dot"/>
                                            </svg>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="fw-semibold"><?= htmlspecialchars($full_name) ?>
                                                <?php if (!empty($company)): ?>
                                                <span class="text-muted fw-normal"> — <?= htmlspecialchars($company) ?></span>
                                                <?php endif; ?>
                                                <span class="badge bg-success ms-1" style="font-size:.65rem;">Saved</span>
                                            </div>
                                            <div class="text-muted small mt-1"><?= nl2br(htmlspecialchars($address)) ?></div>
                                            <?php if (!empty($phone)): ?>
                                            <div class="small mt-1"><i class="bi bi-telephone me-1"></i><?= htmlspecialchars($phone) ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                            <?php endif; ?>

                            <!-- Use a different address -->
                            <div class="addr-option mt-2 <?= (!$hasSavedAddresses && empty($address) && empty($full_name)) ? 'selected' : '' ?>"
                                id="addrNew" onclick="selectAddress('new')">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="addr-radio">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                            <circle cx="8" cy="8" r="4" id="addrDotNew" style="display:none"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">Use a different address</div>
                                        <div class="text-muted small">Enter a one-time delivery address</div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <a href="<?= base_url('home/account#addresses') ?>" target="_blank" class="small text-primary">
                                    <i class="bi bi-plus-circle me-1"></i>Manage saved addresses →
                                </a>
                            </div>
                        </div>

                        <!-- Manual address form (hidden by default when saved address exists) -->
                        <?php $showManual = (!$hasSavedAddresses && empty($address) && empty($full_name)); ?>
                        <div id="manualAddressForm" <?= !$showManual ? 'style="display:none;"' : '' ?>>
                            <div class="co-card">
                                <h5>Enter Delivery Address</h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label small">Contact Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="f_name_manual" placeholder="Full name">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small">Phone <span class="text-danger">*</span></label>
                                        <input type="tel" class="form-control" id="f_phone_manual" placeholder="+91 9876543210">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="f_email_manual" placeholder="your@email.com">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small">Company Name</label>
                                        <input type="text" class="form-control" id="f_company_manual" placeholder="Your company">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small">GST Number</label>
                                        <input type="text" class="form-control" id="f_gst_manual" placeholder="22AAAAA0000A1Z5">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small">City</label>
                                        <input type="text" class="form-control" id="f_city_manual" placeholder="City">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label small">Full Address <span class="text-danger">*</span></label>
                                        <textarea class="form-control" rows="3" id="f_address_manual" placeholder="Street, area, landmark…"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden fields actually submitted -->
                        <input type="hidden" name="first_name" id="f_name">
                        <input type="hidden" name="phone"      id="f_phone">
                        <input type="hidden" name="email"      id="f_email">
                        <input type="hidden" name="company"    id="f_company">
                        <input type="hidden" name="gst"        id="f_gst">
                        <input type="hidden" name="city"       id="f_city">
                        <input type="hidden" name="state"      id="f_state">
                        <input type="hidden" name="post_code"  id="f_pincode">
                        <input type="hidden" name="address"    id="f_address">

                        <div class="co-card">
                            <label class="form-label small">Order Notes (Optional)</label>
                            <textarea class="form-control" rows="2" name="notes" placeholder="Any special instructions…"></textarea>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn-next" onclick="goStep(2)">Continue to Payment →</button>
                        </div>
                    </div><!-- /step-1 -->

                    <!-- ── STEP 2: PAYMENT ── -->
                    <div class="checkout-panel" id="step-2">
                        <div class="co-card">
                            <h5>Apply Coupon</h5>
                            <div class="input-group">
                                <input type="text" class="form-control" id="couponInput" placeholder="Enter coupon code">
                                <button type="button" class="btn btn-dark" id="applyCouponBtn">Apply</button>
                            </div>
                            <div id="couponMsg" class="mt-2"></div>
                        </div>

                        <div class="co-card">
                            <h5>Payment Method</h5>
                            <?php if (!empty($cashondelivery_visibility) && $cashondelivery_visibility == 1): ?>
                            <div class="payment-option">
                                <div class="d-flex align-items-center gap-3">
                                    <input class="form-check-input m-0" type="radio" name="payment_type" id="pay_cod" value="cashOnDelivery" checked>
                                    <label for="pay_cod">
                                        <div>Cash on Delivery</div>
                                        <div class="text-muted" style="font-size:.8rem;font-weight:400;">Pay when you receive your order</div>
                                    </label>
                                </div>
                            </div>
                            <?php endif; ?>
                            <?php if (isset($bank_account['iban']) && !empty($bank_account['iban'])): ?>
                            <div class="payment-option">
                                <div class="d-flex align-items-center gap-3">
                                    <input class="form-check-input m-0" type="radio" name="payment_type" id="pay_bank" value="Bank">
                                    <label for="pay_bank">
                                        <div>Bank Transfer</div>
                                        <div class="text-muted" style="font-size:.8rem;font-weight:400;">Transfer directly to our bank account</div>
                                    </label>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="co-card">
                            <h5>Order Details</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small">Dispatch Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="dispatch_date" id="dispatch_date" min="<?= $minDate ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small">Payment Receipt (Attachment)</label>
                                    <input type="file" class="form-control" name="bank_payment_receipt">
                                </div>
                            </div>
                        </div>

                        <div class="co-card">
                            <h5>Bank Details</h5>
                            <dl class="bank-info-grid">
                                <dt>Party Name</dt>   <dd>SPANGLE CLOTHING PRIVATE LTD</dd>
                                <dt>Bank Name</dt>    <dd>AXIS BANK</dd>
                                <dt>Branch</dt>       <dd>Sukhliya, Indore</dd>
                                <dt>Account No.</dt>  <dd>922030050559554</dd>
                                <dt>IFSC Code</dt>    <dd>UTIB0002661</dd>
                                <dt>Mobile</dt>       <dd>96446-64338</dd>
                            </dl>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn-back" onclick="goStep(1)">← Back</button>
                            <button type="button" class="btn-next" onclick="goStep(3)">Review Order →</button>
                        </div>
                    </div><!-- /step-2 -->

                    <!-- ── STEP 3: OVERVIEW ── -->
                    <div class="checkout-panel" id="step-3">
                        <div class="co-card">
                            <h5>Order Items</h5>
                            <?php foreach ($cartItems['array'] as $item):
                                $img = base_url('/attachments/no-image-frontend.png');
                                if (is_file('attachments/shop_images/' . $item['image'])) {
                                    $img = base_url('/attachments/shop_images/' . $item['image']);
                                }
                            ?>
                            <div class="summary-item-row">
                                <img src="<?= $img ?>" class="summary-item-img" alt="">
                                <div class="flex-grow-1">
                                    <div class="summary-item-title"><?= htmlspecialchars($item['title']) ?></div>
                                    <div class="summary-item-meta">Qty: <?= $item['num_added'] ?></div>
                                </div>
                                <div class="fw-semibold" style="font-size:.9rem;"><?= $item['sum_price'] . CURRENCY ?></div>
                            </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="co-card">
                            <h5>Summary</h5>
                            <div class="overview-row">
                                <span>Subtotal</span>
                                <span>Rs. <?= number_format($tax['base'], 2) ?></span>
                            </div>
                            <div class="overview-row" id="ov-discount-row" style="display:none!important;">
                                <span>Coupon Discount (<span id="ov-code"></span>)</span>
                                <span class="text-success">− Rs. <span id="ov-discount">0.00</span></span>
                            </div>
                            <?php if ($tax['enabled'] && $tax['rate'] > 0): ?>
                            <div class="overview-row">
                                <span>Tax (<?= $tax['rate'] ?>%)</span>
                                <span>Rs. <?= number_format($tax['tax_amount'], 2) ?></span>
                            </div>
                            <?php endif; ?>
                            <div class="overview-row total">
                                <span>Total</span>
                                <span id="ov-total">Rs. <?= number_format($tax['total'], 2) ?></span>
                            </div>
                        </div>

                        <div class="co-card">
                            <h5>Delivery Address</h5>
                            <p class="mb-1 fw-semibold" id="ov-name"></p>
                            <p class="mb-0 text-muted" id="ov-address"></p>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="terms" required>
                            <label class="form-check-label" for="terms">I agree to the <a href="#">Terms & Conditions</a> <span class="text-danger">*</span></label>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <button type="button" class="btn-back" onclick="goStep(2)">← Back</button>
                            <button type="button" class="btn-place" id="checkout-submit-btn" onclick="placeOrder(this)">
                                Place Order
                            </button>
                        </div>
                    </div><!-- /step-3 -->

                </div><!-- /col-lg-8 -->

                <!-- RIGHT COLUMN: order summary (visible all steps) -->
                <div class="col-lg-4">
                    <div class="order-summary-sticky">
                        <div class="co-card">
                            <h5>Your Order</h5>
                            <?php foreach ($cartItems['array'] as $item):
                                $img = base_url('/attachments/no-image-frontend.png');
                                if (is_file('attachments/shop_images/' . $item['image'])) {
                                    $img = base_url('/attachments/shop_images/' . $item['image']);
                                }
                            ?>
                            <div class="summary-item-row">
                                <img src="<?= $img ?>" class="summary-item-img" alt="">
                                <div class="flex-grow-1">
                                    <div class="summary-item-title"><?= htmlspecialchars($item['title']) ?></div>
                                    <div class="summary-item-meta">Qty: <?= $item['num_added'] ?> × <?= $item['price'] . CURRENCY ?></div>
                                </div>
                            </div>
                            <?php endforeach; ?>

                            <div class="mt-3 pt-2 border-top">
                                <div class="overview-row">
                                    <span class="text-muted">Order Value</span>
                                    <span>Rs. <?= number_format($tax['base'], 2) ?></span>
                                </div>
                                <div class="overview-row" id="sb-discount-row" style="display:none!important;">
                                    <span class="text-muted">Discount</span>
                                    <span class="text-success">− Rs. <span id="sb-discount">0.00</span></span>
                                </div>
                                <?php if ($tax['enabled'] && $tax['rate'] > 0): ?>
                                <div class="overview-row">
                                    <span class="text-muted">Tax (<?= $tax['rate'] ?>%)</span>
                                    <span>Rs. <?= number_format($tax['tax_amount'], 2) ?></span>
                                </div>
                                <?php endif; ?>
                                <div class="overview-row total">
                                    <span>Total</span>
                                    <span id="sb-total">Rs. <?= number_format($tax['total'], 2) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /row -->
        </form>
    </div>
</div>

<script>
var CO = {
    currentStep:  1,
    baseTotal:    <?= $tax['total'] ?>,
    discount:     0,
    discountCode: '',
    addrMode:     '<?= ($hasSavedAddresses || (!empty($address) || !empty($full_name))) ? 'saved' : 'new' ?>',
    saved: {
        name:    '',
        phone:   '',
        email:   <?= json_encode($email) ?>,
        company: '',
        gst:     '',
        address: '',
        city:    ''
    }
};

// Read the first selected saved card on page load
(function () {
    var firstCard = document.querySelector('.co-addr-saved.selected');
    if (firstCard) {
        CO.saved.name    = firstCard.dataset.name    || '';
        CO.saved.phone   = firstCard.dataset.phone   || '';
        CO.saved.email   = firstCard.dataset.email   || CO.saved.email;
        CO.saved.company = firstCard.dataset.company || '';
        CO.saved.gst     = firstCard.dataset.gst     || '';
        CO.saved.address = firstCard.dataset.address || '';
    }
})();

// Select one of the saved address cards
function selectSavedAddress(el) {
    CO.addrMode = 'saved';
    // Deselect all saved cards + new option
    document.querySelectorAll('.co-addr-saved').forEach(function (c) {
        c.classList.remove('selected');
        var dot = c.querySelector('.co-addr-dot');
        if (dot) dot.style.display = 'none';
    });
    document.getElementById('addrNew').classList.remove('selected');
    document.getElementById('addrDotNew').style.display = 'none';
    // Select this card
    el.classList.add('selected');
    var dot = el.querySelector('.co-addr-dot');
    if (dot) dot.style.display = '';
    // Update hidden manual form visibility
    document.getElementById('manualAddressForm').style.display = 'none';
    // Update CO.saved from data attributes
    CO.saved.name    = el.dataset.name    || '';
    CO.saved.phone   = el.dataset.phone   || '';
    CO.saved.email   = el.dataset.email   || CO.saved.email;
    CO.saved.company = el.dataset.company || '';
    CO.saved.gst     = el.dataset.gst     || '';
    CO.saved.address = el.dataset.address || '';
}

// Populate hidden fields from saved address
function fillHiddenFromSaved() {
    document.getElementById('f_name').value    = CO.saved.name;
    document.getElementById('f_phone').value   = CO.saved.phone;
    document.getElementById('f_email').value   = CO.saved.email;
    document.getElementById('f_company').value = CO.saved.company;
    document.getElementById('f_gst').value     = CO.saved.gst;
    document.getElementById('f_address').value = CO.saved.address;
    document.getElementById('f_city').value    = CO.saved.city || '';
    document.getElementById('f_state').value   = '';
    document.getElementById('f_pincode').value = '';
}

// Populate hidden fields from manual form inputs
function fillHiddenFromManual() {
    document.getElementById('f_name').value    = document.getElementById('f_name_manual').value;
    document.getElementById('f_phone').value   = document.getElementById('f_phone_manual').value;
    document.getElementById('f_email').value   = document.getElementById('f_email_manual').value;
    document.getElementById('f_company').value = document.getElementById('f_company_manual').value;
    document.getElementById('f_gst').value     = document.getElementById('f_gst_manual').value;
    document.getElementById('f_city').value    = document.getElementById('f_city_manual').value;
    document.getElementById('f_address').value = document.getElementById('f_address_manual').value;
}

function selectAddress(mode) {
    CO.addrMode = mode;
    var newCard    = document.getElementById('addrNew');
    var manualForm = document.getElementById('manualAddressForm');
    var dotNew     = document.getElementById('addrDotNew');

    if (mode === 'new') {
        // Deselect all saved cards
        document.querySelectorAll('.co-addr-saved').forEach(function (c) {
            c.classList.remove('selected');
            var dot = c.querySelector('.co-addr-dot');
            if (dot) dot.style.display = 'none';
        });
        newCard  && newCard.classList.add('selected');
        dotNew   && (dotNew.style.display = '');
        manualForm && (manualForm.style.display = '');
    }
}

// Pre-fill hidden fields on page load if a saved address is selected
if (CO.addrMode === 'saved') fillHiddenFromSaved();

function goStep(n) {
    if (n > CO.currentStep && !validateStep(CO.currentStep)) return;

    // Update panels
    document.querySelectorAll('.checkout-panel').forEach(function(p) { p.classList.remove('active'); });
    document.getElementById('step-' + n).classList.add('active');

    // Update step indicators
    for (var i = 1; i <= 3; i++) {
        var si = document.getElementById('si-' + i);
        si.classList.remove('active', 'done');
        var sc = document.getElementById('sc-' + i);
        if (i < n) {
            si.classList.add('done');
            sc.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M13.485 1.431a1.473 1.473 0 0 1 2.104 2.062l-7.84 9.801a1.473 1.473 0 0 1-2.12.04L.875 9.232a1.473 1.473 0 1 1 2.084-2.083l4.111 4.112 6.921-9.86a.486.486 0 0 1 .014-.02z"/></svg>';
        } else if (i === n) {
            si.classList.add('active');
            sc.textContent = i;
        } else {
            sc.textContent = i;
        }
    }

    // Step lines
    for (var j = 1; j <= 2; j++) {
        var sl = document.getElementById('sl-' + j);
        sl.classList.toggle('done', j < n);
    }

    // Populate overview when going to step 3
    if (n === 3) populateOverview();

    CO.currentStep = n;
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function validateStep(step) {
    if (step === 1) {
        if (CO.addrMode === 'new') {
            var name    = document.getElementById('f_name_manual').value.trim();
            var phone   = document.getElementById('f_phone_manual').value.trim();
            var email   = document.getElementById('f_email_manual').value.trim();
            var address = document.getElementById('f_address_manual').value.trim();
            if (!name)    { alert('Please enter your full name.');           return false; }
            if (!phone)   { alert('Please enter your phone number.');        return false; }
            if (!email || !email.includes('@')) { alert('Please enter a valid email.'); return false; }
            if (!address) { alert('Please enter your address.');             return false; }
            fillHiddenFromManual();
        } else {
            // Saved address — check it has at least a name and address
            if (!CO.saved.name)    { alert('The selected address is missing a name. Please edit it in My Account.'); return false; }
            if (!CO.saved.address) { alert('The selected address has no address text. Please edit it in My Account.'); return false; }
            fillHiddenFromSaved();
        }
    }
    if (step === 2) {
        var payChecked = document.querySelector('[name="payment_type"]:checked');
        if (!payChecked) { alert('Please select a payment method.'); return false; }
        var dispatchDate = document.querySelector('[name="dispatch_date"]').value;
        if (!dispatchDate) { alert('Please select a dispatch date.'); return false; }
    }
    return true;
}

function populateOverview() {
    document.getElementById('ov-name').textContent    = document.querySelector('[name="first_name"]').value;
    document.getElementById('ov-address').textContent =
        document.querySelector('[name="address"]').value + ', ' +
        document.querySelector('[name="city"]').value;
    updateTotals();
}

function updateTotals() {
    var after = CO.baseTotal - CO.discount;
    if (after < 0) after = 0;

    var fmt = 'Rs. ' + after.toFixed(2);
    document.getElementById('sb-total').textContent = fmt;

    var ovTotal = document.getElementById('ov-total');
    if (ovTotal) ovTotal.textContent = fmt;

    document.getElementById('h_final_amount').value = after.toFixed(2);
    document.getElementById('h_discount_amount').value = CO.discount.toFixed(2);
    document.getElementById('h_discount_code').value   = CO.discountCode;

    // Show/hide discount rows
    var show = CO.discount > 0;
    ['sb-discount-row', 'ov-discount-row'].forEach(function(id) {
        var el = document.getElementById(id);
        if (el) el.style.setProperty('display', show ? 'flex' : 'none', 'important');
    });
    ['sb-discount', 'ov-discount'].forEach(function(id) {
        var el = document.getElementById(id);
        if (el) el.textContent = CO.discount.toFixed(2);
    });
    if (document.getElementById('ov-code')) {
        document.getElementById('ov-code').textContent = CO.discountCode;
    }
}

// Coupon
document.getElementById('applyCouponBtn').addEventListener('click', function () {
    var code = document.getElementById('couponInput').value.trim();
    var msg  = document.getElementById('couponMsg');
    if (!code) { msg.innerHTML = '<span class="text-danger small">Please enter a coupon code.</span>'; return; }

    fetch('<?= base_url('discountCodeChecker') ?>', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest' },
        body: 'enteredCode=' + encodeURIComponent(code)
    })
    .then(function(r) { return r.text(); })
    .then(function(res) {
        if (res === '0' || res === '') {
            msg.innerHTML = '<span class="text-danger small">Invalid or expired coupon code.</span>';
            CO.discount = 0; CO.discountCode = '';
        } else {
            var data = JSON.parse(res);
            if (data.type === 'percent') {
                CO.discount = CO.baseTotal * parseFloat(data.amount) / 100;
            } else {
                CO.discount = parseFloat(data.amount);
            }
            CO.discountCode = code;
            msg.innerHTML = '<div class="coupon-applied mt-1">✓ Coupon <strong>' + code + '</strong> applied — Rs. ' + CO.discount.toFixed(2) + ' off</div>';
        }
        updateTotals();
    })
    .catch(function() {
        msg.innerHTML = '<span class="text-danger small">Could not verify coupon. Try again.</span>';
    });
});

// Place order
function placeOrder(btn) {
    if (!document.getElementById('terms').checked) {
        alert('Please accept the Terms & Conditions.');
        return;
    }
    btn.disabled = true;
    btn.textContent = 'Placing Order…';
    document.getElementById('checkoutForm').submit();
}

// Dispatch date validation
document.getElementById('dispatch_date').addEventListener('change', function () {
    var sel = new Date(this.value), min = new Date();
    min.setDate(min.getDate() + 1); min.setHours(0,0,0,0);
    if (sel < min) { alert('Please select a future date.'); this.value = ''; }
});
</script>

<?php include("footer.php") ?>
