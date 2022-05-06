<?php

/**
 * 
 */
class Reports extends MY_Controller{
	
	public function __construct(){
		parent::__construct();
	}

	public function not_arrived($chatroom_id,$quote_id){
		//print_r($quote_id); die;
		if(!$this->ion_auth->is_member()){ 
			redirect('login');
		} else {
			$chatroom = ChatRoom::find_by_id($chatroom_id);
			$request = QuoteRequest::find_by_id($quote_id);
			
			$time = $this->getTime($request->avail_time);
			//print_r( $time <= date('His')); die;
			if(date('Y-m-d'.$time.'', strtotime($request->avail_date)) <= date('Y-m-dH:i:s')){

			//	print_r(date('Y-m-d'.$time.'', strtotime($request->avail_date))); die;	
					if(!empty($chatroom)){
						$data = array(
							'quote_request_id' => $quote_id,
							'report_description' => 'Service Provider not arrived',
							'chatroom_id' => $chatroom_id,
							'booking_id' => Booking::find(array('conditions'=>array('booked_status=? AND chatroom_id = ?','success',$chatroom_id)))->id
						);

					

						$emaildata = array(
							'booking_id' => Booking::find(array('conditions'=>array('booked_status=? AND chatroom_id = ?','success',$chatroom_id)))->id,
							'quoterequest' => $request,
							'response' => ResponseForProposal::find_by_id($chatroom->request_id),


						);
						
						$adminemail = $this->data['site_data']->email;
						$messageSprovider = $this->load->view('emails/not_arrived_to_sp', $emaildata, true);
						$messageAdmin = $this->load->view('emails/not_arrived_to_admin', $emaildata, true);
						$subject = 'Service Provider not arrived';
						$this->custom_email->send(get_user($chatroom->professional_id)->email , "UrbanSense", $subject, $messageSprovider);
						$this->custom_email->send($adminemail , "UrbanSense", $subject, $messageAdmin);

						$recipient = User::find_by_id($chatroom->professional_id);
			            foreach($recipient->user_authentications as $row){
			            $device_id = array($row->device_id);
			                if(!empty($device_id)){
			                    $this->send_notification($device_id, get_user($chatroom->customer_id)->first_name.' has reported non-arrival for '.get_service($request->service_id).'. You must talk to the client to sort this out.','Not Arrived',get_user($chatroom->customer_id)->first_name,'not_arrived');
			                }
			            } 

						$report = Report::create($data);
						
						$request->update_attributes(array('not_arrived'=>1));

						if($report){
							$this->session->set_flashdata('success', 'We are sorry for this issue! One of our members will try to resolve the issue and nothing works out for you, we will initiate the refund process.');
							redirect('booking-detail/'.$quote_id);
							/*print_r(json_encode(array("status" => "success", 'message' => 'Your report (for service provider not arrived) has been submitted successfully')));*/
						}
						
					} else {
						$this->session->set_flashdata('error', 'Your issue could not be reported at this moment. Please try again later.');
						redirect('booking-detail/'.$quote_id);
						/*print_r(json_encode(array("status" => "error", 'message' => 'we are not able to report at this moment. please try again later.')));*/
					}

			} else {
				$this->session->set_flashdata('error', 'It seems you are reporting this issue before the scheduled time. Please wait for the provider to come.');
				redirect('booking-detail/'.$quote_id);
			}

		}
	}


	private function getTime($time){

		$exeed_time = '';
		if($time == '9 am to 12 pm'){
			$exeed_time = '12:59:59';
			return $exeed_time;
		} else if($time == '12 pm to 3 pm'){

			$exeed_time = '15:59:59';
			return $exeed_time;
		} else if($time == '3 pm to 6 pm'){

			$exeed_time = '18:59:59';
			return $exeed_time;
		} else if($time == '6 pm to 9 pm'){
			
			$exeed_time = '21:59:59';
			return $exeed_time;
		}	
	}
}