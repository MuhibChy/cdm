<!-- Create Manager Modal -->
<div class="modal fade" id="createManagerModal" tabindex="-1" role="dialog" aria-labelledby="createManagerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="createManagerForm" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="createManagerModalLabel" style="font-size: 12px;">Information Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="createManagerFirstname" style="font-size: 12px;">First Name</label>
                            <input type="text" class="form-control form-control-sm" id="createManagerFirstname" name="firstname" style="font-size: 12px; text-transform:capitalize;" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="createManagerMiddleInitial" style="font-size: 12px;">Middle Initial</label>
                            <input type="text" class="form-control form-control-sm" id="createManagerMiddleInitial" name="middle_initial" style="font-size: 12px; text-transform:capitalize;">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="createManagerLastname" style="font-size: 12px;">Last Name</label>
                            <input type="text" class="form-control form-control-sm" id="createManagerLastname" name="lastname" style="font-size: 12px; text-transform:capitalize;" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="createManagerGender" style="font-size: 12px;">Gender</label>
                            <select class="form-control form-control-sm" id="createManagerGender" name="gender" style="font-size: 12px; text-transform:capitalize;" required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm xhire-secondary" data-dismiss="modal" style="font-size: 12px;">
                        <i class="fas fa-circle-xmark"></i> Close
                    </button>
                    <button type="submit" class="btn btn-sm xhire-astros" style="font-size: 12px;">
                        <i class="fas fa-circle-check"></i> Create Record
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Update Manager Modal -->
<div class="modal fade" id="updateManagerModal" tabindex="-1" role="dialog" aria-labelledby="updateManagerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="updateManagerForm" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateManagerModalLabel" style="font-size: 12px;">Information Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="updateManagerId" name="manager_id">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="updateManagerFirstname" style="font-size: 12px;">First Name</label>
                            <input type="text" class="form-control form-control-sm" id="updateManagerFirstname" name="firstname" style="font-size: 12px; text-transform:capitalize;" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="updateManagerMiddleInitial" style="font-size: 12px;">Middle Initial</label>
                            <input type="text" class="form-control form-control-sm" id="updateManagerMiddleInitial" name="middle_initial" style="font-size: 12px; text-transform:capitalize;">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="updateManagerLastname" style="font-size: 12px;">Last Name</label>
                            <input type="text" class="form-control form-control-sm" id="updateManagerLastname" name="lastname" style="font-size: 12px; text-transform:capitalize;" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="updateManagerGender" style="font-size: 12px;">Gender</label>
                            <select class="form-control form-control-sm" id="updateManagerGender" name="gender" style="font-size: 12px; text-transform:capitalize;" required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm xhire-secondary" data-dismiss="modal" style="font-size: 12px;">
                        <i class="fas fa-circle-xmark"></i> Close
                    </button>
                    <button type="button" class="btn btn-sm xhire-info" onclick="submitUpdateForm()" style="font-size: 12px;">
                        <i class="fas fa-pen-nib"></i> Update Record
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Records Modal -->
<div class="modal fade" id="viewManagerModal" tabindex="-1" role="dialog" aria-labelledby="viewManagerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewManagerModalLabel" style="font-size:12px;">Manager Records</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="managerDetailsForm">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="managerFirstName" style="font-size:12px;">First Name</label>
                            <input type="text" class="form-control form-control-sm" id="managerFirstName" name="managerFirstName" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="managerMiddleInitial" style="font-size:12px;">Middle Initial</label>
                            <input type="text" class="form-control form-control-sm" id="managerMiddleInitial" name="managerMiddleInitial" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="managerLastName" style="font-size:12px;">Last Name</label>
                            <input type="text" class="form-control form-control-sm" id="managerLastName" name="managerLastName" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="managerGender" style="font-size:12px;">Gender</label>
                            <input type="text" class="form-control form-control-sm" id="managerGender" name="managerGender" readonly>
                        </div>
                    </div>
                </form>
                <br>
                <h5 style="font-size:12px; font-weight: bold;">Sales Agents Managed:</h5>
                <table id="agentsTables" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Agent ID</th>
                            <th>First Name</th>
                            <th>Middle Initial</th>
                            <th>Last Name</th>
                            <th>Gender</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Sales agents will be loaded here -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal" style="font-size:12px;">Close</button>
            </div>
        </div>
    </div>
</div>
