<?php
// Start the session to access session variables
session_start();

// Check if the user is authenticated (logged in)
if (!isset($_SESSION["authenticated"]) || $_SESSION["authenticated"] !== true) {
    // If the user is not authenticated, redirect back to the login page
    header("Location: login.php");
    exit();
}

// Replace this with your database connection code
$host = "localhost";
$username = "root";
$password = "";
$database = "inventory";

$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Pagination variables
$itemsPerPage = 10; // Number of items to display per page
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Get the current page number

// Calculate the offset for the SQL query
$offset = ($page - 1) * $itemsPerPage;

// Filter variables
$filterStatus = isset($_GET['status']) ? $_GET['status'] : ''; // Get the filter status
$filterCategory = isset($_GET['category']) ? $_GET['category'] : ''; // Get the filter category

// Build the SQL query
$sql = "SELECT p.product_id, p.product_name, p.product_quantity, c.category_name 
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.category_id";

// Apply filters
if ($filterStatus === 'available') {
    $sql .= " WHERE p.product_quantity > 0";
} elseif ($filterStatus === 'outofstock') {
    $sql .= " WHERE p.product_quantity = 0";
}

if (!empty($filterCategory)) {
    $sql .= " AND p.category_id = $filterCategory";
}

$sql .= " LIMIT $offset, $itemsPerPage"; // Add pagination limits to the query

$result = mysqli_query($conn, $sql);

// Count the total number of products for pagination
$countSql = "SELECT COUNT(*) AS total FROM products";
$countResult = mysqli_query($conn, $countSql);
$totalProducts = mysqli_fetch_assoc($countResult)['total'];
$totalPages = ceil($totalProducts / $itemsPerPage);

// Fetch the categories for the dropdown filter
$categorySql = "SELECT * FROM categories";
$categoryResult = mysqli_query($conn, $categorySql);

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management System - Product Status</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- External CSS -->
    <link rel="stylesheet" href="styles.css">
</head>

<style type="text/css">
    .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
    color: #495057;
    background-color: #dc0b80;
    border-color: #dee2e6 #dee2e6 #fff;
}
</style>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-4">
        <!-- Menu Tabs -->
        <ul class="nav nav-tabs mb-3">
            <li class="nav-item" >
                <a class="nav-link active" href="#productStatus" data-bs-toggle="tab">Product Status</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#graph" data-bs-toggle="tab">Graph</a>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content">
            <div class="tab-pane fade show active" id="productStatus">
                <?php include 'product_status.php'; ?>
            </div>
            <div class="tab-pane fade" id="graph">
                <?php include 'graph.php'; ?>
            </div>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
