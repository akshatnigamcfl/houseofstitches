<?php
$o         = $order;
$processed = (int)$o['processed'];
$status_map = [0 => ['pend','Pending','fa-clock-o'], 1 => ['proc','Processed','fa-check'], 2 => ['rejt','Rejected','fa-times'], 3 => ['rtd','Ready to Dispatch','fa-truck']];
[$bc, $bl, $bi] = $status_map[$processed] ?? $status_map[0];
$bamt  = (float)($o['billing_amount'] ?? 0);
$bpaid = (float)($o['paid_amount']    ?? 0);
$pstat = (int)($o['payment_status']   ?? 0);
?>
<style>
.od-wrap { font-family: -apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif; color:#1a1a2e; max-width:1100px; }
.od-back { display:inline-flex; align-items:center; gap:6px; color:#6B7280; font-size:13px; font-weight:600; text-decoration:none; margin-bottom:18px; }
.od-back:hover { color:#4F46E5; }
.od-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:22px; flex-wrap:wrap; gap:10px; }
.od-title { font-size:22px; font-weight:800; color:#111827; margin:0; }
.od-badge { display:inline-flex; align-items:center; gap:5px; padding:5px 12px; border-radius:20px; font-size:12px; font-weight:700; }
.od-badge.pend { background:#FEF3C7; color:#D97706; }
.od-badge.proc { background:#D1FAE5; color:#059669; }
.od-badge.rejt { background:#FEE2E2; color:#DC2626; }
.od-badge.rtd  { background:#DBEAFE; color:#1D4ED8; }
.od-card { background:#fff; border:1px solid #E5E7EB; border-radius:12px; padding:22px; margin-bottom:18px; box-shadow:0 1px 4px rgba(0,0,0,.04); }
.od-card h5 { font-size:12px; font-weight:800; text-transform:uppercase; letter-spacing:.7px; color:#9CA3AF; margin:0 0 16px; padding-bottom:10px; border-bottom:1px solid #F3F4F6; }
.od-row { display:flex; align-items:flex-start; margin-bottom:10px; gap:10px; }
.od-row-icon { width:28px; flex-shrink:0; color:#9CA3AF; font-size:13px; padding-top:2px; }
.od-row-text { font-size:13px; color:#374151; }
.od-row-text strong { color:#111827; }
/* products table */
.prod-table { width:100%; border-collapse:collapse; font-size:13px; }
.prod-table th { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.5px; color:#9CA3AF; padding:8px 10px; border-bottom:1px solid #E5E7EB; background:#FAFAFA; }
.prod-table td { padding:10px; border-bottom:1px solid #F3F4F6; vertical-align:middle; }
.prod-table tr:last-child td { border-bottom:none; }
.prod-table tfoot td { background:#111827; color:#fff; font-weight:700; padding:10px; }
/* status buttons */
.od-status-btn { border:none; border-radius:8px; padding:8px 16px; font-size:13px; font-weight:700; cursor:pointer; display:inline-flex; align-items:center; gap:6px; transition:all .15s; }
.od-status-btn.proc { background:#D1FAE5; color:#059669; }
.od-status-btn.proc:hover { background:#059669; color:#fff; }
.od-status-btn.pend { background:#FEF3C7; color:#D97706; }
.od-status-btn.pend:hover { background:#D97706; color:#fff; }
.od-status-btn.rejt { background:#FEE2E2; color:#DC2626; }
.od-status-btn.rejt:hover { background:#DC2626; color:#fff; }
.od-status-btn.rtd  { background:#DBEAFE; color:#1D4ED8; }
.od-status-btn.rtd:hover  { background:#1D4ED8; color:#fff; }
.od-feedback { font-size:12px; color:#16a34a; display:none; margin-left:8px; }
/* multi-step wizard */
.wizard-steps { display:flex; align-items:center; gap:0; margin-bottom:22px; }
.wizard-step { flex:1; text-align:center; position:relative; }
.wizard-step::after { content:''; position:absolute; top:16px; left:50%; width:100%; height:2px; background:#E5E7EB; z-index:0; }
.wizard-step:last-child::after { display:none; }
.ws-circle { width:32px; height:32px; border-radius:50%; display:inline-flex; align-items:center; justify-content:center; font-size:13px; font-weight:800; border:2px solid #E5E7EB; background:#fff; position:relative; z-index:1; color:#9CA3AF; transition:all .2s; }
.ws-label { font-size:11px; font-weight:600; color:#9CA3AF; margin-top:5px; transition:all .2s; }
.wizard-step.active .ws-circle { border-color:#4F46E5; background:#4F46E5; color:#fff; }
.wizard-step.active .ws-label { color:#4F46E5; }
.wizard-step.done .ws-circle { border-color:#059669; background:#059669; color:#fff; }
.wizard-step.done .ws-label { color:#059669; }
.wizard-panel { display:none; }
.wizard-panel.active { display:block; }
</style>

<div class="od-wrap">
    <a href="<?= base_url('admin/orders') ?>" class="od-back"><i class="fa fa-arrow-left"></i> Back to Orders</a>

    <div class="od-header">
        <div style="display:flex;align-items:center;gap:12px;">
            <h1 class="od-title">Order #<?= (int)$o['order_id'] ?></h1>
            <span class="od-badge <?= $bc ?>" id="page-status-badge"><i class="fa <?= $bi ?>"></i> <?= $bl ?></span>
            <?php if ($pstat === 2): ?>
                <span class="od-badge proc"><i class="fa fa-inr"></i> Paid</span>
            <?php elseif ($pstat === 1): ?>
                <span class="od-badge pend"><i class="fa fa-inr"></i> Partial</span>
            <?php else: ?>
                <span class="od-badge rejt"><i class="fa fa-inr"></i> Unpaid</span>
            <?php endif; ?>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap;">
            <?php if ($processed != 3): ?>
            <button class="od-status-btn rtd" onclick="changeStatus(3)"><i class="fa fa-truck"></i> Ready to Dispatch</button>
            <?php endif; ?>
            <?php if ($processed == 3): ?>
            <button class="od-status-btn proc" onclick="openProcessModal(true)"><i class="fa fa-pencil"></i> Edit Dispatch &amp; Tracking</button>
            <button class="od-status-btn proc" onclick="changeStatus(1)"><i class="fa fa-undo"></i> Revert to Processed</button>
            <?php else: ?>
            <button class="od-status-btn proc" onclick="openProcessModal()"><i class="fa fa-check"></i> Mark Processed</button>
            <?php endif; ?>
            <button class="od-status-btn pend" onclick="changeStatus(0)"><i class="fa fa-clock-o"></i> Mark Pending</button>
            <button class="od-status-btn rejt" onclick="changeStatus(2)"><i class="fa fa-times"></i> Mark Rejected</button>
            <span id="status-feedback" class="od-feedback">Status updated!</span>
        </div>
    </div>

    <div class="row">
        <!-- Left column: customer + order info -->
        <div class="col-md-4">
            <div class="od-card">
                <h5>Customer</h5>
                <?php
                // If this is a registered user order, prefer their account data
                $has_account = !empty($o['user_id']) && !empty($o['buyer_contact']);
                $display_name    = $has_account ? $o['buyer_contact']  : trim($o['first_name'] . ' ' . $o['last_name']);
                $display_company = $has_account ? ($o['buyer_company'] ?? '') : ($o['company'] ?? '');
                $display_phone   = $has_account ? ($o['buyer_phone']   ?? '') : ($o['phone']   ?? '');
                $display_email   = $has_account ? ($o['buyer_email']   ?? '') : ($o['email']   ?? '');
                // GST: use order-specific value only if it looks valid (≤20 chars, not a raw encrypted blob)
                $raw_gst     = trim($o['gst'] ?? '');
                $order_gst   = (strlen($raw_gst) <= 20 && $raw_gst !== '') ? $raw_gst : '';
                $display_gst = $order_gst ?: ($has_account ? trim($o['buyer_gst'] ?? '') : '');
                ?>
                <div class="od-row"><div class="od-row-icon"><i class="fa fa-user"></i></div><div class="od-row-text"><strong><?= htmlspecialchars($display_name) ?: '—' ?></strong></div></div>
                <?php if (!empty($display_company)): ?>
                <div class="od-row"><div class="od-row-icon"><i class="fa fa-building"></i></div><div class="od-row-text"><?= htmlspecialchars($display_company) ?></div></div>
                <?php endif; ?>
                <div class="od-row"><div class="od-row-icon"><i class="fa fa-phone"></i></div><div class="od-row-text"><a href="tel:<?= htmlspecialchars($display_phone) ?>"><?= htmlspecialchars($display_phone) ?: '—' ?></a></div></div>
                <div class="od-row"><div class="od-row-icon"><i class="fa fa-envelope"></i></div><div class="od-row-text"><a href="mailto:<?= htmlspecialchars($display_email) ?>"><?= htmlspecialchars($display_email) ?: '—' ?></a></div></div>
                <?php if (!empty($display_gst)): ?>
                <div class="od-row"><div class="od-row-icon"><i class="fa fa-id-card"></i></div><div class="od-row-text">GST: <?= htmlspecialchars($display_gst) ?></div></div>
                <?php endif; ?>
            </div>

            <!-- Delivery Address (from checkout form) -->
            <?php
            $ship_name  = trim(($o['first_name'] ?? '') . ' ' . ($o['last_name'] ?? ''));
            $ship_addr  = trim($o['address'] ?? '');
            $ship_city  = trim($o['city']    ?? '');
            $ship_pin   = trim($o['post_code'] ?? '');
            $ship_phone = trim($o['phone']   ?? '');
            $ship_co    = trim($o['company'] ?? '');
            $has_delivery = $ship_addr || $ship_city || $ship_name;
            ?>
            <?php if ($has_delivery): ?>
            <div class="od-card">
                <h5>Delivery Address</h5>
                <?php if ($ship_name): ?>
                <div class="od-row"><div class="od-row-icon"><i class="fa fa-user-o"></i></div><div class="od-row-text"><strong><?= htmlspecialchars($ship_name) ?></strong></div></div>
                <?php endif; ?>
                <?php if ($ship_co): ?>
                <div class="od-row"><div class="od-row-icon"><i class="fa fa-building"></i></div><div class="od-row-text"><?= htmlspecialchars($ship_co) ?></div></div>
                <?php endif; ?>
                <?php if ($ship_addr): ?>
                <div class="od-row"><div class="od-row-icon"><i class="fa fa-map-marker"></i></div><div class="od-row-text">
                    <?= htmlspecialchars($ship_addr) ?>
                    <?php if ($ship_city): ?><br><?= htmlspecialchars($ship_city) ?><?php endif; ?>
                    <?php if ($ship_pin): ?> — <?= htmlspecialchars($ship_pin) ?><?php endif; ?>
                </div></div>
                <?php endif; ?>
                <?php if ($ship_phone): ?>
                <div class="od-row"><div class="od-row-icon"><i class="fa fa-phone"></i></div><div class="od-row-text"><a href="tel:<?= htmlspecialchars($ship_phone) ?>"><?= htmlspecialchars($ship_phone) ?></a></div></div>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <div class="od-card">
                <h5>Order Info</h5>
                <div class="od-row"><div class="od-row-icon"><i class="fa fa-calendar"></i></div><div class="od-row-text"><?= date('d M Y, H:i', $o['date']) ?></div></div>
                <div class="od-row"><div class="od-row-icon"><i class="fa fa-credit-card"></i></div><div class="od-row-text"><?= htmlspecialchars($o['payment_type'] ?? '—') ?></div></div>
                <?php if (!empty($o['expected_dispatch_date'])): ?>
                <div class="od-row"><div class="od-row-icon"><i class="fa fa-truck"></i></div><div class="od-row-text">Expected Dispatch: <strong><?= htmlspecialchars($o['expected_dispatch_date']) ?></strong></div></div>
                <?php endif; ?>
                <?php if (!empty($o['notes'])): ?>
                <div class="od-row"><div class="od-row-icon"><i class="fa fa-sticky-note"></i></div><div class="od-row-text"><?= htmlspecialchars($o['notes']) ?></div></div>
                <?php endif; ?>
                <?php if (!empty($billed_user)): $type_map=[1=>'Agent',2=>'Distributor',3=>'Wholesaler',4=>'Retailer']; ?>
                <div class="od-row"><div class="od-row-icon"><i class="fa fa-briefcase"></i></div><div class="od-row-text">Billed to: <strong><?= htmlspecialchars($billed_user['name']) ?></strong> <span style="color:#9CA3AF;font-size:11px;">(<?= $type_map[$billed_user['type']] ?? '' ?>)</span></div></div>
                <?php endif; ?>
            </div>

            <!-- Tracking -->
            <div class="od-card">
                <h5><i class="fa fa-truck" style="margin-right:4px;"></i> Tracking</h5>
                <?php if (!empty($o['tracking_courier']) || !empty($o['tracking_id'])): ?>
                <div class="od-row"><div class="od-row-icon"><i class="fa fa-truck"></i></div><div class="od-row-text" id="display-courier"><strong><?= htmlspecialchars($o['tracking_courier'] ?? '') ?></strong></div></div>
                <div class="od-row"><div class="od-row-icon"><i class="fa fa-barcode"></i></div><div class="od-row-text" id="display-tracking-id"><?= htmlspecialchars($o['tracking_id'] ?? '') ?></div></div>
                <?php else: ?>
                <p style="font-size:12px;color:#9CA3AF;margin:0;" id="no-tracking-msg">No tracking info yet. Set it when marking this order as processed.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Right column: products + dispatch + payment -->
        <div class="col-md-8">
            <!-- Products + Dispatch -->
            <?php
            $saved_dispatch = [];
            if (!empty($o['dispatch_products'])) {
                $sd = @unserialize($o['dispatch_products']);
                if (is_array($sd)) $saved_dispatch = $sd;
            }
            ?>
            <div class="od-card">
                <h5>Products &amp; Dispatch</h5>
                <div class="table-responsive">
                    <table class="prod-table" id="products-table">
                        <thead>
                            <tr>
                                <th style="width:46px;"></th>
                                <th>Product</th>
                                <th style="text-align:center;width:80px;">Ordered</th>
                                <th style="text-align:center;width:100px;">Dispatch Qty</th>
                                <th style="text-align:right;width:80px;">WSP</th>
                                <th style="text-align:right;width:90px;">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $grand_qty = 0; $grand_amt = 0; $grand_dispatch = 0;
                        foreach ($products as $product):
                            $details  = get_product_details($product['product_info']['id'] ?? null);
                            $img_url  = base_url('attachments/shop_images/' . ($product['product_info']['image'] ?? ''));
                            $fallback = base_url('attachments/shop_images/spark_logo-06.jpg');
                            $wsp      = $details ? (float)($details->wsp ?? $details->price ?? 0) : (float)($product['product_info']['price'] ?? 0);
                            $pid      = (int)($product['product_info']['id'] ?? 0);
                            $qty      = (int)($product['product_quantity'] ?? 0);
                            $disp_qty = isset($saved_dispatch[$pid]) ? (int)$saved_dispatch[$pid] : $qty;
                            $grand_qty += $qty; $grand_amt += $wsp * $qty; $grand_dispatch += $disp_qty;
                        ?>
                        <tr data-pid="<?= $pid ?>" data-qty="<?= $qty ?>">
                            <td><img src="<?= $img_url ?>" onerror="this.onerror=null;this.src='<?= $fallback ?>'" style="width:36px;height:36px;object-fit:cover;border-radius:6px;border:1px solid #E5E7EB;"></td>
                            <td>
                                <div style="font-weight:600;color:#111827;"><?= $details ? htmlspecialchars($details->title ?? 'N/A') : '<em style="color:#9CA3AF;">Unknown</em>' ?></div>
                                <div style="font-size:11px;color:#9CA3AF;"><?= $details ? htmlspecialchars(trim(($details->color ?? '') . ' ' . ($details->size_range ?? ''))) : '' ?></div>
                                <?php if ($details && !empty($details->article_number)): ?>
                                <div style="font-size:11px;color:#6B7280;margin-top:2px;">Art# <strong><?= htmlspecialchars($details->article_number) ?></strong></div>
                                <?php endif; ?>
                            </td>
                            <td style="text-align:center;color:#6B7280;"><?= $qty ?> pcs</td>
                            <td style="text-align:center;">
                                <input type="number" class="dispatch-qty-input form-control input-sm" data-pid="<?= $pid ?>" value="<?= $disp_qty ?>" min="0" max="<?= $qty ?>" style="width:70px;margin:0 auto;text-align:center;">
                            </td>
                            <td style="text-align:right;color:#6B7280;">₹<?= number_format($wsp, 2) ?></td>
                            <td style="text-align:right;font-weight:700;color:#111827;">₹<?= number_format($wsp * $qty, 2) ?></td>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                        <?php if ($grand_qty > 0): ?>
                        <tfoot>
                            <tr>
                                <td colspan="2" style="text-align:right;">Total</td>
                                <td style="text-align:center;"><?= $grand_qty ?> pcs</td>
                                <td style="text-align:center;color:#fff;"><?= $grand_dispatch ?> pcs</td>
                                <td></td>
                                <td style="text-align:right;">₹<?= number_format($grand_amt, 2) ?></td>
                            </tr>
                        </tfoot>
                        <?php endif; ?>
                    </table>
                </div>
                <div style="margin-top:10px;font-size:11px;color:#9CA3AF;"><i class="fa fa-info-circle"></i> Dispatch quantities are saved when you click <strong>Mark Processed</strong>.</div>
            </div>

            <!-- Payment Recovery -->
            <div class="od-card">
                <h5><i class="fa fa-inr" style="margin-right:4px;"></i> Payment Recovery</h5>
                <div style="display:flex;gap:20px;margin-bottom:16px;flex-wrap:wrap;">
                    <div style="background:#F9FAFB;border:1px solid #E5E7EB;border-radius:8px;padding:12px 18px;text-align:center;">
                        <div style="font-size:11px;color:#9CA3AF;font-weight:700;text-transform:uppercase;margin-bottom:4px;">Bill Amount</div>
                        <div style="font-size:20px;font-weight:800;color:#111827;" id="page-billing">₹<?= number_format($bamt, 2) ?></div>
                    </div>
                    <div style="background:#F9FAFB;border:1px solid #E5E7EB;border-radius:8px;padding:12px 18px;text-align:center;">
                        <div style="font-size:11px;color:#9CA3AF;font-weight:700;text-transform:uppercase;margin-bottom:4px;">Paid</div>
                        <div style="font-size:20px;font-weight:800;color:#059669;" id="page-paid">₹<?= number_format($bpaid, 2) ?></div>
                    </div>
                    <div style="background:#F9FAFB;border:1px solid #E5E7EB;border-radius:8px;padding:12px 18px;text-align:center;">
                        <div style="font-size:11px;color:#9CA3AF;font-weight:700;text-transform:uppercase;margin-bottom:4px;">Balance Due</div>
                        <div style="font-size:20px;font-weight:800;color:#DC2626;" id="page-balance">₹<?= number_format(max(0, $bamt - $bpaid), 2) ?></div>
                    </div>
                </div>

                <!-- Payment history -->
                <div style="margin-bottom:16px;">
                    <div style="font-size:12px;font-weight:700;color:#374151;margin-bottom:8px;">Payment History</div>
                    <?php if (empty($payments)): ?>
                    <p style="font-size:12px;color:#9CA3AF;">No payments recorded yet.</p>
                    <?php else: ?>
                    <table style="width:100%;font-size:12px;border-collapse:collapse;" id="payment-history-table">
                        <thead>
                            <tr style="background:#FAFAFA;">
                                <th style="padding:6px 8px;border-bottom:1px solid #E5E7EB;color:#9CA3AF;font-weight:700;text-transform:uppercase;font-size:10px;letter-spacing:.5px;">Date</th>
                                <th style="padding:6px 8px;border-bottom:1px solid #E5E7EB;color:#9CA3AF;font-weight:700;text-transform:uppercase;font-size:10px;">Mode</th>
                                <th style="padding:6px 8px;border-bottom:1px solid #E5E7EB;color:#9CA3AF;font-weight:700;text-transform:uppercase;font-size:10px;">Reference</th>
                                <th style="padding:6px 8px;border-bottom:1px solid #E5E7EB;color:#9CA3AF;font-weight:700;text-transform:uppercase;font-size:10px;text-align:right;">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($payments as $p): ?>
                        <tr>
                            <td style="padding:7px 8px;border-bottom:1px solid #F3F4F6;"><?= date('d M Y', (int)$p['recorded_at']) ?></td>
                            <td style="padding:7px 8px;border-bottom:1px solid #F3F4F6;"><?= htmlspecialchars($p['mode'] ?? '—') ?></td>
                            <td style="padding:7px 8px;border-bottom:1px solid #F3F4F6;"><?= htmlspecialchars($p['reference'] ?? '—') ?></td>
                            <td style="padding:7px 8px;border-bottom:1px solid #F3F4F6;text-align:right;font-weight:700;color:#059669;">₹<?= number_format((float)$p['amount'], 2) ?></td>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php endif; ?>
                </div>

                <!-- Record payment form -->
                <div style="font-size:12px;font-weight:700;color:#374151;margin-bottom:8px;">Record a Payment</div>
                <div class="row" style="margin:0 -5px;">
                    <div class="col-xs-3" style="padding:0 5px;">
                        <input type="number" class="form-control input-sm" id="pay-amount" placeholder="Amount ₹" min="1" step="0.01">
                    </div>
                    <div class="col-xs-3" style="padding:0 5px;">
                        <select class="form-control input-sm" id="pay-mode">
                            <option value="bank">Bank Transfer</option>
                            <option value="cash">Cash</option>
                            <option value="online">Online/UPI</option>
                        </select>
                    </div>
                    <div class="col-xs-3" style="padding:0 5px;">
                        <input type="text" class="form-control input-sm" id="pay-ref" placeholder="Reference / UTR">
                    </div>
                    <div class="col-xs-3" style="padding:0 5px;">
                        <button type="button" class="btn btn-sm btn-success" id="record-payment-btn" style="width:100%;"><i class="fa fa-check"></i> Record</button>
                    </div>
                </div>
                <span id="payment-feedback" class="od-feedback" style="margin-top:8px;display:block;">Payment recorded!</span>
            </div>
            <!-- Payment Receipts submitted by user -->
            <div class="od-card">
                <h5><i class="fa fa-file-image-o" style="margin-right:4px;"></i> Payment Receipts (User Submitted)</h5>
                <?php if (empty($receipts)): ?>
                <p style="font-size:12px;color:#9CA3AF;margin:0;">No receipts submitted for this order yet.</p>
                <?php else: ?>
                <table style="width:100%;font-size:12px;border-collapse:collapse;">
                    <thead>
                        <tr style="background:#FAFAFA;">
                            <th style="padding:6px 8px;border-bottom:1px solid #E5E7EB;color:#9CA3AF;font-weight:700;text-transform:uppercase;font-size:10px;">Date</th>
                            <th style="padding:6px 8px;border-bottom:1px solid #E5E7EB;color:#9CA3AF;font-weight:700;text-transform:uppercase;font-size:10px;">User</th>
                            <th style="padding:6px 8px;border-bottom:1px solid #E5E7EB;color:#9CA3AF;font-weight:700;text-transform:uppercase;font-size:10px;">Mode</th>
                            <th style="padding:6px 8px;border-bottom:1px solid #E5E7EB;color:#9CA3AF;font-weight:700;text-transform:uppercase;font-size:10px;">Reference</th>
                            <th style="padding:6px 8px;border-bottom:1px solid #E5E7EB;color:#9CA3AF;font-weight:700;text-transform:uppercase;font-size:10px;text-align:right;">Amount</th>
                            <th style="padding:6px 8px;border-bottom:1px solid #E5E7EB;color:#9CA3AF;font-weight:700;text-transform:uppercase;font-size:10px;">File</th>
                            <th style="padding:6px 8px;border-bottom:1px solid #E5E7EB;color:#9CA3AF;font-weight:700;text-transform:uppercase;font-size:10px;">Status</th>
                            <th style="padding:6px 8px;border-bottom:1px solid #E5E7EB;color:#9CA3AF;font-weight:700;text-transform:uppercase;font-size:10px;"></th>
                        </tr>
                    </thead>
                    <tbody id="receipts-tbody">
                    <?php foreach ($receipts as $r): ?>
                    <tr data-rid="<?= (int)$r['id'] ?>">
                        <td style="padding:7px 8px;border-bottom:1px solid #F3F4F6;"><?= date('d M Y', (int)$r['recorded_at']) ?></td>
                        <td style="padding:7px 8px;border-bottom:1px solid #F3F4F6;"><?= htmlspecialchars($r['user_name'] ?? '—') ?></td>
                        <td style="padding:7px 8px;border-bottom:1px solid #F3F4F6;"><?= htmlspecialchars($r['mode'] ?? '—') ?></td>
                        <td style="padding:7px 8px;border-bottom:1px solid #F3F4F6;"><?= htmlspecialchars($r['reference'] ?? '—') ?></td>
                        <td style="padding:7px 8px;border-bottom:1px solid #F3F4F6;text-align:right;font-weight:700;">₹<?= number_format((float)$r['amount'], 2) ?></td>
                        <td style="padding:7px 8px;border-bottom:1px solid #F3F4F6;">
                            <?php if (!empty($r['receipt_file'])): ?>
                                <a href="<?= base_url('assets/uploads/payment_receipts/' . $r['receipt_file']) ?>" target="_blank" class="btn btn-xs btn-info"><i class="fa fa-eye"></i> View</a>
                            <?php else: ?><span style="color:#9CA3AF;">No file</span><?php endif; ?>
                        </td>
                        <td style="padding:7px 8px;border-bottom:1px solid #F3F4F6;" class="receipt-status-cell">
                            <?php if ($r['status'] === 'verified'): ?>
                                <span style="background:#D1FAE5;color:#059669;padding:2px 8px;border-radius:10px;font-size:10px;font-weight:700;">Verified</span>
                            <?php elseif ($r['status'] === 'rejected'): ?>
                                <span style="background:#FEE2E2;color:#DC2626;padding:2px 8px;border-radius:10px;font-size:10px;font-weight:700;">Rejected</span>
                            <?php else: ?>
                                <span style="background:#FEF3C7;color:#D97706;padding:2px 8px;border-radius:10px;font-size:10px;font-weight:700;">Pending</span>
                            <?php endif; ?>
                        </td>
                        <td style="padding:7px 8px;border-bottom:1px solid #F3F4F6;" class="receipt-action-cell">
                            <?php if ($r['status'] === 'pending'): ?>
                            <button type="button" class="btn btn-xs btn-success" onclick="verifyReceiptInline(<?= (int)$r['id'] ?>, this)"><i class="fa fa-check"></i></button>
                            <button type="button" class="btn btn-xs btn-danger" onclick="rejectReceiptInline(<?= (int)$r['id'] ?>, this)"><i class="fa fa-times"></i></button>
                            <?php else: ?>&mdash;<?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php endif; ?>
            </div>

            <!-- GR Returns for this order -->
            <div class="od-card" id="gr-section">
                <h5><i class="fa fa-undo" style="margin-right:4px;"></i> GR Returns</h5>
                <?php if (empty($gr_requests)): ?>
                <p style="font-size:12px;color:#9CA3AF;margin:0;">No GR return requests for this order yet.</p>
                <?php else: ?>
                <table style="width:100%;font-size:12px;border-collapse:collapse;">
                    <thead>
                        <tr style="background:#FAFAFA;">
                            <th style="padding:6px 8px;border-bottom:1px solid #E5E7EB;color:#9CA3AF;font-weight:700;text-transform:uppercase;font-size:10px;">GR No</th>
                            <th style="padding:6px 8px;border-bottom:1px solid #E5E7EB;color:#9CA3AF;font-weight:700;text-transform:uppercase;font-size:10px;">Submitter</th>
                            <th style="padding:6px 8px;border-bottom:1px solid #E5E7EB;color:#9CA3AF;font-weight:700;text-transform:uppercase;font-size:10px;">Type</th>
                            <th style="padding:6px 8px;border-bottom:1px solid #E5E7EB;color:#9CA3AF;font-weight:700;text-transform:uppercase;font-size:10px;">Items</th>
                            <th style="padding:6px 8px;border-bottom:1px solid #E5E7EB;color:#9CA3AF;font-weight:700;text-transform:uppercase;font-size:10px;">Status</th>
                            <th style="padding:6px 8px;border-bottom:1px solid #E5E7EB;color:#9CA3AF;font-weight:700;text-transform:uppercase;font-size:10px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($gr_requests as $gr): ?>
                    <tr>
                        <td style="padding:7px 8px;border-bottom:1px solid #F3F4F6;font-weight:700;"><?= htmlspecialchars($gr['gr_no']) ?></td>
                        <td style="padding:7px 8px;border-bottom:1px solid #F3F4F6;">
                            <?= htmlspecialchars($gr['submitter_name'] ?? '—') ?>
                            <?php if (!empty($gr['submitter_company'])): ?><br><span style="color:#9CA3AF;"><?= htmlspecialchars($gr['submitter_company']) ?></span><?php endif; ?>
                        </td>
                        <td style="padding:7px 8px;border-bottom:1px solid #F3F4F6;"><?= htmlspecialchars($gr['return_type']) ?></td>
                        <td style="padding:7px 8px;border-bottom:1px solid #F3F4F6;max-width:160px;">
                            <span style="font-size:11px;color:#6B7280;"><?= nl2br(htmlspecialchars($gr['items'])) ?></span>
                        </td>
                        <td style="padding:7px 8px;border-bottom:1px solid #F3F4F6;" id="gr-status-<?= (int)$gr['id'] ?>">
                            <?php
                            $gs_map = ['pending'=>['#FEF3C7','#D97706'],'approved'=>['#DBEAFE','#1D4ED8'],'rejected'=>['#FEE2E2','#DC2626'],'processed'=>['#D1FAE5','#059669']];
                            [$gsbg, $gsfc] = $gs_map[$gr['status']] ?? ['#F3F4F6','#6B7280'];
                            ?>
                            <span style="background:<?= $gsbg ?>;color:<?= $gsfc ?>;padding:2px 8px;border-radius:10px;font-size:10px;font-weight:700;"><?= ucfirst($gr['status']) ?></span>
                            <?php if (!empty($gr['credit_amount'])): ?>
                            <div style="font-size:11px;color:#059669;margin-top:2px;">Credit: ₹<?= number_format((float)$gr['credit_amount'], 2) ?></div>
                            <?php endif; ?>
                        </td>
                        <td style="padding:7px 8px;border-bottom:1px solid #F3F4F6;">
                            <button type="button" class="btn btn-xs btn-default" onclick="openGrUpdateModal(<?= (int)$gr['id'] ?>, '<?= addslashes($gr['gr_no']) ?>', '<?= $gr['status'] ?>', <?= (float)($gr['credit_amount'] ?? 0) ?>)">
                                <i class="fa fa-pencil"></i> Update
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- ── Process Order Modal (3-step wizard) ── -->
<?php
// Build JS-safe product list for the modal
$js_products = [];
foreach ($products as $product) {
    $pid     = (int)($product['product_info']['id'] ?? 0);
    $qty     = (int)($product['product_quantity'] ?? 0);
    $details = get_product_details($pid);
    $disp    = isset($saved_dispatch[$pid]) ? (int)$saved_dispatch[$pid] : $qty;
    $wsp     = $details ? (float)($details->wsp ?? $details->price ?? 0) : (float)($product['product_info']['price'] ?? 0);
    $img     = base_url('attachments/shop_images/' . ($product['product_info']['image'] ?? ''));
    $js_products[] = [
        'pid'   => $pid,
        'title' => $details ? ($details->title ?? 'Unknown') : 'Unknown',
        'color' => $details ? trim(($details->color ?? '') . ' ' . ($details->size_range ?? '')) : '',
        'qty'   => $qty,
        'disp'  => $disp,
        'wsp'   => $wsp,
        'img'   => $img,
    ];
}
?>
<script>var PROCESS_PRODUCTS = <?= json_encode($js_products) ?>;</script>

<div class="modal fade" id="processOrderModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background:#1e2a3a;color:#fff;border-radius:4px 4px 0 0;padding:14px 20px;">
                <button type="button" class="close" data-dismiss="modal" style="color:#fff;opacity:.8;">×</button>
                <h4 class="modal-title" style="font-size:15px;font-weight:800;"><i class="fa fa-check-circle" style="margin-right:6px;"></i> Process Order #<?= (int)$o['order_id'] ?></h4>
            </div>
            <div class="modal-body" style="padding:20px 24px;">
                <!-- Step indicators -->
                <div class="wizard-steps" id="wizard-steps">
                    <div class="wizard-step active" id="ws-1">
                        <div class="ws-circle">1</div>
                        <div class="ws-label">Dispatch</div>
                    </div>
                    <div class="wizard-step" id="ws-2">
                        <div class="ws-circle">2</div>
                        <div class="ws-label">Tracking</div>
                    </div>
                    <div class="wizard-step" id="ws-3">
                        <div class="ws-circle">3</div>
                        <div class="ws-label">Confirm</div>
                    </div>
                </div>

                <!-- Step 1: Dispatch Quantities -->
                <div class="wizard-panel active" id="wp-1">
                    <p style="font-size:12px;color:#6B7280;margin-bottom:14px;">Set the quantity being dispatched for each product. Cannot exceed ordered quantity.</p>
                    <table style="width:100%;border-collapse:collapse;font-size:13px;" id="wizard-dispatch-table">
                        <thead>
                            <tr style="background:#FAFAFA;">
                                <th style="padding:8px 10px;border-bottom:1px solid #E5E7EB;color:#9CA3AF;font-size:10px;font-weight:700;text-transform:uppercase;">Product</th>
                                <th style="padding:8px 10px;border-bottom:1px solid #E5E7EB;color:#9CA3AF;font-size:10px;font-weight:700;text-transform:uppercase;text-align:center;width:80px;">Ordered</th>
                                <th style="padding:8px 10px;border-bottom:1px solid #E5E7EB;color:#9CA3AF;font-size:10px;font-weight:700;text-transform:uppercase;text-align:center;width:110px;">Dispatch Qty</th>
                            </tr>
                        </thead>
                        <tbody id="wizard-dispatch-tbody"></tbody>
                    </table>
                </div>

                <!-- Step 2: Tracking -->
                <div class="wizard-panel" id="wp-2">
                    <p style="font-size:12px;color:#6B7280;margin-bottom:16px;">Enter the courier name and tracking ID for this shipment.</p>
                    <div class="form-group">
                        <label style="font-size:12px;font-weight:700;color:#374151;">Courier Name</label>
                        <input type="text" class="form-control" id="wiz-courier" placeholder="e.g. DTDC, Blue Dart, Delhivery" value="<?= htmlspecialchars($o['tracking_courier'] ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label style="font-size:12px;font-weight:700;color:#374151;">Tracking ID / AWB Number</label>
                        <input type="text" class="form-control" id="wiz-tracking-id" placeholder="Enter tracking number" value="<?= htmlspecialchars($o['tracking_id'] ?? '') ?>">
                    </div>
                </div>

                <!-- Step 3: Confirm -->
                <div class="wizard-panel" id="wp-3">
                    <p style="font-size:12px;color:#6B7280;margin-bottom:16px;">Review the dispatch summary before confirming.</p>
                    <div id="wiz-summary" style="background:#F9FAFB;border:1px solid #E5E7EB;border-radius:8px;padding:14px 16px;font-size:13px;"></div>
                </div>
            </div>
            <div class="modal-footer" style="display:flex;justify-content:space-between;align-items:center;">
                <button type="button" class="btn btn-default" id="wiz-back-btn" onclick="wizStep(-1)" style="display:none;"><i class="fa fa-arrow-left"></i> Back</button>
                <div style="display:flex;gap:8px;margin-left:auto;">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="wiz-next-btn" onclick="wizStep(1)">Next <i class="fa fa-arrow-right"></i></button>
                    <button type="button" class="btn btn-success" id="wiz-confirm-btn" onclick="confirmProcessOrder()" style="display:none;"><i class="fa fa-check"></i> Confirm &amp; Process</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- GR Update Modal (inline) -->
<div class="modal fade" id="grUpdateModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background:#1e2a3a;color:#fff;border-radius:4px 4px 0 0;">
                <button type="button" class="close" data-dismiss="modal" style="color:#fff;opacity:.8;">×</button>
                <h4 class="modal-title" style="font-size:14px;font-weight:700;"><i class="fa fa-undo"></i> Update GR Return</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="gr-update-id">
                <div style="font-size:12px;font-weight:700;color:#374151;margin-bottom:4px;">GR No: <span id="gr-update-no" style="color:#6B7280;"></span></div>
                <div class="form-group" style="margin-top:12px;">
                    <label style="font-size:12px;font-weight:700;">Status</label>
                    <select class="form-control input-sm" id="gr-update-status" onchange="toggleGrCreditField()">
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                        <option value="processed">Processed</option>
                    </select>
                </div>
                <div class="form-group" id="gr-credit-wrap" style="display:none;">
                    <label style="font-size:12px;font-weight:700;">Credit Amount (₹)</label>
                    <input type="number" class="form-control input-sm" id="gr-update-credit" min="0" step="0.01" placeholder="Enter credit amount">
                </div>
                <div class="form-group">
                    <label style="font-size:12px;font-weight:700;">Admin Remark</label>
                    <textarea class="form-control input-sm" id="gr-update-remark" rows="2" placeholder="Optional remark"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary btn-sm" onclick="saveGrUpdate()"><i class="fa fa-save"></i> Save</button>
            </div>
        </div>
    </div>
</div>

<script>
var ORDER_DB_ID = <?= (int)$o['id'] ?>;
var ORDER_NUM   = <?= (int)$o['order_id'] ?>;
var ORDER_PRODUCTS_SERIALIZED = '<?= htmlentities($o['products']) ?>';
var ORDER_EMAIL = '<?= addslashes($o['email'] ?? '') ?>';
var _processEditOnly = false; // true = just updating dispatch/tracking, not changing status

// Status change
function changeStatus(to_status) {
    var labels = {0:'Pending', 1:'Processed', 2:'Rejected', 3:'Ready to Dispatch'};
    var msg = 'Change status to ' + labels[to_status] + '?';
    if (to_status == 3) {
        msg = 'Mark as Ready to Dispatch?\n\nThis will deduct stock from both DB1 (local) and DB2 (SpangleDBnew). This cannot be undone without manually reverting the order.';
    }
    if (!confirm(msg)) return;
    jQuery.post('<?= base_url('admin/changeOrdersOrderStatus') ?>', {
        the_id: ORDER_DB_ID,
        to_status: to_status,
        products: ORDER_PRODUCTS_SERIALIZED,
        userEmail: ORDER_EMAIL
    }, function() {
        var badgeMap = {
            0: 'pend|fa-clock-o|Pending',
            1: 'proc|fa-check|Processed',
            2: 'rejt|fa-times|Rejected',
            3: 'rtd|fa-truck|Ready to Dispatch'
        };
        var parts = badgeMap[to_status].split('|');
        var html = '<span class="od-badge ' + parts[0] + '" id="page-status-badge"><i class="fa ' + parts[1] + '"></i> ' + parts[2] + '</span>';
        jQuery('#page-status-badge').replaceWith(html);
        jQuery('#status-feedback').show().delay(2000).fadeOut();
        // Reload to reflect updated buttons
        setTimeout(function() { location.reload(); }, 800);
    });
}

// ── Process Order Wizard ──
var _wizCurrentStep = 1;

function openProcessModal(editOnly) {
    _processEditOnly = !!editOnly;
    _wizCurrentStep = 1;
    // Populate dispatch table from JS product list
    var tbody = '';
    PROCESS_PRODUCTS.forEach(function(p) {
        var disp = jQuery('.dispatch-qty-input[data-pid="' + p.pid + '"]').val() || p.disp;
        tbody += '<tr>' +
            '<td style="padding:8px 10px;border-bottom:1px solid #F3F4F6;">' +
            '<div style="font-weight:600;color:#111827;">' + p.title + '</div>' +
            (p.color ? '<div style="font-size:11px;color:#9CA3AF;">' + p.color + '</div>' : '') +
            '</td>' +
            '<td style="padding:8px 10px;border-bottom:1px solid #F3F4F6;text-align:center;color:#6B7280;">' + p.qty + ' pcs</td>' +
            '<td style="padding:8px 10px;border-bottom:1px solid #F3F4F6;text-align:center;">' +
            '<input type="number" class="form-control input-sm wiz-disp-input" data-pid="' + p.pid + '" data-max="' + p.qty + '" ' +
            'value="' + disp + '" min="0" max="' + p.qty + '" style="width:75px;margin:0 auto;text-align:center;">' +
            '</td></tr>';
    });
    jQuery('#wizard-dispatch-tbody').html(tbody);
    wizGoTo(1);
    jQuery('#processOrderModal').modal('show');
}

function wizGoTo(step) {
    _wizCurrentStep = step;
    // Update panels
    jQuery('.wizard-panel').removeClass('active');
    jQuery('#wp-' + step).addClass('active');
    // Update step indicators
    jQuery('.wizard-step').removeClass('active done');
    for (var i = 1; i < step; i++) jQuery('#ws-' + i).addClass('done');
    jQuery('#ws-' + step).addClass('active');
    // Buttons
    jQuery('#wiz-back-btn').toggle(step > 1);
    jQuery('#wiz-next-btn').toggle(step < 3);
    jQuery('#wiz-confirm-btn').toggle(step === 3);
    // Build summary on step 3
    if (step === 3) {
        var courier   = jQuery('#wiz-courier').val().trim();
        var trackingId = jQuery('#wiz-tracking-id').val().trim();
        var rows = '';
        jQuery('.wiz-disp-input').each(function() {
            var pid = jQuery(this).data('pid');
            var p = PROCESS_PRODUCTS.find(function(x) { return x.pid == pid; });
            if (p) rows += '<div style="display:flex;justify-content:space-between;padding:5px 0;border-bottom:1px solid #F3F4F6;font-size:12px;"><span>' + p.title + '</span><span style="font-weight:700;">' + jQuery(this).val() + ' / ' + p.qty + ' pcs</span></div>';
        });
        var summary = '<div style="margin-bottom:10px;"><strong style="font-size:11px;text-transform:uppercase;color:#9CA3AF;letter-spacing:.5px;">Dispatch</strong>' + rows + '</div>';
        summary += '<div style="margin-top:10px;font-size:12px;">';
        summary += '<strong style="font-size:11px;text-transform:uppercase;color:#9CA3AF;letter-spacing:.5px;">Tracking</strong>';
        summary += '<div style="padding:6px 0;">' + (courier || '<em style="color:#9CA3AF;">No courier</em>') + '</div>';
        summary += '<div style="padding:2px 0;">' + (trackingId || '<em style="color:#9CA3AF;">No tracking ID</em>') + '</div></div>';
        if (!_processEditOnly) {
            summary += '<div style="margin-top:12px;padding:10px;background:#D1FAE5;border-radius:6px;font-size:12px;color:#059669;font-weight:700;"><i class="fa fa-check-circle"></i> Order will be marked as <strong>Processed</strong>.</div>';
        }
        jQuery('#wiz-summary').html(summary);
    }
}

function wizStep(dir) {
    var next = _wizCurrentStep + dir;
    if (next < 1 || next > 3) return;
    // Validate step 1: dispatch qtys
    if (_wizCurrentStep === 1 && dir === 1) {
        var ok = true;
        jQuery('.wiz-disp-input').each(function() {
            var v = parseInt(jQuery(this).val(), 10);
            var max = parseInt(jQuery(this).data('max'), 10);
            if (isNaN(v) || v < 0 || v > max) { ok = false; jQuery(this).focus(); return false; }
        });
        if (!ok) { alert('Check dispatch quantities — values must be between 0 and ordered qty.'); return; }
    }
    wizGoTo(next);
}

function confirmProcessOrder() {
    var dispatch = {};
    jQuery('.wiz-disp-input').each(function() { dispatch[jQuery(this).data('pid')] = jQuery(this).val(); });
    var courier    = jQuery('#wiz-courier').val().trim();
    var trackingId = jQuery('#wiz-tracking-id').val().trim();

    jQuery('#wiz-confirm-btn').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving…');

    // Step A: save dispatch
    jQuery.post('<?= base_url('admin/orders/setDispatchQty') ?>', {order_id: ORDER_DB_ID, dispatch: dispatch}, function(r1) {
        if (!r1.success) { alert('Failed to save dispatch quantities.'); jQuery('#wiz-confirm-btn').prop('disabled',false).html('<i class="fa fa-check"></i> Confirm &amp; Process'); return; }

        // Step B: save tracking
        jQuery.post('<?= base_url('admin/orders/setTracking') ?>', {order_id: ORDER_DB_ID, courier: courier, tracking_id: trackingId}, function(r2) {

            // Update dispatch inputs on the page
            jQuery('.wiz-disp-input').each(function() {
                jQuery('.dispatch-qty-input[data-pid="' + jQuery(this).data('pid') + '"]').val(jQuery(this).val());
            });

            // Update tracking display on the page
            if (courier || trackingId) {
                jQuery('#no-tracking-msg').hide();
                jQuery('#display-courier').html('<strong>' + courier + '</strong>');
                jQuery('#display-tracking-id').text(trackingId);
            }

            if (_processEditOnly) {
                jQuery('#processOrderModal').modal('hide');
                jQuery('#wiz-confirm-btn').prop('disabled',false).html('<i class="fa fa-check"></i> Confirm &amp; Process');
                return;
            }

            // Step C: mark processed
            jQuery.post('<?= base_url('admin/changeOrdersOrderStatus') ?>', {
                the_id: ORDER_DB_ID,
                to_status: 1,
                products: ORDER_PRODUCTS_SERIALIZED,
                userEmail: ORDER_EMAIL
            }, function() {
                jQuery('#processOrderModal').modal('hide');
                var html = '<span class="od-badge proc" id="page-status-badge"><i class="fa fa-check"></i> Processed</span>';
                jQuery('#page-status-badge').replaceWith(html);
                jQuery('#status-feedback').show().delay(2500).fadeOut();
                jQuery('#wiz-confirm-btn').prop('disabled',false).html('<i class="fa fa-check"></i> Confirm &amp; Process');
            });
        }, 'json');
    }, 'json');
}

// Record payment
jQuery(document).on('click', '#record-payment-btn', function() {
    var amt = parseFloat(jQuery('#pay-amount').val());
    if (!amt || amt <= 0) { alert('Enter a valid amount.'); return; }
    jQuery.post('<?= base_url('admin/orders/recordPayment') ?>', {
        order_id: ORDER_DB_ID,
        amount: amt,
        mode: jQuery('#pay-mode').val(),
        reference: jQuery('#pay-ref').val()
    }, function(r) {
        if (r.success) {
            var billing  = parseFloat(jQuery('#page-billing').text().replace('₹','').replace(/,/g,'')) || 0;
            var newPaid  = parseFloat(jQuery('#page-paid').text().replace('₹','').replace(/,/g,'')) + amt;
            jQuery('#page-paid').text('₹' + newPaid.toFixed(2));
            jQuery('#page-balance').text('₹' + Math.max(0, billing - newPaid).toFixed(2));
            jQuery('#pay-amount').val(''); jQuery('#pay-ref').val('');
            jQuery('#payment-feedback').show().delay(2000).fadeOut();
            // Add row to history table
            var today = new Date().toLocaleDateString('en-IN', {day:'2-digit',month:'short',year:'numeric'});
            var row = '<tr><td style="padding:7px 8px;border-bottom:1px solid #F3F4F6;">' + today + '</td><td style="padding:7px 8px;border-bottom:1px solid #F3F4F6;">' + jQuery('#pay-mode').val() + '</td><td style="padding:7px 8px;border-bottom:1px solid #F3F4F6;">' + (jQuery('#pay-ref').val() || '—') + '</td><td style="padding:7px 8px;border-bottom:1px solid #F3F4F6;text-align:right;font-weight:700;color:#059669;">₹' + amt.toFixed(2) + '</td></tr>';
            if (jQuery('#payment-history-table tbody').length) {
                jQuery('#payment-history-table tbody').append(row);
            }
        }
    }, 'json');
});

// Inline receipt verify / reject
function verifyReceiptInline(id, btn) {
    if (!confirm('Mark this receipt as verified and credit the ledger?')) return;
    jQuery.post('<?= base_url('admin/verifyPayment') ?>', {id: id}, function(r) {
        try { r = typeof r === 'string' ? JSON.parse(r) : r; } catch(e){}
        if (r && r.success) {
            var row = jQuery(btn).closest('tr');
            row.find('.receipt-status-cell').html('<span style="background:#D1FAE5;color:#059669;padding:2px 8px;border-radius:10px;font-size:10px;font-weight:700;">Verified</span>');
            row.find('.receipt-action-cell').html('&mdash;');
        } else { alert('Failed. Try again.'); }
    });
}
function rejectReceiptInline(id, btn) {
    if (!confirm('Reject this receipt?')) return;
    jQuery.post('<?= base_url('admin/rejectPayment') ?>', {id: id}, function(r) {
        try { r = typeof r === 'string' ? JSON.parse(r) : r; } catch(e){}
        if (r && r.success) {
            var row = jQuery(btn).closest('tr');
            row.find('.receipt-status-cell').html('<span style="background:#FEE2E2;color:#DC2626;padding:2px 8px;border-radius:10px;font-size:10px;font-weight:700;">Rejected</span>');
            row.find('.receipt-action-cell').html('&mdash;');
        } else { alert('Failed. Try again.'); }
    });
}

// GR update modal
function openGrUpdateModal(id, grNo, status, creditAmt) {
    jQuery('#gr-update-id').val(id);
    jQuery('#gr-update-no').text(grNo);
    jQuery('#gr-update-status').val(status);
    jQuery('#gr-update-credit').val(creditAmt > 0 ? creditAmt : '');
    jQuery('#gr-update-remark').val('');
    toggleGrCreditField();
    jQuery('#grUpdateModal').modal('show');
}
function toggleGrCreditField() {
    var s = jQuery('#gr-update-status').val();
    jQuery('#gr-credit-wrap').toggle(s === 'processed');
}
function saveGrUpdate() {
    var id     = jQuery('#gr-update-id').val();
    var status = jQuery('#gr-update-status').val();
    var credit = jQuery('#gr-update-credit').val();
    var remark = jQuery('#gr-update-remark').val();
    if (status === 'processed' && (!credit || parseFloat(credit) <= 0)) {
        alert('Enter a credit amount when marking as processed.'); return;
    }
    jQuery.post('<?= base_url('admin/gr_returns/updateStatus') ?>', {
        id: id, status: status, admin_remark: remark, credit_amount: credit || 0
    }, function(r) {
        try { r = typeof r === 'string' ? JSON.parse(r) : r; } catch(e){}
        if (r && r.success) {
            jQuery('#grUpdateModal').modal('hide');
            var colorMap = {pending:['#FEF3C7','#D97706'], approved:['#DBEAFE','#1D4ED8'], rejected:['#FEE2E2','#DC2626'], processed:['#D1FAE5','#059669']};
            var c = colorMap[status] || ['#F3F4F6','#6B7280'];
            var badge = '<span style="background:' + c[0] + ';color:' + c[1] + ';padding:2px 8px;border-radius:10px;font-size:10px;font-weight:700;">' + status.charAt(0).toUpperCase() + status.slice(1) + '</span>';
            if (status === 'processed' && parseFloat(credit) > 0) {
                badge += '<div style="font-size:11px;color:#059669;margin-top:2px;">Credit: ₹' + parseFloat(credit).toFixed(2) + '</div>';
            }
            jQuery('#gr-status-' + id).html(badge);
        } else { alert((r && r.error) ? r.error : 'Failed. Try again.'); }
    });
}
</script>
