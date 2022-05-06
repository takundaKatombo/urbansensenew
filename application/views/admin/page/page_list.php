<div class="content-inner">
    <!-- Page Header-->
    <header class="page-header">


        <div class="container-fluid">
            <div class="row">
                <div class="col-md-9">
                    <h2 class="no-margin-bottom">Page List</h2>
                </div>
                <div class="col-md-3 right-menu">
                    <a href="<?= base_url('admin/Pages/create') ?>" class="btn btn-info">Add new page </a>

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
                        <h3 class="h4">Page List</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <table class="table table-hover" id="customerlist">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Image</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php if (!isset($pages)) : ?>
                                            <td>No data found</td>
                                            <?php else :
                                            foreach ($pages as $row) : ?>
                                                <tr>
                                                    <td><?= $row->title; ?></td>
                                                    <td><img src="<?= base_url('uploads/image/') . $row->flash_image_one; ?>" width="75"></td>
                                                    <td>
                                                        <a href="<?= base_url('admin/Pages/status/') . $row->id ?>" class="badge badge-<?= ($row->status == 1) ? 'success' : 'danger' ?>">
                                                            <?= ($row->status == 1) ? 'Active' : 'Inactive' ?>
                                                        </a>
                                                    </td>
                                                    <td> <a href="<?= base_url('admin/Pages/update/') . $row->id ?>"><i class="fa fa-edit"></i></a> <a href="<?= base_url('admin/Pages/delete/') . $row->id ?>" class="delete-button"><i class="fa fa-trash"></i></a></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>

                                    </tbody>
                                </table>
                        </div>
                    </div>
                    <div class="text-center"><?= $pagination ?></div>
                </div>
            </div>
        </div>
    </section>