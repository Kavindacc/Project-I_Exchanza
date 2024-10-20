<?php

require_once '../stripe-php-master/stripe-php-master/init.php';
$stripedetails= array(
    "publishabelKey"=>"pk_test_51QBzFrP2evlv58Yf56SdZUikI0JXYA50I2BZWXv1WDVxSmHaLlKOxBtD6ZYClk78pF0sfc8AovLsNS12xqnuRFZ100uLviMoQ0",
    "secretKey"=>"sk_test_51QBzFrP2evlv58YfwN4hskjlXCy0IP1a3rHH4Ah2jMgNKS2mGh7xgPPHMfZrVVlEk9Wq9ODXPU4bCeSapmA2h7pB00BsRB3s3j"
);

\Stripe\stripe::setApiKey($stripedetails["secretKey"]);

?>