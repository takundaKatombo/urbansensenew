
<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once FCPATH . 'dompdf/autoload.inc.php';

// reference the Dompdf namespace
use Dompdf\Dompdf;

class Bookings extends MY_Controller {
    /*
     * *******customer***********
      ongoing status = 1
      cancel status = 0
      booked status = 2
      completed status = 3
      review status = 4

     */

    /*
     * **********service provider*********
      new leads => request_accept = 0
      ongoing_leads  => request_accept = 1
      converted_leads => request_accept = 2
      payment complete => request_accept = 3

     */

    public function index() {
        if (!$this->ion_auth->is_member()) {
            redirect('login');
        } else {
            $config['per_page'] = 10;
            $config['total_rows'] = QuoteRequest::count(array('conditions' => array('user_id=? AND  (status = 1 OR status =2)', $this->ion_auth->user()->row()->id)));
            $config['base_url'] = base_url('my-bookings');
            $page = (null !== $this->input->get('page')) ? $this->input->get('page') : 1;
            $start_index = ($page - 1) * $config['per_page'];

            $this->data['title'] = 'Ongoing Bookings';
            $this->data['pagination'] = $this->custom_pagination->create_frontend_pagination($config);
            $this->data['bookings'] = QuoteRequest::find('all', array('conditions' => array('user_id=? AND  (status = 1 OR status =2)', $this->ion_auth->user()->row()->id), 'limit' => $config['per_page'], 'offset' => $start_index, 'order' => 'created_at desc'));
            $this->template->load('frontend/front_base', 'customer/bookings', $this->data);
        }
    }

    public function booking_history() {
        if (!$this->ion_auth->is_member()) {
            redirect('login');
        } else {
            $config['per_page'] = 10;
            $config['total_rows'] = QuoteRequest::count(array('conditions' => array('user_id=? AND is_delete = 0 AND (status = 0 OR status =3 OR status = 4)', $this->ion_auth->user()->row()->id)));
            $config['base_url'] = base_url('booking-history');
            $page = (null !== $this->input->get('page')) ? $this->input->get('page') : 1;
            $start_index = ($page - 1) * $config['per_page'];

            $this->data['title'] = 'Bookings History';
            $this->data['pagination'] = $this->custom_pagination->create_frontend_pagination($config);
            $this->data['bookings'] = QuoteRequest::find('all', array('conditions' => array('user_id=? AND is_delete = 0 AND  (status = 0 OR status =3  OR status = 4)', $this->ion_auth->user()->row()->id), 'limit' => $config['per_page'], 'offset' => $start_index, 'order' => 'created_at desc'));
            $this->template->load('frontend/front_base', 'customer/bookings_history', $this->data);
        }
    }

    public function booking_detail($id = null) {
        if (!$this->ion_auth->is_member()) {
            redirect('login');
        } else {


            $request = QuoteRequest::find_by_id($id);
            $chatroom_id = '';
            if ($request->status > 1) {
                $ResponseForProposal = ResponseForProposal::find(array('conditions' => array('status = 1 AND quote_request_id = ?', $request->id)))->id;
                $chatroom_id = ChatRoom::find_by_request_id($ResponseForProposal)->id;
            }


            $this->data['title'] = 'Bookings Details';
            $this->data['booking'] = $request;
            $this->data['chatroom_id'] = $chatroom_id ? $chatroom_id : '';
            $this->template->load('frontend/front_base', 'customer/booking_details', $this->data);
        }
    }

    public function quote_success() {
        $this->data['title'] = 'Quote submitted successfully';
        $this->data['message'] = 'Your request was submitted successfully. You will get quote from service provider soon.';
        $this->template->load('frontend/front_base', 'common/success_page', $this->data);
    }

