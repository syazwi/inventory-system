<?php
// Start the session
session_start();

// Check for login error message
$loginError = "";
if (isset($_SESSION['login_error'])) {
    $loginError = $_SESSION['login_error'];
    unset($_SESSION['login_error']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Inventory Management System</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <!-- External CSS -->
  <link rel="stylesheet" href="styles.css">
</head>

<style type="text/css">
  body {
  background-color: #ececec;
}

.card {
  margin-top: 50px;
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

.form-label {
  font-weight: bold;
}

.btn-primary {
  background-color: #03aab5;
  border-color: #03aab5;
}

</style>
<body>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-4">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title text-center">Inventory</h4>
          </div>
          <div class="card-body">
            <?php if ($loginError !== ""): ?>
            <!-- Error notification -->
            <div class="alert alert-danger mb-3" role="alert">
              <?php echo $loginError; ?>
            </div>
            <?php endif; ?>

            <form action="login_process.php" method="post">
              <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
              </div>
              <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Login</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS and dependencies -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
