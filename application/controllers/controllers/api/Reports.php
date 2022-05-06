<?php

/**
 * 
 */ 
class Reports extends API_Controller{
	
	public function __construct(){
		parent::__construct();
	}

	public function not_arrived_post($chatroom_id,$quote_id){
		//print_r($quote_id); die;
		$request = json_decode($this->input->raw_input_stream);
        $user = $this->is_logged_in();
        if (empty($user)) {

            $message = [
                'status' => FALSE,
                'message' => 'You need to be logged in to proceed with the checkout process.',
                'responseCode' => '0'
            ];
            $this->set_response($message, REST_Controller::HTTP_METHOD_NOT_ALLOWED);
        } else {
			$chatroom = ChatRoom::find_by_id($chatroom_id);
			$request = QuoteRequest::find_by_id($quote_id);
			$time = $this->getTime($request->avail_time);
			//print_r($time.'/'.date('His')); die;
			if(date('Y-m-d', strtotime($request->avail_date)) <= date('Y-m-d') AND $time <= date('His')){
				
				if(!empty($chatroom)){
					$data = array(
							'quote_request_id' => $quote_id,
							'report_description' => 'Service Provider not arrived',
							'chatroom_id' => $chatroom_id,
							'booking_id' => Booking::find(array('conditions'=>array('booked_status=? AND chatroom_id = ?','success',$chatroom_id)))->id
						);

					$emaildata = array('chatroom' => $chatroom);
					
					$adminemail = Setting::find(array('conditions' => array('id = 1'), 'limit' => 1))->email;
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
					$request = QuoteRequest::find_by_id($quote_id);
					$request->update_attributes(array('not_arrived'=>1));

					if($report){
						$this->response([
		                'status' => TRUE,
		                'response' => 'We are sorry for this issue! One of our members will try to resolve the issue and nothing works out for you, we will initiate the refund process.',
		                'responseCode' => '1'
		                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
					}
					
				} else {
					$this->response([
		                'status' => FALSE,
		                'message' => 'Your issue could not be reported at this moment. Please try again later.',
		                'responseCode' => '0'
		                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
				}

			} else {
				$this->response([
		                'status' => FALSE,
		                'message' => 'It seems you are reporting this issue before the scheduled time. Please wait for the provider to come.',
		                'responseCode' => '0'
		                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
				
			}

		}
	}
	
	
	/* 
	This function was created specifically for Android
	because the developer wasn't able to parse GET & POST both together
	*/
	public function not_arrived_android_post(){
		//print_r($quote_id); die;
		$request = json_decode($this->input->raw_input_stream);
		$chatroom_id = $request->chatroom_id;
		$quote_id = $request->quote_id;
		
        $user = $this->is_logged_in();
        if (empty($user)) {

            $message = [
                'status' => FALSE,
                'message' => 'You need to be logged in to proceed with the checkout process.',
                'responseCode' => '0'
            ];
            $this->set_response($message, REST_Controller::HTTP_METHOD_NOT_ALLOWED);
        } else {
			$chatroom = ChatRoom::find_by_id($chatroom_id);
			$request = QuoteRequest::find_by_id($quote_id);
			$time = $this->getTime($request->avail_time);
			//print_r($time.'/'.date('His')); die;
			if(date('Y-m-d', strtotime($request->avail_date)) <= date('Y-m-d') AND $time <= date('His')){
				
				if(!empty($chatroom)){
					$data = array(
							'quote_request_id' => $quote_id,
							'report_description' => 'Service Provider not arrived',
							'chatroom_id' => $chatroom_id,
							'booking_id' => Booking::find(array('conditions'=>array('booked_status=? AND chatroom_id = ?','success',$chatroom_id)))->id
						);

					$emaildata = array('chatroom' => $chatroom);
					
					$adminemail = Setting::find(array('conditions' => array('id = 1'), 'limit' => 1))->email;
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
					$request = QuoteRequest::find_by_id($quote_id);
					$request->update_attributes(array('not_arrived'=>1));

					if($report){
						$this->response([
		                'status' => TRUE,
		                'response' => 'We are sorry for this issue! One of our members will try to resolve the issue and nothing works out for you, we will initiate the refund process.',
		                'responseCode' => '1'
		                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
					}
					
				} else {
					$this->response([
		                'status' => FALSE,
		                'message' => 'Your issue could not be reported at this moment. Please try again later.',
		                'responseCode' => '0'
		                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
				}

			} else {
				$this->response([
		                'status' => FALSE,
		                'message' => 'It seems you are reporting this issue before the scheduled time. Please wait for the provider to come.',
		                'responseCode' => '0'
		                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
				
			}

		}
	}


	private function getTime($time){

		$exeed_time = '';
		if($time == '9 am to 12 pm'){
			$exeed_time = '125959';
			return $exeed_time;
		} else if($time == '12 pm to 3 pm'){

			$exeed_time = '155959';
			return $exeed_time;
		} else if($time == '3 pm to 6 pm'){

			$exeed_time = '185959';
			return $exeed_time;
		} else if($time == '6 pm to 9 pm'){
			
			$exeed_time = '215959';
			return $exeed_time;
		}	
	}
}