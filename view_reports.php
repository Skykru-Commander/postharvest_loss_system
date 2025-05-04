<?php
session_start();
include 'db_config.php';

// Check user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role']; 
$search = '';
$filter_sql = '';
$params = [];
$param_types = '';
$query_role_filter = '';

// handle search/filter
if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
    $search = trim($_GET['search']);
    $filter_sql = " (crop_type LIKE CONCAT('%', ?, '%') OR loss_stage LIKE CONCAT('%', ?, '%') OR loss_reason LIKE CONCAT('%', ?, '%'))";
    $params[] = $search;
    $params[] = $search;
    $params[] = $search;
    $param_types .= 'sss';
}

// restrict farmers to own record
if ($role === 'farmer') {
    $query_role_filter = "user_id = ?";
    array_unshift($params, $user_id);      
    $param_types = 'i' . $param_types;     
}

// final where clause
$where_clause = '';
if (!empty($filter_sql) && !empty($query_role_filter)) {
    $where_clause = "WHERE $query_role_filter AND $filter_sql";
} elseif (!empty($filter_sql)) {
    $where_clause = "WHERE $filter_sql";
} elseif (!empty($query_role_filter)) {
    $where_clause = "WHERE $query_role_filter";
}

// Build, execute SQL query
$sql = "SELECT crop_type, loss_stage, loss_amount, loss_reason, date_submitted 
        FROM loss_reports 
        $where_clause";
$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($param_types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Loss Reports</title>
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
    <h2>My Loss Reports</h2>

    <form method="GET" action="">
        <label>Search reports:</label>
        <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>">
        <input type="submit" value="Search">
    </form>

    <br>
    <table border="1" cellpadding="8">
        <tr>
            <th>Crop Type</th>
            <th>Loss Stage</th>
            <th>Loss Amount</th>
            <th>Reason</th>
            <th>Date Submitted</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo htmlspecialchars($row['crop_type']); ?></td>
            <td><?php echo htmlspecialchars($row['loss_stage']); ?></td>
            <td><?php echo htmlspecialchars($row['loss_amount']); ?></td>
            <td><?php echo htmlspecialchars($row['loss_reason']); ?></td>
            <td><?php echo htmlspecialchars($row['date_submitted']); ?></td>
        </tr>
        <?php } ?>
    </table>

    <br>
    <p><a href="dashboard.php">Back to Dashboard</a></p>
</body>
</div>
</html>

<?php
$stmt->close();
$conn->close();
?>