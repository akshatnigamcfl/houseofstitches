<title>House of Stitches | Wholesale Kidswear & Bulk Clothing Supplier India</title>
<meta name="description"
  content="Shop wholesale kidswear in bulk at House of Stitches. Premium clothing for boys & girls (6–15 years). Trusted supplier for bulk orders across India.">
<meta name="keywords"
  content="wholesale kidswear, bulk kids clothing supplier, kids fashion wholesale India, bulk children’s clothing, wholesale boys & girls wear, kidswear distributor, bulk school clothes supplier, wholesale party wear kids, House of Stitches India, kidswear wholesale market">
<?php include("header.php") ?>
<div class="loader-wrapper" aria-hidden="true">
  <div class="preloader-overlay" role="status" aria-live="polite" aria-busy="true" aria-label="Loading">
    <div class="preloader-orbit-loading" aria-hidden="true">
      <div class="cssload-inner cssload-one"></div>
      <div class="cssload-inner cssload-two"></div>
      <div class="cssload-inner cssload-three"></div>
    </div>
  </div>
  <div class="loader-section section-left"></div>
  <div class="loader-section section-right"></div>
</div>

<div class="home_video">
  <div class="container-fluid">
    <div class="row justify-content-center align-items-center">
      <div class="col-12 px-0">
        <div class="video-stage">
          <div class="video-viewport">
            <video autoplay muted loop playsinline>
              <source src="assets/gallery/houseofstitches-video.mp4" type="video/mp4">
              Your browser does not support HTML video.
            </video>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="our_showroom">
  <div class="container-fluid">
    <div class="row justify-content-center align-items-center">
      <div class="col-12 px-0">
        <div class="flipbook-section">
          <div class="book" id="book">
            <div class="page">
              <img src="assets/gallery/showroom.webp" alt="showroom" class="img-fluid postion-relative">
              <div class="caption">
                <h1 class="h1_heading px-lg-3 px-2 rounded text-center">Explore Our Collection</h1>
              </div>
            </div>
            <div class="page">
              <img src="assets/gallery/flipbook-2.webp" alt="house of stitches catelog" class="img-fluid">
            </div>
            <div class="page">
              <img src="assets/gallery/flipbook-3.webp" alt="house of stitches catelog" class="img-fluid">
            </div>
            <div class="page">
              <img src="assets/gallery/flipbook-4.webp" alt="house of stitches catelog" class="img-fluid">
            </div>
            <div class="page">
              <img src="assets/gallery/flipbook-5.webp" alt="house of stitches catelog" class="img-fluid">
            </div>
            <div class="page">
              <img src="assets/gallery/flipbook-6.webp" alt="house of stitches catelog" class="img-fluid">
            </div>
            <div class="page">
              <img src="assets/gallery/flipbook-7.webp" alt="house of stitches catelog" class="img-fluid">
            </div>
            <div class="page">
              <img src="assets/gallery/flipbook-8.webp" alt="house of stitches catelog" class="img-fluid">
            </div>
            <div class="page">
              <img src="assets/gallery/flipbook-9.webp" alt="house of stitches catelog" class="img-fluid">
            </div>
            <div class="page">
              <img src="assets/gallery/flipbook-10.webp" alt="house of stitches catelog" class="img-fluid">
            </div>
          </div>
          <div class="nav-left" title="Previous Page"></div>
          <div class="nav-right" title="Next Page"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="our_catalogue py-5">
  <div class="container-fluid px-lg-5 px-3">

    <?php if (!empty($all_categories)): ?>
    <div class="row mb-4">
      <div class="col-12 text-center">
        <h2 class="h2_heading mb-3">Shop by Category</h2>
        <div class="d-flex flex-wrap justify-content-center gap-2">
          <a href="<?php echo base_url('home/shop'); ?>" class="btn rounded-pill catalogue-chip active-chip">All</a>
          <?php foreach ($all_categories as $cat):
                if ($cat['sub_for'] != 0) continue; ?>
            <a href="<?php echo base_url('home/shop?category=' . $cat['id']); ?>" class="btn rounded-pill catalogue-chip">
              <?php echo htmlspecialchars($cat['name']); ?>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
    <?php endif; ?>

    <?php if (!empty($bestSellers)): ?>
    <h2 class="h2_heading text-center mb-4">Best Sellers</h2>
    <div class="row g-3">
      <?php foreach ($bestSellers as $product): ?>
      <div class="col-lg-3 col-md-4 col-6">
        <div class="tb-product-item-inner">
          <div class="card product-card border-0">
            <a href="<?php echo base_url($product['url'] . '_' . $product['id']); ?>">
              <div class="product-img-wrapper overflow-hidden">
                <?php if (!empty($product['image'])): ?>
                  <img src="<?php echo base_url('attachments/shop_images/' . $product['image']); ?>"
                       class="w-100 img_products" alt="<?php echo htmlspecialchars($product['title']); ?>" loading="lazy"
                       onerror="this.onerror=null;this.src='<?php echo base_url('attachments/shop_images/spark_logo-06.jpg'); ?>';">
                <?php else: ?>
                  <img src="<?php echo base_url('attachments/shop_images/spark_logo-06.jpg'); ?>"
                       class="w-100 img_products" alt="product" loading="lazy">
                <?php endif; ?>
              </div>
            </a>
          </div>
          <ul class="list-unstyled tb-content mt-2">
            <li class="product-title">
              <a href="<?php echo base_url($product['url'] . '_' . $product['id']); ?>">
                <?php echo htmlspecialchars($product['title']); ?>
              </a>
            </li>
            <?php if (!empty($product['price'])): ?>
            <li class="product-price"><?php echo CURRENCY . ' ' . number_format($product['price'], 2); ?></li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if (!empty($newProducts)): ?>
    <h2 class="h2_heading text-center mt-5 mb-4">New Arrivals</h2>
    <div class="row g-3">
      <?php foreach ($newProducts as $product): ?>
      <div class="col-lg-3 col-md-4 col-6">
        <div class="tb-product-item-inner">
          <div class="card product-card border-0">
            <a href="<?php echo base_url($product['url'] . '_' . $product['id']); ?>">
              <div class="product-img-wrapper overflow-hidden">
                <?php if (!empty($product['image'])): ?>
                  <img src="<?php echo base_url('attachments/shop_images/' . $product['image']); ?>"
                       class="w-100 img_products" alt="<?php echo htmlspecialchars($product['title']); ?>" loading="lazy"
                       onerror="this.onerror=null;this.src='<?php echo base_url('attachments/shop_images/spark_logo-06.jpg'); ?>';">
                <?php else: ?>
                  <img src="<?php echo base_url('attachments/shop_images/spark_logo-06.jpg'); ?>"
                       class="w-100 img_products" alt="product" loading="lazy">
                <?php endif; ?>
              </div>
            </a>
          </div>
          <ul class="list-unstyled tb-content mt-2">
            <li class="product-title">
              <a href="<?php echo base_url($product['url'] . '_' . $product['id']); ?>">
                <?php echo htmlspecialchars($product['title']); ?>
              </a>
            </li>
            <?php if (!empty($product['price'])): ?>
            <li class="product-price"><?php echo CURRENCY . ' ' . number_format($product['price'], 2); ?></li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="text-center mt-4">
      <a href="<?php echo base_url('home/shop'); ?>" class="btn btn-outline-dark rounded-pill px-5">View All Products</a>
    </div>
    <?php endif; ?>

  </div>
