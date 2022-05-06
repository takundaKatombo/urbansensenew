<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SendReminder extends CI_Controller{
    public function __construct() {
        parent::__construct();
    }

    public function remind_professionals(){
        
        
        //RUN THIS CRON EVERY 1 hour 
        
        $remind_window = 24; // In Hours. Remind professionals before 24 hours

        $date = date('Y-m-d');
        $current_time = date('H:i a');
        
        $next_date = date('Y-m-d', strtotime($date .' +1 day'));
        //echo $next_date;exit;
        $bookings = Booking::all(array("conditions" => array("required_date = ?",$next_date)));
//        echo '<pre>';print_r($bookings);
        foreach($bookings as $booking){
            $booking_time = $booking->required_time;
            $start_time = substr($booking_time, 0,4);
           
            if($current_time == $start_time){
                $professional = Professional::find(array("select" => "u.phone as professional_phone,u.email as professional_email, u.first_name AS fname, u.last_name AS lname","joins" =>"join users u ON u.id = professionals.user_id","conditions" => array("professionals.id = ?", $booking->professional_id)));
                $to_email = $professional->professional_email;
                $to_name = $professional->fname." ".$professional->lname;
                
                $data = array(
                    "booking" => $booking,
                    "name" => $to_name
                );
                $subject = "[URBANSENSE] Your service is scheduled for tomorrow.";
                $message = $this->load->view('emails/service_reminder_email', $data, TRUE);
                $sms_message = $this->load->view('emails/service_reminder_sms', $data, TRUE);

//                $this->custom_email->send($to_email, $to_name, $subject, $message);
                
                //send SMS
                $to_number = "+27".$professional->professional_phone;
//                $to_number = "+919899944398";
                
                $ch = curl_init();
  
                $url = "https://xml2sms.gsm.co.za/send";
                //echo $sms_message;exit;
                $dataArray = ['username' => 'unathi', "password" => 'Mkizozo1', 'number' => $to_number, "message" => $sms_message];

                $data = http_build_query($dataArray);

                $getUrl = $url."?".$data;

                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_URL, $getUrl);
                curl_setopt($ch, CURLOPT_TIMEOUT, 80);

                $response = curl_exec($ch);

                if(curl_error($ch)){
                    echo 'Request Error:' . curl_error($ch);
                }else{
                    echo $response;
                }

                curl_close($ch);
                
                
            }
        }
    }
}
