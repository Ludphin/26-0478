<?php
// One-time database installer for shared hosting.
//
// Free hosting blocks MySQL from outside its own network, so the tables can't
// be created from a laptop. This runs the two SQL files server-side instead.
//
//   1. upload it together with sql/schema.sql and sql/seed.sql
//   2. open  /install.php?token=<INSTALL_TOKEN>
//   3. DELETE IT, along with sql/  -  it drops and recreates every table
//
// It refuses to run if the tables already hold data, so a stray click can't
// wipe a live site; ?force=1 overrides that when you really do mean to reset.

// Deliberately not a working value. This file lives in a public repository, so
// a real token committed here would be a published key to wiping the database.
// Generate one and substitute it in the copy you upload, never in the repo:
//
//   php -r 'echo bin2hex(random_bytes(16)), "\n";'
//
const INSTALL_TOKEN = "REPLACE_BEFORE_UPLOAD";

header("Content-Type: text/plain; charset=utf-8");

// Checked by length, not by comparing against the placeholder text: a careless
// search-and-replace would rewrite both copies of that string and defeat the
// check. A real token is 32 hex characters.
if (strlen(INSTALL_TOKEN) < 32) {
    http_response_code(500);
    exit("This installer still has its placeholder token. Set INSTALL_TOKEN first.\n");
}

if (!hash_equals(INSTALL_TOKEN, $_GET["token"] ?? "")) {
    http_response_code(404);
    exit("Not found\n");
}

require __DIR__ . "/includes/db.php";

$force = ($_GET["force"] ?? "") === "1";

// Bail out if this looks like a database someone is already using.
try {
    $existing = (int) $pdo->query("SELECT COUNT(*) FROM registrations")->fetchColumn()
              + (int) $pdo->query("SELECT COUNT(*) FROM contact_messages")->fetchColumn();

    if ($existing > 0 && !$force) {
        exit("Refusing to run: the database already holds $existing registration/message rows.\n"
           . "Re-run with &force=1 only if you mean to delete them.\n");
    }
} catch (PDOException $e) {
    // No such table - a fresh database, which is exactly what we want.
}

/**
 * Run every statement in one .sql file.
 *
 * Splitting on a semicolon at end-of-line is enough for these two files: no
 * statement contains a semicolon inside a string literal, and there are no
 * stored routines with their own delimiters. It is not a general SQL parser.
 */
function run_sql_file(PDO $pdo, string $path): int
{
    if (!is_readable($path)) {
        throw new RuntimeException("Cannot read $path - was sql/ uploaded?");
    }

    $sql = file_get_contents($path);

    // Strip full-line -- comments so they can't swallow a following statement.
    $sql = preg_replace('/^\s*--.*$/m', "", $sql);

    $count = 0;
    foreach (preg_split('/;\s*$/m', $sql) as $statement) {
        $statement = trim($statement);
        if ($statement === "") {
            continue;
        }
        $pdo->exec($statement);
        $count++;
    }

    return $count;
}

try {
    echo "Installing into " . DB_NAME . " on " . DB_HOST . "\n\n";

    // Order matters: schema.sql drops and recreates, seed.sql fills.
    echo "schema.sql  " . run_sql_file($pdo, __DIR__ . "/sql/schema.sql") . " statements\n";
    echo "seed.sql    " . run_sql_file($pdo, __DIR__ . "/sql/seed.sql") . " statements\n\n";

    foreach (["categories", "products", "gallery_images", "videos",
              "registrations", "contact_messages", "admins", "site_settings"] as $table) {
        printf("  %-18s %d rows\n", $table, $pdo->query("SELECT COUNT(*) FROM `$table`")->fetchColumn());
    }

    echo "\nDone.\n\n";
    echo "NOW DELETE install.php AND THE sql/ FOLDER FROM THE SERVER.\n";
    echo "Then log in at /admin/login.php as admin / turbo2026 and change the password.\n";
} catch (Throwable $e) {
    http_response_code(500);
    echo "Install failed: " . $e->getMessage() . "\n";
}
