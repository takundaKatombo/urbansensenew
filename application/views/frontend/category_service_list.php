<!-- ========== MAIN ========== -->
<main id="content" role="main">
   <!-- Contact Content Section -->
   <div class="container u-space-1">
      <div class="row">
         <div class="col-12 col-sm-3">
            <div class="card">
               <article class="card-group-item">
                  <header class="card-header text-center">
                     <h6 class="title"> Categories </h6>
                     <button type="button" class="navbar-toggler btn u-hamburger "
                     aria-label="Toggle navigation"
                     aria-expanded="false"
                     aria-controls="collapsiblenavbar"
                     data-toggle="collapse"
                     data-target="#collapsiblenavbar" >
                     <span id="hamburgerTrigger1" class="u-hamburger__box">
                     <span class="u-hamburger__inner"></span>
                     </span>
                  </button>
                  </header>
                  <div class="filter-content collapse" id="collapsiblenavbar" >
                     <div class="list-group list-group-flush">

                        <?php if(!empty($categories)){ foreach ($categories as $row) { ?>
                        <a href="<?= base_url('all-services/').$row['slug'] ?>" class="list-group-item <?= ($category->id===$row['id']) ? 'active' : ''; ?>"><span class="float-left round mr-2"> <img src="<?= base_url('uploads/image/').$row['image']; ?>" width="35" height="35"> </span> <?= ucwords($row['title']); ?><span class="float-right badge badge-light round"><?= $row['number']; ?></span> </a>
                        <?php }} else {
                           echo 'No category found';
                        } ?>
                     </div>
                     <!-- list-group .// -->
                  </div>
               </article>
               <!-- card-group-item.// -->
            </div>
         </div>
         <div class="col-12 col-sm-9">
            <h5 class="service"><?= ucwords(@$category->title); ?></h5>
            <!-- Projects -->
            <?php if(empty($services)){?>   
            <div class="alert alert-info alert-dismissible">
              We are sorry, there are no service providers in your area, we are working on getting more. Please try again later. For a custom request  <a href="<?= base_url('send-request'); ?>"><b>Click Here</b></a>
            </div>
            
            <?php } else  {?>
               <div class="row">
                  <?php foreach ($services as $row) { ?>
                  
                     <div class="col-md-6">
                        <div class="card pr-5 pl-5 pb-2 pt-3 mb-5">
                           <!-- List of Icons -->
                           <a href="<?= base_url('services/').$row->slug ?>">
                              <div class="row justify-content-between align-items-center mb-2">
                                 <img src="<?= base_url("image/display?image=". base_url().'uploads/image/'.$row->image."&w=360&h=180"); ?>""  class="img-fluid w-100">
                              </div>
                              <div class="text-center">
                                 <?= ucwords($row->title); ?>
                              </div>
                           </a>
                           <!-- End List of Icons -->
                        </div>
                     </div>
                     
                  <?php } ?>
               </div>
            <?php } ?>
           
            <!-- End Projects -->
         </div>
      </div>
   </div>
   <!-- End Contact Content Section -->
   <div id="stickyBlockEndPoint"></div>
</main>
<!-- ========== END MAIN ========== -->