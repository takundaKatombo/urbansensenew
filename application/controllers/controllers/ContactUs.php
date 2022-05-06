<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ContactUs extends MY_Controller {


	public function index(){	

		$this->data['title'] = 'Contact Us';
		//$this->data['services'] = Service::all(array('conditions'=>array('status=1'))); 
		//$this->data['cities'] = City::all(array('conditions'=>array('status=1'))); 
		$this->template->load('frontend/front_base','frontend/contact_us',$this->data);
	}

	public function create(){
		if($this->input->post()){
		$this->form_validation->set_rules('name','Name','required|max_length[100]');
		$this->form_validation->set_rules('phone', 'phone', 'required|numeric|min_length[10]|max_length[15]');
		$this->form_validation->set_rules('email', 'Email', 'required|max_length[50]|valid_email');
		$this->form_validation->set_rules('subject', 'Subject', 'required|max_length[50]');
		$this->form_validation->set_rules('message', 'Message', 'required|max_length[500]');
		
		if ($this->form_validation->run() == FALSE) {
		 	if ($this->input->is_ajax_request()) {

                if (validation_errors()) {

                    print_r(json_encode(array("status" => "error", "message" => validation_errors())));
                }
            }
           
		} else {
			$data = array('name' => $this->input->post('name'),
				'phone' => $this->input->post('phone'),
				'email' => $this->input->post('email'),
				'subject' => $this->input->post('subject'),
				'message' => $this->input->post('message'),
				
			);

			$user = Contact::create($data);
			$message = $this->load->view('emails/contactus', $data,TRUE);
			$this->custom_email->send($this->input->post('email'), $this->input->post('first_name'), "[UrbanSense] Your Contact Request Has Been Received",$message); 
			
			
		if($user){
				print_r(json_encode(array("status" => "success", "message" => 'Your requirement has been submitted successfully.')));
			} else {
				print_r(json_encode(array("status" => "error", "message" => 'Your requirement is not submitted. Please try again.')));
			}
		}
	} else {
		 $this->data['title'] = 'Contact Us';
		$this->template->load('frontend/front_base','frontend/contact_us',$this->data);
	}
}



}
