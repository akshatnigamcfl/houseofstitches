<script src="<?= base_url('assets/ckeditor/ckeditor.js') ?>"></script>
<h1><img src="<?= base_url('assets/imgs/shop-cart-add-icon.png') ?>" class="header-img" style="margin-top:-3px;"> Publish product</h1>
<hr>
<?php
$timeNow = time();
if (validation_errors()) {
    ?>
    <hr>
    <div class="alert alert-danger"><?= validation_errors() ?></div>
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
<form method="POST" action="" enctype="multipart/form-data">
    <input type="hidden" value="<?= isset($_POST['folder']) ? htmlspecialchars($_POST['folder']) : $timeNow ?>" name="folder">
    <div class="form-group available-translations">
        <b>Languages</b>
        <?php foreach ($languages as $language) { ?>
            <button type="button" data-locale-change="<?= htmlspecialchars($language->abbr) ?>" class="btn btn-default locale-change text-uppercase <?= $language->abbr == MY_DEFAULT_LANGUAGE_ABBR ? 'active' : '' ?>">
                <img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">
                <?= htmlspecialchars($language->abbr) ?>
            </button>
        <?php } ?>
    </div>
    <?php
    $i = 0;
    foreach ($languages as $language) {
        ?>
        <div class="locale-container locale-container-<?= htmlspecialchars($language->abbr) ?>" <?= $language->abbr == MY_DEFAULT_LANGUAGE_ABBR ? 'style="display:block;"' : '' ?>>
            <input type="hidden" name="translations[]" value="<?= htmlspecialchars($language->abbr) ?>">
            <div class="form-group"> 
                <label>Title (<?= htmlspecialchars($language->name) ?><img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">)</label>
                <input type="text" name="title[]" value="<?= $trans_load != null && isset($trans_load[$language->abbr]['title']) ? $trans_load[$language->abbr]['title'] : '' ?>" class="form-control">
            </div>

            <div class="form-group">
                <a href="javascript:void(0);" class="btn btn-default showSliderDescrption" data-descr="<?= $i ?>">Show Slider Description <span class="glyphicon glyphicon-circle-arrow-down"></span></a>
            </div>
            <div class="theSliderDescrption" id="theSliderDescrption-<?= $i ?>" <?= isset($_POST['in_slider']) && $_POST['in_slider'] == 1 ? 'style="display:block;"' : '' ?>>
                <div class="form-group">
                    <label for="basic_description<?= $i ?>">Slider Description (<?= htmlspecialchars($language->name) ?><img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">)</label>
                    <textarea name="basic_description[]" id="basic_description<?= $i ?>" rows="50" class="form-control"><?= $trans_load != null && isset($trans_load[$language->abbr]['basic_description']) ? $trans_load[$language->abbr]['basic_description'] : '' ?></textarea>
                    <script>
                        CKEDITOR.replace('basic_description<?= $i ?>');
                        CKEDITOR.config.entities = false;
                    </script>
                </div>
            </div>
            <div class="form-group">
                <label for="description<?= $i ?>">Description (<?= htmlspecialchars($language->name) ?><img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">)</label>
                <textarea name="description[]" id="description<?= $i ?>" rows="50" class="form-control"><?= $trans_load != null && isset($trans_load[$language->abbr]['description']) ? $trans_load[$language->abbr]['description'] : '' ?></textarea>
                <script>
                    CKEDITOR.replace('description<?= $i ?>');
                    CKEDITOR.config.entities = false;
                </script>
            </div>
            <div class="form-group for-shop">
                <label>Price (<?= htmlspecialchars($language->name) ?><img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">)</label>
                <input type="text" name="price[]" placeholder="without currency at the end" value="<?= $trans_load != null && isset($trans_load[$language->abbr]['price']) ? $trans_load[$language->abbr]['price'] : '' ?>" class="form-control">
            </div>
            <div class="form-group for-shop">
                <label>Msp</label>
                <input type="text" name="msp[]" placeholder="without currency at the end" value="<?= isset($_POST['msp']) ? htmlspecialchars($_POST['msp']) : '' ?>" class="form-control">
            </div>
            <div class="form-group for-shop">
                <label>Wsp</label>
                <input type="text" name="wsp[]" placeholder="without currency at the end" value="<?= isset($_POST['wsp']) ? htmlspecialchars($_POST['wsp']) : '' ?>" class="form-control">
            </div>
            <div class="form-group for-shop">
                <label>Old Price (<img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">)</label>
                <input type="text" name="old_price[]" placeholder="without currency at the end" value="<?= $trans_load != null && isset($trans_load[$language->abbr]['old_price']) ? $trans_load[$language->abbr]['old_price'] : '' ?>" class="form-control">
            </div>
        </div>
        <?php
        $i++;
    }
    ?>
    <div class="form-group bordered-group">
        <?php
        if (isset($_POST['image']) && $_POST['image'] != null) {
            $image = 'attachments/shop_images/' . htmlspecialchars($_POST['image']);
            if (!file_exists($image)) {
                $image = 'attachments/no-image.png';
            }
            ?>
            <p>Current image:</p>
            <div>
                <img src="<?= base_url($image) ?>" class="img-responsive img-thumbnail" style="max-width:300px; margin-bottom: 5px;">
            </div>
            <input type="hidden" name="old_image" value="<?= htmlspecialchars($_POST['image']) ?>">
            <?php if (isset($_GET['to_lang'])) { ?>
                <input type="hidden" name="image" value="<?= htmlspecialchars($_POST['image']) ?>">
                <?php
            }
        }
        ?>
        <label for="userfile">Cover Image</label>
        <input type="file" id="userfile" name="userfile">
    </div>
    <div class="form-group bordered-group">
        <div class="others-images-container">
            <?= $otherImgs ?>
        </div>
        <a href="javascript:void(0);" data-toggle="modal" data-target="#modalMoreImages" class="btn btn-default">Upload more images</a>
    </div>
    <div class="form-group for-shop">
        <label>Shop Categories</label>
        <select class="selectpicker form-control show-tick show-menu-arrow" name="shop_categorie">
            <?php foreach ($shop_categories as $key_cat => $shop_categorie) { ?>
                <option <?= isset($_POST['shop_categorie']) && $_POST['shop_categorie'] == $key_cat ? 'selected=""' : '' ?> value="<?= $key_cat ?>">
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
    <div class="form-group for-shop">
        <label>Quantity</label>
        <input type="text" placeholder="number" name="quantity" value="<?= isset($_POST['quantity']) ? htmlspecialchars($_POST['quantity']) : '' ?>" class="form-control" id="quantity">
    </div>
    <div class="form-group for-shop">
        <label><strong>Size &amp; Color Variations</strong></label>
        <div id="variations-container">
            <?php
            $existingVariations = isset($variations) && !empty($variations) ? $variations : [['color'=>'','sizes'=>'']];
            foreach ($existingVariations as $v):
            ?>
            <div class="variation-row" style="background:#f9f9f9;border:1px solid #ddd;border-radius:4px;padding:10px;margin-bottom:8px;">
                <div class="row">
                    <div class="col-sm-3">
                        <label>Color</label>
                        <input type="text" name="variation_color[]" class="form-control" placeholder="e.g. Red, Navy" value="<?= htmlspecialchars($v['color']) ?>">
                    </div>
                    <div class="col-sm-8">
                        <label>Sizes <small class="text-muted">(click to add/remove)</small></label>
                        <input type="text" name="variation_sizes[]" class="form-control var-sizes-input" placeholder="e.g. S,M,L or 0-3M,3-6M" value="<?= htmlspecialchars($v['sizes']) ?>" style="margin-bottom:6px;">
                        <div class="size-quick-tags" style="line-height:2;">
                            <small class="text-muted">Baby:</small>
                            <?php foreach(['0-3M','3-6M','6-9M','6-12M','12-18M','18-24M'] as $s): ?>
                            <button type="button" class="btn btn-xs btn-default size-tag" data-size="<?= $s ?>"><?= $s ?></button>
                            <?php endforeach; ?>
                            &nbsp;<small class="text-muted">Kids:</small>
                            <?php foreach(['2Y','3Y','4Y','5Y','6Y','7Y','8Y','9Y','10Y','11Y','12Y','13Y','14Y','15Y'] as $s): ?>
                            <button type="button" class="btn btn-xs btn-default size-tag" data-size="<?= $s ?>"><?= $s ?></button>
                            <?php endforeach; ?>
                            &nbsp;<small class="text-muted">Adult:</small>
                            <?php foreach(['XS','S','M','L','XL','XXL','XXXL'] as $s): ?>
                            <button type="button" class="btn btn-xs btn-default size-tag" data-size="<?= $s ?>"><?= $s ?></button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="col-sm-1" style="padding-top:22px;">
                        <button type="button" class="btn btn-danger btn-xs remove-variation" title="Remove"><span class="glyphicon glyphicon-remove"></span></button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <button type="button" id="add-variation" class="btn btn-default btn-sm" style="margin-top:4px;">
            <span class="glyphicon glyphicon-plus"></span> Add Variation
        </button>
    </div>

    <script>
    (function() {
        var sizesList = ['0-3M','3-6M','6-9M','6-12M','12-18M','18-24M','2Y','3Y','4Y','5Y','6Y','7Y','8Y','9Y','10Y','11Y','12Y','13Y','14Y','15Y','XS','S','M','L','XL','XXL','XXXL'];

        function buildRow(color, sizes) {
            color = color || ''; sizes = sizes || '';
            var tagsHtml = '';
            var groups = [
                {label:'Baby:', sizes:['0-3M','3-6M','6-9M','6-12M','12-18M','18-24M']},
                {label:'Kids:', sizes:['2Y','3Y','4Y','5Y','6Y','7Y','8Y','9Y','10Y','11Y','12Y','13Y','14Y','15Y']},
                {label:'Adult:', sizes:['XS','S','M','L','XL','XXL','XXXL']}
            ];
            groups.forEach(function(g) {
                tagsHtml += '<small class="text-muted">'+g.label+'</small> ';
                g.sizes.forEach(function(s) {
                    tagsHtml += '<button type="button" class="btn btn-xs btn-default size-tag" data-size="'+s+'">'+s+'</button> ';
                });
                tagsHtml += '&nbsp;';
            });
            return '<div class="variation-row" style="background:#f9f9f9;border:1px solid #ddd;border-radius:4px;padding:10px;margin-bottom:8px;"><div class="row"><div class="col-sm-3"><label>Color</label><input type="text" name="variation_color[]" class="form-control" placeholder="e.g. Red, Navy" value="'+color+'"></div><div class="col-sm-8"><label>Sizes <small class="text-muted">(click to add/remove)</small></label><input type="text" name="variation_sizes[]" class="form-control var-sizes-input" placeholder="e.g. S,M,L or 0-3M,3-6M" value="'+sizes+'" style="margin-bottom:6px;"><div class="size-quick-tags" style="line-height:2;">'+tagsHtml+'</div></div><div class="col-sm-1" style="padding-top:22px;"><button type="button" class="btn btn-danger btn-xs remove-variation" title="Remove"><span class="glyphicon glyphicon-remove"></span></button></div></div></div>';
        }

        document.getElementById('add-variation').onclick = function() {
            var cont = document.getElementById('variations-container');
            cont.insertAdjacentHTML('beforeend', buildRow());
        };

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-variation') || e.target.closest && e.target.closest('.remove-variation')) {
                var btn = e.target.classList.contains('remove-variation') ? e.target : e.target.closest('.remove-variation');
                var row = btn.closest('.variation-row');
                if (document.querySelectorAll('.variation-row').length > 1) {
                    row.remove();
                }
            }
            if (e.target.classList.contains('size-tag')) {
                var tag = e.target;
                var row = tag.closest('.variation-row');
                var input = row.querySelector('.var-sizes-input');
                var size = tag.getAttribute('data-size');
                var parts = input.value.split(',').map(function(s){return s.trim();}).filter(Boolean);
                var idx = parts.indexOf(size);
                if (idx === -1) {
                    parts.push(size);
                    tag.classList.add('btn-primary');
                    tag.classList.remove('btn-default');
                } else {
                    parts.splice(idx, 1);
                    tag.classList.remove('btn-primary');
                    tag.classList.add('btn-default');
                }
                input.value = parts.join(',');
            }
        });

        // Highlight size tags that match existing values on page load
        document.querySelectorAll('.variation-row').forEach(function(row) {
            var input = row.querySelector('.var-sizes-input');
            var parts = input.value.split(',').map(function(s){return s.trim();}).filter(Boolean);
            row.querySelectorAll('.size-tag').forEach(function(tag) {
                if (parts.indexOf(tag.getAttribute('data-size')) !== -1) {
                    tag.classList.add('btn-primary');
                    tag.classList.remove('btn-default');
                }
            });
        });
    })();
    </script>
    <?php if ($showBrands == 1) { ?>
        <div class="form-group for-shop">
            <label>Brand</label>
            <select class="selectpicker" name="brand_id">
                <?php foreach ($brands as $brand) { ?>
                    <option <?= isset($_POST['brand_id']) && $_POST['brand_id'] == $brand['id'] ? 'selected' : '' ?> value="<?= $brand['id'] ?>"><?= $brand['name'] ?></option>
                <?php } ?>
            </select>
        </div>
    <?php } if ($virtualProducts == 1) { ?>
        <div class="form-group for-shop">
            <label>Virtual Products <a href="javascript:void(0);" data-toggle="modal" data-target="#virtualProductsHelp"><i class="fa fa-question-circle" aria-hidden="true"></i></a></label>
            <textarea class="form-control" name="virtual_products"><?= isset($_POST['virtual_products']) ? htmlspecialchars($_POST['virtual_products']) : '' ?></textarea>
        </div>
    <?php } ?>
    <div class="form-group for-shop">
        <label>In Slider</label>
        <select class="selectpicker" name="in_slider">
            <option value="1" <?= isset($_POST['in_slider']) && $_POST['in_slider'] == 1 ? 'selected' : '' ?>>Yes</option>
            <option value="0" <?= isset($_POST['in_slider']) && $_POST['in_slider'] == 0 || !isset($_POST['in_slider']) ? 'selected' : '' ?>>No</option>
        </select>
    </div>
    <div class="form-group for-shop">
        <label>Position</label>
        <input type="text" placeholder="Position number" name="position" value="<?= isset($_POST['position']) ? htmlspecialchars($_POST['position']) : '' ?>" class="form-control">
    </div>
    <button type="submit" name="submit" class="btn btn-lg btn-default btn-publish">Publish</button>
    <?php if ($this->uri->segment(3) !== null) { ?>
        <a href="<?= base_url('admin/products') ?>" class="btn btn-lg btn-default">Cancel</a>
    <?php } ?>
</form>
<!-- Modal Upload More Images -->
<div class="modal fade" id="modalMoreImages" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Upload more images</h4>
            </div>
            <div class="modal-body">
                <form id="uploadImagesForm">
                    <input type="hidden" value="<?= isset($_POST['folder']) ? htmlspecialchars($_POST['folder']) : $timeNow ?>" name="folder">
                    <label for="others">Select images</label>
                    <input type="file" name="others[]" id="others" multiple />
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default finish-upload">
                    <span class="finish-text">Finish</span>
                    <img src="<?= base_url('assets/imgs/load.gif') ?>" class="loadUploadOthers" alt="">
                </button>
            </div>
        </div>
    </div>
</div>
<!-- virtualProductsHelp -->
<div class="modal fade" id="virtualProductsHelp" tabindex="-1" role="dialog" aria-labelledby="virtualProductsHelp">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">What are virtual products?</h4>
            </div>
            <div class="modal-body">
                Sometimes we want to sell products that are for electronic use such as books. In the box below, you can enter links to products that can be downloaded after you confirm the order as "Processed" through the "Orders" tab, an email will be sent to the customer entered with the entire text entered in the "virtual products" field.
                We have left only the possibility to add links in this field because sometimes it is necessary that the electronic stuff you provide for downloading will be uploaded to other servers. If you want, you can add your files to "file manager" and take the links to them to add to the "virtual products"
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>