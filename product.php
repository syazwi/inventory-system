<!DOCTYPE html>
<html>

<head>
    <title>Product List</title>
    <!-- Add your CSS and other meta tags here -->
</head>

<style type="text/css">
    a.btn.btn-success.mb-3 {
    background-color: #E00A81!important;
    border: 0px;
  border-radius: 0px;
}
</style>
<body>
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

    // Fetch the products from the database
    $sql = "SELECT * FROM products";
    $result = mysqli_query($conn, $sql);
    ?>

    <?php include 'header.php'; ?>

    <h2>Product List</h2>
    <!-- Link to the create_product.php page -->
    <a href="create_product.php" class="btn btn-success mb-3">Create New Product</a>

    <?php include 'product_table.php'; ?>

</body>

</html>
