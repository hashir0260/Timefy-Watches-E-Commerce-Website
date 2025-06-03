<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

require 'db.php';

// Check if product ID is provided and is valid
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: admin_products.php");
    exit;
}

$product_id = (int)$_GET['id'];

// Delete product from database
$stmt = $conn->prepare("DELETE FROM products WHERE product_id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$stmt->close();

// Redirect back to product list page
header("Location: admin_products.php");
exit;
