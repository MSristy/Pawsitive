<?php 
    
    include('db_connect.php');


?>


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
        <section class="hero">
            <div class="hero-content">
                <h1>Find Your Perfect Pet</h1>
                <p>Connecting pets with loving homes.</p>
                <div class="hero-buttons">
                    <a href="find-a-pet.php" class="btn-adopt">I want to adopt a pet</a>
                    <a href="rehomers.php" class="btn-rehome">I need to rehome my pet</a>
                </div>
            </div>
        </section>

        <section class="box">
            <div class="container">
                <h2>Browse by Category</h2>
                <div class="catgr-grid">
                    <div class="catgr"><a href="find-a-pet.php"><img src="images/dog.png" alt="Dogs"><h4>Dogs</h4></a></div>
                    <div class="catgr"><a href="find-a-pet.php"><img src="images/dodo.png" alt="Cats"><h4>Cats</h4></a></div>
                    <div class="catgr"><a href="find-a-pet.php"><img src="images/bluebird.png" alt="Birds"><h4>Birds</h4></a></div>            
                </div>
            </div>
        </section>


        <section class="brands">
            <div class="container">
                <h2>Types Of Breeds Are Available at PAWSITIVE</h2>
                <div class="brands-grid">
                    <div class="brand"><a href="find-a-pet.php"><img src="images/dogpod.png" alt="Brand 1"><b>Poodle</b></a></div>
                    <div class="brand"><a href="find-a-pet.php"><img src="images/catExo.png" alt="Brand 2"><b>Exotic Shorthair</b></a></div>
                    <div class="brand"><a href="find-a-pet.php"><img src="images/nooo.png" alt="Brand 3"><b>Budgerigar</b></a></div>
                    <div class="brand"><a href="find-a-pet.php"><img src="images/dog2.png" alt="Brand 4"><b>Bichon Frisé </b></a></div>
                    <div class="brand"><a href="find-a-pet.php"><img src="images/catNor.png" alt="Brand 5"><b>Norwegian Forest cat</b></a></div>
                    <div class="brand"><a href="find-a-pet.php"><img src="images/imagas.png" alt="Brand 6"><b>Cockatiel</b></a></div>
                    
                </div>
            </div>
        </section>
    

        <section class="testimonials">
            <div class="container">
                <h2>Happy Adoption Stories</h2>
                <div class="testimonials-grid">
                    <div class="testimonial">
                        <img src="images/adopt3.png" alt="Happy Pet Owner">
                        <p>"Adopting from PAWSITIVE was the best decision ever!" - Helena</p>
                    </div>
                    <div class="testimonial">
                        <img src="images/m.jpg" alt="Happy Pet Owner">
                        <p>"Thank you PAWSITIVE for helping us find our furry friend." - Lisa</p>
                    </div>
                    <div class="testimonial">
                        <img src="images/adopt2.png" alt="Happy Pet Owner">
                        <p>"Our new puppy is the perfect addition to our family." - Maryam</p>
                    </div>
                </div>
            </div>
            <div>
                <p><a href="blog.php"><h2>Add Your Stories</h2></a></p>
            </div>
        </section>
    

    </main>

    <section class="cta">
        <div class="container">
            <h3>Join Our Community</h3>
            <p>Share your adoption stories and connect with other pet lovers.</p>
        </div>
    </section>

    <?php include('templates/footer.php'); ?>
    <script src="index.js"></script>
</body>
</html>