<?php include 'admin_session.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head> 
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CDMS | Dashboard</title>
  <?php include 'header_scripts.php'; ?> 
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.0.0/chartjs-plugin-datalabels.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-3d/1.0.0/chartjs-plugin-3d.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
  <link rel="shortcut icon" href="dist/img/xchire-logo.png" type="image/x-icon">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <?php include 'admin_navbarsection.php'; ?>  
  <?php include 'admin_profile_modal.php'; ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include 'admin_main_sidebar.php'; ?>  

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    
    <!-- Content Header (Page header) -->
    <?php include 'admin_alert.php'; ?>   
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Admin Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item" style="font-size:12px;"><a href="#">Home</a></li>
              <li class="breadcrumb-item active" style="font-size:12px;">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

   <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- First Row -->
        <div class="row">
          <div class="col-md-8 col-sm-6 col-12">
            <div class="card xhire-outline">
              <div class="card-header">
                <h3 class="card-title" style="font-size:12px;">Stages</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div style="min-height: 250px; max-width: 100%;">
                  <canvas id="customerMetricsChart"></canvas>
                  <script src="customer_metrics_chart.js"></script>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-sm-6 col-12">
            <!-- Total New Customers -->
            <div class="info-box xhire-carinfo">
              <span class="info-box-icon"><i class="fa-solid fa-people-group"></i></span>
              <div class="info-box-content">
                <span class="info-box-text" style="font-size:12px;">Total New Clients</span>
                <span class="info-box-number">
                  <?php
                    include 'conn.php';
                    $sql = "SELECT COUNT(*) AS total_customers FROM customer_orders WHERE customer_category = 'New'";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    echo $row['total_customers'] ?? 'None';
                  ?>
                </span>
              </div>
            </div>
            <!-- Total Existing Customers -->
            <div class="info-box xhire-carsuccess">
              <span class="info-box-icon"><i class="fa-solid fa-people-roof"></i></span>
              <div class="info-box-content">
                <span class="info-box-text" style="font-size:12px;">Total Existing Clients</span>
                <span class="info-box-number">
                  <?php
                    include 'conn.php';
                    $sql = "SELECT COUNT(*) AS total_customers FROM customer_orders WHERE customer_category = 'Existing'";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    echo $row['total_customers'] ?? 'None';
                  ?>
                </span>
              </div>
            </div>
            <!-- Customer Charts Tabs -->
            <div class="info-box bg-gradient-light card xhire-outline card-tabs">
              <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true" style="font-size: 12px;">Client Gender</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false" style="font-size: 12px;">Client Type</a>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-three-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                    <canvas id="genderPieChart" width="400" height="400"></canvas>
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">
                    <canvas id="customerTypePieChart" width="400" height="400"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

<div class="row">
  <div class="col-md-12">
    <div class="card card-navy">
      <div class="card-header">
        <h3 class="card-title" style="font-size:12px;">Status Per Sales Manager</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <!-- /.card-header -->

      <div class="card-body">
        <div class="row">
          <!-- Sales Manager Selection -->
          <div class="col-md-4">
            <div class="form-group">
              <label style="font-size: 12px;">Select Sales Manager</label>
              <select class="form-control form-control-sm select2" id="sales-manager" style="width: 100%;">
              </select>
            </div>
          </div>
          <!-- Filter Button -->
          <div class="col-md-2">
            <div class="form-group">
              <label style="font-size: 12px;">&nbsp;</label>
              <button class="btn bg-navy btn-sm btn-block" onclick="filterByManager()">Filter</button>
            </div>
          </div>
          <!-- Status Counts -->
          <div class="col-md-6">
            <div class="form-group">
              <label style="font-size:12px;">Status Count Per Selected Manager</label>
              <div class="row">
                <!-- Total Leads Generation -->
                <div class="col-md-6 col-sm-6 col-12">
                  <div class="info-box bg-gradient-navy">
                    <span class="info-box-icon"><i class="fa-solid fa-clipboard"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text" style="font-size:12px;">Total Leads Generation</span>
                      <span class="info-box-number" id="leads-generation-count">
                        <!-- This will be populated dynamically -->
                      </span>
                    </div>
                  </div>
                </div>
                <!-- Total Engagement -->
                <div class="col-md-6 col-sm-6 col-12">
                  <div class="info-box xhire-carinfo">
                    <span class="info-box-icon"><i class="fas fa-thumbs-up"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text" style="font-size:12px;">Total Engagement</span>
                      <span class="info-box-number" id="engagement-count">
                        <!-- This will be populated dynamically -->
                      </span>
                    </div>
                  </div>
                </div>
                <!-- Total Proposal -->
                <div class="col-md-6 col-sm-6 col-12">
                  <div class="info-box xhire-cardanger">
                    <span class="info-box-icon"><i class="fa-solid fa-list-check"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text" style="font-size:12px;">Total Proposal</span>
                      <span class="info-box-number" id="proposal-count">
                        <!-- This will be populated dynamically -->
                      </span>
                    </div>
                  </div>
                </div>
                <!-- Total Order -->
                <div class="col-md-6 col-sm-6 col-12">
                  <div class="info-box xhire-carwarning">
                    <span class="info-box-icon"><i class="fa-solid fa-receipt"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text" style="font-size:12px;">Total Order</span>
                      <span class="info-box-number" id="order-count">
                        <!-- This will be populated dynamically -->
                      </span>
                    </div>
                  </div>
                </div>
                <!-- Total Payment -->
                <div class="col-md-6 col-sm-6 col-12">
                  <div class="info-box xhire-carflame">
                    <span class="info-box-icon"><i class="fas fa-wallet"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text" style="font-size:12px;">Total Payment</span>
                      <span class="info-box-number" id="payment-count">
                        <!-- This will be populated dynamically -->
                      </span>
                    </div>
                  </div>
                </div>
                <!-- Total Delivery -->
                <div class="col-md-6 col-sm-6 col-12">
                  <div class="info-box xhire-carsuccess">
                    <span class="info-box-icon"><i class="fa-solid fa-share"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text" style="font-size:12px;">Total Delivery</span>
                      <span class="info-box-number" id="delivery-count">
                        <!-- This will be populated dynamically -->
                      </span>
                    </div>
                  </div>
                </div>
                <!-- Repeat similar structure for other statuses -->
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.col -->
</div>

