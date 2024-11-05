<?php
session_start();

// Check if admin is logged in
//if (!isset($_SESSION['admin_email'])) {
  //  header('Location: login.php'); // Redirect to login page if not logged in
   //exit();
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

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register_admin'])) {
    $email = $_POST['email'];
    $password = $_POST['new-password'];
    $confirm_password = $_POST['confirm-password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        $error = 'Passwords do not match.';
    } else {
        // Check if the email already exists
        $stmt = $conn->prepare('SELECT * FROM admins WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = 'Email already exists.';
        } else {
            // Password hash and insert into admins table
            $password_hash = password_hash($password, PASSWORD_BCRYPT);

            $stmt = $conn->prepare('INSERT INTO admins (email, password) VALUES (?, ?)');
            $stmt->bind_param('ss', $email, $password_hash);

            if ($stmt->execute()) {
                $success = 'Admin registration successful!';
            } else {
                $error = 'Error: ' . $stmt->error;
            }
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Pawsitive</title>
    <style>
        /* General Body Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
        }
        /* Navbar Styles */
        .navbar {
            background-color: #333;
            overflow: hidden;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 10;
        }
        .navbar ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        .navbar ul li {
            display: inline-block;
        }
        .navbar ul li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .navbar ul li a:hover {
            background-color: #575757;
            color: white;
        }
        /* Dashboard Container */
        .dashboard {
            padding: 60px 20px;
            max-width: 1200px;
            margin: 80px auto;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .dashboard h1 {
            font-size: 36px;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }
        .dashboard p {
            font-size: 18px;
            color: #666;
            margin-bottom: 20px;
            text-align: center;
        }
        /* Admin Registration Form */
        form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }
        form .form-group {
            margin-bottom: 20px;
        }
        form .form-group label {
            font-size: 16px;
            color: #333;
            margin-bottom: 10px;
            display: block;
        }
        form .form-group input {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        form .form-group input:focus {
            outline: none;
            border-color: #777;
        }
        form button {
            background-color: #5cb85c;
            color: white;
            padding: 12px 20px;
            font-size: 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        form button:hover {
            background-color: #4cae4c;
        }
        /* Success and Error Messages */
        p[style="color: red;"] {
            text-align: center;
            font-weight: bold;
            color: #e74c3c;
        }
        p[style="color: green;"] {
            text-align: center;
            font-weight: bold;
            color: #2ecc71;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <ul>
            <li><a href="admin_home.php">Dashboard</a></li>
            <li><a href="admin_rehomers.php">Rehomers</a></li>
            <li><a href="admin_adoption.php">Adopters</a></li>
            <li><a href="admin_blog.php">Blog</a></li>
            <li><a href="admin_vet.php">Veterinary</a></li>
            <li><a href="admin_logout.php">Logout</a></li>
        </ul>
    </nav>

    <div class="dashboard">
        <h1>Welcome to the Admin Panel</h1>
        <p>Use the navigation bar to manage different sections of the website.</p>

        <h2>Register New Admin</h2>
        <?php if ($error): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <?php if ($success): ?>
            <p style="color: green;"><?php echo $success; ?></p>
        <?php endif; ?>

        <form action="admin_home.php" method="POST">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="new-password">Password:</label>
                <input type="password" id="new-password" name="new-password" required>
            </div>
            <div class="form-group">
                <label for="confirm-password">Confirm Password:</label>
                <input type="password" id="confirm-password" name="confirm-password" required>
            </div>
            <button type="submit" name="register_admin">Register Admin</button>
        </form>
    </div>
</body>
</html>
