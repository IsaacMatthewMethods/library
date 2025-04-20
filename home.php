<?php require 'functions.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= SITE_NAME ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="container">
            <a href="home.php" class="logo">
                <i class="fas fa-book-open"></i> <?= SITE_NAME ?>
            </a>
            <nav>
                <?php if (isLoggedIn()): ?>
                    <a href="index.php" class="landing-link">Main Page</a>
                    <?php if (isAdmin()): ?>
                        <a href="admin.php"><i class="fas fa-tachometer-alt"></i> Admin</a>
                    <?php endif; ?>
                    <a href="login.php?logout=1"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    
                <?php else: ?>
                    <a href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
                    <a href="register.php"><i class="fas fa-user-plus"></i> Register</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <section class="hero">
        <div class="container">
            <h1>Discover Thousands of Books</h1>
            <p>Read anytime, anywhere with KadPoly's digital library</p>
            <form action="home.php" method="get" class="search-box">
                <input type="text" name="search" placeholder="Search books...">
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </section>

    <main class="container">
        <h2>Featured Books</h2>
        <div class="book-grid">
            <?php
            $search = $_GET['search'] ?? '';
            $books = getBooks($search);
            
            if ($books->num_rows > 0):
                while ($book = $books->fetch_assoc()): ?>
                    <div class="book-card">
                        <div class="book-cover">
                            <img src="assets/covers/<?= $book['cover_image'] ?? 'default.jpg' ?>" alt="<?= $book['title'] ?>">
                        </div>
                        <div class="book-info">
                            <h3><?= $book['title'] ?></h3>
                            <p class="author"><?= $book['author'] ?></p>
                            <div class="actions">
                                <a href="reader.php?id=<?= $book['id'] ?>" class="btn read-btn">Read Now</a>
                                <?php if (isAdmin()): ?>
                                    <a href="upload.php?delete=<?= $book['id'] ?>" class="btn delete-btn">Delete</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile;
            else: ?>
                <p class="no-results">No books found<?= $search ? " for '$search'" : '' ?>.</p>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; <?= date('Y') ?> <?= SITE_NAME ?>. All rights reserved.</p>
        </div>
    </footer>

    <script src="scripts.js"></script>
</body>
</html>