</div>
</section>

<!-- /.content -->
</div>
<?php include 'footer.php'; ?>
<?php include 'footer_scripts.php'; ?>
</body>
</html>

<script>
     document.addEventListener('DOMContentLoaded', function() {
    // Function to fetch data from fetch_customer_metrics.php
    function fetchDataFromServer(callback) {
        fetch('fetch_records.php')
            .then(response => response.json())
            .then(data => callback(data));
    }

    // Function to create line chart
    function createLineChart(data) {
        var ctx = document.getElementById('customerMetricsChart').getContext('2d');
        var customerMetricsChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.dates,
                datasets: [
                    {
                        label: 'Leads Generation',
                        data: data.leadsGeneration,
                        borderColor: 'rgba(0,31,63)',
                        backgroundColor: 'rgba(0,31,63, 0.2)',
                        fill: false
                    },
                    {
                        label: 'Engagement',
                        data: data.engagement,
                        borderColor: 'rgba(0, 118, 206)',
                        backgroundColor: 'rgba(0, 118, 206, 0.2)',
                        fill: false
                    },
                    {
                        label: 'Proposal',
                        data: data.proposal,
                        borderColor: 'rgba(174, 13, 1)',
                        backgroundColor: 'rgba(174, 13, 1, 0.2)',
                        fill: false
                    },
                    {
                        label: 'Order',
                        data: data.order,
                        borderColor: 'rgba(255, 199, 44)',
                        backgroundColor: 'rgba(255, 199, 44, 0.2)',
                        fill: false
                    },
                    {
                        label: 'Payment',
                        data: data.payment,
                        borderColor: 'rgba(255, 56, 0)',
                        backgroundColor: 'rgba(255, 56, 0, 0.2)',
                        fill: false
                    },
                    {
                        label: 'Delivery',
                        data: data.delivery,
                        borderColor: 'rgba(15, 81, 50)',
                        backgroundColor: 'rgba(15, 81, 50, 0.2)',
                        fill: false
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    },
                    y: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Count'
                        }
                    }
                }
            }
        });
    }

    // Fetch data and create chart on page load
    fetchDataFromServer(createLineChart);
});

