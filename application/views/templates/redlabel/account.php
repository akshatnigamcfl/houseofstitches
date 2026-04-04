<title>Shop | Bulk Clothing Supplier – House of Stitches</title>
<meta name="description"
    content="Browse our wholesale kidswear shop – premium bulk clothing for boys & girls aged 6–15 years. Trusted supplier in India for bulk orders only. Quality at scale.">
<meta name="keywords"
    content="wholesale kidswear shop, bulk kids clothing India, wholesale children’s fashion, kidswear supplier India, wholesale boys & girls wear, bulk order kids clothes, kidswear wholesale online, wholesale kids clothing distributor, House of Stitches shop, kidswear wholesale supplier">
<script>
    const USER_ROLE = "<?= htmlspecialchars($user_role) ?>"; // set from DB: agent, distributor, wholesaler, retailer
</script>

<div class="account_page">
    <div class="container-fluid d-flex align-items-start gap-3">
        <div class="sidebar-overlay d-lg-none" id="sidebarOverlay"
            onclick="closeSidebar()"></div>
        <div class="accountsidebar shadow d-lg-block" id="accountSidebar">
            <div class="brand">
                <div class="logo"><img src="<?php echo base_url(); ?>assets/gallery/favicon.webp" alt="logo" class="w-100"></div>
                <div>
                    <h1 class="title">House of Stitches</h1>
                    <h2 class="fs-6">Member Dashboard</h2>
                </div>
                <a class="btn btn-outline-muted d-block d-lg-none mb-3 p-0" onclick="closeSidebar()" aria-label="Close Sidebar">
                    <i class="bi bi-x-lg"></i>
                </a>
            </div>
            <ul class="nav flex-column nav-pills" id="pills-tab" role="tablist">
                <li class="nav-item role-all" role="presentation">
                    <a class="nav-link active position-relative" id="account-tab" data-bs-toggle="pill"
                        data-bs-target="#account" type="button" role="tab" aria-controls="account"
                        aria-selected="true"><i class="bi bi-house-door me-2"></i></i>Home</a>
                </li>
                <?php if ($user_role !== 'retailer'): ?>
                <li class="nav-item role-all" role="presentation">
                    <a class="nav-link position-relative" id="clients-tab" data-bs-toggle="pill"
                        data-bs-target="#clients" type="button" role="tab" aria-controls="clients"
                        aria-selected="true"><i class="bi bi-people-fill me-2"></i></i>My Clients</a>
                </li>
                <?php endif; ?>
                <li class="nav-item role-all" role="presentation">
                    <a class="nav-link position-relative" id="myorders-tab" data-bs-toggle="pill" data-bs-target="#myorders"
                        type="button" role="tab" aria-controls="myorders" aria-selected="false"><i
                            class="bi bi-receipt me-2"></i>My Orders</a>
                </li>
                <?php if ($user_role !== 'retailer'): ?>
                <li class="nav-item role-all" role="presentation">
                    <a class="nav-link position-relative" id="retailerorders-tab" data-bs-toggle="pill" data-bs-target="#retailerorders"
                        type="button" role="tab" aria-controls="retailerorders" aria-selected="false"><i
                            class="bi bi-shop me-2"></i>Retailer Orders</a>
                </li>
                <?php endif; ?>
                <li class="nav-item role-all" role="presentation">
                    <a class="nav-link position-relative" id="track-tab" data-bs-toggle="pill" data-bs-target="#track"
                        type="button" role="tab" aria-controls="track" aria-selected="false"><i
                            class="bi bi-truck me-2"></i>Tracking</a>
                </li>
                <?php if ($user_role === 'agent'): ?>
                <li class="nav-item role-all" role="presentation">
                    <a class="nav-link position-relative" id="commission-tab" data-bs-toggle="pill" data-bs-target="#commission"
                        type="button" role="tab" aria-controls="commission" aria-selected="false"><i
                            class="bi bi-currency-rupee me-2"></i>Commission</a>
                </li>
                <?php endif; ?>
                <?php if (empty($hide_finance_tabs)): ?>
                <li class="nav-item role-all" role="presentation">
                    <a class="nav-link position-relative" id="ledger-tab" data-bs-toggle="pill" data-bs-target="#ledger"
                        type="button" role="tab" aria-controls="ledger" aria-selected="false"><i
                            class="bi bi-person-lines-fill me-2"></i>Ledger</a>
                </li>
                <?php endif; ?>
                <li class="nav-item role-all" role="presentation">
                    <a class="nav-link position-relative" id="claim-tab" data-bs-toggle="pill" data-bs-target="#claim"
                        type="button" role="tab" aria-controls="claim" aria-selected="false"><i
                            class="bi bi-file-earmark-check me-2"></i>Claim</a>
                </li>
                <li class="nav-item role-all" role="presentation">
                    <a class="nav-link position-relative" id="coupons-tab" data-bs-toggle="pill"
                        data-bs-target="#coupons" type="button" role="tab" aria-controls="coupons"
                        aria-selected="false"><i class="bi bi-ticket-perforated me-2"></i>Coupons</a>
                </li>
                <li class="nav-item role-all" role="presentation">
                    <a class="nav-link position-relative" id="addresses-tab" data-bs-toggle="pill"
                        data-bs-target="#addresses" type="button" role="tab" aria-controls="addresses"
                        aria-selected="false"><i class="bi bi-geo-alt me-2"></i>Addresses</a>
                </li>
                <?php if (empty($hide_finance_tabs)): ?>
                <li class="nav-item role-all" role="presentation">
                    <a class="nav-link position-relative" id="payments-tab" data-bs-toggle="pill"
                        data-bs-target="#payments" type="button" role="tab" aria-controls="payments"
                        aria-selected="false"><i class="bi bi-credit-card-2-front me-2"></i>Payments</a>
                </li>
                <?php endif; ?>
                <li class="nav-item role-all" role="presentation">
                    <a class="nav-link position-relative" id="accountsettings-tab" data-bs-toggle="pill"
                        data-bs-target="#accountsettings" type="button" role="tab" aria-controls="accountsettings"
                        aria-selected="false"><i class="bi bi-gear me-2"></i>Account Settings</a>
                </li>
            </ul>
            <div class="sidebar-footer">
                <div class="fw-semibold">Support <a href="tel:9644664338" class="mute"> +91 9644664338</a></div>
                <a href="<?php echo base_url('logout'); ?>" class="btn btn-outline-danger fw-semibold mt-3 w-100"><i class="bi bi-box-arrow-right"></i>
                    Sign out</a>
            </div>
        </div>
        <div class="accountdetails">
            <div class="topbar d-flex justify-content-end px-4 py-2 shadow-sm bg-white">
                <button class="btn btn-outline-muted d-lg-none me-auto" onclick="openSidebar()" aria-label="Open Sidebar">
                    <i class="bi bi-list fs-3"></i>
                </button>
                <div class="d-flex align-items-center gap-3">
                    <a href="#" class="text-dark position-relative">
                        <i class="bi bi-bell fs-5"></i>
                    </a>
                    <div class="d-flex align-items-center gap-2">
                        <div class="text-end d-none d-md-block">
                            <div class="fw-bold"><?php echo get_loggedin_user_details()->name; ?></div>
                            <div class="text-muted"><?php echo get_loggedin_user_details()->email; ?></div>
                        </div>
                        <img id="userAvatar"
                            src="https://ui-avatars.com/api/?name=AS&background=0b4db0&color=fff&rounded=true&size=48"
                            alt="avatar" class="rounded-circle" style="width:40px;height:40px;">
                    </div>
                </div>
            </div>
            <div class="tab-content w-100" id="pills-tabContent">
                <div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="account-tab">
                    <?php
                    $__ud       = get_loggedin_user_details();
                    $__created  = $__ud->created ?? null;
                    $__memberSince = $__created
                        ? (is_numeric($__created) ? date('d M Y', (int)$__created) : date('d M Y', strtotime($__created)))
                        : '—';
                    $__roleLabel = ucfirst($user_role ?? 'member');
                    $__totalOrders  = $my_stats['total']   ?? 0;
                    $__pendingDisp  = $my_stats['pending']  ?? 0;
                    $__pendingPay   = $pay_stats['pending'] ?? 0.0;
                    ?>
                    <div class="row g-4 mt-2">
                        <div class="col-xl-8">
                            <div class="bg-white rounded-4 shadow-sm p-4">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div>
                                        <h2 class="fw-bold mb-1">
                                            Welcome, <?php echo htmlspecialchars($__ud->name); ?>
                                        </h2>
                                        <p class="text-muted mb-0">Business overview &amp; recent activity</p>
                                    </div>
                                    <span class="badge rounded-pill bg-dark px-4 py-2 text-uppercase">
                                        <?= $__roleLabel ?>
                                    </span>
                                </div>
                                <hr>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="border rounded-4 p-4 h-100">
                                            <div class="text-muted small mb-1">TOTAL ORDERS</div>
                                            <h2 class="fw-bold mb-0"><?= $__totalOrders ?></h2>
                                            <div class="text-muted small mt-1">All time</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="border rounded-4 p-4 h-100">
                                            <div class="text-muted small mb-1">PENDING PAYMENT</div>
                                            <h2 class="fw-bold text-danger mb-0">₹ <?= number_format($__pendingPay, 0) ?></h2>
                                            <div class="text-muted small mt-1">Outstanding amount</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="border rounded-4 p-4 h-100">
                                            <div class="text-muted small mb-1">PENDING DISPATCH</div>
                                            <h2 class="fw-bold text-info mb-0"><?= $__pendingDisp ?></h2>
                                            <div class="text-muted small mt-1">Awaiting shipment</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="bg-white rounded-4 shadow-sm p-3 h-100">
                                <div class="text-center">
                                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($__ud->name) ?>&background=000000&color=ffffff&rounded=true&size=140"
                                        class="rounded-circle mb-3" width="120">
                                    <h5 class="fw-bold mb-1"><?= htmlspecialchars($__ud->name) ?></h5>
                                    <div class="text-muted mb-2"><?= htmlspecialchars($__ud->email) ?></div>
                                    <span class="badge bg-dark px-4 py-2 mb-3"><?= $__roleLabel ?></span>
                                    <div class="small text-muted mt-1">
                                        Member since <strong><?= $__memberSince ?></strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="clients" role="tabpanel" aria-labelledby="clients-tab">
                    <div class="card-panel my-2">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h5 class="mb-1">My Clients</h5>
                                <small class="text-muted">Manage your retailers and distributors</small>
                            </div>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addClientModal">
                                <i class="bi bi-plus-lg me-1"></i> Add New Client
                            </button>
                            <div class="modal fade" id="addClientModal" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 rounded-2">
                                        <div class="modal-header border-0">
                                            <h5 class="modal-title fw-normal">Add New Client</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body px-4">
                                            <form id="clientForm" novalidate>
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <label for="companyName" class="form-label small">Company Name</label>
                                                        <input type="text" class="form-control" id="companyName">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="email" class="form-label small">Email</label>
                                                        <input type="email" class="form-control" id="email">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="password" class="form-label small">Password</label>
                                                        <div class="position-relative align-items-center d-flex">
                                                            <input type="password" class="form-control" id="password" autocomplete="new-password">
                                                            <i class="bi toggle-password bi-eye-slash" style="position: absolute; right: 12px; cursor: pointer; user-select: none;"
                                                                id="togglePassword"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="phone" class="form-label small">Phone</label>
                                                        <input type="tel" class="form-control" id="phone">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="panNumber" class="form-label small">PAN Number</label>
                                                        <input type="text" class="form-control" id="panNumber" maxlength="10">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="gstNumber" class="form-label small">GST Number</label>
                                                        <input type="text" class="form-control" id="gstNumber" maxlength="15">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="userType" class="form-label small">User Type</label>
                                                        <select class="form-select" id="userType">
                                                            <option value="4" selected>Retailer</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="address" class="form-label small">Address</label>
                                                        <textarea class="form-control" id="address" rows="2"></textarea>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-end gap-2 mt-4">
                                                    <button type="button" class="btn btn-light Cancel" data-bs-dismiss="modal">
                                                        Cancel
                                                    </button>
                                                    <button type="submit" class="btn btn-dark">Save Client</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-sm modal-dialog-centered">
                                    <div class="modal-content border-0 shadow text-center py-4 position-relative">
                                        <button type="button" class="btn-close position-absolute top-0 end-0 m-2" data-bs-dismiss="modal" aria-label="Close"></button>
                                        <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle bg-success text-white"
                                            style="width:60px; height:60px; font-size:1.5rem;">
                                            ✓
                                        </div>
                                        <div class="fw-semibold fs-5">Client Added</div>
                                        <div class="text-muted small">Saved successfully</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Client Modal -->
                        <div class="modal fade" id="editClientModal" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 rounded-2">
                                    <div class="modal-header border-0">
                                        <h5 class="modal-title fw-normal">Edit Client</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body px-4">
                                        <input type="hidden" id="editClientId">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label small">Company Name</label>
                                                <input type="text" class="form-control" id="editCompanyName">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small">Name</label>
                                                <input type="text" class="form-control" id="editName">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small">Email</label>
                                                <input type="email" class="form-control" id="editEmail" readonly tabindex="-1" style="background:#e0e0e0; color:#444; cursor:not-allowed;">
                                                <div class="form-text" style="font-size:11px; color:#888;">Email cannot be changed</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small">Phone</label>
                                                <input type="tel" class="form-control" id="editPhone">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small">PAN Number</label>
                                                <input type="text" class="form-control" id="editPan" maxlength="10">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small">GST Number</label>
                                                <input type="text" class="form-control" id="editGst" maxlength="15">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label small">Address</label>
                                                <textarea class="form-control" id="editAddress" rows="2"></textarea>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label small">New Password <span class="text-muted">(leave blank to keep current)</span></label>
                                                <input type="password" class="form-control" id="editPassword" autocomplete="new-password">
                                            </div>
                                        </div>
                                        <div id="editClientError" class="alert alert-danger mt-3 d-none"></div>
                                        <div class="d-flex justify-content-end gap-2 mt-4">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                            <button type="button" class="btn btn-dark" id="saveEditClientBtn">Save Changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <input class="form-control" placeholder="Search by client name or phone">
                            </div>
                            <div class="col-md-3">
                                <select class="form-select">
                                    <option>All Client Types</option>
                                    <option>Retailer</option>
                                    <option>Wholesaler</option>
                                    <option>Distributor</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select">
                                    <option>All Status</option>
                                    <option>Active</option>
                                    <option>Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button class="btn btn-dark rounded-0 w-100">Apply Filters</button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Client Name</th>
                                        <th>Business</th>
                                        <th>Type</th>
                                        <th>Phone</th>
                                        <th>Total Orders</th>
                                        <th>Total Business</th>
                                        <th>Status</th>
                                        <th width="180">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="clientTableBody">
