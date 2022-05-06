
<!-- ========== MAIN ========== -->

<main id="content" role="main">

   <div class="position-relative u-gradient-half-primary-v1">

      <div class="container u-space-1-top u-space-1-bottom">

         <div class="row align-items-lg-center">

            <div class="col-lg-12 mb-7 mb-lg-0">

               <!-- Info -->

               <h1 class="display-5 font-size-48--md-down text-white font-weight-bold text-center">Reset your password</h1>

               <p class="text-center text-white">Enter your email address below and we'll get you back on track.</p>

               <!-- End Info -->

            </div>

         </div>

      </div>

   </div>

   <!-- Contact Content Section -->
   <div class="container">
   <div class="row no-gutters">

      <div class="col-md-8 col-lg-7 col-xl-6 offset-md-2 offset-lg-2 offset-xl-3 u-space-3 u-space-0--lg">

         <!-- Form -->

         <form class="js-validate mt-5 " method="post" action="<?= base_url('forgot-password') ?>">

            <!-- Title -->

            <!-- End Title -->

            <!-- Input -->

            <div class="js-form-message mb-4">

               <label class="h6 small d-block text-uppercase">Mobile Number</label>

               <div class="js-focus-state input-group u-form">
                  
                  <input class="form-control u-form__input" name="phone" onkeyup="this.value=this.value.replace(/[^\d]/,'')" value="<?= set_value('phone') ? set_value('phone') : "" ?>" required="" placeholder="0825412568" aria-label="jack@walley.com" data-msg="Please enter a valid phone number." data-error-class="u-has-error" data-success-class="u-has-success" type="text">

                  <?= invalid_error('phone') ?>
                  
               </div>

            </div>

            <!-- End Input -->

            <!-- Button -->

            <div class="row align-items-center mb-5">

               <div class="col-4 col-sm-6">

                  <a class="small u-link-muted" href="<?= base_url('login'); ?>">Back to sign in</a>

               </div>

               <div class="col-8 col-sm-6 text-right">

                  <button type="submit" class="btn btn-primary u-btn-primary transition-3d-hover">Request Reset Link</button>

               </div>

            </div>

            <!-- End Button -->

         </form>

         <!-- End Form -->

      </div>

   </div>
   </div>

   <!-- End Contact Content Section -->

   <div id="stickyBlockEndPoint"></div>

</main>

<!-- ========== END MAIN ========== -->