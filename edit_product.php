<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

require 'db.php';

// Validate product ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: admin_products.php");
    exit;
}

$product_id = (int)$_GET['id'];

// Fetch product data
$stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<p class='error'>Product not found.</p>";
    exit;
}

$product = $result->fetch_assoc();
$stmt->close();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $image = trim($_POST['image'] ?? '');

    if ($name && $description && $price > 0 && $image) {
        $update_stmt = $conn->prepare("UPDATE products SET name=?, description=?, price=?, image=? WHERE product_id=?");
        $update_stmt->bind_param("ssdsi", $name, $description, $price, $image, $product_id);
        $update_stmt->execute();
        $update_stmt->close();

        header("Location: admin_products.php");
        exit;
    } else {
        $error = "Please fill in all fields correctly.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Edit Product | Timefy Admin</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
    <div class="container">
        <h1>Edit Product</h1>

        <?php if (!empty($error)): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="post" action="edit_product.php?id=<?= $product_id ?>">
            <label>
                Product Name:
                <input type="text" name="name" required value="<?= htmlspecialchars($product['name']) ?>" />
            </label>

            <label>
                Description:
                <textarea name="description" rows="4" required><?= htmlspecialchars($product['description']) ?></textarea>
            </label>

            <label>
                Price (₹):
                <input type="number" step="0.01" name="price" required value="<?= htmlspecialchars($product['price']) ?>" />
            </label>

            <label>
                Image URL:
                <input type="text" name="image" required value="<?= htmlspecialchars($product['image']) ?>" />
            </label>

            <input type="submit" value="Update Product">
        </form>

        <p><a href="admin_products.php">← Back to Products</a></p>
    </div>
</body>
</html>
