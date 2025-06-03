<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="admin_style.css">
  <style>
    .dashboard-container {
      max-width: 600px;
      margin: 80px auto;
      background-color: #1E1E1E;
      padding: 40px 30px;
      border-radius: 12px;
      box-shadow: 0 0 20px #F7D44C55;
      text-align: center;
    }

    .dashboard-container h1 {
      font-size: 30px;
      margin-bottom: 30px;
      color: #F7D44C;
    }

    .dashboard-container a {
      display: block;
      background-color: #F7D44C;
      color: #121212;
      padding: 12px;
      margin: 12px 0;
      border-radius: 8px;
      font-weight: bold;
      text-decoration: none;
      transition: background-color 0.3s ease;
    }

    .dashboard-container a:hover {
      background-color: #d6b93e;
    }
  </style>
</head>
<body>
  <div class="dashboard-container">
    <h1>Welcome</h1>

    <a href="add_product.php">Add New Product</a>
    <a href="admin_products.php">Manage Products</a>
    <a href="messages.php">Customer Messages</a>
    <a href="admin_logout.php">Logout</a>
  </div>
</body>
</html>
