<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Product_attributes_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->_ensureTables();
    }

    private function _ensureTables()
    {
        $tables = [
            'product_fabrics'           => 'CREATE TABLE IF NOT EXISTS `product_fabrics` (`id` INT UNSIGNED NOT NULL AUTO_INCREMENT, `name` VARCHAR(150) NOT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4',
            'product_fabric_categories' => 'CREATE TABLE IF NOT EXISTS `product_fabric_categories` (`id` INT UNSIGNED NOT NULL AUTO_INCREMENT, `name` VARCHAR(150) NOT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4',
            'product_fabric_types'      => 'CREATE TABLE IF NOT EXISTS `product_fabric_types` (`id` INT UNSIGNED NOT NULL AUTO_INCREMENT, `name` VARCHAR(150) NOT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4',
        ];
        foreach ($tables as $sql) {
            $this->db->query($sql);
        }
    }

    // ── Generic helpers ──────────────────────────────────────────────────────

    private function _getAll($table)
    {
        return $this->db->order_by('name', 'ASC')->get($table)->result_array();
    }

    private function _add($table, $name)
    {
        $name = trim($name);
        if ($name === '') return;
        if (!$this->db->insert($table, ['name' => $name])) {
            log_message('error', print_r($this->db->error(), true));
        }
    }

    private function _delete($table, $id)
    {
        if (!$this->db->where('id', (int)$id)->delete($table)) {
            log_message('error', print_r($this->db->error(), true));
        }
    }

    // ── Fabrics ──────────────────────────────────────────────────────────────

    public function getFabrics()           { return $this->_getAll('product_fabrics'); }
    public function addFabric($name)       { $this->_add('product_fabrics', $name); }
    public function deleteFabric($id)      { $this->_delete('product_fabrics', $id); }

    // ── Fabric Categories ────────────────────────────────────────────────────

    public function getFabricCategories()        { return $this->_getAll('product_fabric_categories'); }
    public function addFabricCategory($name)     { $this->_add('product_fabric_categories', $name); }
    public function deleteFabricCategory($id)    { $this->_delete('product_fabric_categories', $id); }

    // ── Fabric Types ─────────────────────────────────────────────────────────

    public function getFabricTypes()       { return $this->_getAll('product_fabric_types'); }
    public function addFabricType($name)   { $this->_add('product_fabric_types', $name); }
    public function deleteFabricType($id)  { $this->_delete('product_fabric_types', $id); }
}
