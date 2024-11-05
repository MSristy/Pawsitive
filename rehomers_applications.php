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
    $pet_choice = $conn->real_escape_string($_POST['pet_choice']);
    $pet_age = $conn->real_escape_string($_POST['pet_age']);

    // Handling file upload for pet picture
    $target_dir = "images/";
    $target_file = $target_dir . basename($_FILES["pet_picture"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is valid
    $check = getimagesize($_FILES["pet_picture"]["tmp_name"]);
    if ($check !== false && move_uploaded_file($_FILES["pet_picture"]["tmp_name"], $target_file)) {
        // Insert form data into the database
        $sql = "INSERT INTO rehomers_application (name, email, phone, pet_choice, pet_age, pet_picture) 
                VALUES ('$name', '$email', '$phone', '$pet_choice', '$pet_age', '$target_file')";

        if ($conn->query($sql) === TRUE) {
            echo "<p>Application submitted successfully!</p>";
        } else {
            echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
        }
    } else {
        echo "File upload error.";
    }
}

$conn->close();
?>

<!-- HTML Form for Rehomers Application -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rehomers Application</title>
    <link rel="stylesheet" href="style_rehomers.css"> <!-- Link to the CSS file -->
</head>
<body>
<?php include('templates/header.php'); ?>
    <h2>Rehomers Application</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" required><br><br>

        <label for="pet_choice">Pet Choice:</label>
        <select id="pet_choice" name="pet_choice" required>
            <option value="dog">Dog</option>
            <option value="cat">Cat</option>
            <option value="bird">Bird</option>
        </select><br><br>

        <label for="pet_age">Pet Age:</label>
        <input type="text" id="pet_age" name="pet_age" required><br><br>

        <label for="pet_picture">Upload Pet Picture:</label>
        <input type="file" id="pet_picture" name="pet_picture" accept="image/*" required><br><br>

        <input type="submit" value="Submit Application">
    </form>
    <?php include('templates/footer.php'); ?>
</body>
</html>