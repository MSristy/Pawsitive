<?php

// Database connection
$host = 'localhost'; 
$db = 'pawsitive';
$user = 'root'; 
$pass = ''; 

$conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

// Fetch pet data from the database
$query = "SELECT * FROM pets1";
$stmt = $conn->prepare($query);
$stmt->execute();
$pets = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style_findPet.css"> 
    <title>Find a Pet</title>
</head>

<body>
<?php include('templates/header.php'); ?>

<div class="find-pet-container">
    <h1>Find Your Perfect Pet here</h1>
    <p>Connecting pets with loving homes.</p>
    
    <div class="pet-buttons">
        <a href="rehomers.php" class="btn">I need to rehome my pet</a>
        <a href="query.php" class="btn">I have some quaries</a>
    </div>

    <div class="pet-list">
        <?php foreach ($pets as $pet): ?>
            <div class="pet-card">
                <img src="<?= $pet['image_url']; ?>" alt="<?= $pet['name']; ?>">
                <h3><?= $pet['name']; ?></h3>
                <p><b>Breed:</b>  <?= $pet['breed']; ?></p>
                <p><b>Age:</b>  <?= $pet['age']; ?></p>
                <p><b>Gender:</b>  <?= $pet['gender']; ?></p>
                <p><b>Pet Size:</b>  <?= $pet['pet_size']; ?></p>
                <p><b>Adoption Fee:</b>   <?= $pet['fee']; ?></p>
                <p><b>Temperament:</b>   <?= $pet['temp']; ?></p>
                <a href="adopters.php?id=<?= $pet['id']; ?>" class="btn">Adopt Now</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include('templates/footer.php'); ?>

<script src="index.js"></script>

</body>
</html>
