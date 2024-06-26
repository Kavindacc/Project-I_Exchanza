<?php

require '../model/products.php';

//product.php add karanna ,nmut product.php change karanna one
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
    <title>User page</title>
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
                            <a class="nav-link" href="../view/thrift.php">Thrift</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link" href="#">Bidding</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link" href="#">Selling</a>
                        </li>
                    </ul>
                    <!--login nav-link-a-color-->
                    <div class="d-flex flex-column float-start flex-lg-row justify-content-center  align-items-center mt-3 mt-lg-0 gap-3">
                        <a href="../Project-I_Exchanza/view/cart.php" class="nav-link  text-decoration-none mx-1"><i class="fa-solid fa-cart-plus"><span></span></i></a>
                        <?php
                        if (isset($_SESSION['logedin']) && $_SESSION['logedin'] === true) { ?>
                            <a href="logout.php" class=" text-decoration-none"><button class="lo-button btn-sm ms-2 px-3 " style="color: #FFFF;">logout</button></a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </nav>


    <h2 class="mt-3 ms-4">Hi, <?php echo  $_SESSION['username']; ?> </h2>


    <div class="container-fluid py-2">
        <div class="row d-flex  mx-auto ">
            <div class="col-sm-3 d-flex flex-column "><!--prifile picture with button-->

                <?php if (isset($_SESSION['profilepic']) && !empty($_SESSION['profilepic'])) { ?>
                    <img src="<?php echo htmlspecialchars($_SESSION['profilepic']); ?>" class="img-fluid rounded-4 py-2" alt="Profile Picture" style="max-height:300px;">
                <?php } else { ?>
                    <img src="../img/profile.png" class="img-fluid rounded-4" alt="Default Profile Picture" style="max-height:300px;">
                <?php } ?>

                <button type="button" class="btn  my-2" onclick="showInformation()" id="information">Pesonal information</button>
                <button type="button" class="btn  mb-2" onclick="showOrderTable()" id="order">My Orders</button>
                <button type="button" class="btn  " onclick="showItemTable()" id="item">My Iteams</button>

            </div>
            <div class="col-sm-8 py-2  mx-auto mt-5 " id="personalinfo"><!--personal information -->
                <?php if (isset($_GET['success'])) {
                    echo $_GET['success'];
                }
                if (isset($_GET['error'])) {
                    echo $_GET['error'];
                } ?>
                <?php

                $obj = new User();
                $row = $obj->getInformation($_SESSION['userid']);

                ?>
                <form action="../control/updatepersonalinfocon.php" method="post" enctype="multipart/form-data"><!--from-->
                    <div class="row mb-3">
                        <div class="col">
                            <label for="" class="form-label">Full Name</label>
                            <input type="text" class="form-control" placeholder="<?php echo $row['name']; ?>" name="name" disabled>
                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <label for="" class="form-label">Email</label>
                            <input type="email" class="form-control" placeholder="<?php echo $row['email']; ?>" name="email" disabled>
                        </div>
                        <div class="col-sm-6">
                            <label for="" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" placeholder="<?php echo $row['phoneno']; ?>" name="phoneno" disabled>
                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <label for="" class="form-label">Gender</label>
                            <input class="form-control" type="text" id="" name="gender" placeholder="<?php echo $row['gender']; ?>" disabled>
                        </div>
                        <div class="col-sm-6">
                            <label for="" class="form-label">Profile Picture</label>
                            <input class="form-control" type="file" id="profile" name="profilepic" disabled>
                        </div>
                    </div>
                    <div class="float-sm-end"><button type="submit" class="btn btn-outline-success" id="update" name="update"style="--bs-btn-color:#FFFF;--bs-btn-bg:#897062;--bs-btn-border-color:none; --bs-btn-hover-bg:#4c3f31;">Update</button></div>

                </form><!--form end-->
                <div class="float-sm-end"><button type="button" class="btn btn-outline-success" id="edit" onclick="edit();"style="--bs-btn-color:#FFFF;--bs-btn-bg:#897062;--bs-btn-border-color:none; --bs-btn-hover-bg:#4c3f31;">Add Profile Picture</button><!--edit button--></div>

            </div>
            <div class="col-sm-9 py-2 mt-5" id="itemtable" style="display:none;"><!--iteam table-->
                <?php
                $obj = new Products(); // product get product table according to userid
                $rows = $obj->get($_SESSION['userid']);
                if ($rows != null) {
                ?>
                    <table class="table table-striped table-hover table-sm">
                        <thead >
                            <tr class="table-primary">
                                <th scope="col">Product_Id</th>
                                <th scope="col">Product_Name</th>
                                <th scope="col">Image</th>
                                <th scope="col">Price</th>
                                <th scope="col">Category</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            foreach ($rows as $row) {
                                $modalId = "staticBackdrop" . $row['product_id'];
                            ?>
                                <tr class="vertical-center">
                                    <td><?php echo $row['product_id']; ?></td>
                                    <td><?php echo $row['product_name']; ?></td>
                                    <td><img src="<?php echo $row['image']; ?>" class="table-image"></td>
                                    <td><?php echo $row['price']; ?></td>
                                    <td><?php echo $row['category']; ?></td>
                                    <td>
                                        <button type="submit" class="btn btn-outline-success" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .9rem; --bs-btn-font-size: .75rem;"> Edit</button>&nbsp;&nbsp;
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#<?php echo $modalId; ?>" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .6rem; --bs-btn-font-size: .75rem;">
                                            Delete
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="<?php echo $modalId; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="<?php echo $modalId; ?>Label" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-sm">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="<?php echo $modalId; ?>Label">Do you Want to Delete?</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <form action="../control/deleteitem.php" method="post">
                                                            <input type="hidden" name="productid" value="<?php echo $row['product_id']; ?>">
                                                            <button type="submit" class="btn btn-danger" name="delete">
                                                                Delete
                                                            </button>
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
                    <h2>No Add Iteams Yet</h2>
                <?php } ?>

            </div>
            <div class="col-sm-9 py-2 mt-5" id="producttable" style="display:none;"><!--order table-->
                <table class="table  table-striped table-hover table-sm">
                    <thead>
                        <tr class="table-primary">
                            <th scope="col">Product_Id</th>
                            <th scope="col">Product_Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Category</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                            <td><button type="button" class="btn btn-outline-success" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .9rem; --bs-btn-font-size: .75rem;"> Edit</button>&nbsp;&nbsp;
                                <button type="button" class="btn btn-outline-danger" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .6rem; --bs-btn-font-size: .75rem;"> Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="main.js"></script>
    <script type="text/javascript">
        function preventback() {
            window.history.forward()
        };
        setTimeout("preventback()", 0);
        window.onunload = function() {
            null
        };
    </script>
</body>

</html>