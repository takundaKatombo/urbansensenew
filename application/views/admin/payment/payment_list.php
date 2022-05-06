
<div class="content-inner">
<!-- Page Header -->
<header class="page-header">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-12">
            <h1 class="no-margin-bottom">Payment List</h1>
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
               
               <form action="<?= base_url('admin/Payments/search_payments') ?>" method="get">
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
                     <option value="">Status</option>
                      <option value="initiated" <?= (@$this->input->get('status')=='initiated') ? 'selected' : '' ?>>Initiated</option>
                      <option value="Success" <?= (@$this->input->get('status')=='Success') ? 'selected' : '' ?>>Success</option>
                       <option value="Failed" <?= (@$this->input->get('status')=='Failed') ? 'selected' : '' ?>>Failed</option>
                       <option value="refund" <?= (@$this->input->get('status')=='refund') ? 'selected' : '' ?>>Refund</option>
                  </select>
               </div>

               <div class="col-md-2">
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
                           
                           <th>Payment ID</th>
                           <th>Customer email</th>
                           <th>Customer Name</th>
                           <th>Service Provider</th>
                           <th>Service</th>
                           <th>Price</th>
                           <th>Status</th>
                           <th>Date</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>

                     <?php  $totalamount=0; if(!isset($payments)){ ?>
                     <td>No data found</td>
                     <?php }else{ foreach ($payments as $row) { ?>
                           <tr>
                              <td><?= $row->payment_key; ?></td>
                              <td><?= $row->customer_email ?></td>
                              <td><?= $row->customer_name ?></td>
                              <td><?= get_user($row->professional_id)->professionals->company_name ?></td>
                              <td><?= get_service($row->service_id) ?></td>
                              <td>ZAR <?= $row->amount  ?> </td>
                              <td><?= $row->payment_status; ?></td>
                              <td><?= date('d-m-Y h:i:s',strtotime($row->created_at)); ?></td>
                              <td><a href="<?= base_url('admin/Payments/payment_details/').$row->id ?>"><i class="fa fa-info-circle"></i></a></td>
                           </tr>

                        <?php $totalamount = $totalamount+$row->amount; } ?>
                        <tr>
                           <td></td>
                           <td></td>
                           <td></td>
                           <td></td>
                           <th>Total Payment</th>
                           <th>ZAR <?= $totalamount ?> </th>
                           <td></td>
                           <td></td>
                           <td></td>
                        </tr>
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