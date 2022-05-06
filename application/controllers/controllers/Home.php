<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends MY_Controller {
    public function __construct() {
        parent::__construct();
    }

    public function index() {

        $this->data['title']                  = 'UrbanSense';
        $this->data['services']               = Service::all(array('conditions' => array('status=1'), 'order' => 'title asc'));
        $this->data['categories']             = Category::find('all', array('conditions' => array('make_default = 1')));
        $this->data['reviews']                = Review::find('all', array('conditions' => array('show_on_homepage = 1 AND type =?', 'admin')));
        $this->data['cities']                 = City::all(array('conditions' => array('status=1')));
        $this->data['featured_professionals'] = Professional::all(array('conditions' => array('featured_service_provider =1')));
        $this->template->load('frontend/front_base', 'frontend/home', $this->data);
    }

    /*    public function get_cities(){
    $key=$_GET['key'];
    $this->db->select('*');
    $this->db->from('cities');
    $this->db->like('title', $key);
    $query= $this->db->get()->result_array();
    $result  = array();
    foreach ($query as $row) {
    $result[] = $row['title'];

    }
    print_r(json_encode($result));
    }

    public function get_services(){
    $key=$_GET['key'];
    $this->db->select('*');
    $this->db->from('services');
    $this->db->like('title', $key);
    $query= $this->db->get()->result_array();
    $result  = array();
    foreach ($query as $row) {
    $result[] = $row['title'];

    }
    print_r(json_encode($result));
    }*/

    public function search_services() {
        $user_id                     = $this->get_professional();
        $this->data['title']         = 'Service List';
        $this->data['professionals'] = Professional::all(array('conditions' => array("user_id IN (?)", $user_id)));
        $this->data['services_list'] = Service::all(array('conditions' => array('status=1'), 'order' => 'title asc'));
        //$this->data['categories'] =  $this->get_category();
        $this->data['service_title'] = Service::find_by_slug($this->input->get('service'));
        $this->data['services']      = $this->get_service($this->data['service_title']->category_id);

        delete_cookie('service_slug');
        delete_cookie('location');
        delete_cookie('latitude');
        delete_cookie('longitude');

        set_cookie('service_slug', $this->input->get('service'), '360000');
        set_cookie('location', $this->input->get('location'), '360000');
        set_cookie('latitude', $this->input->get('latitude'), '360000');
        set_cookie('longitude', $this->input->get('longitude'), '360000');

        $this->data['service_slug'] = $this->input->get('service');
        $this->data['location']     = $this->input->get('location');
        $this->data['longitude']    = $this->input->get('longitude');
        $this->data['latitude']     = $this->input->get('latitude');

        if (!empty($this->data['professionals'])) {
            $this->template->load('frontend/front_base', 'frontend/services', $this->data);
        } else {

            $this->data['message'] = 'We are sorry, there are no service providers in your area, we are working on getting more. Please try again later. For a custom request <a  href="' . base_url('send-request') . ' "><b>Click Here</b></a>.<BR>
            <center><a class="btn btn-primary u-btn-primary transition-3d-hover " href="' . base_url() . '">Home</a></center>';
            $this->template->load('frontend/front_base', 'common/failure', $this->data);
        }
    }

    public function get_professional() {

        $lat1       = $this->input->get('latitude');
        $long1      = $this->input->get('longitude');
        $service_id = Service::find_by_slug($this->input->get('service'))->id;

        //print_r($lat1.' '.$long1.''.$service_id);
        if ($service_id and $lat1 != null and $long1 != null) {

            $distance = $this->db->select("professionals.user_id, ( 6371 *
    ACOS(
        COS( RADIANS( latitude ) ) *
        COS( RADIANS( $lat1 ) ) *
        COS( RADIANS( $long1 ) -
        RADIANS( longitude ) ) +
        SIN( RADIANS( latitude ) ) *
        SIN( RADIANS( $lat1) )
    )
)
AS distance");
            $this->db->from('professionals');
            $this->db->join('professional_services', 'professional_services.user_id = professionals.user_id', 'inner');
            $this->db->join('users', 'professionals.user_id = users.id', 'inner');
            $this->db->where('users.verification =1');
            $this->db->where('professional_services.service_id =' . $service_id);
            $this->db->having('distance <= 100');
            $this->db->order_by("distance", "asc");
            $query = $this->db->get()->result_array();
            

            if ($query) {
                $user_ids = array();
                foreach ($query as $row) {
                    $user_ids[] = $row['user_id'];
                }

                if (!empty($user_ids)) {
                    return $user_ids;
                }
            } else {
            }
        }
    }

    /*public function get_service_by_category($category = null){

    $user_id = $this->get_professional();
    $this->data['title'] = 'Service List';
    $this->data['services'] = Professional::all(array('conditions'=>array("user_id IN (?)",$user_id)));
    $this->data['services_list'] = Service::all(array('conditions'=>array('status=1')));
    $this->data['categories'] =  $this->get_category();
    $this->template->load('frontend/front_base','frontend/service_list',$this->data);

    }*/

    function notify_suppliers() {
        //            echo 'here';exit;
        $professionals_ids  = UsersGroup::all(array("select" => "GROUP_CONCAT(user_id) AS professional_ids", "conditions" => array("group_id = ?", 3)));
        $professional_users = User::all(array("select" => "first_name,activation_code,email,last_login,id", "conditions" => array("id IN ({$professionals_ids[0]->professional_ids}) AND verification = 0")));

        //echo '<pre>';print_r(User::connection()->last_query);

        foreach ($professional_users as $user) {
            $mail_temp = array(
                'id'    => $user->id,
                'name'  => $user->first_name,
                'email' => $user->email,
                'key'   => $user->activation_code,
            );
            //print_r($mail_temp) ; die;
            $message = $this->load->view('emails/notify_professionals_for_activation', $mail_temp, TRUE);
            //echo $message;exit;

            require 'vendor/autoload.php'; // If you're using Composer (recommended)
            $email = new \SendGrid\Mail\Mail();
            $email->setFrom("contact@urbansense.com", "UrbanSense");
            $email->setSubject("UrbanSense Account Created");
            $email->addTo("$user->email", "$user->first_name");
            //            $email->addContent("text/plain", "and easy to do anywhere, even with PHP");
            $email->addContent(
                "text/html",
                $message
            );
            //            echo '<pre>';
            //            $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
            $sendgrid = new \SendGrid('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');
            try {
                $response = $sendgrid->send($email);
                //print $response->statusCode() . "\n";
                //print_r($response->headers());
                //print $response->body() . "\n";
                if ($response->statusCode() == 202) {
                    echo "$user->first_name notified successfully";
                }
            } catch (Exception $e) {
                echo 'Caught exception: ' . $e->getMessage() . "\n";
            }
        }
    }
}
