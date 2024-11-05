<?php
session_start();

// Check if admin is logged in (assuming you have an admin login system)
//if (!isset($_SESSION['admin_logged_in'])) {
   // header('Location: login.php');
    //exit();
//}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pawsitive";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle approval action
if (isset($_POST['approve'])) {
    $adopter_id = $conn->real_escape_string($_POST['a_id']);

    // Update adopter status to approved
    $sql = "UPDATE adopters SET status = 'approved' WHERE a_id = '$adopter_id'";
    
    if ($conn->query($sql) === TRUE) {
        // Generate certificate
       // $adopter_name = $_POST['name'];
        $adoption_date = $_POST['adoption_date'];
        $email = $_POST['email'];
        $phone_number = $_POST['phone'];
        $certificate_number = uniqid('CERT_');

        $sql_certificate = "INSERT INTO certificates (date_of_issue, adopter_email, certificate_number)
                            VALUES ('$adoption_date', '$email', '$certificate_number')";
        
        if ($conn->query($sql_certificate) === TRUE) {
            echo "<script>alert('Adoption approved and certificate issued successfully!');</script>";
        } else {
            echo "<script>alert('Error generating certificate: " . $conn->error . "');</script>";
        }
    } else {
        echo "<script>alert('Error updating status: " . $conn->error . "');</script>";
    }
}

// Fetch all adopters with their status
$sql = "SELECT * FROM adopters";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Approve Adoptions</title>
    <link rel="stylesheet" href="admin_adopters.css">
</head>
<body>
    <h1>Adoption Requests</h1>

    <table border="1">
        <thead>
            <tr>
                <th>Adopter ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Adoption Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['a_id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['phone_number']; ?></td>
                <td><?php echo $row['adoption_date']; ?></td>
                <td>
                    <?php if ($row['status'] === 'approved'): ?>
                        <span class="approved-tag">Approved</span>
                    <?php else: ?>
                        <span class="pending-tag">Pending</span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($row['status'] !== 'approved'): ?>
                        <form method="POST" action="">
                            <input type="hidden" name="a_id" value="<?php echo $row['a_id']; ?>">
                            <input type="hidden" name="name" value="<?php echo $row['name']; ?>">
                            <input type="hidden" name="email" value="<?php echo $row['email']; ?>">
                            <input type="hidden" name="phone" value="<?php echo $row['phone_number']; ?>">
                            <input type="hidden" name="adoption_date" value="<?php echo $row['adoption_date']; ?>">
                            <button type="submit" name="approve">Approve</button>
                        </form>
                    <?php else: ?>
                        <span>Already Approved</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <?php $conn->close(); ?>
</body>
</html>
