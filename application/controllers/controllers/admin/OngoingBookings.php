<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class OngoingBookings extends CI_Controller{
	
	public function __construct(){
		parent::__construct();

		if($this->ion_auth->is_admin()){
			 return true;
		} else{
			$this->session->set_flashdata("warning",'You must be an administrator to view this page.');
			redirect(base_url('logout')); 
		}
	}


	public function index(){
		if (!$this->ion_auth->logged_in()){
			redirect('admin/auth/login', 'refresh');
		} else {
			
			$config['per_page'] = 20;
	        $config['total_rows'] = QuoteRequest::count();
	        $config['base_url'] = base_url('admin/OngoingBookings');
	        $page = (null !== $this->input->get('page')) ? $this->input->get('page') : 1;
	        $start_index = ($page - 1) * $config['per_page'];
	      
			$this->data['title'] = 'Ongoing Bookings';
			$booking = QuoteRequest::find('all',array('limit'=>$config['per_page'], 'offset' => $start_index, 'order' => 'created_at desc'));
			$this->data['bookings'] = $booking;
			$this->data['pagination'] = $this->custom_pagination->create_backend_pagination($config);
			$this->template->load('admin/admin_base','admin/booking/ongoing_booking_list',$this->data);
		}
	}


	public function booking_details($id){
		if (!$this->ion_auth->logged_in()){
			redirect('admin/auth/login', 'refresh');
		} else {
			$this->data['title'] = 'Ongoing Bookings Details';
			$booking = QuoteRequest::find(array('conditions' => array('id=?',$id)));
			$this->data['booking'] = $booking;
			$this->template->load('admin/admin_base','admin/booking/ongoing_booking_details',$this->data);
		}
	}



	function search_bookings(){
		if (!$this->ion_auth->logged_in()){
			redirect('admin/auth/login', 'refresh');
		} else {
			
			$conditions = '';
			$name = $this->input->get("name");
			$status = $this->input->get("status");
			$start_date = $this->input->get("start_date") ? date('Y-m-d',strtotime($this->input->get("start_date"))) : '';
		    $end_date = $this->input->get("end_date") ?  date('Y-m-d',strtotime($this->input->get("end_date"))) : '';

			if($start_date AND $end_date){
	  			$conditions .= " AND created_at BETWEEN "."'".$start_date." 00:00:00'"." AND "."'".$end_date. " 23:59:59'"."";
	  		}

	 		if ($name != '') {

		    	$user_id = '';
		        $user = User::find(array('select'=>'id', 'conditions'=>array('email = ? or phone = ?',$name,$name)));
		        if($user != ''){
		        	$user_id = $user->id;
		        }

		       // print_r($user_id);

		        $service_id = '';
		        $service = Service::find(array('select'=>'id', 'conditions'=>array('title = ?',$name)));
		        if($service != ''){
		        	$service_id = $service->id;
		        }

		        $conditions .=  " and ( user_id ='".$user_id."' OR service_id ='" . $service_id."')";
	        } 

		    

	        if ($status != '') {
	          	$conditions .=  " AND (status = '".$status."')";
	        }

			$this->data['title'] = 'Ongoing Booking';
			$bookings = QuoteRequest::all(array('order' => 'created_at desc','conditions'=>array("by_phone_and_email = '0' ". $conditions)));
			$this->data['bookings'] = $bookings;
			$this->template->load('admin/admin_base','admin/booking/ongoing_booking_list',$this->data);
		}
	}
}