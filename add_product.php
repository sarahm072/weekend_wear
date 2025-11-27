<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <title>إضافة منتج جديد</title>
    <link rel="shortcut icon" href="image/Weekend wear.png" type="image/x-icon">
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <header>
    <h1>Weekend Wear - لوحة التحكم</h1>
  </header>
   <div class="return">
    <a href="adminZ.php">العودة الى الصفحة الرئيسية</a>
   </div>
  <div class="add-product-form">
    <h2>➕ إضافة منتج جديد</h2>
    <form action="save_product.php" method="POST" enctype="multipart/form-data">
      
      <label for="name">اسم المنتج:</label>
      <input type="text" id="name" name="name" required>

      <label for="price">السعر (DZD):</label>
      <input type="number" id="price" name="price" required>

      <label for="quantity">الكمية:</label>
      <input type="number" id="quantity" name="quantity" required>

      <label for="category">الصنف:</label>
      <select id="category" name="category">
        <option value="clothes">👕 ملابس</option>
        <option value="shoes">👟 أحذية</option>
      </select>

      <label for="image">📷 صورة المنتج:</label>
      <input type="file" id="image" name="image" accept="image/*" required>

      <button type="submit">حفظ المنتج</button>
    </form>
  </div>

</body>
</html>
