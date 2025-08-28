/**
 * Facial Recognition Client Library
 * Handles client-side face detection and processing using face-api.js
 */

class FacialRecognitionClient {
    constructor() {
        this.modelsLoaded = false;
        this.isProcessing = false;
        this.config = {
            apiEndpoint: 'api/facial_recognition.php',
            modelPath: 'https://cdn.jsdelivr.net/npm/@vladmandic/face-api@latest/model/',
            minConfidence: 0.6,
            faceDetectorOptions: {
                minFaceSize: 160,
                scoreThreshold: 0.5,
                nmsThreshold: 0.4
            }
        };
        
        this.callbacks = {
            onProgress: null,
            onSuccess: null,
            onError: null
        };
    }

    /**
     * Initialize face-api.js and load models
     */
    async initialize(progressCallback = null) {
        try {
            if (this.modelsLoaded) {
                return true;
            }

            if (progressCallback) progressCallback('Loading face detection models...');

            // Load required models
            await Promise.all([
                faceapi.nets.tinyFaceDetector.loadFromUri(this.config.modelPath),
                faceapi.nets.faceLandmark68Net.loadFromUri(this.config.modelPath),
                faceapi.nets.faceRecognitionNet.loadFromUri(this.config.modelPath),
                faceapi.nets.faceExpressionNet.loadFromUri(this.config.modelPath)
            ]);

            this.modelsLoaded = true;
            if (progressCallback) progressCallback('Face detection models loaded successfully');
            
            return true;

        } catch (error) {
            console.error('Failed to load face-api models:', error);
            throw new Error('Failed to initialize facial recognition: ' + error.message);
        }
    }

    /**
     * Detect faces in an image
     */
    async detectFaces(imageElement, options = {}) {
        try {
            if (!this.modelsLoaded) {
                await this.initialize();
            }

            const detectionOptions = new faceapi.TinyFaceDetectorOptions({
                ...this.config.faceDetectorOptions,
                ...options
            });

            const detections = await faceapi
                .detectAllFaces(imageElement, detectionOptions)
                .withFaceLandmarks()
                .withFaceDescriptors()
                .withFaceExpressions();

            return {
                success: true,
                detections: detections,
                faceCount: detections.length
            };

        } catch (error) {
            console.error('Face detection failed:', error);
            return {
                success: false,
                error: error.message,
                faceCount: 0
            };
        }
    }

    /**
     * Process image for face registration
     */
    async processImageForRegistration(imageFile, birthId) {
        try {
            this.isProcessing = true;
            
            if (this.callbacks.onProgress) {
                this.callbacks.onProgress('Processing image...');
            }

            // Create image element
            const imageElement = await this.createImageElement(imageFile);
            
            if (this.callbacks.onProgress) {
                this.callbacks.onProgress('Detecting faces...');
            }

            // Detect faces
            const detection = await this.detectFaces(imageElement);
            
            if (!detection.success) {
                throw new Error('Face detection failed: ' + detection.error);
            }

            if (detection.faceCount === 0) {
                throw new Error('No face detected in the image. Please ensure the image shows a clear face.');
            }

            if (detection.faceCount > 1) {
                throw new Error('Multiple faces detected. Please use an image with only one face.');
            }

            const faceDetection = detection.detections[0];
            const confidence = faceDetection.detection.score;

            if (confidence < this.config.minConfidence) {
                throw new Error(`Face detection confidence too low (${(confidence * 100).toFixed(1)}%). Please use a clearer image.`);
            }

            if (this.callbacks.onProgress) {
                this.callbacks.onProgress('Extracting face features...');
            }

            // Get face descriptor
            const descriptor = Array.from(faceDetection.descriptor);
            
            // Get landmarks
            const landmarks = this.extractLandmarks(faceDetection.landmarks);
            
            // Calculate quality score
            const qualityScore = this.calculateQualityScore(faceDetection);

            // Convert image to base64
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            canvas.width = imageElement.width;
            canvas.height = imageElement.height;
            ctx.drawImage(imageElement, 0, 0);
            const imageData = canvas.toDataURL('image/jpeg', 0.9);

            if (this.callbacks.onProgress) {
                this.callbacks.onProgress('Storing facial data...');
            }

            // Store face data
            const storeResult = await this.storeFaceData({
                birth_id: birthId,
                face_descriptor: JSON.stringify(descriptor),
                image_data: imageData,
                confidence: confidence,
                landmarks: JSON.stringify(landmarks),
                quality_score: qualityScore
            });

            this.isProcessing = false;

            if (storeResult.success) {
                if (this.callbacks.onSuccess) {
                    this.callbacks.onSuccess(storeResult);
                }
                return {
                    success: true,
                    message: 'Facial data stored successfully',
                    confidence: confidence,
                    qualityScore: qualityScore,
                    faceId: storeResult.face_id
                };
            } else {
                throw new Error(storeResult.error);
            }

        } catch (error) {
            this.isProcessing = false;
            
            if (this.callbacks.onError) {
                this.callbacks.onError(error);
            }
            
            return {
                success: false,
                error: error.message
            };
        }
    }

