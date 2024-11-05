<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PAWSITIVE - Pet Adoption Platform</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
     <?php include('templates/header.php'); ?>
    
    <main>
        <section class="list-pet">
            <h2>List Your Pet for Adoption</h2>
            <form>
                <label for="pet-type">Pet Type</label>
                <select id="pet-type">
                    <option value="dog">Dog</option>
                    <option value="cat">Cat</option>
                    <option value="rabbit">Rabbit</option>
                </select>

                <label for="pet-name">Pet Name</label>
                <input type="text" id="pet-name" placeholder="Enter your pet's name">

                <label for="breed">Breed</label>
                <input type="text" id="breed" placeholder="Enter your pet's breed">

                <label for="age">Age</label>
                <input type="text" id="age" placeholder="Enter your pet's age">

                <label for="description">Description</label>
                <textarea id="description" rows="5" placeholder="Enter a description of your pet"></textarea>

                <label for="location">Location</label>
                <input type="text" id="location" placeholder="Enter your location">

                <button type="submit">List Pet</button>
            </form>
        </section>
    </main>
    <?php include('templates/footer.php'); ?>

    <script src="index.js"></script>
</body>
</html>
