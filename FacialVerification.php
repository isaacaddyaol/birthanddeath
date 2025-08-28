<?php
session_start();
error_reporting(0);
include('dbcon.php');
require_once 'lib/FacialRecognition.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <?php include_once('title.php');?>
  <!-- CSS Dependencies -->
  <link rel="stylesheet" href="vendors/iconfonts/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/camera-capture.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  
  <!-- Face-api.js -->
  <script src="https://cdn.jsdelivr.net/npm/@vladmandic/face-api@latest/dist/face-api.min.js"></script>
  
  <style>
    .verification-container {
      max-width: 800px;
      margin: 0 auto;
      padding: 20px;
    }
    
    .verification-card {
      background: white;
      border-radius: 15px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      padding: 30px;
      margin-bottom: 20px;
    }
    
    .verification-header {
      text-align: center;
      margin-bottom: 30px;
      color: #2c3e50;
    }
    
    .verification-steps {
      display: flex;
      justify-content: space-between;
      margin-bottom: 30px;
      flex-wrap: wrap;
    }
    
    .step {
      flex: 1;
      text-align: center;
      padding: 15px;
      margin: 5px;
      border-radius: 10px;
      background: #f8f9fa;
      transition: all 0.3s ease;
    }
    
    .step.active {
      background: #3498db;
      color: white;
    }
    
    .step.complete {
      background: #27ae60;
      color: white;
    }
    
    .verification-form {
      background: #f8f9fa;
      padding: 25px;
      border-radius: 10px;
      margin-bottom: 20px;
    }
    
    .face-verification-area {
      border: 3px dashed #e0e0e0;
      border-radius: 15px;
      padding: 30px;
      text-align: center;
      background: #fafafa;
      transition: all 0.3s ease;
      min-height: 200px;
    }
    
    .verification-result {
      padding: 20px;
      border-radius: 10px;
      margin-top: 20px;
      text-align: center;
    }
    
    .verification-result.success {
      background: #d4edda;
      color: #155724;
      border: 1px solid #c3e6cb;
    }
    
    .verification-result.failure {
      background: #f8d7da;
      color: #721c24;
      border: 1px solid #f5c6cb;
    }
    
    /* Enhanced Upload Zone Styles */
    .upload-zone {
      border: 3px dashed #dee2e6;
      border-radius: 15px;
      padding: 30px 20px;
      text-align: center;
      background: #f8f9fa;
      transition: all 0.3s ease;
      cursor: pointer;
      margin: 20px 0;
    }
    
    .upload-zone:hover {
      border-color: #4a90e2;
      background: #f0f7ff;
    }
    
    .upload-zone.dragover {
      border-color: #28a745;
      background: #f0fff4;
      transform: scale(1.02);
    }
    
    .upload-icon {
      font-size: 36px;
      color: #4a90e2;
      margin-bottom: 15px;
    }
    
    .upload-zone h6 {
      color: #2c3e50;
      margin-bottom: 8px;
    }
    
    .upload-zone p {
      color: #666;
      margin-bottom: 15px;
      font-size: 0.9rem;
    }
  </style>
</head>

