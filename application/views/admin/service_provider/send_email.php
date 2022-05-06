
<div class="content-inner">
    <!-- Page Header-->
    <header class="page-header">
        <div class="container-fluid">
            <h2 class="no-margin-bottom">Send Email Form</h2>
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
                        <form action="<?= base_url('admin/professionals/send_email') ?>" method="post" enctype="multipart/form-data">
                            <div class="row">

                                <input type="hidden" name="service_providers" value="<?= $service_providers ?>">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="title">To Email</label>
                                        <input type="text" name="to_email" id="" placeholder="" value="<?= @$emails ? $emails : @set_value('to_email'); ?>" class="form-control"  required="required" readonly="">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="subject">Subject</label>
                                        <input type="text" name="subject" id="subject" placeholder="Please enter subject" value="<?= @set_value('subject'); ?>" class="form-control"  required="required">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="body">Body</label>
                                        <textarea class="form-control ckeditor" name="body" required="required"></textarea>
                                    </div>
                                </div>

                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-default large-btn" id="sub">Send</button>
                                </div>


                            </div>
                        </form>
                    </div>

                </div>
            </div>
    </section>