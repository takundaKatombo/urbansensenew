
<div class="content-inner">
<!-- Page Header-->
<header class="page-header">
 

   <div class="container-fluid">
      <div class="row">
         <div class="col-md-9">
            <h2 class="no-margin-bottom">Reviews List</h2>
         </div>
         <div class="col-md-3 right-menu">
          <a href="<?= base_url('admin/Reviews/create') ?>" class="btn btn-info">Add Review </a>
           
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
               <h3 class="h4">Reviews  List</h3>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                  <table class="table">
                  <table class="table table-hover" id="customerlist">
                     <thead>
                        <tr>
                        
                           <th>Name</th>
                           <th>Image</th>
                           <th>Review</th>
                           <th>Show on homepage</th>
                           <th>Status</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>

                     <?php if(!isset($reviews)){ ?>
                     <td>No data found</td>
                     <?php }else{ foreach ($reviews as $row) { ?>
                           <tr>
                              <td><?= $row->name; ?></td>
                              <td><img src="<?= base_url('uploads/image/').$row->image; ?>" width="75" height="75"></td>
                              <td><?= $row->review; ?></td>

                              <td><input type="checkbox" name="show_on_homepage" id="<?= $row->id; ?>" class="show_on_homepage" <?= ($row->show_on_homepage===1) ? 'checked' : '';?>></td>

                              <td><a href="<?= base_url('admin/Reviews/status/').$row->id ?>" class="badge badge-<?php if($row->status == 1){ echo 'success'; } else { echo 'danger'; } ?>"><?php if($row->status == 1){ echo 'Varified'; } else { echo 'Un Varified'; } ?></a></td>
                              <td> <a href="<?= base_url('admin/Reviews/update/').$row->id ?>"><i class="fa fa-edit"></i></a>  <a href="<?= base_url('admin/Reviews/delete/').$row->id ?>" class="delete-button"><i class="fa fa-trash"></i></a></td>
                           </tr>

                        <?php } }?>

                       
                     </tbody>
                  </table>
               </div>
            </div>
          <div class="text-center"><?= $pagination ?></div>  
         </div>
      </div>
   </div>
</section>