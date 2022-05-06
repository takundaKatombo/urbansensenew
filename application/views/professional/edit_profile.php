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
         <!-- Form -->

         <!-- Title -->

         <!-- End Title -->
         <div class="row">


             <div class="col-md-12">
                 <form class="js-validate mt-5" novalidate="novalidate" action="<?= base_url('edit-profile') ?>" method="post" enctype='multipart/form-data'>
                     <div class="row">
                         <div class="col-md-6  ">
                             <div class="js-form-message mb-6">
                                 <label class="h6 small d-block text-uppercase">First Name</label>

                                 <div class="js-focus-state input-group u-form">
                                     <input class="form-control u-form__input" name="first_name" value="<?= @$_POST['first_name'] ? @$_POST['first_name'] : $user->first_name; ?>" required="" placeholder="First Name" aria-label="********" data-msg="Please enter a valid Name" data-error-class="u-has-error" data-success-class="u-has-success" type="text">
                                     <?= invalid_error('first_name') ?>
                                 </div>
                             </div>

                             <div class="js-form-message mb-6">
                                 <label class="h6 small d-block text-uppercase">Email address</label>

                                 <div class="js-focus-state input-group u-form">
                                     <input class="form-control u-form__input" name="email" value="<?= $user->email; ?>" required="" placeholder="jack@walley.com" aria-label="jack@walley.com" data-msg="Please enter a valid email address." data-error-class="u-has-error" data-success-class="u-has-success" type="email" readonly="readonly">
                                     <?= invalid_error('email') ?>
                                 </div>
                             </div>

                             <div class="js-form-message mb-6">
                                 <label class="h6 small d-block text-uppercase">Company Name </label>
                                 <div class="js-focus-state input-group u-form">
                                     <input class="form-control u-form__input" name="company_name" value="<?= @$_POST['company_name'] ? @$_POST['company_name'] : $user->professionals->company_name ?>" required="" placeholder="Please enter your company name" aria-label="jack@walley.com" data-msg="Please enter a company name." data-error-class="u-has-error" data-success-class="u-has-success" type="text">
                                     <?= invalid_error('company_name') ?>
                                 </div>
                             </div>

                             <div class="js-form-message mb-6">
                                 <label class="h6 small d-block text-uppercase">ID Type</label>
                                 <div class="js-focus-state input-group u-form">
                                     <select id="id_type" name="id_type" class="form-control u-form__input">
                                         <option value="<?= $user->professionals->id_type; ?>">Select ID Type</option>
                                         <option value="RSA ID Card/Green ID Book" <?= ((!empty(@$user->professionals->id_type) && $user->professionals->id_type == 'RSA ID Card/Green ID Book') or (isset($_POST['id_type']) and $_POST['id_type'] == 'RSA ID Card/Green ID Book')) ? 'selected="selected"' : ''  ?>>RSA ID Card/Green ID Book</option>
                                         <option value="Foreign Passport" <?= ((!empty(@$user->professionals->id_type) && $user->professionals->id_type == 'Foreign Passport') or (isset($_POST['id_type']) and $_POST['id_type'] == 'Foreign Passport')) ? 'selected="selected"' : ''  ?>>Foreign Passport</option>
                                     </select>
                                     <?= invalid_error('id_type') ?>
                                 </div>
                             </div>

                             <div class="js-form-message mb-6">
                                 <label class="h6 small d-block text-uppercase">Upload ID Card Image</label>

                                 <div class="js-focus-state input-group u-form">
                                     <input class="form-control u-form__input" accept="image/*" name="id_card_image" placeholder="Please upload a valid ID card image ." aria-label="" data-msg="Please upload a valid ID card image ." data-error-class="u-has-error" data-success-class="u-has-success" type="file" readonly="readonly" <?= ($loggedin_user->verification != 1) ? '' : 'disabled="disabled"' ?>>
                                     <?= invalid_error('id_card_image') ?>
                                     <?php if ($user->professionals->id_card_image != '') { ?>
                                         <p style="width: 100%;">
                                             <img src="<?= base_url('uploads/id_card_image/') . $user->professionals->id_card_image; ?>" width="200" />
                                         </p>
                                     <?php } ?>
                                     <p>
                                         <?= ($loggedin_user->verification != 1) ? '' : '<small>Please contact to ' . $site_data->email . ' to update ID card</small>' ?>
                                     </p>
                                 </div>
                             </div>


                         </div>
                         <div class=" col-md-6 ">
                             <div class=" js-form-message mb-6">
                                 <label class="h6 small d-block text-uppercase">Last Name</label>

                                 <div class="js-focus-state input-group u-form">
                                     <input class="form-control u-form__input" name="last_name" value="<?= @$_POST['last_name'] ? @$_POST['last_name'] :  $user->last_name; ?>" required="" placeholder="Last Name" aria-label="Last Name" data-msg="Please enter a valid Name" data-error-class="u-has-error" data-success-class="u-has-success" type="text">
                                     <?= invalid_error('last_name') ?>
                                 </div>
                             </div>
                             <div class="js-form-message mb-6">
                                 <label class="h6 small d-block text-uppercase">Mobile Number</label>

                                 <div class="js-focus-state input-group u-form">
                                     <input class="form-control u-form__input" name="phone" value="<?= $user->phone; ?>" required="" placeholder="Please enter your cell phone number" aria-label="" data-msg="Please enter a valid phone number." data-error-class="u-has-error" data-success-class="u-has-success" type="text" readonly="readonly">
                                     <?= invalid_error('phone') ?>
                                 </div>
                             </div>

                             <div class="js-form-message mb-6">
                                 <label class="h6 small d-block text-uppercase">City</label>
                                 <div class="js-focus-state input-group u-form">
                                     <select name="location" class="form-control u-form__input" autocomplete="off" spellcheck="false">
                                         <?php foreach ($cities as $row) { ?>
                                             <option value="<?= $row->id ?>" <?= $user->professionals->city_id == $row->id ? 'selected="selected"' : '' ?>><?= $row->title ?></option>
                                         <?php } ?>
                                     </select>
                                     <?= invalid_error('city') ?>

                                 </div>
                             </div>
                             <input class="form-control u-form__input" name="longitude" id="longitude" value="<?= @$_POST['longitude'] ? @$_POST['longitude'] :  $user->professionals->longitude; ?>" required="" type="hidden">
                             <input class="form-control u-form__input" name="latitude" id="latitude" required="" value="<?= @$_POST['latitude'] ? @$_POST['latitude'] :  $user->professionals->latitude ?>" type="hidden">

                             <div class="js-form-message mb-6">
                                 <label class="h6 small d-block text-uppercase">ID Number</label>

                                 <div class="js-focus-state input-group u-form">
                                     <input class="form-control u-form__input" name="id_number" value="<?= @$_POST['id_number'] ? @$_POST['id_number'] :  $user->professionals->id_number ?>" required="" placeholder="Enter your id number" aria-label="" data-msg="Please enter a valid id number." data-error-class="u-has-error" data-success-class="u-has-success" type="text">
                                     <?= invalid_error('id_number') ?>
                                 </div>
                             </div>

                             <div class="js-form-message mb-6">
                                 <label class="h6 small d-block text-uppercase">Upload Bank Passbook Image</label>

                                 <div class="js-focus-state input-group u-form">
                                     <input class="form-control u-form__input" accept="image/*" name="bank_passbook_image" placeholder="Please upload a valid bank passbook image ." aria-label="" data-msg="Please upload a valid bank passbook image ." data-error-class="u-has-error" data-success-class="u-has-success" type="file" readonly="readonly" <?= ($loggedin_user->verification != 1) ? '' : 'disabled="disabled"' ?>>
                                     <?= invalid_error('bank_passbook_image') ?>
                                     <?php if ($user->professionals->bank_passbook_image != '') { ?>
                                         <p style="width: 100%;">
                                             <img src="<?= base_url('uploads/bank_passbook_image/') . $user->professionals->bank_passbook_image; ?>" width="200">
                                         </p>

                                     <?php } ?>
                                     <p>
                                         <?= ($loggedin_user->verification != 1) ? '' : '<small>Please contact to ' . $site_data->email . ' to update bank passbook</small>' ?>
                                     </p>

                                 </div>
                             </div>

                         </div>
                         <div class=" col-md-12 ">
                             <div class=" js-form-message mb-6">
                                 <label class="h6 small d-block text-uppercase">Address</label>

                                 <div class="js-focus-state input-group u-form">
                                     <input class="form-control u-form__input" name="address" id="my-address" value="<?= @$_POST['address'] ? @$_POST['address'] :  $user->professionals->address; ?>" type="text" onmouseover="codeAddress();">
                                     <?= invalid_error('address') ?>
                                 </div>
                             </div>


                             <div class="js-form-message mb-6">
                                 <label class="h6 small d-block text-uppercase">Service</label>

                                 <div class="js-focus-state input-group u-form">
                                     <select name="service[]" class="form-control u-form__input" placeholder="Your service" multiple>
                                         <option value="">Select Services</option>
                                         <?php foreach ($services as $row) { ?>
                                             <option value="<?= $row->id ?>" <?= (isset($user) and in_array($row->id, $user->id_associated_services())) ? 'selected' : '' ?>><?= $row->title ?></option>
                                         <?php } ?>
                                     </select>
                                     <?= invalid_error('service') ?>

                                 </div>
                             </div>

                             <div class="row">
                                 <div class="col-md-3">
                                     <div class="js-form-message mb-6">
                                         <label class="h6 small d-block text-uppercase">Account holder name</label>

                                         <div class="js-focus-state input-group u-form">
                                             <textarea class="form-control u-form__input" name="account_holder_name" required="" placeholder="Account holder name" aria-label="jack@walley.com" data-msg="Please enter bank account holder name." data-error-class="u-has-error" data-success-class="u-has-success"><?= @$_POST['account_holder_name'] ? @$_POST['account_holder_name'] :  $user->professionals->account_holder_name; ?></textarea>
                                             <?= invalid_error('account_holder_name') ?>
                                         </div>
                                     </div>
                                 </div>



                                 <div class="col-md-3">
                                     <div class="js-form-message mb-6">
                                         <label class="h6 small d-block text-uppercase">Bank Name</label>

                                         <div class="js-focus-state input-group u-form">
                                             <textarea class="form-control u-form__input" name="ifsc" required="" placeholder="Bank Name" aria-label="jack@walley.com" data-msg="Please enter bank name." data-error-class="u-has-error" data-success-class="u-has-success"><?= @$_POST['ifsc'] ? @$_POST['ifsc'] : $user->professionals->ifsc; ?></textarea>
                                             <?= invalid_error('ifsc') ?>
                                         </div>
                                     </div>
                                 </div>

                                 <div class="col-md-3">
                                     <div class="js-form-message mb-6">
                                         <label class="h6 small d-block text-uppercase">Branch </label>

                                         <div class="js-focus-state input-group u-form">
                                             <textarea class="form-control u-form__input" name="branch" required="" placeholder="Branch" aria-label="jack@walley.com" data-msg="Please enter branch." data-error-class="u-has-error" data-success-class="u-has-success"><?= @$_POST['branch'] ? @$_POST['branch'] : $user->professionals->branch; ?></textarea>
                                             <?= invalid_error('branch') ?>
                                         </div>
                                     </div>
                                 </div>


                                 <div class="col-md-3">
                                     <div class="js-form-message mb-6">
                                         <label class="h6 small d-block text-uppercase">Account Number</label>

                                         <div class="js-focus-state input-group u-form">
                                             <textarea class="form-control u-form__input" name="account_number" required="" placeholder="Account Number" aria-label="jack@walley.com" data-msg="Please enter account number." data-error-class="u-has-error" data-success-class="u-has-success"><?= @$_POST['account_number'] ? @$_POST['account_number'] : $user->professionals->account_number; ?></textarea>
                                             <?= invalid_error('account_number') ?>
                                         </div>
                                     </div>
                                 </div>
                             </div>

                             <div class="js-form-message mb-6">
                                 <label class="h6 small d-block text-uppercase">Company Introduction</label>

                                 <div class="js-focus-state input-group u-form">
                                     <textarea class="form-control u-form__input" name="introduction" required="" placeholder="Company Introduction" aria-label="jack@walley.com" data-msg="Please enter ypur company introduction." data-error-class="u-has-error" data-success-class="u-has-success"><?= @$_POST['introduction'] ? @$_POST['introduction'] : $user->professionals->introduction; ?></textarea>
                                     <?= invalid_error('introduction') ?>
                                 </div>
                             </div>

                             <div class="js-form-message mb-6">
                                 <label class="h6 small d-block text-uppercase">Company Detail</label>

                                 <div class="js-focus-state input-group u-form">
                                     <textarea class="form-control u-form__input text-editor" name="company_detail" required="" placeholder="Company Details" aria-label="jack@walley.com" data-msg="Please enter your company detail." data-error-class="u-has-error" data-success-class="u-has-success"><?= @$_POST['company_detail'] ? @$_POST['company_detail'] : $user->professionals->company_detail; ?></textarea>
                                     <?= invalid_error('company_detail') ?>
                                 </div>
                             </div>
                             <button type="submit" class="btn btn-primary u-btn-primary transition-3d-hover but1">Update</button>

                         </div>
                     </div>
                 </form>
             </div>
         </div>

         <!--   <div class="row">
            <?php foreach ($user->professional_images as $row) { ?>
                    <div class="col-md-3 mb-6 mt-5">
                        <div class="imageulpod">
                            <img src="<?= base_url('uploads/image/') . $row->image ?>" alt="" width="250" height="250">
                        </div>
                        <div class="pull-right">
                          Make Profile Picture : <input type="radio" name="default1" value="<?= $row->id; ?>" id="default1" onclick ="make_default1(<?= $row->id ?>);"  <?php if ($row->default_image == 1) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                          Delete :  <a href="<?= base_url("professional/Profile/delete_image/{$row->id}") ?>" class="pull-right delete-button"><i class="fa fa-trash"></i></a>
                        </div>
                </div>
            <?php  } ?>
            <div class="col-md-4">
                <form class="js-validate mt-5" novalidate="novalidate" action="<?= base_url('professional/Profile/create_service_images') ?>" method="post" enctype="multipart/form-data">
                    <div class="col-md-12">
                        <center> <label class="h6 small d-block text-uppercase mb-2">Upload Image</label></center>

                        <div class="js-focus-state input-group u-form">
                             <input class="form-control u-form__input" name="image" value="" required="" placeholder="Please select a image" aria-label="" data-msg="Please select a image" data-error-class="u-has-error" data-success-class="u-has-success" type="file" accept="image/*">
                            <?= invalid_error('image') ?>
                        </div>
                           
                    </div>

                   <center><button type="submit" class="btn btn-primary u-btn-primary transition-3d-hover mt-2">Submit</button></center> 

                </form>
            </div>
        </div> -->
     </div>

     <!-- End Form -->

     </div>

     <!-- End Contact Content Section -->

     <div id="stickyBlockEndPoint"></div>
 </main>
 <!-- ========== END MAIN ========== -->