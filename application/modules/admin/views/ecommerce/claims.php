<h2><i class="fa fa-file-text-o" aria-hidden="true"></i> Claims</h2>
<hr>

<?php
$status_map = [
    'pending'  => ['label' => 'Pending',  'class' => 'warning'],
    'approved' => ['label' => 'Approved', 'class' => 'info'],
    'rejected' => ['label' => 'Rejected', 'class' => 'danger'],
    'paid'     => ['label' => 'Paid',     'class' => 'success'],
];
?>

<!-- Stats row -->
<div class="row mb-3">
    <?php
    $counts = ['pending' => 0, 'approved' => 0, 'rejected' => 0, 'paid' => 0];
    $total_amount = 0;
    foreach ($claims as $c) {
        $counts[$c['status']] = ($counts[$c['status']] ?? 0) + 1;
        $total_amount += (float)$c['amount'];
    }
    ?>
    <div class="col-sm-3"><div class="panel panel-warning"><div class="panel-heading"><strong><?= $counts['pending'] ?></strong> Pending</div></div></div>
    <div class="col-sm-3"><div class="panel panel-info"><div class="panel-heading"><strong><?= $counts['approved'] ?></strong> Approved</div></div></div>
    <div class="col-sm-3"><div class="panel panel-success"><div class="panel-heading"><strong><?= $counts['paid'] ?></strong> Paid</div></div></div>
    <div class="col-sm-3"><div class="panel panel-default"><div class="panel-heading"><strong>₹<?= number_format($total_amount, 2) ?></strong> Total Value</div></div></div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">All Claims</div>
    <div class="panel-body table-responsive" style="padding:0;">
        <table class="table table-hover table-striped" id="claims-table">
            <thead>
                <tr>
                    <th>Claim #</th>
                    <th>User</th>
                    <th>Type</th>
                    <th>Order Ref</th>
                    <th>Amount (₹)</th>
                    <th>Submitted</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($claims)): ?>
                <tr><td colspan="8" class="text-center text-muted">No claims submitted yet.</td></tr>
                <?php else: foreach ($claims as $c):
                    $st = $status_map[$c['status']] ?? ['label' => ucfirst($c['status']), 'class' => 'default'];
                ?>
                <tr>
                    <td><strong><?= htmlspecialchars($c['claim_no']) ?></strong></td>
                    <td>
                        <?= htmlspecialchars($c['user_company'] ?: $c['user_name']) ?>
                        <?php if ($c['user_phone']): ?><br><small class="text-muted"><?= htmlspecialchars($c['user_phone']) ?></small><?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($c['type']) ?></td>
                    <td><?= $c['order_ref'] ? '#' . htmlspecialchars($c['order_ref']) : '—' ?></td>
                    <td>₹<?= number_format((float)$c['amount'], 2) ?></td>
                    <td><?= date('d M Y', $c['created_at']) ?></td>
                    <td><span class="label label-<?= $st['class'] ?>"><?= $st['label'] ?></span></td>
                    <td>
                        <button class="btn btn-xs btn-default" onclick="openClaimModal(<?= (int)$c['id'] ?>, '<?= htmlspecialchars($c['claim_no']) ?>', '<?= htmlspecialchars(addslashes($c['type'])) ?>', <?= (float)$c['amount'] ?>, '<?= htmlspecialchars(addslashes($c['description'] ?? '')) ?>', '<?= $c['status'] ?>', '<?= htmlspecialchars(addslashes($c['admin_remark'] ?? '')) ?>')">
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
<div class="modal fade" id="claimModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Update Claim — <span id="modal-claim-no"></span></h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="modal-claim-id">
                <div class="form-group">
                    <label>Type</label>
                    <p id="modal-claim-type" class="form-control-static"></p>
                </div>
                <div class="form-group">
                    <label>Amount</label>
                    <p id="modal-claim-amount" class="form-control-static"></p>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <p id="modal-claim-desc" class="form-control-static text-muted"></p>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" id="modal-claim-status">
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                        <option value="paid">Paid</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Admin Remark (optional)</label>
                    <textarea class="form-control" id="modal-claim-remark" rows="3" placeholder="Leave a note for the user..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="modal-save-btn">Save</button>
            </div>
        </div>
    </div>
</div>

<script>
function openClaimModal(id, claimNo, type, amount, desc, status, remark) {
    document.getElementById('modal-claim-id').value     = id;
    document.getElementById('modal-claim-no').textContent     = claimNo;
    document.getElementById('modal-claim-type').textContent   = type;
    document.getElementById('modal-claim-amount').textContent = '₹' + parseFloat(amount).toLocaleString('en-IN', {minimumFractionDigits: 2});
    document.getElementById('modal-claim-desc').textContent   = desc || '—';
    document.getElementById('modal-claim-status').value       = status;
    document.getElementById('modal-claim-remark').value       = remark || '';
    $('#claimModal').modal('show');
}

document.getElementById('modal-save-btn').addEventListener('click', function() {
    var btn    = this;
    var id     = document.getElementById('modal-claim-id').value;
    var status = document.getElementById('modal-claim-status').value;
    var remark = document.getElementById('modal-claim-remark').value;
    var amount = document.getElementById('modal-claim-amount').textContent;

    if (status === 'paid') {
        if (!confirm('Mark this claim as Paid?\n\nThis will create a credit ledger entry of ' + amount + ' for the user. This action cannot be undone.')) {
            return;
        }
    }

    btn.disabled = true;
    btn.textContent = 'Saving...';

    $.post('<?= base_url('admin/claims/updateStatus') ?>', {id: id, status: status, remark: remark}, function(res) {
        btn.disabled = false;
        btn.textContent = 'Save';
        if (res && res.success) {
            $('#claimModal').modal('hide');
            location.reload();
        } else {
            alert(res.error || 'Error saving.');
        }
    }, 'json').fail(function() {
        btn.disabled = false;
        btn.textContent = 'Save';
        alert('Request failed.');
    });
});
</script>
