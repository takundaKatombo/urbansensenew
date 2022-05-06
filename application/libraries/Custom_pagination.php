<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pagination
 *
 * @author raakesh
 */
class Custom_pagination {
    //put your code here
    
    public $ci;
    public $page_config = array();
            
    function __construct() {
        $this->ci = & get_instance();
        $this->ci->load->library('pagination');
        
        
    }
    
    function create_backend_pagination($config = array()) {
        
        $this->page_config = $config;
        $this->page_config['reuse_query_string'] = TRUE;
        $this->page_config['full_tag_open'] = '<nav aria-label="Page navigation"><ul class="pagination justify-content-end">';
        $this->page_config['full_tag_close'] = '</ul></nav>';
        $this->page_config['next_link'] = 'Next >>';
        $this->page_config['next_tag_open'] = '<li class="page-item">';
        $this->page_config['next_tag_close'] = '</li>';
        $this->page_config['prev_link'] = '<< Prev';
        $this->page_config['prev_tag_open'] = '<li class="page-item">';
        $this->page_config['prev_tag_close'] = '</li>';
        $this->page_config['num_tag_open'] = '<li class="page-item">';
        $this->page_config['num_tag_close'] = '</li>';
        $this->page_config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $this->page_config['cur_tag_close'] = '</span></li>';
        $this->page_config['last_tag_open'] = '<li class="page-item">';
        $this->page_config['last_tag_close'] = '</li>';
        $this->page_config['first_tag_open'] = '<li class="page-item">';
        $this->page_config['first_tag_close'] = '</li>';
        $this->page_config['use_page_numbers'] = TRUE;
        $this->page_config['page_query_string'] = TRUE;
        $this->page_config['query_string_segment'] = 'page';
        $this->page_config['attributes'] = array("class" => "page-link");

        $this->ci->pagination->initialize($this->page_config);
        return $this->ci->pagination->create_links();
    }

    function create_frontend_pagination($config = array()) {
        
        $this->page_config = $config;
        $this->page_config['reuse_query_string'] = TRUE;
        $this->page_config['full_tag_open'] = '<nav aria-label="Page navigation"><ul class="pagination justify-content-end">';
        $this->page_config['full_tag_close'] = '</ul></nav>';
        $this->page_config['next_link'] = 'Next >>';
        $this->page_config['next_tag_open'] = '<li class="page-item">';
        $this->page_config['next_tag_close'] = '</li>';
        $this->page_config['prev_link'] = '<< Prev';
        $this->page_config['prev_tag_open'] = '<li class="page-item">';
        $this->page_config['prev_tag_close'] = '</li>';
        $this->page_config['num_tag_open'] = '<li class="page-item">';
        $this->page_config['num_tag_close'] = '</li>';
        $this->page_config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $this->page_config['cur_tag_close'] = '</span></li>';
        $this->page_config['last_tag_open'] = '<li class="page-item">';
        $this->page_config['last_tag_close'] = '</li>';
        $this->page_config['first_tag_open'] = '<li class="page-item">';
        $this->page_config['first_tag_close'] = '</li>';
        $this->page_config['use_page_numbers'] = TRUE;
        $this->page_config['page_query_string'] = TRUE;
        $this->page_config['query_string_segment'] = 'page';
        $this->page_config['attributes'] = array("class" => "page-link");

        $this->ci->pagination->initialize($this->page_config);
        return $this->ci->pagination->create_links();
    }
}
