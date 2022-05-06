
<div class="content-inner">
<!-- Page Header-->
<header class="page-header">
   <div class="container-fluid">
      <h2 class="no-margin-bottom">Customer Form</h2>
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
                        <label for="title">First Name</label>
                        <input type="text" name="first_name" id="first_name" placeholder="Please enter your first name" value="<?= @$user ? $user->first_name : @set_value('first_name'); ?>" class="form-control"  required="required" >
                    </div>
                  </div>

                  <div class="col-md-6">
                      <div class="form-group">
                        <label for="title">Last Name</label>
                        <input type="text" name="last_name" id="last_name" placeholder="Please enter your last name" value="<?= @$user ? $user->last_name : @set_value('last_name'); ?>" class="form-control"  required="required">
                      </div>
                  </div>

                  <div class="col-md-6">
                      <div class="form-group">
                        <label for="title">Email</label>
                        <input type="email" name="email" id="email" placeholder="Please enter your valid email" value="<?= @$user ? $user->email : @set_value('email'); ?>" class="form-control"  required="required">
                      </div>
                  </div>


                  <div class="col-md-6">
                      <div class="form-group">
                        <label for="title">Phone</label>
                        <input type="text" name="phone" id="phone"  onkeyup="this.value=this.value.replace(/[^\d]/,'')"  placeholder="Please enter your phone number" value="<?= @$user ? $user->phone : @set_value('phone'); ?>" class="form-control"  required="required"  maxlength="10">
                      </div>
                  </div>

                  <?php if(!@$user){ ?>
                  <div class="col-md-6">
                      <div class="form-group">
                        <label for="title">Password</label>
                        <input type="password" name="password" id="password" placeholder="Please enter your password" value="" class="form-control"  required="required">
                      </div>
                  </div>


                  <div class="col-md-6">
                      <div class="form-group">
                        <label for="title">Confirm Password</label>
                        <input type="password" name="confirm_password" id="confirm_password" placeholder="Please enter your confirm password" value="" class="form-control" required="required">
                      </div>
                  </div>
                <?php } ?>
             
                     <button type="submit" class="btn btn-default" id="sub"><?= @$user ? 'Update User' : 'Add User'; ?></button>
                  </div>
                  </form>
               </div>
            
      </div>
   </div>
</section>