<?php
include_once '../model/DbConnector.php';
include_once '../model/wishlist.php';
include_once '../model/addtocart.php';

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/thriftW.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   
    <title>StoreTem</title>
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

 

    <!-- Main Section -->
    <main>


    <?php
      // Start the session and fetch the user ID from session
     
      $userid = $_SESSION['userid']; 

      // Include your database connection file
      include_once '../model/DbConnector.php';

      // Establish a database connection
      $dsn = new DbConnector();
      $con = $dsn->getConnection(); // Assuming getConnection() returns a PDO object

      // Prepare SQL query to fetch store details for the logged-in user
      $sql = "SELECT store_name, slogan, profile_pic, cover_pic FROM stores WHERE user_id = :userid";
      $stmt = $con->prepare($sql);
      $stmt->bindParam(':userid', $userid, PDO::PARAM_INT);
      $stmt->execute();

      // Fetch the data and store in an associative array
      $store = $stmt->fetch(PDO::FETCH_ASSOC);

      // Extract data from the array
      $store_name = htmlspecialchars($store['store_name']);
      $slogan = htmlspecialchars($store['slogan']);
      $profile_pic = htmlspecialchars($store['profile_pic']);
      $cover_pic = htmlspecialchars($store['cover_pic']);
  ?>

      
      

    
      <div class="sbanner">
        <img src="<?php echo $cover_pic ?>" alt="Cover Photo" class="cover-photo"><!----Meka thmnt kamathi widiht wes krnn sellert plwn wenn oni-->
        <div class="profile-container">
          <img src="<?php echo $profile_pic ?>" alt="Profile Photo" class="profile-photo"><!----Profile photo 1k wens krnn sellert plwn wenn oni-->
          <h2 class="store-name"><?php echo $store_name ?></h2><!----Store name 1k wens krnn sellert plwn wenn oni-->
        </div>
        <div class="now-in-stock"><?php echo $slogan ?></div> <!----Methn tyn quote 1k wens krnn sellert plwn wenn oni-->
      </div>
        


 
    
        <div class="heads">
          <div class="grid text-center">
            <div class="g-col-6 g-col-md-4">
              <i class="bi bi-handbag"></i>
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-handbag" viewBox="0 0 16 16">
                <path d="M8 1a2 2 0 0 1 2 2v2H6V3a2 2 0 0 1 2-2m3 4V3a3 3 0 1 0-6 0v2H3.36a1.5 1.5 0 0 0-1.483 1.277L.85 13.13A2.5 2.5 0 0 0 3.322 16h9.355a2.5 2.5 0 0 0 2.473-2.87l-1.028-6.853A1.5 1.5 0 0 0 12.64 5zm-1 1v1.5a.5.5 0 0 0 1 0V6h1.639a.5.5 0 0 1 .494.426l1.028 6.851A1.5 1.5 0 0 1 12.678 15H3.322a1.5 1.5 0 0 1-1.483-1.723l1.028-6.851A.5.5 0 0 1 3.36 6H5v1.5a.5.5 0 1 0 1 0V6z"/>
              </svg>
               New Products Added Every Week</div>

            <div class="g-col-6 g-col-md-4">
              <i class="bi bi-truck"></i>
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-truck" viewBox="0 0 16 16">
                <path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5zm1.294 7.456A2 2 0 0 1 4.732 11h5.536a2 2 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456M12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2"/>
              </svg>
              Quick Delivery</div>

            <div class="g-col-6 g-col-md-4">
              <i class="bi bi-gift"></i>
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gift" viewBox="0 0 16 16">
                <path d="M3 2.5a2.5 2.5 0 0 1 5 0 2.5 2.5 0 0 1 5 0v.006c0 .07 0 .27-.038.494H15a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a1.5 1.5 0 0 1-1.5 1.5h-11A1.5 1.5 0 0 1 1 14.5V7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h2.038A3 3 0 0 1 3 2.506zm1.068.5H7v-.5a1.5 1.5 0 1 0-3 0c0 .085.002.274.045.43zM9 3h2.932l.023-.07c.043-.156.045-.345.045-.43a1.5 1.5 0 0 0-3 0zM1 4v2h6V4zm8 0v2h6V4zm5 3H9v8h4.5a.5.5 0 0 0 .5-.5zm-7 8V7H2v7.5a.5.5 0 0 0 .5.5z"/>
              </svg>
              
              Special Packaging For Gifts</div>
          </div>
        </div>

        <br>



         <!-- Products Section -->
        <!--
         <section id="newproducts" class="product-store">
            
          <div class="product-grid">
            
            <div class="product-item">
              <div class="image-holder">
                <span class="new-label">New</span>  
                <img src="../img/item-1.jpg" class="product-img" alt="Product 1">
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
                <h3 class="product-name">Product Name 1</h3>
                <p class="category-type">Category Type</p>
                <p class="product-price">$49.99</p>
              </div>
            </div>   
          </div>

        </section>   
        -->

