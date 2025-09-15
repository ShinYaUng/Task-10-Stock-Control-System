<?php
include 'dbconnect.php'; // เชื่อมต่อฐานข้อมูล

$product_id = $_GET['id']; // รับ ID สินค้าจาก URL
$query = $conn->prepare("SELECT * FROM products WHERE id = ?");
$query->bind_param("i", $product_id);
$query->execute();
$result = $query->get_result();
$product = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>รายละเอียดสินค้า</title>
</head>
<body>
    <h2>รายละเอียดสินค้า</h2>

    <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" width="300" height="400"><br>
    <strong>ชื่อสินค้า:</strong> <?php echo $product['name']; ?><br>
    <strong>รายละเอียดสินค้า:</strong> <?php echo $product['description']; ?><br>
    <strong>ราคา:</strong> <?php echo $product['price']; ?> บาท<br>
    <strong>จำนวนในสต็อก:</strong> <?php echo $product['stock']; ?><br>

    <a href="products.php">กลับไปหน้ารายการสินค้า</a>
</body>
</html>
