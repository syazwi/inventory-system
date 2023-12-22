<!-- navbar.php -->

<style type="text/css">
  /* CSS */
  .border-element {
    border-bottom: 3px solid #dc0b80;
  }


a#logout {
    color: white!important;
}


</style>
<div class="border-element">
  <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #ffffff;">
    <div class="container d-flex justify-content-between"> <!-- Use justify-content-between to align items on both ends -->
      <a class="navbar-brand" href="dashboard.php" style="color: #000000; font-weight: bolder;">
        <!-- Add your logo image here -->
        <img src="inventory.png" alt="Logo" style="height: 60px; width: auto; margin-right: 10px;">
      </a>
      <ul class="navbar-nav">
        <!-- Add the Logout link -->
        <li class="nav-item">
          <a class="nav-link" id="logout" href="logout.php" style="color: #000000;">Logout</a>
        </li>
      </ul>
    </div>
  </nav>
</div>
