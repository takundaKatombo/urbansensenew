<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**

 * Class Auth

 * @property Ion_auth|Ion_auth_model $ion_auth        The ION Auth spark

 * @property CI_Form_validation      $form_validation The form validation library

 */
class Auth extends MY_Controller {

    public function __construct() {

        parent::__construct();

        $this->load->database();

        $this->load->library(array('ion_auth', 'form_validation'));

        $this->load->helper(array('url', 'language'));



        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));



        $this->lang->load('auth');
    }

    /**

     * Redirect if needed, otherwise display the user list

     */
    public function index() {



        if (!$this->ion_auth->logged_in()) {

            // redirect them to the login page

            redirect('login', 'refresh');
        } else if (!$this->ion_auth->is_admin()) { // remove this elseif if you want to enable this for non-admins

            // redirect them to the home page because they must be an administrator to view this

            return show_error('You must be an administrator to view this page.');
        } else {

            // set the flash data error message if there is one

            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');



            //list the users

            $this->data['users'] = $this->ion_auth->users()->result();

            foreach ($this->data['users'] as $k => $user) {

                $this->data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
            }



            $this->_render_page('auth' . DIRECTORY_SEPARATOR . 'index', $this->data);
        }
    }

    /**

     * Log the user in

     */
    public function login() {
        if (!$this->ion_auth->logged_in()) {

            if ($this->input->post()) {

                //print_r($this->input->post()); die;
                $email_or_phone = $this->input->post('identity');
                $uniqueuser = User::find(array("conditions" => array("email = ? OR phone = ?", $email_or_phone, $email_or_phone)));

                if (!$uniqueuser) {
                   
                    print_r(json_encode(array('status' => 'failed', 'message' => 'You are not a registered user')));
                    
                } else if ($uniqueuser->active == 0) {

                    print_r(json_encode(array('status' => 'failed', 'message' => 'Your account is not verify. Please check your mail for verify your account')));
                } else {

                    $email_or_phone = $this->input->post('identity');

                    $user = User::find(array("conditions" => array("email = ? OR phone = ?", $email_or_phone, $email_or_phone)));
                    //echo '<pre>';print_r($user);exit;
                    $name = $user->first_name . " " . $user->last_name;

                    $id = $user->id;

                    //print_r(json_encode(array('status'=>'success','message'=>$name)));

                    $this->data['title'] = "Login";

                    $this->form_validation->set_rules('identity', 'Identity', 'required');

                    $this->form_validation->set_rules('password', 'Password', 'required');



                    if ($this->form_validation->run() == true) {

                        // check to see if the user is logging in
                        // check for "remember me"

                        $remember = (bool) $this->input->post('remember');



                        if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)) {

                            //if the login is successful
                            //redirect them back to the home page

                            $group = UsersGroup::find_by_user_id($uniqueuser->id);

                            if ($group->group_id === 3) {

                                print_r(json_encode(array('status' => 'success', 'message' => 'You are logged in ', 'user' => 'professional')));
                            } else if ($group->group_id === 2) {

                                print_r(json_encode(array('status' => 'success', 'message' => 'You are logged in ', 'user' => 'member')));
                            } else if ($group->group_id === 1) {

                                print_r(json_encode(array('status' => 'success', 'message' => 'You are logged in ', 'user' => 'admin')));
                            } else {

                                print_r(json_encode(array('status' => 'success', 'message' => 'You are a unknown user please create another account ', 'user' => 'unknown')));
                            }
                        } else {

                            // if the login was un-successful
                            // redirect them back to the login page

                            print_r(json_encode(array('status' => 'failed', 'message' => "Your username or password is not correct")));
                        }
                    }
                }
            } else {
                include_once"vendor/autoload.php";
                $this->load->config("google");
                $google_items = config_item("google");

                $google_client = new Google_Client();
                $google_client->setClientId($google_items["client_id"]); //Define your ClientID

                $google_client->setClientSecret($google_items["client_secret"]); //Define your Client Secret Key

                $google_client->addScope('email');
                $google_client->addScope('profile');
                
                $google_client->setRedirectUri(base_url('google_login/login')); //Define your Redirect Uri
                $login_button = '<a href="' . $google_client->createAuthUrl() . '"><img class="google-login-btn" src="' . base_url() . 'assets/google-login.png" /></a>';

                $this->data['login_button'] = $login_button;
                
                
                //Apple login details
                
                $this->load->config("apple");
                $apple_items = config_item("apple");
                $this->data['apple_client_id'] = $apple_items["client_id"];
                $this->data['apple_scope'] = $apple_items["scope"];
                $this->data['apple_redirect_uri'] = $apple_items["redirect_uri"];
                
                $this->template->load('frontend/front_base', 'common/login', $this->data);
            }
        } else {
            redirect();
        }
    }

    /**

     * Log the user out

     */
    public function logout() {

        $this->data['title'] = "Logout";



        // log the user out

        $logout = $this->ion_auth->logout();



        // redirect them to the login page

        $this->session->set_flashdata('message', $this->ion_auth->messages());

        redirect('login', 'refresh');
    }

    /**

     * Change password

     */
    public function change_password() {

        if (!$this->input->post()) {

            $this->template->load('frontend/front_base', 'common/change_password', $this->data);
        } else {

            $this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');

            $this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');

            $this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required|matches[new]');



            if (!$this->ion_auth->logged_in()) {

                redirect('login', 'refresh');
            }



            $user = $this->ion_auth->user()->row();

            if ($user->oauth_provider == "facebook") {

                print_r(json_encode(array('status' => 'warning', 'message' => 'You are registered with UrbanSense by facebook. So you do not have permission to change password. ')));
            } else {
                //print_r('expression'); die;
                if ($this->form_validation->run() == FALSE) {

                    if ($this->input->is_ajax_request()) {



                        if (validation_errors()) {



                            print_r(json_encode(array("status" => "error", "message" => validation_errors())));
                        }
                    }
                } else {



                    $identity = $this->session->userdata('identity');



                    $change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));



                    if ($change) {

                        //if the password was successfully changed

                        print_r(json_encode(array("status" => "success", "message" => 'Password changed successfully')));

                        $this->logout();
                    } else {

                        print_r(json_encode(array("status" => "error", "message" => $this->ion_auth->errors())));
                    }
                }
            }
        }
    }

    /**

     * Forgot password

     */
    public function forgot_password() {

        if (!$this->ion_auth->logged_in()) {

            $this->form_validation->set_rules('phone', 'phone', 'required|max_length[10]');

            if ($this->form_validation->run() == FALSE) {

                if (validation_errors()) {
                    $this->session->set_flashdata("warning",validation_errors());                    
                }

                $this->data['title'] = 'Forgot Password';

                $this->template->load('frontend/front_base', 'common/forgot_password', $this->data);
            } else {


                $is_user = User::find_by_phone($this->input->post('phone'));
                if ($is_user) {
                    if (@$is_user->oauth_provider == "facebook") {

                        print_r(json_encode(array('status' => 'warning', 'message' => 'You are registered with UrbanSense by facebook. Please choose facebook option for login. ')));
                    } else {

                        $activation_code = '123456';
                        if ( ENVIRONMENT != 'development' ) {
                            $activation_code = generate_otp_token(5,5,'forgot_password_code',$this->input->post('phone'));
                        }                        

                        $is_user->update_attributes(array('forgotten_password_code' => $activation_code));

                        //$this->template->load('frontend/front_base','common/success_page',$this->data);
                    }
                    // $this->session->set_flashdata("warning", 'We have sent a reset password link to your email. Please check your email to reset your password.' );
                    redirect('forgot-password-otp-verify');
                } else {
                    $this->session->set_flashdata("warning", 'You are not a registered user ' );                    
                    redirect();                    
                }
            }
        } else {
            redirect();
        }
    }

    // forgot_password_otp

    public function forgot_password_otp() {        
        if (!$this->ion_auth->logged_in()) {
            $this->form_validation->set_rules('otp', 'otp', 'required|max_length[6]');
            if ($this->form_validation->run() == FALSE) {

                if (validation_errors()) {
                    $this->session->set_flashdata("warning", validation_errors());                                      
                }
                
                $this->data['title'] = 'Successfully OTP Registred';
                $this->data['message'] = 'Your OTP successfully registered. We Send OTP on your registered Mobile, Please check and use to verify your account.';
                $this->template->load('frontend/front_base', 'common/forgot_password_otp_verify', $this->data);
                
            }else{
                $check_exist = User::count(array('conditions' =>array('forgotten_password_code = ?',$this->input->post('otp'))));
                if ( $check_exist > 0 ) {
                    $is_user = User::find_by_forgotten_password_code($this->input->post('otp'));

                    // $data = array(                        
                    //     'forgotten_password_code' => ''
                    // );
                    // $chatroom = User::find_by_activation_code($this->input->post('otp'));
                    // $chatroom->update_attributes($data);                    
                    // $this->session->set_flashdata("success", 'Account verified successfully');                     
                    redirect('reset-password/'.$is_user->id.'/'.$this->input->post('otp'));
                }else{
                    $this->session->set_flashdata("warning", 'Not a valid otp');                                        
                    redirect('forgot-password-otp-verify');
                }
                                
            }

        }else{
            redirect();
        }

    }

    public function resend_otp() {

        if (!$this->ion_auth->logged_in()) {

            $this->form_validation->set_rules('phone', 'phone', 'required|max_length[10]');

            if ($this->form_validation->run() == FALSE) {

                if (validation_errors()) {
                    $this->session->set_flashdata("warning",validation_errors());                    
                }

                $this->data['title'] = 'Resend OTP';

                $this->template->load('frontend/front_base', 'common/resend_otp', $this->data);
            } else {


                $otp_for = $this->input->post('otpType');
                $is_user = User::find_by_phone($this->input->post('phone'));
                if ($is_user) {
                    if (@$is_user->oauth_provider == "facebook") {

                        print_r(json_encode(array('status' => 'warning', 'message' => 'You are registered with UrbanSense by facebook. Please choose facebook option for login. ')));
                    } else {

                        $activation_code = '123456';
                        if ( ENVIRONMENT != 'development' ) {
                            if ( $otp_for == 'activate_account_otp' ) {
                                $activation_code = generate_otp_token(5,5,'activation_code',$this->input->post('phone'));
                            }else{
                                $activation_code = generate_otp_token(5,5,'forgot_password_code',$this->input->post('phone'));
                            }
                        }                        

                        $is_user->update_attributes(array('forgotten_password_code' => $activation_code));
                        
                    }
                    
                    if ( $otp_for == 'activate_account_otp' ) {
                        redirect('registred-sucessfully');
                    }else{
                        redirect('forgot-password-otp-verify');
                    }
                } else {
                    $this->session->set_flashdata("warning", 'You are not a registered user ' );                    
                    redirect('resend-otp');
                }
            }
        } else {
            redirect();
        }
    }

    

    /**

     * Reset password - final step for forgotten password

     *

     * @param string|null $code The reset code

     */
    public function reset_password($id = NULL, $code = NULL) {

        if (!$this->ion_auth->logged_in()) {
            // if the code is valid then display the password reset form
            $user = User::find(array('conditions' => array('id = ? AND forgotten_password_code = ?', $id, $code)));
            if ($this->input->post()) {
                $this->form_validation->set_rules('new_password', 'new_password', 'required');

                $this->form_validation->set_rules('confirm_password', 'confirm_password', 'required|matches[new_password]');

                if ($this->form_validation->run() == FALSE) {
                    if ($this->input->is_ajax_request()) {

                        if (validation_errors()) {

                            print_r(json_encode(array("status" => "error", "message" => validation_errors())));
                        }
                    }
                } else {
                    //print_r($user->email); die;

                    $this->ion_auth->reset_password($this->input->post('phone'), $this->input->post('new_password'));

                    print_r(json_encode(array("status" => "destination", "destination" => 'login', 'message' => 'Password changed successfully.')));

                    //print_r(json_encode(array("status" => "success",  'message' => 'Password changed successfully.')));
                }
            } else {

                if (!$user) {
                    $this->data['message'] = 'Forgot password link is expired. Please try again.';

                    $this->template->load('frontend/front_base', 'common/failure', $this->data);
                } else {
                    $this->data['title'] = 'Forgot Password';
                    $this->data['email'] = $user->email;
                    $this->data['phone'] = $user->phone;
                    $this->template->load('frontend/front_base', 'common/reset_password', $this->data);
                }
            }
        } else {
            redirect();
        }
    }

    /**

     * Activate the user

     *

     * @param int         $id   The user ID

     * @param string|bool $code The activation code

     */
    public function activate($id, $code = FALSE) {
        if ($code !== FALSE) {
            $active = User::find_by_id_and_activation_code($id, $code);
            if ($active) {
                $chk = $active->update_attributes(array('active' => 1, 'activation_code' => ''));
                if ($chk) {
                    $this->data['title'] = 'Account Activated';
                    $this->data['message'] = 'Your account has been successfully activated. Please click here to <a href="' . base_url('login') . '"><b> Login</b></a>';
                    $this->template->load('frontend/front_base', 'common/success_page', $this->data);
                }
            } else {
                $this->data['title'] = 'Account Activation failed';
                $this->data['message'] = 'This link is expired.';
                $this->template->load('frontend/front_base', 'common/failure', $this->data);
            }
        }
    }

    /**

     * Deactivate the user

     *

     * @param int|string|null $id The user ID

     */
    public function deactivate($id = NULL) {

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {

            // redirect them to the home page because they must be an administrator to view this

            return show_error('You must be an administrator to view this page.');
        }



        $id = (int) $id;



        $this->load->library('form_validation');

        $this->form_validation->set_rules('confirm', $this->lang->line('deactivate_validation_confirm_label'), 'required');

        $this->form_validation->set_rules('id', $this->lang->line('deactivate_validation_user_id_label'), 'required|alpha_numeric');



        if ($this->form_validation->run() === FALSE) {

            // insert csrf check

            $this->data['csrf'] = $this->_get_csrf_nonce();

            $this->data['user'] = $this->ion_auth->user($id)->row();



            $this->_render_page('auth' . DIRECTORY_SEPARATOR . 'deactivate_user', $this->data);
        } else {

            // do we really want to deactivate?

            if ($this->input->post('confirm') == 'yes') {

                // do we have a valid request?

                if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id')) {

                    return show_error($this->lang->line('error_csrf'));
                }



                // do we have the right userlevel?

                if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

                    $this->ion_auth->deactivate($id);
                }
            }



            // redirect them back to the auth page

            redirect('professional/auth', 'refresh');
        }
    }

    /**

     * Create a new user

     */
    public function create_user() {

        if (!$this->ion_auth->logged_in()) {

            $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|max_length[30]');

            $this->form_validation->set_rules('phone', 'phone', 'required|max_length[10]|is_unique[users.phone]');

            $this->form_validation->set_rules('email', 'Email', 'required|max_length[50]|valid_email|is_unique[users.email]');

            $this->form_validation->set_rules('service_id[]', 'Service', 'required');

            $this->form_validation->set_rules('terms_conditions', 'Terms & Conditions', 'required');

            $this->form_validation->set_rules('location', 'Address', 'required');

            $this->form_validation->set_rules('city_id', 'City', 'required');

            $this->form_validation->set_rules('password', 'Password', 'required|max_length[20]|min_length[8] ');

            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|max_length[20]|matches[password]');

            if ($this->form_validation->run() == FALSE) {

                if (validation_errors()) {

                    $this->session->set_flashdata("warning", validation_errors());

                    //print_r(validation_errors()); die;
                }

                $this->data['title'] = 'Join as a Service Provider';

                $this->data['services'] = Service::all(array('conditions' => array('status=1'), 'order' => 'title asc'));

                $this->data['cities'] = City::all(array('conditions' => array('status=1'), 'order' => 'title asc'));

                $this->template->load('frontend/front_base', 'professional/sign_up', $this->data);
            } else {





                $email = strtolower($this->input->post('email'));

                $identity = strtolower($this->input->post('email'));

                $password = $this->input->post('password');

                $activation_code = '123456';
                if ( ENVIRONMENT === 'development' ) {                    
                    $activation_code = generate_otp_token(5,5,'activation_code',$this->input->post('phone'));
                }

                $additional_data = array(
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'company' => $this->input->post('company'),
                    'phone' => $this->input->post('phone'),
                    'terms_conditions' => $this->input->post('terms_conditions'),
                    'activation_code' => $activation_code
                );



                $id = $this->ion_auth->register($identity, $password, $email, $additional_data, 3);

                if ($id) {

                    //print_r($user); exit();

                    $user = User::find_by_id($id);

                    Professional::create(array(
                        'user_id' => $user->id,
                        'city_id' => $this->input->post('city_id'),
                        'longitude' => $this->input->post('longitude'),
                        'latitude' => $this->input->post('latitude'),
                        'address' => $this->input->post('location')
                    ));

                    $services = filter_input(INPUT_POST, 'service_id', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
                    //print_r($this->input->post('service_id'));exit;
                    //ProfessionalService::delete_all(array("conditions" => array("user_id = ?", $user->id)));
                    foreach ($services as $row) {
                        ProfessionalService::create(array('user_id' => $user->id, 'service_id' => $row));
                    }


                    if ( isset( $identity ) ) {
                        
                        $mail_temp = array(
                        	'id' => $user->id,
                        	'name' => $user->first_name,
                        	'email' => $user->email,
                        	'key' => $user->activation_code
                        );                        
                        $message = $this->load->view('api_email/account_varification', $mail_temp, TRUE);
                        $send = $this->custom_email->send($this->input->post('email'), $this->input->post('first_name'), "UrbanSense Account Activation Request", $message);
                        // $this->session->set_flashdata('success', 'City created successfully');
                    }

                    redirect('registred-sucessfully');
                }
            }
        } else {
            redirect();
        }
    }

    public function signup_success() {

        if (!$this->ion_auth->logged_in()) {
            $this->form_validation->set_rules('otp', 'otp', 'required|max_length[6]');
            if ($this->form_validation->run() == FALSE) {

                if (validation_errors()) {
                    $this->session->set_flashdata("warning", validation_errors());                                      
                }
                
                $this->data['title'] = 'Successfully Registred';        
                $this->data['message'] = 'You are successfully registered. We Send OTP on your registered Mobile, Please check and use to verify your account.';
                $this->template->load('frontend/front_base', 'common/success_page', $this->data);
                
            }else{
                $check_exist = User::count(array('conditions' =>array('activation_code = ?',$this->input->post('otp'))));
                if ( $check_exist > 0 ) {
                    $data = array(
                        'verification' => '1',
                        'active' => '1',
                        'activation_code' => ''
                    );
                    $chatroom = User::find_by_activation_code($this->input->post('otp'));
                    $chatroom->update_attributes($data);                    
                    $this->session->set_flashdata("success", 'Account verified successfully'); 
                    redirect();        
                }else{
                    $this->session->set_flashdata("warning", 'Not a valid otp');                                        
                    redirect('registred-sucessfully');
                }
                                
            }

        }else{
            redirect();
        }

    }

    /**

     * Redirect a user checking if is admin

     */
    public function redirectUser() {

        if ($this->ion_auth->is_admin()) {

            redirect('auth', 'refresh');
        }

        redirect('/', 'refresh');
    }

    /**

     * Edit a user

     *

     * @param int|string $id

     */
    public function edit_user($id) {

        $this->data['title'] = $this->lang->line('edit_user_heading');



        if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id))) {

            redirect('professional/auth', 'refresh');
        }



        $user = $this->ion_auth->user($id)->row();

        $groups = $this->ion_auth->groups()->result_array();

        $currentGroups = $this->ion_auth->get_users_groups($id)->result();



        // validate form input

        $this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'trim|required');

        $this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'trim|required');

        $this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), 'trim|required');

        $this->form_validation->set_rules('company', $this->lang->line('edit_user_validation_company_label'), 'trim|required');



        if (isset($_POST) && !empty($_POST)) {

            // do we have a valid request?

            if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id')) {

                show_error($this->lang->line('error_csrf'));
            }



            // update the password if it was posted

            if ($this->input->post('password')) {

                $this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');

                $this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
            }



            if ($this->form_validation->run() === TRUE) {

                $data = array(
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'company' => $this->input->post('company'),
                    'phone' => $this->input->post('phone'),
                );



                // update the password if it was posted

                if ($this->input->post('password')) {

                    $data['password'] = $this->input->post('password');
                }



                // Only allow updating groups if user is admin

                if ($this->ion_auth->is_admin()) {

                    // Update the groups user belongs to

                    $groupData = $this->input->post('groups');



                    if (isset($groupData) && !empty($groupData)) {



                        $this->ion_auth->remove_from_group('', $id);



                        foreach ($groupData as $grp) {

                            $this->ion_auth->add_to_group($grp, $id);
                        }
                    }
                }



                // check to see if we are updating the user

                if ($this->ion_auth->update($user->id, $data)) {

                    // redirect them back to the admin page if admin, or to the base url if non admin

                    $this->session->set_flashdata('message', $this->ion_auth->messages());

                    $this->redirectUser();
                } else {

                    // redirect them back to the admin page if admin, or to the base url if non admin

                    $this->session->set_flashdata('message', $this->ion_auth->errors());

                    $this->redirectUser();
                }
            }
        }



        // display the edit user form

        $this->data['csrf'] = $this->_get_csrf_nonce();



        // set the flash data error message if there is one

        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));



        // pass the user to the view

        $this->data['user'] = $user;

        $this->data['groups'] = $groups;

        $this->data['currentGroups'] = $currentGroups;



        $this->data['first_name'] = array(
            'name' => 'first_name',
            'id' => 'first_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('first_name', $user->first_name),
        );

        $this->data['last_name'] = array(
            'name' => 'last_name',
            'id' => 'last_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('last_name', $user->last_name),
        );

        $this->data['company'] = array(
            'name' => 'company',
            'id' => 'company',
            'type' => 'text',
            'value' => $this->form_validation->set_value('company', $user->company),
        );

        $this->data['phone'] = array(
            'name' => 'phone',
            'id' => 'phone',
            'type' => 'text',
            'value' => $this->form_validation->set_value('phone', $user->phone),
        );

        $this->data['password'] = array(
            'name' => 'password',
            'id' => 'password',
            'type' => 'password'
        );

        $this->data['password_confirm'] = array(
            'name' => 'password_confirm',
            'id' => 'password_confirm',
            'type' => 'password'
        );



        $this->_render_page('auth' . DIRECTORY_SEPARATOR . 'edit_user', $this->data);
    }

    /**

     * Create a new group

     */
    public function create_group() {

        $this->data['title'] = $this->lang->line('create_group_title');



        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {

            redirect('professional/auth', 'refresh');
        }



        // validate form input

        $this->form_validation->set_rules('group_name', $this->lang->line('create_group_validation_name_label'), 'trim|required|alpha_dash');



        if ($this->form_validation->run() === TRUE) {

            $new_group_id = $this->ion_auth->create_group($this->input->post('group_name'), $this->input->post('description'));

            if ($new_group_id) {

                // check to see if we are creating the group
                // redirect them back to the admin page

                $this->session->set_flashdata('message', $this->ion_auth->messages());

                redirect("professional/auth", 'refresh');
            }
        } else {

            // display the create group form
            // set the flash data error message if there is one

            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));



            $this->data['group_name'] = array(
                'name' => 'group_name',
                'id' => 'group_name',
                'type' => 'text',
                'value' => $this->form_validation->set_value('group_name'),
            );

            $this->data['description'] = array(
                'name' => 'description',
                'id' => 'description',
                'type' => 'text',
                'value' => $this->form_validation->set_value('description'),
            );



            $this->_render_page('auth' . DIRECTORY_SEPARATOR . 'create_group', $this->data);
        }
    }

    /**

     * Edit a group

     *

     * @param int|string $id

     */
    public function edit_group($id) {

        // bail if no group id given

        if (!$id || empty($id)) {

            redirect('professional/auth', 'refresh');
        }



        $this->data['title'] = $this->lang->line('edit_group_title');



        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {

            redirect('professional/auth', 'refresh');
        }



        $group = $this->ion_auth->group($id)->row();



        // validate form input

        $this->form_validation->set_rules('group_name', $this->lang->line('edit_group_validation_name_label'), 'required|alpha_dash');



        if (isset($_POST) && !empty($_POST)) {

            if ($this->form_validation->run() === TRUE) {

                $group_update = $this->ion_auth->update_group($id, $_POST['group_name'], $_POST['group_description']);



                if ($group_update) {

                    $this->session->set_flashdata('message', $this->lang->line('edit_group_saved'));
                } else {

                    $this->session->set_flashdata('message', $this->ion_auth->errors());
                }

                redirect("professional/auth", 'refresh');
            }
        }



        // set the flash data error message if there is one

        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));



        // pass the user to the view

        $this->data['group'] = $group;



        $readonly = $this->config->item('admin_group', 'ion_auth') === $group->name ? 'readonly' : '';



        $this->data['group_name'] = array(
            'name' => 'group_name',
            'id' => 'group_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('group_name', $group->name),
            $readonly => $readonly,
        );

        $this->data['group_description'] = array(
            'name' => 'group_description',
            'id' => 'group_description',
            'type' => 'text',
            'value' => $this->form_validation->set_value('group_description', $group->description),
        );



        $this->_render_page('auth' . DIRECTORY_SEPARATOR . 'edit_group', $this->data);
    }

    /**

     * @return array A CSRF key-value pair

     */
    public function _get_csrf_nonce() {

        $this->load->helper('string');

        $key = random_string('alnum', 8);

        $value = random_string('alnum', 20);

        $this->session->set_flashdata('csrfkey', $key);

        $this->session->set_flashdata('csrfvalue', $value);



        return array($key => $value);
    }

    /**

     * @return bool Whether the posted CSRF token matches

     */
    public function _valid_csrf_nonce() {

        $csrfkey = $this->input->post($this->session->flashdata('csrfkey'));

        if ($csrfkey && $csrfkey === $this->session->flashdata('csrfvalue')) {

            return TRUE;
        }

        return FALSE;
    }

    /**

     * @param string     $view

     * @param array|null $data

     * @param bool       $returnhtml

     *

     * @return mixed

     */
    public function _render_page($view, $data = NULL, $returnhtml = FALSE) { //I think this makes more sense



        $this->viewdata = (empty($data)) ? $this->data : $data;



        $view_html = $this->load->view($view, $this->viewdata, $returnhtml);



        // This will return html on 3rd argument being true

        if ($returnhtml) {

            return $view_html;
        }
    }

}
