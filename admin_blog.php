<?php
$host = 'localhost';  
$db   = 'pawsitive';  
$user = 'root';       
$pass = '';           

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Handle post approval
if (isset($_GET['approve_id'])) {
    $approveId = (int)$_GET['approve_id'];
    $stmt = $pdo->prepare("UPDATE user_posts SET approved = 1 WHERE id = :id");
    $stmt->execute([':id' => $approveId]);
    header("Location: admin_blog.php");
    exit();
}

// Fetch posts from database for admin view
$stmt = $pdo->prepare("SELECT * FROM user_posts WHERE approved = 0 ORDER BY date_submitted DESC");
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Blog - Pet Adoption Blog</title>
    <link rel="stylesheet" href="style_blog.css">
</head>
<body>
<?php include('templates/header.php'); ?>
<div class="container">
    <h2>User Posts Awaiting Approval</h2>
    <div class="posts">
        <?php foreach ($posts as $post): ?>
            <div class="post">
                <img src="<?= $post['picture']; ?>" alt="<?= $post['blog_post']; ?>">
                <h2><?= htmlspecialchars($post['blog_post']); ?></h2>
                <p class="meta">Submitted by <?= htmlspecialchars($post['name']); ?> on <?= $post['date_submitted']; ?></p>
                <a href="admin_blog.php?approve_id=<?= $post['id']; ?>" class="btn-apply">Approve</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php include('templates/footer.php'); ?>
</body>
</html>
