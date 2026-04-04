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
    <input type="hidden" value="<?= (!empty($_POST['folder'])) ? htmlspecialchars($_POST['folder']) : ($id > 0 ? (string)$id : (string)$timeNow) ?>" name="folder">
   
    <!-- <div class="form-group available-translations">
        <b>Languages</b>
        <?php foreach ($languages as $language) { ?>
            <button type="button" data-locale-change="<?= htmlspecialchars($language->abbr) ?>" class="btn btn-default locale-change text-uppercase <?= $language->abbr == MY_DEFAULT_LANGUAGE_ABBR ? 'active' : '' ?>">
                <img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">
                <?= htmlspecialchars($language->abbr) ?>
            </button>
        <?php } ?>
    </div> -->

    <?php $defaultLang = MY_DEFAULT_LANGUAGE_ABBR; ?>
    <input type="hidden" name="translations[]" value="<?= $defaultLang ?>">
    <div class="form-group">
        <label>Title</label>
        <input type="text" name="title[]" value="<?= $trans_load != null && isset($trans_load[$defaultLang]['title']) ? htmlspecialchars($trans_load[$defaultLang]['title']) : '' ?>" class="form-control">
    </div>
    <div class="form-group">
        <a href="javascript:void(0);" class="btn btn-default showSliderDescrption" data-descr="0">Show Slider Description <span class="glyphicon glyphicon-circle-arrow-down"></span></a>
    </div>
    <div class="theSliderDescrption" id="theSliderDescrption-0" <?= isset($_POST['in_slider']) && $_POST['in_slider'] == 1 ? 'style="display:block;"' : '' ?>>
        <div class="form-group">
            <label for="basic_description0">Slider Description</label>
            <textarea name="basic_description[]" id="basic_description0" rows="10" class="form-control"><?= $trans_load != null && isset($trans_load[$defaultLang]['basic_description']) ? $trans_load[$defaultLang]['basic_description'] : '' ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label for="description0">Description</label>
        <textarea name="description[]" id="description0" rows="10" class="form-control"><?= $trans_load != null && isset($trans_load[$defaultLang]['description']) ? $trans_load[$defaultLang]['description'] : '' ?></textarea>
    </div>
    <div class="form-group for-shop">
        <div class="row">
            <div class="col-xs-4">
                <label>Price</label>
                <input type="text" name="price[]" placeholder="Price" value="<?= $trans_load != null && isset($trans_load[$defaultLang]['price']) ? htmlspecialchars($trans_load[$defaultLang]['price']) : '' ?>" class="form-control input-sm">
            </div>
            <div class="col-xs-4">
                <label>MRP</label>
                <input type="text" name="msp[]" placeholder="MRP" value="<?= isset($_POST['msp']) ? htmlspecialchars($_POST['msp']) : '' ?>" class="form-control input-sm">
            </div>
            <div class="col-xs-4">
                <label>WSP</label>
                <input type="text" name="wsp[]" placeholder="WSP" value="<?= isset($_POST['wsp']) ? htmlspecialchars($_POST['wsp']) : '' ?>" class="form-control input-sm">
            </div>
        </div>
    </div>
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
        <label>Additional Images <small class="text-muted">(shown in product gallery)</small></label>
        <div id="extra-img-thumbs" style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:10px;">
            <?= $otherImgs ?>
        </div>
        <input type="file" id="extra-img-file-input" accept="image/*" multiple style="display:none;">
        <div id="extra-img-upload-zone" class="var-img-upload-zone" style="max-width:420px;">
            <span class="zone-icon glyphicon glyphicon-cloud-upload"></span>
            <div class="zone-text">
                <strong>Click to add more images</strong>
                <span>JPG, PNG, WEBP — select multiple</span>
            </div>
            <span class="zone-progress">Uploading…</span>
        </div>
        <div id="extra-upload-msg" style="margin-top:6px;font-size:12px;"></div>
    </div>
    <script>
    (function () {
        var uploadUrl   = '<?= base_url("admin/uploadExtraImage") ?>';
        var folderInput = document.querySelector('input[name="folder"]');
        var folder      = folderInput ? folderInput.value : '';
        var productId   = '<?= $id ?>';
        var zone        = document.getElementById('extra-img-upload-zone');
        var fileInput   = document.getElementById('extra-img-file-input');
        var thumbsDiv   = document.getElementById('extra-img-thumbs');
        var msgDiv      = document.getElementById('extra-upload-msg');

        zone.addEventListener('click', function () { fileInput.click(); });

        fileInput.addEventListener('change', function () {
            var files = Array.prototype.slice.call(fileInput.files);
            if (!files.length) return;

            zone.classList.add('uploading');
            msgDiv.innerHTML = '';

            var placeholders = [];
            files.forEach(function () {
                var ph = document.createElement('div');
                ph.className = 'var-img-thumb uploading-thumb';
                thumbsDiv.appendChild(ph);
                placeholders.push(ph);
            });

            var index = 0, errored = 0;
            function uploadNext() {
                if (index >= files.length) {
                    zone.classList.remove('uploading');
                    zone.querySelector('.zone-progress').textContent = 'Uploading…';
                    fileInput.value = '';
                    if (errored > 0) {
                        msgDiv.innerHTML = '<span style="color:#a94442;">' + errored + ' image(s) failed to upload.</span>';
                    } else {
                        msgDiv.innerHTML = '<span style="color:#3c763d;">✓ ' + files.length + ' image(s) uploaded.</span>';
                    }
                    return;
                }
                var file = files[index];
                var i    = index;
                index++;

                zone.querySelector('.zone-progress').textContent = 'Uploading ' + index + ' / ' + files.length + '…';

                var fd = new FormData();
                fd.append('folder', folder);
                fd.append('product_id', productId);
                fd.append('extra_image', file);

                var xhr = new XMLHttpRequest();
                xhr.open('POST', uploadUrl, true);
                xhr.onload = function () {
                    try {
                        var res = JSON.parse(xhr.responseText);
                        if (res.success) {
                            // If server generated a new folder, sync it back
                            if (res.folder && res.folder !== folder) {
                                folder = res.folder;
                                if (folderInput) folderInput.value = folder;
                            }
                            placeholders[i].className = 'var-img-thumb';
                            placeholders[i].innerHTML = '<img src="' + res.url + '" onerror="this.onerror=null;">';
                        } else {
                            placeholders[i].remove();
                            errored++;
                            msgDiv.innerHTML = '<span style="color:#a94442;">Upload failed: ' + (res.error || 'Unknown error') + '</span>';
                        }
                    } catch(e) {
                        placeholders[i].remove();
                        errored++;
                        msgDiv.innerHTML = '<span style="color:#a94442;">Server error. Check logs.</span>';
                    }
                    uploadNext();
                };
                xhr.onerror = function () {
                    placeholders[i].remove();
                    errored++;
                    uploadNext();
                };
                xhr.send(fd);
            }
            uploadNext();
        });
    })();
    </script>
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
        <label>Sub Category <small class="text-muted">(e.g. 2 Pcs Set, T-Shirt, Trouser)</small></label>
        <input type="text" name="sub_category" class="form-control" placeholder="e.g. 2 Pcs Set" value="<?= htmlspecialchars(!empty($_POST['sub_category']) ? $_POST['sub_category'] : '') ?>">
    </div>
    <div class="form-group for-shop">
        <label>Article Number</label>
        <input type="text" placeholder="Unique article / SKU code" name="article_number" value="<?= isset($_POST['article_number']) ? htmlspecialchars($_POST['article_number']) : '' ?>" class="form-control">
    </div>
    <div class="form-group for-shop">
        <label>Quantity</label>
        <input type="text" placeholder="number" name="quantity" value="<?= isset($_POST['quantity']) ? htmlspecialchars($_POST['quantity']) : '' ?>" class="form-control" id="quantity">
    </div>
    <style>
    /* ── Variation Card ── */
    .variation-row {
        background:#fff; border:1px solid #ddd; border-radius:8px;
        margin-bottom:14px; overflow:hidden;
        box-shadow:0 1px 3px rgba(0,0,0,.06);
    }
    .variation-row .var-card-header {
        background:#f5f6f8; border-bottom:1px solid #e4e6ea;
        padding:8px 12px; display:flex; align-items:center; justify-content:space-between;
    }
    .variation-row .var-card-header .var-card-title {
        font-size:12px; font-weight:600; color:#555; text-transform:uppercase; letter-spacing:.5px;
    }
    .variation-row .var-card-body { padding:14px; }
    /* Swatch zone */
    .swatch-zone {
        width:96px; height:96px; border:2px dashed #ccc; border-radius:8px;
        background:#f8f8f8; cursor:pointer; overflow:hidden;
        display:flex; align-items:center; justify-content:center;
        margin:0 auto 6px; position:relative; transition:border-color .15s, background .15s;
    }
    .swatch-zone:hover { border-color:#3498db; background:#eaf4fd; }
    .swatch-zone.has-img { border-style:solid; border-color:#bbb; }
    .swatch-zone img { width:100%; height:100%; object-fit:cover; display:block; position:absolute; inset:0; }
    .swatch-placeholder { color:#bbb; text-align:center; pointer-events:none; }
    .swatch-placeholder .glyphicon { font-size:24px; display:block; margin-bottom:3px; }
    .swatch-placeholder small { font-size:10px; line-height:1.3; display:block; }
    .swatch-upload-msg { font-size:11px; color:#888; text-align:center; min-height:15px; margin-bottom:4px; }
    /* Color row */
    .var-color-row { display:flex; align-items:center; gap:5px; margin-top:2px; }
    .var-hex-picker { width:32px; height:28px; border:1px solid #ccc; border-radius:4px; padding:1px 2px; cursor:pointer; flex-shrink:0; }
    .var-color-input { flex:1; font-size:12px; }
    /* Sizes */
    .size-quick-tags { line-height:2; margin-top:4px; }
    /* Variation Images Upload Zone */
    .var-img-upload-zone {
        border:2px dashed #ccc; border-radius:6px; background:#f8f8f8;
        padding:10px 12px; cursor:pointer; transition:border-color .15s, background .15s;
        display:flex; align-items:center; gap:8px; margin-bottom:8px;
    }
    .var-img-upload-zone:hover { border-color:#3498db; background:#eaf4fd; }
    .var-img-upload-zone.uploading { border-color:#f0ad4e; background:#fffbf0; cursor:default; }
    .var-img-upload-zone .zone-icon { font-size:20px; color:#aaa; flex-shrink:0; }
    .var-img-upload-zone .zone-text { font-size:12px; }
    .var-img-upload-zone .zone-text strong { display:block; color:#555; }
    .var-img-upload-zone .zone-text span { color:#aaa; font-size:11px; }
    .var-img-upload-zone .zone-progress { font-size:11px; color:#f0ad4e; margin-left:auto; display:none; }
    .var-img-upload-zone.uploading .zone-progress { display:block; }
    /* Image thumbnails grid */
    .var-img-thumbs { display:flex; flex-wrap:wrap; gap:8px; }
    .var-img-thumb {
        position:relative; width:72px; height:72px;
        border:1px solid #ddd; border-radius:6px; overflow:hidden;
        background:#f0f0f0; flex-shrink:0;
        transition:box-shadow .15s;
    }
    .var-img-thumb:hover { box-shadow:0 2px 8px rgba(0,0,0,.15); }
    .var-img-thumb img { width:100%; height:100%; object-fit:cover; display:block; }
    .var-img-thumb .remove-var-img {
        position:absolute; top:3px; right:3px;
        background:rgba(200,30,30,.85); color:#fff; border:none; border-radius:50%;
        width:18px; height:18px; font-size:12px; line-height:18px; text-align:center;
        cursor:pointer; padding:0; display:none; font-weight:700;
    }
    .var-img-thumb:hover .remove-var-img { display:block; }
    .var-img-thumb.uploading-thumb {
        border-style:dashed; border-color:#f0ad4e;
        display:flex; align-items:center; justify-content:center;
    }
    .var-img-thumb.uploading-thumb::after { content:'…'; font-size:18px; color:#f0ad4e; }
    .var-images-section { margin-top:10px; border-top:1px solid #eee; padding-top:10px; }
    .var-images-section > label { font-size:12px; font-weight:600; color:#555; display:block; margin-bottom:6px; }
    </style>

    <div class="form-group for-shop">
        <label><strong>Colour &amp; Size Variations</strong></label>
        <p class="text-muted" style="font-size:12px;margin-bottom:10px;">Each variation is one colour of the product. Set colour, pick sizes, and upload product images for that colour.</p>
        <div id="variations-container">
            <?php
            $existingVariations = isset($variations) && !empty($variations) ? $variations : [['color'=>'','sizes'=>'','swatch'=>'','hex'=>'','images'=>'']];
            foreach ($existingVariations as $vi => $v):
                $swatchFile = isset($v['swatch']) ? $v['swatch'] : '';
                $swatchUrl  = $swatchFile ? base_url('attachments/product_swatches/' . $swatchFile) : '';
                $vHex       = isset($v['hex']) && $v['hex'] ? $v['hex'] : '#cccccc';
                $vImages    = isset($v['images']) ? trim($v['images']) : '';
                $vImgList   = $vImages ? array_filter(array_map('trim', explode(',', $vImages))) : [];
                $vColorName = isset($v['color']) && $v['color'] ? htmlspecialchars($v['color']) : 'New Variation';
            ?>
            <div class="variation-row">
                <div class="var-card-header">
                    <span class="var-card-title">
                        <span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:<?= htmlspecialchars($vHex) ?>;vertical-align:middle;margin-right:5px;border:1px solid rgba(0,0,0,.15);"></span>
                        <?= $vColorName ?>
                    </span>
                    <button type="button" class="btn btn-danger btn-xs remove-variation" title="Remove variation">
                        <span class="glyphicon glyphicon-trash"></span> Remove
                    </button>
                </div>
                <div class="var-card-body">
                    <div class="row">
                        <!-- Swatch + Color name -->
                        <div class="col-sm-3 text-center">
                            <div class="swatch-upload-wrap">
                                <div class="swatch-zone <?= $swatchUrl ? 'has-img' : '' ?>" title="Click to upload swatch">
                                    <?php if ($swatchUrl): ?>
                                    <img src="<?= $swatchUrl ?>" onerror="this.style.display='none'">
                                    <?php else: ?>
                                    <div class="swatch-placeholder">
                                        <span class="glyphicon glyphicon-picture"></span>
                                        <small>Click to upload<br>colour swatch</small>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <input type="file" class="swatch-file-input" accept="image/*" style="display:none;">
                                <input type="hidden" name="variation_swatch[]" class="swatch-filename" value="<?= htmlspecialchars($swatchFile) ?>">
                                <div class="swatch-upload-msg"><?= $swatchUrl ? '<span style="color:#3c763d;">✓ Swatch uploaded</span>' : '<span style="color:#aaa;">No swatch yet</span>' ?></div>
                            </div>
                            <div class="var-color-row" style="margin-top:8px;">
                                <input type="color" class="var-hex-picker" value="<?= htmlspecialchars($vHex) ?>" title="Pick colour">
                                <input type="hidden" name="variation_hex[]" class="var-hex-value" value="<?= htmlspecialchars($vHex) ?>">
                                <input type="text" name="variation_color[]" class="form-control var-color-input" placeholder="e.g. Navy Blue" value="<?= htmlspecialchars($v['color']) ?>">
                            </div>
                        </div>
                        <!-- Sizes + Product Images -->
                        <div class="col-sm-9">
                            <label style="font-size:12px;font-weight:600;color:#555;">Sizes <small class="text-muted">(click to toggle)</small></label>
                            <input type="text" name="variation_sizes[]" class="form-control var-sizes-input" placeholder="e.g. S,M,L or 0-3M,3-6M" value="<?= htmlspecialchars($v['sizes']) ?>" style="margin-bottom:6px;font-size:12px;">
                            <div class="size-quick-tags">
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

                            <!-- Variation Product Images -->
                            <div class="var-images-section">
                                <label>Product Images for this Colour <small class="text-muted">(shown on product page when this colour is selected)</small></label>
                                <div class="var-img-thumbs" style="margin-bottom:8px;">
                                    <?php foreach ($vImgList as $imgFile): ?>
                                    <div class="var-img-thumb">
                                        <img src="<?= base_url('attachments/variation_images/' . $imgFile) ?>" onerror="this.parentElement.style.display='none'">
                                        <button type="button" class="remove-var-img" data-file="<?= htmlspecialchars($imgFile) ?>" title="Remove">×</button>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                                <input type="hidden" name="variation_images[]" class="var-images-value" value="<?= htmlspecialchars($vImages) ?>">
                                <input type="file" class="var-img-file-input" accept="image/*" multiple style="display:none;">
                                <div class="var-img-upload-zone">
                                    <span class="zone-icon glyphicon glyphicon-cloud-upload"></span>
                                    <div class="zone-text">
                                        <strong>Click to add images</strong>
                                        <span>JPG, PNG, WEBP — select multiple</span>
                                    </div>
                                    <span class="zone-progress">Uploading…</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <button type="button" id="add-variation" class="btn btn-default btn-sm">
            <span class="glyphicon glyphicon-plus"></span> Add Another Variation
        </button>
    </div>

    <script>
    (function() {
        var swatchUploadUrl = '<?= base_url("admin/uploadSwatch") ?>';
        var varImgUploadUrl = '<?= base_url("admin/uploadVariationImage") ?>';

        function sizeTagsHtml() {
            var groups = [
                {label:'Baby:',  sizes:['0-3M','3-6M','6-9M','6-12M','12-18M','18-24M']},
                {label:'Kids:',  sizes:['2Y','3Y','4Y','5Y','6Y','7Y','8Y','9Y','10Y','11Y','12Y','13Y','14Y','15Y']},
                {label:'Adult:', sizes:['XS','S','M','L','XL','XXL','XXXL']}
            ];
            var h = '';
            groups.forEach(function(g) {
                h += '<small class="text-muted">'+g.label+'</small> ';
                g.sizes.forEach(function(s) {
                    h += '<button type="button" class="btn btn-xs btn-default size-tag" data-size="'+s+'">'+s+'</button> ';
                });
                h += '&nbsp;';
            });
            return h;
        }

        function buildRow() {
            return '<div class="variation-row">'
                + '<div class="var-card-header">'
                + '<span class="var-card-title"><span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:#cccccc;vertical-align:middle;margin-right:5px;border:1px solid rgba(0,0,0,.15);"></span>New Variation</span>'
                + '<button type="button" class="btn btn-danger btn-xs remove-variation" title="Remove"><span class="glyphicon glyphicon-trash"></span> Remove</button>'
                + '</div>'
                + '<div class="var-card-body"><div class="row">'
                + '<div class="col-sm-3 text-center">'
                + '<div class="swatch-upload-wrap">'
                + '<div class="swatch-zone" title="Click to upload swatch">'
                + '<div class="swatch-placeholder"><span class="glyphicon glyphicon-picture"></span><small>Click to upload<br>colour swatch</small></div>'
                + '</div>'
                + '<input type="file" class="swatch-file-input" accept="image/*" style="display:none;">'
                + '<input type="hidden" name="variation_swatch[]" class="swatch-filename" value="">'
                + '<div class="swatch-upload-msg"><span style="color:#aaa;">No swatch yet</span></div>'
                + '</div>'
                + '<div class="var-color-row" style="margin-top:8px;">'
                + '<input type="color" class="var-hex-picker" value="#cccccc" title="Pick colour">'
                + '<input type="hidden" name="variation_hex[]" class="var-hex-value" value="#cccccc">'
                + '<input type="text" name="variation_color[]" class="form-control var-color-input" placeholder="e.g. Navy Blue" value="">'
                + '</div>'
                + '</div>'
                + '<div class="col-sm-9">'
                + '<label style="font-size:12px;font-weight:600;color:#555;">Sizes <small class="text-muted">(click to toggle)</small></label>'
                + '<input type="text" name="variation_sizes[]" class="form-control var-sizes-input" placeholder="e.g. S,M,L or 0-3M,3-6M" value="" style="margin-bottom:6px;font-size:12px;">'
                + '<div class="size-quick-tags">' + sizeTagsHtml() + '</div>'
                + '<div class="var-images-section">'
                + '<label style="font-size:12px;font-weight:600;color:#555;">Product Images for this Colour <small class="text-muted">(shown on product page when this colour is selected)</small></label>'
                + '<div class="var-img-thumbs" style="margin-bottom:8px;"></div>'
                + '<input type="hidden" name="variation_images[]" class="var-images-value" value="">'
                + '<input type="file" class="var-img-file-input" accept="image/*" multiple style="display:none;">'
                + '<div class="var-img-upload-zone">'
                + '<span class="zone-icon glyphicon glyphicon-cloud-upload"></span>'
                + '<div class="zone-text"><strong>Click to add images</strong><span>JPG, PNG, WEBP — select multiple</span></div>'
                + '<span class="zone-progress">Uploading…</span>'
                + '</div>'
                + '</div>'
                + '</div>'
                + '</div></div></div>';
        }

        document.getElementById('add-variation').onclick = function() {
            document.getElementById('variations-container').insertAdjacentHTML('beforeend', buildRow());
        };

        // ── Delegated click handler ──
        document.addEventListener('click', function(e) {
            // Swatch zone click
            var zone = e.target.closest && e.target.closest('.swatch-zone');
            if (zone && !zone.closest('.remove-var-img')) {
                zone.closest('.swatch-upload-wrap').querySelector('.swatch-file-input').click();
                return;
            }
            // Remove variation row
            if (e.target.closest && e.target.closest('.remove-variation')) {
                var row = e.target.closest('.variation-row');
                if (document.querySelectorAll('.variation-row').length > 1) row.remove();
                return;
            }
            // Size tag toggle
            if (e.target.classList.contains('size-tag')) {
                var tag = e.target;
                var row = tag.closest('.variation-row');
                var inp = row.querySelector('.var-sizes-input');
                var sz  = tag.getAttribute('data-size');
                var pts = inp.value.split(',').map(function(s){return s.trim();}).filter(Boolean);
                var idx = pts.indexOf(sz);
                if (idx === -1) { pts.push(sz); tag.classList.add('btn-primary'); tag.classList.remove('btn-default'); }
                else            { pts.splice(idx,1); tag.classList.remove('btn-primary'); tag.classList.add('btn-default'); }
                inp.value = pts.join(',');
                return;
            }
            // Var image upload zone click
            var uploadZone = e.target.closest && e.target.closest('.var-img-upload-zone');
            if (uploadZone && !uploadZone.classList.contains('uploading')) {
                uploadZone.closest('.var-images-section').querySelector('.var-img-file-input').click();
                return;
            }
            // Remove single variation image
            var rmBtn = e.target.closest && e.target.closest('.remove-var-img');
            if (rmBtn) {
                var thumb = rmBtn.closest('.var-img-thumb');
                var section = thumb.closest('.var-images-section');
                var hidden = section.querySelector('.var-images-value');
                var fname  = rmBtn.getAttribute('data-file');
                hidden.value = hidden.value.split(',').map(function(s){return s.trim();}).filter(function(f){return f && f!==fname;}).join(',');
                thumb.remove();
            }
        });

        // ── Input/change handlers ──
        document.addEventListener('input', function(e) {
            // Sync color picker → hex hidden + header dot
            if (e.target.classList.contains('var-hex-picker')) {
                var colorRow = e.target.closest('.var-color-row');
                colorRow.querySelector('.var-hex-value').value = e.target.value;
                // Update header colour dot
                var header = e.target.closest('.variation-row').querySelector('.var-card-title span');
                if (header) header.style.background = e.target.value;
            }
            // Update header title from color name input
            if (e.target.classList.contains('var-color-input')) {
                var row = e.target.closest('.variation-row');
                var titleSpan = row.querySelector('.var-card-title');
                var dot = titleSpan.querySelector('span');
                titleSpan.textContent = e.target.value || 'New Variation';
                titleSpan.insertBefore(dot, titleSpan.firstChild);
            }
        });

        document.addEventListener('change', function(e) {
            // Swatch file upload
            if (e.target.classList.contains('swatch-file-input')) {
                var fileInput = e.target;
                var wrap = fileInput.closest('.swatch-upload-wrap');
                var swatchZone = wrap.querySelector('.swatch-zone');
                var msg = wrap.querySelector('.swatch-upload-msg');
                if (!fileInput.files || !fileInput.files[0]) return;
                msg.innerHTML = 'Uploading…';
                var fd = new FormData();
                fd.append('swatch', fileInput.files[0]);
                var xhr = new XMLHttpRequest();
                xhr.open('POST', swatchUploadUrl, true);
                xhr.onload = function() {
                    try {
                        var res = JSON.parse(xhr.responseText);
                        if (res.success) {
                            swatchZone.innerHTML = '<img src="'+res.url+'" onerror="this.style.display=\'none\'">';
                            swatchZone.classList.add('has-img');
                            wrap.querySelector('.swatch-filename').value = res.filename;
                            msg.innerHTML = '<span style="color:#3c763d;">✓ Swatch uploaded</span>';
                        } else {
                            msg.innerHTML = '<span style="color:#a94442;">Error: '+(res.error||'Upload failed')+'</span>';
                        }
                    } catch(ex) { msg.innerHTML = '<span style="color:#a94442;">Upload failed</span>'; }
                };
                xhr.onerror = function() { msg.innerHTML = '<span style="color:#a94442;">Upload failed</span>'; };
                xhr.send(fd);
                return;
            }

            // Variation product image upload (multiple files)
            if (e.target.classList.contains('var-img-file-input')) {
                var fileInput = e.target;
                var section   = fileInput.closest('.var-images-section');
                var thumbsDiv = section.querySelector('.var-img-thumbs');
                var hidden    = section.querySelector('.var-images-value');
                var zone      = section.querySelector('.var-img-upload-zone');
                var files     = Array.prototype.slice.call(fileInput.files);
                if (!files.length) return;

                var total   = files.length;
                var done    = 0;
                var errored = 0;

                zone.classList.add('uploading');
                zone.querySelector('.zone-progress').textContent = 'Uploading 0 / ' + total + '…';

                // Add placeholder thumbs immediately
                var placeholders = [];
                files.forEach(function() {
                    var ph = document.createElement('div');
                    ph.className = 'var-img-thumb uploading-thumb';
                    thumbsDiv.appendChild(ph);
                    placeholders.push(ph);
                });

                files.forEach(function(file, i) {
                    var fd = new FormData();
                    fd.append('varimage', file);
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', varImgUploadUrl, true);
                    xhr.onload = function() {
                        done++;
                        try {
                            var res = JSON.parse(xhr.responseText);
                            if (res.success) {
                                // Replace placeholder with real thumb
                                placeholders[i].className = 'var-img-thumb';
                                placeholders[i].innerHTML = '<img src="'+res.url+'" onerror="this.onerror=null;">'
                                    + '<button type="button" class="remove-var-img" data-file="'+res.filename+'" title="Remove">\u00d7</button>';
                                // Append to hidden value
                                var cur = hidden.value.split(',').map(function(s){return s.trim();}).filter(Boolean);
                                cur.push(res.filename);
                                hidden.value = cur.join(',');
                            } else {
                                placeholders[i].remove();
                                errored++;
                            }
                        } catch(ex) { placeholders[i].remove(); errored++; }

                        zone.querySelector('.zone-progress').textContent = 'Uploading ' + done + ' / ' + total + '…';
                        if (done === total) {
                            zone.classList.remove('uploading');
                            zone.querySelector('.zone-progress').textContent = 'Uploading…';
                            fileInput.value = '';
                            if (errored > 0) alert(errored + ' image(s) failed to upload.');
                        }
                    };
                    xhr.onerror = function() {
                        done++; errored++;
                        placeholders[i].remove();
                        if (done === total) {
                            zone.classList.remove('uploading');
                            zone.querySelector('.zone-progress').textContent = 'Uploading…';
                            fileInput.value = '';
                            alert(errored + ' image(s) failed to upload.');
                        }
                    };
                    xhr.send(fd);
                });
            }
        });

        // Highlight active size tags on page load
        document.querySelectorAll('.variation-row').forEach(function(row) {
            var inp = row.querySelector('.var-sizes-input');
            if (!inp) return;
            var active = inp.value.split(',').map(function(s){return s.trim();}).filter(Boolean);
            row.querySelectorAll('.size-tag').forEach(function(tag) {
                if (active.indexOf(tag.getAttribute('data-size')) !== -1) {
                    tag.classList.add('btn-primary'); tag.classList.remove('btn-default');
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
                <?php
                // Helper: build select options, auto-adding current value if not in list
                function _attr_select($name, $items, $current) {
                    $current = trim((string)$current);
                    $found = false;
                    $html = '<option value="">— None —</option>';
                    foreach ($items as $item) {
                        $sel = ($current !== '' && $item['name'] === $current) ? ' selected' : '';
                        if ($sel) $found = true;
                        $html .= '<option value="' . htmlspecialchars($item['name']) . '"' . $sel . '>' . htmlspecialchars($item['name']) . '</option>';
                    }
                    if ($current !== '' && !$found) {
                        $html .= '<option value="' . htmlspecialchars($current) . '" selected>' . htmlspecialchars($current) . ' (custom)</option>';
                    }
                    return '<select name="' . $name . '" class="form-control">' . $html . '</select>';
                }
                ?>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Fabric
                            <small class="text-muted">— <a href="<?= base_url('admin/product-attributes?tab=fabric') ?>" target="_blank">Manage</a></small>
                        </label>
                        <?= _attr_select('fabric', $attr_fabrics, !empty($_POST['fabric']) ? $_POST['fabric'] : '') ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Brand
                            <small class="text-muted">— <a href="<?= base_url('admin/product-attributes?tab=brand') ?>" target="_blank">Manage</a></small>
                        </label>
                        <?= _attr_select('brand', $brands, !empty($_POST['brand']) ? $_POST['brand'] : '') ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Fabric Category
                            <small class="text-muted">— <a href="<?= base_url('admin/product-attributes?tab=fabric_category') ?>" target="_blank">Manage</a></small>
                        </label>
                        <?= _attr_select('fabric_category', $attr_fab_cats, !empty($_POST['fabric_category']) ? $_POST['fabric_category'] : '') ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Fabric Type
                            <small class="text-muted">— <a href="<?= base_url('admin/product-attributes?tab=fabric_type') ?>" target="_blank">Manage</a></small>
                        </label>
                        <?= _attr_select('fabric_type', $attr_fab_types, !empty($_POST['fabric_type']) ? $_POST['fabric_type'] : '') ?>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Fabric Composition <small class="text-muted">(e.g. 80% Cotton 20% Polyester)</small></label>
                        <input type="text" name="fabric_composition" class="form-control" placeholder="e.g. 80% Cotton 20% Polyester" value="<?= htmlspecialchars(!empty($_POST['fabric_composition']) ? $_POST['fabric_composition'] : '') ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if ($id > 0): ?>
    <!-- ── Parent / Child Variants Panel ─────────────────────────────────── -->
    <div class="panel panel-default" style="margin-top:24px;" id="vc-panel">
        <div class="panel-heading" style="background:#f0f4ff;border-color:#c5d0e8;">
            <strong><i class="fa fa-sitemap"></i> Product Variants (Parent / Child)</strong>
            <span class="text-muted small" style="margin-left:8px;">Amazon-style: link colour/style variants together so they appear as one product on the shop.</span>
        </div>
        <div class="panel-body">

            <?php if ($parent_id > 0): ?>
            <!-- This product IS a child -->
            <div class="alert alert-info" style="margin-bottom:14px;">
                <i class="fa fa-level-up"></i> This product is a <strong>child variant</strong> of
                <a href="<?= base_url('admin/publish/' . $parent_id) ?>" target="_blank"><strong>Product #<?= $parent_id ?></strong></a>.
                <button type="button" class="btn btn-xs btn-danger pull-right vc-unlink-self" data-child="<?= $id ?>" data-parent="<?= $parent_id ?>">
                    <i class="fa fa-unlink"></i> Unlink from parent
                </button>
            </div>
            <?php else: ?>

            <!-- This is a parent — show children -->
            <p class="text-muted small" style="margin-bottom:12px;">
                Children are separate product records linked to this one. On the shop, all variants appear together as colour/style options (like Amazon). Each child has its own image, stock, and price.
            </p>

            <!-- Children list -->
            <div id="vc-children-list">
                <?php if (!empty($children)): ?>
                <?php foreach ($children as $child): ?>
                <div class="vc-child-row" data-child-id="<?= $child['id'] ?>" style="display:flex;align-items:center;gap:10px;padding:8px 10px;border:1px solid #e4e6ea;border-radius:6px;margin-bottom:8px;background:#fafbfc;">
                    <?php
                    $cimg = base_url('attachments/no-image.png');
                    if (!empty($child['image']) && is_file('attachments/shop_images/'.$child['image'])) {
                        $cimg = base_url('attachments/shop_images/'.$child['image']);
                    }
                    ?>
                    <img src="<?= $cimg ?>" style="width:44px;height:44px;object-fit:cover;border-radius:4px;border:1px solid #ddd;flex-shrink:0;">
                    <div style="flex:1;min-width:0;">
                        <strong style="font-size:13px;"><?= htmlspecialchars($child['title']) ?></strong><br>
                        <span class="text-muted" style="font-size:11px;">
                            #<?= $child['id'] ?>
                            <?php if ($child['article_number']): ?> &middot; <?= htmlspecialchars($child['article_number']) ?><?php endif; ?>
                            <?php if ($child['color']): ?> &middot; <?= htmlspecialchars($child['color']) ?><?php endif; ?>
                            <?php if ($child['size_range']): ?> &middot; <?= htmlspecialchars($child['size_range']) ?><?php endif; ?>
                        </span>
                    </div>
                    <span class="label <?= $child['visibility'] ? 'label-success' : 'label-default' ?>" style="font-size:11px;"><?= $child['visibility'] ? 'Live' : 'Hidden' ?></span>
                    <a href="<?= base_url('admin/publish/'.$child['id']) ?>" class="btn btn-xs btn-default" title="Edit child"><i class="fa fa-pencil"></i></a>
                    <button type="button" class="btn btn-xs btn-danger vc-unlink" data-child="<?= $child['id'] ?>" title="Unlink"><i class="fa fa-unlink"></i></button>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
                <?php if (empty($children)): ?>
                <p class="text-muted small vc-no-children">No child variants linked yet.</p>
                <?php endif; ?>
            </div>

            <!-- Link existing product -->
            <div style="margin-top:14px;padding-top:12px;border-top:1px solid #eee;">
                <label style="font-size:13px;font-weight:600;">Link an existing product as a child variant</label>
                <div style="display:flex;gap:8px;align-items:flex-start;flex-wrap:wrap;margin-top:6px;">
                    <div style="position:relative;flex:1;min-width:200px;">
                        <input type="text" id="vc-search-input" class="form-control" placeholder="Search by name or article code…" autocomplete="off">
                        <div id="vc-search-results" style="display:none;position:absolute;top:100%;left:0;right:0;z-index:999;background:#fff;border:1px solid #ddd;border-radius:0 0 4px 4px;max-height:220px;overflow-y:auto;box-shadow:0 4px 12px rgba(0,0,0,.1);"></div>
                    </div>
                    <button type="button" id="vc-link-btn" class="btn btn-primary" disabled>
                        <i class="fa fa-link"></i> Link Selected
                    </button>
                </div>
                <div id="vc-selected-preview" style="display:none;margin-top:8px;padding:8px 10px;background:#eaf4fd;border:1px solid #b8d9f0;border-radius:6px;display:flex;align-items:center;gap:10px;">
                    <img id="vc-sel-img" src="" style="width:36px;height:36px;object-fit:cover;border-radius:4px;border:1px solid #ddd;">
                    <div>
                        <strong id="vc-sel-title" style="font-size:13px;"></strong><br>
                        <span id="vc-sel-meta" class="text-muted" style="font-size:11px;"></span>
                    </div>
                    <button type="button" id="vc-clear-sel" class="btn btn-xs btn-default pull-right" style="margin-left:auto;">✕ Clear</button>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </div>

    <style>
    .vc-child-row:hover { background:#f0f4ff !important; }
    #vc-search-results .vc-result-item { padding:8px 12px; cursor:pointer; display:flex; align-items:center; gap:8px; border-bottom:1px solid #f0f0f0; }
    #vc-search-results .vc-result-item:hover { background:#f5f7ff; }
    #vc-search-results .vc-result-item img { width:36px; height:36px; object-fit:cover; border-radius:3px; border:1px solid #ddd; flex-shrink:0; }
    #vc-search-results .vc-result-meta { font-size:11px; color:#888; }
    #vc-search-results .vc-result-title { font-size:13px; font-weight:600; }
    </style>

    <script>
    (function() {
        var PARENT_ID  = <?= (int)$id ?>;
        var linkUrl    = '<?= base_url("admin/linkChild") ?>';
        var unlinkUrl  = '<?= base_url("admin/unlinkChild") ?>';
        var searchUrl  = '<?= base_url("admin/searchProducts") ?>';
        var noImgUrl   = '<?= base_url("attachments/no-image.png") ?>';
        var baseImgUrl = '<?= base_url("attachments/shop_images/") ?>';

        var selectedChildId = null;

        function childRowHtml(c) {
            var img = c.image ? baseImgUrl + c.image : noImgUrl;
            var meta = '#' + c.id;
            if (c.article_number) meta += ' &middot; ' + c.article_number;
            if (c.color)          meta += ' &middot; ' + c.color;
            if (c.size_range)     meta += ' &middot; ' + c.size_range;
            var badge = c.visibility == 1
                ? '<span class="label label-success" style="font-size:11px;">Live</span>'
                : '<span class="label label-default" style="font-size:11px;">Hidden</span>';
            return '<div class="vc-child-row" data-child-id="' + c.id + '" style="display:flex;align-items:center;gap:10px;padding:8px 10px;border:1px solid #e4e6ea;border-radius:6px;margin-bottom:8px;background:#fafbfc;">'
                + '<img src="' + img + '" style="width:44px;height:44px;object-fit:cover;border-radius:4px;border:1px solid #ddd;flex-shrink:0;">'
                + '<div style="flex:1;min-width:0;"><strong style="font-size:13px;">' + c.title + '</strong><br>'
                + '<span class="text-muted" style="font-size:11px;">' + meta + '</span></div>'
                + badge
                + '<a href="<?= base_url("admin/publish/") ?>' + c.id + '" class="btn btn-xs btn-default" title="Edit"><i class="fa fa-pencil"></i></a>'
                + '<button type="button" class="btn btn-xs btn-danger vc-unlink" data-child="' + c.id + '" title="Unlink"><i class="fa fa-unlink"></i></button>'
                + '</div>';
        }

        function refreshList(children) {
            var list = document.getElementById('vc-children-list');
            if (!list) return;
            if (!children || children.length === 0) {
                list.innerHTML = '<p class="text-muted small vc-no-children">No child variants linked yet.</p>';
                return;
            }
            var html = '';
            children.forEach(function(c) { html += childRowHtml(c); });
            list.innerHTML = html;
        }

        // ── Unlink child ──
        document.addEventListener('click', function(e) {
            var btn = e.target.closest && e.target.closest('.vc-unlink');
            if (!btn) return;
            var childId = parseInt(btn.getAttribute('data-child'));
            if (!confirm('Unlink this product from the group?')) return;
            var fd = new FormData();
            fd.append('parent_id', PARENT_ID);
            fd.append('child_id', childId);
            var xhr = new XMLHttpRequest();
            xhr.open('POST', unlinkUrl, true);
            xhr.onload = function() {
                try { var r = JSON.parse(xhr.responseText); if (r.success) refreshList(r.children); }
                catch(ex) {}
            };
            xhr.send(fd);
        });

        // ── Unlink self (child page) ──
        var selfBtn = document.querySelector('.vc-unlink-self');
        if (selfBtn) {
            selfBtn.addEventListener('click', function() {
                if (!confirm('Unlink this product from its parent?')) return;
                var fd = new FormData();
                fd.append('parent_id', selfBtn.getAttribute('data-parent'));
                fd.append('child_id',  selfBtn.getAttribute('data-child'));
                var xhr = new XMLHttpRequest();
                xhr.open('POST', unlinkUrl, true);
                xhr.onload = function() {
                    try {
                        var r = JSON.parse(xhr.responseText);
                        if (r.success) { window.location.reload(); }
                    } catch(ex) {}
                };
                xhr.send(fd);
            });
        }

        // ── Search ──
        var searchInput   = document.getElementById('vc-search-input');
        var searchResults = document.getElementById('vc-search-results');
        var linkBtn       = document.getElementById('vc-link-btn');
        var selPreview    = document.getElementById('vc-selected-preview');
        var selImg        = document.getElementById('vc-sel-img');
        var selTitle      = document.getElementById('vc-sel-title');
        var selMeta       = document.getElementById('vc-sel-meta');
        var clearBtn      = document.getElementById('vc-clear-sel');

        if (!searchInput) return; // child page, no search UI

        var searchTimer;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimer);
            var q = searchInput.value.trim();
            if (q.length < 1) { searchResults.style.display = 'none'; return; }
            searchTimer = setTimeout(function() {
                var xhr = new XMLHttpRequest();
                xhr.open('GET', searchUrl + '?q=' + encodeURIComponent(q) + '&exclude=' + PARENT_ID, true);
                xhr.onload = function() {
                    try {
                        var items = JSON.parse(xhr.responseText);
                        if (!items.length) { searchResults.innerHTML = '<div style="padding:10px 12px;color:#888;font-size:13px;">No products found</div>'; searchResults.style.display = 'block'; return; }
                        var html = '';
                        items.forEach(function(p) {
                            var img = p.image ? baseImgUrl + p.image : noImgUrl;
                            var meta = '#' + p.id + (p.article_number ? ' · ' + p.article_number : '');
                            var already = p.parent_id > 0 ? ' <span style="color:#e67e22;font-size:10px;">(already a child)</span>' : '';
                            html += '<div class="vc-result-item" data-id="'+p.id+'" data-title="'+p.title+'" data-img="'+img+'" data-meta="'+meta+'">'
                                + '<img src="'+img+'">'
                                + '<div><div class="vc-result-title">'+p.title+already+'</div><div class="vc-result-meta">'+meta+'</div></div>'
                                + '</div>';
                        });
                        searchResults.innerHTML = html;
                        searchResults.style.display = 'block';
                    } catch(ex) {}
                };
                xhr.send();
            }, 300);
        });

        document.addEventListener('click', function(e) {
            var item = e.target.closest && e.target.closest('.vc-result-item');
            if (item) {
                selectedChildId = parseInt(item.getAttribute('data-id'));
                selImg.src       = item.getAttribute('data-img');
                selTitle.textContent = item.getAttribute('data-title');
                selMeta.textContent  = item.getAttribute('data-meta');
                selPreview.style.display = 'flex';
                searchResults.style.display = 'none';
                searchInput.value = '';
                linkBtn.disabled = false;
                return;
            }
            if (!e.target.closest('#vc-search-input') && !e.target.closest('#vc-search-results')) {
                searchResults.style.display = 'none';
            }
        });

        if (clearBtn) clearBtn.addEventListener('click', function() {
            selectedChildId = null;
            selPreview.style.display = 'none';
            linkBtn.disabled = true;
        });

        if (linkBtn) linkBtn.addEventListener('click', function() {
            if (!selectedChildId) return;
            linkBtn.disabled = true;
            linkBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Linking…';
            var fd = new FormData();
            fd.append('parent_id', PARENT_ID);
            fd.append('child_id',  selectedChildId);
            var xhr = new XMLHttpRequest();
            xhr.open('POST', linkUrl, true);
            xhr.onload = function() {
                try {
                    var r = JSON.parse(xhr.responseText);
                    if (r.success) {
                        refreshList(r.children);
                        selectedChildId = null;
                        selPreview.style.display = 'none';
                        linkBtn.innerHTML = '<i class="fa fa-link"></i> Link Selected';
                        linkBtn.disabled = true;
                        var noChildren = document.querySelector('.vc-no-children');
                        if (noChildren) noChildren.remove();
                    }
                } catch(ex) {
                    linkBtn.disabled = false;
                    linkBtn.innerHTML = '<i class="fa fa-link"></i> Link Selected';
                }
            };
            xhr.send(fd);
        });
    })();
    </script>
    <?php endif; ?>

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