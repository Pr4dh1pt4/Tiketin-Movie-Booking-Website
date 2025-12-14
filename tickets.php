<?php
require_once 'config.php';

// 1. CEK LOGIN (WAJIB)
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// AMBIL DATA TIKET DARI DATABASE
$sql = "SELECT * FROM tickets WHERE user_id = ? ORDER BY show_date DESC, show_time DESC";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$tickets_data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $show_datetime = $row['show_date'] . ' ' . str_replace('.', ':', $row['show_time']); // Gabung tgl & jam
    $is_past = strtotime($show_datetime) < time(); // Cek apakah sudah lewat hari ini?

    // $poster_default = 'https://via.placeholder.com/150x225?text=No+Image';

    $tickets_data[] = [
        'id' => $row['id'],
        'movie' => $row['movie_title'],
        // 'poster' => $poster_default,
        'date' => $row['show_date'],
        'time' => $row['show_time'],
        'seats' => explode(',', $row['seat_numbers']),
        'total' => (int)$row['total_price'],
        'status' => $is_past ? 'past' : 'upcoming',
        'bookingId' => $row['booking_code']
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Tickets - Tiketin</title>
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

    .logo {
        display: flex;
        align-items: center;
        font-size: 24px;
        font-weight: bold;
        color: #f9e103;
        text-decoration: none;
        white-space: nowrap;
    }

    .logo::before {
        content: url('assets/Vector.png');
        margin-right: 10px;
        margin-top: 5px;
        transform: scale(1);
    }

    nav {
        display: flex;
        gap: 30px;
        align-items: center;
        justify-content: center;
    }

    nav a {
        color: #fff;
        text-decoration: none;
        font-size: 16px;
        transition: color 0.3s;
    }

    nav a:hover,
    nav a.active {
        color: #f9e103;
    }

    .auth-buttons {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 15px;
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
        top: 100%;
        background-color: #1a1a1a;
        min-width: 150px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        border-radius: 10px;
        z-index: 1;
        border: 1px solid #333;
        overflow: hidden;
    }

    .dropdown-content a {
        color: #fff;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        font-size: 14px;
    }

    .dropdown-content a:hover {
        background-color: #f9e103;
        color: #000;
    }

    .user-dropdown:hover .dropdown-content {
        display: block;
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

    .btn-signup {
        color: #f9e103;
    }

    .main-content {
        margin-top: 120px;
        padding: 40px 50px;
        max-width: 1400px;
        margin-left: auto;
        margin-right: auto;
        min-height: calc(100vh - 200px);
    }

    .page-header {
        margin-bottom: 40px;
    }

    .page-header h1 {
        font-size: 48px;
        margin-bottom: 10px;
    }

    .page-header p {
        color: #888;
        font-size: 16px;
    }

    .tabs {
        display: flex;
        gap: 20px;
        margin-bottom: 30px;
        border-bottom: 2px solid #2a2a2a;
        padding-bottom: 10px;
    }

    .tab-btn {
        background: none;
        border: none;
        color: #888;
        font-size: 16px;
        padding: 10px 20px;
        cursor: pointer;
        transition: all 0.3s;
        border-bottom: 3px solid transparent;
        margin-bottom: -12px;
    }

    .tab-btn:hover {
        color: #fff;
    }

    .tab-btn.active {
        color: #f9e103;
        border-bottom-color: #f9e103;
    }

    .tickets-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 30px;
    }

    .ticket-card {
        display: flex;
        flex-direction: row;
        background: linear-gradient(135deg, #1a1a1a 0%, #2a2a2a 100%);
        border-radius: 15px;
        overflow: hidden;
        border: 1px solid #3a3a3a;
        transition: all 0.3s;
        cursor: pointer;
        position: relative;
        width: 100%;
        align-items: stretch;
    }

    .ticket-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(249, 225, 3, 0.2);
        border-color: #f9e103;
    }

    .ticket-header {
        width: 35%;
        background: rgba(0, 0, 0, 0.3);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 20px;
        border-right: 1px solid rgba(255, 255, 255, 0.05);
    }

    .ticket-info {
        text-align: center;
        width: 100%;
    }

    .ticket-title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 10px;
        color: #fff;
        line-height: 1.3;
    }

    .ticket-meta {
        display: flex;
        flex-direction: column;
        gap: 5px;
        align-items: center;
    }

    .ticket-meta-item {
        display: flex;
        align-items: center;
        gap: 6px;
        color: #bbb;
        font-size: 13px;
    }

    .ticket-body {
        width: 65%;
        padding: 25px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .ticket-details {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .detail-item {
        text-align: left;
    }

    .detail-label {
        color: #888;
        font-size: 11px;
        margin-bottom: 5px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .detail-value {
        color: #fff;
        font-size: 16px;
        font-weight: bold;
    }

    .booking-id-text {
        color: #f9e103;
        font-family: monospace;
        font-size: 16px;
    }

    .ticket-seats {
        background-color: rgba(0, 0, 0, 0.2);
        padding: 15px;
        border-radius: 8px;
        margin-bottom: auto;
    }

    .seats-label {
        color: #888;
        font-size: 11px;
        margin-bottom: 8px;
        text-transform: uppercase;
    }

    .seats-list {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .seat-badge {
        background-color: #f9e103;
        color: #000;
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 13px;
        font-weight: bold;
    }

    .ticket-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        margin-top: 20px;
    }

    .ticket-status {
        padding: 6px 15px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .status-upcoming {
        background-color: rgba(0, 255, 0, 0.15);
        color: #4cd137;
        border: 1px solid rgba(76, 209, 55, 0.3);
    }

    .status-past {
        background-color: rgba(255, 255, 255, 0.1);
        color: #aaa;
    }

    .ticket-actions-group {
        display: flex;
        gap: 15px;
        align-items: center;
    }

    .qr-link {
        text-decoration: none;
        display: flex;
        align-items: center;
    }

    .ticket-qr {
        font-size: 20px;
        cursor: pointer;
        transition: transform 0.2s;
        color: #3498db;
    }

    .ticket-qr:hover {
        transform: scale(1.1);
    }

    .delete-form {
        margin: 0;
        display: flex;
        align-items: center;
    }

    .btn-delete {
        background: none;
        border: none;
        padding: 0;
        cursor: pointer;
        color: #e74c3c;
        font-size: 20px;
        display: flex;
        align-items: center;
        transition: all 0.2s;
    }

    .btn-delete:hover {
        color: #ff6b6b;
        transform: scale(1.1);
    }

    .alert-box {
        padding: 15px;
        margin-bottom: 30px;
        border-radius: 8px;
        font-weight: 500;
        text-align: center;
    }

    .alert-success {
        background-color: rgba(46, 204, 113, 0.2);
        color: #2ecc71;
        border: 1px solid rgba(46, 204, 113, 0.3);
    }

    .alert-error {
        background-color: rgba(231, 76, 60, 0.2);
        color: #e74c3c;
        border: 1px solid rgba(231, 76, 60, 0.3);
    }

    .empty-state {
        text-align: center;
        padding: 100px 20px;
    }

    .empty-icon {
        font-size: 80px;
        margin-bottom: 20px;
        opacity: 0.2;
    }

    .empty-state h2 {
        font-size: 28px;
        margin-bottom: 10px;
    }

    .empty-state p {
        color: #888;
        font-size: 16px;
        margin-bottom: 30px;
    }

    .btn-primary {
        padding: 12px 30px;
        background-color: #f9e103;
        color: #000;
        border: none;
        border-radius: 50px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
    }

    .btn-primary:hover {
        background-color: #ffd700;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(249, 225, 3, 0.3);
    }

    footer {
        background-color: #000;
        padding: 30px;
        text-align: center;
        margin-top: 50px;
    }

    footer p {
        color: #888;
    }

    @media (max-width: 768px) {
        header {
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            width: 92% !important;
            padding: 12px 15px !important;
            top: 15px !important;
            left: 50% !important;
            transform: translateX(-50%) !important;
            grid-template-columns: none !important;
        }

        nav {
            display: none !important;
        }

        .logo {
            font-size: 20px !important;
        }

        .logo::before {
            font-size: 24px !important;
            margin-right: 5px !important;
            transform: scale(0.8);
        }

        .auth-buttons {
            gap: 8px !important;
        }

        .user-name-btn,
        .btn {
            font-size: 14px !important;
            padding: 5px 8px !important;
        }

        .main-content {
            margin-top: 90px !important;
            padding: 20px !important;
        }

        .page-header h1 {
            font-size: 28px !important;
        }

        .page-header p {
            font-size: 14px;
        }

        .tickets-grid {
            grid-template-columns: 1fr !important;
        }

        .ticket-card {
            flex-direction: column !important;
        }

        .ticket-header {
            width: 100% !important;
            border-right: none !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            flex-direction: row !important;
            justify-content: flex-start !important;
            text-align: left !important;
            gap: 20px !important;
        }


        .ticket-info {
            text-align: left !important;
        }

        .ticket-meta {
            align-items: flex-start !important;
        }

        .ticket-body {
            width: 100% !important;
            padding: 20px !important;
        }

        .ticket-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .detail-item {
            text-align: left;
        }

        .detail-item:last-child {
            grid-column: span 2;
            margin-top: 5px;
            padding-top: 10px;
            border-top: 1px dashed rgba(255, 255, 255, 0.1);
        }

        .ticket-footer {
            flex-direction: row !important;
            justify-content: space-between !important;
        }
    }
</style>
</head>
<body>
    <header>
        <a class="logo">Tiketin</a>
        <nav>
            <a href="index.php">Movies</a>
            <a href="cinemas.php">Cinemas</a>
            <a href="tickets.php" class="active">Tickets</a>
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

    <div class="main-content">
        <div class="page-header">
            <h1>My Tickets</h1>
            <p>View and manage your movie bookings</p>
        
            <?php if (isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
                <div class="alert-box alert-success">
                    Tiket berhasil dihapus.
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['msg']) && $_GET['msg'] == 'error'): ?>
                <div class="alert-box alert-error">
                    Gagal menghapus tiket.
                </div>
            <?php endif; ?>
        </div>

        <div class="tabs">
            <button class="tab-btn active" onclick="filterTickets('all')">All Tickets</button>
            <button class="tab-btn" onclick="filterTickets('upcoming')">Upcoming</button>
            <button class="tab-btn" onclick="filterTickets('past')">Past</button>
        </div>

        <div id="ticketsContainer"></div>
        
    </div>

    <footer>
        <p>&copy; 2025 Tiketin. All rights reserved.</p>
    </footer>

    <script>
        // 1. AMBIL DATA ASLI DARI PHP DAN MASUKKAN KE VARIABEL JS
        const tickets = <?php echo json_encode($tickets_data); ?>;
        
        let currentFilter = 'all';

        function displayTickets(ticketsToShow) {
            const container = document.getElementById('ticketsContainer');

            // Cek jika kosong
            if (ticketsToShow.length === 0) {
                container.innerHTML = `
                    <div class="empty-state">
                        <div class="empty-icon">🎟️</div>
                        <h2>No Tickets Found</h2>
                        <p>You don't have any ${currentFilter === 'all' ? '' : currentFilter} tickets.<br>Start booking your favorite movies now!</p>
                        <a href="index.php" class="btn-primary">Browse Movies</a>
                    </div>
                `;
                return;
            }

            let html = '<div class="tickets-grid">';
            
            ticketsToShow.forEach(ticket => {
                // Format Tanggal Javascript
                const dateObj = new Date(ticket.date);
                const dateStr = dateObj.toLocaleDateString('en-US', { 
                    weekday: 'short', year: 'numeric', month: 'short', day: 'numeric' 
                });

                // RENDER KARTU TIKET
                html += `
                    <div class="ticket-card" onclick="viewTicketDetail('${ticket.bookingId}')">
                        
                        <div class="ticket-header">
                            <div class="ticket-info">
                                <div class="ticket-title">${ticket.movie}</div>
                                <div class="ticket-meta">
                                    <div class="ticket-meta-item">
                                        <span>📅</span> <span>${dateStr}</span>
                                    </div>
                                    <div class="ticket-meta-item">
                                        <span>🕐</span> <span>${ticket.time}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="ticket-body">
                            <div class="ticket-details">
                                <div class="detail-item">
                                    <div class="detail-label">Booking ID</div>
                                    <div class="detail-value booking-id-text">${ticket.bookingId}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Seats</div>
                                    <div class="detail-value">${ticket.seats.length}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Total</div>
                                    <div class="detail-value">Rp${ticket.total.toLocaleString('id-ID')}</div>
                                </div>
                            </div>

                            <div class="ticket-seats">
                                <div class="seats-label">Seat Numbers</div>
                                <div class="seats-list">
                                    ${ticket.seats.map(seat => `<span class="seat-badge">${seat}</span>`).join('')}
                                </div>
                            </div>

                            <div class="ticket-footer">
                                <span class="ticket-status status-${ticket.status}">
                                    ${ticket.status === 'upcoming' ? '🎬 Upcoming' : '✓ Past'}
                                </span>

                                <div class="ticket-actions-group">
                                    <a href="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=${ticket.bookingId}" target="_blank" class="qr-link" onclick="event.stopPropagation()">
                                        <span class="ticket-qr" title="Show QR Code">📱</span>
                                    </a>

                                    <form action="delete_tickets.php" method="POST" class="delete-form" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pemesanan ini? Pembayaran tidak dapat dikembalikan.');" onclick="event.stopPropagation()">
                                        <input type="hidden" name="booking_code" value="${ticket.bookingId}">
                                        <button type="submit" class="btn-delete" title="Delete Ticket">
                                            🗑
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div> 
                        </div> 
                    `;
            });

            html += '</div>';
            container.innerHTML = html;
        }

        function filterTickets(filter) {
            currentFilter = filter;
            
            // Update active tab
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.classList.add('active');

            // Filter tickets
            let filtered = tickets;
            if (filter === 'upcoming') {
                filtered = tickets.filter(t => t.status === 'upcoming');
            } else if (filter === 'past') {
                filtered = tickets.filter(t => t.status === 'past');
            }

            displayTickets(filtered);
        }

        function viewTicketDetail(bookingId) {
            // Cari tiket berdasarkan bookingId (String)
            const ticket = tickets.find(t => t.bookingId === bookingId);
            if(ticket) {
                alert(`Ticket Details\n\nBooking ID: ${ticket.bookingId}\nMovie: ${ticket.movie}\nDate: ${ticket.date}\nTime: ${ticket.time}\n\nShow code at entrance.`);
            }
        }

        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('pesan') === 'booking_success') {
            alert('🎉 Pembayaran Berhasil! Tiket Anda telah terbit.');
            window.history.replaceState(null, null, window.location.pathname);
        }

        // Panggil pertama kali
        displayTickets(tickets);
    </script>
</body>
</html>