 <!-- ========== END HEADER ========== -->
      <main id="content" role="main">
         <div class="container">
         <div class="row">
            <div class="col-md-10 offset-md-1">
               <div class="card mt-4 mb-4 p-4">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="card-header d-flex align-items-center">
                           <h3 class="h4">Reviews & Ratings</h3>
                        </div>
                     </div>
                  </div>
                  <form class="js-validate ajax-form" novalidate="novalidate"  action="<?= base_url('Reviews/review') ?>" method="post">
                  <div class="row ">
                     <div class="col-md-6">
                        <div class="pro">
                           <h3 class="h6">Professionalism</h3>
                        </div>
                        <div class="pro">
                           <h3 class="h6">Knowledge and advise given</h3>
                        </div>
                     <div class="pro">
                           <h3 class="h6">Service cost</h3>
                        </div>
                     <div class="pro">
                           <h3 class="h6">Punctuality</h3>
                        </div>
                     <div class="pro">
                           <h3 class="h6">Tidiness</h3>
                        </div>
                     <div class="pro">
                           <h3 class="h6">User friendly</h3>
                        </div>
                    

                     <div class="pro">
                           <h3 class="h6">Interface</h3>
                        </div>
                    
                     <div class="pro">
                           <h3 class="h6">Technical issues</h3>
                     </div>
                  </div>

                     <div class="col-md-6">
                        <div class="stars">
                          
                              <input class="star star-5" id="star-5" type="radio" value="5" name="professionalism"  required="required" />
                              <label class="star star-5" for="star-5"></label>
                              <input class="star star-4" id="star-4" type="radio" value="4" name="professionalism" required="required"/>
                              <label class="star star-4" for="star-4"></label>
                              <input class="star star-3" id="star-3" type="radio" value="3" name="professionalism" required="required"/>
                              <label class="star star-3" for="star-3"></label>
                              <input class="star star-2" id="star-2" type="radio" value="2" name="professionalism" required="required"/>
                              <label class="star star-2" for="star-2"></label>
                              <input class="star star-1" id="star-1" type="radio" value="1" name="professionalism" required="required"/>
                              <label class="star star-1" for="star-1"></label>
                           
                        </div>
                        <div class="stars">
                          
                              <input class="star star-6" id="star-6" type="radio" value="5" name="knowledge" required="required"/>
                              <label class="star star-6" for="star-6"></label>
                              <input class="star star-7" id="star-7" type="radio" value="4" name="knowledge" required="required"/>
                              <label class="star star-4" for="star-7"></label>
                              <input class="star star-3" id="star-8" type="radio" value="3" name="knowledge" required="required"/>
                              <label class="star star-3" for="star-8"></label>
                              <input class="star star-2" id="star-9" type="radio" value="2" name="knowledge" required="required"/>
                              <label class="star star-2" for="star-9"></label>
                              <input class="star star-0" id="star-10" type="radio" value="1" name="knowledge" required="required"/>
                              <label class="star star-0" for="star-10"></label>
                           
                        </div>
                  <div class="stars">
                          
                              <input class="star star-6" id="star-11" type="radio" value="5" name="cost"/>
                              <label class="star star-6" for="star-11"></label>
                              <input class="star star-4" id="star-12" type="radio" value="4" name="cost"/>
                              <label class="star star-4" for="star-12"></label>
                              <input class="star star-3" id="star-13" type="radio" value="3" name="cost"/>
                              <label class="star star-3" for="star-13"></label>
                              <input class="star star-2" id="star-14" type="radio" value="2" name="cost"/>
                              <label class="star star-2" for="star-14"></label>
                              <input class="star star-0" id="star-15" type="radio" value="1" name="cost"/>
                              <label class="star star-0" for="star-15"></label>
                           
                        </div>
                 <div class="stars">
                          
                              <input class="star star-6" id="star-16" type="radio" value="5" name="punctuality"/>
                              <label class="star star-6" for="star-16"></label>
                              <input class="star star-4" id="star-17" type="radio" value="4" name="punctuality"/>
                              <label class="star star-4" for="star-17"></label>
                              <input class="star star-3" id="star-18" type="radio" value="3" name="punctuality"/>
                              <label class="star star-3" for="star-18"></label>
                              <input class="star star-2" id="star-19" type="radio" value="2" name="punctuality"/>
                              <label class="star star-2" for="star-19"></label>
                              <input class="star star-0" id="star-20" type="radio" value="1" name="punctuality"/>
                              <label class="star star-0" for="star-20"></label>
                           
                        </div>

                         <div class="stars">
                          
                              <input class="star star-6" id="star-25" type="radio" value="5" name="tidiness"/>
                              <label class="star star-6" for="star-25"></label>
                              <input class="star star-4" id="star-24" type="radio" value="4" name="tidiness"/>
                              <label class="star star-4" for="star-24"></label>
                              <input class="star star-3" id="star-23" type="radio" value="3" name="tidiness"/>
                              <label class="star star-3" for="star-23"></label>
                              <input class="star star-2" id="star-22" type="radio" value="2" name="tidiness"/>
                              <label class="star star-2" for="star-22"></label>
                              <input class="star star-1" id="star-21" type="radio" value="1" name="tidiness"/>
                              <label class="star star-0" for="star-21"></label>
                           
                        </div>

                
                        

                        <div class="stars">
                          
                              <input class="star star-6" id="star-30" type="radio" value="5" name="user_friendly"/>
                              <label class="star star-6" for="star-30"></label>
                              <input class="star star-4" id="star-29" type="radio" value="4" name="user_friendly"/>
                              <label class="star star-4" for="star-29"></label>
                              <input class="star star-3" id="star-28" type="radio" value="3" name="user_friendly"/>
                              <label class="star star-3" for="star-28"></label>
                              <input class="star star-2" id="star-27" type="radio" value="2" name="user_friendly"/>
                              <label class="star star-2" for="star-27"></label>
                              <input class="star star-0" id="star-26" type="radio" value="1" name="user_friendly"/>
                              <label class="star star-0" for="star-26"></label>
                           
                        </div>

                        <div class="stars">
                          
                              <input class="star star-6" id="star-35" type="radio" value="5" name="interface"/>
                              <label class="star star-6" for="star-35"></label>
                              <input class="star star-4" id="star-34" type="radio" value="4" name="interface"/>
                              <label class="star star-4" for="star-34"></label>
                              <input class="star star-3" id="star-33" type="radio" value="3" name="interface"/>
                              <label class="star star-3" for="star-33"></label>
                              <input class="star star-2" id="star-32" type="radio" value="2" name="interface"/>
                              <label class="star star-2" for="star-32"></label>
                              <input class="star star-0" id="star-31" type="radio" value="1" name="interface"/>
                              <label class="star star-0" for="star-31"></label>
                           
                        </div>

                        <div class="stars">
                          
                              <input class="star star-6" id="star-36" type="radio" value="5" name="technical_issue"/>
                              <label class="star star-6" for="star-36"></label>
                              <input class="star star-4" id="star-37" type="radio" value="4" name="technical_issue"/>
                              <label class="star star-4" for="star-37"></label>
                              <input class="star star-3" id="star-38" type="radio" value="3" name="technical_issue"/>
                              <label class="star star-3" for="star-38"></label>
                              <input class="star star-2" id="star-39" type="radio" value="2" name="technical_issue"/>
                              <label class="star star-2" for="star-39"></label>
                              <input class="star star-0" id="star-40" type="radio" value="1" name="technical_issue"/>
                              <label class="star star-0" for="star-40"></label>
                           
                        </div>

                  
                     </div>
                  </div>
               <hr>
              
                    
                  <div class="row">
                        <div class="col-md-12  mb-2">
                           <div class="js-form-message">
                              <label class="h6 small d-block text-uppercase">
                              Share your experience
                              <span class="text-danger">*</span>
                              </label>
                              <div class="js-focus-state input-group u-form">
                                 <textarea class="form-control u-form__input" rows="4" name="review" required="" placeholder="Share your experience" aria-label="Share your experience" data-msg="Share your experience" data-error-class="u-has-error" data-success-class="u-has-success"><?= set_value('review') ? set_value('review') : "" ?></textarea>
                                  <?= invalid_error('review')?>
                              </div>
                           </div>
                        </div>
                  </div>
                  <div class="row">
                       
                        <div class="col-md-6 mb-2">
                           <div class="js-form-message">
                              <label class="h6 small d-block text-uppercase">
                              Name
                              <span class="text-danger">*</span>
                              </label>
                              <div class="js-focus-state input-group u-form">
                                 <input class="form-control u-form__input " name="name" id="name" value="<?= set_value('name') ? set_value('name') : "" ?>" required="" placeholder="Enter your name" aria-label="name" data-msg="Please enter your name" data-error-class="u-has-error" data-success-class="u-has-success" type="text" autocomplete="off" >
                             
                              </div>
                           </div>
                        </div>
                         <input type="hidden" name="professional_id" value="<?= $this->uri->segment(2); ?>">
                        <div class="col-md-6 mb-2">
                           <div class="js-form-message">
                              <label class="h6 small d-block text-uppercase">
                              Phone
                              <span class="text-danger">*</span>
                              </label>
                              <div class="js-focus-state input-group u-form">
                                 <input class="form-control u-form__input service" onkeyup="this.value=this.value.replace(/[^\d]/,'')" name="phone" value="<?= set_value('phone') ? set_value('phone') : "" ?>" required="" placeholder="Enter your phone" aria-label="phone" data-msg="Please enter your phone" data-error-class="u-has-error" data-success-class="u-has-success" type="text" autocomplete="off">
                              </div>
                           </div>
                        </div>
                  </div>

                     <div class="col-md-12 ">
                        <div class="but_review">
                           <button class="btn btn-sm btn-primary u-btn-primary transition-3d-hover">
                           Submit
                           </button>
                        </div>
                     </div>
               </form>    
                     
                
               </div>
            </div>
            </div>
         </div>
      </main>
      <!-- ========== END MAIN CONTENT ========== -->