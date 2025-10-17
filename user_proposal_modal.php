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
                    <div class="form-group">
                        <label for="updateQuotationReferenceNumber" style="font-size: 12px;">Quotation Reference Number</label>
                        <input type="text" class="form-control form-control-sm" id="updateQuotationReferenceNumber" name="quotation_reference_number" value="<?php echo 'QRN-' . uniqid(); ?>" style="font-size: 12px; text-transform: uppercase;" readonly>
                    </div>
                    <div class="form-group">
                        <label for="updateDateQuotationSent" style="font-size: 12px;">Date Quotation Sent</label>
                        <input type="datetime-local" class="form-control form-control-sm" id="updateDateQuotationSent" name="date_qtn_sent" style="font-size: 12px;" value="<?php echo date('Y-m-d\TH:i'); ?>">
                    </div>
                    <div class="form-group">
                        <label for="updateOrderStatus" style="font-size: 12px;">Order Status</label>
                        <select class="form-control form-control-sm" id="updateOrderStatus" name="order_status" required style="font-size: 12px;" onchange="toggleFields(this.value)">
                            <option value="" disabled selected>Choose stage</option>
                            <option value="Proposal">Stage 3: Proposal</option>
                            <option value="Cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div class="form-group" id="proposalRemarksGroup" style="display: none;">
                        <label for="updateProposalRemarks" style="font-size: 12px;">Proposal Remarks</label>
                        <textarea class="form-control form-control-sm" id="updateProposalRemarks" name="proposal_remarks" style="font-size: 12px; text-transform: capitalize;" rows="3"></textarea>
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
                    <button type="button" class="btn btn-sm xhire-secondary" data-dismiss="modal" style="font-size: 12px;"><i class="fas fa-circle-xmark"></i> Close</button>
                    <button type="submit" class="btn btn-sm xhire-info" style="font-size: 12px;"><i class="fas fa-pen-nib"></i>&nbsp;Update Transaction</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleFields(status) {
        var proposalRemarksGroup = document.getElementById('proposalRemarksGroup');
        var reasonCancelledGroup = document.getElementById('reasonCancelledGroup');
        var uploadFileGroupCancelled = document.getElementById('uploadFileGroupCancelled');

        if (status === 'Proposal') {
            proposalRemarksGroup.style.display = 'block';
            reasonCancelledGroup.style.display = 'none';
            uploadFileGroupCancelled.style.display = 'none';
        } else if (status === 'Cancelled') {
            proposalRemarksGroup.style.display = 'none';
            reasonCancelledGroup.style.display = 'block';
            uploadFileGroupCancelled.style.display = 'block';
        } else {
            proposalRemarksGroup.style.display = 'none';
            reasonCancelledGroup.style.display = 'none';
            uploadFileGroupCancelled.style.display = 'none';
        }
    }
</script>
