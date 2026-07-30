<?php
// Database connection. Credentials live in config.php.

require_once __DIR__ . "/config.php";

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            // Real prepared statements, not client-side string interpolation.
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );
} catch (PDOException $e) {
    // Never print the driver message on a live site - it names the host, the
    // database and the user. Log it instead and show something harmless.
    error_log("DB connection failed: " . $e->getMessage());

    $isLocal = in_array(
        $_SERVER["SERVER_NAME"] ?? "localhost",
        ["localhost", "127.0.0.1", "::1"],
        true
    );

    http_response_code(503);
    die($isLocal
        ? "Database connection failed: " . $e->getMessage()
        : "The site is temporarily unavailable. Please try again shortly.");
}
