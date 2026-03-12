<?php
$section_labels = [
    'best_sellers' => 'Best Sellers',
    'new_arrivals' => 'New Arrivals',
    'featured'     => 'Featured Products',
];
$section_icons = [
    'best_sellers' => 'fa-star',
    'new_arrivals' => 'fa-clock-o',
    'featured'     => 'fa-bookmark',
];
?>
<div id="home-sections-manager">
    <h1><i class="fa fa-home" aria-hidden="true"></i> Home Sections Manager</h1>
    <p class="text-muted">Manage which products appear in Best Sellers, New Arrivals, and Featured sections on the home page.</p>
    <hr>

    <div class="nav-tabs-wrapper">
        <ul class="nav nav-tabs" id="sectionTabs">
            <?php $first = true; foreach ($section_labels as $key => $label): ?>
                <li class="<?= $first ? 'active' : '' ?>">
                    <a href="#tab-<?= $key ?>" data-toggle="tab">
                        <i class="fa <?= $section_icons[$key] ?>"></i> <?= $label ?>
                        <span class="badge"><?= count($sections_data[$key]) ?></span>
                    </a>
                </li>
            <?php $first = false; endforeach; ?>
        </ul>
    </div>

    <div class="tab-content" style="margin-top:20px;">
    <?php $first = true; foreach ($section_labels as $key => $label): ?>
        <div class="tab-pane <?= $first ? 'active' : '' ?>" id="tab-<?= $key ?>">

            <!-- Settings bar -->
            <div class="panel panel-default">
                <div class="panel-heading"><strong><i class="fa fa-cog"></i> Display Settings</strong></div>
                <div class="panel-body">
                    <div class="form-inline">
                        <label>Max items to show on home page:</label>
                        <input type="number" class="form-control input-sm" id="limit-<?= $key ?>" value="<?= (int)$settings[$key] ?>" min="1" max="50" style="width:80px; margin:0 8px;">
                        <button class="btn btn-sm btn-primary save-limit-btn" data-section="<?= $key ?>">
                            <i class="fa fa-save"></i> Save
                        </button>
                        <span class="limit-msg text-success" id="limit-msg-<?= $key ?>" style="margin-left:8px; display:none;"><i class="fa fa-check"></i> Saved</span>
                    </div>
                </div>
            </div>

            <!-- Search & Add -->
            <div class="panel panel-default">
                <div class="panel-heading"><strong><i class="fa fa-plus-circle"></i> Add Product to <?= $label ?></strong></div>
                <div class="panel-body">
                    <div class="input-group" style="max-width:500px;">
                        <input type="text" class="form-control product-search-input" data-section="<?= $key ?>" placeholder="Search product by name..." autocomplete="off">
                        <span class="input-group-addon"><i class="fa fa-search"></i></span>
                    </div>
                    <div class="product-search-results list-group" data-section="<?= $key ?>" style="max-width:500px; position:relative; z-index:100;"></div>
                </div>
            </div>

            <!-- Current products -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong><i class="fa fa-list"></i> Products in <?= $label ?></strong>
                    <span class="badge pull-right section-count" id="count-<?= $key ?>"><?= count($sections_data[$key]) ?></span>
                </div>
                <div class="panel-body">
                    <?php if (empty($sections_data[$key])): ?>
                        <div class="alert alert-info section-empty-msg" id="empty-<?= $key ?>">No products added yet. Search above to add products.</div>
                    <?php else: ?>
                        <div class="alert alert-info section-empty-msg" id="empty-<?= $key ?>" style="display:none;">No products added yet. Search above to add products.</div>
                    <?php endif; ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="table-<?= $key ?>">
                            <thead>
                                <tr>
                                    <th style="width:60px;">Image</th>
                                    <th>Product Name</th>
                                    <th style="width:120px;">Price</th>
                                    <th style="width:80px;">Order</th>
                                    <th style="width:80px;" class="text-center">Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($sections_data[$key] as $item): ?>
                                <tr id="row-<?= (int)$item['hs_id'] ?>">
                                    <td><img src="<?= base_url('attachments/products/' . $item['image']) ?>" style="width:45px;height:45px;object-fit:cover;border-radius:4px;" onerror="this.onerror=null;this.src='<?= base_url('assets/imgs/products-img.png') ?>'"></td>
                                    <td><?= htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8') ?></td>
                                    <td>&#8377;<?= htmlspecialchars($item['price'], ENT_QUOTES, 'UTF-8') ?></td>
                                    <td><span class="text-muted"><?= (int)$item['sort_order'] ?></span></td>
                                    <td class="text-center">
                                        <button class="btn btn-danger btn-xs remove-product-btn" data-id="<?= (int)$item['hs_id'] ?>" data-section="<?= $key ?>">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    <?php $first = false; endforeach; ?>
    </div>
