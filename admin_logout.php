<?php
session_start();

// Check if admin is logged in before proceeding to logout
if (isset($_SESSION['email'])) {
    // Unset admin session variable
    unset($_SESSION['email']);
    
    // If it's desired to kill the session, also delete the session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"], $params["secure"], $params["httponly"]
        );
    }

    // Finally, destroy the session
    session_destroy();

    // Redirect to admin login page after logout
    header("Location: login.php");
    exit();
} else {
    // If admin is not logged in, redirect to the admin login page
    header("Location: login.php");
    exit();
}
?>
