<?php
// Database connection
$host = 'localhost';
$db = 'pawsitive';
$user = 'root';
$pass = '';
$conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

// Fetch adopter details based on the provided email
if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $stmt = $conn->prepare("SELECT name, phone_number, preferences AS pet_name FROM adopters WHERE email = :email LIMIT 1");
    $stmt->execute(['email' => $email]);
    $adopter = $stmt->fetch(PDO::FETCH_ASSOC);

    // Return adopter data in JSON format
    echo json_encode($adopter);
}
?>