    public function cancel_request() {
        $this->form_validation->set_rules('cancel_request', 'Please select reason for cancel request', 'required|max_length[50]');

        if ($this->form_validation->run() == FALSE) {
            if ($this->input->is_ajax_request()) {

                if (validation_errors()) {

                    print_r(json_encode(array("status" => "error", "message" => validation_errors())));
                }
            }
        } else {
            //print_r($this->input->post()); die;
            $this->data['title'] = 'Bookings Details';
            $id = $this->input->post('id');
            $booking = QuoteRequest::find_by_id($id);
            $booking->update_attributes(array('cancel_request' => $this->input->post('cancel_request'), 'status' => 0));

            $ResponseForProposal = ResponseForProposal::find('all', array('conditions' => array('quote_request_id = ?', $booking->id)));
            $subject = "The service request for the " . ucwords(get_service($booking->service_id)) . " has been canceled by the customer";

            $user = User::find_by_id($this->ion_auth->user()->row()->id);
            foreach ($ResponseForProposal as $row) {

                $recipient = User::find_by_id($row->professional_id);
                foreach ($recipient->user_authentications as $row1) {
                    $device_id = array($row1->device_id);
                    if (!empty($device_id)) {
                        $this->send_notification($device_id, 'The request for a quote from ' . $user->first_name . ' has been canceled.', 'Lead Canceled', $user->first_name, 'lead_canceled');
                    }
                }

                $row->update_attributes(array('status' => 0));
                $data = array(
                    'sp_name' => get_user($row->professional_id)->professionals->company_name,
                    'customer_name' => get_user($booking->user_id)->first_name . ' ' . get_user($booking->user_id)->last_name,
                    'service_name' => ucwords(get_service($booking->service_id)),
                    'date_time' => date('m-d-Y', strtotime($booking->avail_date)) . ' | ' . $booking->avail_time,
                    'location' => $booking->location,
                    'cancel_request' => $booking->cancel_request
                );

                $message = $this->load->view('emails/cancel_request', $data, true);

                $this->custom_email->send(get_user($row->professional_id)->email, "UrbanSense", $subject, $message);
            }

            print_r(json_encode(array("status" => "success", "message" => 'Request cancelled successfully')));
            redirect('booking-detail/' . $id);
        }
    }

    public function checkout($id = null) {
        if (!$this->ion_auth->is_member()) {
            redirect('login');
        } else {
            $chatroom = ChatRoom::find_by_id($id);
            $response = ResponseForProposal::find_by_id($chatroom->request_id);
            $quote = QuoteRequest::find_by_id($response->quote_request_id);

            $price = (int)($chatroom->price);
            $pgcharges = (int)(3.5 + ((1.7/100) * $price));
            $total_charge = $price + $pgcharges;
            $this->data['service'] = get_service($quote->service_id);
            $this->data['price'] = $price;
            $this->data['pgcharges'] = $pgcharges;
            $this->data['total_charge'] = $total_charge;
            $this->data['service_provider'] = User::find_by_id($chatroom->professional_id);
            $this->data['payment_id'] = $this->generate_string();
            $this->data['booking_id'] = $this->generate_booking_id();
            $this->data['required_time'] = $quote->avail_time;
            $this->data['required_date'] = date('m/d/Y', strtotime($quote->avail_date));
            $this->template->load('frontend/front_base', 'customer/checkout', $this->data);
        }
    }

