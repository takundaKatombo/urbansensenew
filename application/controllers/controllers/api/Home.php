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
class Home extends API_Controller {

    function __construct() {

        parent::__construct();
    }

    public function all_home_categories_get() {
        // Users from a data store e.g. database
        $result = Category::all(array('conditions' => array('status = ?', 1), 'order' => 'title asc'));
        $categories = array();
        foreach ($result as $row) {
            $categories[] = array(
                'id' => $row->id,
                'title' => $row->title,
                'image' => base_url("uploads/image/$row->image"),
                'slug' => $row->slug,
            );
        }
        if (!empty($categories)) {
            $this->response([
                'status' => TRUE,
                'response' => $categories,
                'responseCode' => '1'
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response([
                'status' => FALSE,
                'message' => 'No categories available. Please come back later.',
                'responseCode' => '0'
                    ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        }
    }

    public function all_home_provider_get() {
        // Users from a data store e.g. database
        $result = Professional::all(array('conditions' => array('featured_service_provider =1')));
        $providers = array();
        foreach ($result as $row) {
            $providers[] = array(
                'userid' => $row->user_id,
                'name' => get_user($row->user_id)->first_name . ' ' . get_user($row->user_id)->last_name,
                'image' => base_url("uploads/image/" . get_default_pro_image($row->user_id)),
                'company_name' => $row->company_name,
                'rating' => get_rating($row->user_id),
                'service_categories' => $row->services($row->user_id),
                'address' => $row->city->title
            );
        }

        if (!empty($providers)) {
            $this->response([
                'status' => TRUE,
                'response' => $providers,
                'responseCode' => '1'
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response([
                'status' => FALSE,
                'message' => 'No featured service providers available. Please come back later.',
                'responseCode' => '0'
                    ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        }
    }

    public function all_home_services_get() {
        // Users from a data store e.g. database
        $result = Service::all(array('conditions' => array('status = ?', 1), 'order' => 'title asc'));

        $services = array();
        foreach ($result as $row) {
            $services[] = array(
                'id' => $row->id,
                'name' => $row->title,
                'image' => base_url("uploads/image/$row->image")
            );
        }
        if (!empty($services)) {
            $this->response([
                'status' => TRUE,
                'response' => $services,
                'responseCode' => '1'
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response([
                'status' => FALSE,
                'message' => 'No services available. Please come back later.',
                'responseCode' => '0'
                    ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        }
    }

    public function services_per_category_get($category_id) {
        // Users from a data store e.g. database
        $result = Service::all(array('conditions' => array('status = 1 AND category_id = ?', $category_id), 'order' => 'title asc'));
        $services = array();
        foreach ($result as $row) {
            $services[] = array(
                'id' => $row->id,
                'name' => $row->title,
                'image' => base_url("uploads/image/$row->image")
            );
        }
        if (!empty($services)) {
            $this->response([
                'status' => TRUE,
                'response' => $services,
                'responseCode' => '1'
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response([
                'status' => FALSE,
                'message' => 'No service is available under this category. Please come back later to check ',
                'responseCode' => '0'
                    ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        }
    }

    public function all_cities_get() {
        // Users from a data store e.g. database
        $result = City::all(array('conditions' => array('status = ?', 1), 'order' => 'title asc'));

        $cities = array();
        foreach ($result as $row) {
            $cities[] = array(
                'id' => $row->id,
                'city_name' => $row->title
            );
        }
        if (!empty($cities)) {
            $this->response([
                'status' => TRUE,
                'response' => $cities,
                'responseCode' => '1'
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response([
                'status' => FALSE,
                'message' => 'No cities available at this moment.',
                'responseCode' => '0'
                    ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        }
    }

    public function sp_per_service_post() {

        $request = json_decode($this->input->raw_input_stream);

        if (empty($request->service_id) OR empty($request->latitude) OR empty($request->longitude)) {

            $message = [
                'status' => FALSE,
                'message' => 'Please provide all the mandatory parameters',
                'responseCode' => '0'
            ];
            $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
        } else {

            try {
                $service = Service::find($request->service_id);
            } catch (\ActiveRecord\ActiveRecordException $ex) {
                $service = NULL;
            }

            if (!empty($service)) {

                $this->db->select('professionals.*, 6371 * 2 * ASIN(SQRT( POWER(SIN((ABS(' . abs($request->latitude) . ') - ABS(professionals.latitude)) * pi()/180 / 2),2) + COS(ABS(' . abs($request->longitude) . ') * pi()/180 ) * COS( abs (professionals.latitude) *pi()/180) * POWER(SIN((ABS(' . abs($request->longitude) . ') - professionals.longitude) *  pi()/180 / 2), 2) )) as distance');
                $this->db->from('professionals');
                $this->db->join('users', 'professionals.user_id = users.id', 'inner');
                $this->db->join('professional_services', 'professional_services.user_id = professionals.user_id', 'inner');
                $this->db->where('professional_services.service_id =' . $service->id);
                $this->db->where('users.verification =1');
                $this->db->having('distance <= 4.5');
                $this->db->order_by("distance", "asc");
                $result = $this->db->get()->result_array();

                if (!empty($result)) {
                    $providers = array();
                    foreach ($result as $row) {
                        $image = get_default_pro_image($row['user_id']);
                        array_push($providers, array("name" => $row['company_name'],
                            "image" => !empty($image) ? base_url("uploads/image/$image") : '', "company_address" => $row['address'],
                            'user_id' => $row['user_id'],
                            'rating' => get_rating($row['user_id']),
                            'review_count' => get_review_count($row['user_id'])));
                    }
                    $this->response([
                        'status' => TRUE,
                        'response' => $providers,
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

                $this->response([
                    'status' => FALSE,
                    'message' => "Invalid service has been provided",
                    'responseCode' => '0'
                        ], REST_Controller::HTTP_BAD_REQUEST); // Bad Request (400) being the HTTP response code
            }
        }
    }

}
