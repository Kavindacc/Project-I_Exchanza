<?php
include_once '../model/DbConnector.php';
include_once '../model/item.php';
include_once '../model/wishlist.php';
include_once '../model/User.php';
include_once '../model/addtocart.php';
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
                            $dsn = new DbConnector();
                            $con = $dsn->getConnection();
                            $obj = new Cart();
                            $obj->setUserId($userid);
                            $count = $obj->cartItemCount($con); ?>
                            <a href="addtocart.php" class="nav-link  text-decoration-none mx-1"><i class="fa-solid fa-cart-plus position-relative"><span class="position-absolute translate-middle badge rounded-pill bg-danger sp"><?php if (isset($count)) {
                                                                                                                                                                                                                                        echo $count;
                                                                                                                                                                                                                                    } ?></span></i></a><!--addtocart-->
                            <?php


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

                $_SESSION['category'] = $_GET['cat'];
                $_SESSION['subcategory'] = $_GET['sub'];
            } ?>

            <div class="text-center mt-3">
                <h1>Shop Thrifted <?php if (isset($_SESSION['category'])) {
                                        echo ucfirst($_SESSION['category']);
                                    } ?> 's &nbsp; <?php if ($_SESSION['subcategory']) {
                                                        echo ucfirst($_SESSION['subcategory']);
                                                    } ?></h1>
            </div>

            <div class="d-flex justify-left gap-2">

                <div class="dropdown">
                    <button class="btn dropdown-toggle" type="button" id="sortDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Sort
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="sortDropdown">
                        <li><a class="dropdown-item" href="item_template.php?price=LH">Price: Low to High</a></li>
                        <li><a class="dropdown-item" href="item_template.php?price=HL">Price: High to Low</a></li>
                        <li><a class="dropdown-item" href="item_template.php?price=NA">Newest Arrivals</a></li>
                    </ul>
                </div>
                <div class="dropdown">
                    <button class="btn dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Filter
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                        <li class="dropdown-submenu dropend">
                            <a class="dropdown-item dropdown-toggle" href="#" id="categoryDropdown" data-bs-toggle="dropdown" aria-expanded="false">Category</a>
                            <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
                                <li><a class="dropdown-item" href="thrift.php">Women</a></li>
                                <li><a class="dropdown-item" href="thrift_men.php?size=s">Men</a></li>
                                <li><a class="dropdown-item" href="thrift_kids.php?size=m">Kids</a></li>

                            </ul>
                        </li>
                        
                        <!-- subcategory ain kra -->

                        <li class="dropdown-submenu dropend">
                            <a class="dropdown-item dropdown-toggle" href="#" id="categoryDropdown" data-bs-toggle="dropdown" aria-expanded="false">Size</a>
                            <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
                                <li><a class="dropdown-item" href="item_template.php?size=xs">XS</a></li>
                                <li><a class="dropdown-item" href="item_template.php?size=s">S</a></li>
                                <li><a class="dropdown-item" href="item_template.php?size=m">M</a></li>
                                <li><a class="dropdown-item" href="item_template.php?size=l">L</a></li>
                                <li><a class="dropdown-item" href="item_template.php?size=xl">XL</a></li>
                                <li><a class="dropdown-item" href="item_template.php?size=other">Other</a></li>
                            </ul>
                        </li>

                        <!-- colour ain kra -->
                    </ul>
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
            $user->setCategory( $_SESSION['category']);
            $user->setSubCategory( $_SESSION['subcategory']);
            //$rows = $user->getThriftItemsLogin($con);
            if (isset($_GET['size'])) {
                $size = $_GET['size'];
                $rows = $user->getThriftItemsBySize($con, $size);
            } elseif (isset($_GET['price'])) {
                $price = $_GET['price'];
                $rows = $user->getThriftItemsBySort($con, $price);
            }  else {
                $rows = $user->getThriftItemsLogin($con);
            }

            if (!empty($rows)) {
                foreach ($rows as $row) {
                    $modalId = $row['itemid']; ?>
                    <div class="card mb-3" style="width: 17rem;">
                        <img src="../upload/<?php echo $row['coverimage'] ?>" class="card-img-top" alt="..." style="height:15rem;width:75%;object-fit: cover; display:block;padding:20px;margin:0 auto;" data-bs-toggle="modal" data-bs-target="#<?php echo $modalId; ?>">
                        <div class="card-body">
                            <h3 class="card-title"><?php echo ucfirst($row['itemname']); ?></h3>
                            <?php if (isset($row['size'])) { ?>
                                <h5 class="card-text"><strong>Size: </strong><?php echo $row['size']; ?></h5>
                            <?php } ?>

                            <h5 class="card-text"><strong>Price:</strong><?php echo 'Rs.' . $row['price']; ?></h5>

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

                            <!-- Write Review Button 
                            <button type="button" class="btn btn-secondary mt-2 equal-width" data-bs-toggle="modal" data-bs-target="#reviewModal<?php echo $row['itemid']; ?>" style="--bs-btn-color:black;--bs-btn-bg:none;--bs-btn-border-color:black; --bs-btn-hover-bg:#4c3f31;">
                                Write a Review
                            </button>

                            <!-- Review Modal 
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
                            </div>-->
                        </div>
                    </div>
                    <!-- Modal pop up display click item-->
                    <div class="modal fade" id="<?php echo $modalId; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="<?php echo $modalId; ?> aria-hidden=" true">
                        <div class="modal-dialog ">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id=id="<?php echo $modalId; ?>">Item Details</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <!-- item details-->
                                <div class="modal-body">
                                    <div id="itemDetails">
                                        <div class="container mt-4">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="product-image-container">

                                                        <img id="mainImage" src="../upload/<?php echo $row['coverimage']; ?>" class="img-fluid product-image" alt="Product Image" style="width: 400px; height: 400px;">
                                                    </div>
                                                    <div class="mt-3 d-flex item">

                                                        <img src="../upload/<?php echo $row['otherimage']; ?>" class="img-thumbnail thumbnail" alt="Thumbnail 3"
                                                            onclick="changeImage(this)">

                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <h1><?php echo $row['itemname']; ?>
                                                    </h1>
                                                    <h2>LKR <?php echo $row['price']; ?></h2>
                                                    <h2>Size <?php if (isset($row['size'])) { ?>
                                                            <?php echo $row['size']; ?>
                                                        <?php } ?>
                                                    </h2>
                                                    <p><span class="fw-bold">Code:</span> <?php echo $row['itemid']; ?></p>
                                                    <div class="d-flex flex-column">
                                                        <p class="fw-bold"><?php echo $row['color']; ?></p>

                                                    </div>
                                                    <div class="d-flex flex-column">
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

                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                        <!-- Wishlist Form -->
                                        <form action="../control/wishlistcon.php" method="post">
                                            <input type="hidden" name="productid" value="<?php echo $row['itemid']; ?>">
                                            <input type="hidden" name="userid" value="<?php echo $userid; ?>">
                                            <input type="hidden" name="cat" value="<?php echo $category; ?>">
                                            <input type="hidden" name="sub" value="<?php echo $subcategory; ?>">
                                            <button type="submit" class="btn btn-primary mt-2 equal-width" name="wishlist" style="--bs-btn-color:white; --bs-btn-bg:#4c3f31; --bs-btn-border-color:white; --bs-btn-hover-bg:#3e2f23;">
                                                <i class="fa-regular fa-heart"></i>&nbsp;Add to Wishlist
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php }
            } else { ?>
                <h2>No Items</h2>
            <?php } ?>
        </div>




        </div>

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
                        <li><a class="dropdown-item" href="#">Price: Low to High</a></li>
                        <li><a class="dropdown-item" href="#">Price: High to Low</a></li>
                        <li><a class="dropdown-item" href="#">Newest Arrivals</a></li>
                    </ul>
                </div>
                <div class="dropdown">
                    <button class="btn dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Filter
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                        <li><a class="dropdown-item" href="#">Category</a></li>
                        <li><a class="dropdown-item" href="#">Type</a></li>
                        <li><a class="dropdown-item" href="#">Size</a></li>
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
            $rows = $user->getThriftItems($con);
            if (!empty($rows)) {
                foreach ($rows as $row) {
                    $modalId = $row['itemid']; ?>
                    <div class="card mb-3 pt-2" style="width: 17rem;">
                        <img src="../upload/<?php echo $row['coverimage'] ?>" class="card-img-top" alt="..." style="height:10rem;" data-bs-toggle="modal" data-bs-target="#<?php echo $modalId; ?>">
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

                        </div>
                    </div>
                    <!-- Modal pop up display click item-->
                    <div class="modal fade" id="<?php echo $modalId; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="<?php echo $modalId; ?> aria-hidden=" true">
                        <div class="modal-dialog ">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id=id="<?php echo $modalId; ?>">Item Details</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <!-- item details-->
                                <div class="modal-body">
                                    <div id="itemDetails">
                                        <div class="container mt-4">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="product-image-container">

                                                        <img id="mainImage" src="../upload/<?php echo $row['coverimage']; ?>" class="img-fluid product-image" alt="Product Image" style="width: 400px; height: 400px;">
                                                    </div>
                                                    <div class="mt-3 d-flex item">
                                                        <!--<img src="../upload/<?php echo $row['otherimage']; ?>" class="img-thumbnail thumbnail" alt="Thumbnail 1" onclick="changeImage(this)">
                                                        <img src="../upload/<?php echo $row['other_image_2']; ?>" class="img-thumbnail thumbnail" alt="Thumbnail 2"
                                                            onclick="changeImage(this)">-->
                                                        <img src="../upload/<?php echo $row['otherimage']; ?>" class="img-thumbnail thumbnail" alt="Thumbnail 3"
                                                            onclick="changeImage(this)">

                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <h1><?php echo $row['itemname']; ?>
                                                    </h1>
                                                    <h2>LKR <?php echo $row['price']; ?></h2>
                                                    <h2>Size <?php if (isset($row['size'])) { ?>
                                                            <?php echo $row['size']; ?>
                                                        <?php } ?>
                                                    </h2>
                                                    <p><span class="fw-bold">Code:</span> <?php echo $row['itemid']; ?></p>
                                                    <div class="d-flex flex-column">
                                                        <p class="fw-bold"><?php echo $row['color']; ?></p>

                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                <h2>No Items</h2>
            <?php } ?>


        </div>
        <script src="https://unpkg.com/scrollreveal"></script>
        <script src="../js/main.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>

    </html>


<?php } ?>