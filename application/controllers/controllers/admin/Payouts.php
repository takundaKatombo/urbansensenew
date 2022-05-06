<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payouts extends CI_Controller {


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
			$date =  date('Y-m-d 23:59:59',strtotime("-7 day"));
			$config['per_page'] = 20;
	        $config['total_rows'] = Booking::count(array('conditions'=>array('booked_status=? AND created_at <= ?','success',$date)));
	        $config['base_url'] = base_url('admin/Payouts');
	        $page = (null !== $this->input->get('page')) ? $this->input->get('page') : 1;
	        $start_index = ($page - 1) * $config['per_page'];
	      
			$this->data['title'] = 'Payout';
			
			//print_r($date); die;
			$payment = Booking::all(array('limit'=>$config['per_page'], 'offset' => $start_index, 'order' => 'created_at desc','conditions'=>array('booked_status=? AND created_at <= ?','success',$date)));
			//print_r($payment); die;
			$this->data['payments'] = $payment;
			$this->data['pagination'] = $this->custom_pagination->create_backend_pagination($config);
			$this->template->load('admin/admin_base','admin/payout/payout_list',$this->data);
		}
	}


	public function create(){
		
		if (!$this->ion_auth->logged_in()){
			redirect('admin/auth/login', 'refresh');
		} else {
			$bookings = Booking::find_by_id($this->input->post('booking_id'));

			Payout::create($this->input->post());
			$bookings->update_attributes(array('paidto_professional'=>1));
			
			
			$this->session->set_flashdata('success', 'Amount has been paid successfully to service provider');
			redirect('admin/Payouts');
		}
	}


	function payout_search(){
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
		        $company = Professional::find(array('select'=>'user_id', 'conditions'=>array('company_name = ?',$name)));
		        if($company != ''){
		        	$user_id = $company->user_id;
		        }

		       // print_r($user_id);

		        $service_id = '';
		        $service = Service::find(array('select'=>'id', 'conditions'=>array('title = ?',$name)));
		        if($service != ''){
		        	$service_id = $service->id;
		        }

		        $conditions .=  " and (payment_key ='" . $name . "' OR booking_reference_number ='" . $name . "' OR professional_id ='".$user_id."')";
	        }

	        if ($status != '') {
	          	$conditions .=  " AND (paidto_professional = '".$status."')";
	        }

	       
	        //print_r($conditions); 
	        $date =  date('Y-m-d 23:59:59',strtotime("-7 day"));
	        $conditions .=  " AND ( created_at <= '".$date."')";
			$this->data['title'] = 'Payout Report';
			$bookings = Booking::all(array('order' => 'created_at desc','conditions'=>array("status = '1' AND booked_status='success' ". $conditions)));
			/*$bookings = Payout::all(array('order' => 'created_at desc','conditions'=>array("status = '1' ". $conditions)));*/
			$this->data['payments'] = $bookings;
			$this->template->load('admin/admin_base','admin/payout/payout_list',$this->data);
		}
	}



		function payout_report(){
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
		        $company = Professional::find(array('select'=>'user_id', 'conditions'=>array('company_name = ?',$name)));
		        if($company != ''){
		        	$user_id = $company->user_id;
		        }

		       // print_r($user_id);

		        $service_id = '';
		        $service = Service::find(array('select'=>'id', 'conditions'=>array('title = ?',$name)));
		        if($service != ''){
		        	$service_id = $service->id;
		        }

		        $conditions .=  " and (payment_key ='" . $name . "' OR booking_reference_number ='" . $name . "' OR professional_id ='".$user_id."')";
	        }

	        if ($status != '') {
	          	$conditions .=  " AND (booked_status = '".$status."')";
	        }

	        $date =  date('Y-m-d 23:59:59',strtotime("-7 day"));
	        $conditions .=  " AND ( created_at <= '".$date."')";
	        //print_r($conditions); 
			$this->data['title'] = 'Payout Report';
			$bookings = Payout::all(array('order' => 'created_at desc','conditions'=>array("status = '1' ". $conditions)));
			$this->data['payments'] = $bookings;
			$this->template->load('admin/admin_base','admin/payout/payout_reports',$this->data);
		}
	}



	


        public function exports_payout_report(){

        	$conditions = '';
			$name = $this->input->get("name");

			if($this->input->get("start_date") AND $this->input->get("end_date")){
	  			$conditions .= " and created_at BETWEEN '{$this->input->get("start_date")}' and '{$this->input->get("end_date")}'";
	  		}

	 		
		    if ($name != '') {

		    	$user_id = '';
		        $company = Professional::find(array('select'=>'user_id', 'conditions'=>array('company_name = ?',$name)));
		        if($company != ''){
		        	$user_id = $company->user_id;
		        }

		       // print_r($user_id);

		        $service_id = '';
		        $service = Service::find(array('select'=>'id', 'conditions'=>array('title = ?',$name)));
		        if($service != ''){
		        	$service_id = $service->id;
		        }

		        $conditions .=  " and (payment_key ='" . $name . "' OR booking_reference_number ='" . $name . "' OR professional_id ='".$user_id."')";
	        } 

	      	$date =  date('Y-m-d 23:59:59',strtotime("-7 day"));
	        $conditions .=  " AND ( created_at <= '".$date."')";
			$payouts = Payout::all(array('order' => 'created_at desc','conditions'=>array("status = '1' ")));
			$data = array();
			$data[] = array('CompanyName' => 'Company Name',
					'Email' => 'Email',
					'BookingID' => 'Booking ID',
					'PaymentKey' => 'Payment Key',
					'total_amount' => 'Total Amount (ZAR)',
					'payable_amount' => 'Payable Amount (ZAR)',
					'booking_date' => 'Booking Date',
					'paid_date' => 'Paid Date');
			foreach ($payouts as $row) {
				$data[] = array(
					'CompanyName' => get_user($row->professional_id)->professionals->company_name,
					'Email' => get_user($row->professional_id)->email,
					'BookingID' => $row->booking_reference_number,
					'PaymentKey' => $row->payment_key,
					'total_amount' => $row->total_amount,
					'payable_amount' => $row->payable_amount,
					'booking_date' => date('d/m/Y h:i s',strtotime($row->booking_date)),
					'paid_date' => date('d/m/Y h:i s',strtotime($row->created_at))

				);
			}
		

          
            header("Content-type: application/csv");
            header("Content-Disposition: attachment; filename=\"test".".csv\"");
            header("Pragma: no-cache");
            header("Expires: 0");

            $handle = fopen('php://output', 'w');

            foreach ($data as $data) {
                fputcsv($handle, $data);
            }
                fclose($handle);
            exit;
        }

}