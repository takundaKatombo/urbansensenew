<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends MY_Controller {


	public function page($slug=NULL){	
		$this->data['page'] = Page::find_by_status_and_slug(1,$slug);
		$this->template->load('frontend/front_base','frontend/page',$this->data);

		
	}



}
