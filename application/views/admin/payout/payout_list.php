
<div class="content-inner">
<!-- Page Header-->
<header class="page-header">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-12">
          <h1>Payout List</h1>
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
               <form action="<?= base_url('admin/Payouts/payout_search') ?>" method="get">
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
                   
                    // print_r($payments); die;
                     if(empty($payments)){ ?>
                     <td>No data found</td>
                     <?php }else{ 
                     	foreach ($payments as $row) {  ?>

                          
                                    
                                 
                           <tr>
                              <td><?= get_user($row->professional_id)->professionals->company_name ?></td>
                              <td><?= $row->booking_reference_number; ?></td>
                              <td><?= $row->payment_key; ?></td>
                              <td>ZAR <?= $row->amount_paid ?></td>
                              <td>ZAR <?= ($row->amount_paid) - ($row->amount_paid*10)/100 ?></td>
                              <td>
                                 <?php if(get_quotation_response($row->response_for_quote_id)->quote_request->status == 0){ echo '<span class="badge badge-danger">Cancel Request</span>'; } else if(get_quotation_response($row->response_for_quote_id)->quote_request->status == 1) { echo '<span class="badge badge-secondary">Ongoing Request</span>'; 
                                 } else if(get_quotation_response($row->response_for_quote_id)->quote_request->status==2){ echo '<span class="badge badge-info">Service Booked</span>'; } else {
                                    echo ' <span class="badge badge-success">Service Complete</span>';
                                 }?></td>
                              <td><?= date('d-m-Y h:i:s',strtotime($row->created_at)); ?></td>
                              <td>
                                 <form method="post" onsubmit="return validate(this);" action="<?= base_url('admin/Payouts/create'); ?>">
                                    <input type="hidden" name="professional_id" id="professional_id" value="<?= $row->professional_id ?>">
                                    <input type="hidden" name="booking_reference_number" id="booking_reference_number" value="<?= $row->booking_reference_number ?>">
                                     <input type="hidden" name="booking_id" id="booking_id" value="<?= $row->id ?>">
                                    <input type="hidden" name="payment_key" id="payment_key" value="<?= $row->payment_key ?>">
                                    <input type="hidden" name="percent_cost_cut" id="percent_cost_cut" value="10">
                                    <input type="hidden" name="total_amount" id="total_amount" value="<?= $row->amount_paid ?>">
                                    <input type="hidden" name="payable_amount" id="payable_amount" value="<?= ($row->amount_paid) - ($row->amount_paid*10)/100 ?>">
                                    <input type="hidden" name="payment_status" id="payment_status" value="1">
                                    <input type="hidden" name="booking_date" id="booking_date" value="<?= $row->created_at ?>">
                                  <?php if(get_payout_status($row->payment_key)){ ?>
                                      <button type="button" class=" btn-danger">Paid</button>
                                  <?php } else { ?>
                                     <button type="submit" class=" btn-success">Pay</button>
                                       
                                  <?php } ?>
                                 </form>
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