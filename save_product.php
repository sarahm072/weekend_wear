<?php
include "db.php"; // الاتصال بقاعدة البيانات

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = $_POST['name'];
    $price    = $_POST['price'];
    $quantity = $_POST['quantity'];
    $category = $_POST['category'];

    // 📸 معالجة الصورة
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $targetDir  = "uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true); // إنشاء مجلد إذا ماكانش
        }
        $fileName   = time() . "_" . basename($_FILES["image"]["name"]);
        $targetFile = $targetDir . $fileName;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $imagePath = $targetFile;
        } else {
            die("⚠️ خطأ في رفع الصورة.");
        }
    } else {
        die("⚠️ لم يتم اختيار صورة.");
    }

    // ✅ إدخال المنتج في قاعدة البيانات
    $stmt = $conn->prepare("INSERT INTO products (name, price, stock, category, image) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("siiss", $name, $price, $quantity, $category, $imagePath);

    if ($stmt->execute()) {
        echo "<script>
                alert('✅ تم إضافة المنتج بنجاح');
                window.location.href='admin.php';
              </script>";
    } else {
        echo "⚠️ خطأ: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
