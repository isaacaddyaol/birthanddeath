<?php

include('dbcon.php');

if(isset($_POST['type'])){
    $year = $_POST['year'];
    $region = $_POST['region'];
    $type = $_POST['type'];
    
    if($type=='birth'){
        $query = $con->query("SELECT * FROM tblbirth WHERE state='$region' AND YEAR(dateOfBirth)='$year'") or die(mysqli_error($con));
        $month1 = $month2 = $month3 = $month4 = $month5 = $month6 = $month7 = $month8 = $month9 = $month10 = $month11 = $month12 = 0;
        $month_1 = $month_2 = $month_3 = $month_4 = $month_5 = $month_6 = $month_7 = $month_8 = $month_9 = $month_10 = $month_11 = $month_12 = 0;
        
        while($ass = mysqli_fetch_assoc($query)){
            $month_sub = substr($ass['dateOfBirth'], 5, 2);
            if($ass['gender']=='Male'){
                switch($month_sub){
                    case "01": $month1++; break;
                    case "02": $month2++; break;
                    case "03": $month3++; break;
                    case "04": $month4++; break;
                    case "05": $month5++; break;
                    case "06": $month6++; break;
                    case "07": $month7++; break;
                    case "08": $month8++; break;
                    case "09": $month9++; break;
                    case "10": $month10++; break;
                    case "11": $month11++; break;
                    case "12": $month12++; break;
                }
            } else if($ass['gender']=='Female'){
                switch($month_sub){
                    case "01": $month_1++; break;
                    case "02": $month_2++; break;
                    case "03": $month_3++; break;
                    case "04": $month_4++; break;
                    case "05": $month_5++; break;
                    case "06": $month_6++; break;
                    case "07": $month_7++; break;
                    case "08": $month_8++; break;
                    case "09": $month_9++; break;
                    case "10": $month_10++; break;
                    case "11": $month_11++; break;
                    case "12": $month_12++; break;
                }
            }
        }
        
        header('Content-Type: application/json');
        echo json_encode(array(
            "male" => "$month1,$month2,$month3,$month4,$month5,$month6,$month7,$month8,$month9,$month10,$month11,$month12",
            "female" => "$month_1,$month_2,$month_3,$month_4,$month_5,$month_6,$month_7,$month_8,$month_9,$month_10,$month_11,$month_12"
        ));
    }
    
    if($type=='death'){
        $query = $con->query("SELECT * FROM tbldeath WHERE state='$region' AND YEAR(dateOfDeath)='$year'") or die(mysqli_error($con));
        $month1 = $month2 = $month3 = $month4 = $month5 = $month6 = $month7 = $month8 = $month9 = $month10 = $month11 = $month12 = 0;
        $month_1 = $month_2 = $month_3 = $month_4 = $month_5 = $month_6 = $month_7 = $month_8 = $month_9 = $month_10 = $month_11 = $month_12 = 0;
        
        while($ass = mysqli_fetch_assoc($query)){
            $month_sub = substr($ass['dateOfDeath'], 5, 2);
            if($ass['gender']=='Male'){
                switch($month_sub){
                    case "01": $month1++; break;
                    case "02": $month2++; break;
                    case "03": $month3++; break;
                    case "04": $month4++; break;
                    case "05": $month5++; break;
                    case "06": $month6++; break;
                    case "07": $month7++; break;
                    case "08": $month8++; break;
                    case "09": $month9++; break;
                    case "10": $month10++; break;
                    case "11": $month11++; break;
                    case "12": $month12++; break;
                }
            } else if($ass['gender']=='Female'){
                switch($month_sub){
                    case "01": $month_1++; break;
                    case "02": $month_2++; break;
                    case "03": $month_3++; break;
                    case "04": $month_4++; break;
                    case "05": $month_5++; break;
                    case "06": $month_6++; break;
                    case "07": $month_7++; break;
                    case "08": $month_8++; break;
                    case "09": $month_9++; break;
                    case "10": $month_10++; break;
                    case "11": $month_11++; break;
                    case "12": $month_12++; break;
                }
            }
        }
        
        header('Content-Type: application/json');
        echo json_encode(array(
            "male" => "$month1,$month2,$month3,$month4,$month5,$month6,$month7,$month8,$month9,$month10,$month11,$month12",
            "female" => "$month_1,$month_2,$month_3,$month_4,$month_5,$month_6,$month_7,$month_8,$month_9,$month_10,$month_11,$month_12"
        ));
    }
}

?>