    /**
     * Verify face against stored data
     */
    async verifyFace(imageFile, birthId, certNo = null) {
        try {
            this.isProcessing = true;
            
            if (this.callbacks.onProgress) {
                this.callbacks.onProgress('Processing verification image...');
            }

            // Create image element
            const imageElement = await this.createImageElement(imageFile);
            
            if (this.callbacks.onProgress) {
                this.callbacks.onProgress('Detecting face for verification...');
            }

            // Detect face
            const detection = await this.detectFaces(imageElement);
            
            if (!detection.success) {
                throw new Error('Face detection failed: ' + detection.error);
            }

            if (detection.faceCount === 0) {
                throw new Error('No face detected in verification image');
            }

            if (detection.faceCount > 1) {
                throw new Error('Multiple faces detected in verification image');
            }

            const faceDetection = detection.detections[0];
            const descriptor = Array.from(faceDetection.descriptor);

            if (this.callbacks.onProgress) {
                this.callbacks.onProgress('Comparing with stored facial data...');
            }

            // Verify against stored data
            const verifyResult = await this.verifyFaceData({
                birth_id: birthId,
                cert_no: certNo,
                face_descriptor: JSON.stringify(descriptor)
            });

            this.isProcessing = false;

            if (this.callbacks.onSuccess) {
                this.callbacks.onSuccess(verifyResult);
            }

            return verifyResult;

        } catch (error) {
            this.isProcessing = false;
            
            if (this.callbacks.onError) {
                this.callbacks.onError(error);
            }
            
            return {
                success: false,
                error: error.message
            };
        }
    }

    /**
     * Search for matching faces
     */
    async searchFaces(imageFile, limit = 10) {
        try {
            this.isProcessing = true;
            
            if (this.callbacks.onProgress) {
                this.callbacks.onProgress('Processing search image...');
            }

            // Create image element
            const imageElement = await this.createImageElement(imageFile);
            
            // Detect face
            const detection = await this.detectFaces(imageElement);
            
            if (!detection.success) {
                throw new Error('Face detection failed: ' + detection.error);
            }

            if (detection.faceCount === 0) {
                throw new Error('No face detected in search image');
            }

            const faceDetection = detection.detections[0];
            const descriptor = Array.from(faceDetection.descriptor);

            if (this.callbacks.onProgress) {
                this.callbacks.onProgress('Searching for matching faces...');
            }

            // Search for matches
            const searchResult = await this.searchFaceData({
                face_descriptor: JSON.stringify(descriptor),
                limit: limit
            });

            this.isProcessing = false;

            return searchResult;

        } catch (error) {
            this.isProcessing = false;
            
            return {
                success: false,
                error: error.message
            };
        }
    }

    /**
     * Create image element from file
     */
    async createImageElement(file) {
        return new Promise((resolve, reject) => {
            const img = new Image();
            const url = URL.createObjectURL(file);
            
            img.onload = () => {
                URL.revokeObjectURL(url);
                resolve(img);
            };
            
            img.onerror = () => {
                URL.revokeObjectURL(url);
                reject(new Error('Failed to load image'));
            };
            
            img.src = url;
        });
    }

    /**
     * Extract landmarks data
     */
    extractLandmarks(landmarks) {
        return {
            jaw: landmarks.getJawOutline().map(p => [p.x, p.y]),
            leftEyebrow: landmarks.getLeftEyeBrow().map(p => [p.x, p.y]),
            rightEyebrow: landmarks.getRightEyeBrow().map(p => [p.x, p.y]),
            nose: landmarks.getNose().map(p => [p.x, p.y]),
            leftEye: landmarks.getLeftEye().map(p => [p.x, p.y]),
            rightEye: landmarks.getRightEye().map(p => [p.x, p.y]),
            mouth: landmarks.getMouth().map(p => [p.x, p.y])
        };
    }

