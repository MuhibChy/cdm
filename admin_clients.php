<?php include 'admin_session.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CDMS | List of Client Transactions</title>
  <?php include 'header_scripts.php'; ?>
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

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card xhire-outline">
              <div class="card-header">
                <h3 class="card-title d-flex" style="font-size:12px; font-weight: bold; color: black; align-items: center;">
                  <span class="badge" style="width:10px; height: 10px; display: inline-block; border-radius: 100%; background-color: #0f5132;"></span>&nbsp; List of Client Transactions
                </h3>
              </div>
              <div class="card-body">
                <table id="customerOrdersTable" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Order ID | Reference Number</th>
                      <th>Client Name</th>
                      <th>Company Name</th>
                      <th>Sales Agent Name</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php

                    // Function to return animation class based on status
                    function getStatusAnimationClass($status) {
                        $status = strtolower($status);
                        $classes = [
                            'leads generation' => 'animation-navy',
                            'engagement' => 'animation-olive',
                            'proposal' => 'animation-danger',
                            'order' => 'animation-warning',
                            'payment' => 'animation-orange',
                            'delivery' => 'animation-success',
                            'closed' => 'animation-dark',
                            'cancelled' => 'animation-dark-red',
                        ];
                        return $classes[$status] ?? 'animation-secondary';
                    }

                    // SQL query to fetch data
                    $sql = "SELECT 
                                CONCAT(c.firstname, ' ', c.lastname) AS customer_name,
                                c.company_name,
                                co.order_id,
                                co.reference_number,
                                co.order_status AS status,
                                sa.firstname AS agent_firstname,
                                sa.lastname AS agent_lastname
                            FROM customers c
                            INNER JOIN customer_orders co ON c.customer_id = co.customer_id
                            LEFT JOIN sales_agents sa ON co.agent_id = sa.agent_id";

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $animationClass = getStatusAnimationClass($row["status"]);

                            echo "<tr>";
                            echo "<td style='text-transform: uppercase;'>".$row["order_id"]." | ".$row["reference_number"]."</td>";
                            echo "<td style='text-transform: capitalize;'>".$row["customer_name"]."</td>";
                            echo "<td>".$row["company_name"]."</td>";
                            echo "<td style='text-transform: capitalize;'>".$row["agent_firstname"]." ".$row["agent_lastname"]."</td>";
                            echo "<td class='$animationClass' style='color: white;'>".$row["status"]."</td>";
                            echo "<td>
                                    <div class='btn-group'>
                                      <button type='button' class='btn-xs btn btn-primary' onclick='viewCustomerOrderDetails(".$row['order_id'].")'>View Details</button>
                                    </div>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No records found</td></tr>";
                    }

                    $conn->close();
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include 'footer.php'; ?>
</div>

<?php include 'footer_scripts.php'; ?>
<?php include 'user_closed_modal.php'; ?>
<?php include 'admin_client_scripts.php'; ?>
</body>
</html>
