<?php
include_once '../model/DbConnector.php';
include_once '../model/User.php';
include_once '../model/wishlist.php';
include_once '../model/addtocart.php';
include_once '../model/MyOrders.php';
include_once '../model/Order.php';

if (isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid']; ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="../css/style.css">
        <title>User page</title>
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

                            <a href="logout.php" class=" text-decoration-none"><button class="lo-button btn-sm ms-2 px-3 " style="color: #FFFF;">logout</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <h2 class="mt-3 ms-4">Hi, <?php echo  ucwords($_SESSION['name']); ?> </h2>
        <div class="container-fluid py-2">
            <div class="row d-flex  mx-auto ">
                <div class="col-md-3 d-flex flex-column "><!--prifile picture with button-->
                    <?php

                    $dsn = new DbConnector();
                    $con = $dsn->getConnection();

                    $user = new RegisteredCustomer($userid); //manage account
                    $row = $user->accountDetails($con);

                    ?>

                    <?php if (!empty($row['profilepic'])) { ?>
                        <img src="<?php echo htmlspecialchars($row['profilepic']); ?>" class="img-fluid rounded-4 py-2" alt="Profile Picture" style="max-height:300px;">
                    <?php } else { ?>
                        <img src="../img/profile.png" class="img-fluid rounded-4" alt="Default Profile Picture" style="max-height:300px;">
                    <?php } ?>

                    <button type="button" class="btn  my-2" onclick="showInformation()" id="information">Pesonal information</button>
                    <button type="button" class="btn  mb-2" onclick="showOrderTable()" id="order">My Orders</button>
                    <button type="button" class="btn  mb-2" onclick="showOrdersTable()" id="orders">Orders</button><!-- other user bought items-->
                    <button type="button" class="btn  mb-2" onclick="showItemTable()" id="item">My Iteams</button>

                </div>
                <div class="col-md-8 p-4  mx-auto my-5 " id="personalinfo"><!--personal information -->
                    <?php if (isset($_SESSION['success'])) { ?><!--change personal information-->
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong><?php echo $_SESSION['success']; ?></strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php unset($_SESSION['success']);
                    } ?>
                    <?php if (isset($_SESSION['error'])) { ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong><?php echo $_SESSION['error']; ?></strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php unset($_SESSION['error']);
                    } ?>

                    <?php if (isset($_SESSION['psuccess'])) { ?><!--change password-->
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong><?php echo $_SESSION['psuccess']; ?></strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php unset($_SESSION['psuccess']);
                    } ?>
                    <?php if (isset($_SESSION['perror'])) { ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong><?php echo $_SESSION['perror']; ?></strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php unset($_SESSION['perror']);
                    } ?>

                    <form style="margin:25px auto;"><!--from-->
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                                <label for="" class="form-label">First Name</label>
                                <input type="text" class="form-control" placeholder="<?php echo ucfirst($row['firstname']); ?>" name="fname" id="name" disabled>
                            </div>
                            <div class="col-md-6">
                                <label for="" class="form-label">Last Name</label>
                                <input type="text" class="form-control" placeholder="<?php echo ucfirst($row['lastname']); ?>" name="lname" id="name" disabled>
                            </div>

                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                                <label for="" class="form-label">Email</label>
                                <input type="email" class="form-control" placeholder="<?php echo $row['email']; ?>" id="email" name="email" disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" placeholder="<?php echo $row['phonenum']; ?>" name="phoneno" id="phoneno" disabled>
                            </div>

                        </div>

                    </form><!--form end-->

                    <div class="float-sm-end"><button type="button" class="btn btn-outline-warning p-btn m-3" data-bs-toggle="modal" data-bs-target="#changeimgModal" style="--bs-btn-color:#FFFF;--bs-btn-bg:#897062;--bs-btn-border-color:none; --bs-btn-hover-bg:#FFA500;">Change Profile picture</button></div>
                    <div class="modal fade" id="changeimgModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content" style="background:#AE9D92;color:#ffff;">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="changePasswordModalLabel">Change Profile Picture</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="../control/updateimg.php" method="POST" enctype="multipart/form-data"><!--change profile img-->
                                    <input type="hidden" name="userid" value="<?php echo $userid; ?>">
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="confirmNewPassword" class="form-label">Profile Img</label>
                                            <input type="file" class="form-control" name="profilepic" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" name="changeimg" style="--bs-btn-color:#FFFF;--bs-btn-bg:#897062;--bs-btn-border-color:none; --bs-btn-hover-bg:#4c3f31;">Change Profile Img</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Change Password Button -->
                    <div class="float-sm-end"><button type="button" class="btn btn-outline-warning p-btn m-3" data-bs-toggle="modal" data-bs-target="#changePasswordModal" style="--bs-btn-color:#FFFF;--bs-btn-bg:#897062;--bs-btn-border-color:none; --bs-btn-hover-bg:#FFA500;">Change Password</button></div>

                    <!-- Change Password Modal -->
                    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content" style="background:#AE9D92;color:#ffff;">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="../control/changepasswordcon.php" method="POST">
                                    <input type="hidden" name="userid" value="<?php echo $userid ?>">
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="currentPassword" class="form-label">Current Password</label>
                                            <input type="password" class="form-control" id="currentPassword" name="currentPassword" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="newPassword" class="form-label">New Password</label>
                                            <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="confirmNewPassword" class="form-label">Confirm New Password</label>
                                            <input type="password" class="form-control" id="confirmNewPassword" name="confirmNewPassword" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" name="changepassword" style="--bs-btn-color:#FFFF;--bs-btn-bg:#897062;--bs-btn-border-color:none; --bs-btn-hover-bg:#4c3f31;">Change Password</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php


                $rows = $user->browserProducts($con);
                ?>

                <div class="col-md-9 py-2 mt-5 table-responsive overflow-auto" id="itemtable" style="display:none;max-height: 400px;"><!--item table-->
                    <?php if (isset($_SESSION['deletesuccess'])) { ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong><?php echo $_SESSION['deletesuccess']; ?></strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php unset($_SESSION['deletesuccess']);
                    } ?>
                    <?php if (isset($_SESSION['editsuccess'])) { ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong><?php echo $_SESSION['editsuccess']; ?></strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php unset($_SESSION['editsuccess']);
                    } ?>

                    <?php if ($rows) { ?>
                        <table class="table table-striped table-hover table-sm">
                            <thead>
                                <tr class="table-primary">
                                    <th scope="col">Image</th>
                                    <th scope="col">Product_Name</th>
                                    <th scope="col">Price(Rs.)</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Subcategory</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rows as $row) {
                                    $modalId = "staticBackdrop" . $row['itemid'];
                                    $editModalId = "editModal" . $row['itemid'];
                                ?>
                                    <tr class="vertical-center">
                                        <td><img src="<?php echo $row['coverimage']; ?>" class="table-image"></td>
                                        <td><?php echo ucwords($row['itemname']); ?></td>
                                        <td><?php echo $row['price']; ?></td>
                                        <td><?php echo ucfirst($row['category']); ?></td>
                                        <td><?php echo ucfirst($row['subcategory']); ?></td>
                                        <td>
                                            <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#<?php echo $editModalId; ?>" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .9rem; --bs-btn-font-size: .75rem;">
                                                Edit
                                            </button>
                                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#<?php echo $modalId; ?>" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .6rem; --bs-btn-font-size: .75rem;">
                                                Delete
                                            </button>
                                            <!-- Modal edit -->
                                            <div class="modal fade" id="<?php echo $editModalId; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="<?php echo $editModalId; ?>Label" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content" style="background:#AE9D92;color:#ffff;">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="<?php echo $editModalId; ?>Label">Edit Product</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="../control/edititemcon.php" method="POST" enctype="multipart/form-data">
                                                                <input type="hidden" name="productid" value="<?php echo $row['itemid']; ?>">
                                                                <div class="mb-3">
                                                                    <label for="product_name" class="form-label">Product Name</label>
                                                                    <input type="text" class="form-control" name="product_name" value="<?php echo ucwords($row['itemname']); ?>" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="price" class="form-label">Price</label>
                                                                    <input type="text" class="form-control" name="price" value="<?php echo $row['price']; ?>" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="image" class="form-label">Product Image</label>
                                                                    <input type="file" class="form-control" name="image">
                                                                    <input type="hidden" name="current_image" value="<?php echo $row['coverimage']; ?>">
                                                                </div>
                                                                <button type="submit" class="btn btn-primary" name="edit" style="--bs-btn-color:#FFFF;--bs-btn-bg:#897062;--bs-btn-border-color:none; --bs-btn-hover-bg:#4c3f31;">Save changes</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal delete -->
                                            <div class="modal fade" id="<?php echo $modalId; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="<?php echo $modalId; ?>Label" aria-hidden="true">
                                                <div class="modal-dialog  modal-sm">
                                                    <div class="modal-content" style="background:#AE9D92;color:#ffff;">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title fs-5" id="<?php echo $modalId; ?>Label">Do you Want to Delete?<strong><?php echo ucwords($row['itemname']); ?></strong></h4>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <form action="../control/deleteitem.php" method="post">
                                                                <input type="hidden" name="productid" value="<?php echo $row['itemid']; ?>">
                                                                <button type="submit" class="btn btn-danger" name="delete">Delete</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>


                    <?php } else { ?>
                        <h2>No Items Yet</h2>
                    <?php } ?>
                </div>

                <div class="col-md-9 py-2 mt-5 table-responsive overflow-auto" id="producttable" style="display:none;max-height: 400px;"><!--my order table-->
                    <?php if (!empty($_GET['s'])) {
                        if ($_GET['s'] == 1) { ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Order Confirm Success</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                    <?php }
                    } ?>
                    <?php
                    $obj = new MyOrders($userid);
                    $rows = $obj->getOrderDetails($con);
                    if (!empty($rows)) { ?>
                        <table class="table table-striped table-hover table-sm">
                            <thead>
                                <tr class="table-primary">
                                    <th scope="col">Image</th>
                                    <th scope="col">Product Name</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Tracking Number</th>
                                    <th scope="col">Order Confirm</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rows as $row) { ?>
                                    <tr class="vertical-center">
                                        <td><img src="<?php echo $row['coverimage']; ?>" class="table-image"></td>
                                        <th scope="row"><?php echo $row['itemname']; ?></th>
                                        <td><?php echo $row['price']; ?></td>
                                        <td><?php echo $row['order_date']; ?></td>
                                        <td><?php echo $row['trackingnum']; ?></td>
                                        <td>
                                            <!-- Confirm button triggers the modal -->
                                            <?php if ($row['order_status'] == 0) { ?>
                                                <button type="button" class="btn btn-outline-success" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .9rem; --bs-btn-font-size: .75rem;"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#confirmModal"
                                                    data-orderid="<?php echo $row['order_id']; ?>"
                                                    data-itemname="<?php echo $row['itemname']; ?>">
                                                    Confirm Order Received
                                                </button>

                                            <?php } else { ?>
                                                <button type="button" class="btn btn-success disabled" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .9rem; --bs-btn-font-size: .75rem;">
                                                    Recived
                                                </button>
                                            <?php } ?>

                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } else { ?>
                        <h2>No Bought Items</h2>
                    <?php } ?>
                    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true"><!--model confirm-->
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="confirmModalLabel">Confirm Order</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <!-- Form confirm -->
                                <form action="../control/confirm_order.php" method="POST" id="confirmOrderForm">
                                    <div class="modal-body">
                                        Are you sure you want to confirm the order for <strong id="modalItemName"><?php echo $row['itemname']; ?></strong>?
                                        <input type="hidden" name="orderid" id="modalOrderId" value=<?php echo $row['order_id']; ?>>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-success">Confirm Order</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-9 py-2 mt-5 table-responsive overflow-auto" id="ordertable" style="display:none;max-height: 400px;"><!--orders table-->
                    <?php if (!empty($_GET['s']) && $_GET['s'] == 1) { ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Order Confirmed Successfully</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } ?>
                    <?php if (!empty($_GET['d']) && $_GET['d'] == 1) { ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Order Canceled</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } ?>

                    <!-- Fetch and Display Orders -->
                    <?php
                    $obj = new Orders($userid);
                    $rows = $obj->getOrderDetails($con);
                    if (!empty($rows)) { ?>
                        <table class="table table-striped table-hover table-sm">
                            <thead>
                                <tr class="table-primary">
                                    <th scope="col">Order ID</th>
                                    <th scope="col">Product Name</th>
                                    <th scope="col">Price (Rs.)</th>
                                    <th scope="col">Customer Name</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rows as $row) {
                                    $cancelModalId = "cancelModal" . $row['order_id'];
                                    $confirmModalId = "confirmModal" . $row['order_id'];
                                ?>
                                    <tr>
                                        <td><?php echo $row['order_id']; ?></td>
                                        <td><?php echo ucwords($row['itemname']); ?></td>
                                        <td><?php echo $row['price']; ?></td>
                                        <td><?php echo ucfirst($row['firstname'])." ".ucfirst($row['lastname']); ?></td>
                                        <td><?php echo $row['order_date']; ?></td>
                                        <td>
                                            <?php if ($row['confirm'] == 0) { ?>
                                                <!-- Confirm Button -->
                                                <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#<?php echo $confirmModalId; ?>">
                                                    Confirm
                                                </button>
                                                <!-- Cancel Button -->
                                                <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#<?php echo $cancelModalId; ?>">
                                                    Cancel
                                                </button>

                                                <!-- Confirm Modal -->
                                                <div class="modal fade" id="<?php echo $confirmModalId; ?>" tabindex="-1" aria-labelledby="<?php echo $confirmModalId; ?>Label" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content" style="background:#AE9D92; color:#fff;">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="<?php echo $confirmModalId; ?>Label">Confirm Order</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Do you want to confirm the order for <strong><?php echo ucwords($row['itemname']); ?></strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form action="../control/confirm_seller_orders.php" method="post">
                                                                    <input type="hidden" name="orderid" value="<?php echo $row['order_id']; ?>">
                                                                    <button type="submit" class="btn btn-success">Confirm Order</button>
                                                                </form>
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Cancel Modal -->
                                                <div class="modal fade" id="<?php echo $cancelModalId; ?>" tabindex="-1" aria-labelledby="<?php echo $cancelModalId; ?>Label" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content" style="background:#AE9D92; color:#fff;">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="<?php echo $cancelModalId; ?>Label">Cancel Order</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure you want to cancel the order for <strong><?php echo ucwords($row['itemname']); ?></strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form action="../control/Delete_order.php" method="post">
                                                                    <input type="hidden" name="orderid" value="<?php echo $row['order_id']; ?>">
                                                                    <button type="submit" class="btn btn-danger">Cancel Order</button>
                                                                </form>
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } else { ?>
                                                <!-- Confirmed Button -->
                                                <button type="button" class="btn btn-success btn-sm" disabled>
                                                    Confirmed
                                                </button>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } else { ?>
                        <h2>No Items Yet</h2>
                    <?php } ?>
                </div>

            </div>

        </div>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
        <script src="../js/main.js"></script>
    </body>

    </html>
<?php } else {
    header("Location:login_user.php");
    exit();
} ?>