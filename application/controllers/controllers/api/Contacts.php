<?php

defined('BASEPATH') OR exit('No direct script access allowed');

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
class Contacts extends API_Controller {

    function __construct() {

        parent::__construct();
    }

    public function savecontact_post() {
        $request = json_decode($this->input->raw_input_stream);

        $name = $request->name;
        $phone = $request->phone;
        $email = $request->email;
        $subject = $request->subject;
        $message = $request->message;

        if (!$name OR!$phone OR!$email OR!$subject OR!$message) {

            $message = [
                'status' => FALSE,
                'message' => 'Please provide all the mendatory parameters',
                'responseCode' => '0'
            ];
            $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
        } else {

            $data = array(
                'name' => $name,
                'phone' => $phone,
                'email' => $email,
                'subject' => $subject,
                'message' => $message
            );

            $user = Contact::create($data);

            $message = $this->load->view('emails/contactus', $data, TRUE);


            $this->custom_email->send($email, $name, "[UrbanSense] Your Contact Request Has Been Received", $message);

            if ($user) {
                $this->response([
                    'status' => TRUE,
                    'response' => 'Contact details have been received. We will respond to you soon',
                    'responseCode' => '1'
                        ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                $this->response([
                    'status' => FALSE,
                    'response' => 'Contact details could not be saved. It could be an internet issue. Please try later',
                    'responseCode' => '0'
                        ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
        }
    }

}
