<?php

$host = 'localhost';  
$db   = 'pawsitive';  
$user = 'root';       
$pass = '';           

try {
    // Create a PDO instance (connect to the database)
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // If there is an error, print the error message
    die("Database connection failed: " . $e->getMessage());
}

// Initialize variables
$success = [];
$errors = [];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_post'])) {
    // Retrieve and sanitize form inputs
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $blog_post = trim($_POST['blog_post']);
    $picture = $_FILES['picture'];

    // Validation
    if (empty($name)) {
        $errors[] = "Name is required.";
    }
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if (empty($blog_post)) {
        $errors[] = "Blog post content is required.";
    }

    // Image upload validation
    if ($picture['error'] == UPLOAD_ERR_OK) {
        $target_dir = "images/"; 
        // Create the uploads directory if it doesn't exist
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . basename($picture["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($picture["tmp_name"]);
        if ($check === false) {
            $errors[] = "File is not an image.";
            $uploadOk = 0;
        }

        // Check file size (limit to 2MB)
        if ($picture["size"] > 2000000) {
            $errors[] = "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
            $errors[] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $errors[] = "Sorry, your file was not uploaded.";
        } else {
            // If everything is ok, try to upload file
            if (move_uploaded_file($picture["tmp_name"], $target_file)) {
                // File uploaded successfully
            } else {
                $errors[] = "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        $errors[] = "No image uploaded or there was an error with the image.";
    }

    // If no errors, insert the post into the database
    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO user_posts (name, email, blog_post, picture, is_approved) VALUES (:name, :email, :blog_post, :picture, 0)"); // Set approved to 0
        try {
            $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':blog_post' => $blog_post,
                ':picture' => isset($target_file) ? $target_file : null // Save the file path to the database
            ]);
            $success[] = "Your post has been submitted successfully! It will be reviewed by an admin.";
        } catch (PDOException $e) {
            $errors[] = "Failed to submit your post: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Your Post - Pet Adoption Blog</title>
    <link rel="stylesheet" href="style_blog.css">
</head>
<body>
<?php include('templates/header.php'); ?>
<div class="container">
    <div class="content">
        <form action="create_post.php" method="POST" enctype="multipart/form-data"> <!-- Added enctype for file upload -->
            <h2>Blog Your Post</h2>

            <?php if (!empty($success)): ?>
                <div class="success-messages">
                    <ul>
                        <?php foreach ($success as $msg): ?>
                            <li><?= htmlspecialchars($msg); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if (!empty($errors)): ?>
                <div class="error-messages">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>

            <label for="blog_post">Blog Post:</label>
            <textarea id="blog_post" name="blog_post" rows="10" required><?= isset($_POST['blog_post']) ? htmlspecialchars($_POST['blog_post']) : ''; ?></textarea>

            <label for="picture">Upload a Picture:</label>
            <input type="file" id="picture" name="picture" accept="images/*">

            <div class="button-container">
                <button type="submit" name="submit_post" class="btn-apply">Submit Post</button>
            </div>
        </form>
    </div>
</div>
<?php include('templates/footer.php'); ?>
</body>
</html>
