<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 400px;
            max-width: 90%;
            text-align: center;
        }
        input[type="text"], input[type="password"], input[type="number"], select, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #28a745;
            color: white;
            padding: 12px;
            width: 100%;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        a {
            text-decoration: none;
            color: #007bff;
        }
        h2 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
    <p>Your role: <?php echo htmlspecialchars($_SESSION['role']); ?></p>
    <p>You have successfully logged in.</p>

    <ul>
        <!-- Shared by all roles -->
        <li><a href="submit_loss.php">Submit a Loss Report</a></li>
        <li><a href="view_reports.php">View My Loss Reports</a></li>
        <li><a href="view_catalog.php">View Product Catalog</a></li>

        <!-- Researcher only -->
        <?php if ($_SESSION['role'] === 'researcher'): ?>
            <li><a href="add_product.php">Add Product to Catalog</a></li>
        <?php endif; ?>

        <!-- Admin only -->
        <?php if ($_SESSION['role'] === 'admin'): ?>
            <li><a href="user_management.php">Manage Users</a></li>
            <li><a href="system_logs.php">System Logs</a></li>
        <?php endif; ?>

        <li><a href="logout.php">Logout</a></li>
    </ul>
</div>
</body>
</html>
