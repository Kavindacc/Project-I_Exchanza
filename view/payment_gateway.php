<?php
include_once '../model/DbConnector.php';
//include_once '../control/save.php';
include_once '../model/addtocart.php';
//include_once '../view/addtocart.php';


session_start();


class PaymentGateway
{

    private $userid;
    public $country = null;

    public function __construct()
    {
        if (isset($_SESSION['userid'])) {
            $this->userid = $_SESSION['userid'];
        }
    }

    public function displayPaymentForm()
    {
?>
        <!DOCTYPE html>
        <html>

        <head>
            <meta charset='utf-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1'>
            <title>Payment</title>
            <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' rel='stylesheet'>
            <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet'>
            <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
            <link rel="stylesheet" href="../css/payment_gateway.css">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
            <link rel="stylesheet" href="css/style.css">
            <script type='text/javascript' src='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js'></script>
            <script type='text/javascript' src='#'></script>
            <script type='text/javascript' src='#'></script>
            <script type='text/javascript' src='#'></script>
            <script type='text/javascript'></script>
        </head>

        <body className='snippet-body'>
            <div class="card">
                <div class="card-top border-bottom text-center">
                    <a href="addtocart.php">
                        <h5> Back to cart </h5>
                    </a>
                    <span id="logo"></span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="left border">
                                <form method="POST" action="payment_gateway.php">
                                    <lable for="name">Full name: </lable><br>
                                    <input type="text" name="name" id="name" required><br>
                                    <lable for="addres">Address: </lable><br>
                                    <input type="text" name="addres" id="addres" required><br>
                                    <lable for="city">City: </lable><br>
                                    <input type="text" name="city" id="city" required><br>
                                    <lable for="zip">Zip: </lable><br>
                                    <input type="text" name="zip" id="zip" required><br>
                                    <lable for="district">District: </lable><br>
                                    <select name="district" id="district" required>
                                        <option value="Colombo">Colombo</option>
                                        <option value="Gampaha">Gampaha</option>
                                        <option value="Kalutara">Kalutara</option>
                                        <!-- Add the remaining options -->
                                    </select><br>
                                    <lable for="province">Province: </lable><br>
                                    <select name="province" id="province" required>
                                        <option value="Central">Central</option>
                                        <option value="Eastern">Eastern</option>
                                        <!-- Add the remaining options -->
                                    </select><br>
                                    <lable for="province">Country: </lable><br>
                                    <select name="country" id="country" required>
                                        <option value="srilanka">Sri Lanka</option>
                                        <option value="india">India</option>
                                        <!-- Add the remaining options -->
                                    </select><br><br>
                                    <ul class="list-unstyled components mb-5">
                                        <li class="active">
                                            <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><span class="header">
                                                    <div class="header">Card Payment &nbsp</div>
                                                </span></a>
                                            <ul class="collapse list-unstyled" id="homeSubmenu">
                                                <li>

                                                    <div class="row">
                                                        <div class="icons">
                                                            <img src="https://img.icons8.com/color/48/000000/visa.png" />
                                                            <img src="https://img.icons8.com/color/48/000000/mastercard-logo.png" />
                                                            <img src="https://img.icons8.com/color/48/000000/maestro.png" />
                                                        </div>
                                                    </div>
                                                    <span>Cardholder's name:</span>
                                                    <input type="text" name="name2" placeholder="Geeth Liyanage" required autocomplete="on">
                                                    <span>Card Number:</span>
                                                    <input type="text" name="cardNumber" placeholder="0125 6780 4567 9909" required autocomplete="on">
                                                    <div class="row">
                                                        <div class="col-md-5"><span>Expiry date:</span>
                                                            <input type="text" name="expDate" placeholder="YY-MM" required autocomplete="on">
                                                        </div>
                                                        <div class="col-md-5"><span>CVV:</span>
                                                            <input type="text" name="cvv" id="cvv" required autocomplete="on">
                                                        </div>
                                                    </div>
                                                    <input type="checkbox" id="saveCard" class="align-left" name="save" value="save">
                                                    <label for="save_card">Save card details to wallet</label>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>

                                    <div>
                                        <span id="error_msg" class="text-danger"></span>
                                    </div>




                                    <input type="submit" value="Submit" class="btn btn-primary">

                            </div>
                        </div>

                        <div id="summary" class="col-md-5">
                            <div class="right border">
                                <div class="header">Order Summary</div>
                                <hr>
                                <span class="item">
                                    <?php
                                    $this->displayCartItems();
                                    ?>
                                </span>

                                <hr>

                                <div class="row lower">
                                    <div class="col text-left">Subtotal</div>
                                    <div class="col text-right"><span id="cart-subtotal"><?php $this->displayTotal(); ?></span></div>
                                </div>

                                <div class="row lower">
                                    <div class="col text-left">Delivery</div>
                                    <div class="col text-right"><span id="delivery"><?php echo $this->displayDeleveryfee(); ?></span></div>
                                </div>

                                <div id="totalpay" class="row lower">
                                    <div class="col text-left"><b>Total to pay</b></div>
                                    <div class="col text-right"><b><span id="cart-total"><?php $this->displaySubTotal(); ?></span></b></div>
                                </div>

                                <hr>

                                <input type="button" value="Buy now" class="btn btn-primary" onclick="errormsg()">

                                <p class="text-muted text-center">Complimentary Shipping & Returns</p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <?php
            // Database connection
            //require '../control/save.php';
            require '../control/validation.php';

            $val = new validateCardDetails();
            $validationResult = $val->validation();

            ?>

            <script>
                // updateCartTotal();

                // var myLink = document.querySelector('a[href="#"]');
                // myLink.addEventListener('click', function(e) {
                // e.preventDefault();
                // });

                function errormsg() {

                    if (("<?php echo $validationResult; ?>" != 1)) {

                        document.getElementById("error_msg").innerHTML = "<?php echo $validationResult; ?>";

                    } else {
                        doPayment();
                    }


                }

                function doPayment() {
                        var message = "Payment Successful.";
                        alert(message);
                        <?php
                        $cardDetails = new validateCardDetails();
                        // Call the validation method
                        $validationResult = $cardDetails->validation();

                        // Check the validation result and output it
                        if ($validationResult === true) {
                            $po = new Save();
                            $po->place_orderdb();
                            $po->card_detailsdb();
                        }
                        ?>
                        window.location.href = "http://localhost/Exchanza/index.php";
                    }
                
            </script>

        </body>

        </html>
<?php
    }

