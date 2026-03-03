<div class="auth-container container my-5">
  <div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">
      <!-- Flash Messages -->
      <?php if ($this->session->flashdata('login_error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <?= $this->session->flashdata('login_error') ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>
      
      <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <?= $this->session->flashdata('success') ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>

      <div class="auth-card shadow-lg">
        <!-- Tab Navigation -->
        <ul class="nav nav-tabs auth-tabs justify-content-center" id="authTabs" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active tab-btn" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button" role="tab">
              <i class="bi bi-person-plus me-1"></i> Register
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link tab-btn" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab">
              <i class="bi bi-box-arrow-in-right me-1"></i> Login
            </button>
          </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content p-4" id="authTabContent">
          <!-- Register Form -->
          <div class="tab-pane fade show active" id="register" role="tabpanel">
            <form id="registerForm" action="<?= current_url() ?>" method="post" novalidate>
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label fw-bold">Company Name <span class="text-danger">*</span></label>
                  <input type="text" class="form-control auth-input" name="name" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-bold">Phone <span class="text-danger">*</span></label>
                  <input type="tel" class="form-control auth-input" name="phone" pattern="[0-9]{10,15}" required>
                </div>
              </div>
              
              <div class="row g-3 mt-2">
                <div class="col-md-6">
                  <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                  <input type="email" class="form-control auth-input" name="email" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-bold">User Type <span class="text-danger">*</span></label>
                  <select class="form-select auth-input" name="user_type" id="user_type" required>
                    <option value="">Choose...</option>
                    <option value="1">Agent</option>
                    <option value="2">Distributor</option>
                  </select>
                </div>
              </div>

              <div class="row g-3 mt-3">
                <div class="col-md-6">
                  <label class="form-label">Password <span class="text-danger">*</span></label>
                  <input type="password" class="form-control auth-input" name="pass" minlength="6" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Confirm Password</label>
                  <input type="password" class="form-control auth-input" name="confirm_pass" minlength="6" required>
                </div>
              </div>

              <div class="row g-3 mt-3">
                <div class="col-md-6">
                  <label class="form-label">PAN Number</label>
                  <input type="text" class="form-control auth-input" name="pan" pattern="[A-Z]{5}[0-9]{4}[A-Z]{1}">
                </div>
                <div class="col-md-6">
                  <label class="form-label">GST Number</label>
                  <input type="text" class="form-control auth-input" name="gst">
                </div>
              </div>

              <div class="mb-4 mt-3">
                <label class="form-label">Business Address <span class="text-danger">*</span></label>
                <textarea class="form-control auth-input" name="address" rows="2" required></textarea>
              </div>

              <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" id="termsCheck" name="terms" required>
                <label class="form-check-label" for="termsCheck">
                  I agree to <a href="terms-and-conditions.php" target="_blank" class="text-decoration-none">Terms & Conditions</a>
                </label>
              </div>

              <button type="submit" name="signup" class="btn btn-primary w-100 auth-btn py-3 mb-3">
                <i class="bi bi-check-circle me-2"></i>Create Account
              </button>
            </form>
          </div>

          <!-- Login Form -->
          <div class="tab-pane fade" id="login" role="tabpanel">
            <form id="loginForm" action="<?= base_url('login') ?>" method="post" novalidate>
              <div class="mb-4">
                <label class="form-label fw-bold">Email Address</label>
                <input type="email" class="form-control auth-input" name="email" required>
              </div>
              
              <div class="mb-4">
                <label class="form-label fw-bold">Password</label>
                <input type="password" class="form-control auth-input" name="pass" required>
              </div>

              <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="remember">
                  <label class="form-check-label small" for="remember">Remember me</label>
                </div>
                <a href="#" class="small text-decoration-none">Forgot Password?</a>
              </div>

              <button type="submit" name="login" class="btn btn-primary w-100 auth-btn py-3 mb-3">
                <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
              </button>
            </form>
          </div>
        </div>
      </div>

      <!-- Trust Indicators -->
      <div class="text-center mt-4">
        <small class="text-muted">Trusted by 5K+ businesses across India</small>
      </div>
    </div>
  </div>
</div>

<!-- Floating WhatsApp -->
<div class="whatsapp-float">
  <a href="https://wa.me/919893520448?text=Hello%20House%20of%20Stitches!%20Need%20help%20with%20registration" target="_blank" class="whatsapp-btn">
    <i class="bi bi-whatsapp"></i>
  </a>
</div>
<style>
    .auth-container {
  min-height: 70vh;
  display: flex;
  align-items: center;
}

.auth-card {
  border-radius: 20px;
  border: none;
  background: linear-gradient(145deg, #ffffff, #f8fafc);
  backdrop-filter: blur(10px);
  transition: all 0.3s ease;
}

.auth-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 25px 50px rgba(0,0,0,0.15) !important;
}

.auth-tabs {
  border: none;
  margin-bottom: 0;
  background: linear-gradient(90deg, #0f4c75, #2c5f8a);
  border-radius: 15px 15px 0 0;
  padding: 5px;
}

.tab-btn {
  border-radius: 12px;
  border: none;
  color: rgba(255,255,255,0.8);
  font-weight: 600;
  padding: 12px 30px;
  transition: all 0.3s ease;
  background: transparent;
}

.tab-btn:hover, .tab-btn.active {
  background: rgba(255,255,255,0.2);
  color: white;
  transform: scale(1.05);
  backdrop-filter: blur(10px);
}

.auth-input {
  border: 2px solid #e2e8f0;
  border-radius: 12px;
  padding: 12px 16px;
  font-size: 16px;
  transition: all 0.3s ease;
  background: #fafbfc;
}

.auth-input:focus {
  border-color: #0f4c75;
  box-shadow: 0 0 0 0.2rem rgba(15,76,117,0.15);
  background: white;
  transform: translateY(-1px);
}

.auth-btn {
  background: linear-gradient(135deg, #0f4c75 0%, #2c5f8a 100%);
  border: none;
  border-radius: 12px;
  font-weight: 700;
  font-size: 16px;
  transition: all 0.3s ease;
  box-shadow: 0 10px 25px rgba(15,76,117,0.3);
}

.auth-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 15px 35px rgba(15,76,117,0.4);
}

.whatsapp-float {
  position: fixed;
  bottom: 30px;
  right: 30px;
  z-index: 1000;
}

.whatsapp-btn {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  background: #25D366;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 24px;
  color: white;
  box-shadow: 0 10px 30px rgba(37,211,102,0.4);
  transition: all 0.3s ease;
}

.whatsapp-btn:hover {
  transform: scale(1.1) rotate(10deg);
}

/* Validation States */
.was-validated .form-control:valid {
  border-color: #10b981;
  background: #f0fdf4;
}

.was-validated .form-control:invalid {
  border-color: #ef4444;
  background: #fef2f2;
}

/* Mobile Responsiveness */
@media (max-width: 768px) {
  .auth-tabs {
    flex-direction: column;
    border-radius: 12px;
  }
  .tab-btn {
    margin-bottom: 5px;
  }
}

</style>
<script>
$(document).ready(function() {
  // Retain your existing AJAX for user_type
  $('#user_type').on('change', function() {
    var val = $(this).val();
    if (val !== '0') {
      $.ajax({
        url: '<?= base_url("Users/get_data") ?>',
        type: 'POST',
        data: { option_id: val },
        success: function(res) {
          $('#userlist').html(res).removeClass('hide');
        }
      });
    }
  });

  // Form validation
  $('#registerForm, #loginForm').on('submit', function(e) {
    if (!$('#termsCheck').is(':checked') && $(this).attr('id') === 'registerForm') {
      e.preventDefault();
      alert('Please agree to Terms & Conditions');
      return false;
    }
  });

  // Password match validation
  $('#registerForm').on('input', 'input[name="confirm_pass"]', function() {
    var pass = $('input[name="pass"]').val();
    var confirm = $(this).val();
    if (confirm && confirm !== pass) {
      $(this).addClass('is-invalid').removeClass('is-valid');
    } else {
      $(this).removeClass('is-invalid');
    }
  });
});
</script>
