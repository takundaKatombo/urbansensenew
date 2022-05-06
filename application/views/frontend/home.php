
<!-- ========== MAIN CONTENT ========== -->
<main id="content" role="main">
    <!-- Hero Section -->
    <div class="position-relative">
        <!-- Slick Carousel -->
        <div class="js-slick-carousel u-slick"
             data-fade="true"
             data-autoplay="true"
             data-speed="5000"
             data-infinite="true">
            <div class="js-slide">
                <div class="u-bg-img-hero" style="background-image: url(assets/frontend/img/1920x800/img18.jpg);min-height:400px"></div>
            </div>
            <div class="js-slide">
                <div class="u-bg-img-hero" style="background-image: url(assets/frontend/img/1920x800/img17.jpg);min-height:400px"></div>
            </div>
        </div>
        <!-- End Slick Carousel -->

        <div class="container position-absolute-bottom-0 u-space-5-top u-space-2-bottom">
            <!-- Info Link -->

            <!-- End Info Link -->
            <h2 class="text-center">Search Thousands of Qualified Service Providers</h2>
            <div class="rounded p-3" style="background:rgba(0, 0, 0, 0.2);">
                <!-- Search Jobs Form -->


                <form class="js-validate" id="formid" method="get" action="<?= base_url('search-service') ?>">
                    <div class="row">
                        <div class="col-lg-5 mb-4 mb-lg-0">

                            <!-- Input -->
                             <!--   <input type="text" name="service" class="service form-control"  spellcheck="false" placeholder="What service you are looking for" required="required" autocomplete="off">-->
                            <div class="js-focus-state input-group u-form u-form--no-addon-brd">
                                <div class="bs-example">
                                    <select name="service" class="form-control u-form__input" required="required">
                                        <option></option> 
                                        <?php if (!empty($services)): ?>
                                            <?php foreach ($services as $row): ?>
                                                <option value="<?= $row->slug ?>" <?= ($service_slug == $row->slug) ? 'selected' : ''; ?>><?= ucwords($row->title) ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <!-- End Input -->
                        </div>

                        <div class="col-lg-5 mb-4 mb-lg-0">
                            <!-- Input --> 

                            <div class="js-focus-state input-group u-form u-form--no-addon-brd">
                                <div class="bs-example">

                                    <input class="form-control u-form__input home-search-font" name="location" id="my-address" value="<?= @$location ? $location : ''; ?>" type="text" autocomplete="off"  onkeydown="codeAddress();" onkeyup="codeAddress()" required="required">

                                </div>
                            </div>
                            <input name="longitude" id="longitude" value="<?= @$longitude ? $longitude : ''; ?>" required="" type="hidden">


                            <input name="latitude" id="latitude" required="" value="<?= @$latitude ? $latitude : ''; ?>"  type="hidden">
                            <!-- End Input -->
                        </div>

                        <div class="col-lg-2 align-self-lg-end">
                            <button type="submit" class="btn btn-primary u-btn-primary transition-3d-hover ">Search Services</button>
                        </div>
                    </div>
                    <!-- End Checkbox -->
                </form>
                <!-- End Search Jobs Form -->
            </div>
        </div>
    </div>
    <!-- End Hero Section -->


    <!-- Job Listings Section -->
    <div class="container u-space-1">
        <!-- Title -->


        <div class="d-sm-flex justify-content-sm-between align-items-sm-center mb-5">
            <h2 class="h3 font-weight-medium">Explore the Marketplace</h2>
            <a class="u-link-muted" href="<?= base_url('services') ?>">
                See all Services
                <span class="fa fa-angle-right font-size-13 ml-2"></span>
            </a>
        </div>


        <!-- End Title -->
        <div class="row">
            <?php $i = 1;
            foreach ($categories as $row) { ?>
                <div class="col-md-4 card bg-transparent border-0 mb-5">
                    <!-- Job Listing -->
                    <a class="card-body u-info-v2 bg-white-home text-center rounded transition-3d-hover p-4" href="<?= base_url('all-services/') . $row->slug ?>">
                        <div class="media">
                            <div class="d-flex">
                            <!--   <img class="u-avatar rounded" src="<?= base_url('uploads/image/') . $row->image; ?>" alt="Image Description"> -->

                                <picture>
                                    <source media="(max-width: 799px)" srcset="<?= base_url("image/display?image=" . base_url('uploads/image/') . $row->image . "&w=50&h=50") ?>">
                                    <source media="(min-width: 800px)" srcset="<?= base_url("image/display?image=" . base_url('uploads/image/') . $row->image . "&w=50&h=50") ?>">
                                    <img src="<?= base_url("image/display?image=" . base_url('uploads/image/') . $row->image . "&w=50&h=50") ?>">
                                </picture>
                            </div>
                            <div class="media-body px-4">
                                <h4 class="h6 text-dark mb-1"><?= ucwords($row->title); ?></h4>
                               <!--  <small class="d-block text-muted">London, UK</small> -->
                            </div>
                        </div>
                    </a>
                    <!-- End Job Listing -->
                </div>
<?php } ?>

        </div>
        <!--  <div class="text-center">
             <a class="btn btn-primary u-btn-primary transition-3d-hover" href="#">View More</a>
           </div> -->
    </div>



    <!-- End Job Listings Section -->


    <div class="container u-space-1">
        <hr class="my-0">
    </div>


    <!-- Get Started Section -->
    <div class="container u-space-1">

        <h2 class="text-center" style="padding-bottom:20px">How it works</h2>
        <div class="row justify-content-md-between">
            <div class="col-sm-6 offset-sm-3 col-lg-4 offset-lg-0 mb-9 mb-lg-0">
                <!-- Icon Blocks -->
                <div class="text-center">
                    <!-- SVG Icon -->
                    <figure class="w-65 mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             viewBox="0 0 168.6 78.8" style="enable-background:new 0 0 168.6 78.8;" xml:space="preserve">
                        <ellipse class="u-fill-light-blue-125" opacity=".5" cx="84.3" cy="71.9" rx="84.3" ry="6.9"/>
                        <g id="XMLID_ca39_">
                        <g id="XMLID_ca70_" opacity=".3">
                        <path id="XMLID_ca72_" class="u-fill-primary" d="M27.3,49.1c-0.3,0.3-1.9,0-3.8,1.7c-0.5,0.5-0.8,1.1-1.2,1.7c-0.3,0.5-0.5,1.1-0.7,1.6
                              c0,0,0,0-0.1,0c-0.4-0.1-0.9-0.2-1.3-0.2v0c0,0-0.1,0-0.1,0c-3.6,0-6.7,2.5-7.4,6H12c-3.2,0-5.8,2.6-5.8,5.8v0.4
                              c0,2.4,1.4,4.4,3.5,5.3l14.7,0L27.3,49.1z"/>
                        <path id="XMLID_ca1_" class="u-fill-primary" d="M27.3,49.1"/>
                        </g>
                        <g id="XMLID_ca68_">
                        <path id="XMLID_ca535_" class="u-fill-white" d="M56.9,60.5h-0.2c-0.9-3.1-3.8-5.4-7.2-5.4c-1.5,0-2.9,0.4-4.1,1.2c-0.8-5-5-8.8-10.2-8.8
                              c-4.6,0-8.6,3.1-9.9,7.3c-0.6-0.2-1.2-0.3-1.8-0.3c-3.5,0-6.5,2.6-7,6h-1.2c-2.9,0-5.3,2.4-5.3,5.3v0.4c0,2.9,2.4,5.3,5.3,5.3
                              h41.6c2.9,0,5.3-2.4,5.3-5.3v-0.4C62.2,62.9,59.8,60.5,56.9,60.5z"/>
                        <path id="XMLID_ca69_" class="u-fill-none u-stroke-primary" stroke-width="1.5" stroke-miterlimit="10" d="M50.5,71.5h6.3c2.9,0,5.3-2.4,5.3-5.3v-0.4c0-2.9-2.4-5.3-5.3-5.3h-0.2
                              c-0.9-3.1-3.8-5.4-7.2-5.4c-1.5,0-2.9,0.4-4.1,1.2c-0.8-5-5-8.8-10.2-8.8c-3.2,0-6,1.4-7.9,3.7c-0.4,0.5-0.8,1-1.1,1.6
                              c-0.3,0.6-0.6,1.3-0.8,2c-0.6-0.2-1.2-0.3-1.8-0.3c-3.5,0-6.5,2.6-7,6h-1.2c-2.9,0-5.3,2.4-5.3,5.3v0.4c0,2.9,2.4,5.3,5.3,5.3h29"
                              />
                        <path id="XMLID_ca531_" class="u-fill-none u-stroke-primary" stroke-width="1.5" stroke-miterlimit="10" d="M23.6,54.5c2,0,3.7,1.6,3.7,3.7"/>
                        </g>
                        <g id="XMLID_ca710_">
                        <path id="XMLID_ca424_" class="u-fill-warning-lighter" d="M37.6,61.6h-1.8v-3.6c0-1.8-1.5-3.2-3.2-3.2c-1.8,0-3.2,1.5-3.2,3.2v3.6h-1.8v-3.6
                              c0-2.8,2.2-5,5-5c2.8,0,5,2.2,5,5V61.6z"/>
                        <path id="XMLID_ca67_" class="u-fill-none u-stroke-darker" stroke-miterlimit="10" d="M37.6,61.6h-1.8v-3.6c0-1.8-1.5-3.2-3.2-3.2c-1.8,0-3.2,1.5-3.2,3.2v3.6h-1.8v-3.6
                              c0-2.8,2.2-5,5-5c2.8,0,5,2.2,5,5V61.6z"/>
                        <path id="XMLID_ca778_" class="u-fill-white" d="M39,64.9c0,3.6-2.9,6.5-6.5,6.5c-3.6,0-6.5-2.9-6.5-6.5s2.9-6.5,6.5-6.5
                              C36.1,58.5,39,61.3,39,64.9z"/>
                        <path id="XMLID_ca65_" class="u-fill-none u-stroke-warning" stroke-width="1.5" stroke-miterlimit="10" d="M39,64.9c0,3.6-2.9,6.5-6.5,6.5c-3.6,0-6.5-2.9-6.5-6.5s2.9-6.5,6.5-6.5
                              C36.1,58.5,39,61.3,39,64.9z"/>
                        <path id="XMLID_ca409_" class="u-fill-warning-lighter" opacity="0.6" d="M37,64.9c0,2.4-2,4.4-4.4,4.4c-2.4,0-4.4-2-4.4-4.4s2-4.4,4.4-4.4C35,60.5,37,62.5,37,64.9z"
                              />
                        <path id="XMLID_ca63_" class="u-fill-warning-darker" d="M34.1,64.1c0,0.9-0.7,1.5-1.5,1.5c-0.9,0-1.5-0.7-1.5-1.5c0-0.9,0.7-1.5,1.5-1.5
                              C33.4,62.5,34.1,63.2,34.1,64.1z"/>
                        <rect id="XMLID_ca54_" x="31.6" y="63.9" class="u-fill-warning-darker" width="1.8" height="3.5"/>
                        </g>
                        <g id="XMLID_ca371_">
                        <path id="XMLID_ca66_" class="u-fill-primary" opacity=".1" d="M153.3,68.2v-67h4.3c0.9,0,1.7,0.7,1.7,1.6v68.3H159h-0.2h-5.1
                              C153.5,71.1,153.3,69.8,153.3,68.2z"/>
                        <path id="XMLID_ca434_" class="u-fill-white" d="M157.2,71.4h-39.3V4.2c0-1.7,1.4-3,3-3h33.2c1.7,0,3,1.4,3,3V71.4z"/>
                        <path id="XMLID_ca423_" class="u-fill-primary" d="M157.2,8.7h-39.3V3.5c0-1.3,1-2.3,2.3-2.3h34.6c1.3,0,2.3,1,2.3,2.3V8.7z"/>
                        <rect id="XMLID_ca418_" x="123.8" y="31.3" class="u-fill-danger" opacity=".2" width="27.2" height="3.8"/>
                        <rect id="XMLID_ca2_" x="123.8" y="37.3" class="u-fill-danger" opacity=".2" width="27.2" height="3.8"/>
                        <rect id="XMLID_ca413_" x="123.8" y="43.3" class="u-fill-danger" opacity=".2" width="27.2" height="3.7"/>
                        <circle class="u-fill-white" cx="122.5" cy="4.3" r="0.7"/>
                        <circle class="u-fill-white" cx="124.5" cy="4.3" r="0.7"/>
                        <circle class="u-fill-white" cx="126.5" cy="4.3" r="0.7"/>
                        <g id="XMLID_ca367_">
                        <path id="XMLID_ca369_" class="u-fill-none u-stroke-primary" stroke-width="1.5" stroke-miterlimit="10" d="M139.3,16.7c0,1.1-0.9,2-2,2c-1.1,0-2-0.9-2-2c0-1.1,0.9-2,2-2
                              C138.4,14.7,139.3,15.6,139.3,16.7z"/>
                        <path id="XMLID_ca368_" class="u-fill-none u-stroke-primary" stroke-width="1.5" stroke-miterlimit="10" d="M134.1,25.5v-1.9c0-1.8,1.5-3.3,3.3-3.3l0,0c1.8,0,3.3,1.5,3.3,3.3v1.9"/>
                        </g>
                        <circle id="XMLID_ca374_" class="u-fill-none u-stroke-primary" stroke-width="1.5" stroke-miterlimit="10" cx="137.4" cy="20.1" r="7.6"/>
                        </g>
                        <g id="XMLID_ca77_">
                        <path id="XMLID_ca110_" class="u-fill-white" d="M123.9,68.6H53.6c-0.6,0-1-0.5-1-1v-50c0-0.5,0.4-1,1-1h70.3c0.5,0,1,0.5,1,1v50
                              C124.9,68.2,124.5,68.6,123.9,68.6z"/>
                        <line id="XMLID_ca108_" class="u-fill-none u-stroke-primary" stroke-width="1.5" stroke-miterlimit="10" x1="109" y1="16.6" x2="114" y2="16.6"/>
                        <path id="XMLID_ca107_" class="u-fill-none u-stroke-primary" stroke-width="1.5" stroke-miterlimit="10" d="M52.6,41V18.4c0-1,0.8-1.8,1.8-1.8h51.4"/>
                        <path id="XMLID_ca105_" class="u-fill-none u-stroke-primary" stroke-width="1.5" stroke-miterlimit="10" d="M116.1,16.6h7c1,0,1.8,0.8,1.8,1.8v36.1"/>
                        <rect id="XMLID_ca100_" x="56.1" y="20.7" class="u-fill-primary" width="64.9" height="42.2"/>
                        <path id="XMLID_ca94_" class="u-fill-white" d="M123.7,71.5H53c-1.7,0-3.1-1.2-3.4-2.9l-0.5-3.1h32.7l1.3,1.8h9l1.4-1.8H128l-0.4,2.7
                              C127.2,70.1,125.6,71.5,123.7,71.5z"/>
                        <path id="XMLID_ca93_" class="u-fill-none u-stroke-primary" stroke-width="1.5" stroke-miterlimit="10" d="M123.7,71.5H53c-1.7,0-3.1-1.2-3.4-2.9l-0.5-3.1h32.7l1.3,1.8h9l1.4-1.8H128l-0.4,2.7
                              C127.2,70.1,125.6,71.5,123.7,71.5z"/>
                        </g>
                        <g id="XMLID_ca73_">
                        <g id="XMLID_ca78_">
                        <path id="XMLID_ca82_" class="u-fill-white" d="M158.9,71.5h-20.2c-0.9,0-1.6-0.7-1.6-1.6V56.6c0-0.9,0.7-1.6,1.6-1.6h20.2
                              c0.9,0,1.6,0.7,1.6,1.6v13.3C160.5,70.8,159.8,71.5,158.9,71.5z"/>
                        <path id="XMLID_ca81_" class="u-fill-primary-lighter" opacity=".2" d="M160.5,55l-11.2,7.9c-0.3,0.2-0.7,0.2-1,0L137.1,55H160.5z"/>
                        <path id="XMLID_ca80_" class="u-fill-none u-stroke-primary" stroke-width="1.5" stroke-miterlimit="10" d="M137.3,55.2l11,7.7c0.3,0.2,0.7,0.2,1,0l2.3-1.6"/>
                        <path id="XMLID_ca79_" class="u-fill-none u-stroke-primary" stroke-width="1.5" stroke-miterlimit="10" d="M160.5,63.9v6.5c0,0.6-0.5,1-1,1h-21.3c-0.6,0-1-0.5-1-1V56c0-0.6,0.5-1,1-1h12.8"/>
                        </g>
                        <circle id="XMLID_ca76_" class="u-fill-danger" stroke-width="1.5" stroke-miterlimit="10" cx="157.7" cy="57.3" r="6.1"/>
                        <polyline id="XMLID_ca74_" class="u-fill-none u-stroke-white" stroke-width="1.5" stroke-miterlimit="10" points="156.7,55.2 158.1,55.2 158.1,59.6    "/>
                        </g>
                        <g id="XMLID_ca538_">
                        <g id="XMLID_ca745_">
                        <path id="XMLID_ca783_" class="u-fill-none u-stroke-warning-darker" stroke-width="1.5" stroke-miterlimit="10" d="M95.5,39.6c1.2,1.2,0.8,3.6,0.8,3.6s-2.4,0.4-3.6-0.8c-1.2-1.2-0.8-3.6-0.8-3.6
                              S94.2,38.3,95.5,39.6z"/>
                        <path id="XMLID_ca793_" class="u-fill-none u-stroke-warning-darker" stroke-width="1.5" stroke-miterlimit="10" d="M78.6,39.6c-1.2,1.2-0.8,3.6-0.8,3.6s2.4,0.4,3.6-0.8c1.2-1.2,0.8-3.6,0.8-3.6
                              S79.8,38.3,78.6,39.6z"/>
                        <path id="XMLID_ca819_" class="u-fill-white" d="M93,40c0,0.4-0.3,0.6-0.6,0.6l0,0c-0.4,0-0.6-0.3-0.6-0.6v-0.6c0-0.4,0.3-0.6,0.6-0.6l0,0
                              c0.4,0,0.6,0.3,0.6,0.6V40z"/>
                        <path id="XMLID_ca787_" class="u-fill-white" d="M82.3,40c0,0.4-0.3,0.6-0.6,0.6l0,0c-0.4,0-0.6-0.3-0.6-0.6v-0.6c0-0.4,0.3-0.6,0.6-0.6l0,0
                              c0.4,0,0.6,0.3,0.6,0.6V40z"/>
                        <path id="XMLID_ca782_" class="u-fill-warning-lighter" d="M92.5,38v-1.5c0-3.1-2.5-5.6-5.6-5.6l0,0c-3.1,0-5.6,2.5-5.6,5.6V38c0,0.2,0.2,0.4,0.4,0.4
                              h10.3C92.3,38.4,92.5,38.2,92.5,38z"/>
                        <path id="XMLID_ca733_" class="u-fill-none u-stroke-warning-darker" stroke-width="1.5" stroke-miterlimit="10" d="M92.5,38v-1.5c0-3.1-2.5-5.6-5.6-5.6l0,0c-3.1,0-5.6,2.5-5.6,5.6V38c0,0.2,0.2,0.4,0.4,0.4
                              h10.3C92.3,38.4,92.5,38.2,92.5,38z"/>
                        <path id="XMLID_ca775_" class="u-fill-success" d="M93,52.6v-1c0-3.2-2.6-5.9-5.9-5.9l0,0c-3.2,0-5.9,2.6-5.9,5.9v1H93z"/>
                        <path id="XMLID_ca824_" class="u-fill-white" d="M93,52.6v-1c0-1.6-0.6-3-1.6-4c0,1.1,0,2.7,0,4.4v0.6H93z"/>
                        <path id="XMLID_ca822_" class="u-fill-white" d="M82.7,52c0-1.7,0-3.2,0-4.3c-0.9,1-1.5,2.4-1.5,3.9v1h1.5V52z"/>
                        <path id="XMLID_ca774_" class="u-fill-white" d="M85.7,50.8h2.7c1.3,0,2-0.9,1.9-2.4v-1.5c-0.7-0.6-1.6-1-2.6-1.1c-0.6,0-1.2,0-1.3,0
                              c0,0-0.1,0-0.2,0c-0.9,0.2-1.8,0.6-2.5,1.2v1.6C83.6,49.8,84.5,50.8,85.7,50.8z"/>
                        <path id="XMLID_ca773_" class="u-fill-none u-stroke-white" stroke-width="1.5" stroke-miterlimit="10" d="M85.7,50.8h2.7c1.3,0,2-0.9,1.9-2.4v-1.5c-0.7-0.6-1.6-1-2.6-1.1c-0.6,0-1.2,0-1.3,0
                              c0,0-0.1,0-0.2,0c-0.9,0.2-1.8,0.6-2.5,1.2v1.6C83.6,49.8,84.5,50.8,85.7,50.8z"/>
                        <path id="XMLID_ca772_" class="u-fill-none u-stroke-white" stroke-width="1.5" stroke-miterlimit="10" d="M83.3,47.2c1-0.9,2.4-1.4,3.8-1.4l0,0c3.2,0,5.9,2.6,5.9,5.9v1"/>
                        <path id="XMLID_ca771_" class="u-fill-none u-stroke-white" stroke-width="1.5" stroke-miterlimit="10" d="M81.9,48.9c0.2-0.3,0.4-0.6,0.6-0.9"/>
                        <path id="XMLID_ca532_" class="u-fill-none u-stroke-white" stroke-width="1.5" stroke-miterlimit="10" d="M81.2,52.6v-1c0-0.5,0.1-0.9,0.2-1.3"/>
                        <path id="XMLID_ca528_" class="u-fill-white" d="M89.1,45.2l-0.8,0.3h-2.6l-0.8-0.3c-1.5-0.5-2.5-1.8-2.5-3.2l0-3.6h0.2
                              c1.6,0,3.2-1.2,4.1-2.3l0.5-0.6l0.4,0.5c0.9,1.1,2.4,2.4,4.1,2.4l0,0l0,3.6C91.6,43.4,90.6,44.7,89.1,45.2z"/>
                        </g>
                        <g id="XMLID_ca53_">
                        <path id="XMLID_ca542_" class="u-fill-none u-stroke-white" stroke-width="1.5" stroke-miterlimit="10" d="M97.7,32.5c2,2.4,3.3,5.5,3.3,9c0,7.7-6.2,13.9-13.9,13.9s-13.9-6.2-13.9-13.9
                              S79.3,27.5,87,27.5c1.9,0,3.8,0.4,5.4,1.1"/>
                        <path id="XMLID_ca541_" class="u-fill-none u-stroke-white" stroke-width="1.5" stroke-miterlimit="10" d="M96.5,31.2c0.2,0.2,0.4,0.4,0.7,0.6"/>
                        <path id="XMLID_ca540_" class="u-fill-none u-stroke-white" stroke-width="1.5" stroke-miterlimit="10" d="M93.5,29.1c0.7,0.4,1.3,0.8,1.9,1.2"/>
                        </g>
                        </g>
                        </g>
                        </svg>
                    </figure>
                    <!-- End SVG Icon -->

                    <div class="mb-4">
                        <h1 class="h5">Tell us what you need</h1>
                        <p>Choose the service you want and state your requirements in words.</p>

                    </div>

                </div>
                <!-- End Icon Blocks -->
            </div>

            <div class="col-sm-6 col-lg-4 mb-9 mb-sm-0">
                <!-- Icon Blocks -->
                <div class="text-center">
                    <!-- SVG Icon -->
                    <figure class="w-65 mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             viewBox="0 0 168.6 78.8" style="enable-background:new 0 0 168.6 78.8;" xml:space="preserve">
                        <ellipse class="u-fill-light-blue-125" opacity=".5" cx="84.3" cy="71.9" rx="84.3" ry="6.9"/>
                        <g id="XMLID_ps1_">
                        <g id="XMLID_ps58_">
                        <path id="XMLID_ps52_" class="u-fill-white" d="M94,69H23.7c-0.5,0-1-0.5-1-1V18c0-0.5,0.4-1,1-1H94c0.5,0,1,0.5,1,1v50
                              C95,68.6,94.6,69,94,69z"/>
                        <line id="XMLID_ps51_" class="u-fill-none u-stroke-primary" stroke-width="1.5" stroke-miterlimit="10" x1="79.1" y1="17" x2="84.1" y2="17"/>
                        <path id="XMLID_ps50_" class="u-fill-none u-stroke-primary" stroke-width="1.5" stroke-miterlimit="10" d="M22.7,28.2v-9.4c0-1,0.8-1.8,1.8-1.8h51.4"/>
                        <path id="XMLID_ps49_" class="u-fill-none u-stroke-primary" stroke-width="1.5" stroke-miterlimit="10" d="M86.2,17h7c1,0,1.8,0.8,1.8,1.8v20.8"/>
                        <rect id="XMLID_ps48_" x="26.2" y="21.1" class="u-fill-white" width="64.9" height="42.2"/>
                        <rect id="XMLID_ps47_" x="58.7" y="21.1" class="u-fill-primary" width="32.5" height="42.2"/>
                        <path id="XMLID_ps46_" class="u-fill-white" d="M93.8,71.9H23.2c-1.7,0-3.1-1.2-3.4-2.9L19.2,66H52l1.3,1.8h9l1.4-1.8h34.5l-0.4,2.7
                              C97.3,70.5,95.7,71.9,93.8,71.9z"/>
                        <path id="XMLID_ps45_" class="u-fill-none u-stroke-primary" stroke-width="1.5" stroke-miterlimit="10" d="M93.8,71.9H23.2c-1.7,0-3.1-1.2-3.4-2.9L19.2,66H52l1.3,1.8h9l1.4-1.8h34.5l-0.4,2.7
                              C97.3,70.5,95.7,71.9,93.8,71.9z"/>
                        <line id="XMLID_ps159_" class="u-fill-none u-stroke-white" stroke-width="1.5" stroke-miterlimit="10" x1="61.1" y1="26.8" x2="73.8" y2="26.8"/>
                        <line id="XMLID_ps44_" class="u-fill-none u-stroke-white" stroke-width="1.5" stroke-miterlimit="10" x1="61.1" y1="34.3" x2="89.2" y2="34.3"/>
                        <line id="XMLID_ps43_" class="u-fill-none u-stroke-white" stroke-width="1.5" stroke-miterlimit="10" x1="61.1" y1="38.2" x2="89.2" y2="38.2"/>
                        <line id="XMLID_ps42_" class="u-fill-none u-stroke-white" stroke-width="1.5" stroke-miterlimit="10" x1="61.1" y1="42.1" x2="85.3" y2="42.1"/>
                        <line id="XMLID_ps41_" class="u-fill-none u-stroke-white" stroke-width="1.5" stroke-miterlimit="10" x1="61.1" y1="46" x2="85.3" y2="46"/>
                        <line id="XMLID_ps40_" class="u-fill-none u-stroke-white" stroke-width="1.5" stroke-miterlimit="10" x1="61.1" y1="49.8" x2="85.3" y2="49.8"/>
                        <line id="XMLID_ps167_" class="u-fill-none u-stroke-white" stroke-width="1.5" stroke-miterlimit="10" x1="61.1" y1="53.7" x2="78.1" y2="53.7"/>
                        </g>
                        <g id="XMLID_ps614_">
                        <line id="XMLID_ps671_" class="u-fill-none u-stroke-primary" stroke-width="1.5" stroke-miterlimit="10" x1="23.9" y1="54.4" x2="19.2" y2="58.4"/>
                        <path id="XMLID_ps668_" class="u-fill-warning" d="M18.6,41.4c-0.8,10.3,6.9,19.4,17.2,20.2c10.3,0.8,19.4-6.9,20.2-17.2
                              C56.9,34,49.2,25,38.8,24.2C28.5,23.3,19.5,31,18.6,41.4z M23.1,41.7c0.6-7.9,7.5-13.7,15.4-13.1c7.9,0.6,13.7,7.5,13.1,15.4
                              c-0.6,7.9-7.5,13.7-15.4,13.1C28.3,56.5,22.5,49.6,23.1,41.7z"/>

                        <rect x="12.7" y="56.9" transform="matrix(0.7619 -0.6477 0.6477 0.7619 -35.2587 25.2318)" class="u-fill-primary u-stroke-primary" stroke-width="1.5" stroke-miterlimit="10" width="8.1" height="7.4"/>
                        </g>
                        <g id="XMLID_ps833_">
                        <path id="XMLID_ps828_" class="u-fill-primary-lighter" opacity=".5" d="M33.3,41.3h-0.2c-0.3,0-0.5-0.2-0.5-1.6L32,35.2c-0.1-0.7,0.3-1.4,0.9-1.7
                              c0.2-0.1,0.4-0.3,0.4-0.3c-1.7-1.1-1.3-2.2-1.3-2.4c0,0,0,0,0,0c0.8,1.2,5.3,0.7,7.9,1.1c0.6,0.1,1.1,0.6,1.2,1.2l0.1,0.5l0,0
                              c0.5,0,0.9,0.4,0.9,0.9l-0.7,6.2c0,0.3-0.2,0.5-0.5,0.5H33.3z"/>
                        <path id="XMLID_ps874_" class="u-fill-none u-stroke-primary" stroke-width="1.5" stroke-miterlimit="10" d="M33.3,41.3h-0.2c-0.3,0-0.5-0.2-0.5-1.6L32,35.2c-0.1-0.7,0.3-1.4,0.9-1.7
                              c0.2-0.1,0.4-0.3,0.4-0.3c-1.7-1.1-1.3-2.2-1.3-2.4c0,0,0,0,0,0c0.8,1.2,5.3,0.7,7.9,1.1c0.6,0.1,1.1,0.6,1.2,1.2l0.1,0.5l0,0
                              c0.5,0,0.9,0.4,0.9,0.9l-0.7,6.2c0,0.3-0.2,0.5-0.5,0.5H33.3z"/>
                        <path id="XMLID_ps868_" class="u-fill-white" d="M42.6,39.4c0,0.3-0.3,0.6-0.6,0.6l0,0c-0.3,0-0.6-0.3-0.6-0.6v-0.6c0-0.3,0.3-0.6,0.6-0.6
                              l0,0c0.3,0,0.6,0.3,0.6,0.6V39.4z"/>
                        <path id="XMLID_ps867_" class="u-fill-none u-stroke-primary" stroke-width="1.5" stroke-miterlimit="10" d="M42.6,39.4c0,0.3-0.3,0.6-0.6,0.6l0,0c-0.3,0-0.6-0.3-0.6-0.6v-0.6c0-0.3,0.3-0.6,0.6-0.6
                              l0,0c0.3,0,0.6,0.3,0.6,0.6V39.4z"/>
                        <path id="XMLID_ps866_" class="u-fill-white" d="M32.6,39.4c0,0.3-0.3,0.6-0.6,0.6l0,0c-0.3,0-0.6-0.3-0.6-0.6v-0.6c0-0.3,0.3-0.6,0.6-0.6
                              l0,0c0.3,0,0.6,0.3,0.6,0.6V39.4z"/>
                        <path id="XMLID_ps865_" class="u-fill-none u-stroke-primary" stroke-width="1.5" stroke-miterlimit="10" d="M32.6,39.4c0,0.3-0.3,0.6-0.6,0.6l0,0c-0.3,0-0.6-0.3-0.6-0.6v-0.6c0-0.3,0.3-0.6,0.6-0.6
                              l0,0c0.3,0,0.6,0.3,0.6,0.6V39.4z"/>
                        <path id="XMLID_ps864_" class="u-fill-primary-lighter" opacity=".5" d="M43.4,54.2v-3.9c0-3-2.8-5.4-6.3-5.4l0,0c-3.5,0-6.3,2.4-6.3,5.4v3.9H43.4z"/>
                        <path id="XMLID_ps840_" class="u-fill-none u-stroke-primary" stroke-width="1.5" stroke-miterlimit="10" d="M43.4,54.2v-3.9c0-3-2.8-5.4-6.3-5.4l0,0c-3.5,0-6.3,2.4-6.3,5.4v3.9"/>
                        <line id="XMLID_ps862_" class="u-fill-none u-stroke-primary" stroke-width="1.5" stroke-miterlimit="10" x1="34.4" y1="49.9" x2="34.4" y2="54.2"/>
                        <line id="XMLID_ps861_" class="u-fill-none u-stroke-primary" stroke-width="1.5" stroke-miterlimit="10" x1="39.9" y1="49.9" x2="39.9" y2="54.2"/>
                        <path id="XMLID_ps860_" class="u-fill-white" d="M36.9,47L36.9,47c-0.7,0-1.2-0.5-1.2-1.2v-2.7c0-0.6,0.5-1,1-1H37c0.6,0,1,0.5,1,1v2.7
                              C38.1,46.5,37.5,47,36.9,47z"/>
                        <path id="XMLID_ps835_" class="u-fill-none u-stroke-primary" stroke-width="1.5" stroke-miterlimit="10" d="M36.9,47L36.9,47c-0.7,0-1.2-0.5-1.2-1.2v-2.7c0-0.6,0.5-1,1-1H37c0.6,0,1,0.5,1,1v2.7
                              C38.1,46.5,37.5,47,36.9,47z"/>
                        <path id="XMLID_ps827_" class="u-fill-white" d="M37,44.7L37,44.7c-2.5,0-4.5-2-4.5-4.5v-3.1c0-2.5,2-2.4,4.5-2.4l0,0c2.5,0,4.5-0.1,4.5,2.4
                              v3.1C41.5,42.7,39.5,44.7,37,44.7z"/>
                        <path id="XMLID_ps855_" class="u-fill-none u-stroke-primary" stroke-width="1.5" stroke-miterlimit="10" d="M37,44.7L37,44.7c-2.5,0-4.5-2-4.5-4.5v-3.1c0-2.5,2-2.4,4.5-2.4l0,0c2.5,0,4.5-0.1,4.5,2.4
                              v3.1C41.5,42.7,39.5,44.7,37,44.7z"/>
                        </g>
                        <path id="XMLID_ps38_" class="u-fill-primary" opacity=".3" d="M98.3,68.7l0.6-3.4H95V40.8H84.2v31.8h9.6C96,72.6,97.9,71,98.3,68.7z"/>
                        <g id="XMLID_ps30_">
                        <rect id="XMLID_ps169_" x="86.7" y="41.4" class="u-fill-primary-lighter" opacity=".9" width="49.5" height="30.5"/>
                        <rect id="XMLID_ps37_" x="89.7" y="44.1" class="u-fill-white" width="43.5" height="25.2"/>
                        <rect id="XMLID_ps170_" x="86.7" y="41.4" class="u-fill-none u-stroke-primary" stroke-width="1.5" stroke-miterlimit="10" width="49.5" height="30.5"/>
                        <g id="XMLID_ps171_">
                        <polygon id="XMLID_ps539_" class="u-fill-warning" points="126.9,62.6 125.1,62.6 125.1,68.2 126.9,67.5 128.7,68.2 128.7,62.6      "/>
                        <polygon id="XMLID_ps172_" class="u-fill-none u-stroke-danger" stroke-width="1.5" stroke-miterlimit="10" points="126.9,62.6 125.1,62.6 125.1,68.2 126.9,67.5 128.7,68.2 128.7,62.6       "/>
                        <path id="XMLID_ps36_" class="u-fill-white u-stroke-danger" stroke-width="1.5" stroke-miterlimit="10" d="M131.5,60.9c0,0.6-0.5,1.1-0.8,1.6c-0.2,0.5-0.2,1.2-0.6,1.6c-0.4,0.4-1.1,0.4-1.6,0.6
                              c-0.5,0.2-1,0.8-1.6,0.8s-1.1-0.5-1.6-0.8c-0.5-0.2-1.2-0.2-1.6-0.6c-0.4-0.4-0.4-1.1-0.6-1.6c-0.2-0.5-0.8-1-0.8-1.6
                              s0.5-1.1,0.8-1.6c0.2-0.5,0.2-1.2,0.6-1.6c0.4-0.4,1.1-0.4,1.6-0.6c0.5-0.2,1-0.8,1.6-0.8c0.6,0,1.1,0.5,1.6,0.8
                              c0.5,0.2,1.2,0.2,1.6,0.6c0.4,0.4,0.4,1.1,0.6,1.6C130.9,59.8,131.5,60.3,131.5,60.9z"/>
                        <path id="XMLID_ps35_" class="u-fill-none u-stroke-danger" stroke-width="1.5" stroke-miterlimit="10" d="M131.5,60.9c0,0.6-0.5,1.1-0.8,1.6c-0.2,0.5-0.2,1.2-0.6,1.6c-0.4,0.4-1.1,0.4-1.6,0.6
                              c-0.5,0.2-1,0.8-1.6,0.8s-1.1-0.5-1.6-0.8c-0.5-0.2-1.2-0.2-1.6-0.6c-0.4-0.4-0.4-1.1-0.6-1.6c-0.2-0.5-0.8-1-0.8-1.6
                              s0.5-1.1,0.8-1.6c0.2-0.5,0.2-1.2,0.6-1.6c0.4-0.4,1.1-0.4,1.6-0.6c0.5-0.2,1-0.8,1.6-0.8c0.6,0,1.1,0.5,1.6,0.8
                              c0.5,0.2,1.2,0.2,1.6,0.6c0.4,0.4,0.4,1.1,0.6,1.6C130.9,59.8,131.5,60.3,131.5,60.9z"/>
                        </g>
                        <line id="XMLID_ps34_" class="u-fill-none u-stroke-primary" stroke-width="1.5" stroke-miterlimit="10" x1="96" y1="51.5" x2="119.8" y2="51.5"/>
                        <line id="XMLID_ps33_" class="u-fill-none u-stroke-primary" stroke-width="1.5" stroke-miterlimit="10" x1="96" y1="53.9" x2="119.8" y2="53.9"/>
                        <line id="XMLID_ps32_" class="u-fill-none u-stroke-primary" stroke-width="1.5" stroke-miterlimit="10" x1="96" y1="56.3" x2="119.8" y2="56.3"/>
                        <line id="XMLID_ps31_" class="u-fill-none u-stroke-primary" stroke-width="1.5" stroke-miterlimit="10" x1="96" y1="58.7" x2="119.8" y2="58.7"/>
                        <line id="XMLID_ps173_" class="u-fill-none u-stroke-primary" stroke-width="1.5" stroke-miterlimit="10" x1="96" y1="61.2" x2="119.8" y2="61.2"/>
                        </g>
                        <g>
                        <line id="XMLID_ps29_" class="u-fill-none u-stroke-success" stroke-width="1.5" stroke-miterlimit="10" x1="147.5" y1="56.8" x2="147.5" y2="71.9"/>

                        <ellipse id="XMLID_ps28_" transform="matrix(0.9755 -0.2199 0.2199 0.9755 -7.4901 33.6834)" class="u-fill-white" cx="147.6" cy="50.5" rx="8.1" ry="8.1"/>
                        <path id="XMLID_ps27_" class="u-fill-none u-stroke-warning" stroke-width="1.5" stroke-miterlimit="10" d="M154.4,46.2c0.8,1.2,1.2,2.7,1.2,4.3c0,4.5-3.6,8.1-8.1,8.1c-4.5,0-8.1-3.6-8.1-8.1
                              c0-4.5,3.6-8.1,8.1-8.1c0.9,0,1.7,0.1,2.5,0.4"/>
                        <path id="XMLID_ps26_" class="u-fill-none u-stroke-warning" stroke-width="1.5" stroke-miterlimit="10" d="M151.5,43.4c0.6,0.3,1.1,0.7,1.5,1.1"/>
                        <g id="XMLID_ps24_">
                        <path id="XMLID_ps194_" class="u-fill-none u-stroke-warning" stroke-width="1.5" stroke-miterlimit="10" d="M150.8,47.4h-4c-0.8,0-1.5,0.7-1.5,1.5l0,0c0,0.8,0.7,1.5,1.5,1.5h1.6
                              c0.8,0,1.5,0.7,1.5,1.5l0,0c0,0.8-0.7,1.5-1.5,1.5h-4.1"/>
                        <line id="XMLID_ps25_" class="u-fill-none u-stroke-warning" stroke-width="1.5" stroke-miterlimit="10" x1="147.6" y1="44.9" x2="147.6" y2="56.1"/>
                        </g>
                        <path id="XMLID_ps23_" class="u-fill-success-lighter" opacity=".6" d="M157.1,59.7c0,0,0.3,4.1-2,6.4c-2.3,2.3-6.4,2-6.4,2s-0.3-4.1,2-6.4
                              C153,59.4,157.1,59.7,157.1,59.7z"/>
                        <path id="XMLID_ps22_" class="u-fill-none u-stroke-success" stroke-width="1.5" stroke-miterlimit="10" d="M157.1,59.7c0,0,0.3,4.1-2,6.4c-2.3,2.3-6.4,2-6.4,2s-0.3-4.1,2-6.4
                              C153,59.4,157.1,59.7,157.1,59.7z"/>
                        <path id="XMLID_ps21_" class="u-fill-success-lighter" opacity=".6" d="M146.7,68.1c0,0,0.3-4.1-2-6.4c-2.3-2.3-6.4-2-6.4-2s-0.3,4.1,2,6.4
                              C142.7,68.4,146.7,68.1,146.7,68.1z"/>
                        <path id="XMLID_ps20_" class="u-fill-none u-stroke-success" stroke-width="1.5" stroke-miterlimit="10" d="M146.7,68.1c0,0,0.3-4.1-2-6.4c-2.3-2.3-6.4-2-6.4-2s-0.3,4.1,2,6.4
                              C142.7,68.4,146.7,68.1,146.7,68.1z"/>
                        </g>
                        <g id="XMLID_ps3_">
                        <rect id="XMLID_ps19_" x="111.6" y="8.4" class="u-fill-white" width="10.6" height="9.7"/>
                        <rect id="XMLID_ps18_" x="111.6" y="8.4" class="u-fill-none u-stroke-primary" stroke-width="1.5" stroke-miterlimit="10" width="10.6" height="9.7"/>
                        <polygon id="XMLID_ps17_" class="u-fill-white" points="123.8,39.6 122.5,18.7 111.3,18.7 110,39.6     "/>
                        <polygon id="XMLID_ps16_" class="u-fill-success" points="122.5,18.7 111.9,18.7 111.3,19 110.9,25.9 122.5,19.2     "/>
                        <polygon id="XMLID_ps15_" class="u-fill-success" points="110,39.6 123.3,31.9 122.9,25.5 110.4,32.7    "/>
                        <polygon id="XMLID_ps14_" class="u-fill-none u-stroke-primary" stroke-width="1.5" stroke-miterlimit="10" points="122.5,18.7 111.9,18.7 111.3,19 110.9,25.9 122.5,19.2    "/>
                        <polyline id="XMLID_ps13_" class="u-fill-none u-stroke-primary" stroke-width="1.5" stroke-miterlimit="10" points="110,39.6 123.3,31.9 122.9,25.5 110.4,32.7    "/>
                        <line id="XMLID_ps12_" class="u-fill-none u-stroke-primary" stroke-width="1.5" stroke-miterlimit="10" x1="123.6" y1="36.5" x2="123.8" y2="39.6"/>
                        <polyline id="XMLID_ps11_" class="u-fill-none u-stroke-primary" stroke-width="1.5" stroke-miterlimit="10" points="110,40 111.3,18.7 122.5,18.7 123.5,34.1    "/>
                        <path id="XMLID_ps10_" class="u-fill-white" opacity=".9" d="M123.3,19.9h-12.9c-0.3,0-0.5-0.2-0.5-0.5v-2.5c0-0.3,0.2-0.5,0.5-0.5h12.9
                              c0.3,0,0.5,0.2,0.5,0.5v2.5C123.8,19.6,123.6,19.9,123.3,19.9z"/>
                        <path id="XMLID_ps196_" class="u-fill-none u-stroke-primary" stroke-width="1.5" stroke-miterlimit="10" d="M123.3,19.9h-12.9c-0.3,0-0.5-0.2-0.5-0.5v-2.5c0-0.3,0.2-0.5,0.5-0.5h12.9
                              c0.3,0,0.5,0.2,0.5,0.5v2.5C123.8,19.6,123.6,19.9,123.3,19.9z"/>
                        <path id="XMLID_ps195_" class="u-fill-white" opacity=".9" d="M116.8,1.7l-7.9,6.5c-0.1,0.1,0,0.2,0.1,0.2h15.8c0.1,0,0.2-0.1,0.1-0.2L117,1.7
                              C116.9,1.7,116.9,1.7,116.8,1.7z"/>
                        <path id="XMLID_ps9_" class="u-fill-none u-stroke-primary" stroke-width="1.5" stroke-miterlimit="10" d="M116.8,1.7l-7.9,6.5c-0.1,0.1,0,0.2,0.1,0.2h15.8c0.1,0,0.2-0.1,0.1-0.2L117,1.7
                              C116.9,1.7,116.9,1.7,116.8,1.7z"/>
                        <path id="XMLID_ps8_" class="u-fill-none u-stroke-success" stroke-width="1.5" stroke-miterlimit="10" d="M118.3,12.5c0,0.8-0.6,1.4-1.4,1.4c-0.8,0-1.4-0.6-1.4-1.4c0-0.8,0.6-1.4,1.4-1.4
                              C117.7,11.1,118.3,11.7,118.3,12.5z"/>
                        <line id="XMLID_ps7_" class="u-fill-none u-stroke-primary" stroke-width="1.5" stroke-miterlimit="10" x1="100.9" y1="18.7" x2="108.4" y2="14.3"/>
                        <line id="XMLID_ps6_" class="u-fill-none u-stroke-primary" stroke-width="1.5" stroke-miterlimit="10" x1="108.4" y1="10.7" x2="100.9" y2="6.3"/>
                        <line id="XMLID_ps5_" class="u-fill-none u-stroke-primary" stroke-width="1.5" stroke-miterlimit="10" x1="133.3" y1="18.7" x2="125.8" y2="14.3"/>
                        <line id="XMLID_ps4_" class="u-fill-none u-stroke-primary" stroke-width="1.5" stroke-miterlimit="10" x1="125.8" y1="10.7" x2="133.3" y2="6.3"/>
                        </g>
                        </g>
                        </svg>
                    </figure>
                    <!-- End SVG Icon -->

                    <div class="mb-4">
                        <h2 class="h5">Receive Quotes</h2>
                        <p>Get quotes from 5 service providers in the locality for the service chosen  free from UrbanSense or get in touch directly with the service provider.</p>
                    </div>

                </div>
                <!-- End Icon Blocks -->
            </div>

            <div class="col-sm-6 col-lg-4">
                <!-- Icon Blocks -->
                <div class="text-center">
                    <!-- SVG Icon -->
                    <figure class="w-65 mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             viewBox="0 0 168.6 78.8" style="enable-background:new 0 0 168.6 78.8;" xml:space="preserve">
                        <ellipse class="u-fill-light-blue-125" opacity=".5" cx="84.3" cy="71.9" rx="84.3" ry="6.9"/>
                        <g>
                        <g id="XMLID_pj459_">
                        <g id="XMLID_pj501_">
                        <path id="XMLID_pj509_" class="u-fill-warning" d="M131,28.9l8,8v27.9c0,1.3-1,2.3-2.3,2.3h-23.8c-1.3,0-2.3-1-2.3-2.3V31.2
                              c0-1.3,1-2.3,2.3-2.3H131z"/>
                        <polygon id="XMLID_pj508_" class="u-fill-warning" points="131,36.9 131,28.9 139,36.9       "/>
                        <path id="XMLID_pj507_" class="u-fill-none u-stroke-white" stroke-width="1.5" stroke-miterlimit="10" d="M139,36.9h-7.2c-0.4,0-0.8-0.4-0.8-0.8v-7.2"/>
                        <line id="XMLID_pj506_" class="u-fill-none u-stroke-white" stroke-width="1.5" stroke-miterlimit="10" x1="135.1" y1="40.8" x2="114.8" y2="40.8"/>
                        <line id="XMLID_pj505_" class="u-fill-none u-stroke-white" stroke-width="1.5" stroke-miterlimit="10" x1="135.1" y1="45.3" x2="114.8" y2="45.3"/>
                        <line id="XMLID_pj504_" class="u-fill-none u-stroke-white" stroke-width="1.5" stroke-miterlimit="10" x1="135.1" y1="49.8" x2="114.8" y2="49.8"/>
                        <line id="XMLID_pj503_" class="u-fill-none u-stroke-white" stroke-width="1.5" stroke-miterlimit="10" x1="135.1" y1="54.4" x2="114.8" y2="54.4"/>
                        <path id="XMLID_pj251_" class="u-fill-none u-stroke-white" stroke-width="1.5" stroke-miterlimit="10" d="M115.4,28.9H131l8,8v27.9c0,1.3-1,2.3-2.3,2.3h-1.1"/>
                        </g>
                        <g id="XMLID_pj470_">
                        <path id="XMLID_pj500_" class="u-fill-success" d="M137.6,33.4l8,8v27.9c0,1.3-1,2.3-2.3,2.3h-23.8c-1.3,0-2.3-1-2.3-2.3V35.7
                              c0-1.3,1-2.3,2.3-2.3H137.6z"/>
                        <polygon id="XMLID_pj499_" class="u-fill-success" points="137.6,41.4 137.6,33.4 145.6,41.4       "/>
                        <path id="XMLID_pj498_" class="u-fill-none u-stroke-white" stroke-width="1.5" stroke-miterlimit="10" d="M145.6,41.4h-7.2c-0.4,0-0.8-0.4-0.8-0.8v-7.2"/>
                        <line id="XMLID_pj497_" class="u-fill-none u-stroke-white" stroke-width="1.5" stroke-miterlimit="10" x1="141.8" y1="45.3" x2="121.5" y2="45.3"/>
                        <line id="XMLID_pj496_" class="u-fill-none u-stroke-white" stroke-width="1.5" stroke-miterlimit="10" x1="141.8" y1="49.8" x2="121.5" y2="49.8"/>
                        <line id="XMLID_pj493_" class="u-fill-none u-stroke-white" stroke-width="1.5" stroke-miterlimit="10" x1="135.1" y1="54.3" x2="121.5" y2="54.3"/>
                        <line id="XMLID_pj492_" class="u-fill-none u-stroke-white" stroke-width="1.5" stroke-miterlimit="10" x1="135.1" y1="58.8" x2="121.5" y2="58.8"/>
                        <path id="XMLID_pj250_" class="u-fill-none u-stroke-white" stroke-width="1.5" stroke-miterlimit="10" d="M117.2,65.8V35.7c0-1.3,1-2.3,2.3-2.3h18.1l8,8v5.9"/>
                        </g>
                        </g>
                        <path id="XMLID_pj2_" class="u-fill-primary" opacity=".1" d="M15.1,68.5V0h-4.3C9.9,0,9.2,0.8,9.2,1.7v69.8h0.2h0.2h5.1C14.9,71.5,15.1,70.2,15.1,68.5z"/>
                        <g id="XMLID_pj139_">
                        <g>
                        <path id="XMLID_pj226_" class="u-fill-white" d="M61.9,71.5H11.8V1.9c0-1,0.8-1.9,1.9-1.9h48.2c1,0,1.9,0.8,1.9,1.9v67.8
                              C63.8,70.7,62.9,71.5,61.9,71.5z"/>
                        <path id="XMLID_pj225_" class="u-fill-primary" d="M63.8,17.8h-52V1.9c0-1,0.9-1.9,1.9-1.9h49.1c0.6,0,1,0.5,1,1V17.8z"/>
                        <path id="XMLID_pj224_" class="u-fill-warning" d="M24.2,8.8c0,1.7-1.3,3-3,3c-1.7,0-3-1.3-3-3c0-1.7,1.3-3,3-3C22.8,5.7,24.2,7.1,24.2,8.8z"
                              />
                        <g id="XMLID_pj214_">
                        <path id="XMLID_pj215_" class="u-fill-warning" d="M20.9,67.1h-0.5v-2.8h0.5V67.1z M20.9,61.5h-0.5v-2.8h0.5V61.5z M20.9,55.9h-0.5v-2.8h0.5
                              V55.9z M20.9,50.3h-0.5v-2.8h0.5V50.3z M20.9,44.7h-0.5v-2.8h0.5V44.7z M20.9,39.1h-0.5v-2.8h0.5V39.1z M20.9,33.5h-0.5v-2.8
                              h0.5V33.5z M20.9,27.9h-0.5v-2.8h0.5V27.9z"/>
                        </g>
                        <path id="XMLID_pj213_" class="u-fill-warning" d="M22.4,59.9c0,1-0.8,1.7-1.7,1.7c-1,0-1.7-0.8-1.7-1.7c0-1,0.8-1.7,1.7-1.7
                              C21.6,58.2,22.4,58.9,22.4,59.9z"/>
                        <path id="XMLID_pj210_" class="u-fill-warning" d="M22.4,43.2c0,1-0.8,1.7-1.7,1.7c-1,0-1.7-0.8-1.7-1.7c0-1,0.8-1.7,1.7-1.7
                              C21.6,41.5,22.4,42.3,22.4,43.2z"/>
                        <path id="XMLID_pj209_" class="u-fill-warning" d="M22.4,26.5c0,1-0.8,1.7-1.7,1.7c-1,0-1.7-0.8-1.7-1.7c0-1,0.8-1.7,1.7-1.7
                              C21.6,24.8,22.4,25.6,22.4,26.5z"/>
                        <line id="XMLID_pj208_" class="u-fill-none u-stroke-danger" stroke-width="1.5" stroke-miterlimit="10" x1="25.7" y1="26.5" x2="58.2" y2="26.5"/>
                        <line id="XMLID_pj207_" class="u-fill-none u-stroke-danger" stroke-width="1.5" stroke-miterlimit="10" x1="25.7" y1="41.9" x2="58.2" y2="41.9"/>
                        <line id="XMLID_pj206_" class="u-fill-none u-stroke-danger" stroke-width="1.5" stroke-miterlimit="10" x1="25.7" y1="44.9" x2="58.2" y2="44.9"/>
                        <line id="XMLID_pj205_" class="u-fill-none u-stroke-danger" stroke-width="1.5" stroke-miterlimit="10" x1="25.7" y1="47.9" x2="58.2" y2="47.9"/>
                        <line id="XMLID_pj204_" class="u-fill-none u-stroke-danger" stroke-width="1.5" stroke-miterlimit="10" x1="25.8" y1="58.2" x2="58.2" y2="58.2"/>
                        <line id="XMLID_pj203_" class="u-fill-none u-stroke-danger" stroke-width="1.5" stroke-miterlimit="10" x1="25.7" y1="61" x2="58.2" y2="61"/>
                        <line id="XMLID_pj202_" class="u-fill-none u-stroke-danger" stroke-width="1.5" stroke-miterlimit="10" x1="25.7" y1="63.8" x2="48.1" y2="63.8"/>
                        <line id="XMLID_pj201_" class="u-fill-none u-stroke-danger" stroke-width="1.5" stroke-miterlimit="10" x1="25.7" y1="50.9" x2="37.8" y2="50.9"/>
                        <line id="XMLID_pj200_" class="u-fill-none u-stroke-danger" stroke-width="1.5" stroke-miterlimit="10" x1="25.7" y1="29.6" x2="58.2" y2="29.6"/>
                        <line id="XMLID_pj199_" class="u-fill-none u-stroke-danger" stroke-width="1.5" stroke-miterlimit="10" x1="25.7" y1="32.6" x2="58.2" y2="32.6"/>
                        <line id="XMLID_pj198_" class="u-fill-none u-stroke-danger" stroke-width="1.5" stroke-miterlimit="10" x1="25.7" y1="35.6" x2="37.8" y2="35.6"/>
                        </g>
                        </g>
                        <g id="XMLID_pj101_">
                        <path id="XMLID_pj254_" class="u-fill-primary" opacity=".3" d="M63.8,69.7V27.9H40.2v43.7h0.8h0.7h20.2C62.9,71.5,63.8,70.7,63.8,69.7z"/>
                        <rect id="XMLID_pj98_" x="42.9" y="27.9" class="u-fill-white" width="68.7" height="43.7"/>
                        <rect id="XMLID_pj97_" x="42.9" y="28.8" class="u-fill-primary" opacity=".3" width="68.7" height="17"/>
                        <rect id="XMLID_pj96_" x="42.9" y="27.9" class="u-fill-primary" width="68.7" height="17"/>
                        <rect id="XMLID_pj95_" x="74.5" y="40.9" class="u-fill-primary" width="5.4" height="8.8"/>
                        <path id="XMLID_pj64_" class="u-fill-none u-stroke-primary" stroke-width="1.5" stroke-miterlimit="10" d="M67.1,28.1V24c0-1.9,1.5-3.4,3.4-3.4H84c1.9,0,3.4,1.5,3.4,3.4v4.1"/>
                        </g>
                        <g id="XMLID_pj140_">
                        <rect id="XMLID_pj138_" x="75.4" y="68.2" class="u-fill-primary" width="3.9" height="2.4"/>
                        <rect id="XMLID_pj137_" x="75.4" y="68.2" class="u-fill-none u-stroke-primary" stroke-width="1.5" stroke-miterlimit="10" width="3.9" height="2.4"/>
                        <line id="XMLID_pj136_" class="u-fill-none u-stroke-primary" stroke-width="1.5" stroke-miterlimit="10" x1="122.1" y1="69.4" x2="125.2" y2="69.4"/>
                        <polyline id="XMLID_pj133_" class="u-fill-none u-stroke-primary" stroke-width="1.5" stroke-miterlimit="10" points="97.4,65.3 79.5,65.3 79.5,67.6    "/>
                        <path id="XMLID_pj116_" class="u-fill-primary" d="M118.7,71.5H79.3v-4.2h39.4l5.2,2c0.1,0,0.1,0.2,0,0.2L118.7,71.5z"/>
                        <rect id="XMLID_pj115_" x="79.3" y="67.3" class="u-fill-white" width="39.4" height="4.2"/>
                        <rect id="XMLID_pj112_" x="100.5" y="67.3" class="u-fill-primary" width="13.3" height="4.2"/>
                        <rect id="XMLID_pj109_" x="100.5" y="67.3" class="u-fill-primary" width="13.3" height="2.1"/>
                        <path id="XMLID_pj106_" class="u-fill-none u-stroke-primary" stroke-width="1.5" stroke-miterlimit="10" d="M118.7,71.5H79.3v-4.2h39.4l5.2,2c0.1,0,0.1,0.2,0,0.2L118.7,71.5z"/>
                        <line id="XMLID_pj104_" class="u-fill-none u-stroke-primary" stroke-width="1.5" stroke-miterlimit="10" x1="100.5" y1="67.6" x2="100.5" y2="71.3"/>
                        <line id="XMLID_pj103_" class="u-fill-none u-stroke-primary" stroke-width="1.5" stroke-miterlimit="10" x1="113.1" y1="67.6" x2="113.1" y2="71.3"/>
                        <line id="XMLID_pj102_" class="u-fill-none u-stroke-primary" stroke-width="1.5" stroke-miterlimit="10" x1="118.7" y1="67.6" x2="118.7" y2="71.3"/>
                        </g>
                        <g id="XMLID_pj474_">
                        <path id="XMLID_pj491_" class="u-fill-white" d="M161.2,49.2h-21.5v6.5c0,4.6,1.7,9.1,4.9,12.5l0,0v3.3h11.7v-3.3l0,0
                              c3.1-3.4,4.9-7.9,4.9-12.5V49.2z"/>
                        <path id="XMLID_pj490_" class="u-fill-primary" d="M156.6,49.2v6.5c0,4.6-1.7,9.1-4.9,12.5v0v3.3h2.5v-3.3v0c3.1-3.4,4.9-7.9,4.9-12.5v-6.5
                              H156.6z"/>
                        <path id="XMLID_pj489_" class="u-fill-none u-stroke-primary-darker" opacity=".2" stroke-width="1.5" stroke-miterlimit="10" d="M160.6,59.7c0.3-1.3,0.4-2.6,0.4-4v-1.8v-4.7h-21.5v6.5c0,4.6,1.7,9.1,4.9,12.5l0,0v3.3
                              h11.7v-3.3l0,0c0.6-0.7,1.2-1.4,1.7-2.1"/>
                        <path id="XMLID_pj488_" class="u-fill-none u-stroke-white" opacity=".2" stroke-width="1.5" stroke-miterlimit="10" d="M158.6,64.9c0.6-1.1,1.1-2.2,1.5-3.4"/>
                        <path id="XMLID_pj487_" class="u-fill-none u-stroke-white" stroke-width="1.5" stroke-miterlimit="10" d="M140.6,61.5h-3.5c-2.5,0-4.6-2.1-4.6-4.6l0,0c0-2.5,2.1-4.6,4.6-4.6h2.3"/>
                        <path id="XMLID_pj486_" class="u-fill-none u-stroke-light-blue-150" stroke-width="1.5" stroke-miterlimit="10" d="M147.5,46.8v-1.3c0-1.9,1.5-3.4,3.4-3.4h3.2c0.7,0,1.2-0.6,1.2-1.2l0,0
                              c0-0.7-0.6-1.2-1.2-1.2h-10c-0.6,0-1.1-0.5-1.1-1.1l0,0c0-0.6,0.5-1.1,1.1-1.1h4.2"/>
                        <path id="XMLID_pj475_" class="u-fill-none u-stroke-light-blue-150" stroke-width="1.5" stroke-miterlimit="10" d="M150.1,37.6h3.6c0.7,0,1.3-0.6,1.3-1.3l0,0c0-0.7-0.6-1.3-1.3-1.3h-9.3
                              c-0.8,0-1.4-0.6-1.4-1.4l0,0c0-0.8,0.6-1.4,1.4-1.4h13.5"/>
                        </g>
                        </g>
                        </svg>
                    </figure>
                    <!-- End SVG Icon -->

                    <div class="mb-4">
                        <h3 class="h5">Hire the right  service provider</h3>
                        <p>Choose a service provider that you want to work with, get in touch with them and finalize the deal at a competitive price.</p>
                    </div>

                </div>
                <!-- End Icon Blocks -->
            </div>
        </div>
    </div>
    <!-- End Get Started Section -->

    <!-- Divider -->
    <div class="container">
        <hr class="my-0">
    </div>
    <!-- End Divider -->



    <!-- Testimonials -->
    <div class="u-gradient-half-primary-v1">
        <div class="u-bg-img-hero" style="background-image: url(https://htmlstream.com/preview/front-v1.3/assets/svg/bg/bg2.svg);">
            <div class="container u-space-2">
                <!-- Title -->
                <div class="text-center mb-4">
                    <!-- SVG Quote -->
                    <figure class="mx-auto mb-2" style="width: 50px;">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             viewBox="0 0 8 8" style="enable-background:new 0 0 8 8;" xml:space="preserve">
                        <path class="u-fill-warning" d="M3,1.3C2,1.7,1.2,2.7,1.2,3.6c0,0.2,0,0.4,0.1,0.5c0.2-0.2,0.5-0.3,0.9-0.3c0.8,0,1.5,0.6,1.5,1.5c0,0.9-0.7,1.5-1.5,1.5
                              C1.4,6.9,1,6.6,0.7,6.1C0.4,5.6,0.3,4.9,0.3,4.5c0-1.6,0.8-2.9,2.5-3.7L3,1.3z M7.1,1.3c-1,0.4-1.8,1.4-1.8,2.3
                              c0,0.2,0,0.4,0.1,0.5c0.2-0.2,0.5-0.3,0.9-0.3c0.8,0,1.5,0.6,1.5,1.5c0,0.9-0.7,1.5-1.5,1.5c-0.7,0-1.1-0.3-1.4-0.8
                              C4.4,5.6,4.4,4.9,4.4,4.5c0-1.6,0.8-2.9,2.5-3.7L7.1,1.3z"/>
                        </svg>
                    </figure>
                    <!-- End SVG Quote -->

                    <h2 class="text-white font-weight-medium">Satisfied Customers</h2>
                </div>
                <!-- End Title -->

                <!-- Slick Carousel - Testimonials Main Nav -->
                <div id="testimonialsNavMain" class="js-slick-carousel u-slick text-center w-lg-75 mx-lg-auto mb-7"
                     data-adaptive-height="true"
                     data-infinite="true"
                     data-fade="true"
                     data-nav-for="#testimonialsNavPagination">


