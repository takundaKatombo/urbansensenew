
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProviderServices extends MY_Controller {


	public function __construct(){
		parent::__construct();
		
	}

	public function index(){
		if (!$this->ion_auth->logged_in()){
			redirect('login', 'refresh');
		} else {
			$id = $this->data['current_user'];
			$this->data['services'] = ProviderService::all(array('conditions'=>array('user_id =?',$id)));
			$this->template->load('frontend/front_base','professional/services',$this->data);
		}
	}

	public function edit_service(){
		
	}
}