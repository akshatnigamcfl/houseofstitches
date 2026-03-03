<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('calculate_gst')) {
    /**
     * Calculate GST on amount
     * @param float $amount Base price
     * @param float $gst_rate GST percentage (5, 12, 18, 28)
     * @return array ['gst_amount', 'total_with_gst']
     */
    function calculate_gst($amount, $gst_rate = 5) { 
        $amount = (float) str_replace(',', '', $amount);
        $gst_amount = ($amount * $gst_rate) / 100;
        $total = $amount + $gst_amount;
        
        return array(
            'base_amount' => round($amount, 2),
            'gst_rate' => $gst_rate,
            'gst_amount' => round($gst_amount, 2),
            'total_with_gst' => round($total, 2)
        );
    }
}

if (!function_exists('calculate_cart_gst')) {
    /**
     * Calculate GST for entire cart
     * @param array $cart_items Your cart array
     * @param float $gst_rate GST rate
     * @return array Total breakdown
     */
    function calculate_cart_gst($cart_items, $gst_rate = 5) {
        $subtotal = 0;
        
        foreach ($cart_items as $item) {
            $subtotal += (float)$item['product_info']['price'] * (int)$item['product_quantity'];
        }
        
        return calculate_gst($subtotal, $gst_rate);
    }
}

if (!function_exists('get_gst_label')) {
    /**
     * Get GST label for display
     */
    function get_gst_label($gst_rate) {
        $labels = array(
            0 => 'No GST',
            5 => 'GST 5%',
            12 => 'GST 12%', 
            18 => 'GST 18%',
            28 => 'GST 28%'
        );
        return isset($labels[$gst_rate]) ? $labels[$gst_rate] : $gst_rate . '%';
    }
}
