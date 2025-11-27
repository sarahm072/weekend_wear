<?php
include "db.php";

// التحقق من وجود ID
if (!isset($_GET['id'])) {
    die("⚠️ لم يتم تحديد المنتج.");
}

$id = intval($_GET['id']);

// جلب بيانات المنتج
$result = $conn->query("SELECT * FROM products WHERE id=$id");
if ($result->num_rows == 0) {
    die("⚠️ المنتج غير موجود.");
}
$product = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <title>تعديل المنتج</title>
    <link rel="shortcut icon" href="image/Weekend wear.png" type="image/x-icon">

  <link rel="stylesheet" href="style.css">
</head>
<body>

  <header>
    <h1>Weekend Wear - تعديل المنتج</h1>
  </header>
<div class="return">
    <a href="adminZ.php">العودة الى الصفحة الرئيسية</a>
   </div>
  <div class="edit-product-form">
    <h2>✏️ تعديل المنتج</h2>
    <form action="update_product.php" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?= $product['id'] ?>">

      <label for="name">اسم المنتج:</label>
      <input type="text" id="name" name="name" value="<?= $product['name'] ?>" required>

      <label for="price">السعر (DZD):</label>
      <input type="number" id="price" name="price" value="<?= $product['price'] ?>" required>

      <label for="quantity">الكمية:</label>
      <input type="number" id="quantity" name="quantity" value="<?= $product['stock'] ?>" required>

      <label for="category">الصنف:</label>
      <select id="category" name="category">
        <option value="clothes" <?= $product['category']=="clothes" ? "selected" : "" ?>>👕 ملابس</option>
        <option value="shoes" <?= $product['category']=="shoes" ? "selected" : "" ?>>👟 أحذية</option>
      </select>

      <label for="image">📷 صورة جديدة (اختياري):</label>
      <input type="file" id="image" name="image" accept="image/*">

      <p>📌 الصورة الحالية:</p>
      <img src="<?= $product['image'] ?>" width="120">

      <button type="submit">💾 تحديث المنتج</button>
    </form>
  </div>

</body>
</html>
