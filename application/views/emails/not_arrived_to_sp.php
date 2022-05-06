<b>Dear <?= get_user($response->professional_id)->first_name ?> </b><br>

<p><?= get_user($quoterequest->user_id)->first_name ?> has raised the issue of non-arrival for the following service: <p>
 
<b>Service Name:</b> <?= get_service($quoterequest->service_id) ?> <br>
<b>Schedule Date/Time:</b> <?= date('d-M-Y',strtotime($quoterequest->avail_date))  ?> / <?= $quoterequest->avail_time ?> <br>
<b>Location: </b> <?= $quoterequest->location ?> 

<p>You are required to communicate with the customer immediately and resolve the issue. Please note that the customer can still provide the review and so you must complete the task as agreed in order to receive a good review from the customer.</p> 

Thank You 
<br>
UrbanSense Support

<center><small>© 2019 UrbanSense. All rights reserved</small></center>