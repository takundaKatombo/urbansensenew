<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Services extends CI_Controller
{


	public function __construct()
	{
		parent::__construct();
		$this->load->helper('slug');
		if ($this->ion_auth->is_admin()) {
			return true;
		} else {
			$this->session->set_flashdata("warning", 'You must be an administrator to view this page.');
			redirect(base_url('logout'));
		}
	}

	public function index()
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('admin/auth/login', 'refresh');
		} else {
			$config['per_page'] = 20;
			$config['total_rows'] = Service::count();
			$config['base_url'] = base_url('admin/services');
			$page = (null !== $this->input->get('page')) ? $this->input->get('page') : 1;
			$start_index = ($page - 1) * $config['per_page'];

			$data = array(
				'title' => 'Service list',
				'services' => Service::all(array('limit' => $config['per_page'], 'offset' => $start_index, 'order' => 'title asc', 'select' => 'id,title,status,image')),
				'pagination' => $this->custom_pagination->create_backend_pagination($config)
			);
			$this->template->load('admin/admin_base', 'admin/service/service_list', $data);
		}
	}




	public function create()
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('admin/auth/login', 'refresh');
		} else {
			$this->form_validation->set_rules('title', 'Service Title', 'required|max_length[100] |is_unique[services.title]');

			if ($this->form_validation->run() == FALSE) {
				if (validation_errors()) {
					$this->session->set_flashdata("warning", validation_errors());
				}
				$this->data['title'] = 'Create New Service';
				$this->data['categories'] = Category::find('all', array('conditions' => array('status=1'), 'select' => 'id,title'));
				$this->template->load('admin/admin_base', 'admin/service/add_update_service', $this->data);
			} else {
				$image = '';
				$this->load->library('Upload_file');
				$array = array('png', 'jpg', 'jpeg', 'gif');
				$filename = $_FILES["image"]["name"];
				$file_ext = pathinfo($filename, PATHINFO_EXTENSION);
				if (in_array($file_ext, $array)) {

					if ($_FILES['image']['name']) { // if  image selected
						$image = $this->upload_file->optional_image_upload('image');
					}

					$data = array(
						'title' => $this->input->post('title'),
						'category_id' => $this->input->post('category_id'),
						'slug' => slug($this->input->post('title')),
						'user_id' => $this->ion_auth->user()->row()->id,
						'status' => $this->input->post('status'),
						'image' => $image
					);
					$cat = Service::create($data);
					$this->session->set_flashdata('success', 'Category created successfully');
					redirect('admin/services');
				} else {
					$this->session->set_flashdata('warning', 'File format not allowed. Upload only png, jpg, jpeg and gif file');
					$this->data['title'] = 'Create New Service';
					$this->data['categories'] = Category::find('all', array('conditions' => array('status=1'), 'select' => 'id,title'));
					$this->template->load('admin/admin_base', 'admin/service/add_update_service', $this->data);
				}
			}
		}
	}



	public function update($id = null)
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('admin/auth/login', 'refresh');
		} else {
			$service = Service::find_by_id($id);
			$this->form_validation->set_rules('title', 'Service Title', 'required|max_length[100]');

			if ($this->form_validation->run() == FALSE) {
				if (validation_errors()) {
					$this->session->set_flashdata("warning", validation_errors());
				}
				$this->data['title'] = 'Update Service';
				$this->data['categories'] = Category::find('all', array('conditions' => array('status=1'), 'select' => 'id,title'));
				$this->data['service'] = $service;
				$this->template->load('admin/admin_base', 'admin/service/add_update_service', $this->data);
			} else {

				$this->load->library('Upload_file');

				$array = array('png', 'jpg', 'jpeg', 'gif');
				$filename = $_FILES["image"]["name"];
				$file_ext = pathinfo($filename, PATHINFO_EXTENSION);
				$image = ($service->image) ? $service->image : '';
				if ($filename) {
					if (in_array($file_ext, $array)) {
						if ($_FILES['image']['size'] != 0) { // if  image selected
							@unlink('./uploads/image/' . $service->image);
							$chk_image = $this->upload_file->optional_image_upload('image');
						}

						$image = @$chk_image ? $chk_image : $service->image;
					} else {
						$this->session->set_flashdata('warning', 'File format not allowed. Upload only png, jpg, jpeg and gif file');
						redirect('admin/services/update/' . $id);
					}
				}

				$data = array(
					'title' => $this->input->post('title'),
					'category_id' => $this->input->post('category_id'),
					'slug' => slug($this->input->post('title')),
					'user_id' => $this->ion_auth->user()->row()->id,
					'status' => $this->input->post('status'),
					'image' => $image
				);
				$service->update_attributes($data);
				$this->session->set_flashdata('success', 'Category Updated successfully');
				redirect('admin/services');
			}
		}
	}


	public function status($id)
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('admin/auth/login', 'refresh');
		} else {
			$chk = Service::find_by_id($id);
			if ($chk->status == 1) {
				$chk->update_attributes(array('status' => 0));
			} else {
				$chk->update_attributes(array('status' => 1));
			}

			$this->session->set_flashdata('success', 'Service Status Changed Successfully');
			redirect('admin/services');
		}
	}


	public function create_service_images($id = NULL)
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('admin/auth/login', 'refresh');
		} else {
			$this->form_validation->set_rules('alt', 'Alternate Tag', 'max_length[50]');

			if ($this->form_validation->run() == FALSE) {
				if (validation_errors()) {
					$this->session->set_flashdata("warning", validation_errors());
				}
				$this->data['title'] = 'Create Service Images';
				$this->data['service_images'] = ServiceImage::all(array('conditions' => array('service_id = ?', $id)));

				$this->template->load('admin/admin_base', 'admin/service/upload_service_images', $this->data);
			} else {
				$this->load->library('Upload_file');
				if ($_FILES['image']['name']) { // if  image selected
					$image = $this->upload_file->optional_image_upload('image');
				}
				//print_r($_FILES['image']['name']);
				$data = array(
					'alt_tag' => $this->input->post('alt_tag'),
					'service_id' => $id,
					'image' => $image
				);
				//print_r($data); die;		

				$cat = ServiceImage::create($data);
				$this->session->set_flashdata('success', 'Category image created successfully');
				redirect('admin/services/create_service_images/' . $id);
			}
		}
	}


	public function delete_image($id)
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('admin/auth/login', 'refresh');
		} else {
			$image = ServiceImage::find_by_id($id);
			$service_id = $image->service_id;
			@unlink('./uploads/image/' . $image->image);
			$image->delete();

			$this->session->set_flashdata('success', 'Category image deleted successfully');
			redirect('admin/services/create_service_images/' . $service_id);
		}
	}

	function search_services()
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('admin/auth/login', 'refresh');
		} else {

			$conditions = '';
			$status = $this->input->get("status");
			$name = $this->input->get("name");

			if ($name != '' and $status != '') {
				//print_r('expression00'); 
				$conditions =  "title LIKE '%" . $name . "%' AND status = " . $status;
			} else {
				if ($name != '') {
					$conditions =  "title LIKE '%" . $name . "%'";
				}

				if ($status != '') {
					$conditions .=  "status = " . $status;
				}
			}

			$data = array(
				'title' => 'Service list',
				'services' => Service::all(array('conditions' => array($conditions), 'order' => 'title asc', 'select' => 'id,title,status,image'))

			);
			$this->template->load('admin/admin_base', 'admin/service/service_list', $data);
		}
	}
}
