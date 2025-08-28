<?php
session_start();
error_reporting(0);
include('dbcon.php');

if (!isset($_SESSION['email'])) {
    echo "<script type=\"text/javascript\">
    window.location = (\"index.php\");
    </script>";
}

// Get the certificate type and ID from URL parameters
$certType = $_GET['type'] ?? ''; // 'birth' or 'death'
$certId = $_GET['id'] ?? '';

if (empty($certType) || empty($certId)) {
    echo "<script type=\"text/javascript\">
    alert('Invalid certificate access. Please select a certificate from the list.');
    window.location = (\"PrintBirthCert.php\");
    </script>";
}

// Verify the certificate exists
if ($certType === 'birth') {
    $query = $con->query("SELECT * FROM tblbirth WHERE birthId = '$certId'") or die(mysqli_error($con));
    $certData = mysqli_fetch_array($query);
    $printPage = 'PrintBirthCertPage.php?birthRegId=' . $certId;
    $listPage = 'PrintBirthCert.php';
    $certTypeName = 'Birth Certificate';
} else if ($certType === 'death') {
    $query = $con->query("SELECT * FROM tbldeath WHERE deathId = '$certId'") or die(mysqli_error($con));
    $certData = mysqli_fetch_array($query);
    $printPage = 'PrintDeathCertPage.php?deathRegId=' . $certId;
    $listPage = 'PrintDeathCert.php';
    $certTypeName = 'Death Certificate';
} else {
    echo "<script type=\"text/javascript\">
    alert('Invalid certificate type.');
    window.location = (\"PrintBirthCert.php\");
    </script>";
}

if (!$certData) {
    echo "<script type=\"text/javascript\">
    alert('Certificate not found.');
    window.location = (\"" . $listPage . "\");
    </script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php include_once('title.php'); ?>
    
    <!-- CSS -->
    <link rel="stylesheet" href="vendors/iconfonts/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/camera-capture.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="shortcut icon" href="images/favicon.png" />
    
    <!-- Face-api.js -->
    <script src="https://cdn.jsdelivr.net/npm/@vladmandic/face-api@latest/dist/face-api.min.js"></script>
    
    <style>
        .verification-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .verification-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            margin-bottom: 30px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        
        .certificate-info {
            background: white;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .verification-methods {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }
        
        .method-card {
            background: white;
            border: 2px solid #e9ecef;
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
        }
        
        .method-card:hover {
            border-color: #4a90e2;
            box-shadow: 0 8px 25px rgba(74, 144, 226, 0.2);
            transform: translateY(-2px);
        }
        
        .method-card.active {
            border-color: #4a90e2;
            background: linear-gradient(135deg, #f8f9ff, #e8f2ff);
        }
        
        .method-icon {
            background: linear-gradient(135deg, #4a90e2, #357abd);
            color: white;
            width: 80px;
            height: 80px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 32px;
        }
        
        .method-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 15px;
        }
        
        .method-description {
            color: #666;
            margin-bottom: 20px;
            line-height: 1.6;
        }
        
        .verification-interface {
            background: white;
            border: 2px solid #e9ecef;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            display: none;
        }
        
        .verification-interface.active {
            display: block;
        }
        
        .verification-steps {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }
        
        .step {
            display: flex;
            align-items: center;
            margin: 0 15px;
            font-weight: 600;
            color: #999;
        }
        
        .step.active {
            color: #4a90e2;
        }
        
        .step.complete {
            color: #28a745;
        }
        
        .step-number {
            background: #e9ecef;
            color: #666;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            font-size: 14px;
        }
        
        .step.active .step-number {
            background: #4a90e2;
            color: white;
        }
        
        .step.complete .step-number {
            background: #28a745;
            color: white;
        }
        
        .fingerprint-scanner {
            text-align: center;
            padding: 40px;
            border: 2px dashed #dee2e6;
            border-radius: 15px;
            background: #f8f9fa;
        }
        
        .fingerprint-icon {
            font-size: 80px;
            color: #4a90e2;
            margin-bottom: 20px;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.1); opacity: 0.8; }
        }
        
        .verification-result {
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            margin-top: 30px;
        }
        
        .verification-result.success {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            border: 2px solid #28a745;
            color: #155724;
        }
        
        .verification-result.failure {
            background: linear-gradient(135deg, #f8d7da, #f5c6cb);
            border: 2px solid #dc3545;
            color: #721c24;
        }
        
        .proceed-section {
            text-align: center;
            padding: 30px;
            background: #f8f9fa;
            border-radius: 15px;
            margin-top: 30px;
        }
        
        .countdown {
            font-size: 1.2rem;
            font-weight: 600;
            color: #4a90e2;
            margin: 15px 0;
        }
        
        @media (max-width: 768px) {
            .verification-methods {
                grid-template-columns: 1fr;
            }
            
            .verification-steps {
                flex-direction: column;
                align-items: center;
            }
            
            .step {
                margin: 10px 0;
            }
        }
        
        /* Facial Method Selection */
        .facial-method-selection {
            text-align: center;
        }
        
        .facial-method-selection .btn-group .btn {
            padding: 12px 24px;
            font-weight: 600;
            border-width: 2px;
            margin: 0 2px;
            transition: all 0.3s ease;
        }
        
        .facial-method-selection .btn-group .btn.active {
            background: linear-gradient(135deg, #4a90e2, #357abd);
            border-color: #4a90e2;
            color: white !important;
            box-shadow: 0 4px 12px rgba(74, 144, 226, 0.3);
        }
        
        .facial-method-selection .btn-group .btn:not(.active) {
            background: white;
            color: #4a90e2;
            border-color: #4a90e2;
        }
        
        .facial-method-selection .btn-group .btn:not(.active):hover {
            background: #f0f7ff;
            transform: translateY(-1px);
        }
        
        /* Camera and Upload Sections */
        #cameraSection, #uploadSection {
            min-height: 300px;
            padding: 20px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            background: #f8f9fa;
            margin: 20px 0;
            transition: all 0.3s ease;
        }
        
        #cameraSection.active, #uploadSection.active {
            border-color: #4a90e2;
            background: #f0f7ff;
        }
        
        /* Upload Area Styles */
        .upload-area {
            max-width: 500px;
            margin: 0 auto;
        }
        
        .upload-zone {
            border: 3px dashed #dee2e6;
            border-radius: 15px;
            padding: 40px 20px;
            text-align: center;
            background: #f8f9fa;
            transition: all 0.3s ease;
            cursor: pointer;
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
            font-size: 48px;
            color: #4a90e2;
            margin-bottom: 20px;
        }
        
        .upload-zone h5 {
            color: #2c3e50;
            margin-bottom: 10px;
        }
        
        .upload-zone p {
            color: #666;
            margin-bottom: 20px;
        }
        
        /* Image Preview Styles */
        .image-preview {
            text-align: center;
            margin-top: 20px;
            padding: 20px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            background: white;
        }
        
        .preview-img {
            max-width: 300px;
            max-height: 300px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin: 15px 0;
        }
        
        .image-actions {
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        @media (max-width: 480px) {
            .upload-zone {
                padding: 30px 15px;
            }
            
            .upload-icon {
                font-size: 36px;
            }
            
            .preview-img {
                max-width: 250px;
                max-height: 250px;
            }
            
            .image-actions {
                flex-direction: column;
                align-items: center;
            }
            
            .image-actions .btn {
                width: 100%;
                max-width: 200px;
            }
        }
    </style>
</head>

<body>
    <div class="container-scroller">
        <?php include_once 'header.php'; ?>
        
        <div class="container-fluid page-body-wrapper">
            <?php include_once 'sidebar.php'; ?>
            
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="verification-container">
                        
                        <!-- Header -->
                        <div class="verification-header">
                            <h2><i class="fas fa-shield-alt"></i> Biometric Verification Required</h2>
                            <p>Please verify your identity before accessing the certificate</p>
                        </div>
                        
                        <!-- Certificate Information -->
                        <div class="certificate-info">
                            <h4><i class="fas fa-certificate"></i> Certificate Details</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Type:</strong> <?php echo $certTypeName; ?></p>
                                    <p><strong>Certificate Number:</strong> <?php echo $certData['certNo']; ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Name:</strong> <?php echo $certData['firstName'] . ' ' . $certData['lastName']; ?></p>
                                    <p><strong>Registration Date:</strong> <?php echo $certData['dateReg']; ?></p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Verification Steps -->
                        <div class="verification-steps">
                            <div class="step active" id="step1">
                                <div class="step-number">1</div>
                                <span>Choose Method</span>
                            </div>
                            <div class="step" id="step2">
                                <div class="step-number">2</div>
                                <span>Verify Identity</span>
                            </div>
                            <div class="step" id="step3">
                                <div class="step-number">3</div>
                                <span>Access Certificate</span>
                            </div>
                        </div>
                        
                        <!-- Method Selection -->
                        <div id="methodSelection">
                            <h4 class="text-center mb-4">Select Verification Method</h4>
                            <div class="verification-methods">
                                <div class="method-card" onclick="selectMethod('facial')">
                                    <div class="method-icon">
                                        <i class="fas fa-user-circle"></i>
                                    </div>
                                    <div class="method-title">Facial Recognition</div>
                                    <div class="method-description">
                                        Use camera capture or upload an image to verify your face against registered biometric data
                                    </div>
                                    <button class="btn btn-primary">Use Facial Recognition</button>
                                </div>
                                
                                <div class="method-card" onclick="selectMethod('fingerprint')">
                                    <div class="method-icon">
                                        <i class="fas fa-fingerprint"></i>
                                    </div>
                                    <div class="method-title">Fingerprint Scan</div>
                                    <div class="method-description">
                                        Use your fingerprint scanner to verify your identity with registered fingerprint data
                                    </div>
                                    <button class="btn btn-primary">Use Fingerprint</button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Facial Recognition Interface -->
                        <div id="facialInterface" class="verification-interface">
                            <h4><i class="fas fa-user-circle"></i> Facial Recognition Verification</h4>
                            
                            <!-- Method Selection for Facial Recognition -->
                            <div class="facial-method-selection mb-4">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-outline-primary active" id="cameraMethodBtn" onclick="switchToCamera()">
                                        <i class="fas fa-camera"></i> Use Camera
                                    </button>
                                    <button type="button" class="btn btn-outline-primary" id="uploadMethodBtn" onclick="switchToUpload()">
                                        <i class="fas fa-upload"></i> Upload Image
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Camera Interface -->
                            <div id="cameraSection">
                                <div id="facialCameraContainer"></div>
                            </div>
                            
                            <!-- Image Upload Interface -->
                            <div id="uploadSection" style="display: none;">
                                <div class="upload-area">
                                    <div class="upload-zone" id="uploadZone">
                                        <div class="upload-icon">
                                            <i class="fas fa-cloud-upload-alt"></i>
                                        </div>
                                        <h5>Upload Your Photo</h5>
                                        <p>Drag and drop an image file here, or click to select</p>
                                        <input type="file" id="imageUpload" accept="image/*" style="display: none;">
                                        <button type="button" class="btn btn-primary" onclick="document.getElementById('imageUpload').click()">
                                            <i class="fas fa-folder-open"></i> Choose File
                                        </button>
                                    </div>
                                    
                                    <!-- Image Preview -->
                                    <div id="imagePreview" class="image-preview" style="display: none;">
                                        <h6>Selected Image:</h6>
                                        <img id="previewImage" src="" alt="Selected image" class="preview-img">
                                        <div class="image-actions mt-3">
                                            <button type="button" class="btn btn-success" id="processImageBtn">
                                                <i class="fas fa-cogs"></i> Process Image
                                            </button>
                                            <button type="button" class="btn btn-secondary" id="changeImageBtn">
                                                <i class="fas fa-exchange-alt"></i> Change Image
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Status Display -->
                            <div id="facialStatus" class="mt-3"></div>
                            
                            <!-- Progress -->
                            <div id="facialProgress" style="display: none;" class="mt-3">
                                <div class="progress">
                                    <div id="facialProgressBar" class="progress-bar progress-bar-striped progress-bar-animated" 
                                         role="progressbar" style="width: 0%"></div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Fingerprint Interface -->
                        <div id="fingerprintInterface" class="verification-interface">
                            <h4><i class="fas fa-fingerprint"></i> Fingerprint Verification</h4>
                            
                            <div class="fingerprint-scanner">
                                <div class="fingerprint-icon">
                                    <i class="fas fa-fingerprint"></i>
                                </div>
                                <h5>Place your finger on the scanner</h5>
                                <p>Position your registered finger on the fingerprint scanner device</p>
                                
                                <div class="mt-4">
                                    <button class="btn btn-primary btn-lg" onclick="startFingerprintScan()">
                                        <i class="fas fa-play"></i> Start Scanning
                                    </button>
                                </div>
                                
                                <div id="fingerprintStatus" class="mt-3"></div>
                            </div>
                        </div>
                        
                        <!-- Verification Result -->
                        <div id="verificationResult" style="display: none;"></div>
                        
                        <!-- Proceed Section -->
                        <div id="proceedSection" class="proceed-section" style="display: none;">
                            <h4><i class="fas fa-check-circle text-success"></i> Verification Successful!</h4>
                            <p>You have been successfully verified. You can now access the certificate.</p>
                            <div class="countdown" id="countdown"></div>
                            <div class="mt-3">
                                <a href="<?php echo $printPage; ?>" class="btn btn-success btn-lg" id="proceedBtn">
                                    <i class="fas fa-print"></i> Access Certificate
                                </a>
                                <a href="<?php echo $listPage; ?>" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Back to List
                                </a>
                            </div>
                        </div>
                        
                    </div>
                </div>
                
                <?php include_once('footer.php'); ?>
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
        let selectedMethod = null;
        let facialClient = null;
        let cameraClient = null;
        let verificationComplete = false;
        
        // Certificate data from PHP
        const certificateData = {
            type: '<?php echo $certType; ?>',
            id: '<?php echo $certId; ?>',
            certNo: '<?php echo $certData['certNo']; ?>',
            printPage: '<?php echo $printPage; ?>'
        };
        
        document.addEventListener('DOMContentLoaded', async function() {
            try {
                // Initialize facial recognition if available
                facialClient = new FacialRecognitionClient();
                cameraClient = new CameraCaptureClient();
                
                await facialClient.initialize();
                
                // Set up camera callbacks
                cameraClient.setCallbacks({
                    onCameraReady: handleCameraReady,
                    onCameraError: handleCameraError,
                    onPhotoCapture: handleFacialCapture,
                    onStreamEnd: handleCameraStreamEnd
                });
                
                console.log('Biometric verification initialized');
            } catch (error) {
                console.error('Failed to initialize biometric verification:', error);
            }
        });
        
        function selectMethod(method) {
            selectedMethod = method;
            
            // Update UI
            document.querySelectorAll('.method-card').forEach(card => {
                card.classList.remove('active');
            });
            
            event.currentTarget.classList.add('active');
            
            // Hide method selection and show interface
            document.getElementById('methodSelection').style.display = 'none';
            
            if (method === 'facial') {
                showFacialInterface();
            } else if (method === 'fingerprint') {
                showFingerprintInterface();
            }
            
            // Update steps
            moveToStep(2);
        }
        
        function showFacialInterface() {
            const facialInterface = document.getElementById('facialInterface');
            facialInterface.style.display = 'block';
            
            // Set up facial method listeners
            setupFacialMethodListeners();
            
            // Default to camera method
            showCameraMethod();
            
            updateFacialStatus('Choose your preferred verification method: Camera or Image Upload.', 'info');
        }
        
        function setupFacialMethodListeners() {
            // Set up image upload functionality
            setupImageUpload();
        }
        
        function switchToCamera() {
            console.log('Switching to camera method');
            
            // Update button states
            document.getElementById('cameraMethodBtn').classList.add('active');
            document.getElementById('uploadMethodBtn').classList.remove('active');
            
            // Show camera method
            showCameraMethod();
        }
        
        function switchToUpload() {
            console.log('Switching to upload method');
            
            // Update button states
            document.getElementById('uploadMethodBtn').classList.add('active');
            document.getElementById('cameraMethodBtn').classList.remove('active');
            
            // Show upload method
            showUploadMethod();
        }
        
        function showCameraMethod() {
            console.log('showCameraMethod called');
            
            const cameraSection = document.getElementById('cameraSection');
            const uploadSection = document.getElementById('uploadSection');
            
            if (cameraSection) {
                cameraSection.style.display = 'block';
                cameraSection.classList.add('active');
                console.log('Camera section shown and activated');
            } else {
                console.error('Camera section not found!');
                return;
            }
            
            if (uploadSection) {
                uploadSection.style.display = 'none';
                uploadSection.classList.remove('active');
                console.log('Upload section hidden');
            }
            
            // Create camera UI if not already created
            const cameraContainer = document.getElementById('facialCameraContainer');
            if (cameraContainer && !cameraContainer.hasChildNodes()) {
                cameraClient.createCameraUI('facialCameraContainer');
                console.log('Camera UI created');
            }
            
            updateFacialStatus('Camera interface ready. Click "Start Camera" to begin facial verification.', 'info');
        }
        
        function showUploadMethod() {
            console.log('showUploadMethod called');
            
            const cameraSection = document.getElementById('cameraSection');
            const uploadSection = document.getElementById('uploadSection');
            
            if (cameraSection) {
                cameraSection.style.display = 'none';
                cameraSection.classList.remove('active');
                console.log('Camera section hidden');
            }
            
            if (uploadSection) {
                uploadSection.style.display = 'block';
                uploadSection.classList.add('active');
                console.log('Upload section shown and activated');
            } else {
                console.error('Upload section not found!');
                return;
            }
            
            // Stop camera if it's running
            if (cameraClient && cameraClient.isStreamActive) {
                cameraClient.stopCamera();
                console.log('Camera stream stopped');
            }
            
            updateFacialStatus('Upload an image file containing your face for verification.', 'info');
        }
        
        function setupImageUpload() {
            const imageUpload = document.getElementById('imageUpload');
            const uploadZone = document.getElementById('uploadZone');
            const imagePreview = document.getElementById('imagePreview');
            const previewImage = document.getElementById('previewImage');
            const processImageBtn = document.getElementById('processImageBtn');
            const changeImageBtn = document.getElementById('changeImageBtn');
            
            if (!imageUpload || !uploadZone) return;
            
            // File input change handler
            imageUpload.addEventListener('change', handleImageSelection);
            
            // Click to upload
            uploadZone.addEventListener('click', function() {
                imageUpload.click();
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
                    imageUpload.files = files;
                    handleImageSelection({ target: { files: files } });
                }
            });
            
            // Process image button
            if (processImageBtn) {
                processImageBtn.addEventListener('click', processUploadedImage);
            }
            
            // Change image button
            if (changeImageBtn) {
                changeImageBtn.addEventListener('click', function() {
                    imagePreview.style.display = 'none';
                    uploadZone.style.display = 'block';
                    imageUpload.value = '';
                    updateFacialStatus('Select a new image for verification.', 'info');
                });
            }
        }
        
        function handleImageSelection(event) {
            const file = event.target.files[0];
            if (!file) return;
            
            // Validate file type
            if (!file.type.startsWith('image/')) {
                updateFacialStatus('Please select a valid image file.', 'error');
                return;
            }
            
            // Validate file size (max 5MB)
            if (file.size > 5 * 1024 * 1024) {
                updateFacialStatus('Image file is too large. Please select an image smaller than 5MB.', 'error');
                return;
            }
            
            // Show image preview
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewImage = document.getElementById('previewImage');
                const imagePreview = document.getElementById('imagePreview');
                const uploadZone = document.getElementById('uploadZone');
                
                previewImage.src = e.target.result;
                imagePreview.style.display = 'block';
                uploadZone.style.display = 'none';
                
                updateFacialStatus('Image selected successfully. Click "Process Image" to begin verification.', 'success');
            };
            
            reader.readAsDataURL(file);
        }
        
        async function processUploadedImage() {
            try {
                const previewImage = document.getElementById('previewImage');
                if (!previewImage.src) {
                    throw new Error('No image selected');
                }
                
                updateFacialStatus('Processing uploaded image...', 'info');
                showFacialProgress('Analyzing facial features...', 30);
                
                // Process with facial recognition
                const detection = await facialClient.detectFaces(previewImage);
                
                if (!detection.success || detection.faceCount === 0) {
                    throw new Error('No face detected in the uploaded image. Please upload a clear photo of your face.');
                }
                
                if (detection.faceCount > 1) {
                    throw new Error('Multiple faces detected in the image. Please upload a photo with only one person.');
                }
                
                showFacialProgress('Verifying against registered data...', 70);
                
                // Verify against certificate holder's facial data
                const faceDescriptor = Array.from(detection.detections[0].descriptor);
                await verifyFacialData(faceDescriptor);
                
            } catch (error) {
                console.error('Image processing failed:', error);
                updateFacialStatus('Image processing failed: ' + error.message, 'error');
                showVerificationResult(false, error.message);
            }
        }
        
        function showFingerprintInterface() {
            document.getElementById('fingerprintInterface').style.display = 'block';
            updateFingerprintStatus('Ready to scan fingerprint. Click "Start Scanning" to begin.', 'info');
        }
        
        function handleCameraReady() {
            updateFacialStatus('Camera is ready! Position your face in the oval guide and click "Capture Photo".', 'success');
        }
        
        function handleCameraError(error) {
            console.error('Camera error:', error);
            let message = 'Camera error: ' + error.message;
            
            if (error.name === 'NotAllowedError') {
                message = 'Camera access denied. Please allow camera permissions and refresh the page.';
            } else if (error.name === 'NotFoundError') {
                message = 'No camera found. Please connect a camera device.';
            }
            
            updateFacialStatus(message, 'error');
        }
        
        async function handleFacialCapture(imageData) {
            try {
                updateFacialStatus('Photo captured! Processing facial recognition...', 'info');
                showFacialProgress('Analyzing facial features...', 30);
                
                // Process with facial recognition
                const detection = await facialClient.detectFaces(await createImageFromDataUrl(imageData.dataUrl));
                
                if (!detection.success || detection.faceCount === 0) {
                    throw new Error('No face detected. Please take a clear photo of your face.');
                }
                
                if (detection.faceCount > 1) {
                    throw new Error('Multiple faces detected. Please ensure only one person is in the photo.');
                }
                
                showFacialProgress('Verifying against registered data...', 70);
                
                // Verify against certificate holder's facial data
                const faceDescriptor = Array.from(detection.detections[0].descriptor);
                await verifyFacialData(faceDescriptor);
                
            } catch (error) {
                console.error('Facial verification failed:', error);
                updateFacialStatus('Facial verification failed: ' + error.message, 'error');
                showVerificationResult(false, error.message);
            }
        }
        
        async function verifyFacialData(faceDescriptor) {
            try {
                const formData = new FormData();
                formData.append('action', 'verify_certificate_holder');
                formData.append('cert_type', certificateData.type);
                formData.append('cert_id', certificateData.id);
                formData.append('face_descriptor', JSON.stringify(faceDescriptor));
                
                const response = await fetch('api/facial_recognition.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                showFacialProgress('Verification complete!', 100);
                
                if (result.success && result.verified) {
                    updateFacialStatus('Facial verification successful!', 'success');
                    showVerificationResult(true, 'Face matches registered biometric data');
                    completeVerification();
                } else {
                    updateFacialStatus('Facial verification failed: ' + result.error, 'error');
                    showVerificationResult(false, result.error || 'Face does not match registered data');
                }
                
            } catch (error) {
                updateFacialStatus('Verification error: ' + error.message, 'error');
                showVerificationResult(false, 'Technical error during verification');
            }
        }
        
        async function startFingerprintScan() {
            try {
                updateFingerprintStatus('Starting fingerprint scan...', 'info');
                
                // Simulate fingerprint scanning process
                // In a real implementation, this would interface with a fingerprint scanner device
                await simulateFingerprintScan();
                
            } catch (error) {
                console.error('Fingerprint scan failed:', error);
                updateFingerprintStatus('Fingerprint scan failed: ' + error.message, 'error');
                showVerificationResult(false, error.message);
            }
        }
        
        async function simulateFingerprintScan() {
            // Simulate scanning process
            updateFingerprintStatus('Scanning fingerprint...', 'info');
            await new Promise(resolve => setTimeout(resolve, 2000));
            
            updateFingerprintStatus('Processing fingerprint data...', 'info');
            await new Promise(resolve => setTimeout(resolve, 1500));
            
            updateFingerprintStatus('Verifying against registered data...', 'info');
            await new Promise(resolve => setTimeout(resolve, 2000));
            
            // Simulate successful verification (in real implementation, this would verify against stored fingerprint data)
            const success = Math.random() > 0.2; // 80% success rate for demo
            
            if (success) {
                updateFingerprintStatus('Fingerprint verification successful!', 'success');
                showVerificationResult(true, 'Fingerprint matches registered biometric data');
                completeVerification();
            } else {
                updateFingerprintStatus('Fingerprint verification failed', 'error');
                showVerificationResult(false, 'Fingerprint does not match registered data');
            }
        }
        
        function completeVerification() {
            verificationComplete = true;
            moveToStep(3);
            
            // Show proceed section with countdown
            document.getElementById('proceedSection').style.display = 'block';
            startCountdown(10); // 10 second countdown
        }
        
        function startCountdown(seconds) {
            const countdownElement = document.getElementById('countdown');
            let remaining = seconds;
            
            const interval = setInterval(() => {
                countdownElement.textContent = `Redirecting to certificate in ${remaining} seconds...`;
                remaining--;
                
                if (remaining < 0) {
                    clearInterval(interval);
                    // Auto-redirect to certificate
                    window.location.href = certificateData.printPage;
                }
            }, 1000);
            
            // Allow manual navigation
            document.getElementById('proceedBtn').addEventListener('click', () => {
                clearInterval(interval);
            });
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
        }
        
        function showVerificationResult(success, message) {
            const resultDiv = document.getElementById('verificationResult');
            resultDiv.style.display = 'block';
            
            if (success) {
                resultDiv.innerHTML = `
                    <div class="verification-result success">
                        <i class="fas fa-check-circle fa-3x mb-3"></i>
                        <h4>Verification Successful!</h4>
                        <p>${message}</p>
                    </div>
                `;
            } else {
                resultDiv.innerHTML = `
                    <div class="verification-result failure">
                        <i class="fas fa-times-circle fa-3x mb-3"></i>
                        <h4>Verification Failed</h4>
                        <p>${message}</p>
                        <div class="mt-3">
                            <button class="btn btn-primary" onclick="retryVerification()">
                                <i class="fas fa-redo"></i> Try Again
                            </button>
                            <button class="btn btn-secondary" onclick="selectDifferentMethod()">
                                <i class="fas fa-exchange-alt"></i> Use Different Method
                            </button>
                        </div>
                    </div>
                `;
            }
        }
        
        function retryVerification() {
            document.getElementById('verificationResult').style.display = 'none';
            
            if (selectedMethod === 'facial') {
                updateFacialStatus('Ready to retry facial verification.', 'info');
            } else if (selectedMethod === 'fingerprint') {
                updateFingerprintStatus('Ready to retry fingerprint verification.', 'info');
            }
        }
        
        function selectDifferentMethod() {
            // Reset to method selection
            selectedMethod = null;
            verificationComplete = false;
            
            // Hide all interfaces
            document.getElementById('facialInterface').style.display = 'none';
            document.getElementById('fingerprintInterface').style.display = 'none';
            document.getElementById('verificationResult').style.display = 'none';
            document.getElementById('proceedSection').style.display = 'none';
            
            // Show method selection
            document.getElementById('methodSelection').style.display = 'block';
            
            // Reset steps
            moveToStep(1);
            
            // Stop camera if active
            if (cameraClient) {
                cameraClient.stopCamera();
            }
        }
        
        function updateFacialStatus(message, type = 'info') {
            const statusDiv = document.getElementById('facialStatus');
            const alertClass = type === 'success' ? 'alert-success' : 
                              type === 'error' ? 'alert-danger' : 'alert-info';
            
            statusDiv.innerHTML = `<div class="alert ${alertClass}">${message}</div>`;
        }
        
        function updateFingerprintStatus(message, type = 'info') {
            const statusDiv = document.getElementById('fingerprintStatus');
            const alertClass = type === 'success' ? 'alert-success' : 
                              type === 'error' ? 'alert-danger' : 'alert-info';
            
            statusDiv.innerHTML = `<div class="alert ${alertClass}">${message}</div>`;
        }
        
        function showFacialProgress(message, percentage) {
            const progress = document.getElementById('facialProgress');
            const progressBar = document.getElementById('facialProgressBar');
            
            progress.style.display = 'block';
            progressBar.style.width = percentage + '%';
            progressBar.textContent = message;
            
            if (percentage >= 100) {
                setTimeout(() => {
                    progress.style.display = 'none';
                }, 2000);
            }
        }
        
        function handleCameraStreamEnd() {
            updateFacialStatus('Camera stopped.', 'info');
        }
        
        async function createImageFromDataUrl(dataUrl) {
            return new Promise((resolve, reject) => {
                const img = new Image();
                img.onload = () => resolve(img);
                img.onerror = reject;
                img.src = dataUrl;
            });
        }
    </script>
</body>
</html>