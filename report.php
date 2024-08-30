<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard - Student Clearance Management System</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

</head>
<body>

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">

            <!-- Reports -->
<div class="col-12">
    <div class="card">
        <div class="filter">
            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                    <h6>Filter</h6>
                </li>
                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
            </ul>
        </div>

        <div class="card-body">
            <h5 class="card-title">Reports <span>/Today</span></h5>

            <!-- Line Chart -->
            <div id="reportsChart"></div>

            <script>
                document.addEventListener("DOMContentLoaded", () => {
                    fetch('line_chart_report.php')
                        .then(response => response.json())
                        .then(data => {
                            const options = {
                                series: [{
                                    name: 'Pending',
                                    data: data.pendingCounts
                                }, {
                                    name: 'Approved',
                                    data: data.approvedCounts
                                }, {
                                    name: 'Rejected',
                                    data: data.rejectedCounts
                                }],
                                chart: {
                                    height: 350,
                                    type: 'line',
                                    toolbar: {
                                        show: false
                                    },
                                },
                                markers: {
                                    size: 4
                                },
                                colors: ['#4154f1', '#2eca6a', '#ff771d'],
                                stroke: {
                                    curve: 'smooth',
                                    width: 2
                                },
                                xaxis: {
                                    categories: data.actors
                                },
                                tooltip: {
                                    x: {
                                        show: true
                                    }
                                }
                            };

                            const chart = new ApexCharts(document.querySelector("#reportsChart"), options);
                            chart.render();
                        })
                        .catch(error => console.error('Error fetching data:', error));
                });
            </script>
            <!-- End Line Chart -->

        </div>
    </div>
</div><!-- End Reports -->

            <!-- Clearance Requests by Date Report -->
<div class="col-12">
    <div class="card recent-sales overflow-auto">

        <div class="filter">
            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                    <h6>Filter</h6>
                </li>
                <li><a class="dropdown-item" href="#" id="filterToday">Today</a></li>
                <li><a class="dropdown-item" href="#" id="filterThisMonth">This Month</a></li>
                <li><a class="dropdown-item" href="#" id="filterThisYear">This Year</a></li>
            </ul>
        </div>

        <div class="card-body">
            <h5 class="card-title">Clearance Requests by Date Report</h5>
            
            <form method="POST" action="date_report.php">
                <div class="row mb-3">
                    <label for="start_date" class="col-sm-2 col-form-label">Start Date</label>
                    <div class="col-sm-4">
                        <input type="date" class="form-control" name="start_date" id="start_date" required>
                    </div>
                    <label for="end_date" class="col-sm-2 col-form-label">End Date</label>
                    <div class="col-sm-4">
                        <input type="date" class="form-control" name="end_date" id="end_date" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Generate Report</button>
            </form>

            <div id="reportContent">
                <!-- The report will be rendered here by Date_report.php -->
            </div>
        </div>
    </div>
</div>

          </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">

          <!-- Recent Rejected Students -->
<div class="card">
  <div class="filter">
    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
      <li class="dropdown-header text-start">
        <h6>Filter</h6>
      </li>
      <li><a class="dropdown-item" href="#">Today</a></li>
      <li><a class="dropdown-item" href="#">This Month</a></li>
      <li><a class="dropdown-item" href="#">This Year</a></li>
    </ul>
  </div>

  <div class="card-body">
    <h5 class="card-title">Recent Rejected Students <span>| All Time</span></h5>

    <div class="activity">
      <?php include 'recent_report.php'; ?>
    </div>
  </div>
</div><!-- End Recent Rejected Students -->

        </div><!-- End Right side columns -->

      </div>
    </section>

  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>
</html>