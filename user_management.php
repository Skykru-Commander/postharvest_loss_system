<?php
session_start();
include 'db_config.php';

// admin only
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch users
$result = $conn->query("SELECT id, username, role FROM users ORDER BY id ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Management</title>
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
    <h2>User Management (Admin Only)</h2>

    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Role</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['username']); ?></td>
                <td><?php echo htmlspecialchars($row['role']); ?></td>
            </tr>
        <?php } ?>
    </table>

    <br>
    <p><a href="dashboard.php">← Back to Dashboard</a></p>
</div>
</body>
</html>

<?php
$conn->close();
?>
