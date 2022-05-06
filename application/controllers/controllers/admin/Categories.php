<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends CI_Controller {


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
	        $config['total_rows'] = Category::count();
	        $config['base_url'] = base_url('admin/categories');
	        $page = (null !== $this->input->get('page')) ? $this->input->get('page') : 1;
	        $start_index = ($page - 1) * $config['per_page'];
	      
	 		
			$data = array(
				'categories' => Category::all(array('limit'=>$config['per_page'], 'offset' => $start_index, 'order' => 'created_at desc', 'select' =>'id,title,status,image,make_default')),
				'title' => 'Category',
				'pagination' => $this->custom_pagination->create_backend_pagination($config)
			);

			$this->template->load('admin/admin_base','admin/category/category_list',$data);
		}
	}

	public function create(){ 
		if (!$this->ion_auth->logged_in()){
			redirect('admin/auth/login', 'refresh');
		} else {
			$this->form_validation->set_rules('title', 'Category Title', 'required|max_length[100] |is_unique[categories.title]');
			 if ($this->form_validation->run() == FALSE) {
			 	if (validation_errors()) {
	                 $this->session->set_flashdata("warning",validation_errors());
	            }
	            $this->data['title'] = 'Create New Category';
				$this->template->load('admin/admin_base','admin/category/add_update_category',$this->data);
			} else {
				$image = '';
				$this->load->library('Upload_file');
				$array = array('png','jpg','jpeg','gif');
				$filename= $_FILES["image"]["name"];
				$file_ext = pathinfo($filename,PATHINFO_EXTENSION);
				if(in_array($file_ext, $array )){ 
					if ($_FILES['image']['name']){ // if  image selected
						$image= $this->upload_file->optional_image_upload('image');
					}
				

					$data = array(
						'title'=> $this->input->post('title'),
						'slug'=> slug($this->input->post('title')),
						'user_id'=> $this->ion_auth->user()->row()->id,
						'status' =>$this->input->post('status'),
						'image' =>$image
					);
					$cat = Category::create($data);
					$this->session->set_flashdata('success', 'Category created successfully');
		        	redirect('admin/categories');

		        } else {
					$this->session->set_flashdata('warning', 'File format not allowed. Upload only png, jpg, jpeg and gif file');
					 $this->data['title'] = 'Create New Category';
					$this->template->load('admin/admin_base','admin/category/add_update_category',$this->data);
				}
			}
		}
	}


	public function update($id =null){
		if (!$this->ion_auth->logged_in()){
			redirect('admin/auth/login', 'refresh');
		} else {
			$category = Category::find_by_id($id);
			$this->form_validation->set_rules('title', 'Category Title', 'required|max_length[100]');
			 if ($this->form_validation->run() == FALSE) {
			 	if (validation_errors()) {
	                 $this->session->set_flashdata("warning",validation_errors());
	            }
	            $this->data['title'] = 'Update Category';
				$this->data['category'] = $category;
				$this->template->load('admin/admin_base','admin/category/add_update_category',$this->data);
			}  else {

				$this->load->library('Upload_file');

				$array = array('png','jpg','jpeg','gif');
				$filename= $_FILES["image"]["name"];
				$file_ext = pathinfo($filename,PATHINFO_EXTENSION);
				if(in_array($file_ext, $array )){ 
			
					if ($_FILES['image']['size'] != 0){ // if  image selected
						@unlink('./uploads/image/'.$category->image);
						$chk_image= $this->upload_file->optional_image_upload('image');

					}

					$image = @$chk_image ? $chk_image : $category->image;
					
					$data = array(
						'title'=> $this->input->post('title'),
						'slug'=> slug($this->input->post('title')),
						'user_id'=> $this->ion_auth->user()->row()->id,
						'status' =>$this->input->post('status'),
						'image' =>$image
					);
					$category->update_attributes($data);
					$this->session->set_flashdata('success', 'Category Updated Successfully');
					redirect('admin/categories');
				} else {
					$this->session->set_flashdata('warning', 'File format not allowed. Upload only png, jpg, jpeg and gif file');
					redirect('admin/categories/update/'.$id);
				}
			}
		}
	}

	public function status($id){
		if (!$this->ion_auth->logged_in()){
			redirect('admin/auth/login', 'refresh');
			} else {
				$category = Category::find_by_id($id);
				if($category->status==1){
					$category->update_attributes(array('status'=>0));
				} else{
					$category->update_attributes(array('status'=>1));
				}

				$this->session->set_flashdata('success', 'Category Status Changed Successfully');
					redirect('admin/categories');
		}
	}


	public function make_default($id=null){
		if (!$this->ion_auth->logged_in()){
			redirect('admin/auth/login', 'refresh');
			} else {
				$category = Category::find_by_id($id);
				if($category->make_default==1){
					$category->update_attributes(array('make_default'=>0));
				} else{
					$category->update_attributes(array('make_default'=>1));
				}

			echo json_encode(array('message'=> 'Category Status Changed Successfully'));
			
		}
	}

	function search_categories(){
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
		    

	        //print_r($conditions); die;

			$data = array(
				'categories' => Category::all(array('conditions'=>array($conditions), 'order' => 'created_at desc', 'select' =>'id,title,status,image,make_default')),
				'title' => 'Category',
				
			);

			$this->template->load('admin/admin_base','admin/category/category_list',$data);
		}
	}




}