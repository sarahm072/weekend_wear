<?php
include 'db.php';

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $comment = $conn->real_escape_string($_POST['comment']);

    if (!empty($name) && !empty($email) && !empty($comment)) {
        $sql = "INSERT INTO messages (name, email, message) VALUES ('$name', '$email', '$comment')";
        if ($conn->query($sql) === TRUE) {
            $success = "✅ تم إرسال رسالتك بنجاح، شكراً لتواصلك معنا!";
        } else {
            $error = "❌ خطأ أثناء الإرسال: " . $conn->error;
        }
    } else {
        $error = "⚠️ الرجاء ملء جميع الحقول المطلوبة.";
    }
}
?>
<!DOCTYPE html>
<html lang="ar">

<head>
    <title>Weekend wear</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&family=Noto+Sans+JP:wght@100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="image/Weekend wear.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <!--header-->
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

    <div class="contact">
        <h1>Contact</h1>

        <?php if ($success): ?>
            <p style="color:green;"><?= $success ?></p>
        <?php elseif ($error): ?>
            <p style="color:red;"><?= $error ?></p>
        <?php endif; ?>

        <div class="formulaire">
            <form action="" method="POST">
                <input type="text" name="name" id="name" placeholder="Name" required>
                <input type="email" name="email" id="email" placeholder="Email*" required>
                <input type="tel" name="phone" id="phone" placeholder="Phone number">
                <textarea name="comment" id="comment" placeholder="Comment" required></textarea>
                <button type="submit">Send</button>
            </form>
        </div>
    </div>
</body>
</html>
