<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Services extends MY_Controller {

    public function index() {
        $this->data['title'] = 'all categories and services';
        $this->data['category'] = Category::first(array('order' => 'title asc'));
        $this->data['categories'] = $this->get_category();
        if (!empty($this->data['category'])) {
            $this->data['services'] = Service::find('all', array('order' => 'title asc', 'select' => 'id, title, image, slug', 'conditions' => array('status = 1 AND category_id = ? ', $this->data['category']->id)));
        }

        $this->template->load('frontend/front_base', 'frontend/category_service_list', $this->data);
    }

    public function service_detail($id = null) {
        $this->data['title'] = 'Service Details';
        $this->data['user'] = User::find_by_id($id);
        if($this->data['user']){

           // $this->data['services'] = Service::all(array('conditions' => array('status=1'), 'order' => 'title asc'));
            
            $this->data['individualservices'] = ProfessionalService::all(array('conditions' => array('user_id=?',$id)));

            $this->data['reviews'] = Review::find(array('select' => 'avg(professionalism) as professionalism, avg(knowledge) as knowledge, avg(cost) as cost, avg(punctuality) as punctuality, avg(tidiness) as tidiness', 'conditions' => array('type = ? AND professional_id = ?', 'professional', $id)));

            $config['per_page'] = 15;
            $config['total_rows'] = Review::count(array('conditions' => array('type = ? AND professional_id = ?', 'professional', $id)));
            $config['base_url'] = base_url('service-details/' . $id . '?review=review');
            $page = (null !== $this->input->get('page')) ? $this->input->get('page') : 1;
            $start_index = ($page - 1) * $config['per_page'];

            $this->data['review_list'] = Review::find('all', array('order' => 'created_at desc', 'conditions' => array('type = ? AND professional_id = ?', 'professional', $id), 'limit' => $config['per_page'], 'offset' => $start_index, 'order' => 'created_at desc'));
            $this->data['pagination'] = $this->custom_pagination->create_frontend_pagination($config);
            $this->template->load('frontend/front_base', 'frontend/service_view', $this->data);
        } else {
            redirect();
        }
    }

    public function all_service_category($slug = null) {
        $this->data['title'] = 'all categories and services';
        $this->data['category'] = Category::find_by_slug($slug);
        $this->data['categories'] = $this->get_category();
        $this->data['services'] = Service::find('all', array('order' => 'title asc', 'select' => 'id, title, image, slug', 'conditions' => array('status = 1 AND category_id = ? ', $this->data['category']->id)));
        $this->template->load('frontend/front_base', 'frontend/category_service_list', $this->data);
    }

    public function get_service_by_slug($slug = null) {
        $user_id = $this->get_professional($slug);
        $this->data['title'] = 'Service List';
        $this->data['professionals'] = Professional::all(array('conditions' => array("user_id IN (?)", $user_id)));
        $this->data['service_title'] = Service::find_by_slug($slug);
        $this->data['services_list'] = Service::all(array('conditions' => array('status=1'), 'order' => 'title asc'));
        $this->data['services'] = $this->get_service($this->data['service_title']->category_id);
        if(!empty($this->data['professionals'])){
            $this->template->load('frontend/front_base', 'frontend/services', $this->data);
        } else {

            $this->data['message'] = 'We are sorry, there are no service providers in your area, we are working on getting more. Please try again later. For a custom request <a  href="'.base_url('send-request').' "><b>Click Here</b></a>.<BR>
            <center><a class="btn btn-primary u-btn-primary transition-3d-hover " href="'.base_url().'">Home</a></center>';
            $this->template->load('frontend/front_base','common/failure',$this->data);
        }
        
    }

    public function get_professional($slug) {
        $lat1 = $this->data['latitude'];
        $long1 = $this->data['longitude'];

        $service_id = Service::find_by_slug($slug)->id;

        if ($service_id AND $lat1 != null AND $long1 != null) {

            $distance = $this->db->select('professionals.user_id, 6371 * 2 * ASIN(SQRT( POWER(SIN((' . abs($lat1) . ' - abs(professionals.latitude)) * pi()/180 / 2),2) + COS(' . abs($long1) . ' * pi()/180 ) * COS( abs (professionals.latitude) *pi()/180) * POWER(SIN((' . abs($long1) . ' - professionals.longitude) *  pi()/180 / 2), 2) )) as distance');
            $this->db->from('professionals');
            $this->db->join('professional_services', 'professional_services.user_id = professionals.user_id', 'inner');
            $this->db->join('users', 'professionals.user_id = users.id', 'inner');
            $this->db->where('users.verification =1');
            $this->db->where('professional_services.service_id =' . $service_id);
            $this->db->having('distance < 4.5');
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

}
