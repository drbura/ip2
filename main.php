<!-- main.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
    <link rel="stylesheet" href="path_to_your_css/bootstrap.css">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>
<body>

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

</body>
</html>
