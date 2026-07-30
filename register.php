<?php
// Handles the "Join the family" form on index.php and writes to registrations.

require __DIR__ . "/includes/helpers.php";
require __DIR__ . "/includes/db.php";

// Nothing to do for a plain GET - send the visitor back to the form.
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    redirect("index.php#register");
}

if (!csrf_valid()) {
    set_flash("register", "error", "Your session expired. Please try again.");
    redirect("index.php#register");
}

$fullName = trim($_POST["full_name"] ?? "");
$email    = trim($_POST["email"] ?? "");
$phone    = trim($_POST["phone"] ?? "");
$gender   = trim($_POST["gender"] ?? "");

// Keep what they typed so a rejected form comes back filled in.
$_SESSION["register_old"] = compact("fullName", "email", "phone", "gender");

$errors = [];

if ($fullName === "") {
    $errors[] = "Full name is required.";
} elseif (mb_strlen($fullName) > 120) {
    $errors[] = "Full name is too long.";
}

if ($email === "") {
    $errors[] = "Email address is required.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "That email address does not look valid.";
}

// Kenyan numbers, typed with or without spaces: 07xx xxx xxx or +2547xx xxx xxx.
$phoneDigits = preg_replace('/[^0-9+]/', "", $phone);
if ($phone === "") {
    $errors[] = "Phone number is required.";
} elseif (!preg_match('/^(?:\+?254|0)[17]\d{8}$/', $phoneDigits)) {
    $errors[] = "Enter a valid phone number, e.g. 0788 945 632.";
}

// Must match the ENUM in the registrations table, or the INSERT would fail.
$allowedGenders = ["Female", "Male", "Prefer not to say"];
if (!in_array($gender, $allowedGenders, true)) {
    $errors[] = "Please select a gender option.";
}

if ($errors) {
    set_flash("register", "error", implode(" ", $errors));
    redirect("index.php#register");
}

try {
    $stmt = $pdo->prepare(
        "INSERT INTO registrations (full_name, email, phone, gender, ip_address)
         VALUES (?, ?, ?, ?, ?)"
    );
    $stmt->execute([$fullName, $email, $phoneDigits, $gender, $_SERVER["REMOTE_ADDR"] ?? null]);

    unset($_SESSION["register_old"]);
    set_flash("register", "success", "Thank you, $fullName! You are registered - we will be in touch with exclusive deals.");
} catch (PDOException $e) {
    // 23000 with errno 1062 is the UNIQUE index on email doing its job.
    if ($e->errorInfo[1] === 1062) {
        set_flash("register", "error", "That email is already registered.");
    } else {
        set_flash("register", "error", "Sorry, we could not save your registration. Please try again later.");
    }
}

redirect("index.php#register");
