<b>Dear <?php echo $name; ?> </b><br>

<p>We are really sorry that you couldn’t find any service provider in your location. We are working hard to add more and more service providers on our platform daily. </p> 
<p>We have received your request to avail the service provider in your location as per the details below:</p>

<p>
	<B>Service Name : </B> <?php echo $service; ?><br>
	<B>Date & Time : </B> <?php echo date('d M Y',strtotime($avail_date)).' | '.$avail_time; ?><br>
	<B>Location : </B> <?php echo $location; ?><br>
	<B>Service Details : </B> <?php echo $request_details; ?><br>
</p>



<p>Our team will review your request and get back to you shortly with an update.</p>

<br>
Thank You 
<br>
UrbanSense Support

<center><small>© 2019 UrbanSense. All rights reserved</small></center>