<?php
include 'dbconnect.php';

$username = $_POST['username'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$gender = $_POST['gender'];
$age = $_POST['age'];
$province = $_POST['province'];
$email = $_POST['email'];

// ตรวจสอบว่ารหัสผ่านตรงกันและตรงตามเงื่อนไข
if ($password !== $confirm_password) {
    die("Passwords do not match.");
} 
if (!preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).{8,}$/", $password)) {
    die("Password must be at least 8 characters long and contain at least one number, one uppercase and one lowercase letter.");
}

// ตรวจสอบอีเมล์ไม่ซ้ำ
$query = $conn->prepare("SELECT * FROM users WHERE email = ?");
$query->bind_param("s", $email);
$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
    die("Email already in use.");
}

// เพิ่มข้อมูลผู้ใช้ลงฐานข้อมูล
$query = $conn->prepare("INSERT INTO users (username, password, firstname, lastname, gender, age, province, email, role) 
                         VALUES (?, MD5(?), ?, ?, ?, ?, ?, ?, 'Customer')");
$query->bind_param("ssssssss", $username, $password, $firstname, $lastname, $gender, $age, $province, $email);
if ($query->execute()) {
    echo "Registration successful.";
} else {
    echo "Registration failed.";
}
?>