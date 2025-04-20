<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KadPoly Library</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        /* Add any necessary new CSS here, but try to minimize it */
        .landing-hero {
            background: url('assets/hero-bg.jpg') center/cover no-repeat; /* Assuming you have a hero image */
            height: 500px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
        }

        .landing-hero h1 {
            font-size: 3rem;
            margin-bottom: 20px;
        }

        .landing-hero p {
            font-size: 1.2rem;
            max-width: 600px;
            margin: 0 auto;
        }

        .cta-button {
            display: inline-block;
            background: var(--primary); /* Use primary color from style.css */
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

        .featured-books {
            padding: 50px 0;
        }

        .featured-books h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        /* You might need to adjust existing .book-grid styles or add new ones here for the landing page */
        .landing-book-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
        }

        .landing-book-card {
            /* Add styles if you need different card styles on the landing page */
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
        }

        /* Example of overriding existing styles for the landing page */
        /* .book-info h3 {  
            font-size: 1.5rem; 
        } */

        /* Responsive adjustments (you might need more based on testing) */
        @media (max-width: 768px) {
            .landing-hero {
                height: 400px;
            }
            .landing-hero h1 {
                font-size: 2.5rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <a href="index.php" class="logo">
                <i class="fas fa-book-open"></i> KadPoly Library
            </a>
            <nav>
                <a href="index.php">Home</a>
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
            </nav>
        </div>
    </header>

    <section class="landing-hero">
        <div class="container">
            <h1>Welcome to KadPoly Library</h1>
            <p>Explore our vast collection of books, available to read online anytime, anywhere. Discover new worlds and expand your knowledge with our digital library.</p>
            <a href="register.php" class="cta-button">Get Started</a>
        </div>
    </section>

    <section class="featured-books">
        <div class="container">
            <h2>Featured Books</h2>
            <div class="landing-book-grid">
                <!-- Example book cards (replace with dynamic content if needed) -->
                <div class="landing-book-card">
                    <img src="assets/covers/default.jpg" alt="Book 1" width="100%">
                    <h3>Book Title 1</h3>
                    <p>Author Name</p>
                </div>
                <div class="landing-book-card">
                    <img src="assets/covers/default.jpg" alt="Book 2" width="100%">
                    <h3>Book Title 2</h3>
                    <p>Author Name</p>
                </div>
                <div class="landing-book-card">
                    <img src="assets/covers/default.jpg" alt="Book 3" width="100%">
                    <h3>Book Title 3</h3>
                    <p>Author Name</p>
                </div>
                <!-- Add more book cards as needed -->
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <p>&copy; 2023 KadPoly Library. All rights reserved.</p>
        </div>
    </footer>

    <script src="scripts.js"></script>
</body>
</html>