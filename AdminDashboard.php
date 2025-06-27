<?php
error_reporting(0);
session_start(); 
include('dbcon.php');


if (!isset($_SESSION['email']))
{

  echo "<script type = \"text/javascript\">
  window.location = (\"index.php\");
  </script>";

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
</head>

<body>
  <div class="container-scroller">

  <?php include_once 'header.php';?>

</div>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      
<?php include_once 'sidebar.php';?>
      
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row purchace-popup">
            
          </div>
          
          

          <?php 
          
          if(isset($_SESSION['role'])){
             
             $role=$_SESSION['role'];
             
             if($role=='Super Administrator'){
                 include_once 'TopDash.php';
//                 echo "<script type = \"text/javascript\">
//  alert('".$role."');
//   </script>"; 
             }
             
            
             
         }
          
          
          ?>



          <div class="row">
            <div class="col-lg-7 grid-margin stretch-card">
              <!-- Performance Metrics Section -->
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Performance Metrics</h4>
                  <?php
                  // Get current month's data
                  $current_month = date('m');
                  $current_year = date('Y');
                  
                  // Birth registrations this month
                  $birth_month = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tblbirth WHERE MONTH(dateReg) = $current_month AND YEAR(dateReg) = $current_year"));
                  
                  // Death registrations this month
                  $death_month = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbldeath WHERE MONTH(dateReg) = $current_month AND YEAR(dateReg) = $current_year"));
                  
                  // Certificates issued this month
                  $cert_month = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tblbirth WHERE MONTH(dateReg) = $current_month AND YEAR(dateReg) = $current_year AND payId = 1")) +
                               mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbldeath WHERE MONTH(dateReg) = $current_month AND YEAR(dateReg) = $current_year AND payId = 1"));
                  
                  // Calculate month-over-month growth
                  $last_month = $current_month - 1;
                  $last_year = $current_year;
                  if($last_month == 0) {
                    $last_month = 12;
                    $last_year--;
                  }
                  
                  $birth_last_month = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tblbirth WHERE MONTH(dateReg) = $last_month AND YEAR(dateReg) = $last_year"));
                  $death_last_month = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbldeath WHERE MONTH(dateReg) = $last_month AND YEAR(dateReg) = $last_year"));
                  
                  $birth_growth = $birth_last_month > 0 ? (($birth_month - $birth_last_month) / $birth_last_month) * 100 : 0;
                  $death_growth = $death_last_month > 0 ? (($death_month - $death_last_month) / $death_last_month) * 100 : 0;
                  ?>
                  <div class="row">
                    <div class="col-md-4">
                      <div class="card bg-primary text-white">
                        <div class="card-body">
                          <h5>Birth Registrations</h5>
                          <h2><?php echo $birth_month; ?></h2>
                          <p class="mb-0">
                            <?php if($birth_growth >= 0): ?>
                              <i class="mdi mdi-arrow-up"></i>
                            <?php else: ?>
                              <i class="mdi mdi-arrow-down"></i>
                            <?php endif; ?>
                            <?php echo abs(round($birth_growth, 1)); ?>% vs last month
                          </p>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="card bg-danger text-white">
                        <div class="card-body">
                          <h5>Death Registrations</h5>
                          <h2><?php echo $death_month; ?></h2>
                          <p class="mb-0">
                            <?php if($death_growth >= 0): ?>
                              <i class="mdi mdi-arrow-up"></i>
                            <?php else: ?>
                              <i class="mdi mdi-arrow-down"></i>
                            <?php endif; ?>
                            <?php echo abs(round($death_growth, 1)); ?>% vs last month
                          </p>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="card bg-success text-white">
                        <div class="card-body">
                          <h5>Certificates Issued</h5>
                          <h2><?php echo $cert_month; ?></h2>
                          <p class="mb-0">This Month</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="col-lg-5 grid-margin stretch-card">
              <!-- Payment Status Overview -->
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Payment Status Overview</h4>
                  <?php
                  // Get payment statistics
                  $total_birth = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tblbirth"));
                  $paid_birth = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tblbirth WHERE payId = 1"));
                  $total_death = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbldeath"));
                  $paid_death = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbldeath WHERE payId = 1"));
                  
                  $birth_paid_percent = $total_birth > 0 ? ($paid_birth / $total_birth) * 100 : 0;
                  $death_paid_percent = $total_death > 0 ? ($paid_death / $total_death) * 100 : 0;
                  ?>
                  <div class="mb-4">
                    <h6>Birth Certificates</h6>
                    <div class="progress">
                      <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $birth_paid_percent; ?>%">
                        <?php echo round($birth_paid_percent, 1); ?>% Paid
                      </div>
                    </div>
                    <small class="text-muted"><?php echo $paid_birth; ?> of <?php echo $total_birth; ?> paid</small>
                  </div>
                  <div class="mb-4">
                    <h6>Death Certificates</h6>
                    <div class="progress">
                      <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $death_paid_percent; ?>%">
                        <?php echo round($death_paid_percent, 1); ?>% Paid
                      </div>
                    </div>
                    <small class="text-muted"><?php echo $paid_death; ?> of <?php echo $total_death; ?> paid</small>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Regional Distribution -->
          <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Regional Distribution</h4>
                  <canvas id="regionalChart" height="300"></canvas>
                </div>
              </div>
            </div>
            
            <!-- System Health Monitor -->
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">System Health</h4>
                  <?php
                  // Get system statistics
                  $total_records = $total_birth + $total_death;
                  $active_centers = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tblcentre WHERE status = 'Active'"));
                  $total_centers = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tblcentre"));
                  $active_users = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbladmin WHERE status = 'Active'"));
                  $total_users = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbladmin"));
                  
                  // Calculate system health metrics
                  $center_health = ($active_centers / $total_centers) * 100;
                  $user_health = ($active_users / $total_users) * 100;
                  $data_health = ($total_records > 0) ? 100 : 0;
                  ?>
                  <div class="row">
                    <div class="col-md-4">
                      <div class="text-center">
                        <h3 class="text-<?php echo $center_health > 80 ? 'success' : ($center_health > 50 ? 'warning' : 'danger'); ?>">
                          <?php echo round($center_health); ?>%
                        </h3>
                        <p class="text-muted">Center Health</p>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="text-center">
                        <h3 class="text-<?php echo $user_health > 80 ? 'success' : ($user_health > 50 ? 'warning' : 'danger'); ?>">
                          <?php echo round($user_health); ?>%
                        </h3>
                        <p class="text-muted">User Health</p>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="text-center">
                        <h3 class="text-<?php echo $data_health > 80 ? 'success' : ($data_health > 50 ? 'warning' : 'danger'); ?>">
                          <?php echo $data_health; ?>%
                        </h3>
                        <p class="text-muted">Data Health</p>
                      </div>
                    </div>
                  </div>
                  <div class="mt-4">
                    <h6>System Status</h6>
                    <div class="progress">
                      <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo ($center_health + $user_health + $data_health) / 3; ?>%">
                        Overall Health
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Quick Links Section -->
          <div class="row">
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Quick Links</h4>
                  <div class="row">
                    <div class="col-md-3 col-sm-6 mb-3">
                      <a href="BirthRegistration.php" class="btn btn-outline-primary btn-block">
                        <i class="mdi mdi-plus-circle"></i>
                        New Birth Registration
                      </a>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                      <a href="DeathRegistration.php" class="btn btn-outline-danger btn-block">
                        <i class="mdi mdi-plus-circle"></i>
                        New Death Registration
                      </a>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                      <a href="PrintBirthCert.php" class="btn btn-outline-info btn-block">
                        <i class="mdi mdi-printer"></i>
                        Print Certificates
                      </a>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                      <a href="BirthReports.php" class="btn btn-outline-success btn-block">
                        <i class="mdi mdi-chart-bar"></i>
                        View Reports
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Original Graphical Reports Section -->
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="card">
                  <div class='card-header'>
                      <h2>Graphical reports</h2>
                  </div>
                <div class="card-body">
                  <div class="row d-none d-sm-flex mb-4">
                    <div class="col-3">
                      <h5 class="text-primary">Year</h5>
                      <p>
                          <?php
                        echo '<select class="form-control" id="year" name="year" data-component="date">';
                        for($year=1900; $year<=date('Y'); $year++){
                        echo '<option value="'.$year.'">'.$year.'</option>';
                        }
                        ?>
                        </select>
                      </p>
                    </div>
                    <div class="col-3">
                      <h5 class="text-primary">Region</h5>
                      <p>
                           <select name="state" id='region' class="form-control" >
                              
              <option value="Ahafo">Ahafo</option>
              <option value="Ashanti">Ashanti</option>
              <option value="Bono">Bono</option>
              <option value="Central">Central</option>
              <option value="Eastern">Eastern</option>
              
              <option value="Greater Accra">Greater Acrra</option>
              <option value="Northern">Northern</option>
              <option value="North East">North East</option>
              <option value="Oti">Oti</option>
              <option value="Savannah">Savannah</option>
              <option value="Upper East">Upper East</option>
              <option value="Upper West">Upper West</option>
              <option value="Volta">Volta</option>
              <option value="Western">Western</option>
              
              <option value="Western North">Western North</option>
              
              
            </select> 
                      </p>
                    </div>
                    <div class="col-3">
                      <h5 class="text-primary">Type</h5>
                      <p>
                           <select name="state" id="type" class="form-control" >
              <option value="birth">Births</option>
              <option value="death">Deaths</option>
              
              
              
            </select> 
            </div>
            
                           
                             
                    
                    <div class="col-3">
                      
                      <p>
                          <h5></h5>
                        <button type='button' id='query' class='btn btn-primary'>Query</button>    
                      </p>
                    </div>
                  </div>
                  <div class="chart-container" style="position: relative; height:400px; width:100%">
                    <canvas id="dashboard-area-chart"></canvas>
                  </div>
                </div>
                
                <div class='col-12'>
                    
                    <h4>Summary</h4>
                    
                    <span id='report_space'></span>
                    
                </div>
              </div>
            </div>
          </div> -->
         <?php
         
         if(isset($_SESSION['role'])){
             
             $role=$_SESSION['role'];
             
             if($role=='Super Administrator'){
                  include 'usr_ad.php';
//                 echo "<script type = \"text/javascript\">
//  alert('".$role."');
//   </script>"; 
             }
             
            
             
         }
         
         ?>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
       <?php include_once('footer.php');?>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    
    $('#query').on('click',function(){
       var year=$('#year').val();
       var region=$('#region').val();
       var type=$('#type').val();
       $.ajax({
           type: "POST",
           url: "chartquery.php",
           data: {year: year, region: region, type: type},
           success: function(result){
               var newww=JSON.stringify(result);
               var mymale = newww.substring(newww.indexOf(":") + 2, newww.lastIndexOf("\","));
               var myfemale = newww.substring(newww.indexOf("female\":\"") + 2, newww.lastIndexOf("\""));
               
               $('#report_space').html('<p>In '+year+' the above is a general '+ type+' statistics for both males and females in the '+region+ ' region. You can toggle through the dots to find out the number for each gender in a month</p>');
               
               var res = mymale.split(",");
               var res1 = myfemale.split(",");
               
               if ($('#dashboard-area-chart').length) {
                   var lineChartCanvas = $("#dashboard-area-chart").get(0).getContext("2d");
                   var data = {
                       labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                       datasets: [{
                           label: 'Males',
                           data: res,
                           backgroundColor: 'rgba(255, 83, 71, 0.4)',
                           borderColor: 'rgba(255, 83, 71, 1)',
                           borderWidth: 2,
                           fill: true
                       },
                       {
                           label: 'Females',
                           data: res1,
                           backgroundColor: 'rgba(255, 225, 0, 0.4)',
                           borderColor: 'rgba(255, 225, 0, 1)',
                           borderWidth: 2,
                           fill: true
                       }]
                   };
                   var options = {
                       responsive: true,
                       maintainAspectRatio: false,
                       scales: {
                           yAxes: [{
                               display: true,
                               ticks: {
                                   beginAtZero: true,
                                   precision: 0
                               },
                               scaleLabel: {
                                   display: true,
                                   labelString: 'Number of Registrations'
                               }
                           }],
                           xAxes: [{
                               display: true,
                               scaleLabel: {
                                   display: true,
                                   labelString: 'Month'
                               }
                           }]
                       },
                       legend: {
                           display: true,
                           position: 'top'
                       },
                       elements: {
                           point: {
                               radius: 4,
                               hoverRadius: 6
                           },
                           line: {
                               tension: 0.3
                           }
                       },
                       layout: {
                           padding: {
                               left: 10,
                               right: 10,
                               top: 10,
                               bottom: 10
                           }
                       },
                       tooltips: {
                           mode: 'index',
                           intersect: false
                       },
                       hover: {
                           mode: 'nearest',
                           intersect: true
                       }
                   };
                   
                   // Destroy existing chart if it exists
                   if(window.lineChart) {
                       window.lineChart.destroy();
                   }
                   
                   // Create new chart
                   window.lineChart = new Chart(lineChartCanvas, {
                       type: 'line',
                       data: data,
                       options: options
                   });
               }
           }
       });
    });
    
</script>
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
  <script>
// Regional Distribution Chart
document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('regionalChart').getContext('2d');
    
    // Fetch regional data
    fetch('chartquery.php?type=regional')
        .then(response => response.json())
        .then(data => {
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: data.labels,
                    datasets: [{
                        data: data.values,
                        backgroundColor: [
                            '#FF6384',
                            '#36A2EB',
                            '#FFCE56',
                            '#4BC0C0',
                            '#9966FF',
                            '#FF9F40'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                        position: 'right'
                    },
                    title: {
                        display: true,
                        text: 'Registrations by Region'
                    }
                }
            });
        });
});
</script>
</body>

</html>