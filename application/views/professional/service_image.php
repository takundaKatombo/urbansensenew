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

          <div class="row">
              <?php foreach ($user->professional_images as $row) { ?>
                  <div class="col-md-3 mb-6 mt-5">
                      <div class="imageulpod">
                          <img src="<?= base_url('uploads/image/') . $row->image ?>" alt="" width="250">
                      </div>
                      <div class="pull-right">
                          Make Profile Picture : <input type="radio" name="default1" value="<?= $row->id; ?>" id="default1" onclick="make_default1(<?= $row->id ?>);" <?php if ($row->default_image == 1) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                          Delete : <a href="<?= base_url("professional/Profile/delete_image/{$row->id}") ?>" class="pull-right delete-button"><i class="fa fa-trash"></i></a>
                      </div>
                  </div>
              <?php  } ?>
              <div class="col-md-4">
                  <form class="js-validate mt-5" novalidate="novalidate" action="<?= base_url('professional/Profile/create_service_images') ?>" method="post" enctype="multipart/form-data">
                      <div class="col-md-12">
                          <label class="h6 small d-block text-uppercase mb-2">Upload Image</label>

                          <div class="js-focus-state input-group u-form">
                              <input class="form-control u-form__input" name="image" value="" required="" placeholder="Please select a image" aria-label="" data-msg="Please select a image" data-error-class="u-has-error" data-success-class="u-has-success" type="file" accept="image/*">
                              <input type="hidden" name="name">
                              <?= invalid_error('image') ?>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <button type="submit" class="btn btn-primary u-btn-primary transition-3d-hover mt-2 mb-2">Upload</button>
                          <a class="btn btn-danger transition-3d-hover mt-2 mb-2" href="<?= base_url('profile') ?>">Cancel</a>
                      </div>


                  </form>
              </div>
          </div>

      </div>
  </main>