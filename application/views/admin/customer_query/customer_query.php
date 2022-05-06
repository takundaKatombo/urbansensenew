
<div class="content-inner">
<!-- Page Header-->
<header class="page-header">
 

   <div class="container-fluid">
      <div class="row">
         <div class="col-md-9">
            <h2 class="no-margin-bottom">Customer Queries</h2>
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
               <h3 class="h4">Customer Queries</h3>
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
                           <th>Subject</th>
                           <th>Query</th>
                           <th>Date</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>

                     <?php if(!isset($contacts)){ ?>
                     <td>No data found</td>
                     <?php }else{ foreach ($contacts as $row) { ?>
                           <tr>
                              <td><?= $row->name; ?></td>
                              <td><?= $row->email; ?></td>
                              <td><?= $row->phone; ?></td>
                              <td><?= $row->subject; ?></td>
                              <td><?= $row->message; ?> </td>
                              <td><?= date('d/m/Y', strtotime($row->created_at)); ?> </td>

                              <td><a href="" class="badge badge-<?php if($row->status == 1){ echo 'success'; } else { echo 'danger'; } ?>"><?php if($row->status == 1){ echo 'Varified'; } else { echo 'Un Varified'; } ?></a></td>
                             
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