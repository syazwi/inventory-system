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

// Function to sanitize user input
function sanitize_input($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

// Handle search form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and store the search term
    $search_term = sanitize_input($_POST["search"]);

    // Search for categories by name
    $sql = "SELECT * FROM categories WHERE category_name LIKE '%$search_term%'";
    $result = mysqli_query($conn, $sql);
} else {
    // Fetch all categories from the database
    $sql = "SELECT * FROM categories";
    $result = mysqli_query($conn, $sql);
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inventory Management System - Categories</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <!-- External CSS -->
  <link rel="stylesheet" href="styles.css">
</head>

<style type="text/css">
  a.btn.btn-success.mb-3 {
    background-color: #E00A81!important;
    border-radius: 0px;
    border: 0px;
}
</style>
<body>
  <?php include 'navbar.php'; ?>

  <div class="container mt-4">
    <h2>Category List</h2>
    <a href="create_category.php" class="btn btn-success mb-3">Create New Category</a>
    <!-- Search form -->
    <form class="mb-3" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <div class="input-group">
        <input type="text" name="search" class="form-control" placeholder="Search by category name">
        <button type="submit" class="btn btn-primary">Search</button>
      </div>
    </form>
    <div class="table-responsive">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>#</th>
            <th>Category Name</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          // Variable to keep track of the count
          $count = 1;

          while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
              <td><?php echo $count; ?></td>
              <td><?php echo $row['category_name']; ?></td>
              <td>
                <!-- Link to the edit_category.php page with category_id as a query parameter -->
                <a href="edit_category.php?category_id=<?php echo $row['category_id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                <!-- Link to the delete_category.php page with category_id as a query parameter -->
                <a href="delete_category.php?category_id=<?php echo $row['category_id']; ?>" class="btn btn-danger btn-sm">Delete</a>
              </td>
            </tr>
          <?php
          // Increment the count for the next row
          $count++;
          } ?>
        </tbody>
      </table>
    </div>
  </div>
   <?php include 'footer.php'; ?>
  <!-- Bootstrap JS and dependencies -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
