/**
 * Camera Capture Client Library
 * Handles webcam access and photo capture for facial recognition
 */

class CameraCaptureClient {
    constructor() {
        this.stream = null;
        this.videoElement = null;
        this.canvasElement = null;
        this.isCapturing = false;
        this.isStreamActive = false;
        
        this.config = {
            video: {
                width: { ideal: 640 },
                height: { ideal: 480 },
                facingMode: 'user' // front-facing camera
            },
            audio: false
        };
        
        this.callbacks = {
            onCameraReady: null,
            onCameraError: null,
            onPhotoCapture: null,
            onStreamEnd: null
        };
    }

    /**
     * Check if camera is supported
     */
    isCameraSupported() {
        return !!(navigator.mediaDevices && navigator.mediaDevices.getUserMedia);
    }

    /**
     * Initialize camera access
     */
    async initializeCamera(videoElementId, canvasElementId = null) {
        try {
            if (!this.isCameraSupported()) {
                throw new Error('Camera not supported in this browser');
            }

            this.videoElement = document.getElementById(videoElementId);
            if (!this.videoElement) {
                throw new Error(`Video element with id '${videoElementId}' not found`);
            }

            if (canvasElementId) {
                this.canvasElement = document.getElementById(canvasElementId);
                if (!this.canvasElement) {
                    throw new Error(`Canvas element with id '${canvasElementId}' not found`);
                }
            }

            // Request camera access
            this.stream = await navigator.mediaDevices.getUserMedia(this.config);
            
            // Set video source
            this.videoElement.srcObject = this.stream;
            this.videoElement.setAttribute('playsinline', true);
            this.videoElement.setAttribute('autoplay', true);
            this.videoElement.setAttribute('muted', true);
            
            // Wait for video to be ready
            await new Promise((resolve, reject) => {
                this.videoElement.onloadedmetadata = () => {
                    this.videoElement.play()
                        .then(() => {
                            this.isStreamActive = true;
                            if (this.callbacks.onCameraReady) {
                                this.callbacks.onCameraReady();
                            }
                            resolve();
                        })
                        .catch(reject);
                };
                
                this.videoElement.onerror = () => {
                    reject(new Error('Failed to load video stream'));
                };
            });

            return true;

        } catch (error) {
            console.error('Camera initialization failed:', error);
            
            if (this.callbacks.onCameraError) {
                this.callbacks.onCameraError(error);
            }
            
            throw error;
        }
    }

    /**
     * Capture photo from video stream
     */
    capturePhoto() {
        try {
            if (!this.isStreamActive || !this.videoElement) {
                throw new Error('Camera not initialized or stream not active');
            }

            // Create canvas if not provided
            let canvas = this.canvasElement;
            if (!canvas) {
                canvas = document.createElement('canvas');
            }

            // Set canvas dimensions to match video
            const videoWidth = this.videoElement.videoWidth;
            const videoHeight = this.videoElement.videoHeight;
            
            if (videoWidth === 0 || videoHeight === 0) {
                throw new Error('Video stream not ready for capture');
            }

            canvas.width = videoWidth;
            canvas.height = videoHeight;

            // Draw video frame to canvas
            const context = canvas.getContext('2d');
            context.drawImage(this.videoElement, 0, 0, videoWidth, videoHeight);

            // Convert to blob
            return new Promise((resolve, reject) => {
                canvas.toBlob((blob) => {
                    if (blob) {
                        // Create file object
                        const timestamp = new Date().getTime();
                        const file = new File([blob], `camera_capture_${timestamp}.jpg`, {
                            type: 'image/jpeg',
                            lastModified: timestamp
                        });

                        const imageData = {
                            file: file,
                            blob: blob,
                            dataUrl: canvas.toDataURL('image/jpeg', 0.9),
                            width: videoWidth,
                            height: videoHeight,
                            timestamp: timestamp
                        };

                        if (this.callbacks.onPhotoCapture) {
                            this.callbacks.onPhotoCapture(imageData);
                        }

                        resolve(imageData);
                    } else {
                        reject(new Error('Failed to capture photo'));
                    }
                }, 'image/jpeg', 0.9);
            });

        } catch (error) {
            console.error('Photo capture failed:', error);
            throw error;
        }
    }

    /**
     * Stop camera stream
     */
    stopCamera() {
        try {
            if (this.stream) {
                this.stream.getTracks().forEach(track => {
                    track.stop();
                });
                this.stream = null;
            }

            if (this.videoElement) {
                this.videoElement.srcObject = null;
            }

            this.isStreamActive = false;
            this.isCapturing = false;

            if (this.callbacks.onStreamEnd) {
                this.callbacks.onStreamEnd();
            }

            return true;

        } catch (error) {
            console.error('Error stopping camera:', error);
            return false;
        }
    }

    /**
     * Switch camera (front/back)
     */
    async switchCamera() {
        try {
            if (!this.isStreamActive) {
                throw new Error('Camera not active');
            }

            // Toggle facing mode
            this.config.video.facingMode = 
                this.config.video.facingMode === 'user' ? 'environment' : 'user';

            // Restart camera with new configuration
            this.stopCamera();
            await this.initializeCamera(this.videoElement.id, this.canvasElement?.id);

            return true;

        } catch (error) {
            console.error('Camera switch failed:', error);
            throw error;
        }
    }

    /**
     * Get available camera devices
     */
    async getCameraDevices() {
        try {
            if (!this.isCameraSupported()) {
                throw new Error('Media devices not supported');
            }

            const devices = await navigator.mediaDevices.enumerateDevices();
            return devices.filter(device => device.kind === 'videoinput');

        } catch (error) {
            console.error('Failed to get camera devices:', error);
            throw error;
        }
    }

