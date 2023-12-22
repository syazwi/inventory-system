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

// Check if the category_id is provided in the query parameter
if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];

    // Delete the category from the database based on the provided category_id
    $sql = "DELETE FROM categories WHERE category_id = $category_id";
    if (mysqli_query($conn, $sql)) {
        // If the category is deleted successfully, redirect back to the categories page
        header("Location: category.php");
        exit();
    } else {
        // If there's an error in deleting the category, display an error message
        echo "Error deleting category: " . mysqli_error($conn);
    }
} else {
    // If no category_id is provided, redirect back to the categories page
    header("Location: category.php");
    exit();
}

// Close the database connection
mysqli_close($conn);
?>
