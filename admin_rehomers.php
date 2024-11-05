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

// Handle approval action for rehomers
if (isset($_GET['approve_rehomers_id'])) {
    $approve_id = intval($_GET['approve_rehomers_id']);
    $sql = "UPDATE rehomers_application SET approved = 1 WHERE id = $approve_id";

    if ($conn->query($sql) === TRUE) {
        echo "<p style='color:green;'>Rehomers application approved successfully!</p>";
    } else {
        echo "<p style='color:red;'>Error: " . $conn->error . "</p>";
    }
}

// Handle approval action for temporary housing
if (isset($_GET['approve_temp_id'])) {
    $approve_id = intval($_GET['approve_temp_id']);
    $sql = "UPDATE temporary_housing SET approved = 1 WHERE id = $approve_id";

    if ($conn->query($sql) === TRUE) {
        echo "<p style='color:green;'>Temporary housing request approved successfully!</p>";
    } else {
        echo "<p style='color:red;'>Error: " . $conn->error . "</p>";
    }
}

// Fetch all rehomers applications from the database
$sql_rehomers = "SELECT * FROM rehomers_application ORDER BY approved ASC";
$result_rehomers = $conn->query($sql_rehomers);

// Fetch all temporary housing requests from the database
$sql_temporary = "SELECT * FROM temporary_housing ORDER BY approved ASC";
$result_temporary = $conn->query($sql_temporary);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rehomers Management - Admin</title>
    <link rel="stylesheet" href="admin_style.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f4;
        }
        img {
            border-radius: 8px;
        }
        .btn-approve {
            background-color: #28a745;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
        }
        .btn-approve:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <!-- Rehomers Applications Section -->
    <h2>Rehomers Applications</h2>
    <table border="1">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Pet Choice</th>
            <th>Pet Age</th>
            <th>Pet Picture</th>
            <th>Approval Status</th>
            <th>Actions</th>
        </tr>

        <?php if ($result_rehomers->num_rows > 0): ?>
            <?php while ($row = $result_rehomers->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                    <td><?php echo htmlspecialchars($row['pet_choice']); ?></td>
                    <td><?php echo htmlspecialchars($row['pet_age']); ?></td>
                    <td><img src="<?php echo htmlspecialchars($row['pet_picture']); ?>" alt="Pet Picture" width="100"></td>
                    <td><?php echo $row['approved'] ? 'Approved' : 'Pending'; ?></td>
                    <td>
                        <?php if (!$row['approved']): ?>
                            <a class="btn-approve" href="admin_rehomers.php?approve_rehomers_id=<?php echo intval($row['id']); ?>">Approve</a>
                        <?php else: ?>
                            Already Approved
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="8">No rehomers applications found.</td></tr>
        <?php endif; ?>
    </table>

    <!-- Temporary Housing Requests Section -->
    <h2>Temporary Housing Requests</h2>
    <table border="1">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Pet Type</th>
            <th>Pet Name</th>
            <th>Pet Breed</th>
            <th>Pet Age</th>
            <th>Health Status</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Reason</th>
            <th>Pet Picture</th>
            <th>Approval Status</th>
            <th>Actions</th>
        </tr>

        <?php if ($result_temporary->num_rows > 0): ?>
            <?php while ($row = $result_temporary->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                    <td><?php echo htmlspecialchars($row['address']); ?></td>
                    <td><?php echo htmlspecialchars($row['pet_type']); ?></td>
                    <td><?php echo htmlspecialchars($row['pet_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['pet_breed']); ?></td>
                    <td><?php echo htmlspecialchars($row['pet_age']); ?></td>
                    <td><?php echo htmlspecialchars($row['health_status']); ?></td>
                    <td><?php echo htmlspecialchars($row['start_date']); ?></td>
                    <td><?php echo htmlspecialchars($row['end_date']); ?></td>
                    <td><?php echo htmlspecialchars($row['reason']); ?></td>
                    <td><img src="<?php echo htmlspecialchars($row['pet_picture']); ?>" alt="Pet Picture" width="100"></td>
                    <td><?php echo $row['approved'] ? 'Approved' : 'Pending'; ?></td>
                    <td>
                        <?php if (!$row['approved']): ?>
                            <a class="btn-approve" href="admin_rehomers.php?approve_temp_id=<?php echo intval($row['id']); ?>">Approve</a>
                        <?php else: ?>
                            Already Approved
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="15">No temporary housing requests found.</td></tr>
        <?php endif; ?>
    </table>

</body>
</html>
