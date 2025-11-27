<?php
$host = "localhost";
$user = "root"; // الافتراضي في XAMPP
$pass = "";     // فارغ في XAMPP
$dbname = "weekend_wear";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}
?>
