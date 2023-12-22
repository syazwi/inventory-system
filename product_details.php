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

// Check if the product_id is provided in the URL
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Fetch the product details from the database
    $sql = "SELECT * FROM products WHERE product_id = $product_id";
    $result = mysqli_query($conn, $sql);
    $product = mysqli_fetch_assoc($result);

    // Check if the product exists
    if (!$product) {
        // If the product is not found, redirect back to the product list page
        header("Location: product.php");
        exit();
    }
} else {
    // If the product_id is not provided, redirect back to the product list page
    header("Location: product.php");
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
  <title>Inventory Management System - Product Details</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <!-- External CSS -->
  <link rel="stylesheet" href="styles.css">
  <style>
    body {
      background-color: #ececec;
    }

    .card {
      margin-top: 20px;
      border: 1px solid #dc0b80;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    .card-header {
      background-color: #dc0b80;
      color: #ffffff;
    }

    .card-body {
      padding: 20px;
    }

    .product-image {
      width: 200px;
      height: 200px;
      object-fit: cover;
    }

    .btn-primary {
      background-color: #03aab5;
      border-color: #03aab5;
    }
  </style>
</head>
<body>
  <?php include 'navbar.php'; ?>

  <div class="container mt-4">
    <h2>Product Details</h2>
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-md-4">
            <img src="product_images/<?php echo $product['product_image']; ?>" alt="Product Image" class="product-image">
          </div>
          <div class="col-md-8">
            <h4><?php echo $product['product_name']; ?></h4>
            <p><strong>Product ID:</strong> <?php echo $product['product_id']; ?></p>
            <p><strong>Description:</strong> <?php echo $product['product_description']; ?></p>
            <p><strong>Quantity:</strong> <?php echo $product['product_quantity']; ?></p>
            <p><strong>Price:</strong> $<?php echo $product['product_price']; ?></p>
            <p><strong>Date Added:</strong> <?php echo $product['date_added']; ?></p>
            <p><strong>Last Updated:</strong> <?php echo $product['last_updated']; ?></p>
          </div>
        </div>
      </div>
    </div>
    <a href="product.php" class="btn btn-primary mt-3">Back to Product List</a>
  </div>

  <!-- Bootstrap JS and dependencies -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
