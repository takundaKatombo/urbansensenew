<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class CancelledInactiveRequest extends MY_Controller{
	
	public function __construct(){
		parent::__construct();
	}

	public function cancelledRequest(){
		$date = date('Y-m-d h:i:s',strtotime("-7 day"));

		$this->db->where('status =', '1');
		$this->db->where('updated_at < ',$date);
	    $request = $this->db->get("quote_requests");
	    if(!empty($request->result())){
	    	foreach ($request->result() as $row) {
		    	$request = QuoteRequest::find_by_id($row->id);
		    	$request->update_attributes(array('status'=> 0, 'cancel_request' => 'Request Timed Out'));

		    	$response = ResponseForProposal::find_by_quote_request_id($row->id);
		    	$response->update_attributes(array('status'=> 0));

		    }
	    }  
	}

}