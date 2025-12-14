<?php
// delete_ticket.php
require_once 'config.php';

// 1. Cek Login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// 2. Cek apakah ada request POST untuk menghapus
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['booking_code'])) {
    
    $booking_code = $_POST['booking_code'];
    $user_id = $_SESSION['user_id'];

    // 3. Query Hapus (Dengan Validasi User ID agar aman)
    // Kita tambahkan "AND user_id = ?" supaya user tidak bisa menghapus tiket orang lain
    $sql = "DELETE FROM tickets WHERE booking_code = ? AND user_id = ?";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", $booking_code, $user_id);
    
    if (mysqli_stmt_execute($stmt)) {
        // Cek apakah ada baris yang terhapus
        if (mysqli_stmt_affected_rows($stmt) > 0) {
            // Berhasil
            header("Location: tickets.php?msg=deleted");
        } else {
            // Gagal (Mungkin kode salah atau bukan milik user ini)
            header("Location: tickets.php?msg=error");
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    
    mysqli_stmt_close($stmt);

} else {
    // Jika diakses langsung tanpa POST, tendang balik
    header("Location: tickets.php");
}
?>