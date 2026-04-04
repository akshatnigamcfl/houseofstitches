<?php
$tabs = [
    'fabric'          => ['label' => 'Fabrics',           'icon' => 'fa-th-list',   'items' => $fabrics,           'delete_key' => 'delete_fabric',          'placeholder' => 'e.g. Single Jersey'],
    'fabric_category' => ['label' => 'Fabric Categories', 'icon' => 'fa-tags',      'items' => $fabric_categories, 'delete_key' => 'delete_fabric_category', 'placeholder' => 'e.g. Knit to Knit'],
    'fabric_type'     => ['label' => 'Fabric Types',      'icon' => 'fa-filter',    'items' => $fabric_types,      'delete_key' => 'delete_fabric_type',     'placeholder' => 'e.g. Lycra'],
    'brand'           => ['label' => 'Brands',            'icon' => 'fa-registered','items' => $brands,            'delete_key' => 'delete_brand',           'placeholder' => 'e.g. Spark'],
];
?>
<h1><i class="fa fa-list-ul" aria-hidden="true"></i> Product Attributes</h1>
<hr>

<ul class="nav nav-tabs" id="attr-tabs">
    <?php foreach ($tabs as $key => $tab): ?>
    <li class="<?= $active_tab === $key ? 'active' : '' ?>">
        <a href="#tab-<?= $key ?>" data-toggle="tab"><i class="fa <?= $tab['icon'] ?>"></i> <?= $tab['label'] ?></a>
    </li>
    <?php endforeach; ?>
</ul>

<div class="tab-content" style="padding-top:20px;">
    <?php foreach ($tabs as $key => $tab): ?>
    <div class="tab-pane <?= $active_tab === $key ? 'active' : '' ?>" id="tab-<?= $key ?>">
        <div class="row">
            <div class="col-sm-6 col-md-4">
                <button type="button" class="btn btn-default btn-sm" style="margin-bottom:12px;"
                    data-toggle="modal" data-target="#addModal-<?= $key ?>">
                    <i class="fa fa-plus"></i> Add <?= rtrim($tab['label'], 's') ?>
                </button>

                <?php if (!empty($tab['items'])): ?>
                <ul class="list-group">
                    <?php foreach ($tab['items'] as $item): ?>
                    <li class="list-group-item" style="display:flex;justify-content:space-between;align-items:center;">
                        <span><?= htmlspecialchars($item['name']) ?></span>
                        <a href="?<?= $tab['delete_key'] ?>=<?= (int)$item['id'] ?>&tab=<?= $key ?>"
                           class="btn btn-xs btn-danger confirm-delete"
                           onclick="return confirm('Delete this item?')">
                           <i class="fa fa-times"></i>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php else: ?>
                <div class="alert alert-info">No <?= strtolower($tab['label']) ?> added yet.</div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Add Modal -->
        <div class="modal fade" id="addModal-<?= $key ?>" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <form action="<?= base_url('admin/product-attributes') ?>" method="POST">
                        <input type="hidden" name="attr_type" value="<?= $key ?>">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                            <h4 class="modal-title">Add <?= $tab['label'] ?></h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control"
                                       placeholder="<?= htmlspecialchars($tab['placeholder']) ?>" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<script>
// Restore active tab after redirect
(function() {
    var hash = window.location.search.match(/[?&]tab=([^&]+)/);
    if (hash) {
        var t = hash[1];
        $('#attr-tabs a[href="#tab-' + t + '"]').tab('show');
    }
})();
</script>
