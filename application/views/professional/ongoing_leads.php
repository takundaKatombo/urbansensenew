 <!-- ========== MAIN ========== -->
 <main id="content" role="main">

     <!-- Contact Content Section -->

     <div class="container">
         <?php if ($loggedin_user->verification != 1) { ?>
             <div class="col-md-12" style="margin-top: 8px;">
                 <div class="alert alert-warning">
                     Please update your profile and upload relevant documents for account verification purpose. Only verified profiles are entitled to accept orders and payments. <a href="<?= base_url('edit-profile'); ?>">Click here </a> to proceed. If you've already uploaded all documents, please wait while we verify the details. Your account will be activated to receive requests after successful verification.
                 </div>
             </div>
         <?php } ?>
         <div class="row">
             <div class="col-md-12">
                 <h5 class="book"><?= $title;  ?></h5>
             </div>
         </div>


         <center>
             <a class="btn <?= ($this->uri->segment(1) == 'ongoing-leads') ? 'btn-primary' : 'btn-default' ?>" href="<?= base_url('ongoing-leads'); ?>">All Leads</a>

             <a class="btn <?= ($this->uri->segment(1) == 'today-ongoing-leads') ? 'btn-primary' : 'btn-default' ?>" href="<?= base_url('today-ongoing-leads'); ?>">Today Leads</a>

             <a class="btn <?= ($this->uri->segment(1) == 'yesterday-ongoing-leads') ? 'btn-primary' : 'btn-default' ?>" href="<?= base_url('yesterday-ongoing-leads'); ?>">Yesterday Leads</a>

             <a class="btn <?= ($this->uri->segment(1) == 'current-week-ongoing-leads') ? 'btn-primary' : 'btn-default' ?>" href="<?= base_url('current-week-ongoing-leads'); ?>">Current Week Leads</a>
         </center>


         <div class="row mt-5">
             <?php if (empty($requests)) {  ?>
                 <div class="col-md-12">
                     <div class=" mb-3 ">
                         <h1>
                             <center>NO DATA FOUND</center>
                         </h1>
                     </div>
                 </div>
                 <?php } else {
                    foreach ($requests as $row) { ?>
                     <div class="col-md-6">
                         <div class="card mb-6">
                             <div class="card-body">
                                 <div>Service</div>
                                 <div><?= get_service($row->quote_request->service_id); ?></div>
                                 <hr>
                                 <div>Address</div>
                                 <div><?= $row->quote_request->location; ?></div>
                                 <hr>
                                 <div>Details</div>
                                 <div><?= $row->quote_request->request_details; ?></div>
                                 <hr>
                                 <div>Available Date & Time</div>
                                 <div><?= date('d M Y', strtotime($row->quote_request->avail_date)) . ' | ' . $row->quote_request->avail_time ?></div>
                                 <hr>
                                 <div>Request Date & Time</div>
                                 <div><?= date('d M Y | h:i a', strtotime($row->quote_request->created_at)) ?></div>
                                 <hr>
                                 <div>Status</div>
                                 <div>
                                     <p class="font-size-14">
                                         <?php if ($row->quote_request->status == 0 or $row->status == 0) { ?>
                                             <span class="badge badge-danger">REQUEST CANCELLED</span><?php } else if ($row->quote_request->status == 1) { ?> <span class="badge badge-success">ONGOING REQUEST</span><?php } else { ?><span class="badge badge-info">REQUEST COMPLETED</span><?php } ?> <?= ' | ' . $row->quote_request->cancel_request ?>
                                     </p>
                                 </div>
                                 <hr>


                                 <?php if ($row->quote_request->status == 1) { ?>
                                     <button <?= (@$row->request_accept == 1) ? 'Accepted' : 'onclick="showModal(' . $row->quote_request->user_id . ',' . $row->id . ')"' ?> class="btn btn-primary u-btn-primary transition-3d-hover but1"><?= (@$row->request_accept == 1) ? 'Accepted' : 'Accept'; ?></button>
                                 <?php } ?>

                             </div>
                         </div>
                     </div>
             <?php }
                } ?>

         </div>
         <div class="text-center"><?= $pagination ?></div>
     </div>

     <!-- End Contact Content Section -->

     <div id="stickyBlockEndPoint"></div>
 </main>

 <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <h3 class="modal-title" id="exampleModalLabel">Send your quote detail</h3>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
             </div>
             <div id="modalbody">
                 <div class="modal-body">
                     <form action="<?= base_url('professional/Notifications/send_quote') ?>" method="post" class="js-validate ajax-form" novalidate="novalidate">
                         <div class="row">
                             <div class="col-sm-12 mb-2">
                                 <div class="js-form-message">
                                     <div class="js-focus-state input-group u-form">
                                         <textarea class="form-control u-form__input" rows="4" name="request_details" required="" placeholder="Please write your quote " aria-label="Please write your quote" data-msg="Please write your quote" data-error-class="u-has-error" data-success-class="u-has-success"><?= set_value('request_details') ? set_value('request_details') : "" ?></textarea>
                                         <?= invalid_error('request_details') ?>
                                     </div>
                                 </div>
                             </div>
                             <div class="col-sm-12 mb-2">
                                 <div class="js-form-message">
                                     <div class="js-focus-state input-group u-form">
                                         <input class="form-control u-form__input" value="<?= set_value('price') ? set_value('price') : "" ?>" name="price" required="" placeholder="Please write your price" aria-label="Please write your price" data-msg="Please write your price" data-error-class="u-has-error" data-success-class="u-has-success">
                                         <?= invalid_error('price') ?>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <div id="element"></div>
                         <button type="submit" class="btn btn-primary u-btn-primary transition-3d-hover">Send Quotes</button>
                     </form>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <!-- ========== END MAIN ========== -->