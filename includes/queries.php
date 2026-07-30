<?php
// Every read the public pages need. Nothing here writes.

/**
 * Site copy as a key => value map, so callers can do $settings["contact_email"].
 * Fetched once per request and cached in a static.
 */
function get_settings(PDO $pdo): array
{
    static $settings = null;
    if ($settings === null) {
        $rows = $pdo->query("SELECT setting_key, setting_value FROM site_settings")->fetchAll();
        $settings = array_column($rows, "setting_value", "setting_key");
    }
    return $settings;
}

/** One setting, with a fallback for keys that were never seeded. */
function setting(PDO $pdo, string $key, string $default = ""): string
{
    return get_settings($pdo)[$key] ?? $default;
}

function get_gallery_images(PDO $pdo): array
{
    return $pdo->query(
        "SELECT file_path, alt_text, caption
           FROM gallery_images
          WHERE is_active = 1
          ORDER BY sort_order, id"
    )->fetchAll();
}

/** Price list rows, joined to the category name for grouping/filtering. */
function get_products(PDO $pdo): array
{
    return $pdo->query(
        "SELECT p.id, p.name, p.material, p.price, p.stock, p.image,
                c.name AS category_name
           FROM products p
           LEFT JOIN categories c ON c.id = p.category_id
          WHERE p.is_active = 1
          ORDER BY p.sort_order, p.id"
    )->fetchAll();
}

function get_videos(PDO $pdo): array
{
    return $pdo->query(
        "SELECT title, youtube_id
           FROM videos
          WHERE is_active = 1
          ORDER BY sort_order, id"
    )->fetchAll();
}

function get_categories(PDO $pdo): array
{
    return $pdo->query(
        "SELECT id, name, slug, description
           FROM categories
          ORDER BY sort_order, id"
    )->fetchAll();
}
