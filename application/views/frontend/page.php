<!-- ========== MAIN ========== -->
<main id="content" role="main">
   <div class="position-relative u-gradient-half-primary-v1">
      <div class="container u-space-2-top u-space-2-bottom">
         <div class="row align-items-lg-center">
             <?php if($page->flash_image_one !== ''){ ?>
            <div class="col-lg-5 mb-7 mb-lg-0">
               <!-- Info -->
               <h1 class="display-4 font-size-48--md-down text-white font-weight-bold"><span class="text-warning"></span>  <?= ucwords($page->title); ?></h1>
             <!--  <p class="u-text-light">Lorem Ipsum is simply dummy text of the printing and typesetting</p>
                End Info -->
            </div>
            <div class="col-lg-7">
               <!-- SVG Icon -->
              
               <img src="<?= base_url('uploads/image/').$page->flash_image_one; ?>" alt="SVG Illustration">
               <!-- End SVG Icon -->
            </div>
            <?php } else { ?>
               <div class="col-lg-12 mb-7 mb-lg-0">
                  <!-- Info -->
                  <h1 class="display-4 font-size-48--md-down text-center text-white font-weight-bold"><span class="text-warning"></span>  <?= ucwords($page->title); ?></h1>
                <!--  <p class="u-text-light">Lorem Ipsum is simply dummy text of the printing and typesetting</p>
                   End Info -->
               </div>
           <?php }?>
         </div>
      </div>
      <!-- SVG Bottom Shape -->
     
      <!-- End SVG Bottom Shape -->
   </div>
   <!-- Terms Content Section -->
   <div class="u-bg-light-blue-50">
      <div class="container u-space-2">
         <div class="row">
            <div class="col-md-12 col-lg-12">
               <div id="intro" class="u-space-1-bottom text-justify">
                  <!-- Title -->
                  <div class="mb-3">
                     <h3 class="text-primary font-weight-bold"></h3>
                  </div>
                  <!-- End Title -->
                  <!-- Text -->
                  <p ><?= $page->content ?>
                  </p>
                  <!-- End Text -->
               </div>
               <hr class="my-0">
               
            </div>
         </div>
      </div>
   </div>
   <!-- End Terms Content Section -->
   <div id="stickyBlockEndPoint"></div>
</main>
<!-- ========== END MAIN ========== -->