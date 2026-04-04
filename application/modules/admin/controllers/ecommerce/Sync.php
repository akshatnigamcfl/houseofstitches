<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sync extends ADMIN_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Sync_model');
        $this->load->model('Home_admin_model');
    }

    public function index()
    {
        $this->login_check();

        $data = [];
        $head = ['title' => 'Administration - DB2 Sync', 'description' => '', 'keywords' => ''];

        // Save new interval if submitted
        if ($this->input->post('sync_interval')) {
            $interval = max(1, (int)$this->input->post('sync_interval'));
            $this->Sync_model->setSyncInterval($interval);
            $this->session->set_flashdata('sync_msg', 'Sync interval updated to ' . $interval . ' minutes.');
            redirect('admin/db2-sync');
        }

        // Manual sync trigger
        if ($this->input->get('run') === '1') {
            set_time_limit(0);
            $result = $this->Sync_model->runSync();
            $this->session->set_flashdata('sync_msg',
                'Sync complete — Created: ' . $result['created'] .
                ', Updated: ' . $result['updated'] .
                ', Skipped: ' . $result['skipped']
            );
            redirect('admin/db2-sync');
        }

        // Clear all synced products then re-sync fresh
        if ($this->input->get('clear') === '1') {
            set_time_limit(0);
            $deleted = $this->Sync_model->clearSyncedProducts();
            $result  = $this->Sync_model->runSync();
            $this->session->set_flashdata('sync_msg',
                'Cleared ' . $deleted . ' synced products. Fresh sync complete — ' .
                'Created: ' . $result['created'] .
                ', Updated: ' . $result['updated'] .
                ', Skipped: ' . $result['skipped']
            );
            redirect('admin/db2-sync');
        }

        $lastSync  = $this->Sync_model->getLastSyncTime();
        $data['last_sync']        = $lastSync ? date('d M Y, h:i A', $lastSync) : 'Never';
        $data['next_sync']        = $lastSync
            ? date('d M Y, h:i A', $lastSync + ($this->Sync_model->getSyncInterval() * 60))
            : '—';
        $data['sync_interval']    = $this->Sync_model->getSyncInterval();
        $data['db2_item_count']   = $this->Sync_model->getDB2ItemCount();
        $data['pending_setup']    = $this->Sync_model->getPendingSetupCount();
        $data['last_stats']       = $this->Sync_model->getLastSyncStats();
        $data['sync_msg']         = $this->session->flashdata('sync_msg');

        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/sync', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Viewed DB2 sync dashboard');
    }
}
