<?php
// Database connection
$host = 'localhost';  
$db   = 'pawsitive';    
$user = 'root';       
$pass = '';          

try {
    // Create a PDO instance (connect to the database)
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // If there is an error, print the error message
    die("Database connection failed: " . $e->getMessage());
}

// Pagination setup
$postsPerPage = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $postsPerPage;

// Fetch posts from database with pagination
$stmt = $pdo->prepare("SELECT * FROM user_posts WHERE is_approved = 1 ORDER BY date_submitted DESC LIMIT :start, :postsPerPage");
$stmt->bindParam(':start', $start, PDO::PARAM_INT);
$stmt->bindParam(':postsPerPage', $postsPerPage, PDO::PARAM_INT);
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get total number of posts for pagination
$totalPostsStmt = $pdo->query("SELECT COUNT(*) FROM user_posts WHERE is_approved = 1");
$totalPosts = $totalPostsStmt->fetchColumn();
$totalPages = ceil($totalPosts / $postsPerPage);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Adoption Blog</title>
    <link rel="stylesheet" href="style_blog.css">
</head>
<body>
<?php include('templates/header.php'); ?>
<div class="container">
    <a href="create_post.php" class="btn-apply">Blog Your Post</a>
</div>
   
<div class="content">
    <!-- Blog posts section -->
    <div class="posts">
        <?php foreach ($posts as $post): ?>
            <div class="post">
                <img src="<?= $post['picture']; ?>" alt="<?= $post['name']; ?>">
                <h2><?= $post['name']; ?></h2>
                <p class="meta">Posted on <?= $post['date_submitted']; ?></p>
                <p><?= $post['blog_post']; ?></p>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1; ?>">&laquo; Previous</a>
        <?php endif; ?>
        
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?= $i; ?>" class="<?= $i === $page ? 'active' : ''; ?>"><?= $i; ?></a>
        <?php endfor; ?>
        
        <?php if ($page < $totalPages): ?>
            <a href="?page=<?= $page + 1; ?>">Next &raquo;</a>
        <?php endif; ?>
    </div>
</div>
<?php include('templates/footer.php'); ?>
</body>
</html>
