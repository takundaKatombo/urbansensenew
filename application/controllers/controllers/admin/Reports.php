  <?php

  defined('BASEPATH') OR exit('No direct script access allowed');

          // Export data in CSV format 
          public function exportCSV(){ 
             // file name 
             $filename = 'users_'.date('Ymd').'.csv'; 
             header("Content-Description: File Transfer"); 
             header("Content-Disposition: attachment; filename=$filename"); 
             header("Content-Type: application/csv; ");
             
             // get data 
             $usersData = $this->Main_model->getUserDetails();

             // file creation 
             $file = fopen('php://output', 'w');
           
             $header = array("Username","Name","Gender","Email"); 
             fputcsv($file, $header);
             foreach ($usersData as $key=>$line){ 
               fputcsv($file,$line); 
             }
             fclose($file); 
             
             exit; 
        }
  }