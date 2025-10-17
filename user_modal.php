<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel" style="font-size:12px;">Create User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <div class="modal-body">
                <form id="createForm" action="create_user.php" method="POST" enctype="multipart/form-data">        
                    <div class="row"> 
                        <div class="col-md-6">    
                              <div class="form-group">
                                <label for="create_firstname" style="font-size:12px;">First Name</label>
                                <input type="text" class="form-control form-control-sm" id="create_firstname" name="firstname" style="font-size:12px;" required>
                              </div>
                        </div>
                        <div class="col-md-6">    
                            <div class="form-group">
                              <label for="create_lastname" style="font-size:12px;">Last Name</label>
                              <input type="text" class="form-control form-control-sm" id="create_lastname" name="lastname" style="font-size:12px;" required>
                            </div>
                        </div>
                        <div class="col-md-6">  
                            <div class="form-group">
                              <label for="create_username" style="font-size:12px;">Username</label>
                              <input type="text" class="form-control form-control-sm" id="create_username" name="username" style="font-size:12px;" required>
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
                <button type="submit" class="btn btn-primary btn-sm">Create</button>
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
                    <h5 class="modal-title" id="updateModalLabel" style="font-size:12px;">Update User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="updateForm" action="update_user.php" method="POST">
                        <input type="hidden" name="user_id" id="update_user_id">
                            <div class="row"> 
                                <div class="col-md-6">    
                                    <div class="form-group">
                                        <label for="update_firstname" style="font-size:12px;">First Name</label>
                                        <input type="text" class="form-control form-control-sm" id="update_firstname" name="firstname" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="update_lastname" style="font-size:12px;">Last Name</label>
                                        <input type="text" class="form-control form-control-sm" id="update_lastname" name="lastname" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="update_username" style="font-size:12px;">Username</label>
                                        <input type="text" class="form-control form-control-sm" id="update_username" name="username" required>
                                    </div>
                                </div>
                                <div class="col-md-6">  
                            <div class="form-group">
                              <label for="create_role" style="font-size:12px;">Role</label>
                              <select class="form-control form-control-sm" id="update_role" name="role" style="font-size:12px;" required>
                                <option value="admin">Admin Account</option>
                                <option value="user">Sales Account</option>
                                <option value="director">Directors Account</option>
                              </select>
                            </div>
                        </div>
                        <div class="col-md-6">  
                            <div class="form-group">
                              <label for="department" style="font-size:12px;">Department</label>
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
                              <label for="id_number" style="font-size:12px;">Company ID</label>
                              <input type="text" class="form-control form-control-sm" id="update_id_number" name="id_number" style="font-size:12px;" required>
                            </div>
                        </div>
                            </div>
                        <button type="submit" class="btn btn-success btn-sm" style="font-size:12px;">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel" style="font-size:12px;">Delete User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p style="font-size:12px;">Are you sure you want to delete this user?</p>
                </div>
                <div class="modal-footer">
                    <form id="deleteForm" action="delete_user.php" method="POST">
                        <input type="hidden" name="user_id" id="delete_user_id">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" style="font-size:12px;">Cancel</button>
                        <button type="submit" class="btn btn-danger btn-sm" style="font-size:12px;">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>