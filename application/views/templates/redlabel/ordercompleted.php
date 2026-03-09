<title>Order Confirmed | House of Stitches</title>
<meta name="description" content="Your order has been placed successfully at House of Stitches.">

<style>
.oc-wrap { max-width: 760px; margin: 0 auto; }

/* success banner */
.oc-banner { background: linear-gradient(135deg, #111 0%, #2d2d2d 100%); border-radius: 16px; padding: 2.5rem 2rem; text-align: center; color: #fff; margin-bottom: 1.5rem; }
.oc-check { width: 64px; height: 64px; background: #22c55e; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem; animation: popIn .4s cubic-bezier(.175,.885,.32,1.275) both; }
.oc-check svg { width: 32px; height: 32px; }
@keyframes popIn { from { transform: scale(0); opacity: 0; } to { transform: scale(1); opacity: 1; } }
.oc-banner h2 { font-size: 1.5rem; font-weight: 700; margin-bottom: .35rem; }
.oc-banner p  { font-size: .9rem; color: rgba(255,255,255,.7); margin: 0; }
.oc-order-num { display: inline-block; background: rgba(255,255,255,.12); border-radius: 20px; padding: .3rem 1rem; font-size: .85rem; font-weight: 600; margin-top: .75rem; letter-spacing: .5px; }

/* cards */
.oc-card { background: #fff; border: 1px solid #e9ecef; border-radius: 12px; padding: 1.5rem; margin-bottom: 1.25rem; }
.oc-card-title { font-size: .8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #6c757d; margin-bottom: 1rem; }

/* info grid */
.oc-info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: .6rem 1.5rem; font-size: .88rem; }
.oc-info-grid dt { color: #6c757d; font-weight: 400; }
.oc-info-grid dd { font-weight: 600; margin: 0; }
@media (max-width: 576px) { .oc-info-grid { grid-template-columns: 1fr; } }

/* product rows */
.oc-product-row { display: flex; align-items: center; gap: 1rem; padding: .75rem 0; border-bottom: 1px solid #f5f5f5; }
.oc-product-row:last-child { border-bottom: none; }
.oc-product-img { width: 56px; height: 56px; object-fit: cover; border-radius: 8px; flex-shrink: 0; background: #f8f9fa; }
.oc-product-title { font-size: .88rem; font-weight: 600; line-height: 1.3; }
.oc-product-meta  { font-size: .78rem; color: #6c757d; margin-top: .15rem; }
.oc-product-price { font-size: .88rem; font-weight: 700; margin-left: auto; flex-shrink: 0; }

/* totals */
.oc-total-row { display: flex; justify-content: space-between; font-size: .88rem; padding: .35rem 0; }
.oc-total-row.grand { font-size: 1rem; font-weight: 700; border-top: 2px solid #111; padding-top: .75rem; margin-top: .25rem; }

/* actions */
.oc-actions { display: flex; gap: .75rem; flex-wrap: wrap; }
.oc-actions .btn-primary-dark { background: #111; color: #fff; border: none; padding: .65rem 1.5rem; border-radius: 8px; font-weight: 600; font-size: .9rem; text-decoration: none; display: inline-flex; align-items: center; gap: .4rem; }
.oc-actions .btn-primary-dark:hover { background: #333; color: #fff; }
.oc-actions .btn-outline-dark-c { background: transparent; border: 1.5px solid #dee2e6; padding: .65rem 1.5rem; border-radius: 8px; font-weight: 600; font-size: .9rem; color: #555; text-decoration: none; display: inline-flex; align-items: center; gap: .4rem; cursor: pointer; }
.oc-actions .btn-outline-dark-c:hover { border-color: #aaa; color: #111; }
</style>

<?php
// ── compute totals ──────────────────────────────────────────
$total1   = 0;
$quantity = 0;
$products = unserialize($order_details->products);
foreach ($products as $val) {
    if (isset($val['product_info']['price'])) {
        $total1   += (float)$val['product_info']['price'] * $val['product_quantity'];
        $quantity += $val['product_quantity'];
    }
}
$tax = get_tax_breakdown($total1);
?>

<div class="py-5">
    <div class="container oc-wrap" id="order_invoice">

        <!-- Banner -->
        <div class="oc-banner">
            <div class="oc-check">
                <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
            </div>
            <h2>Order Placed Successfully!</h2>
            <p>A confirmation has been sent to <strong><?= htmlspecialchars($order_details->email) ?></strong></p>
            <span class="oc-order-num">Order #<?= htmlspecialchars($order_details->order_id) ?></span>
        </div>

        <!-- Order Info -->
        <div class="oc-card">
            <div class="oc-card-title">Order Details</div>
            <dl class="oc-info-grid">
                <dt>Order Number</dt>
                <dd>#<?= htmlspecialchars($order_details->order_id) ?></dd>

                <dt>Order Date</dt>
                <dd><?= date('d M Y', $order_details->date) ?></dd>

                <dt>Customer</dt>
                <dd><?= htmlspecialchars($order_details->name) ?></dd>

                <dt>Delivery Address</dt>
                <dd><?= htmlspecialchars($order_details->address ?: '—') ?></dd>

                <dt>Agent</dt>
                <dd><?php
                    $agentName = '';
                    $agentUser = get_loggedin_user_agent();
                    if ($agentUser) {
                        $agentName = is_string($agentUser) ? $agentUser : ($agentUser->name ?? '');
                    } else {
                        $allSess = $this->session->all_userdata();
                        $agentName = $allSess['logged_user']['agents'] ?? '—';
                    }
                    echo htmlspecialchars($agentName ?: '—');
                ?></dd>

                <dt>Payment Method</dt>
                <dd><?= htmlspecialchars($order_details->payment_type ?? 'Cash on Delivery') ?></dd>
            </dl>
        </div>

        <!-- Items -->
        <div class="oc-card">
            <div class="oc-card-title">Items Ordered (<?= $quantity ?> pcs)</div>
            <?php foreach ($products as $val):
                $item = get_product_details($val['product_info']['id'] ?? null);
                if (!$item) continue;
                $img = base_url('attachments/shop_images/' . $item->image);
                $lineTotal = (float)$val['product_info']['price'] * $val['product_quantity'];
            ?>
            <div class="oc-product-row">
                <img src="<?= $img ?>" class="oc-product-img" alt="<?= htmlspecialchars($item->title) ?>">
                <div class="flex-grow-1">
                    <div class="oc-product-title"><?= htmlspecialchars($item->title) ?></div>
                    <div class="oc-product-meta">
                        <?php if (!empty($item->color)): ?>Color: <?= htmlspecialchars($item->color) ?> &nbsp;·&nbsp; <?php endif; ?>
                        Qty: <?= (int)$val['product_quantity'] ?> &nbsp;·&nbsp; ₹<?= number_format((float)$val['product_info']['price'], 2) ?> each
                    </div>
                </div>
                <div class="oc-product-price">₹<?= number_format($lineTotal, 2) ?></div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Totals -->
        <div class="oc-card">
            <div class="oc-card-title">Price Summary</div>
            <div class="oc-total-row">
                <span>Subtotal (<?= $quantity ?> items)</span>
                <span>₹<?= number_format($tax['base'], 2) ?></span>
            </div>
            <?php if ($tax['enabled'] && $tax['rate'] > 0): ?>
            <div class="oc-total-row">
                <span>Tax (<?= $tax['rate'] ?>%)</span>
                <span>₹<?= number_format($tax['tax_amount'], 2) ?></span>
            </div>
            <?php endif; ?>
            <div class="oc-total-row grand">
                <span>Total</span>
                <span>₹<?= number_format($tax['total'], 2) ?></span>
            </div>
        </div>

    </div><!-- /order_invoice -->

    <!-- Actions (outside printable area) -->
    <div class="container oc-wrap mt-3">
        <div class="oc-actions">
            <a href="<?= base_url('home/shop') ?>" class="btn-primary-dark">
                <i class="bi bi-bag"></i> Continue Shopping
            </a>
            <a href="<?= base_url('home/account') ?>" class="btn-outline-dark-c">
                <i class="bi bi-receipt"></i> My Orders
            </a>
            <button type="button" class="btn-outline-dark-c" onclick="downloadOrderPdf()">
                <i class="bi bi-download"></i> Download Invoice
            </button>
        </div>
    </div>
</div>

<?php include("footer.php") ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
function downloadOrderPdf() {
    var el = document.getElementById('order_invoice');
    html2pdf().set({
        margin: 8,
        filename: 'HouseOfStitches_Order_<?= $order_details->order_id ?>.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2, useCORS: true },
        jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
    }).from(el).save();
}
</script>
