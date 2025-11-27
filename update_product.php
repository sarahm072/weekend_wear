<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id       = intval($_POST['id']);
    $name     = $_POST['name'];
    $price    = $_POST['price'];
    $quantity = $_POST['quantity'];
    $category = $_POST['category'];

    // جلب الصورة القديمة
    $result = $conn->query("SELECT image FROM products WHERE id=$id");
    $oldImage = $result->fetch_assoc()['image'];

    $imagePath = $oldImage;

    // ✅ إذا تم رفع صورة جديدة
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $targetDir  = "uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $fileName   = time() . "_" . basename($_FILES["image"]["name"]);
        $targetFile = $targetDir . $fileName;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $imagePath = $targetFile;
            // حذف الصورة القديمة إذا لزم
            if (file_exists($oldImage)) {
                unlink($oldImage);
            }
        }
    }

    // ✅ تحديث البيانات
    $stmt = $conn->prepare("UPDATE products SET name=?, price=?, stock=?, category=?, image=? WHERE id=?");
    $stmt->bind_param("siissi", $name, $price, $quantity, $category, $imagePath, $id);

    if ($stmt->execute()) {
        echo "<script>
                alert('✅ تم تحديث المنتج بنجاح');
                window.location.href='admin.php';
              </script>";
    } else {
        echo "⚠️ خطأ: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>

