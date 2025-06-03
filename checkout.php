<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: user/login.php");
    exit;
}
?>
<!DOCTYPE html> 
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Timefy | Checkout</title>
  <link rel="stylesheet" href="checkout.css">
</head>
<body>

  <!-- Header -->
  <header>
    <img src="logo.jpg" alt="Timefy Logo">
    <nav>
      <a href="index.php">Home</a>
      <a href="product-list.php">Watches</a>
      <a href="cart.php">Cart</a>
        <a href="user/login.html">Login</a>
      <a href="user/logout.php">Logout</a>
    </nav>
  </header>

  <!-- Checkout Form -->
  <section class="checkout-container">
    <h1>Checkout</h1>
    <form action="checkout-success.php" method="POST">
      <label>Name on Card</label>
      <input type="text" name="card_name" required>

      <label>Card Number</label>
      <input type="text" name="card_number" maxlength="16" required>

      <label>CVV</label>
      <input type="text" name="cvv" maxlength="3" required>

      <label>Expiry Date (MM/YY)</label>
      <input type="text" name="expiry" placeholder="MM/YY" required>

      <input type="submit" value="Pay ₹11,998">
    </form>
  </section>

  <!-- Footer -->
  <footer>
    © 2025 Timefy. All rights reserved.
  </footer>

</body>
</html>
