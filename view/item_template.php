<?php
include_once '../model/DbConnector.php';
include_once '../model/item.php';
include_once '../model/wishlist.php';
include_once '../model/User.php';
if (isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid']; ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <title>Item Template</title>

        <!-- Popper.js -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-RXf+QSDMFZ+7hz/qFFFmvnH7Cjmx1ka37U64yk8PEAgH6FZJvEFqPB3F7KbbtXgX" crossorigin="anonymous"></script>
    </head>

    <body>
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
                                <a class="nav-link" aria-current="page" href="../index.php">Home</a>
                            </li>
                            <li class="nav-item mx-2">
                                <a class="nav-link" href="thrift.php">Thrift</a>
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

                            <?php
                            /*$dsn=new DbConnector();
                            $con=$dsn->getConnection();

                            $obj = new wishlist();
                            $obj->setUserId($userid);
                            $count = $obj->itemCount($con); */ ?>
                            <a href="view/cart.php" class="nav-link  text-decoration-none mx-1"><i class="fa-solid fa-cart-plus position-relative"><span class="position-absolute translate-middle badge rounded-pill bg-danger sp"><?php if (isset($count)) {
                                                                                                                                                                                                                                        echo $count;
                                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                                        echo '0';
                                                                                                                                                                                                                                    } ?></span></i></a><!--addtocart-->
                            <?php
                            $dsn = new DbConnector();
                            $con = $dsn->getConnection();

                            $obj = new wishlist();
                            $obj->setUserId($userid);
                            $count = $obj->itemCount($con); ?>
                            <a href="wishlist.php" class="nav-link  text-decoration-none mx-1"><i class="fa-regular fa-heart position-relative"><span class="position-absolute translate-middle badge rounded-pill bg-dark sp"><?php if (isset($count)) {
                                                                                                                                                                                                                                    echo $count;
                                                                                                                                                                                                                                } ?></span></i></a><!--addto wishlist-->

                            <a href="userpage.php" class=" text-decoration-none"><i class="fa-regular fa-circle-user" style="font-size:1.5rem;"></i></a>
                            <?php echo "Hi," . ucwords($_SESSION['name']); ?>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <div class="container pt-1"><!--sub category eka ganna-->
            <?php if (isset($_GET['cat']) && isset($_GET['sub'])) {

                $category = trim(htmlspecialchars(stripcslashes($_GET['cat'])));
                $subcategory = trim(htmlspecialchars(stripcslashes($_GET['sub'])));
            } ?>

            <div class="text-center mt-3">
                <h1>Shop Thrifted <?php if (isset($category)) {
                                        echo ucfirst($category);
                                    } ?> 's &nbsp; <?php if (isset($subcategory)) {
                                                        echo ucfirst($subcategory);
                                                    } ?></h1>
            </div>

            <div class="d-flex justify-left gap-2">

                <div class="dropdown">
                    <button class="btn dropdown-toggle" type="button" id="sortDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Sort
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="sortDropdown">
                        <li><a class="dropdown-item" href="?price=LH">Price: Low to High</a></li>
                        <li><a class="dropdown-item" href="?price=HL">Price: High to Low</a></li>
                        <li><a class="dropdown-item" href="?price=NA">Newest Arrivals</a></li>
                    </ul>
                </div>

                <div class="dropdown">
                    <button class="btn dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Filter
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                        <li class="dropdown-submenu dropend">
                            <a class="dropdown-item dropdown-toggle" href="#" id="categoryDropdown" data-bs-toggle="dropdown" aria-expanded="false">Size</a>
                            <ul class="dropdown-menu" aria-labelledby="categoryDropdown">


                                <li><a class="dropdown-item" href="?selected_size=s">S</a></li>
                                <li><a class="dropdown-item" href="?selected_size=m">M</a></li>
                                <li><a class="dropdown-item" href="?selected_size=l">L</a></li>
                                <li><a class="dropdown-item" href="?selected_size=xl">XL</a></li>
                                <li><a class="dropdown-item" href="?selected_size=xxl">XXL</a></li>
                                <li><a class="dropdown-item" href="?selected_size=o">Other</a></li>


                            </ul>
                        </li>
                        <li><a class="dropdown-item" href="#">Colour</a></li>
                    </ul>
                </div>
            </div>

            <div class="collapse mb-4" id="filterOptions">
                <div class="card card-body">
                    <!-- Filter options methna danna -->
                </div>
            </div>
        </div>
        <div class="container d-flex justify-content-start mt-2"><!--close button-->
            <?php if (isset($_SESSION['msg'])) { ?>
                <div class="alert alert-success  alert-dismissible fade show col-12" role="alert">
                    <strong><?php echo $_SESSION['msg'];
                            unset($_SESSION['msg']); ?></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>


            <?php } ?>
            <?php if (isset($_SESSION['wmsg'])) { ?>
                <div class="alert alert-warning alert-dismissible fade show col-12" role="alert">
                    <strong><?php echo $_SESSION['wmsg'];
                            unset($_SESSION['wmsg']); ?></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>


            <?php } ?>
            <?php if (isset($_SESSION['amsg'])) { ?>
                <div class="alert alert-success  alert-dismissible fade show col-12" role="alert">
                    <strong><?php echo $_SESSION['amsg'];
                            unset($_SESSION['amsg']); ?></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>


            <?php } ?>
            <?php if (isset($_GET['s'])) {
                if ($_GET['s'] == '1') { ?>
                    <div class="alert alert-success  alert-dismissible fade show col-12" role="alert">
                        <strong><?php echo "Review submitted successfully";
                                unset($_SESSION['amsg']); ?></strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
            <?php   }
            } ?>
        </div>
        <div class="container d-flex justify-content-start flex-wrap mt-5 gap-4"><!--get iteam-->
            <?php
            $dsn = new DbConnector();
            $con = $dsn->getConnection();

            $user = new Thrift($userid);
            $user->setCategory($category);
            $user->setSubCategory($subcategory);

            if (isset($_GET['selected_size'])) {
                $size = $_GET['selected_size'];
                $rows = $user->getThriftItemsBySize($con, $size);
            } elseif (isset($_GET['price'])) {
                $price = $_GET['price'];
                $rows = $user->getThriftItemsBySort($con, $price);
            } else {
                $rows = $user->getThriftItemsLogin($con);
            }

            if (!empty($rows)) {
                foreach ($rows as $row) { ?>
                    <div class="card mb-3 pt-2" style="width: 17rem;">
                    <a href="item_template.php?productId=<?php echo $row['product_id']; ?>"> 
                        <img src="../upload/<?php echo $row['coverimage'] ?>" class="card-img-top" alt="..." style="height:10rem;">
                    </a>
                        <div class="card-body">
                            <h3 class="card-title"><?php echo $row['itemname']; ?></h3>
                            <?php if (isset($row['size'])) { ?>
                                <h5 class="card-text"><strong>Size: </strong><?php echo $row['size']; ?></h5>
                            <?php } ?>

                            <h5 class="card-text"><strong>Price:</strong><?php echo 'Rs.' . $row['price']; ?></h5>
                            <?php //rating
                            $obj = new GeneralCustomer();
                            $obj->setItemId($row['itemid']);
                            $rating = $obj->getRating($con);
                            if (!empty($rating)) { ?>
                                <div class="review mt-4">
                                    <?php foreach ($rating as $rate) {
                                        $user_id = $rate['user_id'];
                                        $obj->setUserid($user_id);
                                        $name = $obj->getusername($con);

                                    ?>


                                        <div class="rating-stars">
                                            <h6><?php echo ucwords($name); ?></h6>
                                            <h6><strong>Rating:</strong>
                                                <?php
                                                $ratingValue = $rate['rating'];
                                                for ($i = 1; $i <= 5; $i++) {
                                                    if ($i <= $ratingValue) {
                                                        echo '<i class="fas fa-star filled"></i>';
                                                    } else {
                                                        echo '<i class="fas fa-star"></i>';
                                                    }
                                                }
                                                ?>
                                            </h6>
                                            <h6><strong>Review:</strong><?php echo $rate['review_text'] ?></h6>

                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } ?>

                            <!-- Wishlist Form -->
                            <form action="../control/wishlistcon.php" method="post">
                                <input type="hidden" name="productid" value="<?php echo $row['itemid']; ?>">
                                <input type="hidden" name="userid" value="<?php echo $userid; ?>">
                                <input type="hidden" name="cat" value="<?php echo  $category; ?>">
                                <input type="hidden" name="sub" value="<?php echo $subcategory; ?>">
                                <button type="submit" class="btn btn-primary mt-2  equal-width" name="wishlist" style="--bs-btn-color:black;--bs-btn-bg:none;--bs-btn-border-color:black; --bs-btn-hover-bg:#4c3f31;">
                                    <i class="fa-regular fa-heart"></i>&nbsp;Add to Wishlist
                                </button>
                            </form>

                            <!-- Write Review Button -->
                            <button type="button" class="btn btn-secondary mt-2 equal-width" data-bs-toggle="modal" data-bs-target="#reviewModal<?php echo $row['itemid']; ?>" style="--bs-btn-color:black;--bs-btn-bg:none;--bs-btn-border-color:black; --bs-btn-hover-bg:#4c3f31;">
                                Write a Review
                            </button>

                            <!-- Review Modal -->
                            <div class="modal fade" id="reviewModal<?php echo $row['itemid']; ?>" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="reviewModalLabel">Write a Review for <?php echo $row['itemname']; ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="../control/reviewcon.php" method="post">
                                                <input type="hidden" name="productid" value="<?php echo $row['itemid']; ?>">
                                                <input type="hidden" name="userid" value="<?php echo $userid; ?>">
                                                <input type="hidden" name="cat" value="<?php echo  $category; ?>">
                                                <input type="hidden" name="sub" value="<?php echo $subcategory; ?>">
                                                <div class="mb-3">
                                                    <label for="reviewText" class="form-label">Your Review</label>
                                                    <textarea class="form-control" id="reviewText" name="review_text" rows="3" required></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="rating" class="form-label">Rating</label>
                                                    <select class="form-control" id="rating" name="rating" required>
                                                        <option value="1">1 - Poor</option>
                                                        <option value="2">2 - Fair</option>
                                                        <option value="3">3 - Good</option>
                                                        <option value="4">4 - Very Good</option>
                                                        <option value="5">5 - Excellent</option>
                                                    </select>
                                                </div>
                                                <button type="submit" class="btn btn-primary" style="--bs-btn-color:black;--bs-btn-bg:none;--bs-btn-border-color:black; --bs-btn-hover-bg:#4c3f31;">Submit Review</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        
                <?php }
            } else { ?>
                <h2>No Item</h2>
            <?php } ?>


        </div>
        //product detail hidden div 
        <?php if (isset($_GET['id'])) {
                    $pid = $_GET['id'];
                } ?>
        <div id="itemDetails" style="display:none">
        <div class="container mt-4">
        <div class="row">
            <div class="col-md-6">
                <?php
                $dsn = new DbConnector();
                $con = $dsn->getConnection();
    
                $user = new Thrift($userid);
                $rows = $user->loaditemDetails($con,$pid);


                ?>

                <div class="product-image-container">

                    <img id="mainImage" src="../upload/<?php echo $row['image']; ?>" class="img-fluid product-image" alt="Product Image" style="width: 400px; height: 400px;">
                </div>
                <div class="mt-3 d-flex item">
                    <img src="../upload/<?php echo $row['otherimage']; ?>" class="img-thumbnail thumbnail" alt="Thumbnail 1" onclick="changeImage(this)">
                    <img src="../upload/<?php echo $row['other_image_2']; ?>" class="img-thumbnail thumbnail" alt="Thumbnail 2"
                        onclick="changeImage(this)">
                    <img src="../upload/<?php echo $row['other_image_3']; ?>" class="img-thumbnail thumbnail" alt="Thumbnail 3"
                        onclick="changeImage(this)">
                         https://via.placeholder.com/120
                </div>
            </div>
            <div class="col-md-6">
                <h1><?php echo $row['product_name']; ?>
                <svg class="heart-icon" id="heartIcon" viewBox="0 0 24 24">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 
                            0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z">
                        </path>
                    </svg>
            </h1>
                <h2>LKR <?php echo $row['price']; ?></h2>
                
                <p><span class="fw-bold">Code:</span> <?php echo $row['product_id']; ?></p>
                <div class="d-flex flex-column">
                    <p class="fw-bold"><?php echo $row['colour']; ?></p>
                    <div class="d-flex gap-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                            <label class="form-check-label" for="flexRadioDefault1">
                                Image 01
                            </label>
                        </div>
                        <!-- <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                            <label class="form-check-label" for="flexRadioDefault2">
                                Image 02
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                            <label class="form-check-label" for="flexRadioDefault2">
                                Image 03
                            </label> -->
                        </div>
                    </div>

                </div>
                <div class="mt-4">
                    <?php
                    if (isset($row['size'])) { ?>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-secondary"><?php echo $row['size']; ?></button>
                        </div>
                    <?php  }
                    ?>

                </div>
            </div>
        </div>
    </div>

    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 5">
        <div id="toast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" style="background-color: #897062;">
            <div class="toast-body" id="toastBody" style="color: white;">
            </div>
        </div>
    </div>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://unpkg.com/scrollreveal"></script>
        <script src="../js/main.js"></script>
        <script src="../js/itemtemp.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>

    </html>
<?php } else { ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- Popper.js -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-RXf+QSDMFZ+7hz/qFFFmvnH7Cjmx1ka37U64yk8PEAgH6FZJvEFqPB3F7KbbtXgX" crossorigin="anonymous"></script>

        <title>Item Template</title>
    </head>

    <body>
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
                                <a class="nav-link" aria-current="page" href="../index.php">Home</a>
                            </li>
                            <li class="nav-item mx-2">
                                <a class="nav-link" href="thrift.php">Thrift</a>
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

                            <a href="cart.php" class="nav-link  text-decoration-none mx-1"><i class="fa-solid fa-cart-plus position-relative"><span class="position-absolute translate-middle badge rounded-pill bg-danger sp">0</span></i></a><!--addtocart-->
                            <a href="wishlist.php" class="nav-link  text-decoration-none mx-1"><i class="fa-regular fa-heart position-relative"><span class="position-absolute translate-middle badge rounded-pill bg-danger sp">0</span></i></a>
                            <a href="login_user.php" class=" text-decoration-none"><button class="lo-button btn-sm ms-2 px-3" style="color:#ffff;">login</button></a>

                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <div class="container pt-1"><!--sub category eka ganna-->
            <?php if (isset($_GET['cat']) && isset($_GET['sub'])) {

                $category = $_GET['cat'];
                $subcategory = $_GET['sub'];
            } ?>

            <div class="text-center mt-3">
                <h1>Shop Thrifted <?php if (isset($category)) {
                                        echo ucfirst($category);
                                    } ?> 's &nbsp; <?php if (isset($subcategory)) {
                                                        echo ucfirst($subcategory);
                                                    } ?></h1>
            </div>

            <div class="d-flex justify-left gap-2">

                <div class="dropdown">
                    <button class="btn dropdown-toggle" type="button" id="sortDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Sort
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="sortDropdown">
                        <li><a class="dropdown-item" href="?price=LH">Price: Low to High</a></li>
                        <li><a class="dropdown-item" href="?price=HL">Price: High to Low</a></li>
                        <li><a class="dropdown-item" href="?price=NA">Newest Arrivals</a></li>
                    </ul>
                </div>
                <div class="dropdown">
                    <button class="btn dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Filter
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                        <li class="dropdown-submenu dropend">
                            <a class="dropdown-item dropdown-toggle" href="#" id="categoryDropdown" data-bs-toggle="dropdown" aria-expanded="false">Size</a>
                            <ul class="dropdown-menu" aria-labelledby="categoryDropdown">


                                <li><a class="dropdown-item" href="#">S</a></li>
                                <li><a class="dropdown-item" href="#">M</a></li>
                                <li><a class="dropdown-item" href="#">L</a></li>
                                <li><a class="dropdown-item" href="#">XL</a></li>
                                <li><a class="dropdown-item" href="#">XXL</a></li>
                                <li><a class="dropdown-item" href="#">Other</a></li>


                            </ul>
                        </li>
                        <li><a class="dropdown-item" href="#">Colour</a></li>
                    </ul>
                </div>
            </div>

            <div class="collapse mb-4" id="filterOptions">
                <div class="card card-body">
                    <!-- Filter options methna danna -->
                </div>
            </div>
        </div>
        <div class="container d-flex justify-content-start mt-2"><!--close button-->
            <?php if (isset($_SESSION['msg'])) { ?>
                <div class="alert alert-success  alert-dismissible fade show col-12" role="alert">
                    <strong><?php echo $_SESSION['msg'];
                            unset($_SESSION['msg']); ?></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>


            <?php } ?>
            <?php if (isset($_SESSION['wmsg'])) { ?>
                <div class="alert alert-warning alert-dismissible fade show col-12" role="alert">
                    <strong><?php echo $_SESSION['wmsg'];
                            unset($_SESSION['wmsg']); ?></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>


            <?php } ?>
            <?php if (isset($_SESSION['amsg'])) { ?>
                <div class="alert alert-success  alert-dismissible fade show col-12" role="alert">
                    <strong><?php echo $_SESSION['amsg'];
                            unset($_SESSION['amsg']); ?></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>


            <?php } ?>
        </div>
        <div class="container d-flex justify-content-start flex-wrap mt-5 gap-4"><!--get iteam-->

            <?php

            $dsn = new DbConnector();
            $con = $dsn->getConnection();

            $user = new Thrift();
            $user->setCategory($category);
            $user->setSubCategory($subcategory);

            // $rows = $user->getThriftItemsLogin($con);
            if (isset($_GET['selected_size'])) {
                $size = $_GET['selected_size'];
                $rows = $user->getThriftItemsBySize($con, $size);
            } elseif (isset($_GET['price'])) {
                $price = $_GET['price'];
                $rows = $user->getThriftItemsBySort($con, $price);
            } else {
                $rows = $user->getThriftItemsLogin($con);
            }
            if (!empty($rows)) {
                foreach ($rows as $row) { ?>
                    <div class="card mb-3 pt-2" style="width: 17rem;">
                    <a href="item_template.php?productId=<?php echo $row['thrift_id']; ?>"> 
                        <img src="../upload/<?php echo $row['coverimage'] ?>" class="card-img-top" alt="..." style="height:10rem;">
                    </a>
                        <div class="card-body">
                            <h3 class="card-title"><?php echo $row['itemname']; ?></h3>
                            <?php if (isset($row['size'])) { ?>
                                <h5 class="card-text"><strong>Size: </strong><?php echo $row['size']; ?></h5>
                            <?php } ?>

                            <h5 class="card-text"><strong>Price:</strong><?php echo 'Rs.' . $row['price']; ?></h5>
                            <?php //rating
                            $obj = new GeneralCustomer();
                            $obj->setItemId($row['itemid']);
                            $rating = $obj->getRating($con);
                            if (!empty($rating)) { ?>
                                <div class="review mt-4">
                                    <?php foreach ($rating as $rate) {
                                        $user_id = $rate['user_id'];
                                        $obj->setUserid($user_id);
                                        $name = $obj->getusername($con);

                                    ?>


                                        <div class="rating-stars">
                                            <h6><?php echo ucwords($name); ?></h6>
                                            <h6><strong>Rating:</strong>
                                                <?php
                                                $ratingValue = $rate['rating'];
                                                for ($i = 1; $i <= 5; $i++) {
                                                    if ($i <= $ratingValue) {
                                                        echo '<i class="fas fa-star filled"></i>';
                                                    } else {
                                                        echo '<i class="fas fa-star"></i>';
                                                    }
                                                }
                                                ?>
                                            </h6>
                                            <h6><strong>Review:</strong><?php echo $rate['review_text'] ?></h6>

                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } ?>

                            <!-- Wishlist Form -->
                            <a href="login_user.php" style="text-decoration: none;">
                                <button type="button" class="btn btn-primary mt-2  equal-width" style="--bs-btn-color:black;--bs-btn-bg:none;--bs-btn-border-color:black; --bs-btn-hover-bg:#4c3f31;"><i class="fa-regular fa-heart"></i>&nbsp;Add to Wishlist</button>
                            </a>

                            <!-- Write Review Button -->
                            <a href="login_user.php" style="text-decoration: none;">
                                <button type="button" class="btn btn-primary mt-2  equal-width" style="--bs-btn-color:black;--bs-btn-bg:none;--bs-btn-border-color:black; --bs-btn-hover-bg:#4c3f31;"><i class="fa-regular fa-heart"></i>&nbsp;Write a Review</button>
                            </a>

                        </div>
                    </div>

        


                <?php } 
                /* if (!empty($rows)) {
                foreach ($rows as $row) { ?>
                    <div class="card m- pt-2" style="width: 17rem;">
                        <img src="../upload/<?php echo $row['coverimage'] ?>" class="card-img-top" alt="..." style="height:10rem;">
                        <div class="card-body">
                            <h3 class="card-title"><?php echo $row['itemname']; ?></h3>
                            <h5 class="card-text"><?php if (isset($row['size'])) {
                                                        echo 'Size : ' . $row['size'];
                                                    } ?></h5>
                            <h5 class="card-text">Rs.<?php echo 'Price : Rs.' . $row['price']; ?></h5>

                            <?php
                            $currentPage = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; //get current page 
                            $redirect = $currentPage; ?>
                            <a href="login_user.php?redirect=<?php echo $redirect; ?>" style="text-decoration: none;">
                                <button type="button" class="btn btn-primary mt-2  equal-width" style="--bs-btn-color:black;--bs-btn-bg:none;--bs-btn-border-color:black; --bs-btn-hover-bg:#4c3f31;"><i class="fa-regular fa-heart"></i>&nbsp;Add to Wishlist</button>
                            </a>
                        </div>
                    </div>
                <?php }*/



                
            } else { ?>
                <h2>No Iteasm</h2>
            <?php } ?>


        </div>
        <?php if (isset($_GET['productId'])) {
                    $pid = $_GET['productId'];
                 ?>

        <div id="itemDetails">
        <div class="container mt-4">
        <div class="row">
            <div class="col-md-6">
                <?php
                
            $dsn = new DbConnector();
            $con = $dsn->getConnection();

            $user = new Thrift();
            $rows = $user->loaditemDetails($con,$pid);


                ?>

                <div class="product-image-container">

                    <img id="mainImage" src="../upload/<?php echo $rows['coverimage']; ?>" class="img-fluid product-image" alt="Product Image" style="width: 400px; height: 400px;">
                </div>
                <div class="mt-3 d-flex item">
                    <img src="../upload/<?php echo $rows['otherimage']; ?>" class="img-thumbnail thumbnail" alt="Thumbnail 1" onclick="changeImage(this)">

                         https://via.placeholder.com/120
                </div>
            </div>
            <div class="col-md-6">
                <h1><?php echo $rows['itemname']; ?>
                <svg class="heart-icon" id="heartIcon" viewBox="0 0 24 24">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 
                            0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z">
                        </path>
                    </svg>
            </h1>
                <h2>LKR <?php echo $rows['price']; ?></h2>
                
                <p><span class="fw-bold">Code:</span> <?php echo $rows['product_id']; ?></p>
                <div class="d-flex flex-column">
                    <p class="fw-bold"><?php echo $rows['colour']; ?></p>
                    <div class="d-flex gap-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                            <label class="form-check-label" for="flexRadioDefault1">
                                Image 01
                            </label>
                        </div>
                        <!-- <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                            <label class="form-check-label" for="flexRadioDefault2">
                                Image 02
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                            <label class="form-check-label" for="flexRadioDefault2">
                                Image 03
                            </label> -->
                        </div>
                    </div>

                </div>
                <div class="mt-4">
                    <?php
                    if (isset($rows['size'])) { ?>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-secondary"><?php echo $rows['size']; ?></button>
                        </div>
                    <?php  }
                    ?>

                </div>
            </div>
        </div>
    </div>

    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 5">
        <div id="toast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" style="background-color: #897062;">
            <div class="toast-body" id="toastBody" style="color: white;">
            </div>
        </div>
    </div>
<?php } ?>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://unpkg.com/scrollreveal"></script>
        <script src="../js/main.js"></script>
        <script src="../js/itemtemp.js"></script>
        <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> -->
    </body>

    </html>


<?php } ?>