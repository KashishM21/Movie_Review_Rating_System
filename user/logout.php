<?php
include "../includes/session.php"; // Start the session or resume existing session

// Remove all session variables
session_unset();

// Destroy the session completely
session_destroy();

// Redirect the user back to the homepage after logout
header("Location: ../index.php");
exit; // Ensure no further code is executed
?>
