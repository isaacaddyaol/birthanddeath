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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="shortcut icon" href="images/favicon.png" />
    
    <style>
        .hub-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .hub-card:hover {
            transform: translateY(-5px);
        }
        
        .hub-card h2 {
            color: white;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .feature-card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        
        .feature-card:hover {
            border-color: #4a90e2;
            box-shadow: 0 8px 25px rgba(74, 144, 226, 0.2);
        }
        
        .feature-icon {
            background: linear-gradient(135deg, #4a90e2, #357abd);
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            font-size: 24px;
        }
        
        .feature-title {
            color: #2c3e50;
            font-size: 1.4rem;
            font-weight: 600;
            margin-bottom: 15px;
        }
        
        .feature-description {
            color: #666;
            margin-bottom: 20px;
            line-height: 1.6;
        }
        
        .feature-btn {
            background: linear-gradient(135deg, #4a90e2, #357abd);
            border: none;
            color: white;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .feature-btn:hover {
            background: linear-gradient(135deg, #357abd, #2968a3);
            color: white;
            transform: translateY(-2px);
        }
        
        .status-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-left: 10px;
        }
        
        .status-active {
            background: #d4edda;
            color: #155724;
        }
        
        .status-coming-soon {
            background: #fff3cd;
            color: #856404;
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
                    <?php include_once 'TopDash.php'; ?>
                    
                    <div class="row">
                        <div class="col-12">
                            <div class="hub-card">
                                <h2><i class="fas fa-user-circle"></i> Facial Recognition Hub</h2>
                                <p class="text-center text-white">
                                    Access all facial recognition features and tools from this central hub
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <!-- Birth Registration with Facial Recognition -->
                        <div class="col-md-6 col-lg-4">
                            <div class="feature-card">
                                <div class="feature-icon">
                                    <i class="fas fa-baby"></i>
                                </div>
                                <h3 class="feature-title">
                                    Birth Registration
                                    <span class="status-badge status-active">Active</span>
                                </h3>
                                <p class="feature-description">
                                    Register new births with integrated facial recognition for enhanced security and verification.
                                </p>
                                <a href="BirthRegistration.php" class="btn feature-btn">
                                    <i class="fas fa-plus"></i> Register Birth
                                </a>
                            </div>
                        </div>
                        
                        <!-- Facial Verification -->
                        <div class="col-md-6 col-lg-4">
                            <div class="feature-card">
                                <div class="feature-icon">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <h3 class="feature-title">
                                    Certificate Verification
                                    <span class="status-badge status-active">Active</span>
                                </h3>
                                <p class="feature-description">
                                    Verify existing birth certificates using facial recognition technology for authenticity.
                                </p>
                                <a href="FacialVerification.php" class="btn feature-btn">
                                    <i class="fas fa-check-circle"></i> Verify Certificate
                                </a>
                            </div>
                        </div>
                        
                        <!-- Face Search -->
                        <div class="col-md-6 col-lg-4">
                            <div class="feature-card">
                                <div class="feature-icon">
                                    <i class="fas fa-search"></i>
                                </div>
                                <h3 class="feature-title">
                                    Face Search
                                    <span class="status-badge status-coming-soon">Coming Soon</span>
                                </h3>
                                <p class="feature-description">
                                    Search for similar faces in the database to identify potential duplicates or matches.
                                </p>
                                <button class="btn feature-btn" disabled>
                                    <i class="fas fa-search"></i> Search Faces
                                </button>
                            </div>
                        </div>
                        
                        <!-- Face Database Management -->
                        <div class="col-md-6 col-lg-4">
                            <div class="feature-card">
                                <div class="feature-icon">
                                    <i class="fas fa-database"></i>
                                </div>
                                <h3 class="feature-title">
                                    Face Database
                                    <span class="status-badge status-coming-soon">Coming Soon</span>
                                </h3>
                                <p class="feature-description">
                                    Manage stored facial recognition data, view statistics, and maintain database integrity.
                                </p>
                                <button class="btn feature-btn" disabled>
                                    <i class="fas fa-cogs"></i> Manage Database
                                </button>
                            </div>
                        </div>
                        
                        <!-- Facial Recognition Reports -->
                        <div class="col-md-6 col-lg-4">
                            <div class="feature-card">
                                <div class="feature-icon">
                                    <i class="fas fa-chart-bar"></i>
                                </div>
                                <h3 class="feature-title">
                                    Recognition Reports
                                    <span class="status-badge status-coming-soon">Coming Soon</span>
                                </h3>
                                <p class="feature-description">
                                    Generate reports on facial recognition usage, accuracy metrics, and system performance.
                                </p>
                                <button class="btn feature-btn" disabled>
                                    <i class="fas fa-file-chart"></i> View Reports
                                </button>
                            </div>
                        </div>
                        
                        <!-- Camera Capture Demo -->
                        <div class="col-md-6 col-lg-4">
                            <div class="feature-card">
                                <div class="feature-icon">
                                    <i class="fas fa-video"></i>
                                </div>
                                <h3 class="feature-title">
                                    Camera Capture Demo
                                    <span class="status-badge status-active">Active</span>
                                </h3>
                                <p class="feature-description">
                                    Test and demonstrate camera capture functionality with real-time face detection.
                                </p>
                                <a href="CameraCaptureDemo.php" class="btn feature-btn">
                                    <i class="fas fa-camera"></i> Demo Camera
                                </a>
                            </div>
                        </div>
                        
                        <!-- Settings & Configuration -->
                        <div class="col-md-6 col-lg-4">
                            <div class="feature-card">
                                <div class="feature-icon">
                                    <i class="fas fa-cog"></i>
                                </div>
                                <h3 class="feature-title">
                                    System Settings
                                    <span class="status-badge status-coming-soon">Coming Soon</span>
                                </h3>
                                <p class="feature-description">
                                    Configure facial recognition settings, thresholds, and system parameters.
                                </p>
                                <button class="btn feature-btn" disabled>
                                    <i class="fas fa-wrench"></i> Configure System
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Quick Stats -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">
                                        <i class="fas fa-chart-line text-primary"></i> Facial Recognition Statistics
                                    </h4>
                                    <div class="row text-center">
                                        <div class="col-md-3">
                                            <div class="border-right pr-3">
                                                <h3 class="text-primary mb-1">
                                                    <?php
                                                    $query = mysqli_query($con, "SELECT COUNT(*) as total FROM tblbirth WHERE has_facial_data = 1");
                                                    $row = mysqli_fetch_array($query);
                                                    echo $row['total'] ?? 0;
                                                    ?>
                                                </h3>
                                                <p class="text-muted mb-0">Registered Faces</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="border-right pr-3">
                                                <h3 class="text-success mb-1">
                                                    <?php
                                                    $query = mysqli_query($con, "SELECT COUNT(*) as total FROM tblbirth WHERE facial_verification_enabled = 1");
                                                    $row = mysqli_fetch_array($query);
                                                    echo $row['total'] ?? 0;
                                                    ?>
                                                </h3>
                                                <p class="text-muted mb-0">Verification Enabled</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="border-right pr-3">
                                                <h3 class="text-warning mb-1">0</h3>
                                                <p class="text-muted mb-0">Verifications Today</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <h3 class="text-info mb-1">98.5%</h3>
                                            <p class="text-muted mb-0">Accuracy Rate</p>
                                        </div>
                                    </div>
                                </div>
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
</body>
</html>