<?php
// Replace this with your database connection code
$host = "localhost";
$username = "root";
$password = "";
$database = "inventory";

$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Define the number of products to display per page
$productsPerPage = 5;

// Get the current page number from the URL
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $currentPage = intval($_GET['page']);
} else {
    $currentPage = 1;
}

// Calculate the offset for the SQL query
$offset = ($currentPage - 1) * $productsPerPage;

// Build the base query for fetching products
$sql = "SELECT * FROM products";

// Create an array to store the search, filter, and sorting conditions
$conditions = array();

// Check if user entered any search keyword
$searchKeyword = '';
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchKeyword = $_GET['search'];
    // Add the search condition to the array
    $conditions[] = "(product_name LIKE '%$searchKeyword%' OR product_description LIKE '%$searchKeyword%' OR product_id = '$searchKeyword')";
}

// Check if the filter form is submitted
$filterCategory = '';
if (isset($_GET['category']) && !empty($_GET['category'])) {
    $filterCategory = $_GET['category'];
    // Add the filter condition to the array
    $conditions[] = "category_id = '$filterCategory'";
}

// Check if the price range filter form is submitted
$filterMinPrice = '';
$filterMaxPrice = '';
if (isset($_GET['min_price']) && is_numeric($_GET['min_price'])) {
    $filterMinPrice = $_GET['min_price'];
}
if (isset($_GET['max_price']) && is_numeric($_GET['max_price'])) {
    $filterMaxPrice = $_GET['max_price'];
}

// Add the price range filter condition to the array if both min and max prices are provided
if (!empty($filterMinPrice) && !empty($filterMaxPrice)) {
    $conditions[] = "product_price BETWEEN $filterMinPrice AND $filterMaxPrice";
}

// Check if the sorting order form is submitted
$sortOrder = 'DESC'; // Default sorting order is from highest to lowest price
if (isset($_GET['sort_order']) && !empty($_GET['sort_order'])) {
    $sortOrder = $_GET['sort_order'];
}

// If there are conditions, add them to the base query
if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

// Add the sorting order to the query
$sql .= " ORDER BY product_price $sortOrder";

// Add pagination limit to the query
$sql .= " LIMIT $offset, $productsPerPage";

// Fetch the products from the database
$result = mysqli_query($conn, $sql);

// Count the total number of products in the database for pagination
$totalProductsResult = mysqli_query($conn, "SELECT COUNT(*) as total FROM products");
$totalProductsData = mysqli_fetch_assoc($totalProductsResult);
$totalProducts = $totalProductsData['total'];

// Calculate the total number of pages
$totalPages = ceil($totalProducts / $productsPerPage);

// Get the category options for the filter dropdown
$sqlCategories = "SELECT * FROM categories";
$resultCategories = mysqli_query($conn, $sqlCategories);

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<body>
    <div class="container mt-4">
        <!-- Search form -->
        <form action="product.php" method="get" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search by name, description, or product ID" value="<?php echo $searchKeyword; ?>">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>
        <!-- Filter and Sort form -->
        <form action="product.php" method="get" class="mb-3">
            <div class="input-group">
                <select name="category" class="form-select">
                    <option value="">All Categories</option>
                    <?php while ($rowCategory = mysqli_fetch_assoc($resultCategories)) { ?>
                        <option value="<?php echo $rowCategory['category_id']; ?>" <?php if ($filterCategory == $rowCategory['category_id']) echo 'selected'; ?>><?php echo $rowCategory['category_name']; ?></option>
                    <?php } ?>
                </select>
                <input type="number" name="min_price" class="form-control" placeholder="Min Price" value="<?php echo $filterMinPrice; ?>">
                <input type="number" name="max_price" class="form-control" placeholder="Max Price" value="<?php echo $filterMaxPrice; ?>">
                <select name="sort_order" class="form-select">
                    <option value="DESC" <?php if ($sortOrder == 'DESC') echo 'selected'; ?>>Price High to Low</option>
                    <option value="ASC" <?php if ($sortOrder == 'ASC') echo 'selected'; ?>>Price Low to High</option>
                </select>
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Product Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo $row['product_id']; ?></td>
                            <td><?php echo $row['product_name']; ?></td>
                            <td><?php echo $row['product_description']; ?></td>
                            <td><?php echo $row['product_quantity']; ?></td>
                            <td><?php echo $row['product_price']; ?></td>
                            <td><img src="product_images/<?php echo $row['product_image']; ?>" alt="Product Image" style="max-height: 100px;"></td>
                            <td>
                                <!-- Add links for edit and delete pages, passing the product_id as a parameter -->
                                <a href="edit_product.php?product_id=<?php echo $row['product_id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                                <a href="delete_product.php?product_id=<?php echo $row['product_id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <?php
                    // Generate pagination links
                    for ($page = 1; $page <= $totalPages; $page++) {
                        // Add 'active' class to the current page link
                        $activeClass = ($currentPage == $page) ? 'active' : '';

                        // Add the page number as a query parameter to the URL
                        $url = $_SERVER['PHP_SELF'] . '?page=' . $page;

                        echo '<li class="page-item ' . $activeClass . '"><a class="page-link" href="' . $url . '">' . $page . '</a></li>';
                    }
                    ?>
                </ul>
            </nav>
        </div>
    </div>
</body>
</html>