<?php foreach ($reviews as $row) { ?>
                        <div class="js-slide">
                            <!-- Testimonials -->
                            <blockquote class="lead u-text-light text-lh-md"><?= $row->review; ?></blockquote>
                            <!-- End Testimonials -->
                        </div>
<?php } ?>


                </div>
                <!-- End Slick Carousel - Testimonials Main Nav -->

                <!-- Slick Carousel - Testimonials Pagination Nav -->
                <div id="testimonialsNavPagination" class="js-slick-carousel u-slick u-slick--gutters-3 u-slick--pagination-testimonials-v1"
                     data-infinite="true"
                     data-slides-show="3"
                     data-center-mode="true"
                     data-focus-on-select="true"
                     data-nav-for="#testimonialsNavMain"
                     data-responsive='[{
                     "breakpoint": 1200,
                     "settings": {
                     "slidesToShow": 2
                     }
                     }, {
                     "breakpoint": 768,
                     "settings": {
                     "slidesToShow": 2
                     }
                     }, {
                     "breakpoint": 554,
                     "settings": {
                     "slidesToShow": 1
                     }
                     }]'>

<?php foreach ($reviews as $row) { ?>
                        <div class="js-slide rounded-pill p-2">
                            <!-- Authors -->
                            <div class="media align-items-center">
                                <div class="d-flex mr-3">
                                    <img class="u-md-avatar rounded-circle" src="<?= base_url('uploads/image/') . $row->image ?>" alt="Image Description">
                                </div>
                                <div class="media-body">
                                    <h4 class="h6 u-slick--pagination-testimonials-v1__title mb-0"><?= $row->name; ?></h4>
                                    <p class="small u-slick--pagination-testimonials-v1__text mb-0">Consultant</p>
                                </div>
                            </div>
                            <!-- End Authors -->
                        </div>
<?php } ?>
                </div>
                <!-- End Slick Carousel - Testimonials Pagination Nav -->
            </div>
        </div>
    </div>
    <!-- End Testimonials -->



    <hr class="my-0">



    <!-- Divider -->
    <div class="container">
        <hr class="my-0">
    </div>
    <!-- End Divider -->

    <!-- Featured Jobs Section -->
    <div class="u-bg-img-hero" style="background-image: url(https://htmlstream.com/preview/front-v1.3/assets/svg/bg/bg1.svg);">
        <div class="container u-space-1">
            <!-- Title -->
            <div class="d-sm-flex justify-content-sm-between align-items-sm-center mb-5">
                <h2 class="h3 font-weight-medium">Featured Service Providers</h2>
                <a class="u-link-muted" href="<?= base_url('services') ?>">
                    See all Services
                    <span class="fa fa-angle-right font-size-13 ml-2"></span>
                </a>
            </div>
            <!-- End Title -->

            <div class="row">
