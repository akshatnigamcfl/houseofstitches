<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

function pagination($url, $rowscount, $per_page, $segment = 3)
{  // echo  $this->uri->segment('2'); die;
    $ci = & get_instance();
    $ci->load->library('pagination');

    $config = array();
    $config["base_url"] = LANG_URL . '/' . $url;
    $config["total_rows"] = $rowscount;
    $config["per_page"] = $per_page;
    $config["uri_segment"] = $segment;
    $config['full_tag_open'] = '<nav><ul class="pagination justify-content-center align-items-center gap-3 mt-3">';
    $config['full_tag_close'] = '</ul></nav>';
    $config['num_tag_open'] = '<li class="page-item">';
    $config['num_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="active"><a class="page-link rounded-circle">';
    $config['cur_tag_close'] = '</a></li>';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    $config['first_link'] = lang('first');
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    $config['last_link'] = lang('last');
    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';
    $config['next_link'] = lang('next');
    $config['prev_link'] = lang('previous');
    $config['reuse_query_string'] = TRUE;
    $ci->pagination->initialize($config);
    return $ci->pagination->create_links();
}
