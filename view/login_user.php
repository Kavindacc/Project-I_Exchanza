<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/style.css">
    <title>Login</title>
    <style>
        body {
            overflow-x: hidden;
        }
        
        .login-container {
            height:100vh;
            overflow: hidden;
        }
        
        .login-image-section {
            background: linear-gradient(135deg, #897062 0%, #6d5a4d 100%);
            height:100vh ;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        
        .login-image-section::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background-image: url('https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=800');
            background-size: cover;
            background-position: center;
            opacity: 0.3;
        }
        
        .login-image-content {
            position: relative;
            z-index: 1;
            color: white;
            text-align: center;
            padding: 2rem;
        }
        
        .login-image-content h1 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }
        
        .login-image-content p {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        
        .login-form-section {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            height: calc(100vh - 76px);
        }
        
        .password-wrapper {
            position: relative;
        }
        
        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6c757d;
            cursor: pointer;
            padding: 0;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .password-toggle:hover {
            color: #897062;
        }
        
        .form-control-password {
            padding-right: 40px;
        }
        
        .login-card {
            width: 100%;
            max-width: 450px;
        }
        
        .login-header {
            margin-bottom: 2rem;
        }
        
        .login-header h2 {
            color: #897062;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .btn-login {
            background: #897062;
            border: none;
            padding: 12px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-login:hover {
            background: #6d5a4d;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(137, 112, 98, 0.3);
        }
        
        .form-control:focus {
            border-color: #897062;
            box-shadow: 0 0 0 0.2rem rgba(137, 112, 98, 0.25);
        }
        
        .login-links {
            color: #897062;
            text-decoration: none;
        }
        
        .login-links:hover {
            color: #6d5a4d;
            text-decoration: underline;
        }
        
        @media (max-width: 991px) {
            .login-container {
                height: auto;
                overflow: visible;
            }
            
            .login-image-section {
                height: 300px;
                padding: 3rem 1rem;
            }
            
            .login-image-content h1 {
                font-size: 2rem;
            }
            
            .login-form-section {
                height: auto;
                min-height: auto;
            }
        }
        
        @media (max-width: 576px) {
            .login-image-content h1 {
                font-size: 1.5rem;
            }
            
            .login-image-content p {
                font-size: 1rem;
            }
        }
    </style>
</head>

<body>
    <!--nav bar-->
    <nav class="navbar navbar-expand-lg sticky-top nav">
        <div class="container-fluid logo">
            <a class="navbar-brand" href="#"><img src="../img/Exchanza.png" width="100px"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header border-bottom">
                    <h5 class="offcanvas-title " id="offcanvasNavbarLabel">Exchanze</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
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
                            <a class="nav-link" href="#">About us</a>
                        </li>
                    </ul>
                    <div class="d-flex flex-column flex-lg-row float-start  justify-content-center  align-items-center mt-3 mt-lg-0 gap-3">
                        <a href="login_user.php" class=" text-decoration-none"><button class="lo-button btn-sm ms-2 px-3" style="color:#ffff;">login</button></a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="login-container">
        <div class="container-fluid p-0">
            <div class="row g-0">
                <!-- Left Image Section -->
                <div class="col-lg-6 d-none d-lg-block">
                    <div class="login-image-section">
                        <div class="login-image-content">
                            <h1>Welcome to Exchanza</h1>
                            <p>Your trusted marketplace for thrifting and bidding</p>
                            <p class="mt-4"><i class="fas fa-exchange-alt fa-3x"></i></p>
                        </div>
                    </div>
                </div>

                <!-- Right Form Section -->
                <div class="col-lg-6">
                    <div class="login-form-section">
                        <div class="login-card">
                            <div class="login-header text-center">
                                <h2>User Login</h2>
                                <p class="text-muted">Sign in to continue to your account</p>
                            </div>

                            <div class="text-center mb-3">
                                <small>Are you an admin? <a href="login_admin.php" class="login-links">Login as Admin</a></small>
                            </div>

                            <?php if (isset($_GET['error'])) { ?>
                                <div class="alert alert-warning" role="alert">
                                    <?php echo $_GET['error']; ?>
                                </div>
                            <?php } ?>

                            <form action="../control/logincon.php" method="post">
                                <input type="hidden" name="redirect" value="<?php if (isset($_GET['redirect']) && !empty($_GET['redirect'])) {
                                                                                echo $_GET['redirect'];
                                                                            } ?>">
                                <input type="hidden" name="usertype" value="user">

                                <div class="mb-3">
                                    <label class="form-label">Email Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        <input type="email" class="form-control" placeholder="example@gmail.com" name="email" required="">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <div class="password-wrapper">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                            <input class="form-control form-control-password" type="password" name="password" id="password" required>
                                        </div>
                                        <button type="button" class="password-toggle" onclick="togglePassword()">
                                            <i class="fas fa-eye" id="toggleIcon"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <small>No account yet? <a href="signup.php" class="login-links">Join now for free</a></small>
                                </div>

                                <div class="d-grid">
                                    <button class="btn btn-primary btn-login" type="submit" name="signin">
                                        Log In <i class="fas fa-arrow-right ms-2"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Prevent back button
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