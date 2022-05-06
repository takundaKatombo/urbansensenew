<b>Dear Administrator, </b><br>

<p><b><?= get_user($quoterequest->user_id)->first_name ?></b> has raised the issue of non-arrival for the following service: <p>
 
<b>Service Name : </b> <?= get_service($quoterequest->service_id) ?> <br>
<b>Provider Name : </b> <?= get_user($response->professional_id)->first_name ?> <br>
<b>Company Name : </b> <?= get_user($response->professional_id)->professionals->company_name ?> <br>
<b>Provider Email : </b> <?= get_user($response->professional_id)->email ?> <br>
<b>Provider Phone : </b> <?= get_user($response->professional_id)->phone ?> <br>
<b>Schedule Date/Time : </b> <?= date('d-M-Y',strtotime($quoterequest->avail_date))  ?> / <?= $quoterequest->avail_time ?> <br>
<b>Location : </b> <?= $quoterequest->location ?>  <br>


<p>An intimation email has been sent to the provider for the same. Please look into this matter on an urgent basis.</p> 

Thank You 
<br>
UrbanSense Support

<center><small>© 2019 UrbanSense. All rights reserved</small></center>