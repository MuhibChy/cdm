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
                <h5 class="modal-title" id="updateCustomerOrderModalLabel" style="font-size:12px;">Transaction Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="updateCustomerOrderForm" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="updateOrderId" name="order_id">
                    <div class="form-group">
                        <label for="updateDeliveryReferenceNumber" style="font-size:12px;">Delivery Reference Number</label>
                        <input type="text" class="form-control form-control-sm" id="updateDeliveryReferenceNumber" name="delivery_reference_number" value="<?php echo 'DRN-' . uniqid(); ?>" style="font-size: 12px; text-transform: uppercase;" readonly>
                    </div>
                    <div class="form-group">
                         <label for="updateDeliveryDate" style="font-size:12px;">Delivery Date</label>
                         <input type="datetime-local" class="form-control form-control-sm" id="updateDeliveryDate" name="delivery_date" style="font-size: 12px;" value="<?php echo date('Y-m-d\TH:i'); ?>">
                    </div>
                    <div class="form-group">
                        <label for="updateOrderStatus" style="font-size:12px;">Order Status</label>
                        <select class="form-control form-control-sm" id="updateOrderStatus" name="order_status" style="font-size: 12px;" required>
                            <option value="">Select Status</option>
                            <option value="Delivery">Stage 6: Delivery</option>
                            <option value="Cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div class="form-group" id="deliveryRemarksGroup" style="display: none;">
                        <label for="updateDeliveryRemarks" style="font-size:12px;">Delivery Remarks</label>
                        <textarea class="form-control form-control-sm" id="updateDeliveryRemarks" name="delivery_remarks" style="font-size: 12px; text-transform: capitalize;" rows="3"></textarea>
                    </div>
                    <div class="form-group" id="cancellationReasonGroup" style="display: none;">
                        <label for="updateCancellationReason" style="font-size:12px;">Reason for Cancellation</label>
                        <textarea class="form-control form-control-sm" id="updateCancellationReason" name="reason_cancelled" style="font-size: 12px; text-transform: capitalize;" rows="3"></textarea>
                    </div>
                    <div class="custom-file" id="uploadFileGroupCancelled" style="display: none;">
                        <input type="file" class="custom-file-input form-control-sm" id="updateUploadedFileCancelled" name="uploaded_file_cancelled">
                        <label class="custom-file-label" for="updateUploadedFileCancelled" style="font-size: 12px;">Proof of Cancellation</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm xhire-secondary" data-dismiss="modal" style="font-size: 12px;"><i class="fas fa-circle-xmark"></i> Close</button>
                    <button type="submit" class="btn btn-sm xhire-info"><i class="fas fa-pen-nib"></i> Update Transaction</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var orderStatusSelect = document.getElementById("updateOrderStatus");
    var deliveryRemarksGroup = document.getElementById("deliveryRemarksGroup");
    var cancellationReasonGroup = document.getElementById("cancellationReasonGroup");
    var uploadFileGroupCancelled = document.getElementById("uploadFileGroupCancelled");
    var updateDeliveryReferenceNumber = document.getElementById("updateDeliveryReferenceNumber");

    // Function to generate unique ID
    function generateUniqueId() {
        return 'DRN-' + Math.random().toString(36).substr(2, 9);
    }

    // Event listener for showing the modal
    $('#updateCustomerOrderModal').on('show.bs.modal', function (event) {
        // Generate and set the unique Delivery Reference Number
        updateDeliveryReferenceNumber.value = generateUniqueId();
    });

    orderStatusSelect.addEventListener("change", function() {
        var selectedOption = orderStatusSelect.value;

        if (selectedOption === "Delivery") {
            deliveryRemarksGroup.style.display = "block";
            cancellationReasonGroup.style.display = "none";
            uploadFileGroupCancelled.style.display = "none";
        } else if (selectedOption === "Cancelled") {
            deliveryRemarksGroup.style.display = "none";
            cancellationReasonGroup.style.display = "block";
            uploadFileGroupCancelled.style.display = "block";
        } else {
            deliveryRemarksGroup.style.display = "none";
            cancellationReasonGroup.style.display = "none";
            uploadFileGroupCancelled.style.display = "none";
        }
    });

    // Trigger change event to set initial state
    orderStatusSelect.dispatchEvent(new Event('change'));
});
</script>