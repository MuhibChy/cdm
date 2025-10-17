<?php
include 'conn.php';

if (isset($_POST['manager_id'])) {
    $manager_id = $_POST['manager_id'];
    $sql = "SELECT * FROM sales_agents WHERE manager_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $manager_id);
    $stmt->execute();
    $result = $stmt->get_result();
    echo '<option value="">Select Sales Agent</option>';
    while ($row = $result->fetch_assoc()) {
        echo "<option value='".$row['agent_id']."'>".$row['firstname']." ".$row['lastname']."</option>";
    }
}
?>
