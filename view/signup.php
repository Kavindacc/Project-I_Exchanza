<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/style.css">
    <title>Signup</title>
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
                            <a class="nav-link" href="#">Thrift</a>
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

                        <a href="view/login.php" class="nav-link  text-decoration-none mx-1"><i class="fa-solid fa-cart-plus position-relative"><span class="position-absolute translate-middle badge rounded-pill bg-danger sp"></span></i></a><!--addtocart-->
                        <a href="view/login.php" class="nav-link  text-decoration-none mx-1"><i class="fa-regular fa-heart position-relative"></i></a>
                        <a href="login_user.php" class=" text-decoration-none"><button class="lo-button btn-sm ms-2 px-3" style="color:#ffff;">login</button></a>

                    </div>
                </div>
            </div>
        </div>
    </nav>
    <!--register form-->
    <div class="container-fluid d-flex align-items-center regi" style="min-height: 90vh;">
        <div class="container">
            <div class="row pb-1">
                <div class="col text-center">
                    <h2>Create Account</h2>
                </div>
            </div>
            <div class="row d-flex justify-content-center pb-1">
                <div class="col-md-8">
                    <?php if (isset($_GET['error'])) { ?>
                        <strong class="col-12 text-warning"><?php echo $_GET['error']; ?></strong>
                    <?php } ?>
                </div>
            </div>
            <form action="../control/signupcon.php" method="post"><!--register form-->
                <div class="row d-flex justify-content-center pb-2">
                    <div class="col-md-4">
                        <label class="form-label">First name</label>
                        <input type="text" class="form-control" placeholder="First name" name="fname" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Last name</label>
                        <input type="text" class="form-control" placeholder="Last name" name="lname" required>
                    </div>

                </div>
                <div class="row d-flex justify-content-center pb-2">
                    <div class="col-md-4">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-control" placeholder="example@gmail.com" name="email" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Gender</label>
                        <select class="form-select" aria-label="Default select example" name="gender" required>
                            <option value="" disabled selected hidden>--Select Gender--</option>
                            <option value="1">Male</option>
                            <option value="2">Female</option>
                        </select>
                    </div>
                    
                </div>
                <div class="row d-flex justify-content-center pb-2">
                    <div class="col-md-4">
                        <label class="form-label">Country</label>
                        <select class="form-select" aria-label="Default select example" name="country" required>
                            <option value="" disabled selected hidden>--Select Country--</option>
                            <option value="sl">Sri lanka</option>
                            <option value="uk">Uk</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Phone number</label>
                        <input type="tel" class="form-control" name="pnum" placeholder="">
                    </div>
                    
                </div>
                <div class="row d-flex justify-content-center pb-3">
                   
                    <div class="col-md-4">
                        <label class="form-label">Password</label>
                        <input class="form-control" type="password" name="password" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Repeat password</label>
                        <input class="form-control" type="password" name="rpassword" required>
                    </div>
                </div>
                <div class="row d-flex justify-content-center pb-2">
                    <div class="col-md-8" >
                        <input class="btn btn-primary w-100 " type="submit" value="Register" name="register" style="background:#897062;border:none;">
                    </div>
                </div>
                <div class="row pt-2">
                    <div class="col text-center">
                        <p>alredy have account<a href="login_user.php"> login in</a></p>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>