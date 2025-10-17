<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button" aria-label="Toggle navigation menu">
                <i class="fas fa-bars"></i>
            </a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="superadmin_dashboard.php" class="nav-link" style="font-size:12px;">
                Welcome Webmaster <?php echo htmlspecialchars($nickname, ENT_QUOTES, 'UTF-8'); ?>!
            </a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <img src="<?php echo htmlspecialchars($profile_photo, ENT_QUOTES, 'UTF-8'); ?>" alt="Profile Picture" class="user-image img-circle elevation-2" style="height: 35px; width: 35px;">
                <span class="d-none d-md-inline dropdown-toggle dropdown-icon"></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <li class="user-footer" style="font-size:12px;">
                    <a class="dropdown-item" data-toggle="modal" data-target="#updateProfileModal" href="#" aria-label="Update Profile">
                        Update Profile
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" onclick="confirmLogout(); return false;" aria-label="Sign Out">
                        Sign Out
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>

<script>
function confirmLogout() {
    if (confirm('Are you sure you want to sign out?')) {
        window.location.href = 'logout.php'; // Replace with your logout URL
    }
}
</script>
