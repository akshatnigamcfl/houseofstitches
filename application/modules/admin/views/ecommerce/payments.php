<div id="payment-receipts">
    <h1><i class="fa fa-credit-card" aria-hidden="true"></i> Payment Receipts</h1>
    <hr>
    <?php if ($this->session->flashdata('result')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('result') ?></div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-striped custab">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Order</th>
                    <th>User</th>
                    <th>Phone</th>
                    <th>Amount</th>
                    <th>Mode</th>
                    <th>Reference</th>
                    <th>Receipt</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php if (empty($receipts)): ?>
                <tr><td colspan="11" class="text-center">No payment receipts yet.</td></tr>
            <?php else: foreach ($receipts as $r): ?>
                <tr>
                    <td><?= (int)$r->id ?></td>
                    <td><?= htmlspecialchars($r->order_ref ?? '#'.$r->order_id) ?></td>
                    <td><?= htmlspecialchars($r->user_name ?? '—') ?></td>
                    <td><?= htmlspecialchars($r->user_phone ?? '—') ?></td>
                    <td>₹ <?= number_format((float)$r->amount, 2) ?></td>
                    <td><?= htmlspecialchars($r->mode) ?></td>
                    <td><?= htmlspecialchars($r->reference) ?></td>
                    <td>
                        <?php if (!empty($r->receipt_file)): ?>
                            <a href="<?= base_url('assets/uploads/payment_receipts/' . $r->receipt_file) ?>" target="_blank" class="btn btn-xs btn-info">
                                <i class="fa fa-eye"></i> View
                            </a>
                        <?php else: ?>
                            <span class="text-muted">No file</span>
                        <?php endif; ?>
                    </td>
                    <td><?= date('d M Y', (int)$r->recorded_at) ?></td>
                    <td>
                        <?php if ($r->status === 'verified'): ?>
                            <span class="label label-success">Verified</span>
                        <?php elseif ($r->status === 'rejected'): ?>
                            <span class="label label-danger">Rejected</span>
                        <?php else: ?>
                            <span class="label label-warning">Pending</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($r->status === 'pending'): ?>
                        <button type="button" class="btn btn-xs btn-success" onclick="verifyReceipt(<?= (int)$r->id ?>)">
                            <i class="fa fa-check"></i> Verify
                        </button>
                        <button type="button" class="btn btn-xs btn-danger" onclick="rejectReceipt(<?= (int)$r->id ?>)">
                            <i class="fa fa-times"></i> Reject
                        </button>
                        <?php else: ?>
                            &mdash;
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function verifyReceipt(id) {
    if (!confirm('Mark this payment as verified and update the order?')) return;
    jQuery.post('<?= base_url('admin/verifyPayment') ?>', {id: id}, function(r) {
        try { r = typeof r === 'string' ? JSON.parse(r) : r; } catch(e){}
        if (r && r.success) location.reload();
        else alert('Failed. Try again.');
    });
}
function rejectReceipt(id) {
    if (!confirm('Reject this receipt?')) return;
    jQuery.post('<?= base_url('admin/rejectPayment') ?>', {id: id}, function(r) {
        try { r = typeof r === 'string' ? JSON.parse(r) : r; } catch(e){}
        if (r && r.success) location.reload();
        else alert('Failed. Try again.');
    });
}
</script>
