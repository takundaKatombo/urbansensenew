<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you user __autoload() in config.php OR user Modular Extensions
/** @noinspection PhpIncludeInspection */
//require APPPATH . 'libraries/REST_Controller.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Saurabh Sahu
 * @license         MIT

 */
class Auth extends API_Controller {

    private $appSecretKey;

    function __construct() {
        // $this->appSecretKey    =   APP_SALT;
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
    }

    /* registered service provider */

    public function register_service_provider_post() {
        $request = json_decode($this->input->raw_input_stream);

        // $this->authenticate_client();
        // $this->some_model->update_user( ... );
        $email = $request->email;
        $password = $request->password;
        $phone_number = $request->phone_number;
        $device_id = $request->device_id;
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $service_ids = $request->service_id;
        $city_id = $request->city_id;
        $terms_conditions = $request->terms_conditions;

        $address = $request->address;
        $latitude = $request->latitude;
        $longitude = $request->longitude;


        // $activation_code = mt_rand(100000, 999999);
        $activation_code = '123456';
        if ( ENVIRONMENT != 'development' ) {                    
            $activation_code = generate_otp_token(6,6,'activation_code',$phone_number);
        }
        $additional_data = array(
            'email' => $email,
            'first_name' => ucwords($first_name),
            'last_name' => ucwords($last_name),
            'phone' => $phone_number,
            'activation_code' => $activation_code,
            'terms_conditions' => $terms_conditions
        );


        
        $result = User::all(array('select' => 'count(*) as existingcount', 'conditions' => array('email = ? or phone =? ', $email, $phone_number)));
        if ( !empty( $request->email ) ) {
            $user_email = User::all(array('select' => 'count(*) as existingcount', 'conditions' => array('email = ? ', $email)));            
        }

        $user_phone = User::all(array('select' => 'count(*) as existingcount', 'conditions' => array('phone = ? ', $phone_number)));

        if ( !$password || !$phone_number || !$city_id || !$service_ids || !$first_name || !$last_name || !$address) {
            $message = [
                'message' => 'Please provide all the mendatory parameters',
                'responseCode' => '0'
            ];

            $this->set_response($message, REST_Controller::HTTP_OK);
        } else if ($terms_conditions != 1) {
            $message = [
                'message' => 'Please check terms & conditions before proceeding',
                'responseCode' => '0'
            ];
            $this->set_response($message, REST_Controller::HTTP_OK);
        } else if (  isset($user_email[0]->existingcount) &&  $user_email[0]->existingcount > 0 ) {
            
            $message = [
                'message' => 'This email ID is already registered. Please user a different email or click on forgot password to reset your password',
                'responseCode' => '0'
            ];
            $this->set_response($message, REST_Controller::HTTP_OK);
            
        } else if ($user_phone[0]->existingcount > 0) {
            $message = [
                'message' => 'This phone number is already registered. Please use a different phone or click on forgot password to reset your password',
                'responseCode' => '0'
            ];
            $this->set_response($message, REST_Controller::HTTP_OK);
        } else {
            $id = $this->ion_auth->register($phone_number, $password, $email, $additional_data, 3);
            $user = User::find_by_phone($phone_number);
            if ($user) {

                Professional::create(array(
                    'user_id' => $user->id,
                    'city_id' => $city_id,
                    'longitude' => $longitude,
                    'latitude' => $latitude,
                    'address' => $address
                ));

                $services = array_unique(explode(",", $service_ids));
                //ProfessionalService::delete_all(array("conditions" => array("user_id = ?", $user->id)));
                foreach ($services as $row) {
                    ProfessionalService::create(array('user_id' => $user->id, 'service_id' => $row));
                }
                //ProfessionalService::create(array('user_id'=> $user->id,'service_id'=>$service_id));

                if ( !empty( $request->email ) ) {                    
                    $mail_temp = array(
                        'id' => $user->id,
                        'name' => $user->first_name . ' ' . $user->last_name,
                        'email' => $user->email,
                        'otp' => $user->activation_code
                    );
                    $message = $this->load->view('api_email/account_sp_varification', $mail_temp, TRUE);
                    $this->custom_email->send($email, $first_name . ' ' . $last_name, "UrbanSense Account Activation Request", $message);                    
                }

                $message = [
                    // 'user_id'      =>    $userId,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'message' => 'Your account has been created successfully. We have sent you an OTP on your mobile to verify your account',
                    'responseCode' => '1'
                ];

                $this->set_response($message, REST_Controller::HTTP_OK); // CREATED (201) being the HTTP response code
            }
        }
    }

