
<div class="content-inner">
<!-- Page Header-->
<header class="page-header">
 

   <div class="container-fluid">
      <div class="row">
         <div class="col-md-9">
            <h2 class="no-margin-bottom">Update Settings</h2>
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
               <h3 class="h4">Update  Settings</h3>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                  <table class="table">
                  <table class="table table-hover" id="customerlist">
                     <thead>
                        <tr>
                        
                           <th>Title</th>
                           <th>Data</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>

                   
                           
                     <form method="post" action="<?= base_url('admin/Settings/save_site_name') ?>">
                        <tr>
                            <td>Site Name</td>
                            <td> 
                                <input name="site_name" id="site_name" class="form-control" value="<?= set_value('site_name') ? set_value('site_name') : @$setting[0]->site_name ?>"/>
                                <input type="hidden" name="id" class="form-control" value="<?= @$setting[0]->id ?>"/>
                            </td>
                            <td>  <input type="submit" value="<?= (@$setting) ? 'Update' : 'Create' ?>" class="btn btn-raised btn-info  "/></td>
                        </tr>
                      </form>

                    <form method="post" action="<?= base_url('admin/Settings/save_phone') ?>">
                        <tr>
                            <td>Support Phone</td>
                            <td> 
                                <input name="phone" id="phone" class="form-control" value="<?= set_value('phone') ? set_value('phone') : @$setting[0]->phone ?>"/>
                                <input type="hidden" name="id" class="form-control" value="<?= @$setting[0]->id ?>"/>
                            </td>
                            <td>  <input type="submit" value="<?= (@$setting) ? 'Update' : 'Create' ?>" class="btn btn-raised btn-info  "/></td>
                        </tr>
                    </form>  

                    <form method="post" action="<?= base_url('admin/Settings/save_email') ?>">
                        <tr>
                            <td>Support Email</td>
                            <td> 
                                <input name="email" id="email" class="form-control" value="<?= set_value('email') ? set_value('email') : @$setting[0]->email ?>"/>
                                <input type="hidden" name="id" class="form-control" value="<?= @$setting[0]->id ?>"/>

                            </td>
                            <td>  <input type="submit" value="<?= (@$setting) ? 'Update' : 'Create' ?>" class="btn btn-raised btn-info  "/></td>
                        </tr>
                    </form>


                    <form method="post" action="<?= base_url('admin/Settings/save_logo') ?>"  enctype="multipart/form-data">
                        <tr>
                            <td>Site Logo</td>
                            <td> 
                                <input type="file" name="image" id="image" class="form-control"/>
                              
                                <input type="hidden" name="id" class="form-control" value="<?= @$setting[0]->id ?>"/>
                                <img src="<?= base_url('uploads/image/').@$setting[0]->logo ?>" width="100">
                            </td >
                            
                            <td>  <input type="submit" value="<?= (@$setting) ? 'Update' : 'Create' ?>" class="btn btn-raised btn-info  "/></td>
                        </tr>
                    </form>


                    <form method="post" action="<?= base_url('admin/Settings/save_terms_conditions') ?>">
                        <tr>
                            <td>Privacy Policy Page</td>
                            <td> 
                                <select name="terms_conditions" id="terms_conditions" class="form-control">  
                                       <?php if (!empty($pages)): ?>
                                            <?php foreach ($pages as $row): ?>
                                                <option value="<?= $row->slug ?>" <?= ($row->slug == @$setting[0]->terms_conditions) ? 'selected' : '' ?>><?= $row->title ?></option>
                                            <?php endforeach; ?>

                                        <?php endif; ?>
                                    </select>
                                <input type="hidden" name="id" class="form-control" value="<?= @$setting[0]->id ?>"/>
                            </td>
                            <td>  <input type="submit" value="<?= (@$setting) ? 'Update' : 'Create' ?>" class="btn btn-raised btn-info  "/></td>
                        </tr>
                    </form>


                     <form method="post" action="<?= base_url('admin/Settings/save_address') ?>">
                        <tr>
                            <td>Address</td>
                            <td> 
                               
                                <textarea  name="address" id="address" class="form-control"><?= set_value('address') ? set_value('address') : @$setting[0]->address ?></textarea>
                                <input type="hidden" name="id" class="form-control" value="<?= @$setting[0]->id ?>"/>

                            </td>
                            <td>  <input type="submit" value="<?= (@$setting) ? 'Update' : 'Create' ?>" class="btn btn-raised btn-info  "/></td>
                        </tr>
                    </form>
                       
                     </tbody>
                  </table>
               </div>
            </div>
         
         </div>
      </div>
   </div>
</section>