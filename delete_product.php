<?php
include "db.php"; // connection file

// ✅ Check if ID exists in the URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("❌ Invalid product ID.");
}

$product_id = intval($_GET['id']);

// ✅ First check if the product exists
$check = $conn->prepare("SELECT id, name FROM products WHERE id = ?");
$check->bind_param("i", $product_id);
$check->execute();
$result = $check->get_result();

if ($result->num_rows === 0) {
    die("❌ Product not found.");
}

$product = $result->fetch_assoc();

// ✅ Delete product
$delete = $conn->prepare("DELETE FROM products WHERE id = ?");
$delete->bind_param("i", $product_id);

if ($delete->execute()) {
    echo "<p style='color:green'>✅ Product <b>" . htmlspecialchars($product['name']) . "</b> deleted successfully.</p>";
    echo "<a href='admin.php'>⬅️ Back to Admin</a>";
} else {
    echo "❌ Error deleting product: " . $conn->error;
}
?>
