<?php
session_start(); // Start the session

// Determine if the user is an admin or a regular user before destroying the session
$isAdmin = isset($_SESSION['email']);
$isUser = isset($_SESSION['email']);

// Unset all of the session variables
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"], $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session
session_destroy();

// Redirect to the appropriate page based on user role
if ($isUser) {
    header("Location: login.php"); // Redirect to login page for users
} elseif ($isAdmin) {
    header("Location: login.php"); // Redirect to admin login page for admins
} 
exit();
?>
