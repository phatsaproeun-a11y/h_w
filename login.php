<?php 
session_start();
include("connection.php");
include("functions.php");

$error = ""; // prevent undefined variable warning

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $user_name   = trim($_POST['user_name']);
    $password    = trim($_POST['password']);
    $student_id  = trim($_POST['student_id']); // KEEP INPUT because you want it in UI

    if (!empty($user_name) && !empty($password)) {

        // Secure query
        $query = "SELECT * FROM login WHERE user_name = ? LIMIT 1";
        $stmt = mysqli_prepare($con, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $user_name);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result && mysqli_num_rows($result) > 0) {

                $user_data = mysqli_fetch_assoc($result);

                // Check hashed password
                if (password_verify($password, $user_data['password'])) {

                    // Login success
                    $_SESSION['user_id'] = $user_data['user_id'];

                    header("Location: index.php");
                    exit;
                }
            }

            // Fail (username exists but password wrong OR username not found)
            $error = "Wrong username or password!";
        } else {
            $error = "Server error. Try again later.";
        }

    } else {
        $error = "Please fill all fields!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login</title>

<style>
*{
    margin: 0;
    padding: 0;
    font-family: Arial;
}
body{
    background: #f2f2f2;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}
.container{
    width: 350px;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 0 15px rgba(0,0,0,0.2);
}

.top-section{
    background: linear-gradient(180deg,#c65ffc,#9d48ff,#7d39f1);
    padding: 70px;
    color: white;
}

.input-box{
    width: 100%;
    background: white;
    border-radius: 30px;
    margin: 10px 0;
    padding: 12px 18px;
    border: none;
    outline: none;
    font-size: 15px;
}

.login-btn{
    width: 100%;
    padding: 12px;
    background: #7a39f1;
    color: white;
    border-radius: 25px;
    border: none;
    margin-top: 15px;
    cursor: pointer;
    font-size: 16px;
}

.bottom-section{
    background: white;
    padding: 25px;
    text-align: center;
}

.error-message{
    color: yellow;
    font-weight: bold;
    text-align: center;
}
</style>

</head>
<body>

<div class="container">

    <div class="top-section">
        <h2 style="text-align:center">Login</h2><br>

        <?php if (!empty($error)): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div><br>
        <?php endif; ?>

        <form method="post">
            Username*:<input class="input-box" type="text" name="user_name" placeholder="Name" required>
            Password*:<input class="input-box" type="password" name="password" placeholder="Password" required>
            Student ID*:<input class="input-box" type="text" name="student_id" placeholder="Student ID" required>

            <button class="login-btn" type="submit">Login</button>
        </form>
    </div>

    <div class="bottom-section">
        <p>OR</p>
        <p style="margin-top: 15px;">
            Don't have an account?
            <a href="signup.php">Sign up</a>
        </p>
    </div>

</div>

</body>
</html>