<?php foreach ($featured_professionals as $row) { ?>
                    <div class="col-md-4 card bg-transparent border-0 mb-5">
                        <div class="card-body u-info-v2 bg-white-home text-center rounded transition-3d-hover p-4">

    <?php $logo = @get_default_pro_image($row->user_id) ? base_url('uploads/image/') . get_default_pro_image($row->user_id) : base_url('assets/upload.png'); ?>
                            <picture>
                                <source media="(max-width: 799px)" srcset="<?= base_url("image/display?image=" . $logo . "&w=50&h=50") ?>">
                                <source media="(min-width: 800px)" srcset="<?= base_url("image/display?image=" . $logo . "&w=50&h=50") ?>">
                                <img class="u-md-avatar rounded mb-4" src="<?= base_url("image/display?image=" . $logo . "&w=50&h=50") ?>">
                            </picture>
                            <div class="mb-4 ml-2">
                                <h4 class="h6 mb-1"><?= $row->user->first_name . ' ' . $row->user->last_name ?></h4>
                                <p><?= $row->complete_address($row->user_id) ?></p>
                                <p class="font-size-14">
                                    Ratings: <i class="fa fa-thumbs-o-up"></i>   
                                    <?php
                                    $rating = get_rating($row->user_id);
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($i <= $rating) {
                                            echo '<span class="fa fa-star checked" style="color:#f4701a;padding:1px;"></span>';
                                        } else {
                                            echo '<span class="fa fa-star" style="padding:1px;"></span>';
                                        }
                                    }
                                    ?> (<?= get_review_count($row->user_id) ?> Reviews)


                                </p>
                                <p class="break-word"><?php echo $row->services($row->user_id) ?></p>
                                <a class="btn btn-primary u-btn-primary transition-3d-hover " href="<?= base_url('service-details/') . $row->user_id ?>">View Details</a>
                                
                            </div>
                        </div>
                    </div>
<?php } ?>
            </div>

        </div>
    </div>
    <!-- End Featured Jobs Section -->
</main>

<!-- ========== END MAIN CONTENT ========== -->

