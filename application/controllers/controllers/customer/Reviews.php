 <?php
	defined('BASEPATH') or exit('No direct script access allowed');

	class Reviews extends MY_Controller
	{


		public function review()
		{
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

				$id = $this->input->post('chat_room_id');
				$chatroom = ChatRoom::find_by_id($id);

				$res_for_pro = ResponseForProposal::find_by_id($chatroom->request_id);

				//print_r($res_for_pro);
				$ResponseForProposal = ResponseForProposal::find('all', array('conditions' => array('quote_request_id = ?', $res_for_pro->quote_request_id)));
				//echo '<pre>'; print_r($ResponseForProposal); die;
				foreach ($ResponseForProposal as $row) {
					$row->update_attributes(array('status' => 0));
				}

				$res_for_pro->update_attributes(array('request_accept' => 4, 'status' => 1));

				$request = QuoteRequest::find_by_id($res_for_pro->quote_request_id);
				$request->update_attributes(array('status' => 4));

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
					'rating' => 0,
					'image' => '',
					'name' => $this->data['loggedin_user']->first_name . ' ' . $this->data['loggedin_user']->last_name,
					'phone' => $this->data['loggedin_user']->phone,
					'professional_id' => $chatroom->professional_id,
					'type' => 'professional',
					'status' => 1
				);

				//print_r($data); die;
				$is_create = Review::create($data);

				if ($is_create) {

					$recipient = User::find_by_id($chatroom->professional_id);

					foreach ($recipient->user_authentications as $row) {
						$device_id = array($row->device_id);
						if (!empty($device_id)) {
							$this->send_notification($device_id, 'You have received feedback from ' . $this->data['loggedin_user']->first_name . ' ' . $this->data['loggedin_user']->last_name . ' for ' . get_service($request->service_id), 'Review', $this->data['loggedin_user']->first_name, 'review');
						}
					}


					print_r(json_encode(array("status" => "destination", "destination" => 'customer-chat/' . $id, 'message' => 'Your review has been submitted successfully')));
				} else {
					print_r(json_encode(array("status" => "error", 'message' => 'Your review is not submitted. please try again')));
				}
			}
		}


		function review_list($id)
		{

			$this->data['reviews'] = Review::find('all', array('order' => 'created_at desc',  'conditions' => array('type = ? AND professional_id = ?', 'professional', $id)));
			//print_r($this->data['reviews']); die;
			$this->data['title'] = 'Review';
			$this->template->load('frontend/front_base', 'frontend/reviews_list', $this->data);
		}
	}
