<?php
// Admin dashboard: who registered, who wrote in, what's in the catalogue.

require __DIR__ . "/auth.php";
require __DIR__ . "/../includes/queries.php";
require_admin();

// Mark a message as read.
if ($_SERVER["REQUEST_METHOD"] === "POST" && ($_POST["action"] ?? "") === "mark_read") {
    if (csrf_valid()) {
        $pdo->prepare("UPDATE contact_messages SET is_read = 1 WHERE id = ?")
            ->execute([(int) ($_POST["id"] ?? 0)]);
    }
    redirect("index.php#messages");
}

$counts = $pdo->query(
    "SELECT
        (SELECT COUNT(*) FROM registrations)                     AS registrations,
        (SELECT COUNT(*) FROM contact_messages)                  AS messages,
        (SELECT COUNT(*) FROM contact_messages WHERE is_read = 0) AS unread,
        (SELECT COUNT(*) FROM products WHERE is_active = 1)      AS products"
)->fetch();

$registrations = $pdo->query(
    "SELECT id, full_name, email, phone, gender, created_at
       FROM registrations
      ORDER BY created_at DESC, id DESC
      LIMIT 100"
)->fetchAll();

$messages = $pdo->query(
    "SELECT id, name, email, phone, message, is_read, created_at
       FROM contact_messages
      ORDER BY is_read, created_at DESC
      LIMIT 100"
)->fetchAll();

$products = get_products($pdo);

$cell = "padding: 10px; border-bottom: 1px solid rgba(0,0,0,0.05); vertical-align: top;";
$head = "padding: 10px; border-bottom: 2px solid var(--text-plum); color: var(--text-plum); text-align: left;";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Turbo Company</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <header>
        <div class="logo-area">
            <h1>🚗 Turbo Company</h1>
            <p>Signed in as <?= e(current_admin()) ?></p>
        </div>
        <nav>
            <a href="#registrations">Registrations</a>
            <a href="#messages">Messages</a>
            <a href="#catalogue">Catalogue</a>
            <a href="../index.php">View site</a>
            <a href="logout.php">Log out</a>
        </nav>
    </header>

    <main style="max-width: 1000px; margin: 0 auto; padding: 20px;">

        <section class="features-container" style="margin-top: 30px;">
            <div class="feature-card"><h3><?= (int) $counts["registrations"] ?></h3><p>Registered members</p></div>
            <div class="feature-card"><h3><?= (int) $counts["messages"] ?></h3><p>Messages (<?= (int) $counts["unread"] ?> unread)</p></div>
            <div class="feature-card"><h3><?= (int) $counts["products"] ?></h3><p>Active products</p></div>
        </section>

        <section id="registrations">
            <h2>Registrations</h2>
            <div class="feature-card" style="overflow-x: auto;">
                <?php if (!$registrations): ?>
                <p>No registrations yet.</p>
                <?php else: ?>
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th style="<?= $head ?>">Name</th>
                            <th style="<?= $head ?>">Email</th>
                            <th style="<?= $head ?>">Phone</th>
                            <th style="<?= $head ?>">Gender</th>
                            <th style="<?= $head ?>">Registered</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($registrations as $row): ?>
                        <tr>
                            <td style="<?= $cell ?>"><?= e($row["full_name"]) ?></td>
                            <td style="<?= $cell ?>"><?= e($row["email"]) ?></td>
                            <td style="<?= $cell ?>"><?= e($row["phone"]) ?></td>
                            <td style="<?= $cell ?>"><?= e($row["gender"]) ?></td>
                            <td style="<?= $cell ?>"><?= e($row["created_at"]) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php endif; ?>
            </div>
        </section>

        <section id="messages">
            <h2>Contact Messages</h2>
            <div class="feature-card" style="overflow-x: auto;">
                <?php if (!$messages): ?>
                <p>No messages yet.</p>
                <?php else: ?>
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th style="<?= $head ?>">From</th>
                            <th style="<?= $head ?>">Contact</th>
                            <th style="<?= $head ?>">Message</th>
                            <th style="<?= $head ?>">Received</th>
                            <th style="<?= $head ?>">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($messages as $row): ?>
                        <tr style="<?= $row["is_read"] ? "" : "font-weight: 600;" ?>">
                            <td style="<?= $cell ?>"><?= e($row["name"]) ?></td>
                            <td style="<?= $cell ?>">
                                <?= e($row["email"]) ?><?= $row["phone"] ? "<br>" . e($row["phone"]) : "" ?>
                            </td>
                            <td style="<?= $cell ?>max-width: 320px;"><?= nl2br(e($row["message"])) ?></td>
                            <td style="<?= $cell ?>"><?= e($row["created_at"]) ?></td>
                            <td style="<?= $cell ?>">
                                <?php if ($row["is_read"]): ?>
                                    Read
                                <?php else: ?>
                                <form method="post" style="background: none; border: none; box-shadow: none; padding: 0;">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="action" value="mark_read">
                                    <input type="hidden" name="id" value="<?= (int) $row["id"] ?>">
                                    <button type="submit" style="background: var(--accent-rose); color: white; border: none; padding: 6px 12px; border-radius: 15px; cursor: pointer;">Mark read</button>
                                </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php endif; ?>
            </div>
        </section>

        <section id="catalogue">
            <h2>Catalogue</h2>
            <div class="feature-card" style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th style="<?= $head ?>">Item</th>
                            <th style="<?= $head ?>">Category</th>
                            <th style="<?= $head ?>">Material</th>
                            <th style="<?= $head ?>">Price (KSh)</th>
                            <th style="<?= $head ?>">Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $row): ?>
                        <tr>
                            <td style="<?= $cell ?>"><?= e($row["name"]) ?></td>
                            <td style="<?= $cell ?>"><?= e($row["category_name"] ?? "-") ?></td>
                            <td style="<?= $cell ?>"><?= e($row["material"] ?? "-") ?></td>
                            <td style="<?= $cell ?>"><?= ksh($row["price"]) ?></td>
                            <td style="<?= $cell ?>"><?= (int) $row["stock"] ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>

    </main>
</body>
</html>
