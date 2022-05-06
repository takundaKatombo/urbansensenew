
<div class="content-inner">
<!-- Page Header-->
<header class="page-header">
   <div class="container-fluid">
      <h2 class="no-margin-bottom">Service Form</h2>
   </div>
</header>
 <?php $this->load->view('errors/error'); ?> 
<!-- Dashboard Counts Section-->
<section class="dashboard-counts no-padding-bottom">
   <div class="container-fluid">
   <div class="col-lg-12">
      <div class="card">
         <div class="card-header d-flex align-items-center">
            <h3 class="h4"><?= $title ?></h3>
         </div>
         <div class="card-body">
           <form action="" method="post" enctype="multipart/form-data">
               <div class="row">
                  <div class="col-md-6">
                     
                      
                      <div class="form-group">
                          <label for="file">Upload Images:</label>
                         <input type="file" name="image">
                     </div>
                    
                     <div class="form-group">
                        <label for="alt_tag">Alternate Tag</label>
                        <input type="text" name="alt_tag" id="alt_tag" placeholder="Please Enter Alternate Tag" value="" class="form-control" id="alt_tag" >
                      </div>

                    
                     <button type="submit" class="btn btn-default" id="sub">Submit</button>
                  </div>
                  
               </div>
            </form>
      </div>
   </div>
</section>

<section class="tables">
   <div class="container-fluid">
      <div class="col-lg-12">
         <div class="card">
            
            <div class="card-header d-flex align-items-center">
               <h3 class="h4">Service Images</h3>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                  <table class="table">
                  <table class="table table-hover" id="customerlist">
                     <thead>
                        <tr>
                           <th>Image</th>
                           <th>Alt Tag</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>

                     <?php if(!isset($service_images)){ ?>
                     <td>No data found</td>
                     <?php }else{ foreach ($service_images as $rows) { ?>
                           <tr>
                              <td><img src="<?= base_url('uploads/image/').$rows->image; ?>" width="75" height="75"> </td>
                              <td><?= $rows->alt_tag; ?></td>
                              <td> 
                             <a href="<?= base_url().'admin/services/delete_image/'.$rows->id ?>" class="delete-button"><i class="fa fa-trash"></i></a></td>
                           </tr>

                        <?php } }?>

                       
                     </tbody>
                  </table>
               </div>
            </div>
          
         </div>
      </div>
   </div>
</section>