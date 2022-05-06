<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Google_login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('google_login_model');
    }

    function login() {
        include_once"vendor/autoload.php";
        $this->load->config("google");
        $google_items = config_item("google");
        
        $google_client = new Google_Client();

        $google_client->setClientId($google_items["client_id"]); //Define your ClientID

        $google_client->setClientSecret($google_items["client_secret"]); //Define your Client Secret Key

        $google_client->setRedirectUri(base_url('google_login/login')); //Define your Redirect Uri

        $google_client->addScope('email');
        $google_client->addScope('profile');

        if (isset($_GET["code"])) {
            $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);

            if (!isset($token["error"])) {
                $google_client->setAccessToken($token['access_token']);
                
                $this->session->set_userdata('access_token', $token['access_token']);

                $google_service = new Google_Service_Oauth2($google_client);

                $data = $google_service->userinfo->get();
                //echo '<pre>';print_r($data);exit;
                $current_datetime = date('Y-m-d H:i:s');

                $user = User::find(array("conditions" => array("email = ?", $data["email"])));
                
                if ($user) {
                    //update data
                    $user_data = array(
                        'id' => $data['id'],
                        'first_name' => $data['given_name'],
                        'last_name' => $data['family_name'],
                        'email' => $data['email'],
                        'oauth_provider' => 'google',
                        'created_at' => $current_datetime,
                        'identity' => $data['email'],
                        'user_id' => $user->id,
                        'old_last_login' => $user->last_login,
                        'ip_address'      => $this->input->ip_address(),
                        
                    );
                    $user->last_login = time();
                    $user->save();
                } else {
                    //insert data
                    $user_data = array(
                        'first_name' => $data['given_name'],
                        'last_name' => $data['family_name'],
                        'email' => $data['email'],
                        'username' => $data['email'],
                        'oauth_provider' => 'google',
                        'created_at' => $current_datetime,
                        'ip_address'      => $this->input->ip_address(),
                        'last_login' => time(),
                        'created_on' => $current_datetime,
                        'password' => "",
                        'terms_conditions' => 0
                    );

//                    $this->google_login_model->Insert_user_data($user_data);
                    
                    $user = User::create($user_data);
                    
                    $user_group_data = array(
                        "user_id" => $user->id,
                        "group_id" => 2
                    );
                    UsersGroup::create($user_group_data);

                    $user_data["identity"] = $data['email'];
                    $user_data["user_id"] = $user->id;
                    
                }

                $this->session->set_userdata($user_data);
//                $this->session->set_userdata(loggedIn, true);
//                $this->session->set_userdata('userData', $user_data);
            }
        }
        $login_button = '';
        if (!$this->session->userdata('access_token')) {
            $login_button = '<a href="' . $google_client->createAuthUrl() . '"><img src="' . base_url() . 'assets/google-login.png" /></a>';
            $data['login_button'] = $login_button;
            $this->load->view('google_login', $data);
        } else {
            redirect(base_url('my-bookings'), $data);
        }
    }

    function logout() {
        $this->session->unset_userdata('access_token');

        $this->session->unset_userdata('user_data');

        redirect('google_login/login');
    }

}

?>
