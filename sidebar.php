<?php
error_reporting(0);
session_start(); 
?>
  
<nav class="sidebar" id="sidebar" style="position: fixed; width: 255px; height: 100vh; overflow-y: auto; background: #161a27;">
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
              <span class="menu-title">Print Certificates</span>
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
/* Additional styles for the sidebar */
.sidebar {
  box-shadow: 0 0 15px rgba(0,0,0,0.1);
}

.sidebar .nav-link:hover {
  background: rgba(255,255,255,0.9) !important;
  color: #000 !important;
}

.sidebar .nav-link:hover i {
  color: #000 !important;
}

/* Active state for main menu items */
.sidebar .nav-item.active > .nav-link,
.sidebar .nav-item > .nav-link[aria-expanded="true"] {
  background: rgba(255,255,255,0.9) !important;
  color: #000 !important;
}

.sidebar .nav-item.active > .nav-link i,
.sidebar .nav-item > .nav-link[aria-expanded="true"] i {
  color: #000 !important;
}

/* Submenu items */
.sidebar .sub-menu .nav-link:hover {
  background: rgba(255,255,255,0.9) !important;
  color: #000 !important;
}

.sidebar .sub-menu .nav-link:hover i {
  color: #000 !important;
}

/* Active state for submenu items */
.sidebar .nav.sub-menu .nav-item.active > .nav-link,
.sidebar .collapse.show .nav-item.active > .nav-link {
  background: rgba(255,255,255,0.9) !important;
  color: #000 !important;
}

.sidebar .nav.sub-menu .nav-item.active > .nav-link i,
.sidebar .collapse.show .nav-item.active > .nav-link i {
  color: #000 !important;
}

/* Menu arrow color fix */
.sidebar .nav-link[aria-expanded="true"] .menu-arrow {
  color: #000 !important;
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