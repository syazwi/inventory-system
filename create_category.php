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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the category name from the form
    $category_name = $_POST["category_name"];

    // Insert the new category into the database
    $sql = "INSERT INTO categories (category_name) VALUES ('$category_name')";
    if (mysqli_query($conn, $sql)) {
        // If the category is inserted successfully, redirect back to the categories page
        header("Location: category.php");
        exit();
    } else {
        // If there's an error in inserting the category, display an error message
        echo "Error creating category: " . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Category - Inventory Management System</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <!-- External CSS -->
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <?php include 'navbar.php'; ?>

  <div class="container mt-4">
    <h2>Create New Category</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <div class="mb-3">
        <label for="category_name" class="form-label">Category Name</label>
        <input type="text" name="category_name" id="category_name" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary">Create Category</button>
    </form>
  </div>
   <?php include 'footer.php'; ?>
  <!-- Bootstrap JS and dependencies -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
