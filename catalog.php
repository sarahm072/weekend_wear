<?php
include 'db.php';

// نجيب المنتجات من قاعدة البيانات
$result = $conn->query("SELECT * FROM products ORDER BY created_at DESC");
$products = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>Weekend wear</title>
    <link rel="shortcut icon" href="image/Weekend wear.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<!-- ✅ الهيدر -->
<header>
    <h1>Weekend Wear</h1>
    <nav>
        <a href="index.php">Home</a>
        <a href="catalog.php">Catalog</a>
        <a href="contact.php">Contact</a>
    </nav>
    <div class="cart">
    <a href="cart.php" class="cart-icon">
        <i class="fas fa-shopping-cart"></i>
    </a>

    <a href="login.php" class="user-icon">
        <i class="fas fa-user"></i>
    </a>
</div>

</header>

<!-- ✅ أزرار التصنيف -->
<div class="catalog-buttons">
    <button class="btn" data-category="clothes">Clothes</button>
    <button class="btn" data-category="shoes">Shoes</button>
    <button class="btn" data-category="all">All</button>
</div>

<!-- ✅ المنتجات -->
<div class="catalog">
    <?php
    $categories = ["clothes" => "Clothes", "shoes" => "Shoes"];
    foreach ($categories as $catKey => $catName): ?>
        <div class="<?php echo $catKey; ?> category">
            <h3><?php echo $catName; ?></h3>
            <div class="article">
                <?php foreach ($products as $p): ?>
                    <?php if ($p['category'] === $catKey): ?>
                        <div class="card">
                            <a href="product.php?id=<?php echo $p['id']; ?>">
                                <img src="<?php echo $p['image']; ?>" alt="<?php echo htmlspecialchars($p['name']); ?>">
                            </a>
                            <div class="carte_info">
                                <h4><?php echo htmlspecialchars($p['name']); ?></h4>
                                <p>DA <?php echo number_format($p['price'], 2); ?> DZD</p>
                                <a href="product.php?id=<?php echo $p['id']; ?>">اشتري الآن</a>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- ✅ سكريبت الفلترة -->
<script>
  const buttons = document.querySelectorAll(".catalog-buttons .btn");
  const categories = document.querySelectorAll(".category");

  buttons.forEach(btn => {
    btn.addEventListener("click", () => {
      const category = btn.getAttribute("data-category");

      categories.forEach(cat => {
        if (category === "all" || cat.classList.contains(category)) {
          cat.style.display = "block";
        } else {
          cat.style.display = "none";
        }
      });
    });
  });

  // نخلي "الكل" يظهر أول مرة
  document.querySelector('[data-category="all"]').click();
</script>

</body>
</html>
