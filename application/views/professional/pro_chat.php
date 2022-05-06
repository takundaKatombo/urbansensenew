<main id="content" role="main">
    <div class="container">
        <?php if ($loggedin_user->verification != 1) { ?>
            <div class="col-md-12" style="margin-top: 8px;">
                <div class="alert alert-warning">
                    Please update your profile and upload relevant documents for account verification purpose. Only verified profiles are entitled to accept orders and payments. <a href="<?= base_url('edit-profile'); ?>">Click here </a> to proceed. If you've already uploaded all documents, please wait while we verify the details. Your account will be activated to receive requests after successful verification.
                </div>
            </div>
        <?php } ?>
        <h4 class="title text-center mt-3"> Chat </h4>
        <div class="messaging">

            <?php if (!empty($contacts)) { ?>
                <div class="inbox_msg">
                    <div class="inbox_people col-md-5">
                        <div class="headind_srch">
                            <div class="recent_heading">
                                <h4>Contacts</h4>
                            </div>
                        </div>
                        <div class="inbox_chat" id="inbox_chat">

                            <?php foreach ($contacts as $key => $row) { ?>
                                <a href="<?= base_url('professional-messages/') . $row['id'] ?>">

                                    <div class="chat_list <?= ($row['id'] == $this->uri->segment(2)) ? 'active_chat' : ''; ?>">
                                        <div class="chat_people">
                                            <div class="chat_img"> <?= strtoupper($row['user'][0]); ?> </div>
                                            <div class="chat_ib">

                                                <h5><?= ucwords($row['user']) . ' | Price : ZAR ' . $row['price']; ?> <span class="chat_date"><?= date('M d', strtotime($row['created_at'])) ?></span></h5>

                                                <p class="break-word <?= ($row['message']->is_view_professional == 0) ? 'font-weight-bold text-dark' : ''; ?> "><?= substr($row['message']->message, 0, 95); ?> . . .</p>

                                            </div>
                                        </div>
                                    </div>
                                </a>
                            <?php  } ?>


                        </div>
                    </div>

                    <div class="mesgs col-md-7">
                        <div class="mb-2 chat_list pb-5">
                            <b><i class="fa fa-comment"></i> Chat - <?= ucfirst($customer_name->first_name) . ' ' . ucfirst($customer_name->last_name) . ' | Price : ZAR ' . $price->price ?>
                                <?php if ($active_status == 1) { ?>
                                    <?= ($request_status->request_accept < 3) ? ' <button type="button" class="btn1 btn-success attachment">Booking Accepted</button>' : ''; ?>

                                    <?php if ($request_status->request_accept == 2) {
                                        echo '<button type="button" class="btn1 btn-info attachment" id="lnkBEE" >Paid</button>';
                                    } else if ($request_status->request_accept > 2) {
                                        echo '<button type="button" class="btn1 btn-success attachment" id="lnkBEE">Completed</button>';
                                    } ?>
                                    <?= ($request_status->request_accept < 4) ? '<button type="button" class="btn1 btn-success attachment" href="#" data-toggle="modal" data-target="#uploadimage" title="Upload Media"><i class="fa fa-paperclip" aria-hidden="true"></i></button>' : ''; ?>

                            </b>
                        <?php } else {
                                    echo '<button type="button" class="btn1 btn-danger attachment" id="lnkBEE">Cancelled</button>';
                                } ?>
                        </div>


                        <div class="msg_history overflow-auto" id="chat_div">
                            <div id="mydiv">
                                <?php foreach ($chats as $row) { ?>
                                    <input type="hidden" class="write_msg" id="chat_room_id" value="<?= $row->chat_room_id; ?>" />
                                    <?php if ($row->user_id == $this->ion_auth->user()->row()->id) { ?>

                                        <?php if ($row->media_file != '') { ?>
                                            <div class="incoming_msg">
                                                <div class="received_msg">
                                                    <div class="received_withd_msg">
                                                        <p class="break-word" style="padding: 15px;"><?= $row->message ?><br><img src="<?= base_url('uploads/chat/') . $row->media_file; ?>" class="mt-1"></p>
                                                        <span class="time_date">
                                                            <?= date('h:i a', strtotime($row->created_at)); ?> | <?= date('M d', strtotime($row->created_at)); ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } else if ($row->video_file != '') { ?>
                                            <div class="incoming_msg">
                                                <div class="received_msg">
                                                    <div class="received_withd_msg">
                                                        <p class="break-word" style="padding: 15px;"><?= $row->message ?><br><a href="<?= base_url('uploads/chat/') . $row->video_file; ?>" class="mt-1" target="_blank"><?= base_url('uploads/chat/') . $row->video_file; ?></a></p>
                                                        <span class="time_date">
                                                            <?= date('h:i a', strtotime($row->created_at)); ?> | <?= date('M d', strtotime($row->created_at)); ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="incoming_msg">
                                                <div class="received_msg">
                                                    <div class="received_withd_msg">
                                                        <p class="break-word"><?= $row->message ?></p>
                                                        <span class="time_date">
                                                            <?= date('h:i a', strtotime($row->created_at)); ?> | <?= date('M d', strtotime($row->created_at)); ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>

                                    <?php } else { ?>
                                        <?php if ($row->media_file != '') { ?>
                                            <div class="outgoing_msg">
                                                <div class="sent_msg">
                                                    <p class="break-word" style="padding: 15px;"><?= $row->message ?><br><img src="<?= base_url('uploads/chat/') . $row->media_file; ?>" class="mt-1"></p>
                                                    <span class="time_date">
                                                        <?= date('h:i a', strtotime($row->created_at)); ?> | <?= date('M d', strtotime($row->created_at)); ?>
                                                    </span>
                                                </div>
                                            </div>
                                        <?php } else if ($row->video_file != '') { ?>
                                            <div class="outgoing_msg">
                                                <div class="sent_msg">
                                                    <p class="break-word" style="padding: 15px;"><?= $row->message ?><br><a href="<?= base_url('uploads/chat/') . $row->video_file; ?>" class="mt-1" target="_blank"><?= base_url('uploads/chat/') . $row->video_file; ?></a></p>
                                                    <span class="time_date">
                                                        <?= date('h:i a', strtotime($row->created_at)); ?> | <?= date('M d', strtotime($row->created_at)); ?>
                                                    </span>
                                                </div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="outgoing_msg">
                                                <div class="sent_msg">
                                                    <p class="break-word"><?= $row->message ?></p>
                                                    <span class="time_date">
                                                        <?= date('h:i a', strtotime($row->created_at)); ?> | <?= date('M d', strtotime($row->created_at)); ?>
                                                    </span>
                                                </div>
                                            </div>
                                        <?php } ?>

                                <?php }
                                } ?>


                            </div>
                            <div id="sending"></div>
                        </div>
                        <div class="type_msg">
                            <div class="input_msg_write">

                                <input type="text" class="write_msg" id="message" placeholder="Type a message" />
                                <?php if ($active_status == 1) { ?>
                                    <?php if ($request_status->request_accept < 4) { ?>
                                        <button class="msg_send_btn" id="send_message" type="button"><i class="fa fa-plane" aria-hidden="true"></i></button>
                                <?php }
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <div class="col-md-12">
                    <div class=" mb-3 ">
                        <h1>
                            <center>NO DATA FOUND</center>
                        </h1>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>
</main>

<!-- Modal -->
<div id="completerequestModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Quotation Price</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 mb-6">
                        <form class="js-validate ajax-form" novalidate="novalidate" action="<?= base_url('professional/Notifications/update_quote') ?>" method="post">
                            <div class="col-md-12 mb-2">
                                <div class="js-form-message">
                                    <label class="h6 small d-block text-uppercase">
                                        Your Quotation
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="js-focus-state input-group u-form">
                                        <textarea class="form-control u-form__input " name="message" id="message" placeholder="Enter your Quotation" required="required" aria-label="price" data-msg="Please enter your message" data-error-class="u-has-error" data-success-class="u-has-success" autocomplete="off"><?= set_value('price') ? set_value('price') : "" ?> </textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mb-4">
                                <div class="js-form-message">
                                    <label class="h6 small d-block text-uppercase">
                                        Price
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="js-focus-state input-group u-form">
                                        <input class="form-control u-form__input " name="price" id="price" value="<?= set_value('price') ? set_value('price') : "" ?>" onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;" required="" placeholder="Enter your price" aria-label="price" data-msg="Please enter your price" data-error-class="u-has-error" data-success-class="u-has-success" type="text" autocomplete="off">
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="chat_room_id" value="<?= $price->id ?>">

                            <div class="col-md-12 mb-2 ">
                                <div class="js-form-message">
                                    <label class="h6 small d-block text-uppercase text-center">
                                        <button type="submit" class="btn btn-primary u-btn-primary transition-3d-hover">Update Quote</button>
                                    </label>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Upload Image Modal  -->
<div id="uploadimage" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Media</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 mb-6">
                        <form class="js-validate ajax-form" novalidate="novalidate" onsubmit="return Validate(this);" action="<?= base_url('professional/ProChats/upload_media') ?>" method="post" enctype="multipart/form-data">
                            <div class="col-md-12 mb-4">
                                <div class="js-form-message">
                                    <label class="h6 small d-block text-uppercase">
                                        Your Message

                                    </label>
                                    <div class="js-focus-state input-group u-form">
                                        <textarea class="form-control u-form__input " name="message" id="message" placeholder="Enter your Message"><?= set_value('message') ? set_value('message') : "" ?> </textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mb-4">
                                <div class="js-form-message">
                                    <label class="h6 small d-block text-uppercase">
                                        Upload File
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="js-focus-state input-group u-form">
                                        <input type="file" class="upload" class="form-control u-form__input " name="media_file" id="media_file" value="" required="" placeholder="Please upload your file" aria-label="media_file" data-msg="Please upload your file" data-error-class="u-has-error" data-success-class="u-has-success" autocomplete="off" onchange="ValidateSize(this)" />

                                    </div>
                                </div>
                                <center>
                                    <div id="loading"></div>
                                </center>
                            </div>

                    </div>


                    <input type="hidden" name="chat_room_id" value="<?= $price->id ?>">

                    <div class="col-md-12 mb-2 ">
                        <div class="js-form-message">
                            <label class="h6 small d-block text-uppercase text-center">
                                <button type="submit" id="send" class="btn btn-primary u-btn-primary transition-3d-hover">Send</button>
                            </label>
                        </div>
                    </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<script type="text/javascript">
    var objDiv = document.getElementById("chat_div");
    objDiv.scrollTop = objDiv.scrollHeight;
</script>