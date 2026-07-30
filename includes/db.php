<?php
// Database connection. Edit these to match your server.

$host   = "127.0.0.1";
// 3307, not 3306: the MariaDB instance on this machine listens on 3307.
// Under a stock XAMPP install this is usually 3306.
$port   = "3307";
$dbname = "turbo_company";
$user   = "root";
$pass   = "";

try {
    $pdo = new PDO(
        "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            // Real prepared statements, not client-side string interpolation.
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
