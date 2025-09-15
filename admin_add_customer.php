<?php
session_start();
include 'dbconnect.php';

// ตรวจสอบสิทธิ์ผู้ดูแลระบบ
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'Admin') {
    header("Location: index.html");
    exit();
}

// เมื่อฟอร์มถูกส่ง
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับค่าจากฟอร์ม
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $province = $_POST['province'];
    $email = $_POST['email'];

    // ตรวจสอบความถูกต้องของข้อมูล เช่นเดียวกับการลงทะเบียน
    if ($password !== $confirm_password) {
        die("รหัสผ่านไม่ตรงกัน");
    } 
    if (!preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).{8,}$/", $password)) {
        die("รหัสผ่านต้องมีอย่างน้อย 8 ตัวอักษร มีตัวเลข ตัวพิมพ์ใหญ่และตัวพิมพ์เล็กอย่างน้อยหนึ่งตัว");
    }
    // ตรวจสอบอีเมล์ไม่ซ้ำ
    $query = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $query->bind_param("s", $email);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows > 0) {
        die("อีเมล์นี้ถูกใช้งานแล้ว");
    }

    // เพิ่มข้อมูลลูกค้าใหม่
    $query = $conn->prepare("INSERT INTO users (username, password, firstname, lastname, gender, age, province, email, role) 
                             VALUES (?, MD5(?), ?, ?, ?, ?, ?, ?, 'Customer')");
    $query->bind_param("ssssssss", $username, $password, $firstname, $lastname, $gender, $age, $province, $email);
    if ($query->execute()) {
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "ไม่สามารถเพิ่มสมาชิกได้";
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css"> <!-- ลิงก์ไปยังไฟล์ CSS -->
    <title>เพิ่มบัญชีสมาชิกของลูกค้า</title>
</head>
<body>
    <div class="container">
        <h2>เพิ่มบัญชีสมาชิกของลูกค้า</h2>
        <form method="POST" action="">
            <label for="username">ชื่อผู้ใช้:</label>
            <input type="text" name="username" required><br>
            
            <label for="password">รหัสผ่าน:</label>
            <input type="password" name="password" required><br>
            
            <label for="confirm_password">ยืนยันรหัสผ่าน:</label>
            <input type="password" name="confirm_password" required><br>
            
            <label for="firstname">ชื่อ:</label>
            <input type="text" name="firstname" required><br>
            
            <label for="lastname">นามสกุล:</label>
            <input type="text" name="lastname" required><br>
            
            <label for="gender">เพศ:</label>
            <select name="gender" required>
                <option value="Male">ชาย</option>
                <option value="Female">หญิง</option>
            </select><br>
            
            <label for="age">อายุ:</label>
            <input type="number" name="age" required><br>
            
            <label for="province">จังหวัด:</label>
            <input type="text" name="province" required><br>
            
            <label for="email">อีเมล์:</label>
            <input type="email" name="email" required><br>
            
            <button type="submit">เพิ่มสมาชิก</button>
        </form>
        <a href="admin_dashboard.php">กลับไปยังแดชบอร์ด</a>
    </div>
</body>
</html>
