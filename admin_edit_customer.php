<?php
session_start();
include 'dbconnect.php';

// ตรวจสอบสิทธิ์ผู้ดูแลระบบ
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'Admin') {
    header("Location: index.html");
    exit();
}

$id = $_GET['id'];

// ดึงข้อมูลลูกค้า
$query = $conn->prepare("SELECT * FROM users WHERE id = ?");
$query->bind_param("i", $id);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    die("ไม่พบข้อมูลผู้ใช้");
}

// เมื่อฟอร์มถูกส่ง
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับค่าจากฟอร์ม
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $province = $_POST['province'];
    $email = $_POST['email'];

    // ตรวจสอบอีเมล์ไม่ซ้ำกับผู้อื่น
    $query = $conn->prepare("SELECT * FROM users WHERE email = ? AND id != ?");
    $query->bind_param("si", $email, $id);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows > 0) {
        die("อีเมล์นี้ถูกใช้งานแล้ว");
    }

    // อัปเดตข้อมูลลูกค้า
    $query = $conn->prepare("UPDATE users SET firstname = ?, lastname = ?, gender = ?, age = ?, province = ?, email = ? WHERE id = ?");
    $query->bind_param("ssssssi", $firstname, $lastname, $gender, $age, $province, $email, $id);
    if ($query->execute()) {
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "ไม่สามารถอัปเดตข้อมูลได้";
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>แก้ไขข้อมูลลูกค้า</title>
</head>
<body>
    <h2>แก้ไขข้อมูลลูกค้า</h2>
    <form method="POST" action="">
        ชื่อ: <input type="text" name="firstname" value="<?php echo $user['firstname']; ?>" required><br>
        นามสกุล: <input type="text" name="lastname" value="<?php echo $user['lastname']; ?>" required><br>
        เพศ:
        <select name="gender" required>
            <option value="Male" <?php if ($user['gender'] == 'Male') echo 'selected'; ?>>ชาย</option>
            <option value="Female" <?php if ($user['gender'] == 'Female') echo 'selected'; ?>>หญิง</option>
        </select><br>
        อายุ: <input type="number" name="age" value="<?php echo $user['age']; ?>" required><br>
        จังหวัด: <input type="text" name="province" value="<?php echo $user['province']; ?>" required><br>
        อีเมล์: <input type="email" name="email" value="<?php echo $user['email']; ?>" required><br>
        <button type="submit">อัปเดตข้อมูล</button>
    </form>
    <a href="admin_dashboard.php">กลับไปยังแดชบอร์ด</a>
</body>
</html>