<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: user/login.php");
    exit;
}

require 'db.php';

// Handle quantity updates or removals
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['quantities'])) {
        foreach ($_POST['quantities'] as $productId => $quantity) {
            $quantity = (int)$quantity;
            if ($quantity > 0) {
                $_SESSION['cart'][$productId] = $quantity;
            } else {
                unset($_SESSION['cart'][$productId]);
            }
        }
        header("Location: cart.php");
        exit;
    }

    if (isset($_POST['remove'])) {
        $removeId = (int)$_POST['remove'];
        unset($_SESSION['cart'][$removeId]);
        header("Location: cart.php");
        exit;
    }
}

// Load cart products
$cart = $_SESSION['cart'] ?? [];
$totalAmount = 0;
$products = [];

if (!empty($cart)) {
    $placeholders = implode(',', array_fill(0, count($cart), '?'));
    $stmt = $conn->prepare("SELECT product_id, name, price, image FROM products WHERE product_id IN ($placeholders)");
    $stmt->bind_param(str_repeat('i', count($cart)), ...array_keys($cart));
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $row['quantity'] = $cart[$row['product_id']];
        $row['subtotal'] = $row['price'] * $row['quantity'];
        $products[] = $row;
        $totalAmount += $row['subtotal'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Timefy | Cart</title>
  <link rel="stylesheet" href="cart.css">
</head>
<body>

  <!-- Header -->
  <header>
    <img src="logo.jpg" alt="Timefy Logo">
    <nav>
      <a href="index.php">Home</a>
      <a href="product-list.php">Watches</a>
      <a href="cart.php">Cart</a>
      <?php if (isset($_SESSION['user_id'])): ?>
        <a href="user/logout.php">Logout</a>
      <?php else: ?>
        <a href="user/login.php">Login</a>
      <?php endif; ?>
    </nav>
  </header>

  <!-- Cart Content -->
  <section class="cart-container">
    <h1>Your Shopping Cart</h1>

    <?php if (empty($products)): ?>
      <p>Your cart is empty.</p>
    <?php else: ?>
      <form method="post" action="cart.php">
        <table>
          <thead>
            <tr>
              <th>Product</th>
              <th>Name</th>
              <th>Price</th>
              <th>Qty</th>
              <th>Total</th>
              <th>Remove</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($products as $item): ?>
              <tr>
                <td><img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>"></td>
                <td><?= htmlspecialchars($item['name']) ?></td>
                <td>₹<?= number_format($item['price'], 2) ?></td>
                <td>
                  <div class="qty-control">
                    <button type="button" class="qty-minus">−</button>
                    <input type="number" name="quantities[<?= $item['product_id'] ?>]" value="<?= $item['quantity'] ?>" min="0" max="99">
                    <button type="button" class="qty-plus">+</button>
                  </div>
                </td>
                <td>₹<?= number_format($item['subtotal'], 2) ?></td>
                <td>
                  <button type="button" class="remove-btn" onclick="removeItem(<?= $item['product_id'] ?>)">×</button>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>

        <div class="cart-total">
          <p>Total Amount: <strong>₹<?= number_format($totalAmount, 2) ?></strong></p>
          <button type="submit" class="update-btn">Update Cart</button>
          <a href="checkout.php" class="checkout-btn">Proceed to Checkout</a>
        </div>
      </form>

      <!-- Hidden remove form -->
      <form id="removeForm" method="post" action="cart.php" style="display: none;">
        <input type="hidden" name="remove" id="removeProductId">
      </form>
    <?php endif; ?>
  </section>

  <!-- Footer -->
  <footer>
    © 2025 Timefy. All rights reserved.
  </footer>

  <!-- JS for quantity and removal -->
  <script>
    document.querySelectorAll('.qty-control').forEach(control => {
      const input = control.querySelector('input[type="number"]');
      control.querySelector('.qty-plus').addEventListener('click', () => {
        let value = parseInt(input.value) || 0;
        if (value < 99) input.value = value + 1;
      });
      control.querySelector('.qty-minus').addEventListener('click', () => {
        let value = parseInt(input.value) || 0;
        if (value > 0) input.value = value - 1;
      });
    });

    function removeItem(productId) {
      document.getElementById('removeProductId').value = productId;
      document.getElementById('removeForm').submit();
    }
  </script>

</body>
</html>