<?php if (empty($clients)): ?>
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">
                                            <i class="bi bi-people fs-3 d-block mb-2"></i>
                                            No clients yet. Use <strong>Add New Client</strong> to add a retailer.
                                        </td>
                                    </tr>
                                    <?php else: ?>
                                    <?php
                                    $type_labels = [1=>'Agent', 2=>'Distributor', 3=>'Wholesaler', 4=>'Retailer'];
                                    foreach ($clients as $val): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($val->name) ?></td>
                                        <td><?= htmlspecialchars($val->company) ?></td>
                                        <td><span class="badge bg-info text-dark"><?= $type_labels[(int)$val->type] ?? 'Retailer' ?></span></td>
                                        <td><?= htmlspecialchars($val->phone) ?></td>
                                        <td class="client-orders-cell" data-client-id="<?= (int)$val->id ?>">—</td>
                                        <td class="client-business-cell" data-client-id="<?= (int)$val->id ?>">—</td>
                                        <td>
                                            <?php if ($val->status == 1): ?>
                                                <span class="badge bg-success">Active</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-secondary edit-client-btn"
                                                data-id="<?= (int)$val->id ?>"
                                                data-name="<?= htmlspecialchars($val->name, ENT_QUOTES) ?>"
                                                data-company="<?= htmlspecialchars($val->company, ENT_QUOTES) ?>"
                                                data-email="<?= htmlspecialchars($val->email, ENT_QUOTES) ?>"
                                                data-phone="<?= htmlspecialchars($val->phone, ENT_QUOTES) ?>"
                                                data-pan="<?= htmlspecialchars($val->pan ?? '', ENT_QUOTES) ?>"
                                                data-gst="<?= htmlspecialchars($val->gst ?? '', ENT_QUOTES) ?>"
                                                data-address="<?= htmlspecialchars($val->address ?? '', ENT_QUOTES) ?>">
                                                <i class="bi bi-pencil"></i> Edit
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="myorders" role="tabpanel" aria-labelledby="myorders-tab">
                    <div class="d-flex justify-content-between align-items-center my-3 flex-wrap">
                        <div>
                            <small class="text-muted">All your orders — track status, dispatch, and raise returns</small>
                        </div>
                        <div class="d-flex gap-2 mt-2 mt-md-0 flex-wrap">
                            <button class="btn btn-outline-secondary">
                                <i class="bi bi-download"></i> Export Orders
                            </button>
                            <button class="btn_button">
                                <i class="bi bi-bag-check"></i> Create Order
                            </button>
                        </div>
                    </div>
                    <!-- Stats -->
                    <div class="row mb-4 g-3">
                        <div class="col-md-3">
                            <div class="border rounded-4 p-4 h-100">
                                <p class="text-muted m-0">Total Orders</p>
                                <h4><?= $my_stats['total'] ?></h4>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border rounded-4 p-4 h-100">
                                <p class="text-muted m-0">Pending Orders</p>
                                <h4><?= $my_stats['pending'] ?></h4>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border rounded-4 p-4 h-100">
                                <p class="text-muted m-0">Shipped</p>
                                <h4><?= $my_stats['shipped'] ?></h4>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border rounded-4 p-4 h-100">
                                <p class="text-muted m-0">Delivered</p>
                                <h4><?= $my_stats['delivered'] ?></h4>
                            </div>
                        </div>
                    </div>
                    <!-- Filters -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3">Filters</h6>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Order Status</label>
                                    <select class="form-select" id="mo-filter-status">
                                        <option value="">All</option>
                                        <option value="0">Pending</option>
                                        <option value="1">Shipped</option>
                                        <option value="2">Delivered</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Payment Status</label>
                                    <select class="form-select" id="mo-filter-payment">
                                        <option value="">All</option>
                                        <option value="0">Unpaid</option>
                                        <option value="1">Partial</option>
                                        <option value="2">Paid</option>
                                    </select>
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button class="btn btn-dark rounded-0 w-100" id="mo-filter-apply">Apply</button>
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button class="btn btn-outline-secondary rounded-0 w-100" id="mo-filter-reset">Reset</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Orders Table -->
                    <div class="card mb-4">
                        <div class="card-body table-responsive">
                            <table class="table table-hover align-middle" id="mo-table">
                                <thead class="table-light">
                                    <tr>
                                        <th>Order #</th>
                                        <th>Items</th>
                                        <th>Billing Amount</th>
                                        <th>Paid</th>
                                        <th>Order Date</th>
                                        <th>Status</th>
                                        <th>Payment</th>
                                        <th>GR</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($my_orders)): ?>
                                    <?php foreach ($my_orders as $mo):
                                        $mo_products = @unserialize($mo['products']);
                                        $mo_dispatch = [];
                                        if (!empty($mo['dispatch_products'])) { $d = @unserialize($mo['dispatch_products']); if (is_array($d)) $mo_dispatch = $d; }
                                        $mo_items = is_array($mo_products) ? count($mo_products) : 0;
                                        $mo_status_map = [0 => ['label'=>'Pending','class'=>'bg-warning text-dark'], 1 => ['label'=>'Shipped','class'=>'bg-info text-dark'], 2 => ['label'=>'Delivered','class'=>'bg-success']];
                                        $mo_st = $mo_status_map[$mo['processed']] ?? ['label'=>'Unknown','class'=>'bg-secondary'];
                                        $mo_pay_map = [0 => ['label'=>'Unpaid','class'=>'bg-danger'], 1 => ['label'=>'Partial','class'=>'bg-warning text-dark'], 2 => ['label'=>'Paid','class'=>'bg-success']];
                                        $mo_pay = $mo_pay_map[$mo['payment_status']] ?? ['label'=>'Unpaid','class'=>'bg-danger'];
                                        $mo_billing = ($mo['billing_amount'] > 0) ? '₹' . number_format((float)$mo['billing_amount'], 2) : '—';
                                        $mo_paid_amt = ($mo['paid_amount'] > 0) ? '₹' . number_format((float)$mo['paid_amount'], 2) : '₹0.00';
                                        $mo_row_id = 'mo-items-' . (int)$mo['id'];
                                        $mo_gr = $gr_by_order[(int)$mo['id']] ?? null;
                                        $mo_gr_map = ['pending'=>['label'=>'Pending','class'=>'bg-warning text-dark'],'approved'=>['label'=>'Approved','class'=>'bg-info text-dark'],'rejected'=>['label'=>'Rejected','class'=>'bg-danger'],'processed'=>['label'=>'Processed','class'=>'bg-success']];
                                        $mo_gr_badge = $mo_gr ? ($mo_gr_map[$mo_gr['status']] ?? ['label'=>ucfirst($mo_gr['status']),'class'=>'bg-secondary']) : null;
                                        // Build product JSON for GR modal (use dispatched qty, fall back to ordered qty)
                                        $mo_gr_products = [];
                                        if (is_array($mo_products)) {
                                            foreach ($mo_products as $mp) {
                                                $pi  = $mp['product_info'] ?? [];
                                                $pid = (int)($pi['id'] ?? 0);
                                                $disp_qty = isset($mo_dispatch[$pid]) ? (int)$mo_dispatch[$pid] : 0;
                                                if ($disp_qty < 1) $disp_qty = (int)($mp['product_quantity'] ?? 1);
                                                $mo_gr_products[] = [
                                                    'title' => $pi['title'] ?? 'Product',
                                                    'color' => $pi['color'] ?? '',
                                                    'size'  => $pi['size_range'] ?? '',
                                                    'qty'   => $disp_qty,
                                                ];
                                            }
                                        }
                                    ?>
                                    <tr data-bs-toggle="collapse" data-bs-target="#<?= $mo_row_id ?>" data-mo-status="<?= (int)$mo['processed'] ?>" data-mo-payment="<?= (int)$mo['payment_status'] ?>" style="cursor:pointer;">
                                        <td><strong>#<?= (int)$mo['order_id'] ?></strong></td>
                                        <td><?= $mo_items ?> item<?= $mo_items != 1 ? 's' : '' ?></td>
                                        <td><?= $mo_billing ?></td>
                                        <td><?= $mo_paid_amt ?></td>
                                        <td><?= date('d M Y', $mo['date']) ?></td>
                                        <td><span class="badge rounded-pill <?= $mo_st['class'] ?>"><?= $mo_st['label'] ?></span></td>
                                        <td><span class="badge rounded-pill <?= $mo_pay['class'] ?>"><?= $mo_pay['label'] ?></span></td>
                                        <td>
                                            <?php if ($mo_gr_badge): ?>
                                            <span class="badge rounded-pill <?= $mo_gr_badge['class'] ?>"><?= $mo_gr_badge['label'] ?></span>
                                            <?php else: ?>
                                            <span class="text-muted small">—</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><i class="bi bi-chevron-down"></i></td>
                                    </tr>
                                    <tr class="collapse" id="<?= $mo_row_id ?>">
                                        <td colspan="9" class="p-0">
                                            <?php if (!empty($mo['tracking_id']) || !empty($mo['payment_type'])): ?>
                                            <div class="d-flex gap-4 flex-wrap px-3 py-2 border-bottom bg-light">
                                                <?php if (!empty($mo['tracking_id'])): ?>
                                                <span class="small text-muted"><i class="bi bi-truck me-1"></i><strong>Courier:</strong> <?= htmlspecialchars($mo['tracking_courier'] ?? '—') ?> &nbsp;|&nbsp; <strong>LR#:</strong> <?= htmlspecialchars($mo['tracking_id']) ?></span>
                                                <?php endif; ?>
                                                <?php if (!empty($mo['payment_type'])): ?>
                                                <span class="small text-muted"><i class="bi bi-credit-card me-1"></i><strong>Payment Mode:</strong> <?= htmlspecialchars($mo['payment_type']) ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <?php endif; ?>
                                            <?php if (is_array($mo_products) && count($mo_products) > 0): ?>
                                            <table class="table table-sm table-bordered mb-0 align-middle">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th style="width:64px;">Image</th>
                                                        <th>Article #</th>
                                                        <th>Product</th>
                                                        <th>Color</th>
                                                        <th>Size</th>
                                                        <th class="text-center">Ordered</th>
                                                        <th class="text-center">Dispatched</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach ($mo_products as $mp):
                                                    $pi         = $mp['product_info'] ?? [];
                                                    $pid        = (int)($pi['id'] ?? 0);
                                                    $ordered    = (int)($mp['product_quantity'] ?? 0);
                                                    $dispatched = isset($mo_dispatch[$pid]) ? (int)$mo_dispatch[$pid] : null;
                                                    $img_src    = base_url('attachments/shop_images/' . ($pi['image'] ?? ''));
                                                    $fallback   = base_url('attachments/shop_images/spark_logo-06.jpg');
                                                ?>
                                                <tr>
                                                    <td><img src="<?= $img_src ?>" onerror="this.onerror=null;this.src='<?= $fallback ?>'" style="width:52px;height:52px;object-fit:cover;border-radius:6px;display:block;"></td>
                                                    <td><code><?= htmlspecialchars($pi['article_number'] ?? '—') ?></code></td>
                                                    <td class="fw-semibold"><?= htmlspecialchars($pi['title'] ?? ('Product #' . ($pi['id'] ?? '?'))) ?></td>
                                                    <td><?= htmlspecialchars($pi['color'] ?? '—') ?></td>
                                                    <td><?= htmlspecialchars($pi['size_range'] ?? '—') ?></td>
                                                    <td class="text-center fw-bold"><?= $ordered ?></td>
                                                    <td class="text-center">
                                                        <?php if ($dispatched === null): ?>
                                                            <span class="text-muted small">—</span>
                                                        <?php elseif ($dispatched >= $ordered): ?>
                                                            <span class="badge bg-success"><?= $dispatched ?></span>
                                                        <?php elseif ($dispatched > 0): ?>
                                                            <span class="badge bg-warning text-dark"><?= $dispatched ?> / <?= $ordered ?></span>
                                                        <?php else: ?>
                                                            <span class="badge bg-danger">0</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                            <?php else: ?>
                                            <div class="px-3 py-3 text-muted small">No product details available.</div>
                                            <?php endif; ?>
                                            <?php if ((int)$mo['processed'] >= 1 && !$mo_gr): ?>
                                            <div class="px-3 py-3 border-top bg-light d-flex align-items-center gap-3">
                                                <span class="small text-muted"><i class="bi bi-info-circle me-1"></i>Raise a return request if there's an issue with this order.</span>
                                                <button class="btn btn-outline-danger btn-sm"
                                                    onclick="openGrModal(<?= (int)$mo['id'] ?>, '<?= (int)$mo['order_id'] ?>', '', <?= (int)user_id() ?>, <?= htmlspecialchars(json_encode($mo_gr_products), ENT_QUOTES) ?>); event.stopPropagation();">
                                                    <i class="bi bi-arrow-counterclockwise me-1"></i> Return
                                                </button>
                                            </div>
                                            <?php elseif ($mo_gr): ?>
                                            <div class="px-3 py-2 border-top bg-light">
                                                <span class="small text-muted"><i class="bi bi-arrow-counterclockwise me-1"></i>GR <strong><?= htmlspecialchars($mo_gr['gr_no']) ?></strong> — <?= $mo_gr_badge['label'] ?></span>
                                                <?php if (!empty($mo_gr['admin_remark'])): ?>
                                                <span class="small text-muted ms-2">| Admin: <?= htmlspecialchars($mo_gr['admin_remark']) ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                    <tr><td colspan="9" class="text-center text-muted py-4">No orders placed yet.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var applyBtn = document.getElementById('mo-filter-apply');
                        var resetBtn = document.getElementById('mo-filter-reset');
                        if (!applyBtn) return;
                        function applyFilters() {
                            var st = document.getElementById('mo-filter-status').value;
                            var py = document.getElementById('mo-filter-payment').value;
                            var rows = document.querySelectorAll('#mo-table tbody tr[data-mo-status]');
                            rows.forEach(function(row) {
                                var show = true;
                                if (st !== '' && row.dataset.moStatus !== st) show = false;
                                if (py !== '' && row.dataset.moPayment !== py) show = false;
                                var detailId = row.getAttribute('data-bs-target');
                                var detailRow = detailId ? document.querySelector(detailId) : null;
                                row.style.display = show ? '' : 'none';
                                if (detailRow && !show) detailRow.classList.remove('show');
                            });
                        }
                        applyBtn.addEventListener('click', applyFilters);
                        resetBtn.addEventListener('click', function() {
                            document.getElementById('mo-filter-status').value = '';
                            document.getElementById('mo-filter-payment').value = '';
                            applyFilters();
                        });
                    });
                    </script>
                </div>
                <div class="tab-pane fade" id="retailerorders" role="tabpanel" aria-labelledby="retailerorders-tab">
                    <!-- Stats -->
                    <div class="row mb-4 g-3 mt-1">
                        <div class="col-6 col-md-3">
                            <div class="border rounded-4 p-3 h-100 text-center">
                                <div class="text-muted small">Total</div>
                                <h4 class="fw-bold mb-0"><?= $retailer_stats['total'] ?></h4>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="border rounded-4 p-3 h-100 text-center">
                                <div class="text-muted small">Pending</div>
                                <h4 class="fw-bold mb-0 text-warning"><?= $retailer_stats['pending'] ?></h4>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="border rounded-4 p-3 h-100 text-center">
                                <div class="text-muted small">Shipped</div>
                                <h4 class="fw-bold mb-0 text-info"><?= $retailer_stats['shipped'] ?></h4>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="border rounded-4 p-3 h-100 text-center">
                                <div class="text-muted small">Delivered</div>
                                <h4 class="fw-bold mb-0 text-success"><?= $retailer_stats['delivered'] ?></h4>
                            </div>
                        </div>
                    </div>

                    <!-- Orders Table -->
                    <div class="card mb-4">
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-3">Order #</th>
                                        <th>Retailer</th>
                                        <th>Items</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>GR Status</th>
                                        <th class="pe-3">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $ro_status_map = [
                                    0 => ['label'=>'Pending',  'class'=>'bg-warning text-dark'],
                                    1 => ['label'=>'Shipped',  'class'=>'bg-info text-white'],
                                    2 => ['label'=>'Delivered','class'=>'bg-success text-white'],
                                ];
                                $gr_status_map = [
                                    'pending'   => ['label'=>'GR Pending',   'class'=>'text-bg-warning'],
                                    'approved'  => ['label'=>'GR Approved',  'class'=>'text-bg-info'],
                                    'rejected'  => ['label'=>'GR Rejected',  'class'=>'text-bg-danger'],
                                    'processed' => ['label'=>'GR Processed', 'class'=>'text-bg-success'],
                                ];
                                if (!empty($retailer_orders)):
                                    foreach ($retailer_orders as $ro):
                                        $ro_products = @unserialize($ro['products']);
                                        $ro_items    = is_array($ro_products) ? count($ro_products) : 0;
                                        $ro_st       = $ro_status_map[$ro['processed']] ?? ['label'=>'Unknown','class'=>'bg-secondary'];
                                        $ro_gr       = $gr_by_order[(int)$ro['id']] ?? null;
                                        $ro_bill     = (float)($ro['billing_amount'] ?? 0);
                                        // Also compute retail total for margin display
                                        $ro_retail   = 0;
                                        if (is_array($ro_products)) {
                                            foreach ($ro_products as $_rp) {
                                                $_wsp = (float)($_rp['product_info']['wsp'] ?? 0);
                                                if ($_wsp <= 0) $_wsp = (float)($_rp['product_info']['price'] ?? 0);
                                                $ro_retail += $_wsp * (int)($_rp['product_quantity'] ?? 1);
                                            }
                                        }
                                        $ro_margin   = ($ro_retail > 0 && $ro_bill > 0) ? round($ro_retail - $ro_bill, 2) : 0;
                                        $ro_amount   = $ro_bill > 0 ? '₹ ' . number_format($ro_bill, 0) : '—';
                                        $ro_dispatch = [];
                                        if (!empty($ro['dispatch_products'])) { $rod = @unserialize($ro['dispatch_products']); if (is_array($rod)) $ro_dispatch = $rod; }
                                        $ro_gr_products = [];
                                        if (is_array($ro_products)) {
                                            foreach ($ro_products as $rp) {
                                                $rpi  = $rp['product_info'] ?? [];
                                                $rpid = (int)($rpi['id'] ?? 0);
                                                $ro_disp_qty = isset($ro_dispatch[$rpid]) ? (int)$ro_dispatch[$rpid] : 0;
                                                if ($ro_disp_qty < 1) $ro_disp_qty = (int)($rp['product_quantity'] ?? 1);
                                                $ro_gr_products[] = [
                                                    'title' => $rpi['title'] ?? 'Product',
                                                    'color' => $rpi['color'] ?? '',
                                                    'size'  => $rpi['size_range'] ?? '',
                                                    'qty'   => $ro_disp_qty,
                                                ];
                                            }
                                        }
                                ?>
                                <tr>
                                    <td class="ps-3 fw-semibold">#<?= (int)$ro['order_id'] ?></td>
                                    <td><?= htmlspecialchars($ro['retailer_name'] ?? '—') ?></td>
                                    <td><?= $ro_items ?> item<?= $ro_items != 1 ? 's' : '' ?></td>
                                    <td>
                                        <?= $ro_amount ?>
                                        <?php if ($ro_margin > 0): ?>
                                        <div class="small text-success mt-1" title="Your margin on this order">
                                            <i class="bi bi-graph-up-arrow"></i> +₹<?= number_format($ro_margin, 0) ?>
                                        </div>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= date('d M Y', (int)$ro['date']) ?></td>
                                    <td><span class="badge rounded-pill <?= $ro_st['class'] ?>"><?= $ro_st['label'] ?></span></td>
                                    <td>
                                        <?php if ($ro_gr): ?>
                                            <?php $gst = $gr_status_map[$ro_gr['status']] ?? ['label'=>ucfirst($ro_gr['status']),'class'=>'text-bg-secondary']; ?>
                                            <span class="badge rounded-pill <?= $gst['class'] ?>" title="<?= htmlspecialchars($ro_gr['gr_no']) ?>"><?= $gst['label'] ?></span>
                                        <?php else: ?>
                                            <span class="text-muted small">—</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="pe-3">
                                        <?php if ((int)$ro['processed'] >= 1 && !$ro_gr): ?>
                                        <button class="btn btn-sm btn-outline-danger"
                                            onclick="openGrModal(<?= (int)$ro['id'] ?>, '<?= (int)$ro['order_id'] ?>', '<?= htmlspecialchars(addslashes($ro['retailer_name'] ?? '')) ?>', <?= (int)($ro['retailer_id'] ?? 0) ?>, <?= htmlspecialchars(json_encode($ro_gr_products), ENT_QUOTES) ?>)">
                                            <i class="bi bi-arrow-return-left"></i> Return
                                        </button>
                                        <?php elseif ($ro_gr): ?>
                                        <span class="text-muted small">GR #<?= htmlspecialchars($ro_gr['gr_no']) ?></span>
                                        <?php else: ?>
                                        <span class="text-muted small">—</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach;
                                else: ?>
                                <tr><td colspan="8" class="text-center text-muted py-4">No retailer orders found.</td></tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- GR Return Modal -->
                <div class="modal fade" id="grReturnModal" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 rounded-3 shadow">
                            <div class="modal-header border-0 pb-0">
                                <h5 class="modal-title fw-semibold">Submit GR Return Request</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p class="text-muted small mb-3">
                                    Order <strong id="grOrderLabel"></strong> &mdash; <span id="grRetailerLabel"></span>
                                </p>
                                <input type="hidden" id="grOrderId">
                                <input type="hidden" id="grRetailerId">

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Return Type <span class="text-danger">*</span></label>
                                    <select class="form-select" id="grReturnType">
                                        <option value="" disabled selected>Select type</option>
                                        <option>Wrong Item</option>
                                        <option>Quality Issue</option>
                                        <option>Damage in Transit</option>
                                        <option>Excess Quantity</option>
                                        <option>Other</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Items Being Returned <span class="text-danger">*</span></label>
                                    <div id="grItemsList" class="border rounded-2 p-2" style="max-height:240px;overflow-y:auto;"></div>
                                    <div class="form-text">Check each item you wish to return and set the return quantity.</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Remark / Notes</label>
                                    <textarea class="form-control" id="grRemark" rows="2" placeholder="Any additional details…"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Proof Images / Invoice</label>
                                    <input type="file" class="form-control" id="grProof" multiple accept="image/*,.pdf">
                                </div>
                                <p class="text-muted" style="font-size:11px;">
                                    <i class="bi bi-info-circle"></i>
                                    Submitting this request does not guarantee approval. Our team will review and confirm.
                                </p>
                                <div id="grError" class="alert alert-danger d-none py-2 small"></div>
                            </div>
                            <div class="modal-footer border-0 pt-0">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-dark" id="grSubmitBtn">
                                    <i class="bi bi-send"></i> Submit GR Request
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                function _grEscHtml(s) {
                    return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
                }
                function openGrModal(orderId, orderNo, retailerName, retailerId, products) {
                    document.getElementById('grOrderId').value     = orderId;
                    document.getElementById('grRetailerId').value  = retailerId;
                    document.getElementById('grOrderLabel').textContent   = '#' + orderNo;
                    document.getElementById('grRetailerLabel').textContent = retailerName || '';
                    document.getElementById('grReturnType').value = '';
                    document.getElementById('grRemark').value     = '';
                    document.getElementById('grProof').value      = '';
                    document.getElementById('grError').classList.add('d-none');

                    var list = document.getElementById('grItemsList');
                    list.innerHTML = '';
                    if (products && products.length) {
                        products.forEach(function(p, i) {
                            var row = document.createElement('div');
                            row.className = 'd-flex align-items-center gap-2 py-2' + (i > 0 ? ' border-top' : '');
                            var meta = [p.color, p.size].filter(Boolean).join(', ');
                            row.innerHTML =
                                '<input type="checkbox" class="form-check-input gr-item-chk flex-shrink-0" id="grItm' + i + '" checked>' +
                                '<label class="form-check-label flex-grow-1 small" for="grItm' + i + '">' +
                                    '<span class="fw-semibold">' + _grEscHtml(p.title) + '</span>' +
                                    (meta ? '<span class="text-muted ms-1">· ' + _grEscHtml(meta) + '</span>' : '') +
                                    '<span class="text-muted ms-1 small">(dispatched: ' + p.qty + ')</span>' +
                                '</label>' +
                                '<input type="number" class="form-control form-control-sm gr-item-qty" style="width:74px;" value="' + p.qty + '" min="1" max="' + p.qty + '" ' +
                                    'data-title="' + _grEscHtml(p.title) + '" data-color="' + _grEscHtml(p.color || '') + '" data-size="' + _grEscHtml(p.size || '') + '">';
                            list.appendChild(row);
                        });
                    } else {
                        list.innerHTML = '<p class="text-muted small m-0 p-1">No product details available.</p>';
                    }

                    var modal = new bootstrap.Modal(document.getElementById('grReturnModal'));
                    modal.show();
                }

                document.getElementById('grSubmitBtn').addEventListener('click', function() {
                    var btn         = this;
                    var orderId     = document.getElementById('grOrderId').value;
                    var retailerId  = document.getElementById('grRetailerId').value;
                    var returnType  = document.getElementById('grReturnType').value;
                    var remark      = document.getElementById('grRemark').value.trim();
                    var proofInput  = document.getElementById('grProof');
                    var errEl       = document.getElementById('grError');

                    // Build items string from checked product rows
                    var itemLines = [];
                    document.querySelectorAll('#grItemsList .gr-item-chk').forEach(function(chk) {
                        if (!chk.checked) return;
                        var qtyEl = chk.closest('div').querySelector('.gr-item-qty');
                        var qty   = qtyEl ? parseInt(qtyEl.value) || 1 : 1;
                        var t     = qtyEl ? qtyEl.dataset.title : '';
                        var c     = qtyEl ? qtyEl.dataset.color : '';
                        var s     = qtyEl ? qtyEl.dataset.size  : '';
                        var meta  = [c, s].filter(Boolean).join(', ');
                        itemLines.push(t + (meta ? ' (' + meta + ')' : '') + ' × ' + qty);
                    });
                    var items = itemLines.join('\n');

                    if (!returnType || !items) {
                        errEl.textContent = 'Please select Return Type and at least one item.';
                        errEl.classList.remove('d-none');
                        return;
                    }
                    errEl.classList.add('d-none');
                    btn.disabled = true;
                    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Submitting…';

                    var fd = new FormData();
                    fd.append('order_id',    orderId);
                    fd.append('retailer_id', retailerId);
                    fd.append('return_type', returnType);
                    fd.append('items',       items);
                    fd.append('remark',      remark);
                    for (var i = 0; i < proofInput.files.length; i++) {
                        fd.append('proof[]', proofInput.files[i]);
                    }

                    fetch('<?= base_url('submit_gr') ?>', { method: 'POST', body: fd })
                        .then(function(r){ return r.json(); })
                        .then(function(res) {
                            btn.disabled = false;
                            btn.innerHTML = '<i class="bi bi-send"></i> Submit GR Request';
                            if (res.success) {
                                bootstrap.Modal.getInstance(document.getElementById('grReturnModal')).hide();
                                alert('GR Request submitted successfully! Reference: ' + res.gr_no);
                                location.reload();
                            } else {
                                errEl.textContent = res.error || 'Submission failed.';
                                errEl.classList.remove('d-none');
                            }
                        })
                        .catch(function() {
                            btn.disabled = false;
                            btn.innerHTML = '<i class="bi bi-send"></i> Submit GR Request';
                            errEl.textContent = 'Network error. Please try again.';
                            errEl.classList.remove('d-none');
                        });
                });
                </script>
                <div class="tab-pane fade" id="track" role="tabpanel" aria-labelledby="track-tab">
                    <div class="card-panel my-2">
                        <div class="mb-4">
                            <h5 class="mb-1">Track Your Shipments</h5>
                            <small class="text-muted">Courier and tracking details for your dispatched orders</small>
                        </div>
                        <?php
                        $tracked_orders = array_filter($my_orders, function($o) {
                            return !empty($o['tracking_id']);
                        });
                        ?>
                        <?php if (empty($tracked_orders)): ?>
                            <div class="text-center py-5 text-muted">
                                <i class="bi bi-truck fs-1 d-block mb-3"></i>
                                <p class="mb-1 fw-semibold">No tracking information yet</p>
                                <small>Once your order is dispatched, tracking details will appear here.</small>
                            </div>
                        <?php else: ?>
                            <div class="row g-3">
                            <?php foreach ($tracked_orders as $to):
                                $status_map = [0 => ['warning','Pending'], 1 => ['success','Dispatched'], 2 => ['danger','Rejected']];
                                [$scls, $slbl] = $status_map[$to['processed']] ?? ['secondary','Unknown'];
                            ?>
                                <div class="col-12">
                                    <div class="border rounded-3 p-3" style="background:#FAFAFA;">
                                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                                            <div>
                                                <span class="fw-bold fs-6">Order #<?= (int)$to['order_id'] ?></span>
                                                <span class="text-muted small ms-2"><?= date('d M Y', (int)$to['date']) ?></span>
                                            </div>
                                            <span class="badge bg-<?= $scls ?> px-3 py-2"><?= $slbl ?></span>
                                        </div>
                                        <div class="row g-3">
                                            <div class="col-sm-4">
                                                <div class="small text-muted mb-1">Courier / Transporter</div>
                                                <div class="fw-semibold"><?= htmlspecialchars($to['tracking_courier'] ?: '—') ?></div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="small text-muted mb-1">Tracking / LR Number</div>
                                                <div class="fw-semibold d-flex align-items-center gap-2">
                                                    <?= htmlspecialchars($to['tracking_id']) ?>
                                                    <button type="button" class="btn btn-sm btn-outline-secondary py-0 px-2 copy-tracking-btn"
                                                        data-val="<?= htmlspecialchars($to['tracking_id']) ?>" title="Copy">
                                                        <i class="bi bi-copy" style="font-size:11px;"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="small text-muted mb-1">Payment</div>
                                                <div class="fw-semibold"><?= htmlspecialchars($to['payment_type'] ?? '—') ?></div>
                                            </div>
                                        </div>
                                        <?php
                                        $bamt  = (float)($to['billing_amount'] ?? 0);
                                        $bpaid = (float)($to['paid_amount']    ?? 0);
                                        $pstat = (int)($to['payment_status']   ?? 0);
                                        if ($bamt > 0):
                                        ?>
                                        <div class="mt-2 pt-2 border-top d-flex gap-3 flex-wrap">
                                            <span class="small text-muted">Bill: <strong>₹<?= number_format($bamt, 0) ?></strong></span>
                                            <span class="small text-muted">Paid: <strong class="text-success">₹<?= number_format($bpaid, 0) ?></strong></span>
                                            <?php if ($pstat < 2 && ($bamt - $bpaid) > 0): ?>
                                            <span class="small text-muted">Due: <strong class="text-danger">₹<?= number_format($bamt - $bpaid, 0) ?></strong></span>
                                            <?php endif; ?>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            </div>
                            <div class="alert alert-light border mt-4 mb-0 small">
                                <i class="bi bi-info-circle me-1"></i>
                                Contact us with your LR / Tracking number for any delivery issues.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if ($user_role === 'agent'): ?>
                <div class="tab-pane fade" id="commission" role="tabpanel" aria-labelledby="commission-tab">
                    <div class="card-panel my-3 p-4 rounded-4 shadow-sm bg-white">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h4 class="mb-1 fw-semibold">Commission</h4>
                                <small class="text-muted">Track your earnings and payouts</small>
                            </div>
                            <button class="btn btn-outline-dark rounded-pill px-4">
                                <i class="bi bi-download me-2"></i> Download Statement
                            </button>
                        </div>
                        <div class="row g-4 mb-4">
                            <div class="col-md-3">
                                <div class="border rounded-4 p-4 h-100">
                                    <div class="small text-muted mb-1">Total Commission</div>
                                    <h4 class="fw-semibold mb-0">₹ <?= number_format($commission_stats['total'], 2) ?></h4>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="border rounded-4 p-4 h-100">
                                    <div class="small text-muted mb-1">Paid</div>
                                    <h4 class="fw-semibold mb-0 text-success">₹ <?= number_format($commission_stats['paid'], 2) ?></h4>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="border rounded-4 p-4 h-100" style="border-color:#F59E0B!important;">
                                    <div class="small text-muted mb-1">Payable <i class="bi bi-check-circle-fill text-warning"></i></div>
                                    <h4 class="fw-semibold mb-0" style="color:#D97706;">₹ <?= number_format($commission_stats['payable'], 2) ?></h4>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="border rounded-4 p-4 h-100">
                                    <div class="small text-muted mb-1">Pending</div>
                                    <h4 class="fw-semibold mb-0 text-danger">₹ <?= number_format($commission_stats['pending'], 2) ?></h4>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <input class="form-control rounded-3" placeholder="Search by Order ID or Client">
                            </div>
                            <div class="col-md-3">
                                <input type="date" class="form-control rounded-3">
                            </div>
                            <div class="col-md-3">
                                <select class="form-select rounded-3">
                                    <option>All Status</option>
                                    <option>Paid</option>
                                    <option>Pending</option>
                                </select>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button class="btn btn-dark rounded-0 w-100">Apply Filters</button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="fw-semibold">Order ID</th>
                                        <th>Client</th>
                                        <th>Order Amount</th>
                                        <th>Commission %</th>
                                        <th>Commission</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($commission_records)): ?>
                                    <tr><td colspan="8" class="text-center text-muted py-4">No commission records yet.</td></tr>
                                    <?php else: ?>
                                    <?php foreach ($commission_records as $cr): ?>
                                    <tr>
                                        <td class="fw-semibold">#<?= (int)$cr['order_id'] ?></td>
                                        <td><?= htmlspecialchars($cr['retailer_name']) ?></td>
                                        <td>₹ <?= number_format((float)$cr['order_amount'], 2) ?></td>
                                        <td><?= number_format((float)$cr['commission_rate'], 2) ?>%</td>
                                        <td>₹ <?= number_format((float)$cr['commission_amt'], 2) ?></td>
                                        <td>
                                            <?php if ($cr['status'] === 'paid'): ?>
                                            <span class="badge rounded-pill bg-success-subtle text-success border">Paid</span>
                                            <?php elseif ($cr['status'] === 'payable'): ?>
                                            <span class="badge rounded-pill bg-warning-subtle border" style="color:#D97706;border-color:#F59E0B!important;"><i class="bi bi-check-circle-fill"></i> Payable</span>
                                            <?php else: ?>
                                            <span class="badge rounded-pill bg-secondary-subtle text-secondary border">Pending</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= date('d M Y', (int)$cr['date']) ?></td>
                                        <td>
                                            <?php if ($cr['status'] === 'payable' && empty($cr['disbursement_requested_at'])): ?>
                                            <button class="btn btn-sm btn-outline-warning rounded-pill commission-req-btn"
                                                    data-id="<?= (int)$cr['id'] ?>"
                                                    onclick="requestCommission(this, <?= (int)$cr['id'] ?>)">
                                                <i class="bi bi-send"></i> Request
                                            </button>
                                            <?php elseif ($cr['status'] === 'payable' && !empty($cr['disbursement_requested_at'])): ?>
                                            <span class="text-success small"><i class="bi bi-check2-circle"></i> Requested</span>
                                            <?php else: ?>
                                            <span class="text-muted">—</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <div class="tab-pane fade" id="ledger" role="tabpanel" aria-labelledby="ledger-tab">
                    <div class="card-panel p-4 rounded-4 shadow-sm bg-white my-2">
                        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                            <div>
                                <h4 class="fw-semibold mb-1">Ledger</h4>
                                <small class="text-muted">Debit / Credit transaction history</small>
                            </div>
                            <?php
                            $ledger_balance = !empty($ledger) ? (float)end($ledger)['balance'] : 0;
                            reset($ledger);
                            ?>
                            <div class="text-end">
                                <div class="small text-muted mb-1">Current Balance Due</div>
                                <div class="fw-bold fs-4 <?= $ledger_balance > 0 ? 'text-danger' : 'text-success' ?>">
                                    ₹ <?= number_format(abs($ledger_balance), 2) ?>
                                    <span class="fs-6 fw-normal"><?= $ledger_balance > 0 ? 'Payable' : 'Clear' ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Date</th>
                                        <th>Order #</th>
                                        <th>Client</th>
                                        <th>Description</th>
                                        <th class="text-success">Credit</th>
                                        <th class="text-danger">Debit</th>
                                        <th>Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($ledger)): ?>
                                    <tr><td colspan="8" class="text-center text-muted py-4">No ledger entries yet.</td></tr>
                                    <?php else: ?>
                                    <?php foreach ($ledger as $le): ?>
                                    <tr>
                                        <td><?= date('d M Y', (int)$le['date']) ?></td>
                                        <td><?= !empty($le['order_no']) ? '#' . (int)$le['order_no'] : '—' ?></td>
                                        <td>
                                            <?php
                                            $cname = trim(($le['client_name'] ?? '') . ' ' . ($le['client_company'] ?? ''));
                                            echo $cname ? htmlspecialchars($cname) : '—';
                                            ?>
                                        </td>
                                        <td><?= htmlspecialchars($le['description']) ?></td>
                                        <?php if ($le['type'] === 'credit'): ?>
                                        <td class="text-success fw-semibold">₹ <?= number_format((float)$le['amount'], 2) ?></td>
                                        <td>—</td>
                                        <?php else: ?>
                                        <td>—</td>
                                        <td class="text-danger fw-semibold">₹ <?= number_format((float)$le['amount'], 2) ?></td>
                                        <?php endif; ?>
                                        <td>₹ <?= number_format((float)$le['balance'], 2) ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="claim" role="tabpanel" aria-labelledby="claim-tab">
                    <?php
                    $claim_status_cfg = [
                        'pending'  => ['label' => 'Pending',  'badge' => 'bg-warning text-dark'],
                        'approved' => ['label' => 'Approved', 'badge' => 'bg-info text-dark'],
                        'rejected' => ['label' => 'Rejected', 'badge' => 'bg-danger'],
                        'paid'     => ['label' => 'Paid',     'badge' => 'bg-success'],
                    ];
                    ?>
                    <div class="card-panel p-4 rounded-4 shadow-sm bg-white my-2">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h4 class="fw-semibold mb-1">Claims</h4>
                                <small class="text-muted">Submit and track your claims</small>
                            </div>
                            <button class="btn btn-dark rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#newClaimModal">
                                <i class="bi bi-plus-circle me-2"></i> New Claim
                            </button>
                        </div>

                        <!-- Summary stats -->
                        <?php
                        $cl_counts = ['pending' => 0, 'approved' => 0, 'rejected' => 0, 'paid' => 0];
                        foreach ($claims as $cl) { $cl_counts[$cl['status']] = ($cl_counts[$cl['status']] ?? 0) + 1; }
                        ?>
                        <div class="row g-3 mb-4">
                            <div class="col-6 col-md-3">
                                <div class="border rounded-3 p-3 text-center">
                                    <div class="fw-bold fs-5"><?= count($claims) ?></div>
                                    <div class="text-muted small">Total</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="border rounded-3 p-3 text-center">
                                    <div class="fw-bold fs-5 text-warning"><?= $cl_counts['pending'] ?></div>
                                    <div class="text-muted small">Pending</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="border rounded-3 p-3 text-center">
                                    <div class="fw-bold fs-5 text-success"><?= $cl_counts['approved'] + $cl_counts['paid'] ?></div>
                                    <div class="text-muted small">Approved / Paid</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="border rounded-3 p-3 text-center">
                                    <div class="fw-bold fs-5 text-danger"><?= $cl_counts['rejected'] ?></div>
                                    <div class="text-muted small">Rejected</div>
                                </div>
                            </div>
                        </div>

                        <!-- Filter bar -->
                        <div class="row g-2 mb-3">
                            <div class="col-md-4">
                                <input class="form-control" id="claim-search" placeholder="Search by Claim ID or type…">
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" id="claim-filter-status">
                                    <option value="">All Status</option>
                                    <option value="pending">Pending</option>
                                    <option value="approved">Approved</option>
                                    <option value="rejected">Rejected</option>
                                    <option value="paid">Paid</option>
                                </select>
                            </div>
                        </div>

                        <!-- Claims table -->
                        <div class="table-responsive">
                            <table class="table table-hover align-middle" id="claims-table">
                                <thead class="table-light">
                                    <tr>
                                        <th>Claim #</th>
                                        <th>Type</th>
                                        <th>Order Ref</th>
                                        <th>Amount (₹)</th>
                                        <th>Submitted On</th>
                                        <th>Status</th>
                                        <th>Remark</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($claims)): ?>
                                    <tr><td colspan="7" class="text-center text-muted py-4">No claims submitted yet.</td></tr>
                                    <?php else: foreach ($claims as $cl):
                                        $cl_cfg = $claim_status_cfg[$cl['status']] ?? ['label' => ucfirst($cl['status']), 'badge' => 'bg-secondary'];
                                    ?>
                                    <tr data-cl-status="<?= $cl['status'] ?>" data-cl-text="<?= strtolower(htmlspecialchars($cl['claim_no'] . ' ' . $cl['type'])) ?>">
                                        <td class="fw-semibold"><?= htmlspecialchars($cl['claim_no']) ?></td>
                                        <td><?= htmlspecialchars($cl['type']) ?></td>
                                        <td><?= htmlspecialchars($cl['order_ref']) ?></td>
                                        <td>₹<?= number_format((float)$cl['amount'], 2) ?></td>
                                        <td><?= date('d M Y', $cl['created_at']) ?></td>
                                        <td><span class="badge rounded-pill <?= $cl_cfg['badge'] ?>"><?= $cl_cfg['label'] ?></span></td>
                                        <td class="text-muted small"><?= htmlspecialchars($cl['admin_remark'] ?? '—') ?></td>
                                    </tr>
                                    <?php endforeach; endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- New Claim Modal -->
                    <div class="modal fade" id="newClaimModal" tabindex="-1" aria-labelledby="newClaimModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="newClaimModalLabel">Submit New Claim</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div id="claim-form-alert" class="alert d-none"></div>
                                    <div class="mb-3">
                                        <label class="form-label">Claim Type <span class="text-danger">*</span></label>
                                        <select class="form-select" id="claim-type">
                                            <option value="" disabled selected>Select type</option>
                                            <option>Incentive</option>
                                            <option>Rate Difference</option>
                                            <option>Damage</option>
                                            <option>Special Incentive</option>
                                            <option>Other</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Amount (₹) <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="claim-amount" min="1" step="0.01" placeholder="0.00">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Related Order (optional)</label>
                                        <select class="form-select" id="claim-order">
                                            <option value="">— None —</option>
                                            <?php foreach ($my_orders as $mo): ?>
                                            <option value="<?= (int)$mo['id'] ?>">#<?= (int)$mo['order_id'] ?> &nbsp; <?= date('d M Y', $mo['date']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea class="form-control" id="claim-description" rows="3" placeholder="Explain your claim…"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-dark" id="claim-submit-btn">Submit Claim</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        // Filter logic
                        var searchEl  = document.getElementById('claim-search');
                        var statusEl  = document.getElementById('claim-filter-status');
                        function filterClaims() {
                            var q  = searchEl.value.toLowerCase();
                            var st = statusEl.value;
                            document.querySelectorAll('#claims-table tbody tr[data-cl-status]').forEach(function(row) {
                                var match = (!q || row.dataset.clText.includes(q)) && (!st || row.dataset.clStatus === st);
                                row.style.display = match ? '' : 'none';
                            });
                        }
                        searchEl.addEventListener('input', filterClaims);
                        statusEl.addEventListener('change', filterClaims);

                        // Submit claim
                        var submitBtn = document.getElementById('claim-submit-btn');
                        if (!submitBtn) return;
                        submitBtn.addEventListener('click', function() {
                            var type  = document.getElementById('claim-type').value;
                            var amt   = document.getElementById('claim-amount').value;
                            var order = document.getElementById('claim-order').value;
                            var desc  = document.getElementById('claim-description').value;
                            var alert = document.getElementById('claim-form-alert');
                            alert.className = 'alert d-none';
                            if (!type || !amt || parseFloat(amt) <= 0) {
                                alert.className = 'alert alert-danger';
                                alert.textContent = 'Claim type and a valid amount are required.';
                                return;
                            }
                            submitBtn.disabled = true;
                            submitBtn.textContent = 'Submitting…';
                            fetch('<?= base_url('submit_claim') ?>', {
                                method: 'POST',
                                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                                body: new URLSearchParams({type: type, amount: amt, order_id: order, description: desc})
                            })
                            .then(function(r) { return r.json(); })
                            .then(function(res) {
                                submitBtn.disabled = false;
                                submitBtn.textContent = 'Submit Claim';
                                if (res && res.success) {
                                    var m = bootstrap.Modal.getInstance(document.getElementById('newClaimModal'));
                                    if (m) m.hide();
                                    location.reload();
                                } else {
                                    alert.className = 'alert alert-danger';
                                    alert.textContent = res.error || 'Error submitting claim.';
                                }
                            })
                            .catch(function() {
                                submitBtn.disabled = false;
                                submitBtn.textContent = 'Submit Claim';
                                alert.className = 'alert alert-danger';
                                alert.textContent = 'Request failed. Please try again.';
                            });
                        });
                    });
                    </script>
                </div>
                <div class="tab-pane fade" id="coupons" role="tabpanel" aria-labelledby="coupons-tab">
                    <div class="row g-3 coupons_items mt-0">
                        <?php if (isset($coupons) && !empty($coupons)) : ?>
                            <?php foreach ($coupons as $coupon) : ?>
                                <div class="col-lg-3 col-md-4 col-6">
                                    <div class="coupon-item card-panel p-3 text-center position-relative">
                                        <div class="coupon-header d-flex justify-content-between align-items-center mb-2">
                                            <?php
                                            $badgeClass = ($coupon->status == 'active') ? 'bg-success' : (($coupon->status == 'expired') ? 'bg-secondary' : 'bg-warning');
                                            ?>
                                            <span class="badge <?= $badgeClass ?>"><?= ucfirst($coupon->status) ?></span>
                                            <small class="text-muted">Valid till: <?= date('d-m-Y', strtotime($coupon->expiry)) ?></small>
                                        </div>
                                        <div class="fs-5 fw-bold coupon-code mb-2"><?= strtoupper($coupon->code) ?></div>
                                        <div class="text-muted mb-2"><?= $coupon->description ?></div>
                                        <div class="coupon-discount fs-6 text-primary mb-3">
                                            <?php
                                            if ($coupon->discount_type == 'percentage') {
                                                echo $coupon->discount . '% off';
                                            } else {
                                                echo '₹ ' . $coupon->discount . ' discount';
                                            }
                                            ?>
                                        </div>
                                        <button class="btn btn-outline-primary btn-sm copy-coupon-btn" onclick="copyCoupon(this)">Copy Code</button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-12 text-center">
                                <h2 class="fs-3 py-4 text-muted gfamily fw-bold">You don’t have any active coupons.</h2>
                                <a href="<?= base_url('home/shop'); ?>" class="btn_button d-inline-block">Browse Shop</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="tab-pane fade" id="addresses" role="tabpanel" aria-labelledby="addresses-tab">
                    <div class="card-panel my-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h5 class="mb-0">Saved Business Addresses</h5>
                                <small class="text-muted">Manage your billing &amp; delivery locations</small>
                            </div>
                            <button type="button" class="btn btn-primary btn-sm" id="addNewAddressBtn"
                                data-bs-toggle="modal" data-bs-target="#editAddressModal">
                                <i class="bi bi-plus-lg"></i> Add New Address
                            </button>
                        </div>

                        <!-- Address list -->
                        <div id="addressList">
                        <?php if (!empty($user_addresses)): ?>
                            <?php foreach ($user_addresses as $ua): ?>
                            <div class="p-3 border rounded mb-2 d-flex justify-content-between align-items-start addr-list-card" data-id="<?= (int)$ua->id ?>">
                                <div>
                                    <?php if (!empty($ua->label)): ?>
                                    <div class="fw-bold fs-6"><?= htmlspecialchars($ua->label) ?>
                                        <?php if ($ua->is_default): ?><span class="badge bg-success ms-2" style="font-size:.7rem;">Default</span><?php endif; ?>
                                    </div>
                                    <?php elseif ($ua->is_default): ?>
                                    <div class="fw-bold fs-6">Address <span class="badge bg-success ms-1" style="font-size:.7rem;">Default</span></div>
                                    <?php endif; ?>
                                    <div class="text-muted small mt-1">
                                        <?php if (!empty($ua->company)): ?><strong>Company:</strong> <?= htmlspecialchars($ua->company) ?><br><?php endif; ?>
                                        <?php if (!empty($ua->gst)): ?><strong>GST:</strong> <?= htmlspecialchars($ua->gst) ?><br><?php endif; ?>
                                        <strong>Contact:</strong> <?= htmlspecialchars($ua->name) ?><br>
                                        <strong>Phone:</strong> <?= htmlspecialchars($ua->phone) ?><br>
                                        <strong>Address:</strong> <?= nl2br(htmlspecialchars($ua->address)) ?>
                                    </div>
                                </div>
                                <div class="d-flex gap-2 flex-shrink-0 ms-3">
                                    <?php if (!$ua->is_default): ?>
                                    <button type="button" class="btn btn-sm btn-outline-secondary addr-set-default-btn"
                                        data-id="<?= (int)$ua->id ?>">Set Default</button>
                                    <?php endif; ?>
                                    <button type="button" class="btn btn-sm btn-outline-primary addr-edit-btn"
                                        data-id="<?= (int)$ua->id ?>"
                                        data-label="<?= htmlspecialchars($ua->label ?? '') ?>"
                                        data-company="<?= htmlspecialchars($ua->company ?? '') ?>"
                                        data-gst="<?= htmlspecialchars($ua->gst ?? '') ?>"
                                        data-name="<?= htmlspecialchars($ua->name ?? '') ?>"
                                        data-phone="<?= htmlspecialchars($ua->phone ?? '') ?>"
                                        data-address="<?= htmlspecialchars($ua->address ?? '') ?>"
                                        data-default="<?= (int)$ua->is_default ?>"
                                        data-bs-toggle="modal" data-bs-target="#editAddressModal">
                                        <i class="bi bi-pencil"></i> Edit
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger addr-delete-btn"
                                        data-id="<?= (int)$ua->id ?>">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div id="noAddressMsg" class="text-muted text-center py-4">
                                <i class="bi bi-geo-alt fs-2 d-block mb-2"></i>
                                No saved addresses yet. Click "Add New Address" to get started.
                            </div>
                        <?php endif; ?>
                        </div>

                        <!-- Add / Edit Address Modal -->
                        <div class="modal fade" id="editAddressModal" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 rounded-2">
                                    <div class="modal-header border-0">
                                        <h5 class="modal-title fw-normal" id="addrModalTitle">Add New Address</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body px-4">
                                        <div id="addrSaveMsg" class="alert alert-success d-none">Saved successfully.</div>
                                        <input type="hidden" id="addrId" value="0">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label class="form-label small">Address Label (e.g. "Head Office")</label>
                                                <input type="text" class="form-control" id="addrLabel" placeholder="Optional label">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small">Company Name</label>
                                                <input type="text" class="form-control" id="addrCompany">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small">GST Number</label>
                                                <input type="text" class="form-control" id="addrGst">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small">Contact Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="addrName">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small">Phone <span class="text-danger">*</span></label>
                                                <input type="tel" class="form-control" id="addrPhone">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label small">Full Address <span class="text-danger">*</span></label>
                                                <textarea class="form-control" id="addrAddress" rows="3"></textarea>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="addrIsDefault">
                                                    <label class="form-check-label small" for="addrIsDefault">Set as default address</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end gap-2 mt-4">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                            <button type="button" class="btn btn-dark" id="saveAddressBtn">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="payments" role="tabpanel" aria-labelledby="payments-tab">
                    <div class="d-flex justify-content-between align-items-center my-3 flex-wrap">
                        <div>
                            <small class="text-muted">Track Pending Bills, Payment History, and Saved Methods</small>
                        </div>
                        <div class="d-flex gap-2 mt-2 mt-md-0 flex-wrap">
                            <button class="btn btn-outline-secondary">
                                <i class="bi bi-download"></i> Export
                            </button>
                            <button class="btn_button">
                                <i class="bi bi-file-earmark-text"></i> Generate Invoice
                            </button>
                        </div>
                    </div>
                    <div class="row mb-4 g-3">
                        <div class="col-md-4">
                            <div class="border rounded-4 p-4 h-100">
                                <p class="text-muted m-0">Total Orders</p>
                                <h4><?= (int)$pay_stats['total_bills'] ?></h4>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border rounded-4 p-4 h-100">
                                <p class="text-muted m-0">Pending Amount</p>
                                <h4>₹ <?= number_format($pay_stats['pending'], 2) ?></h4>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border rounded-4 p-4 h-100">
                                <p class="text-muted m-0">Cleared</p>
                                <h4>₹ <?= number_format($pay_stats['cleared'], 2) ?></h4>
                            </div>
                        </div>
                    </div>
                    <ul class="nav nav-tabs mb-4 flex-wrap">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#pending">Pending Bills</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#history">Payment History</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#methods">Saved Methods</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="pending">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h6 class="fw-bold mb-3">Filters</h6>
                                    <div class="row g-3">
                                        <div class="col-md-3">
                                            <label class="form-label">Bill Status</label>
                                            <select class="form-select">
                                                <option>All</option>
                                                <option>Pending</option>
                                                <option>Overdue</option>
                                                <option>Partially Paid</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Client</label>
                                            <select class="form-select">
                                                <option selected>All Clients</option>
                                                <option>Global Traders</option>
                                                <option>Sharma Enterprises</option>
                                                <option>AMRUN Business</option>
                                                <option>Elite Solutions</option>
                                                <option>Omega Corp</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Select date range</label>
                                            <input type="date" class="form-control">
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button class="btn btn-dark rounded-0 w-100">Apply Filters</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-4">
                                <div class="card-body table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Order #</th>
                                                <th>Placed By</th>
                                                <th>Bill Amount</th>
                                                <th>Paid</th>
                                                <th>Balance Due</th>
                                                <th>Order Date</th>
                                                <th>Status</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (empty($payment_bills)): ?>
                                            <tr><td colspan="7" class="text-center text-muted py-3">No pending bills.</td></tr>
                                            <?php else: foreach ($payment_bills as $bill):
                                                $bamt    = (float)($bill['billing_amount'] ?? 0);
                                                $bpaid   = (float)($bill['paid_amount']    ?? 0);
                                                $bstatus = (int)($bill['payment_status']   ?? 0);
                                                if ($bamt == 0 && !empty($bill['products'])) {
                                                    $prods = @unserialize($bill['products']);
                                                    if (is_array($prods)) {
                                                        foreach ($prods as $p) {
                                                            $wsp = (float)($p['product_info']['wsp'] ?? $p['product_info']['price'] ?? 0);
                                                            $qty = (int)($p['product_quantity'] ?? 1);
                                                            $bamt += $wsp * $qty;
                                                        }
                                                    }
                                                }
                                                $badge = $bstatus === 1
                                                    ? '<span class="badge bg-warning rounded-pill">Partial</span>'
                                                    : '<span class="badge bg-danger rounded-pill">Unpaid</span>';
                                            ?>
                                            <tr>
                                                <td><?= htmlspecialchars($bill['order_id']) ?></td>
                                                <td><?= htmlspecialchars($bill['placed_by'] ?? '—') ?></td>
                                                <td>₹ <?= number_format($bamt, 2) ?></td>
                                                <td>₹ <?= number_format($bpaid, 2) ?></td>
                                                <td>₹ <?= number_format(max(0, $bamt - $bpaid), 2) ?></td>
                                                <td><?= date('d M Y', (int)$bill['date']) ?></td>
                                                <td><?= $badge ?></td>
                                                <td>
                                                    <?php if (in_array((int)$bill['id'], (array)($pending_receipt_order_ids ?? []))): ?>
                                                    <span class="badge rounded-pill bg-warning text-dark"><i class="bi bi-clock me-1"></i>Pending Review</span>
                                                    <?php else: ?>
                                                    <button type="button" class="btn btn-sm btn-dark" onclick="openReceiptModal(<?= (int)$bill['id'] ?>, '<?= htmlspecialchars($bill['order_id']) ?>', <?= max(0, $bamt - $bpaid) ?>)">
                                                        <i class="bi bi-upload"></i> Submit Receipt
                                                    </button>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <?php endforeach; endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="history">
                            <div class="card mb-4 table-responsive">
                                <div class="card-body">
                                    <h6 class="fw-bold mb-3">Payment History</h6>
                                    <table class="table table-hover align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Date</th>
                                                <th>Order #</th>
                                                <th>Submitted By</th>
                                                <th>Amount Paid</th>
                                                <th>Payment Mode</th>
                                                <th>Reference</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (empty($payment_history)): ?>
                                            <tr><td colspan="7" class="text-center text-muted py-3">No payment history found.</td></tr>
                                            <?php else: foreach ($payment_history as $ph): ?>
                                            <tr>
                                                <td><?= date('d M Y', (int)$ph['recorded_at']) ?></td>
                                                <td><?= htmlspecialchars($ph['order_ref'] ?? '—') ?></td>
                                                <td><?= htmlspecialchars($ph['submitted_by'] ?? '—') ?></td>
                                                <td>₹ <?= number_format((float)$ph['amount'], 2) ?></td>
                                                <td><?= htmlspecialchars($ph['mode'] ?? '—') ?></td>
                                                <td><?= htmlspecialchars($ph['reference'] ?? '—') ?></td>
                                                <?php
                                                $ph_status_map = [
                                                    'pending'  => ['bg-warning text-dark', 'Pending Review'],
                                                    'verified' => ['bg-success', 'Verified'],
                                                    'rejected' => ['bg-danger',  'Rejected'],
                                                ];
                                                [$ph_cls, $ph_lbl] = $ph_status_map[$ph['status'] ?? ''] ?? ['bg-secondary', ucfirst($ph['status'] ?? '—')];
                                                ?>
                                                <td><span class="badge rounded-pill <?= $ph_cls ?>"><?= $ph_lbl ?></span></td>
                                            </tr>
                                            <?php endforeach; endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="methods">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h6 class="fw-bold mb-3">Saved Payment Methods</h6>
                                    <ul class="list-group mb-3" id="paymentMethodsList">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Bank Transfer - HDFC Bank, A/C: 1234567890
                                            <span class="badge bg-dark rounded-pill">Default</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Cash
                                            <span class="badge bg-secondary rounded-pill">Saved</span>
                                        </li>
                                    </ul>
                                    <button class="btn_button" data-bs-toggle="modal" data-bs-target="#addMethodModal">
                                        <i class="bi bi-plus-circle"></i> Add New Method
                                    </button>
                                </div>
                            </div>
                            <div class="modal fade" id="addMethodModal" tabindex="-1" aria-labelledby="addMethodLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addMethodLabel">Add New Payment Method</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <label for="paymentType" class="form-label">Payment Type</label>
                                            <select class="form-select" id="paymentType">
                                                <option selected>Select Type</option>
                                                <option value="bank">Bank Transfer</option>
                                                <option value="cash">Cash</option>
                                            </select>
                                            <div id="bankDetails" class="mt-3" style="display:none;">
                                                <label class="form-label">Bank Name</label>
                                                <input type="text" class="form-control" id="bankName" placeholder="Enter bank name">
                                                <label class="form-label mt-2">Account Number</label>
                                                <input type="text" class="form-control" id="accountNumber" placeholder="Enter account number">
                                                <label class="form-label mt-2">IFSC / SWIFT Code</label>
                                                <input type="text" class="form-control" id="ifsc" placeholder="Enter IFSC / SWIFT">
                                                <label class="form-label mt-2">Account Holder Name</label>
                                                <input type="text" class="form-control" id="accountHolder" placeholder="Enter account holder name">
                                            </div>
                                            <div id="cashDetails" class="mt-3" style="display:none;">
                                                <label class="form-label">Reference / Description</label>
                                                <input type="text" class="form-control" id="cashRef" placeholder="Enter description">
                                            </div>
                                            <div class="form-check mt-3">
                                                <input class="form-check-input" type="checkbox" id="setDefault">
                                                <label class="form-check-label" for="setDefault">Set as Default</label>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="button" class="btn btn-primary" id="savePaymentMethod">Add Method</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

