<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Payment Successful</title>
  <style>
    body {
      background-color: #000;
      color: #F7D44C;
      font-family: 'Segoe UI', sans-serif;
      text-align: center;
      padding: 100px 20px;
    }
    h1 {
      color: lime;
    }
    a {
      margin-top: 20px;
      display: inline-block;
      background-color: #F7D44C;
      color: #000;
      padding: 12px 20px;
      text-decoration: none;
      font-weight: bold;
      border-radius: 5px;
    }
  </style>
</head>
<body>

  <h1>✅ Payment Successful</h1>
  <p>Thank you for shopping with Timefy! Your order has been placed.</p>
  <a href="index.php">Back to Home</a>

</body>
</html>
