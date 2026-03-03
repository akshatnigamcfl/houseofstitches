<?php
// PHP built-in server router for CodeIgniter
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Serve existing static files directly
if ($uri !== '/' && file_exists(__DIR__ . $uri)) {
    return false;
}

// Rewrite production URLs to localhost in HTML output
ob_start(function($buffer) {
    return str_replace('https://houseofstitches.in', 'http://localhost:8080', $buffer);
});

chdir(__DIR__);
require_once __DIR__ . '/index.php';

ob_end_flush();
