<?php
require('dbconn.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Library Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all">
    <link href="//fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <style>
        /* Additional CSS for toggle feature */
        .form-container {
            display: none;
        }

        .form-container.active {
            display: block;
        }

        .btn-toggle {
            cursor: pointer;
            color: #007bff;
            text-decoration: underline;
            background: none;
            border: none;
            font-size: 16px;
        }

        .btn-toggle:hover {
            text-decoration: none;
        }
    </style>
</head>

<body>

<h1 style="
        text-align: center;
        color: #ff69b4; /* Light pink */
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7); /* Adds contrast */
        padding: 20px;
        font-size: 2.5em;
        margin-top: 0;
        background: rgba(0, 0, 0, 0.6); /* Semi-transparent background */
    ">
        SHELF MASTER: LIBRARY MANAGEMENT SYSTEM
    </h1>

    <div class="container">

        <!-- Login Form -->
        <div id="loginForm" class="form-container active">
            <h2>Sign In</h2>
            <form action="index.php" method="post">
                <input type="text" Name="RollNo" placeholder="Roll Number" required>
                <input type="password" Name="Password" placeholder="Password" required>
                <div class="send-button">
                    <input type="submit" name="signin" value="Sign In">
                </div>
            </form>
            <p>Don’t have an account? <button class="btn-toggle" onclick="toggleForm()">Sign Up</button></p>
        </div>

        <!-- Signup Form -->
        <div id="signupForm" class="form-container">
            <h2>Sign Up</h2>
            <form action="index.php" method="post">
                <input type="text" Name="Name" placeholder="Name" required>
                <input type="text" Name="Email" placeholder="Email" required>
                <input type="password" Name="Password" placeholder="Password" required>
                <input type="text" Name="PhoneNumber" placeholder="Phone Number" required>
                <input type="text" Name="RollNo" placeholder="Roll Number" required>
                <div class="send-button">
                    <input type="submit" name="signup" value="Sign Up">
                </div>
            </form>
            <p>Already have an account? <button class="btn-toggle" onclick="toggleForm()">Sign In</button></p>
        </div>

    </div>

    <div class="footer w3layouts agileits">
        <p>&copy; 2024 Library Member Login. All Rights Reserved</p>
    </div>

    <script>
        // JavaScript to toggle forms
        function toggleForm() {
            const loginForm = document.getElementById('loginForm');
            const signupForm = document.getElementById('signupForm');
            loginForm.classList.toggle('active');
            signupForm.classList.toggle('active');
        }
    </script>

    <?php
    if (isset($_POST['signin'])) {
        $u = $_POST['RollNo'];
        $p = $_POST['Password'];

        $sql = "select * from LMS.user where RollNo='$u'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $x = $row['Password'];
        $y = $row['Type'];

        if (strcasecmp($x, $p) == 0 && !empty($u) && !empty($p)) {
            $_SESSION['RollNo'] = $u;

            if ($y == 'Admin')
                header('location:admin/index.php');
            else
                header('location:student/index.php');
        } else {
            echo "<script type='text/javascript'>alert('Failed to Login! Incorrect RollNo or Password')</script>";
        }
    }

    if (isset($_POST['signup'])) {
        $name = $_POST['Name'];
        $email = $_POST['Email'];
        $password = $_POST['Password'];
        $mobno = $_POST['PhoneNumber'];
        $rollno = $_POST['RollNo'];
        $type = 'Student';

        $sql = "insert into LMS.user (Name,Type,RollNo,EmailId,MobNo,Password) values ('$name','$type','$rollno','$email','$mobno','$password')";

        if ($conn->query($sql) === TRUE) {
            echo "<script type='text/javascript'>alert('Registration Successful')</script>";
        } else {
            echo "<script type='text/javascript'>alert('User Exists')</script>";
        }
    }
    ?>

</body>

</html>