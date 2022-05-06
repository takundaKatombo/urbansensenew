<?php
/**
 * 
 */
class CustomerReports extends CI_Controller{
	
	function __construct(){
		parent::__construct();

		if($this->ion_auth->is_admin()){
			 return true;
		} else {
			$this->session->set_flashdata("warning",'You must be an administrator to view this page.');
			redirect(base_url('logout')); 
		}
	}


	public function index(){
		if (!$this->ion_auth->logged_in()){
			redirect('admin/auth/login', 'refresh');
			} else {
				$config['per_page'] = 20;
		        $config['total_rows'] = Report::count();
		        $config['base_url'] = base_url('admin/CustomerReports');
		        $page = (null !== $this->input->get('page')) ? $this->input->get('page') : 1;
		        $start_index = ($page - 1) * $config['per_page'];
		      	
		      	$reports = Report::find('all',array('limit'=>$config['per_page'], 'offset' => $start_index, 'order' => 'created_at desc'));

		      	$report_list = array();

		      	foreach ($reports as $row) {

		      		$requestData = $this->getRequestDetail($row->quote_request_id);
		      		
		      		$provider = $this->getChatRoomDetail($row->chatroom_id);

		      		$booking = Booking::find_by_id($row->booking_id);
		      		//print_r(QuoteRequest::find_by_id($row->quote_request_id)->status); die;
		      		$report_list[] = array(
		      						'customer_name' => get_user($requestData->user_id)->first_name.' '.get_user($requestData->user_id)->last_name,
		      						'preferred_time' =>date('d-m-Y', strtotime($requestData->avail_date)).' | '.$requestData->avail_time,
		      						'provider_name' => $provider->professionals->company_name,
		      						'provider_email' => $provider->email,
		      						'provider_phone' => $provider->phone,
		      						'status' => QuoteRequest::find_by_id($row->quote_request_id)->status,
		      						'amount' => $booking->currency.' '.$booking->amount_paid,
		      						'refund_status' => $row->refund_status,
		      						'date' => date('d-m-Y h:i:s', strtotime($row->created_at)),
		      						'report_id' => $row->id



		      		);
		      	}
		 		
				$data = array(
					'reports' => $report_list,
					'title' => 'Customer Complaint',
					'pagination' => $this->custom_pagination->create_backend_pagination($config)
				);
				//echo '<pre>'; print_r($data); die;
			$this->template->load('admin/admin_base','admin/report/complain_list',$data);
		}
	}


	private function getRequestDetail($id){
 			$request =  QuoteRequest::find_by_id($id);
 			return $request;
	}

	private function getChatRoomDetail($id){
 			$chatroom =  ChatRoom::find_by_id($id);
 			//print_r($chatroom->professional_id); 
 			$user = get_user($chatroom->professional_id);
 			return $user;
	}
    

    public function refund($id){
    	if (!$this->ion_auth->logged_in()){
			redirect('admin/auth/login', 'refresh');
		} else {
			$report = Report::find_by_id($id);
			$report->update_attributes(array('refund_status'=>1));

			$booking = Booking::find_by_id($report->booking_id);
			$booking->update_attributes(array('booked_status'=>'refund'));

			$payment = Payment::find(array('conditions'=>array('payment_status=? AND payment_key = ?','success',$booking->payment_key)));
			$payment->update_attributes(array('payment_status'=>'refund'));

			$response = ResponseForProposal::find_by_id($booking->response_for_quote_id);
			$response->update_attributes(array('status'=>0));

			$request = QuoteRequest::find_by_id($response->quote_request_id);
			$request->update_attributes(array('status'=>0));

			$customer = get_user($booking->customer_id);

			$emaildata = array( 
				'name' => $booking->customer_name,
				'service' => get_service($booking->service_id),
				'booking_id' => $booking->booking_reference_number,
				'payment_id' => $booking->payment_key,
				'amount' => $booking->amount_paid,
				'location' => $booking->customer_address,
				'datetime' => date('d-M-Y',strtotime($booking->required_date)) .' / ' .$booking->required_time,
				'provider' => get_user($booking->professional_id)->professionals->company_name,
				 );
			$refundmessage = $this->load->view('emails/refund_message', $emaildata, true);
			$subject = '[UrbanSense] Refund';
			$this->custom_email->send($customer->email , "UrbanSense", $subject, $refundmessage);

			redirect('admin/CustomerReports');

		}
    }



}

