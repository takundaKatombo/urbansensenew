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
class CustomerChat extends API_Controller {

    function __construct() {
       
        parent::__construct();
    }

    public function customer_chatroom_get(){
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
            $chat_rooms = ChatRoom::find('all',array('conditions'=>array('customer_id = ?',$user->id), 'order' => 'updated_at desc'));

            $contacts = array();
            $chat = array();
            foreach ($chat_rooms as $row) {
                $chat[] = array('id'=>$row->id);
                //$price = (int)ceil($row->price);
                $price = (int)($row->price + 3.5 + ((1.7/100) * $row->price));
                $contacts[] = array(
                    'chatroomid' => $row->id,
                    'service_provider' => Professional::find_by_user_id($row->professional_id)->company_name,
                    'image' => base_url('uploads/image/').get_default_pro_image($row->professional_id),
                    'price'     => $price,
                    'created_at'    => $row->created_at,
                    'message'   => Chat::last(array('conditions'=>array('chat_room_id = ?',$row->id)))->message,
                    'is_view' => Chat::last(array('conditions'=>array('chat_room_id = ?',$row->id)))->is_view_customer
                );
	        }   	
			
			if ($contacts) {
            $this->response([
                'status' => TRUE,
                'response' => $contacts,
                'responseCode' => '1'
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			} else {
			$this->response([
				'status' => FALSE,
                'message' => 'No chat record was found at this moment',
                'responseCode' => '0'
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			}
        
        }
    }


    public function customerchat_per_chatroom_get($chatroomid){
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


            $chats = Chat::find('all',array('conditions'=>array('chat_room_id = ?',$chatroomid),'order'=>'created_at asc'));

            $pre_amount = PriceHistory::find('all', array('select' => 'sum(amount) as total_amount', 'conditions'=>array('chatroom_id = ? AND payment_status = ? AND status = ?',$chatroomid,'success',1)));
             $workstatus = 0;
             $pre_price = $pre_amount[0]->total_amount ?$pre_amount[0]->total_amount : 0;
             if($pre_price != ''){
                if($pre_price < $request->price){
                     $workstatus = 1;
                } else {
                     $workstatus = 0;
                }
            }


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

            $data = array('is_view_customer'=>1);
            $this->db->where('chat_room_id',$chatroomid);
            $this->db->update('chats',$data);
            
            if ($chats) {
            $this->response([
                'status' => TRUE,
                'response' => $chats,
                'chat_status' =>  $request_status,
                'active' => $active_status,
                'extra_work_status' => $workstatus,
                'responseCode' => '1'
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
            $this->response([
                'status' => FALSE,
                'response' => 'No chat record was found at this moment',
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
            $recipient = User::find_by_id($chatroom->professional_id);
            if ($chat) {

            foreach($recipient->user_authentications as $row){
            $device_id = array($row->device_id);
                if(!empty($device_id)){
                    $this->send_notification($device_id, $user->first_name.' has sent you a new message.', 'New Message', $user->first_name,'message');
                }
            }

            
            $this->response([
                'status' => TRUE,
                'response' => 'Message sent successfully',
                'responseCode' => '1'
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
            $this->response([
                'status' => FALSE,
                'response' => 'Message could not be sent. There could be an internet issue. Please try again.',
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
                    
              if (isset($_FILES['media_file'])){ 
                         
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
                       // 'message' => $this->input->post('message'),
                        'media_file' =>  $imagename,
                        'user_id' => $user->id,
                        'chat_room_id' => $this->input->post('chat_room_id')
                    );

                    $issend =  Chat::create($data);
                } else {
                    $data = array(
                        //'message' => $this->input->post('message'),
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
            
            $chatroom = ChatRoom::find_by_id($this->input->post('chat_room_id'));
            $recipient = User::find_by_id($chatroom->professional_id);
    
               if(!empty($issend)){
                foreach($recipient->user_authentications as $row){
                $device_id = array($row->device_id);
                    if(!empty($device_id)){
                        $this->send_notification($device_id, $user->first_name.' has sent you a new message.', 'New Message', $user->first_name,'message');
                    }
                }
                    

                    $this->response([
                    'status' => TRUE,
                    'response' => 'File sent successfully',
                    'responseCode' => '1'
                        ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                } else {
                    $this->response([
                    'status' => FALSE,
                    'response' => ' File could not be sent. There could be an internet issue. Please try again.',
                    'responseCode' => '0'
                        ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                }
               
            }
        }
    }




}


