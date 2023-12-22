<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inventory";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the input values from the form
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Validate username and password inputs (You should perform additional validation)
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    // Query to check if the username and password match
    $sql = "SELECT * FROM login WHERE username = '$username' AND password = '$password'";

    // Execute the query
    $result = mysqli_query($conn, $sql);

    // Check if any row is returned
    if (mysqli_num_rows($result) == 1) {
        // Login successful, set the session variable and redirect to dashboard
        session_start();
        $_SESSION["authenticated"] = true;
        header("Location: dashboard.php");
        exit();
    } else {
        // Login failed, redirect back to the login page with an error message
        header("Location: login.php?error=1");
        exit();
    }
} else {
    // If the form is not submitted, redirect back to the login page
    header("Location: login.php");
    exit();
}
?>
