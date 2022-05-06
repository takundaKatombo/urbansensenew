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
class Payments extends API_Controller {

    //put your code here

    function __construct() {
        parent::__construct();
    }

    function checkout_page_details_get($chatroomid = null) {
        //Instead of this function use the newx function v2
        $request = json_decode($this->input->raw_input_stream);
        $user = $this->is_logged_in();
        if (empty($user)) {

            $message = [
                'status' => FALSE,
                'message' => 'You need to be logged in to proceed with the checkout process.',
                'responseCode' => '0'
            ];
            $this->set_response($message, REST_Controller::HTTP_METHOD_NOT_ALLOWED);
        } else {
            $chatroom = ChatRoom::find_by_id($chatroomid);
            if ($chatroom) {

                $response = ResponseForProposal::find_by_id($chatroom->request_id);
                $quote = QuoteRequest::find_by_id($response->quote_request_id);

                $service = get_service($quote->service_id);
                $price = (int) ceil($chatroom->price);
                $service_provider = User::find_by_id($chatroom->professional_id);
                $payment_id = $this->generate_string();
                $booking_id = $this->generate_booking_id();
                $required_time = $quote->avail_time;
                $required_date = date('m/d/Y', strtotime($quote->avail_date));

                $checkout = array(
                    'custom_int1' => $chatroomid,
                    'custom_int2' => 0,
                    'custom_str1' => $quote->location,
                    'custom_str2' => $required_date,
                    'custom_str3' => $required_time,
                    'custom_str4' => $booking_id,
                    'm_payment_id' => $payment_id,
                    'amount' => $price,
                    'item_name' => ucwords($service),
                    'merchant_id' => $this->config->item('merchant_id'),
                    'merchant_key' => $this->config->item('merchant_key'),
                    'passphrase' => $this->config->item('passphrase'),
                    'return_url' => base_url() . 'customer/Payments/m_booking_success?txnid=' . $payment_id . '_' . $price . '_' . $booking_id . '&other_data=' . $chatroomid . '_' . $this->input->get_request_header('API_KEY', TRUE),
                    'cancel_url' => base_url() . 'customer/Payments/m_booking_cancel?txnid=' . $payment_id . '_' . $price . '_' . $booking_id . '&other_data=' . $chatroomid . '_' . $this->input->get_request_header('API_KEY', TRUE),
                    'notify_url' => base_url('customer/Payments/itn'),
                    'name_first' => $user->first_name,
                    'name_last' => $user->last_name,
                    'email_address' => $user->email,
                    'cell_number' => $user->phone,
                    'company_name' => $service_provider->professionals->company_name,
                    'company_image' => @get_default_pro_image($service_provider->id) ? base_url('uploads/image/') . get_default_pro_image($service_provider->id) : base_url('assets/upload.png')
                );

                $this->response([
                    'status' => TRUE,
                    'response' => $checkout,
                    'responseCode' => '1'
                        ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                $this->response([
                    'status' => TRUE,
                    'response' => 'Please provide the correct details in order to proceed.',
                    'responseCode' => '1'
                        ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
        }
    }

    function checkout_page_details_v2_get($chatroomid = null) {
        $request = json_decode($this->input->raw_input_stream);
        $user = $this->is_logged_in();
        if (empty($user)) {

            $message = [
                'status' => FALSE,
                'message' => 'You need to be logged in to proceed with the checkout process.',
                'responseCode' => '0'
            ];
            $this->set_response($message, REST_Controller::HTTP_METHOD_NOT_ALLOWED);
        } else {
            $chatroom = ChatRoom::find_by_id($chatroomid);
            if ($chatroom) {

                $response = ResponseForProposal::find_by_id($chatroom->request_id);
                $quote = QuoteRequest::find_by_id($response->quote_request_id);

                $service = get_service($quote->service_id);
                $price = (int) ($chatroom->price);
                $pgcharges = (int) (3.5 + ((1.7 / 100) * $price));
                $total_charge = $price + $pgcharges;
                $service_provider = User::find_by_id($chatroom->professional_id);
                $payment_id = $this->generate_string();
                $booking_id = $this->generate_booking_id();
                $required_time = $quote->avail_time;
                $required_date = date('m/d/Y', strtotime($quote->avail_date));

                $checkout = array(
                    'custom_int1' => $chatroomid,
                    'custom_int2' => 0,
                    'custom_str1' => $quote->location,
                    'custom_str2' => $required_date,
                    'custom_str3' => $required_time,
                    'custom_str4' => $booking_id,
                    'm_payment_id' => $payment_id,
                    'amount' => $price,
                    'pgcharges' => $pgcharges,
                    'total_charge' => $total_charge,
                    'item_name' => ucwords($service),
                    'merchant_id' => $this->config->item('merchant_id'),
                    'merchant_key' => $this->config->item('merchant_key'),
                    'passphrase' => $this->config->item('passphrase'),
                    'return_url' => base_url() . 'customer/Payments/m_booking_success?txnid=' . $payment_id . '_' . $price . '_' . $booking_id . '&other_data=' . $chatroomid . '_' . $this->input->get_request_header('API_KEY', TRUE),
                    'cancel_url' => base_url() . 'customer/Payments/m_booking_cancel?txnid=' . $payment_id . '_' . $price . '_' . $booking_id . '&other_data=' . $chatroomid . '_' . $this->input->get_request_header('API_KEY', TRUE),
                    'notify_url' => base_url('customer/Payments/itn'),
                    'name_first' => $user->first_name,
                    'name_last' => $user->last_name,
                    'email_address' => $user->email,
                    'cell_number' => $user->phone,
                    'company_name' => $service_provider->professionals->company_name,
                    'company_image' => @get_default_pro_image($service_provider->id) ? base_url('uploads/image/') . get_default_pro_image($service_provider->id) : base_url('assets/upload.png')
                );

                $this->response([
                    'status' => TRUE,
                    'response' => $checkout,
                    'responseCode' => '1'
                        ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                $this->response([
                    'status' => TRUE,
                    'response' => 'Please provide the correct details in order to proceed.',
                    'responseCode' => '1'
                        ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
        }
    }

    public function checkout_for_extra_work_get($chatroomid) {
        $request = json_decode($this->input->raw_input_stream);
        $user = $this->is_logged_in();
        if (empty($user)) {

            $message = [
                'status' => FALSE,
                'message' => 'You need to be logged in to proceed with the checkout process.',
                'responseCode' => '0'
            ];
            $this->set_response($message, REST_Controller::HTTP_METHOD_NOT_ALLOWED);
        } else {


            $chatroom = ChatRoom::find_by_id($chatroomid);
            if ($chatroom) {
                $extra_work = PriceHistory::find(array('select' => 'sum(amount) as total_amount', 'conditions' => array('chatroom_id = ? AND payment_status = ? AND status = 1', $chatroom->id, 'success')));
                $response = ResponseForProposal::find_by_id($chatroom->request_id);
                $quote = QuoteRequest::find_by_id($response->quote_request_id);

                $booking = Booking::find(array('conditions' => array('booked_status= ? AND chatroom_id = ? AND response_for_quote_id = ?', 'success', $chatroom->id, $chatroom->request_id)));

                $service = get_service($quote->service_id);
                $price = (int) ceil($chatroom->price);
                $service_provider = User::find_by_id($chatroom->professional_id);
                $payment_id = $this->generate_string();
                $booking_id = $booking->booking_reference_number;
                $required_time = $quote->avail_time;
                $required_date = date('m/d/Y', strtotime($quote->avail_date));
                $payable_amount = ($chatroom->price - $extra_work->total_amount);
                $pgcharges = (int) (3.5 + ((1.7 / 100) * $payable_amount));
                $total_charge = $payable_amount + $pgcharges;
                
                $checkout = array(
                    'custom_int1' => $chatroomid,
                    'custom_int2' => 0,
                    'custom_str1' => $quote->location,
                    'custom_str2' => $required_date,
                    'custom_str3' => $required_time,
                    'custom_str4' => $booking_id,
                    'm_payment_id' => $payment_id,
                    'amount' => $price,
                    'pgcharges' => $pgcharges,
                    'total_charge' => $total_charge,
                    'extra_amount' => floatval($payable_amount),
                    'item_name' => ucwords($service),
                    'merchant_id' => $this->config->item('merchant_id'),
                    'merchant_key' => $this->config->item('merchant_key'),
                    'passphrase' => $this->config->item('passphrase'),
                    'return_url' => base_url() . 'customer/Payments/m_booking_success?txnid=' . $payment_id . '_' . $payable_amount . '_' . $booking_id . '&other_data=' . $chatroomid . '_' . $this->input->get_request_header('API_KEY', TRUE),
                    'cancel_url' => base_url() . 'customer/Payments/m_booking_cancel?txnid=' . $payment_id . '_' . $payable_amount . '_' . $booking_id . '&other_data=' . $chatroomid . '_' . $this->input->get_request_header('API_KEY', TRUE),
                    'notify_url' => base_url('customer/Payments/itn'),
                    'name_first' => $user->first_name,
                    'name_last' => $user->last_name,
                    'email_address' => $user->email,
                    'cell_number' => $user->phone,
                    'company_name' => $service_provider->professionals->company_name,
                    'company_image' => @get_default_pro_image($service_provider->id) ? base_url('uploads/image/') . get_default_pro_image($service_provider->id) : base_url('assets/upload.png')
                );

                $this->response([
                    'status' => TRUE,
                    'response' => $checkout,
                    'responseCode' => '1'
                        ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                $this->response([
                    'status' => TRUE,
                    'response' => 'Please provide the correct details in order to proceed.',
                    'responseCode' => '1'
                        ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
        }
    }

    function payment_initiated_post() {
        $request = json_decode($this->input->raw_input_stream);
        $user = $this->is_logged_in();
        if (empty($user)) {

            $message = [
                'status' => FALSE,
                'message' => 'You need to be logged in to proceed with the payment process',
                'responseCode' => '0'
            ];
            $this->set_response($message, REST_Controller::HTTP_METHOD_NOT_ALLOWED);
        } else {

            $pfData = $_POST;

            // Create GET string
            $pfParamString = '';
            foreach ($request as $key => $val) {
                if ($val != '' && $key != 'submit' && $key != 'passphrase') {
                    $pfParamString .= $key . '=' . urlencode(stripslashes(trim($val))) . '&';
                }
            }

            // Remove the last '&' from the Parameter string
            $pfParamString = substr($pfParamString, 0, -1);

            // Add the passphrase
            if (@$pfData['passphrase']) {
                $preSigString = $pfParamString . '&passphrase=' . urlencode($pfData['passphrase']);
            } else {
                $preSigString = $pfParamString;
            }

            // Generate signature
            $signature = md5($preSigString);

            $url = "https://www.payfast.co.za/eng/process/?" . $pfParamString;

            $custom_int1 = $request->custom_int1;
            $custom_int2 = $request->custom_int2;
            $custom_str1 = $request->custom_str1;
            $custom_str2 = $request->custom_str2;
            $custom_str3 = $request->custom_str3;
            $custom_str4 = $request->custom_str4;
            $m_payment_id = $request->m_payment_id;
            $email_address = $request->email_address;
            $amount = (int) ceil($request->amount);
            $item_name = $request->item_name;
            $name_first = $request->name_first;
            $name_last = $request->name_last;
            $cell_number = $request->cell_number;


            if (!$custom_int1 || $custom_int2 || $custom_str1 || $custom_str2 || $custom_str3 || $custom_str4 || $m_payment_id || $amount || $item_name || $name_first || $name_last || $cell_number) {
                $chatroom = ChatRoom::find_by_id($custom_int1);

                if (!$chatroom) {
                    $this->response([
                        'status' => TRUE,
                        'response' => 'Please provide the correct details in order to proceed',
                        'responseCode' => '1'
                            ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                } else {
                    $res_for_pro = ResponseForProposal::find_by_id($chatroom->request_id);
                    $quote = QuoteRequest::find_by_id($res_for_pro->quote_request_id);

                    $payment_data = array(
                        'professional_id' => $chatroom->professional_id,
                        'customer_id' => $chatroom->customer_id,
                        'amount' => $amount,
                        'service_id' => $quote->service_id,
                        'chatroom_id' => $custom_int1,
                        'payment_key' => $m_payment_id,
                        'signature' => $signature,
                        'customer_address' => $custom_str1,
                        'customer_phone' => $cell_number,
                        'customer_email' => $email_address,
                        'customer_name' => $name_first . ' ' . $name_last,
                        'txndatetime' => date('Y-m-d h:i:s'),
                        'payment_status' => 'initiated',
                        'currency_type' => 'ZAR',
                        'terms_and_conditions' => $custom_int2
                    );

                    Payment::create($payment_data);

                    $booking_data = array(
                        'professional_id' => $chatroom->professional_id,
                        'customer_id' => $chatroom->customer_id,
                        'amount_paid' => $amount,
                        'service_id' => $quote->service_id,
                        'chatroom_id' => $custom_int1,
                        'payment_key' => $m_payment_id,
                        "booking_reference_number" => $custom_str4,
                        'customer_address' => $custom_str1,
                        'customer_phone' => $cell_number,
                        'customer_email' => $email_address,
                        'customer_name' => $name_first . ' ' . $name_last,
                        'booking_time' => date('Y-m-d h:i:s'),
                        'required_time' => $custom_str3,
                        'required_date' => $custom_str2,
                        'booked_status' => 'initiated',
                        'currency' => 'ZAR',
                        'response_for_quote_id' => $chatroom->request_id,
                        'terms_acceptence' => $custom_int2
                    );

                    Booking::create($booking_data);
                    $this->response([
                        'status' => TRUE,
                        'message' => 'Payment process has been initiated successfully',
                        'response' => $url,
                        'responseCode' => '1'
                            ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                }
            } else {
                $message = [
                    'status' => FALSE,
                    'message' => 'Please provide all the mandatory parameters',
                    'responseCode' => '0'
                ];
                $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    public function payment_success_details_get($txnid) {
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
            $txnid = $txnid;
            $txn = explode("_", $txnid);

            $payment_key = $txn[0];
            $amount = $txn[1];
            $booking_reference_number = $txn[2];

            $booking = Booking::find(array('conditions' => array('booking_reference_number = ? AND payment_key = ? AND amount_paid = ?', $booking_reference_number, $payment_key, $amount)));

            if ($booking) {
                $professional = User::find_by_id($booking->professional_id);

                $data = array(
                    "payment_key" => $booking->payment_key,
                    "booking_reference_number" => $booking->booking_reference_number,
                    "customer_name" => $booking->customer_name,
                    "customer_phone" => $booking->customer_phone,
                    "customer_email" => $booking->customer_email,
                    "customer_address" => $booking->customer_address,
                    "required_date" => date('d M Y', strtotime($booking->required_date)) . " | " . $booking->required_time,
                    "booking_time" => date('d M Y h:i A', strtotime($booking->booking_time)),
                    "service" => ucwords(get_service($booking->service_id)),
                    "company_name" => $professional->professionals->company_name,
                    "amount" => $booking->currency . ' ' . $booking->amount_paid,
                    "payment_status" => $booking->booked_status,
                    "chatroom_id" => $booking->chatroom_id
                );

                $this->response([
                    'status' => TRUE,
                    'response' => $data,
                    'responseCode' => '1'
                        ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {

                $this->response([
                    'status' => TRUE,
                    'message' => 'Please provide the correct transaction ID to see the details',
                    'responseCode' => '1'
                        ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
        }
    }

}
