<?php
require("connection.php");

if (isset($_POST['submit'])) {
    $userType = $_POST['userType'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM loginas WHERE Login_as = ? AND username = ? AND pass = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sss", $userType, $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            if ($userType == "student") {
                header("Location: http://localhost/try%20lms/studentlogin.php");
                exit();
            } elseif ($userType == "teacher") {
                header("Location: http://localhost/try%20lms/teacherlogin.html");
                exit();
            }
        } else {
            echo "Incorrect Username or Password";
            header("Location: http://localhost/leave/login.php");
            exit();
        }
    } else {
        die('Error in preparing SQL statement: ' . $conn->error);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="try1.css">
</head>

<body>
    <div class="login-container">
        <h1>Login</h1><br>
        <form method="POST">
            <label for="userType">Login As:</label>
            <select id="userType" name="userType" required>
                <option value="">Select User Type</option>
                <option value="student">Student</option>
                <option value="teacher">Teacher</option>
            </select>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" name='submit'>Login</button>
        </form>
    </div>
</body>

</html>