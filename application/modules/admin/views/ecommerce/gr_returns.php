<h2><i class="fa fa-undo" aria-hidden="true"></i> GR Returns</h2>
<hr>

<?php
$status_map = [
    'pending'   => ['label' => 'Pending',   'class' => 'warning'],
    'approved'  => ['label' => 'Approved',  'class' => 'info'],
    'rejected'  => ['label' => 'Rejected',  'class' => 'danger'],
    'processed' => ['label' => 'Processed', 'class' => 'success'],
];
$counts = ['pending' => 0, 'approved' => 0, 'rejected' => 0, 'processed' => 0];
foreach ($gr_requests as $g) { if (isset($counts[$g['status']])) $counts[$g['status']]++; }
?>

<!-- Stats -->
<div class="row mb-3">
    <div class="col-sm-3"><div class="panel panel-warning"><div class="panel-heading"><strong><?= $counts['pending'] ?></strong> Pending</div></div></div>
    <div class="col-sm-3"><div class="panel panel-info"><div class="panel-heading"><strong><?= $counts['approved'] ?></strong> Approved</div></div></div>
    <div class="col-sm-3"><div class="panel panel-success"><div class="panel-heading"><strong><?= $counts['processed'] ?></strong> Processed</div></div></div>
    <div class="col-sm-3"><div class="panel panel-danger"><div class="panel-heading"><strong><?= $counts['rejected'] ?></strong> Rejected</div></div></div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">All GR Requests</div>
    <div class="panel-body table-responsive" style="padding:0;">
        <table class="table table-hover table-striped" id="gr-table">
            <thead>
                <tr>
                    <th>GR #</th>
                    <th>Order #</th>
                    <th>Submitted By</th>
                    <th>Retailer</th>
                    <th>Return Type</th>
                    <th>Items</th>
                    <th>Date</th>
                    <th>Proof</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($gr_requests)): ?>
                <tr><td colspan="10" class="text-center text-muted">No GR requests submitted yet.</td></tr>
                <?php else: foreach ($gr_requests as $g):
                    $st = $status_map[$g['status']] ?? ['label' => ucfirst($g['status']), 'class' => 'default'];
                    $proofFiles = $g['proof_files'] ? array_filter(explode(',', $g['proof_files'])) : [];
                ?>
                <tr>
                    <td><strong><?= htmlspecialchars($g['gr_no']) ?></strong></td>
                    <td>#<?= htmlspecialchars($g['order_no']) ?></td>
                    <td>
                        <?= htmlspecialchars($g['submitter_company'] ?: $g['submitter_name']) ?>
                        <?php if ($g['submitter_phone']): ?>
                        <br><small class="text-muted"><?= htmlspecialchars($g['submitter_phone']) ?></small>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($g['retailer_company'] ?: $g['retailer_name']) ?></td>
                    <td><?= htmlspecialchars($g['return_type']) ?></td>
                    <td style="max-width:200px;white-space:pre-wrap;font-size:12px;"><?= htmlspecialchars($g['items']) ?></td>
                    <td><?= date('d M Y', (int)$g['created_at']) ?></td>
                    <td>
                        <?php if (!empty($proofFiles)): ?>
                        <?php foreach ($proofFiles as $pf): $ext = strtolower(pathinfo($pf, PATHINFO_EXTENSION)); ?>
                            <?php if (in_array($ext, ['jpg','jpeg','png','webp'])): ?>
                            <a href="<?= base_url('attachments/gr_proofs/' . $pf) ?>" target="_blank">
                                <img src="<?= base_url('attachments/gr_proofs/' . $pf) ?>" style="width:40px;height:40px;object-fit:cover;border-radius:3px;border:1px solid #ddd;">
                            </a>
                            <?php else: ?>
                            <a href="<?= base_url('attachments/gr_proofs/' . $pf) ?>" target="_blank" class="btn btn-xs btn-default"><i class="fa fa-file"></i> File</a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <span class="text-muted">—</span>
                        <?php endif; ?>
                    </td>
                    <td><span class="label label-<?= $st['class'] ?>"><?= $st['label'] ?></span></td>
                    <td>
                        <button class="btn btn-xs btn-default" onclick="openGrModal(
                            <?= (int)$g['id'] ?>,
                            '<?= htmlspecialchars($g['gr_no']) ?>',
                            '<?= htmlspecialchars(addslashes($g['return_type'])) ?>',
                            '<?= htmlspecialchars(addslashes($g['items'])) ?>',
                            '<?= htmlspecialchars(addslashes($g['remark'] ?? '')) ?>',
                            '<?= $g['status'] ?>',
                            '<?= htmlspecialchars(addslashes($g['admin_remark'] ?? '')) ?>'
                        )">
                            <i class="fa fa-pencil"></i> Update
                        </button>
                    </td>
                </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Update Status Modal -->
