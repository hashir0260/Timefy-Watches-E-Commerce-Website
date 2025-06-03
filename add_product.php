<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

require 'db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $price = $_POST['price'] ?? 0;
    $image = $_POST['image'] ?? '';

    if ($name && $description && $price && $image) {
        $stmt = $conn->prepare("INSERT INTO products (name, description, price, image) VALUES (?, ?, ?, ?)");
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($conn->error));
        }
        $stmt->bind_param("ssds", $name, $description, $price, $image);
        $stmt->execute();
        $stmt->close();

        $message = "<p class='success'>✅ Product added successfully! <a href='admin_dashboard.php'>Back to Dashboard</a></p>";
    } else {
        $message = "<p class='error'>⚠️ Please fill in all fields.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add New Product</title>
  <link rel="stylesheet" href="admin_style.css">
  <style>
    .form-container {
      max-width: 500px;
      margin: 80px auto;
      background-color: #1E1E1E;
      padding: 40px 30px;
      border-radius: 12px;
      box-shadow: 0 0 20px #F7D44C55;
      color: #F7D44C;
      font-family: 'Segoe UI', sans-serif;
    }

    .form-container h1 {
      text-align: center;
      margin-bottom: 25px;
      font-size: 26px;
    }

    .form-container label {
      margin-top: 15px;
      display: block;
      font-weight: 600;
    }

    .form-container input[type="text"],
    .form-container input[type="number"],
    .form-container textarea {
      width: 100%;
      padding: 12px;
      margin-top: 8px;
      border-radius: 6px;
      border: 1px solid #F7D44C88;
      background-color: #121212;
      color: #F7D44C;
      font-size: 16px;
    }

    .form-container button {
      margin-top: 25px;
      width: 100%;
      background-color: #F7D44C;
      border: none;
      padding: 14px;
      font-weight: 700;
      font-size: 16px;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      color: #121212;
    }

    .form-container button:hover {
      background-color: #d6b93e;
    }

    .form-container a {
      display: inline-block;
      margin-top: 20px;
      color: #F7D44C;
      text-decoration: none;
      font-weight: 600;
      text-align: center;
    }

    .form-container a:hover {
      text-decoration: underline;
    }

    .success, .error {
      text-align: center;
      font-weight: bold;
      margin-bottom: 20px;
    }

    .success {
      color: #4CAF50;
    }

    .error {
      color: #FF6B6B;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h1>Add New Product</h1>

    <?= $message ?>

    <form method="post" action="add_product.php">
      <label>Product Name:</label>
      <input type="text" name="name" required />

      <label>Description:</label>
      <textarea name="description" rows="4" required></textarea>

      <label>Price (Rs):</label>
      <input type="number" step="0.01" name="price" required />

      <label>Image URL:</label>
      <input type="text" name="image" required placeholder="http://example.com/image.jpg" />

      <button type="submit">Add Product</button>
    </form>

    <a href="admin_dashboard.php">← Back to Dashboard</a>
  </div>
</body>
</html>
