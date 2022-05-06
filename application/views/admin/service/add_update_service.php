
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
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" placeholder="Please enter Service" value="<?= @$service ? $service->title : ''; ?>" class="form-control" id="title" >
                      </div>
                      
                     <div class="form-group">
                          <label for="category_id">Select Category:</label>
                          <select class="form-control" id="category_id" name="category_id" required="">
                              <?php foreach ($categories as $row) { ?>
                                <option value="<?= $row->id ?>" <?php if(@$service->category_id == $row->id){ echo "selected"; } ?>><?= $row->title ?></option>
                              <?php } ?>
                          </select>
                     </div>

                     <div class="form-group">
                          <label for="file">Upload Images : <small> (Image size should be 360*180 px)</small></label>
                         <input type="file" name="image"> <?php if(@$service->image){ ?> <img src="<?= base_url('uploads/image/').@$service->image; ?>" width="75" height="75"><?php } ?>
                      </div>

                    

                     <div class="form-group">
                          <label for="status">Select Status:</label>
                          <select class="form-control" id="status" name="status">
                           <option value="1" <?php if(@$service->status == 1){ echo 'selected';}?>>Active</option>
                           <option value="0" <?php if(@$service->status == 0){ echo 'selected';}?>>Deactive</option>
                           
                          </select>
                     </div>
                     <button type="submit" class="btn btn-default" id="sub"><?= @$service ? 'Update' : 'Add'?> Service</button>
                  </div>
                  
               </div>
            </form>
      </div>
   </div>
</section>