<?php
session_start();
require 'db.php'; // your DB connection

// Fetch 3 featured products (latest 3 here)
$sql = "SELECT product_id, name, price, image FROM products ORDER BY created_at DESC LIMIT 3";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Timefy | Premium Watches</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>

  <!-- Header -->
  <header>
    <img src="logo.jpg" alt="Timefy Logo" />
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

  <!-- Hero Section -->
  <section class="hero">
    <h1>Where Time Meets Elegance</h1>
    <p>Discover stylish premium watches at Timefy</p>
  </section>

  <!-- Featured Products -->
  <section class="featured">
    <h2>Featured Watches</h2>
    <div class="products">
      <?php
      if ($result && $result->num_rows > 0):
        $index = 0;
        while ($row = $result->fetch_assoc()):
      ?>
        <div class="product-card" style="--i: <?= $index ?>;">
          <img src="<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>" />
          <h3><?= htmlspecialchars($row['name']) ?></h3>
          <p>₹<?= number_format($row['price'], 0) ?></p>
        </div>
      <?php
        $index++;
        endwhile;
      else:
      ?>
        <p>No featured watches available at the moment.</p>
      <?php endif; ?>
    </div>
  </section>

  <!-- Footer -->
  <div class="footer">
    © 2025 Timefy. All rights reserved.
  </div>

</body>
</html>
