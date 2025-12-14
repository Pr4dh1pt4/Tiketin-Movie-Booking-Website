<?php
// check_seats.php
require_once 'config.php';

header('Content-Type: application/json'); // Pastikan output JSON

if (isset($_GET['title']) && isset($_GET['date']) && isset($_GET['time'])) {
    
    $title = $_GET['title'];
    $date  = $_GET['date'];
    $time  = $_GET['time'];
    
    // 2. Tentukan ID user. Jika belum login, set ke 0 atau null
    $current_user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

    // 3. Query ambil data kursi berdasarkan Judul, Tanggal, dan Jam
    $sql = "SELECT seat_numbers, user_id FROM tickets WHERE movie_title = ? AND show_date = ? AND show_time = ?";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "sss", $title, $date, $time);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $seat_data = [];

        while ($row = mysqli_fetch_assoc($result)) {
            // Pecah string kursi (contoh: "A1, A2, B5") menjadi array
            $seats = explode(',', $row['seat_numbers']);
            
            // ID Pemilik tiket ini
            $owner_id = $row['user_id'];

            foreach ($seats as $seat) {
                // Bersihkan spasi berlebih
                $clean_seat = trim($seat);
                
                if (!empty($clean_seat)) {
                    // 4. Logika PENTING: Bandingkan ID pemilik tiket dengan ID user yang sedang login
                    // Jika sama -> 'mine' (nanti jadi biru)
                    // Jika beda -> 'occupied' (nanti jadi abu-abu)
                    if ($current_user_id != 0 && $owner_id == $current_user_id) {
                        $status = 'mine'; 
                    } else {
                        $status = 'occupied';
                    }
                    
                    $seat_data[] = [
                        'seat' => $clean_seat,
                        'status' => $status
                    ];
                }
            }
        }
        
        echo json_encode($seat_data);
    
    } else {
        // Jika query gagal prepare
        echo json_encode(['error' => 'Database query failed']);
    }

} else {
    // Jika parameter kurang
    echo json_encode([]);
}
?>