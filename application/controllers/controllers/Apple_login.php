<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Apple_login extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    function login() {
 if($_POST){
            $jwt = $_POST["id_token"];
            $jwt_array = explode('.', $jwt);
            $user_details = json_decode(base64_decode($jwt_array[1]));
            
            $current_datetime = date('Y-m-d H:i:s');
            $user = User::find(array("conditions" => array("oauth_provider = ? AND email = ? AND oauth_provider_id = ?",'apple',$user_details->email, $user_details->sub)));
            //print_r($user);exit;
            if ($user){
                //update data
                $user_data = array(
                    'first_name'=> $user->first_name,
                    'last_name' => $user->last_name,
                    'ip_address'=> $this->input->ip_address(),
                    'email' => $user->email,
                    'identity' => $user->email,
		    'user_id' => $user->id
                );
                $user->last_login = time();
                $user->save();
            }else {
                
                $apple_user = $_POST["user"];
                //print_r($user_details);exit;
                $apple_user_arr = json_decode($apple_user);
                $first_name = $apple_user_arr->name->firstName;
                $last_name = $apple_user_arr->name->lastName;
                $email_address = $apple_user_arr->email;
                
//                echo '<pre>';print_r($user_details);exit;
                
                
                    //insert data
                    $user_data = array(
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'email' => $email_address,
                        'username' => $email_address,
                        'oauth_provider' => 'apple',
                        'oauth_provider_id' => $user_details->sub,
                        'created_at' => $current_datetime,
                        'ip_address'      => $this->input->ip_address(),
                        'last_login' => time(),
                        'created_on' => $current_datetime,
                        'password' => "",
                        'terms_conditions' => 0
                    );

                    $user = User::create($user_data);
                    
                    $user_group_data = array(
                        "user_id" => $user->id,
                        "group_id" => 2
                    );
                    UsersGroup::create($user_group_data);

                    $user_data["identity"] = $email_address;
                    $user_data["user_id"] = $user->id;
                    
                }
                
            $this->session->set_userdata($user_data);
            redirect(base_url('my-bookings'), $data);
       }else{
            redirect(base_url('login'));  
       }
        
    }

    function logout() {
        $this->session->unset_userdata('access_token');

        $this->session->unset_userdata('user_data');

        redirect('google_login/login');
    }

}

?>
