<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contacts extends CI_Controller {


	public function __construct(){
		parent::__construct();
		//$this->load->helper('slug');
		if($this->ion_auth->is_admin()){
			 return true;
		} else{
			$this->session->set_flashdata("warning",'You must be an administrator to view this page.');
			redirect(base_url('logout'));
		}
		
	}

	public function index(){
		if (!$this->ion_auth->logged_in()){
			redirect('admin/auth/login', 'refresh');
		} else {
			$config['per_page'] = 20;
	        $config['total_rows'] = Contact::count();
	        $config['base_url'] = base_url('admin/Contacts');
	        $page = (null !== $this->input->get('page')) ? $this->input->get('page') : 1;
	        $start_index = ($page - 1) * $config['per_page'];
	      
	 		
			$data = array(
				'contacts' => Contact::find('all',array('limit'=>$config['per_page'], 'offset' => $start_index, 'order' => 'created_at desc')),
				'title' => 'Customer Query',
				'pagination' => $this->custom_pagination->create_backend_pagination($config)
			);
			//echo '<pre>'; print_r($data); die;

			$this->template->load('admin/admin_base','admin/customer_query/customer_query',$data);
		}
	}
}