    /**
     * Set specific camera device
     */
    async setCameraDevice(deviceId) {
        try {
            this.config.video.deviceId = { exact: deviceId };
            
            if (this.isStreamActive) {
                this.stopCamera();
                await this.initializeCamera(this.videoElement.id, this.canvasElement?.id);
            }

            return true;

        } catch (error) {
            console.error('Failed to set camera device:', error);
            throw error;
        }
    }

    /**
     * Set event callbacks
     */
    setCallbacks(callbacks) {
        this.callbacks = { ...this.callbacks, ...callbacks };
    }

    /**
     * Get camera stream status
     */
    getStatus() {
        return {
            isSupported: this.isCameraSupported(),
            isStreamActive: this.isStreamActive,
            isCapturing: this.isCapturing,
            hasVideoElement: !!this.videoElement,
            hasCanvasElement: !!this.canvasElement,
            facingMode: this.config.video.facingMode
        };
    }

    /**
     * Create camera UI elements
     */
    createCameraUI(containerId) {
        const container = document.getElementById(containerId);
        if (!container) {
            throw new Error(`Container with id '${containerId}' not found`);
        }

        const cameraHTML = `
            <div class="camera-capture-container">
                <div class="camera-preview-area">
                    <video id="cameraVideo" class="camera-video" playsinline autoplay muted></video>
                    <canvas id="cameraCanvas" class="camera-canvas" style="display: none;"></canvas>
                    
                    <div class="camera-overlay">
                        <div class="face-guide-oval"></div>
                        <div class="camera-instructions">
                            <p>Position your face in the oval</p>
                            <small>Look directly at the camera</small>
                        </div>
                    </div>
                </div>
                
                <div class="camera-controls">
                    <button type="button" class="btn btn-primary" id="startCameraBtn">
                        <i class="fas fa-camera"></i> Start Camera
                    </button>
                    <button type="button" class="btn btn-success" id="capturePhotoBtn" style="display: none;">
                        <i class="fas fa-camera-retro"></i> Capture Photo
                    </button>
                    <button type="button" class="btn btn-warning" id="switchCameraBtn" style="display: none;">
                        <i class="fas fa-sync-alt"></i> Switch Camera
                    </button>
                    <button type="button" class="btn btn-danger" id="stopCameraBtn" style="display: none;">
                        <i class="fas fa-stop"></i> Stop Camera
                    </button>
                </div>
                
                <div class="camera-status" id="cameraStatus"></div>
            </div>
        `;

        container.innerHTML = cameraHTML;
        
        // Add event listeners
        this.setupCameraControls();
        
        return {
            videoElement: document.getElementById('cameraVideo'),
            canvasElement: document.getElementById('cameraCanvas'),
            container: container
        };
    }

    /**
     * Setup camera control event listeners
     */
    setupCameraControls() {
        const startBtn = document.getElementById('startCameraBtn');
        const captureBtn = document.getElementById('capturePhotoBtn');
        const switchBtn = document.getElementById('switchCameraBtn');
        const stopBtn = document.getElementById('stopCameraBtn');
        const statusDiv = document.getElementById('cameraStatus');

        if (startBtn) {
            startBtn.addEventListener('click', async () => {
                try {
                    this.showCameraStatus('Starting camera...', 'info');
                    await this.initializeCamera('cameraVideo', 'cameraCanvas');
                    
                    startBtn.style.display = 'none';
                    captureBtn.style.display = 'inline-block';
                    switchBtn.style.display = 'inline-block';
                    stopBtn.style.display = 'inline-block';
                    
                    this.showCameraStatus('Camera ready', 'success');
                } catch (error) {
                    this.showCameraStatus('Failed to start camera: ' + error.message, 'error');
                }
            });
        }

        if (captureBtn) {
            captureBtn.addEventListener('click', async () => {
                try {
                    this.showCameraStatus('Capturing photo...', 'info');
                    const imageData = await this.capturePhoto();
                    this.showCameraStatus('Photo captured successfully', 'success');
                } catch (error) {
                    this.showCameraStatus('Failed to capture photo: ' + error.message, 'error');
                }
            });
        }

        if (switchBtn) {
            switchBtn.addEventListener('click', async () => {
                try {
                    this.showCameraStatus('Switching camera...', 'info');
                    await this.switchCamera();
                    this.showCameraStatus('Camera switched', 'success');
                } catch (error) {
                    this.showCameraStatus('Failed to switch camera: ' + error.message, 'error');
                }
            });
        }

        if (stopBtn) {
            stopBtn.addEventListener('click', () => {
                this.stopCamera();
                
                startBtn.style.display = 'inline-block';
                captureBtn.style.display = 'none';
                switchBtn.style.display = 'none';
                stopBtn.style.display = 'none';
                
                this.showCameraStatus('Camera stopped', 'info');
            });
        }
    }

    /**
     * Show camera status message
     */
    showCameraStatus(message, type = 'info') {
        const statusDiv = document.getElementById('cameraStatus');
        if (statusDiv) {
            statusDiv.innerHTML = `<div class="alert alert-${type === 'error' ? 'danger' : type === 'success' ? 'success' : 'info'}">${message}</div>`;
            
            // Auto-hide success messages
            if (type === 'success') {
                setTimeout(() => {
                    statusDiv.innerHTML = '';
                }, 3000);
            }
        }
    }
}

// Global instance
window.CameraCaptureClient = CameraCaptureClient;