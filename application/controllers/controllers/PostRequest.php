<?php

defined('BASEPATH') or exit('No direct script access allowed');

class PostRequest extends MY_Controller
{

    public function index()
    {

        $this->data['title'] = 'Post Request';
        $this->data['services'] = Service::all(array('conditions' => array('status=1'), 'order' => 'title asc'));
        $this->data['cities'] = City::all(array('conditions' => array('status=1')));
        $this->template->load('frontend/front_base', 'frontend/post_request', $this->data);
    }

    public function post_request()
    {

        //print_r($this->input->GET()); die;
        $this->form_validation->set_rules('location', 'location', 'required');
        $this->form_validation->set_rules('service', 'Service', 'required');
        $this->form_validation->set_rules('avail_date', 'Available Date', 'required');
        $this->form_validation->set_rules('avail_time', 'Available Time', 'required');
        $this->form_validation->set_rules('request_details', 'Request Detail', 'required|max_length[500]');

        if ($this->form_validation->run() == FALSE) {
            if ($this->input->is_ajax_request()) {

                if (validation_errors()) {

                    print_r(json_encode(array("status" => "error", "message" => validation_errors())));
                }
            }
        } else {

            if (!$this->ion_auth->logged_in()) {
                $query_data = base_url('PostRequest/post_submit_after_login?') . 'latitude=' . $this->input->post('latitude') .
                    '&longitude=' . $this->input->post('longitude') .
                    '&service=' . $this->input->post('service') .
                    '&avail_date=' . $this->input->post('avail_date') .
                    '&avail_time=' . $this->input->post('avail_time') .
                    '&request_details=' . $this->input->post('request_details') .
                    '&location=' . $this->input->post('location');
                $this->session->set_userdata('queryform', $query_data);

                print_r(json_encode(array("status" => "destination", "destination" => 'login', 'message' => 'Please login/sign up as a customer to get quotes')));
            } else if (!$this->ion_auth->is_member()) {

                print_r(json_encode(array("status" => "error", 'message' => 'You are currently logged in as a service provider. Please register as a customer to request for a quote.')));
            } else {

                delete_cookie('service_slug');
                delete_cookie('location');
                delete_cookie('latitude');
                delete_cookie('longitude');

                set_cookie('service_slug', $this->input->post('service'), '360000');
                set_cookie('location', $this->input->post('location'), '3600');
                set_cookie('latitude', $this->input->post('latitude'), '3600');
                set_cookie('longitude', $this->input->post('longitude'), '3600');



                $service_id = Service::find_by_slug($this->input->post('service'))->id;
                $lat1 = $this->input->post('latitude');
                $long1 = $this->input->post('longitude');

                $data = array(
                    'user_id' => $this->ion_auth->user()->row()->id,
                    'service_id' => $service_id,
                    'avail_date' => $this->input->post('avail_date'),
                    'location' => $this->input->post('location'),
                    'latitude' => $lat1,
                    'longitude' => $long1,
                    'avail_time' => $this->input->post('avail_time'),
                    'request_details' => $this->input->post('request_details')
                );



                if ($service_id and $lat1 != null and $long1 != null) {

                    $query = $this->get_professionals_by_city($service_id, $lat1, $long1);

                    //echo '<pre>';print_r($query);exit;

                    if (!empty($query)) {

                        $request = QuoteRequest::create($data);

                        foreach ($query as $row) {
                            $quote_data = array(
                                'quote_request_id' => $request->id,
                                'professional_id' => $row['user_id'],
                                'status' => 1
                            );
                            $is_send = ResponseForProposal::create($quote_data);
                            $recipient = User::find_by_id($row['user_id']);
                            foreach ($recipient->user_authentications as $row) {
                                $device_id = array($row->device_id);
                                if (!empty($device_id)) {
                                    $this->send_notification($device_id, 'You have received a request to submit a proposal for ' . get_service($service_id), 'New Lead', $this->data['loggedin_user']->first_name, 'lead');
                                }
                            }

                            // Send OTP to the user's phone and email
                            if ($recipient) {
                                send_otp_on_mobile($recipient->phone, "You have received a new service request. Please log in to check the details");
                                $mail_data = array(
                                    'name' => $recipient->first_name . ' ' . $recipient->last_name,
                                    'request' => $request
                                );
                                $message = $this->load->view('emails/new_service_request', $mail_data, TRUE);
                                $this->custom_email->send($recipient->email, $recipient->first_name . ' ' . $recipient->last_name, "UrbanSense New Service Request", $message);
                            }
                        }

                        print_r(json_encode(array("status" => "success", 'message' => 'Your request was submitted successfully. You will get quote from service providers.')));
                    } else {
                        print_r(json_encode(array("status" => "error", 'message' => 'We are sorry there are no service providers in your area, we are working on getting more, please try again later')));
                    }
                }
            }
        }
    }

