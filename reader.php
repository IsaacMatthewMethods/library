<?php
require 'functions.php';
requireLogin();

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$bookId = intval($_GET['id']);
$book = $conn->query("SELECT * FROM books WHERE id = $bookId")->fetch_assoc();

if (!$book) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $book['title'] ?> | <?= SITE_NAME ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="container">
            <a href="index.php" class="logo">
                <i class="fas fa-book-open"></i> <?= SITE_NAME ?>
            </a>
            <nav>
                <?php if (isAdmin()): ?>
                    <a href="admin.php"><i class="fas fa-tachometer-alt"></i> Admin</a>
                <?php endif; ?>
                <a href="index.php"><i class="fas fa-home"></i> Home</a>
                <a href="login.php?logout=1"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <div class="reader-header">
            <h1><?= $book['title'] ?></h1>
            <p>by <?= $book['author'] ?></p>
        </div>
        
        <div class="reader-content">
            <?php if (pathinfo($book['file_path'], PATHINFO_EXTENSION) === 'pdf'): ?>
                <embed src="assets/uploads/<?= $book['file_path'] ?>" type="application/pdf" width="100%" height="600px">
            <?php else: ?>
                <div class="text-content">
                    <?= file_get_contents("assets/uploads/" . $book['file_path']) ?>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="reader-actions">
            <a href="index.php" class="btn">Back to Library</a>
            <?php if (isAdmin()): ?>
                <a href="upload.php?delete=<?= $book['id'] ?>" class="btn delete-btn">Delete Book</a>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>