    private function displayCartItems()
    {

        $obj = new Cart();
        $obj->setUserId($this->userid);
        $obj2 = new DbConnector();
        $con = $obj2->getConnection();
        $rows = $obj->cartItemDetails($con);




        if (!empty($rows)) {
            $i = 0;
            foreach ($rows as $row) {
                $itemid = $row['itemid'];


                echo "
                <table>
                    <tr>
                        <div class='col-6 align-self-center'>
                            <img class='img-fluid' src='{$row['coverimage']}'>
                        </div>
                    </tr>
                    <div class='col-8'>
                        <tr><b>Unit price : </b>Rs.{$row['price']}</tr><br>
                        <tr><b>Unit name : </b>{$row['itemname']}</tr><br>
                    </div>
                </table>
                <hr>";
            }
            try {

                $quantity = 1;

                // Get the database connection
                $db = new DbConnector();
                $conn = $db->getConnection();

                $stmt = $conn->prepare("SELECT order_id FROM orders ORDER BY order_id DESC LIMIT 1");
                $stmt->execute();


                $result = $stmt->fetch(PDO::FETCH_ASSOC);


                $orderid = $result['order_id'];

                //echo $orderid;
                //echo $itemid;
                //echo $row['price'];

                $db = new DbConnector();
                $conn = $db->getConnection();

                // Prepare the SQL statement with placeholders
                $stmt = $conn->prepare("INSERT INTO order_item (item_id, order_id, quantity, price) VALUES (:itemid, :orderid, :quantity, :price)");

                // Check if preparation was successful
                if ($stmt) {
                    // Bind the parameters with appropriate types using bindParam
                    $stmt->bindParam(':itemid', $itemid, PDO::PARAM_INT);
                    $stmt->bindParam(':orderid', $orderid, PDO::PARAM_INT);
                    $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
                    $stmt->bindParam(':price', $row['price'], PDO::PARAM_STR); // price should remain as STR since it can have decimal values

                    // Execute the statement
                    if ($stmt->execute()) {
                        //echo "Order placed successfully!";
                    } else {
                        //echo "Failed to execute order placement.";
                    }

                    // Close the statement
                    $stmt = null;
                } else {
                    echo "Failed to prepare the SQL statement.";
                }


                // Close the database connection

            } catch (PDOException $e) {
                //echo "Error: " . $e->getMessage();
            }
        }
    }

    private function displayTotal()
    {

        $obj = new Cart();
        $obj->setUserId($this->userid);
        $obj2 = new DbConnector();
        $con = $obj2->getConnection();
        $rows = $obj->cartItemDetails($con);
        $total = 0;

        if (!empty($rows)) {
            $i = 0;
            foreach ($rows as $row) {
                $total += $row['price'];
            }
        }
        echo $total;
    }

    private function displaySubTotal()
    {

        $obj = new Cart();
        $obj->setUserId($this->userid);
        $obj2 = new DbConnector();
        $con = $obj2->getConnection();
        $rows = $obj->cartItemDetails($con);
        $total = 0;
        $deleveryfee = $this->displayDeleveryfee();

        if (!empty($rows)) {
            $i = 0;
            foreach ($rows as $row) {
                $total += $row['price'];
            }
        }
        $subtotal = $total + $deleveryfee;
        echo $subtotal;
    }

    private function displayDeleveryfee()
    {

        $obj = new Cart();
        $obj->setUserId($this->userid);
        $obj2 = new DbConnector();
        $con = $obj2->getConnection();
        $rows = $obj->cartItemDetails($con);
        $deleveryfee = 0;
        if (isset($_POST['country'])) {
            $country = $_POST['country'];
        } else {
            $country = 'srilanka';
        }


        if ($country == 'srilanka') {
            $deleveryfee = 350;
        } else if ($country == 'india') {
            $deleveryfee = 1000;
        } else {
            $deleveryfee = 0;
        }
        return $deleveryfee;
    }
}

// Create an instance of PaymentGateway and display the form
$paymentGateway = new PaymentGateway();
$paymentGateway->displayPaymentForm();
?>