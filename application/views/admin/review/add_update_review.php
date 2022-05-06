
<div class="content-inner">
<!-- Page Header-->
<header class="page-header">
   <div class="container-fluid">
      <h2 class="no-margin-bottom">Review Form</h2>
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
                        <label for="title">Name</label>
                        <input type="text" name="name" id="name" placeholder="Please enter your name" value="<?= @$review ? $review->name : ''; ?>" class="form-control"  >
                      </div>

                      <div class="form-group">
                        <label for="title">Phone</label>
                        <input type="text" name="phone" id="phone" placeholder="Please enter your phone number" value="<?= @$review ? $review->phone : ''; ?>" class="form-control" >
                      </div>

                    

                      <div class="form-group">
                          <label for="status">Rating:</label>
                          <select class="form-control" id="rating" name="rating">
                             <option value="1" <?php if(@$review->rating == 1){ echo 'selected';}?>>1</option>
                             <option value="2" <?php if(@$review->rating == 2){ echo 'selected';}?>>2</option>
                             <option value="3" <?php if(@$review->rating == 3){ echo 'selected';}?>>3</option>
                             <option value="4" <?php if(@$review->rating == 4){ echo 'selected';}?>>4</option>
                             <option value="5" <?php if(@$review->rating == 5){ echo 'selected';}?>>5</option>
                             <option value="6" <?php if(@$review->rating == 6){ echo 'selected';}?>>6</option>
                             <option value="7" <?php if(@$review->rating == 7){ echo 'selected';}?>>7</option>
                             <option value="8" <?php if(@$review->rating == 8){ echo 'selected';}?>>8</option>
                          </select>
                     </div>

                      <div class="form-group">
                          <label for="file">Upload Images:</label>
                         <input type="file" name="image"> <img src="<?= base_url('uploads/image/').@$review->image; ?>" width="75" height="75" required="required">
                     </div>

                      <div class="form-group">
                        <label for="title">Review Detail</label>
                        <textarea name="review" id="review" placeholder="Please enter Review" class="form-control"><?= @$review ? $review->review : ''; ?></textarea>
                      </div>

                     <div class="form-group">
                          <label for="status">Select Status:</label>
                          <select class="form-control" id="status" name="status">
                             <option value="1" <?php if(@$review->status == 1){ echo 'selected';}?>>Active</option>
                             <option value="0" <?php if(@$review->status == 0){ echo 'selected';}?>>Deactive</option>
                          </select>
                     </div>
                     <button type="submit" class="btn btn-default" id="sub"><?= @$review ? 'Update' : 'Add' ?> Review</button>
                  </div>
                  
               </div>
            </form>
      </div>
   </div>
</section>