    public function post_request_individual()
    {
        //	print_r($this->input->post()); die;
        $this->form_validation->set_rules('location', 'location', 'required');
        $this->form_validation->set_rules('service', 'Service', 'required');
        $this->form_validation->set_rules('avail_date', 'Available Date', 'required');
        $this->form_validation->set_rules('avail_time', 'Available Time', 'required');
        $this->form_validation->set_rules('request_details', 'Request Detail', 'required|max_length[500]');

        if ($this->form_validation->run() == FALSE) {
            //print_r(validation_errors()); die;
            if ($this->input->is_ajax_request()) {

                if (validation_errors()) {

                    print_r(json_encode(array("status" => "error", "message" => validation_errors())));
                }
            }
        } else {

            if (!$this->ion_auth->logged_in()) {

                $query_data = base_url('PostRequest/post_individual_request_after_login?') . 'latitude=' . $this->input->post('latitude') .
                    '&longitude=' . $this->input->post('longitude') .
                    '&service=' . $this->input->post('service') .
                    '&avail_date=' . $this->input->post('avail_date') .
                    '&avail_time=' . $this->input->post('avail_time') .
                    '&request_details=' . $this->input->post('request_details') .
                    '&location=' . $this->input->post('location') .
                    '&professional_id=' . $this->input->post('professional_id');
                $this->session->set_userdata('queryform', $query_data);
                print_r(json_encode(array("status" => "destination", "destination" => 'login', 'message' => 'Please login/sign up as a customer to get quotes')));
            } else if (!$this->ion_auth->is_member()) {
                print_r(json_encode(array("status" => "error", 'message' => 'You are currently logged in as a service provider. Please register as a customer to request for a quote.')));
            } else {

                delete_cookie('service_slug');
                delete_cookie('location');
                delete_cookie('latitude');
                delete_cookie('longitude');

                set_cookie('service_slug', $this->input->post('service'), '360000');
                set_cookie('location', $this->input->post('location'), '3600');
                set_cookie('latitude', $this->input->post('latitude'), '3600');
                set_cookie('longitude', $this->input->post('longitude'), '3600');


                $service_id = Service::find_by_slug($this->input->post('service'))->id;

                $data = array(
                    'user_id' => $this->ion_auth->user()->row()->id,
                    'service_id' => $service_id,
                    'avail_date' => $this->input->post('avail_date'),
                    'location' => $this->input->post('location'),
                    'latitude' => $this->input->post('latitude'),
                    'longitude' => $this->input->post('longitude'),
                    'avail_time' => $this->input->post('avail_time'),
                    'request_details' => $this->input->post('request_details')
                );


                $request = QuoteRequest::create($data);
                $quote_data = array(
                    'quote_request_id' => $request->id,
                    'professional_id' => $this->input->post('professional_id'),
                    'status' => 1
                );
                $is_send = ResponseForProposal::create($quote_data);
                if ($is_send = TRUE) {

                    $recipient = User::find_by_id($this->input->post('professional_id'));
                    foreach ($recipient->user_authentications as $row) {
                        $device_id = array($row->device_id);
                        if (!empty($device_id)) {
                            $this->send_notification($device_id, 'You have received a request to submit a proposal for ' . get_service($service_id), 'New Lead', $this->data['loggedin_user']->first_name, 'lead');
                        }
                    }

                    // Send OTP to the user's phone and email
                    if ($recipient) {
                        send_otp_on_mobile($recipient->phone, "You have received a new service request. Please log in to check the details");
                        $mail_data = array(
                            'name' => $recipient->first_name . ' ' . $recipient->last_name,
                            'request' => $request
                        );
                        $message = $this->load->view('emails/new_service_request', $mail_data, TRUE);
                        $this->custom_email->send($recipient->email, $recipient->first_name . ' ' . $recipient->last_name, "UrbanSense New Service Request", $message);
                    }



                    print_r(json_encode(array("status" => "success", 'message' => 'Your request was submitted successfully. You will get quote from service providers.')));
                } else {
                    print_r(json_encode(array("status" => "error", "message" => 'Your requirement is not submitted. Please try again.')));
                }
            }
        }
    }

