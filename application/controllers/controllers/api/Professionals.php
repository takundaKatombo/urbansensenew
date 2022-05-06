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
class Professionals extends API_Controller {

    function __construct() {

        parent::__construct();
    }

    public function show_sp_profile_get() {
        $request = json_decode($this->input->raw_input_stream);
        $user = $this->is_logged_in();
        if (empty($user)) {

            $message = [
                'status' => FALSE,
                'message' => 'You need to be logged in to perform this action.',
                'responseCode' => '0'
            ];
            $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
        } else {

            $service_images = array();
            foreach ($user->professional_images as $row) {
                $service_images[] = array('id' => $row->id,
                    'image' => base_url('uploads/image/') . $row->image,
                    'is_profile_image' => $row->default_image
                );
            }

            $services = array();
            foreach ($user->professional_services as $row) {
                $services[] = array(
                    'service_title' => get_service($row->service_id),
                    'service_id' => $row->service_id
                );
            }

            //  print_r(expression)

            $profile = array(
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'phone' => $user->phone,
                'email' => $user->email,
                'profile_image' => get_default_pro_image($user->id) ? base_url('uploads/image/') . get_default_pro_image($user->id) : '',
                'city_name' => get_city($user->professionals->city_id),
                'city_id' => $user->professionals->city_id,
                'services' => $services,
                'address' => $user->professionals->address,
                'company_name' => $user->professionals->company_name,
                'company_detail' => $user->professionals->company_detail,
                'introduction' => $user->professionals->introduction,
                // 'price' => $user->professionals->price,
                'latitude' => $user->professionals->latitude,
                'longitude' => $user->professionals->longitude,
                'id_type' => $user->professionals->id_type,
                'id_number' => $user->professionals->id_number,
                'account_holder_name' => $user->professionals->account_holder_name,
                'account_number' => $user->professionals->account_number,
                'ifsc' => $user->professionals->ifsc,
                'branch' => $user->professionals->branch,
                'bank_passbook_image' => $user->professionals->bank_passbook_image ? base_url('uploads/bank_passbook_image/' . $user->professionals->bank_passbook_image) : '',
                'id_card_image' => $user->professionals->bank_passbook_image ? base_url('uploads/id_card_image/' . $user->professionals->id_card_image) : '',
                'services_image' => $service_images
            );

            $this->response([
                'status' => TRUE,
                'response' => $profile,
                'verified' => $user->verification,
                'responseCode' => '1'
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

            $this->set_response($message, REST_Controller::HTTP_OK);
        }
    }

    public function update_sp_profile_post() {
        $request = json_decode($this->input->raw_input_stream);

        $email = $request->email;
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $city_id = $request->city_id;
        $address = $request->address;
        $company_name = $request->company_name;
        $company_detail = $request->company_detail;
        $introduction = $request->introduction;
        // $price = $request->price;
        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $id_type = $request->id_type;
        $id_number = $request->id_number;
        $account_holder_name = $request->account_holder_name;
        $account_number = $request->account_number;
        $ifsc = $request->ifsc;
        $branch = $request->branch;
        $bank_passbook_image = $request->bank_passbook_image;
        $id_card_image = $request->id_card_image;
        $services_ids = $request->services;
        //'image' => @$image ? $image : $chk->image


        $user = $this->is_logged_in();
        /* CHECK LOGIN ? */
        if (empty($user)) {

            $message = [
                'status' => FALSE,
                'message' => 'You need to be logged in to perform this action.',
                'responseCode' => '0'
            ];
            $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
        } else {

            //Check for duplicate email
            if ( !empty( $email ) ) {
                $user_email = User::all(array('select' => 'count(*) as existingcount', 'conditions' => array('email = ? AND id != ?', $email, $user->id)));
                if ($user_email[0]->existingcount > 0) {
                    $message = [
                        'message' => 'This email is already in use, please user a different email',
                        'responseCode' => '0'
                    ];
                    $this->set_response($message, REST_Controller::HTTP_OK);
                }                
            }

            /* INITAILIZE PARAMETER */
            $bpassbookimage = '';
            $uidimage = '';

            /* CHECK FILE EXIST ? */
            if ($user->verification != 1) {
                if ($bank_passbook_image != '' || $id_card_image != '') {
                    $target_path = "././uploads/bank_passbook_image/";
                    $base = $bank_passbook_image;
                    $binary = base64_decode($base);

                    $passbookimage = @imagecreatefromstring($binary);

                    if ($passbookimage != FALSE) {
                        header('Content-Type: bitmap; charset=utf-8');
                        @unlink($target_path . $user->id . '_bank_passbook_image.jpg');

                        imagejpeg($passbookimage, $target_path . $user->id . '_bank_passbook_image.jpg');
                        $bpassbookimage = $user->id . '_bank_passbook_image.jpg';
                    }

                    $target_path1 = "././uploads/id_card_image/";
                    $base1 = $id_card_image;
                    $binary1 = base64_decode($base1);

                    $idimage = @imagecreatefromstring($binary1);

                    if ($idimage != FALSE) {
                        header('Content-Type: bitmap; charset=utf-8');
                        @unlink($target_path1 . $user->id . '_id_card_image.jpg');

                        imagejpeg($idimage, $target_path1 . $user->id . '_id_card_image.jpg');
                        $uidimage = $user->id . '_id_card_image.jpg';
                    }
                }
            }
            /* UPDATE INFORMATION */
            $data = array('first_name' => $first_name,
                'last_name' => $last_name
            );
            if (!empty( $email )) {
                $data['email'] = $email;
            }
            $user->update_attributes($data);

            $professional = Professional::find_by_user_id($user->id);
            $other_data = array(
                'city_id' => $city_id,
                'address' => $address,
                'company_name' => $company_name,
                'company_detail' => $company_detail,
                'introduction' => $introduction,
                //'price' => $price,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'id_type' => $id_type,
                'id_number' => $id_number,
                'account_holder_name' => $account_holder_name,
                'account_number' => $account_number,
                'ifsc' => $ifsc,
                'branch' => $branch,
                'bank_passbook_image' => $bpassbookimage ? $bpassbookimage : $professional->bank_passbook_image,
                'id_card_image' => $uidimage ? $uidimage : $professional->id_card_image
            );


            $professional->update_attributes($other_data);
            $services = array_unique(explode(",", $services_ids));
            ProfessionalService::delete_all(array("conditions" => array("user_id = ?", $user->id)));
            foreach ($services as $row) {
                ProfessionalService::create(array('user_id' => $user->id, 'service_id' => $row));
            }

            if ($user->verification != 1) {

                $admin = Setting::find(array('conditions' => array('id = 1'), 'limit' => 1));
                $message = 'Hello UrbanSense <br> ' . $user->first_name . ' ' . $user->last_name . ' updated his account  details. Please check if all documents are accurate then verify his account<br> <b>Name : </b>' . $user->first_name . ' ' . $user->last_name . ' <br> <b>Email : </b>' . $user->email;
                $send = $this->custom_email->send($admin->email, 'UrbanSense', "[UrbanSense] " . $user->email . " Account Update", $message);
            }

            $this->response([
                'status' => TRUE,
                'response' => 'Profile details have been updated successfully.',
                'verified' => $user->verification,
                'responseCode' => '1'
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

            $this->set_response($message, REST_Controller::HTTP_OK);
        }
    }

    public function service_image_get() {
        $request = json_decode($this->input->raw_input_stream);

        $user = $this->is_logged_in();
        if (empty($user)) {

            $message = [
                'status' => FALSE,
                'message' => 'You need to be logged in to perform this action.',
                'responseCode' => '0'
            ];
            $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
        } else {


            $service_images = array();
            foreach ($user->professional_images as $row) {
                $service_images[] = array('id' => $row->id,
                    'image' => base_url('uploads/image/') . $row->image,
                    'is_profile_image' => $row->default_image
                );
            }

            $this->response([
                'status' => TRUE,
                'response' => $service_images,
                'verified' => $user->verification,
                'responseCode' => '1'
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

            $this->set_response($message, REST_Controller::HTTP_OK);
        }
    }

    public function upload_service_image_post() {
        $request = json_decode($this->input->raw_input_stream);
        $service_image = $request->service_image;

        $user = $this->is_logged_in();
        if (empty($user)) {

            $message = [
                'status' => FALSE,
                'message' => 'You need to be logged in to perform this action.',
                'responseCode' => '0'
            ];
            $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
        } else {

            if ($service_image != '') {
                $target_path = "././uploads/image/";
                $base = $service_image;
                $binary = base64_decode($base);

                $image = @imagecreatefromstring($binary);

                if ($image != FALSE) {
                    header('Content-Type: bitmap; charset=utf-8');
                    //unlink($target_path.$user_details->id.'.jpg');

                    imagejpeg($image, $target_path . date('Ymdhis') . '_profile.jpg');
                    $proimage = date('Ymdhis') . '_profile.jpg';
                    ProfessionalImage::create(array('user_id' => $user->id, 'image' => $proimage));

                    $service_images = array();
                    foreach ($user->professional_images as $row) {
                        $service_images[] = array('id' => $row->id,
                            'image' => base_url('uploads/image/') . $row->image,
                            'is_profile_image' => $row->default_image
                        );
                    }

                    $this->response([
                        'status' => TRUE,
                        'message' => 'Profile image have been uploaded successfully.',
                        'response' => $service_images,
                        'verified' => $user->verification,
                        'responseCode' => '1'
                            ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

                    $this->set_response($message, REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'Your profile image could not be saved at this moment. Please try again.',
                        'verified' => $user->verification,
                        'responseCode' => '0'
                            ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

                    $this->set_response($message, REST_Controller::HTTP_OK);
                }
            } else {

                $this->response([
                    'status' => FALSE,
                    'message' => 'The seleced image could not be found. Please select another image to upload.',
                    'verified' => $user->verification,
                    'responseCode' => '0'
                        ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

                $this->set_response($message, REST_Controller::HTTP_OK);
            }
        }
    }

    public function make_profile_pic_post() {
        $request = json_decode($this->input->raw_input_stream);
        $image_id = $request->image_id;

        $user = $this->is_logged_in();
        if (empty($user)) {

            $message = [
                'status' => FALSE,
                'message' => 'You need to be logged in to perform this action.',
                'responseCode' => '0'
            ];
            $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
        } else {
            $image = ProfessionalImage::find_by_id($image_id);
            $chk = ProfessionalImage::all(array('conditions' => array('user_id=?', $user->id)));

            foreach ($chk as $key => $value) {
                $data = array('default_image' => 0);
                $value->update_attributes($data);
            }

            $result = $image->update_attributes(array('default_image' => 1));
            $service_image = ProfessionalImage::all(array('conditions' => array('user_id=?', $user->id)));
            $service_images = array();
            foreach ($service_image as $row) {
                $service_images[] = array('id' => $row->id,
                    'image' => base_url('uploads/image/') . $row->image,
                    'is_profile_image' => $row->default_image
                );
            }

            if ($result) {
                $this->response([
                    'status' => TRUE,
                    'message' => 'Profile image has been selected successfully.',
                    'response' => $service_images,
                    'verified' => $user->verification,
                    'responseCode' => '1'
                        ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

                $this->set_response($message, REST_Controller::HTTP_OK);
            } else {
                $message = [
                    'status' => FALSE,
                    'message' => 'The seleced image could not be found. Please select other image to update the profile image.',
                    'verified' => $user->verification,
                    'responseCode' => '0'
                ];
                $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }

    public function delete_service_image_post() {
        $request = json_decode($this->input->raw_input_stream);
        $image_id = $request->image_id;

        $user = $this->is_logged_in();
        if (empty($user)) {

            $message = [
                'status' => FALSE,
                'message' => 'You need to be logged in to perform this action.',
                'responseCode' => '0'
            ];
            $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
        } else {
            $image = ProfessionalImage::find_by_id($image_id);



            if ($image) {
                @unlink('./uploads/image/' . $image->image);
                $image->delete();
                $service_image = ProfessionalImage::all(array('conditions' => array('user_id=?', $user->id)));
                $service_images = array();
                foreach ($service_image as $row) {
                    $service_images[] = array('id' => $row->id,
                        'image' => base_url('uploads/image/') . $row->image,
                        'is_profile_image' => $row->default_image
                    );
                }

                $this->response([
                    'status' => TRUE,
                    'message' => 'Image has been deleted successfully.',
                    'response' => $service_images,
                    'verified' => $user->verification,
                    'responseCode' => '1'
                        ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

                $this->set_response($message, REST_Controller::HTTP_OK);
            } else {
                $message = [
                    'status' => FALSE,
                    'message' => 'The seleced image could not be found. Please select other image.',
                    'verified' => $user->verification,
                    'responseCode' => '0'
                ];
                $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }

    public function new_leads_get() {
        $user = $this->is_logged_in();
        if (empty($user)) {

            $message = [
                'status' => FALSE,
                'message' => 'You need to be logged in to perform this action.',
                'responseCode' => '0'
            ];
            $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
        } else {

            $requests = ResponseForProposal::find('all', array('conditions' => array('request_accept = 0 AND professional_id = ?', $user->id), 'order' => 'created_at desc'));
            $count_leads = ResponseForProposal::count(array('conditions' => array('request_accept = 0 AND professional_id = ?', $user->id)));

            $request = ResponseForProposal::find('all', array('conditions' => array('is_view = 0 AND professional_id = ?', $user->id)));
            foreach ($request as $row) {
                $row->update_attributes(array('is_view' => 1));
            }


            $new_leads = array();
            foreach ($requests as $row) {
                $request_status = '';
                $booking_status = '';
                if ($row->quote_request->status == 0 OR $row->status == 0) {
                    $request_status = 'REQUEST CANCELLED';
                } else if ($row->quote_request->status == 1) {
                    $request_status = 'ONGOING REQUEST';
                } else {
                    $request_status = 'REQUEST COMPLETED';
                }

                if ($row->quote_request->status == 1) {
                    $booking_status = (@$row->request_accept == 1) ? 'Accepted' : 'Accept';
                }


                $new_leads[] = array(
                    'service' => get_service($row->quote_request->service_id),
                    'customer_id' => $row->quote_request->user_id,
                    'quote_request_id' => $row->id,
                    'address' => $row->quote_request->location,
                    'request_deatils' => $row->quote_request->request_details,
                    'time_for_booking' => date('d M Y', strtotime($row->quote_request->avail_date)) . ' | ' . $row->quote_request->avail_time,
                    'time_of_booking' => date('d M Y  h:i a', strtotime($row->quote_request->created_at)),
                    'reason_of_cancel_request' => $row->quote_request->cancel_request,
                    'request_status' => $request_status,
                    'booking_status' => $booking_status
                );
            }



            if (!empty($new_leads)) {
                $this->response([
                    'status' => TRUE,
                    'response' => $new_leads,
                    'lead_count' => $count_leads,
                    'verified' => $user->verification,
                    'responseCode' => '1'
                        ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                $this->set_response($message, REST_Controller::HTTP_OK);
            } else {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'No new lead was found at this moment. You will see the leads when a customer requests you for your services.',
                    'verified' => $user->verification,
                    'responseCode' => '0'
                        ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
                //  $this->set_response($message, REST_Controller::HTTP_OK);
            }
        }
    }

    public function request_accept_post() {
        $request = json_decode($this->input->raw_input_stream);
        $customer_id = $request->customer_id;
        $response_for_proposal_id = $request->quote_request_id;
        $price = $request->price;
        $quote_details = $request->quote_details;

        $user = $this->is_logged_in();
        if (empty($user)) {
            $message = [
                'status' => FALSE,
                'message' => 'You need to be logged in to perform this action.',
                'responseCode' => '0'
            ];
            $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
        } else {

            $var = ResponseForProposal::find_by_id($response_for_proposal_id);
            if (!empty($var)) {

                $data1 = array(
                    'professional_id' => $user->id,
                    'customer_id' => $customer_id,
                    'request_id' => $response_for_proposal_id,
                    'price' => $price
                );
                $chat_room_id = ChatRoom::create($data1)->id;

                $data2 = array(
                    'chat_room_id' => $chat_room_id,
                    'user_id' => $user->id,
                    'message' => $quote_details
                );
                Chat::create($data2);
                //print_r($var);
                $var->update_attributes(array('request_accept' => 1));


                $data3 = array(
                    'chatroom_id' => $chat_room_id,
                    'amount' => $price,
                    'currency' => 'ZAR',
                    'payment_status' => 'initiated',
                    'status' => 0,
                );

                PriceHistory::create($data3);

                $recipient = User::find_by_id($customer_id);
                foreach ($recipient->user_authentications as $row) {
                    $device_id = array($row->device_id);
                    if (!empty($device_id)) {
                        $this->send_notification($device_id, 'Your request for the quotation has been accepted by ' . $user->professionals->company_name, 'Request Accepted', $user->first_name, 'request_accepted');
                    }
                }



                $this->response([
                    'status' => TRUE,
                    'response' => "You have accepted this request successfully. Please read the service details and provide your best quote to the customer.",
                    'verified' => $user->verification,
                    'responseCode' => '1'
                        ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                $this->set_response($message, REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => False,
                    'message' => "You could not accept the request at this moment. Either the request has been cancelled by the customer or an internet issue has occurred. Please try again.",
                    'verified' => $user->verification,
                    'responseCode' => '0'
                        ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                $this->set_response($message, REST_Controller::HTTP_OK);
            }
        }
    }

    public function ongoing_leads_get() {
        $user = $this->is_logged_in();
        if (empty($user)) {

            $message = [
                'status' => FALSE,
                'message' => 'You need to be logged in to perform this action.',
                'responseCode' => '0'
            ];
            $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
        } else {

            $requests = ResponseForProposal::find('all', array('conditions' => array('request_accept = 1 AND professional_id = ?', $user->id), 'order' => 'created_at desc'));
            $count_leads = ResponseForProposal::count(array('conditions' => array('request_accept = 1 AND professional_id = ?', $user->id)));

            $request = ResponseForProposal::find('all', array('conditions' => array('is_view = 0 AND professional_id = ?', $user->id)));
            foreach ($request as $row) {
                $row->update_attributes(array('is_view' => 1));
            }


            $ongoing_leads = array();
            foreach ($requests as $row) {
                $request_status = '';
                $booking_status = '';
                if ($row->quote_request->status == 0 OR $row->status == 0) {
                    $request_status = 'REQUEST CANCELLED';
                } else if ($row->quote_request->status == 1) {
                    $request_status = 'ONGOING REQUEST';
                } else {
                    $request_status = 'REQUEST COMPLETED';
                }

                if ($row->quote_request->status == 1) {
                    $booking_status = (@$row->request_accept == 1) ? 'Accepted' : 'Accept';
                }


                $ongoing_leads[] = array(
                    'service' => get_service($row->quote_request->service_id),
                    'customer_id' => $row->quote_request->user_id,
                    'quote_request_id' => $row->quote_request->id,
                    'address' => $row->quote_request->location,
                    'request_deatils' => $row->quote_request->request_details,
                    'time_for_booking' => date('d M Y', strtotime($row->quote_request->avail_date)) . ' | ' . $row->quote_request->avail_time,
                    'time_of_booking' => date('d M Y  h:i a', strtotime($row->quote_request->created_at)),
                    'request_status' => $request_status,
                    'reason_of_cancel_request' => $row->quote_request->cancel_request,
                    'booking_status' => $booking_status
                );
            }



            if (!empty($ongoing_leads)) {
                $this->response([
                    'status' => TRUE,
                    'response' => $ongoing_leads,
                    'lead_count' => $count_leads,
                    'verified' => $user->verification,
                    'responseCode' => '1'
                        ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                $this->set_response($message, REST_Controller::HTTP_OK);
            } else {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'No ongoing lead could be found at this moment. You will be able see ongoing leads when you accept any service request from the customer.',
                    'verified' => $user->verification,
                    'responseCode' => '0'
                        ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
                // $this->set_response($message, REST_Controller::HTTP_OK);
            }
        }
    }

    public function converted_leads_get() {
        $user = $this->is_logged_in();
        if (empty($user)) {


            $this->response([
                'status' => FALSE,
                'message' => 'You need to be logged in to perform this action.',
                'responseCode' => '0'
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
        } else {

            $requests = ResponseForProposal::find('all', array('conditions' => array('request_accept  >= 2 AND professional_id = ?', $user->id), 'order' => 'created_at desc'));
            $count_leads = ResponseForProposal::count(array('conditions' => array('request_accept  >= 2 AND professional_id = ?', $user->id)));

            $request = ResponseForProposal::find('all', array('conditions' => array('is_view = 0 AND professional_id = ?', $user->id)));
            foreach ($request as $row) {
                $row->update_attributes(array('is_view' => 1));
            }


            $converted_leads = array();
            foreach ($requests as $row) {
                $request_status = '';
                $booking_status = '';
                if ($row->quote_request->status == 0 OR $row->status == 0) {
                    $request_status = 'REQUEST CANCELLED';
                } else if ($row->quote_request->status == 1) {
                    $request_status = 'ONGOING REQUEST';
                } else {
                    $request_status = 'REQUEST COMPLETED';
                }

                if ($row->quote_request->status == 1) {
                    $booking_status = (@$row->request_accept == 1) ? 'Accepted' : 'Accept';
                }


                $converted_leads[] = array(
                    'service' => get_service($row->quote_request->service_id),
                    'customer_id' => $row->quote_request->user_id,
                    'quote_request_id' => $row->quote_request->id,
                    'address' => $row->quote_request->location,
                    'request_deatils' => $row->quote_request->request_details,
                    'time_for_booking' => date('d M Y', strtotime($row->quote_request->avail_date)) . ' | ' . $row->quote_request->avail_time,
                    'time_of_booking' => date('d M Y  h:i a', strtotime($row->quote_request->created_at)),
                    'request_status' => $request_status,
                    'reason_of_cancel_request' => $row->quote_request->cancel_request,
                    'booking_status' => $booking_status
                );
            }

            if (!empty($converted_leads)) {
                $this->response([
                    'status' => TRUE,
                    'response' => $converted_leads,
                    'lead_count' => $count_leads,
                    'verified' => $user->verification,
                    'responseCode' => '1'
                        ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                $this->set_response($message, REST_Controller::HTTP_OK);
            } else {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'No converted lead could be found at this moment. You will be able see ongoing leads when you accept any service request from the customer.',
                    'verified' => $user->verification,
                    'responseCode' => '0'
                        ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    public function update_address_post() {
        $request = json_decode($this->input->raw_input_stream);
        $latitude = $request->latitude;
        $longitude = $request->longitude;
        //'image' => @$image ? $image : $chk->image
        $user = $this->is_logged_in();
        /* CHECK LOGIN ? */
        if (empty($user)) {

            $message = [
                'status' => FALSE,
                'message' => 'You need to be logged in to perform this action.',
                'responseCode' => '0'
            ];
            $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
        } else {

            if ($latitude != "" AND $longitude != "") {
                /* UPDATE INFORMATION */
                $other_data = array(
                    'latitude' => $latitude,
                    'longitude' => $longitude
                );

                $professional = Professional::find_by_user_id($user->id);
                $professional->update_attributes($other_data);


                $this->response([
                    'status' => TRUE,
                    'response' => 'Your address has been updated successfully.',
                    'verified' => $user->verification,
                    'responseCode' => '1'
                        ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

                $this->set_response($message, REST_Controller::HTTP_OK);
            } else {
                $message = [
                    'message' => 'Please provide all the mandatory parameters.',
                    'verified' => $user->verification,
                    'responseCode' => '0'
                ];

                $this->set_response($message, REST_Controller::HTTP_OK);
            }
        }
    }

    public function dashboard_get() {
        $request = json_decode($this->input->raw_input_stream);
        $user = $this->is_logged_in();
        if (empty($user)) {

            $message = [
                'status' => FALSE,
                'message' => 'You need to be logged in to perform this action.',
                'responseCode' => '0'
            ];
            $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
        } else {

            $booking = Booking::find(array('select' => 'count(amount_paid) as total_payment, count(id) as total_booking', 'conditions' => array('booked_status = "success" AND professional_id = ?', $user->id)));
            $new_leads = ResponseForProposal::count(array('conditions' => array(' is_view = 0 AND professional_id = ? ', $user->id)));

            $recent_booking = Booking::find('all', array('limit' => 4, 'order' => 'created_at desc', 'conditions' => array('booked_status = "success" AND professional_id = ?', $user->id)));

            $recent_payment = Payment::find('all', array('conditions' => array('payment_status = "success" AND professional_id = ?', $user->id), 'limit' => 4, 'order' => 'created_at desc'));

            $chat_room = ChatRoom::find('all', array('conditions' => array('professional_id = ?', $user->id)));
            $total_message = 0;
            foreach ($chat_room as $row) {
                $total_message = Chat::count(array('conditions' => array('chat_room_id = ? AND is_view_professional = ?', $row->id, 0))) + $total_message;
            }


            $booking_list = array();
            foreach ($recent_booking as $row) {
                $booking_list[] = array(
                    "amount" => $row->amount_paid,
                    "currency_type" => $row->currency
                );
            }

            $payment_list = array();
            foreach ($recent_payment as $row) {
                $payment_list[] = array(
                    "service" => get_service($row->service_id)
                );
            }

            $dashboard = array(
                'total_payment' => $booking->total_payment,
                'total_booking' => $booking->total_booking,
                'total_message' => $total_message,
                'new_leads' => $new_leads,
                'recent_booking' => $booking_list,
                'recent_payment' => $payment_list,
                'profile_image' => get_default_pro_image($user->id) ? base_url('uploads/image/') . get_default_pro_image($user->id) : ''
            );

            $this->response([
                'status' => TRUE,
                'response' => $dashboard,
                'verified' => $user->verification,
                'responseCode' => '1'
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

            $this->set_response($message, REST_Controller::HTTP_OK);
        }
    }

    public function leads_count_get() {
        $request = json_decode($this->input->raw_input_stream);
        $user = $this->is_logged_in();
        if (empty($user)) {

            $message = [
                'status' => FALSE,
                'message' => 'You need to be logged in to perform this action.',
                'responseCode' => '0'
            ];
            $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
        } else {


            $new_leads = ResponseForProposal::count(array('conditions' => array(' is_view = 0 AND professional_id = ? ', $user->id)));
            $converted_leads = ResponseForProposal::count(array('conditions' => array('request_accept  >= 2 AND professional_id = ?', $user->id)));
            $ongoing_leads = ResponseForProposal::count(array('conditions' => array('request_accept = 1 AND professional_id = ?', $user->id)));

            $lead = array(
                'new_leads' => $new_leads,
                'converted_leads' => $converted_leads,
                'ongoing_leads' => $ongoing_leads
            );

            $this->response([
                'status' => TRUE,
                'response' => $lead,
                'verified' => $user->verification,
                'responseCode' => '1'
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

            $this->set_response($message, REST_Controller::HTTP_OK);
        }
    }

    public function paymentlist_get() {
        $request = json_decode($this->input->raw_input_stream);
        $user = $this->is_logged_in();
        if (empty($user)) {

            $message = [
                'status' => FALSE,
                'message' => 'You need to be logged in to perform this action.',
                'responseCode' => '0'
            ];
            $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
        } else {

            $payments = Payment::find('all', array('conditions' => array('payment_status = "success" AND professional_id = ?', $user->id), 'order' => 'created_at desc'));

            $payment_list = array();
            foreach ($payments as $row) {
                $payment_list[] = array(
                    "payment_id" => $row->id,
                    "payment_key" => $row->payment_key,
                    "price" => $row->amount,
                    "currency" => $row->currency_type,
                    "service" => get_service($row->service_id),
                    "customer_name" => $row->customer_name,
                    "customer_email" => $row->customer_email,
                    "customer_phone" => $row->customer_phone,
                    "payment_date" => $row->created_at,
                    "invoice" => base_url('api/professionals/download_invoice/') . $row->payment_key,
                );
            }

            $this->response([
                'status' => TRUE,
                'response' => $payment_list,
                'verified' => $user->verification,
                'responseCode' => '1'
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

            $this->set_response($message, REST_Controller::HTTP_OK);
        }
    }

    public function bookinglist_get() {
        $request = json_decode($this->input->raw_input_stream);
        $user = $this->is_logged_in();
        if (empty($user)) {

            $message = [
                'status' => FALSE,
                'message' => 'You need to be logged in to perform this action.',
                'responseCode' => '0'
            ];
            $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
        } else {

            $bookings = Booking::find('all', array('conditions' => array('booked_status = "success" AND professional_id = ?', $user->id), 'order' => 'created_at desc'));

            $booking_list = array();
            foreach ($bookings as $row) {
                $booking_list[] = array(
                    "id" => $row->id,
                    "payment_id" => $row->payment_key,
                    "booking_id" => $row->booking_reference_number,
                    "price" => $row->amount_paid,
                    "currency" => $row->currency,
                    "service" => get_service($row->service_id),
                    "customer_name" => $row->customer_name,
                    "customer_email" => $row->customer_email,
                    "customer_phone" => $row->customer_phone,
                    "customer_address" => $row->customer_address,
                    "customer_required_date" => date('d-M-Y', strtotime($row->required_date)),
                    "customer_required_time" => $row->required_time,
                    "payment_date" => $row->created_at,
                    "invoice" => base_url('api/professionals/download_invoice/') . $row->payment_key,
                );
            }

            $this->response([
                'status' => TRUE,
                'response' => $booking_list,
                'verified' => $user->verification,
                'responseCode' => '1'
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

            $this->set_response($message, REST_Controller::HTTP_OK);
        }
    }

    function download_invoice_get($id = null) {

        $booking = Booking::find(array('conditions' => array('payment_key = ? AND booked_status = ? ', $id, 'success')));

        $data = array(
            'booking' => $booking,
            'professional' => User::find_by_id($booking->professional_id),
            'site_data' => Setting::find(array('conditions' => array('id = 1'), 'limit' => 1))
        );

        $html = $this->load->view('emails/receipt', $data, true);

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

}
