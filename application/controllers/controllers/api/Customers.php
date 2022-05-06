<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once FCPATH . 'dompdf/autoload.inc.php';

// reference the Dompdf namespace
use Dompdf\Dompdf;

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
class Customers extends API_Controller {

    function __construct() {

        parent::__construct();
    }

    public function show_customer_profile_get() {
        $request = json_decode($this->input->raw_input_stream);
        $user = $this->is_logged_in();
        if (empty($user)) {

            $message = [
                'status' => FALSE,
                'message' => 'You need to be logged in to perform this action',
                'responseCode' => '0'
            ];
            $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
        } else {

            $profile = array(
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'phone' => $user->phone,
                'email' => $user->email,
                'image' => @$user->customers->image ? base_url('uploads/customer_profile/') . $user->customers->image : ''
            );

            $this->response([
                'status' => TRUE,
                'response' => $profile,
                'responseCode' => '1'
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

            $this->set_response($message, REST_Controller::HTTP_OK);
        }
    }

    public function update_customer_profile_post() {
        $request = json_decode($this->input->raw_input_stream);
        $email   = $request->email;
        $phone   = $request->phone;
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $image_data = $request->image;
        

        $user = $this->is_logged_in();
        
        if (empty($user)) {

            $message = [
                'status' => FALSE,
                'message' => 'You need to be logged in to perform this action',
                'responseCode' => '0'
            ];
            $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
        } else {
            //Check for duplicate phone
            $user_phone = User::all(array('select' => 'count(*) as existingcount', 'conditions' => array('phone = ? AND id != ?', $phone, $user->id)));
            if ($user_phone[0]->existingcount > 0) {
                $message = [
                    'message' => 'This phone number is already in use, please user a different phone',
                    'responseCode' => '0'
                ];
                $this->set_response($message, REST_Controller::HTTP_OK);
            }
            
            //Check for duplicate email
            if ( !empty( $email ) ) {
                $user_email = User::all(array('select' => 'count(*) as existingcount', 'conditions' => array('email = ? AND id != ?', $email, $user->id)));
                if ($user_email[0]->existingcount > 0) {                    
                    $this->response([                        
                        'message' => 'This email is already in use, please user a different email',
                        'responseCode' => '0'
                            ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

                    $this->set_response($message, REST_Controller::HTTP_OK);
                    
                }                
            }            
            
            $customer = Customer::find_by_user_id($user->id);
            $profileimg = md5($user->id . '' . date('Ymdhis'));
            if (!$customer) {
                if ($image_data != '') {
                    $target_path = "./uploads/customer_profile/";
                    $base = $image_data;
                    $binary = base64_decode($base);

                    $image = imagecreatefromstring($binary);
                    //echo $image;exit;
                    if ($image != FALSE) {
                        header('Content-Type: bitmap; charset=utf-8');
                        //unlink($target_path.$user_details->id.'.jpg');

                        imagejpeg($image, $target_path . $profileimg . '_profile.jpg');
                        $proimage = $profileimg . '_profile.jpg';
                        Customer::create(array('user_id' => $user->id, 'image' => $proimage));

                        $data = array(
                            'first_name' => $first_name,
                            'last_name' => $last_name,
                            'phone' => $phone
                        );
                        $user->update_attributes($data);


                        $profile = array(
                            'first_name' => $user->first_name,
                            'last_name' => $user->last_name,
                            'phone' => $user->phone,
                            'email' => $user->email,
                            'image' => @$user->customers->image ? base_url('uploads/customer_profile/') . $user->customers->image : ''
                        );

                        $this->response([
                            'status' => TRUE,
                            'message' => 'Profile details have been updated successfully',
                            'profile_data' => $profile,
                            'responseCode' => '1'
                                ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

                        $this->set_response($message, REST_Controller::HTTP_OK);
                    } else {
                        $this->response([
                            'status' => TRUE,
                            'message' => 'Your profile details could not be saved at this moment. Please try again',
                            'responseCode' => '0'
                                ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

                        $this->set_response($message, REST_Controller::HTTP_OK);
                    }
                } else {
                    $data = array(
                        'first_name' => $first_name,
                        'last_name' => $last_name,                        
                        'phone' => $phone
                    );
                    if (!empty( $email )) {
                        $data['email'] = $email;
                    }
                    $user->update_attributes($data);

                    $profile = array(
                        'first_name' => $user->first_name,
                        'last_name' => $user->last_name,
                        'phone' => $user->phone,
                        'email' => $user->email,
                        'image' => @$user->customers->image ? base_url('uploads/customer_profile/') . $user->customers->image : ''
                    );

                    $this->response([
                        'status' => TRUE,
                        'message' => 'Profile details have been updated successfully',
                        'profile_data' => $profile,
                        'responseCode' => '1'
                            ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

                    $this->set_response($message, REST_Controller::HTTP_OK);
                }
            } else {

                if ($image_data != '') {
                    $target_path = "./uploads/customer_profile/";
                    $base = $image_data;
                    $binary = base64_decode($base);

                    $image = @imagecreatefromstring($binary);

                    if ($image != FALSE) {
                        // unlink($target_path.$profileimg.'_profile.jpg');
                        header('Content-Type: bitmap; charset=utf-8');


                        imagejpeg($image, $target_path . $profileimg . '_profile.jpg');
                        $proimage = $profileimg . '_profile.jpg';
                        $customer->update_attributes(array('image' => $proimage));

                        $data = array(
                            'first_name' => $first_name,
                            'last_name' => $last_name,                            
                            'phone' => $phone
                        );
                        if (!empty( $email )) {
                            $data['email'] = $email;
                        }
                        $user->update_attributes($data);
                        $profile = array(
                            'first_name' => $user->first_name,
                            'last_name' => $user->last_name,
                            'phone' => $user->phone,
                            'email' => $user->email,
                            'image' => @$user->customers->image ? base_url('uploads/customer_profile/') . $user->customers->image : ''
                        );

                        $this->response([
                            'status' => TRUE,
                            'message' => 'Profile details have been updated successfully',
                            'profile_data' => $profile,
                            'responseCode' => '1'
                                ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

                        $this->set_response($message, REST_Controller::HTTP_OK);
                    } else {
                        $this->response([
                            'status' => TRUE,
                            'message' => 'Your profile details could not be saved at this moment. Please try again',
                            'responseCode' => '0'
                                ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

                        $this->set_response($message, REST_Controller::HTTP_OK);
                    }
                } else {
                    $data = array(
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'phone' => $phone
                    );
                    if (!empty( $email )) {
                        $data['email'] = $email;
                    }
                    $user->update_attributes($data);
                    $profile = array(
                        'first_name' => $user->first_name,
                        'last_name' => $user->last_name,
                        'phone' => $user->phone,
                        'email' => $user->email,
                        'image' => @$user->customers->image ? base_url('uploads/customer_profile/') . $user->customers->image : ''
                    );

                    $this->response([
                        'status' => TRUE,
                        'message' => 'Profile details have been updated successfully',
                        'profile_data' => $profile,
                        'responseCode' => '1'
                            ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

                    $this->set_response($message, REST_Controller::HTTP_OK);
                }
            }
        }
    }

    public function ongoing_bookings_get() {
        $request = json_decode($this->input->raw_input_stream);
        $user = $this->is_logged_in();

        if (empty($user)) {
            $message = [
                'status' => FALSE,
                'message' => 'You need to be logged in to perform this action',
                'responseCode' => '0'
            ];
            $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
        } else {
            $bookings = QuoteRequest::find('all', array('conditions' => array('user_id=? AND  (status = 1 OR status =2)', $user->id), 'order' => 'created_at desc'));


            $ongoing_bookings = array();
            $status = '';

            $download_invoice = '';
            foreach ($bookings as $row) {
                if ($row->status == 0) {
                    $status = 'REQUEST CANCELLED';
                } else if ($row->status == 1) {
                    $status = 'ONGOING REQUEST';
                } else if ($row->status == 2) {
                    $status = 'BOOKED';
                } else {
                    $status = 'REQUEST COMPLETED';
                }
                $chatroom_id = '';
                if ($row->status > 1) {
                    $download_invoice = base_url('api/Customers/download_invoice/') . $row->id;
                    $ResponseForProposal = ResponseForProposal::find(array('conditions' => array('status = 1 AND quote_request_id = ?', $row->id)))->id;

                    $chatroom_id = ChatRoom::find_by_request_id($ResponseForProposal)->id;
                    //print_r($chatroom_id); die;
                }




                $ongoing_bookings[] = array(
                    'booking_id' => $row->id,
                    'service' => ucwords(get_service($row->service_id)),
                    'status' => $status,
                    'flag' => $row->status,
                    'chatroom_id' => $chatroom_id ? $chatroom_id : '',
                    'not_arrived' => $row->not_arrived,
                    'service_description' => $row->request_details,
                    'location' => $row->location,
                    'download_invoice' => $download_invoice ? $download_invoice : '',
                    'date_of_booking' => date('d M Y h:i a', strtotime($row->created_at)),
                    'date_for_booking' => date('d M Y', strtotime($row->avail_date)) . ' | ' . $row->avail_time
                );
            }

            if (!empty($ongoing_bookings)) {
                $this->response([
                    'status' => TRUE,
                    'response' => $ongoing_bookings,
                    'responseCode' => '1'
                        ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'There are no bookings available at this moment.',
                    'responseCode' => '0'
                        ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    public function cancel_booking_post() {
        $request = json_decode($this->input->raw_input_stream);
        $booking_id = $request->booking_id;
        $cancel_request = $request->cancel_request_reason;

        $user = $this->is_logged_in();
        if (empty($user)) {
            $message = [
                'status' => FALSE,
                'message' => 'You need to be logged in to perform this action',
                'responseCode' => '0'
            ];
            $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
        } else {

            $booking = QuoteRequest::find_by_id_and_user_id($booking_id, $user->id);

            if (!empty($booking)) {
                $booking->update_attributes(array('cancel_request' => $cancel_request, 'status' => 0));

                $ResponseForProposal = ResponseForProposal::find('all', array('conditions' => array('quote_request_id = ?', $booking_id)));

                foreach ($ResponseForProposal as $row) {
                    $row->update_attributes(array('status' => 0));
                    $recipient = User::find_by_id($row->professional_id);
                    foreach ($recipient->user_authentications as $row1) {
                        $device_id = array($row1->device_id);
                        if (!empty($device_id)) {
                            $this->send_notification($device_id, 'The request for a quote from ' . $user->first_name . ' has been canceled.', 'Lead Canceled', $user->first_name, 'lead_canceled');
                        }
                    }


                    $data = array(
                        'sp_name' => get_user($row->professional_id)->professionals->company_name,
                        'customer_name' => get_user($booking->user_id)->first_name . ' ' . get_user($booking->user_id)->last_name,
                        'service_name' => ucwords(get_service($booking->service_id)),
                        'date_time' => date('m-d-Y', strtotime($booking->avail_date)) . ' | ' . $booking->avail_time,
                        'location' => $booking->location,
                        'cancel_request' => $booking->cancel_request);

                    $subject = "The service request for the " . ucwords(get_service($booking->service_id)) . " has been canceled by the customer";
                    $message = $this->load->view('emails/cancel_request', $data, true);
                    // print_r($data); die;
                    $this->custom_email->send(get_user($row->professional_id)->email, "UrbanSense", $subject, $message);
                }

                $this->response([
                    'status' => TRUE,
                    'response' => 'Booking has been cancelled successfully',
                    'responseCode' => '1'
                        ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'Booking could not be cancelled at this moment. If you think it is an error, please contact the administrator',
                    'responseCode' => '0'
                        ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    public function bookings_history_get() {
        $request = json_decode($this->input->raw_input_stream);
        $user = $this->is_logged_in();

        if (empty($user)) {
            $message = [
                'status' => FALSE,
                'message' => 'You need to be logged in to perform this action',
                'responseCode' => '0'
            ];
            $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
        } else {
            $bookings = QuoteRequest::find('all', array('conditions' => array('user_id=? AND is_delete = 0 AND  (status = 0 OR status =3 OR status = 4)', $user->id), 'order' => 'created_at desc'));

            $bookings_history = array();
            $status = '';
            $download_invoice = '';
            foreach ($bookings as $row) {
                if ($row->status == 0) {
                    $status = 'REQUEST CANCELLED';
                } else if ($row->status == 1) {
                    $status = 'ONGOING REQUEST';
                } else if ($row->status == 2) {
                    $status = 'BOOKED';
                } else {
                    $status = 'REQUEST COMPLETED';
                }

                $chatroom_id = '';
                if ($row->status > 1) {
                    $download_invoice = base_url('api/Customers/download_invoice/') . $row->id;
                    $ResponseForProposal = ResponseForProposal::find(array('conditions' => array('status = 1 AND quote_request_id = ?', $row->id)))->id;

                    $chatroom_id = ChatRoom::find_by_request_id($ResponseForProposal)->id;
                }

                $bookings_history[] = array(
                    'booking_id' => $row->id,
                    'service' => ucwords(get_service($row->service_id)),
                    'status' => $status,
                    'flag' => $row->status,
                    'chatroom_id' => $chatroom_id ? $chatroom_id : '',
                    'service_description' => $row->request_details,
                    'location' => $row->location,
                    'date_of_booking' => date('d M Y h:i a', strtotime($row->created_at)),
                    'date_for_booking' => date('d M Y', strtotime($row->avail_date)) . ' | ' . $row->avail_time,
                    'download_invoice' => $download_invoice ? $download_invoice : '',
                    'request_cancel_reason' => $row->cancel_request
                );
            }

            if (!empty($bookings_history)) {
                $this->response([
                    'status' => TRUE,
                    'response' => $bookings_history,
                    'responseCode' => '1'
                        ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'There are no booking history available at this moment.',
                    'responseCode' => '0'
                        ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    public function delete_booking_post() {
        $request = json_decode($this->input->raw_input_stream);
        $booking_id = $request->booking_id;
        // $cancel_request = $request->cancel_request_reason;

        $user = $this->is_logged_in();
        if (empty($user)) {
            $message = [
                'status' => FALSE,
                'message' => 'You need to be logged in to perform this action',
                'responseCode' => '0'
            ];
            $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
        } else {

            $booking = QuoteRequest::find_by_id_and_user_id($booking_id, $user->id);


            if (!empty($booking)) {
                $booking->update_attributes(array('is_delete' => 1));

                $this->response([
                    'status' => TRUE,
                    'response' => 'Booking has been deleted successfully',
                    'responseCode' => '1'
                        ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'Booking could not be deleted at this moment. If you think it is an error, please contact the administrator.',
                    'responseCode' => '0'
                        ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    function download_invoice_get($id = null) {

        $request = QuoteRequest::find_by_id($id);
        $response = ResponseForProposal::find_by_quote_request_id_and_status($request->id, 1);
        $booking = Booking::all(array('conditions' => array('response_for_quote_id = ? AND booked_status = ? ', $response->id, 'success')));
        //echo  "<pre>";    print_r($response); die;
        $data = array(
            'bookings' => $booking,
            'professional' => User::find_by_id($booking[0]->professional_id),
            'site_data' => Setting::find(array('conditions' => array('id = 1'), 'limit' => 1))
        );

        $html = $this->load->view('emails/invoice', $data, true);
        // print_r($html); die;
        $dompdf = new Dompdf();
        $dompdf->loadHtml(utf8_encode($html));
        //echo "<pre>";   print_r($dompdf); die;
        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');
        // Render the HTML as PDF
        $dompdf->render();
        // Output the generated PDF to Browser
        $dompdf->stream();
    }

    public function completeService($chatroomid) {
        $request = json_decode($this->input->raw_input_stream);
        $user = $this->is_logged_in();
        if (empty($user)) {

            $message = [
                'status' => FALSE,
                'message' => 'You need to be logged in to perform this action',
                'responseCode' => '0'
            ];
            $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
        } else {

            $chatroom = ChatRoom::find_by_id($chatroomid);
            $response = ResponseForProposal::find_by_id($chatroom->request_id);
            $response->update_attributes(array('request_accept' => 3, 'status' => 1));
            $request = QuoteRequest::find_by_id($response->quote_request_id);
            $request->update_attributes(array('status' => 3));

            $this->response([
                'status' => TRUE,
                'response' => 'You marked service as complete',
                'chat_status' => $response->request_accept,
                'active' => $response->status,
                'responseCode' => '1'
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

            $this->set_response($message, REST_Controller::HTTP_OK);
        }
    }

    public function completeService_android_post() {
        $request = json_decode($this->input->raw_input_stream);
        $chatroomid = $request->chatroom_id;
        $user = $this->is_logged_in();
        if (empty($user)) {

            $message = [
                'status' => FALSE,
                'message' => 'You need to be logged in to perform this action',
                'responseCode' => '0'
            ];
            $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
        } else {

            $chatroom = ChatRoom::find_by_id($chatroomid);
            $response = ResponseForProposal::find_by_id($chatroom->request_id);
            $response->update_attributes(array('request_accept' => 3, 'status' => 1));
            $request = QuoteRequest::find_by_id($response->quote_request_id);
            $request->update_attributes(array('status' => 3));

            $this->response([
                'status' => TRUE,
                'response' => 'You marked service as complete',
                'chat_status' => $response->request_accept,
                'active' => $response->status,
                'responseCode' => '1'
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

            $this->set_response($message, REST_Controller::HTTP_OK);
        }
    }

    public function cancel_extra_payment_get($chatroomid) {
        $request = json_decode($this->input->raw_input_stream);
        $user = $this->is_logged_in();
        if (empty($user)) {

            $message = [
                'status' => FALSE,
                'message' => 'You need to be logged in to perform this action',
                'responseCode' => '0'
            ];
            $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
        } else {

            $chatroom = ChatRoom::find_by_id($chatroomid);
            if ($chatroom) {
                $extra_work = PriceHistory::find(array('select' => 'sum(amount) as total_amount', 'conditions' => array('chatroom_id = ? AND payment_status = ? AND status = 1', $chatroom->id, 'success')));

                $data3 = array(
                    'chatroom_id' => $chatroom->id,
                    'amount' => ($chatroom->price) - ($extra_work->total_amount),
                    'currency' => 'ZAR',
                    'payment_status' => 'cancelled',
                    'status' => 0,
                );

                PriceHistory::create($data3);

                $chatroom->update_attributes(array('price' => $extra_work->total_amount));


                $this->response([
                    'status' => TRUE,
                    'response' => 'Request cancelled successfully.',
                    'responseCode' => '1'
                        ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

                $this->set_response($message, REST_Controller::HTTP_OK);
            } else {

                $this->set_response([
                    'status' => FALSE,
                    'message' => 'Request can not be cancelled at this time. Please try again later. If you think it is an error, please contact the administrator.',
                    'responseCode' => '0'
                        ], REST_Controller::HTTP_OK);
                // NOT_FOUND (404) being the HTTP response code            }
            }
        }
    }

    public function reviews_post() {
        $request = json_decode($this->input->raw_input_stream);
        $professionalism = $request->professionalism;
        $knowledge = $request->knowledge;
        $cost = $request->cost;
        $punctuality = $request->punctuality;
        $tidiness = $request->tidiness;
        $user_friendly = $request->user_friendly;
        $interface = $request->interface;
        $technical_issue = $request->technical_issue;
        $review = $request->review;
        $chatroom_id = $request->chatroom_id;

        $user = $this->is_logged_in();
        if (empty($user)) {

            $message = [
                'status' => FALSE,
                'message' => 'You need to be logged in to perform this action',
                'responseCode' => '0'
            ];
            $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
        } else {

            if ($professionalism == "" OR $knowledge == "" OR $cost == "" OR $punctuality == "" OR $tidiness == "" OR $user_friendly == "" OR $interface == "" OR $technical_issue == "" OR $review == "" OR $chatroom_id == "") {

                $this->response([
                    'status' => TRUE,
                    'message' => 'Please provide all the mandatory parameters in order to proceed',
                    'responseCode' => '1'
                        ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

                $this->set_response($message, REST_Controller::HTTP_OK);
            } else {


                $chatroom = ChatRoom::find_by_id($chatroom_id);

                $res_for_pro = ResponseForProposal::find_by_id($chatroom->request_id);

                //print_r($res_for_pro);
                $ResponseForProposal = ResponseForProposal::find('all', array('conditions' => array('quote_request_id = ?', $res_for_pro->quote_request_id)));
                //echo '<pre>'; print_r($ResponseForProposal); die;
                foreach ($ResponseForProposal as $row) {
                    $row->update_attributes(array('status' => 0));
                }

                $res_for_pro->update_attributes(array('request_accept' => 4, 'status' => 1));

                $request = QuoteRequest::find_by_id($res_for_pro->quote_request_id);
                $request->update_attributes(array('status' => 4));

                $data = array(
                    'professionalism' => $professionalism,
                    'knowledge' => $knowledge,
                    'cost' => $cost,
                    'punctuality' => $punctuality,
                    'tidiness' => $tidiness,
                    'user_friendly' => $user_friendly,
                    'interface' => $interface,
                    'technical_issue' => $technical_issue,
                    'review' => $review,
                    'name' => $user->first_name . ' ' . $user->last_name,
                    'phone' => $user->phone,
                    'professional_id' => $chatroom->professional_id,
                    'type' => 'professional',
                    'status' => 1
                );

                $is_create = Review::create($data);
                $recipient = User::find_by_id($chatroom->professional_id);
                if ($is_create) {

                    foreach ($recipient->user_authentications as $row) {
                        $device_id = array($row->device_id);
                        if (!empty($device_id)) {
                            $this->send_notification($device_id, 'You have received feedback from ' . $user->first_name . ' ' . $user->last_name . ' for ' . get_service($request->service_id), 'Review', $user->first_name, 'review');
                        }
                    }

                    $this->response([
                        'status' => TRUE,
                        'message' => 'Your review has been stored and will be shown on the providers profile shortly',
                        'responseCode' => '1'
                            ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

                    $this->set_response($message, REST_Controller::HTTP_OK);
                } else {

                    $this->response([
                        'status' => TRUE,
                        'message' => 'Your review could not be saved at this moment. If you think it is an error, please contact the administrator.',
                        'responseCode' => '1'
                            ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

                    $this->set_response($message, REST_Controller::HTTP_OK);
                }
            }
        }
    }

}
