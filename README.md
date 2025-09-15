---

```markdown
# 🛍️ PHP E-Commerce Web Application

โปรเจกต์ระบบเว็บขายสินค้าออนไลน์ เขียนด้วย **PHP (Procedural + MySQLi)** พร้อมระบบการจัดการผู้ใช้และสินค้า  
รองรับ **Admin, Manager, Customer** โดยใช้ฐานข้อมูล `dbhw9.sql`

---

## 🚀 Features

### 👤 Authentication & User Roles
- สมัครสมาชิก (Register) / เข้าสู่ระบบ (Login) / ออกจากระบบ (Logout)
- รองรับ 3 บทบาท:
  - **Admin** → จัดการผู้ใช้/ลูกค้า, dashboard
  - **Manager** → จัดการสินค้า, หมวดหมู่
  - **Customer** → สั่งซื้อ, แก้ไขโปรไฟล์

### 🛒 Shop & Products
- หน้า **Shop** (`shop.php`) แสดงสินค้าทั้งหมด
- หน้า **Product Detail** (`product_detail.php`) แสดงรายละเอียดสินค้า
- สินค้าแยกตาม **หมวดหมู่** (`categories`)

### 📊 Dashboards
- **Admin Dashboard** → จัดการลูกค้า (`admin_add_customer.php`, `admin_edit_customer.php`)
- **Manager Dashboard** → จัดการหมวดหมู่/สินค้า (`manage_dashboard.php`, `manage_categories.php`)
- **Customer Dashboard** → ดู/แก้ไขโปรไฟล์ (`customer_dashboard.php`, `customer_edit_profile.php`)

### 🗄️ Database (`dbhw9.sql`)
- `users` → เก็บข้อมูลผู้ใช้ + role
- `products`, `categories` → จัดการสินค้า
- `orders`, `order_items`, `delivery_addresses` → ข้อมูลการสั่งซื้อ
- foreign keys ครบถ้วน

---

## 📂 Project Structure

```

├── admin\_add\_customer.php
├── admin\_dashboard.php
├── admin\_edit\_customer.php
├── customer\_dashboard.php
├── customer\_edit\_profile.php
├── manage\_categories.php
├── manage\_dashboard.php
├── product\_detail.php
├── products.php
├── shop.php
├── register.php
├── register\_manager.php
├── regis.html
├── login.php
├── logout.php
├── showdata.php
├── index.html
├── dbconnect.php
├── dbhw9.sql
├── styles.css

````

---

## ⚙️ Installation

1. Clone หรือดาวน์โหลดโปรเจกต์นี้  
2. วางไฟล์ไว้ในโฟลเดอร์เซิร์ฟเวอร์ เช่น `htdocs` (XAMPP) หรือ `www` (WAMP)  
3. Import ฐานข้อมูล:
   - เข้า phpMyAdmin
   - สร้าง database ชื่อ `dbhw9`
   - Import ไฟล์ `dbhw9.sql`
4. แก้ไขการเชื่อมต่อฐานข้อมูลใน `dbconnect.php`:
   ```php
   $conn = new mysqli("localhost", "root", "", "dbhw9");
````

5. เปิดเบราว์เซอร์ไปที่ `http://localhost/project/index.html`

---

## 🔑 Default Accounts

| Role     | Username  | Password |
| -------- | --------- | -------- |
| Admin    | admin     | 1234     |
| Manager  | manage    | 1234     |
| Customer | Kittamate | 1234     |

> ⚠️ บัญชีถูกเก็บด้วย **MD5** ในไฟล์ SQL ดั้งเดิม → แนะนำให้เปลี่ยนเป็น `password_hash()` และอัปเดตรหัสผ่านใหม่

---

## 🛡️ Security Notes (ควรปรับปรุง)

* ใช้ `password_hash()` / `password_verify()` แทน MD5
* เพิ่ม CSRF token ในฟอร์มที่สำคัญ
* Escape output ด้วย `htmlspecialchars()` ป้องกัน XSS
* ใช้ `prepared statements` ทุก query ป้องกัน SQL Injection

---

## ✨ Screenshots (Optional)

> เพิ่มรูปหน้า Dashboard, Shop, Register ได้ตามต้องการ

---

## 📌 Author

โปรเจกต์พัฒนาโดยนักศึกษาคณะวิศวกรรมคอมพิวเตอร์ (RMUTT)
เพื่อการเรียนรู้และฝึกฝนการทำเว็บแอปพลิเคชัน

---
