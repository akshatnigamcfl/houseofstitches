<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('calculate_cart_total')) {
    function calculate_cart_total($cart_items) {
        // Extract all prices and multiply by quantity in ONE LINE
        $total = array_sum(
            array_map(function($item) {
                return (float)$item['product_info']['price'] * (int)$item['product_quantity'];
            }, $cart_items)
        );
        
        return $total;
    }
}

if (!function_exists('get_cart_items_count')) {
    function get_cart_items_count($cart_items) {
        return count($cart_items);
    }
}
