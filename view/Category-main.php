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
                                <a class="nav-link" href="Store Index.php">Selling</a>
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
                            <a href="#" class="nav-link  text-decoration-none mx-1"><i class="fa-solid fa-cart-plus position-relative"><span class="position-absolute translate-middle badge rounded-pill bg-danger sp"><?php if (isset($count)) {
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


       <!---Navigation Bar - Sub-->
    <nav class="nav justify-content-center" >
      <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <button class="nav-link active" id="nav-dresses-tab" data-bs-toggle="tab" data-bs-target="#nav-dresses" type="button" role="tab" aria-controls="nav-dresses" aria-selected="true" >Dresses</button>
        <button class="nav-link" id="nav-blouse-tab" data-bs-toggle="tab" data-bs-target="#nav-blouse" type="button" role="tab" aria-controls="nav-blouse" aria-selected="false">Blouses</button>
        <button class="nav-link" id="nav-tshirt-tab" data-bs-toggle="tab" data-bs-target="#nav-tshirt" type="button" role="tab" aria-controls="nav-tshirt" aria-selected="false">T-Shirts</button>
        <button class="nav-link" id="nav-shirt-tab" data-bs-toggle="tab" data-bs-target="#nav-shirt" type="button" role="tab" aria-controls="nav-shirt" aria-selected="false">Shirts</button>
        <button class="nav-link" id="nav-croptop-tab" data-bs-toggle="tab" data-bs-target="#nav-croptop" type="button" role="tab" aria-controls="nav-croptop" aria-selected="false">Crop-Tops</button>
        <button class="nav-link" id="nav-skirt-tab" data-bs-toggle="tab" data-bs-target="#nav-skirt" type="button" role="tab" aria-controls="nav-skirt" aria-selected="false">Skirts</button>
        <button class="nav-link" id="nav-pantt-tab" data-bs-toggle="tab" data-bs-target="#nav-pant" type="button" role="tab" aria-controls="nav-pantt" aria-selected="false">Pants</button>
        <button class="nav-link" id="nav-short-tab" data-bs-toggle="tab" data-bs-target="#nav-short" type="button" role="tab" aria-controls="nav-short" aria-selected="false">Shorts</button>
        <button class="nav-link" id="nav-jean-tab" data-bs-toggle="tab" data-bs-target="#nav-jean" type="button" role="tab" aria-controls="nav-jean" aria-selected="false">Jeans</button>
        <button class="nav-link" id="nav-sandal-tab" data-bs-toggle="tab" data-bs-target="#nav-sandal" type="button" role="tab" aria-controls="nav-sandal" aria-selected="false">Sandals</button>
        <button class="nav-link" id="nav-bag-tab" data-bs-toggle="tab" data-bs-target="#nav-bag" type="button" role="tab" aria-controls="nav-bag" aria-selected="false">Bags</button>
        <button class="nav-link" id="nav-j&a-tab" data-bs-toggle="tab" data-bs-target="#nav-j&a" type="button" role="tab" aria-controls="nav-j&a" aria-selected="false">Jewelry & Accessories</button>
    </nav>

    <br>
    <div class="tab-content" id="nav-tabContent">
      <div class="tab-pane fade show active" id="nav-dresses" role="tabpanel" aria-labelledby="nav-dresses-tab" tabindex="0">
        
          <br> 

          <!-- Products Section -->
          <section id="newproducts" class="product-store">
            <div class="product-grid">
              <!--methn adala product type 1k ewa witri enna oni--->
              <!-- Example product item -->
              <div class="product-item">
                <div class="image-holder">
                  <span class="new-label">New</span>  <!----New product nm "new" label 1k enna oni methnt-->
                  <img src="item-1.jpg" class="product-img" alt="Product 1"><!--methn images tynn oni adala product type 1k ewa witri--->
                  <div class="cart-concern">
                
                    <button type="button" class="btn-cart">
                      <i class="bi bi-cart-plus"></i>
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
                        <path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9z"/>
                        <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zm3.915 10L3.102 4h10.796l-1.313 7zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                      </svg>
                    </button> 
                   
                    <button type="button" class="btn-whishlist">
                      <i class="bi bi-heart"></i>
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                        <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15"/>
                      </svg>
                    </button> 
                    
                  </div>
                </div>
                <div class="product-detail">
                  <h3 class="product-name">Product Name 1</h3><!-----product name enna oni methnt-->
                  <p class="category-type">Category Type</p><!-----men/women/kids enna oni methnt - -->
                  <p class="product-price">$49.99</p><!-----product price enna oni methnt-->
                </div>
              </div>      
              


            </div>      
          </section>   
 
      </div>
    
      <div class="tab-pane fade" id="nav-blouse" role="tabpanel" aria-labelledby="nav-blouse-tab" tabindex="0">
        <br> 

          <!-- Products Section -->
          <section id="newproducts" class="product-store">
            <div class="product-grid">
              <!--methn adala product type 1k ewa witri enna oni--->
              <!-- Example product item -->
              <div class="product-item">
                <div class="image-holder">
                  <span class="new-label">New</span>  <!----New product nm "new" label 1k enna oni methnt-->
                  <img src="item-1.jpg" class="product-img" alt="Product 1"><!--methn images tynn oni adala product type 1k ewa witri--->
                  <div class="cart-concern">
                
                    <button type="button" class="btn-cart">
                      <i class="bi bi-cart-plus"></i>
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
                        <path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9z"/>
                        <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zm3.915 10L3.102 4h10.796l-1.313 7zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                      </svg>
                    </button> 
                   
                    <button type="button" class="btn-whishlist">
                      <i class="bi bi-heart"></i>
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                        <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15"/>
                      </svg>
                    </button> 
                    
                  </div>
                </div>
                <div class="product-detail">
                  <h3 class="product-name">Product Name 1</h3><!-----product name enna oni methnt-->
                  <p class="category-type">Category Type</p><!-----men/women/kids enna oni methnt - -->
                  <p class="product-price">$49.99</p><!-----product price enna oni methnt-->
                </div>
              </div>           


            </div>      
          </section>   
      </div>
      <div class="tab-pane fade" id="nav-tshirt" role="tabpanel" aria-labelledby="nav-tshirt-tab" tabindex="0"><br> 

        <!-- Products Section -->
        <section id="newproducts" class="product-store">
          <div class="product-grid">
            <!--methn adala product type 1k ewa witri enna oni--->
            <!-- Example product item -->
            <div class="product-item">
              <div class="image-holder">
                <span class="new-label">New</span>  <!----New product nm "new" label 1k enna oni methnt-->
                <img src="item-1.jpg" class="product-img" alt="Product 1"><!--methn images tynn oni adala product type 1k ewa witri--->
                <div class="cart-concern">
              
                  <button type="button" class="btn-cart">
                    <i class="bi bi-cart-plus"></i>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
                      <path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9z"/>
                      <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zm3.915 10L3.102 4h10.796l-1.313 7zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                    </svg>
                  </button> 
                 
                  <button type="button" class="btn-whishlist">
                    <i class="bi bi-heart"></i>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                      <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15"/>
                    </svg>
                  </button> 
                  
                </div>
              </div>
              <div class="product-detail">
                <h3 class="product-name">Product Name 1</h3><!-----product name enna oni methnt-->
                <p class="category-type">Category Type</p><!-----men/women/kids enna oni methnt - -->
                <p class="product-price">$49.99</p><!-----product price enna oni methnt-->
              </div>
            </div>      
            

          </div>      
        </section>   
      </div>
      <div class="tab-pane fade" id="nav-shirt" role="tabpanel" aria-labelledby="nav-shirt-tab" tabindex="0">
        <br> 

          <!-- Products Section -->
          <section id="newproducts" class="product-store">
            <div class="product-grid">
              <!--methn adala product type 1k ewa witri enna oni--->
              <!-- Example product item -->
              <div class="product-item">
                <div class="image-holder">
                  <span class="new-label">New</span>  <!----New product nm "new" label 1k enna oni methnt-->
                  <img src="item-1.jpg" class="product-img" alt="Product 1"><!--methn images tynn oni adala product type 1k ewa witri--->
                  <div class="cart-concern">
                
                    <button type="button" class="btn-cart">
                      <i class="bi bi-cart-plus"></i>
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
                        <path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9z"/>
                        <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zm3.915 10L3.102 4h10.796l-1.313 7zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                      </svg>
                    </button> 
                   
                    <button type="button" class="btn-whishlist">
                      <i class="bi bi-heart"></i>
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                        <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15"/>
                      </svg>
                    </button> 
                    
                  </div>
                </div>
                <div class="product-detail">
                  <h3 class="product-name">Product Name 1</h3><!-----product name enna oni methnt-->
                  <p class="category-type">Category Type</p><!-----men/women/kids enna oni methnt - -->
                  <p class="product-price">$49.99</p><!-----product price enna oni methnt-->
                </div>
              </div>      
    

            </div>      
          </section>   
      </div>
      <div class="tab-pane fade" id="nav-croptop" role="tabpanel" aria-labelledby="nav-croptop-tab" tabindex="0">
        <br> 

          <!-- Products Section -->
          <section id="newproducts" class="product-store">
            <div class="product-grid">
              <!--methn adala product type 1k ewa witri enna oni--->
              <!-- Example product item -->
              <div class="product-item">
                <div class="image-holder">
                  <span class="new-label">New</span>  <!----New product nm "new" label 1k enna oni methnt-->
                  <img src="item-1.jpg" class="product-img" alt="Product 1"><!--methn images tynn oni adala product type 1k ewa witri--->
                  <div class="cart-concern">
                
                    <button type="button" class="btn-cart">
                      <i class="bi bi-cart-plus"></i>
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
                        <path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9z"/>
                        <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zm3.915 10L3.102 4h10.796l-1.313 7zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                      </svg>
                    </button> 
                   
                    <button type="button" class="btn-whishlist">
                      <i class="bi bi-heart"></i>
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                        <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15"/>
                      </svg>
                    </button> 
                    
                  </div>
                </div>
                <div class="product-detail">
                  <h3 class="product-name">Product Name 1</h3><!-----product name enna oni methnt-->
                  <p class="category-type">Category Type</p><!-----men/women/kids enna oni methnt - -->
                  <p class="product-price">$49.99</p><!-----product price enna oni methnt-->
                </div>
              </div>      
              

            </div>      
          </section>   
      </div>
      <div class="tab-pane fade" id="nav-skirt" role="tabpanel" aria-labelledby="nav-skirt-tab" tabindex="0">
        <br> 

          <!-- Products Section -->
          <section id="newproducts" class="product-store">
            <div class="product-grid">
              <!--methn adala product type 1k ewa witri enna oni--->
              <!-- Example product item -->
              <div class="product-item">
                <div class="image-holder">
                  <span class="new-label">New</span>  <!----New product nm "new" label 1k enna oni methnt-->
                  <img src="item-1.jpg" class="product-img" alt="Product 1"><!--methn images tynn oni adala product type 1k ewa witri--->
                  <div class="cart-concern">
                
                    <button type="button" class="btn-cart">
                      <i class="bi bi-cart-plus"></i>
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
                        <path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9z"/>
                        <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zm3.915 10L3.102 4h10.796l-1.313 7zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                      </svg>
                    </button> 
                   
                    <button type="button" class="btn-whishlist">
                      <i class="bi bi-heart"></i>
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                        <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15"/>
                      </svg>
                    </button> 
                    
                  </div>
                </div>
                <div class="product-detail">
                  <h3 class="product-name">Product Name 1</h3><!-----product name enna oni methnt-->
                  <p class="category-type">Category Type</p><!-----men/women/kids enna oni methnt - -->
                  <p class="product-price">$49.99</p><!-----product price enna oni methnt-->
                </div>
              </div>      
              

            </div>      
          </section>   
      </div>
      <div class="tab-pane fade" id="nav-pant" role="tabpanel" aria-labelledby="nav-pant-tab" tabindex="0">
        <br> 

          <!-- Products Section -->
          <section id="newproducts" class="product-store">
            <div class="product-grid">
              <!--methn adala product type 1k ewa witri enna oni--->
              <!-- Example product item -->
              <div class="product-item">
                <div class="image-holder">
                  <span class="new-label">New</span>  <!----New product nm "new" label 1k enna oni methnt-->
                  <img src="item-1.jpg" class="product-img" alt="Product 1"><!--methn images tynn oni adala product type 1k ewa witri--->
                  <div class="cart-concern">
                
                    <button type="button" class="btn-cart">
                      <i class="bi bi-cart-plus"></i>
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
                        <path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9z"/>
                        <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zm3.915 10L3.102 4h10.796l-1.313 7zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                      </svg>
                    </button> 
                   
                    <button type="button" class="btn-whishlist">
                      <i class="bi bi-heart"></i>
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                        <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15"/>
                      </svg>
                    </button> 
                    
                  </div>
                </div>
                <div class="product-detail">
                  <h3 class="product-name">Product Name 1</h3><!-----product name enna oni methnt-->
                  <p class="category-type">Category Type</p><!-----men/women/kids enna oni methnt - -->
                  <p class="product-price">$49.99</p><!-----product price enna oni methnt-->
                </div>
              </div>      
              

            </div>      
          </section>   
      </div>
      <div class="tab-pane fade" id="nav-short" role="tabpanel" aria-labelledby="nav-short-tab" tabindex="0">
        <br> 

          <!-- Products Section -->
          <section id="newproducts" class="product-store">
            <div class="product-grid">
              <!--methn adala product type 1k ewa witri enna oni--->
              <!-- Example product item -->
              <div class="product-item">
                <div class="image-holder">
                  <span class="new-label">New</span>  <!----New product nm "new" label 1k enna oni methnt-->
                  <img src="item-1.jpg" class="product-img" alt="Product 1"><!--methn images tynn oni adala product type 1k ewa witri--->
                  <div class="cart-concern">
                
                    <button type="button" class="btn-cart">
                      <i class="bi bi-cart-plus"></i>
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
                        <path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9z"/>
                        <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zm3.915 10L3.102 4h10.796l-1.313 7zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                      </svg>
                    </button> 
                   
                    <button type="button" class="btn-whishlist">
                      <i class="bi bi-heart"></i>
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                        <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15"/>
                      </svg>
                    </button> 
                    
                  </div>
                </div>
                <div class="product-detail">
                  <h3 class="product-name">Product Name 1</h3><!-----product name enna oni methnt-->
                  <p class="category-type">Category Type</p><!-----men/women/kids enna oni methnt - -->
                  <p class="product-price">$49.99</p><!-----product price enna oni methnt-->
                </div>
              </div>      
              

            </div>      
          </section>   
      </div>
      <div class="tab-pane fade" id="nav-jean" role="tabpanel" aria-labelledby="nav-jean-tab" tabindex="0">
        <br> 

          <!-- Products Section -->
          <section id="newproducts" class="product-store">
            <div class="product-grid">
              <!--methn adala product type 1k ewa witri enna oni--->
              <!-- Example product item -->
              <div class="product-item">
                <div class="image-holder">
                  <span class="new-label">New</span>  <!----New product nm "new" label 1k enna oni methnt-->
                  <img src="item-1.jpg" class="product-img" alt="Product 1"><!--methn images tynn oni adala product type 1k ewa witri--->
                  <div class="cart-concern">
                
                    <button type="button" class="btn-cart">
                      <i class="bi bi-cart-plus"></i>
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
                        <path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9z"/>
                        <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zm3.915 10L3.102 4h10.796l-1.313 7zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                      </svg>
                    </button> 
                   
                    <button type="button" class="btn-whishlist">
                      <i class="bi bi-heart"></i>
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                        <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15"/>
                      </svg>
                    </button> 
                    
                  </div>
                </div>
                <div class="product-detail">
                  <h3 class="product-name">Product Name 1</h3><!-----product name enna oni methnt-->
                  <p class="category-type">Category Type</p><!-----men/women/kids enna oni methnt - -->
                  <p class="product-price">$49.99</p><!-----product price enna oni methnt-->
                </div>
              </div>      
              

            </div>      
          </section>   
      </div>
      <div class="tab-pane fade" id="nav-sandal" role="tabpanel" aria-labelledby="nav-sandal-tab" tabindex="0">
        <br> 

          <!-- Products Section -->
          <section id="newproducts" class="product-store">
            <div class="product-grid">
              <!--methn adala product type 1k ewa witri enna oni--->
              <!-- Example product item -->
              <div class="product-item">
                <div class="image-holder">
                  <span class="new-label">New</span>  <!----New product nm "new" label 1k enna oni methnt-->
                  <img src="item-1.jpg" class="product-img" alt="Product 1"><!--methn images tynn oni adala product type 1k ewa witri--->
                  <div class="cart-concern">
                
                    <button type="button" class="btn-cart">
                      <i class="bi bi-cart-plus"></i>
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
                        <path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9z"/>
                        <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zm3.915 10L3.102 4h10.796l-1.313 7zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                      </svg>
                    </button> 
                   
                    <button type="button" class="btn-whishlist">
                      <i class="bi bi-heart"></i>
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                        <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15"/>
                      </svg>
                    </button> 
                    
                  </div>
                </div>
                <div class="product-detail">
                  <h3 class="product-name">Product Name 1</h3><!-----product name enna oni methnt-->
                  <p class="category-type">Category Type</p><!-----men/women/kids enna oni methnt - -->
                  <p class="product-price">$49.99</p><!-----product price enna oni methnt-->
                </div>
              </div>      


            </div>      
          </section>   
      </div>
      <div class="tab-pane fade" id="nav-bag" role="tabpanel" aria-labelledby="nav-bag-tab" tabindex="0">
        <br> 

          <!-- Products Section -->
          <section id="newproducts" class="product-store">
            <div class="product-grid">
              <!--methn adala product type 1k ewa witri enna oni--->
              <!-- Example product item -->
              <div class="product-item">
                <div class="image-holder">
                  <span class="new-label">New</span>  <!----New product nm "new" label 1k enna oni methnt-->
                  <img src="item-1.jpg" class="product-img" alt="Product 1"><!--methn images tynn oni adala product type 1k ewa witri--->
                  <div class="cart-concern">
                
                    <button type="button" class="btn-cart">
                      <i class="bi bi-cart-plus"></i>
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
                        <path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9z"/>
                        <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zm3.915 10L3.102 4h10.796l-1.313 7zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                      </svg>
                    </button> 
                   
                    <button type="button" class="btn-whishlist">
                      <i class="bi bi-heart"></i>
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                        <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15"/>
                      </svg>
                    </button> 
                    
                  </div>
                </div>
                <div class="product-detail">
                  <h3 class="product-name">Product Name 1</h3><!-----product name enna oni methnt-->
                  <p class="category-type">Category Type</p><!-----men/women/kids enna oni methnt - -->
                  <p class="product-price">$49.99</p><!-----product price enna oni methnt-->
                </div>
              </div>      
              


            </div>      
          </section>   
      </div>
      <div class="tab-pane fade" id="nav-j&a" role="tabpanel" aria-labelledby="nav-j&a-tab" tabindex="0">
        <br> 

          <!-- Products Section -->
          <section id="newproducts" class="product-store">
            <div class="product-grid">
              <!--methn adala product type 1k ewa witri enna oni--->
              <!-- Example product item -->
              <div class="product-item">
                <div class="image-holder">
                  <span class="new-label">New</span>  <!----New product nm "new" label 1k enna oni methnt-->
                  <img src="item-1.jpg" class="product-img" alt="Product 1"><!--methn images tynn oni adala product type 1k ewa witri--->
                  <div class="cart-concern">
                
                    <button type="button" class="btn-cart">
                      <i class="bi bi-cart-plus"></i>
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
                        <path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9z"/>
                        <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zm3.915 10L3.102 4h10.796l-1.313 7zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                      </svg>
                    </button> 
                   
                    <button type="button" class="btn-whishlist">
                      <i class="bi bi-heart"></i>
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                        <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15"/>
                      </svg>
                    </button> 
                    
                  </div>
                </div>
                <div class="product-detail">
                  <h3 class="product-name">Product Name 1</h3><!-----product name enna oni methnt-->
                  <p class="category-type">Category Type</p><!-----men/women/kids enna oni methnt - -->
                  <p class="product-price">$49.99</p><!-----product price enna oni methnt-->
                </div>
              </div>      
              


            </div>      
          </section>   
      </div>
    
      
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
    <script src="../js/sidepanel.js"></script>

  
  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
       integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  
  
  </body>
  </html>
  