</div>

<style>
.product-search-results .list-group-item {
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 12px;
}
.product-search-results .list-group-item:hover { background: #f0f4ff; }
.product-search-results .list-group-item img { width:36px; height:36px; object-fit:cover; border-radius:3px; }
#home-sections-manager .nav-tabs { border-bottom: 2px solid #ddd; }
#home-sections-manager .nav-tabs > li.active > a { font-weight:bold; }
</style>

<script>
(function($){
    var baseUrl = '<?= base_url() ?>';
    var searchUrl    = baseUrl + 'admin/homesections/search_products';
    var addUrl       = baseUrl + 'admin/homesections/add_product';
    var removeUrl    = baseUrl + 'admin/homesections/remove_product';
    var limitUrl     = baseUrl + 'admin/homesections/update_limit';

    // Product search
    var searchTimers = {};
    $(document).on('keyup', '.product-search-input', function(){
        var $input   = $(this);
        var section  = $input.data('section');
        var $results = $('.product-search-results[data-section="' + section + '"]');
        clearTimeout(searchTimers[section]);
        var q = $.trim($input.val());
        if (q.length < 2) { $results.empty(); return; }
        searchTimers[section] = setTimeout(function(){
            $.post(searchUrl, {q: q}, function(data){
                $results.empty();
                if (!data || !data.length) {
                    $results.append('<div class="list-group-item text-muted">No products found</div>');
                    return;
                }
                $.each(data, function(i, p){
                    var imgSrc = baseUrl + 'attachments/products/' + p.image;
                    var $item = $('<div class="list-group-item add-product-item">'
                        + '<img src="' + imgSrc + '" onerror="this.onerror=null;this.src=\'' + baseUrl + 'assets/imgs/products-img.png\'">'
                        + '<span>' + $('<div>').text(p.title).html() + '</span>'
                        + '<span class="text-muted" style="margin-left:auto;">&#8377;' + p.price + '</span>'
                        + '</div>');
                    $item.data('product', p).data('section', section);
                    $results.append($item);
                });
            }, 'json');
        }, 300);
    });

    // Add product on click
    $(document).on('click', '.add-product-item', function(){
        var $item   = $(this);
        var section = $item.data('section');
        var p       = $item.data('product');
        $item.html('<i class="fa fa-spinner fa-spin"></i> Adding...').off('click');

        $.post(addUrl, {section: section, product_id: p.id}, function(res){
            if (res && res.success) {
                // Build new table row
                var imgSrc = baseUrl + 'attachments/products/' + p.image;
                // Reload to get real hs_id — simpler than tracking
                location.reload();
            } else {
                alert('Could not add product (may already be in this section).');
                location.reload();
            }
        }, 'json').fail(function(){ location.reload(); });
    });

    // Close search results when clicking elsewhere
    $(document).on('click', function(e){
        if (!$(e.target).closest('.product-search-input, .product-search-results').length) {
            $('.product-search-results').empty();
        }
    });

    // Remove product
    $(document).on('click', '.remove-product-btn', function(){
        var $btn    = $(this);
        var id      = $btn.data('id');
        var section = $btn.data('section');
        if (!confirm('Remove this product from the section?')) return;
        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
        $.post(removeUrl, {id: id}, function(res){
            if (res && res.success) {
                $('#row-' + id).fadeOut(300, function(){ $(this).remove(); });
                // Update count badge
                var $badge = $('#count-' + section);
                var cur = parseInt($badge.text()) || 1;
                $badge.text(cur - 1);
                if (cur - 1 <= 0) { $('#empty-' + section).show(); }
            }
        }, 'json');
    });

    // Save limit
    $(document).on('click', '.save-limit-btn', function(){
        var $btn    = $(this);
        var section = $btn.data('section');
        var limit   = parseInt($('#limit-' + section).val()) || 8;
        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving');
        $.post(limitUrl, {section: section, limit: limit}, function(res){
            $btn.prop('disabled', false).html('<i class="fa fa-save"></i> Save');
            if (res && res.success) {
                var $msg = $('#limit-msg-' + section);
                $msg.show();
                setTimeout(function(){ $msg.fadeOut(); }, 2000);
            }
        }, 'json');
    });

})(jQuery);
</script>
