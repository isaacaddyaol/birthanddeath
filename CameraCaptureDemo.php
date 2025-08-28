<?php
session_start();
error_reporting(0);
include('dbcon.php');

if (!isset($_SESSION['email'])) {
    echo "<script type=\"text/javascript\">
    window.location = (\"index.php\");
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
        .demo-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .demo-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            padding: 30px;
            margin-bottom: 20px;
        }
        
        .demo-header {
            text-align: center;
            margin-bottom: 30px;
            color: #2c3e50;
        }
        
        .feature-showcase {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-top: 30px;
        }
        
        .feature-box {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
        }
        
        .feature-box h4 {
            color: #3498db;
            margin-bottom: 15px;
        }
        
        .status-display {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            margin: 15px 0;
            min-height: 60px;
        }
        
        .captured-images {
            display: flex;
            gap: 20px;
            margin-top: 20px;
            flex-wrap: wrap;
        }
        
        .captured-image {
            border: 2px solid #dee2e6;
            border-radius: 8px;
            padding: 10px;
            background: white;
            text-align: center;
        }
        
        .captured-image img {
            max-width: 200px;
            max-height: 200px;
            border-radius: 5px;
        }
        
        @media (max-width: 768px) {
            .feature-showcase {
                grid-template-columns: 1fr;
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
                    <div class="demo-container">
                        
                        <div class="demo-card">
                            <div class="demo-header">
                                <h2><i class="fas fa-video"></i> Camera Capture Demo</h2>
                                <p class="text-muted">Test camera capture functionality for facial recognition</p>
                            </div>
                            
                            <!-- Camera Interface -->
                            <div id="mainCameraContainer"></div>
                            
                            <!-- Status Display -->
                            <div class="status-display" id="statusDisplay">
                                <h5><i class="fas fa-info-circle"></i> Status</h5>
                                <p id="statusMessage">Ready to start camera capture demo</p>
                            </div>
                            
                            <!-- Feature Showcase -->
                            <div class="feature-showcase">
                                <div class="feature-box">
                                    <h4><i class="fas fa-camera"></i> Camera Features</h4>
                                    <ul class="text-left">
                                        <li>Real-time camera preview</li>
                                        <li>Face detection overlay</li>
                                        <li>Front/back camera switching</li>
                                        <li>Photo capture with flash effect</li>
                                        <li>Camera permissions handling</li>
                                    </ul>
                                </div>
                                
                                <div class="feature-box">
                                    <h4><i class="fas fa-face-smile"></i> Face Detection</h4>
                                    <ul class="text-left">
                                        <li>Real-time face detection</li>
                                        <li>Face quality assessment</li>
                                        <li>Multiple face handling</li>
                                        <li>Face positioning guide</li>
                                        <li>Confidence scoring</li>
                                    </ul>
                                </div>
                            </div>
                            
                            <!-- Captured Images Display -->
                            <div id="capturedImagesContainer" style="display: none;">
                                <h4><i class="fas fa-images"></i> Captured Images</h4>
                                <div class="captured-images" id="capturedImages"></div>
                            </div>
                            
                            <!-- Demo Actions -->
                            <div class="text-center mt-4">
                                <button type="button" class="btn btn-secondary" onclick="resetDemo()">
                                    <i class="fas fa-redo"></i> Reset Demo
                                </button>
                                <button type="button" class="btn btn-info" onclick="testFaceDetection()">
                                    <i class="fas fa-search"></i> Test Face Detection
                                </button>
                                <button type="button" class="btn btn-success" onclick="viewResults()">
                                    <i class="fas fa-chart-bar"></i> View Results
                                </button>
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
    <script src="js/camera-capture-client.js"></script>
    <script src="js/facial-recognition-client.js"></script>
    
    <script>
        let cameraClient;
        let facialClient;
        let capturedImages = [];
        let demoActive = false;
        
        document.addEventListener('DOMContentLoaded', async function() {
            try {
                // Initialize clients
                cameraClient = new CameraCaptureClient();
                facialClient = new FacialRecognitionClient();
                
                // Set up camera callbacks
                cameraClient.setCallbacks({
                    onCameraReady: handleCameraReady,
                    onCameraError: handleCameraError,
                    onPhotoCapture: handlePhotoCapture,
                    onStreamEnd: handleStreamEnd
                });
                
                // Initialize facial recognition
                await facialClient.initialize();
                
                // Create camera UI
                cameraClient.createCameraUI('mainCameraContainer');
                
                updateStatus('Demo initialized successfully. Click "Start Camera" to begin.', 'success');
                
            } catch (error) {
                console.error('Demo initialization failed:', error);
                updateStatus('Demo initialization failed: ' + error.message, 'error');
            }
        });
        
        function handleCameraReady() {
            updateStatus('Camera is ready! Position your face in the oval guide and capture photos.', 'success');
            demoActive = true;
        }
        
        function handleCameraError(error) {
            console.error('Camera error:', error);
            let message = 'Camera error: ' + error.message;
            
            if (error.name === 'NotAllowedError') {
                message = 'Camera access denied. Please allow camera permissions and refresh the page.';
            } else if (error.name === 'NotFoundError') {
                message = 'No camera found. Please connect a camera device.';
            }
            
            updateStatus(message, 'error');
            demoActive = false;
        }
        
        async function handlePhotoCapture(imageData) {
            try {
                updateStatus('Photo captured! Processing with facial recognition...', 'info');
                
                // Add to captured images
                capturedImages.push({
                    ...imageData,
                    id: Date.now(),
                    processed: false
                });
                
                // Process with facial recognition
                const detection = await facialClient.detectFaces(await createImageFromDataUrl(imageData.dataUrl));
                
                if (detection.success && detection.faceCount > 0) {
                    const confidence = detection.detections[0].detection.score;
                    capturedImages[capturedImages.length - 1].faceDetected = true;
                    capturedImages[capturedImages.length - 1].confidence = confidence;
                    capturedImages[capturedImages.length - 1].processed = true;
                    
                    updateStatus(`Photo processed successfully! Face detected with ${(confidence * 100).toFixed(1)}% confidence.`, 'success');
                } else {
                    capturedImages[capturedImages.length - 1].faceDetected = false;
                    capturedImages[capturedImages.length - 1].processed = true;
                    
                    updateStatus('Photo processed. No face detected in the image.', 'warning');
                }
                
                updateCapturedImagesDisplay();
                
            } catch (error) {
                console.error('Photo processing failed:', error);
                updateStatus('Photo processing failed: ' + error.message, 'error');
            }
        }
        
        function handleStreamEnd() {
            updateStatus('Camera stopped.', 'info');
            demoActive = false;
        }
        
        function updateStatus(message, type = 'info') {
            const statusMessage = document.getElementById('statusMessage');
            const statusDisplay = document.getElementById('statusDisplay');
            
            statusMessage.textContent = message;
            
            // Update status display styling
            statusDisplay.className = 'status-display';
            if (type === 'success') {
                statusDisplay.style.borderLeft = '4px solid #28a745';
                statusDisplay.style.background = '#d4edda';
            } else if (type === 'error') {
                statusDisplay.style.borderLeft = '4px solid #dc3545';
                statusDisplay.style.background = '#f8d7da';
            } else if (type === 'warning') {
                statusDisplay.style.borderLeft = '4px solid #ffc107';
                statusDisplay.style.background = '#fff3cd';
            } else {
                statusDisplay.style.borderLeft = '4px solid #17a2b8';
                statusDisplay.style.background = '#d1ecf1';
            }
        }
        
        function updateCapturedImagesDisplay() {
            const container = document.getElementById('capturedImagesContainer');
            const imagesDiv = document.getElementById('capturedImages');
            
            if (capturedImages.length > 0) {
                container.style.display = 'block';
                
                imagesDiv.innerHTML = capturedImages.map((img, index) => `
                    <div class="captured-image">
                        <img src="${img.dataUrl}" alt="Captured ${index + 1}">
                        <div class="mt-2">
                            <small><strong>Image ${index + 1}</strong></small><br>
                            <small>Size: ${img.width}x${img.height}</small><br>
                            ${img.processed ? 
                                img.faceDetected ? 
                                    `<small class="text-success">Face: ${(img.confidence * 100).toFixed(1)}%</small>` :
                                    `<small class="text-warning">No face detected</small>` :
                                `<small class="text-info">Processing...</small>`
                            }
                        </div>
                    </div>
                `).join('');
            } else {
                container.style.display = 'none';
            }
        }
        
        function resetDemo() {
            // Stop camera
            if (cameraClient) {
                cameraClient.stopCamera();
            }
            
            // Clear captured images
            capturedImages = [];
            updateCapturedImagesDisplay();
            
            // Reset status
            updateStatus('Demo reset. Ready to start again.', 'info');
            demoActive = false;
        }
        
        async function testFaceDetection() {
            if (!demoActive) {
                updateStatus('Please start the camera first to test face detection.', 'warning');
                return;
            }
            
            try {
                updateStatus('Testing face detection...', 'info');
                
                // Capture photo automatically for testing
                const imageData = await cameraClient.capturePhoto();
                
                updateStatus('Face detection test completed. Check the captured images below.', 'success');
                
            } catch (error) {
                updateStatus('Face detection test failed: ' + error.message, 'error');
            }
        }
        
        function viewResults() {
            if (capturedImages.length === 0) {
                updateStatus('No images captured yet. Please capture some photos first.', 'warning');
                return;
            }
            
            const totalImages = capturedImages.length;
            const processedImages = capturedImages.filter(img => img.processed).length;
            const facesDetected = capturedImages.filter(img => img.faceDetected).length;
            const avgConfidence = capturedImages
                .filter(img => img.faceDetected)
                .reduce((sum, img) => sum + img.confidence, 0) / facesDetected || 0;
            
            const results = `
                Demo Results:
                • Total Images: ${totalImages}
                • Processed: ${processedImages}
                • Faces Detected: ${facesDetected}
                • Success Rate: ${((facesDetected/totalImages) * 100).toFixed(1)}%
                • Average Confidence: ${(avgConfidence * 100).toFixed(1)}%
            `;
            
            alert(results);
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