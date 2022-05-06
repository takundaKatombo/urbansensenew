<div class="content-inner">
    <!-- Page Header-->
    <header class="page-header">
        <div class="container-fluid">
            <h2 class="no-margin-bottom"><?php (isset($user)) ? 'Add' : 'Update'?>  Service Provider</h2>
        </div>
    </header>
    <?php $this->load->view('errors/error');?>
    <!-- Dashboard Counts Section-->
    <section class="dashboard-counts no-padding-bottom">
        <div class="container-fluid">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h3 class="h4"><?=$title?></h3>
                    </div>
                    <div class="card-body">
                        <form action="" method="post" enctype="multipart/form-data">

                            <fieldset>
                                <legend>Basic Details</legend>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title">First Name</label>
                                            <input type="text" name="first_name" id="first_name" placeholder="Please enter your first name"
                                                value="<?=@$user ? $user->first_name : @set_value('first_name');?>" class="form-control"
                                                required="required">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title">Last Name</label>
                                            <input type="text" name="last_name" id="last_name" placeholder="Please enter your last name"
                                                value="<?=@$user ? $user->last_name : @set_value('last_name');?>" class="form-control"
                                                required="required">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title">Email</label>
                                            <input type="email" name="email" id="email" placeholder="Please enter your valid email"
                                                value="<?=@$user ? $user->email : @set_value('email');?>" class="form-control" required="required">
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title">Phone</label>
                                            <input type="text" name="phone" id="phone" onkeyup="this.value=this.value.replace(/[^\d]/,'')"
                                                placeholder="Please enter your phone number" value="<?=@$user ? $user->phone : @set_value('phone');?>"
                                                class="form-control" required="required" maxlength="10">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title">Primary Profession</label>
                                            <select name="service_id[]" id="service_id[]" required="required" class="form-control" multiple="multiple">

                                                <?php foreach ($services as $row) {?>
                                                <option value="<?=$row->id;?>"
                                                    <?=(isset($user) and in_array($row->id, $user->id_associated_services())) ? 'selected' : ''?>
                                                    <?=(set_select('service_id[]', $row->id))?>><?=$row->title?></option>
                                                <?php }?>

                                            </select>
                                        </div>
                                    </div>

                                    <?php if (!@$user) {?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title">Password</label>
                                            <input type="password" name="password" id="password" placeholder="Please enter your password" value=""
                                                class="form-control" required="required">
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title">Confirm Password</label>
                                            <input type="password" name="confirm_password" id="confirm_password"
                                                placeholder="Please enter your confirm password" value="" class="form-control" required="required">
                                        </div>
                                    </div>
                                    <?php }?>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>Professional Details</legend>
                                <div class="row">
                                    <div class="col-md-6">

                                        <label for="address">Address</label>
                                        <div class="js-focus-state input-group u-form">
                                            <input class="form-control u-form__input" name="address" id="my-address"
                                                value="<?=@$user ? $user->professionals->address : @set_value('address');?>" type="text"
                                                autocomplete="off">
                                            <?=invalid_error('address')?>
                                        </div>
                                        <input name="longitude" id="longitude"
                                            value="<?=@$user ? $user->professionals->longitude : @set_value('longitude');?>" required="" type="hidden">
                                        <input name="latitude" id="latitude" required=""
                                            value="<?=@$user ? $user->professionals->latitude : @set_value('latitude');?>" type="hidden">

                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title">City</label>
                                            <select name="city_id" id="city_id" required="required" class="form-control">
                                                <option>Select City</option>
                                                <?php foreach ($cities as $row) {?>
                                                <option value="<?=$row->id;?>" <?=($row->id == @$user->professionals->city_id) ? 'selected' : ''?>
                                                    <?=(@$_POST['city_id'] == $row->id) ? 'selected' : '';?>>
                                                    <?=$row->title?></option>
                                                <?php }?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="company_name">Company Name</label>
                                            <input type="text" name="company_name" id="company_name" placeholder="Providers company name"
                                                value="<?=@$user ? $user->professionals->company_name : @set_value('company_name');?>" class="form-control" />
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="id_type">ID Type</label>
                                            <select id="id_type" name="id_type" class="form-control u-form__input">
                                                <option value="">Select ID Type <?=$user->professionals->id_type;?></option>
                                                <option value="RSA ID Card/Green ID Book" <?=((!empty(@$user->professionals->id_type) && $user->professionals->id_type == 'RSA ID Card/Green ID Book') or (isset($_POST['id_type']) and $_POST['id_type'] == 'RSA ID Card/Green ID Book')) ? 'selected="selected"' : ''?>>RSA ID Card/Green ID Book</option>
                                                <option value="Foreign Passport" <?=((!empty(@$user->professionals->id_type) && $user->professionals->id_type == 'Foreign Passport') or (isset($_POST['id_type']) and $_POST['id_type'] == 'Foreign Passport')) ? 'selected="selected"' : ''?>>Foreign Passport</option>
                                            </select>
                                            <?=invalid_error('id_type')?>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="id_number">ID Number</label>
                                            <input type="text" name="id_number" id="id_number" placeholder="Provider ID card number"
                                                value="<?=@$user ? $user->professionals->id_number : @set_value('id_number');?>" class="form-control" />
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title">Upload ID Proof Image</label>
                                            <input class="form-control u-form__input" accept="image/*" name="id_card_image" placeholder="Please upload a valid ID card image ." aria-label="" data-msg="Please upload a valid ID card image ." data-error-class="u-has-error" data-success-class="u-has-success" type="file" />
                                            <?= invalid_error('id_card_image') ?>
                                            <?php if ($user->professionals->id_card_image != ''): ?>
                                                <p style="width: 100%;">
                                                    <img src="<?= base_url('uploads/id_card_image/') . $user->professionals->id_card_image; ?>" width="200" />
                                                </p>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title">Upload Bank Passbook Image</label>
                                            <input class="form-control u-form__input" accept="image/*" name="bank_passbook_image" placeholder="Please upload a valid bank passbook image ." aria-label="" data-msg="Please upload a valid bank passbook image ." data-error-class="u-has-error" data-success-class="u-has-success" type="file">
                                            <?= invalid_error('bank_passbook_image') ?>
                                            <?php if ($user->professionals->bank_passbook_image != '') { ?>
                                                <p style="width: 100%;">
                                                    <img src="<?= base_url('uploads/bank_passbook_image/') . $user->professionals->bank_passbook_image; ?>" width="200">
                                                </p>

                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="introduction">Company Introduction</label>
                                            <textarea class="form-control" name="introduction" id="introduction" rows="3"><?=@$user ? $user->professionals->introduction : @set_value('introduction');?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="company_detail">Company Details</label>
                                            <textarea class="form-control" name="company_detail" id="company_detail" rows="3"><?=@$user ? $user->professionals->company_detail : @set_value('company_detail');?></textarea>
                                        </div>
                                    </div>

                                    
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>Bank Account Details</legend>
                                <small>It is required to transfer the payouts to the service providers.</small>
                                <div class="row">
                                    <div class="col-md-6">

                                        <label for="account_holder_name">Account Holder Name</label>
                                        <div class="js-focus-state input-group u-form">
                                            <input class="form-control u-form__input" name="account_holder_name"
                                                value="<?=@$user ? $user->professionals->account_holder_name : @set_value('address');?>" type="text"
                                                autocomplete="off">
                                            <?=invalid_error('account_holder_name')?>
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="ifsc">Bank Name</label>
                                            <div class="js-focus-state input-group u-form">
                                            <input class="form-control u-form__input" name="ifsc"
                                                value="<?=@$user ? $user->professionals->ifsc : @set_value('ifsc');?>" type="text"
                                                autocomplete="off">
                                            <?=invalid_error('ifsc')?>
                                        </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="branch">Branch Code</label>
                                            <input type="text" name="branch" id="branch" placeholder="" value="<?=@$user ? $user->professionals->branch : @set_value('branch');?>"
                                                class="form-control">
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="account_number">A/C Number</label>
                                            <input type="text" name="account_number" id="account_number"
                                                placeholder="" value="<?=@$user ? $user->professionals->account_number : @set_value('account_number');?>" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <button type="submit" class="btn btn-default" id="sub"><?=@$user ? 'Update User' : 'Add User';?></button>

                        </form>
                    </div>

                </div>
            </div>
    </section>