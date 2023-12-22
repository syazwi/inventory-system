<?php
session_start();

if (!isset($_SESSION["authenticated"]) || $_SESSION["authenticated"] !== true) {
    header("Location: login.php");
    exit();
}

$host = "localhost";
$username = "root";
$password = "";
$database = "inventory";

$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    echo "Form submitted!<br>";
    print_r($_POST); // Debug: Print form data

    // Get form data
    $category_id = $_POST["category_id"];
    $category_name = $_POST["category_name"];

    // Debug: Print form data
    echo "Category ID: " . $category_id . "<br>";
    echo "Category Name: " . $category_name . "<br>";

    // Update category in the database
    $sql = "UPDATE categories SET category_name = '$category_name' WHERE category_id = $category_id";

    echo "SQL Query: " . $sql . "<br>";

    if (mysqli_query($conn, $sql)) {
        echo "Category updated successfully!";
        header("Location: category.php"); // Redirect to category.php after successful update
        exit();
    } else {
        echo "Error updating category: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
