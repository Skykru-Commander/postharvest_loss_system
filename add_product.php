<?php
session_start();
include 'db_config.php';

// only researcher access
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'researcher') {
    header("Location: dashboard.php"); // redirect others to dashboard
    exit();
}

// form submission
if (isset($_POST['add_product'])) {
    $product_name = trim($_POST['product_name']);
    $category = trim($_POST['category']);
    $description = trim($_POST['description']);
    $sustainability_rating = trim($_POST['sustainability_rating']);
    $source_provider = trim($_POST['source_provider']);
    $recommended_by = trim($_POST['recommended_by']);
    $date_added = date("Y-m-d");

    $stmt = $conn->prepare("INSERT INTO products 
        (product_name, category, description, sustainability_rating, source_provider, recommended_by, date_added)
        VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $product_name, $category, $description, $sustainability_rating, $source_provider, $recommended_by, $date_added);

    if ($stmt->execute()) {
        $message = "Product added successfully.";
    } else {
        $message = "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Product to Catalog</title>
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
    <h2>Add New Sustainable Product</h2>

    <?php if (isset($message)) echo "<p style='color:green;'>$message</p>"; ?>

    <form method="POST" action="">
        <label>Product Name:</label><br>
        <input type="text" name="product_name" required><br><br>

        <label>Category:</label><br>
        <input type="text" name="category" required><br><br>

        <label>Description:</label><br>
        <textarea name="description" rows="3" cols="40" required></textarea><br><br>

        <label>Sustainability Rating (1 to 5):</label><br>
        <input type="number" name="sustainability_rating" min="1" max="5" required><br><br>

        <label>Source / Provider:</label><br>
        <input type="text" name="source_provider" required><br><br>

        <label>Recommended By:</label><br>
        <input type="text" name="recommended_by" required><br><br>

        <input type="submit" name="add_product" value="Add Product">
    </form>

    <br>
    <p><a href="dashboard.php">← Back to Dashboard</a></p>
</div>
</body>
</html>

<?php
$conn->close();
?>
