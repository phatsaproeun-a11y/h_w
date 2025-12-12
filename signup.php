<?php
session_start();

include("connection.php");
include("functions.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $user_name  = trim($_POST['user_name']);
    $password   = trim($_POST['password']);
    $student_id = trim($_POST['student_id']);
    $telephone  = trim($_POST['telephone']);
    $email      = trim($_POST['email']);

    // Validate required fields
    if (!empty($user_name) && !empty($password) && !empty($email)) {

        // Generate user ID
        $user_id = random_num(20);

        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepared statement
        $query = "INSERT INTO login (user_id, user_name, password, student_id, telephone, email)
                  VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($con, $query);

        if (!$stmt) {
            die("Statement Prepare Failed: " . mysqli_error($con));
        }

        mysqli_stmt_bind_param(
            $stmt,
            "ssssss",
            $user_id,
            $user_name,
            $hashed_password,
            $student_id,
            $telephone,
            $email
        );

        if (!mysqli_stmt_execute($stmt)) {
            die("Database Error: " . mysqli_error($con));
        }

        header("Location: login.php");
        exit;

    } else {
        echo "Please enter all required information!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>

<style>
*{
    margin:0;
    padding:0;
    font-family: Arial;
}
body{
    background:#f2f2f2;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.container{
    width:350px;
    border-radius:25px;
    overflow:hidden;
    box-shadow:0 0 15px rgba(0,0,0,0.2);
}

.top-section{
    background: linear-gradient(180deg, #c86ffc, #b15afd, #8e4bf3, #6bc8f8);
    padding:70px;
    text-align:left;
    color:white;
}

.input-box{
    width:100%;
    background:white;
    border:none;
    outline:none;
    padding:13px 18px;
    margin:10px 0;
    border-radius:30px;
    font-size:15px;
}

.signup-btn{
    width:100%;
    padding:12px;
    background:#8e4bf3;
    color:white;
    border:none;
    border-radius:25px;
    margin-top:10px;
    font-size:16px;
    cursor:pointer;
}

.bottom-section{
    background:white;
    padding:25px;
    text-align:center;
}

.or-text{
    margin:15px 0;
    font-weight:600;
    color:#333;
}
</style>

</head>
<body>

<div class="container">

    <div class="top-section">
        <h2 style="text-align:center">Sign up</h2><br>

        <form method="post">

            Username*: <input class="input-box" type="text" name="user_name" placeholder="Name" required>
            Password*: <input class="input-box" type="password" name="password" placeholder="Password" required>
            Student ID*: <input class="input-box" type="text" name="student_id" placeholder="Student ID" required>
            Telephone: <input class="input-box" type="text" name="telephone" placeholder="Telephone">
            Email*: <input class="input-box" type="email" name="email" placeholder="Email" required>

            <!-- Correct Submit Button -->
            <button class="signup-btn" type="submit">Sign up</button>

        </form>
    </div>

    <div class="bottom-section">
        <div class="or-text">OR</div>
        <p style="margin-top:15px;">
            Already have an account?
            <a href="login.php">Login</a>
        </p>
    </div>

</div>

</body>
</html>
