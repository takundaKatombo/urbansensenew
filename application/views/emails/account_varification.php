

<b>Dear <?php echo $name; ?> </b><br>

<p>Congratulations, your account has been successfully registered! As the part of securing your account, please verify your email address by clicking the button below: </p> 
<center><a href="<?php echo base_url().'activate/'.$id.'/'.$key; ?>" style="font-size:16px;font-family:Helvetica,Helvetica neue,Arial,Verdana,sans-serif;font-weight:none;color:#ffffff;text-decoration:none;background-color:#3572b0;border-top:11px solid #3572b0;border-bottom:11px solid #3572b0;border-left:20px solid #3572b0;border-right:20px solid #3572b0;border-radius:5px;display:inline-block">Activate Account</a> </center><br>

<p>In case, you have trouble clicking on the button please copy the below URL and paste it in your browser to activate your account. We also encourage to add this email in your contact so that the emails from our side don't go to your spam folder.</p>

<a href="<?=  base_url().'activate/'.$id.'/'.$key; ?>"><?=  base_url().'activate/'.$id.'/'.$key; ?></a> <br>

<p>We wish you all the good luck in managing your business with us. </p>

<br>
Thank You 
<br>
UrbanSense Support

<center><small>© 2019 UrbanSense. All rights reserved</small></center>