<b>Dear <?php echo $name; ?> </b><br>

<p>Your service is scheduled for tomorrow. Please check the below details.</p>

<strong>Customer Name: </strong> <?= $booking->customer_name ?><br>
<strong>Customer Address: </strong> <?= $booking->customer_address ?><br>
<strong>Scheduled Date: </strong> <?= $booking->required_date ?><br>
<strong>Scheduled Time: </strong> <?= $booking->required_time ?><br>

<br>
<p>Thank You </p>

UrbanSense Support

<center><small>© 2019 UrbanSense. All rights reserved</small></center>