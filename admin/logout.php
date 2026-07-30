<?php
require __DIR__ . "/auth.php";

// Drop everything, not just the admin keys, then start a clean session.
$_SESSION = [];
session_destroy();

redirect("login.php");
