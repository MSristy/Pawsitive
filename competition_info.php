
<?php
// Database connection
$host = 'localhost';
$db = 'pawsitive';
$user = 'root';
$pass = '';
$conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

// Fetch the competition details based on the ID passed via GET
if (isset($_GET['id'])) {
    $competitionId = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM competitions WHERE id = :id");
    $stmt->execute(['id' => $competitionId]);
    $competition = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$competition) {
        echo "Competition not found!";
        exit;
    }
} else {
    echo "No competition selected!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $competition['title']; ?> - Details</title>
    <link rel="stylesheet" href="vet.css">
    <link rel="stylesheet" href="competition_info.css">

</head>
<body>
    <?php include('templates/header.php'); ?>
    

    <div class="competition-details">
        <h1><?= $competition['title']; ?></h1>
        <p><strong>Date:</strong> <?= $competition['date']; ?></p>
        <p><strong>Location:</strong> <?= $competition['location']; ?></p>
        <p><strong>Contact:</strong> <?= $competition['contact']; ?></p>

        <h2>How to Win</h2>
        <p><?= $competition['how_to_win']; ?></p>

        <h2>Previous Winners</h2>
        <p><?= $competition['previous_winners']; ?></p>

        <a href="vatenary.php">Back to Competitions</a>
    </div>
    <?php include('templates/footer.php'); ?>
    <script src="index.js"></script>
</body>
</html>
