
        <div class="content-inner">
          <!-- Page Header-->
          <header class="page-header">
            <div class="container-fluid">
              <h2 class="no-margin-bottom">Dashboard</h2>
            </div>
          </header>
          <!-- Dashboard Counts Section-->
          <section class="dashboard-counts no-padding-bottom">
            <div class="container-fluid">
              <div class="row bg-white has-shadow">
                 <!-- Item -->
                <div class="col-xl-3 col-sm-6">
                  <div class="item d-flex align-items-center">
                    <div class="icon bg-green"><i class="icon-bill"></i></div>
                    <div class="title"><span>Services</span>
                      
                    </div>
                    <div class="number"><strong><?= @$total_service; ?></strong></div>
                  </div>
                </div>
                <!-- Item -->
                <div class="col-xl-3 col-sm-6">
                  <div class="item d-flex align-items-center">
                    <div class="icon bg-orange"><i class="icon-check"></i></div>
                    <div class="title"><span>Booking</span>
                     
                    </div>
                    <div class="number"><strong><?= $total_booking ?></strong></div>
                  </div>
                </div>
                <!-- Item -->
                <div class="col-xl-3 col-sm-6">
                  <div class="item d-flex align-items-center">
                    <div class="icon bg-red"><i class="icon-user"></i></div>
                    <div class="title"><span>Customer</span>
                     
                    </div>
                    <div class="number"><strong><?= @$total_customer - 1; ?></strong></div>
                  </div>
                </div>
                <!-- Item -->
                <div class="col-xl-3 col-sm-6">
                  <div class="item d-flex align-items-center">
                    <div class="icon bg-violet"><i class="icon-user"></i></div>
                    <div class="title"><span>Service Provider</span>
                     
                    </div>
                    <div class="number"><strong><?= @$total_service_provider; ?></strong></div>
                  </div>
                </div>
                
                 
              </div>
            </div>
          </section>
          <!-- Dashboard Header Section    -->
          <section class="dashboard-header">
            <div class="container-fluid">
              <div class="row  bg-white">

                <!-- Statistics -->
                <div class=" col-lg-1 col-1">
                <div class="vertical"> Number of booking and customer</div>
                </div>
                <!-- Line Chart            -->
                <div class="chart col-lg-11 col-11">
                  <div class="line-chart d-flex align-items-center justify-content-center has-shadow">
                    <canvas id="lineCahrt"></canvas>
                  </div>
                </div>
                <div class="horizontal">Number of days</div>
                
              </div>
            </div>
          </section>
         
<script type="text/javascript">
       var seventh_day = <?= $seventh_day->total_booking; ?> ;
       var sixth_day = <?= $sixth_day->total_booking; ?>;
       var fifth_day  = <?= $fifth_day->total_booking; ?> ;
       var fourth_day = <?= $fourth_day->total_booking; ?> ;
      var third_day = <?= $third_day->total_booking; ?> ;
      var second_day = <?= $second_day->total_booking; ?> ;
      var first_day = <?= $first_day->total_booking; ?> ;

      var seventh_day_customer = <?= $seventh_day_customer->total_customer; ?> ;
       var sixth_day_customer = <?= $sixth_day_customer->total_customer; ?>;
       var fifth_day_customer  = <?= $fifth_day_customer->total_customer; ?> ;
       var fourth_day_customer = <?= $fourth_day_customer->total_customer; ?> ;
      var third_day_customer = <?= $third_day_customer->total_customer; ?> ;
      var second_day_customer = <?= $second_day_customer->total_customer; ?> ;
      var first_day_customer = <?= $first_day_customer->total_customer; ?> ;


</script>

<style type="text/css">
  .vertical{
    transform: rotate(-90deg); transform-origin: left top 0;
    margin-top: 280px;
    display: inline-grid;
    font-size: 11px;
  }

  .horizontal{
     display: inline-grid;
      margin-left: 450px;
    font-size: 11px;
    text-align: center;
  }
</style>