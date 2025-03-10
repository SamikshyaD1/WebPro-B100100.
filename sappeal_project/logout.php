<?php
session_start(); // Start the session
session_destroy(); // Destroy the session
header("Location: form.html"); // Redirect to the login page
exit();
?>