<!-- Payment Receipt Upload Modal -->
<div class="modal fade" id="receiptModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Submit Payment Receipt</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="receiptForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="receipt_order_id" name="order_id">
                    <p class="text-muted small mb-3">Order: <strong id="receipt_order_ref"></strong> &nbsp;|&nbsp; Balance Due: <strong id="receipt_balance"></strong></p>
                    <div class="mb-3">
                        <label class="form-label small">Amount Paid <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="receipt_amount" name="amount" step="0.01" min="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Payment Mode</label>
                        <select class="form-select" name="mode" id="receipt_mode">
                            <option value="">Select</option>
                            <option value="UPI">UPI</option>
                            <option value="NEFT">NEFT</option>
                            <option value="RTGS">RTGS</option>
                            <option value="IMPS">IMPS</option>
                            <option value="Cheque">Cheque</option>
                            <option value="Cash">Cash</option>
                            <option value="Bank Transfer">Bank Transfer</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">UTR / Reference Number</label>
                        <input type="text" class="form-control" name="reference" placeholder="Transaction ID / UTR">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Upload Receipt (JPG/PNG/PDF)</label>
                        <input type="file" class="form-control" name="receipt" accept=".jpg,.jpeg,.png,.pdf,.webp">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Notes</label>
                        <textarea class="form-control" name="notes" rows="2" placeholder="Any additional info..."></textarea>
                    </div>
                    <div id="receiptError" class="alert alert-danger d-none"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-dark" id="receiptSubmitBtn">Submit Receipt</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
