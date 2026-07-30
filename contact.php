<?php
// Handles the "Send us a message" form on index.php and writes to contact_messages.

require __DIR__ . "/includes/helpers.php";
require __DIR__ . "/includes/db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    redirect("index.php#contact");
}

if (!csrf_valid()) {
    set_flash("contact", "error", "Your session expired. Please try again.");
    redirect("index.php#contact");
}

$name    = trim($_POST["name"] ?? "");
$email   = trim($_POST["email"] ?? "");
$phone   = trim($_POST["phone"] ?? "");
$message = trim($_POST["message"] ?? "");

$_SESSION["contact_old"] = compact("name", "email", "phone", "message");

$errors = [];

if ($name === "") {
    $errors[] = "Your name is required.";
}

if ($email === "") {
    $errors[] = "Email address is required.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "That email address does not look valid.";
}

if ($message === "") {
    $errors[] = "Please type your message.";
} elseif (mb_strlen($message) > 2000) {
    $errors[] = "Message is too long (2000 characters max).";
}

if ($errors) {
    set_flash("contact", "error", implode(" ", $errors));
    redirect("index.php#contact");
}

try {
    $stmt = $pdo->prepare(
        "INSERT INTO contact_messages (name, email, phone, message)
         VALUES (?, ?, ?, ?)"
    );
    $stmt->execute([$name, $email, $phone !== "" ? $phone : null, $message]);

    unset($_SESSION["contact_old"]);
    set_flash("contact", "success", "Message received - we will reply shortly.");
} catch (PDOException $e) {
    set_flash("contact", "error", "Sorry, we could not send your message. Please try again later.");
}

redirect("index.php#contact");
