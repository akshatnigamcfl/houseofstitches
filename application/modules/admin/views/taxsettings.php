<div class="col-sm-9 col-md-9 col-lg-10" style="padding-top:20px;">
    <h2>Tax Settings</h2>
    <hr>

    <?php if ($this->session->flashdata('tax_saved')) { ?>
        <div class="alert alert-success">
            <i class="fa fa-check"></i> Tax settings saved successfully.
        </div>
    <?php } ?>

    <form method="post">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>Tax Configuration</strong></div>
            <div class="panel-body">

                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="tax_enabled" value="1" <?= $tax_enabled ? 'checked' : '' ?>>
                            <strong>Enable Tax on Checkout</strong>
                        </label>
                        <p class="help-block">When disabled, no tax will be applied regardless of rules below.</p>
                    </div>
                </div>

                <div class="form-group">
                    <label><strong>Tax Type</strong></label>
                    <div class="radio">
                        <label>
                            <input type="radio" name="tax_type" value="exclusive" <?= $tax_type !== 'inclusive' ? 'checked' : '' ?>>
                            <strong>Exclusive</strong> — Tax is added on top of the order value (e.g. ₹897 + 12% tax = ₹1,004.64)
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="tax_type" value="inclusive" <?= $tax_type === 'inclusive' ? 'checked' : '' ?>>
                            <strong>Inclusive</strong> — Tax is already included in the order value (e.g. ₹897 already contains 12% tax = ₹96.11 embedded)
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label><strong>HSN Code</strong></label>
                    <input type="text" name="tax_hsn" class="form-control" style="max-width:220px;"
                           value="<?= htmlspecialchars($tax_hsn) ?>"
                           placeholder="e.g. 6111">
                    <p class="help-block">HSN (Harmonized System of Nomenclature) code printed on invoices. Leave blank to omit.</p>
                </div>

                <h4>Tax Rules <small>(applied based on order total)</small></h4>
                <p class="help-block">Add rules to define the tax rate for different order amounts. Rules are evaluated top-to-bottom; the first matching rule applies. Leave <em>Max Amount</em> blank for "and above".</p>

                <table class="table table-bordered" id="tax-rules-table">
                    <thead>
                        <tr>
                            <th>Min Amount (₹)</th>
                            <th>Max Amount (₹)</th>
                            <th>Tax Rate (%)</th>
                            <th style="width:60px;"></th>
                        </tr>
                    </thead>
                    <tbody id="tax-rules-body">
                        <?php if (!empty($tax_rules)) { ?>
                            <?php foreach ($tax_rules as $rule) { ?>
                                <tr>
                                    <td><input type="number" class="form-control" name="rule_min[]" value="<?= htmlspecialchars($rule['min']) ?>" min="0" step="0.01" required></td>
                                    <td><input type="number" class="form-control" name="rule_max[]" value="<?= ($rule['max'] !== null && $rule['max'] !== '') ? htmlspecialchars($rule['max']) : '' ?>" min="0" step="0.01" placeholder="No limit"></td>
                                    <td><input type="number" class="form-control" name="rule_rate[]" value="<?= htmlspecialchars($rule['rate']) ?>" min="0" max="100" step="0.01" required></td>
                                    <td><button type="button" class="btn btn-danger btn-sm remove-rule"><i class="fa fa-trash"></i></button></td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>

                <button type="button" class="btn btn-default btn-sm" id="add-rule-btn">
                    <i class="fa fa-plus"></i> Add Rule
                </button>

            </div>
        </div>

        <button type="submit" name="save_tax_settings" value="1" class="btn btn-primary">
            <i class="fa fa-save"></i> Save Settings
        </button>
    </form>
</div>

<template id="rule-row-tpl">
    <tr>
        <td><input type="number" class="form-control" name="rule_min[]" value="0" min="0" step="0.01" required></td>
        <td><input type="number" class="form-control" name="rule_max[]" value="" min="0" step="0.01" placeholder="No limit"></td>
        <td><input type="number" class="form-control" name="rule_rate[]" value="" min="0" max="100" step="0.01" required></td>
        <td><button type="button" class="btn btn-danger btn-sm remove-rule"><i class="fa fa-trash"></i></button></td>
    </tr>
</template>

<script>
document.getElementById('add-rule-btn').addEventListener('click', function () {
    var tpl = document.getElementById('rule-row-tpl').content.cloneNode(true);
    document.getElementById('tax-rules-body').appendChild(tpl);
});

document.getElementById('tax-rules-body').addEventListener('click', function (e) {
    if (e.target.closest('.remove-rule')) {
        e.target.closest('tr').remove();
    }
});
</script>
