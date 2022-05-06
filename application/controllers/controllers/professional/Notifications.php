<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notifications extends MY_Controller
{


	public function __construct()
	{
		parent::__construct();
	}

	/*
	*******service provider*********
	new leads => request_accept = 0
	ongoing_leads  => request_accept = 1
	converted_leads => request_accept = 2

	*/

	/*
	********customer***********
	ongoing status = 1
	cancel status = 0
	booked status = 2
	completed status = 3

	*/

	public function index()
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('login', 'refresh');
		} else {

			$config['per_page'] = 10;
			$config['total_rows'] = ResponseForProposal::count(array('conditions' => array('(request_accept = 0 OR request_accept is NULL) AND professional_id = ?', $this->ion_auth->user()->row()->id)));
			$config['base_url'] = base_url('all-leads');
			$page = (null !== $this->input->get('page')) ? $this->input->get('page') : 1;
			$start_index = ($page - 1) * $config['per_page'];

			$this->data['pagination'] = $this->custom_pagination->create_frontend_pagination($config);

			$this->data['title'] = 'New Leads';
			$this->data['requests'] = $requests = ResponseForProposal::find('all', array('conditions' => array('(request_accept = 0 OR request_accept is NULL) AND professional_id = ?', $this->ion_auth->user()->row()->id),  'limit' => $config['per_page'], 'offset' => $start_index,  'order' => 'created_at desc'));
			$request = ResponseForProposal::find('all', array('conditions' => array('is_view = 0 AND professional_id = ?', $this->ion_auth->user()->row()->id)));
			foreach ($request as $row) {
				$row->update_attributes(array('is_view' => 1));
			}

			$this->template->load('frontend/front_base', 'professional/notification', $this->data);
		}
	}

	public function request_accept($id)
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('login', 'refresh');
		} else {


			redirect('all-leads');
		}
	}

	public function send_quote()
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('login', 'refresh');
		} else {
			$this->form_validation->set_rules('request_details', 'Request Details', 'required|max_length[250]');
			$this->form_validation->set_rules('price', 'Price', 'required');
			if ($this->form_validation->run() == FALSE) {
				if ($this->input->is_ajax_request()) {

					if (validation_errors()) {

						print_r(json_encode(array("status" => "error", "message" => validation_errors())));
					}
				}
			} else {
				$data1 = array(
					'professional_id' => $this->ion_auth->user()->row()->id,
					'customer_id' => $this->input->post('receiver_id'),
					'request_id' => $this->input->post('response_for_proposal_id'),
					'price' => $this->input->post('price')
				);
				$chatroom = ChatRoom::create($data1);

				$data2 = array(
					'chat_room_id' => $chatroom->id,
					'user_id' => $this->ion_auth->user()->row()->id,
					'message' => $this->input->post('request_details')
				);
				Chat::create($data2);

				$data3 = array(
					'chatroom_id' => $chatroom->id,
					'amount' => $this->input->post('price'),
					'currency' => 'ZAR',
					'payment_status' => 'initiated',
					'status' => 0,
				);

				PriceHistory::create($data3);

				$var = ResponseForProposal::find_by_id($this->input->post('response_for_proposal_id'));
				//print_r($var);
				$var->update_attributes(array('request_accept' => 1));
				$professionals = Professional::find_by_user_id($this->ion_auth->user()->row()->id);
				$recipient = User::find_by_id($chatroom->customer_id);
				foreach ($recipient->user_authentications as $row) {
					$device_id = array($row->device_id);
					if (!empty($device_id)) {
						$this->send_notification($device_id, 'Your request for the quotation has been accepted by ' . $professionals->company_name, 'Request Accepted', $professionals->company_name, 'request_accepted');
					}
				}


				print_r(json_encode(array("status" => "destination", "destination" => 'all-leads', 'message' => 'Your quote sent to the customer successfully and request has been accepted. Now you can start conversation with customer')));
			}
		}
	}

	function update_quote()
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('login', 'refresh');
		} else {
			$this->form_validation->set_rules('message', 'Quote Details', 'required|max_length[250]');
			$this->form_validation->set_rules('price', 'Price', 'required');
			if ($this->form_validation->run() == FALSE) {
				if ($this->input->is_ajax_request()) {

					if (validation_errors()) {

						print_r(json_encode(array("status" => "error", "message" => validation_errors())));
					}
				}
			} else {

				$chat_room_id = $this->input->post('chat_room_id');
				$chatroom = ChatRoom::find_by_id($chat_room_id);

				$qouterequest = ResponseForProposal::find_by_id($chatroom->request_id);

				if ($qouterequest->request_accept == 2) {

					$pre_amount = PriceHistory::find('all', array('select' => 'sum(amount) as total_amount', 'conditions' => array('chatroom_id = ? AND payment_status = ? AND status = 1', $chat_room_id, 'success')));
					if ($pre_amount[0]->total_amount < $this->input->post('price')) {
						$data3 = array(
							'chatroom_id' => $chat_room_id,
							'amount' => $this->input->post('price'),
							'currency' => 'ZAR',
							'payment_status' => 'initiated',
							'status' => 0,
						);

						PriceHistory::create($data3);

						$data1 = array(
							'price' => $this->input->post('price'),
							'extra_work' => 1
						);
						$chatroom->update_attributes($data1);

						$data2 = array(
							'chat_room_id' => $chat_room_id,
							'user_id' => $this->ion_auth->user()->row()->id,
							'message' => $this->input->post('message')
						);
						Chat::create($data2);
						$recipient = User::find_by_id($chatroom->customer_id);

						$user =  Professional::find_by_user_id($this->ion_auth->user()->row()->id);

						foreach ($recipient->user_authentications as $row) {
							$device_id = array($row->device_id);
							if (!empty($device_id)) {
								$this->send_notification($device_id, $user->company_name . ' has updated their price for ' . get_service($qouterequest->quote_request->service_id), 'Price Updated', $user->company_name, 'price_update');
							}
						}

						print_r(json_encode(array("status" => "destination", "destination" => 'professional-messages/' . $chat_room_id, 'message' => 'Your quote updated  successfully.')));
					} else {
						print_r(json_encode(array("status" => "destination", "destination" => 'professional-messages/' . $chat_room_id, 'message' => 'Quote price should not be less than previous price.')));
					}
				} else {

					$data3 = array(
						'chatroom_id' => $chat_room_id,
						'amount' => $this->input->post('price'),
						'currency' => 'ZAR',
						'payment_status' => 'initiated',
						'status' => 0,
					);

					PriceHistory::create($data3);

					$data1 = array(
						'price' => $this->input->post('price')
					);
					$chatroom->update_attributes($data1);

					$data2 = array(
						'chat_room_id' => $chat_room_id,
						'user_id' => $this->ion_auth->user()->row()->id,
						'message' => $this->input->post('message')
					);
					Chat::create($data2);
					$recipient = User::find_by_id($chatroom->customer_id);

					$user =  Professional::find_by_user_id($this->ion_auth->user()->row()->id);

					foreach ($recipient->user_authentications as $row) {
						$device_id = array($row->device_id);
						if (!empty($device_id)) {
							$this->send_notification($device_id, $user->company_name . ' has updated their price for ' . get_service($qouterequest->quote_request->service_id), 'Price Updated', $user->company_name, 'price_update');
						}
					}

					print_r(json_encode(array("status" => "destination", "destination" => 'professional-messages/' . $chat_room_id, 'message' => 'Your quote updated  successfully.')));
				}
			}
		}
	}


	function today_leads()
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('login', 'refresh');
		} else {

			$start_date = date("Y-m-d 00:00:00");
			$end_date = date("Y-m-d 23:59:59");

			$config['per_page'] = 10;
			$config['total_rows'] = ResponseForProposal::count(array('conditions' => array('request_accept = 0 AND  professional_id = ? AND created_at > ? AND created_at < ?', $this->ion_auth->user()->row()->id, $start_date, $end_date)));
			//print_r($config['total_rows']); die;

			$config['base_url'] = base_url('today-leads');
			$page = (null !== $this->input->get('page')) ? $this->input->get('page') : 1;
			$start_index = ($page - 1) * $config['per_page'];

			$this->data['pagination'] = $this->custom_pagination->create_frontend_pagination($config);

			$this->data['title'] = 'New Leads';
			$this->data['requests'] = ResponseForProposal::find('all', array('conditions' => array('request_accept = 0 AND professional_id = ? AND created_at > ? AND created_at < ?', $this->ion_auth->user()->row()->id, $start_date, $end_date),   'order' => 'created_at desc'));

			$this->template->load('frontend/front_base', 'professional/notification', $this->data);
		}
	}

	function yesterday_leads()
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('login', 'refresh');
		} else {
			//print_r($this->db->last_query());
			$start_date = date("Y-m-d 00:00:00", strtotime("-1 days"));
			$end_date = date("Y-m-d 23:59:59", strtotime("-1 days"));
			$config['per_page'] = 10;
			$config['total_rows'] = ResponseForProposal::count(array('conditions' => array('request_accept = 0 AND professional_id = ? AND created_at > ? AND created_at < ?', $this->ion_auth->user()->row()->id, $start_date, $end_date)));
			//print_r($date); die;

			$config['base_url'] = base_url('yesterday-leads');
			$page = (null !== $this->input->get('page')) ? $this->input->get('page') : 1;
			$start_index = ($page - 1) * $config['per_page'];

			$this->data['pagination'] = $this->custom_pagination->create_frontend_pagination($config);

			$this->data['title'] = 'New Leads';
			$this->data['requests'] = ResponseForProposal::find('all', array('conditions' => array('request_accept = 0 AND professional_id = ? AND created_at > ? AND created_at < ?', $this->ion_auth->user()->row()->id, $start_date, $end_date),  'limit' => $config['per_page'], 'offset' => $start_index,  'order' => 'created_at desc'));

			$this->template->load('frontend/front_base', 'professional/notification', $this->data);
		}
	}

	function current_week_leads()
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('login', 'refresh');
		} else {
			//print_r($this->db->last_query());
			$start_date = date("Y-m-d 00:00:00", strtotime("-7 days"));
			$end_date = date("Y-m-d 23:59:59");
			$config['per_page'] = 10;
			$config['total_rows'] = ResponseForProposal::count(array('conditions' => array('request_accept = 0 AND professional_id = ? AND created_at > ? AND created_at < ?', $this->ion_auth->user()->row()->id, $start_date, $end_date)));
			//print_r($config['total_rows']); die;

			$config['base_url'] = base_url('current-week-leads');
			$page = (null !== $this->input->get('page')) ? $this->input->get('page') : 1;
			$start_index = ($page - 1) * $config['per_page'];

			$this->data['pagination'] = $this->custom_pagination->create_frontend_pagination($config);

			$this->data['title'] = 'New Leads';
			$this->data['requests'] = ResponseForProposal::find('all', array('conditions' => array('request_accept = 0 AND professional_id = ? AND created_at > ? AND created_at < ?', $this->ion_auth->user()->row()->id, $start_date, $end_date),  'limit' => $config['per_page'], 'offset' => $start_index,  'order' => 'created_at desc'));

			$this->template->load('frontend/front_base', 'professional/notification', $this->data);
		}
	}


	public function ongoing_leads()
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('login', 'refresh');
		} else {

			$config['per_page'] = 10;
			$config['total_rows'] = ResponseForProposal::count(array('conditions' => array(' request_accept = 1 AND professional_id = ?', $this->ion_auth->user()->row()->id)));
			$config['base_url'] = base_url('ongoing-leads');
			$page = (null !== $this->input->get('page')) ? $this->input->get('page') : 1;
			$start_index = ($page - 1) * $config['per_page'];

			$this->data['pagination'] = $this->custom_pagination->create_frontend_pagination($config);

			$this->data['title'] = 'Ongoing Leads';
			$this->data['requests'] = ResponseForProposal::find('all', array('conditions' => array('request_accept = 1 AND professional_id = ?', $this->ion_auth->user()->row()->id),  'limit' => $config['per_page'], 'offset' => $start_index,  'order' => 'created_at desc'));
			$this->template->load('frontend/front_base', 'professional/ongoing_leads', $this->data);
		}
	}


	function today_onging_leads()
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('login', 'refresh');
		} else {

			$start_date = date("Y-m-d 00:00:00");
			$end_date = date("Y-m-d 23:59:59");

			$config['per_page'] = 10;
			$config['total_rows'] = ResponseForProposal::count(array('conditions' => array('request_accept = 1 AND  professional_id = ? AND created_at > ? AND created_at < ?', $this->ion_auth->user()->row()->id, $start_date, $end_date)));
			//print_r($config['total_rows']); die;

			$config['base_url'] = base_url('today-ongoing-leads');
			$page = (null !== $this->input->get('page')) ? $this->input->get('page') : 1;
			$start_index = ($page - 1) * $config['per_page'];

			$this->data['pagination'] = $this->custom_pagination->create_frontend_pagination($config);

			$this->data['title'] = 'Ongoing Leads';
			$this->data['requests'] = ResponseForProposal::find('all', array('conditions' => array('request_accept = 1 AND professional_id = ? AND created_at > ? AND created_at < ?', $this->ion_auth->user()->row()->id, $start_date, $end_date),   'order' => 'created_at desc'));

			$this->template->load('frontend/front_base', 'professional/ongoing_leads', $this->data);
		}
	}

	function yesterday_ongoing_leads()
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('login', 'refresh');
		} else {
			//print_r($this->db->last_query());
			$start_date = date("Y-m-d 00:00:00", strtotime("-1 days"));
			$end_date = date("Y-m-d 23:59:59", strtotime("-1 days"));
			$config['per_page'] = 10;
			$config['total_rows'] = ResponseForProposal::count(array('conditions' => array('request_accept = 1 AND professional_id = ? AND created_at > ? AND created_at < ?', $this->ion_auth->user()->row()->id, $start_date, $end_date)));
			//print_r($date); die;

			$config['base_url'] = base_url('yesterday-ongoing-leads');
			$page = (null !== $this->input->get('page')) ? $this->input->get('page') : 1;
			$start_index = ($page - 1) * $config['per_page'];

			$this->data['pagination'] = $this->custom_pagination->create_frontend_pagination($config);

			$this->data['title'] = 'Ongoing Leads';
			$this->data['requests'] = ResponseForProposal::find('all', array('conditions' => array('request_accept = 1 AND professional_id = ? AND created_at > ? AND created_at < ?', $this->ion_auth->user()->row()->id, $start_date, $end_date),  'limit' => $config['per_page'], 'offset' => $start_index,  'order' => 'created_at desc'));

			$this->template->load('frontend/front_base', 'professional/ongoing_leads', $this->data);
		}
	}

	function current_week_ongoing_leads()
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('login', 'refresh');
		} else {
			//print_r($this->db->last_query());
			$start_date = date("Y-m-d 00:00:00", strtotime("-7 days"));
			$end_date = date("Y-m-d 23:59:59");
			$config['per_page'] = 10;
			$config['total_rows'] = ResponseForProposal::count(array('conditions' => array('request_accept = 1 AND professional_id = ? AND created_at > ? AND created_at < ?', $this->ion_auth->user()->row()->id, $start_date, $end_date)));
			//print_r($config['total_rows']); die;

			$config['base_url'] = base_url('current-week-ongoing-leads');
			$page = (null !== $this->input->get('page')) ? $this->input->get('page') : 1;
			$start_index = ($page - 1) * $config['per_page'];

			$this->data['pagination'] = $this->custom_pagination->create_frontend_pagination($config);

			$this->data['title'] = 'Ongoing Leads';
			$this->data['requests'] = ResponseForProposal::find('all', array('conditions' => array('request_accept = 1 AND professional_id = ? AND created_at > ? AND created_at < ?', $this->ion_auth->user()->row()->id, $start_date, $end_date),  'limit' => $config['per_page'], 'offset' => $start_index,  'order' => 'created_at desc'));

			$this->template->load('frontend/front_base', 'professional/ongoing_leads', $this->data);
		}
	}


	function converted_leads()
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('login', 'refresh');
		} else {

			$config['per_page'] = 10;
			$config['total_rows'] = ResponseForProposal::count(array('conditions' => array(' request_accept >= 2 AND professional_id = ?', $this->ion_auth->user()->row()->id)));
			$config['base_url'] = base_url('ongoing-leads');
			$page = (null !== $this->input->get('page')) ? $this->input->get('page') : 1;
			$start_index = ($page - 1) * $config['per_page'];

			$this->data['pagination'] = $this->custom_pagination->create_frontend_pagination($config);

			$this->data['title'] = 'Converted Leads';
			$this->data['requests'] = ResponseForProposal::find('all', array('conditions' => array('request_accept >= 2 AND professional_id = ?', $this->ion_auth->user()->row()->id),  'limit' => $config['per_page'], 'offset' => $start_index,  'order' => 'created_at desc'));
			$this->template->load('frontend/front_base', 'professional/converted_leads', $this->data);
		}
	}


	function today_converted_leads()
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('login', 'refresh');
		} else {

			$start_date = date("Y-m-d 00:00:00");
			$end_date = date("Y-m-d 23:59:59");

			$config['per_page'] = 10;
			$config['total_rows'] = ResponseForProposal::count(array('conditions' => array('request_accept >= 2 AND  professional_id = ? AND created_at > ? AND created_at < ?', $this->ion_auth->user()->row()->id, $start_date, $end_date)));
			//print_r($config['total_rows']); die;

			$config['base_url'] = base_url('today-ongoing-leads');
			$page = (null !== $this->input->get('page')) ? $this->input->get('page') : 1;
			$start_index = ($page - 1) * $config['per_page'];

			$this->data['pagination'] = $this->custom_pagination->create_frontend_pagination($config);

			$this->data['title'] = 'Converted Leads';
			$this->data['requests'] = ResponseForProposal::find('all', array('conditions' => array('request_accept >= 2 AND professional_id = ? AND created_at > ? AND created_at < ?', $this->ion_auth->user()->row()->id, $start_date, $end_date),   'order' => 'created_at desc'));

			$this->template->load('frontend/front_base', 'professional/converted_leads', $this->data);
		}
	}


	function yesterday_converted_leads()
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('login', 'refresh');
		} else {
			//print_r($this->db->last_query());
			$start_date = date("Y-m-d 00:00:00", strtotime("-1 days"));
			$end_date = date("Y-m-d 23:59:59", strtotime("-1 days"));
			$config['per_page'] = 10;
			$config['total_rows'] = ResponseForProposal::count(array('conditions' => array('request_accept >= 2 AND professional_id = ? AND created_at > ? AND created_at < ?', $this->ion_auth->user()->row()->id, $start_date, $end_date)));
			//print_r($date); die;

			$config['base_url'] = base_url('yesterday-ongoing-leads');
			$page = (null !== $this->input->get('page')) ? $this->input->get('page') : 1;
			$start_index = ($page - 1) * $config['per_page'];

			$this->data['pagination'] = $this->custom_pagination->create_frontend_pagination($config);

			$this->data['title'] = 'Converted Leads';
			$this->data['requests'] = ResponseForProposal::find('all', array('conditions' => array('request_accept >= 2 AND professional_id = ? AND created_at > ? AND created_at < ?', $this->ion_auth->user()->row()->id, $start_date, $end_date),  'limit' => $config['per_page'], 'offset' => $start_index,  'order' => 'created_at desc'));

			$this->template->load('frontend/front_base', 'professional/converted_leads', $this->data);
		}
	}


	function current_week_converted_leads()
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('login', 'refresh');
		} else {
			//print_r($this->db->last_query());
			$start_date = date("Y-m-d 00:00:00", strtotime("-7 days"));
			$end_date = date("Y-m-d 23:59:59");
			$config['per_page'] = 10;
			$config['total_rows'] = ResponseForProposal::count(array('conditions' => array('request_accept >= 2 AND professional_id = ? AND created_at > ? AND created_at < ?', $this->ion_auth->user()->row()->id, $start_date, $end_date)));
			//print_r($config['total_rows']); die;

			$config['base_url'] = base_url('current-week-ongoing-leads');
			$page = (null !== $this->input->get('page')) ? $this->input->get('page') : 1;
			$start_index = ($page - 1) * $config['per_page'];

			$this->data['pagination'] = $this->custom_pagination->create_frontend_pagination($config);

			$this->data['title'] = 'Converted Leads';
			$this->data['requests'] = ResponseForProposal::find('all', array('conditions' => array('request_accept >= 2 AND professional_id = ? AND created_at > ? AND created_at < ?', $this->ion_auth->user()->row()->id, $start_date, $end_date),  'limit' => $config['per_page'], 'offset' => $start_index,  'order' => 'created_at desc'));

			$this->template->load('frontend/front_base', 'professional/converted_leads', $this->data);
		}
	}
}