<br>

           <!-----Recommendation Section   -->



<div>
<div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0"></div>
                <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0"></div>
                <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0"></div>
                <div class="tab-pane fade" id="disabled-tab-pane" role="tabpanel" aria-labelledby="disabled-tab" tabindex="0"></div>
            </div>

        </div>
        <!-- <a href="sidepanel.php" target="_blank" aria-label="Plus Icon">  -->
        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle" id="openPanel">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="12" y1="8" x2="12" y2="16"></line>
            <line x1="8" y1="12" x2="16" y2="12"></line>
        </svg>
        <!-- </a> -->
    </div>
    <!-- sidepanel -->
    <div id="sidePanel" class="side-panel">
        <button id="closePanel" class="close-btn">&times;</button>
        
       
        <?php if (isset($_SESSION['userid'])) {
            $userid = $_SESSION['userid']; ?>
            <button class="add-item-btn" style="width:100%;" onclick="showForm()">Add Item</button>
        <?php } else { ?>
            <a href="login_user.php" style="text-decoration: none;">
                <button class="add-item-btn" style="width:100%;">Add Item</button>
            </a>
        <?php } ?>


    </div>
    <!-- Popup overlay and form -->
    <div id="popupForm" class="popup-overlay">
        <div class="popup-content">
            <button id="closePopup" class="close-btn">&times;</button>
            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-6">
                        <h2 class="mb-4">Add Item to My Store</h2>
                        <form action="../control/storecon.php" method="post" enctype="multipart/form-data" id="resellForm"> <!--form start add to item-->
                        <input type="hidden" name="userid" value="<?php echo $userid; ?>">
                            <div class="form-group">
                                <label for="itemName" class="bold">Item Name</label>
                                <input type="text" class="form-control" id="itemName" placeholder="Enter item name" name="itemname" required>
                            </div>
                            <div class="form-group">
                                <label for="price" class="bold">Price (Rs.)</label>
                                <input type="number" class="form-control" id="price" placeholder="Enter price" name="price" required>
                            </div>
                            <div class="form-group">
                                <label for="color" class="bold">Color</label>
                                <input type="color" class="form-control" id="color" name="colour" required>
                            </div>
                            <div class="form-group">
                                <label for="coverImage" class="bold">Cover Image</label>
                                <input type="file" class="form-control-file" id="coverImage" name="image" required>
                            </div>
                            <div class="form-group">
                                <label for="otherImages" class="bold">Other Images (Optional)</label>
                                <input type="file" class="form-control-file" id="otherImages" name="otherimage">
                            </div>
                            <div class="form-group">
                                <label for="description" class="bold">Description</label>
                                <textarea class="form-control" id="description" rows="3" placeholder="Enter description" name="description" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="category" class="bold">Category</label>
                                <select class="form-control" id="category" name="category" required>
                                    <option value="">Select Category</option>
                                    <!-- <option value="men">Men</option> -->
                                    <option value="women">Women</option>
                                    <!-- <option value="kids">Kids</option> -->
                                </select>
                            </div>
                            <div class="form-group hidden" id="subcategoryWrapper">
                                <label for="subcategory" class="bold">Subcategory</label>
                                <select class="form-control" id="subcategory" name="subcategory">
                                    <option value="">Select Subcategory</option>
                                    <option value="tops">Tops</option>
                                    <option value="dresses">Dresses</option>
                                    <option value="pants">Pants</option>
                                    <option value="accessories">Accessories</option>
                                    <option value="bags">Bags</option>
                                    <option value="shoes">Shoes</option>
                                </select>
                            </div>
                            <!-- normal sizes -->
                            <div class="form-group hidden" id="normalsizeChartWrapper">
                                <label class="bold">Size</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="size" id="sizeS" value="S">
                                    <label class="form-check-label" for="sizeS">S</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="size" id="sizeM" value="M">
                                    <label class="form-check-label" for="sizeM">M</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="size" id="sizeL" value="L">
                                    <label class="form-check-label" for="sizeL">L</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="size" id="sizeXL" value="XL">
                                    <label class="form-check-label" for="sizeXL">XL</label>
                                </div>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-primary ssubmit" name="submit">Submit</button>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <h2>Preview</h2>
                        <div class="card card-preview">
                            <img id="previewImage" src="https://via.placeholder.com/150" alt="Item image">
                            <div class="card-body">
                                <h5 class="card-title" id="previewName">Item Name</h5>
                                <p class="card-text" id="previewDescription">Description</p>
                                <p class="card-text" id="previewCategory">Category</p>
                                <p class="card-text" id="previewSubcategory">Subcategory</p>
                                <p class="card-text" id="previewSize">Size</p>
                                <h5 class="card-text" id="previewPrice">Rs. 0.00</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>



        
      

    </main>


    <div class="container d-flex justify-content-start flex-wrap mt-5 gap-4"><!--get iteam-->
            <?php

            include_once '../model/item.php';

            $dsn = new DbConnector();
            $con = $dsn->getConnection();

            if (isset($_SESSION['userid'])) {
              $userid = $_SESSION['userid']; 
            }

            $user = new Thrift($userid);
            $rows = $user->getStoreItemsLogin($con, $userid);

            if (!empty($rows)) {
                foreach ($rows as $row) { ?>
                    <div class="card mb-3 pt-2" style="width: 17rem;">
                        <img src="../upload/<?php echo $row['coverimage'] ?>" class="card-img-top" alt="..." style="height:10rem;">
                        <div class="card-body">
                            <h3 class="card-title"><?php echo $row['itemname']; ?></h3>
                            <?php if (isset($row['size'])) { ?>
                                <h5 class="card-text"><strong>Size: </strong><?php echo $row['size']; ?></h5>
                            <?php } ?>

                            <h5 class="card-text"><strong>Price:</strong><?php echo 'Rs.' . $row['price']; ?></h5>
                            <?php //rating
                            include_once '../model/User.php';
                            $obj = new GeneralCustomer();
                            $obj->setItemId($row['id']);
                            $rating = $obj->getRating($con);
                            if (!empty($rating)) { ?>
                                <div class="review mt-4">
                                    <?php foreach ($rating as $rate) {
                                        $user_id = $rate['user_id'];
                                        $obj->setUserid($user_id);
                                        $name = $obj->getusername($con);

                                    ?>


                                        <!-- <div class="rating-stars">
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

                                        </div> -->
                                    <?php } ?>
                                </div>
                            <?php } ?>

                            <!-- Wishlist Form -->
                            <form action="../control/wishlistcon.php" method="post">
                                <input type="hidden" name="productid" value="<?php echo $row['id']; ?>">
                                <input type="hidden" name="userid" value="<?php echo $userid; ?>">
                                <input type="hidden" name="cat" value="<?php echo  $category; ?>">
                                <input type="hidden" name="sub" value="<?php echo $subcategory; ?>">
                                <!-- <button type="submit" class="btn btn-primary mt-2  equal-width" name="wishlist" style="--bs-btn-color:black;--bs-btn-bg:none;--bs-btn-border-color:black; --bs-btn-hover-bg:#4c3f31;">
                                    <i class="fa-regular fa-heart"></i>&nbsp;Add to Wishlist
                                </button> -->
                            </form>

                            <!-- Write Review Button -->
                            <!-- <button type="button" class="btn btn-secondary mt-2 equal-width" data-bs-toggle="modal" data-bs-target="#reviewModal<?php echo $row['id']; ?>" style="--bs-btn-color:black;--bs-btn-bg:none;--bs-btn-border-color:black; --bs-btn-hover-bg:#4c3f31;">
                                Write a Review
                            </button> -->

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
                <h2>No Iteam</h2>
            <?php } ?>


        </div>


    

<hr>   
        <section class="recommendations">
          <h5>Share Your Thoughts with Us</h5>
          <br>
     
          <div class="recommendation-form">
            <textarea id="recommendation-text" placeholder="Enter Your Suggestions"></textarea>
            <button id="submit-recommendation">Submit</button>
          </div>
          <div class="recommendation-list">
    <ul>
      </ul>
          </div>
     
        </section>

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

<script>
  const recommendationForm = document.getElementById('recommendation-form');
  const recommendationText = document.getElementById('recommendation-text');
  const submitRecommendationButton = document.getElementById('submit-recommendation');
  const recommendationList = document.querySelector('.recommendation-list');
  
  submitRecommendationButton.addEventListener('click', () => {
    const recommendation = recommendationText.value;
    if (recommendation.trim() !== '') {
      // Send the recommendation to the backend using PHP
      fetch('/submit-recommendation.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `recommendation=${encodeURIComponent(recommendation)}`
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            // Display the recommendation on the page
            const recommendationItem = document.createElement('li');
            recommendationItem.classList.add('recommendation-item');
            recommendationItem.innerHTML = `<p class="recommendation-text">${recommendation}</p>`;
            recommendationList.appendChild(recommendationItem);
            recommendationText.value = '';
          } else {
            alert('Failed to submit recommendation.');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('An error occurred while submitting the recommendation.');
        });
    }
  });

  // Assuming you have a PHP endpoint to fetch suggestions
function fetchPreviousSuggestions() {
   fetch('/fetch-suggestions.php')
    .then(response => response.json())
    .then(suggestions => {
      const suggestionList = document.querySelector('.recommendation-list ul');
      suggestions.forEach(suggestion => {
        const suggestionItem = document.createElement('li');
        suggestionItem.classList.add('recommendation-item');
        suggestionItem.innerHTML = `<p class="recommendation-text">${suggestion}</p>`;
        suggestionList.appendChild(suggestionItem);
      });
    })
    .catch(error => {
      console.error('Error:', error);
    });
}

fetchPreviousSuggestions();
  </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/sidepanel.js"></script>

</body>
</html>