    /* registered user */

    public function register_post() {
        $request = json_decode($this->input->raw_input_stream);
        
        // $this->authenticate_client();
        // $this->some_model->update_user( ... );
        $email = $request->email;
        $password = $request->password;
        $phone_number = $request->phone_number;
        $device_id = $request->device_id;
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $terms_conditions = $request->terms_conditions;

        // $activation_code = mt_rand(100000, 999999);
        $activation_code = '123456';
        if ( ENVIRONMENT != 'development' ) {                    
            $activation_code = generate_otp_token(6,6,'activation_code',$phone_number);        
        }

        $additional_data = array(
            'email' => $email,
            'first_name' => ucwords($first_name),
            'last_name' => ucwords($last_name),
            'phone' => $phone_number,
            'activation_code' => $activation_code,
            'terms_conditions' => $terms_conditions
        );



        $result = User::all(array('select' => 'count(*) as existingcount', 'conditions' => array('email = ? or phone =? ', $email, $phone_number)));
        if ( !empty( $request->email ) ) {
            $user_email = User::all(array('select' => 'count(*) as existingcount', 'conditions' => array('email = ? ', $email)));        
        }
        // $user_email = User::all(array('select' => 'count(*) as existingcount', 'conditions' => array('email = ? ', $email)));
        $user_phone = User::all(array('select' => 'count(*) as existingcount', 'conditions' => array('phone = ? ', $phone_number)));
       

        if ( !$password || !$phone_number || !$first_name || !$last_name || !$terms_conditions) {
            $message = [
                'message' => 'Please provide all the mendatory parameters',
                'responseCode' => '0'
            ];

            $this->set_response($message, REST_Controller::HTTP_OK);
        } else if (  isset($user_email[0]->existingcount) &&  $user_email[0]->existingcount > 0 ) {
            
            $message = [
                'message' => 'This email ID is already registered. Please user a different email or click on forgot password to reset your password',
                'responseCode' => '0'
            ];
            $this->set_response($message, REST_Controller::HTTP_OK);
            
        } else if ($user_phone[0]->existingcount > 0) {
            $message = [
                'message' => 'This phone number is already registered. Please use a different phone or click on forgot password to reset your password',
                'responseCode' => '0'
            ];
            $this->set_response($message, REST_Controller::HTTP_OK);
        } else {
            $user1 = $this->ion_auth->register($phone_number, $password, $email, $additional_data, 2);
            $user = User::find_by_phone($phone_number);

            if ($user) {
                if ( !empty( $request->email ) ) {                    
                    $mail_temp = array(
                        'id' => $user->id,
                        'name' => $user->first_name . ' ' . $user->last_name,
                        'email' => $user->email,
                        'otp' => $user->activation_code
                    );
                    $message = $this->load->view('api_email/account_varification', $mail_temp, TRUE);
                    $this->custom_email->send($email, $first_name . ' ' . $last_name, "UrbanSense Account Activation Request", $message);
                }
            }

            $message = [
                // 'user_id'      =>    $userId,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'phone' => $phone_number,
                'message' => 'Your account has been created successfully. We have sent you an OTP on your mobile to verify your account',
                'responseCode' => '1'
            ];

            $this->set_response($message, REST_Controller::HTTP_OK); // CREATED (201) being the HTTP response code
        }
    }

