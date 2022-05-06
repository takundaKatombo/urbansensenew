<?php

class Upload_file {

    public function optional_image_upload($value) {
        $ci = & get_instance();
        $ci->load->library('upload');

        $config = [
            'upload_path' => './uploads/' . $value,
            'allowed_types' => 'gif|jpg|png|jpeg',
            'file_ext_tolower' => true,
            'remove_spaces' => true,
            'encrypt_name' => true,
            'max_size' => '5120'
        ];

        $ci->upload->initialize($config);
        if (!$ci->upload->do_upload($value)) {
            $data['image_file'] = $ci->upload->display_errors();

            //$this->session->set_flashdata('warning', $ci->upload->display_errors());
            // can not redirect to form page so print below line to show error
             echo "<pre>", print_r($data['image_file']); 
        } else {
            $upload_data = $ci->upload->data();
            //print_r($upload_data); die;
            return $upload_data['file_name'];
        }
    }

}

?>