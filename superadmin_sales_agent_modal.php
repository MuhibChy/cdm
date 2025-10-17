<!-- Create Agent Modal -->
<div class="modal fade" id="createAgentModal" tabindex="-1" role="dialog" aria-labelledby="createAgentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="createAgentForm" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="createAgentModalLabel" style="font-size: 12px;">Agent Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="firstname" style="font-size: 12px;">First Name</label>
                            <input type="text" class="form-control form-control-sm" id="firstname" name="firstname" style="font-size: 12px; text-transform: capitalize;" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="middle_initial" style="font-size: 12px;">Middle Initial</label>
                            <input type="text" class="form-control form-control-sm" id="middle_initial" name="middle_initial" style="font-size: 12px; text-transform: capitalize;">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="lastname" style="font-size: 12px;">Last Name</label>
                            <input type="text" class="form-control form-control-sm" id="lastname" name="lastname" style="font-size: 12px; text-transform: capitalize;" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="gender" style="font-size: 12px;">Gender</label>
                            <select class="form-control form-control-sm" id="gender" name="gender" style="font-size: 12px; text-transform: capitalize;" required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="manager_id" style="font-size:12px;">Sales Manager</label>
                            <select class="form-control form-control-sm" id="manager_id" name="manager_id" style="font-size: 12px; text-transform: capitalize;" required>
                                <?php
                                $stmt = $conn->prepare("SELECT * FROM sales_managers");
                                $stmt->execute();
                                $result = $stmt->get_result();
                                if ($result->num_rows > 0) {
                                    while ($manager = $result->fetch_assoc()) {
                                        $manager_id = htmlspecialchars($manager['manager_id']);
                                        $manager_firstname = htmlspecialchars($manager['firstname']);
                                        $manager_lastname = htmlspecialchars($manager['lastname']);
                                        echo "<option value='{$manager_id}'>{$manager_firstname} {$manager_lastname}</option>";
                                    }
                                } else {
                                    echo "<option value=''>No managers found</option>";
                                }
                                $stmt->close();
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm xhire-secondary" data-dismiss="modal" style="font-size: 12px;"><i class="fas fa-circle-xmark"></i> Close</button>
                    <button type="submit" class="btn btn-sm xhire-astros" style="font-size: 12px;"><i class="fas fa-circle-check"></i> Create Record</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Update Agent Modal -->
<div class="modal fade" id="updateAgentModal" tabindex="-1" role="dialog" aria-labelledby="updateAgentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="updateAgentForm" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateAgentModalLabel" style="font-size: 12px;">Agent Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="updateAgentId" name="agent_id">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="updateFirstname" style="font-size: 12px;">First Name</label>
                            <input type="text" class="form-control form-control-sm" id="updateFirstname" name="firstname" style="font-size: 12px; text-transform: capitalize;" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="updateMiddleInitial" style="font-size: 12px;">Middle Initial</label>
                            <input type="text" class="form-control form-control-sm" id="updateMiddleInitial" name="middle_initial" style="font-size: 12px; text-transform: capitalize;">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="updateLastname" style="font-size: 12px;">Last Name</label>
                            <input type="text" class="form-control form-control-sm" id="updateLastname" name="lastname" style="font-size: 12px; text-transform: capitalize;" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="updateGender" style="font-size: 12px;">Gender</label>
                            <select class="form-control form-control-sm" id="updateGender" name="gender" style="font-size: 12px; text-transform: capitalize;" required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="updateManagerId" style="font-size:12px;">Sales Manager</label>
                            <select class="form-control form-control-sm" id="updateManagerId" name="manager_id" style="font-size: 12px; text-transform: capitalize;">
                                <?php
                                $stmt = $conn->prepare("SELECT * FROM sales_managers");
                                $stmt->execute();
                                $result = $stmt->get_result();
                                if ($result->num_rows > 0) {
                                    while ($manager = $result->fetch_assoc()) {
                                        $manager_id = htmlspecialchars($manager['manager_id']);
                                        $manager_firstname = htmlspecialchars($manager['firstname']);
                                        $manager_lastname = htmlspecialchars($manager['lastname']);
                                        echo "<option value='{$manager_id}'>{$manager_firstname} {$manager_lastname}</option>";
                                    }
                                } else {
                                    echo "<option value=''>No managers found</option>";
                                }
                                $stmt->close();
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm xhire-secondary" data-dismiss="modal" style="font-size: 12px;"><i class="fas fa-circle-xmark"></i> Close</button>
                    <button type="button" class="btn btn-sm xhire-info" onclick="submitUpdateForm()" style="font-size: 12px;"><i class="fas fa-circle-check"></i> Update Record</button>
                </div>
            </form>
        </div>
    </div>
</div>