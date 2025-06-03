<?php
require 'db.php'; // Your DB connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? ''); // Not saved, optional
    $message = trim($_POST['message'] ?? '');

    // Basic validation
    if ($name && $email && $message) {
        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);

        if ($stmt->execute()) {
            header("Location: contact.php?success=1");
            exit;
        } else {
            echo "Error saving message. Please try again later.";
        }

        $stmt->close();
    } else {
        echo "Please fill out all required fields.";
    }
} else {
    header("Location: contact.php");
    exit;
}
