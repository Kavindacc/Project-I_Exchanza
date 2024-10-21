<?php
include_once '../model/DbConnector.php';
include_once '../model/wishlist.php';
include_once '../model/addtocart.php';
include_once '../model/item.php';
include_once '../model/user.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Seller Store Page</title>
  <link rel="stylesheet" href="../css/Storestyle.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <title>CategoryMain</title>
</head>

<body class="clr">
  <!----Navigation bar----->
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
              <a class="nav-link" aria-current="page" href="../index.php">Home</a>
            </li>
            <li class="nav-item mx-2">
              <a class="nav-link" href="thrift.php">Thrift</a>
            </li>
            <li class="nav-item mx-2">
              <a class="nav-link" href="../Project-I_Exchanza/view/bidding.php">Bidding</a>
            </li>
            <li class="nav-item mx-2">
              <a class="nav-link" href="../view/storeIndex.php">Selling</a>
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
            <?php } else { ?>
              <a href="addtocart.php" class="nav-link  text-decoration-none mx-1"><i class="fa-solid fa-cart-plus position-relative"><span class="position-absolute translate-middle badge rounded-pill bg-danger sp">0</span></i></a><!--addtocart-->
              <a href="wishlist.php" class="nav-link  text-decoration-none mx-1"><i class="fa-regular fa-heart position-relative"><span class="position-absolute translate-middle badge rounded-pill bg-danger sp">0</span></i></a>
              <a href="login_user.php" class=" text-decoration-none"><button class="lo-button btn-sm ms-2 px-3" style="color:#ffff;">login</button></a>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </nav>



  <!-- Main Section - Category -->
  <main>

    <!-------Category Banner------->


    <header>
      <div class="banner">
        <img src="../img/Cat-Banner.jpg" class="img-fluid" alt="New Collection Banner">

        <div class="banner-text">
          <span class="animated bounceInDown">NEW COLLECTION</span>

          <p class="animated fadeInUp">Now online</p>

        </div>
      </div>
    </header>


    <p class="new  text-uppercase ">Shop by Collection</p>

    <?php
    $dsn = new DbConnector();
    $con = $dsn->getConnection();

    $user = new Thrift($userid);
    ?>

    <!---Navigation Bar - Sub-->
    <nav class="nav justify-content-center">
      <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <button class="nav-link active" id="nav-all-tab" data-bs-toggle="tab" data-bs-target="#nav-all" type="button" role="tab" aria-controls="nav-all" aria-selected="true">All</button>
        <button class="nav-link" id="nav-dresses-tab" data-bs-toggle="tab" data-bs-target="#nav-dresses" type="button" role="tab" aria-controls="nav-dresses" aria-selected="false" onclick="<?php $user->getStoreItemsSub($con, "tops"); ?>">Tops</button>
        <button class="nav-link" id="nav-blouse-tab" data-bs-toggle="tab" data-bs-target="#nav-blouse" type="button" role="tab" aria-controls="nav-blouse" aria-selected="false" onclick="<?php $user->getStoreItemsSub($con, "dresses"); ?>">Dresses</button>
        <button class="nav-link" id="nav-tshirt-tab" data-bs-toggle="tab" data-bs-target="#nav-tshirt" type="button" role="tab" aria-controls="nav-tshirt" aria-selected="false" onclick="<?php $user->getStoreItemsSub($con, "pants"); ?>">Pants</button>
        <button class="nav-link" id="nav-shirt-tab" data-bs-toggle="tab" data-bs-target="#nav-shirt" type="button" role="tab" aria-controls="nav-shirt" aria-selected="false" onclick="<?php $user->getStoreItemsSub($con, "accessories"); ?>">Accessories</button>
        <button class="nav-link" id="nav-croptop-tab" data-bs-toggle="tab" data-bs-target="#nav-croptop" type="button" role="tab" aria-controls="nav-croptop" aria-selected="false" onclick="<?php $user->getStoreItemsSub($con, "bags"); ?>">Bags</button>
        <button class="nav-link" id="nav-skirt-tab" data-bs-toggle="tab" data-bs-target="#nav-skirt" type="button" role="tab" aria-controls="nav-skirt" aria-selected="false" onclick="<?php $user->getStoreItemsSub($con, "shoes"); ?>">Shoes</button>
    </nav>

    <br>
    


<?php

if (isset($_SESSION['userid'])) {
  $userid = $_SESSION['userid'];
}


    $dsn = new DbConnector();
    $con = $dsn->getConnection();

    $user = new Thrift($userid);
    $rows = $user->getStoreItemsAll($con, $userid);
    ?>

    <?php if (!empty($rows)) { ?>
        <div class="d-flex flex-wrap justify-content-start">
            <?php foreach ($rows as $row) { ?>
                <div class="card mb-3 pt-2 me-2" style="width: 17rem;">
                    <img src="../upload/<?php echo $row['coverimage']; ?>" class="card-img-top" alt="..." style="height:10rem;">
                    <div class="card-body">
                        <h3 class="card-title"><?php echo $row['itemname']; ?></h3>
                        <?php if (isset($row['size'])) { ?>
                            <h5 class="card-text"><strong>Size: </strong><?php echo $row['size']; ?></h5>
                        <?php } ?>

                        <h5 class="card-text"><strong>Price:</strong><?php echo 'Rs.' . $row['price']; ?></h5>

                        <!-- Ratings Section -->
                        <?php
                        $obj = new GeneralCustomer();
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
                                                echo ($i <= $ratingValue) ? '<i class="fas fa-star filled"></i>' : '<i class="fas fa-star"></i>';
                                            }
                                            ?>
                                        </h6>
                                        <h6><strong>Review:</strong><?php echo $rate['review_text']; ?></h6>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>

                        <!-- Wishlist Form -->
                        <form action="../control/wishlistcon.php" method="post">
                            <input type="hidden" name="itemid" value="<?php echo $itemid; ?>">
                            <input type="hidden" name="userid" value="<?php echo $userid; ?>">
                            <input type="hidden" name="cat" value="<?php echo $category; ?>">
                            <input type="hidden" name="sub" value="<?php echo $subcategory; ?>">
                            <button type="submit" class="btn btn-primary mt-2 equal-width" name="wishlist" style="--bs-btn-color:black;--bs-btn-bg:none;--bs-btn-border-color:black; --bs-btn-hover-bg:#4c3f31;">
                                <i class="fa-regular fa-heart"></i>&nbsp;Add to Wishlist
                            </button>
                        </form>

                        <!-- Write Review Button -->
                        <button type="button" class="btn btn-secondary mt-2 equal-width" data-bs-toggle="modal">
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
                                            <input type="hidden" name="itemid" value="<?php echo $row['itemid']; ?>">
                                            <input type="hidden" name="userid" value="<?php echo $userid; ?>">
                                            <input type="hidden" name="cat" value="<?php echo $category; ?>">
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
            <?php } ?>
        </div>
    <?php } else { ?>
        <h2>No Items</h2>
    <?php } ?>


  <!-------footer------->
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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="../js/sidepanel.js"></script>



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


</body>

</html>