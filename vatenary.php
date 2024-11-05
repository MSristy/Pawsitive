<?php
// Database connection
$host = 'localhost';
$db = 'pawsitive';
$user = 'root';
$pass = '';
$conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

// Fetch vet profiles
$query = "SELECT * FROM vets";
$vets = $conn->query($query);

// Fetch parks for suggestions
$parkQuery = "SELECT * FROM parks";
$parks = $conn->query($parkQuery);

// Fetch pet competitions
$competitionQuery = "SELECT * FROM competitions";
$competitions = $conn->query($competitionQuery);

// Handle form submission for appointment booking
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userName = $_POST['user_name'];
    $email = $_POST['email']; // Email field
    $petName = $_POST['pet_name'];
    $vetId = $_POST['vet_id'];
    $appointmentDate = $_POST['appointment_date'];
    $timeSlot = $_POST['time_slot']; // Time slot field
    $contactInfo = $_POST['contact_info'];

    // Insert appointment into the database
    $stmt = $conn->prepare("INSERT INTO vet_appointments (user_name, email, pet_name, id, appointment_date, time_slot, contact_info)
                            VALUES (:user_name, :email, :pet_name, :id, :appointment_date, :time_slot, :contact_info)");
    $stmt->execute([
        'user_name' => $userName,
        'email' => $email,
        'pet_name' => $petName,
        'id' => $vetId,
        'appointment_date' => $appointmentDate,
        'time_slot' => $timeSlot,
        'contact_info' => $contactInfo
    ]);

    echo "<script>alert('You have requested for the appointment. If your request is approved, we will notify you.');</script>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Veterinary System</title>
    <link rel="stylesheet" href="vet.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
<?php include('templates/header.php'); ?>
    <div class="vet-system">
        <!-- Veterinary Profiles -->
        <section class="vet-profiles">
            <h1>Our Veterinarians</h1>
            <div class="vet-container">
                <?php foreach ($vets as $vet): ?>
                    <div class="vet-card">
                        <img src="images/<?= $vet['image']; ?>" alt="Vet Image">
                        <h2><?= $vet['name']; ?></h2>
                        <p><b>Specialization:</b> <?= $vet['specialization']; ?></p>
                        <p><b>Experience:</b> <?= $vet['experience']; ?> years</p>
                        <p><b>Contact:</b> <?= $vet['contact']; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Book an Appointment -->
        <section class="appointment-form">
            <h2>Book a Veterinary Appointment</h2>
            <form action="vatenary.php" method="POST">
                <input type="email" name="email" id="email" placeholder="Your Email" required>
                <input type="text" name="user_name" id="user_name" placeholder="Your Name" readonly>
                <input type="text" name="pet_name" id="pet_name" placeholder="Pet Name" readonly>
                <select name="vet_id" required>
                    <option value="" disabled selected>Select a Veterinarian</option>
                    <option value="Dr. Sarah Lee">Dr. Sarah Lee</option>
                    <option value="Dr. John Smith">Dr. John Smith</option>
                    <option value="Dr. Emily Davis">Dr. Emily Davis</option>
                    <?php foreach ($vets as $vet): ?>
                        <option value="<?= $vet['id']; ?>"><?= $vet['name']; ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="date" name="appointment_date" required>
                <select name="time_slot" required>
                    <option value="" disabled selected>Select a Time Slot</option>
                    <option value="09:00">09:00 AM</option>
                    <option value="10:00">10:00 AM</option>
                    <option value="11:00">11:00 AM</option>
                    <option value="13:00">01:00 PM</option>
                    <option value="14:00">02:00 PM</option>
                    <option value="15:00">03:00 PM</option>
                    <option value="16:00">04:00 PM</option>
                </select>
                <input type="text" name="contact_info" id="contact_info" placeholder="Contact Info" readonly>
                <button type="submit">Book Appointment</button>
            </form>
        </section>

        <!-- Park Visit Suggestions -->
        <section class="park-suggestions">
            <h2>Suggested Parks Near You</h2>
            <div class="park-container">
                <?php foreach ($parks as $park): ?>
                    <div class="park-card">
                        <img src="images/<?= $park['image']; ?>" alt="<?= $park['name']; ?> Park">
                        <h3><?= $park['name']; ?></h3>
                        <p><a href="https://www.google.com/maps/search/?api=1&query=<?= urlencode($park['location']); ?>" target="_blank">
                            <?= $park['location']; ?>
                        </a></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Pet Competitions -->
        <section class="pet-competitions">
            <h2>Upcoming Pet Competitions</h2>
            <div class="competition-container">
                <?php foreach ($competitions as $competition): ?>
                    <div class="competition-card">
                        <img src="images/<?= $competition['image']; ?>" alt="<?= $competition['title']; ?> Competition">
                        <div class="competition-info">
                            <h3><?= $competition['title']; ?></h3>
                            <p>Date: <?= $competition['date']; ?></p>
                            <p>Location: <a href="https://www.google.com/maps/search/?api=1&query=<?= urlencode($competition['location']); ?>" target="_blank"><?= $competition['location']; ?></a></p>
                            <p>Contact: <?= $competition['contact']; ?></p>
                            <a href="competition_info.php?id=<?= $competition['id']; ?>" class="know-more-btn">Know More</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </div>

    <?php include('templates/footer.php'); ?>

    <script>
        $(document).ready(function() {
            $('#email').on('blur', function() {
                var email = $(this).val();
                if (email) {
                    $.ajax({
                        url: 'fetch_adopter.php',
                        type: 'POST',
                        data: {email: email},
                        success: function(data) {
                            var adopter = JSON.parse(data);
                            if (adopter) {
                                $('#user_name').val(adopter.name);
                                $('#pet_name').val(adopter.pet_name);
                                $('#contact_info').val(adopter.phone_number);
                            }
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>