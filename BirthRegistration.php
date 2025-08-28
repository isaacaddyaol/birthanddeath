<?php
session_start();
error_reporting(0);
include('dbcon.php');
require_once 'locations.php';
require_once 'nationalities.php';


if (!isset($_SESSION['email']))
{

  echo "<script type = \"text/javascript\">
  window.location = (\"index.php\");
  </script>";

}
if (isset($_SESSION['RegCentre']))
{

$querys = mysqli_query($con,"select  * from tblcentre where centreId =".$_SESSION['RegCentre']."") or die(mysqli_error($con));
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
  <!-- Select2 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <!-- Face-api.js for facial recognition -->
  <script src="https://cdn.jsdelivr.net/npm/@vladmandic/face-api@latest/dist/face-api.min.js"></script>
  <!-- Camera Capture CSS -->
  <link rel="stylesheet" href="css/camera-capture.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.png" />
  <script src="location-selector.js"></script>
  
  <!-- jQuery and Select2 JS -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <!-- Facial Recognition Client Library -->
  <script src="js/facial-recognition-client.js"></script>
  <!-- Camera Capture Client Library -->
  <script src="js/camera-capture-client.js"></script>
  
  <script>
  $(document).ready(function() {
      // Initialize Select2 for all dropdowns
      $('.select2').select2({
          theme: 'bootstrap4',
          width: '100%',
          placeholder: 'Select an option',
          allowClear: true
      });

      // Handle Region (State) change
      $('.region-select').on('change', function() {
          var region = $(this).val();
          var districtSelect = $('.district-select');
          var townSelect = $('.town-select');
          
          // Clear and disable dependent dropdowns
          districtSelect.html('<option value="">Select District</option>').prop('disabled', true).trigger('change');
          townSelect.html('<option value="">Select Town</option>').prop('disabled', true).trigger('change');
          
          if (region) {
              // Show loading state
              districtSelect.closest('.select2-container').addClass('loading');
              
              // Fetch districts for selected region
              $.get('get_locations.php', { type: 'districts', region: region }, function(data) {
                  districtSelect.closest('.select2-container').removeClass('loading');
                  districtSelect.prop('disabled', false);
                  data.forEach(function(district) {
                      districtSelect.append($('<option></option>')
                          .attr('value', district)
                          .text(district));
                  });
                  districtSelect.trigger('change');
              }).fail(function() {
                  districtSelect.closest('.select2-container').removeClass('loading');
                  districtSelect.prop('disabled', false);
                  alert('Error loading districts. Please try again.');
              });
          }
      });

      // Handle District (LGA) change
      $('.district-select').on('change', function() {
          var region = $('.region-select').val();
          var district = $(this).val();
          var townSelect = $('.town-select');
          
          // Clear and disable town dropdown
          townSelect.html('<option value="">Select Town</option>').prop('disabled', true).trigger('change');
          
          if (region && district) {
              // Show loading state
              townSelect.closest('.select2-container').addClass('loading');
              
              // Fetch towns for selected region and district
              $.get('get_locations.php', { 
                  type: 'towns', 
                  region: region, 
                  district: district 
              }, function(data) {
                  townSelect.closest('.select2-container').removeClass('loading');
                  townSelect.prop('disabled', false);
                  data.forEach(function(town) {
                      townSelect.append($('<option></option>')
                          .attr('value', town)
                          .text(town));
                  });
                  townSelect.trigger('change');
              }).fail(function() {
                  townSelect.closest('.select2-container').removeClass('loading');
                  townSelect.prop('disabled', false);
                  alert('Error loading towns. Please try again.');
              });
          }
      });

      // Trigger initial change if region is pre-selected
      if ($('.region-select').val()) {
          $('.region-select').trigger('change');
      }

      // Form validation
      $('#birthRegistrationForm').on('submit', function(e) {
          e.preventDefault();
          
          // Basic validation
          var isValid = true;
          $(this).find('select[required]').each(function() {
              if (!$(this).val()) {
                  isValid = false;
                  $(this).addClass('is-invalid');
              } else {
                  $(this).removeClass('is-invalid');
              }
          });

          if (!isValid) {
              alert('Please fill in all required fields');
              return;
          }

          // Submit form if valid
          this.submit();
      });

      // Add error styling for invalid fields
      $('select[required]').on('change', function() {
          if (!$(this).val()) {
              $(this).addClass('is-invalid');
          } else {
              $(this).removeClass('is-invalid');
          }
      });

      // Add loading state styles
      $('<style>')
          .text(`
              .select2-container--bootstrap4.loading .select2-selection {
                  background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="%23999" d="M12,4V2A10,10 0 0,0 2,12H4A8,8 0 0,1 12,4Z"><animateTransform attributeName="transform" type="rotate" from="0 12 12" to="360 12 12" dur="1s" repeatCount="indefinite"/></path></svg>');
                  background-repeat: no-repeat;
                  background-position: right 0.5rem center;
                  background-size: 1.5rem;
                  padding-right: 2.5rem;
              }
          `)
          .appendTo('head');
  });
  </script>
  <style>
    /* Modern Form Design */
    .form-section {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 5px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .form-section h5 {
        color: #2c3e50;
        margin-bottom: 20px;
        border-bottom: 2px solid #3498db;
        padding-bottom: 10px;
    }

    .form-section h5 i {
        margin-right: 10px;
        color: #3498db;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .form-group label {
        font-weight: 500;
        color: #495057;
    }

    .form-control {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background-color: #f8f9fa;
        width: 100%;
    }

    .form-control:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
    }

    select.form-control {
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%232c3e50' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        padding-right: 2.5rem;
    }

    .required-field::after {
        content: " *";
        color: red;
    }

    .card {
        border: none;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        border-radius: 15px;
        margin-bottom: 30px;
    }

    .card-title {
        color: #2c3e50;
        font-size: 1.8rem;
        font-weight: 600;
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 2px solid #e9ecef;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .card-title i {
        color: #4a90e2;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-primary {
        background-color: #3498db;
        border-color: #3498db;
    }

    .btn-primary:hover {
        background-color: #2980b9;
        border-color: #2980b9;
    }

    .btn-light {
        background-color: #f8f9fa;
        border-color: #e9ecef;
        color: #2c3e50;
    }

    .btn-light:hover {
        background-color: #e9ecef;
        border-color: #dee2e6;
        color: #2c3e50;
    }

    .biometric-upload {
        border: 2px dashed #e9ecef;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        transition: all 0.3s ease;
    }

    .biometric-upload:hover {
        border-color: #4a90e2;
        background-color: #f8f9fa;
    }

    .biometric-upload input[type="file"] {
        display: none;
    }

    .biometric-upload label {
        cursor: pointer;
        color: #4a90e2;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .biometric-upload small {
        display: block;
        margin-top: 8px;
        color: #6c757d;
    }

    .alert {
        display: inline-block;
        padding: 0.5rem 1rem;
        background-color: #dc3545;
        color: white;
        border-radius: 6px;
        font-weight: 600;
        margin-bottom: 20px;
    }

    /* Select2 Customization */
    .select2-container--bootstrap4 .select2-selection {
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        transition: all 0.2s ease-in-out;
    }

    .select2-container--bootstrap4 .select2-selection--single {
        height: calc(2.25rem + 2px);
        padding: 0.375rem 0.75rem;
    }

    .select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered {
        line-height: 1.5;
        padding-left: 0;
    }

    .select2-container--bootstrap4 .select2-selection--single .select2-selection__arrow {
        height: 2.25rem;
    }

    .select2-container--bootstrap4 .select2-dropdown {
        border-color: #ced4da;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .select2-container--bootstrap4 .select2-results__option--highlighted[aria-selected] {
        background-color: #3498db;
    }

    .select2-container--bootstrap4 .select2-results__option[aria-selected=true] {
        background-color: #e9ecef;
    }

    .select2-container--bootstrap4.loading .select2-selection {
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="%23999" d="M12,4V2A10,10 0 0,0 2,12H4A8,8 0 0,1 12,4Z"><animateTransform attributeName="transform" type="rotate" from="0 12 12" to="360 12 12" dur="1s" repeatCount="indefinite"/></path></svg>');
        background-repeat: no-repeat;
        background-position: right 0.5rem center;
        background-size: 1.5rem;
        padding-right: 2.5rem;
        cursor: wait;
    }

    .select2-container--bootstrap4.loading .select2-selection--single .select2-selection__arrow {
        display: none;
    }

    .is-invalid {
        border-color: #dc3545 !important;
    }

    .is-invalid + .select2-container .select2-selection {
        border-color: #dc3545 !important;
    }

    .invalid-feedback {
        display: block;
        width: 100%;
        margin-top: 0.25rem;
        font-size: 80%;
        color: #dc3545;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .form-section {
            padding: 20px;
        }
        
        .card-title {
            font-size: 1.5rem;
        }
        
        .btn {
            width: 100%;
            margin-bottom: 10px;
        }
        
        .row {
            margin-bottom: 0;
        }
    }

    /* Add these styles to your existing styles section */
    .biometric-upload-container {
        margin-top: 1rem;
    }

    .upload-area {
        border: 2px dashed #e0e0e0;
        border-radius: 10px;
        padding: 2rem;
        text-align: center;
        background: #fafafa;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .upload-area:hover {
        border-color: #3498db;
        background: #f8f9fa;
    }

    .upload-area.dragover {
        border-color: #3498db;
        background: #e3f2fd;
    }

    .upload-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #666;
    }

    .upload-content i {
        color: #3498db;
        margin-bottom: 1rem;
    }

    .upload-content h5 {
        margin-bottom: 0.5rem;
        color: #333;
    }

    .preview-area {
        width: 100%;
        margin-top: 1rem;
    }

    .preview-content {
        position: relative;
        display: inline-block;
    }

    .img-preview {
        max-width: 200px;
        max-height: 200px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .preview-actions {
        margin-top: 1rem;
        text-align: center;
    }

    .upload-status {
        font-size: 0.875rem;
    }

    .upload-status.success {
        color: #28a745;
    }

    .upload-status.error {
        color: #dc3545;
    }

    .file-input {
        display: none;
    }

    .btn-outline-primary {
        border-color: #3498db;
        color: #3498db;
    }

    .btn-outline-primary:hover {
        background-color: #3498db;
        color: white;
    }
    
    /* Facial Recognition Styles */
    .facial-recognition-section {
        background: #f8f9fa;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 20px;
        margin-top: 20px;
    }
    
    .facial-recognition-section.active {
        border-color: #3498db;
        background: #f0f8ff;
    }
    
    .face-capture-area {
        border: 3px dashed #e0e0e0;
        border-radius: 15px;
        padding: 30px;
        text-align: center;
        background: #fafafa;
        transition: all 0.3s ease;
        min-height: 200px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    
    .face-capture-area.dragover {
        border-color: #3498db;
        background: #e3f2fd;
    }
    
    .face-capture-area.processing {
        border-color: #ff9800;
        background: #fff3e0;
    }
    
    .face-capture-area.success {
        border-color: #4caf50;
        background: #e8f5e8;
    }
    
    .face-capture-area.error {
        border-color: #f44336;
        background: #ffebee;
    }
    
    .face-preview {
        max-width: 300px;
        max-height: 300px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        margin-bottom: 15px;
    }
    
    .face-detection-overlay {
        position: relative;
        display: inline-block;
    }
    
    .face-detection-canvas {
        position: absolute;
        top: 0;
        left: 0;
        pointer-events: none;
    }
    
    .face-capture-progress {
        width: 100%;
        max-width: 300px;
        margin: 15px 0;
    }
    
    .face-capture-status {
        font-size: 14px;
        font-weight: 600;
        margin-top: 10px;
        padding: 8px 16px;
        border-radius: 20px;
        display: inline-block;
    }
    
    .face-capture-status.success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    
    .face-capture-status.error {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    
    .face-capture-status.processing {
        background: #fff3cd;
        color: #856404;
        border: 1px solid #ffeaa7;
    }
    
    .face-capture-status.info {
        background: #d1ecf1;
        color: #0c5460;
        border: 1px solid #bee5eb;
    }
    
    .face-capture-actions {
        margin-top: 15px;
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        justify-content: center;
    }
    
    .face-metrics {
        display: flex;
        gap: 20px;
        margin-top: 15px;
        flex-wrap: wrap;
        justify-content: center;
    }
    
    .face-metric {
        text-align: center;
        padding: 10px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        min-width: 80px;
    }
    
    .face-metric-value {
        font-size: 18px;
        font-weight: bold;
        color: #3498db;
    }
    
    .face-metric-label {
        font-size: 12px;
        color: #666;
        margin-top: 5px;
    }
    
    .facial-recognition-help {
        background: #e8f4fd;
        border-left: 4px solid #3498db;
        padding: 15px;
        margin-top: 15px;
        border-radius: 0 8px 8px 0;
    }
    
    .facial-recognition-help h6 {
        color: #2980b9;
        margin-bottom: 10px;
        font-weight: 600;
    }
    
    .facial-recognition-help ul {
        margin-bottom: 0;
        padding-left: 20px;
    }
    
    .facial-recognition-help li {
        margin-bottom: 5px;
        color: #34495e;
    }
    
    @media (max-width: 768px) {
        .face-capture-area {
            padding: 20px;
            min-height: 150px;
        }
        
        .face-preview {
            max-width: 200px;
            max-height: 200px;
        }
        
        .face-metrics {
            gap: 10px;
        }
        
        .face-metric {
            min-width: 60px;
            padding: 8px;
        }
    }
  </style>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
          
          
          <?php 
          
          error_reporting(1);
          require_once 'lib/FacialRecognition.php';
          
               if (isset($_POST['btnSubmit'])) {
                   $firstName = $_POST['firstName'];
                   $lastName = $_POST['lastName'];
                   $fathersName = $_POST['fathersName'];
                   $mothersName = $_POST['mothersName'];
                   $gender = $_POST['gender'];
                   $dob = $_POST['dob'];
                   $genotype = $_POST['genotype'];
                   $weight = $_POST['weight'];
                   $bPlace = $_POST['bPlace'];
                   $pod = $_POST['pod'];
                   $state = $_POST['state'];
                   $lga = $_POST['lga'];
                   $father_occupation = $_POST['father_occupation'];
                   $father_nationality = $_POST['fNationality'];
                   $father_religion = $_POST['father_religion'];
                   $mother_nationality = $_POST['mNationality'];
                   $Placeissue = $_POST['Placeissue'];
                   $regCentre = $_POST['regCentre'];
                   $dateReg = date('Y-m-d');
                   $payId = isset($_SESSION['payment_status']) && $_SESSION['payment_status'] === 'paid' ? 1 : 0;  // Set payment status

                   // Get facial recognition data
                   $faceDescriptor = $_POST['face_descriptor'] ?? null;
                   $faceImageData = $_POST['face_image_data'] ?? null;
                   $faceConfidence = $_POST['face_confidence'] ?? null;
                   $faceQuality = $_POST['face_quality'] ?? null;
                   $faceLandmarks = $_POST['face_landmarks'] ?? null;
                   $faceProcessed = $_POST['face_processed'] ?? '0';

                   // Validate facial recognition data
                   if ($faceProcessed !== '1' || !$faceDescriptor || !$faceImageData) {
                       echo "<script>alert('Error: Facial recognition data is required. Please capture a face photo.');</script>";
                       exit;
                   }

                   // Handle biometric data
                   if (!isset($_FILES['biofield']) || $_FILES['biofield']['error'] != 0) {
                       $error_msg = isset($_FILES['biofield']) ? "Upload error code: " . $_FILES['biofield']['error'] : "No file uploaded";
                       echo "<script>alert('Error: " . $error_msg . "');</script>";
                       exit;
                   }

                   // Verify file type
                   $allowed_types = array('image/jpeg', 'image/png', 'image/gif');
                   if (!in_array($_FILES['biofield']['type'], $allowed_types)) {
                       echo "<script>alert('Error: Invalid file type. Only JPG, PNG and GIF images are allowed.');</script>";
                       exit;
                   }

                   // Create directory if it doesn't exist
                   $upload_dir = "images/fingerprints/";
                   if (!file_exists($upload_dir)) {
                       if (!mkdir($upload_dir, 0777, true)) {
                           echo "<script>alert('Error: Could not create upload directory');</script>";
                           exit;
                       }
                   }

                   // Ensure directory is writable
                   if (!is_writable($upload_dir)) {
                       echo "<script>alert('Error: Upload directory is not writable');</script>";
                       exit;
                   }

                   $date = date('m/d/Yh:i:sa', time());
                   $rand = rand(10000, 99999);
                   $encname = $date . $rand;
                   $bioname = md5($encname);
                   $bannerpath = $upload_dir . $bioname;

                   // Try to move the uploaded file
                   if (!move_uploaded_file($_FILES["biofield"]["tmp_name"], $bannerpath)) {
                       $error = error_get_last();
                       echo "<script>alert('Error: Could not save biometric data. " . ($error ? $error['message'] : '') . "');</script>";
                       exit;
                   }

                   // Verify the file was moved successfully
                   if (!file_exists($bannerpath)) {
                       echo "<script>alert('Error: File was not saved properly');</script>";
                       exit;
                   }

                   // Read file contents for database storage
                   $imgData = addslashes(file_get_contents($bannerpath));
                   if ($imgData === false) {
                       echo "<script>alert('Error: Could not read biometric file');</script>";
                       exit;
                   }

                   $imageProperties = getimageSize($bannerpath);
                   if ($imageProperties === false) {
                       echo "<script>alert('Error: Invalid image file');</script>";
                       exit;
                   }

                   // Check for duplicate registration
                   $duplicate_query = $con->query("SELECT * FROM tblbirth WHERE firstName = '$firstName' AND mothersName = '$mothersName'");
                   if (mysqli_num_rows($duplicate_query) > 0) {
                       echo "<script>alert('Error: This birth record already exists');</script>";
                       exit;
                   }

                   // Get next certificate number
                   $query = $con->query("SELECT * FROM tblcertno WHERE certId = '100000'") or die(mysqli_error($con));
                   $row = mysqli_fetch_array($query);
                   if (!$row) {
                       echo "<script>alert('Error: Could not get certificate number');</script>";
                       exit;
                   }

                   $newCertNo = $row['lastCertId'] + 1;
                   $newNum = "GHBR";
                   $newNum1 = $newNum . $newCertNo;

                   // Update certificate number
                   $updateCert = $con->query("UPDATE tblcertno SET lastCertId = '$newCertNo' WHERE certId = '100000'") or die(mysqli_error($con));
                   if (!$updateCert) {
                       echo "<script>alert('Error: Could not update certificate number');</script>";
                       exit;
                   }

                   // Insert birth record with facial recognition enabled flag
                   $result = $con->query("INSERT INTO tblbirth (certNo, firstName, lastName, fathersName, mothersName, gender, genotype, weight, birthPlace, state, lga, dateOfBirth, PlaceOfIssue, regCentre, dateReg, pod, father_occupation, father_nationality, father_religion, mother_nationality, biometric, imageType, payId, has_facial_data, facial_verification_enabled, face_capture_date) 
                                        VALUES ('$newNum1', '$firstName', '$lastName', '$fathersName', '$mothersName', '$gender', '$genotype', '$weight', '$bPlace', '$state', '$lga', '$dob', '$Placeissue', '$regCentre', '$dateReg', '$pod', '$father_occupation', '$father_nationality', '$father_religion', '$mother_nationality', '$imgData', '{$imageProperties['mime']}', '$payId', 1, 1, NOW())") 
                                        or die(mysqli_error($con));

                   if ($result) {
                       // Get the inserted birth ID
                       $birthId = mysqli_insert_id($con);
                       
                       // Initialize facial recognition and store facial data
                       try {
                           $facialRecognition = new FacialRecognition();
                           
                           // Parse facial data
                           $descriptor = json_decode($faceDescriptor, true);
                           if (!is_array($descriptor)) {
                               throw new Exception('Invalid face descriptor format');
                           }
                           
                           // Remove data URL prefix from image if present
                           if (strpos($faceImageData, 'data:image') === 0) {
                               $faceImageData = substr($faceImageData, strpos($faceImageData, ',') + 1);
                           }
                           
                           // Store facial recognition data
                           $faceResult = $facialRecognition->storeFacialData(
                               $birthId,
                               $faceImageData,
                               $descriptor,
                               floatval($faceConfidence)
                           );
                           
                           if (!$faceResult['success']) {
                               // Log error but don't fail the registration
                               error_log("Failed to store facial data for birth ID $birthId: " . $faceResult['error']);
                               
                               // Update birth record to indicate facial data storage failed
                               $con->query("UPDATE tblbirth SET has_facial_data = 0 WHERE birthId = $birthId");
                               
                               echo "<script>alert('Birth registration successful, but facial recognition data could not be stored. Certificate: $newNum1');</script>";
                           } else {
                               // Success - both birth record and facial data stored
                               echo "<script>alert('Birth registration and facial recognition data stored successfully! Certificate: $newNum1');</script>";
                           }
                           
                       } catch (Exception $e) {
                           // Log error but don't fail the registration
                           error_log("Facial recognition error for birth ID $birthId: " . $e->getMessage());
                           
                           // Update birth record to indicate facial data storage failed
                           $con->query("UPDATE tblbirth SET has_facial_data = 0 WHERE birthId = $birthId");
                           
                           echo "<script>alert('Birth registration successful, but facial recognition setup failed. Certificate: $newNum1');</script>";
                       }
                       
                       // Clear payment status after successful registration
                       unset($_SESSION['payment_status']);
                       
                       echo "<script>
                           setTimeout(function() {
                               window.location = 'BirthRegistration.php';
                           }, 2000);
                       </script>";
                       
                   } else {
                       echo "<script>alert('Error: Registration failed');</script>";
                   }
               }
           ?>

          
          
          <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">
                      <i class="fas fa-baby"></i> Birth Registration
                  </h4>
                  
                  <?php if (!isset($_SESSION['payment_status']) || $_SESSION['payment_status'] !== 'paid'): ?>
                  <div class="alert">
                      <i class="fas fa-exclamation-circle"></i> Payment Required
                  </div>
                  <?php endif; ?>
                  
                  <form class="form-sample" method="post" action="#" enctype="multipart/form-data">
                      <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
                      
                      <!-- Child's Information Section -->
                      <div class="form-section">
                          <h5><i class="fas fa-baby"></i> Child's Information</h5>
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label class="required-field">First Name</label>
                                      <input type="text" name="firstName" required class="form-control text-only" 
                                             placeholder="Enter first name"/>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label class="required-field">Last Name</label>
                                      <input type="text" name="lastName" required class="form-control text-only" 
                                             placeholder="Enter last name"/>
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label class="required-field">Gender</label>
                                      <select name="gender" required class="form-control select2">
                                          <option value="">Select Gender</option>
                                          <option value="Male">Male</option>
                                          <option value="Female">Female</option>
                                      </select>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label class="required-field">Date of Birth</label>
                                      <input class="form-control" id="datefield" required name="dob" 
                                             type="date" min="1899-01-01" max="2000-13-13"/>
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label class="required-field">Genotype</label>
                                      <select class="form-control select2" required name="genotype">
                                          <option value="">Select Genotype</option>
                                          <option value="AA">AA</option>
                                          <option value="AS">AS</option>
                                          <option value="SS">SS</option>
                                          <option value="NA">Not Available</option>
                                      </select>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label class="required-field">Weight (kg)</label>
                                      <input class="form-control" required name="weight" type="number" 
                                             step="0.01" min="0" max="10" placeholder="Enter weight in kg"/>
                                  </div>
                              </div>
                          </div>
                      </div>

                      <!-- Parents Information Section -->
                      <div class="form-section">
                          <h5><i class="fas fa-users"></i> Parents Information</h5>
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label class="required-field">Father's Full Name</label>
                                      <input type="text" name="fathersName" required class="form-control text-only" 
                                             placeholder="Enter father's full name"/>
                                  </div>
                                  <div class="form-group">
                                      <label class="required-field">Father's Occupation</label>
                                      <input type="text" name="father_occupation" required class="form-control text-only" 
                                             placeholder="Enter father's occupation"/>
                                  </div>
                                  <div class="form-group">
                                      <label class="required-field">Father's Nationality</label>
                                      <select name="fNationality" class="form-control select2" required>
                                          <option value="">Select Nationality</option>
                                          <?php foreach (getNationalities() as $nationality): ?>
                                              <option value="<?php echo htmlspecialchars($nationality); ?>">
                                                  <?php echo htmlspecialchars($nationality); ?>
                                              </option>
                                          <?php endforeach; ?>
                                      </select>
                                  </div>
                                  <div class="form-group">
                                      <label class="required-field">Father's Religion</label>
                                      <select name="father_religion" class="form-control select2" required>
                                          <option value="">Select Religion</option>
                                          <option value="Christianity">Christianity</option>
                                          <option value="Islam">Islam</option>
                                          <option value="Traditional">Traditional</option>
                                          <option value="Other">Other</option>
                                      </select>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label class="required-field">Mother's Full Name</label>
                                      <input type="text" name="mothersName" required class="form-control text-only" 
                                             placeholder="Enter mother's full name"/>
                                  </div>
                                  <div class="form-group">
                                      <label class="required-field">Mother's Nationality</label>
                                      <select name="mNationality" class="form-control select2" required>
                                          <option value="">Select Nationality</option>
                                          <?php foreach (getNationalities() as $nationality): ?>
                                              <option value="<?php echo htmlspecialchars($nationality); ?>">
                                                  <?php echo htmlspecialchars($nationality); ?>
                                              </option>
                                          <?php endforeach; ?>
                                      </select>
                                  </div>
                              </div>
                          </div>
                      </div>

                      <!-- Birth Location Section -->
                      <div class="form-section">
                          <h5><i class="fas fa-map-marker-alt"></i> Birth Location Information</h5>
                          <div class="row">
                              <div class="col-md-4">
                                  <div class="form-group">
                                      <label class="required-field">Region</label>
                                      <select name="state" class="form-control select2 region-select" required>
                                          <option value="">Select Region</option>
                                          <?php foreach (getRegions() as $region): ?>
                                              <option value="<?php echo htmlspecialchars($region); ?>">
                                                  <?php echo htmlspecialchars($region); ?>
                                              </option>
                                          <?php endforeach; ?>
                                      </select>
                                  </div>
                              </div>
                              <div class="col-md-4">
                                  <div class="form-group">
                                      <label class="required-field">District</label>
                                      <select name="lga" class="form-control select2 district-select" required>
                                          <option value="">Select District</option>
                                      </select>
                                  </div>
                              </div>
                              <div class="col-md-4">
                                  <div class="form-group">
                                      <label class="required-field">Town</label>
                                      <select name="bPlace" class="form-control select2 town-select" required>
                                          <option value="">Select Town</option>
                                      </select>
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label class="required-field">Place of Delivery</label>
                                      <select name="pod" required class="form-control select2">
                                          <option value="">Select Place of Delivery</option>
                                          <option value="Hospital">Hospital</option>
                                          <option value="Clinic">Clinic</option>
                                          <option value="Maternity Home">Maternity Home</option>
                                          <option value="House">House</option>
                                          <option value="Other">Other</option>
                                      </select>
                                  </div>
                              </div>
                          </div>
                      </div>

                      <!-- Registration Details Section -->
                      <div class="form-section">
                          <h5><i class="fas fa-file-alt"></i> Registration Details</h5>
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label class="required-field">Place of Issue</label>
                                      <select name="Placeissue" required class="form-control select2">
                                          <option value="">Select Place of Issue</option>
                                          <option value="Birth and Registry,Ghana">Birth and Registry, Ghana</option>
                                          <option value="KORLE BU TEACHING HOSPITAL">KORLE BU TEACHING HOSPITAL</option>
                                          <option value="Mamprobi Polyclinic">Mamprobi Polyclinic</option>
                                          <option value="LA Dade Kotopon">LA Dade Kotopon</option>
                                      </select>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label class="required-field">Registration Centre</label>
                                      <select name="regCentre" required class="form-control select2">
                                          <option value="">Select Registration Centre</option>
                                          <option value="Birth and Registry,Ghana">Birth and Registry, Ghana</option>
                                          <option value="KORLE BU TEACHING HOSPITAL">KORLE BU TEACHING HOSPITAL</option>
                                          <option value="Mamprobi Polyclinic">Mamprobi Polyclinic</option>
                                          <option value="LA Dade Kotopon">LA Dade Kotopon</option>
                                      </select>
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-12">
                                  <div class="form-group">
                                      <label class="required-field">Biometric Data</label>
                                      <div class="biometric-upload-container">
                                          <div class="upload-area" id="uploadArea">
                                              <div class="upload-content" id="uploadContent">
                                                  <i class="fas fa-fingerprint fa-3x mb-3"></i>
                                                  <h5>Upload Biometric Data</h5>
                                                  <p class="text-muted">Drag and drop your biometric image here or click to browse</p>
                                                  <small class="text-muted d-block mb-3">Supported formats: JPG, PNG, GIF (Max size: 1MB)</small>
                                                  <input type="file" id="biofield" name="biofield" class="file-input" 
                                                         accept="image/*" required hidden/>
                                                  <button type="button" class="btn btn-outline-primary" onclick="document.getElementById('biofield').click()">
                                                      <i class="fas fa-upload"></i> Choose File
                                                  </button>
                                              </div>
                                              <div class="preview-area" id="previewArea" style="display: none;">
                                                  <div class="preview-content">
                                                      <img id="imagePreview" src="" alt="Preview" class="img-preview"/>
                                                      <div class="preview-actions">
                                                          <button type="button" class="btn btn-danger btn-sm" onclick="removeImage()">
                                                              <i class="fas fa-trash"></i> Remove
                                                          </button>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="upload-status mt-2" id="uploadStatus"></div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          
                          <!-- Facial Recognition Section -->
                          <div class="row">
                              <div class="col-md-12">
                                  <div class="form-group">
                                      <label class="required-field">Facial Recognition Data</label>
                                      <div class="facial-recognition-section" id="facialRecognitionSection">
                                          <div class="face-capture-area" id="faceCaptureArea">
                                              <div id="faceCaptureContent">
                                                  <i class="fas fa-user-circle fa-4x mb-3" style="color: #3498db;"></i>
                                                  <h5>Capture Face for Recognition</h5>
                                                  <p class="text-muted">Use your camera or upload a photo showing the child's face for biometric verification</p>
                                                  <small class="text-muted d-block mb-3">This will be used for certificate verification and security</small>
                                                  
                                                  <!-- Camera or Upload Options -->
                                                  <div class="capture-options mb-3">
                                                      <button type="button" class="btn btn-primary me-2" id="useCameraBtn">
                                                          <i class="fas fa-camera"></i> Use Camera
                                                      </button>
                                                      <button type="button" class="btn btn-outline-primary" id="uploadFileBtn">
                                                          <i class="fas fa-upload"></i> Upload Photo
                                                      </button>
                                                  </div>
                                                  
                                                  <input type="file" id="faceImageField" class="file-input" 
                                                         accept="image/*" required hidden/>
                                              </div>
                                              
                                              <!-- Camera Capture Interface -->
                                              <div id="cameraInterface" style="display: none;">
                                                  <div id="cameraContainer"></div>
                                              </div>
                                              
                                              <!-- Face Processing Area -->
                                              <div id="faceProcessingArea" style="display: none;">
                                                  <div class="face-detection-overlay" id="faceDetectionOverlay">
                                                      <img id="facePreview" src="" alt="Face Preview" class="face-preview"/>
                                                      <canvas id="faceDetectionCanvas" class="face-detection-canvas"></canvas>
                                                  </div>
                                                  
                                                  <!-- Progress Bar -->
                                                  <div class="progress face-capture-progress" id="faceProgress" style="display: none;">
                                                      <div class="progress-bar progress-bar-striped progress-bar-animated" 
                                                           role="progressbar" style="width: 0%" id="faceProgressBar">
                                                          <span id="faceProgressText">Processing...</span>
                                                      </div>
                                                  </div>
                                                  
                                                  <!-- Status Display -->
                                                  <div id="faceStatus" class="face-capture-status" style="display: none;"></div>
                                                  
                                                  <!-- Face Metrics -->
                                                  <div id="faceMetrics" class="face-metrics" style="display: none;">
                                                      <div class="face-metric">
                                                          <div class="face-metric-value" id="faceConfidence">-</div>
                                                          <div class="face-metric-label">Confidence</div>
                                                      </div>
                                                      <div class="face-metric">
                                                          <div class="face-metric-value" id="faceQuality">-</div>
                                                          <div class="face-metric-label">Quality</div>
                                                      </div>
                                                  </div>
                                                  
                                                  <!-- Action Buttons -->
                                                  <div class="face-capture-actions" id="faceActions" style="display: none;">
                                                      <button type="button" class="btn btn-success" id="acceptFaceBtn" style="display: none;">
                                                          <i class="fas fa-check"></i> Accept Face
                                                      </button>
                                                      <button type="button" class="btn btn-warning" id="retryFaceBtn">
                                                          <i class="fas fa-redo"></i> Try Another Photo
                                                      </button>
                                                      <button type="button" class="btn btn-danger" id="cancelFaceBtn">
                                                          <i class="fas fa-times"></i> Cancel
                                                      </button>
                                                  </div>
                                              </div>
                                          </div>
                                          
                                          <!-- Help Section -->
                                          <div class="facial-recognition-help">
                                              <h6><i class="fas fa-info-circle"></i> Face Photo Guidelines</h6>
                                              <ul>
                                                  <li>Use a clear, recent photo showing the full face</li>
                                                  <li>Ensure good lighting with no shadows on the face</li>
                                                  <li>Face should be straight and looking at the camera</li>
                                                  <li>Avoid glasses, hats, or anything covering the face</li>
                                                  <li>Only one person should be visible in the photo</li>
                                                  <li>Recommended size: at least 400x400 pixels</li>
                                              </ul>
                                          </div>
                                      </div>
                                      
                                      <!-- Hidden fields for facial recognition data -->
                                      <input type="hidden" id="faceDescriptor" name="face_descriptor" />
                                      <input type="hidden" id="faceImageData" name="face_image_data" />
                                      <input type="hidden" id="faceConfidenceValue" name="face_confidence" />
                                      <input type="hidden" id="faceQualityValue" name="face_quality" />
                                      <input type="hidden" id="faceLandmarks" name="face_landmarks" />
                                      <input type="hidden" id="faceProcessed" name="face_processed" value="0" />
                                  </div>
                              </div>
                          </div>
                      </div>

                      <!-- Form Actions -->
                      <div class="row mt-4">
                          <div class="col-12 text-right">
                              <button type="reset" class="btn btn-light">
                                  <i class="fas fa-undo"></i> Clear Form
                              </button>
                              <button type="submit" name="btnSubmit" class="btn btn-primary">
                                  <i class="fas fa-save"></i> Register Birth
                              </button>
                          </div>
                      </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
       
          

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
  <script>
  // Add this to your existing scripts section
  document.addEventListener('DOMContentLoaded', function() {
      const uploadArea = document.getElementById('uploadArea');
      const uploadContent = document.getElementById('uploadContent');
      const previewArea = document.getElementById('previewArea');
      const imagePreview = document.getElementById('imagePreview');
      const fileInput = document.getElementById('biofield');
      const uploadStatus = document.getElementById('uploadStatus');

      // Drag and drop handlers
      ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
          uploadArea.addEventListener(eventName, preventDefaults, false);
      });

      function preventDefaults(e) {
          e.preventDefault();
          e.stopPropagation();
      }

      ['dragenter', 'dragover'].forEach(eventName => {
          uploadArea.addEventListener(eventName, highlight, false);
      });

      ['dragleave', 'drop'].forEach(eventName => {
          uploadArea.addEventListener(eventName, unhighlight, false);
      });

      function highlight(e) {
          uploadArea.classList.add('dragover');
      }

      function unhighlight(e) {
          uploadArea.classList.remove('dragover');
      }

      uploadArea.addEventListener('drop', handleDrop, false);

      function handleDrop(e) {
          const dt = e.dataTransfer;
          const files = dt.files;
          handleFiles(files);
      }

      fileInput.addEventListener('change', function(e) {
          handleFiles(this.files);
      });

      function handleFiles(files) {
          if (files.length > 0) {
              const file = files[0];
              
              // Validate file type
              const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
              if (!validTypes.includes(file.type)) {
                  showStatus('Please upload a valid image file (JPG, PNG, or GIF)', 'error');
                  return;
              }

              // Validate file size (1MB max)
              if (file.size > 1024 * 1024) {
                  showStatus('File size must be less than 1MB', 'error');
                  return;
              }

              const reader = new FileReader();
              reader.onload = function(e) {
                  imagePreview.src = e.target.result;
                  uploadContent.style.display = 'none';
                  previewArea.style.display = 'block';
                  showStatus('File selected successfully', 'success');
              }
              reader.readAsDataURL(file);
          }
      }

      function removeImage() {
          fileInput.value = '';
          imagePreview.src = '';
          uploadContent.style.display = 'flex';
          previewArea.style.display = 'none';
          showStatus('', '');
      }

      function showStatus(message, type) {
          uploadStatus.textContent = message;
          uploadStatus.className = 'upload-status ' + type;
      }
  });
  </script>
  <!-- Custom validation script -->
  <script src="js/custom-validation.js"></script>
  <script>
    // Initialize text-only validation when the document is ready
    document.addEventListener('DOMContentLoaded', function() {
        initializeTextOnlyFields();
        initializeFacialRecognition();
    });
    
    // Facial Recognition Initialization and Handlers
    let facialRecognitionClient;
    let cameraClient;
    let currentBirthId;
    
    async function initializeFacialRecognition() {
        try {
            facialRecognitionClient = new FacialRecognitionClient();
            cameraClient = new CameraCaptureClient();
            
            // Set up callbacks for facial recognition
            facialRecognitionClient.setCallbacks({
                onProgress: updateFaceProgress,
                onSuccess: handleFaceSuccess,
                onError: handleFaceError
            });
            
            // Set up callbacks for camera capture
            cameraClient.setCallbacks({
                onCameraReady: handleCameraReady,
                onCameraError: handleCameraError,
                onPhotoCapture: handleCameraPhotoCapture,
                onStreamEnd: handleCameraStreamEnd
            });
            
            // Set up event listeners
            setupFaceEventListeners();
            setupCameraEventListeners();
            
            console.log('Facial recognition and camera capture initialized successfully');
            
        } catch (error) {
            console.error('Failed to initialize facial recognition:', error);
            showFaceStatus('Facial recognition initialization failed: ' + error.message, 'error');
        }
    }
    
    function setupFaceEventListeners() {
        const faceImageField = document.getElementById('faceImageField');
        const faceCaptureArea = document.getElementById('faceCaptureArea');
        const acceptFaceBtn = document.getElementById('acceptFaceBtn');
        const retryFaceBtn = document.getElementById('retryFaceBtn');
        const cancelFaceBtn = document.getElementById('cancelFaceBtn');
        
        // File input change handler
        faceImageField.addEventListener('change', handleFaceImageSelect);
        
        // Drag and drop handlers
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            faceCaptureArea.addEventListener(eventName, preventDefaults, false);
        });
        
        ['dragenter', 'dragover'].forEach(eventName => {
            faceCaptureArea.addEventListener(eventName, () => {
                faceCaptureArea.classList.add('dragover');
            }, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            faceCaptureArea.addEventListener(eventName, () => {
                faceCaptureArea.classList.remove('dragover');
            }, false);
        });
        
        faceCaptureArea.addEventListener('drop', handleFaceDrop, false);
        
        // Button handlers
        acceptFaceBtn.addEventListener('click', acceptFaceData);
        retryFaceBtn.addEventListener('click', retryFaceCapture);
        cancelFaceBtn.addEventListener('click', cancelFaceCapture);
        
        // Form submission validation
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', validateFaceDataBeforeSubmit);
        }
    }
    
    function setupCameraEventListeners() {
        const useCameraBtn = document.getElementById('useCameraBtn');
        const uploadFileBtn = document.getElementById('uploadFileBtn');
        
        if (useCameraBtn) {
            useCameraBtn.addEventListener('click', showCameraInterface);
        }
        
        if (uploadFileBtn) {
            uploadFileBtn.addEventListener('click', showFileUploadInterface);
        }
    }
    
    function showCameraInterface() {
        try {
            // Hide file upload interface
            document.getElementById('faceCaptureContent').style.display = 'none';
            
            // Show camera interface
            const cameraInterface = document.getElementById('cameraInterface');
            cameraInterface.style.display = 'block';
            
            // Create camera UI
            cameraClient.createCameraUI('cameraContainer');
            
            // Update status
            showFaceStatus('Camera interface ready. Click "Start Camera" to begin.', 'info');
            
        } catch (error) {
            console.error('Failed to show camera interface:', error);
            showFaceStatus('Failed to initialize camera interface: ' + error.message, 'error');
        }
    }
    
    function showFileUploadInterface() {
        // Hide camera interface
        document.getElementById('cameraInterface').style.display = 'none';
        
        // Show file upload interface
        document.getElementById('faceCaptureContent').style.display = 'block';
        
        // Trigger file input
        document.getElementById('faceImageField').click();
    }
    
    // Camera event handlers
    function handleCameraReady() {
        showFaceStatus('Camera is ready. Position your face in the oval guide and click "Capture Photo".', 'success');
    }
    
    function handleCameraError(error) {
        console.error('Camera error:', error);
        let errorMessage = 'Camera error: ' + error.message;
        
        if (error.name === 'NotAllowedError') {
            errorMessage = 'Camera access denied. Please allow camera permissions and try again.';
        } else if (error.name === 'NotFoundError') {
            errorMessage = 'No camera found. Please connect a camera and try again.';
        } else if (error.name === 'NotReadableError') {
            errorMessage = 'Camera is being used by another application. Please close other apps and try again.';
        }
        
        showFaceStatus(errorMessage, 'error');
    }
    
    async function handleCameraPhotoCapture(imageData) {
        try {
            showFaceStatus('Photo captured! Processing facial recognition...', 'info');
            
            // Process the captured image with facial recognition
            await processCapturedImage(imageData.file);
            
            // Show capture preview
            showCapturedPhotoPreview(imageData.dataUrl);
            
        } catch (error) {
            console.error('Failed to process captured photo:', error);
            showFaceStatus('Failed to process captured photo: ' + error.message, 'error');
        }
    }
    
    function handleCameraStreamEnd() {
        showFaceStatus('Camera stopped.', 'info');
    }
    
    function showCapturedPhotoPreview(dataUrl) {
        const cameraContainer = document.getElementById('cameraContainer');
        
        // Add preview section if it doesn't exist
        let previewSection = document.getElementById('capturedPhotoPreview');
        if (!previewSection) {
            previewSection = document.createElement('div');
            previewSection.id = 'capturedPhotoPreview';
            previewSection.className = 'captured-photo-preview';
            cameraContainer.appendChild(previewSection);
        }
        
        previewSection.innerHTML = `
            <h5><i class="fas fa-image"></i> Captured Photo</h5>
            <img src="${dataUrl}" alt="Captured Face" class="img-fluid mb-3">
            <div class="captured-photo-actions">
                <button type="button" class="btn btn-success" onclick="acceptCapturedPhoto()">
                    <i class="fas fa-check"></i> Accept Photo
                </button>
                <button type="button" class="btn btn-warning" onclick="retakeCameraPhoto()">
                    <i class="fas fa-redo"></i> Retake Photo
                </button>
                <button type="button" class="btn btn-secondary" onclick="switchToFileUpload()">
                    <i class="fas fa-upload"></i> Upload Instead
                </button>
            </div>
        `;
    }
    
    function acceptCapturedPhoto() {
        // Hide camera interface and show success
        document.getElementById('cameraInterface').style.display = 'none';
        document.getElementById('faceCaptureContent').style.display = 'block';
        
        // Update the main interface to show photo accepted
        document.getElementById('faceCaptureContent').innerHTML = `
            <i class="fas fa-check-circle fa-4x mb-3" style="color: #28a745;"></i>
            <h5>Face Photo Captured Successfully</h5>
            <p class="text-success">Face photo has been captured and processed for biometric verification.</p>
            <div class="mt-3">
                <button type="button" class="btn btn-warning" onclick="retakePhoto()">
                    <i class="fas fa-camera"></i> Take Another Photo
                </button>
            </div>
        `;
        
        showFaceStatus('Face photo accepted and ready for registration.', 'success');
    }
    
    function retakeCameraPhoto() {
        // Remove preview and restart camera
        const previewSection = document.getElementById('capturedPhotoPreview');
        if (previewSection) {
            previewSection.remove();
        }
        
        showFaceStatus('Ready to capture another photo.', 'info');
    }
    
    function switchToFileUpload() {
        // Stop camera and switch to file upload
        cameraClient.stopCamera();
        showFileUploadInterface();
    }
    
    function retakePhoto() {
        // Reset the interface to show capture options again
        document.getElementById('faceCaptureContent').innerHTML = `
            <i class="fas fa-user-circle fa-4x mb-3" style="color: #3498db;"></i>
            <h5>Capture Face for Recognition</h5>
            <p class="text-muted">Use your camera or upload a photo showing the child's face for biometric verification</p>
            <small class="text-muted d-block mb-3">This will be used for certificate verification and security</small>
            
            <div class="capture-options mb-3">
                <button type="button" class="btn btn-primary me-2" id="useCameraBtn">
                    <i class="fas fa-camera"></i> Use Camera
                </button>
                <button type="button" class="btn btn-outline-primary" id="uploadFileBtn">
                    <i class="fas fa-upload"></i> Upload Photo
                </button>
            </div>
            
            <input type="file" id="faceImageField" class="file-input" 
                   accept="image/*" required hidden/>
        `;
        
        // Re-setup event listeners
        setupCameraEventListeners();
        setupFaceEventListeners();
        
        // Reset hidden fields
        resetFaceCapture();
    }
    
    async function processCapturedImage(file) {
        // Use the existing facial recognition processing logic
        await processFaceImage(file);
    }
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    async function handleFaceImageSelect(event) {
        const file = event.target.files[0];
        if (file) {
            await processFaceImage(file);
        }
    }
    
    async function handleFaceDrop(event) {
        const files = event.dataTransfer.files;
        if (files.length > 0) {
            await processFaceImage(files[0]);
        }
    }
    
    async function processFaceImage(file) {
        try {
            // Validate file
            if (!file.type.startsWith('image/')) {
                throw new Error('Please select a valid image file');
            }
            
            if (file.size > 5 * 1024 * 1024) { // 5MB limit
                throw new Error('Image file is too large. Please use an image smaller than 5MB');
            }
            
            // Show processing state
            showFaceProcessingArea();
            showFaceProgress('Initializing face detection...', 10);
            
            // Initialize face-api if not already done
            await facialRecognitionClient.initialize(updateFaceProgress);
            
            // Display image preview
            const imageUrl = URL.createObjectURL(file);
            const facePreview = document.getElementById('facePreview');
            facePreview.src = imageUrl;
            facePreview.onload = async () => {
                URL.revokeObjectURL(imageUrl);
                await detectAndProcessFace(facePreview, file);
            };
            
        } catch (error) {
            console.error('Face processing error:', error);
            handleFaceError(error);
        }
    }
    
    async function detectAndProcessFace(imageElement, file) {
        try {
            showFaceProgress('Detecting face...', 30);
            
            // Detect faces
            const detection = await facialRecognitionClient.detectFaces(imageElement);
            
            if (!detection.success) {
                throw new Error('Face detection failed: ' + detection.error);
            }
            
            if (detection.faceCount === 0) {
                throw new Error('No face detected in the image. Please use a clear photo showing a face.');
            }
            
            if (detection.faceCount > 1) {
                throw new Error('Multiple faces detected. Please use a photo with only one person.');
            }
            
            showFaceProgress('Processing facial features...', 60);
            
            const faceDetection = detection.detections[0];
            const confidence = faceDetection.detection.score;
            
            // Check confidence threshold
            if (confidence < 0.5) {
                throw new Error(`Face detection confidence too low (${(confidence * 100).toFixed(1)}%). Please use a clearer image.`);
            }
            
            // Draw detection overlay
            drawFaceDetection(faceDetection);
            
            // Extract face data
            const descriptor = Array.from(faceDetection.descriptor);
            const landmarks = facialRecognitionClient.extractLandmarks(faceDetection.landmarks);
            const qualityScore = facialRecognitionClient.calculateQualityScore(faceDetection);
            
            // Convert image to base64
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            canvas.width = imageElement.width;
            canvas.height = imageElement.height;
            ctx.drawImage(imageElement, 0, 0);
            const imageData = canvas.toDataURL('image/jpeg', 0.9);
            
            // Store data in hidden fields
            document.getElementById('faceDescriptor').value = JSON.stringify(descriptor);
            document.getElementById('faceImageData').value = imageData;
            document.getElementById('faceConfidenceValue').value = confidence;
            document.getElementById('faceQualityValue').value = qualityScore;
            document.getElementById('faceLandmarks').value = JSON.stringify(landmarks);
            
            showFaceProgress('Face processing complete!', 100);
            
            // Update metrics display
            updateFaceMetrics(confidence, qualityScore);
            
            // Show success state
            setTimeout(() => {
                showFaceStatus('Face detected and processed successfully!', 'success');
                showFaceActions(true);
                document.getElementById('faceProcessed').value = '1';
            }, 500);
            
        } catch (error) {
            console.error('Face detection error:', error);
            handleFaceError(error);
        }
    }
    
    function drawFaceDetection(detection) {
        const canvas = document.getElementById('faceDetectionCanvas');
        const preview = document.getElementById('facePreview');
        
        canvas.width = preview.width;
        canvas.height = preview.height;
        canvas.style.width = preview.style.width;
        canvas.style.height = preview.style.height;
        
        facialRecognitionClient.drawDetections(canvas, [detection], {
            drawBox: true,
            drawLandmarks: true,
            boxColor: '#00ff00',
            landmarkColor: '#ff0000'
        });
    }
    
    function showFaceProcessingArea() {
        document.getElementById('faceCaptureContent').style.display = 'none';
        document.getElementById('faceProcessingArea').style.display = 'block';
        document.getElementById('facialRecognitionSection').classList.add('active');
        document.getElementById('faceCaptureArea').classList.add('processing');
    }
    
    function showFaceProgress(message, percentage) {
        const progress = document.getElementById('faceProgress');
        const progressBar = document.getElementById('faceProgressBar');
        const progressText = document.getElementById('faceProgressText');
        
        progress.style.display = 'block';
        progressBar.style.width = percentage + '%';
        progressText.textContent = message;
    }
    
    function hideFaceProgress() {
        document.getElementById('faceProgress').style.display = 'none';
    }
    
    function updateFaceProgress(message) {
        console.log('Face processing:', message);
        // You can update progress here if needed
    }
    
    function showFaceStatus(message, type) {
        const status = document.getElementById('faceStatus');
        status.textContent = message;
        status.className = 'face-capture-status ' + type;
        status.style.display = 'block';
        
        // Update capture area class
        const captureArea = document.getElementById('faceCaptureArea');
        captureArea.className = 'face-capture-area ' + type;
    }
    
    function updateFaceMetrics(confidence, quality) {
        document.getElementById('faceConfidence').textContent = (confidence * 100).toFixed(1) + '%';
        document.getElementById('faceQuality').textContent = (quality * 100).toFixed(1) + '%';
        document.getElementById('faceMetrics').style.display = 'flex';
    }
    
    function showFaceActions(showAccept = false) {
        const actions = document.getElementById('faceActions');
        const acceptBtn = document.getElementById('acceptFaceBtn');
        
        actions.style.display = 'flex';
        acceptBtn.style.display = showAccept ? 'block' : 'none';
    }
    
    function acceptFaceData() {
        showFaceStatus('Face data accepted and ready for registration', 'success');
        document.getElementById('acceptFaceBtn').style.display = 'none';
        hideFaceProgress();
    }
    
    function retryFaceCapture() {
        resetFaceCapture();
        document.getElementById('faceImageField').click();
    }
    
    function cancelFaceCapture() {
        resetFaceCapture();
    }
    
    function resetFaceCapture() {
        // Clear hidden fields
        document.getElementById('faceDescriptor').value = '';
        document.getElementById('faceImageData').value = '';
        document.getElementById('faceConfidenceValue').value = '';
        document.getElementById('faceQualityValue').value = '';
        document.getElementById('faceLandmarks').value = '';
        document.getElementById('faceProcessed').value = '0';
        
        // Clear file input
        document.getElementById('faceImageField').value = '';
        
        // Reset UI
        document.getElementById('faceCaptureContent').style.display = 'block';
        document.getElementById('faceProcessingArea').style.display = 'none';
        document.getElementById('faceStatus').style.display = 'none';
        document.getElementById('faceMetrics').style.display = 'none';
        document.getElementById('faceActions').style.display = 'none';
        hideFaceProgress();
        
        // Reset classes
        document.getElementById('facialRecognitionSection').classList.remove('active');
        document.getElementById('faceCaptureArea').className = 'face-capture-area';
    }
    
    function handleFaceSuccess(result) {
        console.log('Face processing success:', result);
        showFaceStatus('Face data processed successfully!', 'success');
    }
    
    function handleFaceError(error) {
        console.error('Face processing error:', error);
        showFaceStatus(error.message || 'Face processing failed', 'error');
        showFaceActions(false);
        hideFaceProgress();
    }
    
    function validateFaceDataBeforeSubmit(event) {
        const faceProcessed = document.getElementById('faceProcessed').value;
        
        if (faceProcessed !== '1') {
            event.preventDefault();
            alert('Please capture and process a face photo before submitting the form.');
            document.getElementById('faceImageField').focus();
            return false;
        }
        
        return true;
    }
  </script>
</body>

</html>