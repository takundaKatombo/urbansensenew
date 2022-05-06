<?php

defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
 <head> 
   <meta charset="utf-8"> 
   <title>Welcome to CodeIgniter</title>
 </head>
 <body>
   <!-- Export Data --> 
   <a href='<?= base_url() ?>index.php/users/exportCSV'>Export</a><br><br>

   <!-- User Records --> 
   <table border='1' style='border-collapse: collapse;'> 
     <thead> 
      <tr> 
       <th>Username</th> 
       <th>Name</th> 
       <th>Gender</th> 
       <th>Email</th> 
      </tr> 
     </thead> 
     <tbody> 
     <?php
     foreach($usersData as $key=>$val){ 
       echo "<tr>"; 
       echo "<td>".$val['username']."</td>"; 
       echo "<td>".$val['name']."</td>"; 
       echo "<td>".$val['gender']."</td>"; 
       echo "<td>".$val['email']."</td>"; 
       echo "</tr>"; 
      } 
      ?> 
     </tbody> 
    </table>
  </body>
</html>