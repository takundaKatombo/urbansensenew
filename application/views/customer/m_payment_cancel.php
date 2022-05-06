<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>UrbanSense | Payment Cancel</title>
<link rel="shortcut icon"  type="image/png" href="<?= base_url('assets/fav.png')?>">
</head>
<body>

<center><h1>Payment Cancel</h1></center>


<center><h3>There are some issues in payment process. Please try again after some time.</h3></center>
 <?php $otherdats = explode("_",$this->input->get('other_data')); ?>
    <script>
var chatroomid = '<?= $otherdats[0]?>';
var token = '<?= $otherdats[1] ?>';
var txnid = '<?= $this->input->get('txnid') ?>';
window.location.assign("openurbanappfromweb://?chatroomid="+chatroomid+"&token="+token+"&txnid="+txnid);
</script>

</body>
</html>




  
