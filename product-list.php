<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: user/login.php");
    exit;
}

require 'db.php';

// Fetch all products
$sql = "SELECT product_id, name, price, image FROM products ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Timefy | All Watches</title>
  <link rel="stylesheet" href="product-style.css">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>
<body>

  <!-- Header -->
  <header>
    <img src="logo.jpg" alt="Timefy Logo">
    <nav>
      <a href="index.php">Home</a>
      <a href="product-list.php">Watches</a>
      <a href="contact.php">Contact</a>
       <a href="cart.php">Cart</a>
      <?php if (isset($_SESSION['user_id'])): ?>
        <a href="user/logout.php">Logout</a>
      <?php else: ?>
        <a href="user/login.php">Login</a>
      <?php endif; ?>
    </nav>
  </header>

  <!-- Product Listing -->
  <section class="product-list">
    <h1 data-aos="fade-up">Explore All Watches</h1>
    <div class="grid">
      <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <a href="product.php?id=<?= $row['product_id'] ?>" class="product-link" data-aos="zoom-in">
            <div class="product">
              <img src="<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>">
              <h3><?= htmlspecialchars($row['name']) ?></h3>
              <p>₹<?= number_format($row['price'], 2) ?></p>
              <button>View Details</button>
            </div>
          </a>
        <?php endwhile; ?>
      <?php else: ?>
        <p>No products available at the moment.</p>
      <?php endif; ?>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    © 2025 Timefy. All rights reserved.
  </footer>

  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>AOS.init();</script>
</body>
</html>