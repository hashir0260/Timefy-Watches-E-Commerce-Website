<?php
require 'db.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = password_hash($_POST['password'] ?? '', PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO admin (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);

    if ($stmt->execute()) {
        $success = "Admin registered successfully!";
    } else {
        $error = "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Registration</title>
  <link rel="stylesheet" href="admin_style.css">
</head>
<body>
  <div class="auth-container">
    <h2>Register Admin</h2>
    <form method="POST" action="">
      <label for="username">Username</label>
      <input type="text" name="username" id="username" required>

      <label for="password">Password</label>
      <input type="password" name="password" id="password" required>

      <input type="submit" value="Register">

      <?php if (!empty($success)): ?>
        <div style="color: #00cc66; text-align: center; margin-top: 15px; font-weight: bold;">
          <?= htmlspecialchars($success) ?>
        </div>
      <?php endif; ?>

      <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>
    </form>
    <p><a href="admin_login.php">← Back to Login</a></p>
  </div>
</body>
</html>
