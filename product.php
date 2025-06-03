<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: user/login.php");
    exit;
}

require 'db.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Invalid product ID.";
    exit;
}

$product_id = intval($_GET['id']);

// Fetch product details from database
$stmt = $conn->prepare("SELECT name, price, image, description FROM products WHERE product_id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Product not found.";
    exit;
}

$product = $result->fetch_assoc();

// Handle Add to Cart action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]++;
    } else {
        $_SESSION['cart'][$product_id] = 1;
    }

    header("Location: cart.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Timefy | <?= htmlspecialchars($product['name']) ?></title>
  <link rel="stylesheet" href="product-detail.css">
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
      <a href="user/logout.php">Logout</a>
    </nav>
  </header>

  <!-- Product Detail -->
  <section class="product-detail">
    <div class="image-box" data-aos="fade-right">
      <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
    </div>
    <div class="info-box" data-aos="fade-left">
      <h1><?= htmlspecialchars($product['name']) ?></h1>
      <p class="price">₹<?= number_format($product['price'], 2) ?></p>
      <p class="description">
        <?= nl2br(htmlspecialchars($product['description'])) ?>
      </p>
      <form method="post" action="">
        <button type="submit" name="add_to_cart">Add to Cart</button>
      </form>
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
