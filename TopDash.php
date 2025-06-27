<div class="row">
            
              <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
              <div class="card card-statistics">
              <a href="BirthRegistration.php">    <div class="card-body">
                  <div class="clearfix">
                    <div class="float-left">
                    <i class="mdi mdi-poll-box text-success icon-lg"></i>
                    </div>
                    <div class="float-right">
                      <p class="mb-0 text-right"> Birth Registrations</p>
                      <div class="fluid-container">
                        <h3 class="font-weight-medium text-right mb-0">     

                    <?php
              $result = mysqli_query($con,"SELECT * FROM tblbirth") or die(mysqli_error());
              $row = mysqli_fetch_array($result);
              $numberOfRows = mysqli_num_rows($result);	
              echo $numberOfRows;
                      ?>

                        </h3>
                      </div>
                    </div>
                  </div>
                  <p class="text-muted mt-3 mb-0">
                    <i class="mdi mdi-alert-octagon mr-1" aria-hidden="true"></i> All Birth Registration
                  </p>
                </div>
              </div>
            </div></a>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
              <div class="card card-statistics">
              <a href="DeathRegistration.php">
                <div class="card-body">
                  <div class="clearfix">
                    <div class="float-left">
                    <i class="mdi mdi-poll-box text-success icon-lg"></i>                 
                     </div>
                    <div class="float-right">
                      <p class="mb-0 text-right"> Death Registrations</p>
                      <div class="fluid-container">
                        <h3 class="font-weight-medium text-right mb-0">


                        <?php
              $result = mysqli_query($con,"SELECT * FROM tbldeath") or die(mysqli_error());
              $row = mysqli_fetch_array($result);
              $numberOfRows = mysqli_num_rows($result);	
              echo $numberOfRows;
                      ?>

                        </h3>
                      </div>
                    </div>
                  </div>
                  <p class="text-muted mt-3 mb-0">
                    <i class="mdi mdi-bookmark-outline mr-1" aria-hidden="true"></i> All Death Registrations
                  </p>
                </div>
              </div>
            </div></a>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
              <div class="card card-statistics">
              <a href="CentreRegistration.php">
                <div class="card-body">
                  <div class="clearfix">
                    <div class="float-left">
                    <i class="mdi mdi-cube text-danger icon-lg"></i>
                    </div>
                    <div class="float-right">
                      <p class="mb-0 text-right">Centres</p>
                      <div class="fluid-container">
                        <h3 class="font-weight-medium text-right mb-0">


                        <?php
              $result = mysqli_query($con,"SELECT * FROM tblcentre") or die(mysqli_error());
              $row = mysqli_fetch_array($result);
              $numberOfRows = mysqli_num_rows($result);	
              echo $numberOfRows;
                      ?>

                        </h3>
                      </div>
                    </div>
                  </div>
                  <p class="text-muted mt-3 mb-0">
                    <i class="mdi mdi-calendar mr-1" aria-hidden="true"></i> All Available Centre
                  </p>
                </div>
              </div>
            </div></a>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
              <div class="card card-statistics">
              <a href="UsersRegistration.php">
                <div class="card-body">
                  <div class="clearfix">
                    <div class="float-left">
                      <i class="mdi mdi-account-location text-info icon-lg"></i>
                    </div>
                    <div class="float-right">
                      <p class="mb-0 text-right">System Users</p>
                      <div class="fluid-container">
                        <h3 class="font-weight-medium text-right mb-0">

                        <?php
              $result = mysqli_query($con,"SELECT * FROM tbladmin") or die(mysqli_error());
              $row = mysqli_fetch_array($result);
              $numberOfRows = mysqli_num_rows($result);	
              echo $numberOfRows;
                      ?>

                        </h3>
                      </div>
                    </div>
                  </div>
                  <p class="text-muted mt-3 mb-0">
                    <i class="mdi mdi-reload mr-1" aria-hidden="true"></i> All System Users
                  </p>
                </div>
              </div>
            </div></a>
          </div>

          <!-- Welcome Message -->
          <div class="row mb-4">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <h2 class="card-title">Welcome, <?php echo $_SESSION['name']; ?>!</h2>
                  <p class="text-muted">Here's what's happening in your Birth and Death Registration System today.</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Quick Action Buttons -->
          <div class="row mb-4">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Quick Actions</h4>
                  <div class="row">
                    <div class="col-md-3 col-sm-6 mb-3">
                      <a href="BirthRegistration.php" class="btn btn-primary btn-block">
                        <i class="mdi mdi-plus-circle"></i> New Birth Registration
                      </a>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                      <a href="DeathRegistration.php" class="btn btn-danger btn-block">
                        <i class="mdi mdi-plus-circle"></i> New Death Registration
                      </a>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                      <a href="PrintBirthCert.php" class="btn btn-info btn-block">
                        <i class="mdi mdi-printer"></i> Print Certificates
                      </a>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                      <a href="BirthReports.php" class="btn btn-success btn-block">
                        <i class="mdi mdi-chart-bar"></i> View Reports
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Quick Stats Section -->
          <div class="row mb-4">
            <div class="col-md-6">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Today's Statistics</h4>
                  <?php
                  $today = date('Y-m-d');
                  $birth_today = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tblbirth WHERE DATE(dateReg) = '$today'"));
                  $death_today = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbldeath WHERE DATE(dateReg) = '$today'"));
                  $cert_today = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tblbirth WHERE DATE(dateReg) = '$today' AND payId = 1")) + 
                               mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbldeath WHERE DATE(dateReg) = '$today' AND payId = 1"));
                  ?>
                  <div class="row">
                    <div class="col-4">
                      <div class="text-center">
                        <h3 class="text-primary"><?php echo $birth_today; ?></h3>
                        <p class="text-muted">Births Today</p>
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="text-center">
                        <h3 class="text-danger"><?php echo $death_today; ?></h3>
                        <p class="text-muted">Deaths Today</p>
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="text-center">
                        <h3 class="text-success"><?php echo $cert_today; ?></h3>
                        <p class="text-muted">Certificates Today</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">System Status</h4>
                  <?php
                  $total_centers = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tblcentre"));
                  $active_centers = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tblcentre WHERE status = 'Active'"));
                  $total_users = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbladmin"));
                  $active_users = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbladmin WHERE status = 'Active'"));
                  ?>
                  <div class="row">
                    <div class="col-6">
                      <div class="mb-3">
                        <p class="mb-1">Registration Centers</p>
                        <div class="progress">
                          <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo ($active_centers/$total_centers)*100; ?>%">
                            <?php echo $active_centers; ?>/<?php echo $total_centers; ?> Active
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="mb-3">
                        <p class="mb-1">System Users</p>
                        <div class="progress">
                          <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo ($active_users/$total_users)*100; ?>%">
                            <?php echo $active_users; ?>/<?php echo $total_users; ?> Active
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Recent Activity Section -->
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Recent Activity</h4>
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>Date</th>
                          <th>Type</th>
                          <th>Name</th>
                          <th>Center</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $query = "SELECT 'Birth' as type, firstName, lastName, regCentre, dateReg, payId 
                                FROM tblbirth 
                                UNION ALL 
                                SELECT 'Death' as type, firstName, lastName, regCentre, dateReg, payId 
                                FROM tbldeath 
                                ORDER BY dateReg DESC LIMIT 5";
                        $result = mysqli_query($con, $query);
                        while($row = mysqli_fetch_array($result)) {
                          $status = $row['payId'] == 1 ? 'Paid' : 'Pending';
                          $status_class = $row['payId'] == 1 ? 'success' : 'warning';
                          echo "<tr>
                                  <td>".date('d M Y', strtotime($row['dateReg']))."</td>
                                  <td>".$row['type']."</td>
                                  <td>".$row['firstName']." ".$row['lastName']."</td>
                                  <td>".$row['regCentre']."</td>
                                  <td><span class='badge badge-".$status_class."'>".$status."</span></td>
                                </tr>";
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>