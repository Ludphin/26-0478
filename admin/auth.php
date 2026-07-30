<?php
// Admin session helpers. Include before any output on every admin page.

require_once __DIR__ . "/../includes/helpers.php";
require_once __DIR__ . "/../includes/db.php";

function admin_logged_in(): bool
{
    return isset($_SESSION["admin_id"]);
}

function current_admin(): ?string
{
    return $_SESSION["admin_username"] ?? null;
}

/** Send anonymous visitors to the login page. */
function require_admin(): void
{
    if (!admin_logged_in()) {
        redirect("login.php");
    }
}

/**
 * Check a username/password against the admins table.
 * Returns the admin row on success, null on failure - the caller shows one
 * generic message either way so the form can't be used to enumerate usernames.
 */
function attempt_login(PDO $pdo, string $username, string $password): ?array
{
    $stmt = $pdo->prepare("SELECT id, username, password_hash FROM admins WHERE username = ?");
    $stmt->execute([$username]);
    $admin = $stmt->fetch();

    if (!$admin || !password_verify($password, $admin["password_hash"])) {
        return null;
    }

    $pdo->prepare("UPDATE admins SET last_login_at = NOW() WHERE id = ?")->execute([$admin["id"]]);

    return $admin;
}
