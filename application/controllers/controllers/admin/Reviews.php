<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reviews extends CI_Controller {


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
	        $config['total_rows'] = Review::count(array('conditions'=>array('type=?','admin')));
	        $config['base_url'] = base_url('admin/reviews');
	        $page = (null !== $this->input->get('page')) ? $this->input->get('page') : 1;
	        $start_index = ($page - 1) * $config['per_page'];
	      
	 		
			$data = array(
				'reviews' => Review::find('all',array('limit'=>$config['per_page'], 'offset' => $start_index, 'order' => 'created_at desc','conditions'=>array('type=?','admin'))),
				'title' => 'Review',
				'pagination' => $this->custom_pagination->create_backend_pagination($config)
			);
			//echo '<pre>'; print_r($data); die;

			$this->template->load('admin/admin_base','admin/review/review_list',$data);
		}
	}

	public function create(){ 
		if (!$this->ion_auth->logged_in()){
			redirect('admin/auth/login', 'refresh');
		} else {
			$this->form_validation->set_rules('name', 'Name', 'required|max_length[100] ');
			$this->form_validation->set_rules('phone', 'Phone', 'required|max_length[15] ');
			$this->form_validation->set_rules('review', 'Review', 'required|max_length[500] ');
			$this->form_validation->set_rules('rating', 'Rating', 'required');
			 if ($this->form_validation->run() == FALSE) {
			 	if (validation_errors()) {
	                 $this->session->set_flashdata("warning",validation_errors());
	            }
	            $this->data['title'] = 'Create New Review';
				$this->template->load('admin/admin_base','admin/review/add_update_review',$this->data);
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
						'rating' => $this->input->post('rating'),
						'review' => $this->input->post('review'),
						'name' => $this->input->post('name'),
						'phone' => $this->input->post('phone'),
						'professional_id' => 0,
						'type' => 'admin',
						'status' =>1,
						'image' =>$image
					);
					$cat = Review::create($data);
					$this->session->set_flashdata('success', 'Review created successfully');
		        	redirect('admin/reviews');
		        } else {
					$this->session->set_flashdata('warning', 'File format not allowed. Upload only png, jpg, jpeg and gif file');
					$this->data['title'] = 'Create New Review';
					$this->template->load('admin/admin_base','admin/review/add_update_review',$this->data);
				}
			}
		}
	}


	public function update($id =null){
		if (!$this->ion_auth->logged_in()){
			redirect('admin/auth/login', 'refresh');
		} else {

			$review = Review::find_by_id($id);
			$this->form_validation->set_rules('name', 'Name', 'required|max_length[100] ');
			$this->form_validation->set_rules('phone', 'Phone', 'required|max_length[15] ');
			$this->form_validation->set_rules('review', 'Review', 'required|max_length[500] ');
			$this->form_validation->set_rules('rating', 'Rating', 'required');
			 if ($this->form_validation->run() == FALSE) {
			 	if (validation_errors()) {
	                 $this->session->set_flashdata("warning",validation_errors());
	            }
	            $this->data['title'] = 'Update Category';
				$this->data['review'] = $review;
				$this->template->load('admin/admin_base','admin/review/add_update_review',$this->data);
			}  else {
				//print_r($_FILES['image']['name']); die;
				$this->load->library('Upload_file');
				$array = array('png','jpg','jpeg','gif');
				$filename= $_FILES["image"]["name"];
				$file_ext = pathinfo($filename,PATHINFO_EXTENSION);
				if(in_array($file_ext, $array )){ 
					if ($_FILES['image']['size'] != 0){ // if  image selected
						@unlink('./uploads/image/'.$review->image);
						$chk_image= $this->upload_file->optional_image_upload('image');

					}

					$image = @$chk_image ? $chk_image : $review->image;

					$data = array(
						'rating' => $this->input->post('rating'),
						'review' => $this->input->post('review'),
						'name' => $this->input->post('name'),
						'phone' => $this->input->post('phone'),
						'professional_id' => 0,
						'type' => 'admin',
						'status' =>1,
						'image' =>$image
					);

					$review->update_attributes($data);
					$this->session->set_flashdata('success', 'Review Updated Successfully');
					redirect('admin/reviews');
				} else {
					$this->session->set_flashdata('warning', 'File format not allowed. Upload only png, jpg, jpeg and gif file');
					redirect('admin/Reviews/update/'.$id);
				}
			}
		}
	}

	public function status($id){
		if (!$this->ion_auth->logged_in()){
			redirect('admin/auth/login', 'refresh');
			} else {
				$category = Review::find_by_id($id);
				if($category->status==1){
					$category->update_attributes(array('status'=>0));
				} else{
					$category->update_attributes(array('status'=>1));
				}

				$this->session->set_flashdata('success', 'Review Status Changed Successfully');
					redirect('admin/reviews');
		}
	}


	public function delete($id){
		if (!$this->ion_auth->logged_in()){
			redirect('admin/auth/login', 'refresh');
			} else {
				$review = Review::find_by_id($id);
				@unlink('./uploads/image/'.$review->image);
				$review->delete();
				$this->session->set_flashdata('success', 'Review Deleted Successfully');
					redirect('admin/reviews');
		}
	}


	public function show_on_homepage($id=null){
		if (!$this->ion_auth->logged_in()){
			redirect('admin/auth/login', 'refresh');
			} else {
				$review = Review::find_by_id($id);
				if($review->show_on_homepage==1){
					$review->update_attributes(array('show_on_homepage'=>0));
					echo json_encode(array('message'=> 'Review deny for show on homepage '));
					
				} else{
					$review->update_attributes(array('show_on_homepage'=>1));
					echo json_encode(array('message'=> 'Review successfully showing on homepage'));
				}

			
			
		}
	}




}