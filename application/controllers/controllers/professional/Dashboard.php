<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once FCPATH . 'dompdf/autoload.inc.php';

// reference the Dompdf namespace
use Dompdf\Dompdf;


class Dashboard extends MY_Controller {


	public function __construct(){
		parent::__construct();
		
	}

	public function index(){
		if (!$this->ion_auth->logged_in()){
			redirect('login', 'refresh');
		} else {
			//$this->data['total_booking'] = Booking::count(array('conditions'=>array('professional_id = ?',$this->ion_auth->user()->row()->id)));

			$this->data['booking'] = Booking::find(array('select'=>'sum(amount_paid) as total_payment, count(id) as total_booking', 'conditions'=>array('booked_status = "success" AND professional_id = ?',$this->ion_auth->user()->row()->id)));
			$this->data['new_leads'] = ResponseForProposal::count(array('conditions'=>array(' is_view = 0 AND professional_id = ? ',$this->ion_auth->user()->row()->id)));

			$this->data['recent_booking'] = Booking::find('all', array('limit'=>4, 'order'=> 'created_at desc', 'conditions'=>array('booked_status = "success" AND professional_id = ?',$this->ion_auth->user()->row()->id)));

			$this->data['recent_payment'] = Payment::find('all', array('conditions'=>array('payment_status = "success" AND professional_id = ?',$this->ion_auth->user()->row()->id), 'limit'=>4, 'order' => 'created_at desc'));

			$chat_room = ChatRoom::find('all', array('conditions'=>array('professional_id = ?',$this->ion_auth->user()->row()->id)));
			$total_message = 0;
			foreach ($chat_room as $row) {
				$total_message	= Chat::count(array('conditions' => array('chat_room_id = ? AND is_view_professional = ?',$row->id,0))) + $total_message;

			}

			$this->data['new_message'] = $total_message;

			$lfirst_day = date('Y-m-d 23:59:59');
			$ffirst_day = date('Y-m-d 00:00:00');
			$query1 = " and created_at BETWEEN '{$ffirst_day}' and '{$lfirst_day}' and professional_id =".$this->ion_auth->user()->row()->id;

           	$lsecond_day = date('Y-m-d 23:59:59', strtotime("-1 day"));
           	$fsecond_day = date('Y-m-d 00:00:00', strtotime("-1 day"));
           	$query2 = " and created_at BETWEEN '{$fsecond_day}' and '{$lsecond_day}' and professional_id =".$this->ion_auth->user()->row()->id;


           	$lthird_day = date('Y-m-d 23:59:59', strtotime("-2 day"));
           	$fthird_day = date('Y-m-d 00:00:00', strtotime("-2 day"));
           	$query3 = " and created_at BETWEEN '{$fthird_day}' and '{$lthird_day}' and professional_id =".$this->ion_auth->user()->row()->id;


           	$lfourth_day = date('Y-m-d 23:59:59', strtotime("-3 day"));
           	$ffourth_day = date('Y-m-d 00:00:00', strtotime("-3 day"));
           	$query4 = " and created_at BETWEEN '{$ffourth_day}' and '{$lfourth_day}' and professional_id =".$this->ion_auth->user()->row()->id;


           	$lfifth_day = date('Y-m-d 23:59:59', strtotime("-4 day"));
           	$ffifth_day = date('Y-m-d 00:00:00', strtotime("-4 day"));
           	$query5 = " and created_at BETWEEN '{$ffifth_day}' and '{$lfifth_day}' and professional_id =".$this->ion_auth->user()->row()->id;


           	$lsix_day = date('Y-m-d 23:59:59', strtotime("-5 day"));
           	$fsix_day = date('Y-m-d 00:00:00', strtotime("-5 day"));
           	$query6 = " and created_at BETWEEN '{$fsix_day}' and '{$lsix_day}' and professional_id =".$this->ion_auth->user()->row()->id;


           	$lseventh_day = date('Y-m-d 23:59:59', strtotime("-6 day"));
           	$fseventh_day = date('Y-m-d 00:00:00', strtotime("-6 day"));
           	$query7 = " and created_at BETWEEN '{$fseventh_day}' and '{$lseventh_day}' and professional_id =".$this->ion_auth->user()->row()->id;


           

			$data = array(
				'first_day' => Booking::find(array('select'=>'count(id) as total_booking', 'conditions'=>array('booked_status = "success"'.$query1))),
				'second_day' => Booking::find(array('select'=>'count(id) as total_booking', 'conditions'=>array('booked_status = "success"'.$query2))),
				'third_day' => Booking::find(array('select'=>'count(id) as total_booking', 'conditions'=>array('booked_status = "success"'.$query3))),
				'fourth_day' => Booking::find(array('select'=>'count(id) as total_booking', 'conditions'=>array('booked_status = "success"'.$query4))),
				'fifth_day' => Booking::find(array('select'=>'count(id) as total_booking', 'conditions'=>array('booked_status = "success"'.$query5))),
				'sixth_day' => Booking::find(array('select'=>'count(id) as total_booking', 'conditions'=>array('booked_status = "success"'.$query6))),
				'seventh_day' => Booking::find(array('select'=>'count(id) as total_booking', 'conditions'=>array('booked_status = "success"'.$query7))),
			);

			
			$this->template->load('frontend/front_base','professional/dashboard',array_merge($data,$this->data));
		}
	}



