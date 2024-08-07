<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Store Page</title>
    <link rel="stylesheet" href="Storestyle.css">
</head>
<body>


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
                            <a class="nav-link active" aria-current="page" href="#">Home</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link" href="#">Thrift</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link" href="#">Bidding</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link" href="#">Selling</a>
                        </li>
                    </ul>
                    <form class="d-flex me-4 align-items-center" role="search">
                        <input class="search me-2" type="search" placeholder="Search">
                        <a href="#1" class="nav-link  text-decoration-none  mt-1"><i class="fa-solid fa-magnifying-glass"></i></a>
                    </form>
                    <!--login nav-link-a-color-->
                    <div class="d-flex flex-column float-start flex-lg-row justify-content-center  align-items-center mt-3 mt-lg-0 gap-3">
                        <a href="#1" class="nav-link  text-decoration-none mx-1"><i class="fa-solid fa-cart-plus"><span></span></i></a>
                        <?php
                        if (isset($_SESSION['logedin']) && $_SESSION['logedin'] === true) { ?>
                            <button class="lo-out btn-sm ms-2 px-3">
                                <a href="view/logout.php" class=" text-decoration-none">logout</a>
                            </button>
                            <?php echo "Hi," . $_SESSION['username']; ?>
                        <?php } else { ?>
                            <button class="lo-button btn-sm ms-2 px-3">
                                <a href="view/login.php" class=" text-decoration-none">login</a>
                            </button>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </nav> 



    <!-- Main Section - store -->
    <main>
        <!-- Banner -->
        <div class="banner">
            <h1>New Arrivals</h1>
        </div>
        
          <!-- Filters and Products -->
           
        <div>
        
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true" onclick="window.location.href='thrift.php';">Women</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false" onclick="window.location.href='thrift_men.php';">Men</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false" onclick="window.location.href='thrift_kids.php';">Kids</button>
                </li>
            </ul>


        </div>



        <!-- Filters and Products -->
        <div class="content">
            <!-- Filters -->
            <aside class="filters">
        
                <div>
                    <h3>Category</h3>
                    <ul >
                        <a class="anchors" href="categoryTem.html">T-Shirts</a><br>
                        <a class="anchors" href="categoryTem.html">Shirts</a><br>
						<a class="anchors" href="categoryTem.html">Shorts</a><br>
						<a class="anchors" href="categoryTem.html">Jeans</a><br>
                        <a class="anchors" href="categoryTem.html">Crop Tops</a><br>
                        <a class="anchors" href="categoryTem.html">Blouses</a><br>
						<a class="anchors" href="categoryTem.html">Dresses</a><br>
						<a class="anchors" href="categoryTem.html">Skirts</a>
                    </ul>
                </div>
                
            </aside>

            <!--Stores----->

            <div class="stores">
                <div class="store-card">
                    <a href="StoreTem.html" >
                        <img src="../img/Clothing Stores.jpg" alt="Store icon">
                    </a>
                    
                    <p><b>Store Name</b></p>
                    
                </div>
            
<hr>

               <!-- Products -->
                <div class="products">
                    <div class="product-card">
                        <img src="../img/Halter Neck Dress.jpg" alt="Halter Neck Dress">
                        <h3>Aloruh Gingham Halter Neck Dress</h3>
                        <p>$12.99</p>
                        <div class="button">
                        <button class="btn btn-cart ">Add to Cart</button>
                        <button class="btn btn-visit">Visit the Store</button>
                        </div>

                        <br>
                        <div class="product-icons">
                            <img src="wishlist-icon.png" alt="Wishlist">
                       
                            <img src="rating-icon.png" alt="Rating">
                        </div>
                    </div>
                </div>
            </div>
		</div>
			
			
		
 
			
		
    </main>

	
<!-------footer------->

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
    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="view/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>



</body>
</html>
