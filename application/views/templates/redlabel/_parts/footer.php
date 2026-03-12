</main>
<footer>
    <div class="footer_area">
        <div class="container-xxl container-lg">
            <div class="row g-3 justify-content-center text-center text-md-start">
                <div class="col-md-7 col-sm-10 col-12 text-center mb-md-5 mb-3">
                    <img src="<?php echo base_url(); ?>assets/gallery/logo.webp" alt="logo" class="img-fluid mb-3">
                </div>
            </div>
            <div class="row g-lg-4 g-3 justify-content-center text-center text-md-start">
                <div class="col-md-3 col-sm-6 col-12 order-1">
                    <div class="footer_menus">
                        <p class="title">Quick Links</p>
                        <ul class="list-unstyled">
                            <li><a class="nav-links" href="<?php echo base_url('aboutus'); ?>">About</a></li>
                            <li><a class="nav-links" href="<?php echo base_url('faq'); ?>">FAQs</a></li>
                            <li><a class="nav-links" href="<?php echo base_url('contact'); ?>">Contact Us</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-12 order-2">
                    <div class="footer_menus">
                        <p class="title">Help & Support</p>
                        <ul class="list-unstyled">
                            <li><a class="nav-links" href="<?php echo base_url('page/terms-conditions'); ?>">Terms & Conditions</a></li>
                            <li><a class="nav-links" href="<?php echo base_url('page/privacy-policy'); ?>">Privacy Policy</a></li>
                            <li><a class="nav-links" href="<?php echo base_url('page/track-order'); ?>">Track Order</a></li>
                            <li><a class="nav-links" href="<?php echo base_url('page/returns-exchange'); ?>">Returns & Exchanges</a></li>
                            <li><a class="nav-links" href="<?php echo base_url('page/shipping'); ?>">Shipping Information</a></li>
                            <li><a class="nav-links" href="<?php echo base_url('page/payment-method'); ?>">Payment Methods</a></li>
                            <li><a class="nav-links" href="<?php echo base_url('page/gift-cards'); ?>">Gift Cards</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 order-sm-4 order-3 col-12">
                    <div class="footer_menus">
                        <p class="title">Location</p>
                        <p>110, Readymade complex Indore, Indore,Madhya Pradesh, 452003</p>
                        <ul
                            class="list-unstyled footer_icons mb-md-0 pt-md-4 pt-2 justify-content-center justify-content-md-start">
                            <li class="social_icons" data-tippy-content="See our latest posts"><a target="_blank" href="https://www.instagram.com/houseofstitches.in/"><i
                                        class="bi bi-instagram"></i></a></li>
                            <li class="social_icons" data-tippy-content="Chat On Whatsapp"><a target="_blank" href="tel:+919424700001"><i
                                        class="bi bi-whatsapp"></i></a></li>
                            <li class="social_icons" data-tippy-content="View location on map"><a target="_blank" href="https://maps.app.goo.gl/oWArEKiF8gEwLEFZA"><i class="bi bi-geo-alt"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 order-sm-2 order-4 col-12">
                    <div class="footer_menus">
                        <p class="title">Contact Us</p>
                        <p class="mb-2"><a href="mailto: info@houseofstitches.in">info@houseofstitches.in</a></p>
                        <p class="tel"><a href="tel:+919424700001">+91-9644664338 / +91-9424700001</a></p>
                    </div>
                </div>
                <div class="col-12 copyright order-5">
                    <p class="text-center fw-bold fs-6">Copyright © <?= date('Y'); ?> <a href="https://enginedigital.in/"
                            target="_blank">SPANGLE CLOTHING PRIVATE LIMITED.</a> All Rights Reserved.</p>
                </div>
            </div>
        </div>
        <a class="float-button sendBtn" target="_blank" href="#">
            <i class="bi bi-whatsapp"></i>
            <span>Message me</span>
        </a>
        <div class="progress-wrap" data-tippy-content="Back to Top">
            <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
                <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
            </svg>
        </div>
</footer>
<script>
    var variable = {
        clearShoppingCartUrl: "<?php echo base_url(); ?>/clearShoppingCart",
        manageShoppingCartUrl: "<?php echo base_url(); ?>/manageShoppingCart",
        discountCodeChecker: "<?php echo base_url(); ?>/discountCodeChecker"
    };
</script>

<script>
    function confirmLogout() {
        if (confirm("Are you sure you want to log out?")) {
            window.location.href = "<?php echo base_url('logout'); ?>";
        }
    }
</script>


<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/Draggable.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/owl.carousel.min.js"></script>
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>
<script src="<?php echo base_url(); ?>assets/js/main.js?v=<?php echo time(); ?>"></script>
<script src="<?php echo base_url(); ?>assets/js/system.js"></script>
<script src="<?php echo base_url(); ?>loadlanguage/all.js"></script>
</body>
<style>
    .tel {
        font-size: smaller !important;
    }
</style>
<script>
    $(function() {
        $("#closePopup1").click(function() {
            if ($("input[name='role']:checked").length > 0) {
                // At least one radio is selected
                let selectedValue = $("input[name='role']:checked").val();

                window.location.href = '<?php echo base_url('register?type='); ?>' + selectedValue;
            } else {

                $('#mandtory').css('color', 'red');
            }
        });

    });
</script>

</html>