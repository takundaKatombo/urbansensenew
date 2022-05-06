<!-- ========== END HEADER ========== -->
<main id="content" role="main">
   <div class="container">
      <div class="row">
         <div class="col-md-10 offset-md-1">
            <div class="card p-4 mt-4 mb-4">
               <div class="row">
                  <div class="col-md-12">
                     <div class="card-header d-flex align-items-center">
                        <h3 class="h4">Reviews & Ratings</h3>
                     </div>
                  </div>
               </div>
                  
               <?php if(empty($reviews)) { ?>
                  <div class="row">
                     <div class="col-md-12">
                        <h3 class="h4 pl-2 mt-4 text-center">No reviews found for this service provider</h3>
                     </div>
                  </div>
               <?php } else { foreach ($reviews as $row) { ?>
               <div class="row">
                  <div class="col-md-12">
                     <h3 class="h4 pl-2 mt-4"><?= ucwords($row->name); ?></h3>
                  </div>
                  <div class="col-md-4">
                     <div class="pl-4 pr-4 pb-2">
                        <div class=" mb-1">
                           <div class="font-size-14">
                              Professionalism : 
                               <span class="float-right">  
                                 <?php for ($i=1; $i <=5  ; $i++) { if($i<= $row->professionalism){ 
                                    echo '<span class="fa fa-star checked" style="color:#f4701a;padding:1px;"></span>';
                                      } else { 
                                       echo '<span class="fa fa-star" style="padding:1px;"></span>';
                                 } } ?> 
                              </span>
                              
                           </div>
                        </div>
                        <div class=" mb-1">
                          <div class="font-size-14">
                              Knowledge :  
                               <span class="float-right">
                                 <?php for ($i=1; $i <=5  ; $i++) { if($i<= $row->knowledge){ 
                                    echo '<span class="fa fa-star checked" style="color:#f4701a;padding:1px;"></span>';
                                      } else { 
                                       echo '<span class="fa fa-star" style="padding:1px;"></span>';
                                 } } ?> 
                              </span>
                              
                           </div>
                        </div>
                        <div class=" mb-1">
                           <div class="font-size-14">
                              Cost : 
                               <span class="float-right">
                                 <?php for ($i=1; $i <=5  ; $i++) { if($i<= $row->cost){ 
                                    echo '<span class="fa fa-star checked" style="color:#f4701a;padding:1px;"></span>';
                                      } else { 
                                       echo '<span class="fa fa-star" style="padding:1px;"></span>';
                                 } } ?> 
                              </span>
                              
                           </div>
                        </div>
                        <div class=" mb-1">
                           <div class="font-size-14">
                              Punctuality : 
                               <span class="float-right">
                                 <?php for ($i=1; $i <=5  ; $i++) { if($i<= $row->punctuality){ 
                                    echo '<span class="fa fa-star checked" style="color:#f4701a;padding:1px;"></span>';
                                      } else { 
                                       echo '<span class="fa fa-star" style="padding:1px;"></span>';
                                 } } ?> 
                              </span>
                              
                           </div>
                        </div>
                        <div class=" mb-1">
                           <div class="font-size-14">
                              Tidiness : 
                              <span class="float-right">
                              <?php for ($i=1; $i <=5  ; $i++) { if($i<= $row->tidiness){ 
                                 echo '<span class="fa fa-star checked" style="color:#f4701a;padding:1px;"></span>';
                                   } else { 
                                    echo '<span class="fa fa-star" style="padding:1px;"></span>';
                              } } ?> 
                              </span>
                             
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-8 pl-4 pr-4 pb-2">
                     <p><?= $row->review?></p>
                  </div>
               </div>
               <hr>
            <?php } } ?>
            </div>
         </div>
      </div>
   </div>
</main>
<!-- ========== END MAIN CONTENT ========== -->