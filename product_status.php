<div class="container mt-4">
        <h2>Product Status</h2>
        <!-- Filter form -->
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="status" class="form-label">Filter by Status:</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">All</option>
                        <option value="available" <?php if ($filterStatus === 'available') echo 'selected'; ?>>Available</option>
                        <option value="outofstock" <?php if ($filterStatus === 'outofstock') echo 'selected'; ?>>Out of Stock</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="category" class="form-label">Filter by Category:</label>
                    <select name="category" id="category" class="form-select">
                        <option value="">All</option>
                        <?php while ($category = mysqli_fetch_assoc($categoryResult)) { ?>
                            <option value="<?php echo $category['category_id']; ?>" <?php if ($filterCategory == $category['category_id']) echo 'selected'; ?>><?php echo $category['category_name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-primary me-md-2">Apply Filters</button>
                        <a href="status.php" class="btn btn-secondary">Clear Filters</a>
                    </div>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Available Quantity</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo $row['product_id']; ?></td>
                            <td><?php echo $row['product_name']; ?></td>
                            <td><?php echo $row['category_name']; ?></td>
                            <td><?php echo $row['product_quantity']; ?></td>
                            <td>
                                <?php
                                if ($row['product_quantity'] > 0) {
                                    echo '<span class="text-success">Available</span>';
                                } else {
                                    echo '<span class="text-danger">Out of Stock</span>';
                                }
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?php
                for ($i = 1; $i <= $totalPages; $i++) {
                    echo '<li class="page-item ' . ($page == $i ? 'active' : '') . '">';
                    echo '<a class="page-link" href="?page=' . $i . '&status=' . $filterStatus . '&category=' . $filterCategory . '">' . $i . '</a>';
                    echo '</li>';
                }
                ?>
            </ul>
        </nav>
    </div>