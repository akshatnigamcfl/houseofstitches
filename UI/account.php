<title>Shop | Bulk Clothing Supplier – House of Stitches</title>
<meta name="description"
    content="Browse our wholesale kidswear shop – premium bulk clothing for boys & girls aged 6–15 years. Trusted supplier in India for bulk orders only. Quality at scale.">
<meta name="keywords"
    content="wholesale kidswear shop, bulk kids clothing India, wholesale children’s fashion, kidswear supplier India, wholesale boys & girls wear, bulk order kids clothes, kidswear wholesale online, wholesale kids clothing distributor, House of Stitches shop, kidswear wholesale supplier">
<?php include("header.php") ?>
<div class="account_page">
    <div class="container-fluid d-flex align-items-start gap-3">
        <div class="accountsidebar shadow d-lg-block d-none" id="accountSidebar">
            <div class="brand">
                <div class="logo"><img src="assets/gallery/favicon.webp" alt="logo" class="w-100"></div>
                <div>
                    <h1 class="title">House of Stitches</h1>
                    <h2 class="fs-6">Member Dashboard</h2>
                </div>
                <a class="btn btn-outline-muted d-inline-flex d-lg-none mb-3 p-0"
                    onclick="document.getElementById('accountSidebar').classList.add('d-none')"
                    aria-label="Close Sidebar">
                    <i class="bi bi-x-lg"></i>
                </a>
            </div>
            <ul class="nav flex-column nav-pills" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active position-relative" id="account-tab" data-bs-toggle="pill"
                        data-bs-target="#account" type="button" role="tab" aria-controls="account"
                        aria-selected="true"><i class="bi bi-house-door me-2"></i></i>Home</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link position-relative" id="orders-tab" data-bs-toggle="pill" data-bs-target="#orders"
                        type="button" role="tab" aria-controls="orders" aria-selected="false"><i
                            class="bi bi-receipt me-2"></i>Orders</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link position-relative" id="wishlist-tab" data-bs-toggle="pill"
                        data-bs-target="#wishlist" type="button" role="tab" aria-controls="wishlist"
                        aria-selected="false"><i class="bi bi-heart me-2"></i>Wishlist</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link position-relative" id="addresses-tab" data-bs-toggle="pill"
                        data-bs-target="#addresses" type="button" role="tab" aria-controls="addresses"
                        aria-selected="false"><i class="bi bi-geo-alt me-2"></i>Addresses</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link position-relative" id="payments-tab" data-bs-toggle="pill"
                        data-bs-target="#payments" type="button" role="tab" aria-controls="payments"
                        aria-selected="false"><i class="bi bi-credit-card-2-front me-2"></i>Payments</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link position-relative" id="accountsettings-tab" data-bs-toggle="pill"
                        data-bs-target="#accountsettings" type="button" role="tab" aria-controls="accountsettings"
                        aria-selected="false"><i class="bi bi-gear me-2"></i>Account Settings</a>
                </li>
            </ul>
            <div class="sidebar-footer">
                <div class="fw-semibold">Support <span class="mute"> +91 9876543210</span></div>
                <a href="#" class="btn btn-outline-danger fw-semibold mt-3 w-100" data-tippy-content="Exit your account"
                    title="sign out"><i class="bi bi-box-arrow-right"></i>
                    Sign out</a>
            </div>
        </div>
        <div class="accountdetails">
            <div class="topbar">
                <a class="btn btn-outline-muted mobile-sidebar-toggle d-inline-flex d-lg-none me-2"
                    aria-label="Toggle Sidebar"><i class="bi bi-list" aria-label="Toggle Sidebar"></i></a>
                <div class="searchbar input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                    <input id="globalSearch" class="form-control" placeholder="Search orders, products, invoices..."
                        aria-label="Search">
                </div>
                <div class="ms-auto d-flex align-items-center gap-2">
                    <a class="btn btn-outline-secondary" title="Notifications" data-tippy-content="View notifications"
                        href="#"><i class="bi bi-bell"></i></a>
                    <div class="d-flex align-items-center gap-2">
                        <div class="text-end me-2 d-none d-md-block">
                            <div style="font-weight:700">Ananya Singh</div>
                            <div>ananya@example.com</div>
                        </div>
                        <img id="userAvatar"
                            src="https://ui-avatars.com/api/?name=AS&background=0b4db0&color=fff&rounded=true&size=48"
                            alt="avatar" style="width:48px;height:48px;" class="rounded-circle">
                    </div>
                </div>
            </div>
            <div class="tab-content w-100" id="pills-tabContent">
                <div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="account-tab">
                    <div class="row g-4">
                        <div class="col-12 col-xl-8">
                            <div class="card-panel mb-3">
                                <div class="d-flex align-items-start justify-content-between gap-3">
                                    <div class="text">
                                        <h3 class="h2_heading mb-1">Welcome back, <span
                                                class="text-primary">Ananya</span></h3>
                                        <p class="text-muted fs-5">Here's a snapshot of your account and recent activity
                                        </p>
                                    </div>
                                    <a class="btn btn-outline-primary fw-semibold"
                                        data-tippy-content="Update your profile information"><i
                                            class="bi bi-pencil me-1"></i>Edit
                                        profile</a>
                                </div>
                                <hr style="border-color:var(--line)" class="mt-0">
                                <div class="row g-3 kpi-grid">
                                    <div class="col-xl-6 col-lg-3 col-6">
                                        <div class="card-panel" style="flex:1; min-width:160px;">
                                            <div>Orders (30d)</div>
                                            <div class="d-flex my-1">
                                                <div class="value">0</div>
                                                <div class="text-muted ms-2">new</div>
                                            </div>
                                            <div>Recent purchases and order status</div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-3 col-6">
                                        <div class="card-panel" style="flex:1; min-width:160px;">
                                            <div>Spend</div>
                                            <div class="d-flex my-1">
                                                <div class="value" id="kpiRevenue">₹0</div>
                                                <div class="text-muted ms-2">net</div>
                                            </div>
                                            <div>Total order value</div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-3 col-6">
                                        <div class="card-panel" style="flex:1; min-width:160px;">
                                            <div>Wishlist</div>
                                            <div class="d-flex my-1">
                                                <div class="value" id="kpiWishlistCount">0</div>
                                                <div class="text-muted ms-2">items</div>
                                            </div>
                                            <div>Save items for later</div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-3 col-6">
                                        <div class="card-panel" style="min-width:160px;">
                                            <div>Loyalty</div>
                                            <div class="value my-1">Gold</div>
                                            <div>Membership Tier</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-panel mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h4 class="title">Recent Orders</h4>
                                    <div>Latest 8 transactions</div>
                                </div>
                                <div class="table-responsive orders-table">
                                    <table class="table align-middle">
                                        <thead>
                                            <tr>
                                                <th>Order</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Amount</th>
                                                <th>Items</th>
                                                <th>Invoice</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>#ORD12345</td>
                                                <td>20 Sep 2025</td>
                                                <td><span class="status bg-success">Delivered</span></td>
                                                <td>₹12,500</td>
                                                <td>18 Items</td>
                                                <td><a href="#" class="btn-invoice">Download</a></td>
                                            </tr>
                                            <tr>
                                                <td>#ORD12346</td>
                                                <td>18 Sep 2025</td>
                                                <td><span class="status bg-warning">Processing</span></td>
                                                <td>₹8,000</td>
                                                <td>12 Items</td>
                                                <td><a href="#" class="btn-invoice">Download</a></td>
                                            </tr>
                                            <tr>
                                                <td>#ORD12346</td>
                                                <td>18 Sep 2025</td>
                                                <td><span class="status bg-secondary">Shipped</span></td>
                                                <td>₹8,000</td>
                                                <td>12 Items</td>
                                                <td><a href="#" class="btn-invoice">Download</a></td>
                                            </tr>
                                            <tr>
                                                <td>#ORD12347</td>
                                                <td>10 Sep 2025</td>
                                                <td><span class="status bg-danger">Cancelled</span></td>
                                                <td>₹0</td>
                                                <td>–</td>
                                                <td><a href="#" class="btn-invoice disabled">N/A</a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-3 d-flex justify-content-between align-items-center">
                                    <a href="#" class="muted-2">View all orders</a>
                                    <div>Auto-updates every 15 minutes</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-xl-4">
                            <div class="card-panel mb-3">
                                <div class="d-flex gap-3 align-items-center">
                                    <img id="avatarRight"
                                        src="https://ui-avatars.com/api/?name=AS&background=0b4db0&color=fff&rounded=true&size=72"
                                        alt="avatar" style="width:72px;height:72px;border-radius:10px">
                                    <div>
                                        <div style="font-weight:700" id="nameRight">Ananya Singh</div>
                                        <div id="emailRight">ananya@example.com</div>
                                        <div class="mt-2 muted">Member since <strong>12/08/2023</strong>
                                        </div>
                                    </div>
                                </div>
                                <hr style="border-color:var(--line)">
                                <div class="muted mb-2">Quick actions</div>
                                <div class="d-grid gap-2">
                                    <a class="btn btn-primary"><i class="bi bi-bag me-1"></i>
                                        Quick Buy</a>
                                    <a class="btn btn-outline-primary"><i class="bi bi-heart me-1"></i> View
                                        Wishlist</a>
                                </div>
                            </div>
                            <div class="card-panel mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <p class="mb-0 fw-semibold">Wishlist Preview</p>
                                    <div><span>0</span> items</div>
                                </div>
                                <div class="d-flex flex-column gap-3">
                                    <div class="d-flex gap-2 align-items-center">
                                        <img src="assets/gallery/product-1.webp" alt="Aurora Party Dress"
                                            style="width:64px;height:64px;object-fit:cover;border-radius:8px">
                                        <div style="flex:1">
                                            <div style="font-weight:700">Aurora Party Dress</div>
                                            <div class="text-muted">₹1,299</div>
                                        </div>
                                        <a class="btn btn-sm btn-outline-secondary p-2" href="#"
                                            data-tippy-content="Remove from wishlist"><i class="bi bi-x"></i></a>
                                    </div>
                                    <div class="d-flex gap-2 align-items-center">
                                        <img src="assets/gallery/product-2.webp" alt="Aurora Party Dress"
                                            style="width:64px;height:64px;object-fit:cover;border-radius:8px">
                                        <div style="flex:1">
                                            <div style="font-weight:700">Aurora Party Dress</div>
                                            <div class="text-muted">₹1,299</div>
                                        </div>
                                        <a class="btn btn-sm btn-outline-secondary p-2"
                                            data-tippy-content="Remove from wishlist" href="#"><i
                                                class="bi bi-x"></i></a>
                                    </div>
                                </div>
                                <div class="mt-2 text-end">
                                    <a class="text-muted" href="#"><u>Manage wishlist</u></a>
                                </div>
                            </div>
                            <div class="card-panel mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <p class="mb-0 fw-semibold">Saved Addresses</p>
                                    <a class="btn btn-outline-secondary p-2 btn-sm"
                                        data-tippy-content="Add a new delivery address" href="#"><i
                                            class="bi bi-plus-lg"></i></a>
                                </div>
                                <div class="d-flex align-items-start justify-content-between">
                                    <div class="caption">
                                        <p class="fw-bold mb-0">Home</p>
                                        <p class="text-muted">Flat 12B, Orchid Apartments, MG Road, Indore, MP, Indore -
                                            452001</p>
                                    </div>
                                    <a class="btn btn-outline-secondary p-2 btn-sm"
                                        data-tippy-content="Edit this address" href="#"><i class="bi bi-pencil"></i></a>
                                </div>
                            </div>
                            <div class="card-panel">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <p class="mb-0 fw-semibold">Payment Methods</p>
                                    <a class="btn btn-outline-secondary p-2 btn-sm" id="btnAddPayment"
                                        data-tippy-content="Add a new payment method" href="#"><i
                                            class="bi bi-plus-lg"></i></a>
                                </div>
                                <div class="d-flex align-items-start justify-content-between">
                                    <div class="caption">
                                        <p class="fw-bold mb-0">Visa •••• 4242</p>
                                        <p class="text-muted">Card</p>
                                    </div>
                                    <a class="btn btn-outline-secondary p-2 btn-sm"
                                        data-tippy-content="Remove this payment method" href="#"><i
                                            class="bi bi-trash"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                    <div class="card-panel mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="title">Order history</h5>
                            <div>Latest 10 transactions</div>
                        </div>
                        <div class="table-responsive orders-table">
                            <table class="table align-middle" id="orderTable">
                                <thead>
                                    <tr>
                                        <th>Order</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Amount</th>
                                        <th>Items</th>
                                        <th>Slips (PO · GRN · Invoice)</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-has-po="true" data-has-grn="true" data-has-invoice="true"
                                        data-order="ORD12345">
                                        <td>#ORD12345</td>
                                        <td>20 Sep 2025</td>
                                        <td><span class="status bg-success">Delivered</span></td>
                                        <td>₹12,500</td>
                                        <td>18 Items</td>
                                        <td class="slips d-flex flex-wrap gap-2"></td>
                                        <td><a href="#" class="btn btn-outline-dark btn-sm py-0"
                                                data-download-all>Download All</a></td>
                                    </tr>
                                    <tr data-has-po="true" data-has-grn="true" data-has-invoice="false"
                                        data-order="ORD12345">
                                        <td>#ORD12346</td>
                                        <td>18 Sep 2025</td>
                                        <td><span class="status bg-warning">Processing</span></td>
                                        <td>₹8,000</td>
                                        <td>12 Items</td>
                                        <td class="slips d-flex flex-wrap gap-2"></td>
                                        <td><a href="#" class="btn btn-outline-dark btn-sm py-0"
                                                data-download-all>Download All</a></td>
                                    </tr>
                                    <tr data-has-po="true" data-has-grn="false" data-has-invoice="false"
                                        data-order="ORD12345">
                                        <td>#ORD12346</td>
                                        <td>18 Sep 2025</td>
                                        <td><span class="status bg-secondary">Shipped</span></td>
                                        <td>₹8,000</td>
                                        <td>12 Items</td>
                                        <td class="slips d-flex flex-wrap gap-2"></td>
                                        <td><a href="#" class="btn btn-outline-dark btn-sm py-0"
                                                data-download-all>Download All</a></td>
                                    </tr>
                                    <tr data-has-po="false" data-has-grn="false" data-has-invoice="false"
                                        data-order="ORD12345">
                                        <td>#ORD12347</td>
                                        <td>10 Sep 2025</td>
                                        <td><span class="status bg-danger">Cancelled</span></td>
                                        <td>₹699</td>
                                        <td>7 Items</td>
                                        <td class="slips d-flex flex-wrap gap-2"></td>
                                        <td><a href="#" class="btn btn-outline-dark btn-sm py-0"
                                                data-download-all>Download All</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <ul class="pagination justify-content-end align-items-center gap-3 mt-3">
                            <li class="page-item"><a class="page-link px-4"><i
                                        class="bi bi-chevron-double-left"></i></a></li>
                            <li class="page-item"><a class="page-link rounded-circle" href="#">1</a></li>
                            <li class="page-item"><a class="page-link rounded-circle active" href="#">2</a></li>
                            <li class="page-item"><a class="page-link px-4" href="#"><i
                                        class="bi bi-chevron-double-right"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-pane fade" id="wishlist" role="tabpanel" aria-labelledby="wishlist-tab">
                    <div class="row g-3 wishlistadd_items mt-0">
                        <div class="col-lg-3 col-md-4 col-6">
                            <div class="wishlist-item" data-tippy-content="View wishlist product">
                                <img src="assets/gallery/product-1.webp" class="img-fluid" alt="Cool Sunglasses">
                                <h6 class="title mt-3 mb-0">product - 5684</h6>
                                <p>Stylish sunglasses to keep the sun out of your eyes.</p>
                                <p class="fs-5">INR 50.00</p>
                                <a href="#" class="btn btn-danger"><i class="bi bi-trash3"></i><span
                                        class="d-md-inline-block d-none"> Remove from
                                        Wishlist</span></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-6">
                            <div class="wishlist-item" data-tippy-content="View wishlist product">
                                <img src="assets/gallery/product-2.webp" class="img-fluid" alt="co - 548932">
                                <p class="title mt-3 mb-0">co - 548932</p>
                                <p>A classic watch for any occasion.</p>
                                <p class="fs-5">INR 150.00</p>
                                <a href="#" class="btn btn-danger"><i class="bi bi-trash3"></i><span
                                        class="d-md-inline-block d-none"> Remove from
                                        Wishlist</span></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-6">
                            <div class="wishlist-item" data-tippy-content="View wishlist product">
                                <img src="assets/gallery/product-1.webp" class="img-fluid" alt="jmo - 8455">
                                <p class="title mt-3 mb-0">jmo - 8455</p>
                                <p>Durable leather backpack for everyday use.</p>
                                <p class="fs-5">INR 120.00</p>
                                <a href="#" class="btn btn-danger"><i class="bi bi-trash3"></i><span
                                        class="d-md-inline-block d-none"> Remove from
                                        Wishlist</span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="addresses" role="tabpanel" aria-labelledby="addresses-tab">
                    <div class="card-panel mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <p class="title">Saved addresses</p>
                            <a class="btn btn-outline-primary" href="#"
                                data-tippy-content="Add a new delivery address"><i class="bi bi-plus-lg"></i> Add
                                address</a>
                        </div>
                        <div class="p-3 border rounded d-flex justify-content-between align-items-start">
                            <div>
                                <div style="font-weight:700">Home</div>
                                <div class="text-muted">Flat 12B, Orchid Apartments, MG Road, Indore, MP, Indore -
                                    452001</div>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="#" data-tippy-content="Edit this address"
                                    class="btn btn-sm btn-outline-primary">Edit</a>
                                <a href="#" data-tippy-content="Delete this address"
                                    class="btn btn-sm btn-outline-secondary">Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="payments" role="tabpanel" aria-labelledby="payments-tab">
                    <div class="card-panel mb-3">
                        <p class="title">Saved payment methods</p>
                        <div class="p-3 border rounded d-flex justify-content-between align-items-start">
                            <div>
                                <div style="font-weight:700">Visa •••• 4242</div>
                                <div class="text-muted">Card</div>
                            </div>
                            <a class="btn btn-sm btn-outline-secondary" href="#"
                                data-tippy-content="Remove this payment method">Remove</a>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="accountsettings" role="tabpanel" aria-labelledby="accountsettings-tab">
                    <div class="card-panel mb-3">
                        <p class="title">Account settings</p>
                        <form class="mt-3">
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <label class="fw-semibold fs-6 mb-1">Full name</label>
                                    <input class="form-control" required placeholder="Your Full Name"
                                        data-tippy-content="Enter your full legal name">
                                </div>
                                <div class="col-md-6">
                                    <label class="fw-semibold fs-6 mb-1">Email</label>
                                    <input class="form-control" type="email" required placeholder="Your Email"
                                        data-tippy-content="Provide your registered email address">
                                </div>
                                <div class="col-12">
                                    <label class="fw-semibold fs-6 mb-1">Phone</label>
                                    <input class="form-control" type="number" placeholder="Your mobile number"
                                        data-tippy-content="Add your active mobile number">
                                </div>
                                <div class="col-12 d-flex gap-2 mt-2">
                                    <a class="btn btn-primary" href="#" data-tippy-content="Save profile updates">Save
                                        changes</a>
                                    <a type="button" class="btn btn-outline-secondary" href="#" data-tippy-content="Update your account password">Change password</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("footer.php") ?>