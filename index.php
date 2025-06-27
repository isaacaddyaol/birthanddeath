<?php

error_reporting(0);
include('dbcon.php');
session_start();

if(isset($_POST['login']))
{

$email=$_POST['email'];
$password=$_POST['password'];

	$result = mysqli_query($con,"SELECT * FROM tbladmin WHERE (email = '$email'or username='$email') AND password = '$password'") or die(mysqli_error());
							
		$row = mysqli_fetch_array($result);
		$numberOfRows = mysqli_num_rows($result);				
		 if ($numberOfRows > 0) 
     {
              $_SESSION['email'] = $row['email'];
              $_SESSION['username'] = $row['username'];
              $_SESSION['role'] = $row['role'];
              $_SESSION['RegCentre'] = $row['RegCentre'];


          echo "<script type = \"text/javascript\">
                alert(\"Login Successful.................\");
                window.location = (\"AdminDashboard.php\")
                </script>";
                                } 
              else 
                 {

                  echo "<script>alert('Invalid Login Credentials');</script>";
                            
                  }																
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
  <link rel="stylesheet" href="css/custom.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.png" />
</head>

<body style="background-color:#fdfffb;">
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper auth-page">
      <div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one" style="min-height:100vh;">
        <div class="row w-100 justify-content-center">
          <div class="col-lg-4 col-md-6 col-sm-8">
            <div class="card shadow-lg border-0">
              <div class="card-body p-4">
                <div class="text-center mb-4">
                  <img src="images/Coat_of_arms_of_Ghana.svg" alt="Coat of Arms of Ghana" style="width: 120px; height: auto; margin-bottom: 20px;">
                  <h2 class="font-weight-bold" style="color:#2d3e50;">Birth and Death Registration System</h2>
                </div>
                <form action="index.php" method="post">
                  <div class="form-group">
                    <label class="label">Username</label>
                    <div class="input-group">
                      <input type="text" name="email" class="form-control" placeholder="Username">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="label">Password</label>
                    <div class="input-group">
                      <input type="password" name="password" class="form-control" placeholder="*********">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <button class="btn btn-primary submit-btn btn-block" name="login">Login</button>
                  </div>
                  <div class="form-group d-flex justify-content-between">
                    <div class="form-check form-check-flat mt-0">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" checked> Keep me signed in
                      </label>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <ul class="auth-footer mt-3">
              <!-- Add footer links if needed -->
            </ul>
            <p class="footer-text text-center mt-2">Birth and Death Registration System. All rights reserved.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- plugins:js -->
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <script src="vendors/js/vendor.bundle.addons.js"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/misc.js"></script>
  <!-- endinject -->
</body>

</html>