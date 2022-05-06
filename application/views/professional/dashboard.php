   <!-- ==========  MAIN CONTENT ========== -->
   <main id="content" role="main">
       <div class="container">
           <div class="row">
               <?php if ($loggedin_user->verification != 1) { ?>
                   <div class="col-md-12" style="margin-top: 8px;">
                       <div class="alert alert-warning">
                           Please update your profile and upload relevant documents for account verification purpose. Only verified profiles are entitled to accept orders and payments. <a href="<?= base_url('edit-profile'); ?>">Click here </a> to proceed. If you've already uploaded all documents, please wait while we verify the details. Your account will be activated to receive requests after successful verification.
                       </div>
                   </div>
               <?php } ?>
               <div class="col-md-3 ">
                   <a href="<?= base_url('booking-view'); ?>">
                       <div class=" bg-white">
                           <div class="icon">
                               <i class="fa fa-list" aria-hidden="true"></i></div>
                           <div class="text">
                               Total Bookings<br>
                               <div class="small"><?= $booking->total_booking; ?></div>
                           </div>
                       </div>
                   </a>
               </div>
               <div class="col-md-3 ">
                   <a href="<?= base_url('payment-view'); ?>">
                       <div class=" bg-white">
                           <div class="icon">
                               <i class="fas fa-hand-holding-usd" aria-hidden="true"></i></div>
                           <div class="text">
                               Total Payments<br>
                               <div class="small"><?= $booking->total_booking; ?></div>
                           </div>
                       </div>
                   </a>
               </div>

               <div class="col-md-3 ">
                   <a href="<?= base_url('all-leads'); ?>">
                       <div class=" bg-white">
                           <div class="icon">
                               <i class="fa fa-bell" aria-hidden="true"></i></div>
                           <div class="text <?= ($new_leads != 0) ? 'font-weight-bold text-dark' : ''; ?>">New Leads
                               <br>
                               <div class="small"><?= $new_leads ?></div>
                           </div>
                       </div>
                   </a>
               </div>

               <div class="col-md-3 ">
                   <a href="<?= base_url('professional-messages'); ?>">
                       <div class=" bg-white">
                           <div class="icon">
                               <i class="fa fa-comments" aria-hidden="true"></i>
                           </div>
                           <div class="text <?= ($new_message != 0) ? 'font-weight-bold text-dark' : ''; ?>">New Messages
                               <br>
                               <div class="small"><?= $new_message ?></div>
                           </div>
                       </div>
                   </a>
               </div>

           </div>
           <div class="row">
               <div class="col-md-1">
                   <div class="vertical"> Number of booking</div>
               </div>
               <div class="col-md-7">
                   <h3>Booking Graph</h3>(Last 7 days)
                   <div class="card_graph1">
                       <div id="chartContainer" style="height: 300px; width: 100%;"></div>
                   </div>
                   <div class="horizontal">Number of days</div>
               </div>

               <div class="col-md-4 ">
                   <div class="col-md-12 ">
                       <div class="card_graph">
                           <h4 class="recent">Recent Booking</h4>
                           <ul>
                               <?php if (!empty($recent_booking)) { ?>
                                   <?php foreach ($recent_booking as $row) { ?>

                                       <li><a href="<?= base_url('booking-detail-view/') . $row->id ?>">Booking for <?= get_service($row->service_id); ?></a></li>

                                   <?php }
                                } else { ?>
                                   <center>No Recent Bookings Found</center>

                               <?php } ?>

                           </ul>
                       </div>
                   </div>
                   <div class="col-md-12 ">
                       <div class="card_graph">
                           <h4 class="recent">Recent Payments</h4>
                           <ul>
                               <?php if (!empty($recent_payment)) { ?>
                                   <?php foreach ($recent_payment as $row) { ?>
                                       <li><a href="<?= base_url('payment-detail-view/') . $row->id ?>">Payment <?= $row->currency_type  . ' ' . $row->amount ?></a></li>
                                   <?php }
                                } else { ?>
                                   <center>No Recent Payments Found</center>

                               <?php } ?>
                           </ul>
                       </div>
                   </div>
               </div>
           </div>
       </div>
       </div>
   </main>

   <script type="text/javascript">
       window.onload = function() {

           var chart = new CanvasJS.Chart("chartContainer", {
               animationEnabled: true,
               theme: "light2",
               title: {

               },
               axisY: {
                   includeZero: false
               },
               data: [{
                   markerColor: "#13A89E",
                   type: "line",
                   lineColor: "#13A89E",
                   dataPoints: [{
                           y: <?= $seventh_day->total_booking; ?>
                       },
                       {
                           y: <?= $sixth_day->total_booking; ?>
                       },
                       {
                           y: <?= $fifth_day->total_booking; ?>
                       },
                       {
                           y: <?= $fourth_day->total_booking; ?>
                       },
                       {
                           y: <?= $third_day->total_booking; ?>
                       },
                       {
                           y: <?= $second_day->total_booking; ?>
                       },
                       {
                           y: <?= $first_day->total_booking; ?>
                       },


                   ]
               }]
           });
           chart.render();

       }
   </script>


   <style type="text/css">
       ul {
           list-style-type: none;
           padding: 13px;
       }

       .fa,
       .fas {

           margin-top: 11px;
       }

       .vertical {
           transform: rotate(-90deg);
           transform-origin: left top 0;
           margin-top: 280px;
           display: inline-grid;
           font-size: 11px;
       }

       .horizontal {
           display: inline-grid;
           margin-left: 250px;
           font-size: 11px;
           text-align: center;
           margin-bottom: 5px;
       }
   </style>
   <!-- ========== END MAIN CONTENT ========== -->