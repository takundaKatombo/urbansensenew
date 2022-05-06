<?php

defined('BASEPATH') or exit('No direct script access allowed');
require_once FCPATH . 'dompdf/autoload.inc.php';

// reference the Dompdf namespace
use Dompdf\Dompdf;

class Payments extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function signatures()
    {

        $chatroom = ChatRoom::find_by_id($this->input->post('custom_int1'));
        $res_for_pro = ResponseForProposal::find_by_id($chatroom->request_id);
        $quote = QuoteRequest::find_by_id($res_for_pro->quote_request_id);


        $this->form_validation->set_rules('name_first', 'First Name', 'required|max_length[100]');
        $this->form_validation->set_rules('name_last', 'Last Name', 'required|max_length[100]');
        $this->form_validation->set_rules('cell_number', 'phone', 'required|numeric|min_length[10]|max_length[15]|regex_match[/^[0-9]{10}$/]');
        $this->form_validation->set_rules('email_address', 'Email', 'required|max_length[50]|valid_email');
        $this->form_validation->set_rules('custom_str1', 'Address', 'required|max_length[200]');
        $this->form_validation->set_rules('custom_int2', 'Terms and conditions', 'required');

        if ($this->form_validation->run() == FALSE) {

            $this->session->set_flashdata("warning", 'Please enter valid data');
            redirect(base_url('checkout/') . $this->input->post('custom_int1'));
        } else {

            $extra_amount = PriceHistory::find(array('select' => 'sum(amount) as total_amount', 'conditions' => array('chatroom_id = ? AND payment_status = ? AND status = 1', $chatroom->id, 'success')));


            $_POST['merchant_id'] = $this->config->item('merchant_id');
            $_POST['merchant_key'] = $this->config->item('merchant_key');
            $_POST['passphrase'] = $this->config->item('passphrase');
            $base_amount = $chatroom->price - $extra_amount->total_amount;
            $pgcharges = (int) (3.5 + ((1.7 / 100) * $base_amount));
            $total_charge = $base_amount + $pgcharges;

            $_POST['amount'] = $total_charge;
            //print_r($chatroom->price - $extra_amount->total_amount); die;

            $pfData = $_POST;
            // Create GET string
            $pfParamString = '';
            foreach ($pfData as $key => $val) {
                if ($val != '' && $key != 'submit' && $key != 'passphrase') {
                    $pfParamString .= $key . '=' . urlencode(stripslashes(trim($val))) . '&';
                }
            }

            // Remove the last '&' from the Parameter string
            $pfParamString = substr($pfParamString, 0, -1);

            // Add the passphrase
            if ($pfData['passphrase']) {
                $preSigString = $pfParamString . '&passphrase=' . urlencode($pfData['passphrase']);
            } else {
                $preSigString = $pfParamString;
            }

            // Generate signature

            $signature = md5($preSigString);




            //save payments details in database
            $data = array(
                'professional_id' => $chatroom->professional_id,
                'customer_id' => $chatroom->customer_id,
                'amount' => $this->input->post('amount'),
                'service_id' => $quote->service_id,
                'payment_key' => $this->input->post('m_payment_id'),
                'signature' => $signature,
                'customer_address' => $this->input->post('custom_str1'),
                'customer_phone' => $this->input->post('cell_number'),
                'customer_email' => $this->input->post('email_address'),
                'customer_name' => $this->input->post('name_first') . ' ' . $this->input->post('name_last'),
                'chatroom_id' => $this->input->post('custom_int1'),
                'txndatetime' => date('Y-m-d h:i:s'),
                'payment_status' => 'initiated',
                'currency_type' => 'ZAR',
                'terms_and_conditions' => $this->input->post('custom_int2')
            );

            Payment::create($data);

            $booking_data = array(
                'professional_id' => $chatroom->professional_id,
                'customer_id' => $chatroom->customer_id,
                'amount_paid' => $this->input->post('amount'),
                'service_id' => $quote->service_id,
                'payment_key' => $this->input->post('m_payment_id'),
                "booking_reference_number" => $this->input->post('custom_str4'),
                'customer_address' => $this->input->post('custom_str1'),
                'customer_phone' => $this->input->post('cell_number'),
                'customer_email' => $this->input->post('email_address'),
                'customer_name' => $this->input->post('name_first') . ' ' . $this->input->post('name_last'),
                'chatroom_id' => $this->input->post('custom_int1'),
                'booking_time' => date('Y-m-d h:i:s'),
                'required_time' => $this->input->post('custom_str3'),
                'required_date' => $this->input->post('custom_str2'),
                'booked_status' => 'initiated',
                'currency' => 'ZAR',
                'response_for_quote_id' => $chatroom->request_id,
                'terms_acceptence' => $this->input->post('custom_int2')
            );

            Booking::create($booking_data);
            // Display signature
            $this->data['service_id'] = get_service($quote->service_id);
            $this->data['professional'] = User::find_by_id($chatroom->professional_id);
            $this->data['form_data'] = $pfData;
            $this->data['signature'] = $signature;
            $url = "https://www.payfast.co.za/eng/process/?" . $pfParamString;
            redirect($url);
            //$this->template->load('frontend/front_base','customer/payment_details',$this->data);
        }
    }

    function itn()
    {

        log_message('info', "submitted data" . json_encode($_POST));

        define('PAYFAST_SERVER', 'TEST');
        define('USER_AGENT', 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        define('PF_ERR_AMOUNT_MISMATCH', 'Amount mismatch');
        define('PF_ERR_BAD_SOURCE_IP', 'Bad source IP address');
        define('PF_ERR_CONNECT_FAILED', 'Failed to connect to PayFast');
        define('PF_ERR_BAD_ACCESS', 'Bad access of page');
        define('PF_ERR_INVALID_SIGNATURE', 'Security signature mismatch');
        define('PF_ERR_CURL_ERROR', 'An error occurred executing cURL');
        define('PF_ERR_INVALID_DATA', 'The data received is invalid');
        define('PF_ERR_UKNOWN', 'Unkown error occurred');
        define('PF_MSG_OK', 'Payment was successful');
        define('PF_MSG_FAILED', 'Payment has failed');
        header('HTTP/1.0 200 OK');
        flush();
        $pfError = false;
        $pfErrMsg = '';
        $filename = 'notify.txt';
        $output = '';
        $pfParamString = '';
        $pfHost = (PAYFAST_SERVER == 'LIVE') ?
            'www.payfast.co.za' : 'sandbox.payfast.co.za';
        $pfData = [];

        if (!$pfError) {

            foreach ($_POST as $key => $val)
                $pfData[$key] = stripslashes($val);
            foreach ($pfData as $key => $val) {
                if ($key != 'signature')
                    $pfParamString .= $key . '=' . urlencode($val) . '&';
            }

            $pfParamString = substr($pfParamString, 0, -1);
            $pfTempParamString = $pfParamString;
            $signature = md5($pfTempParamString);
            if ($_POST['signature'] == $signature) {
                $result = true;
            } else {
                $result = false;
            }
            $output .= "Security Signature:";
            $output .= "- posted     = " . $_POST['signature'] . "\n";
            $output .= "- calculated = " . $signature . "\n";
            $output .= "- result     = " . ($result ? 'SUCCESS' : 'FAILURE') . "\n";
            log_message('info', "submitted data " . $output);
            // die();
        }

        if (!$pfError) {
            $validHosts = array(
                'www.payfast.co.za',
                'sandbox.payfast.co.za',
                'w1w.payfast.co.za',
                'w2w.payfast.co.za',
            );

            $validIps = array();

            foreach ($validHosts as $pfHostname) {
                $ips = gethostbynamel($pfHostname);

                if ($ips !== false)
                    $validIps = array_merge($validIps, $ips);
            }
            $validIps = array_unique($validIps);

            if (!in_array($_SERVER['REMOTE_ADDR'], $validIps)) {
                $pfError = true;
                $pfErrMsg = PF_ERR_BAD_SOURCE_IP;
            }
        }

        if (!$pfError) {
            if (function_exists('curl_init')) {
                $output .= "\n\nUsing cURL\n\n";
                $ch = curl_init();
                $curlOpts = array(
                    CURLOPT_USERAGENT => USER_AGENT,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HEADER => false,
                    CURLOPT_SSL_VERIFYHOST => 2,
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_URL => 'https://' . $pfHost . '/eng/query/validate',
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => $pfParamString,
                );
                curl_setopt_array($ch, $curlOpts);
                $res = curl_exec($ch);
                curl_close($ch);

                if ($res === false) {
                    $pfError = true;
                    $pfErrMsg = PF_ERR_CURL_ERROR;
                }
            } else {
                $output .= "\n\nUsing fsockopen\n\n";
                $header = "POST /eng/query/validate HTTP/1.0\r\n";
                $header .= "Host: " . $pfHost . "\r\n";
                $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
                $header .= "Content-Length: " . strlen($pfParamString) . "\r\n\r\n";
                $socket = fsockopen('ssl://' . $pfHost, 443, $errno, $errstr, 10);
                fputs($socket, $header . $pfParamString);
                $res = '';
                $headerDone = false;

                while (!feof($socket)) {
                    $line = fgets($socket, 1024);
                    if (strcmp($line, "\r\n") == 0) {
                        $headerDone = true;
                    } else if ($headerDone) {
                        $res .= $line;
                    }
                }
            }
        }

        if (!$pfError) {
            $lines = explode("\n", $res);
            $output .= "\n\nValidate response from server:\n\n";
            foreach ($lines as $line)
                $output .= $line . "\n";
        }

        if (!$pfError) {
            $result = trim($lines[0]);
            $output .= "\nResult = " . $result;

            if (strcmp($result, 'VALID') == 0) {
            } else {
                $pfError = true;
                $pfErrMsg = PF_ERR_INVALID_DATA;
            }
        }

        if ($pfError) {
            $output .= "\n\nAn error occurred!";
            $output .= "\nError = " . $pfErrMsg;
        }

        log_message('info', "submitted data " . $output);
        // file_put_contents( $filename, $output );
    }

    function booking_success()
    {
        $txnid = $this->input->get('txnid');
        $txn = explode("_", $txnid);

        $payment_key = $txn[0];
        $amount = $txn[1];
        $booking_reference_number = $txn[2];

        $booking = Booking::find(array('conditions' => array('booking_reference_number = ? AND payment_key = ? AND amount_paid = ?', $booking_reference_number, $payment_key, $amount)));
        if ($booking->booked_status == 'initiated') {
            $booking->update_attributes(array('booked_status' => 'Success'));

            $response = ResponseForProposal::find_by_id($booking->response_for_quote_id);
            //$response->update_attributes(array()); 
            //print_r($booking); die;
            $request = QuoteRequest::find_by_id($response->quote_request_id);
            $request->update_attributes(array('status' => 2));

            $payment = Payment::find_by_payment_key_and_amount($payment_key, $amount);
            $payment->update_attributes(array('payment_status' => 'Success'));

            //disable other service provider request
            $ResponseForProposal = ResponseForProposal::find('all', array('conditions' => array('quote_request_id = ?', $response->quote_request_id)));
            foreach ($ResponseForProposal as $row) {
                $row->update_attributes(array('status' => 0, 'request_accept' => 2));
            }

            $response->update_attributes(array('status' => 1, 'request_accept' => 2));

            $data3 = array(
                'chatroom_id' => $booking->chatroom_id,
                'amount' => $booking->amount_paid,
                'currency' => 'ZAR',
                'payment_status' => 'success',
                'status' => 1,
            );

            PriceHistory::create($data3);

            $bookings = Booking::all(array('conditions' => array('booking_reference_number = ? AND booked_status = ? ', $booking_reference_number, 'success')));

            $this->data['bookings'] = $bookings;
            $this->data['booking'] = $booking;
            $this->data['professional'] = User::find_by_id($booking->professional_id);
            $this->data['payment'] = $payment;

            $html = $this->load->view('emails/invoice', $this->data, true);
            $dompdf = new Dompdf();
            $dompdf->loadHtml(utf8_encode($html));
            // (Optional) Setup the paper size and orientation
            $dompdf->setPaper('A4', 'portrait');
            // Render the HTML as PDF
            $dompdf->render();
            $output = $dompdf->output();
            $this->load->library('Custom_email');

            $subject = "Your booking confirmation receipt #" . $booking->booking_reference_number;
            //$message = "Dear ".$booking->customer_name."<br>  You booked  ".$this->data['professional']->professionals->company_name."  for ".get_service($booking->service_id).' successfully';
            $message = $this->load->view('emails/booking_customer', $this->data, true);
            $date_time = $this->getTime($booking->required_time);

            $time = date('Y-m-d', strtotime($booking->required_date)) . ' ' . $date_time;
            $push_message = 'You have scheduled appointment at ' . $booking->required_date . ' with ' . get_user($request->user_id)->first_name . ' for service (' . get_service($request->service_id) . ')';
            //print_r($time); die;

            if ($message) {
                $recipient = User::find_by_id($booking->professional_id);
                foreach ($recipient->user_authentications as $row) {
                    $device_id = array($row->device_id);
                    if (!empty($device_id)) {
                        $this->send_notification($device_id, 'You have received a payment of ' . $booking->currency . ' ' . $booking->amount_paid . ' from ' . get_user($request->user_id)->first_name . ' successfully', 'Payment Received', get_user($request->user_id)->first_name, 'payment_received', $time, $push_message);
                    }
                }


                $user = User::find_by_id($this->ion_auth->user()->row()->id);

                foreach ($user->user_authentications as $row) {
                    $device_id1 = array($row->device_id);
                    if (!empty($device_id1)) {
                        $this->send_notification($device_id1, 'You have successfully paid ' . $booking->currency . ' ' . $booking->amount_paid . ' to ' . $recipient->professionals->company_name . ' successfully', 'Payment Sent', get_user($request->user_id)->first_name, 'payment_sent', $txnid);
                        $this->send_notification($device_id1, 'Your service has been scheduled and the selected provider will reach to your location on scheduled date & time.', 'Service Scheduled', get_user($request->user_id)->first_name, 'service_scheduled', '', $booking->chatroom_id);
                    }
                }
            }

            $this->custom_email->send($booking->customer_email, "UrbanSense User", $subject, $message, $output);


            $subject1 = "Your booking has been confirmed #" . $booking->booking_reference_number;

            //$message1 = "Hello ".$this->data['professional']->professionals->company_name."<br>  You has been booked  by".$booking->customer_name."  for ".get_service($booking->service_id).' successfully';
            //booking_professional
            $message1 = $this->load->view('emails/booking_professional', $this->data, true);

            $this->custom_email->send($this->data['professional']->email, "UrbanSense", $subject1, $message1, $output);

            $this->template->load('frontend/front_base', 'customer/payment_success_page', $this->data);
        } else {
            $this->data['message'] = 'We are sorry, This link is expired.';
            $this->template->load('frontend/front_base', 'common/failure', $this->data);
        }
    }

    function booking_cancel()
    {
        $txnid = $this->input->get('txnid');
        $txn = explode("_", $txnid);

        $payment_key = $txn[0];
        $amount = $txn[1];
        $booking_reference_number = $txn[2];

        $booking = Booking::find(array('conditions' => array('booking_reference_number = ? AND payment_key = ? AND amount_paid = ?', $booking_reference_number, $payment_key, $amount)));
        //print_r($booking);

        $data3 = array(
            'chatroom_id' => $booking->chatroom_id,
            'amount' => $booking->amount_paid,
            'currency' => 'ZAR',
            'payment_status' => 'failed',
            'status' => 1,
        );

        PriceHistory::create($data3);


        $this->data['professional'] = User::find_by_id($booking->professional_id);

        $booking->update_attributes(array('booked_status' => 'Failed'));

        $payment = Payment::find_by_payment_key_and_amount($payment_key, $amount);
        //print_r($payment);
        $payment->update_attributes(array('payment_status' => 'Failed'));

        $data3 = array(
            'chatroom_id' => $booking->chatroom_id,
            'amount' => $booking->amount_paid,
            'currency' => 'ZAR',
            'payment_status' => 'failed',
            'status' => 1,
        );

        PriceHistory::create($data3);

        $subject = "Booking " . $this->data['professional']->professionals->company_name . "  for " . get_service($booking->service_id) . ' failed ';
        $message = "Hello " . $booking->customer_name . "<br>  You booked  " . $this->data['professional']->professionals->company_name . "  for " . get_service($booking->service_id) . ' are failed. Please try again';

        if ($message) {

            foreach ($this->data['professional']->user_authentications as $row) {
                $device_id = array($row->device_id);
                if (!empty($device_id)) {
                    $this->send_notification($device_id1, 'The payment of ' . $booking->currency . ' ' . $booking->amount_paid . ' has failed for some reason. Please try again', 'Payment Failed', get_user($request->user_id)->first_name, 'payment_failed');
                }
            }
        }

        $send = $this->custom_email->send($this->data['professional']->email, "UrbanSense User", $subject, $message);

        $this->template->load('frontend/front_base', 'customer/payment_cancel_page', $this->data);
    }

    function booking_complete($id = NULL)
    {
        $chatroom = ChatRoom::find_by_id($id);
        $response = ResponseForProposal::find_by_id($chatroom->request_id);
        $quote = QuoteRequest::find_by_id($response->quote_request_id);
        $quote->update_attributes(array('status' => 2));
        //disable other service provider request
        $ResponseForProposal = ResponseForProposal::find('all', array('conditions' => array('quote_request_id = ?', $response->quote_request_id)));
        foreach ($ResponseForProposal as $row) {
            $row->update_attributes(array('status' => 0, 'request_accept' => 2));
        }
        $response->update_attributes(array('status' => 1, 'request_accept' => 2));

        $this->session->set_flashdata('success', 'This service provider has been booked successfully.');
        redirect(base_url('customer-chat/' . $id));
    }

    function m_booking_success()
    {
        $txnid = $this->input->get('txnid');
        $txn = explode("_", $txnid);

        $payment_key = $txn[0];
        $amount = $txn[1];
        $booking_reference_number = $txn[2];

        $booking = Booking::find(array('conditions' => array('booking_reference_number = ? AND payment_key = ? AND amount_paid = ?', $booking_reference_number, $payment_key, $amount)));
        if ($booking->booked_status == 'initiated') {
            $booking->update_attributes(array('booked_status' => 'Success'));

            $response = ResponseForProposal::find_by_id($booking->response_for_quote_id);
            //$response->update_attributes(array()); 
            //print_r($booking); die;
            $request = QuoteRequest::find_by_id($response->quote_request_id);
            $request->update_attributes(array('status' => 2));

            $payment = Payment::find_by_payment_key_and_amount($payment_key, $amount);
            $payment->update_attributes(array('payment_status' => 'Success'));

            //disable other service provider request
            $ResponseForProposal = ResponseForProposal::find('all', array('conditions' => array('quote_request_id = ?', $response->quote_request_id)));
            foreach ($ResponseForProposal as $row) {
                $row->update_attributes(array('status' => 0, 'request_accept' => 2));
            }

            $response->update_attributes(array('status' => 1, 'request_accept' => 2));

            $data3 = array(
                'chatroom_id' => $booking->chatroom_id,
                'amount' => $booking->amount_paid,
                'currency' => 'ZAR',
                'payment_status' => 'success',
                'status' => 1,
            );

            PriceHistory::create($data3);

            $bookings = Booking::all(array('conditions' => array('booking_reference_number = ? AND booked_status = ? ', $booking_reference_number, 'success')));

            $this->data['bookings'] = $bookings;

            $this->data['booking'] = $booking;
            $this->data['professional'] = User::find_by_id($booking->professional_id);
            $this->data['payment'] = $payment;

            $html = $this->load->view('emails/invoice', $this->data, true);
            $dompdf = new Dompdf();
            $dompdf->loadHtml(utf8_encode($html));
            // (Optional) Setup the paper size and orientation
            $dompdf->setPaper('A4', 'portrait');
            // Render the HTML as PDF
            $dompdf->render();
            $output = $dompdf->output();
            $this->load->library('Custom_email');

            $subject = "Your booking confirmation receipt #" . $booking->booking_reference_number;
            //$message = "Dear ".$booking->customer_name."<br>  You booked  ".$this->data['professional']->professionals->company_name."  for ".get_service($booking->service_id).' successfully';
            $message = $this->load->view('emails/booking_customer', $this->data, true);
            $date_time = $this->getTime($booking->required_time);

            $time = date('Y-m-d', strtotime($booking->required_date)) . ' ' . $date_time;

            $push_message = 'You have scheduled appointment at ' . $booking->required_date . ' with ' . get_user($request->user_id)->first_name . ' for service (' . get_service($request->service_id) . ')';
            if ($message) {
                $recipient = User::find_by_id($booking->professional_id);
                foreach ($recipient->user_authentications as $row) {
                    $device_id = array($row->device_id);
                    if (!empty($device_id)) {
                        //   $this->send_notification($device_id, 'You have received a payment of '. $booking->currency.' '.$booking->amount_paid.  ' from '. get_user($request->user_id)->first_name.' successfully', 'Payment Received', $time ,'payment_received');

                        $this->send_notification($device_id, 'You have received a payment of ' . $booking->currency . ' ' . $booking->amount_paid . ' from ' . get_user($request->user_id)->first_name . ' successfully', 'Payment Received', get_user($request->user_id)->first_name, 'payment_received', $time, $push_message);
                    }
                }


                $user = User::find_by_id($booking->customer_id);
                foreach ($user->user_authentications as $row) {
                    $device_id1 = array($row->device_id);
                    if (!empty($device_id1)) {
                        $this->send_notification($device_id1, 'You have successfully paid ' . $booking->currency . ' ' . $booking->amount_paid . ' to ' . $recipient->professionals->company_name . ' successfully', 'Payment Sent', get_user($request->user_id)->first_name, 'payment_sent', $txnid);
                        $this->send_notification($device_id1, 'Your service has been scheduled and the selected provider will reach to your location on scheduled date & time.', 'Service Scheduled', get_user($request->user_id)->first_name, 'service_scheduled', '', $booking->chatroom_id);
                    }
                }
            }

            $this->custom_email->send($booking->customer_email, "UrbanSense User", $subject, $message, $output);


            $subject1 = "Your booking has been confirmed #" . $booking->booking_reference_number;

            //$message1 = "Hello ".$this->data['professional']->professionals->company_name."<br>  You has been booked  by".$booking->customer_name."  for ".get_service($booking->service_id).' successfully';
            //booking_professional
            $message1 = $this->load->view('emails/booking_professional', $this->data, true);

            $this->custom_email->send($this->data['professional']->email, "UrbanSense", $subject1, $message1, $output);

            $this->load->view('customer/m_payment_success', $this->data);
        } else {
            $this->data['message'] = 'We are sorry, This link is expired.';
            $this->template->load('frontend/front_base', 'common/failure', $this->data);
        }
    }

    function m_booking_cancel()
    {
        $txnid = $this->input->get('txnid');
        $txn = explode("_", $txnid);

        $payment_key = $txn[0];
        $amount = $txn[1];
        $booking_reference_number = $txn[2];

        $booking = Booking::find(array('conditions' => array('booking_reference_number = ? AND payment_key = ? AND amount_paid = ?', $booking_reference_number, $payment_key, $amount)));
        //print_r($booking);
        $this->data['professional'] = User::find_by_id($booking->professional_id);
        $booking->update_attributes(array('booked_status' => 'Failed'));

        $payment = Payment::find_by_payment_key_and_amount($payment_key, $amount);
        //print_r($payment);
        $payment->update_attributes(array('payment_status' => 'Failed'));

        $data3 = array(
            'chatroom_id' => $booking->chatroom_id,
            'amount' => $booking->amount_paid,
            'currency' => 'ZAR',
            'payment_status' => 'failed',
            'status' => 1,
        );

        PriceHistory::create($data3);

        $subject = "Booking " . $this->data['professional']->professionals->company_name . "  for " . get_service($booking->service_id) . ' failed ';
        $message = "Hello " . $booking->customer_name . "<br>  You booked  " . $this->data['professional']->professionals->company_name . "  for " . get_service($booking->service_id) . ' are failed. Please try again';

        if ($message) {
            $recipient = User::find_by_id($booking->professional_id);
            foreach ($recipient->user_authentications as $row) {
                $device_id = array($row->device_id);
                if (!empty($device_id)) {
                    $this->send_notification($device_id, 'The payment of ' . $booking->currency . ' ' . $booking->amount_paid . ' has failed for some reason. Please try again', 'Payment Failed', get_user($booking->customer_id)->first_name, 'payment_failed');
                }
            }
        }

        $send = $this->custom_email->send($this->data['professional']->email, "UrbanSense User", $subject, $message);

        $this->load->view('customer/m_payment_cancel', $this->data);
    }

    private function getTime($time)
    {
        $exeed_time = '';
        if ($time == '9 am to 12 pm') {
            $exeed_time = '09:00:00';
            return $exeed_time;
        } else if ($time == '12 pm to 3 pm') {

            $exeed_time = '12:00:00';
            return $exeed_time;
        } else if ($time == '3 pm to 6 pm') {

            $exeed_time = '15:00:00';
            return $exeed_time;
        } else if ($time == '6 pm to 9 pm') {

            $exeed_time = '18:00:00';
            return $exeed_time;
        }
    }
}
