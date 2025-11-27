<?php
include "db.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    // إذا لم يسجل المستخدم دخوله، إعادة التوجيه لتسجيل الدخول
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$sql = "
    SELECT o.id, p.name, p.image, o.size, o.quantity, o.total, o.created_at
    FROM orders o
    JOIN products p ON o.product_id = p.id
    WHERE o.user_id = ?
    ORDER BY o.created_at DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("خطأ في الاستعلام: " . $conn->error);
}
?>



<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <title>سلة المشتريات</title>
    <link rel="stylesheet" href="style.css">
        <link rel="shortcut icon" href="image/Weekend wear.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

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

<div class="cart_page">

    <?php if ($result->num_rows > 0): ?>
        <table border="1" cellpadding="10" cellspacing="0">
            <tr>
                <th>المنتج</th>
                <th>الصورة</th>
                <th>المقاس</th>
                <th>الكمية</th>
                <th>السعر الإجمالي</th>
                <th>تاريخ الطلب</th>
            </tr>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><img src="<?= htmlspecialchars($row['image']) ?>" width="80"></td>
                    <td><?= htmlspecialchars($row['size']) ?></td>
                    <td><?= htmlspecialchars($row['quantity']) ?></td>
                    <td><?= htmlspecialchars($row['total']) ?> دج</td>
                    <td><?= htmlspecialchars($row['created_at']) ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <h1>Your cart is empty</h1>
    <a href="catalog.php">Continue shopping</a>
     <h4>Have an account?</h4>
     <p> <a href="login.php" class="id">Log in</a> to check out faster.</p>
    <?php endif; ?>
</div>

</body>
</html>
