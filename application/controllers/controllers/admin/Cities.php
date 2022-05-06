<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cities extends CI_Controller {


	public function __construct(){
		parent::__construct();
		$this->load->helper('slug');
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
	        $config['total_rows'] = City::count();
	        $config['base_url'] = base_url('admin/categories');
	        $page = (null !== $this->input->get('page')) ? $this->input->get('page') : 1;
	        $start_index = ($page - 1) * $config['per_page'];
	      
	 		
			$data = array(
				'cities' => City::all(array('limit'=>$config['per_page'], 'offset' => $start_index, 'order' => 'created_at desc', 'select' =>'id,title,status')),
				'title' => 'Cities',
				'pagination' => $this->custom_pagination->create_backend_pagination($config)
			);

			$this->template->load('admin/admin_base','admin/city/city_list',$data);
		}
	} 

	public function create(){
		if (!$this->ion_auth->logged_in()){
			redirect('admin/auth/login', 'refresh');
		} else {
			$this->form_validation->set_rules('title', 'City Title', 'required|max_length[100] |is_unique[cities.title]');
			if ($this->form_validation->run() == FALSE) {
			 	if (validation_errors()) {
	                 $this->session->set_flashdata("warning",validation_errors());
	            }
	            $this->data['title'] = 'Create New City';
				$this->template->load('admin/admin_base','admin/city/add_update_city',$this->data);
			} else {
				$data = array(
					'title'=> $this->input->post('title'),
					'slug'=> slug($this->input->post('title')),
					'user_id'=> $this->ion_auth->user()->row()->id,
					'status' =>$this->input->post('status')
				);
				$cat = City::create($data);
				$this->session->set_flashdata('success', 'City created successfully');
	        	redirect('admin/cities');
			}
		}
	}

	public function update($id =null){
		if (!$this->ion_auth->logged_in()){
			redirect('admin/auth/login', 'refresh');
		} else {
			$city = City::find_by_id($id);
			$this->form_validation->set_rules('title', 'City Title', 'required|max_length[100]');
			 if ($this->form_validation->run() == FALSE) {
			 	if (validation_errors()) {
	                 $this->session->set_flashdata("warning",validation_errors());
	            }
	            $this->data['title'] = 'Update City';
				$this->data['city'] = $city;
				$this->template->load('admin/admin_base','admin/city/add_update_city',$this->data);
			}  else {
				$data = array(
					'title'=> $this->input->post('title'),
					'slug'=> slug($this->input->post('title')),
					'user_id'=> $this->ion_auth->user()->row()->id,
					'status' =>$this->input->post('status')
				);
				$city->update_attributes($data);
				$this->session->set_flashdata('success', 'City Updated Successfully');
				redirect('admin/cities');
			}
		}
	}

	public function status($id){
		if (!$this->ion_auth->logged_in()){
			redirect('admin/auth/login', 'refresh');
		} else {
			$chk = City::find_by_id($id);
			if($chk->status==1){
				$chk->update_attributes(array('status'=>0));
			} else{
				$chk->update_attributes(array('status'=>1));
			}

			$this->session->set_flashdata('success', 'City Status Changed Successfully');
				redirect('admin/cities');
		}
		
	}


	function search_cities(){
		if (!$this->ion_auth->logged_in()){
			redirect('admin/auth/login', 'refresh');
		} else {
				
			$conditions = '';
			$status = $this->input->get("status");
	 		$name = $this->input->get("name");
	 		
	 		if($name != '' AND $status != ''){
	 			//print_r('expression00'); 
	 			$conditions =  "title LIKE '%" . $name . "%' AND status = ".$status;
	 		} else{
	 			if ($name != '') {
		         $conditions =  "title LIKE '%" . $name . "%'";
		        } 

		        if ($status != '') {
		          	$conditions .=  "status = ".$status;
		        
		        }
	 		}
				
			$data = array(
				'cities' => City::all(array('conditions'=>array($conditions), 'order' => 'created_at desc', 'select' =>'id,title,status')),
				'title' => 'Cities',
			
			);

			$this->template->load('admin/admin_base','admin/city/city_list',$data);
		}
	}

}