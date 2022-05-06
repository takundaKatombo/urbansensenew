  <!-- ========== Main ========== -->
      <main id="content" role="main">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <h5 class="book">Booking Detail</h5>
                 <!--  <button type="button" class="btn btn-success float-left" id="lnkBEE" href="#" data-toggle="modal" data-target="#completerequestModal">Complete Request</button> -->
                 <?php if($booking->status == 1){?> 
                  <button type="button" class="btn btn-danger float-right" id="lnkBEE" href="#" data-toggle="modal" data-target="#myModal">Cancel Request</button> 
                 
              <?php } else if($booking->status == 2){ ?>
                  <a class="btn btn-info float-right confirmbox" id="lnkBEE" href="<?= base_url('complete/').$chatroom_id ?>" >Complete the Service</a>
               <?php if($booking->not_arrived != 1){ ?>   
                  <a class="btn btn-info float-left confirmfornotarrived" id="lnkBEE" href="<?= base_url('not-arrived/').$chatroom_id.'/'.$booking->id ?>" >Not Arrived</a>
               <?php } ?>
                 <?php } else if($booking->status == 3) { ?>
                 <button type="button" class="btn btn-success float-right " id="lnkBEE" href="#" data-toggle="modal" data-target="#completerequestModal">Rate the Service </button>
                 <?php } else if($booking->status == 4) { ?>
                 <button type="button" class="btn btn-success float-right " >Service Completed</button>
                 <?php } ?>
                 
 <a class="btn btn-info float-left confirmfornotarrived" id="lnkBEE" href="<?= base_url('not-arrived/').$chatroom_id.'/'.$booking->id ?>" >Not Arrived</a>
               </div>
            </div>
            <div class="row">
               <div class="col-md-12">
                  <div class="card4">
                     <div class="row service">
                        <div class="col-md-6">
                           <h5>Service</h5>
                           <p class="font-size-14"><?= get_service($booking->service_id)?></p>
                        </div>
                        <div class="col-md-6">
                           <h5>Status</h5>
                            <p class="font-size-14">
                              <?php if($booking->status == 0){ ?> 
                                 <span class="badge badge-danger">REQUEST CANCELLED</span>
                              <?php } else if($booking->status == 1){ ?> 
                                 <span class="badge badge-success">ONGOING REQUEST</span>
                              <?php } else if($booking->status == 2){ ?> 
                                 <span class="badge badge-success">BOOKED</span>
                              <?php } else { ?>
                                 <span class="badge badge-info">REQUEST COMPLETED</span>
                              <?php }?>
                           </p>
                        </div>
                     </div>
                     <div class="row service">
                        <div class="col-md-12">
                           <h5> Service description</h5>
                           <p class="font-size-14"><?= $booking->request_details?></p>
                        </div>
                     </div>
                    
                     <div class="row service">
                        <div class="col-md-6">
                           <h5> Date & Time Posted</h5>
                           <p class="font-size-14"><?= date('d M Y | h:i a',strtotime($booking->created_at))?></p>
                        </div>
                        <div class="col-md-6">
                           <h5>Location</h5>
                           <p class="font-size-14"><?= $booking->location?></p>
                        </div>
                     </div>

                    
                     <div class="row service">
                        <div class="col-md-6">
                           <h5>Service Preferred Date & Time</h5>
                           <p class="font-size-14"><?= date('d M Y',strtotime($booking->avail_date)) .' | '. $booking->avail_time ?></p>
                        </div>
                        <?php if($booking->status > 1){ ?> 
                        <div class="col-md-6">
                           <h5>Download Invoice</h5>
                           <p class="font-size-14"><a href="<?= base_url('customer/Bookings/download_invoice/').$this->uri->segment(2); ?>"><img src="<?= base_url('assets/download.png') ?>" width="150" height="70"></a></p>
                        </div>
                        <?php } ?>
                     </div>
                  </div>
               </div>
            

            </div>
            
         </div>
      </main>


      <!-- Modal -->
      <div id="myModal" class="modal fade" role="dialog">
         <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
               <div class="modal-header">
                  <h4 class="modal-title">Cancel Request</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <div class="modal-body">
          <form action="<?= base_url('customer/Bookings/cancel_request') ?>" method="post" class="js-validate " novalidate="novalidate">
              
               <div class="row">
                  <div class="col-sm-12 mb-6">
                     <div class="js-form-message">
                        
                        <div class="js-focus-state input-group u-form">
                           <input name="cancel_request" class="mr-2 cancel_request" value="Place request by mistake"  type="radio"> Place request by mistake
                        </div>

                        <div class="js-focus-state input-group u-form">
                           <input name="cancel_request" class="mr-2 cancel_request" value="Reschedule request" type="radio"> Reschedule request
                        </div>

                        <div class="js-focus-state input-group u-form">
                           <input name="cancel_request" class="mr-2 cancel_request" value="Service cost too high"  type="radio"> Service cost too high
                        </div>

                        <div class="js-focus-state input-group u-form">
                           <input name="cancel_request" class="mr-2 cancel_request" value="Service provider not arrived"  type="radio"> Service provider not arrived
                        </div>

                        <div class="js-focus-state input-group u-form">
                           <input name="cancel_request" class="mr-2 cancel_request" value="Other issue" type="radio"> Other issue
                        </div>
                     </div>
                  </div>
                  <input name="id" id="id" required="" value="<?= $this->uri->segment(2) ?>"  type="hidden">
               </div>
               <button type="submit" class="btn btn-primary u-btn-primary transition-3d-hover">Cancel Request</button>
            </form>
               </div>
               <div class="modal-footer">
                  
               </div>
            </div>
         </div>
      </div>






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
               <form class="js-validate ajax-form" novalidate="novalidate"  action="<?= base_url('customer/Reviews/review') ?>" method="post">
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
               <input class="star star-5" id="star-5" type="radio" value="5" name="professionalism"  required="required" />
               <label class="star star-5" for="star-5"></label>
               <input class="star star-4" id="star-4" type="radio" value="4" name="professionalism" required="required"/>
               <label class="star star-4" for="star-4"></label>
               <input class="star star-3" id="star-3" type="radio" value="3" name="professionalism" required="required"/>
               <label class="star star-3" for="star-3"></label>
               <input class="star star-2" id="star-2" type="radio" value="2" name="professionalism" required="required"/>
               <label class="star star-2" for="star-2"></label>
               <input class="star star-1" id="star-1" type="radio" value="1" name="professionalism" required="required"/>
               <label class="star star-1" for="star-1"></label>
               </div>
               <div class="stars">
               <input class="star star-6" id="star-6" type="radio" value="5" name="knowledge" required="required"/>
               <label class="star star-6" for="star-6"></label>
               <input class="star star-7" id="star-7" type="radio" value="4" name="knowledge" required="required"/>
               <label class="star star-4" for="star-7"></label>
               <input class="star star-3" id="star-8" type="radio" value="3" name="knowledge" required="required"/>
               <label class="star star-3" for="star-8"></label>
               <input class="star star-2" id="star-9" type="radio" value="2" name="knowledge" required="required"/>
               <label class="star star-2" for="star-9"></label>
               <input class="star star-0" id="star-10" type="radio" value="1" name="knowledge" required="required"/>
               <label class="star star-0" for="star-10"></label>
               </div>
               <div class="stars">
               <input class="star star-6" id="star-11" type="radio" value="5" name="cost"/>
               <label class="star star-6" for="star-11"></label>
               <input class="star star-4" id="star-12" type="radio" value="4" name="cost"/>
               <label class="star star-4" for="star-12"></label>
               <input class="star star-3" id="star-13" type="radio" value="3" name="cost"/>
               <label class="star star-3" for="star-13"></label>
               <input class="star star-2" id="star-14" type="radio" value="2" name="cost"/>
               <label class="star star-2" for="star-14"></label>
               <input class="star star-0" id="star-15" type="radio" value="1" name="cost"/>
               <label class="star star-0" for="star-15"></label>
               </div>
               <div class="stars">
               <input class="star star-6" id="star-16" type="radio" value="5" name="punctuality"/>
               <label class="star star-6" for="star-16"></label>
               <input class="star star-4" id="star-17" type="radio" value="4" name="punctuality"/>
               <label class="star star-4" for="star-17"></label>
               <input class="star star-3" id="star-18" type="radio" value="3" name="punctuality"/>
               <label class="star star-3" for="star-18"></label>
               <input class="star star-2" id="star-19" type="radio" value="2" name="punctuality"/>
               <label class="star star-2" for="star-19"></label>
               <input class="star star-0" id="star-20" type="radio" value="1" name="punctuality"/>
               <label class="star star-0" for="star-20"></label>
               </div>
               <div class="stars">
               <input class="star star-6" id="star-25" type="radio" value="5" name="tidiness"/>
               <label class="star star-6" for="star-25"></label>
               <input class="star star-4" id="star-24" type="radio" value="4" name="tidiness"/>
               <label class="star star-4" for="star-24"></label>
               <input class="star star-3" id="star-23" type="radio" value="3" name="tidiness"/>
               <label class="star star-3" for="star-23"></label>
               <input class="star star-2" id="star-22" type="radio" value="2" name="tidiness"/>
               <label class="star star-2" for="star-22"></label>
               <input class="star star-1" id="star-21" type="radio" value="1" name="tidiness"/>
               <label class="star star-0" for="star-21"></label>
               </div>

              
               <b>&nbsp</b>
               <div class="stars">
               <input class="star star-6" id="star-30" type="radio" value="5" name="user_friendly"/>
               <label class="star star-6" for="star-30"></label>
               <input class="star star-4" id="star-29" type="radio" value="4" name="user_friendly"/>
               <label class="star star-4" for="star-29"></label>
               <input class="star star-3" id="star-28" type="radio" value="3" name="user_friendly"/>
               <label class="star star-3" for="star-28"></label>
               <input class="star star-2" id="star-27" type="radio" value="2" name="user_friendly"/>
               <label class="star star-2" for="star-27"></label>
               <input class="star star-0" id="star-26" type="radio" value="1" name="user_friendly"/>
               <label class="star star-0" for="star-26"></label>
               </div>
               <div class="stars">
               <input class="star star-6" id="star-35" type="radio" value="5" name="interface"/>
               <label class="star star-6" for="star-35"></label>
               <input class="star star-4" id="star-34" type="radio" value="4" name="interface"/>
               <label class="star star-4" for="star-34"></label>
               <input class="star star-3" id="star-33" type="radio" value="3" name="interface"/>
               <label class="star star-3" for="star-33"></label>
               <input class="star star-2" id="star-32" type="radio" value="2" name="interface"/>
               <label class="star star-2" for="star-32"></label>
               <input class="star star-0" id="star-31" type="radio" value="1" name="interface"/>
               <label class="star star-0" for="star-31"></label>
               </div>
               <div class="stars">
               <input class="star star-6" id="star-36" type="radio" value="5" name="technical_issue"/>
               <label class="star star-6" for="star-36"></label>
               <input class="star star-4" id="star-37" type="radio" value="4" name="technical_issue"/>
               <label class="star star-4" for="star-37"></label>
               <input class="star star-3" id="star-38" type="radio" value="3" name="technical_issue"/>
               <label class="star star-3" for="star-38"></label>
               <input class="star star-2" id="star-39" type="radio" value="2" name="technical_issue"/>
               <label class="star star-2" for="star-39"></label>
               <input class="star star-0" id="star-40" type="radio" value="1" name="technical_issue"/>
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
               <?= invalid_error('review')?>
               </div>
               </div>
               </div>
               </div>
                 
               <input type="hidden" name="chat_room_id" value="<?= $chatroom_id; ?>">
               <button type="submit" class="btn btn-primary u-btn-primary transition-3d-hover">Complete Request</button>
               </form>    
 
</div>
</div>
</div>
</div>
</div>
</div>
      <!-- ========== END MAIN ========== -->