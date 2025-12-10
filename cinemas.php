<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiketin - Cinemas</title>
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

        /* Header (copy dari index.php) */
        header {
            background-color: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(10px);
            padding: 15px 50px;
            display: flex;
            justify-content: space-between;
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
            content: url('Vector.png');
            margin-right: 10px;
            margin-top: 5px;
        }

        nav {
            display: flex;
            gap: 30px;
            align-items: center;
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

        .search-bar {
            padding: 8px 15px;
            width: 300px;
            border: none;
            border-radius: 5px;
            background-color: #fff;
        }

        .auth-buttons {
            display: flex;
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

        .btn-login { color: #fff; }
        .btn-login::before { content: '🔒'; }

        .btn-signup { color: #f9e103; }
        .btn-signup::before { content: '📝'; }

        /* Hero */
        .hero {
            margin-top: 0;
            height: 350px;
            padding-top: 120px;
            background-image: url('assets/cinema.jpg'); /* Bisa diganti foto bioskop */
            background-size: cover;
            background-position: center;
            position: relative;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .hero::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            height: 50%;
            background: linear-gradient(
                to top,
                rgba(0, 0, 0, 1),
                rgba(0, 0, 0, 0)
            );
        }

        .hero h1 {
            font-size: 58px;
            z-index: 2;
            position: relative;
            text-transform: uppercase;
            text-shadow: 3px 3px 10px rgba(0, 0, 0, 0.8);
        }

        /* Cinemas Grid */
        .cinemas-section {
            padding: 50px;
            max-width: 1400px;
            margin: -80px auto 0;
            position: relative;
            z-index: 10;
        }

        .cinema-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 30px;
            margin-top: 30px;
        }

        .cinema-card {
            background-color: #111;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.6);
            transition: transform 0.3s;
            cursor: pointer;
        }

        .cinema-card:hover {
            transform: translateY(-10px);
        }

        .cinema-image {
            height: 180px;
            background-size: cover;
            background-position: center;
        }

        .cinema-content {
            padding: 20px;
        }

        .cinema-content h3 {
            font-size: 20px;
            margin-bottom: 10px;
            color: #f9e103;
        }

        .cinema-content p {
            font-size: 14px;
            color: #bbb;
            margin-bottom: 5px;
        }

        footer {
            background-color: #000;
            padding: 30px;
            text-align: center;
            margin-top: 50px;
            color: #888;
        }

    </style>
</head>
<body>

<header>
    <div class="logo">Tiketin</div>
    <nav>
        <a href="index.php">Movies</a>
        <a href="cinemas.php" style="color: #f9e103;">Cinemas</a>
        <input type="text" class="search-bar" placeholder="Search cinemas...">
    </nav>
    <div class="auth-buttons">
        <a href="login.php" class="btn btn-login">Login</a>
        <a href="register.php" class="btn btn-signup">Sign Up</a>
    </div>
</header>

<section class="hero">
    <h1>Find Your Cinema</h1>
</section>

<section class="cinemas-section">
    <div class="cinema-grid">

        <?php
        $cinemas = [
            [
                'name' => 'CGV Grand Indonesia',
                'location' => 'Jakarta Pusat',
                'image' => 'assets/bioskop.jpg'
            ],
            [
                'name' => 'XXI Plaza Indonesia',
                'location' => 'Jakarta Pusat',
                'image' => 'assets/bioskop.jpg'
            ],
            [
                'name' => 'Cinépolis Lippo Mall Puri',
                'location' => 'Jakarta Barat',
                'image' => 'assets/bioskop.jpg'
            ],
            [
                'name' => 'XXI Summarecon Mall Bekasi',
                'location' => 'Bekasi',
                'image' => 'assets/bioskop.jpg'
            ],
            [
                'name' => 'CGV Paris Van Java',
                'location' => 'Bandung',
                'image' => 'assets/bioskop.jpg'
            ],
            [
                'name' => 'XXI Tunjungan Plaza',
                'location' => 'Surabaya',
                'image' => 'assets/bioskop.jpg'
            ]
        ];

        foreach ($cinemas as $c) {
            echo '
            <div class="cinema-card">
                <div class="cinema-image" style="background-image:url('.$c["image"].');"></div>
                <div class="cinema-content">
                    <h3>'.$c["name"].'</h3>
                    <p>'.$c["location"].'</p>
                    <p>✔ Dolby Atmos • ✔ Recliner Seats • ✔ Online Booking</p>
                </div>
            </div>';
        }
        ?>

    </div>
</section>

<footer>
    <p>&copy; 2024 Tiketin. All rights reserved.</p>
</footer>

</body>
</html>
