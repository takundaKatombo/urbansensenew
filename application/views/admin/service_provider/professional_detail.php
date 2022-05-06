
<div class="content-inner">
<!-- Page Header-->
<header class="page-header">
   <div class="container-fluid">
      <h2 class="no-margin-bottom">Service Provider Details</h2>
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
               <h3 class="h4">Service Provider  Details</h3>
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
                  <div class="col-md-6">Service</div><div class="col-md-6">
                     <?php foreach ($user->professional_services as $row) {
                                    echo get_service($row->service_id).', ';
                                    
                                 } ?></div>
               </div>
               <hr>
               <div class="row">
                  <div class="col-md-6">Company Name</div><div class="col-md-6"><?= $user->professionals->company_name; ?></div>
               </div>
               <hr>
               <div class="row">
                  <div class="col-md-6">Introduction</div><div class="col-md-6"><?= $user->professionals->introduction; ?></div>
               </div>
               <hr>
               <div class="row">
                  <div class="col-md-6">Account holder name</div><div class="col-md-6"><?= $user->professionals->account_holder_name; ?></div>
               </div>
               <hr>

               <div class="row">
                  <div class="col-md-6">Account Number</div><div class="col-md-6"><?= $user->professionals->account_number; ?></div>
               </div>
               <hr>

               <div class="row">
                  <div class="col-md-6">Bank Name</div><div class="col-md-6"><?= $user->professionals->ifsc; ?></div>
               </div>
               <hr>

               <div class="row">
                  <div class="col-md-6">Branch</div><div class="col-md-6"><?= $user->professionals->branch; ?></div>
               </div>
               <hr>

               <div class="row">
                  <div class="col-md-6">Bank Passbook</div><div class="col-md-6">
                  <?php if($user->professionals->bank_passbook_image != ''){ ?>
                      <a href="<?=  base_url('uploads/bank_passbook_image/').$user->professionals->bank_passbook_image ?>" target="_blank">
                        <img src="<?=  base_url('uploads/bank_passbook_image/').$user->professionals->bank_passbook_image ?>"   height="50" width="150">
                     </a>
                  <?php } ?></div>
               </div>
               <hr>
               <div class="row">
                  <div class="col-md-6">ID Number</div><div class="col-md-6"><?= $user->professionals->id_type.' : '.$user->professionals->id_number; ?></div>
               </div>
               <hr>

               <div class="row">
                  <div class="col-md-6">ID Card</div><div class="col-md-6">
                  <?php if($user->professionals->id_card_image != ''){ ?>
                     <a href="<?=  base_url('uploads/id_card_image/').$user->professionals->id_card_image ?>" target="_blank">
                     <img src="<?=  base_url('uploads/id_card_image/').$user->professionals->id_card_image ?>"  height="50" width="150"></a>
                  <?php } ?></div>
               </div>
               <hr>

               <div class="row">
                  <div class="col-md-6">Location</div><div class="col-md-6"><?= $user->professionals->address; ?></div>
               </div>
               <hr>
               <div class="row">
                  
                     <?php foreach ($user->professional_images as $row) { ?>
                  <div class="col-md-3 ">
                     <div class="img-wrapper">
                        <a href="<?= base_url('uploads/image/').$row->image ?>" target="_blank">
                           <img src="<?= base_url('uploads/image/').$row->image ?>" class="img-responsive" width="150" height="150">
                        </a>
                     </div>
                  </div>
                  <?php } ?>
             
            </div>

            </div>
        
         </div>
      </div>
   </div>
</section>