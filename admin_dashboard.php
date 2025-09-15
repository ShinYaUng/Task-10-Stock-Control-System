<?php
session_start();
include 'dbconnect.php';

// ตรวจสอบว่าเป็นผู้ดูแลระบบที่ล็อกอินอยู่หรือไม่
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'Admin') {
    header("Location: index.html");
    exit();
}

// การออกจากระบบ
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.html");
    exit();
}

// ฟังก์ชันการลบสมาชิก
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $query = $conn->prepare("DELETE FROM users WHERE id = ?");
    $query->bind_param("i", $delete_id);
    $query->execute();
    header("Location: admin_dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css"> <!-- ลิงก์ไปยังไฟล์ CSS -->
    <title>แดชบอร์ดผู้ดูแลระบบ</title>
</head>
<body>
    <div class="container">
        <h2>ยินดีต้อนรับ, ผู้ดูแลระบบ</h2>
        <nav>
            <a href="admin_add_customer.php">เพิ่มบัญชีสมาชิกของลูกค้า</a>
            <a href="register_manager.php">เพิ่มผู้จัดการ</a> | 
            <a href="?logout=true">ออกจากระบบ</a>
        </nav>
        <h3>รายชื่อสมาชิกลูกค้า</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ชื่อผู้ใช้</th>
                    <th>ชื่อ</th>
                    <th>นามสกุล</th>
                    <th>เพศ</th>
                    <th>อายุ</th>
                    <th>จังหวัด</th>
                    <th>อีเมล์</th>
                    <th>การจัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = $conn->prepare("SELECT * FROM users WHERE role = 'Customer'");
                $query->execute();
                $result = $query->get_result();
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['username']}</td>
                            <td>{$row['firstname']}</td>
                            <td>{$row['lastname']}</td>
                            <td>{$row['gender']}</td>
                            <td>{$row['age']}</td>
                            <td>{$row['province']}</td>
                            <td>{$row['email']}</td>
                            <td>
                                <a href='admin_edit_customer.php?id={$row['id']}'>แก้ไข</a> | 
                                <a href='admin_dashboard.php?delete_id={$row['id']}' onclick='return confirm(\"คุณต้องการลบผู้ใช้นี้หรือไม่?\")'>ลบ</a>
                            </td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
