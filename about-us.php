<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - PAWSITIVE</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <?php include('templates/header.php'); ?>

    <main>
        <section class="about-us">
            <h2>About Us</h2>
            <p>Welcome to PAWSITIVE, your trusted platform for pet adoption and care. Our mission is to connect loving families with pets in need of homes. Whether you're looking to adopt, foster, or learn more about pet care, we are here to support you every step of the way.</p>

            <div class="about-details">
                <div class="about-item">
                    <i class="fas fa-paw"></i>
                    <h3>Our Mission</h3>
                    <p>To provide a platform where pets can find loving homes and families can find the perfect pet companion.</p>
                </div>
                <div class="about-item">
                    <i class="fas fa-heart"></i>
                    <h3>Our Values</h3>
                    <p>We believe in the power of love and responsibility when it comes to pet ownership. Our values are centered around compassion, care, and a lifelong commitment to pets.</p>
                </div>
                <div class="about-item">
                    <i class="fas fa-users"></i>
                    <h3>Our Community</h3>
                    <p>Our community of pet lovers, adopters, and foster families is growing every day. Join us to help make a difference in the lives of pets and their future families.</p>
                </div>
            </div>

            <div class="contact-info">
                <h3>Contact Us</h3>
                <p>If you have any questions, feel free to reach out to us:</p>
                <ul>
                    <?php
                   
                    $conn = new mysqli('localhost', 'root', '', 'Pawsitive');
                    
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $sql = "SELECT contact_type, contact_value FROM contact_info";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        
                        while ($row = $result->fetch_assoc()) {
                            if ($row['contact_type'] == 'phone') {
                                echo '<li><i class="fas fa-phone"></i> Phone: <a href="tel:' . $row['contact_value'] . '">' . $row['contact_value'] . '</a></li>';
                            } elseif ($row['contact_type'] == 'email') {
                                echo '<li><i class="fas fa-envelope"></i> Email: <a href="mailto:' . $row['contact_value'] . '">' . $row['contact_value'] . '</a></li>';
                            } elseif ($row['contact_type'] == 'facebook') {
                                echo '<li><i class="fab fa-facebook"></i> Facebook: <a href="' . $row['contact_value'] . '" target="_blank">' . $row['contact_value'] . '</a></li>';
                            }
                        }
                    } else {
                        echo '<li>No contact information available.</li>';
                    }

                    $conn->close();
                    ?>
                </ul>
            </div>
        </section>
    </main>

    <?php include('templates/footer.php'); ?>

    <script src="index.js"></script>
</body>
</html>