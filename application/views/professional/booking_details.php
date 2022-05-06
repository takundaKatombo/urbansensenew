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
                  <h5 class="book">Booking Detail</h5>
              </div>
          </div>
          <div class="row">
              <div class="col-md-12">
                  <div class="card4">
                      <div class="row service">
                          <div class="col-md-6">
                              <h5>Payment ID</h5>
                              <p class="font-size-14"><?= $booking->payment_key ?></p>
                          </div>

                          <div class="col-md-6">
                              <h5>Booking ID</h5>
                              <p class="font-size-14"><?= $booking->booking_reference_number ?></p>
                          </div>
                      </div>
                      <div class="row service">

                          <div class="col-md-6">
                              <h5>Price</h5>
                              <p class="font-size-14"><?= $booking->currency . ' ' . $booking->amount_paid ?></p>
                          </div>

                          <div class="col-md-6">
                              <h5>Service</h5>
                              <p class="font-size-14"><?= get_service($booking->service_id) ?></p>
                          </div>
                      </div>


                      <div class="row service">
                          <div class="col-md-6">
                              <h5>Customer Name</h5>
                              <p class="font-size-14">
                                  <?= $booking->customer_name ?>
                              </p>
                          </div>

                          <div class="col-md-6">
                              <h5>Customer Phone</h5>
                              <p class="font-size-14">
                                  <?= $booking->customer_phone ?>
                              </p>
                          </div>
                      </div>

                      <div class="row service">

                          <div class="col-md-6">
                              <h5>Customer email</h5>
                              <p class="font-size-14">
                                  <?= $booking->customer_email ?>
                              </p>
                          </div>

                          <div class="col-md-6">
                              <h5>Customer Address</h5>
                              <p class="font-size-14">
                                  <?= $booking->customer_address ?>
                              </p>
                          </div>
                      </div>


                      <div class="row service">

                          <div class="col-md-6">
                              <h5>Customer required date</h5>
                              <p class="font-size-14">
                                  <?= date('d M Y', strtotime($booking->required_date)); ?>
                              </p>
                          </div>

                          <div class="col-md-6">
                              <h5>Customer required time</h5>
                              <p class="font-size-14">
                                  <?= $booking->required_time ?>
                              </p>
                          </div>
                      </div>

                      <div class="row service">
                          <div class="col-md-6">
                              <h5>Payment Date</h5>
                              <p class="font-size-14"><?= date('d M Y | h:i a', strtotime($booking->created_at)) ?></p>
                          </div>
                          <div class="col-md-6">
                              <h5>Download Invoice</h5>
                              <p class="font-size-14"><a href="<?= base_url('professional/Dashboard/download_invoice/') . $booking->payment_key; ?>"><img src="<?= base_url('assets/download.png') ?>" width="150" height="70"></a></p>
                          </div>

                      </div>
                  </div>
              </div>


          </div>

      </div>
  </main>
  <!-- ========== END MAIN ========== -->