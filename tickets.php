<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Tickets - Ticketor</title>
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
        }

        .logo::before {
            content: url('assets/Vector.png');
            margin-right: 10px;
            margin-top: 5px;
            font-size: 28px;
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

        nav a:hover, nav a.active {
            color: #f9e103;
        }

        .auth-buttons {
            display: flex;
            justify-content: flex-end;
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

        .btn-login {
            color: #fff;
        }

        .btn-signup {
            color: #f9e103;
        }

        /* Main Content */
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

        /* Tabs */
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

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 100px 20px;
        }

        .empty-icon {
            font-size: 120px;
            margin-bottom: 20px;
            opacity: 0.3;
        }

        .empty-state h2 {
            font-size: 32px;
            margin-bottom: 15px;
            color: #fff;
        }

        .empty-state p {
            color: #888;
            font-size: 18px;
            margin-bottom: 30px;
        }

        .btn-primary {
            padding: 15px 40px;
            background-color: #f9e103;
            color: #000;
            border: none;
            border-radius: 50px;
            font-size: 18px;
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

        /* Tickets Grid */
        .tickets-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 30px;
        }

        /* Ticket Card */
        .ticket-card {
            background: linear-gradient(135deg, #1a1a1a 0%, #2a2a2a 100%);
            border-radius: 15px;
            overflow: hidden;
            border: 1px solid #3a3a3a;
            transition: all 0.3s;
            cursor: pointer;
            position: relative;
        }

        .ticket-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(249, 225, 3, 0.2);
            border-color: #f9e103;
        }

        .ticket-header {
            display: flex;
            gap: 15px;
            padding: 20px;
            background: rgba(0, 0, 0, 0.3);
        }

        .ticket-poster {
            width: 80px;
            height: 120px;
            border-radius: 8px;
            object-fit: cover;
        }

        .ticket-info {
            flex: 1;
        }

        .ticket-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 8px;
            color: #fff;
        }

        .ticket-meta {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .ticket-meta-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #888;
            font-size: 14px;
        }

        .ticket-meta-item span:first-child {
            font-size: 16px;
        }

        .ticket-body {
            padding: 20px;
        }

        .ticket-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .detail-item {
            text-align: center;
        }

        .detail-label {
            color: #888;
            font-size: 12px;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .detail-value {
            color: #fff;
            font-size: 16px;
            font-weight: bold;
        }

        .ticket-seats {
            background-color: rgba(0, 0, 0, 0.3);
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .seats-label {
            color: #888;
            font-size: 12px;
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
            padding: 5px 12px;
            border-radius: 5px;
            font-size: 14px;
            font-weight: bold;
        }

        .ticket-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 15px;
            border-top: 1px solid #3a3a3a;
        }

        .ticket-status {
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-upcoming {
            background-color: rgba(0, 255, 0, 0.2);
            color: #00ff00;
        }

        .status-past {
            background-color: rgba(128, 128, 128, 0.2);
            color: #888;
        }

        .ticket-qr {
            font-size: 24px;
            cursor: pointer;
            transition: transform 0.3s;
        }

        .ticket-qr:hover {
            transform: scale(1.2);
        }

        /* Footer */
        footer {
            background-color: #000;
            padding: 30px;
            text-align: center;
            margin-top: 50px;
        }

        footer p {
            color: #888;
        }

        /* Responsive */
        @media (max-width: 768px) {
            header {
                padding: 15px 20px;
                width: calc(100% - 40px);
            }

            .main-content {
                padding: 40px 20px;
            }

            .page-header h1 {
                font-size: 32px;
            }

            .tickets-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <header>
        <a href="index.php" class="logo">Tiketin</a>
        <nav>
            <a href="index.php">Movies</a>
            <a href="cinemas.php">Cinemas</a>
            <a href="tickets.php" style="color: #f9e103;">Tickets</a>
        </nav>
        <div class="auth-buttons">
            <a href="login.php" class="btn btn-login">Login</a>
            <a href="register.php" class="btn btn-signup">Sign Up</a>
        </div>
    </header>

    <div class="main-content">
        <div class="page-header">
            <h1>My Tickets</h1>
            <p>View and manage your movie bookings</p>
        </div>

        <div class="tabs">
            <button class="tab-btn active" onclick="filterTickets('all')">All Tickets</button>
            <button class="tab-btn" onclick="filterTickets('upcoming')">Upcoming</button>
            <button class="tab-btn" onclick="filterTickets('past')">Past</button>
        </div>

        <div id="ticketsContainer">
            <!-- Tickets will be displayed here -->
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Ticketor. All rights reserved. Book your favorite movies now!</p>
    </footer>

    <script>
        // Sample ticket data - in real app, this would come from database/API
        const tickets = [
            {
                id: 1,
                movie: 'Spider-Man: No Way Home',
                poster: 'https://image.tmdb.org/t/p/w500/1g0dhYtq4irTY1GPXvft6k4YLjm.jpg',
                date: '2024-12-15',
                time: '19:00',
                cinema: 'Cinema XXI Plaza',
                seats: ['D5', 'D6'],
                total: 70000,
                status: 'upcoming',
                bookingId: 'TKT001'
            },
            {
                id: 2,
                movie: 'Avengers: Endgame',
                poster: 'https://image.tmdb.org/t/p/w500/or06FN3Dka5tukK1e9sl16pB3iy.jpg',
                date: '2024-12-10',
                time: '14:30',
                cinema: 'Cinema XXI Grand Mall',
                seats: ['F8', 'F9', 'F10'],
                total: 105000,
                status: 'past',
                bookingId: 'TKT002'
            },
            {
                id: 3,
                movie: 'The Matrix Resurrections',
                poster: 'https://image.tmdb.org/t/p/w500/8c4a8kE7PizaGQQnditMmI1xbRp.jpg',
                date: '2024-12-20',
                time: '21:30',
                cinema: 'Cinema XXI Metropolitan',
                seats: ['G12'],
                total: 35000,
                status: 'upcoming',
                bookingId: 'TKT003'
            }
        ];

        let currentFilter = 'all';

        function displayTickets(ticketsToShow) {
            const container = document.getElementById('ticketsContainer');

            if (ticketsToShow.length === 0) {
                container.innerHTML = `
                    <div class="empty-state">
                        <div class="empty-icon">🎟️</div>
                        <h2>No Tickets Found</h2>
                        <p>You don't have any ${currentFilter === 'all' ? '' : currentFilter} tickets yet.<br>Start booking your favorite movies now!</p>
                        <a href="index.php" class="btn-primary">Browse Movies</a>
                    </div>
                `;
                return;
            }

            let html = '<div class="tickets-grid">';
            
            ticketsToShow.forEach(ticket => {
                const date = new Date(ticket.date);
                const dateStr = date.toLocaleDateString('en-US', { 
                    weekday: 'short', 
                    year: 'numeric', 
                    month: 'short', 
                    day: 'numeric' 
                });

                html += `
                    <div class="ticket-card" onclick="viewTicketDetail(${ticket.id})">
                        <div class="ticket-header">
                            <img src="${ticket.poster}" alt="${ticket.movie}" class="ticket-poster">
                            <div class="ticket-info">
                                <div class="ticket-title">${ticket.movie}</div>
                                <div class="ticket-meta">
                                    <div class="ticket-meta-item">
                                        <span>📅</span>
                                        <span>${dateStr}</span>
                                    </div>
                                    <div class="ticket-meta-item">
                                        <span>🕐</span>
                                        <span>${ticket.time}</span>
                                    </div>
                                    <div class="ticket-meta-item">
                                        <span>🎬</span>
                                        <span>${ticket.cinema}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ticket-body">
                            <div class="ticket-details">
                                <div class="detail-item">
                                    <div class="detail-label">Booking ID</div>
                                    <div class="detail-value">${ticket.bookingId}</div>
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
                                <span class="ticket-qr" title="Show QR Code">📱</span>
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

        function viewTicketDetail(ticketId) {
            const ticket = tickets.find(t => t.id === ticketId);
            alert(`Ticket Details\n\nMovie: ${ticket.movie}\nDate: ${ticket.date}\nTime: ${ticket.time}\nSeats: ${ticket.seats.join(', ')}\nTotal: Rp${ticket.total.toLocaleString('id-ID')}\n\nBooking ID: ${ticket.bookingId}`);
            // In real app, navigate to ticket detail page
            // window.location.href = 'ticket-detail.php?id=' + ticketId;
        }

        // Initialize - display all tickets
        // Change tickets array to [] to see empty state
        displayTickets(tickets);
    </script>
</body>
</html>