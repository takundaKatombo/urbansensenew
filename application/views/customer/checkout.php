     <main id="content" role="main">

         <!-- Contact Content Section -->

         <div class="container ">

            <h5 class="service mt-3 mb-3">Checkout  </h5>

            <div class="row">

               <div class="col-md-10 offset-md-1">

                  <!-- Projects -->

                  <div class="card p-5 mb-5">

                     <!-- List of Icons -->

                     <div class="row justify-content-between align-items-center mb-3">

                <div class="col-md-12">

                        <form class="js-validate" novalidate="novalidate" method="post" action="<?= base_url('payment-details') ?>">

                           <!-- Details -->

                           <div class="d-sm-flex  mb-3">

                     <div class="col-md-2">

                              <img class="u-lg-avatar  mb-3 mb-sm-0 " src="<?= @get_default_pro_image($service_provider->id) ?  base_url('uploads/image/').get_default_pro_image($service_provider->id) : base_url('assets/upload.png');?>" alt="Image Description">

                              </div>

                       <div class=" col-md-10">

                                 <!-- Title -->

                                 <div class="mb-3">

                                    <a >

                                       <h3 class="h5 mb-1"><?= ucwords($service) ?> </h3>

                                    </a>

                                    <div class="mb-1 mr-1 bold">Base Price : <?=  $price ?></div>
                                    <div class="mb-1 mr-1 bold">PG Charges : <?=  $pgcharges ?></div>
                                    <div class="mb-1 mr-1 bold">Total Price : <?=  $total_charge ?></div>

                                    <div class="mb-1 bold">Company : <?= $service_provider->professionals->company_name?></div>

                                  



                                    <input type="hidden" name="merchant_id" value="<?php echo $this->config->item('merchant_id'); ?>">

                                    <input type="hidden" name="merchant_key" value="<?php echo $this->config->item('merchant_key'); ?>">
                                  



                                   <!--  <input type="hidden" name="return_url" value="<?= base_url('booking-successfull') ?>?txnid=<?= $payment_id.'_'.$price.'_'.$booking_id ?>">

                                    <input type="hidden" name="cancel_url" value="<?= base_url('booking-cancelled') ?>?txnid=<?= $payment_id.'_'.$price.'_'.$booking_id ?>">

                                    <input type="hidden" name="notify_url" value="<?= base_url('customer/Payments/itn') ?>" /> -->



                                     <input type="hidden" name="return_url" value="http://45.55.163.26/dev3/urbansense/booking-successfull?txnid=<?= $payment_id.'_'.$total_charge.'_'.$booking_id ?>">

                                    <input type="hidden" name="cancel_url" value="http://45.55.163.26/dev3/urbansense/booking-cancelled?txnid=<?= $payment_id.'_'.$total_charge.'_'.$booking_id ?>">

                                    <input type="hidden" name="notify_url" value="http://45.55.163.26/dev3/urbansense/customer/Payments/itn" />

                                 </div>

                              </div>

                           </div>

                           <hr>

                     <div class="row">

                           <div class="js-form-message col-md-6 mb-4">

                              <label class="h6 small d-block text-uppercase">First Name</label>

                              <div class="js-focus-state input-group u-form">

                                 <input class="form-control u-form__input" value="<?= $loggedin_user->first_name ?>" name="name_first" value="" required="" placeholder="First Name" aria-label="********" data-msg="Please enter a valid Name" data-error-class="u-has-error" data-success-class="u-has-success" type="text">

                                 <?= invalid_error('name_first')?>

                              </div>

                           </div>

                           <div class="js-form-message col-md-6 mb-4">

                              <label class="h6 small d-block text-uppercase">Last Name</label>

                              <div class="js-focus-state input-group u-form">

                                 <input class="form-control u-form__input" value="<?= $loggedin_user->last_name ?>" name="name_last" required="" placeholder="Last Name" aria-label="********" data-msg="Please enter a valid Name" data-error-class="u-has-error" data-success-class="u-has-success" type="text">

                                 <?= invalid_error('name_last')?>

                              </div>

                           </div>

                           <div class="js-form-message col-md-6  mb-4">

                              <label class="h6 small d-block text-uppercase">Email address</label>

                              <div class="js-focus-state input-group u-form">

                                 <input class="form-control u-form__input" value="<?= $loggedin_user->email ?>" name="email_address" required="" placeholder="jack@walley.com" aria-label="jack@walley.com" data-msg="Please enter a valid email address." data-error-class="u-has-error" data-success-class="u-has-success" type="email">

                                 <?= invalid_error('email_address')?>

                              </div>

                           </div>

                           <div class="js-form-message col-md-6 mb-4">

                              <label class="h6 small d-block text-uppercase">Mobile Number</label>

                              <div class="js-focus-state input-group u-form">

                                 <input class="form-control u-form__input" value="<?= $loggedin_user->phone ?>" name="cell_number" required="" placeholder="9883874434" aria-label="mobile number" data-msg="Please enter a valid phone number." data-error-class="u-has-error" data-success-class="u-has-success" type="text">

                                 <?= invalid_error('cell_number')?>

                              </div>

                           </div>



                           <div class="js-form-message col-md-6 mb-4">

                              <label class="h6 small d-block text-uppercase">Select Preferred Date</label>

                              <div class="js-focus-state input-group u-form">

                                <input class="form-control u-form__input datepicker" name="custom_str2" value="<?= $required_date ? $required_date : "" ?>" required="" placeholder="Select preferred date" aria-label="avail date" data-msg="Please select a date." data-error-class="u-has-error" data-success-class="u-has-success" type="text" autocomplete="off"  onchange ="change_time(this.value);">

                                 <?= invalid_error('custom_str2')?>

                              </div>

                           </div>



                           <div class="js-form-message col-md-6 mb-4">

                              <label class="h6 small d-block text-uppercase">Select Preferred Time</label>

                              <div class="js-focus-state input-group u-form">

                                <select class="form-control u-form__input " name="custom_str3"  id="avail_time" required="" placeholder="Select preferred time" aria-label="avail time" data-msg="Please select a time." data-error-class="u-has-error" data-success-class="u-has-success" autocomplete="off">

                                    <option value="<?= (@$required_time) ? $required_time : ''; ?>"><?= (@$required_time) ? $required_time : '-Select Preferred Time-'; ?></option>
                                 </select>

                                 <?= invalid_error('custom_str3')?>

                              </div>

                           </div>



                           <div class="js-form-message col-md-12 mb-4">

                              <label class="h6 small d-block text-uppercase">Address</label>

                              <div class="js-focus-state input-group u-form">

                                 <input class="form-control u-form__input" name="custom_str1" value="<?= $location ?>" required="" placeholder="Address" aria-label="address" data-msg="Please enter a valid address." data-error-class="u-has-error" data-success-class="u-has-success" type="text">

                                 <?= invalid_error('custom_str1')?>

                              </div>

                           </div>

                    

                           <div class="col-12">

                              <div class="form-group">

                                  <input type="checkbox" name="custom_int2" value="1"  aria-label="Please accept terms and conditions" data-msg="Please accept terms and conditions" data-error-class="u-has-error" data-success-class="u-has-success"> I accept <a href="<?= base_url($site_data->terms_conditions) ?>" target="_blank" > terms and conditions </a>.

                                  <?= invalid_error('custom_int2')?>

                               </div>

                            </div>



                           <input type="hidden" name="custom_int1" value="<?= $this->uri->segment(2); ?>">

                           <input type="hidden" name="m_payment_id" value="<?= $payment_id ?>">

                           <input type="hidden" name="custom_str4" value="<?= $booking_id ?>">

                           <input type="hidden" name="amount" value="<?=  $total_charge ?>">

                           <input type="hidden" name="item_name" value="<?= ucwords($service) ?>">

                           

                            

                   

                     <!-- End Title -->

                     <div class="col-md-12">

                     <!-- Budget -->

                     <div class="mt-3 mb-3 mb-sm-0 ">

                     <button type="submit"  onclick="this.disabled=true; this.value='Sending, please wait...';this.form.submit();" class="btn btn-primary u-btn-primary transition-3d-hover">Proceed to pay</button>

                     </div> 

                     <!-- End Budget -->

                     <!-- Priority -->

                     <!-- End Priority -->

                     </div>

                     </form>

                  </div>

              </div>

               </div>

               <!-- End Details -->

            </div>

            <!-- End List of Icons -->

         </div>

         <!-- End Projects -->

         </div>

         </div>

         </div>

         <!-- End Contact Content Section -->

         <div id="stickyBlockEndPoint"></div>

      </main>

      <!-- ========== END MAIN ========== -->