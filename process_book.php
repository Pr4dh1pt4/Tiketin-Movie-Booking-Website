<?php
// process_book.php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Tangkap data
    $movie_title = $_POST['movie_title'] ?? '';
    $date        = $_POST['date'] ?? '';
    $time        = $_POST['time'] ?? '';
    $price       = $_POST['price'] ?? 0;
    
    // Normalisasi Input Kursi:
    // Pastikan seats tersimpan sebagai string "A1,B2" (karena di DB kamu pakai string)
    $seats_input = $_POST['seats']; 
    if (is_array($seats_input)) {
        $seats_str = implode(',', $seats_input); // Jika input array, gabung jadi string
    } else {
        $seats_str = $seats_input; // Jika sudah string
    }

    $booking_data = [
        'movie_title' => $movie_title,
        'date'        => $date,
        'time'        => $time,
        'seats'       => $seats_str, 
        'price'       => $price
    ];

    // --- LOGIC START ---

    // KONDISI 1: User BELUM Login
    if (!isset($_SESSION['user_id'])) {
        // Simpan data ke session "titipan"
        $_SESSION['pending_booking'] = $booking_data;

        // Lempar ke login
        header("Location: login.php?pesan=logindulu");
        exit;
    }

    // KONDISI 2: User SUDAH Login
    else {
        $user_id = $_SESSION['user_id'];
        
        // Cek validitas user (opsional tapi bagus)
        $check_user = mysqli_query($conn, "SELECT id FROM users WHERE id = '$user_id'");
        if (mysqli_num_rows($check_user) == 0) {
            session_destroy();
            header("Location: login.php?pesan=error_user");
            exit;
        }

        // --- FILTER PENTING (RACE CONDITION CHECK) ---
        // Sebelum INSERT, cek apakah kursi ini SUDAH diambil orang lain barusan?
        
        // 1. Ambil semua kursi yang sudah laku untuk film & jadwal ini
        $cek_kursi_sql = "SELECT seat_numbers FROM tickets WHERE movie_title = ? AND show_date = ? AND show_time = ?";
        $stmt_cek = mysqli_prepare($conn, $cek_kursi_sql);
        mysqli_stmt_bind_param($stmt_cek, "sss", $movie_title, $date, $time);
        mysqli_stmt_execute($stmt_cek);
        $res_cek = mysqli_stmt_get_result($stmt_cek);

        $kursi_terisi = [];
        while ($row = mysqli_fetch_assoc($res_cek)) {
            // Pecah string db "A1,B2" jadi array dan merge
            $booked = explode(',', $row['seat_numbers']);
            $kursi_terisi = array_merge($kursi_terisi, $booked); 
        }

        // 2. Bandingkan kursi yang mau dipesan user ini dengan database
        $kursi_mau_dibeli = explode(',', $seats_str);
        
        foreach ($kursi_mau_dibeli as $k) {
            $k_bersih = trim($k); // Bersihkan spasi
            // Jika kursi yang mau dibeli ADA di array kursi_terisi...
            if (in_array($k_bersih, $kursi_terisi)) {
                // ...Berarti telat! Kursi sudah diambil.
                echo "<script>
                        alert('Maaf! Kursi $k_bersih sudah dibooking orang lain. Silakan pilih kursi lain.');
                        window.location.href = 'index.php'; // Atau kembalikan ke halaman pilih kursi
                      </script>";
                exit; 
            }
        }
        // --- END FILTER ---

        // Jika lolos filter (kursi aman), baru INSERT
        $code = "TKT-" . strtoupper(bin2hex(random_bytes(4))); 

        $sql = "INSERT INTO tickets (user_id, movie_title, show_date, show_time, seat_numbers, total_price, booking_code) VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($conn, $sql);
        
        // Debugging tipe data: i=int, s=string, d=double/decimal
        mysqli_stmt_bind_param($stmt, "issssds", 
            $user_id, 
            $booking_data['movie_title'], 
            $booking_data['date'], 
            $booking_data['time'], 
            $booking_data['seats'], // Pastikan ini string
            $booking_data['price'],
            $code
        );

        if (mysqli_stmt_execute($stmt)) {
            // Sukses!
            header("Location: tickets.php");
            exit;
        } else {
            echo "Error DB: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }
} else {
    // Akses langsung tanpa POST
    header("Location: index.php");
    exit;
}
?>