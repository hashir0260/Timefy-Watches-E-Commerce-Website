<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Timefy | Contact</title>
  <link rel="stylesheet" href="styles.css" /> <!-- Optional shared stylesheet -->
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #111;
      color: #fff;
      margin: 0;
      padding: 0;
    }

    header, footer {
      background-color: #000;
      color: #F7D44C;
      padding: 15px 20px;
      text-align: center;
    }

    nav a {
      color: #F7D44C;
      margin: 0 15px;
      text-decoration: none;
      font-weight: bold;
    }

    nav a:hover {
      text-decoration: underline;
    }

    .contact-container {
      max-width: 600px;
      margin: 40px auto;
      background-color: #1e1e1e;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(247, 212, 76, 0.4);
    }

    .contact-container h1 {
      color: #F7D44C;
      margin-bottom: 20px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    label {
      display: block;
      margin-bottom: 6px;
      font-weight: bold;
    }

    input[type="text"],
    input[type="email"],
    textarea {
      width: 100%;
      padding: 10px;
      border: none;
      border-radius: 4px;
      background-color: #333;
      color: #fff;
    }

    textarea {
      resize: vertical;
      min-height: 120px;
    }

    .submit-btn {
      background-color: #F7D44C;
      color: #000;
      border: none;
      padding: 12px 25px;
      font-weight: bold;
      cursor: pointer;
      border-radius: 5px;
      transition: background-color 0.3s ease;
    }

    .submit-btn:hover {
      background-color: #d1b83c;
    }

    .success-message {
      color: #a6f4a6;
      margin-top: 15px;
    }
  </style>
</head>
<body>

  <header>
    <img src="logo.jpg" alt="Timefy Logo" style="height: 40px; vertical-align: middle;">
    <nav>
      <a href="index.php">Home</a>
      <a href="product-list.php">Watches</a>
      <a href="cart.php">Cart</a>
      <a href="contact.php">Contact</a>
      <?php if (isset($_SESSION['user_id'])): ?>
        <a href="user/logout.php">Logout</a>
      <?php else: ?>
        <a href="user/login.php">Login</a>
      <?php endif; ?>
    </nav>
  </header>

  <div class="contact-container">
    <h1>Contact Us</h1>

    <?php if (isset($_GET['success']) && $_GET['success'] == '1'): ?>
      <p class="success-message">Thank you! Your message has been sent.</p>
    <?php endif; ?>

    <form action="send_message.php" method="post">
      <div class="form-group">
        <label for="name">Your Name:</label>
        <input type="text" name="name" id="name" required />
      </div>
      <div class="form-group">
        <label for="email">Your Email:</label>
        <input type="email" name="email" id="email" required />
      </div>
      <div class="form-group">
        <label for="subject">Subject:</label>
        <input type="text" name="subject" id="subject" required />
      </div>
      <div class="form-group">
        <label for="message">Your Message:</label>
        <textarea name="message" id="message" required></textarea>
      </div>
      <button type="submit" class="submit-btn">Send Message</button>
    </form>
  </div>

  <footer>
    © 2025 Timefy. All rights reserved.
  </footer>

</body>
</html>
