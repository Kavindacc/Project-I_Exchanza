<?php
require_once '../model/DbConnector.php';
include_once '../model/wishlist.php';
include_once '../model/addtocart.php'; 
session_start();
date_default_timezone_set('Asia/Colombo');l

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
    <title>Product View</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.tailwindcss.com"></script>
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
            let highestBid = parseFloat(document.getElementById('highestBid').innerText);
            let newBid = highestBid * (1 + percentage / 100);

            // Send the bid to the server
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "place_bid.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.status == 'success') {
                        document.getElementById('highestBid').innerText = newBid.toFixed(2);
                        alert('You placed a bid of Rs.' + newBid.toFixed(2));
                    } else {
                        alert('Failed to place bid.');
                    }
                }
            };
            xhr.send("auction_id=<?php echo $auction['auction_id']; ?>&bid_price=" + newBid);
        }

        function placBidValue() {
            let bidInput = document.getElementById('bidInput');
            let highestBid = parseFloat(document.getElementById('highestBid').innerText);
            let newBid = parseFloat(bidInput.value);

            if (isNaN(newBid) || newBid < highestBid) {
                alert('Please enter a valid bid amount.');
                return;
            }

            // Send the bid to the server
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "place_bid.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.status == 'success') {
                        document.getElementById('highestBid').innerText = newBid.toFixed(2);
                        alert('You placed a bid of Rs.' + newBid.toFixed(2));
                    } else {
                        alert('Failed to place bid.');
                    }
                }
            };
            xhr.send("auction_id=<?php echo $auction['auction_id']; ?>&bid_price=" + newBid);
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
    <div class="container mx-auto w-[90%] lg:w-[70%] p-4 bg-white rounded-lg shadow-md my-8">
        <div class="flex flex-col lg:flex-row">
            <div class="lg:w-1/2 flex flex-col items-center">
                <img class="w-1/2 h-auto rounded-lg" src="<?php echo htmlspecialchars($product['coverimage']); ?>"
                    alt="Product Image">
                <div class="flex mt-4 space-x-2">
                    
                    <img class="w-16 h-16 rounded-lg border border-gray-300"
                        src="<?php echo htmlspecialchars($product['coverimage']); ?>" alt="Thumbnail">
                    <img class="w-16 h-16 rounded-lg border border-gray-300"
                        src="<?php echo htmlspecialchars($product['otherimage']); ?>" alt="Thumbnail">

                </div>
            </div>

            <div class="lg:w-1/2 lg:pl-8 mt-4 lg:mt-0">
                <h2 class="text-3xl font-bold text-gray-800"><?php echo htmlspecialchars($product['itemname']); ?></h2>
                <p class="mt-2 text-gray-600"><?php echo htmlspecialchars($product['description']); ?></p>
                <div class="mt-2 flex items-center space-x-2">
                    <span
                        class="text-xl font-semibold text-gray-800">Rs.<?php echo htmlspecialchars($product['price']); ?></span>
                    <?php if ($auction['start_price'] > 0) { ?>
                        <span
                            class="text-sm line-through text-gray-500">Rs.<?php echo htmlspecialchars($auction['start_price']); ?></span>
                    <?php } ?>
                </div>

                <div class="mt-4">
                    <p class="text-lg font-semibold text-gray-800">Highest Bid: Rs.<span
                            id="highestBid"><?php echo $highest_bid; ?></span></p>
                </div>

                <?php if (strtotime($auction['start_time']) <= time() && strtotime($auction['end_time']) >= time()) { ?>
                </br>
                    <div>
                        <form onsubmit="event.preventDefault(); placBidValue();">
                            <input type="number" id="bidInput" placeholder="Enter Bid Value" class="py-2 placeholder-[#897062] border border-[#746557] rounded-md">
                            <button type="submit" class="px-2 py-2 bg-[#CEC0B9] text-[#AE9D92] rounded-md hover:bg-[#746557]">Bid Now</button>
                        </form>
                    </div>
                    <div class="mt-4">
                        <div class="flex space-x-2">
                            <button class="px-4 py-2 bg-[#CEC0B9] text-[#AE9D92] rounded-md hover:bg-[#746557]"
                                onclick="placeBid(5)">+5%</button>
                            <button class="px-4 py-2 bg-[#CEC0B9] text-[#AE9D92] rounded-md hover:bg-[#746557]"
                                onclick="placeBid(10)">+10%</button>
                            <button class="px-4 py-2 bg-[#CEC0B9] text-[#AE9D92] rounded-md hover:bg-[#746557]"
                                onclick="placeBid(15)">+15%</button>
                        </div>
                    </div>
                <?php } ?>

                <div class="mt-4">
                    <?php if (strtotime($auction['start_time']) > time()) { ?>
                        <p class="text-lg font-semibold text-gray-800">Starts In: <span id="countdown"></span></p>
                        <script>
                            updateCountdown("<?php echo $auction['start_time']; ?>", "countdown");
                        </script>
                    <?php } else if (strtotime($auction['end_time']) >= time()) { ?>
                            <p class="text-lg font-semibold text-gray-800">Ends In: <span id="countdown"></span></p>
                            <script>
                                updateCountdown("<?php echo $auction['end_time']; ?>", "countdown");
                            </script>
                    <?php } else { ?>
                            <p class="text-lg font-semibold text-gray-800">Auction Finished</p>
                    <?php } ?>
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
</body>

</html>
<?php }else{
    header("Location:login_user.php");
    exit();
}?>