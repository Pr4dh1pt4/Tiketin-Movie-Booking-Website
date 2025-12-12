<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Tiketin</title>
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
            min-height: 100vh;
            background-image: url('assets/Group 1.png');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-y: auto;
            height: auto;
            padding: 40px 0;
        }

        body::before {
            content: 'TICKETOR';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 200px;
            font-weight: 900;
            color: rgba(255, 255, 255, 0.02);
            letter-spacing: 20px;
            white-space: nowrap;
            z-index: 0;
        }

        body::after {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            backdrop-filter: blur(12px);
            background: rgba(0,0,0,0.4); /* opsional: gelapkan sedikit */
            z-index: 0;
        }

        .login-container {
            position: relative;
            z-index: 1;
            background: rgba(26, 26, 26, 0.95);
            backdrop-filter: blur(10px);
            padding: 50px 60px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 450px;
        }

        .logo {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo-text {
            font-size: 36px;
            font-weight: bold;
            color: #f9e103;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .logo-text::before {
            content: url('assets/Vector.png');
            margin-right: 10px;
            font-size: 40px;
        }

        .logo-subtitle {
            font-size: 14px;
            color: #888;
            margin-top: 5px;
            letter-spacing: 2px;
        }

        h2 {
            font-size: 28px;
            margin-bottom: 10px;
            text-align: center;
        }

        .subtitle {
            text-align: center;
            color: #888;
            margin-bottom: 30px;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #ccc;
            font-size: 14px;
            font-weight: 500;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
        }

        input[type="email"],
        input[type="password"],
        input[type="text"] {
            width: 100%;
            padding: 15px 15px 15px 45px;
            background-color: #1a1a1a;
            border: 2px solid #2a2a2a;
            border-radius: 10px;
            color: #fff;
            font-size: 16px;
            transition: all 0.3s;
        }

        input:focus {
            outline: none;
            border-color: #f9e103;
            background-color: #0a0a0a;
        }

        .forgot-password {
            text-align: right;
            margin-top: -15px;
            margin-bottom: 20px;
        }

        .forgot-password a {
            color: #f9e103;
            text-decoration: none;
            font-size: 13px;
            transition: opacity 0.3s;
        }

        .forgot-password a:hover {
            opacity: 0.8;
        }

        .btn-submit {
            width: 100%;
            padding: 15px;
            background-color: #f9e103;
            color: #000;
            border: none;
            border-radius: 50px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
        }

        .btn-submit:hover {
            background-color: #ffd700;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(249, 225, 3, 0.3);
        }

        .divider {
            text-align: center;
            margin: 30px 0;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            width: 100%;
            height: 1px;
            background: #2a2a2a;
        }

        .divider span {
            background: rgba(26, 26, 26, 0.95);
            padding: 0 15px;
            position: relative;
            color: #888;
            font-size: 14px;
        }

        .social-login {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
        }

        .btn-social {
            flex: 1;
            padding: 12px;
            background-color: #2a2a2a;
            border: 1px solid #3a3a3a;
            border-radius: 10px;
            color: #fff;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-social:hover {
            background-color: #3a3a3a;
            transform: translateY(-2px);
        }

        .register-link {
            text-align: center;
            margin-top: 25px;
            color: #888;
            font-size: 14px;
        }

        .register-link a {
            color: #f9e103;
            text-decoration: none;
            font-weight: bold;
            transition: opacity 0.3s;
        }

        .register-link a:hover {
            opacity: 0.8;
        }

        .back-home {
            text-align: center;
            margin-top: 20px;
        }

        .back-home a {
            color: #888;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s;
        }

        .back-home a:hover {
            color: #f9e103;
        }

        @media (max-width: 768px) {
            .login-container {
                padding: 40px 30px;
                margin: 20px;
            }

            body::before {
                font-size: 80px;
                letter-spacing: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <div class="logo-text">Tiketin</div>
            <div class="logo-subtitle">MOVIE BOOKING</div>
        </div>

        <h2>Welcome Back!</h2>
        <p class="subtitle">Login to book your favorite movies</p>

        <form action="process_login.php" method="POST">
            <div class="form-group">
                <label for="email">Email Address</label>
                <div class="input-wrapper">
                    <span class="input-icon">📧</span>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <span class="input-icon">🔒</span>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>
            </div>

            <div class="forgot-password">
                <a href="#forgot">Forgot Password?</a>
            </div>

            <button type="submit" class="btn-submit">Login</button>
        </form>

        <div class="divider">
            <span>OR</span>
        </div>

        <div class="social-login">
            <button class="btn-social">
                <span>📘</span> Facebook
            </button>
            <button class="btn-social">
                <span>🔍</span> Google
            </button>
        </div>

        <div class="register-link">
            Don't have an account? <a href="register.php">Sign Up</a>
        </div>

        <div class="back-home">
            <a href="index.php">← Back to Home</a>
        </div>
    </div>
</body>
</html>
