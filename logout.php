<?php
// Start the session
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Logout</title>
  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    .notification {
      background-color: #4CAF50;
      color: #fff;
      text-align: center;
      padding: 15px;
      border-radius: 5px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      position: fixed;
      top: 30px;
      left: 50%;
      transform: translateX(-50%);
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
    }
    .notification.show {
      opacity: 1;
      visibility: visible;
    }
  </style>
</head>
<body>
  <div class="notification" id="notification">
    Logout successful! Redirecting to login page...
  </div>

  <script>
    // Function to show the notification
    function showNotification() {
      const notification = document.getElementById('notification');
      notification.classList.add('show');
      setTimeout(() => {
        notification.classList.remove('show');
      }, 3000); // Show the notification for 3 seconds
    }

    // Call the showNotification function on page load
    window.onload = function() {
      showNotification();
      // Redirect to the login page after the notification disappears
      setTimeout(() => {
        window.location.href = 'index.php';
      }, 3000); // Redirect after 3 seconds
    };
  </script>
</body>
</html>
