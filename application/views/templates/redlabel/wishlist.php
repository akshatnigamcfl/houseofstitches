<title>Wishlist | Bulk Kidswear – House of Stitches</title>
<meta name="description"
    content="View your saved wholesale kidswear items. Curate your favorite boys & girls clothing before placing bulk orders. Shop smarter with House of Stitches.">
<meta name="keywords"
    content="wishlist kidswear, saved kids clothing items, wholesale kidswear wishlist, bulk kids clothing wishlist, favorite kidswear, bulk order planning, House of Stitches wishlist, kidswear supplier India">
<?php include("header.php") ?>

<div class="account_header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 px-0">
                <h1 class="h2_heading text-light">Your Wishlist</h1>
                <nav>
                    <a class="text-light px-2" href="<?= base_url(); ?>">Home</a> |
                    <a class="text-light px-2" href="<?= base_url('shop'); ?>">Shop</a> |
                    <a class="text-light px-2" href="<?= base_url(); ?>">Wishlist</a>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="wishlist_items">
    <div class="container">
        <button id="download-catalog-btn" class="btn btn-primary">
  <i class="fa fa-download"></i> Download Catalog
</button>
        <div class="row justify-content-center align-items-center text-center">
            <?php  if(empty($product)){ ?>
            <div class="col-12">
                <h2 class="fs-3 py-2 text-muted text-center">Your wishlist is empty. Start adding items!</h2>
                <a href="<?= base_url('home/shop'); ?>" class="btn btn-primary fs-6">Return to shop</a>
            </div>
            <?php } ?>
            <div class="col-12">
                <div class="row g-3 wishlistadd_items">
                    <?php 
                        if(isset($product) && !empty($product)){
                    foreach ($product as $val){ 
                    if(!empty($val->title)){?>
                    <div class="col-lg-3 col-md-4 col-6">
                        <div class="wishlist-item">
                            <input type="checkbox" id="<?php echo $val->id; ?>" data-price="<?php echo $val->wsp; ?>" name="<?php echo $val->title; ?>" value="<?php echo base_url(); ?>attachments/shop_images/<?php echo $val->image; ?>" class="product-checkbox">
                            <img src="<?= base_url('attachments/shop_images/').$val->image; ?>" onerror="this.onerror=null; this.src='https://houseofstitches.in/attachments/shop_images/spark_logo-06.jpg';" class="img-fluid" alt="Cool Sunglasses">
                            <p class="title mt-3 mb-0">product - <?= $val->title; ?></p>
                            <p><?= $val->description; ?>.</p>
                            <p class="fs-5">INR <?= $val->wsp; ?></p>
                            <a href="#" data-product-id="<?php echo $val->id; ?>" class="btn btn-danger wishlist-btn"><i class="bi bi-trash3"></i><span
                                    class="d-md-inline-block d-none "> Remove from Wishlist</span></a>
                        </div>
                        </div>
                        <?php } } } ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include("footer.php") ?>
<script src="https://houseofstitches.in/assets/js/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
     $(document).ready(function() {
         $('#download-catalog-btn').on('click', async function () {
    const $btn = $(this);
    $btn.prop('disabled', true).text('Processing...');

    // 1) Collect selected products
    const selected = [];
    $('.product-checkbox:checked').each(function () {
        selected.push({
            image: $(this).val(),
            title: $(this).attr('name'),
            price: $(this).data('price'),
            desc:  $(this).data('desc') || $(this).attr('name')
        });
    });

    if (!selected.length) {
        $btn.prop('disabled', false).text('Download catalog');
        return;
    }

    // 2) Helper: build one HTML layout and turn it into PNG
    async function renderProduct(item) {
        const $page = $(`
          <div class="pdf-page"
               style="width:800px;padding:24px;box-sizing:border-box;background:#ffffff;">
            <div style="display:flex;align-items:center;gap:32px;">
              <div style="flex:0 0 320px;">
                <img src="${item.image}"
                     alt="${item.title}"
                     style="width:100%;height:auto;display:block;">
              </div>
              <div style="flex:1;color:#000;letter-spacing:1px;">
                <div style="font-size:12px;margin-bottom:8px;">2 PC SET</div>
                <div style="font-size:36px;font-weight:700;margin-bottom:16px;">${item.title}</div>
                <div style="font-size:18px;margin-bottom:16px;">2Y*5Y</div>
                <div style="font-size:14px;margin-bottom:16px;">C.GREY, OLIVE</div>
                <div style="font-size:22px;margin-bottom:8px;">${item.desc}</div>
                <div style="font-size:22px;">INR. ${item.price}.</div>
              </div>
            </div>
          </div>
        `);

        // keep it off‑screen but in DOM
        $page.css({ position: 'fixed', left: '-10000px', top: 0 });
        $('body').append($page);

        // wait for image load
        await Promise.all(
          $page.find('img').toArray().map(img => {
            if (img.complete) return Promise.resolve();
            return new Promise(res => { img.onload = img.onerror = res; });
          })
        );

        const canvas = await html2canvas($page[0], {
          scale: 2,
          backgroundColor: '#ffffff'
        });
        const dataUrl = canvas.toDataURL('image/png');
        $page.remove();
        return { dataUrl, width: canvas.width, height: canvas.height };
    }

    try {
        const pdf = new jspdf.jsPDF('p', 'pt', 'a4');
        const pageW = pdf.internal.pageSize.getWidth();
        const pageH = pdf.internal.pageSize.getHeight();

        // 3) Loop all selected items, add one page each
        for (let i = 0; i < selected.length; i++) {
            const { dataUrl, width, height } = await renderProduct(selected[i]);

            const ratio = Math.min(pageW / width, pageH / height);
            const w = width * ratio;
            const h = height * ratio;
            const x = (pageW - w) / 2;
            const y = (pageH - h) / 2;

            if (i > 0) pdf.addPage();
            pdf.addImage(dataUrl, 'PNG', x, y, w, h);
        }

        pdf.save('catalog.pdf');
    } finally {
        $btn.prop('disabled', false).text('Download catalog');
    }
});
    // Toggle wishlist on button click
    $('.wishlist-btn').on('click', function(e) { 
        e.preventDefault();
        e.stopPropagation();
       
        var $btn = $(this);
        var productId = $(this).attr('data-product-id');
       // var $icon = $btn.find('.wishlist-icon');
       // var $text = $btn.find('.wishlist-text');
         
        $.ajax({
            url: '<?= base_url("wishlist/toggle") ?>',
            type: 'POST',
            data: { product_id: productId },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'added') {
                    
                } else if (response.status === 'removed') {
                   window.location.reload();
                }
                
                // Update wishlist count
                $('#wishlistCount').text(response.count);
                
                // Show notification (optional)
                showNotification(response.message);
            },
            error: function() {
                alert('Error occurred. Please try again.');
            }
        });
    });
    
    // Check initial wishlist status on page load
    checkWishlistStatus();
});
</script>