<!-- ========== MAIN ========== -->
<main id="content" role="main">
    <div class="position-relative u-gradient-half-primary-v1">
        <div class="container u-space-1-top u-space-1-bottom">
            <div class="row align-items-lg-center">
                <div class="col-lg-12 mb-7 mb-lg-0">
                    <!-- Info -->
                    <h1 class="display-5 font-size-48--md-down text-white font-weight-bold text-center">Sign In</h1>
                    <p class="text-center text-white">Login to manage your account.</p>
                    <!-- End Info -->
                </div>
            </div>
        </div>
    </div>
    <!-- Contact Content Section -->
    <div class="container">
        <div class="row no-gutters">
            <div class="col-md-8 col-lg-7 col-xl-6 offset-md-2 offset-lg-2 offset-xl-3 u-space-3 u-space-0--lg">

                <center class="mt-20"> <a scope="email" onclick="fb_login();"> <img src="<?= base_url(); ?>assets/facebook-login.png" alt="Login with facebook" class="facebook-login-btn">
                    </a>
                    

                    <?php
                    if (!isset($login_button)) {
                        echo '<h3><a href="' . base_url() . 'google_login/logout">Logout</h3></div>';
                    } else {
                        echo  $login_button;
                    }
                    ?>
                    
                    <a id="appleid-signin" data-color="black" data-border="true" data-type="sign in" class="apple-login-btn"></a>



                </center>


                <script type="text/javascript">
                </script>
                <!-- Form -->
                <form class="mt-5">
                    <!-- Title -->
                    <!-- End Title -->
                    <!-- Input -->
                    <div class="js-form-message mb-4">
                        <label class="h6 small d-block text-uppercase">Email / Phone</label>
                        <div class="js-focus-state input-group u-form">
                            <input class="form-control u-form__input" name="identity" id="identity" placeholder="jack@walley.com" aria-label="jack@walley.com" data-error-class="u-has-error" data-success-class="u-has-success" type="email">
                            <div class="text-danger invalid-feedback" id="emsg" style="display: block; color:#de4437;"></div>
                        </div>
                    </div>
                    <!-- End Input -->
                    <!-- Input -->
                    <div class="js-form-message mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <label class="h6 small d-block text-uppercase">Password</label>
                            <div class="mb-2">
                                <a class="small u-link-muted" href="<?= base_url('forgot-password'); ?>">Forgot Password?</a>
                            </div>
                        </div>
                        <div class="js-focus-state input-group u-form">
                            <input class="form-control u-form__input" name="password" id="password" placeholder="********" aria-label="********" data-error-class="u-has-error" data-success-class="u-has-success" type="password">

                            <div class="text-danger invalid-feedback" id="pmsg" style="display: block;"></div>
                        </div>
                    </div>
                    <!-- End Input -->
                    <!-- Button -->
                    <div class="row align-items-center mb-5">
                        <div class="col-6">
                            <span class="small text-muted">Don't have an account?</span>
                            <a class="small" href="<?= base_url('sign-up') ?>">Sign Up</a>
                        </div>
                        <div class="col-6 text-right">
                            <button type="button" id="login" class="btn btn-primary u-btn-primary transition-3d-hover">Get Started</button>
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