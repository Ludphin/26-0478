<?php
// Database credentials for each place this site runs.
//
// Requests to localhost use the local XAMPP/MariaDB install; anything else is
// treated as the live server, so the same files work in both places with no
// editing between uploads.
//
// SECURITY: fill the live password in on the server (File Manager or FTP)
// after uploading. Do not commit it - this repository is public.

$isLocal = in_array(
    $_SERVER["SERVER_NAME"] ?? "localhost",
    ["localhost", "127.0.0.1", "::1"],
    true
);

if ($isLocal) {

    // ---- Local development (XAMPP) ----
    // A stock XAMPP install uses port 3306; this machine's MariaDB is on 3307.
    define("DB_HOST", "127.0.0.1");
    define("DB_PORT", "3307");
    define("DB_NAME", "turbo_company");
    define("DB_USER", "root");
    define("DB_PASS", "");

} else {

    // ---- Live hosting (InfinityFree) ----
    // Copy these from Control Panel -> MySQL Databases. InfinityFree picks the
    // database and user names for you; they both start with if0_ and cannot be
    // changed.
    define("DB_HOST", "sqlXXX.infinityfree.com");   // e.g. sql301.infinityfree.com
    define("DB_PORT", "3306");
    define("DB_NAME", "if0_00000000_turbo");
    define("DB_USER", "if0_00000000");
    define("DB_PASS", "");

}
