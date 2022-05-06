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
class ProfessionalChat extends API_Controller {

    function __construct() {
       
        parent::__construct();
    }

    public function professional_chatroom_get(){
    	$request = json_decode($this->input->raw_input_stream);
        $user = $this->is_logged_in();
        if (empty($user)) {

            $message = [
                'status' => FALSE,
                'message' => 'You need to be logged in to perform this action',
                'responseCode' => '0'
            ];
            $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
        } else {
            $chat_rooms = ChatRoom::find('all',array('conditions'=>array('professional_id = ?',$user->id), 'order' => 'updated_at desc'));

            $contacts = array();
            $chat = array();
            foreach ($chat_rooms as $row) {
                $customer = User::find_by_id($row->customer_id);
                $chat[] = array('id'=>$row->id);
                $contacts[] = array(
                    'chatroomid' => $row->id,
                    'customer_name' => $customer->first_name.' '.$customer->last_name,
                    'image' => @$customer->customers->image ?  base_url('uploads/customer_profile/').$customer->customers->image : '',
                    'price'     => $row->price,
                    'created_at'    => $row->created_at,
                    'message'   => Chat::last(array('conditions'=>array('chat_room_id = ?',$row->id)))->message,
                    'is_view' => Chat::last(array('conditions'=>array('chat_room_id = ?',$row->id)))->is_view_professional
                );
	        }   	
			
			if ($contacts) {
            $this->response([
                'status' => TRUE,
                'response' => $contacts,
                'verified' => $user->verification,
                'responseCode' => '1'
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			} else {
			$this->response([
				'status' => FALSE,
                'response' => 'No chat record was found at this moment.',
                'verified' => $user->verification,
                'responseCode' => '0'
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			}
        
        }
    }


    public function professionalchat_per_chatroom_get($chatroomid){
        $request = json_decode($this->input->raw_input_stream);
        $user = $this->is_logged_in();
        if (empty($user)) {

            $message = [
                'status' => FALSE,
                'message' => 'You need to be logged in to perform this action',
                'responseCode' => '0'
            ];
            $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
        } else {
            
           $result = Chat::find('all',array('conditions'=>array('chat_room_id = ?',$chatroomid),'order'=>'created_at asc'));

           $request = ChatRoom::find_by_id($chatroomid);
            $request_status = ResponseForProposal::find_by_id($request->request_id)->request_accept;
            $active_status = ResponseForProposal::find_by_id($request->request_id)->status;

           $chats = array();
           foreach ($result as $row) {

                $chats[] = array(
                        'message' => $row->message ? $row->message : '',
                        'image' => @$row->media_file ? base_url('uploads/chat/').$row->media_file : '',
                        'video' => @$row->video_file ? base_url('uploads/chat/').$row->video_file : '',
                        'thumbnail' =>  @$row->thumbnail ? base_url('uploads/thumbnail/').$row->thumbnail : '',
                        'user_id' => $row->user_id,
                        'date' => $row->created_at
                );                
           }

            $data = array('is_view_professional'=>1);
            $this->db->where('chat_room_id',$chatroomid);
            $this->db->update('chats',$data);
            
            if ($chats) {
            $this->response([
                'status' => TRUE,
                'response' => $chats,
                'chat_status' =>  $request_status,
                'active' => $active_status,
                'verified' => $user->verification,
                'responseCode' => '1'
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
            $this->response([
                'status' => FALSE,
                'response' => 'No chat record was found at this moment.',
                'verified' => $user->verification,
                'responseCode' => '0'
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
        
        }
    }

    public function send_message_post(){
        $request = json_decode($this->input->raw_input_stream);
        $message = $request->message;
        $chatroomid  = $request->chatroomid;
        $user = $this->is_logged_in();
        if (empty($user)) {

            $message = [
                'status' => FALSE,
                'message' => 'You need to be logged in to perform this action',
                'responseCode' => '0'
            ];
            $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
        } else {
            
           $data = array(
                'message' => $message,
                'chat_room_id' =>$chatroomid,
                'user_id' => $user->id

            );
            $chat = Chat::create($data);

            $chatroom = ChatRoom::find_by_id($chatroomid);
            $chatroom->update_attributes(array('latest'=>1));
            
            if ($chat) {

            $recipient = User::find_by_id($chatroom->customer_id);
           
            foreach($recipient->user_authentications as $row){
                $device_id = array($row->device_id);
                if(!empty($device_id)){
                 $this->send_notification( $device_id, $user->professionals->company_name.' has sent you a new message.','New Message', $user->professionals->company_name,'message');
                }
            }
           
            $this->response([
                'status' => TRUE,
                'response' => 'Message sent successfully',
                'verified' => $user->verification,
                'responseCode' => '1'
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
            $this->response([
                'status' => FALSE,
                'response' => 'Message could not be sent. There could be an internet issue. Please try again.',
                'verified' => $user->verification,
                'responseCode' => '0'
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
        
        }
    }


    function send_file_post(){
        $user = $this->is_logged_in();
        if (empty($user)) {

            $message = [
                'status' => FALSE,
                'message' => 'You need to be logged in to perform this action',
                'responseCode' => '0'
            ];
            $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
        } else {
                    
              if (isset ($_FILES['media_file'])){ 
                  // print_r($_FILES); die;
                  $ext = pathinfo($_FILES['media_file']['name'], PATHINFO_EXTENSION);
                    // change name
                  $imagename = date('dmyhis')."_".$user->id."." . $ext;
                  $source = $_FILES['media_file']['tmp_name'];
                  $target = "uploads/chat/".$imagename;
                  move_uploaded_file($source, $target);

                  $imagepath = $imagename;
                  $save = "uploads/chat/" . $imagepath; //This is the new file you saving
                  $file = "uploads/chat/" . $imagepath; //This is the original file

                $ext = pathinfo($imagepath, PATHINFO_EXTENSION);
                $image_extention = array('jpg','jpeg','png','gif');
                if (in_array($ext, $image_extention)){
                  list($width, $height) = getimagesize($file); 

                  $tn = imagecreatetruecolor($width, $height);

                  //$image = imagecreatefromjpeg($file);
                   $info = getimagesize($target);
                  if ($info['mime'] == 'image/jpeg'){
                    $image = imagecreatefromjpeg($file);
                  }elseif ($info['mime'] == 'image/gif'){
                    $image = imagecreatefromgif($file);
                  }elseif ($info['mime'] == 'image/png'){
                    $image = imagecreatefrompng($file);
                  }elseif ($info['mime'] == 'image/jpg'){
                    $image = imagecreatefromjpg($file);
                  }elseif ($info['mime'] == 'image/mp4'){
                    $image = imagecreatefrommp4($file);
                  }elseif ($info['mime'] == 'image/flv'){
                    $image = imagecreatefromflv($file);
                  }elseif ($info['mime'] == 'image/avi'){
                    $image = imagecreatefromavi($file);
                  }elseif ($info['mime'] == 'image/mov'){
                    $image = imagecreatefrommov($file);
                  }elseif ($info['mime'] == 'image/wmv'){
                    $image = imagecreatefromwmv($file);
                  }

                  imagecopyresampled($tn, $image, 0, 0, 0, 0, $width, $height, $width, $height);
                  imagejpeg($tn, $save, 60);
              }
                 // echo "Large image: ".$imagepath;
                
                $data = array();
                if (in_array($ext, $image_extention)){
                     $data = array(
                       // 'message' => $message,
                        'media_file' =>  $imagename,
                        'user_id' => $user->id,
                        'chat_room_id' => $this->input->post('chat_room_id')

                    );

                     $issend =  Chat::create($data);

                } else {
                    $data = array(
                       // 'message' => $message,
                        'video_file' =>  $imagename,
                        'user_id' => $user->id,
                        'chat_room_id' => $this->input->post('chat_room_id')

                    );
                    $issend =  Chat::create($data);

                    $thumbnail = date('dmyhis')."_".$user->id.".jpg";

                   // print_r($_SERVER["DOCUMENT_ROOT"]."/urbansense/uploads/chat/".$issend->video_file); die;
                     //Get one thumbnail from the video
                    $ffmpeg = $this->config->item('ffmpeg_location');
                    $videoFile =base_url("uploads/chat/").$issend->video_file;
                    $imageFile = "uploads/thumbnail/".$thumbnail;
                    $size = "120x90";
                    $getFromSecond = 5;
                   // $cmd = "$ffmpeg -i $videoFile -r 1 -s 120x90 -f image2 -vframes 1 $imageFile";
                   // $cmd = "ffmpeg -i $videoFile -y -f mjpeg -ss 00:00:05 -s 120x90 -vframes 1 -an thumb.jpg 2>&1";
                    $cmd = "ffmpeg -i $videoFile -r 1 -s 120x90 -f image2 -vframes 1 $imageFile";
                    ;
                    $output = exec($cmd.' 2>&1', $output, $return);
                    if($output){

                        $issend->update_attributes(array('thumbnail' => $thumbnail));
                    }
                }
               
               

               if(!empty($issend)){
                    $chatroom = ChatRoom::find_by_id($this->input->post('chat_room_id'));
                    $recipient = User::find_by_id($chatroom->customer_id);
                    foreach($recipient->user_authentications as $row){
                        $device_id = array($row->device_id);
                        if(!empty($device_id)){
                         $this->send_notification( $device_id, $user->professionals->company_name.' has sent you a new message.','New Message', $user->professionals->company_name,'message');
                        }
                    }
                     

                     $this->response([
                   
                    'status' => TRUE,
                    'response' => 'File sent successfully',
                    'verified' => $user->verification,
                    'responseCode' => '1'
                        ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                } else {
                    $this->response([
                    'status' => FALSE,
                    'response' => 'File could not be sent. There could be an internet issue. Please try again.',
                    'verified' => $user->verification,
                    'responseCode' => '0'
                        ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                }
                
            }
        }
    }


    function update_price_post(){
        $request = json_decode($this->input->raw_input_stream);
        $message = $request->message;
        $price = $request->price;
        $chatroomid  = $request->chatroomid;
        $user = $this->is_logged_in();
        if (empty($user)) {

            $message = [
                'status' => FALSE,
                'message' => 'You need to be logged in to update the price',
                'responseCode' => '0'
            ];
            $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
        } else {
            
            
            $chatroom = ChatRoom::find_by_id($chatroomid);
            $data1 = array(
                'price' => $price
            );
            $chatroom->update_attributes($data1);
            $qouterequest = ResponseForProposal::find_by_id($chatroom->request_id);
                if($qouterequest->request_accept == 2){
                    $pre_amount = PriceHistory::find('all', array('select' => 'sum(amount) as total_amount', 'conditions'=>array('chatroom_id = ? AND payment_status = ? AND status = 1',$chatroomid,'success')));
                    if(@$pre_amount[0]->total_amount < $price){
                      //  print_r($pre_amount[0]->total_amount < $price); die;
                        $data3 = array(
                            'chatroom_id' => $chatroomid,
                            'amount' => $price,
                            'currency' => 'ZAR',
                            'payment_status' => 'initiated',
                            'status' => 0,
                        );
                        
                        PriceHistory::create($data3);
                        
                        $data1 = array(
                            'price' => $price,
                            'extra_work' => 1
                        );
                        $chatroom->update_attributes($data1);

                        $data2 = array(
                            'chat_room_id' => $chatroomid,
                            'user_id' => $user->id,
                            'message' => $message
                        );
                        Chat::create($data2);
                        $recipient = User::find_by_id($chatroom->customer_id);
                        
                        $professional =  Professional::find_by_user_id($user->id);

                        foreach($recipient->user_authentications as $row){
                        $device_id = array($row->device_id);
                            if(!empty($device_id)){
                                $this->send_notification($device_id, $professional->company_name.' has updated their price for '.get_service($qouterequest->quote_request->service_id) ,'Price Updated',$professional->company_name,'price_update');
                            }
                        }
                         
                          $this->response([
                            'status' => TRUE,
                            'response' => 'The new price has been updated successfully and the customer has been notified for the same',
                            'verified' => $user->verification,
                            'responseCode' => '1'
                            ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

                    } else {
                         $this->response([
                            'status' => TRUE,
                            'response' => 'Quote price should not be less than previous price.',
                            'verified' => $user->verification,
                            'responseCode' => '1'
                            ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                       
                    } 

                } else {

                $data3 = array(
                    'chatroom_id' => $chatroomid,
                    'amount' => $price,
                    'currency' => 'ZAR',
                    'payment_status' => 'initiated',
                    'status' => 0,
                );
                
                PriceHistory::create($data3);

                $data1 = array(
                    'price' => $price
                );
                $chatroom->update_attributes($data1);

                $data2 = array(
                    'chat_room_id' => $chatroomid,
                    'user_id' => $user->id,
                    'message' => $message
                );
                Chat::create($data2);
                $recipient = User::find_by_id($chatroom->customer_id);
                
                $professional =  Professional::find_by_user_id($user->id);

                foreach($recipient->user_authentications as $row){
                $device_id = array($row->device_id);
                    if(!empty($device_id)){
                        $this->send_notification($device_id, $professional->company_name.' has updated their price for '.get_service($qouterequest->quote_request->service_id) ,'Price Updated',$professional->company_name,'price_update');
                    }
                }
                 
                   $this->response([
                    'status' => TRUE,
                    'response' => 'The new price has been updated successfully and the customer has been notified for the same',
                    'verified' => $user->verification,
                    'responseCode' => '1'
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                }
            }

        }
}




        /*    if($qouterequest->request_accept == 2){
            $data2 = array(
                'chat_room_id' => $chatroomid,
                'user_id' => $user->id,
                'message' => $message
            );
            $chat = Chat::create($data2);
            
            if ($chat) {

            $qouterequest = ResponseForProposal::find_by_id($chatroom->request_id);
            $recipient = User::find_by_id($chatroom->customer_id);
            foreach($recipient->user_authentications as $row){
                $device_id = array($row->device_id);
                if(!empty($device_id)){
                    $this->send_notification($device_id, $user->professionals->company_name.' has updated their price for '.get_service($qouterequest->quote_request->service_id) ,'Price Updated',$user->professionals->company_name,'price_update');
                }
            }
            
                    
            $this->response([
                'status' => TRUE,
                'response' => 'The new price has been updated successfully and the customer has been notified for the same',
                'verified' => $user->verification,
                'responseCode' => '1'
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
            $this->response([
                'status' => FALSE,
                'response' => 'The new price could not be updated. Please try again later.',
                'verified' => $user->verification,
                'responseCode' => '0'
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
        
        }*/
    

