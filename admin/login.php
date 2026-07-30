<?php
require __DIR__ . "/auth.php";

if (admin_logged_in()) {
    redirect("index.php");
}

$error = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!csrf_valid()) {
        $error = "Your session expired. Please try again.";
    } else {
        $admin = attempt_login($pdo, trim($_POST["username"] ?? ""), $_POST["password"] ?? "");

        if ($admin) {
            // New session id on privilege change, so a fixated id is useless.
            session_regenerate_id(true);
            $_SESSION["admin_id"]       = $admin["id"];
            $_SESSION["admin_username"] = $admin["username"];
            redirect("index.php");
        }

        $error = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Turbo Company</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <header>
        <div class="logo-area">
            <h1>🚗 Turbo Company</h1>
            <p>Administrator Area</p>
        </div>
        <nav><a href="../index.php">← Back to website</a></nav>
    </header>

    <main>
        <section style="max-width: 420px; margin: 60px auto; padding: 20px;">
            <form method="post">
                <h2 style="margin-top: 0;">Admin Login</h2>

                <?php if ($error): ?>
                <p class="flash flash-error"><?= e($error) ?></p>
                <?php endif; ?>

                <?= csrf_field() ?>

                <label style="display: block; margin-top: 10px; font-weight: 600;">Username</label>
                <input type="text" name="username" required autofocus
                       style="width: 100%; padding: 10px; margin-top: 5px; border-radius: 8px; border: 1px solid #ccc;">

                <label style="display: block; margin-top: 15px; font-weight: 600;">Password</label>
                <input type="password" name="password" required
                       style="width: 100%; padding: 10px; margin-top: 5px; border-radius: 8px; border: 1px solid #ccc;">

                <button type="submit" style="width: 100%; background: var(--plum-header); color: white; border: none; padding: 12px; margin-top: 20px; border-radius: 25px; font-weight: bold; cursor: pointer;">Log In</button>
            </form>
        </section>
    </main>
</body>
</html>
