<link rel="stylesheet"
    href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<title>Cart | House of Stitches – Wholesale Kidswear in Bulk</title>
<meta name="description"
    content="Review your cart at House of Stitches. Premium wholesale kidswear for boys & girls aged 6–15 years. Bulk orders only, no single pieces. Trusted supplier in India.">
<meta name="keywords"
    content="kidswear cart, bulk kids clothing checkout, wholesale kidswear order, buy kids clothes in bulk India, wholesale boys & girls clothing, bulk order kidswear online, House of Stitches cart, wholesale children’s wear supplier">
<div class="account_header bg-dark py-4">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center text-white">
                <h1 class="h2_heading text-white">Thank You for Your Order</h1>
                <nav class="mt-2">
                    <a class="text-light px-2" href="<?php echo base_url('home'); ?>">Home</a> |
                    <a class="text-light px-2" href="<?php echo base_url('shop'); ?>">Shop</a> |
                    <a class="text-light px-2" href="<?php echo base_url('home/account'); ?>">My Orders</a>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="thankyou_card pb-4">
    <div class="container py-lg-5 py-3">
        <?= purchase_steps(1, 2, 3) ?>
        <div class="alert alert-success"><?= lang('c_o_d_order_completed') ?></div>
        <div class="row justify-content-center align-items-center text-center" id="order_invoice">
            <div class="col-lg-9 col-md-11 col-12 thankscontent">
                <div class="brand m-auto"><img src="<?php echo base_url(); ?>assets/gallery/logo.webp" alt="House of Stitches" class="img-fluid">
                </div>
                <h1 class="title mt-2 fs-6">Handcrafted with Love</h1>
                <div class="checkmark text-success">✓</div>
                <h2 class="h2_heading">Thank You for Your Order</h2>
                <h3 class="fs-5">Your order has been placed successfully. A confirmation has been sent to your email.
                </h3>
                <hr>
                <div class="card text-start p-4 my-md-4 my-3">
                    <a href="javascript:void(0);" onclick="downloadOrderPdf();" title="Download PDF">
                        <i class="fa fa-file-pdf-o"></i> <!-- or your own icon -->
                    </a>
                    <h4 class="title">Order Details</h4> <?php  //echo '<pre>'; print_r(unserialize($order_details->products)); 
                                                            ?>
                    <p><strong>Agent :</strong> <?php
                                                $name = '';
                                                $user = get_loggedin_user_agent();
                                                if ($user) {
                                                    $name = is_string($user) ? $user : ($user->name ?? '');
                                                } else {
                                                    $all_sessions = $this->session->all_userdata();
                                                    $name = $all_sessions['logged_user']['agents'];
                                                }
                                                echo $name;
                                                ?></p>
                    <p><strong>Order #:</strong> <?php echo $order_details->order_id;  ?></p>
                    <p><strong>Date:</strong><?php echo date(' D  M, Y', $order_details->date); ?></p>
                    <p><strong>Dispatch Date:</strong><?php echo date(' D  M, Y', $order_details->date); ?></p>
                    <p><strong>Customer:</strong> <?php echo $order_details->name;  ?></p>
                    <p><strong>Email:</strong> <?php echo $order_details->email;  ?></p>
                    <p><strong>Shipping Address:</strong> <?php echo $order_details->address;  ?></p>
                    <h5><strong>Items:</strong></h5>
                    <ul>
                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width: 80px;">S.no</th>
                                    <th style="width: 80px;">Image</th>
                                    <th>Title</th>
                                    <th style="width: 80px;">Color</th>
                                    <th style="width: 80px;">Qty</th>
                                    <th style="width: 120px;" class="text-right">Price (₹)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = '0';  
                                //echo '<pre>'; print_r(unserialize($order_details->products)); die;
                                foreach (unserialize($order_details->products) as $val) {
                                    $i++;
                                ?>
                                    <?php $item = get_product_details($val['product_info']['id']); ?>

                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td>
                                            <img src="<?= base_url('attachments/shop_images/' . $item->image); ?>"
                                                alt="<?= $item->image; ?>"
                                                style="width:60px;height:auto;">
                                        </td>
                                        <td><?= $item->title; ?></td>
                                        <td><?= $item->color; ?></td>
                                        <td><?= $val['product_quantity']; ?></td>
                                        <td class="text-right">
                                            <?php $total1 += (float)$val['product_info']['price'] * $val['product_quantity']; ?>
                                            <?= $item->price; ?>
                                        </td>
                                    </tr>
                            </tbody>
                        <?php
                                    if (isset($val['product_info']['price'])) {
                                       echo $total += (float)$val['product_info']['price'] * $val['product_quantity'];
                                        $quantity += $val['product_quantity'];
                                    }
                                }
                           
                                $gst_breakdown = calculate_gst($total1, 5);

                        ?>
                        </table>
                    </ul>
                    <h6><strong>Quantity:</strong> <?php echo  $quantity; ?></h6>
                    <h6><strong>Total:</strong> ₹ <?php echo $gst_breakdown['total_with_gst']; ?></h6>
                </div>

                <a href="<?php echo base_url('home/shop'); ?>" class="d-inline-block btn_button">Continue Shopping</a>
            </div>
        </div>
    </div>
</div>

<?php include("footer.php") ?>
<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script>
    function downloadOrderPdf() {
        const element = document.getElementById('order_invoice');

        const opt = {
            margin: 5,
            filename: 'HouseOfStitches_Order_invoice.pdf',
            image: {
                type: 'jpeg',
                quality: 0.98
            },
            html2canvas: {
                scale: 2,
                useCORS: true,
                scrollY: 0,
                windowWidth: element.scrollWidth,
                windowHeight: element.scrollHeight
            },
            jsPDF: {
                unit: 'mm',
                format: 'a4',
                orientation: 'portrait'
            },
            pagebreak: {
                mode: ['css', 'legacy']
            } // allow multi‑page
        };

        html2pdf().set(opt).from(element).save();
    }
</script>