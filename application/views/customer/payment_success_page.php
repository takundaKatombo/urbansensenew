 <!-- ========== MAIN CONTENT ========== -->
 <main id="content" role="main">
     <div class="form-pro">
         <div class="container">
             <div class="col-sm-12">
                 <div class="successpage">
                     <div class="imagecorrect">
                         <center> <img src="<?= base_url(); ?>assets/check-mark.png" alt="">
                             <h1>Congratulations!!</h1>
                             <h3>You booked service provider successfully</h3>
                         </center>
                     </div>

                     <table class="table">
                         <tbody>
                             <tr>
                                 <th>Name</th>
                                 <td><?= $booking->customer_name ?></td>
                             </tr>
                             <tr>
                                 <th>Phone</th>
                                 <td><?= $booking->customer_phone ?></td>
                             </tr>
                             <tr>
                                 <th>Email</th>
                                 <td><?= $booking->customer_email ?></td>
                             </tr>
                             <tr>
                                 <th>Address</th>
                                 <td><?= $booking->customer_address ?></td>
                             </tr>
                             <tr>
                                 <th>Service Schedule For</th>
                                 <td><?= date('d M Y', strtotime($booking->required_date)) . " | " . $booking->required_time  ?></td>
                             </tr>
                             <tr>
                                 <th>Booking Date & Time</th>
                                 <td><?= date('d M Y h:i:s', strtotime($booking->booking_time)) ?></td>
                             </tr>
                             <tr>
                                 <th>Service</th>
                                 <td> <?= ucwords(get_service($booking->service_id)) ?> </td>
                             </tr>
                             <tr>
                                 <th>Service Provider</th>
                                 <td><?= $professional->professionals->company_name ?></td>
                             </tr>
                             <!-- <tr>
                                 <th>Amount Paid</th>
                                 <td> <?= $booking->currency . ' ' . $booking->amount_paid ?></td>
                             </tr>
                             <tr>
                                 <th>Payment Key</th>
                                 <td><?= $booking->payment_key ?></td>
                             </tr>
                             <tr>
                                 <th>Booking ID</th>
                                 <td><?= $booking->booking_reference_number ?></td>
                             </tr> -->

                         </tbody>
                     </table>
                 </div>
             </div>
         </div>
 </main>
 <!-- ========== END MAIN CONTENT ========== -->