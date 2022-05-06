<b>Dear Administrator </b><br>

<p>
We have received a new request to provide the service provider in a customer’s location as per the details below:</p>

<p>
	<B>Customer Name : </B> <?php echo $name; ?><br>
	<B>Customer Email : </B> <?php echo $customeremail; ?><br>
	<B>Customer Phone : </B> <?php echo $customerphone; ?><br>
	<B>Service Name : </B> <?php echo $service; ?><br>
	<B>Date & Time : </B> <?php echo date('d M Y',strtotime($avail_date)).' | '.$avail_time; ?><br>
	<B>Location : </B> <?php echo $location; ?><br>
	<B>Service Details : </B> <?php echo $request_details; ?><br>
</p>



<br>
Thank You 
<br>
<?php echo $name; ?>

<center><small>© 2019 UrbanSense. All rights reserved</small></center>