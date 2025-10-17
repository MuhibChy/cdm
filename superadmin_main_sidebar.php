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
                <img src="<?php echo htmlspecialchars($profile_photo, ENT_QUOTES, 'UTF-8'); ?>" alt="Profile Picture" class="user-image img-circle elevation-2" style="height: 35px; width: 35px;">
            </div>
            <div class="info">
                <a href="superadmin_dashboard.php" class="d-block" style="font-size: 12px;">
                    <?php echo htmlspecialchars($firstname, ENT_QUOTES, 'UTF-8') . ' ' . htmlspecialchars($lastname, ENT_QUOTES, 'UTF-8'); ?>
                    <br>
                    <p style="font-size:10px; font-weight: bold; text-transform: uppercase;">
                        (<?php echo htmlspecialchars($department_assignment, ENT_QUOTES, 'UTF-8'); ?> / <?php echo htmlspecialchars($id_number, ENT_QUOTES, 'UTF-8'); ?>)
                    </p>
                </a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Dashboard -->
                <li class="nav-item menu-open">
                    <a href="superadmin_dashboard.php" class="nav-link active" style="background-color: #14452f;">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p style="font-size:12px;">Dashboard</p>
                    </a>
                </li>

                <!-- Employees -->
                <li class="nav-item menu-close">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-bars"></i>
                        <p style="font-size:12px;">Employees
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="superadmin_sales_manager.php" class="nav-link">
                                <i class="far fa-user nav-icon"></i>
                                <p style="font-size:12px;">Sales Managers</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="superadmin_sales_agent.php" class="nav-link">
                                <i class="far fa-user nav-icon"></i>
                                <p style="font-size:12px;">Sales Agents</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- User Management -->
                <li class="nav-header" style="font-size:12px; text-transform: uppercase;">User Management</li>
                <li class="nav-item">
                    <a href="superadmin_users.php" class="nav-link">
                        <i class="nav-icon far fa-user"></i>
                        <p style="font-size:12px;">Users</p>
                    </a>
                </li>

                <!-- Database -->
                <li class="nav-header" style="font-size:12px; text-transform: uppercase;">Database</li>
                <li class="nav-item menu-close">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-server"></i>
                        <p style="font-size:12px;">Database
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="superadmin_phpmyadmin.php" class="nav-link">
                                <i class="fas fa-database nav-icon" style="color: #ffd43b;"></i>
                                <p style="font-size:12px;">PHPMyadmin</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
