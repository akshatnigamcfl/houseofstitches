<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Taxsettings extends ADMIN_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->login_check();

        if ($this->input->post('save_tax_settings')) {
            $tax_enabled = $this->input->post('tax_enabled') ? 1 : 0;

            $rules = [];
            $mins  = $this->input->post('rule_min');
            $maxs  = $this->input->post('rule_max');
            $rates = $this->input->post('rule_rate');

            if (is_array($mins)) {
                foreach ($mins as $i => $min) {
                    $rate = (float)$rates[$i];
                    if ($rate <= 0) continue;
                    $rules[] = [
                        'min'  => (float)$min,
                        'max'  => ($maxs[$i] !== '' && $maxs[$i] !== null) ? (float)$maxs[$i] : null,
                        'rate' => $rate,
                    ];
                }
            }

            $tax_type = $this->input->post('tax_type') === 'inclusive' ? 'inclusive' : 'exclusive';

            $tax_hsn = trim($this->input->post('tax_hsn') ?? '');
            $this->Home_admin_model->setValueStore('tax_enabled', $tax_enabled);
            $this->Home_admin_model->setValueStore('tax_type', $tax_type);
            $this->Home_admin_model->setValueStore('tax_rules', json_encode($rules));
            $this->Home_admin_model->setValueStore('tax_hsn', $tax_hsn);
            $this->session->set_flashdata('tax_saved', 1);
            redirect('admin/taxsettings');
        }

        $head = [
            'title'       => 'Administration - Tax Settings',
            'description' => '',
            'keywords'    => '',
        ];

        $data = [];
        $data['tax_enabled'] = (int)$this->Home_admin_model->getValueStore('tax_enabled');
        $data['tax_type']    = $this->Home_admin_model->getValueStore('tax_type') ?: 'exclusive';
        $rulesJson            = $this->Home_admin_model->getValueStore('tax_rules');
        $data['tax_rules']   = ($rulesJson && $rulesJson !== '[]') ? json_decode($rulesJson, true) : [];
        $data['tax_hsn']     = $this->Home_admin_model->getValueStore('tax_hsn') ?: '';

        $this->load->view('_parts/header', $head);
        $this->load->view('taxsettings', $data);
        $this->load->view('_parts/footer');
    }
}
