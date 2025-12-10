<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Tiketin</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #0a0a0a;
            background-image: url('assets/Group 1.png');
            background-size: cover;
            background-position: center;
            color: #fff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-y: auto;
            height: auto;
            padding: 40px 0;
        }

        body::before {
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

        .register-container {
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
            margin-bottom: 20px;
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
        input[type="text"],
        input[type="tel"] {
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

        .name-group {
            display: flex;
            gap: 15px;
        }

        .name-group .form-group {
            flex: 1;
        }

        .checkbox-group {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 25px;
        }

        input[type="checkbox"] {
            width: 18px;
            height: 18px;
            margin-top: 2px;
            cursor: pointer;
            accent-color: #f9e103;
        }

        .checkbox-label {
            color: #ccc;
            font-size: 13px;
            line-height: 1.5;
        }

        .checkbox-label a {
            color: #f9e103;
            text-decoration: none;
        }

        .checkbox-label a:hover {
            text-decoration: underline;
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

        .btn-submit:disabled {
            background-color: #555;
            cursor: not-allowed;
            transform: none;
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

        .login-link {
            text-align: center;
            margin-top: 25px;
            color: #888;
            font-size: 14px;
        }

        .login-link a {
            color: #f9e103;
            text-decoration: none;
            font-weight: bold;
            transition: opacity 0.3s;
        }

        .login-link a:hover {
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

        .password-strength {
            margin-top: 5px;
            font-size: 12px;
            height: 16px;
        }

        .strength-weak { color: #ff5555; }
        .strength-medium { color: #ffaa00; }
        .strength-strong { color: #00ff00; }

        @media (max-width: 768px) {
            .register-container {
                padding: 40px 30px;
                margin: 20px;
            }

            body::before {
                font-size: 80px;
                letter-spacing: 10px;
            }

            .name-group {
                flex-direction: column;
                gap: 0;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="logo">
            <div class="logo-text">Tiketin</div>
            <div class="logo-subtitle">MOVIE BOOKING</div>
        </div>

        <h2>Create Account</h2>
        <p class="subtitle">Join us and start booking your movies</p>

        <form action="process_register.php" method="POST" id="registerForm">
            <div class="name-group">
                <div class="form-group">
                    <label for="firstname">First Name</label>
                    <div class="input-wrapper">
                        <span class="input-icon">👤</span>
                        <input type="text" id="firstname" name="firstname" placeholder="First name" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="lastname">Last Name</label>
                    <div class="input-wrapper">
                        <span class="input-icon">👤</span>
                        <input type="text" id="lastname" name="lastname" placeholder="Last name" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <div class="input-wrapper">
                    <span class="input-icon">📧</span>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <div class="input-wrapper">
                    <span class="input-icon">📱</span>
                    <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required>
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <span class="input-icon">🔒</span>
                    <input type="password" id="password" name="password" placeholder="Create a password" required>
                </div>
                <div class="password-strength" id="passwordStrength"></div>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <div class="input-wrapper">
                    <span class="input-icon">🔒</span>
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
                </div>
            </div>

            <div class="checkbox-group">
                <input type="checkbox" id="terms" name="terms" required>
                <label for="terms" class="checkbox-label">
                    I agree to the <a href="#terms">Terms & Conditions</a> and <a href="#privacy">Privacy Policy</a>
                </label>
            </div>

            <button type="submit" class="btn-submit" id="submitBtn">Create Account</button>
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

        <div class="login-link">
            Already have an account? <a href="login.php">Login</a>
        </div>

        <div class="back-home">
            <a href="index.php">← Back to Home</a>
        </div>
    </div>

    <script>
        // Password strength checker
        const passwordInput = document.getElementById('password');
        const strengthDiv = document.getElementById('passwordStrength');
        
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            
            if (password.length >= 8) strength++;
            if (password.match(/[a-z]/)) strength++;
            if (password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;
            
            if (password.length === 0) {
                strengthDiv.textContent = '';
            } else if (strength <= 2) {
                strengthDiv.textContent = '❌ Weak password';
                strengthDiv.className = 'password-strength strength-weak';
            } else if (strength <= 4) {
                strengthDiv.textContent = '⚠️ Medium password';
                strengthDiv.className = 'password-strength strength-medium';
            } else {
                strengthDiv.textContent = '✅ Strong password';
                strengthDiv.className = 'password-strength strength-strong';
            }
        });

        // Form validation
        const form = document.getElementById('registerForm');
        const confirmPassword = document.getElementById('confirm_password');
        
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const password = passwordInput.value;
            const confirm = confirmPassword.value;
            
            if (password !== confirm) {
                alert('Passwords do not match!');
                return;
            }
            
            if (password.length < 8) {
                alert('Password must be at least 8 characters long!');
                return;
            }
            
            // If validation passes, submit the form
            alert('Registration successful! Welcome to Ticketor!');
            // form.submit(); // Uncomment this when you have backend
            window.location.href = 'login.php';
        });
    </script>
</body>
</html>