    public function register_customer_post() {
        $request = json_decode($this->input->raw_input_stream);

        $email = $request->email;
        //$password = $request->password;
        $phone_number = @$request->phone_number;
        
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $terms_conditions = $request->terms_conditions;
        $login_type = $request->login_type;
        
        $result = User::all(array('select' => 'count(*) as existingcount', 'conditions' => array('email = ? or phone =? ', $email, $phone_number)));
        $user_email = User::all(array('select' => 'count(*) as existingcount', 'conditions' => array('email = ? ', $email)));
        $user_phone = User::all(array('select' => 'count(*) as existingcount', 'conditions' => array('phone = ? ', $phone_number)));
//print_r($user_email);exit;
        if ($user_email[0]->existingcount > 0) {
            $message = [
                'message' => 'This email ID is already registered. Please user a different email or click on forgot password to reset your password',
                'responseCode' => '0'
            ];
            $this->set_response($message, REST_Controller::HTTP_OK); 
	    return;
        }
        
        if ($user_phone[0]->existingcount > 0) {
            $message = [
                'message' => 'This phone number is already registered. Please user a different phone or click on forgot password to reset your password',
                'responseCode' => '0'
            ];
            $this->set_response($message, REST_Controller::HTTP_OK);return;
        }
        
        if(!in_array($login_type, array('facebook', 'google', 'apple', 'local'))) {
            $message = [
                'message' => 'Invalid login type',
                'responseCode' => '0'
            ];
            $this->set_response($message, REST_Controller::HTTP_OK);return;
        }
        
        if($login_type == 'facebook' or $login_type == 'google' or $login_type == 'apple') {
            
            $device_id = $request->device_id;
            
            $user = User::create([
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
		'password' => 'NOT IN USE',
                'oauth_provider' => $login_type,
                'oauth_provider_id' => $request->idprovider,
                'active' => true,
                'terms_conditions' => $request->terms_conditions,
                'ip_address' => $this->input->ip_address(),
                'created_on' => time(),
                'created_at' => date('Y-m-d H:i:s')
            ]);

            UsersGroup::create(['user_id' => $user->id, 'group_id' => 2]);
            
            
            $existingToken = UserAuthentication::find_all_by_device_id($device_id);
            foreach ($existingToken as $entry) {
                $entry->delete();
            }

            $user_token = md5(date('YMdHis') . rand());
            $user_key = md5($user->id . rand());

            $authentication_data = array(
                'user_id' => $user->id,
                'user_token' => $user_token,
                'user_key' => $user_key,
                'device_id' => !empty($device_id) ? $device_id : '',
            );
            UserAuthentication::create($authentication_data);
            
            $message = [
                'user_token' => base64_encode($user_token . '$' . $user_key),
                'user_id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'phone' => $user->phone,
                'profile_image' => @$user->customers->image ? base_url('uploads/customer_profile/') . $user->customers->image : '',
                'responseCode' => '1',
                'message' => 'Your account has been created successfully',
            ];
            
	    $this->set_response($message, REST_Controller::HTTP_OK); // CREATED (201) being the HTTP response code
        }
        

        if ($login_type == 'local') {
            $password = $request->password;
            $activation_code = mt_rand(100000, 999999);
            $additional_data = array(
                'email' => $email,
                'first_name' => ucwords($first_name),
                'last_name' => ucwords($last_name),
                'phone' => $phone_number,
                'activation_code' => $activation_code,
                'terms_conditions' => $terms_conditions
            );



//            $result = User::all(array('select' => 'count(*) as existingcount', 'conditions' => array('email = ? or phone =? ', $email, $phone_number)));
//            $user_email = User::all(array('select' => 'count(*) as existingcount', 'conditions' => array('email = ? ', $email)));
//            $user_phone = User::all(array('select' => 'count(*) as existingcount', 'conditions' => array('phone = ? ', $phone_number)));

            if (!$email || !$password || !$phone_number || !$first_name || !$last_name || !$terms_conditions) {
                $message = [
                    'message' => 'Please provide all the mendatory parameters',
                    'responseCode' => '0'
                ];

                $this->set_response($message, REST_Controller::HTTP_OK);
            } else {
                $user1 = $this->ion_auth->register($phone_number, $password, $email, $additional_data, 2);
                $user = User::find_by_email($email);



                if ($user) {
                    $mail_temp = array(
                        'id' => $user->id,
                        'name' => $user->first_name . ' ' . $user->last_name,
                        'email' => $user->email,
                        'otp' => $user->activation_code
                    );
                    $message = $this->load->view('api_email/account_varification', $mail_temp, TRUE);
                    $this->custom_email->send($email, $first_name . ' ' . $last_name, "UrbanSense Account Activation Request", $message);
                }
                $message = [
                    // 'user_id'      =>    $userId,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'email' => $email,
                    'phone' => $phone_number,
                    'message' => 'Your account has been created successfully. We have sent you an OTP on your email ID to verify your account',
                    'responseCode' => '1'
                ];

                $this->set_response($message, REST_Controller::HTTP_OK); // CREATED (201) being the HTTP response code
            }
        }
    }

