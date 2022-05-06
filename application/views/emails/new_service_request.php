<b>Dear <?= ucwords($name) ?> </b><br>

<p>You have received a new service request as per the details below:</p>

<p>
    <B>Service Name : </B> <?= ucwords(get_service($request->service_id)) ?><br>
    <B>Date & Time : </B> <?= date('m-d-Y', strtotime($request->avail_date)) ?> | <?= $request->avail_time ?><br>
    <B>Location : </B> <?= $request->location ?><br>
</p>

<p>Please login to your account in order to check the details</p>

<br>
Thank You
<br>
UrbanSense Support

<center><small>© 2019 UrbanSense. All rights reserved</small></center>