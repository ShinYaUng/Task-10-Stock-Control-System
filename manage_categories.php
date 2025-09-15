<?php
session_start();
include 'dbconnect.php';

// ตรวจสอบการล็อกอิน
if (!isset($_SESSION['username'])) {
    header("Location: index.html");
    exit();
}

// ตรวจสอบบทบาทว่าเป็น Manager หรือไม่
if ($_SESSION['role'] != 'Manager') {
    echo "คุณไม่มีสิทธิ์ในการเข้าถึงหน้านี้";
    exit();
}

// การเพิ่ม แก้ไข และลบหมวดหมู่สินค้า
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // เพิ่มหมวดหมู่
    if (isset($_POST['add_category'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $image = $_POST['image'];

        $stmt = $conn->prepare("INSERT INTO categories (name, description, image) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $description, $image);

        if ($stmt->execute()) {
            echo "เพิ่มหมวดหมู่สำเร็จ!";
        } else {
            echo "เกิดข้อผิดพลาดในการเพิ่มหมวดหมู่!";
        }
    }

    // แก้ไขหมวดหมู่
    if (isset($_POST['edit_category'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $image = $_POST['image'];

        $stmt = $conn->prepare("UPDATE categories SET name = ?, description = ?, image = ? WHERE id = ?");
        $stmt->bind_param("sssi", $name, $description, $image, $id);

        if ($stmt->execute()) {
            echo "แก้ไขหมวดหมู่สำเร็จ!";
        } else {
            echo "เกิดข้อผิดพลาดในการแก้ไขหมวดหมู่!";
        }
    }

    // ลบหมวดหมู่
    if (isset($_POST['delete_category'])) {
        $id = $_POST['id'];

        $stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "ลบหมวดหมู่สำเร็จ!";
        } else {
            echo "เกิดข้อผิดพลาดในการลบหมวดหมู่!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>จัดการหมวดหมู่สินค้า</title>
</head>
<body>
    <h2>จัดการหมวดหมู่สินค้า</h2>
    <form method="POST">
        <!-- แบบฟอร์มสำหรับเพิ่มหมวดหมู่ -->
        <label>ชื่อหมวดหมู่:</label>
        <input type="text" name="name" required><br>

        <label>คำอธิบายหมวดหมู่:</label>
        <textarea name="description" required></textarea><br>

        <label>รูปภาพหมวดหมู่:</label>
        <input type="text" name="image" required><br>

        <input type="submit" name="add_category" value="เพิ่มหมวดหมู่">
    </form>

    <!-- แบบฟอร์มสำหรับแก้ไขหมวดหมู่ -->
    <form method="POST">
        <label>ID หมวดหมู่:</label>
        <input type="number" name="id" required><br>

        <label>ชื่อหมวดหมู่ใหม่:</label>
        <input type="text" name="name" required><br>

        <label>คำอธิบายใหม่:</label>
        <textarea name="description" required></textarea><br>

        <label>รูปภาพใหม่:</label>
        <input type="text" name="image" required><br>

        <input type="submit" name="edit_category" value="แก้ไขหมวดหมู่">
    </form>

    <!-- แบบฟอร์มสำหรับลบหมวดหมู่ -->
    <form method="POST">
        <label>ID หมวดหมู่ที่ต้องการลบ:</label>
        <input type="number" name="id" required><br>

        <input type="submit" name="delete_category" value="ลบหมวดหมู่">
    </form>
</body>
</html>
