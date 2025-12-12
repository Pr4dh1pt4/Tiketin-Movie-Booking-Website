<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Tickets - <?php echo isset($_GET['movie']) ? ucwords(str_replace('-', ' ', $_GET['movie'])) : 'Movie'; ?></title>
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

        /* Header */
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

        nav a:hover {
            color: #f9e103;
        }

        .search-bar {
            padding: 8px 15px;
            width: 300px;
            border: none;
            border-radius: 5px;
            background-color: #fff;
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

        /* Movie Info Section */
        .movie-info {
            margin-top: 120px;
            padding: 40px 50px;
            display: flex;
            gap: 30px;
            align-items: flex-start;
            max-width: 1400px;
            margin-left: auto;
            margin-right: auto;
        }

        .movie-poster-large {
            width: 250px;
            height: 350px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        .movie-poster-large img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .movie-details {
            flex: 1;
        }

        .movie-category {
            color: #f9e103;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 10px;
        }

        .movie-title {
            font-size: 48px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        /* Booking Section */
        .booking-container {
            padding: 0 50px 50px;
            max-width: 1400px;
            margin: 0 auto;
            background-color: #1a1a1a;
            border-radius: 15px;
            border: 2px solid #2a2a2a;
        }

        .booking-header {
            display: grid;
            grid-template-columns: 2fr 1.5fr; /* kiri lebih lebar dari kanan */
            gap: 40px;
            justify-content: space-between;
            padding: 30px;
            border-bottom: 1px solid #2a2a2a;
        }

        .date-selector {
            flex: 1;
        }

        .date-selector h3 {
            font-size: 18px;
            margin-bottom: 15px;
            color: #ccc;
        }

        .date-scroll-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            gap: 10px;
            max-width: 600px; /* Limit width to show only few dates */
        }

        .scroll-btn {
            background-color: #2a2a2a;
            border: 1px solid #3a3a3a;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            min-width: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
            color: #fff;
            font-size: 18px;
            flex-shrink: 0;
        }

        .scroll-btn:hover:not(:disabled) {
            background-color: #f9e103;
            color: #000;
            transform: scale(1.1);
        }

        .scroll-btn:disabled {
            opacity: 0.3;
            cursor: not-allowed;
        }

        .dates-scroll-container {
            overflow-x: auto;
            overflow-y: hidden;
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none; /* IE and Edge */
            flex: 1;
        }

        .dates-scroll-container::-webkit-scrollbar {
            display: none; /* Chrome, Safari, Opera */
        }

        .dates {
            display: flex;
            gap: 10px;
            scroll-behavior: smooth;
            width: max-content; /* Make it scrollable */
        }

        .date-btn {
            padding: 12px 18px;
            background-color: #2a2a2a;
            border: none;
            border-radius: 10px;
            color: #fff;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 14px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
            min-width: 75px;
            flex-shrink: 0;
        }

        .date-btn .day-name {
            font-weight: bold;
            font-size: 12px;
            color: #888;
        }

        .date-btn .date-number {
            font-size: 20px;
            font-weight: bold;
        }

        .date-btn .month-name {
            font-size: 11px;
            color: #888;
        }

        .date-btn:hover, .date-btn.active {
            background-color: #f9e103;
            color: #000;
        }

        .date-btn.active .day-name,
        .date-btn.active .month-name {
            color: #000;
        }

        .time-selector {
            flex: 1;
        }

        .time-selector h3 {
            font-size: 18px;
            margin-bottom: 15px;
            color: #ccc;
        }

        .times {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .time-btn {
            padding: 10px 20px;
            background-color: #2a2a2a;
            border: none;
            border-radius: 5px;
            color: #fff;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 14px;
        }

        .time-btn:hover, .time-btn.active {
            background-color: #f9e103;
            color: #000;
        }

        /* Seat Selection */
        .seat-selection {
            display: flex;
            gap: 50px;
            padding: 40px 30px;
        }

        .theater {
            flex: 2;
        }

        .screen {
            text-align: center;
            margin-bottom: 40px;
        }

        .screen::before {
            content: '';
            display: block;
            width: 100%;
            height: 3px;
            background: linear-gradient(to right, transparent, #fff, transparent);
            margin-bottom: 10px;
        }

        .screen-label {
            font-size: 12px;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .seats-container {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .seat-row {
            display: flex;
            justify-content: center;
            gap: 10px;
            align-items: center;
        }

        .row-label {
            width: 30px;
            text-align: center;
            font-weight: bold;
            color: #888;
        }

        .seat {
            width: 30px;
            height: 30px;
            background-color: #2a2a2a;
            border: 2px solid #3a3a3a;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .seat:hover {
            background-color: #4a4a4a;
            transform: scale(1.1);
        }

        .seat.selected {
            background-color: #ff9800;
            border-color: #ff9800;
        }

        .seat.occupied {
            background-color: #666;
            border-color: #666;
            cursor: not-allowed;
        }

        .seat-legend {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-top: 30px;
            font-size: 14px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .legend-box {
            width: 20px;
            height: 20px;
            border-radius: 3px;
        }

        .legend-box.available {
            background-color: #2a2a2a;
            border: 2px solid #3a3a3a;
        }

        .legend-box.selected {
            background-color: #ff9800;
        }

        /* Order Summary */
        .order-summary {
            flex: 1;
            background-color: #0a0a0a;
            padding: 30px;
            border-radius: 10px;
            border: 1px solid #2a2a2a;
            height: fit-content;
        }

        .order-summary h3 {
            font-size: 20px;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .selected-seats-list {
            margin-bottom: 20px;
        }

        .seat-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #2a2a2a;
        }

        .seat-item:last-child {
            border-bottom: none;
        }

        .remove-seat {
            background: none;
            border: none;
            color: #ff5555;
            cursor: pointer;
            font-size: 18px;
        }

        .total-price {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid #2a2a2a;
            font-size: 24px;
            font-weight: bold;
        }

        .checkout-btn {
            width: 100%;
            padding: 15px;
            background-color: #f9e103;
            color: #000;
            border: none;
            border-radius: 50px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 20px;
            transition: all 0.3s;
        }

        .checkout-btn:hover {
            background-color: #ffd700;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(249, 225, 3, 0.3);
        }

        .checkout-btn:disabled {
            background-color: #555;
            cursor: not-allowed;
            transform: none;
        }
    </style>
</head>
<body>
    <header>
        <a href="index.php" class="logo">Tiketin</a>
        <nav>
            <a href="index.php">Movies</a>
            <a href="cinemas.php">Cinemas</a>
            <a href="tickets.php">Tickets</a>
        </nav>
        <div class="auth-buttons">
            <a href="#login" class="btn btn-login">Login</a>
            <a href="#signup" class="btn btn-signup">Sign Up</a>
        </div>
    </header>

    <div class="movie-info">
        <?php
        // Data film dari index
        $movies = [
            1 => [
                'title' => 'Spider-Man: No Way Home',
                'category' => 'Spider-Man',
                'poster' => 'https://image.tmdb.org/t/p/w500/1g0dhYtq4irTY1GPXvft6k4YLjm.jpg'
            ],
            2 => [
                'title' => 'Avengers: Endgame',
                'category' => 'Avengers',
                'poster' => 'https://image.tmdb.org/t/p/w500/or06FN3Dka5tukK1e9sl16pB3iy.jpg'
            ],
            3 => [
                'title' => 'Avengers: Infinity War',
                'category' => 'Avengers',
                'poster' => 'https://image.tmdb.org/t/p/w500/7WsyChQLEftFiDOVTGkv3hFpyyt.jpg'
            ],
            4 => [
                'title' => 'Avengers: Age of Ultron',
                'category' => 'Avengers',
                'poster' => 'https://image.tmdb.org/t/p/w500/4ssDuvEDkSArWEdyBl2X5EHvYKU.jpg'
            ],
            5 => [
                'title' => 'Captain America: Civil War',
                'category' => 'Captain America',
                'poster' => 'https://image.tmdb.org/t/p/w500/rAGiXaUfPu0D8FaeOJMHV4gKLJi.jpg'
            ],
            6 => [
                'title' => 'Spider-Man: Far From Home',
                'category' => 'Spider-Man',
                'poster' => 'https://image.tmdb.org/t/p/w500/4q2NNj4S5dG2RLF9CpXsej7yXl.jpg'
            ],
            7 => [
                'title' => 'The Matrix Resurrections',
                'category' => 'The Matrix',
                'poster' => 'https://image.tmdb.org/t/p/w500/8c4a8kE7PizaGQQnditMmI1xbRp.jpg'
            ],
            8 => [
                'title' => 'Black Widow',
                'category' => 'Marvel',
                'poster' => 'https://image.tmdb.org/t/p/w500/qAZ0pzat24kLdO3o8ejmbLxyOac.jpg'
            ],
            9 => [
                'title' => 'Mad Max: Fury Road',
                'category' => 'Mad Max',
                'poster' => 'https://image.tmdb.org/t/p/w500/hA2ple9q4qnwxp3hKVNhroipsir.jpg'
            ],
            10 => [
                'title' => 'Guardians of the Galaxy',
                'category' => 'Marvel',
                'poster' => 'https://image.tmdb.org/t/p/w500/r7vmZjiyZw9rpJMQJdXpjgiCOk9.jpg'
            ],
            11 => [
                'title' => 'Thor: Ragnarok',
                'category' => 'Thor',
                'poster' => 'https://image.tmdb.org/t/p/w500/rzRwTcFvttcN1ZpX2xv4j3tSdJu.jpg'
            ],
            12 => [
                'title' => 'Black Panther',
                'category' => 'Marvel',
                'poster' => 'https://image.tmdb.org/t/p/w500/uxzzxijgPIY7slzFvMotPv8wjKA.jpg'
            ]
        ];

        $movieId = isset($_GET['id']) ? (int)$_GET['id'] : 1;
        $currentMovie = isset($movies[$movieId]) ? $movies[$movieId] : $movies[1];
        
        // Pisahkan title menjadi category dan subtitle
        $titleParts = explode(':', $currentMovie['title']);
        $mainTitle = trim($titleParts[0]);
        $subtitle = isset($titleParts[1]) ? trim($titleParts[1]) : '';
        ?>
        
        <div class="movie-poster-large">
            <img src="<?php echo htmlspecialchars($currentMovie['poster']); ?>" alt="<?php echo htmlspecialchars($currentMovie['title']); ?>">
        </div>
        <div class="movie-details">
            <div class="movie-category"><?php echo htmlspecialchars($currentMovie['category']); ?></div>
            <h1 class="movie-title">
                <?php 
                if ($subtitle) {
                    echo strtoupper(htmlspecialchars($subtitle));
                } else {
                    echo strtoupper(htmlspecialchars($mainTitle));
                }
                ?>
            </h1>
        </div>
    </div>

    <div class="booking-container">
        <div class="booking-header">
            <div class="date-selector">
                <h3>DATE</h3>
                <div class="date-scroll-wrapper">
                    <button class="scroll-btn" id="scrollLeftBtn" onclick="scrollDates('left')">‹</button>
                    <div class="dates-scroll-container" id="datesScrollContainer">
                        <div class="dates" id="datesContainer">
                            <!-- Dates will be generated dynamically -->
                        </div>
                    </div>
                    <button class="scroll-btn" id="scrollRightBtn" onclick="scrollDates('right')">›</button>
                </div>
            </div>
            <div class="time-selector">
                <h3>AVAILABLE TIMES</h3>
                <div class="times">
                    <button class="time-btn active">11.15</button>
                    <button class="time-btn">12.40</button>
                    <button class="time-btn">14.20</button>
                    <button class="time-btn">16.45</button>
                    <button class="time-btn">19.00</button>
                    <button class="time-btn">21.30</button>
                </div>
            </div>
        </div>

        <div class="seat-selection">
            <div class="theater">
                <div class="screen">
                    <div class="screen-label">Screen</div>
                </div>
                <div class="seats-container" id="seatsContainer">
                    <?php
                    $rows = ['I', 'H', 'G', 'F', 'E', 'D', 'C', 'B', 'A'];
                    $seatsPerRow = 20;
                    $occupiedSeats = ['']; // Kursi yang sudah terisi

                    foreach ($rows as $row) {
                        echo '<div class="seat-row">';
                        echo '<span class="row-label">' . $row . '</span>';
                        
                        for ($i = 1; $i <= $seatsPerRow; $i++) {
                            $seatId = $row . '-' . $i;
                            $occupied = in_array($seatId, $occupiedSeats) ? 'occupied' : '';
                            
                            if ($i == 10) {
                                echo '<div style="width: 40px;"></div>'; // Jarak tengah
                            }
                            
                            echo '<div class="seat ' . $occupied . '" data-seat="' . $seatId . '"></div>';
                        }
                        
                        echo '<span class="row-label">' . $row . '</span>';
                        echo '</div>';
                    }
                    ?>
                </div>

                <div class="seat-legend">
                    <div class="legend-item">
                        <div class="legend-box available"></div>
                        <span>Available</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-box selected"></div>
                        <span>Selected</span>
                    </div>
                </div>
            </div>

            <div class="order-summary">
                <h3>Selected Seats:</h3>
                <div class="selected-seats-list" id="selectedSeatsList">
                    <p style="color: #888; text-align: center;">No seats selected</p>
                </div>
                <div class="total-price">
                    Total: <span id="totalPrice">Rp0</span>
                </div>
                <button class="checkout-btn" id="checkoutBtn" disabled>Bayar (Rp0)</button>
            </div>
        </div>
    </div>

    <script>
        const seatPrice = 35000;
        let selectedSeats = [];
        let selectedDate = null;
        let selectedTime = null;

        // Scroll dates function
        function scrollDates(direction) {
            const container = document.getElementById('datesScrollContainer');
            const scrollAmount = 250; // Scroll by approximately 3 dates
            
            if (direction === 'left') {
                container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
            } else {
                container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            }
            
            // Update button states after scroll
            setTimeout(updateScrollButtons, 300);
        }

        // Update scroll button states
        function updateScrollButtons() {
            const container = document.getElementById('datesScrollContainer');
            const leftBtn = document.getElementById('scrollLeftBtn');
            const rightBtn = document.getElementById('scrollRightBtn');
            
            // Check if at start
            if (container.scrollLeft <= 0) {
                leftBtn.disabled = true;
            } else {
                leftBtn.disabled = false;
            }
            
            // Check if at end
            if (container.scrollLeft + container.clientWidth >= container.scrollWidth - 1) {
                rightBtn.disabled = true;
            } else {
                rightBtn.disabled = false;
            }
        }

        // Generate dates dynamically (next 14 days for scrolling)
        function generateDates() {
            const datesContainer = document.getElementById('datesContainer');
            const today = new Date();
            const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            
            // Generate 14 days instead of 7 for scrolling
            for (let i = 0; i < 14; i++) {
                const date = new Date(today);
                date.setDate(today.getDate() + i);
                
                const dayName = days[date.getDay()];
                const dateNumber = date.getDate();
                const monthName = months[date.getMonth()];
                const fullDate = date.toISOString().split('T')[0];
                
                const btn = document.createElement('button');
                btn.className = 'date-btn' + (i === 0 ? ' active' : '');
                btn.dataset.date = fullDate;
                btn.innerHTML = `
                    <span class="day-name">${dayName}</span>
                    <span class="date-number">${dateNumber}</span>
                    <span class="month-name">${monthName}</span>
                `;
                
                btn.addEventListener('click', function() {
                    document.querySelectorAll('.date-btn').forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    selectedDate = this.dataset.date;
                    console.log('Selected date:', selectedDate);
                });
                
                datesContainer.appendChild(btn);
                
                // Set initial selected date
                if (i === 0) {
                    selectedDate = fullDate;
                }
            }
            
            // Initialize scroll buttons
            updateScrollButtons();
            
            // Add scroll listener to update buttons
            const container = document.getElementById('datesScrollContainer');
            container.addEventListener('scroll', updateScrollButtons);
        }

        // Initialize dates on page load
        generateDates();

        // Seat selection logic
        document.querySelectorAll('.seat:not(.occupied)').forEach(seat => {
            seat.addEventListener('click', function() {
                const seatId = this.dataset.seat;
                
                if (this.classList.contains('selected')) {
                    this.classList.remove('selected');
                    selectedSeats = selectedSeats.filter(s => s !== seatId);
                } else {
                    this.classList.add('selected');
                    selectedSeats.push(seatId);
                }
                
                updateOrderSummary();
            });
        });

        function updateOrderSummary() {
            const seatsList = document.getElementById('selectedSeatsList');
            const totalPrice = document.getElementById('totalPrice');
            const checkoutBtn = document.getElementById('checkoutBtn');
            
            if (selectedSeats.length === 0) {
                seatsList.innerHTML = '<p style="color: #888; text-align: center;">No seats selected</p>';
                totalPrice.textContent = 'Rp0';
                checkoutBtn.disabled = true;
                checkoutBtn.textContent = 'Bayar (Rp0)';
            } else {
                let html = '';
                selectedSeats.forEach(seatId => {
                    const rowLabel = seatId.split('-')[0];
                    const seatNumber = seatId.split('-')[1];
                    html += `
                        <div class="seat-item">
                            <span>${rowLabel}${seatNumber}</span>
                            <span>Rp${seatPrice.toLocaleString('id-ID')}</span>
                            <button class="remove-seat" onclick="removeSeat('${seatId}')">×</button>
                        </div>
                    `;
                });
                seatsList.innerHTML = html;
                
                const total = selectedSeats.length * seatPrice;
                totalPrice.textContent = 'Rp' + total.toLocaleString('id-ID');
                checkoutBtn.disabled = false;
                checkoutBtn.textContent = `Bayar (Rp${total.toLocaleString('id-ID')})`;
            }
        }

        function removeSeat(seatId) {
            document.querySelector(`[data-seat="${seatId}"]`).classList.remove('selected');
            selectedSeats = selectedSeats.filter(s => s !== seatId);
            updateOrderSummary();
        }

        // Time selector
        document.querySelectorAll('.time-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.time-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                selectedTime = this.textContent;
                console.log('Selected time:', selectedTime);
            });
        });

        // Set initial time
        selectedTime = document.querySelector('.time-btn.active').textContent;

        // Checkout
        document.getElementById('checkoutBtn').addEventListener('click', function() {
            if (selectedSeats.length > 0) {
                const bookingDetails = `
                Booking Confirmed! 🎬

                Movie: <?php echo addslashes($currentMovie['title']); ?>
                Date: ${formatDate(selectedDate)}
                Time: ${selectedTime}
                Seats: ${selectedSeats.join(', ')}
                Total: Rp${(selectedSeats.length * seatPrice).toLocaleString('id-ID')}
                `;
                alert(bookingDetails);
                
                // Optional: Send to backend
                // submitBooking(selectedDate, selectedTime, selectedSeats);
            }
        });

        function formatDate(dateString) {
            const date = new Date(dateString);
            const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            
            return `${days[date.getDay()]}, ${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear()}`;
        }

        // Optional: Function to submit booking to backend
        function submitBooking(date, time, seats) {
            const bookingData = {
                movie_id: <?php echo $movieId; ?>,
                date: date,
                time: time,
                seats: seats,
                total: seats.length * seatPrice
            };
            
            // Send to backend via fetch/AJAX
            // fetch('process_booking.php', {
            //     method: 'POST',
            //     headers: {'Content-Type': 'application/json'},
            //     body: JSON.stringify(bookingData)
            // })
            // .then(response => response.json())
            // .then(data => {
            //     if(data.success) {
            //         window.location.href = 'payment.php?booking_id=' + data.booking_id;
            //     }
            // });
            
            console.log('Booking data:', bookingData);
        }
    </script>
</body>
</html>
