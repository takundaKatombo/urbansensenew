<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Payments
 *
 * @author saurabh
 */
class PushNotification extends CI_Controller{

    function __construct(){
        parent::__construct();

    }


    // this function will redirect to book service page
    function index(){
        $this->subscribe();
    }


    function send_notification($recipients, $message) {
        $tmp = $recipients;
       // print_r(array($tmp)); die;
        $content = array(
            "en" => $message
        );

        $fields = array(
            'app_id' => "efdb603d-de47-4aa0-bb00-86a42f6d9bcd",         
            'contents' => $content,
            'include_player_ids' => array('b7aba538-1941-4cb7-8234-ff1eec223be4'),
        );
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
            'Authorization: Basic YmIyZGY5ZDYtNTlhNC00MWRhLTlkZWItN2YwNjA4YTMwODk1'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);
      
       return true;
    }

    // this function to load service book page
    function subscribe(){
        $this->load->view('site_subscribe');
    }

    /**
     * Create New Notification
     *
     * Creates adjacency list based on item (id or slug) and shows leafs related only to current item
     *
     * @param int $user_id Current user id
     * @param string $title Current title
     *
     * @return string $response
     */
    function send_message(){
        $message = $this->input->post("message");
        $user_id = $this->input->post("user_id");
        $content = array(
            "en" => "$message"
        );

        $fields = array(
            'app_id' => "23fc4864-d513-4ea9-948d-567fcd9cd3ae",
            'filters' => array(array("field" => "tag", "key" => "user_id", "relation" => "=", "value" => "$user_id")),
            'contents' => $content
        );

        $fields = json_encode($fields);
        print("\nJSON sent:\n");
        print($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
            'Authorization: Basic N2E2YTBkMmEtOGU3Mi00M2U4LThiZTAtMTM5YjBhNTc2NjI4'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);
       print_r($response) ;
    }

}
/* End of file news.php */
/* Location: ./application/controllers/Services.php */

