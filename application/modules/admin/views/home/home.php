<script src="<?= base_url('assets/highcharts/highcharts.js') ?>"></script>
<script src="<?= base_url('assets/highcharts/data.js') ?>"></script>
<script src="<?= base_url('assets/highcharts/drilldown.js') ?>"></script>
<h1><img src="<?= base_url('assets/imgs/admin-home.png') ?>" class="header-img" style="margin-top:-3px;"> Home</h1>
<hr>
<div class="home-page">
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li class="active"><i class="fa fa-dashboard"></i> Dashboard — Statistics Overview</li>
            </ol>
        </div>
    </div>

    <!-- Row 1: Key Stats -->
    <div class="row">
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="panel panel-yellow">
                <div class="panel-heading fast-view-panel">
                    <div class="row">
                        <div class="col-xs-3"><i class="fa fa-shopping-cart fa-3x"></i></div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?= $newOrdersCount ?></div>
                            <div>New Orders</div>
                        </div>
                    </div>
                </div>
                <a href="<?= base_url('admin/orders') ?>">
                    <div class="panel-footer"><span class="pull-left">View</span><span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span><div class="clearfix"></div></div>
                </a>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="panel panel-primary">
                <div class="panel-heading fast-view-panel">
                    <div class="row">
                        <div class="col-xs-3"><i class="fa fa-clock-o fa-3x"></i></div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?= $pendingOrders ?></div>
                            <div>Pending Orders</div>
                        </div>
                    </div>
                </div>
                <a href="<?= base_url('admin/orders?status=0') ?>">
                    <div class="panel-footer"><span class="pull-left">View</span><span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span><div class="clearfix"></div></div>
                </a>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="panel panel-green">
                <div class="panel-heading fast-view-panel">
                    <div class="row">
                        <div class="col-xs-3"><i class="fa fa-inr fa-3x"></i></div>
                        <div class="col-xs-9 text-right">
                            <div class="huge" style="font-size:18px;">₹ <?= number_format((float)$totalRevenue, 0) ?></div>
                            <div>Total Revenue</div>
                        </div>
                    </div>
                </div>
                <a href="<?= base_url('admin/orders') ?>">
                    <div class="panel-footer"><span class="pull-left">View</span><span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span><div class="clearfix"></div></div>
                </a>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="panel panel-primary">
                <div class="panel-heading fast-view-panel">
                    <div class="row">
                        <div class="col-xs-3"><i class="fa fa-users fa-3x"></i></div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?= $totalUsers ?></div>
                            <div>Active Users</div>
                        </div>
                    </div>
                </div>
                <a href="<?= base_url('admin/adminusers') ?>">
                    <div class="panel-footer"><span class="pull-left">View</span><span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span><div class="clearfix"></div></div>
                </a>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="panel panel-red">
                <div class="panel-heading fast-view-panel">
                    <div class="row">
                        <div class="col-xs-3"><i class="fa fa-exclamation-triangle fa-3x"></i></div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?= $lowQuantity ?></div>
                            <div>Low Stock (&lt;5)</div>
                        </div>
                    </div>
                </div>
                <a href="<?= base_url('admin/products?order_by=quantity-asc') ?>">
                    <div class="panel-footer"><span class="pull-left">View</span><span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span><div class="clearfix"></div></div>
                </a>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="panel" style="border-color:#e74c3c;">
                <div class="panel-heading fast-view-panel" style="background:#e74c3c;border-color:#e74c3c;">
                    <div class="row">
                        <div class="col-xs-3"><i class="fa fa-ban fa-3x"></i></div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?= $outOfStockCount ?></div>
                            <div>Out of Stock</div>
                        </div>
                    </div>
                </div>
                <a href="<?= base_url('admin/products?order_by=quantity-asc') ?>">
                    <div class="panel-footer"><span class="pull-left">Restock</span><span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span><div class="clearfix"></div></div>
                </a>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <div class="col-lg-8">
            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Monthly Orders</h3></div>
                <div class="panel-body">
                    <div id="container-by-month" style="min-width:310px;height:300px;margin:0 auto;"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Orders by Referrer</h3></div>
                <div class="panel-body">
                    <div id="container-by-referrer" style="min-width:310px;height:300px;margin:0 auto;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Restock Alerts -->
    <?php if (!empty($restockAlerts)): ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default" style="border-left:4px solid #e74c3c;">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-bell fa-fw" style="color:#e74c3c;"></i> Restock Alerts — Products with ≤10 units</h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped" style="margin:0;">
                            <thead>
                                <tr>
                                    <th>Item Code</th>
                                    <th>Product</th>
                                    <th style="width:120px;">Stock</th>
                                    <th style="width:100px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($restockAlerts as $p): ?>
                                <tr class="<?= $p['quantity'] == 0 ? 'danger' : ($p['quantity'] <= 5 ? 'warning' : '') ?>">
                                    <td><small><?= htmlspecialchars($p['article_number'] ?: '—') ?></small></td>
                                    <td><?= htmlspecialchars($p['title']) ?></td>
                                    <td>
                                        <?php if ($p['quantity'] == 0): ?>
                                            <span class="label label-danger">OUT OF STOCK</span>
                                        <?php elseif ($p['quantity'] <= 5): ?>
                                            <span class="label label-warning"><?= $p['quantity'] ?> left</span>
                                        <?php else: ?>
                                            <span class="label label-info"><?= $p['quantity'] ?> left</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><a href="<?= base_url('admin/publish/' . $p['id']) ?>" class="btn btn-xs btn-default">Edit</a></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Bottom Tables -->
    <div class="row">
        <!-- Most Ordered -->
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-fire fa-fw"></i> Most Ordered Products</h3></div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead><tr><th>Product</th><th>Orders</th><th>Units</th></tr></thead>
                            <tbody>
                                <?php if (!empty($mostOrdered)): ?>
                                    <?php foreach ($mostOrdered as $p): ?>
                                    <tr>
                                        <td style="max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                            <a href="<?= base_url('admin/publish/' . $p['id']) ?>" title="<?= htmlspecialchars($p['title']) ?>"><?= htmlspecialchars($p['title']) ?></a>
                                        </td>
                                        <td><?= $p['order_count'] ?></td>
                                        <td><?= $p['total_qty'] ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="3">No order data yet</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Type -->
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-long-arrow-right fa-fw"></i> Orders by Payment Type</h3></div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead><tr><th>Payment Type</th><th>Orders</th></tr></thead>
                            <tbody>
                                <?php if (!empty($ordersByPaymentType)): ?>
                                    <?php foreach ($ordersByPaymentType as $pt): ?>
                                    <tr><td><?= $pt['payment_type'] ?></td><td><?= $pt['num'] ?></td></tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="2">No orders</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activity Log -->
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-clock-o fa-fw"></i> Last Activity Log</h3></div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead><tr><th>User</th><th>Action</th></tr></thead>
                            <tbody>
                                <?php if ($activity->result()): ?>
                                    <?php foreach ($activity->result() as $action): ?>
                                    <tr>
                                        <td><i class="fa fa-user"></i> <b><?= $action->username ?></b></td>
                                        <td><?= $action->activity . ' — ' . date('d.m.Y H:i', $action->time) ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="2">No history</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-right"><a href="<?= base_url('admin/history') ?>">View All <i class="fa fa-arrow-circle-right"></i></a></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(function () {
    Highcharts.chart('container-by-referrer', {
        chart: { type: 'column' },
        title: { text: 'Orders by Source' },
        xAxis: { type: 'category' },
        yAxis: { title: { text: 'Orders' } },
        legend: { enabled: false },
        plotOptions: { series: { borderWidth: 0, dataLabels: { enabled: true, format: '{y}' } } },
        tooltip: { headerFormat: '<span>{series.name}</span><br>', pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>' },
        series: [{ name: 'Referrer', colorByPoint: true, data: [
            <?php foreach ($byReferral as $r): ?>
            { name: '<?= addslashes($r['referrer']) ?>', y: <?= $r['num'] ?> },
            <?php endforeach; ?>
        ]}]
    });

    Highcharts.chart('container-by-month', {
        title: { text: 'Monthly Orders' },
        xAxis: { categories: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'] },
        yAxis: { title: { text: 'Orders' }, plotLines: [{ value: 0, width: 1, color: '#808080' }] },
        tooltip: { valueSuffix: ' Orders' },
        legend: { layout: 'vertical', align: 'right', verticalAlign: 'middle', borderWidth: 0 },
        series: [
            <?php foreach ($ordersByMonth['years'] as $year): ?>
            { name: '<?= $year ?>', data: [<?= implode(',', $ordersByMonth['orders'][$year]) ?>] },
            <?php endforeach; ?>
        ]
    });
});
</script>
