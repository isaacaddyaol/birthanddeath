<?php 

include('dbcon.php');


 if(isset($_GET['id'])){
     $id=$_GET['id'];
     
     
     
     $payupdate=$con->query("UPDATE tblbirth SET payId=1 WHERE birthId='$id'" ) or die(mysqli_error());
     
     if($payupdate){
         echo 'Payment updated';
     }
 }







?>