<body>
  <div class="container-scroller">
    <?php include_once 'header.php';?>
    
    <div class="container-fluid page-body-wrapper">
      <?php include_once 'sidebar.php';?>
      
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="verification-container">
            
            <div class="verification-card">
              <div class="verification-header">
                <h2><i class="fas fa-shield-alt"></i> Facial Recognition Verification</h2>
                <p class="text-muted">Verify certificate authenticity using facial recognition</p>
              </div>
              
              <div class="verification-steps">
                <div class="step active" id="step1">
                  <i class="fas fa-certificate fa-2x mb-2"></i>
                  <div>Enter Certificate</div>
                </div>
                <div class="step" id="step2">
                  <i class="fas fa-camera fa-2x mb-2"></i>
                  <div>Capture Face</div>
                </div>
                <div class="step" id="step3">
                  <i class="fas fa-check-circle fa-2x mb-2"></i>
                  <div>Verify</div>
                </div>
              </div>
              
              <!-- Step 1: Certificate Input -->
              <div id="certificateStep" class="verification-form">
                <h4><i class="fas fa-id-card"></i> Step 1: Enter Certificate Details</h4>
                <form id="certificateForm">
                  <div class="form-group">
                    <label for="certNo">Certificate Number:</label>
                    <input type="text" id="certNo" class="form-control" 
                           placeholder="Enter certificate number (e.g., GHBR100001)" required>
                  </div>
                  <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Verify Certificate
                  </button>
                </form>
              </div>
              
              <!-- Step 2: Face Capture -->
              <div id="faceStep" class="verification-form" style="display: none;">
                <h4><i class="fas fa-camera"></i> Step 2: Capture Face for Verification</h4>
                <div class="face-verification-area" id="faceVerificationArea">
                  <div id="faceUploadContent">
                    <i class="fas fa-user-circle fa-4x mb-3" style="color: #3498db;"></i>
                    <h5>Capture Face for Verification</h5>
                    <p class="text-muted">Use your camera or upload a photo to verify against registered face</p>
                    
                    <!-- Camera or Upload Options -->
                    <div class="capture-options mb-3">
                        <button type="button" class="btn btn-primary me-2" id="useCameraBtn">
                            <i class="fas fa-camera"></i> Use Camera
                        </button>
                        <button type="button" class="btn btn-outline-primary" id="uploadFileBtn">
                            <i class="fas fa-upload"></i> Upload Photo
                        </button>
                    </div>
                    
                    <!-- Enhanced Upload Zone -->
                    <div id="uploadZone" class="upload-zone" style="display: none;">
                        <div class="upload-icon">
                            <i class="fas fa-cloud-upload-alt"></i>
                        </div>
                        <h6>Upload Your Photo</h6>
                        <p>Drag and drop an image file here, or click to select</p>
                        <button type="button" class="btn btn-primary" onclick="document.getElementById('verificationFaceField').click()">
                            <i class="fas fa-folder-open"></i> Choose File
                        </button>
                    </div>
                    
                    <input type="file" id="verificationFaceField" accept="image/*" hidden>
                  </div>
                  
                  <!-- Camera Capture Interface -->
                  <div id="cameraInterface" style="display: none;">
                      <div id="cameraContainer"></div>
                  </div>
                  
                  <div id="faceProcessingContent" style="display: none;">
                    <img id="verificationFacePreview" class="face-preview" style="max-width: 300px; border-radius: 10px;">
                    <div class="progress mt-3" id="verificationProgress" style="display: none;">
                      <div class="progress-bar progress-bar-striped progress-bar-animated" id="verificationProgressBar"></div>
                    </div>
                    <div id="verificationStatus" class="mt-3"></div>
                    <div class="mt-3">
                      <button type="button" class="btn btn-success" id="proceedVerificationBtn" style="display: none;">
                        <i class="fas fa-check"></i> Proceed to Verification
                      </button>
                      <button type="button" class="btn btn-warning" onclick="resetFaceCapture()">
                        <i class="fas fa-redo"></i> Try Again
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              
              <!-- Step 3: Verification Result -->
              <div id="resultStep" class="verification-form" style="display: none;">
                <h4><i class="fas fa-clipboard-check"></i> Step 3: Verification Result</h4>
                <div id="verificationResult"></div>
              </div>
              
            </div>
          </div>
        </div>
        
        <?php include_once('footer.php');?>
      </div>
    </div>
  </div>

  <!-- JavaScript -->
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <script src="js/off-canvas.js"></script>
  <script src="js/misc.js"></script>
  <script src="js/facial-recognition-client.js"></script>
  <script src="js/camera-capture-client.js"></script>
  
  <script>
    let facialClient;
    let cameraClient;
    let currentCertData = null;
    let capturedFaceDescriptor = null;
    
    document.addEventListener('DOMContentLoaded', async function() {
      try {
        facialClient = new FacialRecognitionClient();
        cameraClient = new CameraCaptureClient();
        
        await facialClient.initialize();
        
        // Set up camera callbacks
        cameraClient.setCallbacks({
            onCameraReady: handleCameraReady,
            onCameraError: handleCameraError,
            onPhotoCapture: handleCameraPhotoCapture,
            onStreamEnd: handleCameraStreamEnd
        });
        
        console.log('Facial recognition and camera initialized');
      } catch (error) {
        console.error('Failed to initialize:', error);
      }
      
      setupEventListeners();
    });
    
    function setupEventListeners() {
      document.getElementById('certificateForm').addEventListener('submit', handleCertificateSubmit);
      document.getElementById('verificationFaceField').addEventListener('change', handleFaceUpload);
      document.getElementById('proceedVerificationBtn').addEventListener('click', performVerification);
      
      // Camera controls
      const useCameraBtn = document.getElementById('useCameraBtn');
      const uploadFileBtn = document.getElementById('uploadFileBtn');
      
      if (useCameraBtn) {
        useCameraBtn.addEventListener('click', showCameraInterface);
      }
      
      if (uploadFileBtn) {
        uploadFileBtn.addEventListener('click', showFileUploadInterface);
      }
      
      // Set up drag and drop for upload zone
      setupUploadZone();
    }
    
    function setupUploadZone() {
      const uploadZone = document.getElementById('uploadZone');
      const fileInput = document.getElementById('verificationFaceField');
      
      if (!uploadZone || !fileInput) return;
      
      // Click to upload
      uploadZone.addEventListener('click', function() {
        fileInput.click();
      });
      
      // Drag and drop functionality
      uploadZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        uploadZone.classList.add('dragover');
      });
      
      uploadZone.addEventListener('dragleave', function(e) {
        e.preventDefault();
        uploadZone.classList.remove('dragover');
      });
      
      uploadZone.addEventListener('drop', function(e) {
        e.preventDefault();
        uploadZone.classList.remove('dragover');
        
        const files = e.dataTransfer.files;
        if (files.length > 0 && files[0].type.startsWith('image/')) {
          fileInput.files = files;
          handleFaceUpload({ target: { files: files } });
        } else {
          showVerificationStatus('Please drop a valid image file.', 'error');
        }
      });
    }
    
    async function handleCertificateSubmit(e) {
      e.preventDefault();
      const certNo = document.getElementById('certNo').value.trim();
      
      if (!certNo) {
        alert('Please enter a certificate number');
        return;
      }
      
      try {
        const formData = new FormData();
        formData.append('action', 'get_face_data');
        formData.append('cert_no', certNo);
        
        const response = await fetch('api/facial_recognition.php', {
          method: 'POST',
          body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
          currentCertData = result.data;
          moveToStep(2);
        } else {
          alert('Certificate not found or no facial data available: ' + result.error);
        }
      } catch (error) {
        alert('Error verifying certificate: ' + error.message);
      }
    }
    
    async function handleFaceUpload(e) {
      const file = e.target.files[0];
      if (!file) return;
      
      // Validate file type
      if (!file.type.startsWith('image/')) {
        showVerificationStatus('Please select a valid image file.', 'error');
        return;
      }
      
      // Validate file size (max 5MB)
      if (file.size > 5 * 1024 * 1024) {
        showVerificationStatus('Image file is too large. Please select an image smaller than 5MB.', 'error');
        return;
      }
      
      try {
        document.getElementById('faceUploadContent').style.display = 'none';
        document.getElementById('faceProcessingContent').style.display = 'block';
        
        const preview = document.getElementById('verificationFacePreview');
        preview.src = URL.createObjectURL(file);
        
        showVerificationStatus('Image selected successfully. Processing...', 'info');
        
        preview.onload = async () => {
          await processFaceForVerification(preview, file);
        };
      } catch (error) {
        showVerificationStatus('Error processing face: ' + error.message, 'error');
      }
    }
    
    async function processFaceForVerification(imageElement, file) {
      try {
        showProgress('Detecting face...', 30);
        
        const detection = await facialClient.detectFaces(imageElement);
        
        if (!detection.success || detection.faceCount === 0) {
          throw new Error('No face detected. Please use a clear photo.');
        }
        
        if (detection.faceCount > 1) {
          throw new Error('Multiple faces detected. Please use a photo with one person.');
        }
        
        showProgress('Processing facial features...', 70);
        
        const faceDetection = detection.detections[0];
        capturedFaceDescriptor = Array.from(faceDetection.descriptor);
        
        showProgress('Face processing complete!', 100);
        showVerificationStatus('Face captured successfully!', 'success');
        
        document.getElementById('proceedVerificationBtn').style.display = 'block';
        
      } catch (error) {
        showVerificationStatus('Error: ' + error.message, 'error');
      }
    }
    
    async function performVerification() {
      if (!capturedFaceDescriptor || !currentCertData) {
        alert('Missing verification data');
        return;
      }
      
      try {
        showProgress('Verifying face...', 50);
        
        const formData = new FormData();
        formData.append('action', 'verify_face');
        formData.append('birth_id', currentCertData.birth_id);
        formData.append('face_descriptor', JSON.stringify(capturedFaceDescriptor));
        
        const response = await fetch('api/facial_recognition.php', {
          method: 'POST',
          body: formData
        });
        
        const result = await response.json();
        
        moveToStep(3);
        displayVerificationResult(result);
        
      } catch (error) {
        showVerificationStatus('Verification error: ' + error.message, 'error');
      }
    }
    
    function displayVerificationResult(result) {
      const resultDiv = document.getElementById('verificationResult');
      
      if (result.success && result.verified) {
        resultDiv.innerHTML = `
          <div class="verification-result success">
            <i class="fas fa-check-circle fa-3x mb-3"></i>
            <h4>Verification Successful!</h4>
            <p>Face matches registered biometric data</p>
            <p><strong>Confidence:</strong> ${(result.confidence * 100).toFixed(1)}%</p>
            <p><strong>Certificate:</strong> Valid and Verified</p>
          </div>
        `;
      } else {
        resultDiv.innerHTML = `
          <div class="verification-result failure">
            <i class="fas fa-times-circle fa-3x mb-3"></i>
            <h4>Verification Failed</h4>
            <p>Face does not match registered biometric data</p>
            <p><strong>Reason:</strong> ${result.error || 'No match found'}</p>
          </div>
        `;
      }
    }
    
    function moveToStep(stepNumber) {
      // Update step indicators
      for (let i = 1; i <= 3; i++) {
        const step = document.getElementById(`step${i}`);
        if (i < stepNumber) {
          step.className = 'step complete';
        } else if (i === stepNumber) {
          step.className = 'step active';
        } else {
          step.className = 'step';
        }
      }
      
      // Show/hide step content
      document.getElementById('certificateStep').style.display = stepNumber === 1 ? 'block' : 'none';
      document.getElementById('faceStep').style.display = stepNumber === 2 ? 'block' : 'none';
      document.getElementById('resultStep').style.display = stepNumber === 3 ? 'block' : 'none';
    }
    
    function showProgress(message, percentage) {
      const progress = document.getElementById('verificationProgress');
      const progressBar = document.getElementById('verificationProgressBar');
      
      progress.style.display = 'block';
      progressBar.style.width = percentage + '%';
      progressBar.textContent = message;
    }
    
    function showVerificationStatus(message, type) {
      const status = document.getElementById('verificationStatus');
      status.innerHTML = `<div class="alert alert-${type === 'success' ? 'success' : 'danger'}">${message}</div>`;
    }
    
    function showCameraInterface() {
      try {
        // Hide file upload interface
        document.getElementById('faceUploadContent').style.display = 'none';
        
        // Show camera interface
        const cameraInterface = document.getElementById('cameraInterface');
        cameraInterface.style.display = 'block';
        
        // Create camera UI
        cameraClient.createCameraUI('cameraContainer');
        
        showVerificationStatus('Camera interface ready. Click "Start Camera" to begin.', 'info');
        
      } catch (error) {
        console.error('Failed to show camera interface:', error);
        showVerificationStatus('Failed to initialize camera interface: ' + error.message, 'error');
      }
    }
    
    function showFileUploadInterface() {
      // Hide camera interface
      document.getElementById('cameraInterface').style.display = 'none';
      
      // Show file upload interface
      document.getElementById('faceUploadContent').style.display = 'block';
      document.getElementById('uploadZone').style.display = 'block';
      
      // Stop camera if it's running
      if (cameraClient && cameraClient.isStreamActive) {
        cameraClient.stopCamera();
      }
      
      showVerificationStatus('Upload an image file or drag and drop it to the upload zone.', 'info');
    }
    
    // Camera event handlers
    function handleCameraReady() {
      showVerificationStatus('Camera is ready. Position your face in the oval guide and click "Capture Photo".', 'success');
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
      
      showVerificationStatus(errorMessage, 'error');
    }
    
    async function handleCameraPhotoCapture(imageData) {
      try {
        showVerificationStatus('Photo captured! Processing for verification...', 'info');
        
        // Hide camera interface
        document.getElementById('cameraInterface').style.display = 'none';
        document.getElementById('faceProcessingContent').style.display = 'block';
        
        // Show the captured image
        const preview = document.getElementById('verificationFacePreview');
        preview.src = imageData.dataUrl;
        
        // Process the captured image
        await processFaceForVerification(preview, imageData.file);
        
      } catch (error) {
        console.error('Failed to process captured photo:', error);
        showVerificationStatus('Failed to process captured photo: ' + error.message, 'error');
      }
    }
    
    function handleCameraStreamEnd() {
      showVerificationStatus('Camera stopped.', 'info');
    }
    
    function resetFaceCapture() {
      // Stop camera if active
      if (cameraClient && cameraClient.isStreamActive) {
        cameraClient.stopCamera();
      }
      
      // Hide camera interface
      document.getElementById('cameraInterface').style.display = 'none';
      
      // Show main upload interface
      document.getElementById('faceUploadContent').style.display = 'block';
      document.getElementById('faceProcessingContent').style.display = 'none';
      
      // Clear file input
      document.getElementById('verificationFaceField').value = '';
      
      // Reset variables
      capturedFaceDescriptor = null;
      
      // Clear any preview
      const preview = document.getElementById('verificationFacePreview');
      if (preview) {
        preview.src = '';
      }
    }
  </script>
</body>
</html>