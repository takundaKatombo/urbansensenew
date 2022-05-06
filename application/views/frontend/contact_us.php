<!-- ========== MAIN ========== -->
<main id="content" role="main">
   <div class="position-relative u-gradient-half-primary-v1">
      <div class="container u-space-1-top u-space-1-bottom">
         <div class="row align-items-lg-center">
            <div class="col-lg-12 mb-7 mb-lg-0">
               <!-- Info -->
               <h1 class="display-5 font-size-48--md-down text-white font-weight-bold text-center">Got a question?</h1>
               <p class="text-center text-white">We'd love to talk about how we can help you.</p>
               <!-- End Info -->
            </div>
         </div>
      </div>
   </div>
   <!-- Contact Content Section -->
   <div class="clearfix u-space-2">
      <div class="row">
         <div class="col-sm-6 col-lg-3 u-ver-divider u-ver-divider--none-lg">
            <!-- Contacts Info -->
            <div class="text-center py-5">
               <span class="u-icon u-icon-primary--air u-icon--lg rounded-circle mb-4">
               <span class="fa fa-map-marker-alt u-icon__inner"></span>
               </span>
               <h2 class="h6 mb-0">Address</h2>
               <p class="mb-0"><?= $site_data->address; ?></p>
            </div>
            <!-- End Contacts Info -->
         </div>
         <div class="col-sm-6 col-lg-3 u-ver-divider u-ver-divider--none-lg">
            <!-- Contacts Info -->
            <div class="text-center py-5">
               <span class="u-icon u-icon-primary--air u-icon--lg rounded-circle mb-4">
               <span class="fa fa-envelope u-icon__inner"></span>
               </span>
               <h3 class="h6 mb-0">Email</h3>
               <p class="mb-0"><?= $site_data->email; ?></p>
            </div>
            <!-- End Contacts Info -->
         </div>
         <div class="col-sm-6 col-lg-3 u-ver-divider u-ver-divider--none-lg">
            <!-- Contacts Info -->
            <div class="text-center py-5">
               <span class="u-icon u-icon-primary--air u-icon--lg rounded-circle mb-4">
               <span class="fa fa-phone u-icon__inner"></span>
               </span>
               <h3 class="h6 mb-0">Support Number</h3>
               <p class="mb-0"><?= $site_data->phone; ?></p>
            </div>
            <!-- End Contacts Info -->
         </div>
         <div class="col-sm-6 col-lg-3">
            <!-- Contacts Info -->
            <div class="text-center py-5">
               <span class="u-icon u-icon-primary--air u-icon--lg rounded-circle mb-4">
               <span class="fa fa-fax u-icon__inner"></span>
               </span>
               <h3 class="h6 mb-0">Fax</h3>
               <p class="mb-0">+27(0)862625283</p>
            </div>
            <!-- End Contacts Info -->
         </div>
      </div>
   </div>
   <hr class="my-0">
   <div class="container u-space-2">
      <!-- Title -->
      <div class="w-md-80 w-lg-50 text-center mx-auto mb-9">
        
         <h2 class="text-primary font-weight-normal"><span class="font-weight-bold">CONTACT US</span></h2>
         <p></p>
      </div>
      <!-- End Title -->
      <div class="w-lg-80 mx-auto">
         <!-- Contacts Form -->
         <form class="js-validate ajax-form" action="<?= base_url('ContactUs/create') ?>" novalidate="novalidate" method="post">
            <div class="row">
               <!-- Input -->
               <div class="col-sm-6 mb-6">
                  <div class="js-form-message">
                     <label class="h6 small d-block text-uppercase">
                     Your name
                     <span class="text-danger">*</span>
                     </label>
                     <div class="js-focus-state input-group u-form">
                        <input class="form-control u-form__input" name="name" required="" placeholder="Jack Wayley" aria-label="Jack Wayley" value="<?= set_value('name') ? set_value('name') : "" ?>" data-msg="Please enter your name." data-error-class="u-has-error" data-success-class="u-has-success" type="text">
                         <?= invalid_error('name')?>
                     </div>
                  </div>
               </div>
               <!-- End Input -->
               <!-- Input -->
               <div class="col-sm-6 mb-6">
                  <div class="js-form-message">
                     <label class="h6 small d-block text-uppercase">
                     Your email address
                     <span class="text-danger">*</span>
                     </label>
                     <div class="js-focus-state input-group u-form">
                        <input class="form-control u-form__input" name="email" value="<?= set_value('email') ? set_value('email') : "" ?>" required="" placeholder="Email" aria-label="Email" data-msg="Please enter a valid email address." data-error-class="u-has-error" data-success-class="u-has-success" type="email">
                         <?= invalid_error('email')?>
                     </div>
                  </div>
               </div>
               <!-- End Input -->
               <div class="w-100"></div>
               <!-- Input -->
               <div class="col-sm-6 mb-6">
                  <div class="js-form-message">
                     <label class="h6 small d-block text-uppercase">
                     Subject
                     <span class="text-danger">*</span>
                     </label>
                     <div class="js-focus-state input-group u-form">
                        <input class="form-control u-form__input" name="subject" value="<?= set_value('subject') ? set_value('subject') : "" ?>" required="" placeholder="Subject" aria-label="Subject" data-msg="Please enter a subject." data-error-class="u-has-error" data-success-class="u-has-success" type="text">
                         <?= invalid_error('subject')?>
                     </div>
                  </div>
               </div>
               <!-- End Input -->
               <!-- Input -->
               <div class="col-sm-6 mb-6">
                  <div class="js-form-message">
                     <label class="h6 small d-block text-uppercase">
                     Your Phone Number
                     <span class="text-danger">*</span>
                     </label>
                     <div class="js-focus-state input-group u-form">
                        <input class="form-control u-form__input" name="phone" onkeyup="this.value=this.value.replace(/[^\d]/,'')"  value="<?= set_value('phone') ? set_value('phone') : "" ?>" required="" placeholder="Phone" aria-label="Phone" data-msg="Please enter a valid phone number." data-error-class="u-has-error" data-success-class="u-has-success" type="text">
                         <?= invalid_error('phone')?>
                     </div>
                  </div>
               </div>
               <!-- End Input -->
            </div>
            <!-- Input -->
            <div class="js-form-message mb-9">
               <label class="h6 small d-block text-uppercase">
               How can we help you?
               <span class="text-danger">*</span>
               </label>
               <div class="js-focus-state input-group u-form">
                  <textarea class="form-control u-form__input" rows="4" name="message" required="" placeholder="Hi there, I would like to ..." aria-label="Hi there, I would like to ..." data-msg="Please enter your message." data-error-class="u-has-error" data-success-class="u-has-success"><?= set_value('message') ? set_value('message') : "" ?></textarea>
                   <?= invalid_error('message')?>
               </div>
            </div>
            <!-- End Input -->
            <div class="text-center">
               <button type="submit" class="btn btn-primary u-btn-primary u-btn-wide transition-3d-hover mb-4">Submit</button>
               <p class="small">We'll get back to you in 1  - 2 business days.</p>
            </div>
         </form>
         <!-- End Contacts Form -->
      </div>
   </div>
   <!-- End Contact Content Section -->
   <div id="stickyBlockEndPoint"></div>
</main>
<!-- ========== END MAIN ========== -->