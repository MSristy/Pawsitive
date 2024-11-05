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

// Query for rehomers application
$rehomers_sql = "SELECT * FROM rehomers_application WHERE approved = 1";
$rehomers_result = $conn->query($rehomers_sql);

// Query for temporary housing
$temporary_housing_sql = "SELECT * FROM temporary_housing WHERE approved = 1";
$temporary_housing_result = $conn->query($temporary_housing_sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rehomers</title>
    <link rel="stylesheet" href="style_rehomers.css"> <!-- Link to the CSS file -->
</head>
<body>
<?php include('templates/header.php'); ?>
    <header>
        <nav class="navbar">
            <ul>
                <!-- Add any necessary navigation items here -->
            </ul>
        </nav>
    </header>

    <!-- Banner Section -->
    <section class="banner">
        <h1>Rehomers</h1>
        <div class="rehomers-button">
            <p>Help match pets with loving homes through our rehoming process.</p>
            <div class="application-box">
                <h2>Start the Rehomers Application Process</h2>
                <p>Click the button below to apply to rehome a pet.</p>
                <div class="button-container">
                    <a href="rehomers_applications.php" class="btn-apply">Rehomers Application</a> 
                    <a href="temporary_housing.php" class="btn-apply">Apply for Temporary Housing</a>
                </div>
            </div>
        </div>
    </section>

    <!-- The Rehoming Process Section -->
    <section class="process">
        <h2 style="text-align: center;">The Rehoming Process</h2>
        <div class="sidebar">
            <div class="container">
                <div class="step">
                    <img src="images/image02.png" alt="Application">
                    <h3>Application</h3>
                    <p>Fill out the application and we will get back to you within 48 hours.</p>
                </div>
                <div class="step">
                    <img src="images/images_03.png" alt="Follow-Up">
                    <h3>Follow-Up</h3>
                    <p>We will follow up with you to discuss your application.</p>
                </div>
                <div class="step">
                    <img src="images/image_5.png" alt="Placement">
                    <h3>Placement</h3>
                    <p>We will match you with an animal in need of rehoming.</p>
                </div>
                <div class="step">
                    <img src="images/image_6.png" alt="Home Visit">
                    <h3>Home Visit</h3>
                    <p>We'll schedule a home visit to ensure the environment is safe for the pet.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Reasons to Rehome Section -->
    <section class="reasons">
        <h2>Reasons to Rehome</h2>
        <div class="reason-content">
            <ul>
                <li>You're helping save a life!</li>
                <li>Pets get a better chance to find a loving home.</li>
                <li>You can foster a better environment for pets.</li>
                <li>You help pets develop social skills.</li>
            </ul>
        </div>
    </section>

    <!-- Approved Rehomers Applications Section -->
    <section class="approved-applications">
        <h2>Available Pets For Rehoming</h2>
        <?php if ($rehomers_result->num_rows > 0): ?>
            <table border="1">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Pet Choice</th>
                    <th>Pet Age</th>
                    <th>Pet Picture</th>
                    <th>Adoption</th>
                </tr>
                <?php while ($row = $rehomers_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['phone']); ?></td>
                        <td><?php echo htmlspecialchars($row['pet_choice']); ?></td>
                        <td><?php echo htmlspecialchars($row['pet_age']); ?></td>
                        <td><img src="<?php echo htmlspecialchars($row['pet_picture']); ?>" alt="Pet Picture" width="100"></td>
                        <td><a href="adopters.php?id=<?php echo intval($row['id']); ?>" class="btn-adopt">Adopt</a></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No approved rehomers applications found.</p>
        <?php endif; ?>
    </section>

    <!-- Approved Temporary Housing Section -->
    <section class="temporary-housing-section">
        <h2>Approved Temporary Housing Applications</h2>
        <?php if ($temporary_housing_result->num_rows > 0): ?>
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
                </tr>
                <?php while ($row = $temporary_housing_result->fetch_assoc()): ?>
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
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No approved temporary housing requests found.</p>
        <?php endif; ?>
    </section>

    <?php include('templates/footer.php'); ?>
</body>
</html>
