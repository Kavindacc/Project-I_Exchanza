<?php 
session_start(); 
$userid = $_SESSION['userid'] ?? null;


include_once '../model/DbConnector.php';
include_once '../model/wishlist.php';
include_once '../model/addtocart.php';
include_once '../model/auction.php';

// Create an instance of the Auction class
$auction = new Auction();

// Fetch data using the model methods
$ongoingBids = $auction->getOngoingAuctions();
$upcomingBids = $auction->getUpcomingAuctions();
$finishedBids = $auction->getFinishedAuctions();


    date_default_timezone_set('Asia/Colombo');

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Bidding</title>
    <!-- countdown Function -->
    
    <script>
    
    function updateCountdown(startTime, endTime, countdownDomId, auctionId) {
            var interval = setInterval(function() {
                let startDate = new Date(startTime);
                let endDate = new Date(endTime);

                if (!startDate) {
                    document.getElementById(countdownDomId).innerHTML = '00:00:00:00';
                } else {
                    var now = new Date().getTime();
                    var distanceToStart = startDate.getTime() - now;
                    var distanceToEnd = endDate.getTime() - now;
                    var timeLabel = "Time Left to Start: ";

                    if (distanceToStart < 0) {
                        if (distanceToEnd < 0) {
                            clearInterval(interval);
                            document.getElementById(countdownDomId).innerHTML = 'Bidding finished';
                            moveToFinished(auctionId);
                            return;
                        } else {
                            distanceToStart = distanceToEnd;
                            timeLabel = "Time Left to End: ";
                            moveToOngoing(auctionId);
                        }
                    }

                    var days = Math.floor(distanceToStart / (1000 * 60 * 60 * 24));
                    var hours = Math.floor((distanceToStart % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    var minutes = Math.floor((distanceToStart % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((distanceToStart % (1000 * 60)) / 1000);

                    document.getElementById(countdownDomId).innerHTML = `${timeLabel} ${(days + '').padStart(2, '0')}:${(hours + '').padStart(2, '0')}:${(minutes + '').padStart(2, '0')}:${(seconds + '').padStart(2, '0')}`;
                }
            }, 1000);
        }

        function moveToOngoing(auctionId) {
            var bidCard = document.getElementById('bidCard' + auctionId);
            var ongoingContainer = document.querySelector('.ongoing .product-container');
            if (bidCard && ongoingContainer && !bidCard.classList.contains('moved-to-ongoing')) {
                ongoingContainer.appendChild(bidCard);
                bidCard.classList.add('moved-to-ongoing');
                var bidButton = bidCard.querySelector('.card-btn');
                bidButton.innerHTML = "Bid Now";
            }
        }

        function moveToFinished(auctionId) {
            var bidCard = document.getElementById('bidCard' + auctionId);
            var finishedContainer = document.querySelector('.finished .product-container');
            if (bidCard && finishedContainer && !bidCard.classList.contains('moved-to-finished')) {
                finishedContainer.appendChild(bidCard);
                bidCard.classList.add('moved-to-finished');
                var bidButton = bidCard.querySelector('.card-btn');
                bidButton.innerHTML = "View Bid";
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            <?php foreach ($ongoingBids as $auction) { ?>
                updateCountdown('<?php echo $auction['start_time']; ?>', '<?php echo $auction['end_time']; ?>', 'ongoingCountdown<?php echo $auction['auction_id']; ?>', <?php echo $auction['auction_id']; ?>);
            <?php } ?>

            <?php foreach ($upcomingBids as $auction) { ?>
                updateCountdown('<?php echo $auction['start_time']; ?>', '<?php echo $auction['end_time']; ?>', 'upcomingCountdown<?php echo $auction['auction_id']; ?>', <?php echo $auction['auction_id']; ?>);
            <?php } ?>

            <?php foreach ($finishedBids as $auction) { ?>
                updateCountdown('<?php echo $auction['start_time']; ?>', '<?php echo $auction['end_time']; ?>', 'finishedCountdown<?php echo $auction['auction_id']; ?>', <?php echo $auction['auction_id']; ?>);
            <?php } ?>
        });


    </script>

    <style type="text/tailwindcss">
        /* Premium Auction Design Styles */
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            @apply font-['Poppins',sans-serif];
        }
        
        .product{
            @apply relative overflow-hidden p-[20px] transition-all duration-500;
        }
        
        .product-category{
            @apply py-0 px-[10vw] text-[36px] font-[600] mb-[50px] capitalize text-[#4C3F31] font-['Playfair_Display',serif] tracking-wide relative;
        }
        
        .product-category::after {
            content: '';
            @apply absolute bottom-[-15px] left-[10vw] w-[100px] h-[3px] bg-gradient-to-r from-[#746557] to-[#AE9D92];
        }
        
        .product-container{
            @apply py-1 px-[10vw] flex overflow-y-hidden overflow-x-auto scroll-smooth gap-8;
        }
        
        .product-container::-webkit-scrollbar{
            @apply h-2;
        }
        
        .product-container::-webkit-scrollbar-track{
            @apply bg-[#e7e0dc] rounded-full;
        }
        
        .product-container::-webkit-scrollbar-thumb{
            @apply bg-[#746557] rounded-full hover:bg-[#4C3F31];
        }
        
        .product-card{
            @apply flex-[0_0_auto] w-[280px] h-[480px] bg-white rounded-[20px] shadow-lg overflow-hidden transition-all duration-500 hover:shadow-2xl hover:-translate-y-2 border border-[#e7e0dc];
        }
        
        .product-image{
            @apply relative w-full h-[340px] overflow-hidden bg-gradient-to-br from-[#CEC0B9] to-[#e7e0dc];
        }
        
        .product-thumb{
            @apply w-full h-full object-cover transition-transform duration-700 hover:scale-110;
        }
        
        .countdown-tag {
            @apply absolute bg-gradient-to-r from-[#746557] to-[#4C3F31] px-3 py-2 rounded-[10px] text-white right-[10px] top-[10px] capitalize text-sm font-semibold shadow-lg backdrop-blur-sm;
        }
        
        .card-btn{
            @apply absolute bottom-[15px] left-[50%] -translate-x-1/2 px-6 py-3 w-[80%] capitalize border-2 border-[#746557] bg-white rounded-[12px] duration-300 cursor-pointer opacity-0 text-[#4C3F31] font-semibold text-center shadow-lg hover:shadow-xl;    
        }
        
        .product-card:hover .card-btn {
            @apply opacity-100 translate-y-0;
        }

        .card-btn:hover{
            @apply bg-[#746557] text-white scale-105 tracking-wider border-[#4C3F31];
        }
        
        .product-info{
            @apply w-full h-full pt-[15px] px-[20px] bg-gradient-to-b from-white to-[#f9f7f5];
        }
        
        .product-brand{
            @apply font-semibold text-[18px] text-[#4C3F31] mb-2 truncate hover:text-[#746557] transition-colors;
        }
        
        .product-short-description{
            @apply w-full h-[40px] leading-[20px] overflow-hidden text-[#897062] text-sm my-2;
        }
        
        .price{
            @apply font-extrabold text-[24px] text-[#746557] tracking-tight;
        }
        
        .actual-price{
            @apply ml-[15px] opacity-50 line-through text-[16px];
        }
        
        .pre-btn,.nxt-btn{
            @apply border-0 w-[60px] h-[60px] rounded-full absolute top-[50%] -translate-y-1/2 flex justify-center items-center bg-white shadow-xl cursor-pointer z-20 transition-all duration-300 hover:scale-110 hover:shadow-2xl;
        }
        
        .pre-btn {
            @apply left-[20px];
        }
        
        .nxt-btn {
            @apply right-[20px];
        }
        
        .pre-btn img,
        .nxt-btn img {
            @apply opacity-60 w-[24px] h-[24px];
        }
        
        .pre-btn:hover img,
        .nxt-btn:hover img {
            @apply opacity-100;
        }
        
        .pre-btn:hover {
            @apply bg-[#CEC0B9] -translate-x-1 -translate-y-1/2;
        }
        
        .nxt-btn:hover {
            @apply bg-[#CEC0B9] translate-x-1 -translate-y-1/2;
        }
        
        .collection-container {
            @apply w-full grid grid-cols-2 gap-2.5;
        }
        
        .collection {
            @apply relative rounded-[20px] overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500;
        }
        
        .collection img {
            @apply w-full h-full object-cover transition-transform duration-700 hover:scale-105;
        }
        
        .collection p {
            @apply absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-center text-white text-5xl capitalize font-['Playfair_Display',serif];
        }
        
        .collection:nth-child(3) {
            @apply col-span-2 mb-2.5;
        }
        
        .addbit-btn{
            @apply px-8 py-3 my-2 uppercase font-semibold border-2 border-[#AE9D92] bg-gradient-to-r from-[#CEC0B9] to-[#d4c5b8] rounded-[12px] duration-300 cursor-pointer text-[#4C3F31] hover:scale-105 hover:tracking-widest hover:shadow-2xl hover:from-[#746557] hover:to-[#4C3F31] hover:text-white transition-all;
        }
        
        .main-div#blur.active{
            @apply blur-[30px] pointer-events-none select-none;
        }
        
        #bidpopupform {
            @apply bg-white fixed top-[50%] left-[50%] -translate-x-1/2 -translate-y-1/2 p-[30px] shadow-2xl rounded-[20px] transition-all duration-500 w-[85vw] max-w-[1200px] h-[85vh] max-h-[800px] invisible opacity-0 scale-95 border-2 border-[#e7e0dc];
        }
        
        #bidpopupform.active {
            @apply opacity-100 visible scale-100; 
        }
        
        .f-title{
            @apply font-bold text-[2.2rem] uppercase mb-4 text-[#4C3F31] font-['Playfair_Display',serif] tracking-wide;
        }
        
        .bform-items{
            @apply py-2 pr-3;
        }
        
        .bflable{
            @apply font-semibold text-[#4C3F31] mb-1 block text-sm;
        }
        
        .form-control{
            @apply w-full px-4 py-3 placeholder-[#897062] border-2 border-[#e7e0dc] rounded-[10px] focus:border-[#746557] focus:outline-none focus:ring-2 focus:ring-[#CEC0B9] transition-all duration-300;
        }
        
        .form-control-file{
            @apply w-full text-[#897062] border-2 border-[#e7e0dc] rounded-[10px] font-medium text-sm file:cursor-pointer cursor-pointer file:border-0 file:py-3 file:px-6 file:mr-4 file:bg-gradient-to-r file:from-[#CEC0B9] file:to-[#d4c5b8] file:hover:from-[#746557] file:hover:to-[#4C3F31] file:text-[#4C3F31] file:hover:text-white file:rounded-[8px] file:font-semibold file:transition-all file:duration-300;
        }
        
        .form-control-time{
            @apply w-full px-4 py-3 text-[#7b6457] border-2 border-[#e7e0dc] rounded-[10px] shadow-sm focus:outline-none focus:ring-2 focus:ring-[#CEC0B9] focus:border-[#746557] text-sm uppercase transition-all duration-300;
        }
        
        .plsBid-btn{
            @apply px-8 py-4 my-4 w-full md:w-auto uppercase font-bold border-2 border-[#746557] bg-gradient-to-r from-[#746557] to-[#4C3F31] rounded-[12px] duration-300 cursor-pointer text-white hover:scale-105 hover:shadow-2xl active:cursor-progress transition-all tracking-wide;
        }
        
        #previewImage{
            @apply w-full h-[280px] object-cover rounded-[15px] shadow-lg;
        }
        
        .preview-container {
            @apply bg-gradient-to-br from-[#f9f7f5] to-white;
        }
        
        /* Hero Section Enhancement */
        .hero-overlay {
            @apply bg-gradient-to-t from-black/70 via-black/40 to-transparent;
        }
        
        /* Smooth animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease-out;
        }
        
        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }
        
        .animate-bounce {
            animation: bounce 1s ease-in-out infinite;
        }
        
        /* Alert Modal Animations */
        #alertModal {
            animation: modalFadeIn 0.4s ease-out;
        }
        
        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        
        #alertModal > div {
            animation: modalSlideUp 0.5s ease-out;
        }
        
        @keyframes modalSlideUp {
            from {
                opacity: 0;
                transform: translateY(50px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
        
        /* Custom scrollbar for form */
        .overflow-y-auto::-webkit-scrollbar {
            @apply w-2;
        }
        
        .overflow-y-auto::-webkit-scrollbar-track {
            @apply bg-[#f9f7f5] rounded-full;
        }
        
        .overflow-y-auto::-webkit-scrollbar-thumb {
            @apply bg-[#CEC0B9] rounded-full hover:bg-[#746557];
        }
        
        /* Status badge styles */
        .status-badge {
            @apply inline-block px-3 py-1 rounded-full text-xs font-semibold;
        }
        
        .status-ongoing {
            @apply bg-green-100 text-green-800;
        }
        
        .status-upcoming {
            @apply bg-blue-100 text-blue-800;
        }
        
        .status-finished {
            @apply bg-gray-100 text-gray-800;
        }

    </style>

    
</head>

<body>
    <!--nav bar-->
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


    <!-- Success/Error Alert Modal -->
    <?php if (isset($_GET['success'])) { ?>
        <div id="alertModal" class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/60 backdrop-blur-sm animate-fadeInUp">
            <div class="bg-white rounded-[25px] shadow-2xl max-w-md w-full mx-4 overflow-hidden transform scale-100 transition-all duration-300">
                <!-- Success Header -->
                <div class="bg-gradient-to-r from-[#746557] to-[#4C3F31] p-6 text-center">
                    <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center mx-auto mb-4 animate-bounce">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white font-['Playfair_Display',serif]">Success!</h3>
                </div>
                
                <!-- Success Body -->
                <div class="p-8 text-center">
                    <p class="text-[#4C3F31] text-lg font-medium mb-6 leading-relaxed">
                        <?php echo htmlspecialchars($_GET['success']); ?>
                    </p>
                    <button onclick="closeAlertModal()" class="px-8 py-3 bg-gradient-to-r from-[#746557] to-[#4C3F31] text-white font-semibold rounded-[12px] hover:scale-105 hover:shadow-xl transition-all duration-300 w-full">
                        Continue
                    </button>
                </div>
            </div>
        </div>
    <?php } ?>
    
    <?php if (isset($_GET['error'])) { ?>
        <div id="alertModal" class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/60 backdrop-blur-sm animate-fadeInUp">
            <div class="bg-white rounded-[25px] shadow-2xl max-w-md w-full mx-4 overflow-hidden transform scale-100 transition-all duration-300">
                <!-- Error Header -->
                <div class="bg-gradient-to-r from-[#8B4513] to-[#6B3410] p-6 text-center">
                    <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center mx-auto mb-4 animate-bounce">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white font-['Playfair_Display',serif]">Oops!</h3>
                </div>
                
                <!-- Error Body -->
                <div class="p-8 text-center">
                    <p class="text-[#4C3F31] text-lg font-medium mb-6 leading-relaxed">
                        <?php echo htmlspecialchars($_GET['error']); ?>
                    </p>
                    <button onclick="closeAlertModal()" class="px-8 py-3 bg-gradient-to-r from-[#8B4513] to-[#6B3410] text-white font-semibold rounded-[12px] hover:scale-105 hover:shadow-xl transition-all duration-300 w-full">
                        Try Again
                    </button>
                </div>
            </div>
        </div>
    <?php } ?>

    <!-- content -->
    <div id ="blur" class="main-div flex w-full flex-col pb-10" >

        <!-- Hero Section -->
        <div class="relative w-full bg-gradient-to-br from-[#F3F3F3] via-[#e7e0dc] to-[#CEC0B9] px-5 py-8 md:px-10 md:py-12">
            <div class="relative w-full max-w-[1400px] mx-auto max-h-[500px] overflow-hidden rounded-[30px] shadow-2xl">
                <img src="../img/Bidding/banner.png" alt="Exclusive rare collectibles auction" class="w-full h-full object-cover">
                
                <!-- Gradient Overlay -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                
                <!-- Content -->
                <div class="absolute inset-0 flex flex-col justify-end p-8 md:p-12 lg:p-16 animate-fadeInUp">
                    <div class="max-w-[800px]">
                        <p class="text-[#CEC0B9] text-[16px] md:text-[20px] font-semibold tracking-[0.3rem] mb-3 uppercase">Hot Auctions</p>
                        <h1 class="text-white text-[36px] md:text-[56px] lg:text-[64px] font-bold leading-tight mb-4 font-['Playfair_Display',serif]">
                            Exclusive Rare Collectibles Auction
                        </h1>
                        <p class="text-[#e7e0dc] text-[18px] md:text-[24px] font-medium mb-6">
                            Join The Bidding War! Discover Unique Treasures
                        </p>

                        <?php if (isset($_SESSION['userid'])) {
                            $userid = $_SESSION['userid']; ?>
                            <button class="addbit-btn inline-flex items-center gap-2" onclick="addBidForm()">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                Add Your Bid
                            </button>
                            <div id="addItemForm" class="add-item-form"></div>
                        <?php } else { ?>
                            <a href="login_user.php" style="text-decoration: none;">
                                <button class="addbit-btn inline-flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                    </svg>
                                    Add Your Bid
                                </button>
                            </a>
                        <?php } ?>
                    </div>
                </div>
                
                <!-- Decorative Elements -->
                <div class="absolute top-8 right-8 w-20 h-20 border-4 border-[#CEC0B9] rounded-full opacity-30"></div>
                <div class="absolute bottom-8 left-8 w-16 h-16 border-4 border-[#CEC0B9] rounded-full opacity-20"></div>
            </div>
        </div>

        
       <!-- Ongoing Bidding Section -->
        <div class="flex flex-col px-5 md:px-12 pt-16 pb-8 bg-gradient-to-br from-[#F3F3F3] to-[#e7e0dc] ongoing">
            <div class="product bg-gradient-to-br from-[#CEC0B9] to-[#d4c5b8] rounded-[30px] shadow-xl"> 
                <div class="flex items-center justify-between px-[10vw] pt-8">
                    <div>
                        <h2 class="product-category mb-2">Ongoing Bidding</h2>
                        <p class="text-[#4C3F31] text-sm font-medium opacity-70">Live auctions happening now</p>
                    </div>
                    <span class="status-badge status-ongoing hidden md:inline-block">
                        <span class="inline-block w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                        Live
                    </span>
                </div>
                <button class="pre-btn"><img src="../img/Bidding/arrow.png" alt="Previous"></button>
                <button class="nxt-btn"><img src="../img/Bidding/arrow.png" alt="Next"></button>
                <div class="product-container">
                    <?php foreach ($ongoingBids as $auction) { ?>
                        <div class="product-card animate-fadeInUp" id="bidCard<?php echo $auction['auction_id']; ?>">
                            <div class="product-image rounded-t-[20px]">
                                <span class="countdown-tag">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                    </svg>
                                    <span id="ongoingCountdown<?php echo $auction['auction_id']; ?>"></span>
                                </span>
                                <img src="<?php echo htmlspecialchars($auction['coverimage']); ?>" class="product-thumb" alt="<?php echo htmlspecialchars($auction['itemname']); ?>">
                                <a href="bidProduct_view.php?itemid=<?php echo $auction['itemid']; ?>" class="card-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M8 5a1 1 0 100 2h5.586l-1.293 1.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L13.586 5H8zM12 15a1 1 0 100-2H6.414l1.293-1.293a1 1 0 10-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L6.414 15H12z" />
                                    </svg>
                                    Bid Now
                                </a>
                            </div>
                            <div class="product-info">
                                <h2 class="product-brand"><?php echo htmlspecialchars($auction['itemname']); ?></h2>
                                <p class="product-short-description"><?php echo htmlspecialchars($auction['description']); ?></p>
                                <div class="flex items-center justify-between mt-3">
                                    <span class="price">Rs.<?php echo htmlspecialchars($auction['price']); ?></span>
                                    <span class="text-xs text-[#897062] font-medium">Starting Bid</span>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>


        <!-- Upcoming Bidding Section -->
        <div class="flex flex-col px-5 md:px-12 pt-16 pb-8 bg-gradient-to-br from-[#e7e0dc] to-[#F3F3F3]">
            <div class="product bg-gradient-to-br from-[#d4c5b8] to-[#CEC0B9] rounded-[30px] shadow-xl"> 
                <div class="flex items-center justify-between px-[10vw] pt-8">
                    <div>
                        <h2 class="product-category mb-2">Upcoming Bidding</h2>
                        <p class="text-[#4C3F31] text-sm font-medium opacity-70">Get ready for these exciting auctions</p>
                    </div>
                    <span class="status-badge status-upcoming hidden md:inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                        </svg>
                        Upcoming
                    </span>
                </div>
                <button class="pre-btn"><img src="../img/Bidding/arrow.png" alt="Previous"></button>
                <button class="nxt-btn"><img src="../img/Bidding/arrow.png" alt="Next"></button>
                <div class="product-container">
                    <?php foreach ($upcomingBids as $auction) { ?>
                        <div class="product-card animate-fadeInUp" id="bidCard<?php echo $auction['auction_id']; ?>">
                            <div class="product-image rounded-t-[20px] relative">
                                <div class="absolute inset-0 bg-gradient-to-t from-blue-900/20 to-transparent pointer-events-none"></div>
                                <span class="countdown-tag">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                    </svg>
                                    <span id="upcomingCountdown<?php echo $auction['auction_id']; ?>"></span>
                                </span>
                                <img src="<?php echo htmlspecialchars($auction['coverimage']); ?>" class="product-thumb" alt="<?php echo htmlspecialchars($auction['itemname']); ?>">
                                <a href="bidProduct_view.php?itemid=<?php echo $auction['itemid']; ?>" class="card-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                    </svg>
                                    View Details
                                </a>
                            </div>
                            <div class="product-info">
                                <h2 class="product-brand"><?php echo htmlspecialchars($auction['itemname']); ?></h2>
                                <p class="product-short-description"><?php echo htmlspecialchars($auction['description']); ?></p>
                                <div class="flex items-center justify-between mt-3">
                                    <span class="price">Rs.<?php echo htmlspecialchars($auction['price']); ?></span>
                                    <span class="text-xs text-[#897062] font-medium">Starting Bid</span>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>


        <!-- Finished Bidding Section -->
        <div class="flex flex-col px-5 md:px-12 pt-16 pb-16 bg-gradient-to-br from-[#F3F3F3] to-[#e7e0dc] finished">
            <div class="product bg-gradient-to-br from-[#CEC0B9] to-[#d4c5b8] rounded-[30px] shadow-xl"> 
                <div class="flex items-center justify-between px-[10vw] pt-8">
                    <div>
                        <h2 class="product-category mb-2">Finished Bidding</h2>
                        <p class="text-[#4C3F31] text-sm font-medium opacity-70">View completed auction results</p>
                    </div>
                    <span class="status-badge status-finished hidden md:inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        Completed
                    </span>
                </div>
                <button class="pre-btn"><img src="../img/Bidding/arrow.png" alt="Previous"></button>
                <button class="nxt-btn"><img src="../img/Bidding/arrow.png" alt="Next"></button>
                <div class="product-container">
                    <?php foreach ($finishedBids as $auction) { ?>
                        <div class="product-card animate-fadeInUp" id="bidCard<?php echo $auction['auction_id']; ?>">
                            <div class="product-image rounded-t-[20px] relative">
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-900/30 to-transparent pointer-events-none"></div>
                                <span class="countdown-tag bg-gradient-to-r from-gray-600 to-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span id="finishedCountdown<?php echo $auction['auction_id']; ?>"></span>
                                </span>
                                <img src="<?php echo htmlspecialchars($auction['coverimage']); ?>" class="product-thumb opacity-90" alt="<?php echo htmlspecialchars($auction['itemname']); ?>">
                                <a href="bidProduct_view.php?itemid=<?php echo $auction['itemid']; ?>" class="card-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                                    </svg>
                                    View Results
                                </a>
                            </div>
                            <div class="product-info">
                                <h2 class="product-brand"><?php echo htmlspecialchars($auction['itemname']); ?></h2>
                                <p class="product-short-description"><?php echo htmlspecialchars($auction['description']); ?></p>
                                <div class="flex items-center justify-between mt-3">
                                    <span class="price">Rs.<?php echo htmlspecialchars($auction['price']); ?></span>
                                    <span class="text-xs text-[#897062] font-medium">Final Bid</span>
                                </div>
                            </div>  
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        
        
        <!-- Popup Form -->
        <div class="overflow-y-auto backdrop-blur-sm" id="bidpopupform">
            <!-- Close Button -->
            <button id="fcancel-btn" onclick=addBidForm() class="absolute top-4 right-4 w-12 h-12 flex items-center justify-center text-[2rem] text-[#4C3F31] hover:bg-[#f9f7f5] rounded-full hover:scale-110 transition-all duration-300 z-10">
                &times;
            </button>
            
            <div class="flex flex-col lg:flex-row gap-8 px-4 md:px-8 py-6">
                <!-- Form Section -->
                <div class="w-full lg:w-[60%]">
                    <div class="mb-6">
                        <h2 class="f-title text-[#4C3F31] flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-[#746557]" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Create Your Auction
                        </h2>
                        <p class="text-[#897062] mt-2">Fill in the details to list your item for bidding</p>
                    </div>
                    
                    <!-- Form for adding a bid -->
                    <form action="../control/biddingcon.php" method="POST" enctype="multipart/form-data" class="space-y-5">
                        <div class="bform-items">
                            <label for="itemName" class="bflable">Item Name *</label>
                            <input type="text" class="form-control" id="itemName" placeholder="e.g., Vintage Designer Watch" name="itemname" required>
                        </div>
                        
                        <div class="bform-items">
                            <label for="price" class="bflable">Starting Bid Price (Rs.) *</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#897062] font-semibold"></span>
                                <input type="number" class="form-control pl-14" id="price" placeholder="5000" name="price" required min="1" step="0.01">
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bform-items">
                                <label for="coverImage" class="bflable">Cover Image *</label>
                                <input type="file" class="form-control-file" id="coverImage" name="image" accept="image/*" required>
                                <p class="text-xs text-[#897062] mt-1">Max 2MB (JPG, PNG)</p>
                            </div>
                            <div class="bform-items">
                                <label for="otherImages" class="bflable">Additional Image</label>
                                <input type="file" class="form-control-file" id="otherImages" name="otherimage" accept="image/*">
                                <p class="text-xs text-[#897062] mt-1">Optional</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bform-items">
                                <label for="bidstarttime" class="bflable">Auction Start Time *</label>
                                <input type="datetime-local" id="bidstarttime" name="bidstarttime" required class="form-control-time">
                            </div>
                            <div class="bform-items">
                                <label for="bitendtime" class="bflable">Auction End Time *</label>
                                <input type="datetime-local" id="bitendtime" name="bitendtime" required class="form-control-time">
                            </div>
                        </div>
                        
                        <div class="bform-items">
                            <label for="description" class="bflable">Item Description *</label>
                            <textarea class="form-control" id="description" rows="4" placeholder="Describe your item in detail - condition, features, history..." name="description" required></textarea>
                        </div>
                        
                        <input type="hidden" name="userid" value="<?php echo $userid; ?>">
                        <input type="hidden" name="submitBid" value="submitBid">
                        
                        <div class="pt-4">
                            <button type="submit" class="plsBid-btn flex items-center justify-center gap-3" name="submitBid">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd" />
                                </svg>
                                Submit Auction Listing
                            </button>
                        </div>
                    </form>        
                </div>

                <!-- Preview Section -->
                <div class="w-full lg:w-[40%] lg:sticky lg:top-8 h-fit">
                    <div class="mb-4">
                        <h2 class="f-title text-[#4C3F31] flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-[#746557]" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                            </svg>
                            Live Preview
                        </h2>
                        <p class="text-[#897062] mt-2 text-sm">See how your auction will appear</p>
                    </div>
                    
                    <div class="preview-container rounded-[20px] p-6 border-2 border-[#e7e0dc] shadow-xl bg-white">
                        <div class="relative mb-4 rounded-[15px] overflow-hidden shadow-lg">
                            <img id="previewImage" src="https://via.placeholder.com/400x300/CEC0B9/4C3F31?text=Upload+Image" alt="Item preview" class="w-full h-[280px] object-cover">
                            <div class="absolute top-3 right-3 bg-gradient-to-r from-[#746557] to-[#4C3F31] text-white px-3 py-1 rounded-full text-xs font-semibold">
                                Preview
                            </div>
                        </div>
                        
                        <div class="space-y-3">
                            <h5 class="text-2xl font-bold text-[#4C3F31] font-['Playfair_Display',serif]" id="previewName">Item Name</h5>
                            
                            <p class="text-[#897062] text-sm leading-relaxed" id="previewDescription">Your item description will appear here. Add detailed information to attract more bidders.</p>
                            
                            <div class="flex items-center gap-2 text-[#897062] text-sm pt-2 border-t border-[#e7e0dc]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                </svg>
                                <span id="prevBidStartingTime">Starts: <span class="font-semibold">Not set</span></span>
                            </div>
                            
                            <div class="flex items-center justify-between pt-3 border-t border-[#e7e0dc]">
                                <div>
                                    <p class="text-xs text-[#897062] uppercase tracking-wide mb-1">Starting Bid</p>
                                    <h5 class="text-3xl font-extrabold text-[#746557]" id="previewPrice">Rs. 0.00</h5>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-[#897062]">Auction Status</p>
                                    <span class="inline-block mt-1 px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">
                                        Pending
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/bidScript.js"></script>
    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="../js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

    <script>
        // Close alert modal function
        function closeAlertModal() {
            const modal = document.getElementById('alertModal');
            if (modal) {
                modal.style.transition = 'opacity 0.3s, transform 0.3s';
                modal.style.opacity = '0';
                modal.style.transform = 'scale(0.95)';
                setTimeout(function() {
                    // Remove query parameters from URL
                    const url = new URL(window.location);
                    url.searchParams.delete('success');
                    url.searchParams.delete('error');
                    window.history.replaceState({}, document.title, url);
                    modal.remove();
                }, 300);
            }
        }
        
        // Close modal on backdrop click
        document.addEventListener('click', function(e) {
            const modal = document.getElementById('alertModal');
            if (modal && e.target === modal) {
                closeAlertModal();
            }
        });
        
        // Close modal on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeAlertModal();
            }
        });
        
        document.addEventListener('DOMContentLoaded', function() {
            const auctions = <?php echo json_encode($upcomingBids); ?>;
            auctions.forEach(function(auction) {
                updateCountdownUpcomming(auction.start_time, 'ongoingCountdown' + auction.auction_id);
            });
            
            // Enhanced form preview
            const itemNameInput = document.getElementById('itemName');
            const priceInput = document.getElementById('price');
            const descriptionInput = document.getElementById('description');
            const coverImageInput = document.getElementById('coverImage');
            const startTimeInput = document.getElementById('bidstarttime');
            
            if (itemNameInput) {
                itemNameInput.addEventListener('input', function() {
                    document.getElementById('previewName').textContent = this.value || 'Item Name';
                });
            }
            
            if (priceInput) {
                priceInput.addEventListener('input', function() {
                    const price = parseFloat(this.value) || 0;
                    document.getElementById('previewPrice').textContent = 'Rs. ' + price.toFixed(2);
                });
            }
            
            if (descriptionInput) {
                descriptionInput.addEventListener('input', function() {
                    document.getElementById('previewDescription').textContent = this.value || 'Your item description will appear here. Add detailed information to attract more bidders.';
                });
            }
            
            if (coverImageInput) {
                coverImageInput.addEventListener('change', function() {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            document.getElementById('previewImage').src = e.target.result;
                        };
                        reader.readAsDataURL(this.files[0]);
                    }
                });
            }
            
            if (startTimeInput) {
                startTimeInput.addEventListener('change', function() {
                    if (this.value) {
                        const startDate = new Date(this.value);
                        const options = { 
                            year: 'numeric', 
                            month: 'short', 
                            day: 'numeric', 
                            hour: '2-digit', 
                            minute: '2-digit' 
                        };
                        document.getElementById('prevBidStartingTime').innerHTML = 'Starts: <span class="font-semibold">' + startDate.toLocaleDateString('en-US', options) + '</span>';
                    }
                });
            }
        });
    </script>

</body>


</html>