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

// Check if the product_id parameter is provided in the URL
if (!isset($_GET["product_id"]) || empty($_GET["product_id"])) {
    // If product_id is not provided, redirect back to product.php
    header("Location: product.php");
    exit();
}

// Get the product_id from the URL parameter
$product_id = $_GET["product_id"];

// Delete product data from the database based on the product_id
$sql = "DELETE FROM products WHERE product_id = '$product_id'";

if (mysqli_query($conn, $sql)) {
    // Redirect to product.php after successful deletion
    header("Location: product.php");
    exit();
} else {
    // Handle error, if any
    echo "Error: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>
