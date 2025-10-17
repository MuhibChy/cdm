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
                <button type="button" class="btn btn-sm xhire-secondary" data-dismiss="modal" style="font-size: 12px;"><i class="fas fa-circle-xmark"></i> Close</button>
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
        <!-- Hidden field for payment date -->
        <div class="form-group">
            <label for="updatePaymentDate" style="font-size: 12px;">Payment Date</label>
            <input type="datetime-local" class="form-control form-control-sm" id="updatePaymentDate" name="payment_date" style="font-size: 12px;" value="<?php echo date('Y-m-d\TH:i'); ?>">
        </div>
        <div class="form-group">
            <label for="updatePaymentReferenceNumber" style="font-size: 12px;">Payment Reference Number</label>
            <input type="text" class="form-control form-control-sm" id="updatePaymentReferenceNumber" name="payment_reference_number" style="text-transform: uppercase; font-size: 12px;" readonly>
        </div>
        <div class="form-group">
            <label for="updateSalesOrderReferenceNumber" style="font-size: 12px;">Sales Order Reference Number</label>
            <input type="text" class="form-control form-control-sm" id="updateSalesOrderReferenceNumber" style="text-transform: uppercase; font-size: 12px;" readonly>
        </div>
        <div class="form-group">
            <label for="updateOrderStatus" style="font-size: 12px;">Order Status</label>
            <select class="form-control form-control-sm" id="updateOrderStatus" name="order_status" style="font-size: 12px;" required>
                <option value="">Select Status</option>
                <option value="Payment">Stage 5: Payment</option>
                <option value="Cancelled">Cancelled</option>
            </select>
        </div>
        <div class="form-group" id="paymentRemarksGroup" style="display: none;">
            <label for="updatePaymentRemarks" style="font-size: 12px;">Payment Remarks</label>
            <textarea class="form-control form-control-sm" id="updatePaymentRemarks" name="payment_remarks" style="font-size: 12px; text-transform: capitalize;" rows="3"></textarea>
        </div>
        <div class="form-group" id="warehouseEmailGroup" style="display: none;">
            <label for="updateWarehouseEmail" style="font-size: 12px;">Warehouse Email</label>
            <input type="email" class="form-control form-control-sm" id="updateWarehouseEmail" name="warehouse_email" style="font-size: 12px;" readonly>
        </div>
        <div class="form-group" id="cancellationReasonGroup" style="display: none;">
            <label for="cancellationReason" style="font-size: 12px;">Reason for Cancellation</label>
            <textarea class="form-control form-control-sm" id="cancellationReason" name="cancellation_reason" style="font-size: 12px; text-transform: capitalize;" rows="3"></textarea>
        </div>
        <div class="custom-file" id="uploadFileGroupCancelled" style="display: none;">
            <input type="file" class="custom-file-input form-control-sm" id="updateUploadedFileCancelled" name="uploaded_file_cancelled">
            <label class="custom-file-label" for="updateUploadedFileCancelled" style="font-size: 12px;">Proof of Cancellation</label>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-sm xhire-secondary" data-dismiss="modal" style="font-size: 12px;"><i class="fas fa-circle-xmark"></i> Close</button>
        <button type="submit" class="btn btn-sm xhire-info"><i class="fas fa-pen-nib"></i>&nbsp;Update Transaction</button>
    </div>
</form>

        </div>
    </div>
</div>


<script>
document.addEventListener("DOMContentLoaded", function() {
    var updateCustomerOrderModal = document.getElementById('updateCustomerOrderModal');
    var orderStatusSelect = document.getElementById("updateOrderStatus");
    var paymentRemarksGroup = document.getElementById("paymentRemarksGroup");
    var warehouseEmailGroup = document.getElementById("warehouseEmailGroup");
    var cancellationReasonGroup = document.getElementById("cancellationReasonGroup");
    var uploadFileGroupCancelled = document.getElementById("uploadFileGroupCancelled");
    var updatePaymentReferenceNumber = document.getElementById("updatePaymentReferenceNumber");

    // Function to generate unique ID
    function generateUniqueId() {
        return 'PRN-' + Math.random().toString(36).substr(2, 9);
    }

    // Event listener for showing the modal
    $('#updateCustomerOrderModal').on('show.bs.modal', function (event) {
        // Generate and set the unique Payment Reference Number
        updatePaymentReferenceNumber.value = generateUniqueId();
    });

    orderStatusSelect.addEventListener("change", function() {
        var selectedOption = orderStatusSelect.value;

        if (selectedOption === "Payment") {
            paymentRemarksGroup.style.display = "block";
            warehouseEmailGroup.style.display = "block";
            cancellationReasonGroup.style.display = "none";
            uploadFileGroupCancelled.style.display = "none";
        } else if (selectedOption === "Cancelled") {
            paymentRemarksGroup.style.display = "none";
            warehouseEmailGroup.style.display = "none";
            cancellationReasonGroup.style.display = "block";
            uploadFileGroupCancelled.style.display = "block";
        } else {
            paymentRemarksGroup.style.display = "none";
            warehouseEmailGroup.style.display = "none";
            cancellationReasonGroup.style.display = "none";
            uploadFileGroupCancelled.style.display = "none";
        }
    });

    // Trigger change event to set initial state
    orderStatusSelect.dispatchEvent(new Event('change'));
});
</script>