    function post_submit_after_login()
    {
        $service_id = Service::find_by_slug($this->input->get('service'))->id;
        $lat1 = $this->input->get('latitude');
        $long1 = $this->input->get('longitude');



        if ($service_id and $lat1 != null and $long1 != null) {
            $query = $this->get_distance($service_id, $lat1, $long1);
            if (!empty($query)) {

                $data = array(
                    'user_id' => $this->ion_auth->user()->row()->id,
                    'service_id' => $service_id,
                    'avail_date' => $this->input->get('avail_date'),
                    'location' => $this->input->get('location'),
                    'latitude' => $lat1,
                    'longitude' => $long1,
                    'avail_time' => $this->input->get('avail_time'),
                    'request_details' => $this->input->get('request_details')
                );

                $request = QuoteRequest::create($data);
                foreach ($query as $row) {
                    $quote_data = array(
                        'quote_request_id' => $request->id,
                        'professional_id' => $row['user_id'],
                        'status' => 1
                    );
                    ResponseForProposal::create($quote_data);
                    $recipient = User::find_by_id($row['user_id']);
                    foreach ($recipient->user_authentications as $row) {
                        $device_id = array($row->device_id);
                        if (!empty($device_id)) {
                            $this->send_notification($device_id, 'You have received a request to submit a proposal for ' . get_service($service_id), 'New Lead', $this->data['loggedin_user']->first_name, 'lead');
                        }
                    }
                }

                $this->session->set_flashdata('success', 'Your request was submitted successfully. You will get quote from service providers.');
            } else {

                $this->session->set_flashdata('error', 'we are sorry there are no service providers in your area, we are working on getting more, please try again later');
            }
            $this->session->unset_userdata('queryform');
            redirect(base_url());

            /* foreach ($query as $row) {
              $quote_data = array('quote_request_id' => $request->id,
              'professional_id' => $row['user_id'],
              'status' => 1
              );
              $is_send = ResponseForProposal::create($quote_data);
              }
             */
        }
    }

    function post_individual_request_after_login()
    {
        $service_id = Service::find_by_slug($this->input->get('service'))->id;

        $data = array(
            'user_id' => $this->ion_auth->user()->row()->id,
            'service_id' => $service_id,
            'avail_date' => $this->input->get('avail_date'),
            'location' => $this->input->get('location'),
            'latitude' => $this->input->get('latitude'),
            'longitude' => $this->input->get('longitude'),
            'avail_time' => $this->input->get('avail_time'),
            'request_details' => $this->input->get('request_details')
        );


        $request = QuoteRequest::create($data);
        $quote_data = array(
            'quote_request_id' => $request->id,
            'professional_id' => $this->input->get('professional_id'),
            'status' => 1
        );
        $is_send = ResponseForProposal::create($quote_data);
        $recipient = User::find_by_id($this->input->get('professional_id'));
        foreach ($recipient->user_authentications as $row) {
            $device_id = array($row->device_id);
            if (!empty($device_id)) {
                $this->send_notification($device_id, 'You have received a request to submit a proposal for ' . get_service($service_id), 'New Lead', $this->data['loggedin_user']->first_name, 'lead');
            }
        }

        $this->session->unset_userdata('queryform');
        $this->session->set_flashdata('success', 'Your request was submitted successfully. You will get quote from service providers.');
        redirect(base_url());
    }

    public function post_request_email()
    {

        if ($this->input->post()) {

            if ($this->ion_auth->is_member()) {

                $this->form_validation->set_rules('location', 'location', 'required');
                $this->form_validation->set_rules('service', 'Service', 'required');
                $this->form_validation->set_rules('avail_date', 'Available Date', 'required');
                $this->form_validation->set_rules('avail_time', 'Available Time', 'required');
                $this->form_validation->set_rules('request_details', 'Request Detail', 'required|max_length[500]');

                if ($this->form_validation->run() == FALSE) {
                    //print_r(validation_errors()); die;
                    if ($this->input->is_ajax_request()) {

                        if (validation_errors()) {

                            print_r(json_encode(array("status" => "error", "message" => validation_errors())));
                        }
                    }
                } else {
                    $user = get_user($this->ion_auth->user()->row()->id);
                    $data = array(
                        'customeremail' => $user->email,
                        'customerphone' => $user->phone,
                        'name' => $user->first_name,
                        'service' => $this->input->post('service'),
                        'location' => $this->input->post('location'),
                        'avail_date' => $this->input->post('avail_date'),
                        'avail_time' => $this->input->post('avail_time'),
                        'request_details' => $this->input->post('request_details')
                    );

                    $subject1 = "Your request to avail the service provider has been received";
                    $subject2 = "A new request to provide the service provider has been received";
                    $message1 = $this->load->view('emails/no_serviceprovider_found', $data, TRUE);
                    $message2 = $this->load->view('emails/no_serviceprovider_admin', $data, TRUE);
                    $email = $this->data['site_data']->email;
                    $this->custom_email->send($user->email, "UrbanSense ", $subject1, $message1);
                    $this->custom_email->send($email, "UrbanSense", $subject2, $message2);
                    print_r(json_encode(array("status" => "success", 'message' => 'Your request was submitted successfully. You will get quote from service providers.')));
                }
            } else {
                print_r(json_encode(array("status" => "error", 'message' => 'You are currently logged in as a service provider. Please register as a customer to request for a quote.')));
            }
        } else {
            $this->data['services'] = Service::all(array('conditions' => array('status=1'), 'order' => 'title asc'));
            $this->template->load('frontend/front_base', 'frontend/post_request_email', $this->data);
        }
    }
}
