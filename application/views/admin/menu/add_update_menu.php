
<div class="content-inner">
<!-- Page Header-->
<header class="page-header">
   <div class="container-fluid">
      <h2 class="no-margin-bottom">Menu Form</h2>
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
           <form action="" method="post">
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" placeholder="Please enter menu" value="<?= @$menu ? $menu->title : ''; ?>" class="form-control" id="title" >
                      </div>

                     <div class="form-group">
                          <label for="status">Select Status:</label>
                          <select class="form-control" id="status" name="status">
                           <option value="1" <?php if(@$menu->status == 1){ echo 'selected';}?>>Active</option>
                           <option value="0" <?php if(@$menu->status == 0){ echo 'selected';}?>>Deactive</option>
                           
                          </select>
                     </div>
                     <button type="submit" class="btn btn-default" id="sub"><?= @$menu ? 'Update' : 'Add' ?>Menu </button>
                  </div>
                  
               </div>
            </form>
      </div>
   </div>
</section>