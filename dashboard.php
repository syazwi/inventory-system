<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inventory Management System - Dashboard</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <!-- External CSS -->
  <link rel="stylesheet" href="styles.css">
</head>

<style type="text/css">
  body {
      background-image: url("progresif_Tn.svg");
      background-size: cover;
      background-repeat: no-repeat;
      background-attachment: fixed; /* To keep the background fixed when scrolling */
    }
</style>
<body id="">
  <?php include 'navbar.php'; ?>

  <div class="container mt-4">
    <p id="imm">Inventory Management Menu</p>
    <div class="row">
      <!-- Product card -->
      <div class="col-md-4 mb-4">
        <a href="product.php" style="text-decoration: none !important;">
          <div class="card">
            <img src="card/2.jpg" class="card-img-top" alt="Product Image">
            <div class="card-body">
              <h5 class="card-title">Product</h5>
            </div>
          </div>
        </a>
      </div>
      <!-- Category card -->
      <div class="col-md-4 mb-4">
        <a href="category.php" style="text-decoration: none !important;">
          <div class="card">
            <img src="card/3.jpg" class="card-img-top" alt="Category Image">
            <div class="card-body">
              <h5 class="card-title">Category</h5>
            </div>
          </div>
        </a>
      </div>
      <!-- Inventory card -->
      <div class="col-md-4 mb-4">
        <a href="status.php" style="text-decoration: none !important;">
          <div class="card">
            <img src="card/1.jpg" class="card-img-top" alt="Inventory Image">
            <div class="card-body">
              <h5 class="card-title">Inventory Status</h5>
            </div>
          </div>
        </a>
      </div>
    </div>
  </div>


    <?php include 'footer.php'; ?>


  <!-- Bootstrap JS and dependencies -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
