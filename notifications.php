<?php 
include('db_connect.php');
session_start();

// Redirect if not logged in
//if (!isset($_SESSION['user_id'])) {
  //  header('Location: login.php');
   // exit();
//}

//$user_id = $_SESSION['user_id'];

// Mark all notifications as read when viewed
$update_sql = "UPDATE notifications SET is_read = 1 WHERE a_id = ?";
$update_stmt = $conn->prepare($update_sql);
$update_stmt->bind_param("i", $user_id);
$update_stmt->execute();

// Fetch notifications
$notifications_sql = "SELECT * FROM notifications WHERE a_id = ? ORDER BY created_at DESC";
$notifications_stmt = $conn->prepare($notifications_sql);
$notifications_stmt->bind_param("i", $user_id);
$notifications_stmt->execute();
$notifications_result = $notifications_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Notifications - PAWSITIVE</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include('templates/header.php'); ?>

    <main>
        <h1>Your Notifications</h1>
        <div class="notifications-container">
            <?php if ($notifications_result->num_rows > 0): ?>
                <ul>
                    <?php while ($notification = $notifications_result->fetch_assoc()): ?>
                        <li>
                            <p><?php echo $notification['message']; ?></p>
                            <small><?php echo $notification['created_at']; ?></small>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p>No notifications found.</p>
            <?php endif; ?>
        </div>
    </main>

    <?php include('templates/footer.php'); ?>
</body>
</html>
