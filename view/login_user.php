<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/style.css">
    <title>Login</title>
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
                            <a class="nav-link " aria-current="page" href="../index.php">Home</a>
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
                    <div class="d-flex flex-column flex-lg-row float-start  justify-content-center  align-items-center mt-3 mt-lg-0 gap-3">
                        <a href="login_user.php" class=" text-decoration-none"><button class="lo-button btn-sm ms-2 px-3" style="color:#ffff;">login</button></a>

                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div class="d-flex justify-content-center align-items-center" style="height:80vh;">
        <div class="container py-2">
            <div class="row text-center pb-3">
                <h2>User Login</h2>
            </div>
            <div class="row justify-content-center pb-2">
                <div class="col-md-8 col-lg-5">
                    Are you an admin? <a href="login_admin.php">Login as Admin</a>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-5">
                    <?php if (isset($_GET['error'])) { ?>
                        <strong class="text-warning "><?php echo $_GET['error']; ?></strong>
                    <?php } ?>
                </div>

            </div>
            <form action="../control/logincon.php" method="post">
                <input type="hidden" name="redirect" value="<?php if (isset($_GET['redirect']) && !empty($_GET['redirect'])) {
                                                                echo $_GET['redirect'];
                                                            } ?>">
                <input type="hidden" name="usertype" value="user">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-5">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-control" placeholder="example@gmail.com" name="email" required="">
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-5">
                        <label class="form-label">Password</label>
                        <input class="form-control" type="password" name="password" required>
                    </div>
                </div>

                <div class="row justify-content-center mt-2">
                    <div class="col-md-8 col-lg-5"><!--<a href="forgetpassword.php">forget password</a>-->No account yet? <a href="signup.php">Join now for free</a></div>
                </div>
                <div class="row justify-content-center mt-2">
                    <div class="col-md-8 col-lg-5 login-btn">
                        <input class="btn btn-primary w-100" type="submit" value="Sign In" name="signin" style="background:#897062;border:none;">
                    </div>
                </div>
            </form>
        </div>
    </div>



    <!--prevent backbutton-->
    <script type="text/javascript">
        function preventback() {
            window.history.forward()
        };
        setTimeout("preventback()", 0);
        window.onunload = function() {
            null
        };
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>