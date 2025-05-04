<?php
session_start();
include 'db_config.php';

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $hashed_password, $role);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "User not found.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Postharvest Loss System - Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .login-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 25px;
            background-color: #fff;
            box-shadow: 0px 0px 10px #ccc;
            border-radius: 10px;
        }
        h2 {
            margin-top: 10px;
        }
        input[type="text"], input[type="password"] {
            width: 90%;
            padding: 10px;
            margin: 8px 0;
        }
        input[type="submit"] {
            padding: 10px 20px;
            margin-top: 10px;
        }
        .error {
            color: red;
        }
        img.header-img {
            max-width: 100%;
            height: auto;
            border-radius: 10px 10px 0 0;
        }
        .link {
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <img src="images/header.png" alt="Header" class="header-img">
        <h2>Postharvest Loss Reporting System</h2>

        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

        <form method="POST" action="">
            <label>Username:</label><br>
            <input type="text" name="username" required><br><br>

            <label>Password:</label><br>
            <input type="password" name="password" required><br><br>

            <input type="submit" name="login" value="Login">
        </form>

        <div class="link">
            <p>Don't have an account? <a href="register.php">Register here</a>.</p>
        </div>
    </div>
</body>
</html>
