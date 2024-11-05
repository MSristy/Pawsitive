<?php
session_start(); // Ensure the session is started

// Initialize variables
$error = '';
$success = '';
$email = '';

// Check if the user is logged in
//if (!isset($_SESSION['user_email'])) {
  //  header('Location: login.php'); // Redirect to login page if not logged in
  //  exit();
//}

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

// Fetch user data based on session email
$user_email = $_SESSION['email'];
$stmt = $conn->prepare('SELECT id, email FROM users WHERE email = ?');
$stmt->bind_param('s', $user_email);
$stmt->execute();
$stmt->bind_result($user_id, $email);
$stmt->fetch();
$stmt->close();

// Handle profile update (email and password)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $new_email = $_POST['email'];
    $new_password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    if (!empty($new_password) && $new_password === $confirm_password) {
        $password_hash = password_hash($new_password, PASSWORD_BCRYPT);

        // Update email and password
        $stmt = $conn->prepare('UPDATE users SET email = ?, password = ? WHERE id = ?');
        $stmt->bind_param('ssi', $new_email, $password_hash, $user_id);
    } elseif (empty($new_password)) {
        // Only update email if password fields are empty
        $stmt = $conn->prepare('UPDATE users SET email = ? WHERE id = ?');
        $stmt->bind_param('si', $new_email, $user_id);
    } else {
        $error = "Passwords do not match.";
    }

    if (empty($error) && $stmt->execute()) {
        $success = 'Profile updated successfully!';
        $_SESSION['email'] = $new_email; // Update session email
    } else {
        $error = 'Error updating profile: ' . $stmt->error;
    }
    $stmt->close();
}

// Handle adding new pet
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_pet'])) {
    $pet_type = $_POST['pet_type'];
    $pet_picture = 'uploads/default_pet.png'; // Default pet image

    // Handle file upload for pet picture
    if (isset($_FILES['pet_picture']) && $_FILES['pet_picture']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['pet_picture']['tmp_name'];
        $file_name = 'uploads/' . uniqid() . '_' . $_FILES['pet_picture']['name'];
        move_uploaded_file($file_tmp, $file_name);
        $pet_picture = $file_name;
    }

    // Insert pet into the database
    $stmt = $conn->prepare('INSERT INTO user_pets (user_id, pet_type, pet_picture) VALUES (?, ?, ?)');
    $stmt->bind_param('iss', $user_id, $pet_type, $pet_picture);
    
    if ($stmt->execute()) {
        $success = "Pet added successfully!";
    } else {
        $error = "Error adding pet: " . $stmt->error;
    }
    $stmt->close();
}

// Fetch user's pets
$pets = [];
$stmt = $conn->prepare('SELECT pet_type, pet_picture FROM user_pets WHERE user_id = ?');
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($pet_type, $pet_picture);
while ($stmt->fetch()) {
    $pets[] = ['type' => $pet_type, 'picture' => $pet_picture];
}
$stmt->close();

// Fetch adopter status and certificate (if approved)
$stmt = $conn->prepare('SELECT status FROM adopters WHERE email = ?');
$stmt->bind_param('s', $user_email);
$stmt->execute();
$stmt->bind_result($status);
$stmt->fetch();
$stmt->close();

$certificate_number = '';
$date_of_issue = '';
$pet_name = ''; // Initialize pet_name

if ($status == 'approved') {
    // Fetch certificate details if adoption is approved
    $stmt_cert = $conn->prepare('SELECT certificate_number, date_of_issue, pet_name FROM certificates WHERE adopter_email = ?');
    $stmt_cert->bind_param('s', $user_email);
    $stmt_cert->execute();
    $stmt_cert->bind_result($certificate_number, $date_of_issue, $pet_name);
    $stmt_cert->fetch();
    $stmt_cert->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="user_profile_style.css">
</head>
<body>

<div class="container">
    <h2>User Profile</h2>

    <?php if ($error): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <?php if ($success): ?>
        <p style="color: green;"><?php echo htmlspecialchars($success); ?></p>
    <?php endif; ?>

    <!-- Profile Update Form -->
    <form action="user_profile.php" method="POST">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
        </div>
        <div class="form-group">
            <label for="password">New Password:</label>
            <input type="password" id="password" name="password">
        </div>
        <div class="form-group">
            <label for="confirm-password">Confirm Password:</label>
            <input type="password" id="confirm-password" name="confirm-password">
        </div>
        <button type="submit" name="update_profile">Update Profile</button>
    </form>

    <!-- Add New Pet Form -->
    <h3>Add a New Pet</h3>
    <form action="user_profile.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="pet_type">Pet Type:</label>
            <input type="text" id="pet_type" name="pet_type" required>
        </div>
        <div class="form-group">
            <label for="pet_picture">Pet Picture:</label>
            <input type="file" id="pet_picture" name="pet_picture" accept="image/*">
        </div>
        <button type="submit" name="add_pet">Add Pet</button>
    </form>

    <!-- Display User's Pets -->
    <h3>Your Pets</h3>
    <div class="pets-container">
        <?php foreach ($pets as $pet): ?>
            <div class="pet-card">
                <img src="<?php echo htmlspecialchars($pet['picture']); ?>" alt="Pet Picture">
                <p>Type: <?php echo htmlspecialchars($pet['type']); ?></p>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Adoption Certificate (if approved) -->
    <?php if ($status == 'approved') { ?>
    <div class="certificate-section">
        <h3>Adoption Certificate</h3>
        <button id="printCertificate">Download Certificate</button>
        
        <div id="certificate" style="display: none;">
        <div class="certificate">
    <img src="images/logo1.jpg" alt="Logo">
    <h1>Adoption Certificate</h1>
    <p class="certify">This certifies that you have adopted a pet from Pawsitive</p>
    <h2>John Doe</h2>
    <div class="details">
        <p>Certificate Number: CERT_123456789</p>
        <p>Date of Issue: 2024-10-03</p>
    </div>
    <p class="thanks">Thanks for your adoption!</p>
    <div class="bottom-text">
        <p>Powered by Pawsitive</p>
    </div>
</div>

        </div>
    </div>
<?php } else { ?>
    <p>Your adoption request is still pending approval.</p>
<?php } ?>

    <a href="logout.php">Logout</a>
</div>

<script>
    document.getElementById('printCertificate').onclick = function() {
        var certificate = document.getElementById('certificate');
        var printWindow = window.open('', '', 'width=800,height=600');
        printWindow.document.write('<html><head><title>Certificate</title>');
        printWindow.document.write('<style>body { font-family: Arial, sans-serif; }</style>');
        printWindow.document.write('</head><body>');
        printWindow.document.write(certificate.innerHTML);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    };
</script>

</body>
</html>
