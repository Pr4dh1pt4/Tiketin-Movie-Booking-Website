<?php
session_start();

if (isset($_GET['pesan'])) {
    
    $pesan = $_GET['pesan'];
    $alert_msg = "";

    if ($pesan == "success") {
        $alert_msg = "Registration successful! Welcome to Ticketin!";
    } 
    // Tampilkan Javascript Alert jika pesan tidak kosong
    if ($alert_msg != "") {
        echo 
        "<script>
            window.history.replaceState(null, null, window.location.pathname);
            alert('$alert_msg');
        </script>";
    }
}
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiketin - Book Your Movie Tickets Now!</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #0a0a0a;
            color: #fff;
        }

        header {
            background-color: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(10px);
            padding: 15px 50px;
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            position: fixed;
            width: calc(100% - 100px);
            max-width: 1400px;
            left: 50%;
            transform: translateX(-50%);
            top: 20px;
            z-index: 1000;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        header:hover {
            background-color: rgba(0, 0, 0, 0.9);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.6);
        }

        .logo {
            display: flex;
            align-items: center;
            font-size: 24px;
            font-weight: bold;
            color: #f9e103;
        }

        .logo::before {
            content: url('assets/Vector.png');
            margin-right: 10px;
            margin-top: 5px;
            font-size: 28px;
        }

        nav {
            display: flex;
            gap: 30px;
            align-items: center;
            justify-content: center;
            flex: 1;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            font-size: 16px;
            transition: color 0.3s;
        }

        nav a:hover {
            color: #f9e103;
        }

        .user-dropdown {
            position: relative;
        }

        .user-name-btn {
            color: #fff; 
            text-decoration: none;
            font-weight: bold;
            padding: 10px;
            display: block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: #1a1a1a;
            min-width: 100%;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            border-radius: 5px;
            z-index: 1;
            border: 1px solid #333;
            border-radius: 10px;
        }

        .dropdown-content a {
            color: #fff;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            font-size: 14px;
            border-radius: 10px;
        }

        .dropdown-content a:hover {
            background-color: #f9e103;
            color: #000;
        }

        .user-dropdown:hover .dropdown-content {
            display: block;
        }

        .auth-buttons {
            display: flex;
            justify-content: flex-end; 
            gap: 15px;
        }

        .btn {
            padding: 8px 15px;
            text-decoration: none;
            transition: all 0.3s;
            cursor: pointer;
            border: none;
            background: transparent;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 16px;
        }

        .btn-login {
            color: #fff;
        }

        nav a:hover, nav a.active {
            color: #f9e103;
        }

        .btn-signup {
            color: #f9e103;
            font-weight: normal;
        }

        .btn:hover {
            opacity: 0.8;
        }

        /* Hero Section */
        .hero {
            margin-top: 0;
            height: 600px;
            padding-top: 120px;
            background-image: url('assets/Group 1.png');
            background-size: cover;
            background-position: center;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 20px;
            overflow: hidden;
        }

        .hero::before {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 180px;
            font-weight: 900;
            color: rgba(255, 255, 255, 0.03);
            letter-spacing: 20px;
            white-space: nowrap;
            z-index: 0;
        }

        .hero::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            height: 40%; 
            background: linear-gradient(
                to top,            
                rgba(0, 0, 0, 1) 0%,
                rgba(0, 0, 0, 0.6) 40%, 
                rgba(0, 0, 0, 0) 100% 
            );
            pointer-events: none;
            z-index: 1;
        }

        .hero h1 {
            font-size: 72px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 20px;
            text-shadow: 3px 3px 10px rgba(0, 0, 0, 0.8);
            line-height: 1.2;
            position: relative;
            z-index: 2;
        }

        .hero .highlight {
            color: #f9e103;
        }

        /* Movies Grid */
        .movies-section {
            padding: 50px;
            max-width: 1400px;
            margin: -100px auto 0;
            position: relative;
            z-index: 10;
        }

        .movies-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 30px;
            margin-top: 30px;
        }

        .movie-link {
            text-decoration: none;
        }

        .movie-card {
            position: relative;
            border-radius: 10px;
            overflow: hidden;
            cursor: pointer;
            transition: transform 0.3s;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
        }

        .movie-card:hover {
            transform: translateY(-10px);
        }

        .movie-poster {
            width: 100%;
            height: 300px;
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .movie-poster::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, transparent 0%, rgba(0,0,0,0.8) 100%);
            opacity: 0;
            transition: opacity 0.3s;
        }

        .movie-card:hover .movie-poster::before {
            opacity: 1;
        }

        .movie-title {
            position: relative;
            z-index: 1;
            padding: 15px;
            font-size: 14px;
            font-weight: bold;
            color: #fff;
            text-align: center;
            background: rgba(0,0,0,0.7);
            width: 100%;
            transform: translateY(100%);
            transition: transform 0.3s;
        }

        .movie-card:hover .movie-title {
            transform: translateY(0);
        }

        /* Footer */
        footer {
            background-color: #000;
            padding: 30px;
            text-align: center;
            margin-top: 50px;
        }

        footer p {
            color: #888;
        }
 
        /* Responsive */
        @media (max-width: 768px) {
            header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                
                width: 92%;
                padding: 12px 15px;
                top: 15px;
                
                left: 50%;
                transform: translateX(-50%);
                
                grid-template-columns: none;
            }

            .logo {
                font-size: 20px;
            }

            .logo::before {
                font-size: 24px;
            }

            .auth-buttons {
                gap: 10px;
            }

            .user-name-btn, .btn {
                font-size: 14px;
                padding: 5px;
            }

            .hero::before {
                font-size: 60px;
                letter-spacing: 5px;
            }

            .hero h1 {
                font-size: 36px;
            }

            .movies-grid {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
                gap: 15px;
            }

            nav {
                gap: 15px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <header>
        <a class="logo">Tiketin</a>
        <nav>
            <a href="index.php" class="active">Movies</a>
            <a href="cinemas.php">Cinemas</a>
            <a href="tickets.php">Tickets</a>
        </nav>
        <div class="auth-buttons"> 
            <?php if (isset($_SESSION['nama_lengkap'])): ?>
                <div class="user-dropdown">
                    <a href="#" class="user-name-btn">
                        <?php echo htmlspecialchars($_SESSION['nama_lengkap']); ?> ▾
                    </a>
                    <div class="dropdown-content">
                        <a href="logout.php" class="logout-link">Logout</a>
                    </div>
                </div>
            <?php else: ?>
                <a href="login.php" class="btn btn-login">Login</a>
                <a href="register.php" class="btn btn-signup">Sign Up</a>
            <?php endif; ?>
        </div>
    </header>

    <section class="hero">
        <h1>
            BOOK YOUR MOVIE<br>
            TICKETS <span class="highlight">NOW!</span>
        </h1>
    </section>

    <section class="movies-section">
        <div class="movies-grid">
            <?php
            $movies = [
                [
                    'title' => 'Spider-Man: No Way Home',
                    'poster' => 'https://image.tmdb.org/t/p/w500/1g0dhYtq4irTY1GPXvft6k4YLjm.jpg'
                ],
                [
                    'title' => 'Avengers: Endgame',
                    'poster' => 'https://image.tmdb.org/t/p/w500/or06FN3Dka5tukK1e9sl16pB3iy.jpg'
                ],
                [
                    'title' => 'Avengers: Infinity War',
                    'poster' => 'https://image.tmdb.org/t/p/w500/7WsyChQLEftFiDOVTGkv3hFpyyt.jpg'
                ],
                [
                    'title' => 'Avengers: Age of Ultron',
                    'poster' => 'https://image.tmdb.org/t/p/w500/4ssDuvEDkSArWEdyBl2X5EHvYKU.jpg'
                ],
                [
                    'title' => 'Captain America: Civil War',
                    'poster' => 'https://media.themoviedb.org/t/p/w440_and_h660_face/uymMGErUAUXElLJE4jTUrDMT7wr.jpg'
                ],
                [
                    'title' => 'Spider-Man: Far From Home',
                    'poster' => 'https://image.tmdb.org/t/p/w500/4q2NNj4S5dG2RLF9CpXsej7yXl.jpg'
                ],
                [
                    'title' => 'The Matrix Resurrections',
                    'poster' => 'https://image.tmdb.org/t/p/w500/8c4a8kE7PizaGQQnditMmI1xbRp.jpg'
                ],
                [
                    'title' => 'Black Widow',
                    'poster' => 'https://image.tmdb.org/t/p/w500/qAZ0pzat24kLdO3o8ejmbLxyOac.jpg'
                ],
                [
                    'title' => 'Mad Max: Fury Road',
                    'poster' => 'https://image.tmdb.org/t/p/w500/hA2ple9q4qnwxp3hKVNhroipsir.jpg'
                ],
                [
                    'title' => 'Guardians of the Galaxy',
                    'poster' => 'https://image.tmdb.org/t/p/w500/r7vmZjiyZw9rpJMQJdXpjgiCOk9.jpg'
                ],
                [
                    'title' => 'Thor: Ragnarok',
                    'poster' => 'https://image.tmdb.org/t/p/w500/rzRwTcFvttcN1ZpX2xv4j3tSdJu.jpg'
                ],
                [
                    'title' => 'Black Panther',
                    'poster' => 'https://image.tmdb.org/t/p/w500/uxzzxijgPIY7slzFvMotPv8wjKA.jpg'
                ]
            ];

            // menampilkan movie cards
            foreach ($movies as $index => $movie) {
                $movieId = $index + 1;
                $movieSlug = strtolower(str_replace([' ', ':', '-'], '-', $movie['title']));
                $movieSlug = preg_replace('/-+/', '-', $movieSlug);
                
                echo '<a href="book.php?id=' . $movieId . '&movie=' . urlencode($movieSlug) . '" class="movie-link">';
                echo '<div class="movie-card">';
                echo '<img src="' . htmlspecialchars($movie['poster']) . '" alt="' . htmlspecialchars($movie['title']) . '" class="movie-poster">';
                echo '<div class="movie-title">' . htmlspecialchars($movie['title']) . '</div>';
                echo '</div>';
                echo '</a>';
            }
            ?>
        </div>
    </section>

    <footer>
        <p>&copy; 2025 Tiketin. All rights reserved.</p>
    </footer>
</body>
</html>
