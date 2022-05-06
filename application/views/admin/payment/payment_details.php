
<div class="content-inner">
<!-- Page Header-->
<header class="page-header">
   <div class="container-fluid">
      <h2 class="no-margin-bottom">Payment Details</h2>
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
               <h3 class="h4">Payment Details</h3>
            </div>
            <div class="card-body">
               
               <div class="row">
                  <div class="col-md-6">Payment ID</div><div class="col-md-6"><?= $payment->payment_key ?></div>
               </div>
               <hr>

                <div class="row">
                  <div class="col-md-6">Service Cost</div><div class="col-md-6"><?= $payment->currency_type .' '.$payment->amount  ?></div>
               </div>
               <hr>
               <div class="row">
                  <div class="col-md-6">Payment Status</div><div class="col-md-6"><?= $payment->payment_status ?></div>
               </div>
               <hr>
               <div class="row">
                  <div class="col-md-6">Customer Name</div><div class="col-md-6"><?= $payment->customer_name ?></div>
               </div>
               <hr>
               <div class="row">
                  <div class="col-md-6">Customer Phone</div><div class="col-md-6"><?= $payment->customer_phone ?></div>
               </div>
               <hr>
               <div class="row">
                  <div class="col-md-6">Customer Email</div><div class="col-md-6"><?= $payment->customer_email ?></div>
               </div>
               <hr>
               <div class="row">
                  <div class="col-md-6">Customer Address</div><div class="col-md-6"><?= $payment->customer_address ?></div>
               </div>
               <hr>
        
               <div class="row">
                  <div class="col-md-6">Service</div>
                  <div class="col-md-6">
                     <?= ucwords(get_service($payment->service_id)); ?>
                  </div>
               </div>
               <hr>
               <div class="row">
                  <div class="col-md-6">Service Provider</div><div class="col-md-6"><?= get_user($payment->professional_id)->professionals->company_name; ?></div>
               </div>
               <hr>
               <div class="row">
                  <div class="col-md-6">Service Provider email</div><div class="col-md-6"><?= get_user($payment->professional_id)->email; ?></div>
               </div>
               <hr>
               <div class="row">
                  <div class="col-md-6">Service Provider phone</div><div class="col-md-6"><?= get_user($payment->professional_id)->phone; ?></div>
               </div>
               <hr>
               <div class="row">
                  <div class="col-md-6">Service Provider Address</div><div class="col-md-6"><?= get_user($payment->professional_id)->professionals->address; ?></div>
               </div>
               <hr>
               <div class="row">
                  <div class="col-md-6">Service Provider Bank Passbook</div><div class="col-md-6">
                  <a href="<?= base_url().'uploads/bank_passbook_image/'.get_user($payment->professional_id)->professionals->bank_passbook_image; ?>" target="_blank"><img src="<?= base_url().'uploads/bank_passbook_image/'.get_user($payment->professional_id)->professionals->bank_passbook_image; ?>" style="width: 50%"> </a></div>
               </div>
               <hr>
               <div class="row">
                  <div class="col-md-6">Service Provider ID Number</div><div class="col-md-6"><?=get_user($payment->professional_id)->professionals->id_type.' : '.get_user($payment->professional_id)->professionals->id_number; ?></div>
               </div>
               <hr>

            </div>
        
         </div>
      </div>
   </div>
</section>