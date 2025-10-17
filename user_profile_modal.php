<!-- Modal for updating profile information -->
<div class="modal fade" id="leadsprofile" tabindex="-1" role="dialog" aria-labelledby="updateProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateProfileModalLabel" style="font-size:12px;">Profile Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form for updating profile information -->
                <form action="update_profile.php" method="POST" enctype="multipart/form-data">
                    <div class="row"> 
                        <div class="col-md-6"> 
                             <label for="firstname" style="font-size:12px;">First Name:</label>
                             <input type="text" class="form-control form-control-sm" id="firstname" name="firstname" value="<?php echo $firstname; ?>" style="font-size:12px;" required>
                        </div>
                        <div class="col-md-6"> 
                             <label for="lastname" style="font-size:12px;">Last Name:</label>
                             <input type="text" class="form-control form-control-sm" id="lastname" name="lastname" value="<?php echo $lastname; ?>" style="font-size:12px;" required>
                        </div>
                       <div class="col-md-6"> 
                             <label for="department_assignment" style="font-size:12px;">Department Assignment:</label>
                             <input type="text" class="form-control form-control-sm" id="department_assignment" value="<?php echo $department_assignment; ?>" style="font-size:12px;" readonly>
                        </div>
                        <div class="col-md-6"> 
                             <label for="id_number" style="font-size:12px;">Company ID Number:</label>
                             <input type="text" class="form-control form-control-sm" id="id_number" value="<?php echo $id_number; ?>" style="font-size:12px;" readonly>
                        </div>
                        <div class="col-md-12"> 
                             <label for="profile_photo" style="font-size:12px;">Profile Photo:</label>
                             <input type="file" class="form-control-file" id="profile_photo" name="profile_photo" style="font-size:12px;">
                       </div>
                </div>
                       <br>
                       <p style="font-size:12px; font-weight: bold;">Personal Information</p>
                       <div class="row"> 
                        <div class="col-md-6"> 
                             <label for="gender" style="font-size:12px;">Gender:</label>
                             <select class="form-control form-control-sm" name="gender" id="gender" value="<?php echo $gender; ?>">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Bisexual">Bisexual</option>
                            </select>
                        </div>
                        <div class="col-md-6"> 
                             <label for="contact_number" style="font-size:12px;">Contact Number:</label>
                             <input type="text" class="form-control form-control-sm" id="contact_number" name="contact_number" value="<?php echo $contact_number; ?>" style="font-size:12px;" required>
                        </div>
                        <div class="col-md-6"> 
                             <label for="email_address" style="font-size:12px;">Email Address:</label>
                             <input type="text" class="form-control form-control-sm" id="email" name="email" value="<?php echo $email; ?>" style="font-size:12px;" required>
                        </div>
                        <div class="col-md-6"> 
                             <label for="nickname" style="font-size:12px;">Nickname</label>
                             <input type="text" class="form-control form-control-sm" id="nickname" name="nickname" value="<?php echo $nickname; ?>" style="font-size:12px; text-transform: uppercase;" required>
                             <span style="font-size: 10px;">This Nickname Will Display on Your Dashboard</span>
                        </div>
                    </div>
                <br>
                    
                    <!-- Hidden input to pass user ID -->
                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                    <button type="submit" class="btn xhire-info btn-sm" style="font-size:12px;"><i class='fas fa-pen-nib'></i> Update Record</button>
                </form>
            </div>
        </div>
    </div>
</div>