<?php
// auth_google.php
require_once 'config.php';

if (isset($_GET['code'])) {
    
    // 1. Ambil Token
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

    if (isset($token['error'])) {
        header("Location: login.php?pesan=google_error");
        exit;
    }

    else if (!isset($token['error'])) {
        
        $client->setAccessToken($token);
        $_SESSION['access_token'] = $token;

        // 2. Ambil Data User dari Google
        $google_oauth = new Google_Service_Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();
        
        $email = $google_account_info->email;
        $id_google = $google_account_info->id;
        
        // Logika Nama
        $firstname = $google_account_info->given_name;
        $lastname  = $google_account_info->family_name;
        $nama_lengkap = trim($firstname . " " . $lastname); 

        // 3. CEK DATABASE
        $sql_cek = "SELECT * FROM users WHERE email = ? LIMIT 1";
        $stmt = $conn->prepare($sql_cek);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        // Ambil penanda asal halaman
        $source = isset($_SESSION['login_source']) ? $_SESSION['login_source'] : 'login';

        // Variabel untuk menampung ID User yang Login/Daftar
        $final_user_id = 0;
        $is_new_user = false;

        if ($user) {
            // --- SKENARIO 1: USER SUDAH ADA (LOGIN) ---
            $sql_update = "UPDATE users SET google_id = ? WHERE email = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("ss", $id_google, $email);
            $stmt_update->execute();

            $final_user_id = $user['id'];
            // Session Data akan diset di bawah (gabungan)

        } else {
            // --- SKENARIO 2: USER BELUM ADA ---
            if ($source == 'register') {
                $phone_default = "-";
                $password_random = password_hash(bin2hex(random_bytes(8)), PASSWORD_DEFAULT);

                $sql_insert = "INSERT INTO users (nama_lengkap, email, google_id, phone, password) VALUES (?, ?, ?, ?, ?)";
                $stmt_insert = $conn->prepare($sql_insert);
                $stmt_insert->bind_param("sssss", $nama_lengkap, $email, $id_google, $phone_default, $password_random);

                if ($stmt_insert->execute()) {
                    $final_user_id = $conn->insert_id;
                    $is_new_user = true;
                } else {
                    header("Location: register.php?pesan=gagal");
                    exit;
                }
            } else {
                header("Location: register.php?pesan=google_unregistered");
                exit;
            }
        }

        // --- BAGIAN INI MENANGANI LOGIN & BOOKING (AGAR TIDAK SHADOW LOGIN) ---
        
        if ($final_user_id > 0) {
            // 1. Set Session Login
            session_regenerate_id(true);
            $_SESSION['login'] = true;
            $_SESSION['user_id'] = $final_user_id;
            $_SESSION['nama_lengkap'] = $nama_lengkap; // Pastikan namanya sama dgn yang dipakai di header ('nama_lengkap')
            $_SESSION['user_email'] = $email;

            // 2. Cek Pending Booking (Jika user tadi mau booking tapi disuruh login dlu)
            $redirect_url = "index.php"; // Default ke Home

            if (isset($_SESSION['pending_booking'])) {
                $pending = $_SESSION['pending_booking'];
                $code = "TKT-" . strtoupper(bin2hex(random_bytes(4)));
                
                // INSERT Tiket
                $sql_ticket = "INSERT INTO tickets (user_id, movie_title, show_date, show_time, seat_numbers, total_price, booking_code) VALUES (?, ?, ?, ?, ?, ?, ?)";
                
                $stmt_ticket = mysqli_prepare($conn, $sql_ticket);
                
                // Casting harga ke double biar aman
                $price = (double)$pending['price'];

                mysqli_stmt_bind_param($stmt_ticket, "issssds", 
                    $final_user_id, 
                    $pending['movie_title'], 
                    $pending['date'], 
                    $pending['time'], 
                    $pending['seats'], 
                    $price, 
                    $code
                );
                
                if (mysqli_stmt_execute($stmt_ticket)) {
                    // Jika sukses booking, arahkan ke halaman tiket
                    $redirect_url = "tickets.php?pesan=booking_success";
                    unset($_SESSION['pending_booking']); // Hapus antrian
                }
            }

            // 3. FIX SHADOW LOGIN: Paksa simpan session sebelum redirect
            session_write_close(); 

            // 4. Redirect
            header("Location: " . $redirect_url);
            exit;
        }
    }
} else {
    header("Location: login.php");
    exit;
}
?>