</div>

<style>
.catalogue-chip { border: 1px solid #ccc; color: #333; background: #fff; font-size: 0.85rem; padding: 6px 16px; transition: all 0.2s; }
.catalogue-chip:hover, .active-chip { background: #333; color: #fff; border-color: #333; }
</style>

<div class="our_instagram">
  <div class="container-fluid">
    <div class="row g-md-3 g-2 justify-content-center align-items-center text-center">
      <div class="col-lg-7 col-12">
        <h2 class="h2_heading">Our Latest Updates</h2>
      </div>
      <div class="col-12">
        <!-- <div style="max-width: 100%;">
          <iframe src="https://snapwidget.com/embed/1115409" class="snapwidget-widget" allowtransparency="true" frameborder="0" scrolling="no" style="border:none; overflow:hidden; width:100%; height:100%; min-height:400px; pointer-events: none;" title="Posts from Instagram"></iframe>
        </div> -->

      </div>
    </div>
  </div>
</div>

<script>
  (() => {
    const pages = [...document.querySelectorAll('.book .page')];
    const navLeft = document.querySelector('.nav-left');
    const navRight = document.querySelector('.nav-right');
    let currentPage = 0;
    let restartTimeout = null;
    const RESET_DELAY = 4000;
    pages.forEach((page, i) => {
      page.style.zIndex = pages.length - i;
    });
    const startAutoReset = () => {
      if (currentPage === 0) return;

      restartTimeout = setTimeout(() => {
        pages.forEach(page => page.classList.remove('flipped'));
        currentPage = 0;
        restartTimeout = null;
      }, RESET_DELAY);
    };
    const clearAutoReset = () => {
      if (restartTimeout) {
        clearTimeout(restartTimeout);
        restartTimeout = null;
      }
    };
    const flipForward = () => {
      clearAutoReset();

      if (currentPage < pages.length - 1) {
        pages[currentPage].classList.add('flipped');
        currentPage++;
        startAutoReset();
      }
    };
    const flipBackward = () => {
      clearAutoReset();

      if (currentPage <= 0) return;
      currentPage--;
      pages[currentPage].classList.remove('flipped');
      startAutoReset();
    };
    navRight.addEventListener('click', flipForward);
    navLeft.addEventListener('click', flipBackward);
    window.addEventListener('keydown', e => {
      if (e.key === 'ArrowRight') flipForward();
      if (e.key === 'ArrowLeft') flipBackward();
    });
  })();
</script>

<?php include("footer.php") ?>