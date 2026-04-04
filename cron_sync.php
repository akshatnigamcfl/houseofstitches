<?php
/**
 * DB2 Sync Cron Script
 * ---------------------
 * Run this every minute via crontab:
 *   * * * * * php /path/to/cron_sync.php >> /path/to/logs/sync.log 2>&1
 *
 * The script checks whether the configured interval has elapsed
 * before actually running a sync, so it is safe to call every minute.
 */

define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

// Bootstrap CodeIgniter without the HTTP layer
$_SERVER['HTTP_HOST']   = 'localhost';
$_SERVER['REQUEST_URI'] = '/';
define('STDIN', fopen('php://stdin', 'r'));

// Load CI environment
chdir(FCPATH);
require_once FCPATH . 'index.php';

// At this point CI is bootstrapped — get the instance
$CI =& get_instance();
$CI->load->model('Sync_model');

$interval    = $CI->Sync_model->getSyncInterval(); // minutes
$lastSync    = $CI->Sync_model->getLastSyncTime(); // unix timestamp or null
$nowTime     = time();
$elapsedMins = $lastSync ? (int)(($nowTime - $lastSync) / 60) : PHP_INT_MAX;

if ($elapsedMins < $interval) {
    echo '[' . date('Y-m-d H:i:s') . '] Skipped — next sync in ' . ($interval - $elapsedMins) . ' min(s).' . PHP_EOL;
    exit(0);
}

echo '[' . date('Y-m-d H:i:s') . '] Starting DB2 sync...' . PHP_EOL;

$result = $CI->Sync_model->runSync();

echo '[' . date('Y-m-d H:i:s') . '] Done — '
    . 'Created: ' . $result['created']
    . ', Updated: ' . $result['updated']
    . ', Skipped: ' . $result['skipped']
    . PHP_EOL;
