
<!-- Create Customer Modal -->
<div class="modal fade" id="createCustomerModal" tabindex="-1" role="dialog" aria-labelledby="createCustomerModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createCustomerModalLabel" style="font-size:12px; font-weight: bold;">Client Information</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="createForm" method="post">
          <div class="form-group">
            <label for="companyName" style="font-size:12px;">Company Name</label>
            <input type="text" class="form-control form-control-sm" id="companyName" name="company_name" placeholder="eco@eco.com" style="font-size: 12px; text-transform: capitalize;" required>
          </div>
          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="firstName" style="font-size:12px;">First Name</label>
              <input type="text" class="form-control form-control-sm" id="firstName" name="firstname" style="font-size: 12px; text-transform: capitalize;" required>
            </div>
            <div class="form-group col-md-4">
              <label for="middleInitial" style="font-size:12px;">Middle Initial</label>
              <input type="text" class="form-control form-control-sm" id="middleInitial" name="middle_initial" style="font-size: 12px; text-transform: capitalize;" required>
            </div>
            <div class="form-group col-md-4">
              <label for="lastName" style="font-size:12px;">Last Name</label>
              <input type="text" class="form-control form-control-sm" id="lastName" name="lastname" style="font-size: 12px; text-transform: capitalize;" required>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="contactNumber" style="font-size: 12px;">Contact Number</label>
              <input type="text" class="form-control form-control-sm" id="contactNumber" name="contact_number" style="font-size: 12px;" required>
              <small class="text-muted">Format: +639xxxxxxxxxx</small>
            </div>
            <div class="form-group col-md-6">
              <label for="email_address" style="font-size: 12px;">Email Address</label>
              <input type="email" class="form-control form-control-sm" id="email_address" name="email_address" style="font-size: 12px;" required>
              <div id="emailAlertExists" style="display: none; color: red; font-size: 10px; margin-top: 5px;">Email address already exists. Please use a different email address.</div>
              <div id="emailAlertAvailable" style="display: none; color: green; font-size: 10px; margin-top: 5px;">Email is available.</div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="gender" style="font-size:12px;">Gender</label>
              <select class="form-control form-control-sm" id="gender" name="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
              </select>
            </div>
            <div class="form-group col-md-12">
              <label for="cityAddress" style="font-size:12px;">City Address</label>
              <textarea type="text" class="form-control" id="city_address" name="city_address" required style="font-size:12px;"></textarea>
            </div>
          </div>
          <button type="submit" class="btn bg-navy btn-sm" style="font-size:12px;"><i class="fas fa-check-circle"></i> Create New Record</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
<script>
$(document).ready(function() {
    // Email availability check
    $('#email_address').on('blur', function() {
        var email = $(this).val();
        if (email !== '') {
            $.ajax({
                url: 'user_check_email_availability.php',
                type: 'POST',
                data: { email: email },
                success: function(response) {
                    if (response === 'exists') {
                        $('#emailAlertExists').fadeIn();
                        $('#emailAlertAvailable').fadeOut();
                        $('#email_address').val(''); // Clear the input field
                    } else if (response === 'available') {
                        $('#emailAlertExists').fadeOut();
                        $('#emailAlertAvailable').fadeIn();
                    } else {
                        alert('Error checking email availability. Please try again later.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error: ' + xhr.responseText);
                    alert('Error checking email availability. Please try again later.');
                }
            });
        }
    });

    // Input mask for contact number
    $('#contactNumber, #updateContactNumber').inputmask('+639999999999', {
        placeholder: '+639_________',
        clearMaskOnLostFocus: true
    });
});
</script>


<!-- Update Customer Modal -->
<div class="modal fade" id="updateCustomerModal" tabindex="-1" role="dialog" aria-labelledby="updateCustomerModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateCustomerModalLabel" style="font-size:12px;">Client Information</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="updateCustomerForm" method="post">
          <input type="hidden" id="updateCustomerId" name="customer_id">
          <div class="form-group">
            <label for="updateCompanyName" style="font-size:12px;">Company Name</label>
            <input type="text" class="form-control form-control-sm" id="updateCompanyName" name="company_name" style="font-size: 12px; text-transform: capitalize;" required>
          </div>
          <div class="form-row">
          <div class="form-group col-md-4">
            <label for="updateFirstName" style="font-size:12px;">First Name</label>
            <input type="text" class="form-control form-control-sm" id="updateFirstName" name="firstname" style="font-size: 12px; text-transform: capitalize;" required>
          </div>
          <div class="form-group col-md-4">
            <label for="updateMiddleInitial" style="font-size:12px;">Middle Initial</label>
            <input type="text" class="form-control form-control-sm" id="updateMiddleInitial" name="middle_initial" style="font-size: 12px; text-transform: capitalize;" required>
          </div>
          <div class="form-group col-md-4">
            <label for="updateLastName" style="font-size:12px;">Last Name</label>
            <input type="text" class="form-control form-control-sm" id="updateLastName" name="lastname" style="font-size: 12px; text-transform: capitalize;" required>
          </div>
          <div class="form-group col-md-6">
            <label for="updateContactNumber" style="font-size:12px;">Contact Number</label>
            <input type="text" class="form-control form-control-sm" id="updateContactNumber" name="contact_number" style="font-size: 12px;" required>
          </div>
          <div class="form-group col-md-6">
            <label for="updateEmailAddress" style="font-size:12px;">Email Address</label>
            <input type="email" class="form-control form-control-sm" id="updateEmailAddress" name="email_address" style="font-size: 12px; " required>
          </div>
          <div class="form-group col-md-12">
            <label for="updateGender" style="font-size:12px;">Gender</label>
            <select class="form-control" id="updateGender" name="gender" style="font-size:12px;">
              <option value="Male">Male</option>
              <option value="Female">Female</option>
            </select>
          </div>
          <div class="form-group col-md-12">
            <label for="updateCityAddress" style="font-size:12px;">City Address</label>
            <textarea type="text" class="form-control" id="updateCityAddress" name="city_address" style="font-size:12px;"></textarea>
          </div>
          </div>
          <button type="button" class="btn xhire-info btn-sm" style="font-size:12px;" onclick="submitUpdateForm()"><i class="fas fa-pen-nib"></i> Update Record</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Delete Customer Modal -->
<div class="modal fade" id="deleteCustomerModal" tabindex="-1" role="dialog" aria-labelledby="deleteCustomerModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteCustomerModalLabel" style="font-size:12px;">Delete Client Information</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p style="font-size:12px;">Are you sure you want to delete this client records?</p>
        <form id="deleteCustomerForm" action="admin_delete_customer.php" method="post">
          <input type="hidden" id="deleteCustomerId" name="deleteCustomerId">
          <button type="submit" class="btn xhire-danger btn-sm" style="font-size:12px;"><i class="fas fa-trash"></i> Delete Record</button>
          <button type="button" class="btn xhire-secondary btn-sm" style="font-size:12px;" data-dismiss="modal"><i class="fas fa-circle-xmark"></i> Cancel</button>
        </form>
      </div>
    </div>
  </div>
</div>

