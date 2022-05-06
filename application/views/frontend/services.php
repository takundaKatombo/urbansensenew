      <!-- ========== MAIN ========== -->
      <main id="content" role="main">
         <div class="position-relative u-gradient-half-primary-v1">
            <div class="container u-space-1-top u-space-1-bottom">
               <div class="row align-items-lg-center">
                  <div class="col-lg-12 mb-7 mb-lg-0">
                     <!-- Info -->
                     <div class="row">
                        <div class="col-md-6">
                           <div class="card6">
                              <h5>Get Quotes from Qualified Service Providers</h5>
                           <form action="<?= base_url('PostRequest/post_request') ?>" method="post" class="js-validate ajax-form" novalidate="novalidate">
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
                              <div class="col-sm-6 mb-2">
                                 <div class="js-form-message">
                                    <div class="js-focus-state input-group u-form ">
                                       <input class="form-control u-form__input " name="location" id="my-address" value="<?= @$location ? $location : ''; ?>" required="" placeholder="Enter your location" aria-label="location" data-msg="Please enter your location" data-error-class="u-has-error" data-success-class="u-has-success" type="text" autocomplete="off"  onkeydown="codeAddress();" onkeyup="codeAddress()" >
                                       <?= invalid_error('location')?>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-6 mb-2">
                                 <div class="js-form-message">
                                    <div class="js-focus-state input-group u-form ">

                                        <select class="form-control u-form__input select2" name="service"  required="" aria-label="service" data-msg="Please select a service." data-error-class="u-has-error" data-success-class="u-has-success" autocomplete="off">
                                           <option></option> 
                                            <?php if (!empty($services_list)): ?>
                                                <?php foreach ($services_list as $row): ?>
                                                    <option value="<?= $row->slug ?>"  <?=  ($service_slug==$row->slug) ? 'selected' : ''; ?>><?= $row->title ?></option>
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
                        </div>
                        <div class="col-md-6">
                     <div class="quotes">
                        <h5>You will get 5 comparable quotes
 on sending the request 
for your job.</h5>
                        <h5>OR</h5>
                        <h5>Select a service provider of your choice below</h5>
                     </div>
                  </div>
                     </div>
                     <!-- End Info -->
                  </div>
               </div>
            </div>
         </div>
         <!-- Contact Content Section -->
         <div class="container u-space-1">
            <div class="row">
               <div class="col-12 col-sm-3">
                  <div class="card">
                     <article class="card-group-item">
                        <header class="card-header">
                            <h6 class="title text-center"> Related Services </h6>
                        </header>
                        <div class="filter-content">
                           <div class="list-group list-group-flush">
                              <?php foreach ($services as $key=> $row) { ?>
                                
                                <a href="<?= base_url('services/').$row['slug'] ?>" class="list-group-item <?= ($service_title->id===$row['id']) ? 'active' : ''; ?>"><span class="float-left round mr-2"> <img src="<?= base_url('uploads/image/').$row['image']; ?>" width="35" height="35"></span> <span class='mt-2'> <?= ucwords($row['title']); ?><span class="float-right badge badge-light round"></span> </a>
                              <?php } ?>
                           </div>
                           <!-- list-group .// -->
                        </div>
                     </article>
                     <!-- card-group-item.// -->
                  </div>
               </div>
               <div class="col-12 col-sm-9">
            <h5 class="service">Best Service Providers for <?= ucwords($service_title->title); ?></h5>
                  <!-- Projects -->
            <?php if(empty($professionals)){?>   
               <div class="alert alert-info alert-dismissible">
                  We are sorry, there are no service providers in your area, we are working on getting more. Please try again later. For a custom request <a href="<?= base_url('send-request'); ?>"><b>Click Here</b></a>
               </div>
            <?php } else { foreach ($professionals as $row) { ?>
             
            
            <div class="card p-5 mb-5">
               <!-- List of Icons -->
               <div class="row justify-content-between align-items-center mb-3">
                  <div class="col-12">
                     <!-- Details -->
                     <div class="d-sm-flex">
                         <img class="u-lg-avatar rounded-circle mb-3 mb-sm-0 mr-3" src="<?= @get_default_pro_image($row->user_id) ?  base_url('uploads/image/').get_default_pro_image($row->user_id) : base_url('assets/upload.png');?>" alt="Image Description">
                        <div class="mr-3">
                           <!-- Title -->
                           <div class="mb-3">
                              <a href="<?= base_url('service-details/').$row->user_id ?>">
                                 <h3 class="h5 mb-1"><?= $row->company_name ?></h3>
                              </a>
                              <div class="mb-1"><?= $row->address ?></div>
                              <p class="font-size-14">
                                 Ratings: <i class="fa fa-thumbs-o-up"></i>   
                                 <?php $rating = get_rating($row->user_id); for ($i=1; $i <=5  ; $i++) { if($i<= $rating){ 
                                    echo '<span class="fa fa-star checked" style="color:#f4701a;padding:1px;"></span>';
                                      } else { 
                                       echo '<span class="fa fa-star" style="padding:1px;"></span>';

                                 } } ?> (<?= get_review_count($row->user_id) ?> Reviews)
                                   
                                 
                                 
                                 <br>
                                 <?= word_limiter($row->introduction,20) ?>
                              </p>
                           </div>
                           <!-- End Title -->
                           <div class="d-sm-flex align-items-sm-center">
                              <!-- Budget -->
                          
                              <!-- End Budget -->
                              <!-- Priority -->
                              <div class="pr-4 mb-3 mb-sm-0 mr-4">
                                  <a href="<?= base_url('service-details/').$row->user_id ?>" class="btn btn-primary u-btn-primary u-btn-wide transition-3d-hover mb-4">View Details</a>
                              </div>
                              <!-- End Priority -->
                           </div>
                        </div>
                     </div>
                     <!-- End Details -->
                  </div>
               </div>
               <!-- End List of Icons -->
            </div>
          <?php } } ?>
                  <!-- End Projects -->
               </div>
            </div>
         </div>
         <!-- End Contact Content Section -->
         <div id="stickyBlockEndPoint"></div>
      </main>
      <!-- ========== END MAIN ========== -->