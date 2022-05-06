  <!-- ========== Main ========== -->
  <main id="content" role="main">
      <div class="container">
          <?php if ($loggedin_user->verification != 1) { ?>
              <div class="col-md-12" style="margin-top: 8px;">
                  <div class="alert alert-warning">
                      Please update your profile and upload relevant documents for account verification purpose. Only verified profiles are entitled to accept orders and payments. <a href="<?= base_url('edit-profile'); ?>">Click here </a> to proceed. If you've already uploaded all documents, please wait while we verify the details. Your account will be activated to receive requests after successful verification.
                  </div>
              </div>
          <?php } ?>
          <div class="row">
              <div class="col-md-12">
                  <h5 class="book"><?= $title;  ?></h5>
              </div>
          </div>
          <div class="row">
              <?php if (!$payments) { ?>
                  <div class="col-md-12">
                      <div class=" mb-3 ">
                          <h1>
                              <center>NO DATA FOUND</center>
                          </h1>
                      </div>
                  </div>
                  <?php } else {
                    foreach ($payments as $row) { ?>
                      <div class="col-md-12">
                          <div class="card mb-3">
                              <div class="row  m-3">
                                  <div class="col-md-3">
                                      <h5>Service</h5>
                                      <p class="font-size-14"><?= ucwords(get_service($row->service_id)) ?></p>
                                  </div>
                                  <div class="col-md-2">
                                      <h5>Customer</h5>
                                      <p class="font-size-14">
                                          <?= $row->customer_name ?>
                                      </p>
                                  </div>
                                  <div class="col-md-2">
                                      <h5>Payment ID</h5>
                                      <p class="font-size-14"><?= $row->payment_key ?></p>
                                  </div>
                                  <div class="col-md-1">
                                      <h5>Price</h5>
                                      <p class="font-size-14">ZAR <?= $row->amount ?></p>
                                  </div>
                                  <div class="col-md-2">
                                      <h5>Payment Date & Time</h5>
                                      <p class="font-size-14"><?= date('d M Y h:i a', strtotime($row->created_at)) ?></p>
                                  </div>
                                  <div class="col-md-2">
                                      <a href="<?= base_url('payment-detail-view/') . $row->id ?>" class="btn btn-primary u-btn-primary transition-3d-hover but1">View Detail</a>
                                  </div>
                              </div>
                          </div>
                      </div>
              <?php }
                } ?>

          </div>
          <div class="text-center"><?= $pagination ?></div>
      </div>
  </main>
  <!-- ========== END MAIN ========== -->