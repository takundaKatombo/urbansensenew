
<div class="content-inner">
<!-- Page Header-->
<header class="page-header">
   <div class="container-fluid">
      <h2 class="no-margin-bottom">Customer Details</h2>
      <div class="right-menu">
        
      </div>
   </div>
</header>
 <?php $this->load->view('errors/error'); ?> 
<section class="tables">
   <div class="container-fluid">
      <div class="col-lg-12">
         <div class="card">
            
            <div class="card-header d-flex align-items-center">
               <h3 class="h4">Customer Details</h3>
            </div>
            <div class="card-body">
               <div class="row">
                  <div class="col-md-6">Name</div><div class="col-md-6"><?= $user->first_name.' '.$user->last_name ?></div>
               </div>
               <hr>
               <div class="row">
                  <div class="col-md-6">Email</div><div class="col-md-6"><?= $user->email ?></div>
               </div>
               <hr>
               <div class="row">
                  <div class="col-md-6">Phone</div><div class="col-md-6"><?= $user->phone ?></div>
               </div>
               <hr>
               <div class="row">
                  <div class="col-md-6">Total Bookings</div><div class="col-md-6"><?= $total_booking ?></div>
               </div>
               <hr>
               <div class="row">
                  <div class="col-md-6">Total Canceled  Bookings</div><div class="col-md-6"><?= $cancel_booking ?></div>
               </div>
               <hr>
               <div class="row">
                  <div class="col-md-6">Total Ongoing  Bookings</div><div class="col-md-6"><?= 
                ($ongoing_booking) ?></div>
               </div>
               <hr>
               <div class="row">
                  <div class="col-md-6">Total Complete  Bookings</div><div class="col-md-6"><?= 
                ($total_booking-$cancel_booking-$ongoing_booking) ?></div>
               </div>
               <hr>

              
             
              
              
              

            </div>
        
         </div>
      </div>
   </div>
</section>