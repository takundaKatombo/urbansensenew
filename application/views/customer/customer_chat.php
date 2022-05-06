<main id="content" role="main">
    <div class="container">

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
                                <a href="<?= base_url('customer-chat/') . $row['id'] ?>">
                                    <div class="chat_list <?= ($row['id'] == $this->uri->segment(2)) ? 'active_chat' : ''; ?>">
                                        <div class="chat_people">
                                            <div class="chat_img"> <?= strtoupper($row['user'][0]); ?> </div>
                                            <div class="chat_ib">
                                                <h5><?= ucwords($row['user']) . ' | Price : ZAR ' . $row['price']; ?> <span class="chat_date"><?= date('M d', strtotime($row['created_at'])) ?></span></h5>
                                                <p class="break-word <?= isset($row['message']->is_view_customer) and ($row['message']->is_view_customer == 0) ? 'font-weight-bold text-dark' : ''; ?> "><?php if ($row['message']) { ?><?= substr($row['message']->message, 0, 95); ?> <?php } ?>. . .</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            <?php  } ?>


                        </div>
                    </div>

                    <div class="mesgs col-md-7">
                        <div class="mb-2 chat_list pb-5">
                            <b><i class="fa fa-comment"></i> Chat - <?= ucfirst($professional->professionals->company_name) . ' | Price : ZAR ' . $price ?></b>

                            <?php if ($extra_work_status == 1) { ?>

                                <a class="btn1 btn-success attachment" id="lnkBEE" href="<?= base_url('pay-for-extra-work/') . $chatroomid ?>">Pay For Extra Work</a>

                                <a class="btn1 btn-danger confirmbox attachment" id="lnkBEE" href="<?= base_url('cancel-extra-payment/') . $chatroomid ?>">Cancel request for extra work</a>

                            <?php } ?>


                            <?php if ($active_status == 1) { ?>
                                <?php if ($request_status < 2) { ?>
                                    <a class="btn1 btn-success attachment" id="lnkBEE" href="<?= base_url('book/service/') . $chatroomid ?>">Book Service</a>
                                <?php } ?>

                                <?php if ($extra_work_status != 1) {
                                    if ($request_status == 2) { ?> <a class="btn1 btn-success confirmbox attachment" id="lnkBEE" href="<?= base_url('complete/') . $chatroomid ?>">Complete the Service</a>
                                <?php }
                                } ?>

                                <?php if ($request_status == 3) { ?> <button type="button" class="btn1 btn-success attachment" id="lnkBEE" href="#" data-toggle="modal" data-target="#completerequestModal">Rate the Service </button>
                                <?php } ?>
                                <?php if ($request_status < 4) { ?>
                                    <button type="button" class="btn1 btn-success attachment" href="#" data-toggle="modal" data-target="#uploadimage" title="Upload Media"><i class="fa fa-paperclip" aria-hidden="true"></i></button>
                                <?php }  ?>

                                <?php if ($request_status == 4) { ?>
                                    <button type="button" class="btn1 btn-success attachment">Service Completed</button>
                                <?php } ?>

                            <?php } else {
                                echo '<button type="button" class="btn1 btn-danger attachment" id="lnkBEE">Cancelled</button>';
                            } ?>

                        </div>


                        <div class="msg_history overflow-auto" id="chat_div" style='overflow:scroll;overflow-x:hidden;max-height:517px;'>
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

                                <div class="mb-10 margins"></div>
                            </div>
                            <div id="sending"></div>
                        </div>
                        <div class="type_msg">
                            <div class="input_msg_write">

                                <input type="text" class="write_msg" id="message" placeholder="Type a message" />
                                <?php if ($active_status == 1) { ?>
                                    <?php if ($request_status < 4) { ?>
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

<script type="text/javascript">
    var objDiv = document.getElementById("chat_div");
    objDiv.scrollTop = objDiv.scrollHeight;
</script>

<!-- Modal -->
<div id="completerequestModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Share your experience with service provider</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 mb-6">
                        <form class="js-validate ajax-form" novalidate="novalidate" action="<?= base_url('customer/Reviews/review') ?>" method="post">
                            <div class="row ">
                                <div class="col-md-4">
                                    <b>Service Provider Ratings</b>
                                    <div class="pro">
                                        <h6 class="h6">Professionalism</h6>
                                    </div>
                                    <div class="pro">
                                        <h3 class="h6">Knowledge</h3>
                                    </div>
                                    <div class="pro">
                                        <h3 class="h6">Service cost</h3>
                                    </div>
                                    <div class="pro">
                                        <h3 class="h6">Punctuality</h3>
                                    </div>
                                    <div class="pro">
                                        <h3 class="h6">Tidiness</h3>
                                    </div>
                                    <hr>
                                    <b>App Rating</b>

                                    <div class="pro">
                                        <h3 class="h6">User friendly</h3>
                                    </div>
                                    <div class="pro">
                                        <h3 class="h6">Interface</h3>
                                    </div>
                                    <div class="pro">
                                        <h3 class="h6">Technical issues</h3>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <b>&nbsp</b><br> <b>&nbsp</b>
                                    <div class="stars">
                                        <input class="star star-5" id="star-5" type="radio" value="5" name="professionalism" required="required" />
                                        <label class="star star-5" for="star-5"></label>
                                        <input class="star star-4" id="star-4" type="radio" value="4" name="professionalism" required="required" />
                                        <label class="star star-4" for="star-4"></label>
                                        <input class="star star-3" id="star-3" type="radio" value="3" name="professionalism" required="required" />
                                        <label class="star star-3" for="star-3"></label>
                                        <input class="star star-2" id="star-2" type="radio" value="2" name="professionalism" required="required" />
                                        <label class="star star-2" for="star-2"></label>
                                        <input class="star star-1" id="star-1" type="radio" value="1" name="professionalism" required="required" />
                                        <label class="star star-1" for="star-1"></label>
                                    </div>
                                    <div class="stars">
                                        <input class="star star-6" id="star-6" type="radio" value="5" name="knowledge" required="required" />
                                        <label class="star star-6" for="star-6"></label>
                                        <input class="star star-7" id="star-7" type="radio" value="4" name="knowledge" required="required" />
                                        <label class="star star-4" for="star-7"></label>
                                        <input class="star star-3" id="star-8" type="radio" value="3" name="knowledge" required="required" />
                                        <label class="star star-3" for="star-8"></label>
                                        <input class="star star-2" id="star-9" type="radio" value="2" name="knowledge" required="required" />
                                        <label class="star star-2" for="star-9"></label>
                                        <input class="star star-0" id="star-10" type="radio" value="1" name="knowledge" required="required" />
                                        <label class="star star-0" for="star-10"></label>
                                    </div>
                                    <div class="stars">
                                        <input class="star star-6" id="star-11" type="radio" value="5" name="cost" />
                                        <label class="star star-6" for="star-11"></label>
                                        <input class="star star-4" id="star-12" type="radio" value="4" name="cost" />
                                        <label class="star star-4" for="star-12"></label>
                                        <input class="star star-3" id="star-13" type="radio" value="3" name="cost" />
                                        <label class="star star-3" for="star-13"></label>
                                        <input class="star star-2" id="star-14" type="radio" value="2" name="cost" />
                                        <label class="star star-2" for="star-14"></label>
                                        <input class="star star-0" id="star-15" type="radio" value="1" name="cost" />
                                        <label class="star star-0" for="star-15"></label>
                                    </div>
                                    <div class="stars">
                                        <input class="star star-6" id="star-16" type="radio" value="5" name="punctuality" />
                                        <label class="star star-6" for="star-16"></label>
                                        <input class="star star-4" id="star-17" type="radio" value="4" name="punctuality" />
                                        <label class="star star-4" for="star-17"></label>
                                        <input class="star star-3" id="star-18" type="radio" value="3" name="punctuality" />
                                        <label class="star star-3" for="star-18"></label>
                                        <input class="star star-2" id="star-19" type="radio" value="2" name="punctuality" />
                                        <label class="star star-2" for="star-19"></label>
                                        <input class="star star-0" id="star-20" type="radio" value="1" name="punctuality" />
                                        <label class="star star-0" for="star-20"></label>
                                    </div>
                                    <div class="stars">
                                        <input class="star star-6" id="star-25" type="radio" value="5" name="tidiness" />
                                        <label class="star star-6" for="star-25"></label>
                                        <input class="star star-4" id="star-24" type="radio" value="4" name="tidiness" />
                                        <label class="star star-4" for="star-24"></label>
                                        <input class="star star-3" id="star-23" type="radio" value="3" name="tidiness" />
                                        <label class="star star-3" for="star-23"></label>
                                        <input class="star star-2" id="star-22" type="radio" value="2" name="tidiness" />
                                        <label class="star star-2" for="star-22"></label>
                                        <input class="star star-1" id="star-21" type="radio" value="1" name="tidiness" />
                                        <label class="star star-0" for="star-21"></label>
                                    </div>


                                    <b>&nbsp</b>
                                    <div class="stars">
                                        <input class="star star-6" id="star-30" type="radio" value="5" name="user_friendly" />
                                        <label class="star star-6" for="star-30"></label>
                                        <input class="star star-4" id="star-29" type="radio" value="4" name="user_friendly" />
                                        <label class="star star-4" for="star-29"></label>
                                        <input class="star star-3" id="star-28" type="radio" value="3" name="user_friendly" />
                                        <label class="star star-3" for="star-28"></label>
                                        <input class="star star-2" id="star-27" type="radio" value="2" name="user_friendly" />
                                        <label class="star star-2" for="star-27"></label>
                                        <input class="star star-0" id="star-26" type="radio" value="1" name="user_friendly" />
                                        <label class="star star-0" for="star-26"></label>
                                    </div>
                                    <div class="stars">
                                        <input class="star star-6" id="star-35" type="radio" value="5" name="interface" />
                                        <label class="star star-6" for="star-35"></label>
                                        <input class="star star-4" id="star-34" type="radio" value="4" name="interface" />
                                        <label class="star star-4" for="star-34"></label>
                                        <input class="star star-3" id="star-33" type="radio" value="3" name="interface" />
                                        <label class="star star-3" for="star-33"></label>
                                        <input class="star star-2" id="star-32" type="radio" value="2" name="interface" />
                                        <label class="star star-2" for="star-32"></label>
                                        <input class="star star-0" id="star-31" type="radio" value="1" name="interface" />
                                        <label class="star star-0" for="star-31"></label>
                                    </div>
                                    <div class="stars">
                                        <input class="star star-6" id="star-36" type="radio" value="5" name="technical_issue" />
                                        <label class="star star-6" for="star-36"></label>
                                        <input class="star star-4" id="star-37" type="radio" value="4" name="technical_issue" />
                                        <label class="star star-4" for="star-37"></label>
                                        <input class="star star-3" id="star-38" type="radio" value="3" name="technical_issue" />
                                        <label class="star star-3" for="star-38"></label>
                                        <input class="star star-2" id="star-39" type="radio" value="2" name="technical_issue" />
                                        <label class="star star-2" for="star-39"></label>
                                        <input class="star star-0" id="star-40" type="radio" value="1" name="technical_issue" />
                                        <label class="star star-0" for="star-40"></label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12  mb-2">
                                    <div class="js-form-message">
                                        <label class="h6 small d-block text-uppercase">
                                            Share your experience
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="js-focus-state input-group u-form">
                                            <textarea class="form-control u-form__input" rows="4" name="review" required="" placeholder="Share your experience" aria-label="Share your experience" data-msg="Share your experience" data-error-class="u-has-error" data-success-class="u-has-success"><?= set_value('review') ? set_value('review') : "" ?></textarea>
                                            <?= invalid_error('review') ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="chat_room_id" value="<?= $chatroomid; ?>">
                            <button type="submit" class="btn btn-primary u-btn-primary transition-3d-hover">Complete Request</button>
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
                        <form class="js-validate ajax-form" novalidate="novalidate" onsubmit="return Validate(this);" action="<?= base_url('customer/CustomerChats/upload_media') ?>" method="post" enctype="multipart/form-data">
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
                                        <input type="file" class="upload" class="form-control u-form__input " name="media_file" id="media_file" value="" required='required' placeholder="Please upload your file" aria-label="media_file" data-msg="Please upload your file" data-error-class="u-has-error" data-success-class="u-has-success" autocomplete="off" onchange="ValidateSize(this)">
                                    </div>
                                </div>
                                <center style=" text-align: center;">
                                    <div id="loading"></div>
                                </center>
                            </div>
                    </div>

                    <input type="hidden" name="chat_room_id" value="<?= $chatroomid; ?>">

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