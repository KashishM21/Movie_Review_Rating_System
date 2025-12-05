<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Enable all error reporting for debugging
error_reporting(E_ALL);
ini_set("display_errors", 1);
?>
