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

    // Fetch the category data from the database based on the provided category_id
    $sql = "SELECT * FROM categories WHERE category_id = $category_id";
    $result = mysqli_query($conn, $sql);

    // Check if the category exists in the database
    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        // You can use the category data here to pre-populate the edit form fields
        $category_name = $row['category_name'];
    } else {
        // If the category does not exist, redirect back to the categories page
        header("Location: category.php");
        exit();
    }
} else {
    // If no category_id is provided, redirect back to the categories page
    header("Location: category.php");
    exit();
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Category - Inventory Management System</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <!-- External CSS -->
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <?php include 'navbar.php'; ?>

  <div class="container mt-4">
    <h2>Edit Category</h2>
    <form action="update_category.php" method="post">
      <input type="hidden" name="category_id" value="<?php echo $category_id; ?>">
      <div class="mb-3">
        <label for="category_name" class="form-label">Category Name</label>
        <input type="text" name="category_name" id="category_name" class="form-control" value="<?php echo $category_name; ?>" required>
      </div>
      <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
  </div>

  <!-- Bootstrap JS and dependencies -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
