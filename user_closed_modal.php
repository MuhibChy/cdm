<!-- View Customer Order Details Modal -->
<div class="modal fade" id="customerOrderDetailsModal" tabindex="-1" role="dialog" aria-labelledby="customerOrderDetailsModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="customerOrderDetailsModal" style="font-size: 12px;">Client Information and Transaction History</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Content will be dynamically loaded via AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm xhire-secondary" data-dismiss="modal" style="font-size: 12px;"><i class="fas fa-circle-xmark"></i> Close</button>
                <button type="button" class="btn btn-sm xhire-danger" onclick="printToWord()" style="font-size: 12px;"><i class="fa-solid fa-print"></i> Print</button>
            </div>
        </div>
    </div>
</div>
<script>
function printToWord() {
    // Get the content of the modal
    var modalContent = document.querySelector('.tab-content');
    
    // Clone the modal content to avoid modifying the original
    var cloneContent = modalContent.cloneNode(true);
    
    // Replace input fields with their corresponding text values
    var inputs = cloneContent.querySelectorAll('input, textarea, select');
    inputs.forEach(function(input) {
        var textNode = document.createTextNode(input.value);
        var parent = input.parentNode;
        parent.replaceChild(textNode, input);
    });

    // Create a new Blob with the modified content
    var blob = new Blob(['<html><head><meta charset="UTF-8"><title>Document</title></head><body>' + cloneContent.innerHTML + '</body></html>'], {
        type: 'application/msword'
    });

    // Create a link element to trigger the download
    var link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = 'OrderDetails.doc';

    // Append the link to the body, trigger the click, and remove the link
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
</script>
<!-- Update Customer Order Modal -->
<div class="modal fade" id="updateCustomerOrderModal" tabindex="-1" role="dialog" aria-labelledby="updateCustomerOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateCustomerOrderModalLabel" style="font-size:12px;">Update Client Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="updateCustomerOrderForm" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="updateOrderId" name="order_id">
                    <div class="form-group">
                        <label for="updateDeliveryReferenceNumber" style="font-size:12px;">Delivery Reference Number</label>
                        <input type="text" class="form-control form-control-sm" id="updateDeliveryReferenceNumber" style="font-size: 12px; text-transform: uppercase;" readonly>
                    </div>
                    <div class="form-group">
                        <label for="updateDeliveryDate" style="font-size:12px;">Closed Date</label>
                        <input type="date" class="form-control form-control-sm" name="date_closed" style="font-size: 12px;" value="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div class="form-group">
                        <label for="updateOrderStatus" style="font-size:12px;">Order Status</label>
                        <select class="form-control form-control-sm" id="updateOrderStatus" name="order_status" style="font-size: 12px;" required>
                            <option value="">Select Status</option>
                            <option value="Closed">Closed</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal" style="font-size: 12px;">Close</button>
                    <button type="submit" class="btn btn-sm btn-dark" style="font-size: 12px;">Closed Order</button>
                </div>
            </form>
        </div>
    </div>
</div>
