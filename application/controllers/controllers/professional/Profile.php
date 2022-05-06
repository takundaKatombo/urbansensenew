<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends MY_Controller
{


	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$id = $this->data['current_user'];
		$this->data['title'] = 'Profile';
		$this->data['user'] = User::find_by_id($id);
		$this->template->load('frontend/front_base', 'professional/profile', $this->data);
	}

	public function edit_profile()
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('login', 'refresh');
		} else {
			if (!$this->input->post()) {
				$id = $this->data['current_user'];
				$this->data['user'] = User::find_by_id($id);
				$this->data['services'] = Service::all(array('conditions' => array('status =1'), 'order' => 'title asc'));
				$this->data['cities'] = City::all(array('conditions' => array('status =1'), 'order' => 'title asc'));
				$this->template->load('frontend/front_base', 'professional/edit_profile', $this->data);
			} else {
				$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|max_length[30]');
				$this->form_validation->set_rules('last_name', 'Last Name', 'max_length[30]');
				$this->form_validation->set_rules('phone', 'phone', 'required|max_length[15]');
				$this->form_validation->set_rules('email', 'Email', 'required|max_length[50]|valid_email');
				$this->form_validation->set_rules('service[]', 'Service', 'required');
				$this->form_validation->set_rules('location', 'Location', 'required');
				$this->form_validation->set_rules('address', 'Address', 'required|max_length[200]');
				$this->form_validation->set_rules('introduction', 'Comapany Introduction', 'max_length[200]');
				$this->form_validation->set_rules('company_name', 'Comapany Name', 'max_length[50]');
				$this->form_validation->set_rules('company_detail', 'Comapany Detail', 'required|max_length[2000]');
				$this->form_validation->set_rules('id_type', 'ID Type', 'required');
				$this->form_validation->set_rules('account_holder_name', 'Account holder name', 'required|max_length[50]');
				$this->form_validation->set_rules('account_number', 'Account Number', 'required|max_length[20]');
				$this->form_validation->set_rules('ifsc', 'Bank Name', 'required|max_length[200]');
				$this->form_validation->set_rules('branch', 'Branch', 'required|max_length[250]');
				$this->form_validation->set_rules('id_number', 'ID Number', 'required|max_length[20]');

				if ($this->form_validation->run() == FALSE) {
					if (validation_errors()) {
						$this->session->set_flashdata("warning", validation_errors());
						//print_r(validation_errors()); die;
					}
					$this->data['title'] = 'Update Profile';
					$id = $this->data['current_user'];
					$this->data['user'] = User::find_by_id($id);
					$this->data['services'] = Service::all(array('conditions' => array('status =1'), 'order' => 'title asc'));
					$this->data['cities'] = City::all(array('conditions' => array('status =1'), 'order' => 'title asc'));
					$this->template->load('frontend/front_base', 'professional/edit_profile', $this->data);
				} else {
					$id = $this->data['current_user'];
					$user = User::find_by_id($id);

					$data = array(
						'first_name' => $this->input->post('first_name'),
						'last_name' => $this->input->post('last_name'),
						'phone' => $this->input->post('phone'),
						'email' => $this->input->post('email'),
					);


					$services = filter_input(INPUT_POST, 'service', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

					$city_id = $this->input->post('location');

					$chk = Professional::find_by_user_id($id);

					$this->load->library('Upload_file');
					//print_r($_FILES['id_card_image']['name']); die;
					$array = array('png', 'jpg', 'jpeg', 'gif');
					$filename = @$_FILES["id_card_image"]["name"];
					$file_ext = pathinfo($filename, PATHINFO_EXTENSION);
					if (@$_FILES['id_card_image']['size'] != 0) { // if  image selected
						if (in_array($file_ext, $array)) {

							@unlink('./uploads/id_card_image/' . $chk->id_card_image);
							$chk_image = $this->upload_file->optional_image_upload('id_card_image');
							//print_r($chk_image); die;
						} else {
							$this->session->set_flashdata("warning", 'File format not supported. Please upload only jpg, jpeg, png and gif file');
							redirect('edit-profile', 'refresh');
						}
					}


					$id_card_image = @$chk_image ? $chk_image : $chk->id_card_image;
					$array1 = array('png', 'jpg', 'jpeg', 'gif');
					$filename1 = @$_FILES["bank_passbook_image"]["name"];
					$file_ext1 = pathinfo($filename1, PATHINFO_EXTENSION);
					if (@$_FILES['bank_passbook_image']['size'] != 0) { // if  image selected
						if (in_array($file_ext1, $array1)) {

							@unlink('./uploads/bank_passbook_image/' . $chk->bank_passbook_image);
							$chk_image = $this->upload_file->optional_image_upload('bank_passbook_image');
						} else {
							$this->session->set_flashdata("warning", 'File format not supported. Please upload only jpg, jpeg, png and gif file');
							redirect('edit-profile', 'refresh');
						}
					}

					$bank_passbook_image = @$chk_image ? $chk_image : $chk->bank_passbook_image;

					$other_data = array(
						'city_id' => $city_id,
						'address' => $this->input->post('address'),
						'company_name' => $this->input->post('company_name'),
						'company_detail' => $this->input->post('company_detail'),
						'introduction' => $this->input->post('introduction'),
						'price' => $this->input->post('price'),
						'latitude' => $this->input->post('latitude'),
						'longitude' => $this->input->post('longitude'),
						'id_type' => $this->input->post('id_type'),
						'id_number' => $this->input->post('id_number'),
						'account_holder_name' => $this->input->post('account_holder_name'),
						'account_number' => $this->input->post('account_number'),
						'ifsc' => $this->input->post('ifsc'),
						'branch' => $this->input->post('branch'),
						'bank_passbook_image' => $bank_passbook_image,
						'id_card_image' => $id_card_image
					);

					$user->update_attributes($data);

					ProfessionalService::delete_all(array("conditions" => array("user_id = ?", $id)));
					foreach ($services as  $row) {
						ProfessionalService::create(array('user_id' => $id, 'service_id' => $row));
					}

					$update =  $chk->update_attributes($other_data);
					if ($update) {
						$this->data['title'] = 'Updated';
						$this->data['message'] = 'Your Profile Updated Successfully.';
						//$message = $this->load->view('emails/verification_email',$data,TRUE);
						if ($this->data['loggedin_user']->verification != 1) {

							$message = 'Hello UrbanSense <br> ' . $user->first_name . ' ' . $user->last_name . ' updated his account  details. Please check if all documents are accurate then verify his account<br> <b>Name : </b>' . $user->first_name . ' ' . $user->last_name . ' <br> <b>Email : </b>' . $user->email;
							$this->custom_email->send($this->data['site_data']->email, 'UrbanSense', "[UrbanSense] " . $user->email . " Account Update", $message);
						}

						$this->session->set_flashdata("success", $this->data['message']);
						redirect('edit-profile', 'refresh');
					}
				}
			}
		}
	}


	public function create_service_images($id = NULL)
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('login', 'refresh');
		} else {
			if ($this->input->post()) {
				$this->load->library('Upload_file');
				if ($_FILES['image']['name']) { // if  image selected

					$array1 = array('png', 'jpg', 'jpeg', 'gif');
					$filename1 = @$_FILES["image"]["name"];
					$file_ext1 = pathinfo($filename1, PATHINFO_EXTENSION);
					if (in_array($file_ext1, $array1)) {
						$image = $this->upload_file->optional_image_upload('image');
					} else {
						$this->session->set_flashdata("warning", 'File format not supported. Please upload only jpg, jpeg, png and gif file');
						redirect('upload-image', 'refresh');
					}
				}
				$data = array(
					'user_id' => $this->data['current_user'],
					'image' => $image
				);


				$cat = ProfessionalImage::create($data);
				//$this->session->set_flashdata('success', ' image created successfully');
				redirect('upload-image');
			} else {

				$this->data['user'] = User::find_by_id($this->ion_auth->user()->row()->id);
				$this->data['title'] = 'Service Images';
				$this->template->load('frontend/front_base', 'professional/service_image', $this->data);
			}
		}
	}


	public function delete_image($id)
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('login', 'refresh');
		} else {
			$image = ProfessionalImage::find_by_id($id);

			@unlink('./uploads/image/' . $image->image);
			$image->delete();

			//$this->session->set_flashdata('success', 'Image deleted successfully');
			redirect('upload-image');
		}
	}


	function default_image()
	{
		$user_id = $this->data['current_user'];
		$id = $this->input->post('image_id');
		$chk = ProfessionalImage::all(array('conditions' => array('user_id=?', $user_id)));

		foreach ($chk as $key => $value) {
			$data = array('default_image' => 0);
			$value->update_attributes($data);
		}

		$flag = ProfessionalImage::find_by_id($id);
		$result = $flag->update_attributes(array('default_image' => 1));
		if ($result) {
			print_r(json_encode(array('status' => 'success', 'message' => 'Updated image as default')));
		} else {
			print_r(json_encode(array('status' => 'failed', 'message' => 'Image is not update as default')));
		}
	}
}
