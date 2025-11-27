<?php
include "db.php"; // ملف الاتصال بقاعدة البيانات
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <title>Weekend wear - Admin</title>
    <link rel="stylesheet" href="style.css">
        <link rel="shortcut icon" href="image/Weekend wear.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <!--header-->
    <header>
        <h1>Weakend Wear</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="catalog.php">Catalog</a>
        </nav>
    </header>

    <!-- ✅ المنتجات -->
    <h2>🛍️ قائمة المنتجات</h2>

    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>الصورة</th>
                <th>الاسم</th>
                <th>السعر</th>
                <th>الكمية</th>
                <th>الصنف</th>
                <th>إجراءات</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $products = $conn->query("SELECT * FROM products ORDER BY created_at DESC");
            while ($p = $products->fetch_assoc()):
            ?>
                <tr>
                    <td><img src="<?= htmlspecialchars($p['image']) ?>" width="80"></td>
                    <td><?= htmlspecialchars($p['name']) ?></td>
                    <td><?= htmlspecialchars($p['price']) ?> دج</td>
                    <td><?= htmlspecialchars($p['stock']) ?></td>
                    <td><?= htmlspecialchars($p['category']) ?></td>
                    <td>
                        <a href="edit_product.php?id=<?= $p['id'] ?>">✏️ تعديل</a> | 
                        <a href="delete_product.php?id=<?= $p['id'] ?>" onclick="return confirm('هل تريد حذف المنتج؟')">🗑️ حذف</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <div class="add-product">
        <a href="add_product.php">➕ إضافة منتج جديد</a>
    </div>


        <!-- ✅ الطلبات -->
    <h2>📦 قائمة الطلبات</h2>

    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>الاسم</th>
                <th>الهاتف</th>
                <th>المنتج</th>
                <th>المقاس</th>
                <th>الكمية</th>
                <th>المجموع</th>
                <th>العنوان</th>
                <th>🚚 نوع التوصيل</th> <!-- ✅ العمود الجديد -->
                <th>التاريخ</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $orders = $conn->query("
                SELECT o.*, p.name AS product_name 
                FROM orders o
                JOIN products p ON o.product_id = p.id
                ORDER BY o.created_at DESC
            ");
            while ($o = $orders->fetch_assoc()):
                // ✅ تحديد النص حسب سعر التوصيل
                $delivery_type = ($o['delivery_price'] == 500) ? "YALIDINE مكتب" : "توصيل للمنزل";
            ?>
                <tr>
                    <td><?= htmlspecialchars($o['customer_name']) ?></td>
                    <td><?= htmlspecialchars($o['phone']) ?></td>
                    <td><?= htmlspecialchars($o['product_name']) ?></td>
                    <td><?= htmlspecialchars($o['size']) ?></td>
                    <td><?= htmlspecialchars($o['quantity']) ?></td>
                    <td><?= htmlspecialchars($o['total']) ?> دج</td>
                    <td><?= htmlspecialchars($o['wilaya'] . " - " . $o['commune']) ?></td>
                    <td><?= htmlspecialchars($delivery_type) ?></td> <!-- ✅ عرض نوع التوصيل -->
                    <td><?= htmlspecialchars($o['created_at']) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- ✅ الرسائل -->
    <h2>📨 رسائل الزبائن</h2>

    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>الاسم</th>
                <th>البريد الإلكتروني</th>
                <th>الرسالة</th>
                <th>التاريخ</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $messages = $conn->query("SELECT * FROM messages ORDER BY created_at DESC");
            while ($m = $messages->fetch_assoc()):
            ?>
                <tr>
                    <td><?= htmlspecialchars($m['name']) ?></td>
                    <td><?= htmlspecialchars($m['email']) ?></td>
                    <td><?= nl2br(htmlspecialchars($m['message'])) ?></td>
                    <td><?= htmlspecialchars($m['created_at']) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

</body>
</html>
