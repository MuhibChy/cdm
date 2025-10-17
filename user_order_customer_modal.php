<!-- View Customer Order Details Modal -->
<div class="modal fade" id="customerOrderDetailsModal" tabindex="-1" role="dialog" aria-labelledby="customerOrderDetailsModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="customerOrderDetailsModal" style="font-size: 12px;">Transaction Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Content will be dynamically loaded via AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal" style="font-size: 12px;"><i class="fas fa-circle-xmark"></i> Close</button>
            </div>
        </div>
    </div>
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
                        <label for="updateSalesOrderReferenceNumber" style="font-size: 12px;">Sales Order Reference Number</label>
                        <input type="text" class="form-control form-control-sm" id="updateSalesOrderReferenceNumber" name="sales_order_reference_number" value="<?php echo 'SRN-' . uniqid(); ?>" style="font-size: 12px; text-transform: uppercase;" readonly>
                    </div>
                    <div class="form-group">
                        <label for="updateDateSalesOrderCreation" style="font-size: 12px;">Date of Sales Order Creation</label>
                        <input type="datetime-local" class="form-control form-control-sm" id="updateDateSalesOrderCreation" name="date_of_sales_order_creation" style="font-size: 12px;" value="<?php echo date('Y-m-d\TH:i'); ?>">
                    </div>
                    <div class="form-group">
                        <label for="updateOrderStatus" style="font-size: 12px;">Order Status</label>
                        <select class="form-control form-control-sm" id="updateOrderStatus" name="order_status" style="font-size: 12px;" required onchange="toggleFields(this.value)">
                            <option value="" disabled selected>Choose stage</option>
                            <option value="Order">Stage 4: Order</option>
                            <option value="Cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div class="form-group" id="orderRemarksGroup" style="display: none;">
                        <label for="updateOrderRemarks" style="font-size: 12px;">Order Remarks</label>
                        <textarea class="form-control form-control-sm" id="updateOrderRemarks" name="order_remarks" style="font-size: 12px; text-transform: capitalize;" rows="3"></textarea>
                    </div>
                    <div class="form-group" id="warehouseEmailGroup" style="display: none;">
                        <label for="updateWarehouseEmail" style="font-size: 12px;">Warehouse Email</label>
                        <input type="email" class="form-control form-control-sm" id="updateWarehouseEmail" style="font-size: 12px;" name="warehouse_email">
                        <small id="emailValidationMessage" style="font-size: 12px;"></small>
                    </div>
                    <div class="form-group" id="reasonCancelledGroup" style="display: none;">
                        <label for="updateReasonCancelled" style="font-size: 12px;">Reason for Cancellation</label>
                        <textarea class="form-control form-control-sm" id="updateReasonCancelled" name="reason_cancelled" style="font-size: 12px; text-transform: capitalize;" rows="3"></textarea>
                    </div>
                    <div class="custom-file" id="uploadFileGroupCancelled" style="display: none;">
                        <input type="file" class="custom-file-input form-control-sm" id="updateUploadedFileCancelled" name="uploaded_file_cancelled">
                        <label class="custom-file-label" for="updateUploadedFileCancelled" style="font-size: 12px;">Proof of Cancellation</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal" style="font-size: 12px;"><i class="fas fa-circle-xmark"></i> Close</button>
                    <button type="submit" class="btn btn-sm xhire-info"><i class="fas fa-pen-nib"></i>&nbsp;Update Transaction</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    // Function to toggle fields based on order status
    $('#updateOrderStatus').on('change', function() {
        var orderStatus = $(this).val();
        toggleFields(orderStatus);
    });

    // Initial toggle based on default select value
    toggleFields($('#updateOrderStatus').val());

    // Function to toggle fields
    function toggleFields(orderStatus) {
        var orderRemarksGroup = $('#orderRemarksGroup');
        var warehouseEmailGroup = $('#warehouseEmailGroup');
        var reasonCancelledGroup = $('#reasonCancelledGroup');
        var uploadFileGroupCancelled = $('#uploadFileGroupCancelled');

        if (orderStatus === 'Order') {
            orderRemarksGroup.show();
            warehouseEmailGroup.show();
            reasonCancelledGroup.hide();
            uploadFileGroupCancelled.hide();
        } else if (orderStatus === 'Cancelled') {
            orderRemarksGroup.hide();
            warehouseEmailGroup.hide();
            reasonCancelledGroup.show();
            uploadFileGroupCancelled.show();
        } else {
            orderRemarksGroup.hide();
            warehouseEmailGroup.hide();
            reasonCancelledGroup.hide();
            uploadFileGroupCancelled.hide();
        }
    }
});

document.addEventListener("DOMContentLoaded", function() {
    var emailInput = document.getElementById("updateWarehouseEmail");
    var emailMessage = document.getElementById("emailValidationMessage");

    emailInput.addEventListener("input", function() {
        var email = emailInput.value.trim();
        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Regular expression for email validation
        var isValid = emailPattern.test(email);

        if (email === "") {
            // If email field is empty
            emailMessage.textContent = "";
        } else if (isValid) {
            // Valid email format
            emailMessage.textContent = "Valid email address.";
            emailMessage.style.color = "green";
        } else {
            // Invalid email format
            emailMessage.textContent = "Invalid email address.";
            emailMessage.style.color = "red";
        }
    });
});
</script>