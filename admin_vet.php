<?php
// Database connection
$host = 'localhost';
$db = 'pawsitive';
$user = 'root';
$pass = '';
$conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

// Function to send an email notification to the user
function sendNotification($userEmail, $appointmentId) {
    $subject = "Appointment Request Approved";
    $message = "Dear User,\n\nYour appointment request has been approved. Thank you for choosing our veterinary services!\n\nBest regards,\nPawsitive Team";
    $headers = "From: no-reply@pawsitive.com";

    // Send email
    if (mail($userEmail, $subject, $message, $headers)) {
        saveNotification($appointmentId, $userEmail); // Save notification in DB
        return true;
    } else {
        return false;
    }
}

// Function to save notification in the database
function saveNotification($appointmentId, $userEmail) {
    global $conn;

    $stmt = $conn->prepare("INSERT INTO notifications (appointment_id, user_email) VALUES (:appointment_id, :user_email)");
    $stmt->execute([
        'appointment_id' => $appointmentId,
        'user_email' => $userEmail
    ]);
}

// Fetch pending and confirmed appointments
$stmt = $conn->query("SELECT * FROM vet_appointments WHERE status IN ('pending', 'confirmed')");
$appointments = $stmt->fetchAll();

// Handle admin approval
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm'])) {
    $appointmentId = $_POST['appointment_id'];
    $userEmail = $_POST['user_email'];

    // Update appointment status
    $stmt = $conn->prepare("UPDATE vet_appointments SET status = 'confirmed' WHERE id = :appointment_id");
    $stmt->execute(['appointment_id' => $appointmentId]);

    // Send notification
    if (sendNotification($userEmail, $appointmentId)) {
        echo "<script>alert('Appointment approved and notification sent!');</script>";
    } else {
        echo "<script>alert('Failed to send notification.');</script>";
    }

    // Refresh page after approval
    header("Location: admin_vet.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Veterinary Appointments</title>
    <link rel="stylesheet" href="admin_vet.css">
</head>
<body>
    <h1>Manage Veterinary Appointments</h1>

    <table>
        <thead>
            <tr>
                <th>User Name</th>
                <th>Pet Name</th>
                <th>Appointment Date</th>
                <th>Contact Info</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($appointments as $appointment): ?>
                <tr>
                    <td><?= htmlspecialchars($appointment['user_name']); ?></td>
                    <td><?= htmlspecialchars($appointment['pet_name']); ?></td>
                    <td><?= htmlspecialchars($appointment['appointment_date']); ?></td>
                    <td><?= htmlspecialchars($appointment['contact_info']); ?></td>
                    <td>
                        <?= htmlspecialchars($appointment['status'] === 'confirmed' ? 'Confirmed' : 'Pending'); ?>
                    </td>
                    <td>
                        <?php if ($appointment['status'] === 'pending'): ?>
                            <form method="POST">
                                <input type="hidden" name="appointment_id" value="<?= $appointment['id']; ?>">
                                <input type="hidden" name="user_email" value="<?= $appointment['contact_info']; ?>">
                                <button type="submit" name="confirm">Confirm</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
