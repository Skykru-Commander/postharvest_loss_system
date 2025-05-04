<?php
session_start();
include 'db_config.php';

// redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// handle form submission
if (isset($_POST['submit_loss'])) {
    $user_id = $_SESSION['user_id'];
    $crop_type = trim($_POST['crop_type']);
    $loss_stage = trim($_POST['loss_stage']);
    $loss_amount = trim($_POST['loss_amount']);
    $loss_reason = trim($_POST['loss_reason']);
    $date_submitted = date("Y-m-d");

    $stmt = $conn->prepare("INSERT INTO loss_reports (user_id, crop_type, loss_stage, loss_amount, loss_reason, date_submitted) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $user_id, $crop_type, $loss_stage, $loss_amount, $loss_reason, $date_submitted);
    
    if ($stmt->execute()) {
        $message = "Loss report submitted successfully!";
    } else {
        $message = "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Submit Loss Report</title>
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
    <h2>Loss Report Form</h2>
    <?php if (isset($message)) echo "<p>$message</p>"; ?>
    
    <form method="POST" action="">
        <label>Crop Type:</label><br>
        <input type="text" name="crop_type" required><br><br>

        <label>Loss Stage (e.g., harvesting, transport):</label><br>
        <input type="text" name="loss_stage" required><br><br>

        <label>Loss Amount (e.g., 50 kg):</label><br>
        <input type="text" name="loss_amount" required><br><br>

        <label>Reason for Loss:</label><br>
        <input type="text" name="loss_reason" required><br><br>

        <input type="submit" name="submit_loss" value="Submit Report">
    </form>

    <p><a href="dashboard.php">← Back to Dashboard</a></p>
</div>
</body>
</html>


