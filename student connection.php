<?php
require("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $enrollment_number = $_POST['enrollment_number'];
    $leave_type = $_POST['leave_type'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $reason = $_POST['reason'];

    $conn = new mysqli('localhost', 'root', '', 'lms');

    if ($conn->connect_error) {
        die('Connection Failed: ' . $conn->connect_error);
    } else {
        $create_table_query = "CREATE TABLE IF NOT EXISTS reason (
                                id INT(11) AUTO_INCREMENT PRIMARY KEY,
                                enrollment_number VARCHAR(255) NOT NULL, // Add enrollment number column
                                leave_type VARCHAR(255) NOT NULL,
                                start_date DATE NOT NULL,
                                end_date DATE NOT NULL,
                                reason TEXT NOT NULL
                            )";

        if ($conn->query($create_table_query) === TRUE) {
            $sql = "INSERT INTO reason (enrollment_number, leave_type, start_date, end_date, reason) 
                    VALUES ('$enrollment_number', '$leave_type', '$start_date', '$end_date', '$reason')";

            $result = mysqli_query($conn, $sql);

            if ($result) {
                echo "New record created successfully!";
            } else {
                echo "Error: Unable to execute query. Please check your input data.<br>" . mysqli_error($conn);
            }
        } else {
            echo "Error: Unable to create table 'reason': " . $conn->error;
        }

        $conn->close();
    }
}
