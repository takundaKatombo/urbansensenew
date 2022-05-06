
<div class="content-inner">
<!-- Page Header-->
<header class="page-header">
   <div class="container-fluid">
      <h2 class="no-margin-bottom">Ongoing Booking Details</h2>
      <div class="right-menu">
        
      </div>
   </div>
</header>
 <?php $this->load->view('errors/error'); ?> 
<section class="tables">
   <div class="container-fluid">
      <div class="col-lg-12">
         <div class="card">
            
            <div class="card-header d-flex align-items-center">
               <h3 class="h4">Ongoing Booking Details</h3>
            </div>
            <div class="card-body">
               <div class="row">
                  <div class="col-md-6">Customer Name</div><div class="col-md-6"><?= get_user($booking->user_id)->first_name.' '.get_user($booking->user_id)->last_name ?></div>
               </div>
               <hr>
               <div class="row">
                  <div class="col-md-6">Customr Email</div><div class="col-md-6"><?= get_user($booking->user_id)->email ?></div>
               </div>
               <hr>

               <div class="row">
                  <div class="col-md-6">Customr Phone</div><div class="col-md-6"><?= get_user($booking->user_id)->phone ?></div>
               </div>
               <hr>

                <div class="row">
                  <div class="col-md-6">Service</div><div class="col-md-6"><?= ucwords(get_service($booking->service_id)); ?></div>
               </div>
               <hr>


               <div class="row">
                  <div class="col-md-6">Service Detail</div><div class="col-md-6"><?= $booking->request_details ?></div>
               </div>
               <hr>
               <div class="row">
                  <div class="col-md-6">Status</div>
                  <div class="col-md-6">
                     <?php if($booking->status == 0){ ?> 
                           <span class="badge badge-danger">REQUEST CANCELLED</span>
                     <?php } else if($booking->status == 1){ ?> 
                        <span class="badge badge-warning">ONGOING REQUEST</span>
                     <?php } else if($booking->status == 2){ ?> 
                        <span class="badge badge-info ">BOOKED</span>
                     <?php } else { ?>
                        <span class="badge badge-success">REQUEST COMPLETED</span>
                     <?php }?></div>
               </div>
               <hr>
               <div class="row">
                  <div class="col-md-6">Reason of cancel request</div><div class="col-md-6"><?= $booking->cancel_request ?></div>
               </div>
               <hr>
               <div class="row">
                  <div class="col-md-6">Preferred Date & Time</div><div class="col-md-6"><?= date('d/m/Y', strtotime($booking->avail_date)).' | '.$booking->avail_time ?></div>
               </div>
               <hr>
               <div class="row">
                  <div class="col-md-6">Date of booking</div><div class="col-md-6"><?= date('d/m/Y h:i:a', strtotime($booking->created_at)) ?></div>
               </div>
               <hr>
               <div class="row">
                  <div class="col-md-6">Last update date</div><div class="col-md-6"><?= date('d/m/Y h:i:a', strtotime($booking->updated_at)) ?></div>
               </div>
               <hr>

               <div class="row">
                  <div class="col-md-12">
                     <b>Service Providers</b>

                     <table class="table table-hover" id="customerlist">
                     <thead>
                        <tr>
                           <th>Service Provider Name</th>
                           <th>Service Provider Email</th>
                           <th>Service Provider Phone</th>
                           <th>Company Name</th>
                           <th>Status</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>

                     <?php if(!isset($booking)){ ?>
                     <td>No data found</td>
                     <?php }else{ foreach ($booking->response_for_proposals as $row) { ?>
                           <tr>
                              <td><?= get_user($row->professional_id)->first_name.' '.get_user($row->professional_id)->last_name; ?></td>
                              <td><?= get_user($row->professional_id)->email; ?></td>
                              <td><?= get_user($row->professional_id)->phone; ?></td>
                               <td><?= get_user($row->professional_id)->professionals->company_name; ?></td>
                              <td>
                              <?php if($row->status == 1){ ?>
                                 <?php  if($row->request_accept == 0){ ?> 
                                    <span class="badge badge-warning">New Request</span>
                                 <?php } else if($row->request_accept == 1){ ?> 
                                    <span class="badge badge-info ">Request Accept</span>
                                 <?php } else { ?>
                                    <span class="badge badge-success">Paid</span>
                                 <?php } } else { echo '<span class="badge badge-danger">Request Cancelled</span>'; } ?></td>
                              <td><a href="<?= base_url('admin/Professionals/professional_detail/').$row->professional_id ?>" target="_blank"><i class="fa fa-info-circle"></i></a></td>
                           </tr>

                        <?php  }  ?>
                        
                    <?php }?>

                       
                     </tbody>
                  </table>
                  </div>
               </div>
               <hr>
            </div>
        
         </div>
      </div>
   </div>
</section>