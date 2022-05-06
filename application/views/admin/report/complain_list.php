
<div class="content-inner">
<!-- Page Header-->
<header class="page-header">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-12">
          <h1>Customer Complain</h1>
         </div>
      </div>
   </div>
</header>
<?php $this->load->view('errors/error'); ?> 
<section class="tables">
   <div class="container-fluid">
      <div class="col-lg-12">
         <div class="card">
            
            <div class="card-header d-flex align-items-center">
               <!-- <form action="<?= base_url('admin/Payouts/payout_search') ?>" method="get">
                   <div class="row">
                     <div class="col-md-2">
                       <input class="form-control datepicker" type="text" value="<?= @$this->input->get('start_date'); ?>" placeholder="Select start date" name="start_date"  title="select start date" autocomplete="off">
                  </div>

                  <div class="col-md-2">
                     <input class="form-control datepicker" type="text" value="<?= @$this->input->get('end_date'); ?>" placeholder="Select end date" name="end_date"  title="select end date" autocomplete="off">
                  </div>

                  <div class="col-md-4">
                        <input type="text" class="form-control" value="<?= @$this->input->get
                         ('name'); ?>" placeholder="Search " name="name">
                        
                  </div>

                   
                    <div class="col-md-2">
                      <select class="form-control" id="status" name="status">
                         <option value="">Action</option>
                          <option value="0" <?= (@$this->input->get('status')=='0') ? 'selected' : '' ?>>Pay</option>
                          <option value="1" <?= (@$this->input->get('status')=='1') ? 'selected' : '' ?>>Paid</option>
                      </select>
                   </div>

               <div class="col-md-2">
                  <button type="submit" class="btn btn-info add" >Search</button>
               </div>
                 
               </div>
            </form> -->
            </div>
            <div class="card-body">
               <div class="table-responsive">
                  <table class="table">
                  <table class="table table-hover" id="customerlist">
                     <thead>
                        <tr>
                           <th>Customer Name</th>
                           <th>Preferred Date & Time</th>
                           <th>Service Provider Name</th>
                           <th>Service Provider Email</th>
                           <th>Service Provider Phone</th>
                           <th>Refund Amount</th>
                           <th>Service Status</th>
                           <th>Refund Status</th>
                           <th>Date</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>

                     <?php 
                   
                    // print_r($payments); die;
                     if(empty($reports)){ ?>
                     <td>No data found</td>
                     <?php }else{ 
                     	foreach ($reports as $row) {  ?>
                           <tr>
                              <td><?= $row['customer_name'] ?></td>
                              <td><?= $row['preferred_time'] ?></td>
                              <td><?= $row['provider_name'] ?></td>
                              <td><?= $row['provider_email'] ?></td>
                              <td><?= $row['provider_phone'] ?></td>
                              <td><?= $row['amount'] ?></td>
                               <td><?php if($row['status'] == 0){ ?> 
                                 <span class="badge badge-danger">REQUEST CANCELLED</span>
                              <?php } else if($row['status'] == 1){ ?> 
                                 <span class="badge badge-warning">ONGOING REQUEST</span>
                              <?php } else if($row['status'] == 2){ ?> 
                                 <span class="badge badge-info ">BOOKED</span>
                              <?php } else { ?>
                                 <span class="badge badge-success">REQUEST COMPLETED</span>
                              <?php }?></td>
                              <td><?= ($row['refund_status'] == 0) ? '<span class="badge badge-danger">Not Refund</span>' : '<span class="badge badge-success">Refund</span>' ?></td>
                              <td><?= $row['date'] ?></td>
                              <td>
                                <?php if($row['refund_status'] == 0) { ?> 
                                 <a class="btn btn-success refund-button" href="<?= base_url('admin/CustomerReports/refund/'.$row['report_id']) ?>">Refund</a>
                                 <?php  } else { ?>
                                 <button type="button" class="btn btn-danger">Refunded</button>
                                <?php }  ?>

                                </td>
                           </tr>

                        <?php    }  }?>

                       
                     </tbody>
                  </table>
               </div>
            </div>
          <div class="text-center"><?= @$pagination ?></div>  
         </div>
      </div>
   </div>
</section>