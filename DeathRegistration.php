<?php
session_start();
error_reporting(E_ALL);
include('dbcon.php');


if (!isset($_SESSION['email']))
{

  echo "<script type = \"text/javascript\">
  window.location = (\"index.php\");
  </script>";

}

if (isset($_SESSION['RegCentre']))
{

$querys = mysqli_query($con,"select  * from tblcentre where centreId =".$_SESSION['RegCentre']."") or die(mysqli_error());
$rows = mysqli_fetch_array($querys);
$regCentre = $rows['centreName'];

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
  
  <!-- Add jQuery and Select2 -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  
  <style>
/* Modern Form Design */
.card {
    border: none;
    box-shadow: 0 0 20px rgba(0,0,0,0.08);
    border-radius: 15px;
    margin-bottom: 30px;
}

.card-body {
    padding: 2rem;
}

.card-title {
    color: #2c3e50;
    font-size: 1.75rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #e9ecef;
    display: flex;
    align-items: center;
    gap: 10px;
}

.card-title i {
    color: #4a90e2;
}

/* Modern Form Styles */
.form-section {
    background: #fff;
    border-radius: 10px;
    padding: 25px;
    margin-bottom: 25px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    border: 1px solid #e9ecef;
}

.section-title {
    color: #2c3e50;
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 25px;
    padding-bottom: 12px;
    border-bottom: 2px solid #e9ecef;
    display: flex;
    align-items: center;
    gap: 10px;
}

.section-title i {
    color: #4a90e2;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    color: #2c3e50;
    font-weight: 500;
    font-size: 0.95rem;
}

.form-control {
    width: 100%;
    min-height: 45px;
    padding: 10px 15px;
    border: 2px solid #e9ecef;
    border-radius: 6px;
    transition: all 0.3s ease;
    font-size: 0.95rem;
}

textarea.form-control {
    min-height: 100px;
    resize: vertical;
}

select.form-control {
    height: 45px;
    padding-right: 35px;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%232c3e50' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    appearance: none;
}

/* Grid Layout */
.row {
    margin: -10px;
}

.col-md-6 {
    padding: 10px;
}

/* Form Buttons */
.form-buttons {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    margin-top: 30px;
    padding-top: 25px;
    border-top: 1px solid #e9ecef;
}

.btn {
    padding: 12px 24px;
    border-radius: 6px;
    font-weight: 500;
    font-size: 0.95rem;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    min-height: 45px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .form-section {
        padding: 20px;
    }
    
    .form-buttons {
        flex-direction: column;
    }
    
    .btn {
        width: 100%;
        justify-content: center;
    }
    
    .col-md-6 {
        width: 100%;
    }
}

/* Form Validation Styles */
.form-control.is-invalid {
    border-color: #dc3545;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%23dc3545' viewBox='0 0 16 16'%3E%3Cpath d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z'/%3E%3Cpath d='M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 1rem center;
    padding-right: 2.5rem;
}

.invalid-feedback {
    display: none;
    color: #dc3545;
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

.form-control.is-invalid + .invalid-feedback {
    display: block;
}

/* Add these styles in the existing style section */
.document-upload {
    border: 2px dashed #e9ecef;
    border-radius: 8px;
    padding: 20px;
    text-align: center;
    background: #f8f9fa;
    transition: all 0.3s ease;
}

.document-upload:hover {
    border-color: #4a90e2;
    background: #f0f7ff;
}

.document-upload i {
    font-size: 2rem;
    color: #4a90e2;
    margin-bottom: 10px;
}

.document-upload p {
    color: #6c757d;
    margin-bottom: 15px;
}

.document-list {
    margin-top: 20px;
}

.document-item {
    display: flex;
    align-items: center;
    padding: 15px;
    background: #fff;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    margin-bottom: 15px;
    position: relative;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.document-item.uploading {
    background: #f8f9fa;
}

.document-item.uploaded {
    border-left: 4px solid #28a745;
}

.document-preview {
    width: 60px;
    height: 60px;
    margin-right: 15px;
    border-radius: 4px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
}

.document-preview img {
    max-width: 100%;
    max-height: 100%;
    object-fit: cover;
}

.document-preview .file-icon {
    font-size: 2rem;
    color: #6c757d;
}

.document-preview .file-icon.pdf {
    color: #dc3545;
}

.document-preview .file-icon.word {
    color: #007bff;
}

.document-preview .file-icon.image {
    color: #28a745;
}

.document-info {
    flex-grow: 1;
    margin-right: 15px;
}

.document-name {
    font-weight: 500;
    margin-bottom: 4px;
    word-break: break-all;
}

.document-size {
    font-size: 0.8rem;
    color: #6c757d;
}

.document-actions {
    display: flex;
    align-items: center;
    gap: 10px;
}

.remove-file {
    color: #dc3545;
    cursor: pointer;
    padding: 8px;
    border-radius: 4px;
    transition: all 0.2s;
}

.remove-file:hover {
    background: #fff5f5;
}

.upload-status-indicator {
    font-size: 0.8rem;
    display: flex;
    align-items: center;
    gap: 5px;
}

.upload-status-indicator.uploading {
    color: #007bff;
}

.upload-status-indicator.uploaded {
    color: #28a745;
}

.upload-status-indicator.error {
    color: #dc3545;
}

.progress {
    background-color: #e9ecef;
    border-radius: 4px;
    margin: 5px 0;
}

.progress-bar {
    background-color: #007bff;
    transition: width 0.3s ease;
}

.document-item i {
    color: #4a90e2;
    margin-right: 10px;
}

.document-item .file-name {
    flex-grow: 1;
    margin-right: 10px;
    font-size: 0.9rem;
}

.document-item .remove-file {
    color: #dc3545;
    cursor: pointer;
    padding: 5px;
}

.document-item .remove-file:hover {
    color: #bd2130;
}

.file-type-hint {
    font-size: 0.8rem;
    color: #6c757d;
    margin-top: 5px;
}

/* Add these styles to your existing styles */
.biometric-section {
    background: #fff;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.biometric-upload {
    border: 2px dashed #e9ecef;
    border-radius: 8px;
    padding: 30px;
    text-align: center;
    background: #f8f9fa;
    transition: all 0.3s ease;
    cursor: pointer;
    position: relative;
}

.biometric-upload:hover {
    border-color: #4a90e2;
    background: #f0f7ff;
}

.biometric-upload.dragover {
    border-color: #28a745;
    background: #f0fff4;
}

.biometric-upload input[type="file"] {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    opacity: 0;
    cursor: pointer;
}

.biometric-icon {
    font-size: 3rem;
    color: #4a90e2;
    margin-bottom: 15px;
}

.biometric-text {
    margin-bottom: 15px;
}

.biometric-text h5 {
    color: #2c3e50;
    margin-bottom: 8px;
    font-weight: 500;
}

.biometric-text p {
    color: #6c757d;
    font-size: 0.9rem;
    margin-bottom: 0;
}

.biometric-preview {
    margin-top: 20px;
    display: none;
}

.biometric-preview.active {
    display: block;
}

.preview-container {
    position: relative;
    width: 200px;
    height: 200px;
    margin: 0 auto;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.preview-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.preview-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.preview-container:hover .preview-overlay {
    opacity: 1;
}

.preview-actions {
    display: flex;
    gap: 10px;
}

.preview-actions button {
    background: #fff;
    border: none;
    border-radius: 50%;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
}

.preview-actions button:hover {
    transform: scale(1.1);
}

.preview-actions .view-btn {
    color: #4a90e2;
}

.preview-actions .remove-btn {
    color: #dc3545;
}

.biometric-requirements {
    margin-top: 15px;
    padding: 15px;
    background: #fff3cd;
    border: 1px solid #ffeeba;
    border-radius: 6px;
}

.biometric-requirements h6 {
    color: #856404;
    margin-bottom: 8px;
    font-weight: 500;
}

.biometric-requirements ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.biometric-requirements li {
    color: #856404;
    font-size: 0.85rem;
    margin-bottom: 4px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.biometric-requirements li i {
    font-size: 0.8rem;
}

.upload-progress {
    margin-top: 15px;
    display: none;
}

.upload-progress.active {
    display: block;
}

.progress {
    height: 6px;
    background-color: #e9ecef;
    border-radius: 3px;
    overflow: hidden;
}

.progress-bar {
    background-color: #4a90e2;
    transition: width 0.3s ease;
}

.upload-status {
    font-size: 0.85rem;
    color: #6c757d;
    margin-top: 5px;
    text-align: center;
}
</style>

<!-- Add Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<script>
function validateDeathDate(input) {
    const today = new Date();
    const selectedDate = new Date(input.value);
    if (selectedDate > today) {
        alert("Date of death cannot be in the future");
        input.value = '';
    }
}

function validateAge(input) {
    const age = parseInt(input.value);
    if (age < 0 || age > 120) {
        alert("Please enter a valid age between 0 and 120");
        input.value = '';
    }
}
</script>
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
            <!-- <div class="col-12">
              <span class="d-block d-md-flex align-items-center">
                <p>Like what you see? Check out our premium version for more.</p>
                <a class="btn ml-auto download-button d-none d-md-block" href="https://github.com/BootstrapDash/StarAdmin-Free-Bootstrap-Admin-Template" target="_blank">Download Free Version</a>
                <a class="btn purchase-button mt-4 mt-md-0" href="https://www.bootstrapdash.com/product/star-admin-pro/" target="_blank">Upgrade To Pro</a>
                <i class="mdi mdi-close popup-dismiss d-none d-md-block"></i>
              </span>
            </div> -->
          </div>
          

          <?php include_once 'TopDash.php';?>



          <div class="row">
            <div class="col-lg-7 grid-margin stretch-card">
              <!--weather card-->
              <!-- <div class="card card-weather">
                <div class="card-body">
                  <div class="weather-date-location">
                    <h3>Monday</h3>
                    <p class="text-gray">
                      <span class="weather-date">25 October, 2016</span>
                      <span class="weather-location">London, UK</span>
                    </p>
                  </div>
                  <div class="weather-data d-flex">
                    <div class="mr-auto">
                      <h4 class="display-3">21
                        <span class="symbol">&deg;</span>C</h4>
                      <p>
                        Mostly Cloudy
                      </p>
                    </div>
                  </div>
                </div>
                <div class="card-body p-0">
                  <div class="d-flex weakly-weather">
                    <div class="weakly-weather-item">
                      <p class="mb-0">
                        Sun
                      </p>
                      <i class="mdi mdi-weather-cloudy"></i>
                      <p class="mb-0">
                        30°
                      </p>
                    </div>
                    <div class="weakly-weather-item">
                      <p class="mb-1">
                        Mon
                      </p>
                      <i class="mdi mdi-weather-hail"></i>
                      <p class="mb-0">
                        31°
                      </p>
                    </div>
                    <div class="weakly-weather-item">
                      <p class="mb-1">
                        Tue
                      </p>
                      <i class="mdi mdi-weather-partlycloudy"></i>
                      <p class="mb-0">
                        28°
                      </p>
                    </div>
                    <div class="weakly-weather-item">
                      <p class="mb-1">
                        Wed
                      </p>
                      <i class="mdi mdi-weather-pouring"></i>
                      <p class="mb-0">
                        30°
                      </p>
                    </div>
                    <div class="weakly-weather-item">
                      <p class="mb-1">
                        Thu
                      </p>
                      <i class="mdi mdi-weather-pouring"></i>
                      <p class="mb-0">
                        29°
                      </p>
                    </div>
                    <div class="weakly-weather-item">
                      <p class="mb-1">
                        Fri
                      </p>
                      <i class="mdi mdi-weather-snowy-rainy"></i>
                      <p class="mb-0">
                        31°
                      </p>
                    </div>
                    <div class="weakly-weather-item">
                      <p class="mb-1">
                        Sat
                      </p>
                      <i class="mdi mdi-weather-snowy"></i>
                      <p class="mb-0">
                        32°
                      </p>
                    </div>
                  </div>
                </div>
              </div> -->
              <!--weather card ends-->
            </div>
            <!-- <div class="col-lg-5 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h2 class="card-title text-primary mb-5">Performance History</h2>
                  <div class="wrapper d-flex justify-content-between">
                    <div class="side-left">
                      <p class="mb-2">The best performance</p>
                      <p class="display-3 mb-4 font-weight-light">+45.2%</p>
                    </div>
                    <div class="side-right">
                      <small class="text-muted">2017</small>
                    </div>
                  </div>
                  <div class="wrapper d-flex justify-content-between">
                    <div class="side-left">
                      <p class="mb-2">Worst performance</p>
                      <p class="display-3 mb-5 font-weight-light">-35.3%</p>
                    </div>
                    <div class="side-right">
                      <small class="text-muted">2015</small>
                    </div>
                  </div>
                  <div class="wrapper">
                    <div class="d-flex justify-content-between">
                      <p class="mb-2">Sales</p>
                      <p class="mb-2 text-primary">88%</p>
                    </div>
                    <div class="progress">
                      <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" role="progressbar" style="width: 88%" aria-valuenow="88"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                  <div class="wrapper mt-4">
                    <div class="d-flex justify-content-between">
                      <p class="mb-2">Visits</p>
                      <p class="mb-2 text-success">56%</p>
                    </div>
                    <div class="progress">
                      <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" style="width: 56%" aria-valuenow="56"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div> -->
          </div>
          <!-- <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <div class="row d-none d-sm-flex mb-4">
                    <div class="col-4">
                      <h5 class="text-primary">Unique Visitors</h5>
                      <p>34657</p>
                    </div>
                    <div class="col-4">
                      <h5 class="text-primary">Bounce Rate</h5>
                      <p>45673</p>
                    </div>
                    <div class="col-4">
                      <h5 class="text-primary">Active session</h5>
                      <p>45673</p>
                    </div>
                  </div>
                  <div class="chart-container">
                    <canvas id="dashboard-area-chart" height="80"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div> -->
          <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">
                      <i class="fas fa-file-medical"></i>
                      Death Registration Form
                  </h4>
                  
                  <form class="form-sample" method="post" action="DeathRegistration.php" id="deathRegistrationForm">
                      <!-- Deceased Information -->
                      <div class="form-section">
                          <h5 class="section-title">
                              <i class="fas fa-user"></i>
                              Deceased Information
                          </h5>
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label class="required-field">First Name</label>
                                      <input type="text" class="form-control text-only" name="firstName" required>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label class="required-field">Last Name</label>
                                      <input type="text" class="form-control text-only" name="lastName" required>
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label class="required-field">Date of Birth</label>
                                      <input type="date" class="form-control" name="dateOfBirth" required>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label class="required-field">Date of Death</label>
                                      <input type="date" class="form-control" name="dateOfDeath" required>
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label class="required-field">Gender</label>
                                      <select class="form-control" name="gender" required>
                                          <option value="">Select Gender</option>
                                          <option value="Male">Male</option>
                                          <option value="Female">Female</option>
                                          <option value="Other">Other</option>
                                      </select>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="nationality">Nationality <span class="text-danger">*</span></label>
                                      <select class="form-control select2" id="nationality" name="nationality" required>
                                          <option value="">Select Nationality</option>
                                          <option value="Filipino">Filipino</option>
                                          <option value="Afghan">Afghan</option>
                                          <option value="Albanian">Albanian</option>
                                          <option value="Algerian">Algerian</option>
                                          <option value="American">American</option>
                                          <option value="Andorran">Andorran</option>
                                          <option value="Angolan">Angolan</option>
                                          <option value="Antiguan">Antiguan</option>
                                          <option value="Argentine">Argentine</option>
                                          <option value="Armenian">Armenian</option>
                                          <option value="Australian">Australian</option>
                                          <option value="Austrian">Austrian</option>
                                          <option value="Azerbaijani">Azerbaijani</option>
                                          <option value="Bahamian">Bahamian</option>
                                          <option value="Bahraini">Bahraini</option>
                                          <option value="Bangladeshi">Bangladeshi</option>
                                          <option value="Barbadian">Barbadian</option>
                                          <option value="Belarusian">Belarusian</option>
                                          <option value="Belgian">Belgian</option>
                                          <option value="Belizean">Belizean</option>
                                          <option value="Beninese">Beninese</option>
                                          <option value="Bhutanese">Bhutanese</option>
                                          <option value="Bolivian">Bolivian</option>
                                          <option value="Bosnian">Bosnian</option>
                                          <option value="Botswanan">Botswanan</option>
                                          <option value="Brazilian">Brazilian</option>
                                          <option value="British">British</option>
                                          <option value="Bruneian">Bruneian</option>
                                          <option value="Bulgarian">Bulgarian</option>
                                          <option value="Burkinabe">Burkinabe</option>
                                          <option value="Burmese">Burmese</option>
                                          <option value="Burundian">Burundian</option>
                                          <option value="Cambodian">Cambodian</option>
                                          <option value="Cameroonian">Cameroonian</option>
                                          <option value="Canadian">Canadian</option>
                                          <option value="Cape Verdean">Cape Verdean</option>
                                          <option value="Central African">Central African</option>
                                          <option value="Chadian">Chadian</option>
                                          <option value="Chilean">Chilean</option>
                                          <option value="Chinese">Chinese</option>
                                          <option value="Colombian">Colombian</option>
                                          <option value="Comorian">Comorian</option>
                                          <option value="Congolese">Congolese</option>
                                          <option value="Costa Rican">Costa Rican</option>
                                          <option value="Croatian">Croatian</option>
                                          <option value="Cuban">Cuban</option>
                                          <option value="Cypriot">Cypriot</option>
                                          <option value="Czech">Czech</option>
                                          <option value="Danish">Danish</option>
                                          <option value="Djibouti">Djibouti</option>
                                          <option value="Dominican">Dominican</option>
                                          <option value="Dutch">Dutch</option>
                                          <option value="East Timorese">East Timorese</option>
                                          <option value="Ecuadorean">Ecuadorean</option>
                                          <option value="Egyptian">Egyptian</option>
                                          <option value="Emirian">Emirian</option>
                                          <option value="Equatorial Guinean">Equatorial Guinean</option>
                                          <option value="Eritrean">Eritrean</option>
                                          <option value="Estonian">Estonian</option>
                                          <option value="Ethiopian">Ethiopian</option>
                                          <option value="Fijian">Fijian</option>
                                          <option value="Finnish">Finnish</option>
                                          <option value="French">French</option>
                                          <option value="Gabonese">Gabonese</option>
                                          <option value="Gambian">Gambian</option>
                                          <option value="Georgian">Georgian</option>
                                          <option value="German">German</option>
                                          <option value="Ghanaian">Ghanaian</option>
                                          <option value="Greek">Greek</option>
                                          <option value="Grenadian">Grenadian</option>
                                          <option value="Guatemalan">Guatemalan</option>
                                          <option value="Guinea-Bissauan">Guinea-Bissauan</option>
                                          <option value="Guinean">Guinean</option>
                                          <option value="Guyanese">Guyanese</option>
                                          <option value="Haitian">Haitian</option>
                                          <option value="Herzegovinian">Herzegovinian</option>
                                          <option value="Honduran">Honduran</option>
                                          <option value="Hungarian">Hungarian</option>
                                          <option value="Icelander">Icelander</option>
                                          <option value="Indian">Indian</option>
                                          <option value="Indonesian">Indonesian</option>
                                          <option value="Iranian">Iranian</option>
                                          <option value="Iraqi">Iraqi</option>
                                          <option value="Irish">Irish</option>
                                          <option value="Israeli">Israeli</option>
                                          <option value="Italian">Italian</option>
                                          <option value="Ivorian">Ivorian</option>
                                          <option value="Jamaican">Jamaican</option>
                                          <option value="Japanese">Japanese</option>
                                          <option value="Jordanian">Jordanian</option>
                                          <option value="Kazakhstani">Kazakhstani</option>
                                          <option value="Kenyan">Kenyan</option>
                                          <option value="Kittian and Nevisian">Kittian and Nevisian</option>
                                          <option value="Kuwaiti">Kuwaiti</option>
                                          <option value="Kyrgyz">Kyrgyz</option>
                                          <option value="Laotian">Laotian</option>
                                          <option value="Latvian">Latvian</option>
                                          <option value="Lebanese">Lebanese</option>
                                          <option value="Liberian">Liberian</option>
                                          <option value="Libyan">Libyan</option>
                                          <option value="Liechtensteiner">Liechtensteiner</option>
                                          <option value="Lithuanian">Lithuanian</option>
                                          <option value="Luxembourger">Luxembourger</option>
                                          <option value="Macedonian">Macedonian</option>
                                          <option value="Malagasy">Malagasy</option>
                                          <option value="Malawian">Malawian</option>
                                          <option value="Malaysian">Malaysian</option>
                                          <option value="Maldivan">Maldivan</option>
                                          <option value="Malian">Malian</option>
                                          <option value="Maltese">Maltese</option>
                                          <option value="Marshallese">Marshallese</option>
                                          <option value="Mauritanian">Mauritanian</option>
                                          <option value="Mauritian">Mauritian</option>
                                          <option value="Mexican">Mexican</option>
                                          <option value="Micronesian">Micronesian</option>
                                          <option value="Moldovan">Moldovan</option>
                                          <option value="Monacan">Monacan</option>
                                          <option value="Mongolian">Mongolian</option>
                                          <option value="Moroccan">Moroccan</option>
                                          <option value="Mosotho">Mosotho</option>
                                          <option value="Motswana">Motswana</option>
                                          <option value="Mozambican">Mozambican</option>
                                          <option value="Namibian">Namibian</option>
                                          <option value="Nauruan">Nauruan</option>
                                          <option value="Nepalese">Nepalese</option>
                                          <option value="New Zealander">New Zealander</option>
                                          <option value="Nicaraguan">Nicaraguan</option>
                                          <option value="Nigerian">Nigerian</option>
                                          <option value="Nigerien">Nigerien</option>
                                          <option value="North Korean">North Korean</option>
                                          <option value="Northern Irish">Northern Irish</option>
                                          <option value="Norwegian">Norwegian</option>
                                          <option value="Omani">Omani</option>
                                          <option value="Pakistani">Pakistani</option>
                                          <option value="Palauan">Palauan</option>
                                          <option value="Panamanian">Panamanian</option>
                                          <option value="Papua New Guinean">Papua New Guinean</option>
                                          <option value="Paraguayan">Paraguayan</option>
                                          <option value="Peruvian">Peruvian</option>
                                          <option value="Polish">Polish</option>
                                          <option value="Portuguese">Portuguese</option>
                                          <option value="Qatari">Qatari</option>
                                          <option value="Romanian">Romanian</option>
                                          <option value="Russian">Russian</option>
                                          <option value="Rwandan">Rwandan</option>
                                          <option value="Saint Lucian">Saint Lucian</option>
                                          <option value="Salvadoran">Salvadoran</option>
                                          <option value="Samoan">Samoan</option>
                                          <option value="San Marinese">San Marinese</option>
                                          <option value="Sao Tomean">Sao Tomean</option>
                                          <option value="Saudi">Saudi</option>
                                          <option value="Scottish">Scottish</option>
                                          <option value="Senegalese">Senegalese</option>
                                          <option value="Serbian">Serbian</option>
                                          <option value="Seychellois">Seychellois</option>
                                          <option value="Sierra Leonean">Sierra Leonean</option>
                                          <option value="Singaporean">Singaporean</option>
                                          <option value="Slovakian">Slovakian</option>
                                          <option value="Slovenian">Slovenian</option>
                                          <option value="Solomon Islander">Solomon Islander</option>
                                          <option value="Somali">Somali</option>
                                          <option value="South African">South African</option>
                                          <option value="South Korean">South Korean</option>
                                          <option value="Spanish">Spanish</option>
                                          <option value="Sri Lankan">Sri Lankan</option>
                                          <option value="Sudanese">Sudanese</option>
                                          <option value="Surinamer">Surinamer</option>
                                          <option value="Swazi">Swazi</option>
                                          <option value="Swedish">Swedish</option>
                                          <option value="Swiss">Swiss</option>
                                          <option value="Syrian">Syrian</option>
                                          <option value="Taiwanese">Taiwanese</option>
                                          <option value="Tajik">Tajik</option>
                                          <option value="Tanzanian">Tanzanian</option>
                                          <option value="Thai">Thai</option>
                                          <option value="Togolese">Togolese</option>
                                          <option value="Tongan">Tongan</option>
                                          <option value="Trinidadian or Tobagonian">Trinidadian or Tobagonian</option>
                                          <option value="Tunisian">Tunisian</option>
                                          <option value="Turkish">Turkish</option>
                                          <option value="Tuvaluan">Tuvaluan</option>
                                          <option value="Ugandan">Ugandan</option>
                                          <option value="Ukrainian">Ukrainian</option>
                                          <option value="Uruguayan">Uruguayan</option>
                                          <option value="Uzbekistani">Uzbekistani</option>
                                          <option value="Venezuelan">Venezuelan</option>
                                          <option value="Vietnamese">Vietnamese</option>
                                          <option value="Welsh">Welsh</option>
                                          <option value="Yemenite">Yemenite</option>
                                          <option value="Zambian">Zambian</option>
                                          <option value="Zimbabwean">Zimbabwean</option>
                                      </select>
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label class="required-field">Place of Birth</label>
                                      <input type="text" class="form-control" name="placeOfBirth" required>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label class="required-field">Marital Status</label>
                                      <select class="form-control" name="maritalStatus" required>
                                          <option value="">Select Status</option>
                                          <option value="Single">Single</option>
                                          <option value="Married">Married</option>
                                          <option value="Widowed">Widowed</option>
                                          <option value="Divorced">Divorced</option>
                                          <option value="Separated">Separated</option>
                                      </select>
                                  </div>
                              </div>
                          </div>
                      </div>

                      <!-- Add this section after the Deceased Information section and before the Death Location section -->
                      <div class="form-section">
                          <h5 class="section-title">
                              <i class="fas fa-users"></i>
                              Parents Information
                          </h5>
                          <div class="row">
                              <!-- Father's Information -->
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label class="required-field">Father's Name</label>
                                      <input type="text" class="form-control text-only" name="fatherName" required>
                                  </div>
                                  <div class="form-group">
                                      <label class="required-field">Father's Nationality</label>
                                      <select class="form-control select2" name="fatherNationality" required>
                                          <option value="">Select Nationality</option>
                                          <option value="Filipino">Filipino</option>
                                          <option value="Afghan">Afghan</option>
                                          <option value="Albanian">Albanian</option>
                                          <option value="Algerian">Algerian</option>
                                          <option value="American">American</option>
                                          <option value="Andorran">Andorran</option>
                                          <option value="Angolan">Angolan</option>
                                          <option value="Antiguan">Antiguan</option>
                                          <option value="Argentine">Argentine</option>
                                          <option value="Armenian">Armenian</option>
                                          <option value="Australian">Australian</option>
                                          <option value="Austrian">Austrian</option>
                                          <option value="Azerbaijani">Azerbaijani</option>
                                          <option value="Bahamian">Bahamian</option>
                                          <option value="Bahraini">Bahraini</option>
                                          <option value="Bangladeshi">Bangladeshi</option>
                                          <option value="Barbadian">Barbadian</option>
                                          <option value="Belarusian">Belarusian</option>
                                          <option value="Belgian">Belgian</option>
                                          <option value="Belizean">Belizean</option>
                                          <option value="Beninese">Beninese</option>
                                          <option value="Bhutanese">Bhutanese</option>
                                          <option value="Bolivian">Bolivian</option>
                                          <option value="Bosnian">Bosnian</option>
                                          <option value="Botswanan">Botswanan</option>
                                          <option value="Brazilian">Brazilian</option>
                                          <option value="British">British</option>
                                          <option value="Bruneian">Bruneian</option>
                                          <option value="Bulgarian">Bulgarian</option>
                                          <option value="Burkinabe">Burkinabe</option>
                                          <option value="Burmese">Burmese</option>
                                          <option value="Burundian">Burundian</option>
                                          <option value="Cambodian">Cambodian</option>
                                          <option value="Cameroonian">Cameroonian</option>
                                          <option value="Canadian">Canadian</option>
                                          <option value="Cape Verdean">Cape Verdean</option>
                                          <option value="Central African">Central African</option>
                                          <option value="Chadian">Chadian</option>
                                          <option value="Chilean">Chilean</option>
                                          <option value="Chinese">Chinese</option>
                                          <option value="Colombian">Colombian</option>
                                          <option value="Comorian">Comorian</option>
                                          <option value="Congolese">Congolese</option>
                                          <option value="Costa Rican">Costa Rican</option>
                                          <option value="Croatian">Croatian</option>
                                          <option value="Cuban">Cuban</option>
                                          <option value="Cypriot">Cypriot</option>
                                          <option value="Czech">Czech</option>
                                          <option value="Danish">Danish</option>
                                          <option value="Djibouti">Djibouti</option>
                                          <option value="Dominican">Dominican</option>
                                          <option value="Dutch">Dutch</option>
                                          <option value="East Timorese">East Timorese</option>
                                          <option value="Ecuadorean">Ecuadorean</option>
                                          <option value="Egyptian">Egyptian</option>
                                          <option value="Emirian">Emirian</option>
                                          <option value="Equatorial Guinean">Equatorial Guinean</option>
                                          <option value="Eritrean">Eritrean</option>
                                          <option value="Estonian">Estonian</option>
                                          <option value="Ethiopian">Ethiopian</option>
                                          <option value="Fijian">Fijian</option>
                                          <option value="Finnish">Finnish</option>
                                          <option value="French">French</option>
                                          <option value="Gabonese">Gabonese</option>
                                          <option value="Gambian">Gambian</option>
                                          <option value="Georgian">Georgian</option>
                                          <option value="German">German</option>
                                          <option value="Ghanaian">Ghanaian</option>
                                          <option value="Greek">Greek</option>
                                          <option value="Grenadian">Grenadian</option>
                                          <option value="Guatemalan">Guatemalan</option>
                                          <option value="Guinea-Bissauan">Guinea-Bissauan</option>
                                          <option value="Guinean">Guinean</option>
                                          <option value="Guyanese">Guyanese</option>
                                          <option value="Haitian">Haitian</option>
                                          <option value="Herzegovinian">Herzegovinian</option>
                                          <option value="Honduran">Honduran</option>
                                          <option value="Hungarian">Hungarian</option>
                                          <option value="Icelander">Icelander</option>
                                          <option value="Indian">Indian</option>
                                          <option value="Indonesian">Indonesian</option>
                                          <option value="Iranian">Iranian</option>
                                          <option value="Iraqi">Iraqi</option>
                                          <option value="Irish">Irish</option>
                                          <option value="Israeli">Israeli</option>
                                          <option value="Italian">Italian</option>
                                          <option value="Ivorian">Ivorian</option>
                                          <option value="Jamaican">Jamaican</option>
                                          <option value="Japanese">Japanese</option>
                                          <option value="Jordanian">Jordanian</option>
                                          <option value="Kazakhstani">Kazakhstani</option>
                                          <option value="Kenyan">Kenyan</option>
                                          <option value="Kittian and Nevisian">Kittian and Nevisian</option>
                                          <option value="Kuwaiti">Kuwaiti</option>
                                          <option value="Kyrgyz">Kyrgyz</option>
                                          <option value="Laotian">Laotian</option>
                                          <option value="Latvian">Latvian</option>
                                          <option value="Lebanese">Lebanese</option>
                                          <option value="Liberian">Liberian</option>
                                          <option value="Libyan">Libyan</option>
                                          <option value="Liechtensteiner">Liechtensteiner</option>
                                          <option value="Lithuanian">Lithuanian</option>
                                          <option value="Luxembourger">Luxembourger</option>
                                          <option value="Macedonian">Macedonian</option>
                                          <option value="Malagasy">Malagasy</option>
                                          <option value="Malawian">Malawian</option>
                                          <option value="Malaysian">Malaysian</option>
                                          <option value="Maldivan">Maldivan</option>
                                          <option value="Malian">Malian</option>
                                          <option value="Maltese">Maltese</option>
                                          <option value="Marshallese">Marshallese</option>
                                          <option value="Mauritanian">Mauritanian</option>
                                          <option value="Mauritian">Mauritian</option>
                                          <option value="Mexican">Mexican</option>
                                          <option value="Micronesian">Micronesian</option>
                                          <option value="Moldovan">Moldovan</option>
                                          <option value="Monacan">Monacan</option>
                                          <option value="Mongolian">Mongolian</option>
                                          <option value="Moroccan">Moroccan</option>
                                          <option value="Mosotho">Mosotho</option>
                                          <option value="Motswana">Motswana</option>
                                          <option value="Mozambican">Mozambican</option>
                                          <option value="Namibian">Namibian</option>
                                          <option value="Nauruan">Nauruan</option>
                                          <option value="Nepalese">Nepalese</option>
                                          <option value="New Zealander">New Zealander</option>
                                          <option value="Nicaraguan">Nicaraguan</option>
                                          <option value="Nigerian">Nigerian</option>
                                          <option value="Nigerien">Nigerien</option>
                                          <option value="North Korean">North Korean</option>
                                          <option value="Northern Irish">Northern Irish</option>
                                          <option value="Norwegian">Norwegian</option>
                                          <option value="Omani">Omani</option>
                                          <option value="Pakistani">Pakistani</option>
                                          <option value="Palauan">Palauan</option>
                                          <option value="Panamanian">Panamanian</option>
                                          <option value="Papua New Guinean">Papua New Guinean</option>
                                          <option value="Paraguayan">Paraguayan</option>
                                          <option value="Peruvian">Peruvian</option>
                                          <option value="Polish">Polish</option>
                                          <option value="Portuguese">Portuguese</option>
                                          <option value="Qatari">Qatari</option>
                                          <option value="Romanian">Romanian</option>
                                          <option value="Russian">Russian</option>
                                          <option value="Rwandan">Rwandan</option>
                                          <option value="Saint Lucian">Saint Lucian</option>
                                          <option value="Salvadoran">Salvadoran</option>
                                          <option value="Samoan">Samoan</option>
                                          <option value="San Marinese">San Marinese</option>
                                          <option value="Sao Tomean">Sao Tomean</option>
                                          <option value="Saudi">Saudi</option>
                                          <option value="Scottish">Scottish</option>
                                          <option value="Senegalese">Senegalese</option>
                                          <option value="Serbian">Serbian</option>
                                          <option value="Seychellois">Seychellois</option>
                                          <option value="Sierra Leonean">Sierra Leonean</option>
                                          <option value="Singaporean">Singaporean</option>
                                          <option value="Slovakian">Slovakian</option>
                                          <option value="Slovenian">Slovenian</option>
                                          <option value="Solomon Islander">Solomon Islander</option>
                                          <option value="Somali">Somali</option>
                                          <option value="South African">South African</option>
                                          <option value="South Korean">South Korean</option>
                                          <option value="Spanish">Spanish</option>
                                          <option value="Sri Lankan">Sri Lankan</option>
                                          <option value="Sudanese">Sudanese</option>
                                          <option value="Surinamer">Surinamer</option>
                                          <option value="Swazi">Swazi</option>
                                          <option value="Swedish">Swedish</option>
                                          <option value="Swiss">Swiss</option>
                                          <option value="Syrian">Syrian</option>
                                          <option value="Taiwanese">Taiwanese</option>
                                          <option value="Tajik">Tajik</option>
                                          <option value="Tanzanian">Tanzanian</option>
                                          <option value="Thai">Thai</option>
                                          <option value="Togolese">Togolese</option>
                                          <option value="Tongan">Tongan</option>
                                          <option value="Trinidadian or Tobagonian">Trinidadian or Tobagonian</option>
                                          <option value="Tunisian">Tunisian</option>
                                          <option value="Turkish">Turkish</option>
                                          <option value="Tuvaluan">Tuvaluan</option>
                                          <option value="Ugandan">Ugandan</option>
                                          <option value="Ukrainian">Ukrainian</option>
                                          <option value="Uruguayan">Uruguayan</option>
                                          <option value="Uzbekistani">Uzbekistani</option>
                                          <option value="Venezuelan">Venezuelan</option>
                                          <option value="Vietnamese">Vietnamese</option>
                                          <option value="Welsh">Welsh</option>
                                          <option value="Yemenite">Yemenite</option>
                                          <option value="Zambian">Zambian</option>
                                          <option value="Zimbabwean">Zimbabwean</option>
                                      </select>
                                  </div>
                              </div>
                              <!-- Mother's Information -->
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label class="required-field">Mother's Name</label>
                                      <input type="text" class="form-control text-only" name="motherName" required>
                                  </div>
                                  <div class="form-group">
                                      <label class="required-field">Mother's Nationality</label>
                                      <select class="form-control select2" name="motherNationality" required>
                                          <option value="">Select Nationality</option>
                                          <option value="Filipino">Filipino</option>
                                          <option value="Afghan">Afghan</option>
                                          <option value="Albanian">Albanian</option>
                                          <option value="Algerian">Algerian</option>
                                          <option value="American">American</option>
                                          <option value="Andorran">Andorran</option>
                                          <option value="Angolan">Angolan</option>
                                          <option value="Antiguan">Antiguan</option>
                                          <option value="Argentine">Argentine</option>
                                          <option value="Armenian">Armenian</option>
                                          <option value="Australian">Australian</option>
                                          <option value="Austrian">Austrian</option>
                                          <option value="Azerbaijani">Azerbaijani</option>
                                          <option value="Bahamian">Bahamian</option>
                                          <option value="Bahraini">Bahraini</option>
                                          <option value="Bangladeshi">Bangladeshi</option>
                                          <option value="Barbadian">Barbadian</option>
                                          <option value="Belarusian">Belarusian</option>
                                          <option value="Belgian">Belgian</option>
                                          <option value="Belizean">Belizean</option>
                                          <option value="Beninese">Beninese</option>
                                          <option value="Bhutanese">Bhutanese</option>
                                          <option value="Bolivian">Bolivian</option>
                                          <option value="Bosnian">Bosnian</option>
                                          <option value="Botswanan">Botswanan</option>
                                          <option value="Brazilian">Brazilian</option>
                                          <option value="British">British</option>
                                          <option value="Bruneian">Bruneian</option>
                                          <option value="Bulgarian">Bulgarian</option>
                                          <option value="Burkinabe">Burkinabe</option>
                                          <option value="Burmese">Burmese</option>
                                          <option value="Burundian">Burundian</option>
                                          <option value="Cambodian">Cambodian</option>
                                          <option value="Cameroonian">Cameroonian</option>
                                          <option value="Canadian">Canadian</option>
                                          <option value="Cape Verdean">Cape Verdean</option>
                                          <option value="Central African">Central African</option>
                                          <option value="Chadian">Chadian</option>
                                          <option value="Chilean">Chilean</option>
                                          <option value="Chinese">Chinese</option>
                                          <option value="Colombian">Colombian</option>
                                          <option value="Comorian">Comorian</option>
                                          <option value="Congolese">Congolese</option>
                                          <option value="Costa Rican">Costa Rican</option>
                                          <option value="Croatian">Croatian</option>
                                          <option value="Cuban">Cuban</option>
                                          <option value="Cypriot">Cypriot</option>
                                          <option value="Czech">Czech</option>
                                          <option value="Danish">Danish</option>
                                          <option value="Djibouti">Djibouti</option>
                                          <option value="Dominican">Dominican</option>
                                          <option value="Dutch">Dutch</option>
                                          <option value="East Timorese">East Timorese</option>
                                          <option value="Ecuadorean">Ecuadorean</option>
                                          <option value="Egyptian">Egyptian</option>
                                          <option value="Emirian">Emirian</option>
                                          <option value="Equatorial Guinean">Equatorial Guinean</option>
                                          <option value="Eritrean">Eritrean</option>
                                          <option value="Estonian">Estonian</option>
                                          <option value="Ethiopian">Ethiopian</option>
                                          <option value="Fijian">Fijian</option>
                                          <option value="Finnish">Finnish</option>
                                          <option value="French">French</option>
                                          <option value="Gabonese">Gabonese</option>
                                          <option value="Gambian">Gambian</option>
                                          <option value="Georgian">Georgian</option>
                                          <option value="German">German</option>
                                          <option value="Ghanaian">Ghanaian</option>
                                          <option value="Greek">Greek</option>
                                          <option value="Grenadian">Grenadian</option>
                                          <option value="Guatemalan">Guatemalan</option>
                                          <option value="Guinea-Bissauan">Guinea-Bissauan</option>
                                          <option value="Guinean">Guinean</option>
                                          <option value="Guyanese">Guyanese</option>
                                          <option value="Haitian">Haitian</option>
                                          <option value="Herzegovinian">Herzegovinian</option>
                                          <option value="Honduran">Honduran</option>
                                          <option value="Hungarian">Hungarian</option>
                                          <option value="Icelander">Icelander</option>
                                          <option value="Indian">Indian</option>
                                          <option value="Indonesian">Indonesian</option>
                                          <option value="Iranian">Iranian</option>
                                          <option value="Iraqi">Iraqi</option>
                                          <option value="Irish">Irish</option>
                                          <option value="Israeli">Israeli</option>
                                          <option value="Italian">Italian</option>
                                          <option value="Ivorian">Ivorian</option>
                                          <option value="Jamaican">Jamaican</option>
                                          <option value="Japanese">Japanese</option>
                                          <option value="Jordanian">Jordanian</option>
                                          <option value="Kazakhstani">Kazakhstani</option>
                                          <option value="Kenyan">Kenyan</option>
                                          <option value="Kittian and Nevisian">Kittian and Nevisian</option>
                                          <option value="Kuwaiti">Kuwaiti</option>
                                          <option value="Kyrgyz">Kyrgyz</option>
                                          <option value="Laotian">Laotian</option>
                                          <option value="Latvian">Latvian</option>
                                          <option value="Lebanese">Lebanese</option>
                                          <option value="Liberian">Liberian</option>
                                          <option value="Libyan">Libyan</option>
                                          <option value="Liechtensteiner">Liechtensteiner</option>
                                          <option value="Lithuanian">Lithuanian</option>
                                          <option value="Luxembourger">Luxembourger</option>
                                          <option value="Macedonian">Macedonian</option>
                                          <option value="Malagasy">Malagasy</option>
                                          <option value="Malawian">Malawian</option>
                                          <option value="Malaysian">Malaysian</option>
                                          <option value="Maldivan">Maldivan</option>
                                          <option value="Malian">Malian</option>
                                          <option value="Maltese">Maltese</option>
                                          <option value="Marshallese">Marshallese</option>
                                          <option value="Mauritanian">Mauritanian</option>
                                          <option value="Mauritian">Mauritian</option>
                                          <option value="Mexican">Mexican</option>
                                          <option value="Micronesian">Micronesian</option>
                                          <option value="Moldovan">Moldovan</option>
                                          <option value="Monacan">Monacan</option>
                                          <option value="Mongolian">Mongolian</option>
                                          <option value="Moroccan">Moroccan</option>
                                          <option value="Mosotho">Mosotho</option>
                                          <option value="Motswana">Motswana</option>
                                          <option value="Mozambican">Mozambican</option>
                                          <option value="Namibian">Namibian</option>
                                          <option value="Nauruan">Nauruan</option>
                                          <option value="Nepalese">Nepalese</option>
                                          <option value="New Zealander">New Zealander</option>
                                          <option value="Nicaraguan">Nicaraguan</option>
                                          <option value="Nigerian">Nigerian</option>
                                          <option value="Nigerien">Nigerien</option>
                                          <option value="North Korean">North Korean</option>
                                          <option value="Northern Irish">Northern Irish</option>
                                          <option value="Norwegian">Norwegian</option>
                                          <option value="Omani">Omani</option>
                                          <option value="Pakistani">Pakistani</option>
                                          <option value="Palauan">Palauan</option>
                                          <option value="Panamanian">Panamanian</option>
                                          <option value="Papua New Guinean">Papua New Guinean</option>
                                          <option value="Paraguayan">Paraguayan</option>
                                          <option value="Peruvian">Peruvian</option>
                                          <option value="Polish">Polish</option>
                                          <option value="Portuguese">Portuguese</option>
                                          <option value="Qatari">Qatari</option>
                                          <option value="Romanian">Romanian</option>
                                          <option value="Russian">Russian</option>
                                          <option value="Rwandan">Rwandan</option>
                                          <option value="Saint Lucian">Saint Lucian</option>
                                          <option value="Salvadoran">Salvadoran</option>
                                          <option value="Samoan">Samoan</option>
                                          <option value="San Marinese">San Marinese</option>
                                          <option value="Sao Tomean">Sao Tomean</option>
                                          <option value="Saudi">Saudi</option>
                                          <option value="Scottish">Scottish</option>
                                          <option value="Senegalese">Senegalese</option>
                                          <option value="Serbian">Serbian</option>
                                          <option value="Seychellois">Seychellois</option>
                                          <option value="Sierra Leonean">Sierra Leonean</option>
                                          <option value="Singaporean">Singaporean</option>
                                          <option value="Slovakian">Slovakian</option>
                                          <option value="Slovenian">Slovenian</option>
                                          <option value="Solomon Islander">Solomon Islander</option>
                                          <option value="Somali">Somali</option>
                                          <option value="South African">South African</option>
                                          <option value="South Korean">South Korean</option>
                                          <option value="Spanish">Spanish</option>
                                          <option value="Sri Lankan">Sri Lankan</option>
                                          <option value="Sudanese">Sudanese</option>
                                          <option value="Surinamer">Surinamer</option>
                                          <option value="Swazi">Swazi</option>
                                          <option value="Swedish">Swedish</option>
                                          <option value="Swiss">Swiss</option>
                                          <option value="Syrian">Syrian</option>
                                          <option value="Taiwanese">Taiwanese</option>
                                          <option value="Tajik">Tajik</option>
                                          <option value="Tanzanian">Tanzanian</option>
                                          <option value="Thai">Thai</option>
                                          <option value="Togolese">Togolese</option>
                                          <option value="Tongan">Tongan</option>
                                          <option value="Trinidadian or Tobagonian">Trinidadian or Tobagonian</option>
                                          <option value="Tunisian">Tunisian</option>
                                          <option value="Turkish">Turkish</option>
                                          <option value="Tuvaluan">Tuvaluan</option>
                                          <option value="Ugandan">Ugandan</option>
                                          <option value="Ukrainian">Ukrainian</option>
                                          <option value="Uruguayan">Uruguayan</option>
                                          <option value="Uzbekistani">Uzbekistani</option>
                                          <option value="Venezuelan">Venezuelan</option>
                                          <option value="Vietnamese">Vietnamese</option>
                                          <option value="Welsh">Welsh</option>
                                          <option value="Yemenite">Yemenite</option>
                                          <option value="Zambian">Zambian</option>
                                          <option value="Zimbabwean">Zimbabwean</option>
                                      </select>
                                  </div>
                              </div>
                          </div>
                      </div>

                      <!-- Death Location -->
                      <div class="form-section">
                          <h5 class="section-title">
                              <i class="fas fa-map-marker-alt"></i>
                              Death Location
                          </h5>
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label class="required-field">Place of Death</label>
                                      <input type="text" class="form-control" name="placeOfDeath" required>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label class="required-field">Address of Death</label>
                                      <textarea class="form-control" name="addressOfDeath" required></textarea>
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label class="required-field">City/Municipality</label>
                                      <input type="text" class="form-control" name="cityOfDeath" required>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label class="required-field">Province</label>
                                      <input type="text" class="form-control" name="provinceOfDeath" required>
                                  </div>
                              </div>
                          </div>
                      </div>

                      <!-- Medical Information -->
                      <div class="form-section">
                          <h5 class="section-title">
                              <i class="fas fa-notes-medical"></i>
                              Medical Information
                          </h5>
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label class="required-field">Cause of Death</label>
                                      <textarea class="form-control" name="causeOfDeath" required></textarea>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label>Contributing Causes</label>
                                      <textarea class="form-control" name="contributingCauses"></textarea>
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label class="required-field">Attending Physician</label>
                                      <input type="text" class="form-control" name="attendingPhysician" required>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label class="required-field">License Number</label>
                                      <input type="text" class="form-control" name="physicianLicense" required>
                                  </div>
                              </div>
                          </div>
                      </div>

                      <!-- Informant Information -->
                      <div class="form-section">
                          <h5 class="section-title">
                              <i class="fas fa-user-friends"></i>
                              Informant Information
                          </h5>
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label class="required-field">Informant's Name</label>
                                      <input type="text" class="form-control text-only" name="informantName" required>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label class="required-field">Relationship to Deceased</label>
                                      <input type="text" class="form-control text-only" name="informantRelationship" required>
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label class="required-field">Informant's Address</label>
                                      <textarea class="form-control" name="informantAddress" required></textarea>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label class="required-field">Contact Number</label>
                                      <input type="tel" class="form-control" name="informantContact" required>
                                  </div>
                              </div>
                          </div>
                      </div>

                      <!-- Burial Information -->
                      <div class="form-section">
                          <h5 class="section-title">
                              <i class="fas fa-cross"></i>
                              Burial Information
                          </h5>
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label class="required-field">Burial Date</label>
                                      <input type="date" class="form-control" name="burialDate" required>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label class="required-field">Burial Place</label>
                                      <input type="text" class="form-control" name="burialPlace" required>
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label>Funeral Service</label>
                                      <input type="text" class="form-control" name="funeralService">
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label>Burial Permit Number</label>
                                      <input type="text" class="form-control" name="burialPermitNumber">
                                  </div>
                              </div>
                          </div>
                      </div>

                      <!-- Registration Details -->
                      <div class="form-section">
                          <h5 class="section-title">
                              <i class="fas fa-file-alt"></i>
                              Registration Details
                          </h5>
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label class="required-field">Registration Date</label>
                                      <input type="date" class="form-control" name="registrationDate" required>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label class="required-field">Registration Number</label>
                                      <input type="text" class="form-control" name="registrationNumber" required>
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label class="required-field">Registered By</label>
                                      <input type="text" class="form-control" name="registeredBy" required>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label>Remarks</label>
                                      <textarea class="form-control" name="remarks"></textarea>
                                  </div>
                              </div>
                          </div>
                      </div>

                      <!-- Supporting Documents -->
                      <div class="form-section">
                          <h5 class="section-title">
                              <i class="fas fa-file-upload"></i>
                              Supporting Documents
                          </h5>
                          <div class="document-upload" id="dropZone">
                              <i class="fas fa-cloud-upload-alt"></i>
                              <p>Drag and drop files here or click to browse</p>
                              <input type="file" id="fileInput" multiple accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" style="display: none;" required>
                              <button type="button" class="btn btn-light" onclick="document.getElementById('fileInput').click()">
                                  <i class="fas fa-folder-open"></i>
                                  Select Files
                              </button>
                              <div class="file-type-hint">
                                  Accepted file types: PDF, JPG, JPEG, PNG, DOC, DOCX (2-5 files required, 5MB each)
                              </div>
                              <div class="file-count-hint text-muted mt-2">
                                  <small>You must upload between 2 and 5 files</small>
                              </div>
                              <div class="upload-status mt-2" style="display: none;">
                                  <div class="progress" style="height: 5px;">
                                      <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                                  </div>
                                  <small class="upload-status-text"></small>
                              </div>
                          </div>
                          
                          <div class="document-list" id="documentList">
                              <!-- Document items will be added here dynamically -->
                          </div>
                          
                          <input type="hidden" name="uploadedDocuments" id="uploadedDocuments">
                      </div>

                      <!-- Form Buttons -->
                      <div class="form-buttons">
                          <button type="submit" name="btnSubmit" class="btn btn-primary">
                              <i class="fas fa-save"></i>
                              Register Death
                          </button>
                          <button type="reset" class="btn btn-light">
                              <i class="fas fa-undo"></i>
                              Clear Form
                          </button>
                          <a href="dashboard.php" class="btn btn-secondary">
                              <i class="fas fa-times"></i>
                              Cancel
                          </a>
                      </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
       
          <?php 
               if (isset($_POST['btnSubmit'])) {
                   // Get all form fields
                   $firstName = $_POST['firstName'];
                   $lastName = $_POST['lastName'];
                   $gender = $_POST['gender'];
                   $dod = $_POST['dod'];
                   $state = $_POST['state'];
                   $lga = $_POST['lga'];
                   $town = $_POST['town'];
                   $Placeissue = $_POST['Placeissue'];
                   $address = $_POST['address'];
                   $ageDeath = $_POST['ageDeath'];
                   $placeDeath = $_POST['placeDeath'];
                   $regCentre = $_POST['regCentre'];
                   $cause = $_POST['cause'];
                   $maritalStatus = $_POST['maritalStatus'];
                   $medicalCertifier = $_POST['medicalCertifier'];
                   $certifierLicense = $_POST['certifierLicense'];
                   $certificationDate = $_POST['certificationDate'];
                   $informantName = $_POST['informantName'];
                   $informantRelationship = $_POST['informantRelationship'];
                   $informantPhone = $_POST['informantPhone'];
                   $informantAddress = $_POST['informantAddress'];
                   $burialDate = $_POST['burialDate'];
                   $burialPlace = $_POST['burialPlace'];
                   $dateReg = date('Y-m-d');

                   // Get next certificate number
                   $query = $con->query("SELECT * FROM tblcertno WHERE certId = '200000'") or die(mysqli_error($con));
                   $row = mysqli_fetch_array($query);
                   if (!$row) {
                       echo "<script>alert('Error: Could not get certificate number');</script>";
                       exit;
                   }

                   $newCertNo = $row['lastCertId'] + 1;
                   $newNum = "GHDR";
                   $newNum1 = $newNum . $newCertNo;

                   // Update certificate number
                   $updateCert = $con->query("UPDATE tblcertno SET lastCertId = '$newCertNo' WHERE certId = '200000'") or die(mysqli_error($con));
                   if (!$updateCert) {
                       echo "<script>alert('Error: Could not update certificate number');</script>";
                       exit;
                   }

                   // Insert death record with all new fields
                   $result = $con->query("INSERT INTO tbldeath (
                       certNo, firstName, lastName, gender, state, lga, town, address, 
                       ageAtDeath, placeOfDeath, dateOfDeath, PlaceOfIssue, regCentre, 
                       dateReg, cause_death, maritalStatus, medicalCertifier, certifierLicense,
                       certificationDate, informantName, informantRelationship, informantPhone,
                       informantAddress, burialDate, burialPlace
                   ) VALUES (
                       '$newNum1', '$firstName', '$lastName', '$gender', '$state', '$lga', '$town', '$address',
                       '$ageDeath', '$placeDeath', '$dod', '$Placeissue', '$regCentre',
                       '$dateReg', '$cause', '$maritalStatus', '$medicalCertifier', '$certifierLicense',
                       '$certificationDate', '$informantName', '$informantRelationship', '$informantPhone',
                       '$informantAddress', '$burialDate', '$burialPlace'
                   )") or die(mysqli_error($con));

                   if ($result) {
                       echo "<script>
                           alert('Successfully Registered!');
                           window.location = 'DeathRegistration.php';
                       </script>";
                   } else {
                       echo "<script>alert('Error: Registration failed');</script>";
                   }
               }
               ?>


          <!-- <div class="row">
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title mb-4">Manage Tickets</h5>
                  <div class="fluid-container">
                    <div class="row ticket-card mt-3 pb-2 border-bottom pb-3 mb-3">
                      <div class="col-md-1">
                        <img class="img-sm rounded-circle mb-4 mb-md-0" src="images/faces/face1.jpg" alt="profile image">
                      </div>
                      <div class="ticket-details col-md-9">
                        <div class="d-flex">
                          <p class="text-dark font-weight-semibold mr-2 mb-0 no-wrap">James :</p>
                          <p class="text-primary mr-1 mb-0">[#23047]</p>
                          <p class="mb-0 ellipsis">Donec rutrum congue leo eget malesuada.</p>
                        </div>
                        <p class="text-gray ellipsis mb-2">Donec rutrum congue leo eget malesuada. Quisque velit nisi, pretium ut lacinia in, elementum id enim
                          vivamus.
                        </p>
                        <div class="row text-gray d-md-flex d-none">
                          <div class="col-4 d-flex">
                            <small class="mb-0 mr-2 text-muted text-muted">Last responded :</small>
                            <small class="Last-responded mr-2 mb-0 text-muted text-muted">3 hours ago</small>
                          </div>
                          <div class="col-4 d-flex">
                            <small class="mb-0 mr-2 text-muted">Due in :</small>
                            <small class="Last-responded mr-2 mb-0 text-muted">2 Days</small>
                          </div>
                        </div>
                      </div>
                      <div class="ticket-actions col-md-2">
                        <div class="btn-group dropdown">
                          <button type="button" class="btn btn-success dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Manage
                          </button>
                          <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">
                              <i class="fa fa-reply fa-fw"></i>Quick reply</a>
                            <a class="dropdown-item" href="#">
                              <i class="fa fa-history fa-fw"></i>Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">
                              <i class="fa fa-check text-success fa-fw"></i>Resolve Issue</a>
                            <a class="dropdown-item" href="#">
                              <i class="fa fa-times text-danger fa-fw"></i>Close Issue</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row ticket-card mt-3 pb-2 border-bottom pb-3 mb-3">
                      <div class="col-md-1">
                        <img class="img-sm rounded-circle mb-4 mb-md-0" src="images/faces/face2.jpg" alt="profile image">
                      </div>
                      <div class="ticket-details col-md-9">
                        <div class="d-flex">
                          <p class="text-dark font-weight-semibold mr-2 mb-0 no-wrap">Stella :</p>
                          <p class="text-primary mr-1 mb-0">[#23135]</p>
                          <p class="mb-0 ellipsis">Curabitur aliquet quam id dui posuere blandit.</p>
                        </div>
                        <p class="text-gray ellipsis mb-2">Pellentesque in ipsum id orci porta dapibus. Sed porttitor lectus nibh. Curabitur non nulla sit amet
                          nisl.
                        </p>
                        <div class="row text-gray d-md-flex d-none">
                          <div class="col-4 d-flex">
                            <small class="mb-0 mr-2 text-muted">Last responded :</small>
                            <small class="Last-responded mr-2 mb-0 text-muted">3 hours ago</small>
                          </div>
                          <div class="col-4 d-flex">
                            <small class="mb-0 mr-2 text-muted">Due in :</small>
                            <small class="Last-responded mr-2 mb-0 text-muted">2 Days</small>
                          </div>
                        </div>
                      </div>
                      <div class="ticket-actions col-md-2">
                        <div class="btn-group dropdown">
                          <button type="button" class="btn btn-success dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Manage
                          </button>
                          <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">
                              <i class="fa fa-reply fa-fw"></i>Quick reply</a>
                            <a class="dropdown-item" href="#">
                              <i class="fa fa-history fa-fw"></i>Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">
                              <i class="fa fa-check text-success fa-fw"></i>Resolve Issue</a>
                            <a class="dropdown-item" href="#">
                              <i class="fa fa-times text-danger fa-fw"></i>Close Issue</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row ticket-card mt-3">
                      <div class="col-md-1">
                        <img class="img-sm rounded-circle mb-4 mb-md-0" src="images/faces/face3.jpg" alt="profile image">
                      </div>
                      <div class="ticket-details col-md-9">
                        <div class="d-flex">
                          <p class="text-dark font-weight-semibold mr-2 mb-0 no-wrap">John Doe :</p>
                          <p class="text-primary mr-1 mb-0">[#23246]</p>
                          <p class="mb-0 ellipsis">Mauris blandit aliquet elit, eget tincidunt nibh pulvinar.</p>
                        </div>
                        <p class="text-gray ellipsis mb-2">Nulla quis lorem ut libero malesuada feugiat. Proin eget tortor risus. Lorem ipsum dolor sit amet.</p>
                        <div class="row text-gray d-md-flex d-none">
                          <div class="col-4 d-flex">
                            <small class="mb-0 mr-2 text-muted">Last responded :</small>
                            <small class="Last-responded mr-2 mb-0 text-muted">3 hours ago</small>
                          </div>
                          <div class="col-4 d-flex">
                            <small class="mb-0 mr-2 text-muted">Due in :</small>
                            <small class="Last-responded mr-2 mb-0 text-muted">2 Days</small>
                          </div>
                        </div>
                      </div>
                      <div class="ticket-actions col-md-2">
                        <div class="btn-group dropdown">
                          <button type="button" class="btn btn-success dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Manage
                          </button>
                          <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">
                              <i class="fa fa-reply fa-fw"></i>Quick reply</a>
                            <a class="dropdown-item" href="#">
                              <i class="fa fa-history fa-fw"></i>Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">
                              <i class="fa fa-check text-success fa-fw"></i>Resolve Issue</a>
                            <a class="dropdown-item" href="#">
                              <i class="fa fa-times text-danger fa-fw"></i>Close Issue</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div> -->
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
   <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <!-- End custom js for this page-->
  <script>
      function preventNumberInput(e){
    var keyCode = (e.keyCode ? e.keyCode : e.which);
    if (keyCode > 47 && keyCode < 58 || keyCode > 95 && keyCode < 107 && keyCode==189){
        e.preventDefault();
            }
        }

        $(document).ready(function(){
            $('#text_field').keypress(function(e) {
                preventNumberInput(e);
            });
        });
        
        var today = new Date();
var dd = today.getDate();
var mm = today.getMonth() + 1; //January is 0!
var yyyy = today.getFullYear();

if (dd < 10) {
   dd = '0' + dd;
}

if (mm < 10) {
   mm = '0' + mm;
} 
    
today = yyyy + '-' + mm + '-' + dd;
document.getElementById("datefield").setAttribute("max", today);
        
        
  </script>
  <!-- End custom js for this page-->
  <script src="location-selector.js"></script>
  <style>
/* Reset any conflicting styles */
.card-body form {
    display: block !important;
    width: 100% !important;
}

.card-body form > div {
    display: block !important;
    width: 100% !important;
}

/* Basic form container styles */
.card-body {
    padding: 20px !important;
    background: white !important;
}

/* Ensure the form is visible */
.form-sample {
    display: block !important;
    width: 100% !important;
    margin-bottom: 20px !important;
}

/* Basic button container */
div[style*="text-align: center"] {
    display: block !important;
    width: 100% !important;
    margin-top: 20px !important;
    padding: 20px !important;
    background: white !important;
    border-top: 1px solid #eee !important;
}

/* Force button visibility */
input[type="submit"],
input[type="reset"],
a[href="dashboard.php"] {
    display: inline-block !important;
    visibility: visible !important;
    opacity: 1 !important;
    position: relative !important;
    z-index: 1000 !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const form = document.getElementById('deathRegistrationForm');
    const inputs = form.querySelectorAll('input, select');
    
    inputs.forEach(input => {
        input.addEventListener('invalid', function(e) {
            e.preventDefault();
            this.classList.add('is-invalid');
        });
        
        input.addEventListener('input', function() {
            if (this.classList.contains('is-invalid')) {
                this.classList.remove('is-invalid');
            }
        });
    });
    
    // Date validation
    const deathDate = document.querySelector('input[name="dod"]');
    const burialDate = document.querySelector('input[name="burialDate"]');
    const certificationDate = document.querySelector('input[name="certificationDate"]');
    
    if (deathDate && burialDate) {
        burialDate.addEventListener('change', function() {
            if (new Date(this.value) < new Date(deathDate.value)) {
                this.setCustomValidity('Burial date cannot be before death date');
                this.classList.add('is-invalid');
            } else {
                this.setCustomValidity('');
                this.classList.remove('is-invalid');
            }
        });
    }
    
    if (deathDate && certificationDate) {
        certificationDate.addEventListener('change', function() {
            if (new Date(this.value) < new Date(deathDate.value)) {
                this.setCustomValidity('Certification date cannot be before death date');
                this.classList.add('is-invalid');
            } else {
                this.setCustomValidity('');
                this.classList.remove('is-invalid');
            }
        });
    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('fileInput');
    const documentList = document.getElementById('documentList');
    const minFiles = 2;
    const maxFiles = 5;
    const maxFileSize = 5 * 1024 * 1024; // 5MB
    let uploadedFiles = [];

    // Prevent default drag behaviors
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
        document.body.addEventListener(eventName, preventDefaults, false);
    });

    // Highlight drop zone when dragging over it
    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, unhighlight, false);
    });

    // Handle dropped files
    dropZone.addEventListener('drop', handleDrop, false);
    fileInput.addEventListener('change', handleFiles, false);

    // Add form validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        if (uploadedFiles.length < minFiles) {
            e.preventDefault();
            alert(`Please upload at least ${minFiles} files. You have uploaded ${uploadedFiles.length} file(s).`);
            return false;
        }
        if (uploadedFiles.length > maxFiles) {
            e.preventDefault();
            alert(`You can only upload up to ${maxFiles} files. You have uploaded ${uploadedFiles.length} file(s).`);
            return false;
        }
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    function highlight(e) {
        dropZone.classList.add('border-primary');
    }

    function unhighlight(e) {
        dropZone.classList.remove('border-primary');
    }

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        handleFiles({ target: { files: files } });
    }

    function handleFiles(e) {
        const files = [...e.target.files];
        
        if (uploadedFiles.length + files.length > maxFiles) {
            alert(`You can only upload up to ${maxFiles} files. You currently have ${uploadedFiles.length} file(s).`);
            return;
        }

        // Show upload status container
        const uploadStatus = document.querySelector('.upload-status');
        uploadStatus.style.display = 'block';
        const progressBar = uploadStatus.querySelector('.progress-bar');
        const statusText = uploadStatus.querySelector('.upload-status-text');

        let totalFiles = files.length;
        let completedFiles = 0;

        files.forEach(file => {
            if (file.size > maxFileSize) {
                alert(`File ${file.name} is too large. Maximum size is 5MB.`);
                return;
            }

            if (!['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'].includes(file.type)) {
                alert(`File ${file.name} is not a supported file type.`);
                return;
            }

            uploadedFiles.push(file);
            addFileToList(file);
            
            // Update overall progress
            completedFiles++;
            const progress = (completedFiles / totalFiles) * 100;
            progressBar.style.width = `${progress}%`;
            statusText.textContent = `Uploading files... ${completedFiles} of ${totalFiles} complete`;
        });

        // Hide upload status after all files are processed
        setTimeout(() => {
            uploadStatus.style.display = 'none';
            progressBar.style.width = '0%';
            statusText.textContent = '';
        }, 2000);

        updateHiddenInput();
        updateFileCountHint();
    }

    function addFileToList(file) {
        const item = document.createElement('div');
        item.className = 'document-item uploading';
        
        const icon = document.createElement('i');
        icon.className = file.type === 'application/pdf' ? 'fas fa-file-pdf' : 'fas fa-file-image';
        
        const fileName = document.createElement('span');
        fileName.className = 'file-name';
        fileName.textContent = file.name;
        
        const statusIndicator = document.createElement('span');
        statusIndicator.className = 'upload-status-indicator uploading';
        statusIndicator.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Uploading...';
        
        const removeBtn = document.createElement('span');
        removeBtn.className = 'remove-file';
        removeBtn.innerHTML = '<i class="fas fa-times"></i>';
        removeBtn.onclick = () => removeFile(file, item);
        
        item.appendChild(icon);
        item.appendChild(fileName);
        item.appendChild(statusIndicator);
        item.appendChild(removeBtn);
        documentList.appendChild(item);

        // Simulate upload progress (in a real application, this would be tied to actual upload progress)
        simulateUploadProgress(item, statusIndicator);
    }

    function simulateUploadProgress(item, statusIndicator) {
        let progress = 0;
        const interval = setInterval(() => {
            progress += 10;
            if (progress >= 100) {
                clearInterval(interval);
                item.classList.remove('uploading');
                item.classList.add('uploaded');
                statusIndicator.className = 'upload-status-indicator uploaded';
                statusIndicator.innerHTML = '<i class="fas fa-check"></i> Uploaded';
            }
        }, 200);
    }

    function removeFile(file, item) {
        uploadedFiles = uploadedFiles.filter(f => f !== file);
        item.remove();
        updateHiddenInput();
        updateFileCountHint();
    }

    function updateHiddenInput() {
        const input = document.getElementById('uploadedDocuments');
        input.value = JSON.stringify(uploadedFiles.map(f => ({
            name: f.name,
            type: f.type,
            size: f.size
        })));
    }

    function updateFileCountHint() {
        const hint = document.querySelector('.file-count-hint small');
        if (uploadedFiles.length < minFiles) {
            hint.textContent = `Please upload ${minFiles - uploadedFiles.length} more file(s) (minimum ${minFiles} files required)`;
            hint.style.color = '#dc3545';
        } else if (uploadedFiles.length > maxFiles) {
            hint.textContent = `Too many files. Please remove ${uploadedFiles.length - maxFiles} file(s) (maximum ${maxFiles} files allowed)`;
            hint.style.color = '#dc3545';
        } else {
            hint.textContent = `${uploadedFiles.length} file(s) uploaded (${minFiles}-${maxFiles} files required)`;
            hint.style.color = '#28a745';
        }
    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add search functionality to nationality dropdown
    const nationalitySelect = document.getElementById('nationality');
    
    // Create a search input
    const searchInput = document.createElement('input');
    searchInput.type = 'text';
    searchInput.className = 'form-control mb-2';
    searchInput.placeholder = 'Search nationality...';
    nationalitySelect.parentNode.insertBefore(searchInput, nationalitySelect);

    // Add search functionality
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const options = nationalitySelect.options;
        
        for (let i = 0; i < options.length; i++) {
            const option = options[i];
            const text = option.text.toLowerCase();
            if (text.includes(searchTerm) || i === 0) { // Always show the first option (Select Nationality)
                option.style.display = '';
            } else {
                option.style.display = 'none';
            }
        }
    });

    // Add keyboard navigation
    nationalitySelect.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            this.blur();
        }
    });
});
</script>

