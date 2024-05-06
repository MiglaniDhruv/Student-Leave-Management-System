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
        <div class="heading" id="leave-approval">Leaves History</div>
        <div id="leave-container">
            <h2 class="leave-head" id="container-head">Leaves</h2>
            <a class="logout-btn" name="logout-btn" href="index.php">Logout</a>
        </div>
    </div>

    <div class="enrollment-form">
        <form method="post">
            <label for="enrollment_number">Enter Enrollment Number:</label>
            <input type="text" id="enrollment_number" name="enrollment_number" required>
            <button type="submit" name="submit_enrollment">Submit</button>
        </form>
    </div>

    <?php
    require("connection.php");
    $enrollment_number = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_enrollment'])) {
        $enrollment_number = $_POST['enrollment_number'];
    }
    if (!empty($enrollment_number)) {
        $sql = "SELECT * FROM reason WHERE enrollment_number = '$enrollment_number'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<div class='all-leaves-container' id='all-leaves-container'>";
            echo "<table class='table'>";
            echo "<tr class='table-headings' id='table-headings'>";
            echo "<th class='head'>Enrollment No.</th>";
            echo "<th class='head'>Leave Type</th>";
            echo "<th class='head'>Start Date</th>";
            echo "<th class='head'>End Date</th>";
            echo "<th class='head'>Reason</th>";
            echo "<th class='head'>Status</th>";
            echo "</tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["enrollment_number"] . "</td>";
                echo "<td>" . $row["leave_type"] . "</td>";
                echo "<td>" . $row["start_date"] . "</td>";
                echo "<td>" . $row["end_date"] . "</td>";
                echo "<td>" . $row["reason"] . "</td>";
                echo "<td>" . $row["status"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "</div>";
        } else {
            echo "<p>No leaves found for enrollment number: $enrollment_number</p>";
        }
    }

    $conn->close();
    ?>

    <footer class="footer">
        <p>Group Project | Topic - Leave Management System | Frontend for leave management</p><br>
    </footer>

</body>

</html>