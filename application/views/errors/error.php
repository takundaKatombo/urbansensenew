


<?php if($this->session->flashdata('success')){ ?>
   	<div class="alert alert-success alert-dismissible" style="margin: 10px;">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <?= $this->session->flashdata('success') ?>
    </div>
<?php }?> 

<?php if($this->session->flashdata('warning')){ ?>
    <div class="alert alert-danger alert-dismissible" style="margin: 10px; ">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
       <?= $this->session->flashdata('warning') ?>
    </div>
<?php }?> 
  
  <!-- <div class="alert alert-info alert-dismissible">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Info!</strong> This alert box could indicate a neutral informative change or action.
  </div>
  <div class="alert alert-warning alert-dismissible">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Warning!</strong> This alert box could indicate a warning that might need attention.
  </div>
  <div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Danger!</strong> This alert box could indicate a dangerous or potentially negative action.
  </div>
  <div class="alert alert-primary alert-dismissible">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Primary!</strong> Indicates an important action.
  </div>
  <div class="alert alert-secondary alert-dismissible">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Secondary!</strong> Indicates a slightly less important action.
  </div>
  <div class="alert alert-dark alert-dismissible">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Dark!</strong> Dark grey alert.
  </div>
  <div class="alert alert-light alert-dismissible">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Light!</strong> Light grey alert.
  </div>


 -->
