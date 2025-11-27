<?php
include "db.php";
session_start();

if (isset($_POST['email'])) {
    $email = $_POST['email'];

    // ✅ التحقق إذا البريد موجود
    $stmt = $conn->prepare("SELECT id, email FROM users WHERE email=? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // المستخدم موجود
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email']   = $user['email'];
    } else {
        // إنشاء حساب جديد
        $stmt = $conn->prepare("INSERT INTO users (email) VALUES (?)");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $_SESSION['user_id'] = $conn->insert_id;
        $_SESSION['email']   = $email;
    }

    // ✅ تحويل حسب نوع المستخدم
    if ($_SESSION['email'] === "admin@gmail.com") {
        header("Location: adminZ.php");
        exit();
    } else {
        header("Location: index.php");
        exit();
    }
}
?>






<!-- <?php
include "db.php";
session_start();

if(isset($_POST['email'])){
    $email = $_POST['email'];

    // التحقق إذا البريد موجود
    $stmt = $conn->prepare("SELECT id FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id'];
    } else {
        // إنشاء حساب جديد
        $stmt = $conn->prepare("INSERT INTO users (email) VALUES (?)");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        // استخدام $conn->insert_id وليس $stmt->insert_id
        $_SESSION['user_id'] = $conn->insert_id;
    }

    // تحويل لصفحة الطلبات
    header("Location: index.php");
    exit;
}
?> -->