    public function complete($id = null) {
        if (!$this->ion_auth->is_member()) {
            redirect('login');
        } else {
            $chatroom = ChatRoom::find_by_id($id);
            $extra_work = PriceHistory::find(array('select' => 'sum(amount) as total_amount', 'conditions' => array('chatroom_id = ? AND payment_status = ? AND status = 1', $chatroom->id, 'success')));
            $pre_amount = $extra_work->total_amount ? $extra_work->total_amount : 0;
            if ($pre_amount != 0) {
                if ($chatroom->price > $pre_amount) {
                    print_r(json_encode(array("status" => "warning", "message" => 'This request can not be cancelled at this moment. Please try again.')));
                    redirect(base_url('customer-chat/' . $id));
                    //	die;
                } else {

                    $response = ResponseForProposal::find_by_id($chatroom->request_id);
                    //$quote = QuoteRequest::find_by_id($response->quote_request_id);
                    $response->update_attributes(array('request_accept' => 3, 'status' => 1));
                    $request = QuoteRequest::find_by_id($response->quote_request_id);
                    $request->update_attributes(array('status' => 3));
                    //
                    redirect(base_url('customer-chat/' . $id));
                }
            } else {

                $response = ResponseForProposal::find_by_id($chatroom->request_id);
                //$quote = QuoteRequest::find_by_id($response->quote_request_id);
                $response->update_attributes(array('request_accept' => 3, 'status' => 1));
                $request = QuoteRequest::find_by_id($response->quote_request_id);
                $request->update_attributes(array('status' => 3));
                //
                redirect(base_url('customer-chat/' . $id));
            }
        }
    }

    function delete_booking($id = null) {
        if (!$this->ion_auth->is_member()) {
            redirect('login');
        } else {
            $page = $this->input->get('page');
            $booking = QuoteRequest::find_by_id($id);
            $booking->update_attributes(array('is_delete' => 1));
            if ($page != '') {

                redirect(base_url('booking-history?page=' . $page));
            } else {
                redirect(base_url('booking-history'));
            }
        }
    }

    function download_invoice($id = null) {
        if (!$this->ion_auth->is_member()) {
            redirect('login');
        } else {

            $request = QuoteRequest::find_by_id($id);

            $response = ResponseForProposal::find_by_quote_request_id_and_status($request->id, 1);

            $booking = Booking::all(array('conditions' => array('response_for_quote_id = ? AND booked_status = ? ', $response->id, 'success')));

            $this->data['bookings'] = $booking;
            $this->data['professional'] = User::find_by_id($booking[0]->professional_id);

            $html = $this->load->view('emails/invoice', $this->data, true);
            $dompdf = new Dompdf();
            $dompdf->loadHtml(utf8_encode($html));
            // (Optional) Setup the paper size and orientation
            $dompdf->setPaper('A4', 'portrait');
            // Render the HTML as PDF
            $dompdf->render();
            // Output the generated PDF to Browser
            $dompdf->stream();
        }
    }

    public function pay_for_extra_work($id) {
        if (!$this->ion_auth->is_member()) {
            redirect('login');
        } else {
            $chatroom = ChatRoom::find_by_id($id);
            $response = ResponseForProposal::find_by_id($chatroom->request_id);
            $quote = QuoteRequest::find_by_id($response->quote_request_id);
            $booking = Booking::find(array('conditions' => array('booked_status= ? AND chatroom_id = ? AND response_for_quote_id = ?', 'success', $id, $chatroom->request_id)));
            $this->data['extra_work'] = PriceHistory::find(array('select' => 'sum(amount) as total_amount', 'conditions' => array('chatroom_id = ? AND payment_status = ? AND status = 1', $chatroom->id, 'success')));

            $this->data['service'] = get_service($quote->service_id);
            $this->data['location'] = $booking->customer_address;
            $this->data['price'] = $chatroom->price;
            $this->data['service_provider'] = User::find_by_id($chatroom->professional_id);
            $this->data['payment_id'] = $this->generate_string();
            $this->data['booking_id'] = $booking->booking_reference_number;
            $this->data['required_time'] = $quote->avail_time;
            $this->data['required_date'] = date('m/d/Y', strtotime($quote->avail_date));



            $this->template->load('frontend/front_base', 'customer/extra_work_checkout', $this->data);
        }
    }

    public function cancel_extra_payment($id = null) {

        $chatroom = ChatRoom::find_by_id($id);
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

            print_r(json_encode(array("status" => "success", "message" => 'Request cancelled successfully.')));
            redirect('customer-chat/' . $id);
        } else {
            print_r(json_encode(array("status" => "success", "message" => 'Request can not be cancelled at this time. Please try again later.')));
            redirect('customer-chat/' . $id);
        }
    }

}
