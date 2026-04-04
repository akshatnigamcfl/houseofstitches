<?php if ($sync_msg): ?>
<div class="alert alert-success"><?= htmlspecialchars($sync_msg) ?></div>
<?php endif; ?>

<h1><i class="fa fa-refresh" aria-hidden="true"></i> DB2 Sync</h1>
<p class="text-muted">Pulls items from <strong>SpangleDBnew</strong> (SQL Server) into the product catalogue.</p>
<hr>

<!-- Stat Cards -->
<div class="row" style="margin-bottom:20px;">
    <div class="col-sm-3">
        <div class="panel panel-default" style="border-left:4px solid #3498db;">
            <div class="panel-body text-center">
                <div style="font-size:28px;font-weight:700;color:#3498db;"><?= is_numeric($db2_item_count) ? number_format($db2_item_count) : $db2_item_count ?></div>
                <div class="text-muted small">Active Items in DB2</div>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="panel panel-default" style="border-left:4px solid #e67e22;">
            <div class="panel-body text-center">
                <div style="font-size:28px;font-weight:700;color:#e67e22;"><?= $pending_setup ?></div>
                <div class="text-muted small">Awaiting Admin Setup</div>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="panel panel-default" style="border-left:4px solid #27ae60;">
            <div class="panel-body text-center">
                <div style="font-size:16px;font-weight:600;color:#27ae60;"><?= $last_sync ?></div>
                <div class="text-muted small">Last Sync</div>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="panel panel-default" style="border-left:4px solid #95a5a6;">
            <div class="panel-body text-center">
                <div style="font-size:16px;font-weight:600;color:#95a5a6;"><?= $next_sync ?></div>
                <div class="text-muted small">Next Scheduled Sync</div>
            </div>
        </div>
    </div>
</div>

<!-- Last Sync Results -->
<?php if ($last_stats): ?>
<div class="panel panel-default">
    <div class="panel-heading"><strong>Last Sync Results</strong></div>
    <div class="panel-body">
        <span class="label label-success" style="font-size:13px;padding:5px 10px;margin-right:8px;">
            Created: <?= $last_stats['created'] ?>
        </span>
        <span class="label label-primary" style="font-size:13px;padding:5px 10px;margin-right:8px;">
            Updated (inventory): <?= $last_stats['updated'] ?>
        </span>
        <span class="label label-default" style="font-size:13px;padding:5px 10px;">
            Skipped: <?= $last_stats['skipped'] ?>
        </span>
    </div>
</div>
<?php endif; ?>

<div class="row">
    <!-- Manual Sync -->
    <div class="col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>Manual Sync</strong></div>
            <div class="panel-body">
                <p class="text-muted small">Runs immediately regardless of the scheduled interval.</p>
                <a href="<?= base_url('admin/db2-sync?run=1') ?>"
                   class="btn btn-primary"
                   onclick="this.innerHTML='<i class=\'fa fa-spinner fa-spin\'></i> Syncing...'; this.style.pointerEvents='none';">
                    <i class="fa fa-refresh"></i> Sync Now
                </a>
                &nbsp;
                <a href="<?= base_url('admin/db2-sync?clear=1') ?>"
                   class="btn btn-danger"
                   onclick="if(!confirm('This will DELETE all synced products and re-import fresh from DB2. Manually uploaded products are NOT affected. Continue?')) return false; this.innerHTML='<i class=\'fa fa-spinner fa-spin\'></i> Clearing...'; this.style.pointerEvents='none';">
                    <i class="fa fa-trash"></i> Clear &amp; Re-sync
                </a>
                <p class="text-muted small" style="margin-top:8px;">
                    <strong>Clear &amp; Re-sync</strong> deletes all DB2-imported products and does a fresh import with correct barcodes and active stock only.
                </p>
            </div>
        </div>
    </div>

    <!-- Interval Setting -->
    <div class="col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>Sync Interval</strong></div>
            <div class="panel-body">
                <form method="POST" action="<?= base_url('admin/db2-sync') ?>">
                    <div class="input-group" style="max-width:220px;">
                        <input type="number" name="sync_interval" class="form-control"
                               value="<?= $sync_interval ?>" min="1" max="1440">
                        <span class="input-group-addon">minutes</span>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-default">Save Interval</button>
                </form>
                <p class="text-muted small" style="margin-top:8px;">
                    System cron must run <code>cron_sync.php</code> every minute.<br>
                    The script will only sync when the interval has elapsed.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Cron Setup Instructions -->
<div class="panel panel-default">
    <div class="panel-heading"><strong>Cron Job Setup</strong></div>
    <div class="panel-body">
        <p class="text-muted small">Add this to your server's crontab (<code>crontab -e</code>):</p>
        <pre style="background:#f5f5f5;padding:10px;border-radius:4px;">* * * * * php <?= FCPATH ?>cron_sync.php >> <?= FCPATH ?>logs/sync.log 2>&1</pre>
        <p class="text-muted small" style="margin-top:8px;">
            The script checks internally whether the configured interval has elapsed before running a sync.
        </p>
    </div>
</div>

<!-- Pending Setup Notice -->
<?php if ($pending_setup > 0): ?>
<div class="alert alert-warning">
    <strong><?= $pending_setup ?> product(s)</strong> synced from DB2 are awaiting setup.
    <a href="<?= base_url('admin/products?itm_synced=1') ?>" class="btn btn-xs btn-warning" style="margin-left:10px;">
        View Pending
    </a>
</div>
<?php endif; ?>
