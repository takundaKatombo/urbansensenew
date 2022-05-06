  <!-- ========== Main ========== -->
  <main id="content" role="main">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h5 class="book"><?= $title;  ?></h5>
              </div>
          </div>
          <div class="row">
              <?php if (!$bookings) { ?>
                  <div class="col-md-12">
                      <div class=" mb-3 ">
                          <h1>
                              <center>NO DATA FOUND</center>
                          </h1>
                      </div>
                  </div>
                  <?php } else {
                    foreach ($bookings as $row) { ?>
                      <div class="col-md-12">
                          <div class="card mb-3">
                              <div class="row  m-3">
                                  <div class="col-md-4">
                                      <h5>Service</h5>
                                      <p class="font-size-14"><?= ucwords(get_service($row->service_id)) ?></p>
                                  </div>
                                  <div class="col-md-3">
                                      <h5>Status</h5>
                                      <p class="font-size-14">
                                          <?php if ($row->status == 0) { ?>
                                              <span class="badge badge-danger">REQUEST CANCELLED</span>
                                          <?php } else if ($row->status == 1) { ?>
                                              <span class="badge badge-success">ONGOING REQUEST</span>
                                          <?php } else if ($row->status == 2) { ?>
                                              <span class="badge badge-success">BOOKED</span>
                                          <?php } else { ?>
                                              <span class="badge badge-info">REQUEST COMPLETED</span>
                                          <?php } ?>
                                      </p>
                                  </div>
                                  <div class="col-md-3">
                                      <h5> Date Posted</h5>
                                      <p class="font-size-14"><?= date('d M Y', strtotime($row->created_at)) ?></p>
                                  </div>
                                  <div class="col-md-2">
                                      <a href="<?= base_url('booking-detail/') . $row->id ?>" class="btn btn-primary u-btn-primary transition-3d-hover but1">View Detail</a>
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