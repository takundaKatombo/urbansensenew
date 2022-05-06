

<div class="content-inner">

    <!-- Page Header-->

    <header class="page-header">



        <div class="container-fluid">

            <div class="row">

                <div class="col-lg-12">
                    <div class="float-left"><h1>Service Provider</h1></div>

                    <div class="float-right"> <a class="btn btn-info add" href="<?= base_url('admin/Professionals/add_professional') ?>">Add Service Provider</a></div>
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

                        <div class="col-md-12">

                            <form action="<?= base_url('admin/Professionals/search_service_providers') ?>" method="get">

                                <div class="row">

                                    <div class="col-md-2">
                                        <input class="form-control datepicker" type="text" value="<?= @$this->input->get('start_date'); ?>" placeholder="Select start date" name="start_date"  title="select start date" autocomplete="off">
                                    </div>

                                    <div class="col-md-2">
                                        <input class="form-control datepicker" type="text" value="<?= @$this->input->get('end_date'); ?>" placeholder="Select end date" name="end_date"  title="select end date" autocomplete="off">
                                    </div>

                                    <div class="col-md-2">

                                        <input type="text" class="form-control" value="<?= @$this->input->get
            ('name');
    ?>" placeholder="Search by name and email" name="name">

                                    </div>

                                    <div class="col-md-2">

                                        <select class="form-control" id="status" name="status">
                                            <option value="">Status</option>
                                            <option value="1" <?= (@$this->input->get('status') == '1') ? 'selected' : '' ?>>Verified</option>
                                            <option value="0" <?= (@$this->input->get('status') == '0') ? 'selected' : '' ?>>Unverified</option>
                                        </select>

                                    </div>

                                    <div class="col-md-2">
                                        <select class="form-control" id="rating" name="rating">
                                            <option value="">Rating</option>
                                            <option value="0" <?= (@$this->input->get('rating') == '0') ? 'selected' : '' ?>>0</option>
                                            <option value="1" <?= (@$this->input->get('rating') == '1') ? 'selected' : '' ?>>1</option>
                                            <option value="2" <?= (@$this->input->get('rating') == '2') ? 'selected' : '' ?>>2</option>
                                            <option value="3" <?= (@$this->input->get('rating') == '3') ? 'selected' : '' ?>>3</option>
                                            <option value="4" <?= (@$this->input->get('rating') == '4') ? 'selected' : '' ?>>4</option>
                                            <option value="5" <?= (@$this->input->get('rating') == '5') ? 'selected' : '' ?>>5</option>
                                        </select>

                                    </div>

                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-info" >Search</button>
                                        <a class="btn btn-info" href="<?= base_url('admin/Professionals') ?>"><i class="fa fa-refresh"></i></a>

                                    </div>

                                </div>

                            </form>

                        </div>

                    </div>
                    <form action="<?= base_url('admin/professionals/selected_action') ?>" method="post">
                    <div class="card-body">
                        
                        <div class="table-responsive">
                            
                            
                                <table class="table table-hover" id="datatable">

                                    <thead>

                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>

                                            <th>Email</th>

                                            <th>City</th>

                                            <th>Featured</th>

                                            <th>Criminal record Verification</th>

                                            <th>Bank and ID card verification</th>

                                            <th>Skills assessment</th>

                                            <th><a href="<?= base_url('admin/Professionals/ascReview') ?>">ASC</a> Rating <a href="<?= base_url('admin/Professionals/descReview') ?>">DESC</a></th>

                                            <th>Status</th>

                                            <th>Action</th>

                                        </tr>

                                    </thead>

                                    <tbody>



                                        <?php if (empty($users)) { ?>

                                        <td>No service provider found</td>

                                    <?php
                                    } else {
                                        foreach ($users as $row) {
                                            if ($row->city_id != NULL) {
                                                ?>

                                                <tr>
                                                    <td><input type="checkbox" name="service_providers[]"value="<?= $row->id; ?>"></td>

                                                    <td><?= $row->first_name . ' ' . $row->last_name; ?></td>

                                                    <td><?= $row->email; ?></td>

                                                    <td><?= get_city($row->city_id); ?></td>



                                                    <td><input type="checkbox" name="featured_service_provider" id="<?= $row->id; ?>" class="featured_service_provider" <?= $row->featured_service_provider ? 'checked' : ''; ?>></td>



                                                    <td><input type="checkbox" name="criminal_varification" id="<?= $row->id; ?>" class="criminal_varification" <?= $row->criminal_varification ? 'checked' : ''; ?>></td>



                                                    <td><input type="checkbox" name="bank_varification" id="<?= $row->id; ?>" class="bank_varification" <?= $row->bank_varification ? 'checked' : ''; ?>></td>



                                                    <td><input type="checkbox" name="skill_assessment" id="<?= $row->id; ?>" class="skill_assessment" <?= $row->skill_assessment ? 'checked' : ''; ?>></td>

                                                    <td><?= $row->total_avg != null ? $row->total_avg : 0 ?></td>

                                                    <td><a href="<?= base_url('admin/Professionals/status/') . $row->id ?>" class="badge badge-<?php if ($row->verification == 1) {
                                                    echo 'success';
                                                } else {
                                                    echo 'danger';
                                                } ?>"><?php if ($row->verification == 1) {
                                                    echo 'Verified';
                                                } else {
                                                    echo 'Unverified';
                                                } ?></a></td>

                                                    <td>

                                                        <a href="<?= base_url('admin/Professionals/professional_detail/') . $row->id; ?>" title="View detail" target="_blank"><i class="fa fa-info-circle"></i></a>

                                                        <a href="<?= base_url('admin/Professionals/edit_professional/') . $row->id; ?>" title="Edit detail"><i class="fa fa-edit"></i></a>

                                                    </td>

                                                </tr>
        <?php }
    }
} ?>
                                    </tbody>

                                </table>
                            

                        </div>

                    </div>
                       
                    <div class="pull-left margin-bottom-1">
                        &nbsp;<input class="btn btn-info" type="submit" value="Download" name="submit_value">
                        &nbsp;<input class="btn btn-info" type="submit" value="Delete" name="submit_value">
                        &nbsp;<input class="btn btn-info" type="submit" value="Email" name="submit_value">
                        &nbsp;<input class="btn btn-info" type="submit" value="Activate" name="submit_value">
                    </div>
                        
                    </form>
                </div>

            </div>

        </div>

    </section>