

<div class="content-inner">

<!-- Page Header-->

<header class="page-header">



    <div class="container-fluid">

      <div class="row">
         <div class="col-lg-12">
            <div class="float-left"><h1 >Customer  List</h1></div>

            <div class="float-right"> <a class="btn btn-info add" href="<?= base_url('admin/Professionals/add_customer') ?>">Add Customer</a></div>
         </div>

      </div>

   </div>

</header>

 <?php $this->load->view('errors/error'); ?> 

<section class="tables">

   <div class="container-fluid">

      <div class="col-lg-12">

         <div class="card">

            

            <div class="card-header">
                   <div class="col-md-12">

            <form action="<?= base_url('admin/Professionals/search_customers') ?>" method="get">

               <div class="row">

                  <div class="col-md-2">
                       <input class="form-control datepicker" type="text" value="<?= @$this->input->get('start_date'); ?>" placeholder="Select start date" name="start_date"  title="select start date" autocomplete="off">
                  </div>

                  <div class="col-md-2">
                     <input class="form-control datepicker" type="text" value="<?= @$this->input->get('end_date'); ?>" placeholder="Select end date" name="end_date"  title="select end date" autocomplete="off">
                  </div>

                  <div class="col-md-4">

                     <input type="text" class="form-control" value="<?= @$this->input->get

                      ('name'); ?>" placeholder="Search by name and email" name="name">

                  </div>

                  <div class="col-md-2">

                     <select class="form-control" id="status" name="status">
                        <option value="">Status</option>
                         <option value="1" <?= (@$this->input->get('status')=='1') ? 'selected' : '' ?>>Active</option>
                         <option value="0" <?= (@$this->input->get('status')=='0') ? 'selected' : '' ?>>Inactive</option>
                     </select>

                  </div>

                  <div class="col-md-2">
                      <button type="submit" class="btn btn-info add" >Search</button>
                    

                  </div>

               </div>

            </form>

         </div>
              

            </div>

            <div class="card-body">

               <div class="table-responsive">

                  <table class="table">

                  <table class="table table-hover" id="customerlist">

                     <thead>

                        <tr>

                           <th>Name</th>

                           <th>Email</th>

                           <th>Phone</th>

                           <th>Status</th>

                           <th>Action</th>

                        </tr>

                     </thead>

                     <tbody>



                     <?php if(!isset($users)){ ?>

                     <td>No customer found</td>

                     <?php }else{ foreach ($users as $row) { ?>

                           <tr>

                              <td><?= $row->first_name.' '.$row->last_name; ?></td>

                              <td><?= $row->email; ?></td>

                              <td><?= $row->phone; ?></td>

                              <td><a href="<?= base_url('admin/Professionals/customer_status/').$row->id ?>" class="badge badge-<?php if($row->active == 1){ echo 'success'; } else { echo 'danger'; } ?>"><?php if($row->active == 1){ echo 'Verified'; } else { echo 'Unverified'; } ?></a></td>

                              <td>

                             <a href="<?= base_url('admin/Professionals/customer_detail/').$row->id;  ?>" title="View Details"><i class="fa fa-info-circle"></i></a>

                              <a href="<?= base_url('admin/Professionals/edit_customer/').$row->id;  ?>" title="Edit Details"><i class="fa fa-edit"></i></a>

                          </td>

                           </tr>



                        <?php } }?>



                       

                     </tbody>

                  </table>

               </div>

            </div>

          <div class="text-center"><?= @$pagination ?></div>  

         </div>

      </div>

   </div>

</section>

