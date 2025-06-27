<?php

session_start();
error_reporting(E_ALL);
include('dbcon.php');


if(isset($_GET['adminId'])){
    $aid=$_GET['adminId'];
    $dequer=$con->query("DELETE FROM tbladmin WHERE adminId='$aid'");
    
    
    if($dequer){
         echo "<script type = \"text/javascript\">
  window.location = (\"userReports.php\");
  </script>";
    }
}

?>