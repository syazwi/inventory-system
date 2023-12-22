<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "inventory";

$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql_categories = "SELECT * FROM categories";
$result_categories = mysqli_query($conn, $sql_categories);

$sql_manufacturers = "SELECT * FROM manufacturers";
$result_manufacturers = mysqli_query($conn, $sql_manufacturers);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["add_product"])) {
        $product_name = $_POST["product_name"];
        $product_description = $_POST["product_description"];
        $product_quantity = $_POST["product_quantity"];
        $product_price = $_POST["product_price"];
        $category_id = $_POST["category_id"];
        $manufacturer_id = $_POST["manufacturer_id"];
        $product_image = $_FILES["product_image"]["name"];

        if (!empty($product_image)) {
            $target_dir = "product_images/";
            $target_file = $target_dir . basename($product_image);
            move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file);
        } else {
            $product_image = "default.jpg";
        }

        $sql_insert = "INSERT INTO products (product_name, product_description, product_quantity, product_price, category_id, manufacturer_id, product_image)
                       VALUES ('$product_name', '$product_description', '$product_quantity', '$product_price', '$category_id', '$manufacturer_id', '$product_image')";

        if (mysqli_query($conn, $sql_insert)) {
            header("Location: product.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } elseif (isset($_POST["import_csv"])) {
        if ($_FILES["csv_file"]["error"] == 0 && $_FILES["csv_file"]["type"] == "text/csv") {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["csv_file"]["name"]);

            if (move_uploaded_file($_FILES["csv_file"]["tmp_name"], $target_file)) {
                importDataFromCSV($target_file, $conn);

                header("Location: product.php");
                exit();
            } else {
                echo "Error uploading file.";
            }
        } else {
            echo "Please upload a valid CSV file.";
        }
    }
}

function importDataFromCSV($file_path, $conn)
{
    if (($handle = fopen($file_path, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $product_name = mysqli_real_escape_string($conn, $data[0]);
            $product_description = mysqli_real_escape_string($conn, $data[1]);
            $product_quantity = (int) $data[2];
            $product_price = (float) $data[3];
            $category_id = (int) $data[4];
            $manufacturer_id = (int) $data[5];
            $product_image = "default.jpg";

            $sql_insert = "INSERT INTO products (product_name, product_description, product_quantity, product_price, category_id, manufacturer_id, product_image)
                           VALUES ('$product_name', '$product_description', '$product_quantity', '$product_price', '$category_id', '$manufacturer_id', '$product_image')";

            mysqli_query($conn, $sql_insert);
        }
        fclose($handle);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Product - Inventory Management System</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- External CSS -->
    <link rel="stylesheet" href="styles.css">
</head>
<style type="text/css">
    button.btn.btn-success {
    background-color: #E00A81!important;
    border-radius: 0px;
    border: 0px;
}

button.btn.btn-primary {
    border-radius: 0;
}

a.btn.btn-secondary {
    border-radius: 0px;
}
</style>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-4">
        <h2>Create Product</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="product_name" class="form-label">Product Name</label>
                <input type="text" name="product_name" id="product_name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="product_description" class="form-label">Product Description</label>
                <textarea name="product_description" id="product_description" class="form-control" rows="5" required></textarea>
            </div>
            <div class="mb-3">
                <label for="product_quantity" class="form-label">Product Quantity</label>
                <input type="number" name="product_quantity" id="product_quantity" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="product_price" class="form-label">Product Price</label>
                <input type="number" step="0.01" name="product_price" id="product_price" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="category_id" class="form-label">Category</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    <option value="">Select Category</option>
                    <?php while ($row = mysqli_fetch_assoc($result_categories)) { ?>
                        <option value="<?php echo $row['category_id']; ?>"><?php echo $row['category_name']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="manufacturer_id" class="form-label">Manufacturer</label>
                <select name="manufacturer_id" id="manufacturer_id" class="form-control" required>
                    <option value="">Select Manufacturer</option>
                    <?php while ($row = mysqli_fetch_assoc($result_manufacturers)) { ?>
                        <option value="<?php echo $row['manufacturer_id']; ?>"><?php echo $row['manufacturer_name']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="product_image" class="form-label">Product Image</label>
                <input type="file" name="product_image" id="product_image" class="form-control" accept="image/*">
            </div>
            <div class="mb-3">
                <label for="csv_file" class="form-label">Import from CSV</label>
                <input type="file" name="csv_file" id="csv_file" class="form-control" accept=".csv">
            </div>
            <div class="d-grid gap-2">
                <button type="submit" name="add_product" class="btn btn-primary">Add Product</button>
                <button type="submit" name="import_csv" class="btn btn-success">Import from CSV</button>
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
