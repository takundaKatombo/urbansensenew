<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Search
 *
 * @author raakesh
 */
class Search extends API_Controller {

    //put your code here
    function __construct() {
        parent::__construct();
    }

    function services_post() {

        /* if (!$this->is_logged_in()) {

          $message = [
          'status' => FALSE,
          'message' => 'Please log in to perform this action',
          'responseCode' => '0'
          ];
          $this->set_response($message, REST_Controller::HTTP_METHOD_NOT_ALLOWED);
          } else { */

        $request = json_decode($this->input->raw_input_stream);

        if (empty($request->service) OR empty($request->latitude) OR empty($request->longitude) OR empty($request->location)) {

            $message = [
                'status' => FALSE,
                'message' => 'Please provide all the mandatory parameters.',
                'responseCode' => '0'
            ];
            $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
        } else {

            try {
                $service = Service::find_by_id($request->service);
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
                $this->db->having('distance <= 35');
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

                    $location = array('latitude' => $request->latitude, 'longitude' => $request->longitude, 'location' => $request->location);
                    $this->response([
                        'status' => TRUE,
                        'response' => $providers,
                        'location' => $location,
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
                    'message' => "Invalid service requested. Please select the services from provided list and try again.",
                    'responseCode' => '0'
                        ], REST_Controller::HTTP_BAD_REQUEST); // Bad Request (400) being the HTTP response code
            }
        }
        /* } */
    }

    function individual_sp_details_get($id = null) {
        // Users from a data store e.g. database

        $user = User::find_by_id($id);

        /* review rating */
        $reviews = Review::find(array('select' => 'avg(professionalism) as professionalism, avg(knowledge) as knowledge, avg(cost) as cost, avg(punctuality) as punctuality, avg(tidiness) as tidiness', 'conditions' => array('type = ? AND professional_id = ?', 'professional', $id)));

        $review_rating = array(
            'tidiness' => $reviews->tidiness ? number_format($reviews->tidiness, 2) : '0',
            'professionalism' => $reviews->professionalism ? number_format($reviews->professionalism, 2) : '0',
            'knowledge' => $reviews->knowledge ? number_format($reviews->knowledge, 2) : '0',
            'cost' => $reviews->cost ? number_format($reviews->cost, 2) : '0',
            'punctuality' => $reviews->punctuality ? number_format($reviews->punctuality, 2) : '0',
        );



        /* reviews list */
        $review_lists = Review::find('all', array('order' => 'created_at desc', 'conditions' => array('type = ? AND professional_id = ?', 'professional', $id), 'order' => 'created_at desc'));

        $reviews_list = array();
        foreach ($review_lists as $row) {
            $reviews_list[] = array(
                'name' => $row->name,
                'review' => $row->review,
                'professionalism' => $row->professionalism,
                'knowledge' => $row->knowledge,
                'cost' => $row->cost,
                'punctuality' => $row->punctuality,
                'tidiness' => $row->tidiness,
            );
        }


        /* service images */
        $service_images = array();
        foreach ($user->professional_images as $row) {
            $service_images[] = array('id' => $row->id,
                'image' => base_url('uploads/image/') . $row->image
            );
        }

        /* services */

        /* $services = array();
          foreach ($individualservices as $row) {
          $services[] =  get_service($row->service_id) . ', ';
          } */

        $individualservices = ProfessionalService::all(array('conditions' => array('user_id=?', $id)));
        $services = '';
        $service_array = array();
        foreach ($individualservices as $row) {
            $services = get_service($row->service_id) . ',' . $services;
            $service_array[] = array('service_id' => $row->service_id, 'title' => get_service($row->service_id));
        }

        /* provider information */
        $sp_information = array(
            'phone' => $user->phone,
            'email' => $user->email,
            'profile_image' => get_default_pro_image($user->id) ? base_url('uploads/image/') . get_default_pro_image($user->id) : '',
            'city_name' => get_city($user->professionals->city_id),
            'services' => $services,
            'service_array' => $service_array,
            'address' => $user->professionals->address,
            'latitude' => $user->professionals->latitude,
            'longitude' => $user->professionals->longitude,
            'company_name' => $user->professionals->company_name,
            'company_detail' => $user->professionals->company_detail,
            'introduction' => $user->professionals->introduction,
            'services_image' => $service_images,
            'reviews_rating' => $review_rating,
            'review_list' => $reviews_list
        );

        if (!empty($sp_information)) {
            $this->response([
                'status' => TRUE,
                'response' => $sp_information,
                'responseCode' => '1'
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response([
                'status' => FALSE,
                'message' => 'There are no information available for this service provider.',
                'responseCode' => '0'
                    ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        }
    }

}
