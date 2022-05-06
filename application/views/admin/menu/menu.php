
<div class="content-inner">
<!-- Page Header-->
<header class="page-header">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-7">
            <h2 class="no-margin-bottom">Menu List</h2>
         </div>
         <div class="col-md-5 right-menu">
            <form action="<?= base_url('admin/Menus/search_menus') ?>" method="get">
                  <input type="text" class="form-control" value="<?= @$this->input->get
                      ('name'); ?>" placeholder="Search by Menu" name="name">
                  <button type="submit" class="search" ><i class="fa fa-search"></i></button>
            </form>
            <a class="btn btn-info add" href="<?= base_url('admin/Menus/create') ?>">Add Menu</a>
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
               <h3 class="h4">Menu List</h3>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                  <table class="table">
                  <table class="table table-hover" id="customerlist">
                     <thead>
                        <tr>
                           <th>Menu</th>
                           <th>Status</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>

                     <?php if(!isset($menus)){ ?>
                     <td>No data found</td>
                     <?php } else { foreach ($menus as $row) { ?>
                           <tr>
                              <td><?= $row->title; ?></td>
                             
                              <td><a href="<?= base_url().'admin/Menus/status/'.$row->id ?>" class="badge badge-<?php if($row->status == 1){ echo 'success'; } else { echo 'danger'; } ?>"><?php if($row->status == 1){ echo 'Active'; } else { echo 'Inactive'; } ?></a></td>
                              <td>
                             <a href="<?= base_url().'admin/Menus/update/'.$row->id ?>"><i class="fa fa-edit"></i></a><a href=""><i class="fa fa-trash"></i></a></td>
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