function openReceiptModal(orderId, orderRef, balanceDue) {
    document.getElementById('receipt_order_id').value = orderId;
    document.getElementById('receipt_order_ref').textContent = orderRef;
    document.getElementById('receipt_balance').textContent = '₹' + parseFloat(balanceDue).toFixed(2);
    document.getElementById('receipt_amount').value = parseFloat(balanceDue).toFixed(2);
    document.getElementById('receiptError').classList.add('d-none');
    var modalEl = document.getElementById('receiptModal');
    (bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl)).show();
}
document.getElementById('receiptForm').addEventListener('submit', function(e) {
    e.preventDefault();
    var btn = document.getElementById('receiptSubmitBtn');
    btn.disabled = true;
    btn.textContent = 'Submitting...';
    var fd = new FormData(this);
    fetch('<?= base_url('home/submit_payment_receipt') ?>', { method:'POST', body: fd })
        .then(function(r){ return r.json(); })
        .then(function(r){
            btn.disabled = false;
            btn.textContent = 'Submit Receipt';
            if (r.success) {
                bootstrap.Modal.getInstance(document.getElementById('receiptModal')).hide();
                alert('Receipt submitted successfully! We will verify and update your payment status.');
                location.reload();
            } else {
                var err = document.getElementById('receiptError');
                err.textContent = r.message || 'Submission failed. Try again.';
                err.classList.remove('d-none');
            }
        })
        .catch(function(){
            btn.disabled = false;
            btn.textContent = 'Submit Receipt';
        });
});

