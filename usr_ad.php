 <div class="row">
            <div class="col-lg-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">SYSTEM USERS</h4>
                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>S/N</th>
                          <th>USERNAME </th>
                          <th>PASSWORD </th>
                          <th>ROLE</th>
                          <th>CENTRE</th>
                          <th>DATE REGISTERED </th>
                          <th>ACTION </th>
                        </tr>
                      </thead>
                      <tbody>

                      <?php
		      $query = $con->query("SELECT * FROM tbladmin LIMIT 5") or die(mysqli_error());
          $count = mysqli_num_rows($query);
          while ($row = mysqli_fetch_array($query)) 
         
            {

              $querys = $con->query("SELECT * FROM tblcentre where centreId =".$row['RegCentre']."") or die(mysqli_error());
              $counts = mysqli_num_rows($querys);
              while ($rows = mysqli_fetch_array($querys))
            {
             
                            ?>



                        <tr>
                          <td class="font-weight-medium"> <?php echo $row['email'];?></td>
                          <td><?php echo $row['username'];?></td>
                          <td><?php echo '*****';?> </td>
                          <td><?php echo $row['role'];?> </td>
                          <td class="text-success"> <?php echo $rows['centreName'];?><i class="mdi mdi-arrow-down"></i> </td>
                          <td>
                          <?php echo $row['dateReg'];?></td>
                          <td><a href="editUsersRegistration.php?id=<?php echo $row['adminId'];?>">Edit</a></td>
                        </tr>
                        <tr>
                        <?php  
                }
              }
                              ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>