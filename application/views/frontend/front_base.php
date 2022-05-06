
<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        
        <meta name="appleid-signin-client-id" content="<?= isset($apple_client_id)?$apple_client_id:'' ?>">
        <meta name="appleid-signin-scope" content="<?= isset($apple_scope)?$apple_scope:'' ?>">
        <meta name="appleid-signin-redirect-uri" content="<?= isset($apple_redirect_uri)?$apple_redirect_uri:'' ?>">
        <meta name="appleid-signin-state" content="">
        <meta name="appleid-signin-use-popup" content="false">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />

        <!-- Title -->
        <title>UrbanSense</title>
        <!-- Required Meta Tags Always Come First -->
        <meta charset="UTF-8-BOM">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
            <!-- Favicon -->
            <link rel="shortcut icon"  type="image/png" href="<?= base_url('assets/fav.png') ?>" />
            <!-- Google Fonts -->
            <link  rel="preload" href="<?= base_url() ?>assets/frontend/css/fontfamily.css" />
            <!-- CSS Global Compulsory -->
            <link rel="stylesheet" href="<?= base_url() ?>assets/frontend/vendor/bootstrap/css/bootstrap.css" />

            <link rel="preload" href="<?= base_url() ?>assets/frontend/css/select2.min.css" />
            <!-- CSS Implementing Plugins -->
            <link rel="stylesheet" href="<?= base_url('assets/admin/') ?>font-awesome/css/font-awesome.min.css" />
            <link rel="stylesheet" href="<?= base_url() ?>assets/frontend/vendor/animate.css/animate.min.css" />
            <link rel="stylesheet" href="<?= base_url() ?>assets/frontend/vendor/hs-megamenu/src/hs.megamenu.css" />
            <link rel="stylesheet" href="<?= base_url() ?>assets/frontend/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css" />
            <link rel="stylesheet" href="<?= base_url() ?>assets/frontend/vendor/fancybox/jquery.fancybox.css" />
            <link rel="stylesheet" href="<?= base_url() ?>assets/frontend/vendor/slick-carousel/slick/slick.css"/>

            <link rel="stylesheet" href="<?= base_url() ?>assets/frontend/css/jquery-ui.css" />
            <!-- CSS Front Template -->
            <link rel="stylesheet" href="<?= base_url() ?>assets/frontend/css/front.css" />


            <?php
            if ($this->ion_auth->is_member() AND $this->session->userdata('queryform')) {
                header('Location: ' . $this->session->userdata('queryform'));
            }
            ?>
    </head>
    <body>
        <!-- ========== HEADER ========== -->
        <header id="header" class="u-header">
            <div class="u-header__section">
                <!-- End Topbar -->
                <div id="logoAndNav" class="container">
                    <!-- Nav -->
                    <nav class="js-mega-menu navbar navbar-expand-md u-header__navbar">
                        <!-- Logo -->
                        <a class="navbar-brand u-header__navbar-brand u-header__navbar-brand-top-space" href="<?php
                        if (!$this->ion_auth->is_professional()) {
                            echo base_url();
                        } else {
                            echo base_url('professional-dashboard');
                        }
                        ?>" aria-label="Front">
                            <img src="<?= base_url('uploads/image/') . $site_data->logo; ?>" alt="Logo">
                        </a>
                        <!-- End Logo -->
                        <!-- Responsive Toggle Button -->
                        <button type="button" class="navbar-toggler btn u-hamburger"
                                aria-label="Toggle navigation"
                                aria-expanded="false"
                                aria-controls="navBar"
                                data-toggle="collapse"
                                data-target="#navBar">
                            <span id="hamburgerTrigger" class="u-hamburger__box">
                                <span class="u-hamburger__inner"></span>
                            </span>
                        </button>
                        <!-- End Responsive Toggle Button -->
                        <!-- Navigation -->
                        <div id="navBar" class="collapse navbar-collapse py-0">
                            <ul class="navbar-nav u-header__navbar-nav ml-lg-auto">
                                <!-- Home -->
                                <?php if (!$this->ion_auth->is_professional()) { ?>
                                    <li class="nav-item  u-header__nav-item"
                                        data-event="hover"
                                        data-animation-in="slideInUp"
                                        data-animation-out="fadeOut"
                                        data-position="left">
                                        <a id="homeMegaMenu" class="nav-link u-header__nav-link pl-0" href="<?= base_url() ?>"
                                           aria-haspopup="true"
                                           aria-expanded="false">
                                            Home
                                        </a>
                                    </li>
                                    <!-- End Home -->



                                    <!-- Blog -->
                                    <li class="nav-item  u-header__nav-item"
                                        data-event="hover"
                                        data-animation-in="slideInUp"
                                        data-animation-out="fadeOut">
                                        <a id="blogMegaMenu" class="nav-link u-header__nav-link" href="<?= base_url('services') ?>"
                                           aria-haspopup="true"
                                           aria-expanded="false"
                                           aria-labelledby="blogSubMenu">
                                            Services
                                        </a>
                                    </li>
                                    <!-- End Blog -->
                                    <!-- Blog -->
                                    <li class="nav-item  u-header__nav-item"
                                        data-event="hover"
                                        data-animation-in="slideInUp"
                                        data-animation-out="fadeOut">
                                        <a id="blogMegaMenu" class="nav-link u-header__nav-link" href="<?= base_url('contact-us') ?>"
                                           aria-haspopup="true"
                                           aria-expanded="false"
                                           aria-labelledby="blogSubMenu">
                                            Contact Us
                                        </a>
                                    </li>
                                    <!-- End Blog -->
                                    <!-- Blog -->

                                <?php } ?>

                                <?php if (!$this->ion_auth->logged_in()) { ?>
                                    <li class="nav-item  u-header__nav-item"
                                        data-event="hover"
                                        data-animation-in="slideInUp"
                                        data-animation-out="fadeOut">
                                        <a id="blogMegaMenu" class="nav-link u-header__nav-link" href="<?= base_url('login') ?>"
                                           aria-haspopup="true"
                                           aria-expanded="false"
                                           aria-labelledby="blogSubMenu">
                                            Login / Sign Up
                                        </a>
                                    </li>
                                <?php } ?>

                                <!-- End Blog -->
                                <?php if (!$this->ion_auth->is_professional()) {
                                    ?>
                                    <!-- Button -->
                                    <li class="nav-item  d-md-inline-block pb-1 pr-1">
                                        <a class="btn btn-sm btn-primary u-btn-primary transition-3d-hover" href="<?= base_url('post-request'); ?>" target="_blank">
                                            Post Request
                                        </a>
                                    </li>

                                    <?php if (!$this->ion_auth->is_member()) { ?>
                                        <?php if (!$this->ion_auth->logged_in()) { ?>
                                            <li class="nav-item  d-md-inline-block pb-1 pr-1">
                                                <a class="btn btn-sm btn-primary u-btn-primary transition-3d-hover" href="<?= base_url('join-as-pro') ?>" target="_blank">
                                                    Join as a Service Provider
                                                </a>
                                            </li> <?php
                                        }
                                    } else {
                                        ?>



                                        <li class="nav-item  d-md-inline-block pb-1 pr-1">
                                            <div class="dropdown">
                                                <div class="dropdown-toggle" id="menu1" alt="" data-toggle="dropdown" ><?= $loggedin_user->first_name ?></div>

                                                <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="<?= base_url('my-bookings') ?>">Ongoing Booking</a></li>
                                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="<?= base_url('booking-history') ?>">Booking History</a></li>
                                                    <li role="presentation"><a class="<?= ($unread_message != 0) ? 'font-weight-bold text-dark' : ''; ?>" role="menuitem" tabindex="-1" href="<?= base_url('customer-chat') ?>">Messages <?= '(' . $unread_message . ')' ?></a></li>

                                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="<?= base_url('change-password'); ?>">Change Password</a></li>

                                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="<?= base_url('logout') ?>">Logout</a></li>

                                                </ul>
                                            </div>
                                        </li>
                                        <!-- End Button -->
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <li class="nav-item  d-md-inline-block pb-1 pr-1">
                                        <div class="dropdown">
                                            <img class="dropdown-toggle img_pro" src="<?= base_url() ?>assets/avator.jpg" id="menu1" alt="" data-toggle="dropdown" style="border-radius: 50%;height: 55px;">
                                                <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">

                                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="<?= base_url('professional-dashboard') ?>">Dashboard</a></li>
                                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="<?= base_url('profile'); ?>">Profile</a></li>
                                                    <?php if ($loggedin_user->verification == 1) { ?>
                                                        <li role="presentation"><a role="menuitem" tabindex="-1" href="<?= base_url('all-leads') ?>">New Leads</a></li>

                                                        <li role="presentation"><a role="menuitem" tabindex="-1" href="<?= base_url('ongoing-leads') ?>">Ongoing Leads</a></li>

                                                        <li role="presentation"><a role="menuitem" tabindex="-1" href="<?= base_url('converted-leads') ?>">Converted Leads</a></li>

                                                        <li role="presentation"><a role="menuitem" tabindex="-1" href="<?= base_url('professional-messages'); ?>">Your Messages</a></li>

                                                        <li role="presentation"><a role="menuitem" tabindex="-1" href="<?= base_url('upload-image'); ?>">Service Image</a></li>

                                                        <li role="presentation"><a role="menuitem" tabindex="-1" href="<?= base_url('change-password'); ?>">Change Password</a></li>

                                                    <?php } ?>

                                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="<?= base_url('logout') ?>">Logout</a></li>
                                                </ul>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                        <!-- End Navigation -->
                    </nav>
                    <!-- End Nav -->
                </div>
            </div>
        </header>
        <!-- ========== END HEADER ========== -->


        <?= $contents; ?>



        <!-- ========== FOOTER ========== -->
        <footer class="u-gradient-half-primary-v4 footer">
            <div class="container">
                <!-- CTA -->

                <!-- End CTA -->
                <hr class="opacity-0_2 my-0">
                    <div class="row justify-content-md-between u-space-2">
                        <div class="col-6 col-sm-4 col-lg-2 order-lg-2 mb-7 mb-lg-0">
                            <!-- Title -->
                            <h3 class="h6 text-white">
                                <strong>Company</strong>
                            </h3>
                            <!-- End Title -->
                            <!-- List -->
                            <ul class="list-unstyled u-list u-list--white">
                                <?php foreach ($menus as $row) { ?>
                                    <li><a class="u-list__link" href="<?= base_url($row->slug) ?>"><?= $row->title ?></a></li>
                                <?php } ?>
                            </ul>
                            <!-- End List -->
                        </div>
                        <div class="col-6 col-sm-4 col-lg-2 order-lg-3 mb-7 mb-lg-0">
                            <!-- Title -->
                            <h3 class="h6 text-white">
                                <strong>Account </strong>
                            </h3>
                            <!-- End Title -->
                            <!-- List -->
                            <ul class="list-unstyled u-list u-list--white">
                                <?php if (!$this->ion_auth->is_professional()) {
                                    ?>
                                    <li><a class="u-list__link" href="<?= base_url(); ?>">Home</a></li>
                                    <li><a class="u-list__link" href="<?= base_url('services'); ?>">Services</a></li>
                                    <li><a class="u-list__link" href="<?= base_url('post-request'); ?>">Post Request</a></li>
                                    <?php if (!$this->ion_auth->logged_in()) { ?>
                                        <li><a class="u-list__link" href="<?= base_url('login'); ?>">Login</a></li>
                                        <li><a class="u-list__link" href="<?= base_url('join-as-pro'); ?>">Join as a Service Provider</a></li>
                                        <?php
                                    }
                                }
                                ?>
                                <li><a class="u-list__link" href="<?= base_url('contact-us'); ?>">Contact Us</a></li>
                            </ul>
                            <!-- End List -->
                        </div>

                        <div class="col-sm-6 col-md-5 col-lg-3 order-lg-5 mb-6 mb-sm-0">
                            <!-- Title -->
                            <h3 class="h6 text-white ml-3">
                                <strong>Mobile Apps</strong>
                            </h3>
                            <!-- End Title -->
                            <p>
                                <img src="<?= base_url() ?>assets/frontend/img/an.png" style="width:50%;">
                            </p>

                            <p>
                                <a href="https://www.facebook.com/UrbanSenseApp/" target="_blank" class="social_icon"> <i class="fa fa-facebook-square"></i> </a>
                                <a href="https://twitter.com/UrbanSenseApp" target="_blank"  class="social_icon"><i class="fa fa-twitter-square"></i></a>
                            </p>
                            <!-- Events -->
                            <!-- End Events -->
                        </div>
                        <div class="col-sm-6 col-md-5 col-lg-3 order-lg-1">
                            <div class="d-flex align-self-start flex-column h-40">
                                <h3 class="h6 text-white">
                                    <strong>UrbanSense</strong>
                                </h3>
                                <ul class="list-unstyled u-list u-list--white">
                                    <li>
                                        <a class="u-list__link justify" href="#">UrbanSense is your one stop platform for all your service needs. We provide plumbing, interior decor, electrical repairs and many more.</a>
                                    </li>
                                </ul>
                                <!-- Copyright -->
                                <p class="small u-text-light mt-lg-auto mb-0">&copy; UrbanSense 2019   </p>
                                <!-- End Copyright -->
                            </div>
                        </div>
                    </div>
            </div>
            
        <div id="phoneDownloadModal" class="modal" role="dialog">
         <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
               <div class="modal-header">
                  <h4 class="modal-title">Download App</h4>
                  <button type="button" class="close" data-dismiss="modal" id="download-app-popup-close">&times;</button>
               </div>
               <div class="modal-body">
                   <div class="row">
                       <div class="col-md-12">
                           <h4>For users</h4>
                       </div>
                       
                       <div class="col-md-6 col-sm-6">
                           <a href="https://play.google.com/store/apps/details?id=com.dignitech.urbansense"><img src="<?php echo base_url('assets/frontend/img/play-store.png');  ?>"></a>
                       </div>
                       
                       <div class="col-md-6 col-sm-6" style="margin-top:1em;">
                           <a href="https://apps.apple.com/in/app/urbansense/id1451270736"><img src="<?php echo base_url('assets/frontend/img/app-store.png');  ?>"></a>
                       </div>
                   </div>
                   
                   <div class="row">
                       <div class="col-md-12">
                           <h4>For service providers</h4>
                       </div>
                       <div class="col-md-6 col-sm-6">
                           <a href="https://play.google.com/store/apps/details?id=com.dignitech.usprovider"><img src="<?php echo base_url('assets/frontend/img/play-store.png');  ?>"></a>
                       </div>
                       
                       <div class="col-md-6 col-sm-6" style="margin-top:1em;">
                           <a href="https://apps.apple.com/in/app/urbansense-pro/id1451202523"><img src="<?php echo base_url('assets/frontend/img/app-store.png');  ?>"></a>
                       </div>
                   </div>
                    
                       
               </div>
               <div class="modal-footer">
                   
               </div>
            </div>
         </div>
      </div>
            
        </footer>
        <!-- ========== END FOOTER ========== -->
        <!-- Go to Top -->
        <a class="js-go-to u-go-to" href="#"
           data-position='{"bottom": 15, "right": 15 }'
           data-type="fixed"
           data-offset-top="400"
           data-compensation="#header"
           data-show-effect="slideInUp"
           data-hide-effect="slideOutDown">
            <span class="fa fa-arrow-up u-go-to__inner"></span>
        </a>
        <!-- End Go to Top -->
        <!-- JS Global Compulsory -->
        <script src="<?= base_url() ?>assets/frontend/vendor/jquery/dist/jquery.min.js"></script>
        <script src="<?= base_url() ?>assets/frontend/js/select2.min.js" ></script>
        <script src="<?= base_url() ?>assets/frontend/vendor/jquery-migrate/dist/jquery-migrate.min.js" ></script>
        <script src="<?= base_url() ?>assets/frontend/vendor/popper.js/dist/umd/popper.min.js" ></script>
        <script src="<?= base_url() ?>assets/frontend/vendor/bootstrap/bootstrap.min.js"></script>
        <!-- JS Implementing Plugins -->
        <script src="<?= base_url() ?>assets/frontend/vendor/hs-megamenu/src/hs.megamenu.js" ></script>
        <script src="<?= base_url() ?>assets/frontend/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js" ></script>
        <script src="<?= base_url() ?>assets/frontend/vendor/jquery-validation/dist/jquery.validate.min.js" ></script>
        <script src="<?= base_url() ?>assets/frontend/vendor/fancybox/jquery.fancybox.min.js" ></script>
        <script src="<?= base_url() ?>assets/frontend/vendor/slick-carousel/slick/slick.js" ></script>
        <!-- JS Front -->
        <script src="<?= base_url() ?>assets/frontend/js/hs.core.js" ></script>
        <script src="<?= base_url() ?>assets/frontend/js/components/hs.header.js" ></script>
        <script src="<?= base_url() ?>assets/frontend/js/components/hs.unfold.js" ></script>
        <script src="<?= base_url() ?>assets/frontend/js/helpers/hs.focus-state.js" ></script>
        <script src="<?= base_url() ?>assets/frontend/js/components/hs.malihu-scrollbar.js" ></script>
        <script src="<?= base_url() ?>assets/frontend/js/components/hs.validation.js" ></script>
        <script src="<?= base_url() ?>assets/frontend/js/components/hs.fancybox.js" ></script>
        <script src="<?= base_url() ?>assets/frontend/js/components/hs.slick-carousel.js" ></script>
        <script src="<?= base_url() ?>assets/frontend/js/components/hs.go-to.js" ></script>
        <script src="<?= base_url() ?>assets/frontend/js/jquery-ui.js"></script>
       <!--   <script src="<?= base_url() ?>assets/frontend/js/typeahead.min.js"></script> -->
        <script src="<?= base_url() ?>assets/frontend/js/jquery.form.js" ></script>
        <script src="<?= base_url() ?>assets/frontend/js/sweetalert.min.js" ></script>
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=false&libraries=places&key=AIzaSyBTyhhiO6FnR-UYlyeM01lDl2Yqsqm2tp0"></script>

        <script src="<?= base_url() ?>assets/frontend/js/get_lat_long.js"></script>
        <script src="<?= base_url() ?>assets/frontend/js/pro_chat.js" ></script>
        <script src="<?= base_url() ?>assets/frontend/js/canvasjs.min.js" ></script>
        <script src="<?= base_url() ?>assets/frontend/facebook.js"></script>

        <script src="<?= base_url() ?>assets/frontend/custom.js"></script>
        <script> var base_url = "<?= base_url(); ?>";</script>
        <script type="text/javascript" src="https://appleid.cdn-apple.com/appleauth/static/jsapi/appleid/1/en_US/appleid.auth.js"></script>
       


        <script>
            var dateToday = new Date();
            $(function () {
                $(".datepicker").datepicker({
                    minDate: dateToday
                });
            });
        </script>
        <!-- JS Plugins Init. -->
        <script>
            $(window).on('load', function () {
                // initialization of HSMegaMenu component
                $('.js-mega-menu').HSMegaMenu({
                    event: 'hover',
                    pageContainer: $('.container'),
                    breakpoint: 767,
                    hideTimeOut: 0
                });
            });

            $(document).on('ready', function () {
                // initialization of header
                $.HSCore.components.HSHeader.init($('#header'));

                // initialization of unfold component
                $.HSCore.components.HSUnfold.init($('[data-unfold-target]'), {
                    afterOpen: function () {
                        $(this).find('input[type="search"]').focus();
                    }
                });

                // initialization of forms
                $.HSCore.helpers.HSFocusState.init();

                // initialization of form validation
                $.HSCore.components.HSValidation.init('.js-validate');

                // initialization of fancybox
                $.HSCore.components.HSFancyBox.init('.js-fancybox');

                // initialization of slick carousel
                $.HSCore.components.HSSlickCarousel.init('.js-slick-carousel');

                // initialization of slick carousel
                $.HSCore.components.HSMalihuScrollBar.init($('.js-scrollbar'));

                // initialization of go to
                $.HSCore.components.HSGoTo.init('.js-go-to');
            });
        </script>

        <script type="text/javascript">

            if ($('#my-address').val() == '') {
                window.onload = function getLocation() {
                    if (navigator.geolocation) {
                        //alert(navigator.geolocation.getCurrentPosition(showPosition));
                        navigator.geolocation.getCurrentPosition(showPosition, showError);
                    } else {
                        document.getElementById("my-address").innerHTML = "Geolocation is not supported by this browser.";
                    }
                }
            }


            function showPosition(position) {
                var lat = position.coords.latitude;
                var long = position.coords.longitude;
                displayLocation(lat, long);

            }

            function displayLocation(latitude, longitude) {
                var geocoder;
                geocoder = new google.maps.Geocoder();
                var latlng = new google.maps.LatLng(latitude, longitude);

                geocoder.geocode(
                        {'latLng': latlng},
                        function (results, status) {
                            if (status == google.maps.GeocoderStatus.OK) {
                                if (results[0]) {
                                    var add = results[0].formatted_address;
                                    var value = add.split(",");

                                    setCookie('location', add, 1);
                                    setCookie('longitude', longitude, 1);
                                    setCookie('latitude', latitude, 1);
                                    if (!'<?= $this->input->cookie('location') ?>') {
                                        document.location.reload(true);
                                    }


                                } else {
                                    document.getElementById("my-address").value = "address not found";
                                }
                            } else {
                                document.getElementById("my-address").value = "Geocoder failed due to: " + status;
                            }
                        }
                );
            }


            function showError(error) {
                switch (error.code) {
                    case error.PERMISSION_DENIED:
                        document.getElementById("my-address").innerHTML = "User denied the request for Geolocation."
                        break;
                    case error.POSITION_UNAVAILABLE:
                        document.getElementById("my-address").innerHTML = "Location information is unavailable."
                        break;
                    case error.TIMEOUT:
                        document.getElementById("my-address").innerHTML = "The request to get user location timed out."
                        break;
                    case error.UNKNOWN_ERROR:
                        document.getElementById("my-address").innerHTML = "An unknown error occurred."
                        break;
                }
            }

            function setCookie(cname, cvalue, exdays) {
                var d = new Date();
                d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
                var expires = "expires=" + d.toUTCString();
                document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
            }

            function deleteCookie(cname) {
                var d = new Date(); //Create an date object
                d.setTime(d.getTime() - (1000 * 60 * 60 * 24)); //Set the time to the past. 1000 milliseonds = 1 second
                var expires = "expires=" + d.toGMTString(); //Compose the expirartion date
                window.document.cookie = cname + "=" + "; " + expires;//Set the cookie with name and the expiration date

            }

        </script>

        <script type="text/javascript">
            function change_time(date) {
                var today = "<?= date('m/d/Y') ?>";
                var time = "<?= date('His') ?>";
                document.getElementById('avail_time').innerHTML = "";
                if (date == today) {
                    if (time < '085959') {
                        document.getElementById('avail_time').innerHTML += '<option value="">-Select Preferred Time-</option><option value="9 am to 12 pm">9 am to 12 pm</option><option value="12 pm to 3 pm">12 pm to 3 pm</option><option value="3 pm to 6 pm">3 pm to 6 pm</option><option value="6 pm to 9 pm">6 pm to 9 pm</option>';
                    } else if (time < '115959') {
                        document.getElementById('avail_time').innerHTML += '<option value="">-Select Preferred Time-</option><option value="12 pm to 3 pm">12 pm to 3 pm</option><option value="3 pm to 6 pm">3 pm to 6 pm</option><option value="6 pm to 9 pm">6 pm to 9pm</option>';
                    } else if (time < '145959') {
                        document.getElementById('avail_time').innerHTML += '<option value="">-Select Preferred Time-</option><option value="3 pm to 6 pm">3 pm to 6 pm</option><option value="6 pm to 9 pm">6 pm to 9 pm</option>';
                    } else if (time < '175959') {
                        document.getElementById('avail_time').innerHTML += '<option value="">-Select Preferred Time-</option><option value="6 pm to 9 pm">6 pm to 9 pm</option>';
                    } else {
                        document.getElementById('avail_time').innerHTML += '<option value="">-No time slot available for today-</option>';
                    }

                } else {
                    document.getElementById('avail_time').innerHTML += '<option value="">-Select Preferred Time-</option><option value="9 am to 12 pm">9 am to 12 pm</option><option value="12 pm to 3 pm">12 pm to 3 pm</option><option value="3 pm to 6 pm">3 pm to 6 pm</option><option value="6 pm to 9 pm">6 pm to 9 pm</option>';
                }
            }
        </script>

        <?php if ($this->session->flashdata('success')) { ?>
            <script>
                swal("Good job!", '<?= $this->session->flashdata('success'); ?>', "success");
            </script>
        <?php } ?>

        <?php if ($this->session->flashdata('warning')) { ?>
            <script>
                swal("Warning!", '<?= $this->session->flashdata('warning'); ?>', "warning");
            </script>
        <?php } ?>

        <?php if ($this->session->flashdata('error')) { ?>
            <script>
                swal("Sorry!", '<?= $this->session->flashdata('error'); ?>', "error");
            </script>
        <?php } ?>

        <script>
                            
//                            $("#phoneDownloadModal").modal("show");
                            
                            
        if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
            
            console.log("type of cookie");
            if(document.cookie.indexOf('open-app-download-popup') === -1 ){
                //no cookie
                console.log("cookie not set and showing modal");
                $("#phoneDownloadModal").modal("show");
                spu_createCookie("open-app-download-popup",'no',2);
            } 

        }
        
        function spu_createCookie(name, value, hours){
            if (hours){
                var date = new Date();
                date.setTime(date.getTime()+(hours*60*60*1000));
                var expires = "; expires="+date.toGMTString();
            }
            else{
                var expires = "";
            }
            document.cookie = name+"="+value+expires+"; path=/";
        }
        
        </script>
    </body>
</html>
