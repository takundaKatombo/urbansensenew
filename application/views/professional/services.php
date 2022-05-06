 <!-- ========== MAIN ========== -->
 <main id="content" role="main">

     <!-- Contact Content Section -->

     <div class="container">
         <?php if ($loggedin_user->verification != 1) { ?>
             <div class="col-md-12" style="margin-top: 8px;">
                 <div class="alert alert-warning">
                     Please update your profile and upload relevant documents for account verification purpose. Only verified profiles are entitled to accept orders and payments. <a href="<?= base_url('edit-profile'); ?>">Click here </a> to proceed. If you've already uploaded all documents, please wait while we verify the details. Your account will be activated to receive requests after successful verification.
                 </div>
             </div>
         <?php } ?>

         <div class="row mt-5">
             <?php foreach ($services as $row) { ?>
                 <div class="col-md-6">
                     <div class="card mb-6">
                         <div class="card-body">
                             <div>Service</div>
                             <div><?= get_service($row->service_id); ?></div>
                             <hr>
                             <div>Price</div>
                             <div><?= $row->price; ?></div>
                             <hr>
                             <div>Details</div>
                             <div><?= $row->details; ?></div>
                             <hr>
                             <div>Image</div>
                             <div><?= get_service($row->service_id); ?></div>
                             <hr>
                             <button type="submit" class="btn btn-primary u-btn-primary transition-3d-hover but1">Update</button>
                         </div>
                     </div>
                 </div>
             <?php } ?>

         </div>

     </div>

     <!-- End Contact Content Section -->

     <div id="stickyBlockEndPoint"></div>
 </main>
 <!-- ========== END MAIN ========== -->