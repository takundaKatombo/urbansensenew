

<b>Dear <?php echo $name; ?> </b><br>

<p> You are receiving this email because we received a password reset request for your account.</p>
<center><a href="<?php echo base_url().'reset-password/'.$id.'/'.$key; ?>" style="font-size:16px;font-family:Helvetica,Helvetica neue,Arial,Verdana,sans-serif;font-weight:none;color:#ffffff;text-decoration:none;background-color:#3572b0;border-top:11px solid #3572b0;border-bottom:11px solid #3572b0;border-left:20px solid #3572b0;border-right:20px solid #3572b0;border-radius:5px;display:inline-block">Reset Password</a></center>

<p>If you’re having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser.  
<a href="<?php echo base_url().'reset-password/'.$id.'/'.$key; ?>"><?php echo base_url().'reset-password/'.$id.'/'.$key; ?></a> </p><br>

If you did not request a password reset, no further action is required.

<br>
Thank You
<br>
UrbanSense Support

<center><small>© 2019 UrbanSense. All rights reserved</small></center>