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
    <style>
    .variation-row { background:#f9f9f9; border:1px solid #ddd; border-radius:6px; padding:12px; margin-bottom:10px; }
    .swatch-zone {
        width:120px; height:120px; border:2px dashed #ccc; border-radius:8px;
        background:#f0f0f0; cursor:pointer; overflow:hidden;
        display:flex; align-items:center; justify-content:center;
        margin:0 auto 6px; position:relative; transition:border-color .15s;
    }
    .swatch-zone:hover { border-color:#888; }
    .swatch-zone img { width:100%; height:100%; object-fit:cover; display:block; position:absolute; inset:0; }
    .swatch-zone .swatch-placeholder { color:#aaa; text-align:center; pointer-events:none; }
    .swatch-zone .swatch-placeholder .glyphicon { font-size:28px; display:block; margin-bottom:4px; }
    .swatch-zone .swatch-placeholder small { font-size:11px; }
    .swatch-upload-msg { font-size:11px; color:#888; text-align:center; min-height:16px; }
    .var-color-input { text-align:center; font-size:12px; margin-top:2px; }
    .var-color-row { display:flex; align-items:center; gap:4px; margin-top:4px; }
    .var-hex-picker { width:36px; height:28px; border:1px solid #ccc; border-radius:4px; padding:1px; cursor:pointer; flex-shrink:0; }
    .var-color-input { flex:1; }
    </style>

    <div class="form-group for-shop">
        <label><strong>Swatch &amp; Size Variations</strong></label>
        <p class="text-muted" style="font-size:12px;margin-bottom:8px;">Each variation = one colour of the product. Upload a swatch image, then add the available sizes.</p>
        <div id="variations-container">
            <?php
            $existingVariations = isset($variations) && !empty($variations) ? $variations : [['color'=>'','sizes'=>'','swatch'=>'','hex'=>'']];
            foreach ($existingVariations as $v):
                $swatchFile = isset($v['swatch']) ? $v['swatch'] : '';
                $swatchUrl  = $swatchFile ? base_url('attachments/product_swatches/' . $swatchFile) : '';
                $vHex       = isset($v['hex']) && $v['hex'] ? $v['hex'] : '#cccccc';
            ?>
            <div class="variation-row">
                <div class="row">
                    <div class="col-sm-3 text-center">
                        <div class="swatch-upload-wrap">
                            <div class="swatch-zone">
                                <?php if ($swatchUrl): ?>
                                <img src="<?= $swatchUrl ?>" onerror="this.style.display='none'">
                                <?php else: ?>
                                <div class="swatch-placeholder">
                                    <span class="glyphicon glyphicon-camera"></span>
                                    <small>Click to upload<br>swatch image</small>
                                </div>
                                <?php endif; ?>
                            </div>
                            <input type="file" class="swatch-file-input" accept="image/*" style="display:none;">
                            <input type="hidden" name="variation_swatch[]" class="swatch-filename" value="<?= htmlspecialchars($swatchFile) ?>">
                            <div class="swatch-upload-msg"><?= $swatchUrl ? '✓ Uploaded' : 'No image yet' ?></div>
                            <div class="var-color-row">
                                <input type="color" class="var-hex-picker" value="<?= htmlspecialchars($vHex) ?>" title="Pick color">
                                <input type="hidden" name="variation_hex[]" class="var-hex-value" value="<?= htmlspecialchars($vHex) ?>">
                                <input type="text" name="variation_color[]" class="form-control var-color-input" placeholder="Color name" value="<?= htmlspecialchars($v['color']) ?>">
                            </div>
                        </div>
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
                    <div class="col-sm-1" style="padding-top:10px;">
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
        var swatchUploadUrl = '<?= base_url("admin/uploadSwatch") ?>';

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
            return '<div class="variation-row">'
                + '<div class="row">'
                + '<div class="col-sm-3 text-center">'
                + '<div class="swatch-upload-wrap">'
                + '<div class="swatch-zone">'
                + '<div class="swatch-placeholder"><span class="glyphicon glyphicon-camera"></span><small>Click to upload<br>swatch image</small></div>'
                + '</div>'
                + '<input type="file" class="swatch-file-input" accept="image/*" style="display:none;">'
                + '<input type="hidden" name="variation_swatch[]" class="swatch-filename" value="">'
                + '<div class="swatch-upload-msg">No image yet</div>'
                + '<div class="var-color-row">'
                + '<input type="color" class="var-hex-picker" value="#cccccc" title="Pick color">'
                + '<input type="hidden" name="variation_hex[]" class="var-hex-value" value="#cccccc">'
                + '<input type="text" name="variation_color[]" class="form-control var-color-input" placeholder="Color name" value="'+color+'">'
                + '</div>'
                + '</div>'
                + '</div>'
                + '<div class="col-sm-8"><label>Sizes <small class="text-muted">(click to add/remove)</small></label>'
                + '<input type="text" name="variation_sizes[]" class="form-control var-sizes-input" placeholder="e.g. S,M,L or 0-3M,3-6M" value="'+sizes+'" style="margin-bottom:6px;">'
                + '<div class="size-quick-tags" style="line-height:2;">'+tagsHtml+'</div></div>'
                + '<div class="col-sm-1" style="padding-top:10px;"><button type="button" class="btn btn-danger btn-xs remove-variation" title="Remove"><span class="glyphicon glyphicon-remove"></span></button></div>'
                + '</div></div>';
        }

        document.getElementById('add-variation').onclick = function() {
            var cont = document.getElementById('variations-container');
            cont.insertAdjacentHTML('beforeend', buildRow());
        };

        // Delegated click handler — clicking the swatch zone triggers file input
        document.addEventListener('click', function(e) {
            var zone = e.target.closest && e.target.closest('.swatch-zone');
            if (zone) {
                zone.closest('.swatch-upload-wrap').querySelector('.swatch-file-input').click();
                return;
            }

            if (e.target.closest && e.target.closest('.remove-variation')) {
                var row = e.target.closest('.variation-row');
                if (document.querySelectorAll('.variation-row').length > 1) row.remove();
                return;
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

        // Sync color picker → hidden hex input
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('var-hex-picker')) {
                var row = e.target.closest('.var-color-row');
                if (row) row.querySelector('.var-hex-value').value = e.target.value;
            }
        });

        // File input change → AJAX upload
        document.addEventListener('change', function(e) {
            if (!e.target.classList.contains('swatch-file-input')) return;
            var fileInput = e.target;
            var wrap = fileInput.closest('.swatch-upload-wrap');
            var zone = wrap.querySelector('.swatch-zone');
            var msg  = wrap.querySelector('.swatch-upload-msg');
            if (!fileInput.files || !fileInput.files[0]) return;
            msg.textContent = 'Uploading…';
            var fd = new FormData();
            fd.append('swatch', fileInput.files[0]);
            var xhr = new XMLHttpRequest();
            xhr.open('POST', swatchUploadUrl, true);
            xhr.onload = function() {
                try {
                    var res = JSON.parse(xhr.responseText);
                    if (res.success) {
                        zone.innerHTML = '<img src="'+res.url+'" onerror="this.style.display=\'none\'">';
                        wrap.querySelector('.swatch-filename').value = res.filename;
                        msg.textContent = '✓ Uploaded';
                        setTimeout(function(){ msg.textContent=''; }, 2000);
                    } else {
                        msg.textContent = 'Error: ' + (res.error || 'Upload failed');
                    }
                } catch(ex) {
                    msg.textContent = 'Upload failed';
                }
            };
            xhr.onerror = function() { msg.textContent = 'Upload failed'; };
            xhr.send(fd);
        });

        // Highlight size tags on page load
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

    <div class="panel panel-default" style="margin-top:20px;">
        <div class="panel-heading"><strong><i class="fa fa-filter"></i> Filter &amp; Catalogue Fields</strong></div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Season</label>
                        <select name="season" class="form-control">
                            <option value="">— None —</option>
                            <?php
                            $season_opts = ['Summer','Winter','Spring','Autumn','All Season'];
                            $cur_season = !empty($_POST['season']) ? $_POST['season'] : '';
                            foreach ($season_opts as $s): ?>
                            <option value="<?= $s ?>" <?= ($cur_season == $s) ? 'selected' : '' ?>><?= $s ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Gender</label>
                        <select name="gender" class="form-control">
                            <option value="">— None —</option>
                            <?php
                            $gender_opts = ['Girls','Boys','Infant','Unisex'];
                            $cur_gender = !empty($_POST['gender']) ? $_POST['gender'] : '';
                            foreach ($gender_opts as $g): ?>
                            <option value="<?= $g ?>" <?= ($cur_gender == $g) ? 'selected' : '' ?>><?= $g ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Color <small class="text-muted">(e.g. Red, Navy Blue)</small></label>
                        <input type="text" name="color" class="form-control" placeholder="e.g. Red, Navy Blue" value="<?= htmlspecialchars(!empty($_POST['color']) ? $_POST['color'] : '') ?>">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Size Range <small class="text-muted">(e.g. 2Y–8Y, S–XXL)</small></label>
                        <input type="text" name="size_range" class="form-control" placeholder="e.g. 2Y–8Y" value="<?= htmlspecialchars(!empty($_POST['size_range']) ? $_POST['size_range'] : '') ?>">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Fabric <small class="text-muted">(e.g. Cotton, Polyester)</small></label>
                        <input type="text" name="fabric" class="form-control" placeholder="e.g. Cotton" value="<?= htmlspecialchars(!empty($_POST['fabric']) ? $_POST['fabric'] : '') ?>">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Brand <small class="text-muted">(text label, e.g. House of Stitches)</small></label>
                        <input type="text" name="brand" class="form-control" placeholder="e.g. House of Stitches" value="<?= htmlspecialchars(!empty($_POST['brand']) ? $_POST['brand'] : '') ?>">
                    </div>
                </div>
            </div>
        </div>
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