function requestCommission(btn, id) {
    if (!confirm('Request disbursement for this commission?')) return;
    btn.disabled = true;
    btn.textContent = 'Requesting…';
    fetch('<?= base_url('request_commission') ?>', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'commission_id=' + id
    })
    .then(function(r){ return r.json(); })
    .then(function(res) {
        if (res.success) {
            btn.closest('td').innerHTML = '<span class="text-success small"><i class="bi bi-check2-circle"></i> Requested</span>';
        } else {
            btn.disabled = false;
            btn.textContent = 'Request';
            alert('Could not submit request. Try again.');
        }
    })
    .catch(function() { btn.disabled = false; btn.textContent = 'Request'; });
}
</script>

                <div class="tab-pane fade" id="accountsettings" role="tabpanel" aria-labelledby="accountsettings-tab">
                    <div class="card-panel my-2">
                        <div class="mb-3">
                            <h5 class="mb-0">Account Settings</h5>
                            <small class="text-muted">Manage your business profile and login details</small>
                        </div>
                        <?php $settingsUser = get_current_user_info(); ?>
                        <div id="settingsSaveMsg" class="alert alert-success d-none mb-3">Profile updated successfully.</div>
                        <div id="settingsSaveErr" class="alert alert-danger d-none mb-3">Failed to save. Please try again.</div>
                        <form class="mt-3" id="accountSettingsForm">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="fw-semibold fs-6 mb-1">Contact Person Name</label>
                                    <input class="form-control" id="settingsName" placeholder="Enter full name" value="<?= htmlspecialchars($settingsUser->name ?? '') ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="fw-semibold fs-6 mb-1">Company Name</label>
                                    <input class="form-control" id="settingsCompany" placeholder="Your company name" value="<?= htmlspecialchars($settingsUser->company ?? '') ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="fw-semibold fs-6 mb-1">GST Number</label>
                                    <input class="form-control" id="settingsGst" placeholder="22AAAAA0000A1Z5" value="<?= htmlspecialchars($settingsUser->gst ?? '') ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="fw-semibold fs-6 mb-1">Business Email</label>
                                    <input class="form-control" type="email" id="settingsEmail" placeholder="company@email.com" value="<?= htmlspecialchars($settingsUser->email ?? '') ?>">
                                    <div class="form-text text-muted" style="font-size:11px;">This is also used for login. Change with care.</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="fw-semibold fs-6 mb-1">Business Phone</label>
                                    <input class="form-control" type="tel" id="settingsPhone" placeholder="+91 9876543210" value="<?= htmlspecialchars($settingsUser->phone ?? '') ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="fw-semibold fs-6 mb-1">PAN Number</label>
                                    <input class="form-control" id="settingsPan" placeholder="ABCDE1234F" value="<?= htmlspecialchars($settingsUser->pan ?? '') ?>">
                                </div>
                                <div class="col-12">
                                    <label class="fw-semibold fs-6 mb-1">Business Address</label>
                                    <textarea class="form-control" id="settingsAddress" rows="2" placeholder="Full business address"><?= htmlspecialchars($settingsUser->address ?? '') ?></textarea>
                                </div>
                                <div class="col-12 d-flex gap-2 mt-3">
                                    <button type="button" class="btn btn-primary" id="saveSettingsBtn">
                                        <i class="bi bi-check-lg"></i> Save Changes
                                    </button>
                                    <a type="button" class="btn btn-outline-secondary">
                                        <i class="bi bi-key"></i> Change Password
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // payment transfer code 
    const paymentTypeSelect = document.getElementById('paymentType');
    const bankDetails = document.getElementById('bankDetails');
    const cashDetails = document.getElementById('cashDetails');
    const saveBtn = document.getElementById('savePaymentMethod');
    const paymentList = document.getElementById('paymentMethodsList');
    paymentTypeSelect.addEventListener('change', () => {
        const val = paymentTypeSelect.value;
        if (val === 'bank') {
            bankDetails.style.display = 'block';
            cashDetails.style.display = 'none';
        } else if (val === 'cash') {
            bankDetails.style.display = 'none';
            cashDetails.style.display = 'block';
        } else {
            bankDetails.style.display = 'none';
            cashDetails.style.display = 'none';
        }
    });
    saveBtn.addEventListener('click', () => {
        const type = paymentTypeSelect.value;
        let displayText = '';
        if (type === 'bank') {
            const bankName = document.getElementById('bankName').value.trim();
            const accountNumber = document.getElementById('accountNumber').value.trim();
            const ifsc = document.getElementById('ifsc').value.trim();
            const accountHolder = document.getElementById('accountHolder').value.trim();
            if (!bankName || !accountNumber || !ifsc || !accountHolder) {
                alert('Please fill all bank details');
                return;
            }
            displayText = `Bank Transfer - ${bankName}, A/C: ${accountNumber}, IFSC: ${ifsc}, Holder: ${accountHolder}`;
        } else if (type === 'cash') {
            const ref = document.getElementById('cashRef').value.trim();
            if (!ref) {
                alert('Please enter cash reference/description');
                return;
            }
            displayText = `Cash - ${ref}`;
        } else {
            alert('Select a valid payment type');
            return;
        }
        const isDefault = document.getElementById('setDefault').checked;
        if (isDefault) {
            paymentList.querySelectorAll('.badge').forEach(b => {
                if (b.textContent === 'Default') {
                    b.textContent = 'Saved';
                    b.classList.remove('bg-dark');
                    b.classList.add('bg-secondary');
                }
            });
        }
        const li = document.createElement('li');
        li.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-center');
        li.innerHTML = `<span>${displayText}</span>
                        <span class="badge ${isDefault?'bg-dark':'bg-secondary'} rounded-pill">${isDefault?'Default':'Saved'}</span>`;
        paymentList.appendChild(li);
        paymentTypeSelect.value = '';
        bankDetails.style.display = 'none';
        cashDetails.style.display = 'none';
        document.getElementById('bankName').value = '';
        document.getElementById('accountNumber').value = '';
        document.getElementById('ifsc').value = '';
        document.getElementById('accountHolder').value = '';
        document.getElementById('cashRef').value = '';
        document.getElementById('setDefault').checked = false;
        const modalEl = document.getElementById('addMethodModal');
        const modal = bootstrap.Modal.getInstance(modalEl);
        modal.hide();
    });

    // account role define 
    document.addEventListener("DOMContentLoaded", function() {
        const role = USER_ROLE;
        document.querySelectorAll("#pills-tab .nav-item").forEach(tab => {
            if (tab.classList.contains("role-all")) {
                tab.style.display = "block";
                return;
            }
            if (tab.classList.contains("role-" + role)) {
                tab.style.display = "block";
            } else {
                tab.style.display = "none";
            }
        });
    });

    //  coupon copy code
    function copyCoupon(btn) {
        const code = btn.closest('.coupon-item').querySelector('.coupon-code').textContent.trim();
        navigator.clipboard.writeText(code);
        btn.textContent = 'Copied!';
        setTimeout(() => btn.textContent = 'Copy Code', 2000);
    }
    // mobile sidebaar code
    function openSidebar() {
        document.getElementById('accountSidebar').classList.add('show');
        document.getElementById('sidebarOverlay').classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        document.getElementById('accountSidebar').classList.remove('show');
        document.getElementById('sidebarOverlay').classList.remove('show');
        document.body.style.overflow = '';
    }

    // add client code
    document.getElementById("clientForm").addEventListener("submit", function(e) {
        e.preventDefault();
        var form = this;
        var btn = form.querySelector('button[type="submit"]');
        btn.disabled = true;

        var data = {
            company:  document.getElementById("companyName").value,
            email:    document.getElementById("email").value,
            password: document.getElementById("password").value,
            phone:    document.getElementById("phone").value,
            pan:      document.getElementById("panNumber").value,
            gst:      document.getElementById("gstNumber").value,
            address:  document.getElementById("address").value
        };

        fetch('<?= base_url("add_client") ?>', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: new URLSearchParams(data)
        })
        .then(function(r) { return r.json(); })
        .then(function(response) {
            btn.disabled = false;
            if (response && response.success) {
                var m = bootstrap.Modal.getInstance(document.getElementById("addClientModal"));
                if (m) m.hide();
                form.reset();
                location.reload();
            } else {
                alert(response && response.error ? response.error : 'Error adding client. Please try again.');
            }
        })
        .catch(function() {
            btn.disabled = false;
            alert('Request failed. Please try again.');
        });
    });

    // Edit client — open modal
    document.querySelectorAll('.edit-client-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var d = this.dataset;
            document.getElementById('editClientId').value      = d.id;
            document.getElementById('editCompanyName').value   = d.company;
            document.getElementById('editName').value          = d.name;
            document.getElementById('editEmail').value         = d.email;
            document.getElementById('editPhone').value         = d.phone;
            document.getElementById('editPan').value           = d.pan;
            document.getElementById('editGst').value           = d.gst;
            document.getElementById('editAddress').value       = d.address;
            document.getElementById('editPassword').value      = '';
            document.getElementById('editClientError').classList.add('d-none');
            (bootstrap.Modal.getInstance(document.getElementById('editClientModal')) || new bootstrap.Modal(document.getElementById('editClientModal'))).show();
        });
    });

    document.getElementById('saveEditClientBtn').addEventListener('click', function() {
        var btn = this;
        btn.disabled = true;
        btn.textContent = 'Saving…';
        document.getElementById('editClientError').classList.add('d-none');

        var data = {
            id:       document.getElementById('editClientId').value,
            name:     document.getElementById('editName').value,
            company:  document.getElementById('editCompanyName').value,
            phone:    document.getElementById('editPhone').value,
            pan:      document.getElementById('editPan').value,
            gst:      document.getElementById('editGst').value,
            address:  document.getElementById('editAddress').value,
            password: document.getElementById('editPassword').value
        };

        fetch('<?= base_url("edit_client") ?>', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: new URLSearchParams(data)
        })
        .then(function(r) { return r.json(); })
        .then(function(res) {
            btn.disabled = false;
            btn.textContent = 'Save Changes';
            if (res && res.success) {
                bootstrap.Modal.getInstance(document.getElementById('editClientModal')).hide();
                location.reload();
            } else {
                var err = document.getElementById('editClientError');
                err.textContent = res && res.error ? res.error : 'Error saving changes.';
                err.classList.remove('d-none');
            }
        })
        .catch(function() {
            btn.disabled = false;
            btn.textContent = 'Save Changes';
            var err = document.getElementById('editClientError');
            err.textContent = 'Request failed. Please try again.';
            err.classList.remove('d-none');
        });
    });

    // load client stats dynamically
    document.querySelectorAll('.client-orders-cell').forEach(function(cell) {
        var clientId = cell.getAttribute('data-client-id');
        var bizCell = document.querySelector('.client-business-cell[data-client-id="' + clientId + '"]');
        fetch('<?= base_url("get_client_stats") ?>/' + clientId)
            .then(function(r) { return r.json(); })
            .then(function(r) {
                if (r) {
                    cell.textContent = r.orders;
                    if (bizCell) bizCell.textContent = '₹ ' + parseFloat(r.total).toLocaleString('en-IN', {minimumFractionDigits: 2});
                }
            })
            .catch(function(){});
    });
