<?php
// Function to generate a unique reference number
function generateUniqueReferenceNumber() {
    // Generate a unique reference number using timestamp and a unique ID
    $timestamp = time(); // Current timestamp
    $uniqueId = uniqid(); // Unique identifier based on current time in microseconds

    // Combine timestamp and unique ID to create a unique reference number
    $referenceNumber = 'REF-' . $timestamp . '-' . substr($uniqueId, -6); // Use only the last 6 characters of the unique ID

    return $referenceNumber;
}

// Generate a unique reference number
$referenceNumber = generateUniqueReferenceNumber();

echo $referenceNumber;
?>


<!-- Create Customer Order Modal -->
<div class="modal fade" id="createCustomerOrderModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" style="font-size: 12px;">Transaction Details</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="createCustomerOrderForm" method="post">
                    <input type="hidden" value="<?php echo $user_id; ?>" name="user_id">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="order_date" style="font-size: 12px;">Order Date</label>
                            <input type="datetime-local" class="form-control form-control-sm" id="order_date" name="order_date" value="<?php echo date('Y-m-d\TH:i'); ?>" style="font-size: 12px;" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="reference_number" style="font-size: 12px;">Reference Number</label>
                            <input type="text" class="form-control form-control-sm" id="reference_number" name="reference_number" value="<?php echo $referenceNumber; ?>" style="font-size: 12px;" readonly>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="customer_id" style="font-size: 12px;">Client Name</label>
                            <select class="form-control form-control-sm select2" id="customer_id" name="customer_id" onchange="getCustomerDetails(this.value)" required>
                                <option value="" selected="selected" style="font-size: 12px;">Select Customer</option>
                                <?php
                                // Fetch customers from database
                                $sql = "SELECT customer_id, CONCAT(firstname, ' ', lastname) AS customer_name FROM customers";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option style='font-size: 12px; text-transform: capitalize;' value='" . $row['customer_id'] . "'>" . $row['customer_name'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div id="customerDetails">
                        <!-- Customer details will be displayed here dynamically -->
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="customer_category" style="font-size: 12px;">Category</label>
                            <select class="form-control form-control-sm" id="customer_category" name="customer_category" required style="font-size: 12px;">
                                <option value="New">New</option>
                                <option value="Existing">Existing</option>
                                <option value="Existing Transferred">Existing Transferred</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="customer_type" style="font-size: 12px;">Type</label>
                            <select class="form-control form-control-sm" id="customer_type" name="customer_type" required style="font-size: 12px;">
                                <option value="B2C">B2C</option>
                                <option value="B2B">B2B</option>
                                <option value="B2G">B2G</option>
                                <option value="General Trade">General Trade</option>
                                <option value="Modern Trade">Modern Trade</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="managerSelect" style="font-size: 12px;">Sales Manager</label>
                            <select class="form-control form-control-sm select3" id="managerSelect" name="manager_id" required style="font-size: 12px;">
                                <option value="">Select Sales Manager</option>
                                <?php
                                $sql_managers = "SELECT * FROM sales_managers";
                                $result_managers = $conn->query($sql_managers);
                                while ($row = $result_managers->fetch_assoc()) {
                                    echo "<option value='" . $row['manager_id'] . "'>" . $row['firstname'] . " " . $row['lastname'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="agentSelect" style="font-size: 12px;">Sales Agent</label>
                            <select class="form-control form-control-sm select4" id="agentSelect" name="agent_id" required style="font-size: 12px;">
                                <option value="">Select Sales Agent</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="order_status" style="font-size: 12px;">Status</label>
                            <select class="form-control form-control-sm" id="order_status" name="order_status" required style="font-size: 12px;">
                                <option value="Leads Generation">Stage 1: Leads Generation</option>
                                <option value="" disabled>Stage 2: Engagement</option>
                                <option value="" disabled>Stage 3: Proposal</option>
                                <option value="" disabled>Stage 4: Order</option>
                                <option value="" disabled>Stage 5: Payment</option>
                                <option value="" disabled>Stage 6: Delivery</option>
                            </select>
                        </div>
                    </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-sm xhire-secondary" data-dismiss="modal" style="font-size: 12px;"><i class="fas fa-circle-xmark"></i> Close</button>
                <button type="submit" class="btn bg-navy btn-sm" style="font-size: 12px;"><i class="fas fa-circle-check"></i>&nbsp;Create Transaction</button>
            </div>
          </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<!-- Update Customer Order Modal -->
<div class="modal fade" id="updateCustomerOrderModal" tabindex="-1" role="dialog" aria-labelledby="updateCustomerOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateCustomerOrderModalLabel" style="font-size: 12px;">Transaction Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="updateCustomerOrderForm" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="updateOrderId" name="order_id">
                    <div class="form-group">
                        <label for="updateReferenceNumber" style="font-size: 12px;">Reference Number</label>
                        <input type="text" class="form-control form-control-sm" id="updateReferenceNumber" style="font-size: 12px; text-transform: uppercase;" readonly>
                    </div>
                    <div class="form-group">
                        <label for="updateLatestEngagementDate" style="font-size: 12px;">Latest Engagement Date</label>
                        <input type="datetime-local" class="form-control form-control-sm" id="updateLatestEngagementDate" name="latest_engagement_date" style="font-size: 12px;" value="<?php echo date('Y-m-d\TH:i', strtotime($row['latest_engagement_date'])); ?>">
                    </div>
                    <div class="form-group">
                        <label for="updateOrderStatus" style="font-size: 12px;">Update Status</label>
                        <select class="form-control form-control-sm" id="updateOrderStatus" name="order_status" style="font-size: 12px;" required onchange="toggleFields(this.value)">
                            <option value="" disabled selected>Choose stage</option>
                            <option value="Engagement">Stage 2: Engagement</option>
                            <option value="Cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div class="form-group" id="remarksGroup" style="display: none;">
                        <label for="updateRemarks" style="font-size: 12px;">Remarks / Comments</label>
                        <textarea class="form-control form-control-sm" id="updateRemarks" name="remarks" style="font-size: 12px; text-transform: capitalize;" rows="3"></textarea>
                    </div>
                    <div class="form-group" id="reasonCancelledGroup" style="display: none;">
                        <label for="updateReasonCancelled" style="font-size: 12px;">Reason for Cancellation</label>
                        <textarea class="form-control form-control-sm" id="updateReasonCancelled" name="reason_cancelled" style="font-size: 12px; text-transform: capitalize;" rows="3"></textarea>
                    </div>
                    <div class="custom-file" id="uploadFileGroup" style="display: none;">
                        <input type="file" class="custom-file-input form-control-sm" id="updateUploadedFile" name="uploaded_file">
                        <label class="custom-file-label" for="updateUploadedFile" style="font-size: 12px;">Choose file</label>
                    </div>
                    <div class="custom-file" id="uploadFileGroupCancelled" style="display: none;">
                        <input type="file" class="custom-file-input form-control-sm" id="updateUploadedFileCancelled" name="uploaded_file_cancelled">
                        <label class="custom-file-label" for="updateUploadedFileCancelled" style="font-size: 12px;">Proof of Cancellation</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm xhire-secondary" data-dismiss="modal" style="font-size: 12px;"><i class="fas fa-circle-xmark"></i> Close</button>
                    <button type="submit" class="btn btn-sm xhire-info" style="font-size: 12px;"><i class="fas fa-pen-nib"></i>&nbsp;Update Transaction</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleFields(status) {
        var remarksGroup = document.getElementById('remarksGroup');
        var reasonCancelledGroup = document.getElementById('reasonCancelledGroup');
        var uploadFileGroup = document.getElementById('uploadFileGroup');
        var uploadFileGroupCancelled = document.getElementById('uploadFileGroupCancelled');

        if (status === 'Engagement') {
            remarksGroup.style.display = 'block';
            reasonCancelledGroup.style.display = 'none';
            uploadFileGroup.style.display = 'block';
            uploadFileGroupCancelled.style.display = 'none';
        } else if (status === 'Cancelled') {
            remarksGroup.style.display = 'none';
            reasonCancelledGroup.style.display = 'block';
            uploadFileGroup.style.display = 'none';
            uploadFileGroupCancelled.style.display = 'block';
        } else {
            remarksGroup.style.display = 'none';
            reasonCancelledGroup.style.display = 'none';
            uploadFileGroup.style.display = 'none';
            uploadFileGroupCancelled.style.display = 'none';
        }
    }
</script>

<div class="modal fade" id="customerOrderDetailsModal" tabindex="-1" role="dialog" aria-labelledby="customerOrderDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="customerOrderDetailsModalLabel" style="font-size:12px;">Transaction Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Content will be dynamically loaded via AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm xhire-secondary" data-dismiss="modal"><i class="fas fa-circle-xmark"></i> Close</button>
            </div>
        </div>
    </div>
</div>
