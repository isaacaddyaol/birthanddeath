<?php
error_reporting(0);
session_start(); 
?>
  
<nav class="sidebar" id="sidebar" style="position: fixed; width: 255px; height: 100vh; overflow-y: auto; background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%); box-shadow: 4px 0 20px rgba(0,0,0,0.15);">
        <ul class="nav" style="padding-top: 20px;">
          <li class="nav-item nav-profile">
            <div class="nav-link" style="padding: 15px 20px;">
              <div class="user-wrapper">
                <div class="profile-image">
                  <img src="coatofarms.png" alt="profile image" style="width: 40px; height: 40px; border-radius: 50%;">
                </div>
                <div class="text-wrapper" style="margin-left: 15px;">
                  <p class="profile-name" style="color: #fff; margin: 0; font-size: 14px;">
                    <?php if (isset($_SESSION['username'])) { 
                        echo 'User: ' .$_SESSION['username'];          
                    } ?>
                  </p>
                  <div>
                    <small class="designation" style="color: rgba(255,255,255,0.7);">
                    <?php if (isset($_SESSION['role'])) { 
                        echo 'Role: ' .$_SESSION['role']; 
                    } ?>
                    </small>
                    <span class="status-indicator online"></span>
                  </div>
                </div>
              </div>
              <?php
              if(isset($_SESSION['role'])){
                $role=$_SESSION['role'];
                if($role=='Super_Administrator'){
                  echo '<a href="UsersRegistration.php" class="btn btn-success btn-block" style="margin-top: 15px;">
                    <i class="mdi mdi-plus"></i> New Users
                  </a>';
                }
              }
              ?>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="AdminDashboard.php" style="color: #fff; padding: 12px 20px;">
              <i class="menu-icon mdi mdi-television" style="color: rgba(255,255,255,0.7);"></i>
              <span class="menu-title">Home</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic" style="color: #fff; padding: 12px 20px;">
              <i class="menu-icon mdi mdi-content-copy" style="color: rgba(255,255,255,0.7);"></i>
              <span class="menu-title">Registration</span>
              <i class="menu-arrow" style="color: rgba(255,255,255,0.7);"></i>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu" style="background: rgba(0,0,0,0.1);">
                <li class="nav-item">
                  <a class="nav-link" href="BirthRegistration.php" style="color: rgba(255,255,255,0.7); padding: 10px 20px 10px 40px;">Birth Registration</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="DeathRegistration.php" style="color: rgba(255,255,255,0.7); padding: 10px 20px 10px 40px;">Death Registration</a>
                </li>
                <?php if($role=='Super_Administrator'){ echo '
                <li class="nav-item">
                  <a class="nav-link" href="centreRegistration.php" style="color: rgba(255,255,255,0.7); padding: 10px 20px 10px 40px;">Centre Registration</a>
                </li>';} ?>
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#records" aria-expanded="false" aria-controls="records" style="color: #fff; padding: 12px 20px;">
              <i class="menu-icon mdi mdi-table" style="color: rgba(255,255,255,0.7);"></i>
              <span class="menu-title">Records</span>
              <i class="menu-arrow" style="color: rgba(255,255,255,0.7);"></i>
            </a>
            <div class="collapse" id="records">
              <ul class="nav flex-column sub-menu" style="background: rgba(0,0,0,0.1);">
                <li class="nav-item">
                  <a class="nav-link" href="BirthReports.php" style="color: rgba(255,255,255,0.7); padding: 10px 20px 10px 40px;">Birth Records</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="DeathReports.php" style="color: rgba(255,255,255,0.7); padding: 10px 20px 10px 40px;">Death Records</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="CentreReports.php" style="color: rgba(255,255,255,0.7); padding: 10px 20px 10px 40px;">Centre Records</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="UsersReports.php" style="color: rgba(255,255,255,0.7); padding: 10px 20px 10px 40px;">User Records</a>
                </li>
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#certificates" aria-expanded="false" aria-controls="certificates" style="color: #fff; padding: 12px 20px;">
              <i class="menu-icon mdi mdi-file-document" style="color: rgba(255,255,255,0.7);"></i>
              <span class="menu-title">Print Certificates (Biometric Required)</span>
              <i class="menu-arrow" style="color: rgba(255,255,255,0.7);"></i>
            </a>
            <div class="collapse" id="certificates">
              <ul class="nav flex-column sub-menu" style="background: rgba(0,0,0,0.1);">
                <li class="nav-item">
                  <a class="nav-link" href="PrintBirthCert.php" style="color: rgba(255,255,255,0.7); padding: 10px 20px 10px 40px;">Birth Certificates</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="PrintDeathCert.php" style="color: rgba(255,255,255,0.7); padding: 10px 20px 10px 40px;">Death Certificates</a>
                </li>
              </ul>
            </div>
          </li>

          <!-- Facial Recognition Hub -->
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#facial-recognition" aria-expanded="false" aria-controls="facial-recognition" style="color: #fff; padding: 12px 20px;">
              <i class="menu-icon mdi mdi-face-recognition" style="color: rgba(255,255,255,0.7);"></i>
              <span class="menu-title">Facial Recognition</span>
              <i class="menu-arrow" style="color: rgba(255,255,255,0.7);"></i>
            </a>
            <div class="collapse" id="facial-recognition">
              <ul class="nav flex-column sub-menu" style="background: rgba(0,0,0,0.1);">
                <li class="nav-item">
                  <a class="nav-link" href="FacialRecognitionHub.php" style="color: rgba(255,255,255,0.7); padding: 10px 20px 10px 40px;">
                    <i class="mdi mdi-view-dashboard" style="color: rgba(255,255,255,0.5); margin-right: 8px;"></i>
                    Recognition Hub
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="BirthRegistration.php" style="color: rgba(255,255,255,0.7); padding: 10px 20px 10px 40px;">
                    <i class="mdi mdi-baby-face" style="color: rgba(255,255,255,0.5); margin-right: 8px;"></i>
                    Birth Registration
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="FacialVerification.php" style="color: rgba(255,255,255,0.7); padding: 10px 20px 10px 40px;">
                    <i class="mdi mdi-shield-check" style="color: rgba(255,255,255,0.5); margin-right: 8px;"></i>
                    Certificate Verification
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="CameraCaptureDemo.php" style="color: rgba(255,255,255,0.7); padding: 10px 20px 10px 40px;">
                    <i class="mdi mdi-video" style="color: rgba(255,255,255,0.5); margin-right: 8px;"></i>
                    Camera Demo
                  </a>
                </li>
              </ul>
            </div>
          </li>

          <?php
          if($role=='Super_Administrator'){
            echo '<li class="nav-item">
              <a class="nav-link" href="PrintBirthCert.php" style="color: #fff; padding: 12px 20px;">
                <i class="menu-icon mdi mdi-receipt" style="color: rgba(255,255,255,0.7);"></i>
                <span class="menu-title">Birth Certificates</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="PrintDeathCert.php" style="color: #fff; padding: 12px 20px;">
                <i class="menu-icon mdi mdi-receipt" style="color: rgba(255,255,255,0.7);"></i>
                <span class="menu-title">Death Certificates</span>
              </a>
            </li>';
          }
          ?>

          <li class="nav-item" style="margin-top: 20px;">
            <a class="nav-link" href="logout.php" style="color: #fff; padding: 12px 20px;">
              <i class="menu-icon mdi mdi-logout" style="color: rgba(255,255,255,0.7);"></i>
              <span class="menu-title">Sign Out</span>
            </a>
          </li>
        </ul>
      </nav>

<style>
/* Modern Corporate Sidebar Styles */
.sidebar {
  box-shadow: 4px 0 20px rgba(0,0,0,0.15);
  border-right: 1px solid rgba(255,255,255,0.1);
}

.sidebar .nav-link {
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  border-radius: 0;
  margin: 0;
  border-left: 3px solid transparent;
  position: relative;
}

.sidebar .nav-link:hover {
  background: rgba(59, 130, 246, 0.1) !important;
  color: #60a5fa !important;
  border-left: 3px solid #3b82f6;
  transform: none;
  box-shadow: none;
}

.sidebar .nav-link:hover i {
  color: #60a5fa !important;
}

/* Active state for main menu items */
.sidebar .nav-item.active > .nav-link,
.sidebar .nav-item > .nav-link[aria-expanded="true"] {
  background: rgba(59, 130, 246, 0.15) !important;
  color: #60a5fa !important;
  border-left: 3px solid #3b82f6;
  box-shadow: none;
}

.sidebar .nav-item.active > .nav-link i,
.sidebar .nav-item > .nav-link[aria-expanded="true"] i {
  color: #60a5fa !important;
}

/* Submenu items */
.sidebar .sub-menu {
  background: rgba(15, 23, 42, 0.8) !important;
  border-radius: 0;
  margin: 0;
  padding: 8px 0 !important;
  border-left: 3px solid rgba(59, 130, 246, 0.3);
}

.sidebar .sub-menu .nav-link {
  margin: 0;
  border-radius: 0;
  padding-left: 50px !important;
  border-left: none;
  position: relative;
}

.sidebar .sub-menu .nav-link:before {
  content: '';
  position: absolute;
  left: 35px;
  top: 50%;
  width: 6px;
  height: 6px;
  background: rgba(148, 163, 184, 0.5);
  border-radius: 50%;
  transform: translateY(-50%);
  transition: all 0.3s ease;
}

.sidebar .sub-menu .nav-link:hover {
  background: rgba(59, 130, 246, 0.15) !important;
  color: #60a5fa !important;
  transform: none;
  border-left: none;
}

.sidebar .sub-menu .nav-link:hover:before {
  background: #60a5fa;
  transform: translateY(-50%) scale(1.3);
}

.sidebar .sub-menu .nav-link:hover i {
  color: #60a5fa !important;
}

/* Active state for submenu items */
.sidebar .nav.sub-menu .nav-item.active > .nav-link,
.sidebar .collapse.show .nav-item.active > .nav-link {
  background: rgba(59, 130, 246, 0.2) !important;
  color: #60a5fa !important;
  border-left: none;
}

.sidebar .nav.sub-menu .nav-item.active > .nav-link:before,
.sidebar .collapse.show .nav-item.active > .nav-link:before {
  background: #60a5fa;
  transform: translateY(-50%) scale(1.5);
}

.sidebar .nav.sub-menu .nav-item.active > .nav-link i,
.sidebar .collapse.show .nav-item.active > .nav-link i {
  color: #60a5fa !important;
}

/* Menu arrow color fix */
.sidebar .nav-link[aria-expanded="true"] .menu-arrow {
  color: #60a5fa !important;
}

/* Profile section styling */
.sidebar .nav-profile .nav-link {
  background: rgba(30, 41, 59, 0.8);
  border-radius: 0;
  margin: 0;
  border-left: none;
  border-bottom: 1px solid rgba(255,255,255,0.1);
}

.sidebar .nav-profile .nav-link:hover {
  background: rgba(30, 41, 59, 0.9);
  transform: none;
  border-left: none;
}

/* Icon styling */
.sidebar .menu-icon {
  filter: none;
  color: rgba(148, 163, 184, 0.8) !important;
}

/* Text styling */
.sidebar .menu-title {
  font-weight: 500;
  letter-spacing: 0.025em;
}

/* Adjust main content to account for fixed sidebar */
.main-panel {
  margin-left: 255px;
  width: calc(100% - 255px);
}

@media (max-width: 991px) {
  .sidebar {
    transform: translateX(-100%);
    transition: transform 0.3s ease;
  }
  
  .sidebar.active {
    transform: translateX(0);
  }
  
  .main-panel {
    margin-left: 0;
    width: 100%;
  }
}
</style>

<script>
// Add active class to current menu item
document.addEventListener('DOMContentLoaded', function() {
  const currentLocation = window.location.pathname;
  const menuItems = document.querySelectorAll('.sidebar .nav-item');
  
  menuItems.forEach(item => {
    const link = item.querySelector('.nav-link');
    if (link && link.getAttribute('href') === currentLocation.split('/').pop()) {
      item.classList.add('active');
      // If it's in a submenu, expand the parent
      const parentCollapse = item.closest('.collapse');
      if (parentCollapse) {
        parentCollapse.classList.add('show');
        const parentItem = parentCollapse.previousElementSibling.closest('.nav-item');
        if (parentItem) {
          parentItem.classList.add('active');
        }
        const parentLink = document.querySelector(`[href="#${parentCollapse.id}"]`);
        if (parentLink) {
          parentLink.setAttribute('aria-expanded', 'true');
        }
      }
    }
  });
});
</script>