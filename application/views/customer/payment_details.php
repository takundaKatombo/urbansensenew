     <main id="content" role="main">
         <!-- Contact Content Section -->
         <div class="container ">
            <h5 class="service mt-3 mb-3">Confirm Booking </h5>
            <div class="row">
               <div class="col-md-10 offset-md-1">
                  <!-- Projects -->
                  <div class="card p-5 mb-5">
                     <!-- List of Icons -->
                     <div class="row justify-content-between align-items-center mb-3">
                <div class="col-md-12">
                        <form class="js-validate " novalidate="novalidate" method="GET" action="https://www.payfast.co.za/eng/process/">
                           <!-- Details -->
                           <div class="d-sm-flex  mb-3">
                              <div class="col-md-2">
                                       <img class="u-lg-avatar  mb-3 mb-sm-0 " src="<?= @get_default_pro_image($service_provider->id) ?  base_url('uploads/image/').get_default_pro_image($service_provider->id) : base_url('assets/upload.png');?>" alt="Image Description">
                                       </div>
                                <div class=" col-md-10">
                                   
                                    <h3 class="h5 mb-1"><?= ucwords($service_id) ?> </h3>
                                    <div class="mb-1 mr-1 bold">Price : ZAR <?=  $form_data['amount'] ?></div>
                                    <div class="mb-1 bold">Company : <?= $professional->professionals->company_name?></div>
                                 
                              </div>
                           </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12 mb-4">
                              <div class="mb-1 mr-1 bold">Name : <?=  ucwords($form_data['name_first'].' '.$form_data['name_last']) ?></div>
                              <div class="mb-1 mr-1 bold">Phone : <?=  $form_data['cell_number'] ?></div>
                              <div class="mb-1 mr-1 bold">Email : <?=  $form_data['email_address'] ?></div>
                              <div class="mb-1 mr-1 bold">Preferred Date : <?=  $form_data['custom_str2'] ?></div>
                              <div class="mb-1 mr-1 bold">Preferred Time : <?=  $form_data['custom_str3'] ?></div>
                              <div class="mb-1 mr-1 bold">Address : <?=  $form_data['custom_str1'] ?></div>

                            </div>
                        </div>
                          <?php
                            foreach ( $form_data as $key => $val )
                            {
                                if ( !empty( $val ) && $key != 'submit' )
                                {
                                    ?>
                                    <input type="hidden" name="<?php echo $key?>" value="<?php echo $val?>"/>
                                    <?php
                                }

                            }
                        ?>
                        <!-- <input type="hidden" name="signature" value="<?php echo $signature; ?>"/> -->
                     <div class="row">
                     <!-- End Title -->
                     <div class="col-md-12">
                     <!-- Budget -->
                     <div class="mt-3 mb-3 mb-sm-0 ">
                     <button type="submit" class="btn btn-primary u-btn-primary transition-3d-hover">Proceed to pay</button>
                     </div> 
                     <!-- End Budget -->
                     <!-- Priority -->
                     <!-- End Priority -->
                     </div>
                  </div>
                     </form>
                 </div>
              </div>
           </div>
        </div>
     </div>

   <!-- End Contact Content Section -->
   <div id="stickyBlockEndPoint"></div>
</main>
      <!-- ========== END MAIN ========== -->