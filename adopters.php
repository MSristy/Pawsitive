<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

$servername = "localhost";
$username = "root"; 
$password = "";     
$dbname = "pawsitive";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $phone_number = $conn->real_escape_string($_POST['phoneNumber']);
    $email = $conn->real_escape_string($_POST['email']);
    $preference = $conn->real_escape_string($_POST['preference']);
    $adoption_date = $conn->real_escape_string($_POST['adoptionDate']);
    $experience = $conn->real_escape_string($_POST['experience']);
    $address = $conn->real_escape_string($_POST['city']);

    // Insert into adopters table
    $sql = "INSERT INTO adopters (name, phone_number, email, preferences, adoption_date, experience, address)
            VALUES ('$name', '$phone_number', '$email', '$preference', '$adoption_date', '$experience', '$address')";

    if ($conn->query($sql) === TRUE) {
        // After successfully adding the adopter, insert certificate details for them
        $certificate_number = uniqid('CERT_');
        $sql_certificate = "INSERT INTO certificates (date_of_issue, adopter_email, certificate_number)
                            VALUES ('$adoption_date', '$email', '$certificate_number')";

        if ($conn->query($sql_certificate) === TRUE) {
            echo "<script>alert('Your Adoption Request Is Pending!');</script>";

            // Add a link to download the certificate
            echo "<p>Thank you for your application</p>";

        } else {
            echo "<script>alert('Error generating certificate: " . $conn->error . "');</script>";
        }
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PAWSITIVE Adoption Application</title>
    <link rel="stylesheet" href="style_adopt.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <?php include('templates/header.php'); ?>

    <main>
        <section class="banner">
            <div class="content">
                <h2 class="left">Information for Adopters</h2>
            </div>
        </section>

        <section class="grid grid-1">
            <figure>
                <img src="images/sich.png" alt="">
            </figure>
            <figure>
                <img src="images/3.png" alt="" class="autoRotate">
            </figure>
            <h2 class="autoShow">Adoption Guideline</h2>
            <p>Be 18 years of age or older. Have identification showing your present and current address. Have the knowledge and consent of your landlord, if you rent or lease your residence, proof of official lease agreement is required to show approval that pet(s) are allowed within the residence. Be able and willing to spend the time and money necessary to provide training, medical treatment, and proper care for your pet.</p>
        </section>

        <section class="grid grid-2">
            <div class="autoShow">
                <figure>
                    <img src="images/trio.png" alt="">
                </figure>
                <p>
                    • AWGs should maintain good relations and open communications with adopters to encourage adopters to approach them as soon as possible if they have issues post-adoption.<br><br>
                    Each AWG should develop their own policies relating to the adoption and rehoming of dogs under their care based on the guiding principles above.
                </p>
            </div>
            <div class="autoShow">
                Public health and safety as well as animal health and welfare are priority; where necessary, public health and safety take precedence over animal health and welfare.<br>
                • AWGs should screen and assess individual dogs for their suitability to be rehomed, especially if they have any history of aggression.<br>
                • Biting history (if any) should be assessed using objective assessment tools e.g. Dunbar Dog Bite Scale.<br>
                • Existing medical and behavioural conditions and history should be clearly assessed and made known to all relevant stakeholders before adoption.<br>
                • Pre-adoption screening, adoption processes, and post-adoption support should be robust, and clearly communicated to the adopter.<br>
                • The pre-adoption process should not be rushed, and may include completion of application forms, screening of prospective adopters, matching of prospective adopters to suitable animals, assessment, etc. prior to the decision.<br>
                • It is important to educate adopters on animal health, behaviour, appropriate socialisation and training.<br>
                • Key clauses of adoption agreements should be made transparent to potential adopters at the onset, and adopters should acquaint themselves with the stated obligations early, to minimise misalignment of expectations by both parties.
            </div>
        </section>

        <div>
            <h1>Please Fill Up The Given Form To Adopt Your Chosen Pet</h1>
        </div>

        <div class="page-wrapper">
            <div class="form-container">
                <h2>Adoption Application Form</h2>
                <form id="adoptionForm" method="POST" action="">
                
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" placeholder="Enter your Name" required>
                    </div>

                    <div class="form-group">
                        <label for="phoneNumber">Phone Number:</label>
                        <input type="tel" id="phoneNumber" name="phoneNumber" placeholder="Enter your Phone Number" required>
                    </div>

                    <div class="form-group">
                        <label for="address">Address:</label>
                        <div class="address-dropdown">
                            <select id="city" name="city" required>
                                <option value="" disabled selected>Select City</option>
                                <option value="Dhaka">Dhaka</option>
                                <option value="Rajshahi">Rajshahi</option>
                                <option value="Barishal">Barishal</option>
                                <option value="Chittagong">Chittagong</option>
                                <option value="Khulna">Khulna</option>
                                <option value="Sylhet">Sylhet</option>
                                <option value="Rangpur">Rangpur</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" placeholder="Enter your Email" required>
                    </div>

                    <div class="form-group">
                        <label for="preference">Preference:</label>
                        <select id="preferences" name="preference" required>
                            <option value="" disabled selected>Select Preference</option>
                            <option value="Poodle">Poodle</option>
                            <option value="Exotic Shorthair">Exotic Shorthair</option>
                            <option value="Budgerigar">Budgerigar</option>
                            <option value="Bichon Frise">Bichon Frise</option>
                            <option value="Norwegian Forest Cat">Norwegian Forest Cat</option>
                            <option value="Cockatiel">Cockatiel</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="adoptionDate">Date of Adoption:</label>
                        <input type="date" id="adoption_date" name="adoptionDate" required>
                    </div>

                    <div class="form-group">
                        <label for="experience">Previous Experience:</label>
                        <textarea id="experience" name="experience" rows="4" placeholder="Describe any previous experience with pets" required></textarea>
                    </div>

                    <button type="submit">Submit Application</button>
                </form>
            </div>
        </div>
    </main>

    <?php include('templates/footer.php'); ?>

</body>
</html>
