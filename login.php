<?php
session_start(); // Start the session

$host = 'localhost';
$db = 'pawsitive';
$user = 'root'; 
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $login_type = $_POST['login_type']; // Get the selected login type (user/admin)

    if ($login_type === 'admin') {
        // Check if the email exists in the admins table
        $stmt = $conn->prepare('SELECT password FROM admins WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Admin found, verify password
            $stmt->bind_result($password_hash);
            $stmt->fetch();

            if (password_verify($password, $password_hash)) {
                $_SESSION['email'] = $email;
                header('Location: admin_home.php');
                exit();
            } else {
                $error = 'Invalid email or password for admin.';
            }
        } else {
            $error = 'Invalid email or password for admin.';
        }
    } else {
        // Check if the email exists in the users table
        $stmt = $conn->prepare('SELECT password FROM users WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // User found, verify password
            $stmt->bind_result($password_hash);
            $stmt->fetch();

            if (password_verify($password, $password_hash)) {
                $_SESSION['email'] = $email;
                header('Location: user_profile.php'); // Redirect to user profile
                exit();
            } else {
                $error = 'Invalid email or password for user.';
            }
        } else {
            $error = 'Invalid email or password for user.';
        }
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="container1">

    <div class="containert">
        <h2>Login</h2>
        <?php if ($error): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="login_type">Login as:</label><br>
                <input type="radio" id="user" name="login_type" value="user" checked>
                <label for="user">User</label>
                <input type="radio" id="admin" name="login_type" value="admin">
                <label for="admin">Admin</label>
            </div>
            <button type="submit">Login</button>
        </form>
        <p>Create an account? <a href="register.php">Register</a></p>
    </div>

</body>
</html>
