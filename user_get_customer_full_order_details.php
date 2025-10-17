<?php
// Include your connection file (conn.php or any connection setup)
include 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];

    // Query to fetch customer order details including customer, sales manager, and sales agent
    $sql = "SELECT co.order_id, co.order_date, co.customer_category, co.customer_type, co.order_status, co.reference_number,
                   co.latest_engagement_date, co.remarks, co.uploaded_file, co.quotation_reference_number, co.proposal_remarks,
                   co.date_qtn_sent, co.sales_order_reference_number, co.order_remarks, co.date_of_sales_order_creation, co.warehouse_email,
                   co.payment_reference_number, co.payment_remarks, co.delivery_reference_number, co.delivery_date, co.delivery_remarks,
                   co.uploaded_file_cancelled, co.date_closed,
                   c.firstname, c.middle_initial, c.lastname, c.contact_number, c.email_address, c.gender, c.city_address,
                   sm.firstname AS manager_firstname, sm.lastname AS manager_lastname,
                   sa.firstname AS agent_firstname, sa.lastname AS agent_lastname,
                   co.uploaded_file
            FROM customer_orders co
            INNER JOIN customers c ON co.customer_id = c.customer_id
            LEFT JOIN sales_managers sm ON co.manager_id = sm.manager_id
            LEFT JOIN sales_agents sa ON co.agent_id = sa.agent_id
            WHERE co.order_id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Function to format date and time with AM/PM
        function formatDateTime($datetime) {
            if (!empty($datetime)) {
                $dateTimeObj = new DateTime($datetime);
                return $dateTimeObj->format('Y-m-d h:i A');
            }
            return '';
        }

        // Function to display timeline item in a card-like container
        function displayTimelineItem($label, $date, $status, $isCancelled) {
            if (!empty($date)) {
                // Determine color and status text
                if ($isCancelled) {
                    $borderColor = 'red';
                    $statusText = 'Cancelled';
                    $icon = 'fa-times-circle';
                } else {
                    switch ($status) {
                        case 'Leads Generation':
                            $borderColor = '#001f3f'; // Navy color
                            $statusText = 'Leads Generation';
                            break;
                        case 'Engagement':
                            $borderColor = '#0f5132'; // Success green color
                            $statusText = 'Engagement';
                            break;
                        case 'Proposal':
                        case 'Ordered':
                        case 'Delivered':
                            $borderColor = '#0f5132'; // Success green color
                            $statusText = $status;
                            break;
                        case 'Closed':
                            $borderColor = '#2c2c2c'; // Dark gray color
                            $statusText = $status;
                            break;
                        default:
                            $borderColor = '#6c757d'; // Default gray color
                            $statusText = $status;
                            break;
                    }
                    $icon = 'fa-check-circle';
                }

                // Render the card
                echo '<div class="card timeline-item" style="border-left: 5px solid ' . $borderColor . ';">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title" style="color: ' . $borderColor . '; font-size:12px;"></h5>';
                echo '<p class="card-text" style="font-size:12px;"><i class="fa ' . $icon . '" style="color: ' . $borderColor . ';"></i> Status: ' . $statusText . '</p>';
                echo '<p class="card-text" style="font-size:10px; text-transform: uppercase; color: black;">' . $label . ': ' . formatDateTime($date) . '</p>';
                echo '</div>';
                echo '</div>';
                echo '<br>';
            }
        }
        ?>
        <form>
            <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                <!-- Tab Items -->
                <li class="nav-item"><a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill" href="#custom-content-below-home" role="tab" aria-controls="custom-content-below-home" aria-selected="true" style="font-size:12px; color: black;">Transaction Details</a></li>
                <li class="nav-item"><a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill" href="#custom-content-below-profile" role="tab" aria-controls="custom-content-below-profile" aria-selected="false" style="font-size:12px; color: black;">Customer Details</a></li>
                <li class="nav-item"><a class="nav-link" id="custom-content-below-engagement-tab" data-toggle="pill" href="#custom-content-below-engagement" role="tab" aria-controls="custom-content-below-engagement" aria-selected="false" style="font-size:12px; color: black;">Engagement</a></li>
                <li class="nav-item"><a class="nav-link" id="custom-content-below-proposal-tab" data-toggle="pill" href="#custom-content-below-proposal" role="tab" aria-controls="custom-content-below-proposal" aria-selected="false" style="font-size:12px; color: black;">Proposal</a></li>
                <li class="nav-item"><a class="nav-link" id="custom-content-below-order-tab" data-toggle="pill" href="#custom-content-below-order" role="tab" aria-controls="custom-content-below-order" aria-selected="false" style="font-size:12px; color: black;">Order</a></li>
                <li class="nav-item"><a class="nav-link" id="custom-content-below-payment-tab" data-toggle="pill" href="#custom-content-below-payment" role="tab" aria-controls="custom-content-below-payment" aria-selected="false" style="font-size:12px; color: black;">Payment</a></li>
                <li class="nav-item"><a class="nav-link" id="custom-content-below-delivery-tab" data-toggle="pill" href="#custom-content-below-delivery" role="tab" aria-controls="custom-content-below-delivery" aria-selected="false" style="font-size:12px; color: black;">Delivery</a></li>
                <li class="nav-item"><a class="nav-link" id="custom-content-below-timeline-tab" data-toggle="pill" href="#custom-content-below-timeline" role="tab" aria-controls="custom-content-below-timeline" aria-selected="false" style="font-size:12px; color: black;">Timeline</a></li>
            </ul>
            <div class="tab-content" id="custom-content-below-tabContent">
                <div class="tab-pane fade show active" id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
                    <br>
                    <div class="row">
                        <div class="form-group col-md-6"><label for="order_id" style="font-size:12px;">Order ID:</label><input type="text" class="form-control form-control-sm" id="order_id" value="<?php echo $row['order_id']; ?>" style="font-size:12px;" readonly></div>
                        <div class="form-group col-md-6"><label for="order_date" style="font-size:12px;">Order Date:</label><input type="text" class="form-control form-control-sm" id="order_date" value="<?php echo formatDateTime($row['order_date']); ?>" style="font-size:12px;" readonly></div>
                        <div class="form-group col-md-6"><label for="customer_category" style="font-size:12px;">Customer Category:</label><input type="text" class="form-control form-control-sm" id="customer_category" value="<?php echo $row['customer_category']; ?>" style="font-size:12px;" readonly></div>
                        <div class="form-group col-md-6"><label for="customer_type" style="font-size:12px;">Customer Type:</label><input type="text" class="form-control form-control-sm" id="customer_type" value="<?php echo $row['customer_type']; ?>" style="font-size:12px;" readonly></div>
                        <div class="form-group col-md-6"><label for="order_status" style="font-size:12px">Order Status:</label><input type="text" class="form-control form-control-sm" id="order_status" value="<?php echo $row['order_status']; ?>" style="font-size:12px;" readonly></div>
                    </div>
                </div>
                <div class="tab-pane fade" id="custom-content-below-profile" role="tabpanel" aria-labelledby="custom-content-below-profile-tab">
                    <br>
                    <div class="row">
                        <div class="form-group col-md-6"><label for="customer_name" style="font-size:12px;">Fullname:</label><input type="text" class="form-control form-control-sm" id="customer_name" value="<?php echo $row['firstname'].' '.$row['lastname']; ?>" style="font-size:12px; text-transform: capitalize;" readonly></div>
                        <div class="form-group col-md-6"><label for="contact_number" style="font-size:12px;">Contact Number:</label><input type="text" class="form-control form-control-sm" id="contact_number" value="<?php echo $row['contact_number']; ?>" style="font-size:12px;" readonly></div>
                        <div class="form-group col-md-6"><label for="email_address" style="font-size:12px;">Email Address:</label><input type="text" class="form-control form-control-sm" id="email_address" value="<?php echo $row['email_address']; ?>" style="font-size:12px;" readonly></div>
                        <div class="form-group col-md-6"><label for="gender" style="font-size:12px;">Gender:</label><input type="text" class="form-control form-control-sm" id="gender" value="<?php echo $row['gender']; ?>" style="font-size:12px;" readonly></div>
                        <div class="form-group col-md-12"><label for="city_address" style="font-size:12px;">Address:</label><input type="text" class="form-control form-control-sm" id="city_address" value="<?php echo $row['city_address']; ?>" style="font-size:12px;" readonly></div>
                    </div>
                </div>
                <div class="tab-pane fade" id="custom-content-below-engagement" role="tabpanel" aria-labelledby="custom-content-below-engagement-tab">
                    <br>
                    <div class="row">
                        <div class="form-group col-md-6"><label for="latest_engagement_date" style="font-size:12px;">Latest Engagement Date:</label><input type="text" class="form-control form-control-sm" id="latest_engagement_date" value="<?php echo formatDateTime($row['latest_engagement_date']); ?>" style="font-size:12px;" readonly></div>
                        <div class="form-group col-md-6"><label for="remarks" style="font-size:12px;">Remarks:</label><input type="text" class="form-control form-control-sm" id="remarks" value="<?php echo $row['remarks']; ?>" style="font-size:12px;" readonly></div>
                        <div class="form-group col-md-6"><label for="uploaded_file" style="font-size:12px;">Uploaded File:</label><input type="text" class="form-control form-control-sm" id="uploaded_file" value="<?php echo $row['uploaded_file']; ?>" style="font-size:12px;" readonly></div>
                    </div>
                </div>
                <div class="tab-pane fade" id="custom-content-below-proposal" role="tabpanel" aria-labelledby="custom-content-below-proposal-tab">
                    <br>
                    <div class="row">
                        <div class="form-group col-md-6"><label for="quotation_reference_number" style="font-size:12px;">Quotation Reference Number:</label><input type="text" class="form-control form-control-sm" id="quotation_reference_number" value="<?php echo $row['quotation_reference_number']; ?>" style="font-size:12px;" readonly></div>
                        <div class="form-group col-md-6"><label for="proposal_remarks" style="font-size:12px;">Proposal Remarks:</label><input type="text" class="form-control form-control-sm" id="proposal_remarks" value="<?php echo $row['proposal_remarks']; ?>" style="font-size:12px;" readonly></div>
                        <div class="form-group col-md-6"><label for="date_qtn_sent" style="font-size:12px;">Date QTN Sent:</label><input type="text" class="form-control form-control-sm" id="date_qtn_sent" value="<?php echo formatDateTime($row['date_qtn_sent']); ?>" style="font-size:12px;" readonly></div>
                    </div>
                </div>
                <div class="tab-pane fade" id="custom-content-below-order" role="tabpanel" aria-labelledby="custom-content-below-order-tab">
                    <br>
                    <div class="row">
                        <div class="form-group col-md-6"><label for="sales_order_reference_number" style="font-size:12px;">Sales Order Reference Number:</label><input type="text" class="form-control form-control-sm" id="sales_order_reference_number" value="<?php echo $row['sales_order_reference_number']; ?>" style="font-size:12px;" readonly></div>
                        <div class="form-group col-md-6"><label for="order_remarks" style="font-size:12px;">Order Remarks:</label><input type="text" class="form-control form-control-sm" id="order_remarks" value="<?php echo $row['order_remarks']; ?>" style="font-size:12px;" readonly></div>
                        <div class="form-group col-md-6"><label for="date_of_sales_order_creation" style="font-size:12px;">Date of Sales Order Creation:</label><input type="text" class="form-control form-control-sm" id="date_of_sales_order_creation" value="<?php echo formatDateTime($row['date_of_sales_order_creation']); ?>" style="font-size:12px;" readonly></div>
                        <div class="form-group col-md-6"><label for="warehouse_email" style="font-size:12px;">Warehouse Email:</label><input type="text" class="form-control form-control-sm" id="warehouse_email" value="<?php echo $row['warehouse_email']; ?>" style="font-size:12px;" readonly></div>
                    </div>
                </div>
                <div class="tab-pane fade" id="custom-content-below-payment" role="tabpanel" aria-labelledby="custom-content-below-payment-tab">
                    <br>
                    <div class="row">
                        <div class="form-group col-md-6"><label for="payment_reference_number" style="font-size:12px;">Payment Reference Number:</label><input type="text" class="form-control form-control-sm" id="payment_reference_number" value="<?php echo $row['payment_reference_number']; ?>" style="font-size:12px;" readonly></div>
                        <div class="form-group col-md-6"><label for="payment_remarks" style="font-size:12px;">Payment Remarks:</label><input type="text" class="form-control form-control-sm" id="payment_remarks" value="<?php echo $row['payment_remarks']; ?>" style="font-size:12px;" readonly></div>
                    </div>
                </div>
                <div class="tab-pane fade" id="custom-content-below-delivery" role="tabpanel" aria-labelledby="custom-content-below-delivery-tab">
                    <br>
                    <div class="row">
                        <div class="form-group col-md-6"><label for="delivery_reference_number" style="font-size:12px;">Delivery Reference Number:</label><input type="text" class="form-control form-control-sm" id="delivery_reference_number" value="<?php echo $row['delivery_reference_number']; ?>" style="font-size:12px;" readonly></div>
                        <div class="form-group col-md-6"><label for="delivery_date" style="font-size:12px;">Delivery Date:</label><input type="text" class="form-control form-control-sm" id="delivery_date" value="<?php echo formatDateTime($row['delivery_date']); ?>" style="font-size:12px;" readonly></div>
                        <div class="form-group col-md-6"><label for="delivery_remarks" style="font-size:12px;">Delivery Remarks:</label><input type="text" class="form-control form-control-sm" id="delivery_remarks" value="<?php echo $row['delivery_remarks']; ?>" style="font-size:12px;" readonly></div>
                    </div>
                </div>
                <div class="tab-pane fade" id="custom-content-below-timeline" role="tabpanel" aria-labelledby="custom-content-below-timeline-tab">
                    <br>
                    <div class="timeline">
                <?php
                displayTimelineItem('Order Date', $row['order_date'], 'Leads Generation', false);
                displayTimelineItem('Latest Engagement Date', $row['latest_engagement_date'], 'Engagement', $row['order_status'] == 'Cancelled');
                displayTimelineItem('Date Quotation Sent', $row['date_qtn_sent'], 'Proposal', $row['order_status'] == 'Cancelled');
                displayTimelineItem('Date of Sales Order Creation', $row['date_of_sales_order_creation'], 'Ordered', $row['order_status'] == 'Cancelled');
                displayTimelineItem('Delivery Date', $row['delivery_date'], 'Delivered', $row['order_status'] == 'Cancelled');
                displayTimelineItem('Date Closed', $row['date_closed'], 'Closed', $row['order_status'] == 'Cancelled');
                ?>
            </div>
            </div>
        </form>
        <?php
    } else {
        echo "<script>Swal.fire({icon: 'error', title: 'Error', text: 'No record found for the given Order ID.'});</script>";
    }
    $stmt->close();
    $conn->close();
} else {
    echo "<script>Swal.fire({icon: 'error', title: 'Error', text: 'Invalid request method or missing Order ID.'});</script>";
}
?>
