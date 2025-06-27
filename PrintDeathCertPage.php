<?php
session_start();
error_reporting(0);
include('dbcon.php');


if (!isset($_SESSION['email']))
{

  echo "<script type = \"text/javascript\">
  window.location = (\"index.php\");
  </script>";

}

if(isset($_GET['deathRegId']))
{

$_SESSION['deathRegId'] = $_GET['deathRegId'];

}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <?php include_once('title.php');?>
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/iconfonts/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.addons.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.png" />
  

  <script type="text/javascript">

function Print()
{
window.print();
}
</script>


</head>

<body >
  <div class="container-scroller">


</div>
    <!-- partial -->
      <!-- partial:partials/_sidebar.html -->
      

      
      <!-- partial -->
        <div class="content-wrapper" >
          <div class="row purchace-popup">
            <div class="col-12">
             
            </div>
          </div>
          <?php
		  $query = $con->query("select  * from tbldeath where deathId = '$_SESSION[deathRegId]'") or die(mysqli_error());
          $row = mysqli_fetch_array($query);

        ?>



          <div class="row" style="margin-top:0px"  >
            <div class="col-lg-7 grid-margin stretch-card">
           
            </div>
         
          </div>
         
          <div class="col-12 grid-margin" >
              <div class="card" >
                <div class="card-body" >
                    <div style="margin-left: 36%">
                        <div class="card-title" style="margin-left:10%"><img src="coatofarms.png" width="200px" height="150px"></div>
                        <div class="card-title" style="margin-left:15%"><h3>REPUBLIC OF GHANA</h3></div>
                        <div class="card-title" style="margin-left:15%"><h2><u>DEATH CERTIFICATE</u></h2></div>
                    </div>
                  
                    <form class="form-sample" method="post" action="DeathRegistration.php">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Certificate Number:</label>
                                    <div class="col-sm-9">
                                        <u><?php echo $row['certNo'];?></u>
                                        <br>
                                        <?php
                                        $certNo = $row['certNo'];
                                        $qrData = urlencode("https://yourdomain.com/verify.php?certNo=" . $certNo);
                                        $qrUrl = "https://chart.googleapis.com/chart?chs=120x120&cht=qr&chl=$qrData&choe=UTF-8";
                                        ?>
                                        <img src="<?php echo $qrUrl; ?>" alt="QR Code" style="width: 90px; height: 90px; margin-top: 8px; border: 1px solid #eee;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Registration Centre:</label>
                                    <div class="col-sm-9">
                                        <u><?php echo $row['regCentre'];?></u>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Full Name:</label>
                                    <div class="col-sm-9">
                                        <u><?php echo $row['firstName'] . ' ' . $row['lastName'];?></u>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Gender:</label>
                                    <div class="col-sm-9">
                                        <u><?php echo $row['gender'];?></u>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Date of Death:</label>
                                    <div class="col-sm-9">
                                        <u><?php echo $row['dateOfDeath'];?></u>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Place of Death:</label>
                                    <div class="col-sm-9">
                                        <u><?php echo $row['placeOfDeath'];?></u>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Age at Death:</label>
                                    <div class="col-sm-9">
                                        <u><?php echo $row['ageAtDeath'];?> years</u>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Cause of Death:</label>
                                    <div class="col-sm-9">
                                        <u><?php echo $row['cause_death'];?></u>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">State:</label>
                                    <div class="col-sm-9">
                                        <u><?php echo $row['state'];?></u>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">LGA:</label>
                                    <div class="col-sm-9">
                                        <u><?php echo $row['lga'];?></u>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Address:</label>
                                    <div class="col-sm-10">
                                        <u><?php echo $row['address'];?></u>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Registration Details:</label>
                                    <div class="col-sm-10">
                                        <p>This is to certify that the death details recorded herein have been registered on <u><?php echo $row['dateReg'];?></u> at <u><?php echo $row['regCentre'];?></u></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Place of Issue:</label>
                                    <div class="col-sm-9">
                                        <u><?php echo $row['PlaceOfIssue'];?></u>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Date of Issue:</label>
                                    <div class="col-sm-9">
                                        <u><?php echo date('Y-m-d');?></u>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Registration Officer:</label>
                                    <div class="col-sm-9">
                                        <u><?php echo $_SESSION['username'];?></u>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Signature:</label>
                                    <div class="col-sm-9">
                                        ________________________________
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 text-center">
                                <div id='qrcode' style="margin: 20px auto;"></div>
                                <small>Scan QR code to verify certificate authenticity</small>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12 text-center">
                                <input type="button" onclick="Print()" class="btn btn-success btn-fw" value="Print Certificate">
                                <a href="PrintDeathCert.php" class="btn btn-light">Back to List</a>
                            </div>
                        </div>
                    </form>
                </div>
              </div>
            </div>
          </div>
       
         
           


          <?php include_once('footer.php');?>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <script src="vendors/js/vendor.bundle.addons.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/misc.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="js/dashboard.js"></script>
  <!-- End custom js for this page-->
</body>

</html>