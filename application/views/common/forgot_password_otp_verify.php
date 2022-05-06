 <!-- ========== MAIN CONTENT ========== -->
 <main id="content" role="main">
         <div class="form-pro">
            <div class="container">
               <div class="col-sm-12">
                  <div class="successpage"></div>
                  <div class="imagecorrect">
                     <center>
                        <img src="<?= base_url();?>assets/check-mark.png" alt="">
                        <h1>Congratulations!!</h1>
                        <h3><?= $message; ?></h3>
                     </center>
                  </div>
               </div>
               <div class="col-sm-12">
                  <div class="row no-gutters">

                     <div class="col-md-8 col-lg-7 col-xl-6 offset-md-2 offset-lg-2 offset-xl-3 u-space-3 u-space-0--lg">

                        <!-- Form -->

                        <form class="js-validate mt-5" method="post" action="<?= base_url('forgot-password-otp-verify') ?>">

                           <!-- Title -->

                           <!-- End Title -->

                           <!-- Input -->

                           <div class="js-form-message mb-4">

                              <label class="h6 small d-block text-uppercase">OTP</label>

                              <div class="js-focus-state input-group u-form">
                                 
                                 <input class="form-control u-form__input" name="otp" onkeyup="this.value=this.value.replace(/[^\d]/,'')" value="<?= set_value('otp') ? set_value('otp') : "" ?>" required="" placeholder="65ABC6" aria-label="jack@walley.com" data-msg="Please enter a valid OTP number." data-error-class="u-has-error" data-success-class="u-has-success" type="text">

                                 <?= invalid_error('otp') ?>
                                 
                              </div>

                           </div>

                           <!-- End Input -->

                           <!-- Button -->

                           <div class="row align-items-center mb-5">

                              <div class="col-4 col-sm-6">

                                 <a class="small u-link-muted" href="<?= base_url('resend-otp'); ?>">Resend OTP</a>

                              </div>

                              <div class="col-8 col-sm-6 text-right">

                                 <button type="submit" class="btn btn-primary u-btn-primary transition-3d-hover">Verify OTP</button>

                              </div>

                           </div>

                           <!-- End Button -->

                        </form>

                        <!-- End Form -->

                     </div>
                  </div>

               </div>
            </div>
         </div>
      </main>
      <!-- ========== END MAIN CONTENT ========== -->