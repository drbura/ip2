<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Dashboard - Student Clearance Management System</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
</head>
<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="#" class="logo d-flex align-items-center">
        <img width="35px"  src="../images/download.jpg" alt="DDU IMAGE">
        <span class="d-none d-lg-block">Clearance System</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        <li class="nav-item d-block d-lg-none">
        </li>
        <li class="nav-item dropdown">
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
            <li>
              <hr class="dropdown-divider">
            </li>
            <li class="message-item">
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li class="message-item">
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li class="message-item">
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li class="dropdown-footer">
            </li>
          </ul><!-- End Messages Dropdown Items -->
        </li><!-- End Messages Nav -->
        <li class="nav-item dropdown pe-3">
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img width="40vh" height="60vh" src="" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2">SchoolDean</span>
          </a><!-- End Profile Iamge Icon -->
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>Staff</h6>
              <span>SchoolDean</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.php">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="#">
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="#">
                <i class="bi bi-question-circle"></i>
                <span>Need Help?</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="../../index.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
              </a>
            </li>
          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->
      </ul>
    </nav><!-- End Icons Navigation -->
  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
      <li class="nav-item">
        <a id='redirectLink' class="nav-link " href="#">
          <i class="bi bi-grid"></i>
          <span>SchoolDean Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <!-- <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Registration</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="admition.php">
              <i class="bi bi-circle"></i><span>Student Registration</span>
            </a>
          </li>
          <li>
            <a href="privilage.php">
              <i class="bi bi-circle"></i><span>User Previlage</span>
            </a>
          </li>
        </ul> -->
     <!-- </li> End Components Nav -->

      <!-- New Substaff link for School Dean actor -->
      
      <li class="nav-item">
        <a class="nav-link collapsed" href="../subStaffs/">
          <i class="bi bi-people"></i>
          <span>Substaff Registration</span>
        </a>
       </li>
      

       
       
      <li class="nav-item">
        
      </li>
      <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="#">
          <i class="bi bi-person"></i>
          <span>user data</span>
        </a>
      </li> -->
      

      <li class="nav-heading">Pages</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="#">
          <i class="bi bi-person"></i>
          <span>Profile</span>
        </a>
      </li><!-- End Profile Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="../../index.php">
          <i class="bi bi-box-arrow-in-right"></i>
          <span>Logout</span>
        </a>
      </li><!-- End Login Page Nav -->
    </ul>
  </aside><!-- End Sidebar-->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <script>
    document.addEventListener('DOMContentLoaded', (event) => {
    const staff = 'SchoolDean'; // Replace 'actor_name' with the actual staff name or retrieve it dynamically

    // Get the anchor link by its id
    const redirectLink = document.getElementById('redirectLink');

    // Add click event listener
    redirectLink.addEventListener('click', (e) => {
        e.preventDefault(); // Prevent the default anchor link behavior

        // Redirect to the desired URL
        window.location.href = '../actors/actor_dashboard.php?actor=' + encodeURIComponent(staff);
    });
});

  </script>
</body>
</html>
