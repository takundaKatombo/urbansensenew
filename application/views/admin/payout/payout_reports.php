
<div class="content-inner">
<!-- Page Header-->
<header class="page-header">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-12">
              
            
            <div class="float-left"><h1>Payout Report</h1></div>

            <div class="float-right"> <a href='<?= base_url('admin/Payouts/exports_payout_report') ?>' class="float-right">Download Report</a></div>
        
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
               <form action="<?= base_url('admin/Payouts/payout_report') ?>" method="get">
                  <div class="row">
                     <div class="col-md-3">
                       <input class="form-control datepicker" type="text" value="<?= @$this->input->get('start_date'); ?>" placeholder="Select start date" name="start_date"  title="select start date" autocomplete="off">
                  </div>

                  <div class="col-md-3">
                     <input class="form-control datepicker" type="text" value="<?= @$this->input->get('end_date'); ?>" placeholder="Select end date" name="end_date"  title="select end date" autocomplete="off">
                  </div>

                  <div class="col-md-3">
                        <input type="text" class="form-control" value="<?= @$this->input->get
                         ('name'); ?>" placeholder="Search " name="name">
                        
                  </div>

                 

               <div class="col-md-3">
                  <button type="submit" class="btn btn-info add" >Search</button>
               </div>
                 
               </div>
            </form>
               
            </div>
            <div class="card-body">
               <div class="table-responsive">
                  <table class="table">
                  <table class="table table-hover" id="customerlist">
                     <thead>
                        <tr>
                           
                           <th>Company Name</th>
                           <th>Booking ID</th>
                           <th>Payment key</th>
                           <th>Amount </th>
                           <th>Payable amount</th>
                           <th>Status</th>
                           <th>Date</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>

                     <?php 
                     $total_amount = 0;
                     $total_payable_amount = 0;

                     if(!isset($payments)){ ?>
                     <td>No data found</td>
                     <?php }else{ foreach ($payments as $row) { ?>
                           <tr>
                              <td><?= get_user($row->professional_id)->professionals->company_name ?></td>
                              <td><?= $row->booking_reference_number; ?></td>
                              <td><?= $row->payment_key; ?></td>
                              <td>ZAR <?= $row->total_amount ?></td>
                              <td>ZAR <?= $row->payable_amount ?></td>
                              <td>
                                 <?php if($row->payment_status == 0){ echo '<span class="badge badge-danger">Pay</span>'; } else  {
                                    echo ' <span class="badge badge-success">Paid</span>';
                                 }?></td>
                              <td><?= date('d-m-Y h:i:s',strtotime($row->created_at)); ?></td>
                              <td><a href="<?= base_url('admin/Payments/payment_details/').$row->id ?>"><i class="fa fa-info-circle"></i></a>
                              </td>
                           </tr>

                        <?php
                         $total_amount = $total_amount+$row->total_amount;
                         $total_payable_amount = $total_payable_amount + $row->payable_amount;

                       } ?>
                           <th></th>
                           <th>Total Payment</th>
                           <th>ZAR <?= $total_amount ?>  </th>
                           <th>Total Payable amount</th>
                           <th>ZAR <?= $total_payable_amount ?> </th>
                           <th></th>
                           <th></th>
                           <th></th>

                        <?php }?>

                       
                     </tbody>
                  </table>
               </div>
            </div>
          <div class="text-center"><?= @$pagination ?></div>  
         </div>
      </div>
   </div>
</section>