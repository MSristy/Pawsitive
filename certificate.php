<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_email'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit();
}

// Database connection
$host = 'localhost';
$db = 'pawsitive';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch adopter details based on session email
$user_email = $_SESSION['user_email'];
$stmt = $conn->prepare('SELECT name FROM adopters WHERE email = ? AND status = "approved"');
$stmt->bind_param('s', $user_email);
$stmt->execute();
$stmt->bind_result($adopter_name);
$stmt->fetch();
$stmt->close();

if (empty($adopter_name)) {
    echo "You do not have an approved adoption.";
    exit();
}

// Fetch certificate details
$stmt = $conn->prepare('SELECT certificate_number, date_of_issue, pet_name FROM certificates WHERE adopter_email = ?');
$stmt->bind_param('s', $user_email);
$stmt->execute();
$stmt->bind_result($certificate_number, $date_of_issue, $pet_name);
$stmt->fetch();
$stmt->close();

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adoption Certificate</title>
    <link rel="stylesheet" href="certificate_style.css">
</head>
<body>

<div class="certificate-container">
    <h1>Adoption Certificate</h1>
    <p><strong>Adopter Name:</strong> <?php echo htmlspecialchars($adopter_name); ?></p>
    <p><strong>Pet Name:</strong> <?php echo htmlspecialchars($pet_name); ?></p>
    <p><strong>Certificate Number:</strong> <?php echo htmlspecialchars($certificate_number); ?></p>
    <p><strong>Date of Issue:</strong> <?php echo htmlspecialchars($date_of_issue); ?></p>

    <a href="download_certificate.php?certificate_number=<?php echo htmlspecialchars($certificate_number); ?>" class="download-btn">Download Certificate</a>
</div>

</body>
</html>
