<?php
include 'user_session.php'; // Ensure user session is active

// Secure Database Connection
include 'conn.php';

// Prevent direct access if session is not set
if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

$user_id = $_SESSION['user_id'];

// Function to check and update order status
function checkAndUpdateOrderStatus($conn, $orderId, $currentStatus, $statusUpdatedAt) {
    $interval = 24 * 60 * 60; // 24 hours in seconds
    $currentTime = new DateTime();
    $statusUpdatedTime = new DateTime($statusUpdatedAt);
    $elapsedTime = $currentTime->getTimestamp() - $statusUpdatedTime->getTimestamp();

    if ($currentStatus === 'Cancelled' && $elapsedTime > $interval) {
        $stmt = $conn->prepare("UPDATE customer_orders SET order_status = 'Closed' WHERE order_id = ?");
        $stmt->bind_param('i', $orderId);
        $stmt->execute();
        $stmt->close();
    }
}

// Query to fetch customer orders with customer details
$sql = "SELECT co.order_id, co.customer_id, co.order_date, co.customer_category, co.customer_type, co.order_status, 
                co.reference_number, co.latest_engagement_date, co.date_qtn_sent, co.quotation_reference_number, 
                co.proposal_remarks, co.remarks, co.uploaded_file, co.sales_order_reference_number, co.payment_remarks, 
                co.payment_reference_number, co.order_remarks, co.date_of_sales_order_creation, co.warehouse_email, 
                co.delivery_reference_number, co.date_closed, co.status_updated_at, 
                c.company_name, c.firstname, c.middle_initial, c.lastname, c.contact_number, c.email_address, c.gender, 
                c.city_address, sm.firstname AS manager_firstname, sm.lastname AS manager_lastname, 
                sa.firstname AS agent_firstname, sa.lastname AS agent_lastname
        FROM customer_orders co
        INNER JOIN customers c ON co.customer_id = c.customer_id
        LEFT JOIN sales_managers sm ON co.manager_id = sm.manager_id
        LEFT JOIN sales_agents sa ON co.agent_id = sa.agent_id
        WHERE co.order_status = 'Cancelled' AND co.user_id = ?";

// Prepare and execute the statement
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CDMS | Cancelled Transactions</title>

  <!-- Favicon -->
  <link rel="icon" href="dist/img/logo.png" type="image/x-icon">
  <link rel="shortcut icon" href="dist/img/xchire-logo.png" type="image/x-icon">

  <?php include 'header_scripts.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <!-- Navbar -->
  <?php include 'user_navbarsection.php'; ?>
  <?php include 'user_profile_modal.php'; ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include 'user_main_sidebar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <?php include 'user_alert.php'; ?>

    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            
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
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- /.col-md-6 -->
          <div class="col-lg-12">
            <div class="card xhire-redline">
              <div class="card-header">
                <h5 class="m-0" style="font-size:12px; font-weight: bold;">Client Status: Cancelled</h5>
              </div>
              <div class="card-body">

                <table id="customerOrdersTable" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Reference Number</th>
                      <th>Order Date</th>
                      <th>Company Name</th>
                      <th>Client Name</th>
                      <th>Client Type</th>
                      <th>Status</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // Check and update order status if necessary
                            checkAndUpdateOrderStatus($conn, $row['order_id'], $row['order_status'], $row['status_updated_at']);
                            
                            // Format order date
                            $formatted_order_date = date('Y-m-d h:i A', strtotime($row['order_date']));

                            // Fetch updated order status
                            $updatedOrderStatus = $row['order_status'] === 'Cancelled' ? 'Cancelled' : 'Closed';

                            if ($updatedOrderStatus === 'Cancelled') {
                                echo "<tr>";
                                echo "<td style='text-transform: uppercase;'>".$row['reference_number']."</td>";
                                echo "<td>".$formatted_order_date."</td>";
                                echo "<td style='text-transform: capitalize;'>".$row['company_name']."</td>";
                                echo "<td style='text-transform: capitalize;'>".$row['firstname']." ".$row['lastname']."</td>";
                                echo "<td>".$row['customer_type']."</td>";
                                echo "<td><span class='badge xhire-bdred'>".$updatedOrderStatus."</span></td>";
                                echo "<td>";
                                echo "<div class='btn-group'>
                                        <button type='button' class='btn btn-default btn-sm' onclick='viewCustomerOrderDetails(".$row['order_id'].")' style='font-size:12px;'>View Details</button>
                                        <button type='button' class='btn xhire-warning btn-sm' onclick='recoverOrder(".$row['order_id'].")' style='font-size:12px;'>
                                            <i class='fa-solid fa-arrows-spin'></i> Recover
                                  </button>
                                  </div>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        }
                    } else {
                        echo "<tr><td colspan='7'>No customer orders found</td></tr>";
                    }
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
  <?php include 'footer_scripts.php'; ?>
  <?php include 'user_closed_modal.php'; ?>
  <?php include 'scripts/user_cancelled_transaction_scripts.php';?>
</body>
</html>
