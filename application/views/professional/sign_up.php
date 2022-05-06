<!-- < !========== MAIN ========== -->

<main id="content" role="main">

    <!-- Contact Content Section -->

    <div class="form-pro">

        <div class="container">

            <div class="col-sm-12">

                <div class="">

                    <div class="container">

                        <!-- Form -->

                        <form class="js-validate mt-5" method="post" action="" novalidate="novalidate">

                            <!-- Title -->

                            <!-- End Title -->

                            <!-- Input -->

                            <div class="row">

                                <div class="col-md-6 mb-4">

                                    <div class="js-form-message u-has-error u-focus-state js-focus-state input-group">

                                        <label class="h6 small d-block text-uppercase">First Name</label>

                                        <div class="js-focus-state input-group u-form u-has-error">

                                            <input class="form-control u-form__input" name="first_name" value="<?= set_value('first_name') ? set_value('first_name') : "" ?>" required="" placeholder="First Name" aria-label="" data-msg="Please enter a valid Name" data-error-class="u-has-error" data-success-class="u-has-success" type="text" aria-describedby="first_name-error">

                                            <?= invalid_error('first_name') ?>



                                        </div>

                                    </div>

                                </div>

                                <div class="js-form-message col-md-6 mb-4">

                                    <label class="h6 small d-block text-uppercase">Last Name</label>

                                    <div class="js-focus-state input-group u-form u-has-error">

                                        <input class="form-control u-form__input" name="last_name" value="<?= set_value('last_name') ? set_value('last_name') : "" ?>" placeholder="Last Name" aria-label="" data-msg="Please enter a valid Name" data-error-class="u-has-error" data-success-class="u-has-success" type="text">

                                        <?= invalid_error('last_name') ?>

                                    </div>

                                </div>

                                <div class="js-form-message col-md-6 mb-4">

                                    <label class="h6 small d-block text-uppercase">Email address</label>

                                    <div class="js-focus-state input-group u-form u-has-error">

                                        <input class="form-control u-form__input" name="email" value="<?= set_value('email') ? set_value('email') : "" ?>" required="" placeholder="jack@walley.com" aria-label="jack@walley.com" data-msg="Please enter a valid email address." data-error-class="u-has-error" data-success-class="u-has-success" type="email">

                                        <?= invalid_error('email') ?>



                                    </div>

                                </div>

                                <div class="js-form-message col-md-6 mb-4">

                                    <label class="h6 small d-block text-uppercase">Mobile Number</label>

                                    <div class="js-focus-state input-group u-form u-has-error">

                                        <input class="form-control u-form__input" name="phone" onkeyup="this.value=this.value.replace(/[^\d]/,'')" value="<?= set_value('phone') ? set_value('phone') : "" ?>" required="" placeholder="" aria-label="" data-msg="Please enter a valid 10 digit phone number." data-error-class="u-has-error" data-success-class="u-has-success" type="text">

                                        <?= invalid_error('phone') ?>

                                    </div>

                                </div>

                                <div class="js-form-message col-md-6 mb-4">

                                    <label for="sel1" class="form-control-label">Your Address</label>

                                    <div class="js-focus-state input-group u-form u-has-error">

                                        <input class="form-control " name="location" id="my-address" value="<?= @$location ? $location : ''; ?>" type="text" autocomplete="off" onkeydown="codeAddress();" onkeyup="codeAddress()" data-msg="Please enter your address." required="required">
                                        <?= invalid_error('location') ?>
                                    </div>
                                </div>

                                <input name="longitude" id="longitude" value="<?= @$longitude ? $longitude : ''; ?>" required="" type="hidden">


                                <input name="latitude" id="latitude" required="" value="<?= @$latitude ? $latitude : ''; ?>" type="hidden">

                                <div class="js-form-message col-md-6 mb-4">

                                    <label for="sel1" class="form-control-label">Your City</label>

                                    <div class="js-focus-state input-group u-form u-has-error">

                                        <select class="form-control" id="city_id" name="city_id" data-msg="Please Select Your City" data-error-class="u-has-error" data-success-class="u-has-success" id="sel1" required="required">

                                            <option value="<?= set_select('city_id') ? set_select('city_id') : "" ?>">Select Your City</option>

                                            <?php if (!empty($cities)) : ?>

                                                <?php foreach ($cities as $row) : ?>

                                                    <option value="<?= $row->id ?>" <?= (isset($_POST['city_id']) and $row->id == $_POST['city_id']) ? 'selected="selected"' : '' ?>><?= $row->title; ?></option>

                                                <?php endforeach; ?>

                                            <?php endif; ?>

                                        </select>

                                        <?= invalid_error('city_id') ?>

                                    </div>

                                </div>



                            </div>


                            <div class="js-form-message col-md-12 mb-4 pl-0 pr-0" style="line-height: 2;">

                                <label for="sel1" class="form-control-label">Your Primary Services</label>

                                <div class="js-focus-state input-group u-form u-has-error">

                                    <select class="form-control u-form__input" id="service_id[]" name="service_id[]" data-msg="Please Select Your Profession" data-error-class="u-has-error" data-success-class="u-has-success" required="required" multiple>

                                        <option value="<?= set_select('service_id') ? set_select('service_id') : "" ?>">Select Your Primary Profession</option>
                                        <?php foreach ($services as $row) { ?>
                                            <option value="<?= $row->id ?>" <?= isset($_POST['service_id']) and in_array($row->id, @$_POST['service_id']) ? 'selected="selected"' : '' ?>><?= $row->title ?></option>
                                        <?php } ?>
                                    </select>
                                    <?= invalid_error('service_id') ?>
                                </div>
                            </div>

                            <div class="row">

                                <div class="js-form-message col-md-6 mb-4">

                                    <label class="h6 small d-block text-uppercase">Password</label>

                                    <div class="js-focus-state input-group u-form u-has-error">

                                        <input class="form-control u-form__input" name="password" required="" placeholder="********" aria-label="********" data-msg="Please Enter Your password." data-error-class="u-has-error" data-success-class="u-has-success" type="password">

                                        <?= invalid_error('password') ?>

                                    </div>

                                </div>

                                <div class="js-form-message col-md-6 mb-4">

                                    <label class="h6 small d-block text-uppercase">Confirm Password</label>

                                    <div class="js-focus-state input-group u-form u-has-error">

                                        <input class="form-control u-form__input" name="confirm_password" required="" placeholder="********" aria-label="********" data-msg="Password does not match the confirm password." data-error-class="u-has-error" data-success-class="u-has-success" type="password">

                                        <?= invalid_error('confirm_password') ?>

                                    </div>

                                </div>

                            </div>



                            <div class="row">

                                <div class="col-12">

                                    <div class="form-group">

                                        <input type="checkbox" name="terms_conditions" value="1" <?= (isset($_POST['terms_conditions']) and $_POST['terms_conditions'] == '1') ? 'checked="checked"' : '' ?> aria-label="Please accept terms and conditions" data-msg="Please accept terms and conditions" data-error-class="u-has-error" data-success-class="u-has-success"> I accept <a href="<?= base_url($site_data->terms_conditions) ?>" target="_blank"> terms and conditions </a>.

                                        <?= invalid_error('terms_conditions') ?>

                                    </div>

                                </div>

                            </div>



                            <div class="row">

                                <div class="col-md-6 mb-4">

                                    <button type="submit" class="btn btn-primary u-btn-primary transition-3d-hover">Submit</button>

                                </div>

                            </div>

                        </form>

                    </div>

                    </form>

                    <!-- End Form -->

                </div>

            </div>

        </div>

        <!-- End Contact Content Section -->

        <div id="stickyBlockEndPoint"></div>

</main>



<!-- ========== END MAIN ==========