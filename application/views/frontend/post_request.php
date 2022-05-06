<!-- ========== MAIN ========== -->
<main id="content" role="main">
   <div class="position-relative u-gradient-half-primary-v1">
      <div class="container u-space-1-top u-space-1-bottom">
         <div class="row align-items-lg-center">
            <div class="col-lg-12 mb-7 mb-lg-0">
               <!-- Info -->
               <h1 class="display-5 font-size-48--md-down text-white font-weight-bold text-center">Request a Quote</h1>
               <p class="text-center text-white"></p>
               <!-- End Info -->
            </div>
         </div>
      </div>
   </div>
   <!-- Contact Content Section -->
   <div class="container u-space-1">
      <div class="w-lg-80 mx-auto">
         <!-- Contacts Form -->
         <form class="js-validate ajax-form" novalidate="novalidate"  action="<?= base_url('PostRequest/post_request') ?>" method="post">
         
            <div class="row">
               <!-- Input -->
               <div class="col-sm-12 mb-12">
                  <div class="js-form-message mb-6">
                     <label class="h6 small d-block text-uppercase">
                     Tell us what you need and we'll introduce you to service providers ready to quote you!
                     <span class="text-danger">*</span>
                     </label>
                     <div class="js-focus-state input-group u-form">
                        <textarea class="form-control u-form__input" rows="4" name="request_details" required="" placeholder="Give us a detailed description of your project" aria-label="Give us a detailed description of your project" data-msg="Please enter your request details." data-error-class="u-has-error" data-success-class="u-has-success"><?= set_value('request_details') ? set_value('request_details') : "" ?></textarea>
                        <?= invalid_error('request_details')?>
                     </div>
                  </div>
               </div>
               <!-- End Input -->
               <!-- Input -->
          
               <!-- End Input -->
               <div class="w-100"></div>

               <!-- Input -->
               <div class="col-sm-6 mb-6">
                  <div class="js-form-message">
                     <label class="h6 small d-block text-uppercase">
                     Select preferred date
                     <span class="text-danger">*</span>
                     </label>
                     <div class="js-focus-state input-group u-form">
                        <input class="form-control u-form__input datepicker" name="avail_date" value="<?= set_value('avail_date') ? set_value('avail_date') : "" ?>" required="" placeholder="Select preferred date" aria-label="avail date" data-msg="Please select a date." data-error-class="u-has-error" data-success-class="u-has-success" type="text" autocomplete="off"  onchange ="change_time(this.value);">
                                       <?= invalid_error('avail_date')?>
                     </div>
                  </div>
               </div>
               <!-- End Input -->
               <!-- Input -->
               <div class="col-sm-6 mb-6">
                  <div class="js-form-message">
                     <label class="h6 small d-block text-uppercase">
                     Select preferred time
                     <span class="text-danger">*</span>
                     </label>
                     <div class="js-focus-state input-group u-form">
                       <select class="form-control u-form__input " name="avail_time" id="avail_time" required="" placeholder="Select preferred time" aria-label="avail time" data-msg="Please select a time." data-error-class="u-has-error" data-success-class="u-has-success" autocomplete="off">
                                         
                        </select>
                        <?= invalid_error('avail_time')?>
                     </div>
                  </div>
               </div>
               <!-- End Input -->
               <div class="w-100"></div>
               <!-- Input -->
               <div class="col-sm-6 mb-6">
                  <div class="js-form-message">
                     <label class="h6 small d-block text-uppercase">
                     Your address 
                     <span class="text-danger">*</span>
                     </label>
                     <div class="js-focus-state input-group u-form">
                        <input class="form-control u-form__input add" name="location" id="my-address" value="<?= @$location ? $location : ''; ?>" required="" placeholder="Enter your location" aria-label="location" data-msg="Please enter your location" data-error-class="u-has-error" data-success-class="u-has-success" type="text" autocomplete="off"  onkeydown="codeAddress();" onkeyup="codeAddress()" >
                                       <?= invalid_error('location')?>
                     </div>
                  </div>
               </div>
               <!-- End Input -->
               <!-- Input -->
               <div class="col-sm-6 mb-6">
                  <div class="js-form-message">
                     <label class="h6 small d-block text-uppercase">
                     Select service that you require
                     <span class="text-danger">*</span>
                     </label>
                     <div class="js-focus-state input-group u-form">
                       <select class="form-control u-form__input select2 select2width" name="service"  required="" aria-label="service" data-msg="Please select a service." data-error-class="u-has-error" data-success-class="u-has-success" autocomplete="off">
                            <option></option> 
                             <?php if (!empty($services)): ?>
                                 <?php foreach ($services as $row): ?>
                                     <option value="<?= $row->slug ?>" <?=  ($service_slug==$row->slug) ? 'selected' : ''; ?>><?= $row->title ?></option>
                                 <?php endforeach; ?>
                             <?php endif; ?>
                         </select>
                        <?= invalid_error('service')?>
                     </div>
                  </div>
               </div>
               <input name="longitude" id="longitude" value="<?= @$longitude ? $longitude : ''; ?>" required="" type="hidden">
               <input name="latitude" id="latitude" required="" value="<?= @$latitude ? $latitude : ''; ?>"  type="hidden">
               <!-- End Input -->
            </div>
            <div class="text-center">
               <button type="submit" class="btn btn-primary u-btn-primary u-btn-wide transition-3d-hover mb-4">Submit</button>
            </div>
         </form>
         <!-- End Contacts Form -->
      </div>
   </div>
   <!-- End Contact Content Section -->
   <div id="stickyBlockEndPoint"></div>
</main>
<!-- ========== END MAIN ========== -->