<script>
$(document).ready(function() {
    // Initialize all select2 dropdowns
    $('.select2').select2({
        placeholder: "Select Nationality",
        allowClear: true,
        width: '100%',
        dropdownParent: $('body') // This ensures the dropdown is properly positioned
    });
});
</script>

<script>
// Add this to your existing JavaScript
document.addEventListener('DOMContentLoaded', function() {
    const biometricDropZone = document.getElementById('biometricDropZone');
    const biofield = document.getElementById('biofield');
    const biometricPreview = document.getElementById('biometricPreview');
    const previewImage = document.getElementById('previewImage');
    const uploadProgress = document.getElementById('uploadProgress');
    const progressBar = uploadProgress.querySelector('.progress-bar');
    const uploadStatus = uploadProgress.querySelector('.upload-status');

    // Prevent default drag behaviors
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        biometricDropZone.addEventListener(eventName, preventDefaults, false);
        document.body.addEventListener(eventName, preventDefaults, false);
    });

    // Highlight drop zone when dragging over it
    ['dragenter', 'dragover'].forEach(eventName => {
        biometricDropZone.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        biometricDropZone.addEventListener(eventName, unhighlight, false);
    });

    // Handle dropped files
    biometricDropZone.addEventListener('drop', handleDrop, false);
    biofield.addEventListener('change', handleFileSelect, false);

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    function highlight(e) {
        biometricDropZone.classList.add('dragover');
    }

    function unhighlight(e) {
        biometricDropZone.classList.remove('dragover');
    }

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        handleFiles(files);
    }

    function handleFileSelect(e) {
        const files = e.target.files;
        handleFiles(files);
    }

    function handleFiles(files) {
        if (files.length === 0) return;

        const file = files[0];
        const maxSize = 5 * 1024 * 1024; // 5MB

        if (file.size > maxSize) {
            alert('File is too large. Maximum size is 5MB.');
            return;
        }

        if (!file.type.startsWith('image/')) {
            alert('Please upload an image file (JPG, JPEG, or PNG).');
            return;
        }

        // Show preview
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            biometricPreview.classList.add('active');
            biometricDropZone.style.display = 'none';
        };
        reader.readAsDataURL(file);

        // Simulate upload progress
        uploadProgress.classList.add('active');
        let progress = 0;
        const interval = setInterval(() => {
            progress += 10;
            progressBar.style.width = `${progress}%`;
            if (progress >= 100) {
                clearInterval(interval);
                uploadStatus.textContent = 'Upload Complete';
                setTimeout(() => {
                    uploadProgress.classList.remove('active');
                    progressBar.style.width = '0%';
                }, 1000);
            }
        }, 200);
    }
});

function viewFullImage() {
    const previewImage = document.getElementById('previewImage');
    const modal = document.createElement('div');
    modal.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        cursor: pointer;
    `;
    
    const img = document.createElement('img');
    img.src = previewImage.src;
    img.style.cssText = `
        max-width: 90%;
        max-height: 90%;
        object-fit: contain;
    `;
    
    modal.appendChild(img);
    document.body.appendChild(modal);
    
    modal.onclick = function() {
        document.body.removeChild(modal);
    };
}

function removeBiometric() {
    const biometricDropZone = document.getElementById('biometricDropZone');
    const biometricPreview = document.getElementById('biometricPreview');
    const biofield = document.getElementById('biofield');
    
    biometricPreview.classList.remove('active');
    biometricDropZone.style.display = 'block';
    biofield.value = '';
    document.getElementById('previewImage').src = '';
}
</script>
</body>

</html>