<div class="modal fade" id="grModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Update GR — <span id="modal-gr-no"></span></h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="modal-gr-id">
                <div class="form-group">
                    <label>Return Type</label>
                    <p id="modal-gr-type" class="form-control-static"></p>
                </div>
                <div class="form-group">
                    <label>Items</label>
                    <p id="modal-gr-items" class="form-control-static text-muted" style="white-space:pre-wrap;"></p>
                </div>
                <div class="form-group">
                    <label>Remark from Submitter</label>
                    <p id="modal-gr-remark" class="form-control-static text-muted"></p>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" id="modal-gr-status" onchange="toggleCreditField()">
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                        <option value="processed">Processed (goods received)</option>
                    </select>
                </div>
                <div class="form-group" id="credit-amount-group" style="display:none;">
                    <label>Credit Amount (₹) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="modal-gr-credit" min="0" step="0.01" placeholder="Amount to credit back to the user's ledger">
                    <p class="help-block">This amount will be posted as a credit in the user's ledger.</p>
                </div>
                <div class="form-group">
                    <label>Admin Remark (optional)</label>
                    <textarea class="form-control" id="modal-gr-admin-remark" rows="3" placeholder="Leave a note for the submitter…"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="modal-gr-save">Save</button>
            </div>
        </div>
    </div>
</div>

<script>
function toggleCreditField() {
    var st = document.getElementById('modal-gr-status').value;
    document.getElementById('credit-amount-group').style.display = (st === 'processed') ? '' : 'none';
}

function openGrModal(id, grNo, type, items, remark, status, adminRemark) {
    document.getElementById('modal-gr-id').value               = id;
    document.getElementById('modal-gr-no').textContent         = grNo;
    document.getElementById('modal-gr-type').textContent       = type;
    document.getElementById('modal-gr-items').textContent      = items;
    document.getElementById('modal-gr-remark').textContent     = remark || '—';
    document.getElementById('modal-gr-status').value           = status;
    document.getElementById('modal-gr-admin-remark').value     = adminRemark || '';
    document.getElementById('modal-gr-credit').value           = '';
    toggleCreditField();
    $('#grModal').modal('show');
}

document.getElementById('modal-gr-save').addEventListener('click', function() {
    var btn    = this;
    var id     = document.getElementById('modal-gr-id').value;
    var status = document.getElementById('modal-gr-status').value;
    var remark = document.getElementById('modal-gr-admin-remark').value;
    var credit = document.getElementById('modal-gr-credit').value;

    if (status === 'processed' && (!credit || parseFloat(credit) <= 0)) {
        alert('Please enter a credit amount to post to the user\'s ledger.');
        return;
    }

    btn.disabled = true; btn.textContent = 'Saving…';
    $.post('<?= base_url('admin/gr_returns/updateStatus') ?>', {id: id, status: status, admin_remark: remark, credit_amount: credit}, function(res) {
        btn.disabled = false; btn.textContent = 'Save';
        if (res && res.success) { $('#grModal').modal('hide'); location.reload(); }
        else { alert(res.error || 'Error saving.'); }
    }, 'json').fail(function() {
        btn.disabled = false; btn.textContent = 'Save';
        alert('Request failed.');
    });
});
</script>
