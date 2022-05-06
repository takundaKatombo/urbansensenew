
<div class="content-inner">
<!-- Page Header-->
<header class="page-header">
   <div class="container-fluid">
      <h2 class="no-margin-bottom">Booking Details</h2>
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
               <h3 class="h4">Booking Details</h3>
            </div>
            <div class="card-body">
               <div class="row">
                  <div class="col-md-6">Booking ID</div><div class="col-md-6"><?= $booking->booking_reference_number ?></div>
               </div>
               <hr>
               <div class="row">
                  <div class="col-md-6">Payment ID</div><div class="col-md-6"><?= $booking->payment_key ?></div>
               </div>
               <hr>

                <div class="row">
                  <div class="col-md-6">Service Cost</div><div class="col-md-6"><?= $booking->currency .' '.$booking->amount_paid ?></div>
               </div>
               <hr>
               <div class="row">
                  <div class="col-md-6">Booking Status</div><div class="col-md-6"><?= $booking->booked_status ?></div>
               </div>
               <hr>
               <div class="row">
                  <div class="col-md-6">Customer Name</div><div class="col-md-6"><?= $booking->customer_name ?></div>
               </div>
               <hr>
               <div class="row">
                  <div class="col-md-6">Customer Phone</div><div class="col-md-6"><?= $booking->customer_phone ?></div>
               </div>
               <hr>
               <div class="row">
                  <div class="col-md-6">Customer Email</div><div class="col-md-6"><?= $booking->customer_email ?></div>
               </div>
               <hr>
               <div class="row">
                  <div class="col-md-6">Customer Address</div><div class="col-md-6"><?= $booking->customer_address ?></div>
               </div>
               <hr>
               <div class="row">
                  <div class="col-md-6">Preferred  Date & Time</div><div class="col-md-6"><?= date('d/m/Y', strtotime($booking->required_date)).' | '.$booking->required_time ?></div>
               </div>
               <hr>
               <div class="row">
                  <div class="col-md-6">Service</div>
                  <div class="col-md-6">
                     <?= ucwords(get_service($booking->service_id)); ?>
                  </div>
               </div>
               <hr>
               <div class="row">
                  <div class="col-md-6">Service Provider</div><div class="col-md-6"><?= get_user($booking->professional_id)->professionals->company_name; ?></div>
               </div>
               <hr>
               <div class="row">
                  <div class="col-md-6">Service Provider email</div><div class="col-md-6"><?= get_user($booking->professional_id)->email; ?></div>
               </div>
               <hr>
               <div class="row">
                  <div class="col-md-6">Service Provider phone</div><div class="col-md-6"><?= get_user($booking->professional_id)->phone; ?></div>
               </div>
               <hr>
               <div class="row">
                  <div class="col-md-6">Service Provider Address</div><div class="col-md-6"><?= get_user($booking->professional_id)->professionals->address; ?></div>
               </div>
               <hr>
              <div class="row">
                  <div class="col-md-6">Service Provider Bank Passbook</div><div class="col-md-6">
                  <a href="<?= base_url().'uploads/bank_passbook_image/'.get_user($booking->professional_id)->professionals->bank_passbook_image; ?>" target="_blank"><img src="<?= base_url().'uploads/bank_passbook_image/'.get_user($booking->professional_id)->professionals->bank_passbook_image; ?>" style="width: 50%"> </a></div>
               </div>
               <hr>
               <div class="row">
                  <div class="col-md-6">Service Provider ID Number</div><div class="col-md-6"><?=get_user($booking->professional_id)->professionals->id_type.' : '.get_user($booking->professional_id)->professionals->id_number; ?></div>
               </div>
               <hr>

            </div>
        
         </div>
      </div>
   </div>
</section>