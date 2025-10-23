<?php 
session_start();
include_once '../model/DbConnector.php';
include_once '../model/wishlist.php';
include_once '../model/addtocart.php';

$dbConnector = new DbConnector();
$userid = $_SESSION['userid'] ?? null;
$name = $_SESSION['name'] ?? 'Guest';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Exchanza</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/style.css?v=<?php echo time(); ?>">
    <style>
        :root {
            --primary-color: #897062;
            --secondary-color: #AE9D92;
            --accent-color: #e74c3c;
            --light-bg: #f8f9fa;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .hero-section {
            background: linear-gradient(135deg, var(--secondary-color) 0%, var(--primary-color) 100%);
            color: white;
            padding: 100px 0 60px;
            margin-top: 0;
        }

        .hero-section h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .hero-section p {
            font-size: 1.2rem;
            opacity: 0.9;
        }

        .about-content {
            padding: 80px 0;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 20px;
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 60px;
            height: 4px;
            background: var(--accent-color);
        }

        .mission-card {
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            transition: transform 0.3s;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .mission-card:hover {
            transform: translateY(-5px);
        }

        .mission-card i {
            font-size: 3rem;
            color: var(--secondary-color);
            margin-bottom: 20px;
        }

        .mission-card h3 {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 15px;
        }

        .values-section {
            background: var(--light-bg);
            padding: 80px 0;
        }

        .value-item {
            text-align: center;
            padding: 30px;
            background: white;
            border-radius: 10px;
            margin-bottom: 30px;
            height: 100%;
            box-shadow: 0 3px 15px rgba(0,0,0,0.08);
        }

        .value-item i {
            font-size: 2.5rem;
            color: var(--accent-color);
            margin-bottom: 15px;
        }

        .value-item h4 {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 10px;
        }

        .stats-section {
            background: var(--primary-color);
            color: white;
            padding: 60px 0;
        }

        .stat-item {
            text-align: center;
            padding: 20px;
        }

        .stat-item h2 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .stat-item p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        @media (max-width: 768px) {
            .hero-section h1 {
                font-size: 2rem;
            }
            
            .section-title {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top nav">
        <div class="container-fluid logo">
            <a class="navbar-brand" href="../index.php"><img src="../img/Exchanza.png" width="100px"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header border-bottom">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Exchanze</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
                        <li class="nav-item mx-2">
                            <a class="nav-link" href="../index.php">Home</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link" href="thrift.php">Thrift</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link" href="bidding.php">Bidding</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link active" aria-current="page" href="aboutus.php">About Us</a>
                        </li>
                    </ul>

                    <div class="d-flex flex-column float-start flex-lg-row justify-content-center align-items-center mt-3 mt-lg-0 gap-3">
                        <?php if(isset($_SESSION['userid'])): 
                            $dsn = new DbConnector();
                            $con = $dsn->getConnection();

                            $obj = new Cart();
                            $obj->setUserId($userid);
                            $count = $obj->cartItemCount($con);
                        ?>
                        <a href="addtocart.php" class="nav-link text-decoration-none mx-1">
                            <i class="fa-solid fa-cart-plus position-relative">
                                <span class="position-absolute translate-middle badge rounded-pill bg-danger sp">
                                    <?php if (isset($count)) { echo $count; } ?>
                                </span>
                            </i>
                        </a>
                        
                        <?php 
                            $obj = new wishlist();
                            $obj->setUserId($userid);
                            $count = $obj->itemCount($con);
                        ?>
                        <a href="wishlist.php" class="nav-link text-decoration-none mx-1">
                            <i class="fa-regular fa-heart position-relative">
                                <span class="position-absolute translate-middle badge rounded-pill bg-dark sp">
                                    <?php if (isset($count)) { echo $count; } ?>
                                </span>
                            </i>
                        </a>

                        <a href="userpage.php" class="text-decoration-none">
                            <i class="fa-regular fa-circle-user" style="font-size:1.5rem;"></i>
                        </a>
                        <?php echo "Hi, " . ucwords($name); ?>
                        <?php else: ?>
                        <a href="addtocart.php" class="nav-link text-decoration-none mx-1">
                            <i class="fa-solid fa-cart-plus position-relative">
                                <span class="position-absolute translate-middle badge rounded-pill bg-danger sp">0</span>
                            </i>
                        </a>
                        <a href="wishlist.php" class="nav-link text-decoration-none mx-1">
                            <i class="fa-regular fa-heart position-relative">
                                <span class="position-absolute translate-middle badge rounded-pill bg-danger sp">0</span>
                            </i>
                        </a>
                        <a href="userpage.php" class="text-decoration-none">
                            <button class="lo-button btn-sm ms-2 px-3" style="color:#ffff;">login</button>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container text-center">
            <h1>About Exchanza</h1>
            <p class="lead">Revolutionizing the way you buy, sell, and exchange pre-loved items</p>
        </div>
    </section>

    <!-- Main About Content -->
    <section class="about-content">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-6 mb-4">
                    <h2 class="section-title">Our Story</h2>
                    <p class="mt-4">Exchanza was born from a simple idea: to create a sustainable marketplace where quality pre-loved items find new homes. We recognized that countless valuable items sit unused in closets and storage spaces, while others search for affordable, quality goods.</p>
                    <p>Founded in 2024, we've built a platform that combines the excitement of thrift shopping with the thrill of bidding, all while promoting sustainability and circular economy practices.</p>
                </div>
                <div class="col-lg-6 mb-4">
                    <img src="../img/pexels-olly-3755706.jpg" alt="About Exchanza" class="img-fluid rounded shadow" style="width: 100%; height: 400px; object-fit: cover;">
                </div>
            </div>

            <!-- Mission & Vision -->
            <div class="row mt-5">
                <div class="col-lg-6 mb-4">
                    <div class="mission-card">
                        <i class="fas fa-bullseye"></i>
                        <h3>Our Mission</h3>
                        <p>To provide a trusted, user-friendly platform that makes buying and selling pre-loved items simple, enjoyable, and beneficial for both our community and the environment. We strive to reduce waste while offering exceptional value to our users.</p>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="mission-card">
                        <i class="fas fa-eye"></i>
                        <h3>Our Vision</h3>
                        <p>To become the leading marketplace for sustainable shopping in Sri Lanka and beyond, where every item gets a second chance and every transaction contributes to a more sustainable future.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="values-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Our Core Values</h2>
                <p class="mt-4 text-muted">The principles that guide everything we do</p>
            </div>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="value-item">
                        <i class="fas fa-recycle"></i>
                        <h4>Sustainability</h4>
                        <p>We're committed to reducing waste and promoting a circular economy through reuse and recycling.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="value-item">
                        <i class="fas fa-shield-alt"></i>
                        <h4>Trust & Safety</h4>
                        <p>Building a secure marketplace where buyers and sellers can transact with confidence and peace of mind.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="value-item">
                        <i class="fas fa-users"></i>
                        <h4>Community</h4>
                        <p>Fostering a vibrant community of conscious consumers who value quality, affordability, and sustainability.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="value-item">
                        <i class="fas fa-lightbulb"></i>
                        <h4>Innovation</h4>
                        <p>Continuously improving our platform with new features that enhance the user experience.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="value-item">
                        <i class="fas fa-hand-holding-heart"></i>
                        <h4>Transparency</h4>
                        <p>Operating with honesty and openness in all our interactions and business practices.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="value-item">
                        <i class="fas fa-star"></i>
                        <h4>Quality</h4>
                        <p>Ensuring every item listed meets our quality standards for a premium thrift experience.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="stat-item">
                        <h2>10K+</h2>
                        <p>Active Users</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="stat-item">
                        <h2>50K+</h2>
                        <p>Items Sold</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="stat-item">
                        <h2>98%</h2>
                        <p>Satisfaction Rate</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="stat-item">
                        <h2>24/7</h2>
                        <p>Support Available</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- What We Offer -->
    <section class="about-content">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">What We Offer</h2>
            </div>
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="mission-card">
                        <i class="fas fa-shopping-bag"></i>
                        <h3>Thrift Store</h3>
                        <p>Browse through a curated collection of quality pre-loved items at fixed prices. From fashion to electronics, find amazing deals on items that have been carefully vetted for quality.</p>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="mission-card">
                        <i class="fas fa-gavel"></i>
                        <h3>Bidding Platform</h3>
                        <p>Experience the excitement of auctions! Bid on unique items and potentially score incredible deals. Our bidding system is transparent, secure, and designed for fair competition.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <div class="container-fluid footer">
        <div class="container p-3">
            <div class="row">
                <div class="col text-center text-md-start">
                    <img src="../img/Exchanza.png" width="200px">
                </div>
            </div>
            <div class="row mt-4" style="border-bottom:1px solid black;">
                <div class="col-sm-6 col-md-4 text-center text-md-start">
                    <p><i class="fa-solid fa-phone"></i>&nbsp;&nbsp;0717749219</p>
                    <p><i class="fa-solid fa-envelope"></i>&nbsp;&nbsp;Exchanze@gmail.com</p>
                    <p><i class="fa-solid fa-location-dot"></i>&nbsp;&nbsp;243/c, Colombo 03</p>
                </div>
                <div class="col-sm-6 col-md-4 text-center text-md-start lin">
                    <h5>Information</h5>
                    <p><a href="#1">Privacy & Policy</a></p>
                    <p><a href="aboutus.php">About Us</a></p>
                    <p><a href="#1">Terms & Condition</a></p>
                    <p><a href="enquiry.php">Enquire Now</a></p>
                </div>
                <div class="col-md-4 text-center text-md-start lin">
                    <h5>Connect with Us</h5>
                    <p>
                        <a href="#" target="_blank"><i class="fa-brands fa-facebook" style="font-size:50px;"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="#" target="_blank"><i class="fa-brands fa-instagram" style="font-size:50px;"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="#" target="_blank"><i class="fa-brands fa-youtube" style="font-size:50px;"></i></a>
                    </p>
                </div>
            </div>
            <div class="row mt-2 text-center text-md-none">
                <div class="d-flex justify-content-between flex-column flex-md-row">
                    <div>
                        <i class="fa-brands fa-cc-visa" style="font-size:50px;"></i>&nbsp;&nbsp;&nbsp;&nbsp;
                        <i class="fa-brands fa-cc-mastercard" style="font-size:50px;"></i>&nbsp;&nbsp;&nbsp;&nbsp;
                        <i class="fa-brands fa-cc-amex" style="font-size:50px;"></i>
                    </div>
                    <div>&copy; Exchanze All Rights are reserved</div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>