<?php

defined('BASEPATH') or exit('No direct script access allowed');

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
class Quote extends API_Controller
{

    //put your code here

    function __construct()
    {
        parent::__construct();
    }

    function request_quote_post()
    {
        $request = json_decode($this->input->raw_input_stream);
        $user = $this->is_logged_in();
        if (empty($user)) {
            $message = [
                'status' => FALSE,
                'message' => 'You need to be logged in to perform this action.',
                'responseCode' => '0'
            ];
            $this->set_response($message, REST_Controller::HTTP_METHOD_NOT_ALLOWED);
        } else {

            $request = json_decode($this->input->raw_input_stream);
            $user_id = $user->id;
            $service_id = $request->service_id;
            $avail_date = $request->avail_date;
            $location = $request->location;
            $latitude = $request->latitude;
            $longitude = $request->longitude;
            $avail_time = $request->avail_time;
            $request_details = $request->request_details;

            if ($service_id != null or $latitude != null or $longitude != null or $avail_time != null or $avail_date != null or $request_details != null or $location != null) {
                $query = $this->get_distance($service_id, $latitude, $longitude);
                if (!empty($query)) {
                    $data = array(
                        'user_id' => $user_id,
                        'service_id' => $service_id,
                        'avail_date' => date('Y-m-d', strtotime($avail_date)),
                        'location' => $location,
                        'latitude' => $latitude,
                        'longitude' => $longitude,
                        'avail_time' => $avail_time,
                        'request_details' => $request_details
                    );
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
                                $this->send_notification($device_id, 'You have received a request to submit a proposal for ' . get_service($service_id), 'New Lead', $user->first_name, 'lead');
                            }
                        }
                        // Send OTP to the user's phone and email
                        if ($recipient) {
                            send_otp_on_mobile($recipient->phone, "You've received a new service request. Please log in to check the details");
                            $mail_data = array(
                                'name' => $recipient->first_name . ' ' . $recipient->last_name,
                                'request' => $request
                            );
                            $message = $this->load->view('emails/new_service_request', $mail_data, TRUE);
                            $this->custom_email->send($recipient->email, $recipient->first_name . ' ' . $recipient->last_name, "UrbanSense New Service Request", $message);
                        }
                    }

                    $this->response([
                        'status' => TRUE,
                        'response' => 'Your request for quotes has been sent successfully to the providers. You will be notified when they accept the request.',
                        'responseCode' => '1'
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                } else {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'We are sorry, there are no service providers in your area, we are working on getting more. Please try again later.',
                        'responseCode' => '0'
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                }
            } else {
                $message = [
                    'status' => FALSE,
                    'message' => 'Please provide all the mandatory parameters.',
                    'responseCode' => '0'
                ];
                $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    function request_individual_quote_post()
    {
        $request = json_decode($this->input->raw_input_stream);
        $user = $this->is_logged_in();
        if (empty($user)) {

            $message = [
                'status' => FALSE,
                'message' => 'You need to be logged in to perform this action.',
                'responseCode' => '0'
            ];
            $this->set_response($message, REST_Controller::HTTP_METHOD_NOT_ALLOWED);
        } else {

            $request = json_decode($this->input->raw_input_stream);
            $user_id = $user->id;
            $service_id = $request->service_id;
            $avail_date = $request->avail_date;
            $location = $request->location;
            $latitude = $request->latitude;
            $longitude = $request->longitude;
            $avail_time = $request->avail_time;
            $request_details = $request->request_details;
            $service_provider_id = $request->service_provider_id;

            if ($service_id != null and $latitude != null and $longitude != null and $avail_time != null and $avail_date != NULL and $request_details != NULL and $location != null and $service_provider_id != null) {

                $data = array(
                    'user_id' => $user_id,
                    'service_id' => $service_id,
                    'avail_date' => date('Y-m-d', strtotime($avail_date)),
                    'location' => $location,
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'avail_time' => $avail_time,
                    'request_details' => $request_details
                );
                $request = QuoteRequest::create($data);

                $quote_data = array(
                    'quote_request_id' => $request->id,
                    'professional_id' => $service_provider_id,
                    'status' => 1
                );

                $is_send = ResponseForProposal::create($quote_data);

                $recipient = User::find_by_id($service_provider_id);


                if ($is_send) {
                    foreach ($recipient->user_authentications as $row) {
                        $device_id = array($row->device_id);
                        if (!empty($device_id)) {
                            $this->send_notification($device_id, 'You have received a request to submit a proposal for ' . get_service($service_id), 'New Lead', $user->first_name, 'lead');
                        }
                    }

                    // Send OTP to the user's phone and email
                    if ($recipient) {
                        send_otp_on_mobile($recipient->phone, "You've received a new service request. Please log in to check the details");
                        $mail_data = array(
                            'name' => $recipient->first_name . ' ' . $recipient->last_name,
                            'request' => $request
                        );
                        $message = $this->load->view('emails/new_service_request', $mail_data, TRUE);
                        $this->custom_email->send($recipient->email, $recipient->first_name . ' ' . $recipient->last_name, "UrbanSense New Service Request", $message);
                    }

                    $this->response([
                        'status' => TRUE,
                        'response' => 'Your request for quote has been sent successfully to the provider. You will be notified when they accept your request.',
                        'responseCode' => '1'
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                }
            } else {
                $message = [
                    'status' => FALSE,
                    'message' => 'Please provide all the mandatory parameters.',
                    'responseCode' => '0'
                ];
                $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    function nosp_email_post()
    {
        $request = json_decode($this->input->raw_input_stream);
        $user = $this->is_logged_in();
        if (empty($user)) {

            $message = [
                'status' => FALSE,
                'message' => 'You need to be logged in to perform this action.',
                'responseCode' => '0'
            ];
            $this->set_response($message, REST_Controller::HTTP_METHOD_NOT_ALLOWED);
        } else {

            $request = json_decode($this->input->raw_input_stream);
            $user_id = $user->id;
            $service_id = $request->service_id;
            $avail_date = $request->avail_date;
            $location = $request->location;
            $avail_time = $request->avail_time;
            $request_details = $request->request_details;

            if ($service_id and $avail_time != null and $avail_date != NULL and $request_details != NULL and $location != null) {

                $data = array(
                    'customeremail' => $user->email,
                    'customerphone' => $user->phone,
                    'name' => $user->first_name . ' ' . $user->last_name,
                    'service' => get_service($service_id),
                    'location' => $location,
                    'avail_date' => $avail_date,
                    'avail_time' => $avail_time,
                    'request_details' => $request_details
                );

                $subject1 = "Your request to avail the service provider has been received";
                $subject2 = "A new request to provide the service provider has been received";
                $message1 = $this->load->view('emails/no_serviceprovider_found', $data, TRUE);
                $message2 = $this->load->view('emails/no_serviceprovider_admin', $data, TRUE);
                $email = Setting::find(array('conditions' => array('id = 1'), 'limit' => 1))->email;
                $is_send1 = $this->custom_email->send($user->email, "UrbanSense ", $subject1, $message1);
                $is_send = $this->custom_email->send($email, "UrbanSense", $subject2, $message2);

                if ($is_send and $is_send1) {
                    $this->response([
                        'status' => TRUE,
                        'response' => 'Your request for quotes has been sent successfully to the providers. You will be notified when they accept the request.',
                        'responseCode' => '1'
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                } else {
                    $this->response([
                        'status' => TRUE,
                        'response' => 'We are sorry, there are no service providers in your area, we are working on getting more. Please try again later.',
                        'responseCode' => '1'
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                }
            } else {
                $message = [
                    'status' => FALSE,
                    'message' => 'Please provide all the mandatory parameters.',
                    'responseCode' => '0'
                ];
                $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    function pending_review_get()
    {
        $request = json_decode($this->input->raw_input_stream);
        $user = $this->is_logged_in();
        if (empty($user)) {

            $message = [
                'status' => FALSE,
                'message' => 'You need to be logged in to perform this action.',
                'responseCode' => '0'
            ];
            $this->set_response($message, REST_Controller::HTTP_METHOD_NOT_ALLOWED);
        } else {

            $request = json_decode($this->input->raw_input_stream);
            $booking = Booking::last(array('conditions' => array('customer_id =?', $user->id)));
            if ($booking) {
                $review_status = ResponseForProposal::find_by_id($booking->response_for_quote_id)->quote_request->status;
                if ($review_status == 3) {
                    $this->response([
                        'status' => TRUE,
                        'response' => 'Your previous service is completed. Please rate previous service',
                        'chatroom_id' => $booking->chatroom_id,
                        'responseCode' => '1'
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                } else {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'There are no previous review is pending.',
                        'chatroom_id' => $booking->chatroom_id,
                        'responseCode' => '0'
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                }
            } else {

                $message = [
                    'status' => FALSE,
                    'message' => 'There are no previous review is pending.',
                    'responseCode' => '0'
                ];
                $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
}