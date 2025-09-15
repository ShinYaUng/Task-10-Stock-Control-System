<?php
session_start();
include 'dbconnect.php';

$username = $_POST['username'];
$password = $_POST['password'];

// ตรวจสอบผู้ใช้ในฐานข้อมูล
$query = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = MD5(?)");
$query->bind_param("ss", $username, $password);
$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];

    // ตรวจสอบบทบาทของผู้ใช้และส่งไปหน้าที่เหมาะสม
    if ($user['role'] == 'Admin') {
        header("Location: admin_dashboard.php");
    } elseif ($user['role'] == 'Manager') {
        header("Location: manage_dashboard.php");
    } else {
        header("Location: customer_dashboard.php");
    }
} else {
    echo "Invalid username or password.";
}
?>