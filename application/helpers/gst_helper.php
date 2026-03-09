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

if (!function_exists('get_applicable_tax_rate')) {
    /**
     * Look up the configured tax rate for a given order amount.
     * Returns 0 if tax is disabled or no rule matches.
     *
     * @param  float|string $amount  Order total (commas allowed)
     * @return float                 Tax rate in percent (e.g. 5, 12)
     */
    function get_applicable_tax_rate($amount) {
        $CI =& get_instance();

        $tax_enabled = $CI->db->query("SELECT value FROM value_store WHERE thekey = 'tax_enabled' LIMIT 1")->row_array();
        if (empty($tax_enabled) || (int)$tax_enabled['value'] !== 1) {
            return 0;
        }

        $rules_row = $CI->db->query("SELECT value FROM value_store WHERE thekey = 'tax_rules' LIMIT 1")->row_array();
        if (empty($rules_row) || empty($rules_row['value'])) {
            return 0;
        }

        $rules  = json_decode($rules_row['value'], true);
        $amount = (float)str_replace(',', '', $amount);

        foreach ($rules as $rule) {
            $min = (float)$rule['min'];
            $max = (isset($rule['max']) && $rule['max'] !== null && $rule['max'] !== '') ? (float)$rule['max'] : null;
            if ($amount >= $min && ($max === null || $amount <= $max)) {
                return (float)$rule['rate'];
            }
        }

        return 0;
    }
}

if (!function_exists('get_tax_breakdown')) {
    /**
     * Returns a full tax breakdown for a given order amount, respecting
     * the admin's tax_enabled, tax_type (inclusive/exclusive), and tax_rules settings.
     *
     * Exclusive: tax added on top  → total = amount + tax
     * Inclusive: tax baked in      → total = amount, tax extracted from inside
     *
     * @param  float|string $amount  Cart total (commas allowed)
     * @return array {enabled, rate, type, tax_amount, total}
     */
    function get_tax_breakdown($amount) {
        $CI     =& get_instance();
        $amount = (float)str_replace(',', '', $amount);

        $tax_enabled_row = $CI->db->query("SELECT value FROM value_store WHERE thekey = 'tax_enabled' LIMIT 1")->row_array();
        if (empty($tax_enabled_row) || (int)$tax_enabled_row['value'] !== 1) {
            return ['enabled' => false, 'rate' => 0, 'type' => 'exclusive', 'base' => $amount, 'tax_amount' => 0.00, 'total' => $amount];
        }

        $type_row = $CI->db->query("SELECT value FROM value_store WHERE thekey = 'tax_type' LIMIT 1")->row_array();
        $type     = (!empty($type_row) && $type_row['value'] === 'inclusive') ? 'inclusive' : 'exclusive';

        $rate = get_applicable_tax_rate($amount);

        if ($rate <= 0) {
            return ['enabled' => true, 'rate' => 0, 'type' => $type, 'base' => $amount, 'tax_amount' => 0.00, 'total' => $amount];
        }

        if ($type === 'inclusive') {
            // Tax is baked into the price
            // base (pre-tax) = amount * 100 / (100 + rate)
            // tax  = amount - base
            $base       = $amount * 100 / (100 + $rate);
            $tax_amount = $amount - $base;
            $total      = $amount;
        } else {
            // Tax added on top
            $base       = $amount;
            $tax_amount = $amount * $rate / 100;
            $total      = $amount + $tax_amount;
        }

        return [
            'enabled'    => true,
            'rate'       => $rate,
            'type'       => $type,
            'base'       => round($base, 2),
            'tax_amount' => round($tax_amount, 2),
            'total'      => round($total, 2),
        ];
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
