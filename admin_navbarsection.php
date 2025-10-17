<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link" style="font-size:12px;">
                Welcome to Your Dashboard 
                <span style="text-transform: uppercase; font-weight: bold; color: red;"><?php echo htmlspecialchars($nickname); ?></span>!
            </a>
        </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Notification Dropdown -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge xhire-redning navbar-badge" id="notification-count">0</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" id="notification-list">
                <span class="dropdown-item dropdown-header" id="notification-header">0 Notifications</span>
                <div class="dropdown-divider"></div>
                <!-- Notifications will be dynamically populated here -->
                <!-- "See All Notifications" link always visible -->
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item text-center" data-toggle="modal" data-target="#seeAllNotificationsModal" style="font-size: 12px;">
                    See All Notifications
                </a>
            </div>
        </li>

        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <img src="<?php echo htmlspecialchars($profile_photo, ENT_QUOTES, 'UTF-8'); ?>" alt="Profile Picture" class="user-image img-circle elevation-2">  
                <span class="d-none d-md-inline dropdown-toggle dropdown-icon"></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <li class="user-footer" style="font-size:12px;">
                    <a class="dropdown-item" data-toggle="modal" data-target="#leadsprofile">Update Profile</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" class="logout" onclick="confirmLogout(); return false;">Sign Out</a>
                </li>
            </ul>
        </li>
    </ul>
</nav>

<!-- Notification Modal -->
<div class="modal fade" id="notificationModal" tabindex="-1" role="dialog" aria-labelledby="notificationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="notificationModalLabel" style="font-size:12px;">Notification Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="notificationModalBody" style="font-size:12px;">
                <!-- Notification details will be dynamically inserted here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" style="font-size:12px;">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- See All Notifications Modal -->
<div class="modal fade" id="seeAllNotificationsModal" tabindex="-1" role="dialog" aria-labelledby="seeAllNotificationsLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="seeAllNotificationsLabel" style="font-size: 12px;">See All Notifications</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="see-all-notifications-content">
                <!-- All notifications will be dynamically inserted here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark btn-sm" data-dismiss="modal" style="font-size:12px;">Close</button>
            </div>
        </div>
    </div>
</div>

<style>
/* Style for notification list */
#notification-list {
    max-height: 300px; /* Adjust based on your needs */
    overflow-y: auto;
}

/* Style for individual notifications */
#notification-list .dropdown-item {
    padding: 10px 15px;
    font-size: 12px;
    position: relative;
}

/* Style for notification timestamp */
#notification-list .dropdown-item .notification-timestamp {
    font-size: 10px;
    color: gray;
    display: block;
}

/* Style for the three-dot menu */
.notification-menu {
    position: absolute;
    right: 10px;
    top: 10px;
    font-size: 12px;
    cursor: pointer;
}

.modal-body {
    max-height: 400px; /* Set a maximum height */
    overflow-y: auto;  /* Enable vertical scrolling */
}
</style>

<script>
$(document).ready(function() {
    // Load notifications on page load
    loadNotifications();

    // Refresh notifications periodically
    setInterval(loadNotifications, 60000); // Every 60 seconds

    // Handle click event on notification items
    $('#notification-list').on('click', '.dropdown-item', function(event) {
        event.preventDefault();
        var notificationId = $(this).data('id');
        $('#notificationModal').data('id', notificationId); // Store ID for use in modal
        loadNotificationDetails(notificationId);
    });

    // Handle click event on "Remove" option in the dropdown
    $('#notification-list').on('click', '.remove-notification', function(event) {
        event.preventDefault();
        var notificationId = $(this).data('id');
        removeNotification(notificationId);
    });

    // Handle click event on "Remove" option inside the modal
    $('#see-all-notifications-content').on('click', '.remove-notification', function(event) {
        event.preventDefault();
        var notificationId = $(this).data('id');
        removeNotification(notificationId);
    });

    // Function to load notifications
    function loadNotifications() {
        $.ajax({
            url: 'admin_fetch_notifications.php', // PHP file to fetch notifications
            method: 'GET',
            success: function(response) {
                const data = JSON.parse(response);
                $('#notification-list').empty(); // Clear existing notifications
                $('#notification-header').text(data.count + ' Notifications');
                $('#notification-count').text(data.count);

                if (data.count > 0) {
                    data.notifications.forEach(notification => {
                        var truncatedMessage = notification.message.length > 25 
                            ? notification.message.substring(0, 25) + '...' 
                            : notification.message;

                        $('#notification-list').append(`
                            <a href="#" class="dropdown-item" data-id="${notification.id}" data-toggle="modal" data-target="#notificationModal">
                                <i class="fas fa-bell mr-2"></i> ${truncatedMessage}
                                <span class="float-right" style='font-size:9px;'>${notification.created_at}</span>
                            </a>
                            <div class="dropdown-divider"></div>
                        `);
                    });
                } else {
                    $('#notification-list').append(`
                        <a href="#" class="dropdown-item" style='text-align:center;'>
                            <i class="fas fa-bell mr-2"></i> No new notifications
                        </a>
                    `);
                }

                // Ensure "See All Notifications" link is always visible
                $('#notification-list').append(`
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item text-center" data-toggle="modal" data-target="#seeAllNotificationsModal">
                        See All Notifications
                    </a>
                `);
            }
        });
    }

    // Function to load notification details and show modal
    function loadNotificationDetails(notificationId) {
        $.ajax({
            url: 'admin_fetch_notification_details.php', // PHP file to fetch notification details
            method: 'POST',
            data: { id: notificationId },
            success: function(response) {
                let notification = JSON.parse(response);
                $('#notificationModalLabel').text(notification.title);
                $('#notificationModalBody').html(notification.content);

                // Mark notification as read and refresh lists
                $.ajax({
                    url: 'admin_mark_notification_read.php', // PHP file to mark notification as read
                    method: 'POST',
                    data: { id: notificationId },
                    success: function() {
                        loadNotifications(); // Refresh notification list
                    }
                });
            }
        });
    }

    // Function to remove notification
    function removeNotification(notificationId) {
        $.ajax({
            url: 'admin_remove_notifications.php', // PHP file to remove notification
            method: 'POST',
            data: { id: notificationId },
            success: function() {
                loadNotifications(); // Refresh notification list
                loadAllNotifications(); // Refresh "See All Notifications" modal
            }
        });
    }

    // Function to load all notifications
    function loadAllNotifications() {
        $.ajax({
            url: 'admin_fetch_all_notifications.php', // PHP file to fetch all notifications
            method: 'GET',
            success: function(response) {
                const data = JSON.parse(response);
                $('#see-all-notifications-content').empty(); // Clear existing notifications

                if (data.notifications.length > 0) {
                    data.notifications.forEach(notification => {
                        $('#see-all-notifications-content').append(`
                            <div class="notification-item">
                                <p style='font-size:12px;'>${notification.content}</p>
                                <small style='font-size:10px;'>${notification.created_at}</small>
                                <hr>
                                <div class="notification-menu">
                                    <a href="#" class="remove-notification" data-id="${notification.id}">
                                        <i class="fas fa-trash-alt"></i> Remove
                                    </a>
                                </div>
                            </div>
                        `);
                    });
                } else {
                    $('#see-all-notifications-content').append('<p>No notifications available.</p>');
                }
            }
        });
    }

    // Load all notifications when "See All Notifications" modal is opened
    $('#seeAllNotificationsModal').on('show.bs.modal', function() {
        loadAllNotifications();
    });
});
</script>
