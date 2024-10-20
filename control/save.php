<?php
//require '../model/DbConnector.php'; // Make sure this path is correct

class Save {
    
    // Function to save card details into the database
    public function card_detailsdb() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve form data with null coalescing operator to handle unset keys
            $card = $_POST['card'] ?? '';       
            $name = $_POST['name'] ?? '';
            $cardNumber = $_POST['cardNumber'] ?? '';
            $expDate = $_POST['expDate'] ?? '';
            $cvv = $_POST['cvv'] ?? '';
            $save = $_POST['save'] ?? '';

            // Check if the save button was clicked and if card is set
            if ($save === "save") {
                try {
                    // Get the database connection
                    //require '../control/save.php';
                    $db = new DbConnector();
                    $conn = $db->getConnection();
                    
                    // Prepare the SQL statement with placeholders
                    $stmt = $conn->prepare("INSERT INTO card_details (CardHolderName, CardNumber, ExpDate, cvv) VALUES (:name, :cardNumber, :expDate, :cvv)");

                    // Check if preparation was successful
                    if ($stmt) {
                        // Bind the parameters with appropriate types using bindParam
                        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                        $stmt->bindParam(':cardNumber', $cardNumber, PDO::PARAM_STR);
                        $stmt->bindParam(':expDate', $expDate, PDO::PARAM_STR);
                        $stmt->bindParam(':cvv', $cvv, PDO::PARAM_STR);

                        // Execute the statement
                        if ($stmt->execute()) {
                            //echo "Card details saved successfully!";
                        } else {
                            //echo "Failed to execute card details insertion.";
                        }

                        // Close the statement
                        $stmt = null;
                    } else {
                        //echo "Failed to prepare the SQL statement.";
                    }
                    
                    // Close the database connection
                    $conn = null;

                } catch (PDOException $e) {
                    //echo "Error: " . $e->getMessage();
                }
            }
        }
        return null;
    }

    // Function to save place order details into the database
    public function place_orderdb() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve form data with null coalescing operator to handle unset keys
            $userid = $_SESSION['userid'] ?? '';
            $fullname = $_POST['name'] ?? '';
            $addres = $_POST['addres'] ?? '';
            $city = $_POST['city'] ?? '';
            $zip = $_POST['zip'] ?? '';
            $district = $_POST['distric'] ?? '';
            $province = $_POST['province'] ?? ''; 
            $country = $_POST['country'] ?? '';

            try {
                // Get the database connection
                $db = new DbConnector();
                $conn = $db->getConnection();
                
                // Prepare the SQL statement with placeholders
                $stmt = $conn->prepare("INSERT INTO orders (user_id, fullname, address, city, zip, district, province, country) VALUES (:userid, :fullname, :addres, :city, :zip, :district, :province, :country)");

                // Check if preparation was successful
                if ($stmt) {
                    // Bind the parameters with appropriate types using bindParam
                    $stmt->bindParam(':userid', $userid, PDO::PARAM_STR);
                    $stmt->bindParam(':fullname', $fullname, PDO::PARAM_STR);
                    $stmt->bindParam(':addres', $addres, PDO::PARAM_STR);
                    $stmt->bindParam(':city', $city, PDO::PARAM_STR);
                    $stmt->bindParam(':zip', $zip, PDO::PARAM_STR);
                    $stmt->bindParam(':district', $district, PDO::PARAM_STR);
                    $stmt->bindParam(':province', $province, PDO::PARAM_STR);
                    $stmt->bindParam(':country', $country, PDO::PARAM_STR);

                    // Execute the statement
                    if ($stmt->execute()) {
                        //echo "Order placed successfully!";
                    } else {
                        //echo "Failed to execute order placement.";
                    }

                    // Close the statement
                    $stmt = null;
                } else {
                    //echo "Failed to prepare the SQL statement.";
                }
                
                // Close the database connection
                $conn = null;

            } catch (PDOException $e) {
                //echo "Error: " . $e->getMessage();
            }
        }
        return null;
    }
}
