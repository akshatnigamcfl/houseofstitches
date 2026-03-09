<link href="<?= base_url('assets/css/bootstrap-toggle.min.css') ?>" rel="stylesheet">
<style>
/* ── Reset content area for this page ── */
.ord-page { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; color: #1a1a2e; }

/* ── Page header ── */
.ord-page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; }
.ord-page-title { font-size: 20px; font-weight: 700; color: #111827; margin: 0; letter-spacing: -.3px; }
.ord-page-title span { color: #6B7280; font-weight: 400; font-size: 14px; margin-left: 8px; }

/* ── Stat cards ── */
.ord-stats { display: flex; gap: 14px; margin-bottom: 24px; flex-wrap: wrap; }
.ord-stat { flex: 1; min-width: 130px; background: #fff; border: 1px solid #E5E7EB; border-radius: 10px; padding: 16px 18px; display: flex; align-items: center; gap: 14px; box-shadow: 0 1px 3px rgba(0,0,0,.04); }
.ord-stat .stat-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 17px; flex-shrink: 0; }
.ord-stat .stat-num { font-size: 26px; font-weight: 800; line-height: 1; margin-bottom: 2px; color: #111827; }
.ord-stat .stat-lbl { font-size: 11px; color: #9CA3AF; text-transform: uppercase; letter-spacing: .6px; font-weight: 600; }
.stat-icon.all   { background: #EEF2FF; color: #4F46E5; }
.stat-icon.pend  { background: #FEF3C7; color: #D97706; }
.stat-icon.proc  { background: #D1FAE5; color: #059669; }
.stat-icon.rejt  { background: #FEE2E2; color: #DC2626; }

/* ── Toolbar ── */
.ord-toolbar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; flex-wrap: wrap; gap: 10px; }
.ord-filters { display: flex; gap: 6px; flex-wrap: wrap; }
.ord-filter-btn { display: inline-block; padding: 5px 14px; border-radius: 20px; border: 1px solid #E5E7EB; font-size: 12px; font-weight: 600; color: #6B7280; background: #fff; cursor: pointer; transition: all .15s; line-height: 1.5; }
.ord-filter-btn:hover { border-color: #4F46E5; color: #4F46E5; }
.ord-filter-btn.active { background: #4F46E5; color: #fff; border-color: #4F46E5; }
.ord-filter-btn .count { background: rgba(255,255,255,.3); border-radius: 10px; padding: 0 5px; margin-left: 4px; font-size: 10px; }
.ord-filter-btn:not(.active) .count { background: #F3F4F6; color: #6B7280; }

/* ── Sort select ── */
.ord-sort { border: 1px solid #E5E7EB; border-radius: 6px; padding: 6px 10px; font-size: 12px; color: #374151; background: #fff; outline: none; cursor: pointer; }

/* ── Table ── */
.ord-table-wrap { background: #fff; border: 1px solid #E5E7EB; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 4px rgba(0,0,0,.05); }
.ord-table { width: 100%; border-collapse: collapse; margin: 0; }
.ord-table thead tr { border-bottom: 1px solid #F3F4F6; }
.ord-table thead th { padding: 11px 16px; font-size: 11px; font-weight: 700; color: #9CA3AF; text-transform: uppercase; letter-spacing: .6px; background: #FAFAFA; white-space: nowrap; }
.ord-table tbody tr { border-bottom: 1px solid #F9FAFB; transition: background .12s; }
.ord-table tbody tr:last-child { border-bottom: none; }
.ord-table tbody tr:hover td { background: #F8F7FF; }
.ord-table tbody td { padding: 13px 16px; vertical-align: middle; font-size: 13px; color: #374151; }

/* ── Order id cell ── */
.ord-id { font-size: 15px; font-weight: 800; color: #111827; }
.ord-new { display: inline-block; background: #DC2626; color: #fff; font-size: 9px; font-weight: 700; padding: 1px 6px; border-radius: 4px; margin-left: 5px; vertical-align: middle; animation: blink .9s step-start infinite; }
@keyframes blink { 50% { opacity: 0; } }
.ord-conf { font-size: 11px; margin-top: 3px; }
.ord-conf.yes { color: #059669; }
.ord-conf.no  { color: #DC2626; }

/* ── Date cell ── */
.ord-date-main { font-weight: 600; color: #374151; }
.ord-date-time { font-size: 11px; color: #9CA3AF; }

/* ── Customer cell ── */
.ord-cust-name { font-weight: 700; color: #111827; margin-bottom: 2px; }
.ord-cust-meta { font-size: 11px; color: #9CA3AF; }

/* ── Status badge ── */
.ord-badge { display: inline-flex; align-items: center; gap: 5px; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; letter-spacing: .2px; white-space: nowrap; }
.ord-badge.pend { background: #FEF3C7; color: #D97706; }
.ord-badge.proc { background: #D1FAE5; color: #059669; }
.ord-badge.rejt { background: #FEE2E2; color: #DC2626; }
.ord-badge i { font-size: 9px; }

/* ── Payment badge ── */
.pay-badge { display: inline-block; padding: 3px 8px; border-radius: 5px; font-size: 11px; font-weight: 600; background: #F3F4F6; color: #374151; }

/* ── Action buttons ── */
.ord-actions { display: flex; gap: 6px; align-items: center; justify-content: center; flex-wrap: nowrap; }
.btn-icon { display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 7px; border: 1px solid #E5E7EB; background: #fff; color: #6B7280; cursor: pointer; transition: all .15s; font-size: 13px; }
.btn-icon:hover { border-color: #4F46E5; color: #4F46E5; background: #EEF2FF; }
.btn-icon.danger:hover { border-color: #DC2626; color: #DC2626; background: #FEE2E2; }

/* ── Dropdown fix ── */
.ord-actions .dropdown-menu { border-radius: 10px; border: 1px solid #E5E7EB; box-shadow: 0 8px 24px rgba(0,0,0,.12); padding: 6px; min-width: 170px; left: auto; right: 0; }
.ord-actions .dropdown-menu > li > a { border-radius: 7px; padding: 8px 12px; font-size: 13px; color: #374151; display: flex; align-items: center; gap: 8px; }
.ord-actions .dropdown-menu > li > a:hover { background: #F3F4F6; color: #111827; }
.ord-actions .dropdown-menu > li > a.danger { color: #DC2626; }
.ord-actions .dropdown-menu > li > a.danger:hover { background: #FEE2E2; }
.ord-actions .dropdown-menu .divider { margin: 4px 0; }

/* ── Modal ── */
#orderDetailModal .modal-dialog { width: 820px; max-width: 96%; }
#orderDetailModal .modal-content { border: none; border-radius: 14px; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,.22); }
#orderDetailModal .modal-header { background: #111827; padding: 18px 24px; border: none; }
#orderDetailModal .modal-header .modal-title { color: #fff; font-size: 16px; font-weight: 700; }
#orderDetailModal .modal-header .close { color: #9CA3AF; opacity: 1; font-size: 20px; margin-top: 2px; }
#orderDetailModal .modal-header .close:hover { color: #fff; }
#orderDetailModal .modal-body { padding: 0; }
#orderDetailModal .modal-footer { background: #F9FAFB; border-top: 1px solid #E5E7EB; padding: 14px 20px; }

/* Modal left pane */
.ord-modal-left { background: #F9FAFB; border-right: 1px solid #E5E7EB; padding: 22px; }
.ord-modal-right { padding: 22px; }
.ord-info-section { margin-bottom: 20px; }
.ord-info-section-title { font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: .8px; color: #9CA3AF; margin-bottom: 12px; padding-bottom: 6px; border-bottom: 1px solid #E5E7EB; }
.ord-info-row { display: flex; align-items: flex-start; margin-bottom: 8px; }
.ord-info-icon { width: 28px; flex-shrink: 0; color: #9CA3AF; font-size: 12px; padding-top: 2px; }
.ord-info-text { font-size: 13px; color: #374151; line-height: 1.4; }
.ord-info-text a { color: #4F46E5; text-decoration: none; }
.ord-info-text a:hover { text-decoration: underline; }
.ord-info-text strong { color: #111827; }

/* Modal products table */
.prod-table { width: 100%; border-collapse: collapse; font-size: 13px; }
.prod-table th { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: #9CA3AF; padding: 6px 10px; border-bottom: 1px solid #E5E7EB; background: #FAFAFA; }
.prod-table td { padding: 10px 10px; border-bottom: 1px solid #F3F4F6; vertical-align: middle; color: #374151; }
.prod-table tr:last-child td { border-bottom: none; }
.prod-table .prod-img { width: 32px; height: 32px; object-fit: cover; border-radius: 4px; border: 1px solid #E5E7EB; }
.prod-table .prod-name { font-weight: 600; color: #111827; }
.prod-table .prod-meta { font-size: 11px; color: #9CA3AF; }
.prod-table tfoot td { background: #111827; color: #fff; font-weight: 700; padding: 10px; }

/* Modal footer buttons */
.ord-modal-footer-actions { display: flex; gap: 8px; align-items: center; }
.ord-status-btn { border: none; border-radius: 8px; padding: 7px 14px; font-size: 12px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 5px; transition: all .15s; }
.ord-status-btn.proc { background: #D1FAE5; color: #059669; }
.ord-status-btn.proc:hover { background: #059669; color: #fff; }
.ord-status-btn.pend { background: #FEF3C7; color: #D97706; }
.ord-status-btn.pend:hover { background: #D97706; color: #fff; }
.ord-status-btn.rejt { background: #FEE2E2; color: #DC2626; }
.ord-status-btn.rejt:hover { background: #DC2626; color: #fff; }

/* ── Settings ── */
.settings-section-title { font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: #6B7280; margin-bottom: 14px; }
.settings-card { background: #fff; border: 1px solid #E5E7EB; border-radius: 10px; padding: 20px 22px; margin-bottom: 14px; }
.settings-card h5 { font-size: 14px; font-weight: 700; margin: 0 0 12px; color: #111827; }
.settings-card .form-control { border-radius: 7px; border-color: #E5E7EB; font-size: 13px; }
.settings-card .btn-save { background: #4F46E5; color: #fff; border: none; border-radius: 7px; padding: 7px 18px; font-size: 13px; font-weight: 600; cursor: pointer; }
.settings-card .btn-save:hover { background: #4338CA; }

/* ── No orders ── */
.ord-empty { text-align: center; padding: 60px 20px; color: #9CA3AF; }
.ord-empty i { font-size: 48px; margin-bottom: 14px; display: block; color: #D1D5DB; }
.ord-empty p { font-size: 15px; font-weight: 600; margin: 0; }

/* Pagination override */
.ord-page .pagination > li > a,
.ord-page .pagination > li > span { border-radius: 7px !important; margin: 0 2px; border: 1px solid #E5E7EB; color: #4F46E5; font-size: 13px; }
.ord-page .pagination > .active > a { background: #4F46E5; border-color: #4F46E5; color: #fff; }

/* ── Inline expand toggle ── */
.ord-toggle { background: none; border: none; padding: 2px 5px; cursor: pointer; color: #9CA3AF; font-size: 12px; transition: transform .2s, color .15s; vertical-align: middle; outline: none; border-radius: 4px; }
.ord-toggle:hover { color: #4F46E5; background: #EEF2FF; }
.ord-toggle.open { transform: rotate(90deg); color: #4F46E5; }
.order-detail-row > td { padding: 0 !important; background: #F8F7FF !important; }
.order-inline-wrap { padding: 12px 16px 12px 56px; border-top: 2px solid #EEF2FF; }
.order-inline-wrap .prod-table { margin: 0; background: #fff; border-radius: 8px; overflow: hidden; border: 1px solid #E5E7EB; }
.order-inline-wrap .prod-table th { background: #F3F4F6; }
.order-detail-row { display: none; }
</style>

<div class="ord-page">

<!-- ── Page header ── -->
<div class="ord-page-header">
    <h1 class="ord-page-title">
        <i class="fa fa-list-alt" style="color:#4F46E5; margin-right:8px;"></i>
        Orders
        <?php if (isset($_GET['settings'])) { ?><span>/ Settings</span><?php } ?>
    </h1>
    <div>
        <?php if (!isset($_GET['settings'])) { ?>
            <a href="?settings" class="btn-icon" title="Settings" style="width:auto; padding:0 12px; font-size:12px; font-weight:600; text-decoration:none; display:inline-flex; height:32px;">
                <i class="fa fa-cog" style="margin-right:5px;"></i> Settings
            </a>
        <?php } else { ?>
            <a href="<?= base_url('admin/orders') ?>" class="btn-icon" style="width:auto; padding:0 12px; font-size:12px; font-weight:600; text-decoration:none; display:inline-flex; height:32px;">
                <i class="fa fa-arrow-left" style="margin-right:5px;"></i> Back
            </a>
        <?php } ?>
    </div>
</div>

<?php if (!isset($_GET['settings'])) { ?>

<!-- ── Stat cards ── -->
<div class="ord-stats">
    <div class="ord-stat">
        <div class="stat-icon all"><i class="fa fa-shopping-bag"></i></div>
        <div><div class="stat-num"><?= $count_all ?></div><div class="stat-lbl">Total</div></div>
    </div>
    <div class="ord-stat">
        <div class="stat-icon pend"><i class="fa fa-clock-o"></i></div>
        <div><div class="stat-num"><?= $count_pending ?></div><div class="stat-lbl">Pending</div></div>
    </div>
    <div class="ord-stat">
        <div class="stat-icon proc"><i class="fa fa-check-circle"></i></div>
        <div><div class="stat-num"><?= $count_processed ?></div><div class="stat-lbl">Processed</div></div>
    </div>
    <div class="ord-stat">
        <div class="stat-icon rejt"><i class="fa fa-times-circle"></i></div>
        <div><div class="stat-num"><?= $count_rejected ?></div><div class="stat-lbl">Rejected</div></div>
    </div>
</div>

<?php if (!empty($orders)) { ?>

<!-- ── Toolbar ── -->
<div class="ord-toolbar">
    <div class="ord-filters">
        <span class="ord-filter-btn active" data-filter="all">All <span class="count"><?= $count_all ?></span></span>
        <span class="ord-filter-btn" data-filter="0">Pending <span class="count"><?= $count_pending ?></span></span>
        <span class="ord-filter-btn" data-filter="1">Processed <span class="count"><?= $count_processed ?></span></span>
        <span class="ord-filter-btn" data-filter="2">Rejected <span class="count"><?= $count_rejected ?></span></span>
    </div>
    <select class="ord-sort selectpicker changeOrder">
        <option <?= isset($_GET['order_by']) && $_GET['order_by'] == 'id' ? 'selected' : '' ?> value="id">Newest first</option>
        <option <?= (isset($_GET['order_by']) && $_GET['order_by'] == 'processed') || !isset($_GET['order_by']) ? 'selected' : '' ?> value="processed">By status</option>
    </select>
</div>

<!-- ── Orders table ── -->
<div class="ord-table-wrap">
    <table class="ord-table" id="ordersTable">
        <thead>
            <tr>
                <th>Order</th>
                <th>Date</th>
                <th>Customer</th>
                <th>Payment</th>
                <th style="text-align:center;">Status</th>
                <th style="text-align:center;">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($orders as $tr) {
            if ($tr['processed'] == 0)     { $bc = 'pend'; $bl = 'Pending';   $bi = 'fa-clock-o'; }
            elseif ($tr['processed'] == 1) { $bc = 'proc'; $bl = 'Processed'; $bi = 'fa-check'; }
            else                           { $bc = 'rejt'; $bl = 'Rejected';  $bi = 'fa-times'; }

            // Pre-render product rows
            $arr_products = @unserialize($tr['products']);
            ob_start();
            $grand_qty = 0; $grand_amt = 0;
            if (is_array($arr_products)) {
                foreach ($arr_products as $product) {
                    $details = get_product_details($product['product_info']['id'] ?? null);
                    $img_url = base_url('attachments/shop_images/' . ($product['product_info']['image'] ?? ''));
                    $fallback = base_url('attachments/shop_images/spark_logo-06.jpg');
                    $wsp = $details ? (float)($details->wsp ?? $details->price ?? 0) : (float)($product['product_info']['price'] ?? 0);
                    $qty = (int)($product['product_quantity'] ?? 0);
                    $grand_qty += $qty;
                    $grand_amt += $wsp * $qty;
                    ?>
                    <tr>
                        <td><img src="<?= $img_url ?>" onerror="this.onerror=null;this.src='<?= $fallback ?>'" style="width:32px;height:32px;object-fit:cover;border-radius:4px;border:1px solid #E5E7EB;display:block;"></td>
                        <td>
                            <div class="prod-name"><?= $details ? htmlspecialchars($details->title ?? 'N/A') : '<em style="color:#9CA3AF;">Unknown</em>' ?></div>
                            <div class="prod-meta"><?= $details ? htmlspecialchars(trim(($details->color ?? '') . ' ' . ($details->size_range ?? ''))) : '' ?></div>
                        </td>
                        <td style="text-align:center; font-weight:700; color:#374151;"><?= $qty ?> pcs</td>
                        <td style="text-align:right; color:#6B7280;">₹<?= number_format($wsp, 2) ?></td>
                        <td style="text-align:right; font-weight:700; color:#111827;">₹<?= number_format($wsp * $qty, 2) ?></td>
                    </tr>
                <?php }
            }
            $products_html = ob_get_clean();
        ?>
        <tr class="order-row" data-status="<?= $tr['processed'] ?>" data-db-id="<?= $tr['id'] ?>">
            <!-- Order # -->
            <td>
                <button type="button" class="ord-toggle" data-target="detail-row-<?= $tr['id'] ?>" title="Toggle items"><i class="fa fa-chevron-right"></i></button>
                <div class="ord-id" style="display:inline-block;">#<?= $tr['order_id'] ?>
                    <?php if ($tr['viewed'] == 0) { ?><span class="ord-new">NEW</span><?php } ?>
                </div>
                <div class="ord-conf <?= $tr['confirmed'] == 1 ? 'yes' : 'no' ?>">
                    <i class="fa <?= $tr['confirmed'] == 1 ? 'fa-check-circle' : 'fa-times-circle' ?>"></i>
                    <?= $tr['confirmed'] == 1 ? 'Confirmed' : 'Unconfirmed' ?>
                </div>
                <!-- Compat shim for mine_admin.js -->
                <div data-action-id="<?= $tr['id'] ?>" style="display:none;"><div class="status"><b></b></div></div>
            </td>
            <!-- Date -->
            <td>
                <div class="ord-date-main"><?= date('d M Y', $tr['date']) ?></div>
                <div class="ord-date-time"><?= date('H:i', $tr['date']) ?></div>
            </td>
            <!-- Customer -->
            <td>
                <?php
                // Primary company: prefer account profile company, fall back to what was submitted at checkout
                $display_company = !empty($tr['buyer_company']) ? $tr['buyer_company'] : ($tr['company'] ?? '');
                $display_gst     = !empty($tr['buyer_gst'])     ? $tr['buyer_gst']     : ($tr['gst']     ?? '');
                $display_contact = trim($tr['first_name'] . ' ' . $tr['last_name']);
                ?>
                <?php if (!empty($display_company)): ?>
                <div class="ord-cust-name"><i class="fa fa-building" style="width:14px;color:#6B7280;"></i> <?= htmlspecialchars($display_company) ?></div>
                <?php endif; ?>
                <?php if (!empty($display_contact)): ?>
                <div class="ord-cust-meta"><i class="fa fa-user" style="width:12px;"></i> <?= htmlspecialchars($display_contact) ?></div>
                <?php endif; ?>
                <?php if (!empty($display_gst)): ?>
                <div class="ord-cust-meta text-muted" style="font-size:10px;">GST: <?= htmlspecialchars($display_gst) ?></div>
                <?php endif; ?>
                <div class="ord-cust-meta"><i class="fa fa-phone" style="width:12px;"></i> <?= htmlspecialchars($tr['phone'] ?? '') ?></div>
                <div class="ord-cust-meta"><i class="fa fa-envelope" style="width:12px;"></i> <?= htmlspecialchars($tr['email'] ?? '') ?></div>
            </td>
            <!-- Payment -->
            <td><span class="pay-badge"><?= htmlspecialchars($tr['payment_type'] ?? '') ?></span></td>
            <!-- Status -->
            <td style="text-align:center;">
                <span class="ord-badge <?= $bc ?>" id="status-badge-<?= $tr['id'] ?>">
                    <i class="fa <?= $bi ?>"></i> <?= $bl ?>
                </span>
            </td>
            <!-- Actions -->
            <td>
                <div class="ord-actions">
                    <button class="btn-icon" title="View Details"
                        onclick="openOrderDetail(<?= $tr['id'] ?>,<?= $tr['order_id'] ?>,'<?= addslashes(htmlspecialchars(trim($tr['first_name'].' '.$tr['last_name']))) ?>','<?= addslashes($tr['phone'] ?? '') ?>','<?= addslashes($tr['email'] ?? '') ?>','<?= addslashes(trim(($tr['city'] ?? '').($tr['city'] ? ', ' : '').($tr['address'] ?? ''))) ?>','<?= addslashes($tr['payment_type'] ?? '') ?>','<?= date('d M Y, H:i', $tr['date']) ?>','<?= addslashes($tr['notes'] ?? '') ?>',<?= $tr['processed'] ?>,'<?= htmlentities($tr['products']) ?>','<?= addslashes($tr['email'] ?? '') ?>')">
                        <i class="fa fa-eye"></i>
                    </button>
                    <div class="btn-group dropup">
                        <button type="button" class="btn-icon dropdown-toggle" data-toggle="dropdown" title="Change status">
                            <i class="fa fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="javascript:void(0);" onclick="changeOrdersOrderStatus(<?= $tr['id'] ?>,1,'<?= htmlentities($tr['products']) ?>','<?= $tr['email'] ?>')">
                                <i class="fa fa-check" style="color:#059669;width:14px;"></i> Mark Processed
                            </a></li>
                            <li><a href="javascript:void(0);" onclick="changeOrdersOrderStatus(<?= $tr['id'] ?>,0)">
                                <i class="fa fa-clock-o" style="color:#D97706;width:14px;"></i> Mark Pending
                            </a></li>
                            <li><a href="javascript:void(0);" onclick="changeOrdersOrderStatus(<?= $tr['id'] ?>,2)">
                                <i class="fa fa-times" style="color:#DC2626;width:14px;"></i> Mark Rejected
                            </a></li>
                            <li class="divider"></li>
                            <li><a href="<?= base_url('admin/orders/delete/'.$tr['id']) ?>"
                                onclick="return confirm('Delete order #<?= $tr['order_id'] ?>? This cannot be undone.')"
                                class="danger">
                                <i class="fa fa-trash" style="width:14px;"></i> Delete
                            </a></li>
                        </ul>
                    </div>
                </div>
            </td>
        </tr>
        <!-- Inline expandable product detail row -->
        <tr class="order-detail-row" id="detail-row-<?= $tr['id'] ?>" data-status="<?= $tr['processed'] ?>">
            <td colspan="6">
                <div class="order-inline-wrap">
                    <table class="prod-table">
                        <thead>
                            <tr>
                                <th style="width:48px;"></th>
                                <th>Product</th>
                                <th style="text-align:center;width:60px;">Qty</th>
                                <th style="text-align:right;width:80px;">WSP</th>
                                <th style="text-align:right;width:90px;">Total</th>
                            </tr>
                        </thead>
                        <tbody><?= $products_html ?></tbody>
                        <?php if ($grand_qty > 0) { ?>
                        <tfoot>
                            <tr>
                                <td colspan="2" style="text-align:right;background:#111827;color:#fff;padding:8px 10px;font-size:12px;font-weight:700;">
                                    <?= $grand_qty ?> items total
                                </td>
                                <td style="text-align:center;background:#111827;color:#fff;padding:8px 10px;font-weight:800;"><?= $grand_qty ?></td>
                                <td style="background:#111827;"></td>
                                <td style="text-align:right;background:#111827;color:#fff;padding:8px 10px;font-weight:800;">₹<?= number_format($grand_amt, 2) ?></td>
                            </tr>
                        </tfoot>
                        <?php } ?>
                    </table>
                </div>
            </td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<div style="margin-top:16px; text-align:right;"><?= $links_pagination ?></div>

<?php } else { ?>
<div class="ord-empty">
    <i class="fa fa-inbox"></i>
    <p>No orders yet</p>
</div>
<?php } ?>

<?php } // end !settings ?>

<!-- ── Settings ── -->
<?php if (isset($_GET['settings'])) { ?>
<div class="settings-section-title"><i class="fa fa-cog"></i> Payment Settings</div>
<div class="row">
    <div class="col-sm-5">
        <div class="settings-card">
            <h5><i class="fa fa-truck" style="color:#4F46E5;margin-right:6px;"></i>Cash On Delivery</h5>
            <?php if ($this->session->flashdata('cashondelivery_visibility')) { ?>
                <div class="alert alert-info" style="font-size:12px;padding:8px 12px;border-radius:7px;"><?= $this->session->flashdata('cashondelivery_visibility') ?></div>
            <?php } ?>
            <form method="POST" action="">
                <div style="display:flex;align-items:center;gap:12px;">
                    <input type="hidden" name="cashondelivery_visibility" value="<?= htmlspecialchars($cashondelivery_visibility) ?>">
                    <input <?= $cashondelivery_visibility == 1 ? 'checked' : '' ?> data-toggle="toggle" data-for-field="cashondelivery_visibility" class="toggle-changer" type="checkbox">
                    <button class="btn-save" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-sm-5">
        <div class="settings-card">
            <h5><i class="fa fa-paypal" style="color:#4F46E5;margin-right:6px;"></i>PayPal Business Email</h5>
            <?php if ($this->session->flashdata('paypal_email')) { ?>
                <div class="alert alert-info" style="font-size:12px;padding:8px 12px;border-radius:7px;"><?= htmlspecialchars($this->session->flashdata('paypal_email')) ?></div>
            <?php } ?>
            <form method="POST" action="">
                <div style="display:flex;gap:8px;">
                    <input class="form-control" name="paypal_email" value="<?= htmlspecialchars($paypal_email) ?>" type="text" placeholder="Leave empty to disable">
                    <button class="btn-save" type="submit" style="white-space:nowrap;">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="settings-section-title" style="margin-top:8px;"><i class="fa fa-university"></i> Bank Account</div>
<div class="row">
    <div class="col-sm-6">
        <div class="settings-card">
            <?php if ($this->session->flashdata('bank_account')) { ?>
                <div class="alert alert-success" style="font-size:12px;padding:8px 12px;border-radius:7px;"><?= $this->session->flashdata('bank_account') ?></div>
            <?php } ?>
            <form method="POST" action="">
                <div class="form-group">
                    <label style="font-size:12px;color:#6B7280;font-weight:600;">Recipient Name / Company</label>
                    <input type="text" name="name" value="<?= $bank_account != null ? htmlspecialchars($bank_account['name']) : '' ?>" class="form-control" placeholder="e.g. House of Stitches Pvt Ltd">
                </div>
                <div class="row">
                    <div class="col-sm-7">
                        <div class="form-group">
                            <label style="font-size:12px;color:#6B7280;font-weight:600;">Account No / IBAN</label>
                            <input type="text" class="form-control" value="<?= $bank_account != null ? htmlspecialchars($bank_account['iban']) : '' ?>" name="iban" placeholder="Account number">
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label style="font-size:12px;color:#6B7280;font-weight:600;">IFSC / BIC</label>
                            <input type="text" class="form-control" value="<?= $bank_account != null ? htmlspecialchars($bank_account['bic']) : '' ?>" name="bic" placeholder="IFSC code">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label style="font-size:12px;color:#6B7280;font-weight:600;">Bank Name</label>
                    <input type="text" value="<?= $bank_account != null ? htmlspecialchars($bank_account['bank']) : '' ?>" name="bank" class="form-control" placeholder="e.g. Axis Bank">
                </div>
                <button type="submit" class="btn-save" style="width:100%;padding:10px;border-radius:8px;font-size:13px;">
                    <i class="fa fa-save"></i> Save Bank Settings
                </button>
            </form>
        </div>
    </div>
</div>
<?php } ?>

</div><!-- end .ord-page -->

<!-- ── Order Detail Modal ── -->
<div class="modal fade" id="orderDetailModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="width:820px;max-width:96%;margin:40px auto;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="modal-title">
                    Order <strong id="modal-order-num"></strong>
                    &nbsp;<span id="modal-status-badge"></span>
                </div>
            </div>
            <div class="modal-body">
                <div class="row" style="margin:0;">
                    <div class="col-sm-4 ord-modal-left" style="padding:22px;">
                        <div class="ord-info-section">
                            <div class="ord-info-section-title">Customer</div>
                            <div class="ord-info-row"><div class="ord-info-icon"><i class="fa fa-user"></i></div><div class="ord-info-text" id="m-name"></div></div>
                            <div class="ord-info-row"><div class="ord-info-icon"><i class="fa fa-phone"></i></div><div class="ord-info-text" id="m-phone"></div></div>
                            <div class="ord-info-row"><div class="ord-info-icon"><i class="fa fa-envelope"></i></div><div class="ord-info-text" id="m-email"></div></div>
                            <div class="ord-info-row"><div class="ord-info-icon"><i class="fa fa-map-marker"></i></div><div class="ord-info-text" id="m-address"></div></div>
                        </div>
                        <div class="ord-info-section">
                            <div class="ord-info-section-title">Order Info</div>
                            <div class="ord-info-row"><div class="ord-info-icon"><i class="fa fa-credit-card"></i></div><div class="ord-info-text" id="m-payment"></div></div>
                            <div class="ord-info-row"><div class="ord-info-icon"><i class="fa fa-calendar"></i></div><div class="ord-info-text" id="m-date"></div></div>
                            <div class="ord-info-row" id="m-notes-wrap" style="display:none;"><div class="ord-info-icon"><i class="fa fa-sticky-note"></i></div><div class="ord-info-text" id="m-notes"></div></div>
                        </div>
                    </div>
                    <div class="col-sm-8 ord-modal-right" style="padding:22px;">
                        <div class="ord-info-section-title">Products</div>
                        <div class="table-responsive" style="margin-top:10px;">
                            <table class="prod-table">
                                <thead>
                                    <tr>
                                        <th style="width:50px;"></th>
                                        <th>Product</th>
                                        <th style="text-align:center;width:60px;">Qty</th>
                                        <th style="text-align:right;width:70px;">WSP</th>
                                        <th style="text-align:right;width:80px;">Total</th>
                                    </tr>
                                </thead>
                                <tbody id="modal-products-body"></tbody>
                                <tfoot id="modal-products-foot"></tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="pull-left ord-modal-footer-actions">
                    <span style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#9CA3AF;margin-right:4px;">Status:</span>
                    <button class="ord-status-btn proc" id="modal-btn-proc"><i class="fa fa-check"></i> Processed</button>
                    <button class="ord-status-btn pend" id="modal-btn-pend"><i class="fa fa-clock-o"></i> Pending</button>
                    <button class="ord-status-btn rejt" id="modal-btn-rejt"><i class="fa fa-times"></i> Rejected</button>
                </div>
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('assets/js/bootstrap-toggle.min.js') ?>"></script>
<script>
// ── Inline row toggle (only needs jQuery, available immediately) ──
$(document).on('click', '.ord-toggle', function() {
    var targetId = $(this).data('target');
    $(this).toggleClass('open');
    $('#' + targetId).toggle();
});

// ── Filter pills ──
$(document).on('click', '.ord-filter-btn', function() {
    $('.ord-filter-btn').removeClass('active');
    $(this).addClass('active');
    var f = $(this).data('filter');
    var $rows = $('#ordersTable tbody tr.order-row');
    $('#ordersTable tbody tr.order-detail-row').hide();
    $('.ord-toggle').removeClass('open');
    f === 'all' ? $rows.show() : $rows.hide().filter('[data-status="' + f + '"]').show();
});

// ── Open order detail modal (global — called from inline onclick) ──
window._modalOpenDbId = null;
window.openOrderDetail = function(dbId, ordNum, name, phone, email, address, payment, date, notes, status, products, userEmail) {
    window._modalOpenDbId = dbId;
    var badgeMap = {
        0: '<span class="ord-badge pend"><i class="fa fa-clock-o"></i> Pending</span>',
        1: '<span class="ord-badge proc"><i class="fa fa-check"></i> Processed</span>',
        2: '<span class="ord-badge rejt"><i class="fa fa-times"></i> Rejected</span>'
    };
    $('#modal-order-num').text('#' + ordNum);
    $('#modal-status-badge').html(badgeMap[status] || '');
    $('#m-name').html('<strong>' + name + '</strong>');
    $('#m-phone').html('<a href="tel:' + phone + '">' + phone + '</a>');
    $('#m-email').html('<a href="mailto:' + email + '">' + email + '</a>');
    $('#m-address').text(address || '—');
    $('#m-payment').html('<span class="pay-badge">' + payment + '</span>');
    $('#m-date').text(date);
    if (notes) { $('#m-notes').text(notes); $('#m-notes-wrap').show(); }
    else { $('#m-notes-wrap').hide(); }

    var $bodyRows = $('#detail-row-' + dbId + ' tbody tr').clone();
    var $footRow  = $('#detail-row-' + dbId + ' tfoot tr').clone();
    $('#modal-products-body').html($bodyRows.length ? $bodyRows : '<tr><td colspan="5" style="text-align:center;color:#9CA3AF;padding:20px;">No products</td></tr>');
    $('#modal-products-foot').html($footRow.length ? $footRow : '');

    $('#modal-btn-proc').off('click').on('click', function() { changeOrdersOrderStatus(dbId, 1, products, userEmail); });
    $('#modal-btn-pend').off('click').on('click', function() { changeOrdersOrderStatus(dbId, 0); });
    $('#modal-btn-rejt').off('click').on('click', function() { changeOrdersOrderStatus(dbId, 2); });

    $('#orderDetailModal').modal('show');
};

// ── Wrap changeOrdersOrderStatus AFTER mine_admin.js loads ──
$(window).on('load', function() {
    if (typeof changeOrdersOrderStatus === 'function') {
        var _orig = changeOrdersOrderStatus;
        changeOrdersOrderStatus = function(id, to_status, products, userEmail) {
            _orig(id, to_status, products, userEmail);
            var badgeMap = {
                0: '<span class="ord-badge pend"><i class="fa fa-clock-o"></i> Pending</span>',
                1: '<span class="ord-badge proc"><i class="fa fa-check"></i> Processed</span>',
                2: '<span class="ord-badge rejt"><i class="fa fa-times"></i> Rejected</span>'
            };
            setTimeout(function() {
                var $old = $('#status-badge-' + id);
                $old.replaceWith($(badgeMap[to_status]).attr('id', 'status-badge-' + id));
                $('[data-db-id="' + id + '"]').attr('data-status', to_status);
                $('#detail-row-' + id).attr('data-status', to_status);
                if (window._modalOpenDbId == id) {
                    $('#modal-status-badge').html(badgeMap[to_status]);
                }
            }, 350);
        };
    }
});
</script>
