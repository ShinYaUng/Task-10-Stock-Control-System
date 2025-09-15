<?php
session_start();
include 'dbconnect.php';

// ตรวจสอบการล็อกอินและบทบาท
if (!isset($_SESSION['username'])) {
    header("Location: index.html");
    exit();
}

if ($_SESSION['role'] != 'Manager') {
    echo "คุณไม่มีสิทธิ์ในการเข้าถึงหน้านี้";
    exit();
}

// เพิ่ม, แก้ไข, หรือลบหมวดหมู่สินค้า
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // จัดการหมวดหมู่
    if (isset($_POST['add_category'])) {
        $name = $_POST['category_name'];
        $description = $_POST['category_description'];
        $imagePath = '';

        // ตรวจสอบว่าไฟล์ถูกอัปโหลดหรือไม่
        if (isset($_FILES['category_image']) && $_FILES['category_image']['error'] == UPLOAD_ERR_OK) {
            $imageTmpPath = $_FILES['category_image']['tmp_name'];
            $imageName = $_FILES['category_image']['name'];
            $imagePath = 'uploads/' . basename($imageName);

            // ย้ายไฟล์จาก temporary location ไปที่โฟลเดอร์ที่ต้องการ
            move_uploaded_file($imageTmpPath, $imagePath);
        }

        $stmt = $conn->prepare("INSERT INTO categories (name, description, image) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $description, $imagePath);

        if ($stmt->execute()) {
            echo "เพิ่มหมวดหมู่สำเร็จ!";
        } else {
            echo "เกิดข้อผิดพลาดในการเพิ่มหมวดหมู่!";
        }
    }

    if (isset($_POST['edit_category'])) {
        $cat_id = $_POST['category_id'];
        $name = $_POST['category_name'];
        $description = $_POST['category_description'];
        $imagePath = $_POST['current_image']; // เก็บ path ของภาพปัจจุบัน

        // ตรวจสอบว่าไฟล์ใหม่ถูกอัปโหลดหรือไม่
        if (isset($_FILES['category_image']) && $_FILES['category_image']['error'] == UPLOAD_ERR_OK) {
            $imageTmpPath = $_FILES['category_image']['tmp_name'];
            $imageName = $_FILES['category_image']['name'];
            $imagePath = 'uploads/' . basename($imageName);

            // ย้ายไฟล์จาก temporary location ไปที่โฟลเดอร์ที่ต้องการ
            move_uploaded_file($imageTmpPath, $imagePath);
        }

        $stmt = $conn->prepare("UPDATE categories SET name = ?, description = ?, image = ? WHERE id = ?");
        $stmt->bind_param("sssi", $name, $description, $imagePath, $cat_id);

        if ($stmt->execute()) {
            echo "แก้ไขหมวดหมู่สำเร็จ!";
        } else {
            echo "เกิดข้อผิดพลาดในการแก้ไขหมวดหมู่!";
        }
    }

    if (isset($_POST['delete_category'])) {
        $cat_id = $_POST['category_id'];

        $stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
        $stmt->bind_param("i", $cat_id);

        if ($stmt->execute()) {
            echo "ลบหมวดหมู่สำเร็จ!";
        } else {
            echo "เกิดข้อผิดพลาดในการลบหมวดหมู่!";
        }
    }

    // จัดการสินค้า
    if (isset($_POST['add_product'])) {
        $name = $_POST['product_name'];
        $description = $_POST['product_description'];
        $price = $_POST['product_price'];
        $category_id = $_POST['category_id'];

        // ตรวจสอบว่าไฟล์ถูกอัปโหลดหรือไม่
        if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == UPLOAD_ERR_OK) {
            $imageTmpPath = $_FILES['product_image']['tmp_name'];
            $imageName = $_FILES['product_image']['name'];
            $imagePath = 'uploads/' . basename($imageName);

            // ย้ายไฟล์จาก temporary location ไปที่โฟลเดอร์ที่ต้องการ
            if (move_uploaded_file($imageTmpPath, $imagePath)) {
                // บันทึกข้อมูลลงฐานข้อมูล
                $stmt = $conn->prepare("INSERT INTO products (cat_id, name, description, image, price) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("isssd", $category_id, $name, $description, $imagePath, $price);

                if ($stmt->execute()) {
                    echo "เพิ่มสินค้าสำเร็จ!";
                } else {
                    echo "เกิดข้อผิดพลาดในการเพิ่มสินค้า!";
                }
            } else {
                echo "เกิดข้อผิดพลาดในการอัปโหลดไฟล์!";
            }
        } else {
            echo "กรุณาเลือกไฟล์ภาพ!";
        }
    }

    if (isset($_POST['edit_product'])) {
        $product_id = $_POST['product_id'];
        $name = $_POST['product_name'];
        $description = $_POST['product_description'];
        $price = $_POST['product_price'];
        $category_id = $_POST['category_id'];
        $imagePath = $_POST['current_image']; // เก็บ path ของภาพปัจจุบัน

        // ตรวจสอบว่าไฟล์ใหม่ถูกอัปโหลดหรือไม่
        if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == UPLOAD_ERR_OK) {
            $imageTmpPath = $_FILES['product_image']['tmp_name'];
            $imageName = $_FILES['product_image']['name'];
            $imagePath = 'uploads/' . basename($imageName);

            // ย้ายไฟล์จาก temporary location ไปที่โฟลเดอร์ที่ต้องการ
            move_uploaded_file($imageTmpPath, $imagePath);
        }

        $stmt = $conn->prepare("UPDATE products SET cat_id = ?, name = ?, description = ?, image = ?, price = ? WHERE id = ?");
        $stmt->bind_param("isssdi", $category_id, $name, $description, $imagePath, $price, $product_id);

        if ($stmt->execute()) {
            echo "แก้ไขสินค้าสำเร็จ!";
        } else {
            echo "เกิดข้อผิดพลาดในการแก้ไขสินค้า!";
        }
    }

    if (isset($_POST['delete_product'])) {
        $product_id = $_POST['product_id'];

        $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param("i", $product_id);

        if ($stmt->execute()) {
            echo "ลบสินค้าสำเร็จ!";
        } else {
            echo "เกิดข้อผิดพลาดในการลบสินค้า!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Manage Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h2 {
            color: #333;
            text-align: center;
        }

        h3 {
            color: #555;
            margin-top: 20px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            margin: 15px 0;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        input[type="file"] {
            margin-bottom: 15px;
        }

        input[type="submit"] {
            background-color: #5cb85c;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #4cae4c;
        }

        .message {
            color: #d9534f; /* สีแดงสำหรับข้อความผิดพลาด */
            font-weight: bold;
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <h2>จัดการหมวดหมู่และสินค้า</h2>

    <!-- จัดการหมวดหมู่ -->
    <h3>จัดการหมวดหมู่สินค้า</h3>
    <form method="POST" enctype="multipart/form-data">
        <label>ชื่อหมวดหมู่:</label>
        <input type="text" name="category_name" required>

        <label>คำอธิบายหมวดหมู่:</label>
        <textarea name="category_description" required></textarea>

        <label>รูปภาพหมวดหมู่:</label>
        <input type="file" name="category_image" accept="image/*" required>

        <input type="submit" name="add_category" value="เพิ่มหมวดหมู่">
    </form>

    <form method="POST">
        <label>ID หมวดหมู่ที่ต้องการแก้ไข:</label>
        <input type="number" name="category_id" required>

        <label>ชื่อหมวดหมู่ใหม่:</label>
        <input type="text" name="category_name" required>

        <label>คำอธิบายใหม่:</label>
        <textarea name="category_description" required></textarea>

        <label>รูปภาพใหม่ (ถ้ามี):</label>
        <input type="file" name="category_image" accept="image/*">

        <input type="hidden" name="current_image" value="<?= isset($imagePath) ? $imagePath : ''; ?>">

        <input type="submit" name="edit_category" value="แก้ไขหมวดหมู่">
    </form>

    <form method="POST">
        <label>ID หมวดหมู่ที่ต้องการลบ:</label>
        <input type="number" name="category_id" required>

        <input type="submit" name="delete_category" value="ลบหมวดหมู่">
    </form>

    <hr>

    <!-- จัดการสินค้า -->
    <h3>จัดการสินค้า</h3>
    <form method="POST" enctype="multipart/form-data">
        <label>ชื่อสินค้า:</label>
        <input type="text" name="product_name" required>

        <label>คำอธิบายสินค้า:</label>
        <textarea name="product_description" required></textarea>

        <label>รูปภาพสินค้า:</label>
        <input type="file" name="product_image" accept="image/*" required>

        <label>ราคาสินค้า:</label>
        <input type="number" name="product_price" step="0.01" required>

        <label>หมวดหมู่สินค้า:</label>
        <input type="number" name="category_id" required>

        <input type="submit" name="add_product" value="เพิ่มสินค้า">
    </form>

    <form method="POST">
        <label>ID สินค้าที่ต้องการแก้ไข:</label>
        <input type="number" name="product_id" required>

        <label>ชื่อสินค้าใหม่:</label>
        <input type="text" name="product_name" required>

        <label>คำอธิบายใหม่:</label>
        <textarea name="product_description" required></textarea>

        <label>รูปภาพใหม่ (ถ้ามี):</label>
        <input type="file" name="product_image" accept="image/*">

        <label>ราคาใหม่:</label>
        <input type="number" name="product_price" step="0.01" required>

        <label>หมวดหมู่ใหม่:</label>
        <input type="number" name="category_id" required>

        <input type="hidden" name="current_image" value="<?= isset($imagePath) ? $imagePath : ''; ?>">

        <input type="submit" name="edit_product" value="แก้ไขสินค้า">
    </form>

    <form method="POST">
        <label>ID สินค้าที่ต้องการลบ:</label>
        <input type="number" name="product_id" required>

        <input type="submit" name="delete_product" value="ลบสินค้า">
    </form>

</body>
</html>
