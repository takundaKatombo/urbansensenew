
<?php

defined('BASEPATH') or exit('No direct script access allowed');

class CustomerChats extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function chat($id = null)
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('login', 'refresh');
        } else {
            $chat_rooms = ChatRoom::find('all', array('conditions' => array('customer_id = ?', $this->ion_auth->user()->row()->id), 'order' => 'updated_at desc'));

            $contacts = array();
            $chat = array();
            foreach ($chat_rooms as $row) {
                $chat[] = array('id' => $row->id);
                $contacts[] = array(
                    'id' => $row->id,
                    'user' => Professional::find_by_user_id($row->professional_id)->company_name,
                    //'price' => (int)($row->price + 3.5 + ((1.7 / 100) * $row->price)),
                    'price' => $row->price,
                    'created_at' => $row->created_at,
                    'message' => Chat::last(array('conditions' => array('chat_room_id = ?', $row->id), 'select' => 'message, is_view_customer'))
                );
            }

            if (!empty($contacts)) {
                $this->data['contacts'] = $contacts;
                if ($id != null) {
                    $this->data['chatroomid'] = $id;

                    $request = ChatRoom::find_by_id($id);

                    //$this->data['price'] = (int)($request->price + 3.5 + ((1.7 / 100) * $request->price));
                    $this->data['price'] = $request->price;

                    $this->data['professional'] = User::find_by_id($request->professional_id);

                    $this->data['request_status'] = ResponseForProposal::find_by_id($request->request_id)->request_accept;
                    $this->data['active_status'] = ResponseForProposal::find_by_id($request->request_id)->status;
                    //print_r($this->data['active_status']); die;

                    $this->data['chats'] = Chat::find('all', array('conditions' => array('chat_room_id = ?', $id), 'order' => 'created_at asc'));

                    $pre_amount = PriceHistory::find('all', array('select' => 'sum(amount) as total_amount', 'conditions' => array('chatroom_id = ? AND payment_status = ? AND status = ?', $id, 'success', 1)));

                    $workstatus = 0;
                    $pre_price = $pre_amount[0]->total_amount ? $pre_amount[0]->total_amount : 0;
                    if ($pre_price != 0) {
                        if ($pre_price < $request->price) {
                            $workstatus = 1;
                        } else {
                            $workstatus = 0;
                        }
                    }

                    $this->data['extra_work_status'] = $workstatus;

                    $data = array('is_view_customer' => 1);
                    $this->db->where('chat_room_id', $id);
                    $this->db->update('chats', $data);
                } else {

                    $chat_rooms_id = Chat::find(array('conditions' => array('chat_room_id in (?)', $chat), 'order' => 'created_at desc'))->chat_room_id;
                    $this->data['chatroomid'] = $chat_rooms_id;
                    $request = ChatRoom::find_by_id($chat_rooms_id);

                    //$this->data['price'] = (int)($request->price + 3.5 + ((1.7 / 100) * $request->price));
                    $this->data['price'] = $request->price;

                    $this->data['professional'] = User::find_by_id($request->professional_id);

                    $this->data['request_status'] = ResponseForProposal::find_by_id($request->request_id)->request_accept;

                    $this->data['active_status'] = ResponseForProposal::find_by_id($request->request_id)->status;

                    $this->data['chats'] = Chat::find('all', array('conditions' => array('chat_room_id = ?', $chat_rooms_id), 'order' => 'created_at asc'));

                    $pre_amount = PriceHistory::find('all', array('select' => 'sum(amount) as total_amount', 'conditions' => array('chatroom_id = ? AND payment_status = ? AND status = ?', $chat_rooms_id, 'success', 1)));
                    //print_r($pre_amount[0]->total_amount); 
                    $workstatus = 0;
                    $pre_price = $pre_amount[0]->total_amount ? $pre_amount[0]->total_amount : 0;

                    if ($pre_price != 0) {

                        if ($pre_price < $request->price) {
                            $workstatus = 1;
                        } else {
                            $workstatus = 0;
                        }
                    }

                    $this->data['extra_work_status'] = $workstatus;

                    $data = array('is_view_customer' => 1);
                    $this->db->where('chat_room_id = ', $chat_rooms_id);
                    $this->db->update('chats', $data);
                }
            }

            //echo '<pre>';	print_r($this->data['extra_work_status']); die;
            $this->template->load('frontend/front_base', 'customer/customer_chat', $this->data);
        }
    }

    public function send_message()
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('login', 'refresh');
        } else {
            $data = array(
                'message' => $this->input->post('message'),
                'chat_room_id' => $this->input->post('chat_room_id'),
                'user_id' => $this->ion_auth->user()->row()->id
            );
            $chat = Chat::create($data);

            $chatroom = ChatRoom::find_by_id($this->input->post('chat_room_id'));
            $chatroom->update_attributes(array('latest' => 1));
            $name = User::find_by_id($chatroom->professional_id)->professionals->company_name;
            $recipient = User::find_by_id($chatroom->professional_id);


            if ($chat) {

                foreach ($recipient->user_authentications as $row) {
                    $device_id = array($row->device_id);
                    if (!empty($device_id)) {
                        $this->send_notification($device_id, $name . ' has sent you a new message.', 'New Message', $name, 'message');
                    }
                }
                print_r(json_encode(array('status' => 'success', 'message' => 'message send successfully')));
            } else {
                print_r(json_encode(array('status' => 'failed', 'message' => 'message is not send')));
            }
        }
    }

    function upload_media()
    {
        //$this->form_validation->set_rules('media_file', 'Upload Media File', 'required|max_length[250]');
        $this->form_validation->set_rules('message', 'Message', 'max_length[250]');
        if ($this->form_validation->run() == FALSE) {
            if ($this->input->is_ajax_request()) {

                if (validation_errors()) {

                    print_r(json_encode(array("status" => "error", "message" => validation_errors())));
                }
            }
        } else {

            if (isset($_FILES['media_file'])) {
                $user_id = $this->ion_auth->user()->row()->id;
                $ext = pathinfo($_FILES['media_file']['name'], PATHINFO_EXTENSION);
                $imagename = date('dmyhis') . "_" . $user_id . "." . $ext;

                $imagename = $imagename;
                $source = $_FILES['media_file']['tmp_name'];
                $target = "uploads/chat/" . $imagename;
                move_uploaded_file($source, $target);

                $imagepath = $imagename;
                $save = "uploads/chat/" . $imagepath; //This is the new file you saving
                $file = "uploads/chat/" . $imagepath; //This is the original file


                $image_extention = array('jpg', 'jpeg', 'png', 'gif', 'JPG', 'JPEG', 'PNG', 'GIF');
                if (in_array($ext, $image_extention)) {
                    list($width, $height) = getimagesize($file);

                    $tn = imagecreatetruecolor($width, $height);

                    //$image = imagecreatefromjpeg($file);
                    $info = getimagesize($target);
                    if ($info['mime'] == 'image/jpeg') {
                        $image = imagecreatefromjpeg($file);
                    } elseif ($info['mime'] == 'image/gif') {
                        $image = imagecreatefromgif($file);
                    } elseif ($info['mime'] == 'image/png') {
                        $image = imagecreatefrompng($file);
                    } elseif ($info['mime'] == 'image/jpg') {
                        $image = imagecreatefromjpg($file);
                    } elseif ($info['mime'] == 'image/mp4') {
                        $image = imagecreatefrommp4($file);
                    } elseif ($info['mime'] == 'image/flv') {
                        $image = imagecreatefromflv($file);
                    } elseif ($info['mime'] == 'image/avi') {
                        $image = imagecreatefromavi($file);
                    } elseif ($info['mime'] == 'image/mov') {
                        $image = imagecreatefrommov($file);
                    } elseif ($info['mime'] == 'image/wmv') {
                        $image = imagecreatefromwmv($file);
                    } elseif ($info['mime'] == 'image/3gp') {
                        $image = imagecreatefrom3gp($file);
                    }

                    imagecopyresampled($tn, $image, 0, 0, 0, 0, $width, $height, $width, $height);
                    imagejpeg($tn, $save, 60);
                }
                // echo "Large image: ".$imagepath;

                $data = array();
                if (in_array($ext, $image_extention)) {
                    $data = array(
                        'message' => $this->input->post('message'),
                        'media_file' => $imagepath,
                        'user_id' => $this->ion_auth->user()->row()->id,
                        'chat_room_id' => $this->input->post('chat_room_id')
                    );
                } else {
                    $data = array(
                        'message' => $this->input->post('message'),
                        'video_file' => $imagepath,
                        'user_id' => $this->ion_auth->user()->row()->id,
                        'chat_room_id' => $this->input->post('chat_room_id')
                    );
                }

                Chat::create($data);
                $chatroom = ChatRoom::find_by_id($this->input->post('chat_room_id'));
                $name = User::find_by_id($chatroom->customer_id)->first_name;
                $recipient = User::find_by_id($chatroom->professional_id);
                foreach ($recipient->user_authentications as $row) {
                    $device_id = array($row->device_id);
                    if (!empty($device_id)) {
                        $this->send_notification($device_id, $name . ' has sent you a new message.', 'New Message', $name, 'message');
                    }
                }

                print_r(json_encode(array("status" => "destination", "destination" => 'customer-chat/' . $this->input->post('chat_room_id'), 'message' => 'File uploaded successfully')));
            }
        }
    }
}