    /* varify otp */

    public function otp_varification_post() {

        $request = json_decode($this->input->raw_input_stream);

        $otp = $request->otp;
        $identity = $request->identity;


        if (!$identity || !$otp) {

            $message = [
                'message' => 'Please provide all the mandatory parameters',
                'responseCode' => '0'
            ];

            $this->set_response($message, REST_Controller::HTTP_OK);
        } else {

            $result = User::find(array('conditions' => array(' phone =?', $identity)));

            if (!@$result->activation_code) {
                $message = [
                    'message' => "The OTP you have provided has expired. Please click on resend OTP or contact administrator to activate your account",
                    'responseCode' => '0'
                ];
                $this->set_response($message, REST_Controller::HTTP_OK);
            } else if (@$result->activation_code != $otp) {
                $message = [
                    'message' => "The OTP you have provided is wrong. Please try again",
                    'responseCode' => '0'
                ];
                $this->set_response($message, REST_Controller::HTTP_OK);
            } else if (empty($result)) {
                $message = [
                    'message' => 'The values you have provided are either wrong or does not exist. Please contact administrator',
                    'responseCode' => '0'
                ];
                $this->set_response($message, REST_Controller::HTTP_OK);
            } else {

                if ($result) {
                    $data = array(
                        'name' => $result->first_name . ' ' . $result->last_name,
                        'email' => $result->email
                    );

                    $result->update_attributes(array('active' => 1, 'activation_code' => ''));
                    // $message = $this->load->view('api_email/varify_successfully', $data, TRUE);
                    // $this->custom_email->send($result->email, $result->first_name . ' ' . $result->last_name, "UrbanSense Account Activated Successfully", $message);
                    $message = [
                        'first_name' => $result->first_name,
                        'last_name' => $result->last_name,
                        'email' => $result->email,
                        'phone' => $result->phone,
                        'message' => 'Your account has been activated successfully. You can now login with your registered credentials',
                        'responseCode' => '1'
                    ];

                    $this->set_response($message, REST_Controller::HTTP_OK); // CREATED (201) being the HTTP response code
                }
            }
        }
    }

    /* resend otp */

    public function otp_resend_post() {
        

        $request = json_decode($this->input->raw_input_stream);

        $identity = $request->identity;

        if ($identity) {

            $result = User::find(array('conditions' => array('phone =?', $identity)));

            if ($result) {

                // $sixdigit_otp = mt_rand(100000, 999999);
                $activation_code = '123456';
                if ( ENVIRONMENT != 'development' ) {                    
                    $activation_code = generate_otp_token(6,6,'activation_code',$identity);
                }
                $data = array(
                    'name' => $result->first_name . ' ' . $result->last_name,
                    'email' => $result->email,
                    'otp' => $activation_code
                );

                $result->update_attributes(array('active' => 0, 'activation_code' => $activation_code));
                // $message = $this->load->view('api_email/otp_resend', $data, TRUE);
                // $this->custom_email->send($result->email, $result->first_name . ' ' . $result->last_name, "UrbanSense Account OTP Resend", $message);

                $message = [
                    'first_name' => $result->first_name,
                    'last_name' => $result->last_name,
                    'email' => $result->email,
                    'phone' => $result->phone,
                    'message' => 'A new OTP has been sent to your mobile. Please check your mobile and enter the new OTP',
                    'responseCode' => '1'
                ];

                $this->set_response($message, REST_Controller::HTTP_OK); // CREATED (201) being the HTTP response code
            } else {

                $message = [
                    'message' => 'The values you have provided are either wrong or does not exist. Please contact administrator',
                    'responseCode' => '0'
                ];

                $this->set_response($message, REST_Controller::HTTP_OK);
            }
        } else {

            $message = [
                'message' => 'Please provide all the mandatory parameters',
                'responseCode' => '0'
            ];

            $this->set_response($message, REST_Controller::HTTP_OK);
        }
    }

