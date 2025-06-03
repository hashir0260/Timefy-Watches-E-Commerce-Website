<?php
session_start();

require 'db.php';

// Fetch messages
$sql = "SELECT * FROM contact_messages ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Contact Messages</title>
  <style>
    body {
      background-color: #121212;
      color: #F7D44C;
      font-family: 'Segoe UI', sans-serif;
      padding: 40px;
      margin: 0;
    }

    h1 {
      text-align: center;
      margin-bottom: 30px;
    }

    .back-link {
      display: inline-block;
      margin-bottom: 20px;
      text-decoration: none;
      background: #F7D44C;
      color: #121212;
      padding: 10px 18px;
      border-radius: 5px;
      font-weight: bold;
      transition: background-color 0.3s ease;
    }

    .back-link:hover {
      background-color: #e0be3a;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background-color: #1e1e1e;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 0 10px #F7D44C55;
      margin-top: 20px;
    }

    th, td {
      padding: 14px 16px;
      border-bottom: 1px solid #333;
      text-align: left;
    }

    th {
      background-color: #2c2c2c;
      font-size: 15px;
      color: #F7D44C;
    }

    tr:hover {
      background-color: #2b2b2b;
    }

    .no-messages {
      text-align: center;
      margin-top: 50px;
      color: #aaa;
    }

    @media (max-width: 768px) {
      table, thead, tbody, th, td, tr {
        display: block;
      }

      th {
        display: none;
      }

      td {
        position: relative;
        padding-left: 50%;
        border: none;
        border-bottom: 1px solid #444;
      }

      td::before {
        content: attr(data-label);
        position: absolute;
        left: 15px;
        color: #F7D44C;
        font-weight: bold;
      }
    }
  </style>
</head>
<body>

  <a href="admin_dashboard.php" class="back-link">← Back to Dashboard</a>
  <h1>Contact Messages</h1>

  <?php if ($result && $result->num_rows > 0): ?>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Message</th>
          <th>Received At</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td data-label="ID"><?= htmlspecialchars($row['id']) ?></td>
            <td data-label="Name"><?= htmlspecialchars($row['name']) ?></td>
            <td data-label="Email"><?= htmlspecialchars($row['email']) ?></td>
            <td data-label="Message"><?= nl2br(htmlspecialchars($row['message'])) ?></td>
            <td data-label="Received At"><?= htmlspecialchars($row['created_at']) ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p class="no-messages">No messages found.</p>
  <?php endif; ?>

</body>
</html>
