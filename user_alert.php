<script>
$(document).ready(function() {
    // Flag to check if alerts have already been shown
    let alertsShown = {
        proposal: false,
        order: false,
        payment: false
    };

    // Function to check order status
    function checkOrderStatus() {
        $.ajax({
            url: 'user_check_order_status.php',
            method: 'GET',
            success: function(response) {
                const data = JSON.parse(response);

                // Show or hide alerts based on the response
                if (data.alerts.proposal) {
                    showAlert('proposal', data.orders.proposal[0]);
                } else {
                    $('#alert-container-proposal').empty();
                    alertsShown.proposal = false;
                }
                if (data.alerts.order) {
                    showAlert('order', data.orders.order[0]);
                } else {
                    $('#alert-container-order').empty();
                    alertsShown.order = false;
                }
                if (data.alerts.payment) {
                    showAlert('payment', data.orders.payment[0]);
                } else {
                    $('#alert-container-payment').empty();
                    alertsShown.payment = false;
                }
            }
        });
    }

    // Function to show the alert with slide animation
    function showAlert(type, order) {
        if (alertsShown[type]) return; // Prevent showing alert again if already shown

        let alertClass = '';
        let alertIcon = '';
        let message = '';

        switch (type) {
            case 'proposal':
                alertClass = 'alert-danger'; // Red color for proposal alerts
                alertIcon = 'info-circle';
                message = `You sent the customer a proposal 5 days ago. Order ID: ${order.order_id} - Transaction Time: ${order.transaction_time}. Kindly inquire about the progress of your quote.`;
                break;
            case 'order':
                alertClass = 'alert-warning'; // Yellow color for order alerts
                alertIcon = 'info-circle';
                message = `You prepared a sales order 7 days ago. Order ID: ${order.order_id} - Transaction Time: ${order.transaction_time}. Please remind the customer that the order cannot be processed until payment has been received.`;
                break;
            case 'payment':
                alertClass = 'alert-info'; // Blue color for payment alerts
                alertIcon = 'info-circle';
                message = `Payment was processed 3 days ago. Order ID: ${order.order_id} - Transaction Time: ${order.transaction_time}. Please verify if the item has been delivered.`;
                break;
        }

        let alertHtml = `
            <div class="card-body">
                <div class="alert ${alertClass} alert-dismissible slide-left">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-${alertIcon}"></i> Alert!</h5>
                    <p style="font-size: 12px;">${message}</p>
                </div>
            </div>`;

        let containerId = '';
        if (type === 'proposal') {
            containerId = '#alert-container-proposal';
        } else if (type === 'order') {
            containerId = '#alert-container-order';
        } else if (type === 'payment') {
            containerId = '#alert-container-payment';
        }

        $(containerId).html(alertHtml);
        
        // Set the flag to true to prevent showing the same alert again
        alertsShown[type] = true;
    }

    // Check the order status at different intervals for different alerts
    setInterval(checkOrderStatus, 86400000); // 1 day (24 hours) interval to check for proposal
    setInterval(checkOrderStatus, 604800000); // 7 days (1 week) interval to check for order
    setInterval(checkOrderStatus, 259200000); // 3 days interval to check for payment
});
</script>
