
<div class="content-inner">
<!-- Page Header-->
<header class="page-header">
   <div class="container-fluid">
      <h2 class="no-margin-bottom">Category Form</h2>
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
                        <input type="text" name="title" id="title" placeholder="Please enter category" value="<?= @$category ? $category->title : ''; ?>" class="form-control" id="title" >
                      </div>

                       <div class="form-group">
                          <label for="file">Upload Images:</label>
                         <input type="file" name="image"> <img src="<?= base_url('uploads/image/').@$category->image; ?>" width="75" height="75">
                     </div>

                     <div class="form-group">
                          <label for="status">Select Status:</label>
                          <select class="form-control" id="status" name="status">
                           <option value="1" <?php if(@$category->status == 1){ echo 'selected';}?>>Active</option>
                           <option value="0" <?php if(@$category->status == 0){ echo 'selected';}?>>Deactive</option>
                           
                          </select>
                     </div>
                     <button type="submit" class="btn btn-default" id="sub"><?= @$category ? 'Update' : 'Add' ?> Category</button>
                  </div>
                  
               </div>
            </form>
      </div>
   </div>
</section>