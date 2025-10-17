<!-- superadmin_dashboard.php -->
<?php include 'session.php'; ?>
<?php
// Include your database connection file
include 'conn.php';

// Query to get the counts
$totalManagersQuery = "SELECT COUNT(*) as totalManagers FROM sales_managers";
$totalAgentsQuery = "SELECT COUNT(*) as totalAgents FROM sales_agents";
$totalUsersQuery = "SELECT COUNT(*) as totalUsers FROM users WHERE role != 'superadmin'";
$databaseSizeQuery = "SELECT ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) AS size_mb FROM information_schema.tables WHERE table_schema = DATABASE()";

// Execute the queries and get the counts
$totalManagersResult = mysqli_query($conn, $totalManagersQuery);
$totalAgentsResult = mysqli_query($conn, $totalAgentsQuery);
$totalUsersResult = mysqli_query($conn, $totalUsersQuery);
$databaseSizeResult = mysqli_query($conn, $databaseSizeQuery);

$totalManagers = mysqli_fetch_assoc($totalManagersResult)['totalManagers'];
$totalAgents = mysqli_fetch_assoc($totalAgentsResult)['totalAgents'];
$totalUsers = mysqli_fetch_assoc($totalUsersResult)['totalUsers'];
$databaseSize = mysqli_fetch_assoc($databaseSizeResult)['size_mb'];

// Close the database connection
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head> 
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CDMS | Dashboard</title>
  <?php include 'header_scripts.php'; ?> 
  <link rel="shortcut icon" href="dist/img/xchire-logo.png" type="image/x-icon">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
<!-- Navbar -->
<?php include 'superadmin_navbar_section.php'; ?>  
<?php include 'superadmin_profile_modal.php'; ?>
<!-- /.navbar -->
<!-- Main Sidebar Container -->
<?php include 'superadmin_main_sidebar.php'; ?>  

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
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
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box xhire-info">
                    <div class="inner">
                        <h3><?php echo $totalManagers; ?></h3>
                        <p style="font-size: 12px;">Total of Managers</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-people-roof"></i>
                    </div>
                    <a href="superadmin_sales_manager.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box xhire-success">
                    <div class="inner">
                        <h3><?php echo $totalAgents; ?></h3>
                        <p style="font-size: 12px;">Total Of Agents</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-people-group"></i>
                    </div>
                    <a href="superadmin_sales_agent.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box xhire-warning">
                    <div class="inner">
                        <h3><?php echo $totalUsers; ?></h3>
                        <p style="font-size: 12px;">Total of Users</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-person"></i>
                    </div>
                    <a href="superadmin_users.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box xhire-danger">
                    <div class="inner">
                        <h3><?php echo $databaseSize; ?> MB</h3>
                        <p style="font-size: 12px;">Size of Database</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-database"></i>
                    </div>
                    <a href="superadmin_phpmyadmin.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
</section>

<!-- /.content -->
</div>
<?php include 'footer.php'; ?>
<?php include 'footer_scripts.php'; ?>
</body>
</html>