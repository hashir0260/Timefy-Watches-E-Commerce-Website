<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

require 'db.php';

// Fetch all products
$result = $conn->query("SELECT * FROM products ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Products</title>
  <link rel="stylesheet" href="admin_style.css">
  <style>
    body {
      background-color: #121212;
      color: #F7D44C;
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 40px;
    }

    h1 {
      text-align: center;
      margin-bottom: 30px;
    }

    .top-links {
      text-align: center;
      margin-bottom: 30px;
    }

    .top-links a {
      display: inline-block;
      margin: 0 10px;
      background-color: #F7D44C;
      color: #121212;
      padding: 10px 16px;
      text-decoration: none;
      border-radius: 6px;
      font-weight: bold;
      transition: background-color 0.3s ease;
    }

    .top-links a:hover {
      background-color: #e0be3a;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background-color: #1e1e1e;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 0 10px #F7D44C44;
    }

    th, td {
      padding: 12px 15px;
      border-bottom: 1px solid #333;
      text-align: left;
    }

    th {
      background-color: #2c2c2c;
      color: #F7D44C;
      font-size: 15px;
    }

    tr:hover {
      background-color: #2b2b2b;
    }

    img {
      max-width: 70px;
      border-radius: 6px;
    }

    .button {
      display: inline-block;
      background-color: #F7D44C;
      color: #121212;
      padding: 6px 12px;
      border-radius: 4px;
      text-decoration: none;
      font-weight: bold;
      margin-bottom: 5px;
      transition: background-color 0.3s ease;
    }

    .button:hover {
      background-color: #e5c83b;
    }

    .empty-message {
      text-align: center;
      padding: 20px;
      color: #aaa;
    }
  </style>
</head>
<body>

  <h1>Manage Products</h1>

  <div class="top-links">
    <a href="admin_dashboard.php">← Back to Dashboard</a>
    <a href="add_product.php">+ Add New Product</a>
  </div>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Image</th>
        <th>Name</th>
        <th>Price (Rs)</th>
        <th>Description</th>
        <th>Created At</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row['product_id']) ?></td>
            <td><img src="<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>"></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td>₹<?= number_format($row['price'], 2) ?></td>
            <td><?= htmlspecialchars(substr($row['description'], 0, 50)) ?><?= strlen($row['description']) > 50 ? '...' : '' ?></td>
            <td><?= htmlspecialchars($row['created_at']) ?></td>
            <td>
              <a href="edit_product.php?id=<?= $row['product_id'] ?>" class="button">Edit</a>
              <a href="delete_product.php?id=<?= $row['product_id'] ?>" class="button" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="7" class="empty-message">No products found.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>

</body>
</html>
