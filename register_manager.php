<?php
session_start();
include 'dbconnect.php';

// ตรวจสอบสิทธิ์ว่าเป็น Admin หรือไม่
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'Admin') {
    header("Location: index.html");
    exit();
}

// การลงทะเบียนผู้จัดการ
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    
    // ตรวจสอบรหัสผ่าน
    if ($password !== $confirm_password) {
        echo "รหัสผ่านไม่ตรงกัน!";
    } elseif (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)[A-Za-z\d]{8,}$/', $password)) {
        echo "รหัสผ่านต้องมีความยาวอย่างน้อย 8 ตัวอักษร มีตัวเลขอย่างน้อย 1 ตัว และมีตัวพิมพ์ใหญ่และตัวพิมพ์เล็กอย่างน้อย 1 ตัว";
    } else {
        // ตรวจสอบอีเมล์ไม่ซ้ำกัน
        $query = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $query->bind_param("s", $email);
        $query->execute();
        $result = $query->get_result();
        
        if ($result->num_rows > 0) {
            echo "อีเมล์นี้มีอยู่ในระบบแล้ว!";
        } else {
            // เข้ารหัสรหัสผ่าน
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $role = 'Manager'; // กำหนดสิทธิ์เป็นผู้จัดการ
            
            // บันทึกข้อมูลลงในฐานข้อมูล
            $stmt = $conn->prepare("INSERT INTO users (username, password, firstname, lastname, email, role) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $username, $hashed_password, $firstname, $lastname, $email, $role);
            
            if ($stmt->execute()) {
                echo "ลงทะเบียนผู้จัดการสำเร็จ!";
            } else {
                echo "เกิดข้อผิดพลาดในการลงทะเบียน!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ลงทะเบียนผู้จัดการ</title>
</head>
<body>
    <h2>ลงทะเบียนผู้จัดการ</h2>
    <form method="POST" action="register_manager.php">
        <label>ชื่อผู้ใช้:</label>
        <input type="text" name="username" required><br>
        
        <label>รหัสผ่าน:</label>
        <input type="password" name="password" required><br>
        
        <label>ยืนยันรหัสผ่าน:</label>
        <input type="password" name="confirm_password" required><br>
        
        <label>ชื่อ:</label>
        <input type="text" name="firstname" required><br>
        
        <label>นามสกุล:</label>
        <input type="text" name="lastname" required><br>
        
        <label>อีเมล์:</label>
        <input type="email" name="email" required><br>
        
        <input type="submit" value="ลงทะเบียน">
    </form>
</body>
</html>
