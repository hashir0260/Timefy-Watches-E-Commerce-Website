<?php
session_start();
include("../includes/db.php");

$email = $_POST['email'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user_name'] = $user['name'];
        echo "<script>alert('Login successful!'); window.location.href='../index.php';</script>";
    } else {
        echo "<script>alert('Invalid password'); window.location.href='login.html';</script>";
    }
} else {
    echo "<script>alert('Email not found'); window.location.href='login.html';</script>";
}
?>
