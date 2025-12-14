<?php
// process_register.php
require_once 'config.php';

// Pastikan hanya bisa diakses lewat method POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 1. Ambil data dari form (Bersihkan spasi kiri-kanan dengan trim)
    $firstname = trim($_POST['firstname']);
    $lastname  = trim($_POST['lastname']);
    $email     = trim($_POST['email']);
    $phone     = trim($_POST['phone']);
    $password  = $_POST['password'];
    $confirm   = $_POST['confirm_password'];

    // 3. Validasi Password Match (Penting!)
    if ($password !== $confirm) {
        header("Location: register.php?pesan=pass_missmatch");
        exit;
    }

    // 4. Validasi Panjang Password (Opsional, biar makin aman)
    if (strlen($password) < 6) {
        header("Location: register.php?pesan=pass_short");
        exit;
    }

    // 5. CEK EMAIL DUPLIKAT
    // Gunakan LIMIT 1 agar database kerjanya ringan
    $sql_cek = "SELECT id FROM users WHERE email = ? LIMIT 1";
    $stmt_cek = mysqli_prepare($conn, $sql_cek);
    mysqli_stmt_bind_param($stmt_cek, "s", $email);
    mysqli_stmt_execute($stmt_cek);
    mysqli_stmt_store_result($stmt_cek);

    if (mysqli_stmt_num_rows($stmt_cek) > 0) {
        // Email sudah terpakai
        header("Location: register.php?pesan=email_taken");
        exit;
    }
    mysqli_stmt_close($stmt_cek);

    // 6. PROSES SIMPAN DATA
    
    // A. Gabungkan First & Last Name jadi 'nama_lengkap' (Sesuai database login kita)
    $nama_lengkap = $firstname . " " . $lastname;

    // B. Hash Password (WAJIB!)
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // C. Insert ke Database
    // CATATAN: Pastikan di database tabel 'users' sudah ada kolom 'phone'.
    // Kalau belum ada, hapus bagian phone di query ini.
    $sql_insert = "INSERT INTO users (nama_lengkap, email, phone, password) VALUES (?, ?, ?, ?)";
    
    $stmt_insert = mysqli_prepare($conn, $sql_insert);
    
    // "ssss" = String, String, String, String
    mysqli_stmt_bind_param($stmt_insert, "ssss", $nama_lengkap, $email, $phone, $password_hash);

    if (mysqli_stmt_execute($stmt_insert)) {
        // Sukses Register -> Lempar ke Login
        $new_user_id = mysqli_insert_id($conn);

        session_regenerate_id(true); // Biar aman
        $_SESSION['login'] = true;
        $_SESSION['user_id'] = $new_user_id;
        $_SESSION['nama_lengkap'] = $nama_lengkap; 
        $_SESSION['user_email'] = $email;

        header("Location: index.php?pesan=success");
        exit;
    } else {
        // Gagal Query
        header("Location: register.php?pesan=gagal");
        exit;
    }
    
    mysqli_stmt_close($stmt_insert);

} else {
    // Akses tanpa form
    header("Location: register.php");
    exit;
}
?>