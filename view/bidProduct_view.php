<?php
require_once '../model/DbConnector.php';
include_once '../model/wishlist.php';
include_once '../model/addtocart.php'; 
session_start();
date_default_timezone_set('Asia/Colombo');  

if (isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid'];
}
if (isset($_GET['itemid'])) {
    $itemid = $_GET['itemid'];
}


$dsn = new DbConnector();
$con = $dsn->getConnection();

// Fetch product details
$sql = "SELECT * FROM item WHERE itemid = ?";
$stmt = $con->prepare($sql);
$stmt->bindParam(1, $itemid);
$stmt->execute();
$product = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch auction details
$sqlAuction = "SELECT * FROM auction WHERE itemid = ?";
$stmtAuction = $con->prepare($sqlAuction);
$stmtAuction->bindParam(1, $itemid);
$stmtAuction->execute();
$auction = $stmtAuction->fetch(PDO::FETCH_ASSOC);

// Fetch highest bid
$sqlBid = "SELECT MAX(bid_price) as highest_bid FROM bid WHERE auction_id = ?";
$stmtBid = $con->prepare($sqlBid);
$stmtBid->bindParam(1, $auction['auction_id']);
$stmtBid->execute();
$highestBidRow = $stmtBid->fetch(PDO::FETCH_ASSOC);
$highest_bid = $highestBidRow['highest_bid'] ?? $auction['start_price'];
?>
<?php if(!empty($_SESSION['userid'])){?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['itemname']); ?> - Auction Details | Exchanza</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style type="text/tailwindcss">
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            @apply font-['Poppins',sans-serif] bg-gradient-to-br from-[#F3F3F3] to-[#e7e0dc];
        }
        
        .product-gallery-main {
            @apply relative overflow-hidden rounded-[15px] shadow-xl bg-gradient-to-br from-[#f9f7f5] to-white;
        }
        
        .product-gallery-main img {
            @apply w-full h-auto object-contain transition-transform duration-700 hover:scale-105;
        }
        
        .thumbnail-img {
            @apply w-16 h-16 md:w-20 md:h-20 rounded-[10px] border-2 border-[#e7e0dc] cursor-pointer transition-all duration-300 hover:border-[#746557] hover:shadow-lg hover:scale-105 object-cover;
        }
        
        .thumbnail-img.active {
            @apply border-[#746557] shadow-xl scale-105;
        }
        
        .auction-status-badge {
            @apply inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-semibold shadow-lg;
        }
        
        .status-live {
            @apply bg-gradient-to-r from-green-500 to-green-600 text-white animate-pulse;
        }
        
        .status-upcoming {
            @apply bg-gradient-to-r from-blue-500 to-blue-600 text-white;
        }
        
        .status-ended {
            @apply bg-gradient-to-r from-gray-500 to-gray-600 text-white;
        }
        
        .bid-button {
            @apply px-5 py-2.5 bg-gradient-to-r from-[#746557] to-[#4C3F31] text-white font-semibold rounded-[10px] hover:scale-105 hover:shadow-xl transition-all duration-300 flex items-center justify-center gap-2;
        }
        
        .quick-bid-btn {
            @apply px-4 py-3 bg-gradient-to-br from-[#CEC0B9] to-[#d4c5b8] text-[#4C3F31] font-bold rounded-[10px] hover:from-[#746557] hover:to-[#4C3F31] hover:text-white hover:scale-105 hover:shadow-xl transition-all duration-300;
        }
        
        .info-card {
            @apply bg-white rounded-[12px] p-4 shadow-lg border-2 border-[#e7e0dc] transition-all duration-300 hover:shadow-xl hover:border-[#CEC0B9];
        }
        
        .countdown-display {
            @apply bg-gradient-to-br from-[#746557] to-[#4C3F31] text-white px-4 py-2 rounded-[12px] shadow-lg text-center font-bold text-lg;
        }
        
        .price-tag {
            @apply text-3xl md:text-4xl font-extrabold bg-gradient-to-r from-[#746557] to-[#4C3F31] bg-clip-text text-transparent;
        }
        
        @keyframes pulse-glow {
            0%, 100% {
                box-shadow: 0 0 20px rgba(116, 101, 87, 0.5);
            }
            50% {
                box-shadow: 0 0 40px rgba(116, 101, 87, 0.8);
            }
        }
        
        .live-indicator {
            animation: pulse-glow 2s infinite;
        }
        
        .section-title {
            @apply text-2xl md:text-3xl font-bold text-[#4C3F31] font-['Playfair_Display',serif] mb-2;
        }
        
        .breadcrumb-custom {
            @apply flex items-center gap-2 text-sm text-[#897062] mb-3;
        }
        
        .breadcrumb-custom a {
            @apply hover:text-[#746557] transition-colors;
        }
    </style>
    <script>
        function updateCountdown(endTime, countdownId) {
            var end = new Date(endTime).getTime();
            var countdownElement = document.getElementById(countdownId);
            var x = setInterval(function () {
                var now = new Date().getTime();
                var distance = end - now;

                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                countdownElement.innerHTML = days + " " + hours + "h " +
                    minutes + "m " + seconds + "s ";

                if (distance < 0) {
                    clearInterval(x);
                    countdownElement.innerHTML = "EXPIRED";
                }
            }, 1000);
        }

        function placeBid(percentage) {
            let highestBidElement = document.getElementById('highestBid');
            let highestBid = parseFloat(highestBidElement.getAttribute('data-raw-value'));
            let newBid = highestBid * (1 + percentage / 100);

            // Send the bid to the server
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "place_bid.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        try {
                            var response = JSON.parse(xhr.responseText);
                            if (response.status == 'success') {
                                // Update both display and data attribute
                                highestBidElement.setAttribute('data-raw-value', newBid);
                                highestBidElement.innerText = newBid.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                                showCustomAlert('success', 'Bid Placed Successfully!', 'You placed a bid of Rs.' + newBid.toFixed(2));
                                // Reload page to update bid history
                                setTimeout(function() {
                                    location.reload();
                                }, 2000);
                            } else {
                                showCustomAlert('error', 'Bid Failed', response.message || 'Failed to place bid. Please try again.');
                            }
                        } catch (e) {
                            console.error('Parse error:', e);
                            console.error('Response:', xhr.responseText);
                            showCustomAlert('error', 'Error', 'Invalid response from server. Please try again.');
                        }
                    } else {
                        showCustomAlert('error', 'Server Error', 'Unable to connect to server. Please try again.');
                    }
                }
            };
            xhr.send("auction_id=<?php echo $auction['auction_id']; ?>&bid_price=" + newBid + "&userid=<?php echo $userid; ?>");
        }

        function placBidValue() {
            let bidInput = document.getElementById('bidInput');
            let highestBidElement = document.getElementById('highestBid');
            let highestBid = parseFloat(highestBidElement.getAttribute('data-raw-value'));
            let newBid = parseFloat(bidInput.value);

            if (isNaN(newBid) || newBid <= highestBid) {
                showCustomAlert('error', 'Invalid Bid', 'Your bid must be higher than Rs.' + highestBid.toFixed(2));
                return;
            }

            // Send the bid to the server
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "place_bid.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        try {
                            var response = JSON.parse(xhr.responseText);
                            if (response.status == 'success') {
                                // Update both display and data attribute
                                highestBidElement.setAttribute('data-raw-value', newBid);
                                highestBidElement.innerText = newBid.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                                bidInput.value = '';
                                showCustomAlert('success', 'Bid Placed Successfully!', 'You placed a bid of Rs.' + newBid.toFixed(2));
                                // Reload page to update bid history
                                setTimeout(function() {
                                    location.reload();
                                }, 2000);
                            } else {
                                showCustomAlert('error', 'Bid Failed', response.message || 'Failed to place bid. Please try again.');
                            }
                        } catch (e) {
                            console.error('Parse error:', e);
                            console.error('Response:', xhr.responseText);
                            showCustomAlert('error', 'Error', 'Invalid response from server. Please try again.');
                        }
                    } else {
                        showCustomAlert('error', 'Server Error', 'Unable to connect to server. Please try again.');
                    }
                }
            };
            xhr.send("auction_id=<?php echo $auction['auction_id']; ?>&bid_price=" + newBid + "&userid=<?php echo $userid; ?>");
        }
    </script>
</head>

<body>
    <!-- nav bar -->
    <nav class="navbar navbar-expand-lg sticky-top nav">
        <div class="container-fluid logo"><!--logo-->
            <a class="navbar-brand" href="#"><img src="../img/Exchanza.png" width="100px"></a>
            <!--toggle button-->
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!--sidebar-->
            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <!--sidebarheader-->
                <div class="offcanvas-header border-bottom">
                    <h5 class="offcanvas-title " id="offcanvasNavbarLabel">Exchanze</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <!--sider body-->
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-center  flex-grow-1 pe-3">
                        <li class="nav-item mx-2">
                            <a class="nav-link " aria-current="page" href="../index.php">Home</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link active" href="#">Thrift</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link" href="../Project-I_Exchanza/view/bidding.php">Bidding</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link" href="#">Selling</a>
                        </li>
                    </ul>

                    <!--login nav-link-a-color-->
                    <div class="d-flex flex-column float-start flex-lg-row justify-content-center  align-items-center mt-3 mt-lg-0 gap-3">
                        <?php if (isset($_SESSION['userid'])) {
                            $userid = $_SESSION['userid'];

                            $dsn = new DbConnector();
                            $con = $dsn->getConnection();

                            $obj = new Cart();
                            $obj->setUserId($userid);
                            $count = $obj->cartItemCount($con); ?>
                            <a href="addtocart.php" class="nav-link  text-decoration-none mx-1"><i
                                    class="fa-solid fa-cart-plus position-relative"><span
                                        class="position-absolute translate-middle badge rounded-pill bg-danger sp"><?php if (isset($count)) {
                                            echo $count;
                                        } ?></span></i></a><!--addtocart-->
                            <?php

                            $obj = new wishlist();
                            $obj->setUserId($userid);
                            $count = $obj->itemCount($con); ?>
                            <a href="wishlist.php" class="nav-link  text-decoration-none mx-1"><i
                                    class="fa-regular fa-heart position-relative"><span
                                        class="position-absolute translate-middle badge rounded-pill bg-dark sp"><?php if (isset($count)) {
                                            echo $count;
                                        } ?></span></i></a><!--addto wishlist-->
    
    
                            <a href="userpage.php" class=" text-decoration-none"><i class="fa-regular fa-circle-user"
                                    style="font-size:1.5rem;"></i></a>
                            <?php echo "Hi," . ucwords($_SESSION['name']); ?>
                        <?php } else { ?>
                            <a href="addtocart.php" class="nav-link  text-decoration-none mx-1"><i
                                    class="fa-solid fa-cart-plus position-relative"><span
                                        class="position-absolute translate-middle badge rounded-pill bg-danger sp">0</span></i></a><!--addtocart-->
                            <a href="wishlist.php" class="nav-link  text-decoration-none mx-1"><i
                                    class="fa-regular fa-heart position-relative"><span
                                        class="position-absolute translate-middle badge rounded-pill bg-danger sp">0</span></i></a>
                            <a href="login_user.php" class=" text-decoration-none"><button class="lo-button btn-sm ms-2 px-3"
                                    style="color:#ffff;">login</button></a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <!-- Main Content -->
    <div class="container mx-auto max-w-7xl px-4 py-3">
        
        <!-- Breadcrumb -->
        <div class="breadcrumb-custom mb-3">
            <a href="bidding.php" class="hover:text-[#746557]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                </svg>
                Bidding
            </a>
            <span>/</span>
            <span class="text-[#4C3F31] font-semibold">Auction Details</span>
        </div>

        <!-- Auction Status Badge -->
        <div class="mb-3 flex flex-wrap items-center gap-3">
            <?php if (strtotime($auction['start_time']) > time()) { ?>
                <span class="auction-status-badge status-upcoming">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                    </svg>
                    Upcoming Auction
                </span>
            <?php } else if (strtotime($auction['end_time']) >= time()) { ?>
                <span class="auction-status-badge status-live live-indicator">
                    <span class="inline-block w-2 h-2 bg-white rounded-full animate-pulse"></span>
                    Live Auction
                </span>
            <?php } else { ?>
                <span class="auction-status-badge status-ended">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    Auction Ended
                </span>
            <?php } ?>
            
            <button onclick="history.back()" class="ml-auto px-4 py-2 bg-white border-2 border-[#CEC0B9] text-[#4C3F31] rounded-[12px] hover:bg-[#CEC0B9] transition-all duration-300 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back
            </button>
        </div>

        <!-- Main Product Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6 mb-6">
            
            <!-- Left Column - Image Gallery -->
            <div class="space-y-3">
                <div class="product-gallery-main p-3">
                    <img id="mainImage" src="<?php echo htmlspecialchars($product['coverimage']); ?>" 
                         alt="<?php echo htmlspecialchars($product['itemname']); ?>" 
                         class="w-full h-auto max-h-[350px] object-contain mx-auto">
                </div>
                
                <div class="flex justify-center gap-3 flex-wrap">
                    <img class="thumbnail-img active" 
                         src="<?php echo htmlspecialchars($product['coverimage']); ?>" 
                         alt="Main image"
                         onclick="changeMainImage(this)">
                    <?php if (!empty($product['otherimage'])) { ?>
                        <img class="thumbnail-img" 
                             src="<?php echo htmlspecialchars($product['otherimage']); ?>" 
                             alt="Additional image"
                             onclick="changeMainImage(this)">
                    <?php } ?>
                </div>
            </div>

            <!-- Right Column - Product Details -->
            <div class="space-y-3">
                
                <!-- Product Title -->
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-[#4C3F31] font-['Playfair_Display',serif]"><?php echo htmlspecialchars($product['itemname']); ?></h1>
                    <p class="text-[#897062] text-sm leading-relaxed mt-2">
                        <?php echo htmlspecialchars($product['description']); ?>
                    </p>
                </div>

                <!-- Price Information -->
                <div class="info-card">
                    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-3">
                        <div>
                            <p class="text-xs text-[#897062] uppercase tracking-wide mb-1 font-semibold">Current Highest Bid</p>
                            <p class="text-3xl md:text-4xl font-extrabold bg-gradient-to-r from-[#746557] to-[#4C3F31] bg-clip-text text-transparent">
                                Rs.<span id="highestBid" data-raw-value="<?php echo $highest_bid; ?>"><?php echo number_format($highest_bid, 2); ?></span>
                            </p>
                            <?php if ($auction['start_price'] > 0 && $auction['start_price'] != $highest_bid) { ?>
                                <p class="text-[#897062] text-xs mt-1">
                                    Starting bid: <span class="line-through">Rs.<?php echo number_format($auction['start_price'], 2); ?></span>
                                </p>
                            <?php } ?>
                        </div>
                        
                        <!-- Countdown Timer -->
                        <div class="text-center md:text-right">
                            <?php if (strtotime($auction['start_time']) > time()) { ?>
                                <p class="text-xs text-[#897062] uppercase tracking-wide mb-1 font-semibold">Starts In</p>
                                <div class="countdown-display text-base md:text-lg" id="countdown"></div>
                                <script>
                                    updateCountdown("<?php echo $auction['start_time']; ?>", "countdown");
                                </script>
                            <?php } else if (strtotime($auction['end_time']) >= time()) { ?>
                                <p class="text-xs text-[#897062] uppercase tracking-wide mb-1 font-semibold">Ends In</p>
                                <div class="countdown-display text-base md:text-lg" id="countdown"></div>
                                <script>
                                    updateCountdown("<?php echo $auction['end_time']; ?>", "countdown");
                                </script>
                            <?php } else { ?>
                                <div class="countdown-display bg-gradient-to-br from-gray-500 to-gray-600">
                                    Auction Ended
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <!-- Bidding Section - Only show if auction is live -->
                <?php if (strtotime($auction['start_time']) <= time() && strtotime($auction['end_time']) >= time()) { ?>
                    
                    <!-- Custom Bid Input -->
                    <div class="info-card bg-gradient-to-br from-[#f9f7f5] to-white">
                        <h3 class="text-lg font-bold text-[#4C3F31] mb-3 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#746557]" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M8 5a1 1 0 100 2h5.586l-1.293 1.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L13.586 5H8zM12 15a1 1 0 100-2H6.414l1.293-1.293a1 1 0 10-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L6.414 15H12z" />
                            </svg>
                            Place Your Bid
                        </h3>
                        
                        <form onsubmit="event.preventDefault(); placBidValue();" class="space-y-3">
                            <div>
                                <label for="bidInput" class="block text-xs font-semibold text-[#4C3F31] mb-1">
                                    Enter Your Bid Amount
                                </label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[#897062] font-semibold text-base">Rs.</span>
                                    <input type="number" 
                                           id="bidInput" 
                                           step="0.01"
                                           min="<?php echo $highest_bid + 1; ?>"
                                           placeholder="<?php echo number_format($highest_bid + 100, 2); ?>" 
                                           class="w-full pl-14 pr-3 py-3 text-base font-semibold border-2 border-[#e7e0dc] rounded-[12px] focus:border-[#746557] focus:outline-none focus:ring-2 focus:ring-[#CEC0B9] transition-all duration-300"
                                           required>
                                </div>
                                <p class="text-xs text-[#897062] mt-1">
                                    Minimum bid: Rs.<?php echo number_format($highest_bid + 1, 2); ?>
                                </p>
                            </div>
                            
                            <button type="submit" class="bid-button w-full text-base">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd" />
                                </svg>
                                Place Bid Now
                            </button>
                        </form>
                    </div>

                    <!-- Quick Bid Buttons -->
                    <div class="info-card">
                        <h3 class="text-base font-bold text-[#4C3F31] mb-2">Quick Bid Actions</h3>
                        <div class="grid grid-cols-3 gap-2">
                            <button class="quick-bid-btn" onclick="placeBid(5)">
                                <div class="text-lg font-bold">+5%</div>
                                <div class="text-xs mt-1">Rs.<?php echo number_format($highest_bid * 1.05, 2); ?></div>
                            </button>
                            <button class="quick-bid-btn" onclick="placeBid(10)">
                                <div class="text-lg font-bold">+10%</div>
                                <div class="text-xs mt-1">Rs.<?php echo number_format($highest_bid * 1.10, 2); ?></div>
                            </button>
                            <button class="quick-bid-btn" onclick="placeBid(15)">
                                <div class="text-lg font-bold">+15%</div>
                                <div class="text-xs mt-1">Rs.<?php echo number_format($highest_bid * 1.15, 2); ?></div>
                            </button>
                        </div>
                        <p class="text-xs text-[#897062] mt-2 text-center">
                            Click to instantly place a bid above the current highest
                        </p>
                    </div>

                <?php } else if (strtotime($auction['start_time']) > time()) { ?>
                    
                    <!-- Upcoming Auction Notice -->
                    <div class="info-card bg-gradient-to-br from-blue-50 to-blue-100 border-blue-200">
                        <div class="text-center py-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-blue-600 mb-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                            </svg>
                            <h3 class="text-xl font-bold text-[#4C3F31] mb-2">Auction Starting Soon</h3>
                            <p class="text-[#897062] text-sm mb-3">This auction hasn't started yet. Check back soon!</p>
                            <div class="inline-block px-4 py-2 bg-blue-600 text-white rounded-[10px] font-semibold text-sm">
                                Starts: <?php echo date('F j, Y g:i A', strtotime($auction['start_time'])); ?>
                            </div>
                        </div>
                    </div>

                <?php } else { ?>
                    
                    <!-- Auction Ended Notice -->
                    <div class="info-card bg-gradient-to-br from-gray-50 to-gray-100 border-gray-200">
                        <div class="text-center py-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-600 mb-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <h3 class="text-xl font-bold text-[#4C3F31] mb-2">Auction Has Ended</h3>
                            <p class="text-[#897062] text-sm mb-3">This auction closed on <?php echo date('F j, Y g:i A', strtotime($auction['end_time'])); ?></p>
                            <div class="inline-block px-4 py-2 bg-[#746557] text-white rounded-[10px] font-semibold text-sm">
                                Final Bid: Rs.<?php echo number_format($highest_bid, 2); ?>
                            </div>
                        </div>
                    </div>

                <?php } ?>

                <!-- Share & Actions -->
                <div class="flex gap-2 pt-2">
                    <button class="flex-1 px-3 py-2 bg-white border-2 border-[#CEC0B9] text-[#4C3F31] rounded-[10px] hover:bg-[#f9f7f5] transition-all duration-300 flex items-center justify-center gap-2 font-semibold text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M15 8a3 3 0 10-2.977-2.63l-4.94 2.47a3 3 0 100 4.319l4.94 2.47a3 3 0 10.895-1.789l-4.94-2.47a3.027 3.027 0 000-.74l4.94-2.47C13.456 7.68 14.19 8 15 8z" />
                        </svg>
                        Share
                    </button>
                    <button class="flex-1 px-3 py-2 bg-white border-2 border-[#CEC0B9] text-[#4C3F31] rounded-[10px] hover:bg-[#f9f7f5] transition-all duration-300 flex items-center justify-center gap-2 font-semibold text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                        </svg>
                        Save
                    </button>
                </div>

            </div>
        </div>

        <!-- Additional Product Details -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-4">
            <div class="info-card text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto text-[#746557] mb-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <h4 class="font-bold text-[#4C3F31] text-base mb-1">Verified Auction</h4>
                <p class="text-xs text-[#897062]">All items are authenticated</p>
            </div>
            
            <div class="info-card text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto text-[#746557] mb-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                </svg>
                <h4 class="font-bold text-[#4C3F31] text-base mb-1">Secure Bidding</h4>
                <p class="text-xs text-[#897062]">Your information is protected</p>
            </div>
            
            <div class="info-card text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto text-[#746557] mb-2" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z" />
                </svg>
                <h4 class="font-bold text-[#4C3F31] text-base mb-1">Fast Delivery</h4>
                <p class="text-xs text-[#897062]">Nationwide shipping available</p>
            </div>
        </div>
    </div>
    
    <!-- Custom Alert Modal -->
    <div id="customAlertModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm">
        <div class="bg-white rounded-[20px] shadow-2xl max-w-md w-full mx-4 transform transition-all duration-300 scale-95" id="alertModalContent">
            <div class="p-6">
                <!-- Alert Icon -->
                <div class="flex justify-center mb-4">
                    <div id="alertIcon" class="w-20 h-20 rounded-full flex items-center justify-center">
                        <!-- Icon will be inserted by JS -->
                    </div>
                </div>
                
                <!-- Alert Title -->
                <h3 id="alertTitle" class="text-2xl font-bold text-center mb-3 font-['Playfair_Display',serif]"></h3>
                
                <!-- Alert Message -->
                <p id="alertMessage" class="text-center text-[#897062] mb-6 text-base"></p>
                
                <!-- Close Button -->
                <button onclick="closeCustomAlert()" class="w-full py-3 bg-gradient-to-r from-[#746557] to-[#4C3F31] text-white font-semibold rounded-[12px] hover:scale-105 hover:shadow-xl transition-all duration-300">
                    Close
                </button>
            </div>
        </div>
    </div>

    <script>
        // Custom Alert Function
        function showCustomAlert(type, title, message) {
            const modal = document.getElementById('customAlertModal');
            const modalContent = document.getElementById('alertModalContent');
            const iconDiv = document.getElementById('alertIcon');
            const titleEl = document.getElementById('alertTitle');
            const messageEl = document.getElementById('alertMessage');
            
            // Set content
            titleEl.textContent = title;
            messageEl.textContent = message;
            
            // Set icon and colors based on type
            if (type === 'success') {
                iconDiv.className = 'w-20 h-20 rounded-full flex items-center justify-center bg-gradient-to-br from-[#746557] to-[#4C3F31]';
                iconDiv.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>';
                titleEl.className = 'text-2xl font-bold text-center mb-3 font-["Playfair_Display",serif] text-[#4C3F31]';
            } else if (type === 'error') {
                iconDiv.className = 'w-20 h-20 rounded-full flex items-center justify-center bg-gradient-to-br from-[#AE9D92] to-[#897062]';
                iconDiv.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" /></svg>';
                titleEl.className = 'text-2xl font-bold text-center mb-3 font-["Playfair_Display",serif] text-[#746557]';
            } else {
                iconDiv.className = 'w-20 h-20 rounded-full flex items-center justify-center bg-gradient-to-br from-[#CEC0B9] to-[#AE9D92]';
                iconDiv.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" /></svg>';
                titleEl.className = 'text-2xl font-bold text-center mb-3 font-["Playfair_Display",serif] text-[#4C3F31]';
            }
            
            // Show modal with animation
            modal.classList.remove('hidden');
            setTimeout(() => {
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }, 10);
        }
        
        function closeCustomAlert() {
            const modal = document.getElementById('customAlertModal');
            const modalContent = document.getElementById('alertModalContent');
            
            modalContent.classList.remove('scale-100');
            modalContent.classList.add('scale-95');
            
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }
        
        // Function to change main image when clicking thumbnails
        function changeMainImage(thumbnail) {
            document.getElementById('mainImage').src = thumbnail.src;
            document.querySelectorAll('.thumbnail-img').forEach(img => {
                img.classList.remove('active');
            });
            thumbnail.classList.add('active');
        }
    </script>
    <!--footer-->
    <div class="container-fluid footer">
        <div class="container p-3">
            <div class="row">
                <div class="col">
                    <img src="../img/Exchanza.png" width="200px">
                </div>
            </div>
            <div class="row  mt-4" style="border-bottom:1px solid black;">
                <div class="col">
                    <p class=""><i class="fa-solid fa-phone"></i>&nbsp;&nbsp;+94 112 555 444</p>
                    <p class=""><i class="fa-solid fa-envelope"></i>&nbsp;&nbsp;exchanza@gmail.com</p>
                    <p class=""><i class="fa-solid fa-location-dot"></i>&nbsp;&nbsp;No.56/2,Kotta Rd,Colombo
                        05,<br>&nbsp;&nbsp;&nbsp;&nbsp;Sri Lanka</p>
                </div>
                <div class="col lin">
                    <h5>Information</h5>
                    <p><a href="#1">Privacy &amp; Policy</a></p>
                    <p><a href="#1">About Us</a></p>
                    <p><a href="#1">Terms &amp; Condition</a></p>
                </div>
                <div class="col lin">
                    <h5>Connect with Us</h5>
                    <p><a href=""><i class="fa-brands fa-facebook" style="font-size:50px;"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=""><i class="fa-brands fa-instagram" style="font-size:50px;"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=""><i class="fa-brands fa-youtube" style="font-size:50px;"></i></a></p>
                </div>
            </div>
            <div class="row mt-2">
                <div class="d-flex justify-content-between flex-column flex-md-row">
                    <div><i class="fa-brands fa-cc-visa" style="font-size:50px;"></i>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa-brands fa-cc-mastercard" style="font-size:50px;"></i>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa-brands fa-cc-amex" style="font-size:50px;"></i></div>
                    <div>&copy;Exchanze All Rights are reserved</div>

                </div>
            </div>
        </div>
    </div>
</body>

</html>
<?php }else{
    header("Location:login_user.php");
    exit();
}?>