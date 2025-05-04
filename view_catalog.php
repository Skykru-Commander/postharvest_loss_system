<?php
session_start();
include 'db_config.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// pagination settings
$items_per_page = 10;
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($current_page < 1) $current_page = 1;
$offset = ($current_page - 1) * $items_per_page;

// total number of products
$count_result = $conn->query("SELECT COUNT(*) AS total FROM products");
$total_rows = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $items_per_page);

// paginated products
$sql = "SELECT product_name, category, description, sustainability_rating, source_provider, recommended_by, date_added 
        FROM products 
        ORDER BY date_added DESC 
        LIMIT $items_per_page OFFSET $offset";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sustainable Product Catalog</title>
</head>
<body>
    <h2>Sustainable Product Catalog</h2>

    <table border="1" cellpadding="8">
        <tr>
            <th>Product Name</th>
            <th>Category</th>
            <th>Description</th>
            <th>Sustainability Rating</th>
            <th>Source / Provider</th>
            <th>Recommended By</th>
            <th>Date Added</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo htmlspecialchars($row['product_name']); ?></td>
            <td><?php echo htmlspecialchars($row['category']); ?></td>
            <td><?php echo htmlspecialchars($row['description']); ?></td>
            <td><?php echo htmlspecialchars($row['sustainability_rating']); ?></td>
            <td><?php echo htmlspecialchars($row['source_provider']); ?></td>
            <td><?php echo htmlspecialchars($row['recommended_by']); ?></td>
            <td><?php echo htmlspecialchars($row['date_added']); ?></td>
        </tr>
        <?php } ?>
    </table>

    <br>

    <div>
        <?php if ($current_page > 1): ?>
            <a href="?page=<?php echo $current_page - 1; ?>">← Previous</a>
        <?php endif; ?>

        <?php for ($i = max(1, $current_page - 2); $i <= min($total_pages, $current_page + 2); $i++): ?>
            <?php if ($i === $current_page): ?>
                <strong>[<?php echo $i; ?>]</strong>
            <?php else: ?>
                <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            <?php endif; ?>
        <?php endfor; ?>

        <?php if ($current_page < $total_pages): ?>
            <a href="?page=<?php echo $current_page + 1; ?>">Next →</a>
        <?php endif; ?>
    </div>

    <br>
    <p><a href="dashboard.php">← Back to Dashboard</a></p>
</body>
</html>

<?php
$conn->close();
?>
