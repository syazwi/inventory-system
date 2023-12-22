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

// Fetch product data from the database based on the product_id
$sql = "SELECT * FROM products WHERE product_id = '$product_id'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) === 1) {
    // Product found, fetch product details
    $row = mysqli_fetch_assoc($result);
} else {
    // Product not found, redirect back to product.php
    header("Location: product.php");
    exit();
}

// Fetch categories from the database
$sql_categories = "SELECT * FROM categories";
$result_categories = mysqli_query($conn, $sql_categories);

// Fetch manufacturers from the database
$sql_manufacturers = "SELECT * FROM manufacturers";
$result_manufacturers = mysqli_query($conn, $sql_manufacturers);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get data from the form
    $product_name = $_POST["product_name"];
    $product_description = $_POST["product_description"];
    $product_quantity = $_POST["product_quantity"];
    $product_price = $_POST["product_price"];
    $category_id = $_POST["category_id"];
    $manufacturer_id = $_POST["manufacturer_id"];
    $product_image = $_FILES["product_image"]["name"]; // Assuming file input name is "product_image"

    // Upload product image to server
    if (!empty($product_image)) {
        $target_dir = "product_images/"; // Directory to store uploaded images
        $target_file = $target_dir . basename($product_image);
        move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file);
    } else {
        // If no new image is uploaded, retain the existing image in the database
        $product_image = $row["product_image"];
    }

    // Update product data in the database
    $sql = "UPDATE products SET
                product_name = '$product_name',
                product_description = '$product_description',
                product_quantity = '$product_quantity',
                product_price = '$product_price',
                category_id = '$category_id',
                manufacturer_id = '$manufacturer_id',
                product_image = '$product_image'
            WHERE product_id = '$product_id'";

    if (mysqli_query($conn, $sql)) {
        // Redirect to product.php after successful update
        header("Location: product.php");
        exit();
    } else {
        // Handle error, if any
        echo "Error: " . mysqli_error($conn);
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
    <title>Edit Product - Inventory Management System</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- External CSS -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-4">
        <h2>Edit Product</h2>
        <form action="<?php echo $_SERVER['PHP_SELF'] . '?product_id=' . $product_id; ?>" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="product_name" class="form-label">Product Name</label>
                <input type="text" name="product_name" id="product_name" class="form-control" value="<?php echo $row['product_name']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="product_description" class="form-label">Product Description</label>
                <textarea name="product_description" id="product_description" class="form-control" rows="5" required><?php echo $row['product_description']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="product_quantity" class="form-label">Product Quantity</label>
                <input type="number" name="product_quantity" id="product_quantity" class="form-control" value="<?php echo $row['product_quantity']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="product_price" class="form-label">Product Price</label>
                <input type="number" step="0.01" name="product_price" id="product_price" class="form-control" value="<?php echo $row['product_price']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="category_id" class="form-label">Category</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    <option value="">Select Category</option>
                    <?php while ($category = mysqli_fetch_assoc($result_categories)) { ?>
                        <option value="<?php echo $category['category_id']; ?>" <?php if ($row['category_id'] == $category['category_id']) echo 'selected'; ?>>
                            <?php echo $category['category_name']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="manufacturer_id" class="form-label">Manufacturer</label>
                <select name="manufacturer_id" id="manufacturer_id" class="form-control" required>
                    <option value="">Select Manufacturer</option>
                    <?php while ($manufacturer = mysqli_fetch_assoc($result_manufacturers)) { ?>
                        <option value="<?php echo $manufacturer['manufacturer_id']; ?>" <?php if ($row['manufacturer_id'] == $manufacturer['manufacturer_id']) echo 'selected'; ?>>
                            <?php echo $manufacturer['manufacturer_name']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="product_image" class="form-label">Product Image</label>
                <input type="file" name="product_image" id="product_image" class="form-control" accept="image/*">
                <img src="product_images/<?php echo $row['product_image']; ?>" alt="Product Image" class="mt-2" style="max-height: 200px;">
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Update Product</button>
                <a href="product.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
    

        <?php include 'footer.php'; ?>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
