<?php
// process_login.php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['email'];
    $password = $_POST['password'];

    // 2. Query Cek User
    $sql = "SELECT id, password, nama_lengkap FROM users WHERE email = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $db_id, $db_pass, $db_nama);
    
    // Fetch data dulu
    if (mysqli_stmt_fetch($stmt)) {
        
        // PENTING: Tutup statement login dulu agar koneksi database bisa dipakai query INSERT dibawah
        mysqli_stmt_close($stmt); 

        // 3. Cek Password
        if (password_verify($password, $db_pass)) {
            
            // --- LOGIN SUKSES ---
            session_regenerate_id(true);
            $_SESSION['login'] = true;
            $_SESSION['user_id'] = $db_id;
            $_SESSION['nama_lengkap'] = $db_nama;
            $_SESSION['user_email'] = $email; 

            // --- FITUR AUTO BOOKING (JIKA ADA TITIPAN) ---
            if (isset($_SESSION['pending_booking'])) {
                
                // Ambil data titipan
                $pending = $_SESSION['pending_booking'];
                
                // Generate Booking Code Baru
                $code = "TKT-" . strtoupper(bin2hex(random_bytes(4))); 

                // Siapkan Query Insert (Sama persis seperti di process_book.php)
                $sql_book = "INSERT INTO tickets (user_id, movie_title, show_date, show_time, seat_numbers, total_price, booking_code) VALUES (?, ?, ?, ?, ?, ?, ?)";
                
                $stmt_book = mysqli_prepare($conn, $sql_book);
                
                // Pastikan seats berupa string (jaga-jaga)
                $seats_str = is_array($pending['seats']) ? implode(',', $pending['seats']) : $pending['seats'];

                mysqli_stmt_bind_param($stmt_book, "issssds", 
                    $db_id, // Pakai ID user yang baru login
                    $pending['movie_title'], 
                    $pending['date'], 
                    $pending['time'], 
                    $seats_str, 
                    $pending['price'],
                    $code
                );

                if (mysqli_stmt_execute($stmt_book)) {
                    // Berhasil Insert! Hapus titipan
                    unset($_SESSION['pending_booking']);
                    
                    mysqli_stmt_close($stmt_book);
                    
                    // Lempar ke halaman tiket
                    header("Location: tickets.php"); 
                    exit;
                } else {
                    // Jika insert gagal, lempar ke index tapi login tetap masuk
                    // (Opsional: logging error)
                }
            }
            // --- END AUTO BOOKING ---

            // Jika tidak ada bookingan tertunda, masuk ke dashboard biasa
            header("Location: index.php");
            exit;

        } else {
            // Password Salah
            header("Location: login.php?pesan=pass");
            exit;
        }

    } else {
        // Email Tidak Ada
        mysqli_stmt_close($stmt); // Tutup stmt jika user tidak ketemu
        header("Location: login.php?pesan=notfound");
        exit;
    }

} else {
    header("Location: login.php");
    exit;
}
?>