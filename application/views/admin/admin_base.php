<!DOCTYPE html>

<html>

<head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>UrbanSense</title>

    <meta name="description" content="">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="robots" content="all,follow">

    <!-- Bootstrap CSS-->

    <link rel="stylesheet" href="<?=base_url('assets/admin/')?>bootstrap/css/bootstrap.min.css">

    <!-- Font Awesome CSS-->

    <link rel="stylesheet" href="<?=base_url('assets/admin/')?>font-awesome/css/font-awesome.min.css">

    <!-- Fontastic Custom icon font-->

    <link rel="stylesheet" href="<?=base_url('assets/admin/')?>css/fontastic.css">

    <!-- Google fonts - Poppins -->

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,700">

    <!-- theme stylesheet-->

    <link rel="stylesheet" href="<?=base_url('assets/admin/')?>css/style.default.css" id="theme-stylesheet">



    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <!-- Custom stylesheet - for your changes-->

    <link rel="stylesheet" href="<?=base_url('assets/admin/')?>css/custom.css">

    <!-- Favicon-->

    <link rel="shortcut icon" href="<?=base_url('assets/fav.png')?>">

    <!-- Tweaks for older IEs-->
    <!--[if lt IE 9]>

      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>

      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->

</head>

<body>

    <div class="page">

        <!-- Main Navbar-->

        <header class="header">

            <nav class="navbar">

                <!-- Search Box-->

                <div class="container-fluid">

                    <div class="navbar-holder d-flex align-items-center justify-content-between">

                        <!-- Navbar Header-->

                        <div class="navbar-header">

                            <!-- Navbar Brand -->

                            <a href="<?=base_url('admin/Dashboards')?>" class="navbar-brand d-none d-sm-inline-block">

                                <div class="brand-text d-none d-lg-inline-block"><strong>Dashboard</strong></div>

                                <div class="brand-text d-none d-sm-inline-block d-lg-none"><strong>BD</strong></div>

                            </a>

                            <!-- Toggle Button--><a id="toggle-btn" href="#" class="menu-btn active"><span></span><span></span><span></span></a>

                        </div>

                        <ul>

                            <!-- Logout    -->

                            <li><a href="<?=base_url('admin/auth/logout')?>" class="nav-link logout"> <span class="d-none d-sm-inline">Logout</span><i class="fa fa-sign-out"></i></a></li>

                        </ul>

                    </div>

                </div>

            </nav>

        </header>

        <div class="page-content d-flex align-items-stretch">

            <!-- Side Navbar -->

            <nav class="side-navbar">

                <!-- Sidebar Header-->

                <div class="sidebar-header d-flex align-items-center">

                    <div class="avatar"><img src="<?=base_url('assets/admin/')?>img/avatar-1.png" alt="..." class="img-fluid rounded-circle"></div>

                    <div class="title">

                        <h1 class="h4">Admin</h1>

                    </div>

                </div>

                <!-- Sidebar Navidation Menus-->

                <ul class="list-unstyled">

                    <li class="<?php if ($this->uri->segment(2) == 'Dashboards') {
    echo 'active';
}?>"><a href="<?=base_url('admin/Dashboards')?>"> <i class="fa fa-dashboard"></i>Dashboard </a></li>

                    <li class="<?php if ($this->uri->segment(2) == 'professionals') {
    echo 'active';
}?>">

                        <a href="#user" aria-expanded="false" data-toggle="collapse"> <i class="icon-user"></i>User </a>

                        <ul id="user" class="collapse list-unstyled ">

                            <li><a href="<?=base_url('admin/professionals/customer')?>">Customer</a></li>

                            <li><a href="<?=base_url('admin/professionals')?>">Service Provider</a></li>

                        </ul>

                    </li>

                    <li class="<?php if ($this->uri->segment(2) == 'categories') {
    echo 'active';
}?>"><a href="<?=base_url('admin/categories')?>"> <i class="fa fa-exchange"></i>Category </a>

                    </li>

                    <li class="<?php if ($this->uri->segment(2) == 'services') {
    echo 'active';
}?>"><a href="<?=base_url('admin/services')?>"> <i class="fa fa-id-card"></i>Service </a>

                    </li>



                    <li class="<?php if ($this->uri->segment(2) == 'cities') {
    echo 'active';
}?>"><a href="<?=base_url('admin/cities')?>"> <i class="fa fa-home"></i>City </a>

                    </li>



                    <li class="<?php if ($this->uri->segment(2) == 'reviews') {
    echo 'active';
}?>"><a href="<?=base_url('admin/reviews')?>"> <i class="fa fa-file-text" aria-hidden="true"></i>Review</a>

                    </li>


                    <li class="<?php if ($this->uri->segment(2) == 'OngoingBookings') {
    echo 'active';
}?>"><a href="<?=base_url('admin/OngoingBookings')?>"> <i class="fa fa-id-card"></i>Ongoing Bookings </a>
                    </li>

                    <li class="<?php if ($this->uri->segment(2) == 'CustomerReports') {
    echo 'active';
}?>"><a href="<?=base_url('admin/CustomerReports')?>"> <i class="fa fa-id-card"></i>Customer Complain</a>
                    </li>




                    <li class="<?php if ($this->uri->segment(2) == 'Pages') {
    echo 'active';
}?>"><a href="<?=base_url('admin/Pages')?>"> <i class="icon-bill"></i> Pages</a></li>



                    <li class="<?php if ($this->uri->segment(2) == 'Payments') {
    echo 'active';
}?>"><a href="<?=base_url('admin/Payments')?>"> <i class="fa fa-credit-card"></i>Payments </a></li>

                    <li class="<?php if ($this->uri->segment(2) == 'Bookings') {
    echo 'active';
}?>"><a href="<?=base_url('admin/Bookings')?>"> <i class="fa fa-address-book"></i>Bookings </a></li>







                    <!-- <li class="<?php if ($this->uri->segment(2) == 'Payouts') {
    echo 'active';
}?>">

                        <a href="#payout" aria-expanded="false" data-toggle="collapse"><i class="fa fa-money" aria-hidden="true"></i>Payout </a>

                        <ul id="payout" class="collapse list-unstyled ">

                            <li><a href="<?=base_url('admin/Payouts')?>">Payout List</a></li>

                            <li><a href="<?=base_url('admin/Payouts/payout_report')?>">Payout Report</a></li>

                        </ul>

                    </li> -->



                    <li class="<?php if ($this->uri->segment(2) == 'Settings') {
    echo 'active';
}?>"><a href="<?=base_url('admin/Settings')?>"> <i class="fa fa-cogs"></i>Settings </a></li>



                    <li class="<?php if ($this->uri->segment(2) == 'Contacts') {
    echo 'active';
}?>"><a href="<?=base_url('admin/Contacts')?>"> <i class="fa fa-support"></i>Customer Query </a></li>



                    <li class="<?php if ($this->uri->segment(3) == 'change_password') {
    echo 'active';
}?>"><a href="<?=base_url('admin/Auth/change_password')?>"> <i class="fa fa-key"></i>Change Password </a></li>

                </ul>

            </nav>

            <!-- Main Navbar-->





            <?=$contents;?>







            <!-- Page Footer-->

            <footer class="main-footer">

                <div class="container-fluid">

                    <div class="row">

                        <div class="col-sm-6">

                            <p>UrbanSense &copy; 2019</p>

                        </div>

                        <div class="col-sm-6 text-right">

                        </div>

                    </div>

                </div>

            </footer>

        </div>

    </div>

    </div>

    <!-- JavaScript files-->
    <script src="<?=base_url('assets/admin/')?>jquery/jquery.min.js"></script>
    <script src="<?=base_url('assets/admin/')?>popper.js/umd/popper.min.js"> </script>
    <script src="<?=base_url('assets/admin/')?>bootstrap/js/bootstrap.min.js"></script>
    <script src="<?=base_url('assets/admin/')?>jquery.cookie/jquery.cookie.js"> </script>
    <script src="<?=base_url('assets/admin/')?>chart.js/Chart.min.js"></script>
    <script src="<?=base_url('assets/admin/')?>jquery-validation/jquery.validate.min.js"></script>
    <script src="<?=base_url('assets/admin/')?>js/charts-home.js"></script>
    <!-- Main File-->
    <script src="<?=base_url('assets/admin/')?>js/front.js"></script>
    <script src="<?=base_url()?>assets\frontend\js\jquery-ui.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdn.ckeditor.com/4.10.1/full/ckeditor.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=false&libraries=places&key=AIzaSyBTyhhiO6FnR-UYlyeM01lDl2Yqsqm2tp0"></script>
    <script src="<?=base_url('assets/frontend/js/get_lat_long.js')?>"></script>

    <script>
        var base_url = '<?=base_url();?>';
    </script>

    <script src="<?=base_url('assets/admin/')?>custom.js"></script>
    <script>
        var dateToday = new Date();
        $(function() {
            $(".datepicker").datepicker({

            });
        });
    </script>
</body>

</html>