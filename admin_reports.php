<?php include 'admin_session.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CDMS | Reports</title>
  <?php include 'header_scripts.php'; ?>
  <!-- DataTables CSS -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
  <!-- DataTables Buttons CSS -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
  <link rel="shortcut icon" href="dist/img/xchire-logo.png" type="image/x-icon">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <?php include 'admin_navbarsection.php'; ?>
  <?php include 'admin_profile_modal.php'; ?>
  <?php include 'admin_main_sidebar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <?php include 'admin_alert.php'; ?>

    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6"></div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#" style="font-size:12px;">Home</a></li>
              <li class="breadcrumb-item active" style="font-size:12px;">Customers</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card xhire-outline">
              <div class="card-header">
                <h5 class="m-0" style="font-size:12px; font-weight: bold;">Reports</h5>
              </div>
              <div class="card-body">
                <!-- Date Range Filter -->
                <label style="font-size: 12px;">Date range:</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="far fa-calendar-alt"></i>
                    </span>
                  </div>
                  <input type="text" class="form-control form-control-sm float-right col-sm-4" id="reservation">
                </div>
                <br>

                <!-- Export Buttons -->
                <button id="exportB2B" class="btn xhire-astros btn-sm" style="font-size:12px;"><i class="fa-solid fa-file-excel"></i> Export B2B to Excel</button>
                <button id="exportB2C" class="btn xhire-success btn-sm" style="font-size:12px;"><i class="fa-solid fa-file-excel"></i> Export B2C to Excel</button>
                <button id="exportB2G" class="btn xhire-info btn-sm" style="font-size:12px;"><i class="fa-solid fa-file-excel"></i> Export B2G to Excel</button>
                <button id="exportMasterList" class="btn xhire-orange btn-sm" style="font-size:12px;"><i class="fa-solid fa-table-list"></i> Export Master List to Excel</button>

                <table id="customerOrdersTable" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Client Name</th>
                      <th>Company Name</th>
                      <th>Customer Type</th>
                      <th>Order Status</th>
                      <th>Agent Name</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    // Database credentials
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $database = "cdms";

                    // Create connection
                    $conn = new mysqli($servername, $username, $password, $database);

                    // Check connection
                    if ($conn->connect_error) {
                      die("Connection failed: " . $conn->connect_error);
                    }

                    // Retrieve date range from POST request
                    $startDate = isset($_POST['start_date']) ? $_POST['start_date'] : '';
                    $endDate = isset($_POST['end_date']) ? $_POST['end_date'] : '';

                    // SQL query to fetch data with date range filter
                    $sql = "SELECT 
                              CONCAT(c.firstname, ' ', c.lastname) AS customer_name,
                              c.company_name,
                              co.customer_type,
                              co.order_status AS status,
                              CONCAT(sa.firstname, ' ', sa.lastname) AS agent_name
                            FROM customers c
                            INNER JOIN customer_orders co ON c.customer_id = co.customer_id
                            LEFT JOIN sales_agents sa ON co.agent_id = sa.agent_id
                            WHERE co.order_status = 'Closed'";

                    if ($startDate && $endDate) {
                      $sql .= " AND co.status_updated_at BETWEEN ? AND ?";
                    }

                    $stmt = $conn->prepare($sql);
                    if ($startDate && $endDate) {
                      $stmt->bind_param("ss", $startDate, $endDate);
                    }
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                      while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td style='text-transform: capitalize;'>" . htmlspecialchars($row["customer_name"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["company_name"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["customer_type"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["status"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["agent_name"]) . "</td>";
                        echo "</tr>";
                      }
                    } else {
                      echo "<tr><td colspan='5'>No records found</td></tr>";
                    }

                    // Close connection
                    $conn->close();
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php include 'footer.php'; ?>
</div>
<?php include 'footer_scripts.php'; ?>
<?php include 'admin_customer_modal.php'; ?>
<?php include 'scripts/admin_report_scripts.php'; ?>
</body>
</html>