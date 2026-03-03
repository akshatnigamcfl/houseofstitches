<title>Shop | Bulk Clothing Supplier – House of Stitches</title>
<meta name="description"
    content="Browse our wholesale kidswear shop – premium bulk clothing for boys & girls aged 6–15 years. Trusted supplier in India for bulk orders only. Quality at scale.">
<meta name="keywords"
    content="wholesale kidswear shop, bulk kids clothing India, wholesale children’s fashion, kidswear supplier India, wholesale boys & girls wear, bulk order kids clothes, kidswear wholesale online, wholesale kids clothing distributor, House of Stitches shop, kidswear wholesale supplier">
<?php include("header.php") ?>
<div class="approvalbox">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-6 col-md-7 col-sm-10 col-12">
                <form id="registerForm" class="approveform">
                    <h1 class="h2_heading text-center mb-4">Register</h1>
                    <div class="mb-3">
                        <label for="regName" class="title fw-semibold fs-5">Full Name</label>
                        <input type="text" class="form-control" id="regName" name="name"
                            data-tippy-content="Enter your name" required />
                    </div>
                    <div class="mb-3">
                        <label for="regEmail" class="title fw-semibold fs-5">Email Address</label>
                        <input type="email" class="form-control" id="regEmail" data-tippy-content="Enter your email"
                            name="email" required />
                    </div>
                    <div class="mb-3">
                        <label for="regPhone" class="title fw-semibold fs-5">Phone Number</label>
                        <input type="tel" class="form-control" id="regPhone" name="phone"
                            data-tippy-content="Enter your phone number" required pattern="[0-9]{10,15}" />
                    </div>
                    <div class="mb-4">
                        <label for="regPassword" class="title fw-semibold fs-5">Password</label>
                        <input type="password" class="form-control" data-tippy-content="Create a password"
                            id="regPassword" name="password" required minlength="6" />
                    </div>
                    <a type="submit" class="btn btn-success w-100 p-2 fs-4 gfamily fw-semibold">Register</a>
                    <h2 class="toggle-link"
                        onclick="document.getElementById('registerForm').style.display='none'; document.getElementById('loginForm').style.display='block';">
                        Already
                        have an account? LOG IN</h2>
                </form>
                <form id="loginForm" style="display:none;" class="approveform">
                    <h3 class="h2_heading text-center mb-4">Sign In</h3>
                    <div class="mb-3">
                        <label for="loginEmail" class="title fw-semibold fs-5">Email Address</label>
                        <input type="email" class="form-control" data-tippy-content="Enter your registered business email address" id="loginEmail" name="email" required />
                    </div>
                    <div class="mb-4">
                        <label for="loginPassword" class="title fw-semibold fs-5">Password</label>
                        <input type="password" class="form-control" id="loginPassword" data-tippy-content="Use your secure account password" name="password" required />
                        <div class="text-end"><a href="#">Forgot Password?</a></div>
                    </div>
                    <a type="submit" class="btn btn-success w-100 p-2 fs-4 gfamily fw-semibold">Sign In</a>
                    <h4 class="toggle-link"
                        onclick="document.getElementById('loginForm').style.display='none'; document.getElementById('registerForm').style.display='block';">
                        Don't
                        have an account? REGISTER</h4>
                </form>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="page-header-bg"></div>
    </div>
</div>

<?php include("footer.php") ?>