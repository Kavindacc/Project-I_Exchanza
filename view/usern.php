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
        <title>Profile Page</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link rel="stylesheet" href="../css/stylen.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    </head>

    <body>

        <!--nav bar-->
        <div class="containe">
            <nav class="sidebar">
                <div class="profile-section">
                    <?php

                    $dsn = new DbConnector();
                    $con = $dsn->getConnection();

                    $user = new RegisteredCustomer($userid); //manage account
                    $row = $user->accountDetails($con);

                    ?>

                    <?php if (!empty($row['profilepic'])) { ?>
                        <img src="<?php echo htmlspecialchars($row['profilepic']); ?>" class="img-fluid rounded-4 py-2" alt="Profile Picture" id="profile-img">
                    <?php } else { ?>
                        <img src="../img/profile.png" class="img-fluid rounded-4" alt="Default Profile Picture" id="profile-img">
                    <?php } ?>

                    <button id="change-img-btn" data-bs-toggle="modal" data-bs-target="#changeimgModal">
                        <i class="fas fa-camera"></i>
                        <span>Change Image</span>
                    </button>

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
                </div>
                <ul class="nav-links">
                    <li><a href="#personal-info"><i class="fas fa-user"></i> Personal Information</a></li>
                    <li><a href="#my-orders"><i class="fas fa-box"></i> My Orders</a></li>
                    <li><a href="#my-items"><i class="fas fa-th-list"></i> My Items</a></li>
                    <li><a href="#orders"><i class="fas fa-shopping-cart"></i> Orders</a></li>
                    <li><a href="#logout"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </nav>


            <div class="content">
                <!-- Personal Information Section -->
                <section id="personal-info" class="section" style="margin-top:30px;">
                    <h2>Personal Information</h2>
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
                    <form>
                        <label for="fname">First Name</label>
                        <input type="text" class="form-control" placeholder="<?php echo ucfirst($row['firstname']); ?>" name="fname" id="fname">

                        <label for="lname">Last Name</label>
                        <input type="text" class="form-control" placeholder="<?php echo ucfirst($row['lastname']); ?>" name="lname" id="lname">

                        <label for="email">Email</label>
                        <input type="email" class="form-control" placeholder="<?php echo $row['email']; ?>" id="email" name="email">

                        <label for="phone">Phone</label>
                        <input type="tel" class="form-control" placeholder="<?php echo $row['phonenum']; ?>" name="phoneno" id="phoneno">

                        <div style="display: flex; gap: 10px; margin-top: 10px;">
                            <button type="submit">Save</button>
                            <button type="submit">Cancel</button>
                        </div>
                    </form>

                </section>

                <!-- My Orders Section -->
                <section id="my-orders" class="section">
                    <h2>My Orders</h2>
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
                </section>

                <!-- Orders Section -->
                <section id="orders" class="section">
                    <h2>My Orders</h2>
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
                                        <td><?php echo ucfirst($row['firstname']) . " " . ucfirst($row['lastname']); ?></td>
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
                </section>

                <!-- My Items -->
                <section id="my-items" class="section">
                    <?php
                    $rows = $user->browserProducts($con);
                    ?>
                    <h2>My Orders</h2>
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
                </section>


            </div>
        </div>
        </div>

        <script src="../js/script.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    </body>

    </html>
<?php } else {
    header("Location:login_user.php");
    exit();
} ?>