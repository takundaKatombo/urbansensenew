<!DOCTYPE html>
<html>
  

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>UrbanSense | Reset Password</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="<?= base_url() ?>assets/admin/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="<?= base_url() ?>assets/admin/font-awesome/css/font-awesome.min.css">
    <!-- Fontastic Custom icon font-->
    <link rel="stylesheet" href="<?= base_url() ?>assets/admin/css/fontastic.css">
    <!-- Google fonts - Poppins -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,700">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="<?= base_url() ?>assets/admin/css/style.default.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="<?= base_url() ?>assets/admin/css/custom.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="<?= base_url('assets/fav.png')?>">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
  </head>
  <body>
    <div class="page login-page">
      <div class="container d-flex align-items-center">
        <div class="form-holder has-shadow">
          <div class="row">
            <!-- Logo & Information Panel-->
            <div class="col-lg-6">
              <div class="info d-flex align-items-center">
                <div class="content">
                  <div class="logo">
                    <h1>UrbanSense</h1>
                  </div>
                  <p>Reset Password</p>
                </div>
              </div>
            </div>
            <!-- Form Panel    -->
            
            <div class="col-lg-6 bg-white">
              <?php $this->load->view('errors/error'); ?> 
            
              <div class="form d-flex align-items-center">
                <div class="content">
                  <form method="post" action="<?= base_url('admin/auth/reset_password')?>" class="form-validate">
                    <div class="form-group">
                      <label for="login-username" class="label-material">New Password</label>
                      <input id="new_password" type="password" name="new_password"  required data-msg="Please enter your username" class="form-control">
                      
                    </div>
                    <div class="form-group">
                      <label for="login-password" class="label-material">Confirm Password</label>
                      <input id="confirm_password" type="password" name="confirm_password" required data-msg="Please enter your password" class="form-control">
                      
                    </div><button type="submit"  class="btn btn-primary">Reset Password</button>
                    <input type="hidden" name="email" value="<?= $email ?>">
                      <input type="hidden" name="id" value="<?= $id ?>">
                        <input type="hidden" name="code" value="<?= $code ?>">
                    <!-- This should be submit button but I replaced it with <a> for demo purposes-->
                  </form>
                  <a href="<?= base_url('admin/auth/forgot_password'); ?>" class="forgot-pass">Forgot Password?</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
     
    </div>
   
   
    <!-- JavaScript files-->
    <script src="<?= base_url() ?>assets/admin/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/admin/popper.js/umd/popper.min.js"> </script>
    <script src="<?= base_url() ?>assets/admin/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>assets/admin/jquery.cookie/jquery.cookie.js"> </script>
    <script src="<?= base_url() ?>assets/admin/chart.js/Chart.min.js"></script>
    <script src="<?= base_url() ?>assets/admin/jquery-validation/jquery.validate.min.js"></script>
    <!-- Main File-->
    <script src="<?= base_url() ?>assets/js/front.js"></script>
  </body>

</html>