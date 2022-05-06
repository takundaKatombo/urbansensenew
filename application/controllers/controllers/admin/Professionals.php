<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Professionals extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('slug');
        if ($this->ion_auth->is_admin()) {
            return true;
        } else {
            $this->session->set_flashdata("warning", 'You must be an administrator to view this page.');
            redirect(base_url('logout'));
        }
    }

    public function index() {
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth/login', 'refresh');
        } else {
            $config['per_page']   = 20;
            $config['total_rows'] = Professional::count();
            $config['base_url']   = base_url('admin/professionals');
            $page                 = (null !== $this->input->get('page')) ? $this->input->get('page') : 1;
            $start_index          = ($page - 1) * $config['per_page'];

            $data = array(
                'users'      => User::all(array(
                    'select' => 'professionals.featured_service_provider as featured_service_provider, professionals.city_id as city_id,professionals.criminal_varification  as criminal_varification, professionals.bank_varification as bank_varification, professionals.skill_assessment as skill_assessment,  professionals.service_id as service_id,users.first_name as first_name, users.last_name as last_name, users.email as email, users.id as id, users.verification as verification, (AVG(reviews.professionalism)+ AVG(reviews.knowledge)+AVG(reviews.cost)+AVG(reviews.punctuality)+ AVG(reviews.tidiness))/5 as total_avg',
                    'joins'  => 'left join professionals on professionals.user_id=users.id left join reviews on reviews.professional_id =users.id ', 'group' => 'users.id',
                    'limit'  => $config['per_page'],
                    'offset' => $start_index,
                    'order'  => 'professionals.created_at desc, total_avg desc',
                )
                ),
                'title'      => 'Service Provider',
                'pagination' => $this->custom_pagination->create_backend_pagination($config),
            );

            // print_r(User::connection()->last_query);exit;

            $this->template->load('admin/admin_base', 'admin/service_provider/service_provider_list', $data);
        }
    }

    public function selected_action() {

//            echo '<pre>';print_r($_POST);

        if ($_POST["submit_value"] and isset($_POST["service_providers"]) and count($_POST["service_providers"]) > 0) {
            $user_ids = join(",", $_POST["service_providers"]);

            $users = User::all(array(
                'select'     => 'users.id,users.email,users.first_name,users.last_name, professionals.city_id, users.created_at,users.active,users.verification',
                'conditions' => "users.id IN ({$user_ids})",
                'order'      => 'users.created_at desc',
                'joins'      => 'left join professionals on professionals.user_id=users.id',
            ));

            if ($_POST["submit_value"] == "Download") {
                $temp             = array();
                $i                = 1;
                $temp[0]['name']  = 'Name';
                $temp[0]['email'] = 'Email';
                $temp[0]['city']  = 'City';

                foreach ($users as $user) {
                    //echo $user->city_id;exit;
                    try {
                        $city = City::find($user->city_id);
                    } catch (Exception $exc) {
                        $city = NULL;
                    }

                    if ($city) {
                        $city_name = $city->title;
                    } else {
                        $city_name = "";
                    }

                    $temp[$i]['name']  = $user->first_name . ' ' . $user->last_name;
                    $temp[$i]['email'] = $user->email;
                    $temp[$i]['city']  = $city_name;
                    $i++;
                }

                $this->load->helper('csv');
                array_to_csv($temp, 'users.csv');
            }

            if ($_POST["submit_value"] == "Delete") {
                foreach ($users as $user) {
                    $user->active = 0;
                    $user->save();
                }

                $this->session->set_flashdata('success', 'Professionals deleted successfully');
                redirect('admin/professionals');
            }

            if ($_POST["submit_value"] == "Email") {
                $emails = array();
                foreach ($users as $user) {
                    array_push($emails, $user->email);
                }
                $final_emails = '';
                if (count($emails) > 0) {
                    $final_emails = join(",", $emails);
                }

                $data = array(
                    "title"             => "Send emails",
                    "emails"            => $final_emails,
                    "service_providers" => join(",", $_POST["service_providers"]),
                );

                $this->template->load('admin/admin_base', 'admin/service_provider/send_email', $data);
            }

            if ($_POST["submit_value"] == "Activate") {
                foreach ($users as $user) {
                    if ($user->verification == 0) {

                        $name  = $user->first_name . ' ' . $user->last_name;
                        $email = $user->email;

                        $user->update_attributes(array('verification' => 1));
                        $user->update_attributes(array('active' => 1));

                        $data = array(
                            'message' => 'Congratulations! Our backend team has reviewed your account details and approved your request. You can now see all the details on your dashboard and perform relevant actions.
                                                You are advised to keep your account information up to date in order to keep receiving order requests and payments against orders.',
                            'name'    => $name,
                        );
                        $message = $this->load->view('emails/verification_email', $data, TRUE);
                        $send    = $this->custom_email->send($email, $name, "[UrbanSense] Account Verified", $message);
                    }
                }
            }
            $this->session->set_flashdata('success', 'Professionals activated successfully');
            redirect('admin/professionals');
        } else {
            $this->session->set_flashdata("warning", "Please select service providers");
            redirect('admin/professionals');
        }
    }

    public function send_email() {
        if (isset($_POST["service_providers"]) and $_POST["service_providers"] != '' and isset($_POST["body"]) and $_POST["body"] != '') {
            $user_ids = $_POST["service_providers"];

            $users = User::all(array(
                'select'     => 'users.id,users.email,users.first_name,users.last_name',
                'conditions' => "users.id IN ({$user_ids})",
            ));

//                $emails = ["premnisha0123@gmail.com","nisha@dignitech.com"];

            require 'vendor/autoload.php'; // If you're using Composer (recommended)
            $email = new \SendGrid\Mail\Mail();
            $email->setFrom("contact@urbansense.com", "UrbanSense");
            $email->setSubject($this->input->post('subject'));
            foreach ($users as $user) {
                $email->addTo("$user->email", "$user->first_name $user->last_name");
            }

            $message = $this->input->post("body");

            $email->addContent(
                "text/html", $message
            );

            $sendgrid = new \SendGrid('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');
            try {
                $response = $sendgrid->send($email);

                if ($response->statusCode() == 202) {
                    $this->session->set_flashdata('success', 'Email sent to service providers successfully');
                    redirect('admin/professionals');
                }
            } catch (Exception $e) {
                echo 'Caught exception: ' . $e->getMessage() . "\n";
            }
        } else {
            $this->session->set_flashdata('warning', 'Email Body was empty. Emails Discarded.');
            redirect('admin/professionals');
        }
    }

    public function create() {
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth/login', 'refresh');
        } else {
            $this->form_validation->set_rules('title', 'City Title', 'required|max_length[100] |is_unique[cities.title]');
            if ($this->form_validation->run() == FALSE) {
                if (validation_errors()) {
                    $this->session->set_flashdata("warning", validation_errors());
                }
                $this->data['title'] = 'Create New City';
                $this->template->load('admin/admin_base', 'admin/city/add_update_city', $this->data);
            } else {
                $data = array(
                    'title'   => $this->input->post('title'),
                    'slug'    => slug($this->input->post('title')),
                    'user_id' => $this->ion_auth->user()->row()->id,
                    'status'  => $this->input->post('status'),
                );
                $cat = City::create($data);
                $this->session->set_flashdata('success', 'City created successfully');
                redirect('admin/cities');
            }
        }
    }

    public function update($id = null) {
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth/login', 'refresh');
        } else {
            $city = City::find_by_id($id);
            $this->form_validation->set_rules('title', 'City Title', 'required|max_length[100]');
            if ($this->form_validation->run() == FALSE) {
                if (validation_errors()) {
                    $this->session->set_flashdata("warning", validation_errors());
                }
                $this->data['title'] = 'Update City';
                $this->data['city']  = $city;
                $this->template->load('admin/admin_base', 'admin/city/add_update_city', $this->data);
            } else {
                $data = array(
                    'title'   => $this->input->post('title'),
                    'slug'    => slug($this->input->post('title')),
                    'user_id' => $this->ion_auth->user()->row()->id,
                    'status'  => $this->input->post('status'),
                );
                $city->update_attributes($data);
                $this->session->set_flashdata('success', 'City Updated Successfully');
                redirect('admin/cities');
            }
        }
    }

    public function status($id) {
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth/login', 'refresh');
        } else {
            $chk   = User::find_by_id($id);
            $email = $chk->email;
            $name  = $chk->first_name . ' ' . $chk->last_name;
            //print_r($email .' '.$name); die;
            if ($chk->verification == 1) {

                $chk->update_attributes(array('verification' => 0));

                $data = array(
                    'message' => 'Unfortunately! Our backend team has reviewed your account details and found that the document you have uploaded are inaccurate and so your account could not be verified',
                    'name'    => $name,
                );
                $message = $this->load->view('emails/verification_email', $data, TRUE);
                $send    = $this->custom_email->send($email, $name, "[UrbanSense] Account Unverified", $message);
            } else {
                $chk->update_attributes(array('verification' => 1));
                $chk->update_attributes(array('active' => 1));
                $data = array(
                    'message' => 'Congratulations! Our backend team has reviewed your account details and approved your request. You can now see all the details on your dashboard and perform relevant actions.
					You are advised to keep your account information up to date in order to keep receiving order requests and payments against orders.',
                    'name'    => $name,
                );
                $message = $this->load->view('emails/verification_email', $data, TRUE);
                $send    = $this->custom_email->send($email, $name, "[UrbanSense] Account Verified", $message);
            }

            $this->session->set_flashdata('success', 'User Status Changed Successfully');
            redirect('admin/Professionals');
        }
    }

    public function criminal_varification($id = null) {
        $chk = Professional::find_by_user_id($id);
        if ($chk->criminal_varification == 1) {
            $chk->update_attributes(array('criminal_varification' => 0));

            print_r(json_encode(array('message' => 'Criminal Verification status unverified successfully')));
        } else {
            $chk->update_attributes(array('criminal_varification' => 1));
            print_r(json_encode(array('message' => 'Criminal Verification status verified successfully')));
        }
    }

    public function bank_varification($id = null) {

        //$id = $this->uri->segment(4);
        $chk = Professional::find_by_user_id($id);
        if ($chk->bank_varification == 1) {
            $chk->update_attributes(array('bank_varification' => 0));
            print_r(json_encode(array('message' => 'Bank Verification status  unverified successfully')));
        } else {
            $chk->update_attributes(array('bank_varification' => 1));
            print_r(json_encode(array('message' => 'Bank Verification status verified successfully')));
        }
    }

    public function skill_assessment($id = null) {

        //$id = $this->uri->segment(4);
        $chk = Professional::find_by_user_id($id);
        // print_r($id); die;
        if ($chk->skill_assessment == 1) {
            $chk->update_attributes(array('skill_assessment' => 0));
            print_r(json_encode(array('message' => 'Skill assement status unverified successfully')));
        } else {
            $chk->update_attributes(array('skill_assessment' => 1));
            print_r(json_encode(array('message' => 'Skill assement status verified successfully')));
        }
    }

    public function professional_detail($id = null) {
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth/login', 'refresh');
        } else {
            $this->data['title'] = 'Professional Details';
            $this->data['user']  = User::find_by_id($id);
            $this->template->load('admin/admin_base', 'admin/service_provider/professional_detail', $this->data);
        }
    }

    public function customer() {
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth/login', 'refresh');
        } else {
            $config['per_page']   = 20;
            $config['total_rows'] = User::count(array('select' => 'users.id', 'joins' => 'inner join users_groups on users_groups.user_id=users.id ', 'conditions' => array('users_groups.group_id = ?', 2)));
            $config['base_url']   = base_url('admin/professionals/customer');
            $page                 = (null !== $this->input->get('page')) ? $this->input->get('page') : 1;
            $start_index          = ($page - 1) * $config['per_page'];

            $data = array(
                'users'      => User::find('all', array('select' => 'users.first_name as first_name, users.last_name as last_name, users.email as email,users.phone as phone, users.id as id, users.active as active', 'joins' => 'right join users_groups on users_groups.user_id=users.id ', 'conditions' => array('users_groups.group_id = ?', 2), 'limit' => $config['per_page'], 'offset' => $start_index, 'order' => 'users.created_at desc')),
                'title'      => 'Service Provider',
                'pagination' => $this->custom_pagination->create_backend_pagination($config),
            );

            $this->template->load('admin/admin_base', 'admin/service_provider/customer_list', $data);
        }
    }

    public function customer_status($id) {
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth/login', 'refresh');
        } else {
            $chk = User::find_by_id($id);
            if ($chk->active == 1) {
                $chk->update_attributes(array('active' => 0));
            } else {
                $chk->update_attributes(array('active' => 1));
            }

            $this->session->set_flashdata('success', 'User Status Changed Successfully');
            redirect('admin/Professionals/customer');
        }
    }

    public function customer_detail($id = null) {
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth/login', 'refresh');
        } else {
            $this->data['title']           = 'Customer Details';
            $this->data['user']            = User::find_by_id($id);
            $this->data['total_booking']   = QuoteRequest::count(array('conditions' => array('user_id = ?', $id)));
            $this->data['cancel_booking']  = QuoteRequest::count(array('conditions' => array('status = 0 AND user_id = ?', $id)));
            $this->data['ongoing_booking'] = QuoteRequest::count(array('conditions' => array('status = 1 AND user_id = ?', $id)));
            $this->template->load('admin/admin_base', 'admin/service_provider/customer_detail', $this->data);
        }
    }

    public function featured_service_provider($id = null) {
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth/login', 'refresh');
        } else {
            $category = Professional::find_by_user_id($id);
            if ($category->featured_service_provider == 1) {
                $category->update_attributes(array('featured_service_provider' => 0));
                echo json_encode(array('message' => 'featured service provider status change to service provider successfully'));
            } else {
                $category->update_attributes(array('featured_service_provider' => 1));
                echo json_encode(array('message' => 'service provider status change to featured service provider successfully'));
            }
        }
    }

    function search_service_providers() {
        //print_r('expression'); die;
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth/login', 'refresh');
        } else {
            $data = array();

            $conditions = '';
            $name       = trim($this->input->get("name"));
            $status     = $this->input->get("status");
            $start_date = $this->input->get("start_date") ? date('Y-m-d', strtotime($this->input->get("start_date"))) : '';
            $end_date   = $this->input->get("end_date") ? date('Y-m-d', strtotime($this->input->get("end_date"))) : '';
            //print_r(date('Y-m-d 23:59:59',strtotime($start_date)) .' '.date('Y-m-d 23:59:59',strtotime($end_date))); die;
            if ($start_date AND $end_date) {
                $conditions .= " AND users.created_at BETWEEN " . "'" . $start_date . " 00:00:00'" . " AND " . "'" . $end_date . " 23:59:59'" . "";
            }

            if ($name != '') {

                $city_id = '';
                $city    = City::find(array('select' => 'id', 'conditions' => array('title = ?', $name)));
                if ($city != '') {
                    $city_id = $city->id;
                }

                $last_name  = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
                $first_name = trim(preg_replace('#' . $last_name . '#', '', $name));

                $conditions .= " and (users.first_name LIKE '%" . $name . "%' OR users.last_name LIKE '%" . $name . "%' OR users.email LIKE '%" . $name . "%' OR professionals.city_id ='" . $city_id . "' OR users.first_name LIKE '%" . $first_name . "%' AND  users.last_name LIKE '%" . $last_name . "%')";
            }

            if ($status != '') {

                $conditions .= "AND  (users.verification = " . $status . ")";
            }

            $rating = $this->input->get("rating");
            if ($rating != '') {

//                $conditions .= "AND  (users.rating = " . $rating . ")";
            }

            $data = array(
                'users' => User::all(array('select' => 'professionals.featured_service_provider as featured_service_provider, professionals.city_id as city_id,professionals.criminal_varification  as criminal_varification, professionals.bank_varification as bank_varification, professionals.skill_assessment as skill_assessment,  professionals.service_id as service_id,users.verification, users.first_name as first_name, users.last_name as last_name, users.email as email, users.id as id, users.verification as verification, (AVG(reviews.professionalism)+ AVG(reviews.knowledge)+AVG(reviews.cost)+AVG(reviews.punctuality)+ AVG(reviews.tidiness))/5 as total_avg', 'joins' => 'left join professionals on professionals.user_id=users.id left join reviews on reviews.professional_id =users.id ', 'group' => 'users.id', 'order' => 'professionals.created_at desc', 'conditions' => array("professionals.status = '1' " . $conditions))),
                /* 'users' => User::all(array('select'=>'professionals.featured_service_provider as featured_service_provider, professionals.city_id as city_id,professionals.criminal_varification  as criminal_varification, professionals.bank_varification as bank_varification, professionals.skill_assessment as skill_assessment,  professionals.service_id as service_id,users.first_name as first_name, users.last_name as last_name, users.email as email, users.id as id, users.verification as verification', 'joins'=> 'inner join professionals on professionals.user_id=users.id ', 'order' => 'professionals.created_at desc','conditions'=>array("status = '1' ". $conditions))), */
                'title' => 'Service Provider',
            );

            $this->template->load('admin/admin_base', 'admin/service_provider/service_provider_list', $data);
        }
    }

    function search_customers() {
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth/login', 'refresh');
        } else {
            $data       = array();
            $conditions = '';
            $name       = $this->input->get("name");
            $status     = $this->input->get("status");
            $start_date = $this->input->get("start_date") ? date('Y-m-d', strtotime($this->input->get("start_date"))) : '';
            $end_date   = $this->input->get("end_date") ? date('Y-m-d', strtotime($this->input->get("end_date"))) : '';
            //print_r(date('Y-m-d 23:59:59',strtotime($start_date)) .' '.date('Y-m-d 23:59:59',strtotime($end_date))); die;
            if ($start_date AND $end_date) {
                $conditions .= " AND users.created_at BETWEEN " . "'" . $start_date . " 00:00:00'" . " AND " . "'" . $end_date . " 23:59:59'" . "";
            }

            if ($name != '') {

                $last_name  = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
                $first_name = trim(preg_replace('#' . $last_name . '#', '', $name));

                $conditions .= "AND  (first_name LIKE '%" . $name . "%' OR last_name LIKE '%" . $name . "%' OR email LIKE '%" . $name . "%' OR first_name LIKE '%" . $first_name . "%' AND  last_name LIKE '%" . $last_name . "%')";
            }

            if ($status != '') {

                $conditions .= "AND  (active = " . $status . ")";
            }

            // print_r($conditions); die;

            $data = array(
                'users' => User::find('all', array('select' => 'users.first_name as first_name, users.last_name as last_name, users.email as email,users.phone as phone, users.id as id, users.active as active', 'joins' => 'right join users_groups on users_groups.user_id=users.id ', 'conditions' => array('users_groups.group_id = 2 ' . $conditions), 'order' => 'users.created_at desc')),
                'title' => 'Customer',
            );

            $this->template->load('admin/admin_base', 'admin/service_provider/customer_list', $data);
        }
    }

    function add_customer() {
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth/login', 'refresh');
        } else {
            if ($this->input->post()) {
                $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|max_length[30]');

                $this->form_validation->set_rules('phone', 'phone', 'required|max_length[15]|is_unique[users.phone]');
                $this->form_validation->set_rules('email', 'Email', 'required|max_length[50]|valid_email|is_unique[users.email]');
                $this->form_validation->set_rules('password', 'Password', 'required|max_length[20]|min_length[8] ');
                $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|max_length[20]|matches[password]');
                if ($this->form_validation->run() == FALSE) {
                    if (validation_errors()) {
                        $this->session->set_flashdata("warning", validation_errors());
                    }
                    $this->data['title'] = 'Add Customer';
                    $this->template->load('admin/admin_base', 'admin/service_provider/add_update_customer', $this->data);
                } else {

                    $email           = strtolower($this->input->post('email'));
                    $identity        = strtolower($this->input->post('email'));
                    $password        = $this->input->post('password');
                    $activation_code = md5(rand(10, 100));
                    $first_name      = $this->input->post('first_name');

                    $additional_data = array(
                        'first_name'      => $first_name,
                        'last_name'       => $this->input->post('last_name'),
                        'phone'           => $this->input->post('phone'),
                        'ip_address'      => $this->input->ip_address(),
                        'activation_code' => $activation_code,
                    );

                    $id        = $this->ion_auth->register($identity, $password, $email, $additional_data, 2);
                    $mail_temp = array(
                        'id'       => $id,
                        'name'     => $first_name,
                        'password' => $password,
                        'email'    => $email,
                        'key'      => $activation_code,
                    );
                    //print_r($mail_temp) ; die;
                    $message = $this->load->view('emails/register_user_account', $mail_temp, TRUE);
                    $send    = $this->custom_email->send($this->input->post('email'), $this->input->post('first_name'), "UrbanSense Account Created", $message);
                    $this->session->set_flashdata('success', 'Customer account created successfully');
                    redirect('admin/professionals/customer');
                }
            } else {
                $data = array('title' => 'Add Customer');
                $this->template->load('admin/admin_base', 'admin/service_provider/add_update_customer', $data);
            }
        }
    }

    function edit_customer($id = null) {
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth/login', 'refresh');
        } else {
            $user = User::find_by_id($id);

            if ($this->input->post()) {
                $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|max_length[30]');
                $this->form_validation->set_rules('phone', 'phone', 'required|max_length[15]');
                $this->form_validation->set_rules('email', 'Email', 'required|max_length[50]');

                if ($this->form_validation->run() == FALSE) {
                    if (validation_errors()) {
                        $this->session->set_flashdata("warning", validation_errors());
                    }
                    $this->data['title'] = 'Update customer';
                    $this->template->load('admin/admin_base', 'admin/service_provider/add_update_customer', $data);
                } else {

                    $email     = strtolower($this->input->post('email'));
                    $identity  = strtolower($this->input->post('email'));
                    $old_email = $user->email;

                    $additional_data = array(
                        'first_name' => $this->input->post('first_name'),
                        'last_name'  => $this->input->post('last_name'),
                        'phone'      => $this->input->post('phone'),
                        'email'      => $email,
                    );

                    $user->update_attributes($additional_data);

                    $message = $this->load->view('emails/update_customerprofile_by_admin', $additional_data, TRUE);
                    $send    = $this->custom_email->send($old_email, 'UrbanSense', "UrbanSense Account Updated", $message);

                    $this->session->set_flashdata('success', 'Customer account updated successfully');
                    redirect('admin/professionals/customer');
                }
            } else {
                $data = array(
                    'title' => 'Update Customer',
                    'user'  => $user,
                );
                $this->template->load('admin/admin_base', 'admin/service_provider/add_update_customer', $data);
            }
        }
    }

    function add_professional() {
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth/login', 'refresh');
        } else {

            $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|max_length[30]');
            $this->form_validation->set_rules('phone', 'phone', 'required|max_length[15]|is_unique[users.phone]');
            $this->form_validation->set_rules('email', 'Email', 'required|max_length[50]|valid_email|is_unique[users.email]');
            $this->form_validation->set_rules('service_id[]', 'Service', 'required');
            $this->form_validation->set_rules('city_id', 'City', 'required');
            $this->form_validation->set_rules('address', 'Address', 'required|max_length[100]');
            $this->form_validation->set_rules('latitude', 'Address', 'required');
            $this->form_validation->set_rules('longitude', 'Address', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required|max_length[20]|min_length[8] ');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|max_length[20]|matches[password]');
            if ($this->form_validation->run() == FALSE) {
                if (validation_errors()) {
                    $this->session->set_flashdata("warning", validation_errors());
                    //print_r(validation_errors()); die;
                }
                $this->data['title']    = 'Add Service Provider';
                $this->data['services'] = Service::all(array('conditions' => array('status=1'), 'order' => 'title asc'));
                $this->data['cities']   = City::all(array('conditions' => array('status=1')));
                //print_r($this->data['cities']) ;
                $this->template->load('admin/admin_base', 'admin/service_provider/add_update_professional', $this->data);
            } else {

                $email           = strtolower($this->input->post('email'));
                $identity        = strtolower($this->input->post('email'));
                $password        = $this->input->post('password');
                $activation_code = md5(rand(10, 100));
                $first_name      = $this->input->post('first_name');

                $additional_data = array(
                    'first_name'      => $first_name,
                    'last_name'       => $this->input->post('last_name'),
                    'phone'           => $this->input->post('phone'),
                    'ip_address'      => $this->input->ip_address(),
                    'activation_code' => $activation_code,
                );

                $id = $this->ion_auth->register($identity, $password, $email, $additional_data, 3);

                $mail_temp = array(
                    'id'       => $id,
                    'name'     => $first_name,
                    'password' => $password,
                    'email'    => $email,
                    'key'      => $activation_code,
                );

                if ($id) {
                    //print_r($user); exit();
                    $user = User::find_by_id($id);
                    Professional::create(
                        array(
                            'user_id'    => $user->id,
                            'service_id' => $this->input->post('service_id'),
                            'city_id'    => $this->input->post('city_id'),
                            'address'    => $this->input->post('address'),
                            'latitude'   => $this->input->post('latitude'),
                            'longitude'  => $this->input->post('longitude'),
                        )
                    );

                    $services = filter_input(INPUT_POST, 'service_id', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
                    //ProfessionalService::delete_all(array("conditions" => array("user_id = ?", $user->id)));
                    foreach ($services as $row) {
                        ProfessionalService::create(array('user_id' => $user->id, 'service_id' => $row));
                    }

                    //ProfessionalService::create(array('user_id'=> $user->id,'service_id'=>$this->input->post('service_id')));

                    $message = $this->load->view('emails/register_sp_account', $mail_temp, TRUE);
                    $send    = $this->custom_email->send($this->input->post('email'), $this->input->post('first_name'), "UrbanSense Account Created", $message);

                    $this->session->set_flashdata('success', 'Service Provider account created successfully');
                    redirect('admin/professionals');
                }
            }
        }
    }

    function edit_professional($id = null) {
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth/login', 'refresh');
        } else {

            $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|max_length[30]');
            $this->form_validation->set_rules('phone', 'phone', 'required|max_length[15]');
            $this->form_validation->set_rules('email', 'Email', 'required|max_length[50]|valid_email');
            $this->form_validation->set_rules('service_id[]', 'Service', 'required');
            $this->form_validation->set_rules('city_id', 'City', 'required');
            $this->form_validation->set_rules('address', 'Address', 'required|max_length[100]');
            $this->form_validation->set_rules('latitude', 'Address', 'required');
            $this->form_validation->set_rules('longitude', 'Address', 'required');

            if ($this->form_validation->run() == FALSE) {
                if (validation_errors()) {
                    $this->session->set_flashdata("warning", validation_errors());
                    //print_r(validation_errors()); die;
                }
                $this->data['title']    = 'Update Service Provider';
                $this->data['services'] = Service::all(array('conditions' => array('status=1'), 'order' => 'title asc'));
                $this->data['user']     = User::find_by_id($id);
                $this->data['cities']   = City::all(array('conditions' => array('status=1')));
                $this->template->load('admin/admin_base', 'admin/service_provider/add_update_professional', $this->data);
            } else {

                $email    = strtolower($this->input->post('email'));
                $identity = strtolower($this->input->post('email'));

                $additional_data = array(
                    'first_name' => $this->input->post('first_name'),
                    'last_name'  => $this->input->post('last_name'),
                    'company'    => $this->input->post('company'),
                    'phone'      => $this->input->post('phone'),
                    'active'     => 1,
                );
                $user = User::find_by_id($id);
                $user->update_attributes($additional_data);
                $old_email = $user->email;

                if ($id) {
                    $profile = Professional::find_by_user_id($user->id);

                    $this->load->library('Upload_file');
					//print_r($_FILES['id_card_image']['name']); die;
					$array = array('png', 'jpg', 'jpeg', 'gif');
					$filename = @$_FILES["id_card_image"]["name"];
					$file_ext = pathinfo($filename, PATHINFO_EXTENSION);
					if (@$_FILES['id_card_image']['size'] != 0) { // if  image selected
						if (in_array($file_ext, $array)) {

							@unlink('./uploads/id_card_image/' . $profile->id_card_image);
							$card_image = $this->upload_file->optional_image_upload('id_card_image');
							
						} else {
							$this->session->set_flashdata("warning", 'File format not supported. Please upload only jpg, jpeg, png and gif file');
							redirect("Professionals/edit_professional/{$id}", 'refresh');
						}
					}


                    $id_card_image = isset($card_image) ? $card_image : $profile->id_card_image;
                    
					$filename1 = @$_FILES["bank_passbook_image"]["name"];
					$file_ext1 = pathinfo($filename1, PATHINFO_EXTENSION);
					if (@$_FILES['bank_passbook_image']['size'] != 0) { // if  image selected
						if (in_array($file_ext1, $array)) {
							@unlink('./uploads/bank_passbook_image/' . $profile->bank_passbook_image);
							$passbook_image = $this->upload_file->optional_image_upload('bank_passbook_image');
						} else {
							$this->session->set_flashdata("warning", 'File format not supported. Please upload only jpg, jpeg, png and gif file');
							redirect("Professionals/edit_professional/{$id}", 'refresh');
						}
					}

					$bank_passbook_image = isset($passbook_image) ? $passbook_image : $profile->bank_passbook_image;
                    //print_r($professional_id); die;
                    $profile_data = array(
                        'city_id' => $this->input->post('city_id'),
						'address' => $this->input->post('address'),
						'company_name' => $this->input->post('company_name'),
						'company_detail' => $this->input->post('company_detail'),
						'introduction' => $this->input->post('introduction'),
						'price' => $this->input->post('price'),
						'latitude' => $this->input->post('latitude'),
						'longitude' => $this->input->post('longitude'),
						'id_type' => $this->input->post('id_type'),
						'id_number' => $this->input->post('id_number'),
						'account_holder_name' => $this->input->post('account_holder_name'),
						'account_number' => $this->input->post('account_number'),
						'ifsc' => $this->input->post('ifsc'),
						'branch' => $this->input->post('branch'),
						'bank_passbook_image' => $bank_passbook_image,
						'id_card_image' => $id_card_image
                    );
                    //print_r($profile_data);exit;
                    $profile->update_attributes($profile_data);

                    $services = filter_input(INPUT_POST, 'service_id', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
                    ProfessionalService::delete_all(array("conditions" => array("user_id = ?", $user->id)));
                    foreach ($services as $row) {
                        ProfessionalService::create(array('user_id' => $user->id, 'service_id' => $row));
                    }
                   
                    $data = array(
                        'first_name' => $this->input->post('first_name'),
                        'last_name'  => $this->input->post('last_name'),
                        'phone'      => $this->input->post('phone'),
                        'email'      => $email,
                        'service'    => get_service($this->input->post('service_id')),
                        'city'       => get_city($this->input->post('city_id')),
                    );
                    $message = $this->load->view('emails/update_spprofile_by_admin', $data, TRUE);
                    $send    = $this->custom_email->send($old_email, 'UrbanSense', "UrbanSense Account Updated", $message);
                    $this->session->set_flashdata('success', 'Service Provider account updated successfully');
                    redirect('admin/professionals');
                }
            }
        }
    }

    public function descReview() {
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth/login', 'refresh');
        } else {
            $config['per_page']   = 20;
            $config['total_rows'] = Professional::count();
            $config['base_url']   = base_url('admin/professionals/descReview');
            $page                 = (null !== $this->input->get('page')) ? $this->input->get('page') : 1;
            $start_index          = ($page - 1) * $config['per_page'];

            $data = array(
                'users'      => User::all(array('select' => 'professionals.featured_service_provider as featured_service_provider, professionals.city_id as city_id,professionals.criminal_varification  as criminal_varification, professionals.bank_varification as bank_varification, professionals.skill_assessment as skill_assessment,  professionals.service_id as service_id,users.first_name as first_name, users.last_name as last_name, users.email as email, users.id as id, users.verification as verification, (AVG(reviews.professionalism)+ AVG(reviews.knowledge)+AVG(reviews.cost)+AVG(reviews.punctuality)+ AVG(reviews.tidiness))/5 as total_avg', 'joins' => 'left join professionals on professionals.user_id=users.id left join reviews on reviews.professional_id =users.id ', 'group' => 'users.id', 'limit' => $config['per_page'], 'offset' => $start_index, 'order' => 'total_avg desc')),
                'title'      => 'Service Provider',
                'pagination' => $this->custom_pagination->create_backend_pagination($config),
            );

            // print_r(User::connection()->last_query);exit;

            $this->template->load('admin/admin_base', 'admin/service_provider/service_provider_list', $data);
        }
    }

    public function ascReview() {
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth/login', 'refresh');
        } else {
            $config['per_page']   = 20;
            $config['total_rows'] = Professional::count();
            $config['base_url']   = base_url('admin/professionals/ascReview');
            $page                 = (null !== $this->input->get('page')) ? $this->input->get('page') : 1;
            $start_index          = ($page - 1) * $config['per_page'];

            $data = array(
                'users'      => User::all(array('select' => 'professionals.featured_service_provider as featured_service_provider, professionals.city_id as city_id,professionals.criminal_varification  as criminal_varification, professionals.bank_varification as bank_varification, professionals.skill_assessment as skill_assessment,  professionals.service_id as service_id,users.first_name as first_name, users.last_name as last_name, users.email as email, users.id as id, users.verification as verification, (AVG(reviews.professionalism)+ AVG(reviews.knowledge)+AVG(reviews.cost)+AVG(reviews.punctuality)+ AVG(reviews.tidiness))/5 as total_avg', 'joins' => 'left join professionals on professionals.user_id=users.id left join reviews on reviews.professional_id =users.id ', 'group' => 'users.id', 'limit' => $config['per_page'], 'offset' => $start_index, 'order' => 'total_avg asc')),
                'title'      => 'Service Provider',
                'pagination' => $this->custom_pagination->create_backend_pagination($config),
            );

            // print_r(User::connection()->last_query);exit;

            $this->template->load('admin/admin_base', 'admin/service_provider/service_provider_list', $data);
        }
    }

}
