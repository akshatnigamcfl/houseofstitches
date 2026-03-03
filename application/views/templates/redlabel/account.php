<title>Shop | Bulk Clothing Supplier – House of Stitches</title>
<meta name="description"
    content="Browse our wholesale kidswear shop – premium bulk clothing for boys & girls aged 6–15 years. Trusted supplier in India for bulk orders only. Quality at scale.">
<meta name="keywords"
    content="wholesale kidswear shop, bulk kids clothing India, wholesale children’s fashion, kidswear supplier India, wholesale boys & girls wear, bulk order kids clothes, kidswear wholesale online, wholesale kids clothing distributor, House of Stitches shop, kidswear wholesale supplier">
<script>
    const USER_ROLE = "agent"; // retailer, wholesaler, agent, distributor
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
                <li class="nav-item role-agent" role="presentation">
                    <a class="nav-link position-relative" id="clients-tab" data-bs-toggle="pill"
                        data-bs-target="#clients" type="button" role="tab" aria-controls="clients"
                        aria-selected="true"><i class="bi bi-people-fill me-2"></i></i>My Clients</a>
                </li>
                <li class="nav-item role-wholesaler role-retailer role-distributor" role="presentation">
                    <a class="nav-link position-relative" id="myorders-tab" data-bs-toggle="pill" data-bs-target="#myorders"
                        type="button" role="tab" aria-controls="myorders" aria-selected="false"><i
                            class="bi bi-receipt me-2"></i>My Orders</a>
                </li>
                <li class="nav-item role-agent role-distributor" role="presentation">
                    <a class="nav-link position-relative" id="retailerorders-tab" data-bs-toggle="pill" data-bs-target="#retailerorders"
                        type="button" role="tab" aria-controls="retailerorders" aria-selected="false"><i
                            class="bi bi-shop me-2"></i>Retailer Orders</a>
                </li>
                <li class="nav-item role-all" role="presentation">
                    <a class="nav-link position-relative" id="track-tab" data-bs-toggle="pill" data-bs-target="#track"
                        type="button" role="tab" aria-controls="track" aria-selected="false"><i
                            class="bi bi-truck me-2"></i>Tracking</a>
                </li>
                <li class="nav-item role-agent" role="presentation">
                    <a class="nav-link position-relative" id="commission-tab" data-bs-toggle="pill" data-bs-target="#commission"
                        type="button" role="tab" aria-controls="commission" aria-selected="false"><i
                            class="bi bi-currency-rupee me-2"></i>Commission</a>
                </li>
                <li class="nav-item role-agent role-retailer role-distributor role-wholesaler" role="presentation">
                    <a class="nav-link position-relative" id="ledger-tab" data-bs-toggle="pill" data-bs-target="#ledger"
                        type="button" role="tab" aria-controls="ledger" aria-selected="false"><i
                            class="bi bi-person-lines-fill me-2"></i>Ledger</a>
                </li>
                <li class="nav-item role-agent role-distributor" role="presentation">
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
                <li class="nav-item role-all" role="presentation">
                    <a class="nav-link position-relative" id="payments-tab" data-bs-toggle="pill"
                        data-bs-target="#payments" type="button" role="tab" aria-controls="payments"
                        aria-selected="false"><i class="bi bi-credit-card-2-front me-2"></i>Payments</a>
                </li>
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
                    <div class="row g-4 mt-2">
                        <div class="col-xl-8">
                            <div class="bg-white rounded-4 shadow-sm p-4">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div>
                                        <h2 class="fw-bold mb-1">
                                            Welcome, <?php echo get_loggedin_user_details()->name; ?>
                                        </h2>
                                        <p class="text-muted mb-0">Business overview & recent activity</p>
                                    </div>
                                    <!-- Role -->
                                    <span class="badge rounded-pill bg-dark px-4 py-2 text-uppercase">
                                        Agent
                                    </span>
                                </div>
                                <hr>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="border rounded-4 p-4 h-100">
                                            <div class="text-muted small mb-1">ORDERS (30 DAYS)</div>
                                            <h2 class="fw-bold mb-0"><?php echo count(get_order()); ?></h2>
                                            <div class="text-muted small mt-1">Total Orders</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="border rounded-4 p-4 h-100">
                                            <div class="text-muted small mb-1">PENDING PAYMENT</div>
                                            <h2 class="fw-bold text-danger mb-0">₹ 0</h2>
                                            <div class="text-muted small mt-1">Outstanding Invoices</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="border rounded-4 p-4 h-100">
                                            <div class="text-muted small mb-1">PENDING DISPATCH</div>
                                            <h2 class="fw-bold text-info mb-0">2</h2>
                                            <div class="text-muted small mt-1">Awaiting Shipment</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="bg-white rounded-4 shadow-sm p-3 h-100">
                                <div class="text-center">
                                    <img src="https://ui-avatars.com/api/?name=<?php echo get_loggedin_user_details()->name; ?>&background=000000&color=ffffff&rounded=true&size=140"
                                        class="rounded-circle mb-3" width="120">
                                    <h5 class="fw-bold mb-1">
                                        <?php echo $this->session->userdata['logged_user']['name']; ?>
                                    </h5>
                                    <div class="text-muted mb-2">
                                        <?php echo $this->session->userdata['logged_user']['email']; ?>
                                    </div>
                                    <span class="badge bg-dark px-4 py-2 mb-3">
                                        Agent
                                    </span>
                                    <div class="small text-muted mt-1">
                                        Member since <strong><?php echo date('d M Y', strtotime($this->session->userdata['logged_user']['created'])); ?></strong>
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
                                                            <option value="">Select user type</option>
                                                            <option value="1">Agent</option>
                                                            <option value="2">Retailer</option>
                                                            <option value="3">Distributor</option>
                                                            <option value="4">Wholesaler</option>
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
                                    <?php foreach ($clients as $val){ ?>
                                    <tr>
                                        <td><?= $val->name; ?></td>
                                        <td><?= $val->company; ?></td>
                                        <td><span class="badge bg-info"><?php
                                        if($val->type==1){
                                            echo 'Agent';
                                        }elseif ($val->type==2) {
                                            echo 'Distributor';
                                        }elseif($val->type==3){
                                            echo 'Retailer';
                                        }else{
                                            echo 'Wholesller';
                                        }
                                        ?></span></td>
                                        <td><?= $val->phone; ?></td>
                                        <td>₹ 0/-</td>
                                        <td>₹ 0/-</td>
                                        <td>
                                        <?php if($val->status==1){ ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php }else{ ?>
                                         <span class="badge bg-success">Pending</span>

                                        <?php } ?>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary">View</button>
                                            <button class="btn btn-sm btn-outline-success">Order</button>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="myorders" role="tabpanel" aria-labelledby="myorders-tab">
                    <div class="d-flex justify-content-between align-items-center my-3 flex-wrap">
                        <div>
                            <small class="text-muted">Track Orders, Order History, and GR Requests</small>
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
                    <div class="row mb-4 g-3">
                        <div class="col-md-3">
                            <div class="border rounded-4 p-4 h-100">
                                <p class="text-muted m-0">Total Orders</p>
                                <h4>56</h4>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border rounded-4 p-4 h-100">
                                <p class="text-muted m-0">Pending Orders</p>
                                <h4>18</h4>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border rounded-4 p-4 h-100">
                                <p class="text-muted m-0">Shipped</p>
                                <h4>24</h4>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border rounded-4 p-4 h-100">
                                <p class="text-muted m-0">Delivered</p>
                                <h4>14</h4>
                            </div>
                        </div>
                    </div>
                    <ul class="nav nav-tabs mb-4 flex-wrap">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#myOrders">My Orders</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#orderHistory">Order History</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#grRequest">GR Request</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="myOrders">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h6 class="fw-bold mb-3">Filters</h6>
                                    <div class="row g-3">
                                        <div class="col-md-3">
                                            <label class="form-label">Order Status</label>
                                            <select class="form-select">
                                                <option>All</option>
                                                <option>Pending</option>
                                                <option>Processing</option>
                                                <option>Shipped</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Supplier</label>
                                            <select class="form-select">
                                                <option selected>All Suppliers</option>
                                                <option>Global Traders</option>
                                                <option>Sharma Enterprises</option>
                                                <option>AMRUN Business</option>
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
                                                <th>Supplier</th>
                                                <th>Items</th>
                                                <th>Total</th>
                                                <th>Order Date</th>
                                                <th>Delivery Date</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>#ORD-3201</td>
                                                <td>Global Traders</td>
                                                <td>120 Units</td>
                                                <td>₹ 3,50,000</td>
                                                <td>10 Feb 2026</td>
                                                <td>18 Feb 2026</td>
                                                <td><span class="badge bg-warning rounded-pill">Pending</span></td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-secondary">View</button>
                                                    <button class="btn btn-sm btn-dark">Track</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>#ORD-3202</td>
                                                <td>Sharma Enterprises</td>
                                                <td>60 Units</td>
                                                <td>₹ 1,20,000</td>
                                                <td>05 Feb 2026</td>
                                                <td>15 Feb 2026</td>
                                                <td><span class="badge bg-info rounded-pill">Shipped</span></td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-secondary">View</button>
                                                    <button class="btn btn-sm btn-success">Track</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="orderHistory">
                            <div class="card mb-4 table-responsive">
                                <div class="card-body">
                                    <h6 class="fw-bold mb-3">Order History</h6>
                                    <table class="table table-hover align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Date</th>
                                                <th>Order #</th>
                                                <th>Supplier</th>
                                                <th>Total</th>
                                                <th>Invoice</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>25 Jan 2026</td>
                                                <td>#ORD-3190</td>
                                                <td>AMRUN Business</td>
                                                <td>₹ 95,000</td>
                                                <td><button class="btn btn-sm btn-outline-dark">Download</button></td>
                                                <td><span class="badge rounded-pill bg-success">Delivered</span></td>
                                            </tr>
                                            <tr>
                                                <td>15 Jan 2026</td>
                                                <td>#ORD-3175</td>
                                                <td>Elite Solutions</td>
                                                <td>₹ 1,45,000</td>
                                                <td><button class="btn btn-sm btn-outline-dark">Download</button></td>
                                                <td><span class="badge rounded-pill bg-success">Delivered</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="grRequest">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h6 class="fw-bold mb-3">Goods Return (GR) Request</h6>
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label">Order Id *</label>
                                            <select class="form-select">
                                                <option selected disabled>Select Order</option>
                                                <option>ORD-1001</option>
                                                <option>ORD-1002</option>
                                                <option>ORD-1003</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Invoice Number *</label>
                                            <select class="form-select">
                                                <option selected disabled>Select Invoice</option>
                                                <option>INV-5001</option>
                                                <option>INV-5002</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Product *</label>
                                            <select class="form-select">
                                                <option selected disabled>Select Product</option>
                                                <option>Men Shirt Blue</option>
                                                <option>Women Kurti Red</option>
                                                <option>Kids Jeans</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">SKU / Product *</label>
                                            <div class="input-group">
                                                <select class="form-select" id="skuSelect" required>
                                                    <option selected disabled>Select Product</option>
                                                    <option value="SR10-IND">Steel Rod 10mm (SR10-IND)</option>
                                                    <option value="CB50-ACC">Cement Bag 50kg (CB50-ACC)</option>
                                                    <option value="ALS-02">Aluminium Sheet (ALS-02)</option>
                                                </select>
                                                <a class="btn btn-outline-secondary" href="<?php echo base_url('home/barcode_scan'); ?>">
                                                    <i class="bi bi-qr-code-scan"></i>
                                                </a>
                                            </div>
                                            <small class="text-muted">Select product from dropdown or scan barcode</small>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Return Quantity *</label>
                                            <input type="number" class="form-control" placeholder="Enter Quantity">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Return Type *</label>
                                            <select class="form-select">
                                                <option selected disabled>Select Return Type</option>
                                                <option>Wrong Item</option>
                                                <option>Quality Issue</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Upload Proof (Images / Invoice)</label>
                                            <input type="file" class="form-control" multiple>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">Remark / Additional Notes *</label>
                                            <textarea class="form-control" rows="4"
                                                placeholder="Any additional details for processing this return"></textarea>
                                            <i class="bi bi-info-circle-fill me-2"></i>
                                            <small class="text-muted">
                                                Note: Submission of this Goods Return (GR) Request does not guarantee approval.
                                                Approval will be verified and confirmed by our team after review.
                                            </small>
                                        </div>
                                        <div class="col-md-3">
                                            <button class="btn btn-dark rounded-0 w-100 mt-2">
                                                Submit GR Request
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="retailerorders" role="tabpanel" aria-labelledby="retailerorders-tab">
                    <div class="d-flex justify-content-between align-items-center my-3 flex-wrap">
                        <div>
                            <small class="text-muted">Track Retailer Orders, Order History, and GR Requests</small>
                        </div>
                        <div class="d-flex gap-2 mt-2 mt-md-0 flex-wrap">
                            <button class="btn btn-outline-secondary">
                                <i class="bi bi-download"></i> Export Retailer Orders
                            </button>
                            <button class="btn btn-dark">
                                <i class="bi bi-bag-check"></i> Create Retailer Order
                            </button>
                        </div>
                    </div>
                    <div class="row mb-4 g-3">
                        <div class="col-md-3">
                            <div class="border rounded-4 p-4 h-100">
                                <p class="text-muted m-0">Total Retailer Orders</p>
                                <h4>42</h4>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border rounded-4 p-4 h-100">
                                <p class="text-muted m-0">Pending Orders</p>
                                <h4>15</h4>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border rounded-4 p-4 h-100">
                                <p class="text-muted m-0">Shipped Orders</p>
                                <h4>18</h4>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border rounded-4 p-4 h-100">
                                <p class="text-muted m-0">Delivered Orders</p>
                                <h4>9</h4>
                            </div>
                        </div>
                    </div>
                    <ul class="nav nav-tabs mb-4 flex-wrap">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#retailerOrders">Retailer Orders</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#retailerOrderHistory">Order History</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#retailerGrRequest">GR Request</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="retailerOrders">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h6 class="fw-bold mb-3">Filters</h6>
                                    <div class="row g-3">
                                        <div class="col-md-3">
                                            <label class="form-label">Order Status</label>
                                            <select class="form-select">
                                                <option selected>All</option>
                                                <option>Pending</option>
                                                <option>Processing</option>
                                                <option>Shipped</option>
                                                <option>Delivered</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Retailer</label>
                                            <select class="form-select">
                                                <option selected>All Retailers</option>
                                                <option>Retailer One</option>
                                                <option>Retailer Two</option>
                                                <option>Retailer Three</option>
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
                                                <th>Retailer</th>
                                                <th>Items</th>
                                                <th>Total</th>
                                                <th>Order Date</th>
                                                <th>Delivery Date</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>#ORD-4001</td>
                                                <td>Retailer One</td>
                                                <td>50 Units</td>
                                                <td>₹ 1,50,000</td>
                                                <td>10 Feb 2026</td>
                                                <td>18 Feb 2026</td>
                                                <td><span class="badge bg-warning rounded-pill">Pending</span></td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-secondary">View</button>
                                                    <button class="btn btn-sm btn-dark">Track</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>#ORD-4002</td>
                                                <td>Retailer Two</td>
                                                <td>30 Units</td>
                                                <td>₹ 90,000</td>
                                                <td>05 Feb 2026</td>
                                                <td>15 Feb 2026</td>
                                                <td><span class="badge bg-info rounded-pill">Shipped</span></td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-secondary">View</button>
                                                    <button class="btn btn-sm btn-success">Track</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="retailerOrderHistory">
                            <div class="card mb-4 table-responsive">
                                <div class="card-body">
                                    <h6 class="fw-bold mb-3">Order History</h6>
                                    <table class="table table-hover align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Date</th>
                                                <th>Order #</th>
                                                <th>Retailer</th>
                                                <th>Total</th>
                                                <th>Invoice</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>25 Jan 2026</td>
                                                <td>#ORD-3990</td>
                                                <td>Retailer Three</td>
                                                <td>₹ 95,000</td>
                                                <td><button class="btn btn-sm btn-outline-dark">Download</button></td>
                                                <td><span class="badge rounded-pill bg-success">Delivered</span></td>
                                            </tr>
                                            <tr>
                                                <td>15 Jan 2026</td>
                                                <td>#ORD-3975</td>
                                                <td>Retailer Two</td>
                                                <td>₹ 1,45,000</td>
                                                <td><button class="btn btn-sm btn-outline-dark">Download</button></td>
                                                <td><span class="badge rounded-pill bg-success">Delivered</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="retailerGrRequest">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h6 class="fw-bold mb-3">Goods Return (GR) Request</h6>
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label">Order Id *</label>
                                            <select class="form-select">
                                                <option selected disabled>Select Order</option>
                                                <option>ORD-4001</option>
                                                <option>ORD-4002</option>
                                                <option>ORD-4003</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Invoice Number *</label>
                                            <select class="form-select">
                                                <option selected disabled>Select Invoice</option>
                                                <option>INV-6001</option>
                                                <option>INV-6002</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Product *</label>
                                            <select class="form-select">
                                                <option selected disabled>Select Product</option>
                                                <option>Men Shirt Blue</option>
                                                <option>Women Kurti Red</option>
                                                <option>Kids Jeans</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">SKU / Product *</label>
                                            <div class="input-group">
                                                <select class="form-select" id="skuSelect" required>
                                                    <option selected disabled>Select Product</option>
                                                    <option value="SR10-IND">Steel Rod 10mm (SR10-IND)</option>
                                                    <option value="CB50-ACC">Cement Bag 50kg (CB50-ACC)</option>
                                                    <option value="ALS-02">Aluminium Sheet (ALS-02)</option>
                                                </select>
                                                <a class="btn btn-outline-secondary" href="#">
                                                    <i class="bi bi-qr-code-scan"></i>
                                                </a>
                                            </div>
                                            <small class="text-muted">Select product from dropdown or scan barcode</small>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Return Quantity *</label>
                                            <input type="number" class="form-control" placeholder="Enter Quantity">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Return Type *</label>
                                            <select class="form-select">
                                                <option selected disabled>Select Return Type</option>
                                                <option>Wrong Item</option>
                                                <option>Quality Issue</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Upload Proof (Images / Invoice)</label>
                                            <input type="file" class="form-control" multiple>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">Remark / Additional Notes *</label>
                                            <textarea class="form-control" rows="4" placeholder="Any additional details for processing this return"></textarea>
                                            <i class="bi bi-info-circle-fill me-2"></i>
                                            <small class="text-muted">
                                                Note: Submission of this Goods Return (GR) Request does not guarantee approval.
                                                Approval will be verified and confirmed by our team after review.
                                            </small>
                                        </div>
                                        <div class="col-md-3">
                                            <button class="btn btn-dark rounded-0 w-100 mt-2">
                                                Submit GR Request
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="track" role="tabpanel" aria-labelledby="track-tab">
                    <div class="card-panel my-2">
                        <div class="mb-3">
                            <h5 class="mb-1">Track Your Shipment</h5>
                            <small class="text-muted">
                                Enter your Order ID or LR number to get real-time delivery updates
                            </small>
                        </div>
                        <div class="row g-3 align-items-center mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Order ID / LR (Builty) Number</label>
                                <input class="form-control" placeholder="Eg: ORD12345 or LR458963214">
                                <small class="text-muted">You can find this on your invoice or SMS</small>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-primary w-100">
                                    <i class="bi bi-search me-1"></i> Track Shipment
                                </button>
                            </div>
                        </div>
                        <div class="border rounded p-4 bg-light">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h6 class="mb-0">Shipment Status</h6>
                                    <small class="text-muted">Latest delivery update</small>
                                </div>
                                <span class="badge bg-info text-dark px-3 py-2">
                                    In Transit
                                </span>
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <div class="small text-muted">Transporter</div>
                                    <div class="fw-semibold">VRL Logistics</div>
                                </div>
                                <div class="col-md-4">
                                    <div class="small text-muted">LR / Builty Number</div>
                                    <div class="fw-semibold">458963214</div>
                                </div>
                                <div class="col-md-4">
                                    <div class="small text-muted">Current Location</div>
                                    <div class="fw-semibold">Jaipur Hub</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="small text-muted">Dispatch Date</div>
                                    <div class="fw-semibold">15 Jan 2026</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="small text-muted">Expected Delivery</div>
                                    <div class="fw-semibold">20 Jan 2026</div>
                                </div>
                            </div>
                            <div class="alert alert-info mb-0">
                                <i class="bi bi-info-circle me-2"></i>
                                For any delay or support, please contact our logistics team with your LR number.
                            </div>
                        </div>
                    </div>
                </div>
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
                            <div class="col-md-4">
                                <div class="border rounded-4 p-4 h-100">
                                    <div class="small text-muted mb-1">Total Commission</div>
                                    <h4 class="fw-semibold mb-0">₹ 2,45,800</h4>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded-4 p-4 h-100">
                                    <div class="small text-muted mb-1">Paid Commission</div>
                                    <h4 class="fw-semibold mb-0 text-success">₹ 1,80,000</h4>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded-4 p-4 h-100">
                                    <div class="small text-muted mb-1">Pending Commission</div>
                                    <h4 class="fw-semibold mb-0 text-danger">₹ 65,800</h4>
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
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="fw-semibold">ORD-2456</td>
                                        <td>Sharma Retailers</td>
                                        <td>₹ 1,20,000</td>
                                        <td>5%</td>
                                        <td>₹ 6,000</td>
                                        <td>
                                            <span class="badge rounded-pill bg-success-subtle text-success border">
                                                Paid
                                            </span>
                                        </td>
                                        <td>12 Jan 2026</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">ORD-2490</td>
                                        <td>Gupta Distributors</td>
                                        <td>₹ 98,000</td>
                                        <td>5%</td>
                                        <td>₹ 4,900</td>
                                        <td>
                                            <span class="badge rounded-pill bg-warning-subtle text-warning border">
                                                Pending
                                            </span>
                                        </td>
                                        <td>15 Jan 2026</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="ledger" role="tabpanel" aria-labelledby="ledger-tab">
                    <div class="card-panel p-4 rounded-4 shadow-sm bg-white my-2">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h4 class="fw-semibold mb-1">Agent Ledger</h4>
                                <small class="text-muted">Debit / Credit transaction history</small>
                            </div>
                            <button class="btn btn-outline-dark rounded-pill px-4">
                                <i class="bi bi-download me-2"></i> Download Ledger
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Date</th>
                                        <th>Ref No</th>
                                        <th>Description</th>
                                        <th class="text-success">Credit</th>
                                        <th class="text-danger">Debit</th>
                                        <th>Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>10 Jan 2026</td>
                                        <td>COMM-2456</td>
                                        <td>Commission Earned</td>
                                        <td class="text-success">₹ 6,000</td>
                                        <td>-</td>
                                        <td>₹ 80,200</td>
                                    </tr>
                                    <tr>
                                        <td>12 Jan 2026</td>
                                        <td>PAY-1021</td>
                                        <td>Payout</td>
                                        <td>-</td>
                                        <td class="text-danger">₹ 10,000</td>
                                        <td>₹ 70,200</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="claim" role="tabpanel" aria-labelledby="claim-tab">
                    <div class="card-panel p-4 rounded-4 shadow-sm bg-white my-2">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h4 class="fw-semibold mb-1">Agent Claims</h4>
                                <small class="text-muted">Track your submitted claims and their status</small>
                            </div>
                            <button class="btn btn-dark rounded-pill px-4">
                                <i class="bi bi-plus-circle me-2"></i> New Claim
                            </button>
                        </div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <input class="form-control rounded-3" placeholder="Search by Claim ID / Client">
                            </div>
                            <div class="col-md-3">
                                <select class="form-select rounded-3">
                                    <option>All Status</option>
                                    <option>Pending</option>
                                    <option>Approved</option>
                                    <option>Rejected</option>
                                    <option>Paid</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="date" class="form-control rounded-3">
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button class="btn btn-dark w-100 rounded-0">Apply</button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Claim ID</th>
                                        <th>Client / Dealer</th>
                                        <th>Claim Type</th>
                                        <th>Amount (₹)</th>
                                        <th>Submitted On</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="fw-semibold">CLM-1045</td>
                                        <td>Sharma Retailers</td>
                                        <td>Incentive</td>
                                        <td>12,000</td>
                                        <td>14 Jan 2026</td>
                                        <td>
                                            <span class="badge rounded-pill bg-success-subtle text-success border">
                                                Approved
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-dark">View</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">CLM-1052</td>
                                        <td>Gupta Distributors</td>
                                        <td>Rate Difference</td>
                                        <td>8,500</td>
                                        <td>18 Jan 2026</td>
                                        <td>
                                            <span class="badge rounded-pill bg-warning-subtle text-warning border">
                                                Pending
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-dark">View</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">CLM-1058</td>
                                        <td>Kumar Traders</td>
                                        <td>Damage</td>
                                        <td>4,200</td>
                                        <td>20 Jan 2026</td>
                                        <td>
                                            <span class="badge rounded-pill bg-danger-subtle text-danger border">
                                                Rejected
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-dark">View</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">CLM-1060</td>
                                        <td>Sharma Retailers</td>
                                        <td>Special Incentive</td>
                                        <td>10,000</td>
                                        <td>22 Jan 2026</td>
                                        <td>
                                            <span class="badge rounded-pill bg-info-subtle text-info border">
                                                Paid
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-dark">View</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
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
                                <small class="text-muted">Manage your billing & delivery locations</small>
                            </div>
                            <a class="btn btn-primary btn-sm">
                                <i class="bi bi-plus-lg"></i> Add New Address
                            </a>
                        </div>
                        <div class="p-3 border rounded d-flex justify-content-between align-items-start">
                            <div>
                                <div class="fw-bold fs-6">Head Office (Billing Address)</div>
                                <div class="mt-1">
                                    <strong>Company:</strong> <?= get_current_user_info()->company_name; ?><br>
                                    <strong>GST No:</strong> <?= get_current_user_info()->gst_no; ?><br>
                                    <strong>Contact:</strong> <?= get_current_user_info()->contact_person; ?><br>
                                    <strong>Phone:</strong> <?= get_current_user_info()->phone; ?><br>
                                    <strong>Address:</strong>
                                    <span class="text-muted"><?= get_current_user_info()->address; ?></span>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <a class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <a class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i> Delete
                                </a>
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
                        <div class="col-md-3">
                            <div class="border rounded-4 p-4 h-100">
                                <p class="text-muted m-0">Total Bills</p>
                                <h4>42</h4>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border rounded-4 p-4 h-100">
                                <p class="text-muted m-0">Pending</p>
                                <h4>₹ 1,20,000</h4>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border rounded-4 p-4 h-100">
                                <p class="text-muted m-0">Overdue</p>
                                <h4>₹ 58,000</h4>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border rounded-4 p-4 h-100">
                                <p class="text-muted m-0">Cleared</p>
                                <h4>₹ 2,62,000</h4>
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
                                                <th>Bill #</th>
                                                <th>Client</th>
                                                <th>Amount</th>
                                                <th>Tax</th>
                                                <th>Total</th>
                                                <th>Due Date</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>#BILL-2001</td>
                                                <td>Global Traders</td>
                                                <td>₹ 32,500</td>
                                                <td>₹ 2,500</td>
                                                <td>₹ 35,000</td>
                                                <td>18 Feb 2026</td>
                                                <td><span class="badge bg-warning rounded-pill">Pending</span></td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-secondary">View</button>
                                                    <button class="btn btn-sm btn-dark ">Pay Now</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>#BILL-2002</td>
                                                <td>Sharma Enterprises</td>
                                                <td>₹ 58,000</td>
                                                <td>₹ 4,640</td>
                                                <td>₹ 62,640</td>
                                                <td>25 Jan 2026</td>
                                                <td><span class="badge rounded-pill bg-danger">Overdue</span></td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-secondary">View</button>
                                                    <button class="btn btn-sm btn-dark ">Pay Now</button>
                                                </td>
                                            </tr>
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
                                                <th>Bill #</th>
                                                <th>Client</th>
                                                <th>Amount Paid</th>
                                                <th>Payment Mode</th>
                                                <th>Transaction ID</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>12 Jan 2026</td>
                                                <td>#BILL-1999</td>
                                                <td>AMRUN BUSINESS</td>
                                                <td>₹ 45,000</td>
                                                <td>UPI</td>
                                                <td>TXN12345</td>
                                                <td><span class="badge rounded-pill bg-success">Paid</span></td>
                                            </tr>
                                            <tr>
                                                <td>15 Jan 2026</td>
                                                <td>#BILL-2000</td>
                                                <td>Global Traders</td>
                                                <td>₹ 20,000</td>
                                                <td>Credit Card</td>
                                                <td>TXN12346</td>
                                                <td><span class="badge rounded-pill bg-success">Paid</span></td>
                                            </tr>
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
                <div class="tab-pane fade" id="accountsettings" role="tabpanel" aria-labelledby="accountsettings-tab">
                    <div class="card-panel my-2">
                        <div class="mb-3">
                            <h5 class="mb-0">Account Settings</h5>
                            <small class="text-muted">Manage your business profile and login details</small>
                        </div>
                        <form class="mt-3">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="fw-semibold fs-6 mb-1">Contact Person Name</label>
                                    <input class="form-control" required placeholder="Enter full name">
                                </div>
                                <div class="col-md-6">
                                    <label class="fw-semibold fs-6 mb-1">Company Name</label>
                                    <input class="form-control" required placeholder="Your company name">
                                </div>
                                <div class="col-md-6">
                                    <label class="fw-semibold fs-6 mb-1">GST Number</label>
                                    <input class="form-control" placeholder="22AAAAA0000A1Z5">
                                </div>
                                <div class="col-md-6">
                                    <label class="fw-semibold fs-6 mb-1">Business Email</label>
                                    <input class="form-control" type="email" required placeholder="company@email.com">
                                </div>
                                <div class="col-md-6">
                                    <label class="fw-semibold fs-6 mb-1">Business Phone</label>
                                    <input class="form-control" type="tel" placeholder="+91 9876543210">
                                </div>
                                <div class="col-12 d-flex gap-2 mt-3">
                                    <button type="submit" class="btn btn-primary">
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
        const companyName = document.getElementById("companyName").value; 
        const email = document.getElementById("email").value;
        const pass = document.getElementById("password").value;
        const phone = document.getElementById("phone").value;
        const panNumber = document.getElementById("panNumber").value;
        const gstNumber = document.getElementById("gstNumber").value;
        const userType = document.getElementById("userType").value || "N/A";
        const address = document.getElementById("address").value || "N/A";
        const tbody = document.getElementById("clientTableBody");
        var a = '5';  // Your quantity

$.post('<?=base_url()?>users/add_client', 
       {companyName: companyName, 
       email: email, 
       pass: pass,
       phone: phone,
       panNumber: panNumber,
       gstNumber: gstNumber,
       userType: userType,
       address: address,
           
       }, 
       function(response) { //alert(response)
          // console.log('Updated:', response);
        $('#addClientModal').modal('hide');
        $('#successModal').modal('show');

       }, 
       'json');
   tbody.appendChild(row);
        const addClientModalEl = document.getElementById("addClientModal");
        const addClientModal = bootstrap.Modal.getInstance(addClientModalEl);
        addClientModal.hide();
        this.reset();
        const successModal = new bootstrap.Modal(
            document.getElementById("successModal")
        );
        successModal.show();

        setTimeout(() => {
            successModal.hide();
        }, 2000);
        const badgeClass =
            userType === "Retailer" ? "bg-info" :
            userType === "Distributor" ? "bg-warning text-dark" :
            "bg-secondary";
        const row = document.createElement("tr");
        row.innerHTML = `
    <td>${companyName}</td>
    <td>${email}</td>
    <td><span class="badge ${badgeClass}">${userType}</span></td>
    <td>${phone}</td>
    <td>0</td>
    <td>₹ 0</td>
    <td><span class="badge bg-success">Active</span></td>
    <td>
      <button class="btn btn-sm btn-outline-primary">View</button>
      <button class="btn btn-sm btn-outline-success">Order</button>
    </td>
  `;
        
    });
</script>

<?php include("footer.php") ?>
<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>