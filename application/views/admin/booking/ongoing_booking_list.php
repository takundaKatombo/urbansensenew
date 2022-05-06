
<div class="content-inner">
<!-- Page Header-->
<header class="page-header">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-12">
            <h1 class="no-margin-bottom">Ongoing Booking List</h1>
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
               
            <form action="<?= base_url('admin/OngoingBookings/search_bookings') ?>" method="get">
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
                      <option value="0" <?= (@$this->input->get('status')=='0') ? 'selected' : '' ?>>Cancelled</option>
                      <option value="1" <?= (@$this->input->get('status')=='1') ? 'selected' : '' ?>>Ongoing</option>
                       <option value="2" <?= (@$this->input->get('status')=='2') ? 'selected' : '' ?>>Booked</option>
                        <option value="3" <?= (@$this->input->get('status')=='3') ? 'selected' : '' ?>>Complete</option>
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
                 
                  <table class="table table-hover" id="customerlist">
                     <thead>
                        <tr>
                           
                           <th>Customer Email</th>
                           <th>Customer Phone</th>
                           <th>Service</th>
                           <th>Status</th>
                           <th>Booked Date</th>
                           <th>Update Date</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>

                     <?php if(!isset($bookings)){ ?>
                     <td>No data found</td>
                     <?php }else{ foreach ($bookings as $row) { ?>
                           <tr>
                              
                              <td><?= get_user($row->user_id)->email; ?></td>
                              <td><?= get_user($row->user_id)->phone; ?></td>
                              <td><?= get_service($row->service_id) ?></td>
                              <td><?php if($row->status == 0){ ?> 
                                 <span class="badge badge-danger">REQUEST CANCELLED</span>
                              <?php } else if($row->status == 1){ ?> 
                                 <span class="badge badge-warning">ONGOING REQUEST</span>
                              <?php } else if($row->status == 2){ ?> 
                                 <span class="badge badge-info ">BOOKED</span>
                              <?php } else { ?>
                                 <span class="badge badge-success">REQUEST COMPLETED</span>
                              <?php }?></td>
                              <td><?= date('d-m-Y h:i:s',strtotime($row->created_at)); ?></td>
                              <td><?= date('d-m-Y h:i:s',strtotime($row->updated_at)); ?></td>
                              <td><a href="<?= base_url('admin/OngoingBookings/booking_details/').$row->id ?>"><i class="fa fa-info-circle"></i></a></td>
                           </tr>

                        <?php  }  ?>
                        
                    <?PHP }?>

                       
                     </tbody>
                  </table>
               </div>
            </div>
          <div class="text-center"><?= @$pagination ?></div>  
         </div>
      </div>
   </div>
</section>