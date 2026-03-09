<title>Cart | House of Stitches – Wholesale Kidswear in Bulk</title>
<meta name="description"
    content="Review your cart at House of Stitches. Premium wholesale kidswear for boys & girls aged 6–15 years. Bulk orders only, no single pieces. Trusted supplier in India.">
<meta name="keywords"
    content="kidswear cart, bulk kids clothing checkout, wholesale kidswear order, buy kids clothes in bulk India, wholesale boys & girls clothing, bulk order kidswear online, House of Stitches cart, wholesale children’s wear supplier">
<div class="account_header bg-dark py-4">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center text-white">
                <h1 class="h2_heading text-white">Your Shopping Cart</h1>
                <nav class="mt-2">
                    <a class="text-light px-2" href="<?php echo base_url('shop'); ?>">Shop</a> |
                    <a class="text-light px-2" href="<?php echo base_url('shopping-cart'); ?>">Cart</a> |
                    <a class="text-light px-2" href="<?php echo base_url('checkout'); ?>">Checkout</a>
                </nav>
            </div>
        </div>
    </div>
</div>
<?php //print_r(cart_item()); ?>
<div class="shopping_cart pb-4">
    <div class="container-fluid">
        <div class="row g-md-4 g-3">
            <div class="col-lg-7">
                <?php if (empty(cart_item())) { ?>
                    <div class="text-center py-md-5 py-3">
                        <h4>Your cart is currently empty.</h4>
                        <a href="<?php echo base_url('home/shop'); ?>" class="btn_button d-inline-block mt-3">
                            <i class="bi bi-arrow-left me-2"></i>Start Shopping
                        </a>
                    </div>
                <?php } else { ?>
                    <div class="table-responsive" style="overflow-x: auto;">
                        <table class="table">
                            <thead class="table-light fw-bold">
                                <tr>
                                    <th>S.No</th>
                                    <th>Product</th>
                                    <th>Set Qty</th>
                                    <th>WSP</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                foreach (cart_item() as $item) { ?>
                                    <tr>
                                        <td><?= $i++; ?>.</td>
                                        <td>
                                            <div class="d-flex align-items-start" style="min-width: 325px;">
                                                <div class="position-relative me-3">
                                                    <img src="<?= base_url(); ?>attachments/shop_images/<?= $item['image']; ?>"
                                                        onerror="this.onerror=null; this.src='<?= base_url('/attachments/shop_images/spark_logo-06.jpg'); ?>';"
                                                        width="127" class="img-fluid">
                                                    <i data-product-id="<?= $item['id']; ?>"
                                                        class="bi bi-heart wishlist-btn position-absolute"
                                                        style="top:5px; right:5px;"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold"><?= $item['brand']; ?></div>
                                                    <div><?= $item['title']; ?></div>
                                                    <div class="small text-muted">SKU: <?= $item['sku']; ?></div>
                                                    <div class="small text-muted">Colour: <?php echo $item['color']; ?></div>
                                                    <div class="small text-muted">Size: <?php echo $item['size_range']; ?></div>
                                                    <div class="small text-muted">Quantity: <?= $item['quantity']; ?></div>
                                                    <div class="small text-muted">Wsp: <?= $item['wsp']; ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="input-group input-group-sm" style="width:90px;">
                                                <button class="btn btn-dark remove-to-cart" data-action="remove" data-id="<?= $item['product_id']; ?>">-</button>
                                                <input type="text" class="form-control text-center set_quantity" data-product_id="<?= $item['product_id']; ?>" data-id="<?= $item['id']; ?>" value="<?= $item['set_quantity']; ?>">
                                                <button class="btn btn-dark add-to-cart" data-price="<?php echo $item['wsp']; ?>" data-mrp="<?php echo $item['mrp']; ?>" data-id="<?= $item['product_id']; ?>">+</button>
                                            </div>
                                        </td>
                                        <?
                                          $total +=$item['wsp']*$item['quantity'];
                                        ?>
                                        <td class="fw-bold">₹<?= $item['wsp']*$item['quantity']; ?></td>
                                        <td>
                                            <a href="<?php echo base_url('home/deletFromCart/'.$item['id'].'/'.user_id().''); ?>"
                                                class="text-danger add-to-cart" style="cursor:pointer;" data-action="remove" data-id="<?= $item['product_id']; ?>">
                                                <i class="bi bi-trash fs-5"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            </div>
            <div class="col-lg-4 offset-lg-1">
                <form method="post" action="<?php echo base_url('checkout'); ?>">
                    <div class="d-flex justify-content-between mb-3">
                        <span>Apply Coupon</span>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#discountModal"><u>Add</u></a>
                    </div>
                    <?php $tax = get_tax_breakdown($cartItems['finalSum']); ?>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Order value</span>
                        <span>Rs. <?php echo number_format($tax['base'], 2); ?></span>
                    </div>
                    <?php if ($tax['enabled'] && $tax['rate'] > 0): ?>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Tax (<?php echo $tax['rate']; ?>%)</span>
                        <span>Rs. <?php echo number_format($tax['tax_amount'], 2); ?></span>
                    </div>
                    <?php endif; ?>
                    <hr>
                    <div class="d-flex justify-content-between mb-4">
                        <strong>Total</strong>
                        <strong>Rs. <?php echo number_format($tax['total'], 2); ?></strong>
                    </div>
                    <!-- <button type="submit" class="btn_button w-100">Proceed to Checkout</button> -->
                    <?php $isCartEmpty = empty($cartItems['array']); ?>
                    <div class="checkout-message d-none text-danger text-center mb-2" id="checkoutMsg">
                        Please add items to cart to proceed
                    </div>
                    <button
                        type="<?= $isCartEmpty ? 'button' : 'submit' ?>"
                        id="checkoutBtn"
                        class="btn_button w-100 <?= $isCartEmpty ? 'disabled-btn' : '' ?>">
                        Proceed to Checkout
                    </button>
                    <a href="<?php echo base_url('home/shop'); ?>" class="btn btn-outline-dark w-100 rounded-0 mt-3 fw-bold">
                        <i class="bi bi-arrow-left me-2"></i>Continue Shopping
                    </a>
                </form>
            </div>
        </div>
        <div class="modal fade" id="discountModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-0">
                    <div class="modal-header border-0">
                        <h6 class="modal-title fw-bold">DISCOUNTS</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <label class="form-label">Add a discount code</label>
                        <div class="d-flex gap-2 mb-3">
                            <input type="text" class="form-control rounded-0" placeholder="Enter code">
                            <button class="btn btn-dark rounded-0 px-4">ADD</button>
                        </div>
                        <p class="small text-muted mb-4">
                            Enter a valid coupon code to enjoy instant savings on your order.
                        </p>
                        <button class="btn btn-secondary w-100 rounded-0" disabled>
                            SAVE
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<!-- CSS alertify -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css" />

<!-- JS (after jQuery) -->
<script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
<!-- ADD THESE EXACTLY at top of <head> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
$(function(){
    $('.remove-to-cart').click(function () {
        var action = $(this).data('action');
        var product_id = $(this).data('id');
        
        $.ajax({
            type: "POST",
            url: '<?= base_url("home/minus_qty") ?>',  <!-- ✅ FIXED: PHP base_url() -->
            dataType: 'text',  <!-- ✅ Added for JSON response -->
            data: { 
                product_id: product_id,
                action: action 
            },
            success: function(response) { //alert()
            location.reload();
                      },
            error: function() { location.reload();
                //alert('AJAX error - check console');
            }
        });
    });
});
$('.add-to-cart').click(function () {    
        setTimeout(function() { 
            location.reload();
        }, 1000);
    var reload = false;
    var action = $(this).data('action');     //alert(action)
    var article_id = $(this).data('id');     //alert(article_id)
    var goto_site = $(this).data('goto');
    var mrp = $(this).data('mrp'); 
    var wsp = $(this).data('price'); 
    if(action=='remove'){  
            manageShoppingCart('remove', article_id, mrp, wsp, reload);
   
    } else{ 
            manageShoppingCart('add', article_id, mrp, wsp, reload);
    }
});
function manageShoppingCart(action, article_id,mrp, wsp, reload) { 
    var action_error_msg = lang.error_to_cart;
    if (action == 'add') {
        $('.add-to-cart a[data-id="' + article_id + '"] span').hide();
        $('.add-to-cart a[data-id="' + article_id + '"] img').show();
        var action_success_msg = lang.added_to_cart;
    }
    if (action == 'remove') {
        var action_success_msg = lang.remove_from_cart;
    }
         
        $.ajax({
            type: "POST", 
            url: variable.manageShoppingCartUrl,
            dataType: 'text',  <!-- ✅ Added for JSON response -->
            data: { 
            article_id: article_id, action: action,wsp: wsp, mrp: mrp            },
            success: function(response) { //alert()
            location.reload();
                      },
            error: function() { location.reload();
                //alert('AJAX error - check console');
            },    error: function() {
        console.log('ERROR');
        
    }

        });    
}
document.addEventListener("DOMContentLoaded", function() {
    const checkoutBtn = document.getElementById("checkoutBtn");
    const checkoutMsg = document.getElementById("checkoutMsg");
    if (!checkoutBtn || !checkoutMsg) return;
    checkoutBtn.addEventListener("click", function(e) {
        if (checkoutBtn.classList.contains("disabled-btn") || checkoutBtn.type === "button") {
            e.preventDefault(); 
            checkoutMsg.classList.remove("d-none");
        }
    });
});
$(function(){
   $('.set_quantity').keyup(function() {
    var value = $(this).val();
    var product_id = $(this).data('product_id');
    var id = $(this).data('id');
    var baseURL = '<?php echo base_url(); ?>';
            $.ajax({
            type: "POST", 
            url: baseURL.ShoppingCartPage,
            dataType: 'text',  <!-- ✅ Added for JSON response -->
            data: { 
            product_id: product_id, id: id,value: value            },
            success: function(response) { //alert()
            location.reload();
                      },
            error: function() { location.reload();
                //alert('AJAX error - check console');
            },    error: function() {
        console.log('ERROR');
        
    }

        }); 
    //var url = baseURL + 'shopping-cart?qty=' + value+'&product_id='+product_id+'&id='+id+' ';
    window.location.href=url;
}); 
});
</script>

<?php include("footer.php") ?>