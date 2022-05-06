<div class="content-inner">
	<!-- Page Header-->
	<header class="page-header">
		<div class="container-fluid">
			<h2 class="no-margin-bottom"><?= @$page ? 'Update' : 'Add'; ?> Page</h2>
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
								<div class="col-md-12">
									<div class="form-group">
										<label for="title">Title</label>
										<input type="text" name="title" id="title" placeholder="Please enter page tite" value="<?= @$page ? $page->title : ''; ?>" class="form-control" required="required">
									</div>
								</div>

								<div class="col-md-12">
									<div class="form-group">
										<label for="title">Image</label>
										<input type="file" name="image" class="form-control">
										<?php if (@$page and $page->flash_image_one) : ?>
											<img src="<?= base_url('uploads/image/') . $page->flash_image_one; ?>" width="150">
										<?php endif; ?>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label for="title">Meta Keywords</label>

										<textarea id="meta_keywords" name="meta_keywords" class="form-control" required="required"><?= @$page ? $page->meta_keywords : ''; ?></textarea>
									</div>
								</div>


								<div class="col-md-12">
									<div class="form-group">
										<label for="title">Meta Description</label>
										<textarea id="meta_description" name="meta_description" class="form-control" required="required"><?= @$page ? $page->meta_description : ''; ?></textarea>
									</div>
								</div>


								<div class="col-md-12">
									<div class="form-group">
										<label for="title">Content</label>
										<textarea id="content" name="content" class="form-control text-editor" required="required"><?= @$page ? $page->content : ''; ?></textarea>
									</div>
								</div>
								<button type="submit" class="btn btn-default" id="sub"><?= @$page ? 'Update page' : 'Add page'; ?></button>
							</div>
						</form>
					</div>

				</div>
			</div>
	</section>