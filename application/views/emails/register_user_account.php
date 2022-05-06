<b>Dear <?php echo $name; ?> </b><br>

<p> We hope you are doing well!</p>
<p>We have created your account on UrbanSense as a customer. UrbanSense thinks that you can get instant access to reliable and affordable services near you, if you use this platform. Credentials for  use the platform are given below.</p>
<br>
<b>Email ID: </b> <?php echo $email; ?> <br>
<b>Password: </b> <?php echo $password; ?> <br> 

 
<p>As the part of our verification process, we are also providing you an activation link below. Please click on the link below in order to activate your account.</p>  

<center><a href="<?php echo base_url().'activate/'.$id.'/'.$key; ?>" style="font-size:16px;font-family:Helvetica,Helvetica neue,Arial,Verdana,sans-serif;font-weight:none;color:#ffffff;text-decoration:none;background-color:#3572b0;border-top:11px solid #3572b0;border-bottom:11px solid #3572b0;border-left:20px solid #3572b0;border-right:20px solid #3572b0;border-radius:5px;display:inline-block">Activate Account</a> </center><br>

<a href="<?php echo base_url().'activate/'.$id.'/'.$key; ?>"><?php echo base_url().'activate/'.$id.'/'.$key; ?></a> </p><br>



<br>
Thank You
<br>
UrbanSense Support

<center><small>© 2019 UrbanSense. All rights reserved</small></center>