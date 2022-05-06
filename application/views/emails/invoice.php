<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="x-ua-compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Invoice</title>
      <style>
      </style>
   </head>
   <body>
      <center>
         <table style="font-size:12.8px;text-decoration-style:initial;text-decoration-color:initial;background-color: rgb(255, 255, 255);
            border: 4px solid rgb(241, 241, 241);" width="500" cellspacing="3" cellpadding="2" >
            <tbody>

                <tr>
                  <td style="font-family:arial,sans-serif;margin-left:30px">
                     <table width="100%" cellspacing="3" cellpadding="2" align="justify">
                        <tbody style="font-family:Century Gothic; ">
                           
                           <tr>
                              
                              <td style="font-size:1.2em; margin-left:30px;">
                               <center>  <img src="<?php echo FCPATH.'uploads/image/'.$site_data->logo; ?>"></center>
                              </td>
                              <td style="font-size:1.2em;  margin-right:30px;">
                                <center> 
                                 <b>
                                Booking ID : <?= $bookings[0]->booking_reference_number ?><br></b>
                              </center>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </td>
               </tr>


               <tr>
                  <td style="font-family:arial,sans-serif;margin:0px">
                     <table width="100%" cellspacing="3" cellpadding="2" align="justify" style="margin-left: 30px;">
                        <tbody style="font-family:Century Gothic; ">
                           
                           <tr>
                              
                              <td style="font-size:1.2em;"><b>Customer Information</b><br>
                                 <?= ucwords($bookings[0]->customer_name) ?><br>
                                 Phone :  <?= $bookings[0]->customer_phone ?><br>
                                 Email : <?= $bookings[0]->customer_email ?><br>
                                 Address : <?= $bookings[0]->customer_address ?><br>
                              </td>
                              <td style="font-size:1.2em;"><b>Service Provider Details</b><br>
                                 <span style="font-weight:400"></span> <?= $professional->professionals->company_name ?><br> <span style="font-weight:400">Phone : </span> <?= $professional->phone ?>
                                 <br> <span style="font-weight:400">Email : </span> <?= $professional->email ?><br>
                                 <span style="font-weight:400">Address : </span> <?= $professional->professionals->address ?><br>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </td>
               </tr>
               <tr style="height:250px;">
                  <td>
                     <table width="100%" cellspacing="3" cellpadding="2" align="justify" style="border: 1px solid #c1c1c1;
                        padding: 10px; margin-left: 30px;">
                        <tbody style="font-size:1.2em;">
                           <tr>
                              <td style="font-size:1.2em;" ><b>Service</b></td>
                               <td  style="font-size:1.2em;"><b>Payment ID</b></td>
                              <td  style="font-size:1.2em;"><b>Preferred date</b></td>
                              <td  style="font-size:1.2em;"><b>Preferred time</b></td>
                              <td  style="font-size:1.2em;"><b>Price</b></td>
                           </tr>
                          <?php foreach ($bookings as $booking) { ?>
                             
                              <tr>
                                 <td  style="font-size:1.1em;"><?= ucwords(get_service($booking->service_id)) ?></td>
                                 <td  style="font-size:1.1em;"><?= $booking->payment_key ?></td>
                                 <td  style="font-size:1.1em;"><?= date('m-d-Y', strtotime($booking->required_date)) ?></td>
                                 <td  style="font-size:1.1em;"><?= $booking->required_time ?></td>
                                 <td style="font-size:1.1em;"> <?= $booking->currency.' '. $booking->amount_paid ?></td>
                             
                              </tr>
                           <?php } ?>
                          
                        </tbody>
                     </table>
                  </td>
               </tr>
               <tr>
                  <td>
                     <table width="100%" cellspacing="3" cellpadding="2" align="justify" style="margin-left: 20px;">
                        <tbody>
                           <tr style=" height: 60px;background-color: #f1f1f1;">
                              <td style="font-size:1.2em;text-align:center;">
                               <center><small>&copy; 2019 UrbanSense. All rights reserved</small></center>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </td>
               </tr>
            </tbody>
         </table>
      </center>
   </body>
</html>