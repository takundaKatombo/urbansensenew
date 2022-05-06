<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboards extends CI_Controller {


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
			$this->data['total_service_provider'] = Professional::count();
			$user = User::count();
			$this->data['total_customer'] = ($user - $this->data['total_service_provider']);
			$this->data['total_service'] = Service::count();
			$this->data['total_booking'] = Booking::count(array('conditions'=>array('booked_status = ?','success')));
			$date =  date('Y-m-d 23:59:59',strtotime("-7 day"));
			$this->data['today_payout'] =  Booking::count(array('conditions'=>array('booked_status=? AND created_at <= ? AND paidto_professional = ?','success',$date,0))); 

			$lfirst_day = date('Y-m-d 23:59:59');
			$ffirst_day = date('Y-m-d 00:00:00');
			$query1 = " and created_at BETWEEN '{$ffirst_day}' and '{$lfirst_day}'";

           	$lsecond_day = date('Y-m-d 23:59:59', strtotime("-1 day"));
           	$fsecond_day = date('Y-m-d 00:00:00', strtotime("-1 day"));
           	$query2 = " and created_at BETWEEN '{$fsecond_day}' and '{$lsecond_day}'";

           	$lthird_day = date('Y-m-d 23:59:59', strtotime("-2 day"));
           	$fthird_day = date('Y-m-d 00:00:00', strtotime("-2 day"));
           	$query3 = " and created_at BETWEEN '{$fthird_day}' and '{$lthird_day}'";

           	$lfourth_day = date('Y-m-d 23:59:59', strtotime("-3 day"));
           	$ffourth_day = date('Y-m-d 00:00:00', strtotime("-3 day"));
           	$query4 = " and created_at BETWEEN '{$ffourth_day}' and '{$lfourth_day}'";

           	$lfifth_day = date('Y-m-d 23:59:59', strtotime("-4 day"));
           	$ffifth_day = date('Y-m-d 00:00:00', strtotime("-4 day"));
           	$query5 = " and created_at BETWEEN '{$ffifth_day}' and '{$lfifth_day}'";

           	$lsix_day = date('Y-m-d 23:59:59', strtotime("-5 day"));
           	$fsix_day = date('Y-m-d 00:00:00', strtotime("-5 day"));
           	$query6 = " and created_at BETWEEN '{$fsix_day}' and '{$lsix_day}'";

           	$lseventh_day = date('Y-m-d 23:59:59', strtotime("-6 day"));
           	$fseventh_day = date('Y-m-d 00:00:00', strtotime("-6 day"));
           	$query7 = " and created_at BETWEEN '{$fseventh_day}' and '{$lseventh_day}'";

           

			$data = array(
				'first_day' => Booking::find(array('select'=>'count(id) as total_booking', 'conditions'=>array('booked_status = "success"'. $query1))),
				'second_day' => Booking::find(array('select'=>'count(id) as total_booking', 'conditions'=>array('booked_status = "success"'. $query2))),
				'third_day' => Booking::find(array('select'=>'count(id) as total_booking', 'conditions'=>array('booked_status = "success"'. $query3))),
				'fourth_day' => Booking::find(array('select'=>'count(id) as total_booking', 'conditions'=>array('booked_status = "success"'. $query4))),
				'fifth_day' => Booking::find(array('select'=>'count(id) as total_booking', 'conditions'=>array('booked_status = "success"'. $query5))),
				'sixth_day' => Booking::find(array('select'=>'count(id) as total_booking', 'conditions'=>array('booked_status = "success"'. $query6))),
				'seventh_day' => Booking::find(array('select'=>'count(id) as total_booking', 'conditions'=>array('booked_status = "success"'. $query7))),
			
				'first_day_customer' => UsersGroup::find(array('select'=>'count(id) as total_customer', 'conditions'=>array('group_id = "2"'. $query1))),
				'second_day_customer' => UsersGroup::find(array('select'=>'count(id) as total_customer', 'conditions'=>array('group_id = "2"'. $query2))),
				'third_day_customer' => UsersGroup::find(array('select'=>'count(id) as total_customer', 'conditions'=>array('group_id = "2"'. $query3))),
				'fourth_day_customer' => UsersGroup::find(array('select'=>'count(id) as total_customer', 'conditions'=>array('group_id = "2"'. $query4))),
				'fifth_day_customer' => UsersGroup::find(array('select'=>'count(id) as total_customer', 'conditions'=>array('group_id = "2"'. $query5))),
				'sixth_day_customer' => UsersGroup::find(array('select'=>'count(id) as total_customer', 'conditions'=>array('group_id = "2"'. $query6))),
				'seventh_day_customer' => UsersGroup::find(array('select'=>'count(id) as total_customer', 'conditions'=>array('group_id = "2"'. $query7))),
			);

			//echo "<pre>"; print_r($data); die;


			$this->template->load('admin/admin_base','admin/dashboard',array_merge($data,$this->data));
		}
	}
}