    /**
     * Calculate face quality score
     */
    calculateQualityScore(detection) {
        const confidence = detection.detection.score;
        const expressions = detection.expressions;
        
        // Factor in various aspects of face quality
        let qualityScore = confidence;
        
        // Penalize for extreme expressions
        const neutralScore = expressions.neutral || 0;
        const happyScore = expressions.happy || 0;
        const sadScore = expressions.sad || 0;
        const angryScore = expressions.angry || 0;
        const surprisedScore = expressions.surprised || 0;
        const disgustScore = expressions.disgusted || 0;
        const fearScore = expressions.fearful || 0;
        
        // Prefer neutral or mildly happy expressions
        if (neutralScore > 0.5 || (happyScore > 0.3 && happyScore < 0.8)) {
            qualityScore *= 1.1;
        } else if (angryScore > 0.7 || sadScore > 0.7 || surprisedScore > 0.7) {
            qualityScore *= 0.8;
        }
        
        // Ensure score is between 0 and 1
        return Math.min(1.0, Math.max(0.0, qualityScore));
    }

    /**
     * Store face data via API
     */
    async storeFaceData(data) {
        const formData = new FormData();
        formData.append('action', 'store_face');
        
        for (const key in data) {
            formData.append(key, data[key]);
        }

        try {
            const response = await fetch(this.config.apiEndpoint, {
                method: 'POST',
                body: formData
            });

            return await response.json();

        } catch (error) {
            return {
                success: false,
                error: 'Network error: ' + error.message
            };
        }
    }

    /**
     * Verify face data via API
     */
    async verifyFaceData(data) {
        const formData = new FormData();
        formData.append('action', 'verify_face');
        
        for (const key in data) {
            formData.append(key, data[key]);
        }

        try {
            const response = await fetch(this.config.apiEndpoint, {
                method: 'POST',
                body: formData
            });

            return await response.json();

        } catch (error) {
            return {
                success: false,
                error: 'Network error: ' + error.message
            };
        }
    }

    /**
     * Search face data via API
     */
    async searchFaceData(data) {
        const formData = new FormData();
        formData.append('action', 'search_faces');
        
        for (const key in data) {
            formData.append(key, data[key]);
        }

        try {
            const response = await fetch(this.config.apiEndpoint, {
                method: 'POST',
                body: formData
            });

            return await response.json();

        } catch (error) {
            return {
                success: false,
                error: 'Network error: ' + error.message
            };
        }
    }

    /**
     * Set callbacks for events
     */
    setCallbacks(callbacks) {
        this.callbacks = { ...this.callbacks, ...callbacks };
    }

    /**
     * Check if processing
     */
    isProcessingImage() {
        return this.isProcessing;
    }

    /**
     * Draw face detection overlay on canvas
     */
    drawDetections(canvas, detections, options = {}) {
        const {
            drawBox = true,
            drawLandmarks = true,
            drawExpressions = false,
            boxColor = '#ff0000',
            landmarkColor = '#00ff00'
        } = options;

        const ctx = canvas.getContext('2d');
        
        detections.forEach(detection => {
            const { x, y, width, height } = detection.detection.box;

            if (drawBox) {
                ctx.strokeStyle = boxColor;
                ctx.lineWidth = 2;
                ctx.strokeRect(x, y, width, height);
                
                // Draw confidence score
                ctx.fillStyle = boxColor;
                ctx.font = '16px Arial';
                ctx.fillText(
                    `${(detection.detection.score * 100).toFixed(1)}%`,
                    x, y - 5
                );
            }

            if (drawLandmarks && detection.landmarks) {
                ctx.fillStyle = landmarkColor;
                detection.landmarks.positions.forEach(point => {
                    ctx.beginPath();
                    ctx.arc(point.x, point.y, 2, 0, 2 * Math.PI);
                    ctx.fill();
                });
            }

            if (drawExpressions && detection.expressions) {
                const expressions = detection.expressions;
                const maxExpression = Object.keys(expressions).reduce((a, b) => 
                    expressions[a] > expressions[b] ? a : b
                );
                
                ctx.fillStyle = '#ffffff';
                ctx.fillRect(x, y + height + 5, width, 25);
                ctx.fillStyle = '#000000';
                ctx.font = '14px Arial';
                ctx.fillText(
                    `${maxExpression}: ${(expressions[maxExpression] * 100).toFixed(0)}%`,
                    x + 5, y + height + 20
                );
            }
        });
    }
}

// Global instance
window.FacialRecognitionClient = FacialRecognitionClient;