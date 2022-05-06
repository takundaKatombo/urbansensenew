
<div class="content-inner">
<!-- Page Header-->
<header class="page-header">
   <div class="container-fluid">
      <h2 class="no-margin-bottom">Change Password</h2>
   </div>
</header>
 <?php $this->load->view('errors/error'); ?> 
<!-- Dashboard Counts Section-->
<section class="dashboard-counts no-padding-bottom">
   <div class="container-fluid">
   <div class="col-lg-12">
      <div class="card">
         <div class="card-header d-flex align-items-center">
            <h3 class="h4"><?= $title ?></h3>
         </div>
         <div class="card-body">
           <form action="" method="post" enctype="multipart/form-data">
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="title">Old Password</label>
                        <input type="password" name="old" id="old" placeholder="Please enter your old password" value="" class="form-control">
                      </div>
                      
                    <div class="form-group">
                        <label for="title">New Password</label>
                        <input type="password" name="new" id="new" placeholder="Please enter your new password" value="" class="form-control" >
                      </div>
                    <input type="hidden" name="user_id" value="<?= $this->ion_auth->user()->row()->id ?>" id="user_id">
                    <div class="form-group">
                        <label for="title">New Confirm Password</label>
                        <input type="password" name="new_confirm" id="new_confirm" placeholder="Please enter Service" value="" class="form-control" >
                      </div>
                     <button type="submit" class="btn btn-default" id="sub">Change Password</button>
                  </div>
                  
               </div>
            </form>
      </div>
   </div>
</section>