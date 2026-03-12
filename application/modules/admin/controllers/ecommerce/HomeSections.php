<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class HomeSections extends ADMIN_Controller
{
    private $allowed_sections = ['best_sellers', 'new_arrivals', 'featured'];

    public function __construct()
    {
        parent::__construct();
        $this->_ensure_tables();
    }

    private function _ensure_tables()
    {
        if (!$this->db->table_exists('home_sections')) {
            $this->db->query('CREATE TABLE home_sections (
                id INT AUTO_INCREMENT PRIMARY KEY,
                section VARCHAR(30) NOT NULL,
                product_id INT NOT NULL,
                sort_order INT DEFAULT 0,
                UNIQUE KEY unique_section_product (section, product_id)
            )');
        }
        if (!$this->db->table_exists('home_section_settings')) {
            $this->db->query('CREATE TABLE home_section_settings (
                section VARCHAR(30) PRIMARY KEY,
                item_limit INT DEFAULT 8
            )');
            $this->db->query("INSERT IGNORE INTO home_section_settings (section, item_limit) VALUES
                ('best_sellers', 8), ('new_arrivals', 8), ('featured', 8)");
        }
    }

    public function index()
    {
        $this->login_check();

        $data = ['sections_data' => [], 'settings' => []];

        foreach ($this->allowed_sections as $section) {
            $row = $this->db->get_where('home_section_settings', ['section' => $section])->row();
            $data['settings'][$section] = $row ? (int)$row->item_limit : 8;

            $data['sections_data'][$section] = $this->db->query("
                SELECT hs.id AS hs_id, hs.sort_order,
                       p.id, p.image, pt.title, pt.price
                FROM home_sections hs
                JOIN products p ON p.id = hs.product_id
                JOIN products_translations pt ON pt.for_id = p.id AND pt.abbr = '" . MY_LANGUAGE_ABBR . "'
                WHERE hs.section = '" . $this->db->escape_str($section) . "'
                ORDER BY hs.sort_order ASC, hs.id ASC
            ")->result_array();
        }

        $head = ['title' => 'Home Sections Manager', 'description' => '', 'keywords' => ''];
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/homesections', $data);
        $this->load->view('_parts/footer');
    }

    public function search_products()
    {
        $this->login_check();
        $q = trim($this->input->post('q'));
        if (!$q) { echo json_encode([]); return; }
        $q = $this->db->escape_like_str($q);
        $result = $this->db->query("
            SELECT p.id, p.image, pt.title, pt.price
            FROM products p
            JOIN products_translations pt ON pt.for_id = p.id AND pt.abbr = '" . MY_LANGUAGE_ABBR . "'
            WHERE pt.title LIKE '%{$q}%'
            AND p.visibility = 1
            ORDER BY p.id DESC
            LIMIT 15
        ")->result_array();
        echo json_encode($result);
    }

    public function add_product()
    {
        $this->login_check();
        $section    = $this->input->post('section');
        $product_id = (int)$this->input->post('product_id');

        if (!in_array($section, $this->allowed_sections) || !$product_id) {
            echo json_encode(['success' => false, 'msg' => 'Invalid input']); return;
        }

        $max = $this->db->query("SELECT COALESCE(MAX(sort_order),0) AS m FROM home_sections WHERE section = '" . $this->db->escape_str($section) . "'")->row();
        $sort = $max ? (int)$max->m + 1 : 1;

        $this->db->query("INSERT IGNORE INTO home_sections (section, product_id, sort_order)
            VALUES ('" . $this->db->escape_str($section) . "', {$product_id}, {$sort})");

        echo json_encode(['success' => true]);
    }

    public function remove_product()
    {
        $this->login_check();
        $id = (int)$this->input->post('id');
        if (!$id) { echo json_encode(['success' => false]); return; }
        $this->db->where('id', $id)->delete('home_sections');
        echo json_encode(['success' => true]);
    }

    public function update_limit()
    {
        $this->login_check();
        $section = $this->input->post('section');
        $limit   = (int)$this->input->post('limit');

        if (!in_array($section, $this->allowed_sections) || $limit < 1) {
            echo json_encode(['success' => false]); return;
        }

        $sec = $this->db->escape_str($section);
        $this->db->query("INSERT INTO home_section_settings (section, item_limit)
            VALUES ('{$sec}', {$limit})
            ON DUPLICATE KEY UPDATE item_limit = {$limit}");

        echo json_encode(['success' => true]);
    }
}