</script>

<script>
// Account Settings — save via AJAX
document.getElementById('saveSettingsBtn').addEventListener('click', function () {
    var btn = this;
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Saving…';
    document.getElementById('settingsSaveMsg').classList.add('d-none');
    document.getElementById('settingsSaveErr').classList.add('d-none');

    fetch('<?= base_url('home/save_settings') ?>', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({
            name:    document.getElementById('settingsName').value,
            company: document.getElementById('settingsCompany').value,
            gst:     document.getElementById('settingsGst').value,
            email:   document.getElementById('settingsEmail').value,
            phone:   document.getElementById('settingsPhone').value,
            pan:     document.getElementById('settingsPan').value,
            address: document.getElementById('settingsAddress').value,
        })
    })
    .then(function(r) { return r.json(); })
    .then(function (res) {
        if (res.success) {
            document.getElementById('settingsSaveMsg').classList.remove('d-none');
        } else {
            document.getElementById('settingsSaveErr').classList.remove('d-none');
        }
    })
    .catch(function () {
        document.getElementById('settingsSaveErr').classList.remove('d-none');
    })
    .finally(function () {
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-check-lg"></i> Save Changes';
    });
});
</script>

<?php include("footer.php") ?>

<script>
// Address modal — Add / Edit / Delete / Set Default
(function () {
    var modalEl  = document.getElementById('editAddressModal');
    var addrList = document.getElementById('addressList');

    // Populate modal when it's about to show — based on which button triggered it
    modalEl.addEventListener('show.bs.modal', function (event) {
        var trigger = event.relatedTarget;
        document.getElementById('addrSaveMsg').classList.add('d-none');

        if (trigger && trigger.classList.contains('addr-edit-btn')) {
            // Edit mode — pre-fill from data attributes
            document.getElementById('addrModalTitle').textContent = 'Edit Address';
            document.getElementById('addrId').value       = trigger.dataset.id      || '0';
            document.getElementById('addrLabel').value    = trigger.dataset.label   || '';
            document.getElementById('addrCompany').value  = trigger.dataset.company || '';
            document.getElementById('addrGst').value      = trigger.dataset.gst     || '';
            document.getElementById('addrName').value     = trigger.dataset.name    || '';
            document.getElementById('addrPhone').value    = trigger.dataset.phone   || '';
            document.getElementById('addrAddress').value  = trigger.dataset.address || '';
            document.getElementById('addrIsDefault').checked = trigger.dataset.default === '1';
        } else {
            // Add New mode — clear form
            document.getElementById('addrModalTitle').textContent = 'Add New Address';
            document.getElementById('addrId').value       = '0';
            document.getElementById('addrLabel').value    = '';
            document.getElementById('addrCompany').value  = '';
            document.getElementById('addrGst').value      = '';
            document.getElementById('addrName').value     = '';
            document.getElementById('addrPhone').value    = '';
            document.getElementById('addrAddress').value  = '';
            document.getElementById('addrIsDefault').checked = false;
        }
    });

    // Delete / Set Default (delegated — edit is handled by data-bs-toggle)
    addrList.addEventListener('click', function (e) {
        var delBtn = e.target.closest('.addr-delete-btn');
        if (delBtn) {
            if (!confirm('Delete this address?')) return;
            var id = delBtn.dataset.id;
            fetch('<?= base_url('home/delete_user_address') ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ id: id })
            })
            .then(r => r.json())
            .then(function (res) {
                if (res.success) {
                    var card = addrList.querySelector('.addr-list-card[data-id="' + id + '"]');
                    if (card) card.remove();
                    if (!addrList.querySelector('.addr-list-card')) {
                        addrList.innerHTML = '<div class="text-muted text-center py-4"><i class="bi bi-geo-alt fs-2 d-block mb-2"></i>No saved addresses yet.</div>';
                    }
                }
            });
            return;
        }

        var defBtn = e.target.closest('.addr-set-default-btn');
        if (defBtn) {
            fetch('<?= base_url('home/set_default_address') ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ id: defBtn.dataset.id })
            })
            .then(r => r.json())
            .then(function (res) { if (res.success) location.reload(); });
        }
    });

    // Save button inside modal
    document.getElementById('saveAddressBtn').addEventListener('click', function () {
        var btn = this;
        btn.disabled = true;
        btn.textContent = 'Saving…';
        fetch('<?= base_url('home/save_user_address') ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({
                id:         document.getElementById('addrId').value,
                label:      document.getElementById('addrLabel').value,
                company:    document.getElementById('addrCompany').value,
                gst:        document.getElementById('addrGst').value,
                name:       document.getElementById('addrName').value,
                phone:      document.getElementById('addrPhone').value,
                address:    document.getElementById('addrAddress').value,
                is_default: document.getElementById('addrIsDefault').checked ? '1' : '0',
            })
        })
        .then(r => r.json())
        .then(function (res) {
            if (res.success) {
                document.getElementById('addrSaveMsg').classList.remove('d-none');
                setTimeout(function () {
                    bootstrap.Modal.getInstance(modalEl).hide();
                    location.reload();
                }, 700);
            }
        })
        .finally(function () {
            btn.disabled = false;
            btn.textContent = 'Save';
        });
    });
})();
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Update hash on tab click
    document.querySelectorAll('#pills-tab .nav-link').forEach(function (link) {
        link.addEventListener('click', function () {
            var target = this.getAttribute('data-bs-target');
            if (target) history.replaceState(null, '', target);
        });
    });

    // Activate tab from URL hash using Bootstrap Tab API
    var hash = window.location.hash;
    if (hash) {
        var link = document.querySelector('#pills-tab .nav-link[data-bs-target="' + hash + '"]');
        if (link) {
            bootstrap.Tab.getOrCreateInstance(link).show();
        }
    }

    // Copy tracking number button
    document.addEventListener('click', function(e) {
        var btn = e.target.closest('.copy-tracking-btn');
        if (!btn) return;
        var val = btn.getAttribute('data-val');
        navigator.clipboard.writeText(val).then(function() {
            btn.innerHTML = '<i class="bi bi-check" style="font-size:11px;"></i>';
            setTimeout(function() { btn.innerHTML = '<i class="bi bi-copy" style="font-size:11px;"></i>'; }, 1500);
        });
    });
});
</script>