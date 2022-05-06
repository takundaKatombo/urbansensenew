<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menus extends CI_Controller {


	public function __construct(){
		parent::__construct();
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
	        $config['total_rows'] = Menu::count('all');
	        $config['base_url'] = base_url('admin/Menus');
	        $page = (null !== $this->input->get('page')) ? $this->input->get('page') : 1;
	        $start_index = ($page - 1) * $config['per_page'];
	      
	 		
			$data = array(
				'menus' => Menu::all(array('limit'=>$config['per_page'], 'offset' => $start_index, 'order' => 'created_at desc', 'select' =>'id,title,status')),
				'title' => 'All Menus',
				'pagination' => $this->custom_pagination->create_backend_pagination($config)
			);

			$this->template->load('admin/admin_base','admin/menu/menu',$data);
		}
	}


	public function create(){
		if (!$this->ion_auth->logged_in()){
			redirect('admin/auth/login', 'refresh');
		} else {
			$this->form_validation->set_rules('title', 'Menu Title', 'required|max_length[100]|is_unique[menus.title]');
			if ($this->form_validation->run() == FALSE) {
			 	if (validation_errors()) {
	                 $this->session->set_flashdata("warning",validation_errors());
	            }
	            $this->data['title'] = 'Create New Menu';
				$this->template->load('admin/admin_base','admin/menu/add_update_menu',$this->data);
			} else {
				$data = array(
					'title'=> $this->input->post('title'),
					'slug'=> slug($this->input->post('title')),
					'user_id'=> $this->ion_auth->user()->row()->id,
					'status' =>$this->input->post('status')
				);
				$cat = Menu::create($data);
				$this->session->set_flashdata('success', 'Menu created successfully');
	        	redirect('admin/Menus');
			}
		}
	}


	public function update($id =null){
		if (!$this->ion_auth->logged_in()){
			redirect('admin/auth/login', 'refresh');
		} else {
			$menu = Menu::find_by_id($id);
			$this->form_validation->set_rules('title', 'Menu Title', 'required|max_length[100]');
			 if ($this->form_validation->run() == FALSE) {
			 	if (validation_errors()) {
	                 $this->session->set_flashdata("warning",validation_errors());
	            }
	            $this->data['title'] = 'Update Menu';
				$this->data['menu'] = $menu;
				$this->template->load('admin/admin_base','admin/menu/add_update_menu',$this->data);
			}  else {
				$data = array(
					'title'=> $this->input->post('title'),
					'slug'=> slug($this->input->post('title')),
					'user_id'=> $this->ion_auth->user()->row()->id,
					'status' =>$this->input->post('status')
				);
				$menu->update_attributes($data);
				$this->session->set_flashdata('success', 'Menu Updated Successfully');
				redirect('admin/menus');
			}
		}
	}

	public function status($id){
		if (!$this->ion_auth->logged_in()){
			redirect('admin/auth/login', 'refresh');
		} else {
			$chk = Menu::find_by_id($id);
			if($chk->status==1){
				$chk->update_attributes(array('status'=>0));
			} else{
				$chk->update_attributes(array('status'=>1));
			}

			$this->session->set_flashdata('success', 'Menu Status Changed Successfully');
				redirect('admin/menus');
		}
		
	}


	function search_menus(){
		if (!$this->ion_auth->logged_in()){
			redirect('admin/auth/login', 'refresh');
		} else {
				
			 $conditions = '';	
			$name = $this->input->get("name");
		        if ($name != '') {
		         $conditions =  "title LIKE '%" . $name . "%'";
	        } 
				
			$data = array(
				'menus' => Menu::all(array('conditions'=>array($conditions), 'order' => 'created_at desc', 'select' =>'id,title,status')),
				'title' => 'Menus',
			
			);

			$this->template->load('admin/admin_base','admin/menu/menu',$data);
		}
	}



}