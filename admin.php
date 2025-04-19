<?php
require 'functions.php';
requireAdmin();

// Get stats
$booksCount = $conn->query("SELECT COUNT(*) FROM books")->fetch_row()[0];
$usersCount = $conn->query("SELECT COUNT(*) FROM users")->fetch_row()[0];
$adminsCount = $conn->query("SELECT COUNT(*) FROM users WHERE role = 'admin'")->fetch_row()[0];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | <?= SITE_NAME ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="container">
            <a href="index.php" class="logo">
                <i class="fas fa-book-open"></i> <?= SITE_NAME ?>
            </a>
            <nav>
                <a href="landing.html" class="landing-link">Landing</a>
                <a href="admin.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                <a href="upload.php"><i class="fas fa-upload"></i> Upload Books</a>
                <a href="manage_users.php"><i class="fas fa-users"></i> Manage Users</a>
                <a href="index.php"><i class="fas fa-home"></i> Home</a>
                <a href="login.php?logout=1"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <h1>Admin Dashboard</h1>
        
        <div class="dashboard-stats">
            <div class="stat-card">
                <h3><?= $booksCount ?></h3>
                <p>Total Books</p>
            </div>
            
            <div class="stat-card">
                <h3><?= $usersCount ?></h3>
                <p>Total Users</p>
            </div>
            
            <div class="stat-card">
                <h3><?= $adminsCount ?></h3>
                <p>Admin Users</p>
            </div>
        </div>
        
        <div class="recent-uploads">
            <h2>Recent Uploads</h2>
            <?php
            $recentBooks = $conn->query("SELECT * FROM books ORDER BY upload_date DESC LIMIT 5");
            if ($recentBooks->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($book = $recentBooks->fetch_assoc()): ?>
                            <tr>
                                <td><?= $book['title'] ?></td>
                                <td><?= $book['author'] ?></td>
                                <td><?= date('M j, Y', strtotime($book['upload_date'])) ?></td>
                                <td>
                                    <a href="reader.php?id=<?= $book['id'] ?>" class="btn read-btn">View</a>
                                    <a href="upload.php?delete=<?= $book['id'] ?>" class="btn delete-btn">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No books uploaded yet.</p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>