document.addEventListener("DOMContentLoaded", function() {
    fetch('data_pie.php')
      .then(response => response.json())
      .then(data => {
        // Gender Pie Chart
        const genderLabels = data.genderData.map(item => item.gender);
        const genderCounts = data.genderData.map(item => item.count);

        // Define colors based on gender
        const genderColorMapping = {
          'Male': 'rgb(0, 118, 206)',  // Color for Male
          'Female': 'rgb(174, 13, 1)'   // Color for Female
        };

        // Assign colors to each segment based on gender
        const genderColors = genderLabels.map(label => genderColorMapping[label]);

        const genderCtx = document.getElementById('genderPieChart').getContext('2d');
        const genderPieChart = new Chart(genderCtx, {
          type: 'pie',
          data: {
            labels: genderLabels,
            datasets: [{
              label: 'Gender Distribution',
              data: genderCounts,
              backgroundColor: genderColors, // Use the colors defined above
              borderColor: genderColors,     // Use the same colors for borders
              borderWidth: 1
            }]
          },
          options: {
            responsive: true,
            plugins: {
              legend: {
                position: 'top',
              },
              tooltip: {
                callbacks: {
                  label: function(context) {
                    let label = context.label || '';
                    if (label) {
                      label += ': ';
                    }
                    label += context.raw;
                    return label;
                  }
                }
              }
            }
          }
        });

        // Customer Type Pie Chart
        const customerTypeLabels = data.customerTypeData.map(item => item.customer_type);
        const customerTypeCounts = data.customerTypeData.map(item => item.count);

        // Define colors based on customer type
        const customerTypeColorMapping = {
          'B2B': 'rgb(0, 31, 63)',           // Color for B2B
          'B2C': 'rgb(0, 118, 206)',         // Color for B2C
          'B2G': 'rgb(174, 13, 1)',          // Color for B2G
          'General Trade': 'rgb(255, 199, 44)', // Color for General Trade
          'Modern Trade': 'rgb(255, 56, 0)'  // Color for Modern Trade
        };

        // Assign colors to each segment based on customer type
        const customerTypeColors = customerTypeLabels.map(label => customerTypeColorMapping[label]);

        const customerTypeCtx = document.getElementById('customerTypePieChart').getContext('2d');
        const customerTypePieChart = new Chart(customerTypeCtx, {
          type: 'pie',
          data: {
            labels: customerTypeLabels,
            datasets: [{
              label: 'Customer Type Distribution',
              data: customerTypeCounts,
              backgroundColor: customerTypeColors, // Use the colors defined above
              borderColor: customerTypeColors,     // Use the same colors for borders
              borderWidth: 1
            }]
          },
          options: {
            responsive: true,
            plugins: {
              legend: {
                position: 'top',
              },
              tooltip: {
                callbacks: {
                  label: function(context) {
                    let label = context.label || '';
                    if (label) {
                      label += ': ';
                    }
                    label += context.raw;
                    return label;
                  }
                }
              }
            }
          }
        });
      })
      .catch(error => console.error('Error:', error));
  });


 // Function to populate select options for sales managers
function populateSalesManagers() {
    $.ajax({
        url: 'fetch_sales_managers.php', // Adjust path as necessary
        type: 'GET',
        success: function(response) {
            var select = document.getElementById("sales-manager");
            response.forEach(function(manager) {
                var optionElem = document.createElement("option");
                optionElem.value = manager.id;
                optionElem.textContent = manager.firstname + ' ' + manager.lastname;
                select.appendChild(optionElem);
            });
        }
    });
}

// Function to populate select options for sales managers
function populateSalesManagers() {
    $.ajax({
        url: 'fetch_sales_managers.php', // Adjust path as necessary
        type: 'GET',
        success: function(response) {
            var select = document.getElementById("sales-manager");
            response.forEach(function(manager) {
                var optionElem = document.createElement("option");
                optionElem.value = manager.manager_id;
                optionElem.textContent = manager.firstname + ' ' + manager.lastname;
                select.appendChild(optionElem);
            });
        }
    });
}

// Function to filter data by selected sales manager
function filterByManager() {
    var salesManagerId = document.getElementById("sales-manager").value;
    $.ajax({
        url: 'fetch_customer_records.php', // Adjust path as necessary
        type: 'POST',
        data: { manager_id: salesManagerId },
        success: function(response) {
            var statusCounts = {
                'Leads Generation': 0,
                'Engagement': 0,
                'Proposal': 0,
                'Order': 0,
                'Payment': 0,
                'Delivery': 0
            };

            // Count status occurrences
            response.forEach(function(order) {
                statusCounts[order.order_status]++;
            });

            // Display counts in info boxes
            document.getElementById("leads-generation-count").textContent = statusCounts['Leads Generation'];
            document.getElementById("engagement-count").textContent = statusCounts['Engagement'];
            document.getElementById("proposal-count").textContent = statusCounts['Proposal'];
            document.getElementById("order-count").textContent = statusCounts['Order'];
            document.getElementById("payment-count").textContent = statusCounts['Payment'];
            document.getElementById("delivery-count").textContent = statusCounts['Delivery'];
        }
    });
}

// Populate sales managers dropdown on page load
$(document).ready(function() {
    populateSalesManagers();
});
    </script>