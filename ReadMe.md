http://localhost:8080/love-app/public/index.php?action=nfc_scan&tag=5E61CD6E
http://localhost:8080/love-app/public/index.php?action=nfc_scan&tag=2C852B16

http://localhost:8080/love-app/public/index.php?action=nfc_scan&tag=5E61CD6E,2C852B16


# 🚀 Hướng Dẫn Cài Đặt & Chạy Dự Án PHP (Composer + XAMPP)

Dự án này sử dụng PHP, Composer và chạy trong môi trường XAMPP. Tài liệu
này hướng dẫn cách thiết lập đầy đủ để dự án hoạt động trên máy local.

------------------------------------------------------------------------

## 📌 1. Yêu Cầu Hệ Thống

### ✔ PHP

-   Phiên bản yêu cầu: **PHP 8.0.30**

-   Đường dẫn PHP (XAMPP):

        C:\xampp\php\php.exe

### ✔ Composer

Kiểm tra phiên bản Composer trên máy:

``` bash
composer --version
```

Ví dụ kết quả:

    Composer version 2.8.12 2025-09-19 13:41:59
    PHP version 8.0.30 (C:\xampp\php\php.exe)

------------------------------------------------------------------------

## 📂 2. Chuẩn Bị Mã Nguồn

Đặt project vào thư mục XAMPP:

    C:\xampp\htdocs\love-app

Clone bằng Git:

``` bash
git clone https://github.com/bongbro1/Love_App C:\xampp\htdocs\love-app
```

------------------------------------------------------------------------

## 📦 3. Cài Đặt Dependencies (Composer)

Truy cập thư mục dự án:

``` bash
cd C:\xampp\htdocs\love-app
```

Cài đặt thư viện:

``` bash
composer install
```

Composer sẽ: - Tạo `vendor/` - Tạo `autoload.php` - Cài đặt các thư viện
trong `composer.json`

------------------------------------------------------------------------

## ⚙️ 4. Cấu Hình File love-app/config/database.php

Chỉnh lại các thông số:

```
$host = '127.0.0.1';
$db   = 'love-app';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';
```

------------------------------------------------------------------------

## 🗄️ 5. Cấu Hình Database

1.  Mở phpMyAdmin:
    -   http://localhost/phpmyadmin
2.  Tạo database:

```{=html}
<!-- -->
```
    loveapp

3.  Import file SQL để trong thư mục love-app:
    love-app.sql

------------------------------------------------------------------------

## ▶️ 6. Chạy Ứng Dụng
-   Bật **Apache**
-   Truy cập:
    http://localhost/love-app/public

------------------------------------------------------------------------

## 🔧 7. Các Lệnh Composer Thường Dùng

  Mục đích                Lệnh
  ----------------------- --------------------------
  Cài đặt thư viện        `composer install`
  Cập nhật thư viện       `composer update`
  Làm mới autoload        `composer dump-autoload`
  Kiểm tra lỗi Composer   `composer diagnose`

------------------------------------------------------------------------

## ❗ 8. Troubleshooting

### ❌ Composer không tìm được php.exe

``` bash
composer config -g php-bin "C:\\xampp\\php\\php.exe"
```

### ❌ Thiếu extension PHP

Mở file:

    C:\xampp\php\php.ini

Bật:

``` ini
extension=openssl
extension=mbstring
extension=pdo_mysql
```

------------------------------------------------------------------------

## 🎉 9. Hoàn Tất

Bạn đã thiết lập thành công dự án PHP với Composer và XAMPP.
