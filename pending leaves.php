<?php
require("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
    $status = $_POST['status'];
    $enrollment_number = $_POST['enrollment_number'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    $update_sql = "UPDATE reason SET status = '$status', start_date = '$start_date', end_date = '$end_date' WHERE enrollment_number = '$enrollment_number'";
    if ($conn->query($update_sql) === TRUE) {
        echo "Data updated successfully";
    } else {
        echo "Error updating data: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="teach2.css">
    <title>Leave Management System</title>
</head>

<body>
    <div class="admin-leaves" id="admin-leaves">
        <div class="heading" id="leave-approval">Approval For Leaves</div>
        <div id="leave-container">
            <h2 class="leave-head" id="container-head">Leaves</h2>
            <a class="logout-btn" name="logout-btn" href="index.php">Logout</a>
        </div>
    </div>

    <div class="all-leaves-container" id="all-leaves-container">
        <table class="table">
            <tr class="table-headings" id="table-headings">
                <th class="head">Enrollment No.</th>
                <th class="head">Leave Type</th>
                <th class="head">Start Date</th>
                <th class="head">End Date</th>
                <th class="head">Reason</th>
                <th class="head">Status</th>
                <th class="head">Action</th>
            </tr>
            <?php
            $sql = "SELECT * FROM reason WHERE status = 'Pending'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["enrollment_number"] . "</td>";
                    echo "<td>" . $row["leave_type"] . "</td>";
                    echo "<td>";
                    echo "<form method='POST'>";
                    echo "<input type='hidden' name='enrollment_number' value='" . $row["enrollment_number"] . "'>";
                    echo "<input type='date' name='start_date' value='" . $row["start_date"] . "'>";
                    echo "</td>";
                    echo "<td>";
                    echo "<input type='date' name='end_date' value='" . $row["end_date"] . "'>";
                    echo "</td>";
                    echo "<td>" . $row["reason"] . "</td>";
                    echo "<td>";
                    echo "<select name='status'>";
                    echo "<option value='Pending' " . ($row["status"] == "Pending" ? "selected" : "") . ">Pending</option>";
                    echo "<option value='Accepted' " . ($row["status"] == "Accepted" ? "selected" : "") . ">Accepted</option>";
                    echo "<option value='Rejected' " . ($row["status"] == "Rejected" ? "selected" : "") . ">Rejected</option>";
                    echo "</select>";
                    echo "</td>";
                    echo "<td><button type='submit' name='update_status'>Update</button></td>";
                    echo "</form>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>0 results</td></tr>";
            }

            $conn->close();
            ?>
        </table>
    </div>

    <footer class="footer">
        <p>Group Project | Topic - Leave Management System | Frontend for leave management</p><br>
    </footer>

</body>

</html>