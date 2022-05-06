<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Tours
 *
 * @author saurabh
 */
class Settings extends CI_Controller {


    function __construct() {
        parent::__construct();
        if($this->ion_auth->is_admin()){
             return true;
        } else{
            $this->session->set_flashdata("warning",'You must be an administrator to view this page.');
            redirect('logout');
           
            
        }
      
    }

    function index() {     
        $data = array(
            'title'=> 'Settings',
            'setting' => Setting::find('all'),
            'pages' => Page::all(array("conditions" => array('status = ?', 1)))
        );
       // $this->data = array_merge($this->data, $data);
        $this->template->load('admin/admin_base','admin/settings',$data);
    }

    function save_site_name(){

        $this->form_validation->set_rules('site_name', 'site name','required|max_length[250]|trim');

        if ($this->form_validation->run() == FALSE) {

            $data = array(
                'title'=> 'Settings',
                'setting' => Setting::find('all'),
                'pages' => Page::all(array("conditions" => array('status = ?', 1)))
               
             );

            //$this->data = array_merge($this->data, $data);
            $this->template->load('admin/admin_base','admin/settings',$data);

        } else {

            $id = $this->input->post('id');

            if(!empty($id)){
                $Setting = Setting::find($id);
                $Setting->update_attributes($this->input->post(NULL, TRUE));
            }else{
                Setting::create($this->input->post(NULL, TRUE));
            }

            redirect(base_url("admin/Settings"));
        }
    }


    function save_phone(){

        $this->form_validation->set_rules('phone', 'support phone','required|trim');

        if ($this->form_validation->run() == FALSE) {

            $data = array(
                'title'=> 'Settings',
                'setting' => Setting::find('all'),
                'pages' => Page::all(array("conditions" => array('status = ?', 1)))
               
            );

           // $this->data = array_merge($this->data, $data);
            $this->template->load('admin/admin_base','admin/settings',$data);

        } else {

            $id = $this->input->post('id');

            if(!empty($id)){
                $Setting = Setting::find($id);
                $Setting->update_attributes($this->input->post(NULL, TRUE));
            }else{
                Setting::create($this->input->post(NULL, TRUE));
            }

           redirect(base_url("admin/Settings"));
        }
    }


    function save_email(){

        $this->form_validation->set_rules('email', 'support email','trim|required|valid_email|max_length[100]');

        if ($this->form_validation->run() == FALSE) {

            $data = array(
                'title'=> 'Settings',
                'setting' => Setting::find('all'),
                'pages' => Page::all(array("conditions" => array('status = ?', 1)))
            );
           // $this->data = array_merge($this->data, $data);

           $this->template->load('admin/admin_base','admin/settings',$data);

        } else {

            $id = $this->input->post('id');

            if(!empty($id)){
                $Setting = Setting::find($id);
                $Setting->update_attributes($this->input->post(NULL, TRUE));
            }else{
                Setting::create($this->input->post(NULL, TRUE));
            }

          redirect(base_url("admin/Settings"));
        }
    }


    function save_terms_conditions(){

        $this->form_validation->set_rules('terms_conditions', 'Terms and condtion','required|trim');

        if ($this->form_validation->run() == FALSE) {

            $data = array(
                'title'=> 'Settings',
                'setting' => Setting::find('all'),
                'pages' => Page::all(array("conditions" => array('status = ?', 1)))
            );
            //$this->data = array_merge($this->data, $data);

            $this->template->load('admin/admin_base','admin/settings',$data);

        } else {

            $id = $this->input->post('id');

            if(!empty($id)){
                $Setting = Setting::find($id);
                $Setting->update_attributes($this->input->post(NULL, TRUE));
            }else{
                Setting::create($this->input->post(NULL, TRUE));
            }

            redirect(base_url("admin/Settings"));
        }
    }



    function save_address(){
        $this->form_validation->set_rules('address', 'Address','trim|required|max_length[500]');

        if ($this->form_validation->run() == FALSE) {

            $data = array(
                'title'=> 'Settings',
                'setting' => Setting::find('all'),
                'pages' => Page::all(array("conditions" => array('status = ?', 1)))
            );
           // $this->data = array_merge($this->data, $data);

           $this->template->load('admin/admin_base','admin/settings',$data);

        } else {

            $id = $this->input->post('id');

            if(!empty($id)){
                $Setting = Setting::find($id);
                $Setting->update_attributes($this->input->post(NULL, TRUE));
            }else{
                Setting::create($this->input->post(NULL, TRUE));
            }

          redirect(base_url("admin/Settings"));
        }
    }


    
    function save_home_about_page(){

        $this->form_validation->set_rules('about_us_id', 'Home About Page','required|trim');

        if ($this->form_validation->run() == FALSE) {

            $data = array(
                'title'=> 'Settings',
                'setting' => Setting::find('all'),
                'pages' => Page::all(array("conditions" => array('status = ?', 1)))
            );
            $this->data = array_merge($this->data, $data);

            $this->template->load('admin/admin_base','admin/settings',$data);

        } else {

            $id = $this->input->post('id');

            if(!empty($id)){
                $Setting = Setting::find($id);
                $Setting->update_attributes($this->input->post(NULL, TRUE));
            }else{
                Setting::create($this->input->post(NULL, TRUE));
            }

           redirect(base_url("admin/Settings"));
        }
    }


    function save_logo(){


            if(!$this->input->post('id')) {

                $data = array(
                    'title' => 'Settings',
                    'setting' => Setting::find('all'),
                    'pages' => Page::all(array("conditions" => array('status = ?', 1)))
                );
               // $this->data = array_merge($this->data, $data);

                $this->template->load('admin/admin_base','admin/settings',$data);
            } else{

               
                $id = $this->input->post('id');  
                $array = array('png','jpg','jpeg','gif');
                $filename= $_FILES["image"]["name"];
                $file_ext = pathinfo($filename,PATHINFO_EXTENSION);
                if(in_array($file_ext, $array )){ 

                    if(!empty($id)){
                        $image = '';
                        $this->load->library('Upload_file');


                        if ($_FILES['image']['name']){ // if  image selected
                            $image= $this->upload_file->optional_image_upload('image');
                        }
                        $Setting = Setting::find_by_id($id);
                        unlink('./uploads/image/'.$Setting->logo);
                        $Setting->update_attributes(array(
                            'logo'   => $image,
                        ));

                    }else{
                        $image = '';
                        $this->load->library('Upload_file');
                        if ($_FILES['image']['name']){ // if  image selected
                            $image= $this->upload_file->optional_image_upload('image');
                        }
                        Setting::create(array(
                            'logo'   => $image,
                        )); 

                    }
                    redirect(base_url("admin/Settings"));
                
            } else {
                $this->session->set_flashdata('warning', 'File format not allowed. Upload only png, jpg, jpeg and gif file');
                redirect('admin/Settings/');
            }    

        } 
        
    }
    
}
