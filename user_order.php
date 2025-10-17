<?php include 'user_session.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head> 
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CDMS | Order</title>
  <?php include 'header_scripts.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 
  <link rel="shortcut icon" href="dist/img/xchire-logo.png" type="image/x-icon">
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
              <h1 class="m-0"></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item" style="font-size:12px;"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" style="font-size:12px;">Dashboard</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div><!-- /.content-header -->

      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- /.col-md-6 -->
            <div class="col-lg-12">
              <div class="card xhire-outline">
                <div class="card-header">
                  <h3 class="card-title d-flex" style="font-size:12px; font-weight: bold; color: black; align-items: center;"><span class="badge" style="width:10px; height: 10px; display: inline-block; border-radius: 100%; background-color: #0f5132;"></span>&nbsp; Client Status: Order</h3>
                  <br>
                  <div class="d-flex align-items-center">
                    <label for="orderDate" class="mr-2" style="font-size:12px;">Filter by Date of Sales Creation:</label>
                    <input type="date" class="form-control form-control-sm col-md-3 mr-2" id="orderDate" name="orderDate">
                  </div>
                </div>
                <div class="card-body">
                  <table id="customerOrdersTable" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Reference Number</th>
                        <th>Date of Sales Order</th>
                        <th>Company Name</th>
                        <th>Client Name</th>
                        <th>Client Type</th>
                        <th>Status</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      include 'conn.php'; // Ensure your database connection script is included

                      // Check if the user_id is set in the session
                      if (!isset($_SESSION['user_id'])) {
                          die("User not logged in.");
                      }

                      $user_id = $_SESSION['user_id'];

                      // Initialize default date and filter condition
                      $selectedDate = date('Y-m-d'); // Default to today's date
                      $filterCondition = "WHERE DATE(co.date_of_sales_order_creation) = CURDATE()"; // Default filter for today's orders
                      $params = [$user_id];
                      $types = 'i'; // Default type for user_id

                      // Sanitize and validate orderDate from POST request
                      if (isset($_POST['orderDate']) && !empty($_POST['orderDate'])) {
                          $selectedDate = htmlspecialchars($_POST['orderDate'], ENT_QUOTES, 'UTF-8');

                          // Validate that $selectedDate is one of the accepted values or a valid date format
                          if ($selectedDate === 'today') {
                              $filterCondition = "WHERE DATE(co.date_of_sales_order_creation) = CURDATE()";
                          } elseif ($selectedDate === 'yesterday') {
                              $filterCondition = "WHERE DATE(co.date_of_sales_order_creation) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)";
                          } else {
                              // Assuming $selectedDate is a valid date format
                              $selectedDate = date('Y-m-d', strtotime($selectedDate)); // Ensure it's a valid date
                              $filterCondition = "WHERE DATE(co.date_of_sales_order_creation) = ?";
                              $params[] = $selectedDate;
                              $types .= 's'; // Add 's' for the string date parameter
                          }
                      }

                      // Query to fetch customer orders with customer details based on selected date
                      $sql = "SELECT co.order_id, co.customer_id, co.order_date, co.customer_category, co.customer_type, co.order_status, co.reference_number, co.latest_engagement_date, co.date_qtn_sent, co.quotation_reference_number, co.proposal_remarks, co.remarks, co.uploaded_file, co.sales_order_reference_number, co.payment_date, co.payment_remarks, co.payment_reference_number, co.order_remarks, co.date_of_sales_order_creation, co.warehouse_email, c.company_name, c.firstname, c.middle_initial, c.lastname, c.contact_number, c.email_address, c.gender, c.city_address, sm.firstname AS manager_firstname, sm.lastname AS manager_lastname, sa.firstname AS agent_firstname, sa.lastname AS agent_lastname
                              FROM customer_orders co
                              INNER JOIN customers c ON co.customer_id = c.customer_id
                              LEFT JOIN sales_managers sm ON co.manager_id = sm.manager_id
                              LEFT JOIN sales_agents sa ON co.agent_id = sa.agent_id
                              $filterCondition AND co.order_status = 'Order' AND co.user_id = ?";

                      // Prepare the SQL statement
                      $stmt = $conn->prepare($sql);

                      // Bind parameters
                      if ($params) {
                          // Create a dynamically prepared parameter array
                          $bindParams = array_merge([$types], $params);
                          $stmt->bind_param(...$bindParams);
                      } else {
                          // If there are no additional parameters
                          $stmt->bind_param($types, $user_id);
                      }

                      if ($stmt->execute()) {
                          $result = $stmt->get_result();

                          if ($result->num_rows > 0) {
                              while ($row = $result->fetch_assoc()) {
                                  // Escape output
                                  $reference_number = htmlspecialchars($row['reference_number'], ENT_QUOTES, 'UTF-8');
                                  $company_name = htmlspecialchars($row['company_name'], ENT_QUOTES, 'UTF-8');
                                  $customer_name = htmlspecialchars($row['firstname'] . ' ' . $row['lastname'], ENT_QUOTES, 'UTF-8');
                                  $order_status = htmlspecialchars($row['order_status'], ENT_QUOTES, 'UTF-8');
                                  $date_of_sales_order_creation = !empty($row['date_of_sales_order_creation']) ? date('Y-m-d h:i A', strtotime($row['date_of_sales_order_creation'])) : '';

                                  echo "<tr>";
                                  echo "<td style='text-transform: uppercase;'>$reference_number</td>";
                                  echo "<td>$date_of_sales_order_creation</td>"; // Display formatted date and time
                                  echo "<td>$company_name</td>";
                                  echo "<td style='text-transform: capitalize;'>$customer_name</td>";
                                  echo "<td>{$row['customer_type']}</td>";
                                  echo "<td><span class='badge xhire-bdyellow'>$order_status</span></td>";
                                  echo "<td>";
                                  echo "<div class='btn-group'>";
                                  echo "<button type='button' class='btn-xs btn btn-primary' onclick='viewCustomerOrderDetails({$row['order_id']})'>View Details</button>";
                                  echo "<button type='button' class='btn-xs btn btn-default dropdown-toggle dropdown-icon' data-toggle='dropdown'>";
                                  echo "<span class='sr-only'>Toggle Dropdown</span>";
                                  echo "</button>";
                                  echo "<div class='dropdown-menu' role='menu'>";
                                  echo "<a class='dropdown-item' href='#' onclick='fillUpdateCustomerOrder({$row['order_id']}, \"" . htmlspecialchars($row['payment_reference_number'], ENT_QUOTES, 'UTF-8') . "\", \"" . htmlspecialchars($row['sales_order_reference_number'], ENT_QUOTES, 'UTF-8') . "\", \"" . htmlspecialchars($row['payment_remarks'], ENT_QUOTES, 'UTF-8') . "\", \"" . htmlspecialchars($row['warehouse_email'], ENT_QUOTES, 'UTF-8') . "\", \"" . htmlspecialchars($row['order_status'], ENT_QUOTES, 'UTF-8') . "\")' data-toggle='modal' data-target='#updateCustomerOrderModal' style='font-size:12px;'>Update Records</a>";
                                  echo "</div>";
                                  echo "</div>";
                                  echo "</td>";
                                  echo "</tr>";
                              }
                          } else {
                              echo "<tr><td colspan='7'>No customer orders found</td></tr>";
                          }
                      } else {
                          // Debugging statement if execution fails
                          echo "Error executing query: " . $stmt->error;
                      }

                      $stmt->close();
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
      </div><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <?php include 'footer.php'; ?>
    <?php include 'footer_scripts.php'; ?>
    <?php include 'user_payment_customer_modal.php'; ?>
    <?php include 'scripts/user_order_scripts.php'; ?>
  </div><!-- /.wrapper -->
</body>
</html>
