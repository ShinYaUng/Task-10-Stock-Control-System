<?php
include 'dbconnect.php'; // เชื่อมต่อฐานข้อมูล

// ค้นหาสินค้าตามคำสำคัญ (คีย์เวิร์ด)
$keyword = '';
$query = null;

// ตรวจสอบว่ามีการค้นหาหรือเลือกหมวดหมู่หรือไม่
if (isset($_GET['search'])) {
    $keyword = $_GET['search'];
    $query = $conn->prepare("SELECT * FROM products WHERE name LIKE ?");
    $keyword = "%$keyword%";
    $query->bind_param("s", $keyword);
} else if (isset($_GET['category_id'])) {
    // ค้นหาสินค้าตามหมวดหมู่
    $category_id = $_GET['category_id'];
    $query = $conn->prepare("SELECT * FROM products WHERE cat_id = ?");
    $query->bind_param("i", $category_id);
} else {
    // แสดงสินค้าทั้งหมด
    $query = $conn->prepare("SELECT * FROM products");
}

$query->execute();
$result = $query->get_result();

// ดึงหมวดหมู่ทั้งหมด
$category_query = $conn->prepare("SELECT * FROM categories");
$category_query->execute();
$categories = $category_query->get_result();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ร้านค้าออนไลน์</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1, h2 {
            color: #333;
            text-align: center;
        }

        .product {
            width: 150px;
            height: 200px;
            margin: 10px;
            display: inline-block;
            text-align: center;
            border: 1px solid #ccc;
            padding: 10px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        form {
            text-align: center;
            margin-bottom: 20px;
        }

        input[type="text"] {
            padding: 10px;
            width: 300px;
            margin-right: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            padding: 10px 15px;
            border-radius: 5px;
            border: none;
            background-color: #5cb85c;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #4cae4c;
        }

        ul {
            list-style-type: none;
            padding: 0;
            text-align: center;
        }

        ul li {
            display: inline;
            margin: 0 15px;
        }
    </style>
</head>
<body>
    <h1>ยินดีต้อนรับสู่ร้านค้าออนไลน์</h1>
    <h2>รายการสินค้า</h2>

    <!-- ฟอร์มค้นหาสินค้า -->
    <form method="GET">
        <input type="text" name="search" placeholder="ค้นหาสินค้า..." value="<?php echo htmlspecialchars($keyword); ?>">
        <input type="submit" value="ค้นหา">
    </form>

    <!-- แสดงหมวดหมู่สินค้า -->
    <h3>หมวดหมู่สินค้า</h3>
    <ul>
        <?php while ($category = $categories->fetch_assoc()) { ?>
            <li>
                <a href="products.php?category_id=<?php echo $category['id']; ?>">
                    <?php echo htmlspecialchars($category['name']); ?>
                </a>
            </li>
        <?php } ?>
    </ul>

    <!-- แสดงรายการสินค้า -->
    <div style="text-align: center;">
        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="product">
                <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" width="150" height="200"><br>
                <strong><?php echo htmlspecialchars($row['name']); ?></strong><br>
                ราคา: <?php echo number_format($row['price'], 2); ?> บาท<br>
                <a href="product_detail.php?id=<?php echo $row['id']; ?>">ดูรายละเอียด</a>
            </div>
        <?php } ?>
    </div>
</body>
</html>
