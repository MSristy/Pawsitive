<?php
// Database connection
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'pawsitive';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);
    $pet_type = $conn->real_escape_string($_POST['pet_type']);
    $pet_name = $conn->real_escape_string($_POST['pet_name']);
    $pet_breed = $conn->real_escape_string($_POST['pet_breed']);
    $pet_age = $conn->real_escape_string($_POST['pet_age']);
    $health_status = $conn->real_escape_string($_POST['health_status']);
    $start_date = $conn->real_escape_string($_POST['start_date']);
    $end_date = $conn->real_escape_string($_POST['end_date']);
    $reason = $conn->real_escape_string($_POST['reason']);

    // Handling file upload for pet picture
    $target_dir = "images/";
    $target_file = $target_dir . basename($_FILES["pet_picture"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is valid
    $check = getimagesize($_FILES["pet_picture"]["tmp_name"]);
    if ($check !== false && move_uploaded_file($_FILES["pet_picture"]["tmp_name"], $target_file)) {
        // Insert form data into the database
        $sql = "INSERT INTO temporary_housing (name, email, phone, address, pet_type, pet_name, pet_breed, pet_age, health_status, start_date, end_date, reason, pet_picture) 
                VALUES ('$name', '$email', '$phone', '$address', '$pet_type', '$pet_name', '$pet_breed', '$pet_age', '$health_status', '$start_date', '$end_date', '$reason', '$target_file')";

        if ($conn->query($sql) === TRUE) {
            echo "<p>Temporary housing application submitted successfully!</p>";
        } else {
            echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
        }
    } else {
        echo "File upload error.";
    }
}

$conn->close();
?>

<!-- HTML Form for Temporary Housing -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Temporary Housing Application</title>
    <link rel="stylesheet" href="style_temporary.css"> <!-- Link to the CSS file -->
</head>
<body>
<?php include('templates/header.php'); ?>
    <h2>Temporary Housing Application</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="name">Adopter's Name:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="phone">Phone Number:</label>
        <input type="text" id="phone" name="phone" required><br><br>

        <label for="address">Home Address:</label>
        <textarea id="address" name="address" rows="3" required></textarea><br><br>

        <label for="pet_type">Pet Type:</label>
        <select id="pet_type" name="pet_type" required>
            <option value="dog">Dog</option>
            <option value="cat">Cat</option>
            <option value="bird">Bird</option>
        </select><br><br>

        <label for="pet_name">Pet Name:</label>
        <input type="text" id="pet_name" name="pet_name" required><br><br>

        <label for="pet_breed">Pet Breed:</label>
        <input type="text" id="pet_breed" name="pet_breed"><br><br>

        <label for="pet_age">Pet Age:</label>
        <input type="text" id="pet_age" name="pet_age" required><br><br>

        <label for="health_status">Pet Health Status:</label>
        <textarea id="health_status" name="health_status" rows="2"></textarea><br><br>

        <label for="pet_picture">Upload Pet Picture:</label>
        <input type="file" id="pet_picture" name="pet_picture" accept="image/*" required><br><br>

        <label for="start_date">Preferred Start Date:</label>
        <input type="date" id="start_date" name="start_date" required><br><br>

        <label for="end_date">Preferred End Date:</label>
        <input type="date" id="end_date" name="end_date" required><br><br>

        <label for="reason">Reason for Temporary Housing:</label>
        <textarea id="reason" name="reason" rows="4" required></textarea><br><br>

        <input type="submit" value="Submit Temporary Housing Application">
    </form>
    <?php include('templates/footer.php'); ?>
</body>
</html>