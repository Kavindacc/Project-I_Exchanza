<?php

if (isset($_GET['email'])) {
    $email = trim(htmlspecialchars($_GET['email']));
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
    <title>Verification Page</title>
</head>

<body class="d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div style="min-width:50vw;padding:1.6rem;">
        <div class="row pb-2">
            <div class="col-md-10">
                <h3>OTP Verification</h3>
            </div>
        </div>
        <div class="row pb-2">
            <div class="col-md-10">
                <?php if (isset($_GET['error'])) { ?>
                    <strong class=" text-warning"><?php echo $_GET['error']; ?></strong>
                <?php } ?>
            </div>
        </div>
        <form action="../control/verificationcon.php" method="post">
            <div class="row pb-2">
                <input type="hidden" name="email" value="<?php echo $email; ?>">
                <div class="col-md-10">
                    <label>Enter Verification Code</label>
                    <input type="text" class="form-control mt-2" placeholder="ex:XXXXX" name="vcode" required>
                </div>
            </div>
            <div class="row pb-2">
                <div class="col-md-10">
                    <button class="lo-button" type="submit" name="submit" style="color:#ffff;width:100%;">Submit</button>
                </div>
            </div>
        </form>
    </div>
</body>

</html>