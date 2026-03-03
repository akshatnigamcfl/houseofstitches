<title>Shop | Bulk Clothing Supplier – House of Stitches</title>
<meta name="description"
    content="Browse our wholesale kidswear shop – premium bulk clothing for boys & girls aged 6–15 years. Trusted supplier in India for bulk orders only. Quality at scale.">
<meta name="keywords"
    content="wholesale kidswear shop, bulk kids clothing India, wholesale children’s fashion, kidswear supplier India, wholesale boys & girls wear, bulk order kids clothes, kidswear wholesale online, wholesale kids clothing distributor, House of Stitches shop, kidswear wholesale supplier">
<?php include("header.php") ?>
<div class="approvalbox">
    <div class="container">
        <?php
        if ($this->session->flashdata('login_error')) {
        ?>
            <div class="alert alert-danger"><?= $this->session->flashdata('login_error') ?></div>
        <?php
        }
        if ($this->session->flashdata('userError')) {
        ?>
            <div class="alert alert-danger"><?= $this->session->flashdata('userError') ?></div>
        <?php
        }

        if ($this->session->flashdata('success')) {
        ?>
            <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
        <?php
        }
        ?>
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-8 col-12 approveform">
                <ul class="nav nav-tabs mb-md-5 mb-4" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#login">
                            Sign In
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#register">
                            Register
                        </button>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="login">
                        <form class="row g-4" autocomplete="on" id="loginForm" action="<?php echo base_url('login'); ?>" method="post">
                            <div class="col-md-6 form-group">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" autocomplete="email" id="loginEmail" name="email" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-label">Password</label>
                                <div class="password-wrapper">
                                    <input type="password" class="form-control password-input"
                                        autocomplete="current-password" id="loginPassword" name="pass" required>
                                    <i class="bi bi-eye toggle-password"></i>
                                </div>
                            </div>
                            <div class="col-12 text-end">
                                <a href="#" class="password_forgot">Forgot password?</a>
                            </div>
                            <div class="col-12">
                                <button type="submit" name="login" class="btn btn-success w-100 fw-bold rounded-0">Sign In</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="register">
                        <form class="row g-4" id="registerForm" autocomplete="off" action="<?php echo current_url(); ?>" method="post">
                            <div class="col-md-6 form-group">
                                <label class="form-label">Company Name</label>
                                <input type="text" class="form-control" id="regName" name="name" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" id="regEmail" name="email" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control" id="regEmail" name="pass" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-label">Phone</label>
                                <input type="tel" class="form-control" id="regPhone" name="phone" required pattern="[0-9]{10,15}">
                            </div>
                            <div class="col-lg-6 col-md-6 form-group">
                                <label class="form-label">PAN Number</label>
                                <input type="text" class="form-control" id="pan" name="pan" pattern="[A-Z]{5}[0-9]{4}[A-Z]{1}">
                            </div>
                            <div class="col-lg-6 col-md-6 form-group">
                                <label class="form-label">GST Number</label>
                                <input type="text" class="form-control" id="gst" name="gst">
                            </div>
                            <?php
                            $type = isset($_GET['type']) && !empty($_GET['type']) ? $_GET['type'] : '';
                            ?>
                            <div class="col-lg-6 col-md-6 form-group">
                                <label class="form-label" required>User Type</label>
                                <select class="form-select" name="user_type" id="user_type">
                                    <option></option>
                                    <option value="1">Agent</option>
                                    <option value="2">Distributor</option>
                                    <option value="3">Retailer</option>
                                    <option value="4">Wholesaler</option>
                                </select>
                            </div>
                            <div class="col-12 form-group">
                                <label class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address" required>
                            </div>
                            <div class="col-12 form-group">
                                <input type="checkbox" class="form-check-input" id="termsCheck" name="terms" required>
                                <label class="form-check-label" for="termsCheck">
                                    I agree to the <a href="terms-and-conditions.php" target="_blank">Terms and Conditions</a>
                                </label>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-success w-100 fw-bold rounded-0" name="signup">Register</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="page-header-bg"></div>
    </div>
</div>

<?php include("footer.php") ?>
<style>
    .hide {
        display: none;
    }
</style>
<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
<input type="hidden" id="msg" placeholder="Type your message" value="Hello 👋, Welcome to spangle pvt ltd! We're excited you're here. To get started, please complete your registration here: [link]. Need assistance? Just reply to this message!">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(function() {
        $('.agent-select').select2({
            width: '100%',
            placeholder: 'Search agent / distributor',
            allowClear: true
        });
    });
</script>

<script>
    $(function() {
        $('#user_type').on('change', function() {
            var val = $(this).val(); //alert(val)
            // show / hide div
            if (val !== '0') {
                $.ajax({
                    url: '<?= base_url('Users/get_data'); ?>', // controller/method
                    type: 'POST',
                    data: {
                        option_id: val
                    },
                    dataType: 'text',
                    success: function(res) {
                        // update DOM with response
                        $('#userlist').removeClass('hide');
                        $('#userlist').html(res);
                        $('.agent-select').select2({ // re-init Select2
                            width: '100%',
                            placeholder: 'Search...',
                            allowClear: true
                        });
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            } else {
                $('#extraDiv').hide();
            }
        });
        $('#sendBtn,.sendBtn').on('click', function() {
            var phone = '919893520448'; // target number
            var message = $('#msg').val(); //alert(message)
            var url = 'https://wa.me/' + phone + '?text=' + encodeURIComponent(message);
            window.open(url, '_blank'); // opens WhatsApp
        });
    });
</script>