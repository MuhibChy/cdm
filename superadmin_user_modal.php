<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel" style="font-size:12px;">User Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="createForm" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="create_firstname" style="font-size:12px;">First Name</label>
                                <input type="text" class="form-control form-control-sm" id="create_firstname" name="firstname" style="font-size:12px; text-transform: capitalize;" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="create_lastname" style="font-size:12px;">Last Name</label>
                                <input type="text" class="form-control form-control-sm" id="create_lastname" name="lastname" style="font-size:12px; text-transform: capitalize;" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="create_username" style="font-size:12px;">Username</label>
                                <input type="text" class="form-control form-control-sm" id="create_username" name="username" style="font-size:12px; text-transform: capitalize;" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="create_password" style="font-size:12px;">Password</label>
                                <input type="password" class="form-control form-control-sm" id="create_password" name="password" style="font-size:12px;" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="create_role" style="font-size:12px;">Role</label>
                                <select class="form-control form-control-sm" id="create_role" name="role" style="font-size:12px;" required>
                                    <option value="admin">Admin Account</option>
                                    <option value="user">Sales Account</option>
                                    <option value="director">Directors Account</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="create_photo" style="font-size:12px;">Profile Photo</label>
                                <input type="file" class="form-control form-control-sm" id="create_photo" name="profile_photo" style="font-size:12px;" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="department" style="font-size:12px;">Department</label>
                                <select class="form-control form-control-sm" id="department" name="department_assignment" style="font-size:12px;" required>
                                    <option value="" disabled>IT Department</option>
                                    <option value="Sales Department">Sales Department</option>
                                    <option value="CSR Department">CSR Department</option>
                                    <option value="Director">Director</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="id_number" style="font-size:12px;">Company ID</label>
                                <input type="text" class="form-control form-control-sm" id="id_number" name="id_number" style="font-size:12px;" required>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn xhire-astros btn-sm" style="font-size:12px;"><i class="fas fa-circle-check"></i> Create Record</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Update Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel" style="font-size:12px;">User Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="updateForm" method="POST">
                    <input type="hidden" name="user_id" id="update_user_id">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="update_firstname" style="font-size:12px;">First Name</label>
                                <input type="text" class="form-control form-control-sm" id="update_firstname" name="firstname" style="font-size:12px; text-transform: capitalize;" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="update_lastname" style="font-size:12px;">Last Name</label>
                                <input type="text" class="form-control form-control-sm" id="update_lastname" name="lastname" style="font-size:12px; text-transform: capitalize;" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="update_username" style="font-size:12px;">Username</label>
                                <input type="text" class="form-control form-control-sm" id="update_username" name="username" style="font-size:12px; text-transform: capitalize;" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="update_role" style="font-size:12px;">Role</label>
                                <select class="form-control form-control-sm" id="update_role" name="role" style="font-size:12px;" required>
                                    <option value="admin">Admin Account</option>
                                    <option value="user">Sales Account</option>
                                    <option value="director">Directors Account</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="update_department_assignment" style="font-size:12px;">Department</label>
                                <select class="form-control form-control-sm" id="update_department_assignment" name="department_assignment" style="font-size:12px;" required>
                                    <option value="" disabled>IT Department</option>
                                    <option value="Sales Department">Sales Department</option>
                                    <option value="CSR Department">CSR Department</option>
                                    <option value="Director">Director</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="update_id_number" style="font-size:12px;">Company ID</label>
                                <input type="text" class="form-control form-control-sm" id="update_id_number" name="id_number" style="font-size:12px;" required>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn xhire-info btn-sm" style="font-size:12px;" onclick="submitUpdateForm()"><i class="fas fa-pen-nib"></i> Update Record</button>
                </form>
            </div>
        </div>
    </div>
</div>
