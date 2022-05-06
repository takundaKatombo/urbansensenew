
<div class="content-inner">
<!-- Page Header-->
<header class="page-header">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12">
            <div class="float-left"><h1 >Cities List</h1></div>

            <div class="float-right"> <a class="btn btn-info add" href="<?= base_url('admin/cities/create') ?>">Add City</a></div>
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
               <div class="col-md-12">
                  <form action="<?= base_url('admin/Cities/search_cities') ?>" method="get">
                     <div class="row">
                        <div class="col-md-3">
                           <input type="text" class="form-control" value="<?= @$this->input->get
                      ('name'); ?>" placeholder="Search by City" name="name">
                        </div>
                        <div class="col-md-3">
                           <select class="form-control" id="status" name="status">
                              <option value="">Status</option>
                               <option value="1" <?= (@$this->input->get('status')=='1') ? 'selected' : '' ?>>Active</option>
                               <option value="0" <?= (@$this->input->get('status')=='0') ? 'selected' : '' ?>>Inactive</option>
                           </select>
                        </div>
                        <div class="col-md-3">
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
                        
                           <th>City</th>
                         
                           <th>Status</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>

                     <?php if(!isset($cities)){ ?>
                     <td>No data found</td>
                     <?php }else{ foreach ($cities as $row) { ?>
                           <tr>
                              <td><?= $row->title; ?></td>
                             
                              <td><a href="<?= base_url().'admin/cities/status/'.$row->id ?>" class="badge badge-<?php if($row->status == 1){ echo 'success'; } else { echo 'danger'; } ?>"><?php if($row->status == 1){ echo 'Active'; } else { echo 'Inactive'; } ?></a></td>
                              <td>
                             <a href="<?= base_url().'admin/cities/update/'.$row->id ?>"><i class="fa fa-edit"></i></a></td>
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