	public function bookings(){
		if (!$this->ion_auth->logged_in()){
			redirect('login', 'refresh');
		} else {

			$config['per_page'] = 10;
			$config['total_rows'] = Booking::count('all', array('conditions'=>array('booked_status = "success" AND professional_id = ?',$this->ion_auth->user()->row()->id)));
	        $config['base_url'] = base_url('booking-view');
	        $page = (null !== $this->input->get('page')) ? $this->input->get('page') : 1;
	        $start_index = ($page - 1) * $config['per_page'];

			$this->data['bookings'] =  Booking::find('all', array('conditions'=>array('booked_status = "success" AND professional_id = ?',$this->ion_auth->user()->row()->id), 'limit'=>$config['per_page'], 'offset' => $start_index, 'order' => 'created_at desc'));
			$this->data['title'] = 'Booking';
			$this->data['pagination'] = $this->custom_pagination->create_frontend_pagination($config);
			$this->template->load('frontend/front_base','professional/booking',$this->data);
		}
	}


	public function booking_details($id=null){
		if (!$this->ion_auth->logged_in()){
			redirect('login', 'refresh');
		} else {
			$this->data['booking'] =  Booking::find_by_id($id);
			$this->data['title'] = 'Booking Details';
			$this->template->load('frontend/front_base','professional/booking_details',$this->data);
		}
	}


	public function payments(){
		if (!$this->ion_auth->logged_in()){
			redirect('login', 'refresh');
		} else {

			$config['per_page'] = 10;
			$config['total_rows'] = Payment::count('all', array('conditions'=>array('payment_status = "success" AND professional_id = ?',$this->ion_auth->user()->row()->id)));
	        $config['base_url'] = base_url('booking-view');
	        $page = (null !== $this->input->get('page')) ? $this->input->get('page') : 1;
	        $start_index = ($page - 1) * $config['per_page'];

			$this->data['payments'] =  Payment::find('all', array('conditions'=>array('payment_status = "success" AND professional_id = ?',$this->ion_auth->user()->row()->id), 'limit'=>$config['per_page'], 'offset' => $start_index, 'order' => 'created_at desc'));
			$this->data['title'] = 'Payment';
			$this->data['pagination'] = $this->custom_pagination->create_frontend_pagination($config);
			$this->template->load('frontend/front_base','professional/payments',$this->data);
		}
	}


	public function payments_details($id=null){
		if (!$this->ion_auth->logged_in()){
			redirect('login', 'refresh');
		} else {
			$this->data['payment'] =  Payment::find_by_id($id);
			$this->data['title'] = 'Payment Details';
			$this->template->load('frontend/front_base','professional/payment_details',$this->data);
		}
	}

	function download_invoice($id=null){
		if(!$this->ion_auth->logged_in()){ 
			redirect('login');
		} else {

			$booking = Booking::find(array('conditions'=>array('payment_key = ? AND booked_status = ? ',$id,'success')));
	        
			$this->data['booking'] = $booking;
	        $this->data['professional'] = User::find_by_id($booking->professional_id);

	        $html = $this->load->view('emails/invoice', $this->data, true);
	        $dompdf = new Dompdf();
	        $dompdf->loadHtml(utf8_encode($html));
	        // (Optional) Setup the paper size and orientation
	        $dompdf->setPaper('A4', 'portrait');
	        // Render the HTML as PDF
	        $dompdf->render();
	    	// Output the generated PDF to Browser
			$dompdf->stream();
			
		}
	}

}