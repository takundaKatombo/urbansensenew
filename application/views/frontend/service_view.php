 <!-- ========== END HEADER ========== -->
       <main id="content" role="main">
         <div class="container">
    <!--         <div class="row">
               <div class="col-md-6 ">
                  <div id="custom-search-input">
                     <div class="input-group ">
                        <input type="text" class="form-control" placeholder="e.g cleaning service" />
                        <span class="input-group-btn">
                        <button class="btn btn-info " type="button">
                        <i class="fa fa-search"></i>
                        </button>
                        </span>
                     </div>
                  </div>
               </div>
               <div class="col-md-6 ">
                  <div id="custom-search-input">
                     <div class="input-group ">
                        <input type="text" class="form-control" placeholder="e.g Delhi" />
                        <span class="input-group-btn">
                        <button class="btn btn-info" type="button">
                        <i class="fa fa-map-marker"></i>
                        </button>
                        </span>
                     </div>
                  </div>
               </div>
            </div> -->
            <div class="row">
               <div class="col-md-12 ">
                  <div class="card4">
                    
                     <h4> <img class="mr-2 mb-2" src="<?= @get_default_pro_image($this->uri->segment(2)) ?  base_url('uploads/image/').get_default_pro_image($this->uri->segment(2)) : base_url('assets/upload.png'); ?>" width="35" height="35">
                          <?= $user->professionals->company_name; ?></h4>
                     <div class="row">
                        <div class="col-md-6 ">
                           <div class="info2">
                              <ul class="ld-contact-info">
                                 <li class="ld-address"><i class="fa fa-map-marker"></i><label><strong>Address: </strong><?= ucfirst($user->professionals->address); ?></label></li>
                                 <li class="ld-cell"><i class="fa fa-phone"></i><label><strong>Mobile: </strong><a id="lnkBEE" href="#" data-toggle="modal" data-target="#myModal" >0*********</a></label></li>
                                 <li><i class="fa fa-envelope"></i><label><strong>Email: </strong><a id="lnkBEE" href="#" data-toggle="modal" data-target="#myModal" >Click here to send an enquiry by email</a></label></li>
                              </ul>
                           </div>
                        </div>
                        <div class="col-md-6 ">
                           <!-- Blue -->
                           <h5><strong>Ratings </strong></h5>
                           <div class="row">
                              <div class="col-md-3"> Professionalism </div>
                              <div class="col-md-9">
                                 <div class="progress mb-3"> 
                                    <div class="progress-bar <?= get_review_color($reviews->professionalism)?>" style="width:<?= ($reviews->professionalism)*20 ?>%"></div>
                                 </div>
                              </div>
                           </div>

                           <!-- Blue -->
                           <div class="row">
                              <div class="col-md-3"> Knowledge </div>
                              <div class="col-md-9">
                                 <div class="progress mb-3"> 
                                    <div class="progress-bar  <?= get_review_color($reviews->knowledge)?>" style="width:<?= ($reviews->knowledge)*20 ?>%"></div>
                                 </div>
                              </div>
                           </div>


                           <!-- Blue -->
                           <div class="row">
                              <div class="col-md-3"> Cost </div>
                              <div class="col-md-9">
                                 <div class="progress mb-3"> 
                                    <div class="progress-bar <?= get_review_color($reviews->cost)?>" style="width:<?= ($reviews->cost)*20 ?>%"></div>
                                 </div>
                              </div>
                           </div>


                           <!-- Blue -->
                           <div class="row">
                              <div class="col-md-3"> Punctuality </div>
                              <div class="col-md-9">
                                 <div class="progress mb-3"> 
                                    <div class="progress-bar <?= get_review_color($reviews->punctuality)?>" style="width:<?= ($reviews->punctuality)*20 ?>%"></div>
                                 </div>
                              </div>
                           </div>


                           <!-- Blue -->
                           <div class="row">
                              <div class="col-md-3"> Tidiness </div>
                              <div class="col-md-9">
                                 <div class="progress mb-3"> 
                                    <div class="progress-bar <?= get_review_color($reviews->tidiness)?>" style="width:<?= ($reviews->tidiness)*20 ?>%"></div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- Modal -->
                  <div id="myModal" class="modal fade" role="dialog">
                     <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                           <div class="modal-header">
                              <h4 class="modal-title">Request for quote</h4>
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                           </div>
                           <div class="modal-body">
                      <form action="<?= base_url('PostRequest/post_request_individual') ?>" method="post" class="js-validate  ajax-form" novalidate="novalidate">
                           <div class="row">
                              <div class="col-sm-12 mb-2">
                                 <div class="js-form-message">
                                    <div class="js-focus-state input-group u-form">
                                       <textarea class="form-control u-form__input" rows="4" name="request_details" required="" placeholder="Give us a detailed description of your project" aria-label="Give us a detailed description of your project" data-msg="Please enter your request details." data-error-class="u-has-error" data-success-class="u-has-success"><?= set_value('request_details') ? set_value('request_details') : "" ?></textarea>
                                       <?= invalid_error('request_details')?>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-sm-6 mb-2">
                                 <div class="js-form-message">
                                    <div class="js-focus-state input-group u-form ">
                                       <input class="form-control u-form__input datepicker" name="avail_date" value="<?= set_value('avail_date') ? set_value('avail_date') : "" ?>" required="" placeholder="Select preferred date" aria-label="avail date" data-msg="Please select a date." data-error-class="u-has-error" data-success-class="u-has-success" type="text" autocomplete="off"  onchange ="change_time(this.value);">
                                       <?= invalid_error('avail_date')?>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-6 mb-2">
                                 <div class="js-form-message">
                                    <div class="js-focus-state input-group u-form ">
                                       <select class="form-control u-form__input " name="avail_time" id="avail_time"  required="" placeholder="Select preferred time" aria-label="avail time" data-msg="Please select a time." data-error-class="u-has-error" data-success-class="u-has-success" autocomplete="off">
                                          
                                       </select>
                                       <?= invalid_error('avail_time')?>
                                    </div>
                                 </div>
                              </div>
                               <input type="hidden" name="professional_id" value="<?= $this->uri->segment(2); ?>">
                              <div class="col-sm-6 mb-2">
                                 <div class="js-form-message">
                                    <div class="js-focus-state input-group u-form ">
                                       <input class="form-control u-form__input add" name="location" id="my-address" value="<?= @$location ? $location : ''; ?>" required="" placeholder="Enter your location" aria-label="location" data-msg="Please enter your location" data-error-class="u-has-error" data-success-class="u-has-success" type="text" autocomplete="off"  onkeydown="codeAddress();" onkeyup="codeAddress()" >
                                       <?= invalid_error('location')?>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-6 mb-2">

                                 <div class="js-form-message">
                                    <div class="js-focus-state input-group u-form ">

                                        <select class="form-control u-form__input select2" name="service"  required="" aria-label="service" data-msg="Please select a service." data-error-class="u-has-error" data-success-class="u-has-success" autocomplete="off">
                                           <option></option> 
                                            <?php if (!empty($individualservices)): ?>
                                                <?php foreach ($individualservices as $row): ?>
                                                    <option value="<?= slug(get_service($row->service_id)) ?>"  <?=  ($service_slug==slug(get_service($row->service_id))) ? 'selected' : ''; ?>><?= get_service($row->service_id) ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                       <?= invalid_error('service')?>
                                    </div>
                                 </div>
                              </div>
                              <input name="longitude" id="longitude" value="<?= @$longitude ? $longitude : ''; ?>" required="" type="hidden">
                              <input name="latitude" id="latitude" required="" value="<?= @$latitude ? $latitude : ''; ?>"  type="hidden">
                           </div>
                           <button type="submit" class="btn btn-primary u-btn-primary transition-3d-hover">Get Free Quotes</button>
                        </form>
                           </div>
                           <div class="modal-footer">
                              
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <section id="tabs">
               <div class="row">
                  <div class="col-md-8">
                     <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                           <a class="nav-link <?= ($this->input->get('review') =='review') ? '' : 'active show'; ?>" data-toggle="tab" href="#details">Details</a>
                        </li>
                        <li class="nav-item">
                           <a class="nav-link" data-toggle="tab" href="#photos">Photos</a>
                        </li>
                        <li class="nav-item">
                           <a class="nav-link" data-toggle="tab" onclick="initializes(<?= $user->professionals->latitude ?>, <?= $user->professionals->longitude ?>);" href="#location">Location</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link <?= ($this->input->get('review') =='review') ? 'active show' : ''; ?>" data-toggle="tab" href="#review">Reviews</a>
                        </li>
                     </ul>
                     <!-- Tab panes -->
                     <div class="tab-content">
                        <div id="details" class="container tab-pane <?= ($this->input->get('review') =='review') ? '' : 'active show'; ?>">
                         
                         
                           <div class="card4">
                              <h5>About Us</h5>
                              <p><?= $user->professionals->introduction; ?></p>
                              <p><?= $user->professionals->company_detail; ?></p>
                              <h5>We also provide</h5>
                              <p><?php foreach ($user->professional_services as $row) {
                                    echo get_service($row->service_id).', ';
                                    
                                 } ?></p>
                           </div>
                        </div>
                        <div id="photos" class="container tab-pane fade">
                           <br>
                           <section id="gallery">
                              <div class="container">
                                 <div id="image-gallery">
                                    <div class="row mb-3">
                                       <?php foreach ($user->professional_images as $row) { ?>
                                       <div class="col-md-3 image">
                                          <div class="img-wrapper">
                                             <a href="<?= base_url('uploads/image/').$row->image ?>" >
                                                <img src="<?= base_url('uploads/image/').$row->image ?>" class="img-responsive" width="150" height="150">
                                             </a>
                                             <div class="img-overlay">
                                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                             </div>
                                          </div>
                                       </div>
                                       <?php } ?>
                                       
                                    </div>
                                    <!-- End row -->
                                 </div>
                                 <!-- End image gallery -->
                              </div>
                              <!-- End container --> 
                           </section>
                        </div>
                        <div id="location" class="container tab-pane fade">
                           <br>
                           <div class="card4">
                              <div id="map" style="width: 100%; height: 300px;"></div>  
                           </div>
                        </div>
                        <div id="review" class="container tab-pane <?= ($this->input->get('review') =='review') ? 'active show' : 'fade'; ?>">
                           <br>
                           <div class="card4">
                                    <div class="row">
                                       <div class="col-md-12">
                                          <div class="card-header d-flex align-items-center">
                                             <h3 class="h4">Reviews & Ratings</h3>
                                          </div>
                                       </div>
                                    </div>
                                       
                                    <?php if(empty($review_list)) { ?>
                                       <div class="row">
                                          <div class="col-md-12">
                                             <h3 class="h4 pl-2 mt-4 text-center">No reviews found for this service provider</h3>
                                          </div>
                                       </div>
                                    <?php } else { foreach ($review_list as $row) { ?>
                                    <div class="row">
                                       <div class="col-md-12">
                                          <h3 class="h4 pl-2 mt-4"><?= ucwords($row->name); ?></h3>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="pl-4 pr-4 pb-2">
                                             <div class=" mb-1">
                                                <div class="font-size-14">
                                                   Professionalism : 
                                                    <span class="float-right">  
                                                      <?php for ($i=1; $i <=5  ; $i++) { if($i<= $row->professionalism){ 
                                                         echo '<span class="fa fa-star checked" style="color:#f4701a;padding:1px;"></span>';
                                                           } else { 
                                                            echo '<span class="fa fa-star" style="padding:1px;"></span>';
                                                      } } ?> 
                                                   </span>
                                                   
                                                </div>
                                             </div>
                                             <div class=" mb-1">
                                               <div class="font-size-14">
                                                   Knowledge :  
                                                    <span class="float-right">
                                                      <?php for ($i=1; $i <=5  ; $i++) { if($i<= $row->knowledge){ 
                                                         echo '<span class="fa fa-star checked" style="color:#f4701a;padding:1px;"></span>';
                                                           } else { 
                                                            echo '<span class="fa fa-star" style="padding:1px;"></span>';
                                                      } } ?> 
                                                   </span>
                                                   
                                                </div>
                                             </div>
                                             <div class=" mb-1">
                                                <div class="font-size-14">
                                                   Cost : 
                                                    <span class="float-right">
                                                      <?php for ($i=1; $i <=5  ; $i++) { if($i<= $row->cost){ 
                                                         echo '<span class="fa fa-star checked" style="color:#f4701a;padding:1px;"></span>';
                                                           } else { 
                                                            echo '<span class="fa fa-star" style="padding:1px;"></span>';
                                                      } } ?> 
                                                   </span>
                                                   
                                                </div>
                                             </div>
                                             <div class=" mb-1">
                                                <div class="font-size-14">
                                                   Punctuality : 
                                                    <span class="float-right">
                                                      <?php for ($i=1; $i <=5  ; $i++) { if($i<= $row->punctuality){ 
                                                         echo '<span class="fa fa-star checked" style="color:#f4701a;padding:1px;"></span>';
                                                           } else { 
                                                            echo '<span class="fa fa-star" style="padding:1px;"></span>';
                                                      } } ?> 
                                                   </span>
                                                   
                                                </div>
                                             </div>
                                             <div class=" mb-1">
                                                <div class="font-size-14">
                                                   Tidiness : 
                                                   <span class="float-right">
                                                   <?php for ($i=1; $i <=5  ; $i++) { if($i<= $row->tidiness){ 
                                                      echo '<span class="fa fa-star checked" style="color:#f4701a;padding:1px;"></span>';
                                                        } else { 
                                                         echo '<span class="fa fa-star" style="padding:1px;"></span>';
                                                   } } ?> 
                                                   </span>
                                                  
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-md-6 pl-4 pr-4 pb-2">
                                          <p><?= $row->review?></p>
                                       </div>
                                    </div>
                                    <hr>
                                 <?php } } ?>
                                
                           </div>
                           <?= $pagination; ?>
                     </div>
                  </div>
                     
                  </div>
                  <div class="col-md-4">
                     <div class="card4">
                       <center> <a href="<?= base_url('post-request'); ?>" class="btn btn-primary u-btn-primary transition-3d-hover text-center">Get More Free Quotes</a></center>
                       
                     </div>
                  </div>
               </div>
            </section>
         </div>
         </div>
      </main>
     
      <!-- ========== END MAIN CONTENT ========== -->


<style>
  .datepicker{z-index:1151 !important;}

  
</style>

<style>
    .pac-container {
        z-index: 10000 !important;
    }

    $(".select2").select2("readonly", true);
</style>