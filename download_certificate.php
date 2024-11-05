<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit();
}

if (isset($_GET['certificate_number'])) {
    $certificate_number = $_GET['certificate_number'];

    // Ensure this path points to where your certificate files are stored
    $file = 'path/to/certificates/' . $certificate_number . '.pdf'; // Adjust this path as necessary

    // Debugging: Display the path being checked (remove or comment out in production)
    // echo 'Looking for: ' . $file;

    // Check if the file exists
    if (file_exists($file)) {
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename=' . basename($file));
        readfile($file);
        exit();
    } else {
        // File does not exist, display a user-friendly message
        echo 'Certificate not found. Please ensure the certificate number is correct.';
        exit();
    }
} else {
    echo 'No certificate number provided.';
    exit();
}
?>
