  <style>
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f8f9fa; font-weight: bold; }
        img { max-width: 80px; max-height: 80px; }
        .export-btn { background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
    </style>
<div id="products">
    <?php
    if ($this->session->flashdata('result_delete')) {
        ?>
        <hr>
        <div class="alert alert-success"><?= $this->session->flashdata('result_delete') ?></div>
        <hr>
        <?php
    }
    if ($this->session->flashdata('result_publish')) {
        ?>
        <hr>
        <div class="alert alert-success"><?= $this->session->flashdata('result_publish') ?></div>
        <hr>
        <?php
    } 
    ?>
    <h1><img src="<?= base_url('assets/imgs/products-img.png') ?>" class="header-img" style="margin-top:-2px;"> Products</h1>
    <hr>
    <div class="row">
        <div class="col-xs-12">
            <div class="well hidden-xs"> 
                <div class="row">
                    <div class="col-md-6">
                    <form method="post" enctype="multipart/form-data" action="<?php echo base_url('admin/products/import'); ?>">
                        <label>Select Excel File</label>
                        <input type="file" name="file" accept=".xls, .xlsx, .csv" required>
                        <input type="submit" name="import" class="btn btn-info" style="margin-left: 46%;
    margin-top: -10%;"  value="Import">
                    </form>
                    </div>
                    <!--<div class="col-md-6">
                    <form method="post" action="<?= base_url('admin/products/extract') ?>" enctype="multipart/form-data">
    <input type="file" name="file" accept=".zip" required>
    <input type="submit" value="Upload and Extract">
</form>
                    </div> -->   
<!--                    <div class="col-md-6">
                   <form action="<?php echo base_url('admin/products/do_upload'); ?>" method="post" enctype="multipart/form-data">
    <input type="file" name="files[]" multiple />
    <input type="submit" value="Upload" />
</form>

                  </div>-->
                  </div>
<?php if ($this->session->flashdata('msg')) { ?>
    <p><?= $this->session->flashdata('msg'); ?></p>
<?php } ?>

                
                
                <div class="row">
<!--                                      <button id="download-catalog-btn" class="btn btn-primary">
  <i class="fa fa-download"></i> Download Catalog
</button>
-->
                    <form method="GET" id="searchProductsForm" action="">
                        <div class="col-sm-4">
                            <label>Order:</label>
                            <select name="order_by" class="form-control selectpicker change-products-form">
                                <option <?= isset($_GET['order_by']) && $_GET['order_by'] == 'id=desc' ? 'selected=""' : '' ?> value="id=desc">Newest</option>
                                <option <?= isset($_GET['order_by']) && $_GET['order_by'] == 'id=asc' ? 'selected=""' : '' ?> value="id=asc">Latest</option>
                                <option <?= isset($_GET['order_by']) && $_GET['order_by'] == 'quantity=asc' ? 'selected=""' : '' ?> value="quantity=asc">Low Quantity</option>
                                <option <?= isset($_GET['order_by']) && $_GET['order_by'] == 'quantity=desc' ? 'selected=""' : '' ?> value="quantity=desc">High Quantity</option>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label>Title:</label>
                            <div class="input-group">
                                <input class="form-control" placeholder="Product Title" type="text" value="<?= isset($_GET['search_title']) ? htmlspecialchars($_GET['search_title'], ENT_QUOTES, 'UTF-8') : '' ?>" name="search_title">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit" value="">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label>Category:</label>
                            <select name="category" class="form-control selectpicker change-products-form">
                                <option value="">None</option>
                                <?php foreach ($shop_categories as $key_cat => $shop_categorie) { ?>
                                    <option <?= isset($_GET['category']) && $_GET['category'] == $key_cat ? 'selected=""' : '' ?> value="<?= $key_cat ?>">
                                        <?php
                                        foreach ($shop_categorie['info'] as $nameAbbr) {
                                            if ($nameAbbr['abbr'] == $this->config->item('language_abbr')) {
                                                echo $nameAbbr['name'];
                                            }
                                        }
                                        ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="row" style="margin-top:8px;">
                    <div class="col-sm-12">
                        <?php $itm_synced_filter = isset($_GET['itm_synced']) && $_GET['itm_synced'] == '1'; ?>
                        <a href="<?= base_url('admin/products?itm_synced=1') ?>" class="btn btn-sm btn-<?= $itm_synced_filter ? 'warning' : 'default' ?>">
                            <i class="fa fa-clock-o"></i> Pending Setup
                        </a>
                        <?php if ($itm_synced_filter): ?>
                            <a href="<?= base_url('admin/products') ?>" class="btn btn-sm btn-default">Show All</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <hr>
            <?php
            if ($products) {
                ?>
                <div class="table-responsive">
                        
    <button class="btn btn-info" onclick="exportTableToPDF()">📄 Download Catalog to PDF</button>
    
    <table id="productTable">

                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Item Code</th>
                                <th>Scan Code</th>
                                <th>Title</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Color</th>
                                <th>Size Range</th>
                                <th>Vendor</th>
                                <th>Visibility</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($products as $row) {   //echo '<pre>'; print_r($row);
                                $u_path = 'attachments/shop_images/'; //echo $row->image; die;
                                if ($row->image != null && file_exists($u_path . $row->image)) {
                                    $image = base_url($u_path . $row->image);
                                } else {
                                   // $image = base_url('attachments/no-image.png');
                                    $image = base_url('attachments/shop_images/spark_logo-06.jpg');
                                }
                                $base64 = $image; // use URL directly — no need to base64 encode local images

                                ?>

                                <tr>
                                   
                                    <td> <input type="checkbox" id="<?php echo $val['id']; ?>" data-price="<?php echo $row->price; ?>" name="<?php echo $row->title; ?>" value="<?php echo $image; ?>" class="product-checkbox">
                                        <img src="<?= $base64 ?>" alt="No Image" class="img-thumbnail" style="height:100px;">
                                    </td>
                                    <td>
                                        <span style="font-size:12px;color:#555;"><?= $row->article_number ? htmlspecialchars($row->article_number) : '<span class="text-muted">—</span>' ?></span>
                                    </td>
                                    <td>
                                        <?php if (!empty($barcode_map[$row->id])): ?>
                                            <?php foreach ($barcode_map[$row->id] as $bc): ?>
                                                <code style="font-size:10px;display:block;white-space:nowrap;"><?= htmlspecialchars($bc['barcode']) ?></code>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <span class="text-muted">—</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?= $row->title ?>
                                        <?php if ($row->itm_synced && $row->image == ''): ?>
                                            <br><span class="label label-warning" style="font-size:10px;">Pending Setup</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?= $row->wsp; ?>
                                       
                                    </td>
                                    <td>
                                        <?php
                                        $consolidated_qty = !empty($barcode_map[$row->id])
                                            ? array_sum(array_column($barcode_map[$row->id], 'stock_qty'))
                                            : (int)$row->quantity;
                                        if ($consolidated_qty > 5) {
                                            $color = 'label-success';
                                        } elseif ($consolidated_qty > 0) {
                                            $color = 'label-warning';
                                        } else {
                                            $color = 'label-danger';
                                        }
                                        ?>
                                        <span style="font-size:12px;" class="label <?= $color ?>">
                                            <?= $consolidated_qty ?>
                                        </span>
                                    </td>
                                    
                                    <td><?php echo $row->color; ?></td>
                                    <td>
                                        <?php if (!empty($barcode_map[$row->id])): ?>
                                            <?php foreach ($barcode_map[$row->id] as $bc): ?>
                                                <div style="white-space:nowrap;line-height:1.8;">
                                                    <span style="display:inline-block;min-width:32px;font-weight:600;font-size:12px;"><?= htmlspecialchars($bc['size']) ?></span>
                                                    <span class="label <?= $bc['stock_qty'] > 5 ? 'label-success' : ($bc['stock_qty'] > 0 ? 'label-warning' : 'label-danger') ?>" style="font-size:11px;"><?= (int)$bc['stock_qty'] ?></span>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <?= $row->size_range ?: '<span class="text-muted">—</span>' ?>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $row->vendor_id > 0 ? '<a href="?show_vendor=' . $row->vendor_id . '">' . $row->vendor_name . '</a>' : 'No vendor' ?></td>

                                    <td>
                                        <label class="visibility-toggle" style="margin:0;cursor:pointer;" title="<?= $row->visibility ? 'Live — click to hide' : 'Hidden — click to make live' ?>">
                                            <input type="checkbox" class="visibility-checkbox" data-id="<?= $row->id ?>" <?= $row->visibility ? 'checked' : '' ?> style="display:none;">
                                            <span class="label <?= $row->visibility ? 'label-success' : 'label-default' ?>" style="font-size:12px;padding:5px 10px;cursor:pointer;">
                                                <?= $row->visibility ? '<i class="fa fa-eye"></i> Live' : '<i class="fa fa-eye-slash"></i> Hidden' ?>
                                            </span>
                                        </label>
                                    </td>

                                    <td>
                                        <div class="pull-right">
                                            <a href="<?= base_url('admin/publish/' . $row->id) ?>" class="btn btn-info">Edit</a>
                                            <a href="<?= base_url('admin/products?delete=' . $row->id) ?>"  class="btn btn-danger confirm-delete">Delete</a>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
               <?= $links_pagination ?>
            </div>
            <?php
        } else {
            ?>
            <div class ="alert alert-info">No products found!</div>
        <?php } ?>
    </div>
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"/>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css"/>
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.7.0/css/select.dataTables.min.css"/>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/select/1.7.0/js/dataTables.select.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <script>
    function exportTableToPDF() {
    const table1 = document.getElementById('productTable');
    
    // CLONE table and remove unwanted columns completely
    const $clone = $(table1).clone();
    $clone.attr('id', 'pdfTable');
    
    // Remove entire columns (Quantity=4th, Action=8th, Image/Checkbox=1st)
    $clone.find('th:nth-child(4), td:nth-child(4)').remove();  // Quantity
    $clone.find('th:nth-child(8), td:nth-child(8)').remove();  // Action  
    $clone.find('th:nth-child(1), td:nth-child(1)').remove();  // Image/Checkbox
    
    // Append cloned table to body (hidden)
    $('body').append($clone.hide());

    // OR hide by class names (recommended)
    // $('.action-col, .quantity-col, .checkbox-col').hide();
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        
        // Add title
        doc.setFontSize(20);
        doc.text('Product Catalog', 105, 20, { align: 'center' });
        
        // Capture table as image
        const table = document.getElementById('productTable');
        
        html2canvas(table, {
            scale: 2, // Higher quality
            useCORS: true,
            allowTaint: true
        }).then(canvas => {
            const imgData = canvas.toDataURL('image/png');
            const imgWidth = 190;
            const pageHeight = 295;
            const imgHeight = (canvas.height * imgWidth) / canvas.width;
            let heightLeft = imgHeight;
            let position = 40; // Start after title
            
            // Add first image (title area)
            doc.addImage(imgData, 'PNG', 10, position, imgWidth, imgHeight);
            heightLeft -= pageHeight;
            
            // Add new pages if table is too tall
            while (heightLeft >= 0) {
                position = heightLeft - imgHeight + 40;
                doc.addPage();
                doc.addImage(imgData, 'PNG', 10, position, imgWidth, imgHeight);
                heightLeft -= pageHeight;
            }
            
            // Add footer
            doc.setFontSize(10);
            doc.text('House of Stitches | info@houseofstitches.in | +91 9876543210', 105, 280, { align: 'center' });
            
            // Save PDF
            doc.save('product-catalog.pdf');
        });
    }
    </script>

<script>
$(document).on('change', '.visibility-checkbox', function () {
    var cb     = $(this);
    var id     = cb.data('id');
    var status = cb.is(':checked') ? 1 : 0;
    var badge  = cb.siblings('span');

    $.post('<?= base_url('admin/productStatusChange') ?>', { id: id, to_status: status }, function (res) {
        if (res == 1) {
            if (status === 1) {
                badge.removeClass('label-default').addClass('label-success')
                     .html('<i class="fa fa-eye"></i> Live');
                cb.closest('label').attr('title', 'Live — click to hide');
            } else {
                badge.removeClass('label-success').addClass('label-default')
                     .html('<i class="fa fa-eye-slash"></i> Hidden');
                cb.closest('label').attr('title', 'Hidden — click to make live');
            }
        } else {
            // Revert checkbox on failure
            cb.prop('checked', !cb.prop('checked'));
        }
    });
});
</script>




