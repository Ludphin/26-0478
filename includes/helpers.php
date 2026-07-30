<?php
// Session, CSRF and escaping helpers. Include before any output is sent.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// One CSRF token per session, reused by every form on the site.
if (empty($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}

/** Escape a value for HTML output. Every DB value goes through this. */
function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, "UTF-8");
}

/** Hidden input carrying the session's CSRF token. */
function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . e($_SESSION["csrf_token"]) . '">';
}

/**
 * True when the POSTed token matches the session's.
 * is_string() first: a crafted csrf_token[]=x would make hash_equals throw.
 * hash_equals compares in constant time, so the token can't be timed out of us.
 */
function csrf_valid(): bool
{
    return is_string($_POST["csrf_token"] ?? null)
        && hash_equals($_SESSION["csrf_token"], $_POST["csrf_token"]);
}

/**
 * Stash a one-shot message for the page we're about to redirect to.
 * $type is "success" or "error" and drives the banner colour.
 */
function set_flash(string $key, string $type, string $message): void
{
    $_SESSION["flash"][$key] = ["type" => $type, "message" => $message];
}

/** Read and clear a flash message. Returns null when there is nothing to show. */
function take_flash(string $key): ?array
{
    $flash = $_SESSION["flash"][$key] ?? null;
    unset($_SESSION["flash"][$key]);
    return $flash;
}

/** Redirect and stop. Always exit after Location, or the script keeps running. */
function redirect(string $url): void
{
    header("Location: $url");
    exit;
}

/** Money as the price list shows it: 3500.00 -> "3,500". */
function ksh(string $amount): string
{
    return number_format((float) $amount, 0);
}
