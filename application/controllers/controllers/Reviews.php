 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reviews extends MY_Controller {


	public function review(){

		if($this->input->post()){
			$this->form_validation->set_rules('name', 'Name', 'required');
			$this->form_validation->set_rules('phone', 'Phone', 'required');
			$this->form_validation->set_rules('review', 'Reviews', 'required');
			$this->form_validation->set_rules('professionalism', 'Professionalism', 'required');
			$this->form_validation->set_rules('knowledge', 'Knowledge', 'required');
			$this->form_validation->set_rules('cost', 'Service cost', 'required');
			$this->form_validation->set_rules('punctuality', 'Punctuality', 'required');
			$this->form_validation->set_rules('tidiness', 'Tidiness', 'required');
			$this->form_validation->set_rules('user_friendly', 'User friendly', 'required');
			$this->form_validation->set_rules('interface', 'Interface', 'required');
			$this->form_validation->set_rules('technical_issue', 'Technical issues', 'required');
			
			if ($this->form_validation->run() == FALSE) {
			 	if ($this->input->is_ajax_request()) {

	                if (validation_errors()) {

	                    print_r(json_encode(array("status" => "error", "message" => validation_errors())));
	                }
	            }

			} else {
				//print_r(json_encode(array("status" => "success", 'message' => 'Your review has been submitted successfully')));
				$data = array(
					'professionalism' => $this->input->post('professionalism'),
					'knowledge' => $this->input->post('knowledge'),
					'cost' => $this->input->post('cost'),
					'punctuality' => $this->input->post('punctuality'),
					'tidiness' => $this->input->post('tidiness'),
					'user_friendly' => $this->input->post('user_friendly'),
					'interface' => $this->input->post('interface'),
					'technical_issue' => $this->input->post('technical_issue'),

					'review' => $this->input->post('review'),
					'name' => $this->input->post('name'),
					'phone' => $this->input->post('phone'),
					'professional_id' => $this->input->post('professional_id'),
					'type' => 'professional',
					'status' =>1

				);

				

				$is_create = Review::create($data);

				if($is_create){
					print_r(json_encode(array("status" => "success", 'message' => 'Your review has been submitted successfully')));
				} else {
					print_r(json_encode(array("status" => "error", 'message' => 'Your review is not submitted. please try again')));
				}

			}
		} else {
			$this->data['title'] = 'Contact Us';
			$this->template->load('frontend/front_base','frontend/reviews',$this->data);
		}
	
	}


	function review_list($id){

		$this->data['reviews'] = Review::find('all',array('order' => 'created_at desc',  'conditions'=>array('type = ? AND professional_id = ?','professional',$id)));
		//print_r($this->data['reviews']); die;
		$this->data['title'] = 'Review';
		$this->template->load('frontend/front_base','frontend/reviews_list',$this->data);

	}
}