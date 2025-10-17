<aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="dist/img/xchire-logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light" style="font-size:12px;">Client Database Management</span>
    </a>

    <!-- Sidebar -->
<div class="sidebar">
  <!-- Sidebar user panel (optional) -->
  <div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
      <img src="<?php echo $profile_photo; ?>" alt="Profile Picture" class="img-circle elevation-2" style="height: 35px; width: 35px;">
    </div>
    <div class="info">
      <a href="user_dashboard.php?user_id=<?php echo $user_id; ?>" class="d-block" style="font-size: 12px;">
        <?php echo $firstname . ' ' . $lastname; ?>
        <br>
        <p style="font-size:10px; font-weight: bold; text-transform: uppercase;">(<?php echo $department_assignment; ?> / <?php echo $id_number; ?>)</p>
      </a>
    </div>
  </div>
  <!-- Sidebar Menu -->
  <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
      <li class="nav-item menu-open">
        <a href="user_dashboard.php?user_id=<?php echo $user_id; ?>" class="nav-link active" style="background-color: #0f5132;">
          <i class="nav-icon fas fa-tachometer-alt"></i>
          <p style="font-size:12px;">Dashboard</p>
        </a>
      </li>
      <li class="nav-item menu-close">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-bars"></i>
          <p style="font-size:12px;">Menu
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="user_leads.php?user_id=<?php echo $user_id; ?>" class="nav-link active">
              <i class="fas fa-user nav-icon"></i>
              <p style="font-size:12px;">Leads Generation</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="user_engagement.php?user_id=<?php echo $user_id; ?>" class="nav-link active">
              <i class="fas fa-thumbs-up nav-icon"></i>
              <p style="font-size:12px;">Engagement</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="user_proposal.php?user_id=<?php echo $user_id; ?>" class="nav-link active">
              <i class="fas fa-circle-check nav-icon"></i>
              <p style="font-size:12px;">Proposal</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="user_order.php?user_id=<?php echo $user_id; ?>" class="nav-link active">
              <i class="fas fa-cart-shopping nav-icon"></i>
              <p style="font-size:12px;">Order</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="user_payment.php?user_id=<?php echo $user_id; ?>" class="nav-link active">
              <i class="fas fa-wallet nav-icon"></i>
              <p style="font-size:12px;">Payment</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="user_delivery.php?user_id=<?php echo $user_id; ?>" class="nav-link active">
              <i class="fas fa-truck nav-icon"></i>
              <p style="font-size:12px;">Delivery</p>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item menu-close">
        <a href="user_cancelled_transactions.php?user_id=<?php echo $user_id; ?>" class="nav-link">
          <i class="nav-icon fas fa-circle-xmark"></i>
          <p style="font-size:12px;">Cancelled Transactions</p>
        </a>
      </li>
      <li class="nav-item menu-close">
        <a href="user_closed_transactions.php?user_id=<?php echo $user_id; ?>" class="nav-link">
          <i class="nav-icon fas fa-circle-check"></i>
          <p style="font-size:12px;">Closed Transactions</p>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->

<!-- /.sidebar -->
</aside>