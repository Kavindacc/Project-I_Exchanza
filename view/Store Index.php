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

  <title>StoreIndex</title>
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
              <a class="nav-link" href="#">Selling</a>
            </li>
          </ul>

          <!--login nav-link-a-color-->
          <div class="d-flex flex-column float-start flex-lg-row justify-content-center  align-items-center mt-3 mt-lg-0 gap-3">

            <?php
            session_start();
            $userid = $_SESSION['userid'];
            include_once '../model/DbConnector.php';
            include_once '../model/addtocart.php';
            $dsn = new DbConnector();
            $con = $dsn->getConnection();

            $obj = new Cart();
            $obj->setUserId($userid);
            $count = $obj->cartItemCount($con); ?>
            <a href="#" class="nav-link  text-decoration-none mx-1"><i class="fa-solid fa-cart-plus position-relative"><span class="position-absolute translate-middle badge rounded-pill bg-danger sp"><?php if (isset($count)) {
                                                                                                                                                                                                          echo $count;
                                                                                                                                                                                                        } ?></span></i></a><!--addtocart-->
            <?php
            include_once '../model/wishlist.php';
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


  <!-- Main Section - Store -->
  <main>

    <!-------Banner------->
    <section id="billboard" class="overflow-hidden">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="banner-item" style="background-image: url(../img/img1.jpg); background-repeat: no-repeat; background-position: right;  height: 625px;">
              <div class="banner-content padding-large">
                <h1 class="display-1  text-uppercase text-dark pb-2 animated fadeInDown">Style for Every Moment</h1>

                <p class="animated fadeInUp">From everyday wear to special occasions, we've got you covered.
                  Our collection brings together quality and style for everyone,
                  offering timeless essentials and statement pieces to elevate any wardrobe.</p>

                <a href="../view/categoryMain.php">
                  <button type="button" class="btn btn-primary animated fadeInUp" style="--bs-btn-padding-y: 0.5rem; --bs-btn-padding-x: 0.75rem; --bs-btn-font-size: 1em;
                                              --bs-btn-border-radius: 5px;--bs-btn-color: #ffffff;--bs-btn-bg: #746557;--bs-btn-border-color:  #746557;--bs-btn-hover-color: #ffffff;  
                                              --bs-btn-hover-bg: #4c3f31;--bs-btn-hover-border-color: #4c3f31 ;--bs-btn-active-color: #ffffff;--bs-btn-active-bg: #4c3f31;
                                              --bs-btn-active-border-color: #4c3f31 ;">
                    <span class="text-uppercase">Shop Now</span>
                  </button>
                </a>
                <br>
                <br>
                <a href="../view/createStore.php">
                  <button type="button" class="btn btn-primary animated fadeInUp" style="--bs-btn-padding-y: 0.5rem; --bs-btn-padding-x: 0.75rem; --bs-btn-font-size: 1em;
                                              --bs-btn-border-radius: 5px;--bs-btn-color: #ffffff;--bs-btn-bg: #746557;--bs-btn-border-color:  #746557;--bs-btn-hover-color: #ffffff;  
                                              --bs-btn-hover-bg: #4c3f31;--bs-btn-hover-border-color: #4c3f31 ;--bs-btn-active-color: #ffffff;--bs-btn-active-bg: #4c3f31;
                                              --bs-btn-active-border-color: #4c3f31 ;">
                    <span class="text-uppercase">Create Store</span>
                  </button>
                </a>
                <br>
                <br>
                <a href="../view/StoreTem.php">
                  <button type="button" class="btn btn-primary animated fadeInUp" style="--bs-btn-padding-y: 0.5rem; --bs-btn-padding-x: 0.75rem; --bs-btn-font-size: 1em;
                                              --bs-btn-border-radius: 5px;--bs-btn-color: #ffffff;--bs-btn-bg: #746557;--bs-btn-border-color:  #746557;--bs-btn-hover-color: #ffffff;  
                                              --bs-btn-hover-bg: #4c3f31;--bs-btn-hover-border-color: #4c3f31 ;--bs-btn-active-color: #ffffff;--bs-btn-active-bg: #4c3f31;
                                              --bs-btn-active-border-color: #4c3f31 ;">
                    <span class="text-uppercase">My Store</span>
                  </button>
                </a>
                <br>
                <br>

              </div>
            </div>
          </div>
        </div>
      </div>
      <hr>
    </section>


      <br>
      <br>
      <!-- Shop by Collection -->

      <p class="new  text-uppercase ">Shop by Collection</p>
      <!-- me tika wens krnn epa methn tyn images category template 1k tyn categories wlt link krl tynne----->

      <!-- Categorie Collection----->

      <div id="carouselExampleRide" class="carousel slide" data-bs-ride="true">
        <div class="carousel-inner">
          <!-- Categorie collecton with Carousel start here and this should  be repeat----->
          <div class="carousel-item active"><!--plweniyt carousel active wenn methn tyn css oni-->

            <section id="category" class="category-icon">
              <div class="category-grid">
                <!-- Example product item -->
                <div class="category-item">
                  <a href="../view/categoryMain.php#nav-dresses-tab">
                    <div class="image-cat">
                      <img src="../img/dress.jpg" class="category-img" alt="Category-img">
                    </div>
                  </a>
                  <div class="category-detail">
                    <h3 class="category-name">Tops</h3>
                  </div>
                </div>

                <div class="category-item">
                  <a href="../view/categoryMain.php#nav-blouse-tab">
                    <div class="image-cat">
                      <img src="../img/blouse.jpg" class="category-img" alt="blouse-img">
                    </div>
                  </a>
                  <div class="category-detail">
                    <h3 class="category-name">Dresses</h3>
                  </div>
                </div>

                <div class="category-item">
                  <a href="../view/categoryMain.php#nav-tshirt-tab">
                    <div class="image-cat">
                      <img src="../img/tshirt.jpg" class="category-img" alt="Category-img">
                    </div>
                  </a>
                  <div class="category-detail">
                    <h3 class="category-name">Pants</h3>
                  </div>
                </div>

                <div class="category-item">
                  <a href="../view/categoryMain.php#nav-shirt-tab">
                    <div class="image-cat">
                      <img src="../img/shirt.jpg" class="category-img" alt="Category-img">
                    </div>
                  </a>
                  <div class="category-detail">
                    <h3 class="category-name">Accessories</h3>
                  </div>
                </div>

              </div>
            </section>
          </div>

          

          <div class="carousel-item">

            <section id="category" class="category-icon">
              <div class="category-grid">
                <!-- Example product item -->

                <div class="category-item">
                  <a href="../view/categoryMain.php#nav-jean-tab">
                    <div class="image-cat">
                      <img src="../img/jean.jpg" class="category-img" alt="Category-img">
                    </div>
                  </a>
                  <div class="category-detail">
                    <h3 class="category-name">Bags</h3>
                  </div>
                </div>

                <div class="category-item">
                  <a href="../view/categoryMain.php#nav-sandal-tab">
                    <div class="image-cat">
                      <img src="../img/sandal.jpg" class="category-img" alt="Category-img">
                    </div>
                  </a>
                  <div class="category-detail">
                    <h3 class="category-name">Shoes</h3>
                  </div>
                </div>

                <div class="category-item">
                  <a href="../view/categoryMain.php#nav-bag-tab">
                    <div class="image-cat">
                      <img src="../img/bag.png" class="category-img" alt="Category-img">
                    </div>
                  </a>
                  <div class="category-detail">
                    <h3 class="category-name">Bags</h3>
                  </div>
                </div>

                <div class="category-item">
                  <a href="../view/categoryMain.php#nav-j&a-tab">
                    <div class="image-cat">
                      <img src="../img/j&a.jpg" class="category-img" alt="Category-img">
                    </div>
                  </a>
                  <div class="category-detail">
                    <h3 class="category-name">Jewelry & Accessories</h3>
                  </div>
                </div>

              </div>
            </section>

          </div>

        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleRide" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleRide" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>

      <br>
      <br>

      <!-- Stores Section -->
      <p class="new  text-uppercase ">Visit your Favourite Store</p>
      <!-- stores----->
      <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">

          <!-- Stores Section with carousel start from here and this section should be repeat-->
          <div class="carousel-item active"> <!--plweniyt tyn carousel section 1k active wenn methn tyn css oni-->
            <section id="store" class="store-icon">
              <div class="store-grid">
                <!-- Example store---->
                <!--Div 4k 1k section ekkt dann-->
                <div class="store-item">
                  <a href="visitStore.php">
                    <div class="image-st">
                      <img src="../img/store-1.jpg" class="store-img" alt="storeprofilepic"><!---- Store profile pic 1k wens wenna oni-->
                    </div>
                  </a>
                  <div class="store-detail">
                    <h3 class="product-name">Bella Boutique</h3><!---- Store name 1k wens wenna oni-->
                  </div>
                </div>


              </div>
            </section>
          </div>

          <div class="carousel-item"><!--2 weniyt tyn section eke idl awasanet tyn section 1k wenkn repeat wenn methn tyn css oni-->
            <section id="store" class="store-icon">
              <div class="store-grid">
                <!-- Example store---->
                <div class="store-item">
                  <a href="#">
                    <div class="image-st">
                      <img src="../img/Cat-Banner.jpg" class="store-img" alt="storeprofilepic"><!---- Store profile pic 1k wens wenna oni-->
                    </div>
                  </a>
                  <div class="store-detail">
                    <h3 class="product-name">Store Name</h3><!---- Store name 1k wens wenna oni-->
                  </div>
                </div>



              </div>
            </section>
          </div>

          <div class="carousel-item"><!--2 weniyt tyn section eke idl awasanet tyn section 1k wenkn repeat wenn methn tyn css oni-->
            <section id="store" class="store-icon">
              <div class="store-grid">
                <!-- Example store---->
                <div class="store-item">
                  <a href="#">
                    <div class="image-st">
                      <img src="../img/Cat-Banner.jpg" class="store-img" alt="storeprofilepic"><!---- Store profile pic 1k wens wenna oni-->
                    </div>
                  </a>
                  <div class="store-detail">
                    <h3 class="product-name">Store Name</h3><!---- Store name 1k wens wenna oni-->
                  </div>
                </div>



              </div>
            </section>
          </div>

          <div class="carousel-item"><!--2 weniyt tyn section eke idl awasanet tyn section 1k wenkn repeat wenn methn tyn css oni-->
            <section id="store" class="store-icon">
              <div class="store-grid">
                <!-- Example store---->
                <div class="store-item">
                  <a href="#">
                    <div class="image-st">
                      <img src="../img/Cat-Banner.jpg" class="store-img" alt="storeprofilepic"><!---- Store profile pic 1k wens wenna oni-->
                    </div>
                  </a>
                  <div class="store-detail">
                    <h3 class="product-name">Store Name</h3><!---- Store name 1k wens wenna oni-->
                  </div>
                </div>



              </div>
            </section>
          </div>

        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>


  </main>

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
  <script src="../js/sidepanel.js?v=<?php echo time(); ?>"></script>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>