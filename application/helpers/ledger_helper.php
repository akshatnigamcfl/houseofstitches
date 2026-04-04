<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Inserts a ledger entry (debit or credit) for a user.
 * Debit  = user owes money (e.g. new order)
 * Credit = payment received (reduces balance)
 *
 * @param int    $user_id
 * @param string $type        'debit' | 'credit'
 * @param float  $amount
 * @param string $description
 * @param int    $order_id    optional DB id from orders table
 * @param int    $date        optional unix timestamp (defaults to now)
 */
function add_ledger_entry($user_id, $type, $amount, $description, $order_id = null, $date = null)
{
    $CI =& get_instance();
    _ensure_ledger_table($CI);

    // Running balance: last entry for this user
    $last = $CI->db->select('balance')
                   ->where('user_id', (int)$user_id)
                   ->order_by('id', 'DESC')
                   ->limit(1)
                   ->get('ledger')->row();
    $prev = $last ? (float)$last->balance : 0.00;

    // Debit increases what the user owes; credit decreases it
    $new_balance = ($type === 'debit') ? $prev + (float)$amount : $prev - (float)$amount;

    $CI->db->insert('ledger', [
        'user_id'     => (int)$user_id,
        'order_id'    => $order_id ? (int)$order_id : null,
        'ref_no'      => 'LDG-' . date('Ymd') . '-' . rand(1000, 9999),
        'type'        => $type,
        'amount'      => round((float)$amount, 2),
        'description' => $description,
        'balance'     => round($new_balance, 2),
        'date'        => $date ? (int)$date : time(),
    ]);
}

function _ensure_ledger_table(&$CI)
{
    if (!$CI->db->table_exists('ledger')) {
        $CI->db->query("CREATE TABLE `ledger` (
            `id`          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `user_id`     INT UNSIGNED NOT NULL,
            `order_id`    INT UNSIGNED NULL DEFAULT NULL,
            `ref_no`      VARCHAR(30)  NOT NULL DEFAULT '',
            `type`        ENUM('credit','debit') NOT NULL,
            `amount`      DECIMAL(10,2) NOT NULL DEFAULT 0.00,
            `description` VARCHAR(255)  NOT NULL DEFAULT '',
            `balance`     DECIMAL(10,2) NOT NULL DEFAULT 0.00,
            `date`        INT UNSIGNED NOT NULL,
            INDEX `idx_user_id`  (`user_id`),
            INDEX `idx_order_id` (`order_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    }
}
