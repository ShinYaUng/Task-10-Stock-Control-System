<?php
session_start();
include 'dbconnect.php';

// ตรวจสอบสิทธิ์ผู้ดูแลระบบ
if ($_SESSION['role'] != 'Admin') {
    die("Access denied.");
}

// แสดงข้อมูลลูกค้าทั้งหมด
$query = $conn->prepare("SELECT id, username, firstname, lastname, gender, age, province, email FROM users WHERE role = 'Customer'");
$query->execute();
$result = $query->get_result();

echo "<h2>Customer List</h2>";
echo "<table border='1'>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Gender</th>
            <th>Age</th>
            <th>Province</th>
            <th>Email</th>
        </tr>";
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
          </tr>";
}
echo "</table>";
?>
