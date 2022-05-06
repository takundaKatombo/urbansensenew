 <!-- ========== END HEADER ========== -->
 <main id="content" role="main">
 	<div class="container">
 		<?php if ($loggedin_user->verification != 1) { ?>
 			<div class="col-md-12" style="margin-top: 8px;">
 				<div class="alert alert-warning">
 					Please update your profile and upload relevant documents for account verification purpose. Only verified profiles are entitled to accept orders and payments. <a href="<?= base_url('edit-profile'); ?>">Click here </a> to proceed. If you've already uploaded all documents, please wait while we verify the details. Your account will be activated to receive requests after successful verification.
 				</div>
 			</div>
 		<?php } ?>
 		<div class="row">
 			<div class="col-md-4">

 				<div class="col-md-12 sec">
 					<div class="imageulpod">
 						<img src=" <?= @get_default_pro_image($user->id) ?  base_url('uploads/image/') . get_default_pro_image($user->id) : base_url('assets/upload.png'); ?>" alt="" width="250">
 						<?php if ($loggedin_user->verification == 1) { ?>
 							<div class="verified mt-1"><img src="<?= base_url('assets/verified.png') ?>" width="50"> Verified </div>
 						<?php } ?>
 					</div>
 				</div>
 				<div class="col-md-12 mt-4">
 					<center class="but">
 						<a href="<?= base_url('upload-image'); ?>" class="btn btn-primary u-btn-primary transition-3d-hover ">Upload Image</a>
 						<a href="<?= base_url('edit-profile'); ?>" class="btn btn-primary u-btn-primary transition-3d-hover ">Edit Profile</a>
 					</center>
 				</div>
 			</div>

 			<div class="col-sm-8">
 				<div class="sec">

 					<div class="col-md-12">
 						<div class="table-responsive">
 							<table class="table table1">
 								<h4>Profile</h4>

 								<tbody>
 									<tr>
 										<th scope="row">Name</th>
 										<td><?= $user->first_name . ' ' . $user->last_name ?></td>
 									</tr>

 									<tr>
 										<th scope="row">Mobile Number</th>
 										<td><?= $user->phone ?></td>
 									</tr>
 									<tr>
 										<th scope="row">Email </th>
 										<td><?= $user->email ?></td>
 									</tr>
 									<tr>
 										<th scope="row">Company Name </th>
 										<td><?= $user->professionals->company_name ?></td>
 									</tr>
 									<tr>
 										<th scope="row">Introduction </th>
 										<td><?= $user->professionals->introduction ?></td>
 									</tr>
 									<tr>
 										<th scope="row">Company Detail </th>
 										<td><?= $user->professionals->company_detail ?></td>
 									</tr>
 									<tr>
 										<th scope="row">Services </th>
 										<td><?php foreach ($user->professional_services as $row) {
													echo get_service($row->service_id) . ', ';
												} ?></td>
 									</tr>
 									<tr>
 										<th scope="row">Account holder name</th>
 										<td><?= $user->professionals->account_holder_name ?></td>
 									</tr>

 									<tr>
 										<th scope="row">Account Number </th>
 										<td><?= $user->professionals->account_number ?></td>
 									</tr>

 									<tr>
 										<th scope="row">Bank Name </th>
 										<td><?= $user->professionals->ifsc ?></td>
 									</tr>

 									<tr>
 										<th scope="row">Branch </th>
 										<td><?= $user->professionals->branch ?></td>
 									</tr>

 									<tr>
 										<th scope="row">Bank Passbook Image </th>
 										<td> <?php if ($user->professionals->bank_passbook_image != '') { ?>
 												<img src="<?= base_url('uploads/bank_passbook_image/') . $user->professionals->bank_passbook_image ?>" class=" img-fluid" width="200">
 											<?php } ?></td>
 									</tr>

 									<tr>
 										<th scope="row">ID Type </th>
 										<td><?= $user->professionals->id_type ?></td>
 									</tr>
 									<tr>
 										<th scope="row">ID Number </th>
 										<td><?= $user->professionals->id_number ?></td>
 									</tr>

 									<tr>
 										<th scope="row">ID Image </th>
 										<td> <?php if ($user->professionals->id_card_image != '') { ?>
 												<img src="<?= base_url('uploads/id_card_image/') . $user->professionals->id_card_image; ?>""  class=" img-fluid" width="200">
 											<?php } ?></td>
 									</tr>

 									<tr>
 										<th scope="row">City </th>
 										<td><?= get_city($user->professionals->city_id); ?></td>
 									</tr>
 									<tr>
 										<th scope="row">Address </th>
 										<td><?= $user->professionals->address ?></td>
 									</tr>
 								</tbody>
 							</table>
 						</div>
 					</div>

 				</div>
 			</div>
 		</div>
 		<center>
 			<h3>Other Images</h3>
 		</center>
 		<div class="row">
 			<?php foreach ($user->professional_images as $row) { ?>
 				<div class="col-md-3 mb-6 mt-5">
 					<div class="imageulpod">
 						<img src="<?= base_url('uploads/image/') . $row->image ?>" alt="" width="200">
 					</div>

 				</div>
 			<?php  } ?>

 		</div>

 	</div>

 </main>
 <!-- ========== END MAIN CONTENT ========== -->