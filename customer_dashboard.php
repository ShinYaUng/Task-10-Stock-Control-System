<?php
session_start();
include 'dbconnect.php';

// ตรวจสอบว่าเป็นลูกค้าที่ล็อกอินอยู่หรือไม่
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'Customer') {
    header("Location: index.html");
    exit();
}

// การออกจากระบบ
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.html");
    exit();
}

// ดึงข้อมูลลูกค้า
$username = $_SESSION['username'];
$query = $conn->prepare("SELECT * FROM users WHERE username = ?");
$query->bind_param("s", $username);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>แดชบอร์ดลูกค้า</title>
</head>
<body>
    <h2>ยินดีต้อนรับ, <?php echo $user['firstname']; ?>!</h2>
    <a href="customer_edit_profile.php">แก้ไขข้อมูลส่วนตัว</a> | 
    <a href="?logout=true">ออกจากระบบ</a>

    <h3>ข้อมูลส่วนตัวของคุณ</h3>
    <table border="1">
        <tr>
            <th>ชื่อผู้ใช้</th>
            <td><?php echo $user['username']; ?></td>
        </tr>
        <tr>
            <th>ชื่อ</th>
            <td><?php echo $user['firstname']; ?></td>
        </tr>
        <tr>
            <th>นามสกุล</th>
            <td><?php echo $user['lastname']; ?></td>
        </tr>
        <tr>
            <th>เพศ</th>
            <td><?php echo $user['gender']; ?></td>
        </tr>
        <tr>
            <th>อายุ</th>
            <td><?php echo $user['age']; ?></td>
        </tr>
        <tr>
            <th>จังหวัด</th>
            <td><?php echo $user['province']; ?></td>
        </tr>
        <tr>
            <th>อีเมล์</th>
            <td><?php echo $user['email']; ?></td>
        </tr>
    </table>

     <!-- ปุ่มไปหน้าร้าน index.php -->
     <br>
    <a href="shop.php">
        <button>ไปที่หน้าร้าน</button>
    </a>

</body>
</html>
