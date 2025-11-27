<?php
include 'db.php';
session_start(); // تفعيل الجلسة إذا لم تكن موجودة

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// ✅ نتحقق إذا ID موجود
if (!isset($_GET['id'])) {
    die("❌ المنتج غير موجود");
}

$product_id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM products WHERE id = $product_id");
$product = $result->fetch_assoc();

if (!$product) {
    die("❌ المنتج غير موجود");
}

// ✅ معالجة الفورم
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_name = $conn->real_escape_string($_POST['customer_name']);
    $phone    = $conn->real_escape_string($_POST['phone']);
    $wilaya   = $conn->real_escape_string($_POST['wilaya']);
    $commune  = $conn->real_escape_string($_POST['commune']);
    $delivery_price = intval($_POST['delivery']);
    $quantity = intval($_POST['quantity']);
    $size     = $conn->real_escape_string($_POST['size']);

    $total = ($product['price'] * $quantity) + $delivery_price;

    $sql = "INSERT INTO orders (product_id, size, customer_name, phone, wilaya, commune, delivery_price, quantity, total, user_id)
        VALUES ($product_id, '$size', '$customer_name', '$phone', '$wilaya', '$commune', $delivery_price, $quantity, $total, ".($user_id ? $user_id : "NULL").")";

    if ($conn->query($sql)) {
        echo "<script>
    alert('✅ تم إرسال الطلب بنجاح! سنقوم بالتواصل معك لتأكيد الطلب.');
    window.location.href = 'index.php'; 
</script>";
    } else {
        echo "<p style='color:red'>❌ خطأ: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
    <link rel="shortcut icon" href="image/Weekend wear.png" type="image/x-icon">
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <title><?php echo $product['name']; ?></title>
  <link rel="stylesheet" href="style.css">
</head>
<body >
<header>
        <h1>Weakend Wear</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="catalog.php">Catalog</a>
            <a href="contact.php">Contact</a>
        </nav>
    </header>
<div class="product-page">

  <!-- ✅ صورة المنتج -->
  <div class="product-image">
    <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
  </div>

  <!-- ✅ تفاصيل المنتج + استمارة الطلب -->
  <div class="product-details">
    <h1><?php echo $product['name']; ?></h1>
    <p class="price"><?php echo $product['price']; ?> دج</p>


    <hr>

    <!-- ✅ استمارة الطلب -->
    <div class="order-form">
      <h2>استمارة الطلب</h2>
      <form method="post">
        <label>الاسم الكامل</label>
        <input type="text" name="customer_name" required>

        <label>الهاتف</label>
        <input type="tel" name="phone" placeholder="+213" required>

      <p>اختر مقاسك:</p>
    <div class="sizes">
      <?php 
        $sizes = [];

        if ($product['category'] === 'clothes') {
            $sizes = ["S","M","L","XL","XXL"];
        } elseif ($product['category'] === 'shoes') {
            $sizes = ["37","38","39","40","41","42"];
        }

        foreach ($sizes as $s): ?>
          <label>
            <input type="radio" name="size" value="<?php echo $s; ?>" required> <?php echo $s; ?>
          </label>
      <?php endforeach; ?>
    </div>

        <!-- ✅ الولاية والبلدية -->
        <label for="wilaya">الولاية:</label>
        <select id="wilaya" name="wilaya" required>
          <option value="">-- اختر الولاية --</option>
        </select>

        <label for="commune">البلدية:</label>
        <select id="commune" name="commune" disabled required>
          <option value="">-- اختر البلدية --</option>
        </select>

        <!-- ✅ خيارات التوصيل -->
        <label>التوصيل</label>
        <div class="delivery-options">
          <input type="radio" name="delivery" value="500" checked> YALIDINE مكتب (500 دج) <br>
          <input type="radio" name="delivery" value="800"> توصيل للمنزل (800 دج)
        </div>

        <label>الكمية</label>
        <input type="number" id="quantity" name="quantity" value="1" min="1">

        <p id="total" style="font-weight:bold; color:green;"></p>

        <button type="submit">🛒 اشتري الآن</button>
      </form>
    </div>
  </div>
</div>

<script>
  // ✅ السعر من قاعدة البيانات
  const productPrice = <?php echo $product['price']; ?>;

  const wilayaSelect = document.getElementById("wilaya");
  const communeSelect = document.getElementById("commune");
  const quantityInput = document.getElementById("quantity");
  const totalElement = document.getElementById("total");
  const deliveryOptions = document.querySelectorAll("input[name='delivery']");

  // ✅ تحميل ملف الولايات والبلديات
  fetch("data/algeria_cities.json")
    .then(res => res.json())
    .then(data => {
      const grouped = {};
      data.forEach(item => {
        if (!grouped[item.wilaya_name]) {
          grouped[item.wilaya_name] = [];
        }
        grouped[item.wilaya_name].push(item.commune_name);
      });

      Object.keys(grouped).forEach(wilaya => {
        const opt = document.createElement("option");
        opt.value = wilaya;
        opt.textContent = wilaya;
        wilayaSelect.appendChild(opt);
      });

      wilayaSelect.addEventListener("change", () => {
        communeSelect.innerHTML = '<option value="">-- اختر البلدية --</option>';
        communeSelect.disabled = true;

        const selected = wilayaSelect.value;
        if (grouped[selected]) {
          grouped[selected].forEach(commune => {
            const opt = document.createElement("option");
            opt.value = commune;
            opt.textContent = commune;
            communeSelect.appendChild(opt);
          });
          communeSelect.disabled = false;
        }
      });
    })
    .catch(err => console.error("خطأ في تحميل البيانات:", err));

  // ✅ حساب المجموع الكلي
  function updateTotal() {
    let qty = parseInt(quantityInput.value);
    let delivery = parseInt(document.querySelector("input[name='delivery']:checked").value);
    let total = (productPrice * qty) + delivery;
    totalElement.textContent = "المجموع: " + total + " دج";
  }

  quantityInput.addEventListener("input", updateTotal);
  deliveryOptions.forEach(r => r.addEventListener("change", updateTotal));

  updateTotal();
</script>

</body>
</html>
