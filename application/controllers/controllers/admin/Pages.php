<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pages extends CI_Controller
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
			$config['total_rows'] = Page::count();
			$config['base_url'] = base_url('admin/pages');
			$page = (null !== $this->input->get('page')) ? $this->input->get('page') : 1;
			$start_index = ($page - 1) * $config['per_page'];


			$data = array(
				'pages' => Page::find('all', array('limit' => $config['per_page'], 'offset' => $start_index, 'order' => 'created_at desc')),
				'title' => 'Page',
				'pagination' => $this->custom_pagination->create_backend_pagination($config)
			);
			//echo '<pre>'; print_r($data); die;

			$this->template->load('admin/admin_base', 'admin/page/page_list', $data);
		}
	}

	public function create()
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('admin/auth/login', 'refresh');
		} else {

			$this->form_validation->set_rules('title', 'Name', 'required|max_length[100]');
			//$this->form_validation->set_rules('menu_id', 'Menu', 'required');
			$this->form_validation->set_rules('content', 'Content', 'required');
			if ($this->form_validation->run() == FALSE) {
				//print_r($this->input->post()); die;
				if (validation_errors()) {
					$this->session->set_flashdata("warning", validation_errors());
				}
				$this->data['title'] = 'Create New Page';
				$this->data['menus'] = Menu::all();
				//print_r($this->data['menus']); die;
				$this->template->load('admin/admin_base', 'admin/page/add_update_pages', $this->data);
			} else {
				//print_r($_FILES['image']['name']); die();
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
						'content' => $this->input->post('content'),
						'excerpt' => '',
						'meta_keywords' => $this->input->post('meta_keywords'),
						'meta_description' => $this->input->post('meta_description'),
						'menu_id' => '',
						'user_id' => 0,
						'status' => 1,
						'flash_image_one' => $image,
						'slug' => slug($this->input->post('title')),
						'default_page' => 0
					);
					Page::create($data);
					$this->session->set_flashdata('success', 'Page created successfully');
					redirect('admin/Pages');
				} else {
					$this->session->set_flashdata('warning', 'File format not allowed. Upload only png, jpg, jpeg and gif file');
					$this->data['title'] = 'Create New Page';
					$this->data['menus'] = Menu::all();
					//print_r($this->data['menus']); die;
					$this->template->load('admin/admin_base', 'admin/page/add_update_pages', $this->data);
				}
			}
		}
	}


	public function update($id = null)
	{
		$page = Page::find_by_id($id);
		if (!$this->ion_auth->logged_in()) {
			redirect('admin/auth/login', 'refresh');
		} else {

			$this->form_validation->set_rules('title', 'Name', 'required|max_length[100]');
			//$this->form_validation->set_rules('menu_id', 'Menu', 'required');
			$this->form_validation->set_rules('content', 'Content', 'required');
			if ($this->form_validation->run() == FALSE) {
				if (validation_errors()) {
					$this->session->set_flashdata("warning", validation_errors());
				}
				$this->data['title'] = 'Update Page';
				$this->data['page'] = $page;
				$this->data['menus'] = Menu::all();
				$this->template->load('admin/admin_base', 'admin/page/add_update_pages', $this->data);
			} else {

				$this->load->library('Upload_file');
				$array = array('png', 'jpg', 'jpeg', 'gif');
				$filename = $_FILES["image"]["name"];
				$file_ext = pathinfo($filename, PATHINFO_EXTENSION);
				$image = ($page->flash_image_one) ? $page->flash_image_one : '';
				if ($filename) {
					if (in_array($file_ext, $array)) {
						if ($_FILES['image']['size'] != 0) { // if  image selected
							@unlink('./uploads/image/' . $page->flash_image_one);
							$chk_image = $this->upload_file->optional_image_upload('image');
						}
						$image = @$chk_image ? $chk_image : $page->flash_image_one;
					} else {
						$this->session->set_flashdata('warning', 'File format not allowed. Upload only png, jpg, jpeg and gif file');
						redirect('admin/Pages/update/' . $id);
					}
				}

				$data = array(
					'title' => $this->input->post('title'),
					'content' => $this->input->post('content'),
					'meta_keywords' => $this->input->post('meta_keywords'),
					'meta_description' => $this->input->post('meta_description'),
					'menu_id' => 0,
					'status' => 1,
					'flash_image_one' => $image,
					'slug' => slug($this->input->post('title'))
				);

				$page->update_attributes($data);
				$this->session->set_flashdata('success', 'Page Updated Successfully');
				redirect('admin/pages');
			}
		}
	}

	public function status($id)
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('admin/auth/login', 'refresh');
		} else {
			$page = Page::find_by_id($id);
			if ($page->status == 1) {
				$page->update_attributes(array('status' => 0));
			} else {
				$page->update_attributes(array('status' => 1));
			}

			$this->session->set_flashdata('success', 'Page Status Changed Successfully');
			redirect('admin/pages');
		}
	}


	public function delete($id)
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('admin/auth/login', 'refresh');
		} else {
			$page = Page::find_by_id($id);
			@unlink('./uploads/image/' . $page->flash_image_one);
			$page->delete();
			$this->session->set_flashdata('success', 'Page Deleted Successfully');
			redirect('admin/Pages');
		}
	}
}