    /**
     * User Login Validation
     * */
    public function login_post() {

        $request = json_decode($this->input->raw_input_stream);
        $device_id = $request->device_id;
        $identity = $request->identity;
        $password = $request->password;
        

        if (!$identity OR!$password) {
            $message = [
                'message' => 'Please provide Email ID and Password in order to login',
                'responseCode' => '0'
            ];

            $this->set_response($message, REST_Controller::HTTP_OK);
        } else {
            $user = User::find(array('conditions' => array('email = ? OR phone =?', $identity, $identity)));


            if ($this->ion_auth->login($identity, $password)) {
                $group = UsersGroup::find_by_user_id($user->id);
                if ($group->group_id === 2) {

                    $existingToken = UserAuthentication::find_all_by_device_id($device_id);
                    foreach ($existingToken as $entry) {
                        $entry->delete();
                    }

                    $user_token = md5(date('YMdHis') . rand());
                    $user_key = md5($user->password . rand());

                    $authentication_data = array(
                        'user_id' => $user->id,
                        'user_token' => $user_token,
                        'user_key' => $user_key,
                        'device_id' => !empty($device_id) ? $device_id : '',
                    );
                    UserAuthentication::create($authentication_data);

                    $message = [
                        'message' => strip_tags($this->ion_auth->messages()),
                        'user_token' => base64_encode($user_token . '$' . $user_key),
                        'user_id' => $user->id,
                        'first_name' => $user->first_name,
                        'last_name' => $user->last_name,
                        'email' => $user->email,
                        'phone' => $user->phone,
                        'profile_image' => @$user->customers->image ? base_url('uploads/customer_profile/') . $user->customers->image : '',
                        'responseCode' => '1'
                    ];
                    $this->set_response($message, REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'You are not authorized to perform this action. Please login as a customer',
                        'responseCode' => '0'
                            ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

                    $this->set_response($message, REST_Controller::HTTP_OK);
                }
            } else {
                $message = [
                    'status' => FALSE,
                    'message' => strip_tags($this->ion_auth->errors()),
                    'responseCode' => '0'
                ];

                $this->set_response($message, REST_Controller::HTTP_OK);
            }
        }
    }

    
    public function login_customer_post() {
        $request = json_decode($this->input->raw_input_stream);
        $device_id = $request->device_id;
        $login_type = $request->login_type;
        
        if(!in_array($login_type, array('facebook', 'google', 'apple', 'local'))) {
            $message = [
                'message' => 'Invalid login type',
                'responseCode' => '0'
            ];
            $this->set_response($message, REST_Controller::HTTP_OK);
        }
        
        if(in_array($login_type, array('facebook', 'google'))) {
            $idprovider = $request->idprovider;
            $identity = $request->identity;
            if(!isset($idprovider) or is_null($idprovider) or !isset($identity) or is_null($identity)) {
                $message = [
                    'message' => 'Invalid parameters',
                    'responseCode' => '0'
                ];

                $this->set_response($message, REST_Controller::HTTP_OK);
            }
            
            $user = User::find(array("conditions" => array("oauth_provider_id = ? AND oauth_provider = ? AND email = ?", $idprovider, $login_type, $identity)));
            if(!is_null($user)) {
                $group = UsersGroup::find_by_user_id($user->id);
                if ($group->group_id === 2) {

                    $existingToken = UserAuthentication::find_all_by_device_id($device_id);
                    foreach ($existingToken as $entry) {
                        $entry->delete();
                    }

                    $user_token = md5(date('YMdHis') . rand());
                    $user_key = md5($user->id . rand());

                    $authentication_data = array(
                        'user_id' => $user->id,
                        'user_token' => $user_token,
                        'user_key' => $user_key,
                        'device_id' => !empty($device_id) ? $device_id : '',
                    );
                    UserAuthentication::create($authentication_data);

                    $message = [
                        'message' => strip_tags($this->ion_auth->messages()),
                        'user_token' => base64_encode($user_token . '$' . $user_key),
                        'user_id' => $user->id,
                        'first_name' => $user->first_name,
                        'last_name' => $user->last_name,
                        'email' => $user->email,
                        'phone' => $user->phone,
                        'profile_image' => @$user->customers->image ? base_url('uploads/customer_profile/') . $user->customers->image : '',
                        'responseCode' => '1'
                    ];
                    $this->set_response($message, REST_Controller::HTTP_OK);
                }
            } 
        }
        if($login_type == 'apple') {
            $idprovider = $request->idprovider;
            
            if(!isset($idprovider) or is_null($idprovider)) {
                $message = [
                    'message' => 'Invalid parameters',
                    'responseCode' => '0'
                ];

                $this->set_response($message, REST_Controller::HTTP_OK);
            }
            
            $user = User::find(array("conditions" => array("oauth_provider_id = ? AND oauth_provider = ?", $idprovider, $login_type)));
            if(!is_null($user)) {
                $group = UsersGroup::find_by_user_id($user->id);
                if ($group->group_id === 2) {

                    $existingToken = UserAuthentication::find_all_by_device_id($device_id);
                    foreach ($existingToken as $entry) {
                        $entry->delete();
                    }

                    $user_token = md5(date('YMdHis') . rand());
                    $user_key = md5($user->id . rand());

                    $authentication_data = array(
                        'user_id' => $user->id,
                        'user_token' => $user_token,
                        'user_key' => $user_key,
                        'device_id' => !empty($device_id) ? $device_id : '',
                    );
                    UserAuthentication::create($authentication_data);

                    $message = [
                        'message' => strip_tags($this->ion_auth->messages()),
                        'user_token' => base64_encode($user_token . '$' . $user_key),
                        'user_id' => $user->id,
                        'first_name' => $user->first_name,
                        'last_name' => $user->last_name,
                        'email' => $user->email,
                        'phone' => $user->phone,
                        'profile_image' => @$user->customers->image ? base_url('uploads/customer_profile/') . $user->customers->image : '',
                        'responseCode' => '1'
                    ];
                    $this->set_response($message, REST_Controller::HTTP_OK);
                }
            } 
        }
        
        if ($login_type == 'local') {
            $identity = $request->identity;
            $password = $request->password;
            if (!$identity OR!$password) {
                $message = [
                    'message' => 'Please provide Email ID and Password in order to login',
                    'responseCode' => '0'
                ];

                $this->set_response($message, REST_Controller::HTTP_OK);
            } else {
                $user = User::find(array('conditions' => array('email = ? OR phone =?', $identity, $identity)));


                if ($this->ion_auth->login($identity, $password)) {
                    $group = UsersGroup::find_by_user_id($user->id);
                    if ($group->group_id === 2) {

                        $existingToken = UserAuthentication::find_all_by_device_id($device_id);
                        foreach ($existingToken as $entry) {
                            $entry->delete();
                        }

                        $user_token = md5(date('YMdHis') . rand());
                        $user_key = md5($user->password . rand());

                        $authentication_data = array(
                            'user_id' => $user->id,
                            'user_token' => $user_token,
                            'user_key' => $user_key,
                            'device_id' => !empty($device_id) ? $device_id : '',
                        );
                        UserAuthentication::create($authentication_data);

                        $message = [
                            'message' => strip_tags($this->ion_auth->messages()),
                            'user_token' => base64_encode($user_token . '$' . $user_key),
                            'user_id' => $user->id,
                            'first_name' => $user->first_name,
                            'last_name' => $user->last_name,
                            'email' => $user->email,
                            'phone' => $user->phone,
                            'profile_image' => @$user->customers->image ? base_url('uploads/customer_profile/') . $user->customers->image : '',
                            'responseCode' => '1'
                        ];
                        $this->set_response($message, REST_Controller::HTTP_OK);
                    } else {
                        $this->response([
                            'status' => FALSE,
                            'message' => 'You are not authorized to perform this action. Please login as a customer',
                            'responseCode' => '0'
                                ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

                        $this->set_response($message, REST_Controller::HTTP_OK);
                    }
                } else {
                    $message = [
                        'status' => FALSE,
                        'message' => strip_tags($this->ion_auth->errors()),
                        'responseCode' => '0'
                    ];

                    $this->set_response($message, REST_Controller::HTTP_OK);
                }
            }
        }
        
    }
    /**
     * Service Provider Login 
     * */
    public function sp_login_post() {


        $request = json_decode($this->input->raw_input_stream);

        $identity = $request->identity;
        $password = $request->password;
        $device_id = $request->device_id;

        if (!$identity OR!$password) {
            $message = [
                'message' => 'Please provide Email ID and Password in order to login',
                'responseCode' => '0'
            ];

            $this->set_response($message, REST_Controller::HTTP_OK);
        } else {
            $user = User::find(array('conditions' => array('email = ? OR phone =?', $identity, $identity)));


            if ($this->ion_auth->login($identity, $password)) {
                $group = UsersGroup::find_by_user_id($user->id);
                if ($group->group_id === 3) {

                    $existingToken = UserAuthentication::find_all_by_device_id($device_id);
                    foreach ($existingToken as $entry) {
                        $entry->delete();
                    }

                    $user_token = md5(date('YMdHis') . rand());
                    $user_key = md5($user->password . rand());

                    $authentication_data = array(
                        'user_id' => $user->id,
                        'user_token' => $user_token,
                        'user_key' => $user_key,
                        'device_id' => !empty($device_id) ? $device_id : '',
                    );
                    UserAuthentication::create($authentication_data);

                    $message = [
                        'message' => strip_tags($this->ion_auth->messages()),
                        'user_token' => base64_encode($user_token . '$' . $user_key),
                        'user_id' => $user->id,
                        'first_name' => $user->first_name,
                        'last_name' => $user->last_name,
                        'email' => $user->email,
                        'profile_image' => get_default_pro_image($user->id) ? base_url('uploads/image/') . get_default_pro_image($user->id) : '',
                        'phone' => $user->phone,
                        'verified' => $user->verification,
                        'responseCode' => '1'
                    ];
                    $this->set_response($message, REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'You are not authorized to perform this action. Please login as a service provider',
                        'responseCode' => '0'
                            ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

                    $this->set_response($message, REST_Controller::HTTP_OK);
                }
            } else {
                $message = [
                    'status' => FALSE,
                    'message' => strip_tags($this->ion_auth->errors()),
                    'responseCode' => '0'
                ];

                $this->set_response($message, REST_Controller::HTTP_OK);
            }
        }
    }

    public function change_password_post() {


        $request = json_decode($this->input->raw_input_stream);
        $user = $this->is_logged_in();
        if (empty($user)) {

            $message = [
                'status' => FALSE,
                'message' => 'You need to be logged in to change your password',
                'responseCode' => '0'
            ];
            $this->set_response($message, REST_Controller::HTTP_METHOD_NOT_ALLOWED);
        } else {

            $identity = $user->email;
            $password = $request->password;
            $newPassword = $request->new_password;

            if (!$password || !$newPassword) {
                $message = [
                    'message' => 'Please provide all the mandatory parameters in order to proceed',
                    'responseCode' => '0'
                ];

                $this->set_response($message, REST_Controller::HTTP_OK);
            } else {
                $change = $this->ion_auth->change_password($identity, $password, $newPassword);

                if ($change) {
                    $message = [
                        'message' => 'Your password has been updated successfully',
                        'responseCode' => '1'
                    ];
                    $this->set_response($message, REST_Controller::HTTP_OK);
                } else {
                    $message = [
                        'message' => 'Old password you have provided are wrong. Please enter valid password',
                        'responseCode' => '0'
                    ];
                    $this->set_response($message, REST_Controller::HTTP_OK);
                }
            }
        }
    }

    /* forgot password */

    public function forgot_password_sendotp_post() {

        


        $request = json_decode($this->input->raw_input_stream);

        $identity = $request->identity;

        // echo "asd".generate_otp_token(6,6,'forgot_password_code',$identity);
        // exit;

        if (!$identity) {
            $message = [
                'message' => 'Please enter your email or phone number for us to send you the OTP',
                'responseCode' => '0'
            ];

            $this->set_response($message, REST_Controller::HTTP_OK);
        } else {
            $user = User::find(array('conditions' => array('phone =?', $identity)));
            if (empty($user)) {
                $message = [
                    'message' => 'You are not a registered user with us. Please register again or contact administrator',
                    'responseCode' => '0'
                ];

                $this->set_response($message, REST_Controller::HTTP_OK);
            } else {

                //sending OTP and set it as password
                $activation_code = '123456';
                if ( ENVIRONMENT != 'development' ) {                    
                    $activation_code = generate_otp_token(6,6,'forgot_password_code',$identity);
                }

                // $otpNum = rand('111111', '999999');
                // $name = $user->first_name . ' ' . $user->last_name;
                // $email = $user->email;

                $user->update_attributes(array('forgotten_password_code' => $activation_code));

                // $data = array('name' => $name,
                //     'email' => $email,
                //     'otp' => $otpNum
                // );
                // $data = array(
                //     'id' => $user->id,
                //     'name' => $name,
                //     'email' => $email,
                //     'otp' => $otpNum
                // );

                // $message = $this->load->view('api_email/forgot_password', $data, TRUE);

                // $is_send = $this->custom_email->send($email, $name, "UrbanSense Account OTP for Reset Password", $message);

                // if ($is_send) {
                //     $message = [
                //         'message' => 'An OTP has been sent to you successfully',
                //         'responseCode' => '1'
                //     ];
                //     $this->set_response($message, REST_Controller::HTTP_OK);
                // } else {
                //     $message = [
                //         'message' => 'The OTP could not be sent due to some error. Please try again later',
                //         'responseCode' => '0'
                //     ];
                //     $this->set_response($message, REST_Controller::HTTP_OK);
                // }

                $message = [
                    'message' => 'An OTP has been sent to you successfully',
                    'responseCode' => '1'
                ];
                $this->set_response($message, REST_Controller::HTTP_OK);
            }
        }
    }

    /* OTP verify */

    public function forgot_password_otpverify_post() {

        $request = json_decode($this->input->raw_input_stream);

        $identity = $request->identity;
        $otp = $request->otp;

        if (!$identity) {
            $message = [
                'message' => 'Please enter your email or phone number for us to send you the OTP',
                'responseCode' => '0'
            ];

            $this->set_response($message, REST_Controller::HTTP_OK);
        } else {
            $user = User::find(array('conditions' => array(' phone =?', $identity)));
            if (empty($user)) {
                $message = [
                    'message' => 'You are not a registered user with us. Please register again or contact administrator ',
                    'responseCode' => '0'
                ];

                $this->set_response($message, REST_Controller::HTTP_OK);
            } else if ($user->forgotten_password_code == $otp) {

                $user->update_attributes(array('forgotten_password_code' => ''));

                $message = [
                    'message' => 'An OTP has been verified successfully. Please reset your password now',
                    'responseCode' => '1'
                ];
                $this->set_response($message, REST_Controller::HTTP_OK);
            } else {
                $message = [
                    'message' => 'The OTP you provided could not be matched. Please try again later',
                    'responseCode' => '0'
                ];
                $this->set_response($message, REST_Controller::HTTP_OK);
            }
        }
    }

    /* reset password */

    public function reset_password_post() {

        $request = json_decode($this->input->raw_input_stream);

        $identity = $request->identity;
        $password = $request->password;
        $confirm_password = $request->confirm_password;

        if (!$identity) {
            $message = [
                'message' => 'Please enter your phone number for us to reset password',
                'responseCode' => '0'
            ];

            $this->set_response($message, REST_Controller::HTTP_OK);
        } else if ($password != $confirm_password) {
            $message = [
                'message' => 'The confirm password you provided could not be matched. Please try again',
                'responseCode' => '0'
            ];
            $this->set_response($message, REST_Controller::HTTP_OK);
        } else {
            $user = User::find(array('conditions' => array('phone =?', $identity)));
            if (!empty($user)) {
                $change = $this->ion_auth->reset_password_new($identity, $password);
                
                if ($change) {
                    $user->update_attributes(array('password' => $change));
                    $message = [
                        'message' => 'Your account password has been changed successfully. You can now login with your updated credentials',
                        'responseCode' => '1'
                    ];

                    $this->set_response($message, REST_Controller::HTTP_OK);
                }else{
                    $message = [
                        'message' => 'Something wrong. Please contact administrator',
                        'responseCode' => '0'
                    ];
                    $this->set_response($message, REST_Controller::HTTP_OK);    
                }
            } else {


                $message = [
                    'message' => 'The values you have provided are either wrong or does not exist. Please contact administrator',
                    'responseCode' => '0'
                ];
                $this->set_response($message, REST_Controller::HTTP_OK);
            }
        }
    }

    public function logout_post() {
        $request = json_decode($this->input->raw_input_stream);
        $user = $this->is_logged_in();
        if (empty($user)) {

            $message = [
                'status' => FALSE,
                'message' => 'You need to be logged in to perform this action',
                'responseCode' => '0'
            ];
            $this->set_response($message, REST_Controller::HTTP_METHOD_NOT_ALLOWED);
        } else {

            $authentication = UserAuthentication::find_by_user_id($user->id);
            if (!empty($authentication)) {
                $authentication->delete();
                $message = [
                    'message' => 'You have been logged out successfully',
                    'responseCode' => '1'
                ];
                $this->set_response($message, REST_Controller::HTTP_OK);
            }
        }
    }

    //End of file
}
