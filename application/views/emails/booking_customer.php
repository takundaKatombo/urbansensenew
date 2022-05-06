<b>Dear <?= ucwords($booking->customer_name) ?> </b><br>

<p>You have successfully booked <b> <?= $professional->professionals->company_name ?></b> for your service request as per the details below:</p>

<p>
	<B>Service Name : </B> <?= ucwords(get_service($booking->service_id)) ?><br>
	<B>Date & Time : </B> <?= date('m-d-Y', strtotime($booking->required_date)) ?> | <?= $booking->required_time ?><br>
	<B>Location : </B> <?= $professional->professionals->address ?><br>
	<B>Service Provider Name : <?= $professional->professionals->company_name ?><br>
	<B>Amount Paid : </B> <?= $booking->currency.' '. $booking->amount_paid ?><br>
	<B>Status : </B> <?php echo $booking->booked_status; ?><br>
</p>



<p>A copy of the payment receipt has been attached in this email for your reference.</p>

<br>
Thank You 
<br>
UrbanSense Support

<center><small>© 2019 UrbanSense. All rights reserved</small></center>