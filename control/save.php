<?php
session_start();
require '../model/DbConnector.php';
class save{
    
    function card_detailsdb(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve form data with null coalescing operator to handle unset keys
            $card = $_POST['card'] ?? '';       
            $name = $_POST['name'] ?? '';
            $cardNumber = $_POST['cardNumber'] ?? '';
            $expDate = $_POST['expDate'] ?? '';
            $cvv = $_POST['cvv'] ?? '';
            $save = $_POST['save'] ?? '';

            // Check if the save button was clicked
            if ($save == "save" && $card == "card") {
                // Get database connection
                $db = new DbConnector();
                $conn = $db->getConnection();

                // Fetch user_id from the user table (assuming there's only one user)
                $stmt = $conn->prepare("SELECT user_id FROM user WHERE user_id = ?"); // Use WHERE condition if needed
                $stmt->execute(); 
                $userId = $stmt->fetch(PDO::FETCH_ASSOC)['user_id']; // Extract user_id from the associative array
                
                // Prepare the SQL statement with placeholders
                $stmt = $conn->prepare("INSERT INTO card_details (user_id, CardHolderName, CardNumber, ExpDate, cvv) VALUES (?, ?, ?, ?, ?)");

                // Bind the parameters with correct values
                if ($stmt) {
                    $stmt->bindValue(1, $userId, PDO::PARAM_INT);      // user_id
                    $stmt->bindValue(2, $name, PDO::PARAM_STR);        // CardHolderName
                    $stmt->bindValue(3, $cardNumber, PDO::PARAM_STR);  // CardNumber
                    $stmt->bindValue(4, $expDate, PDO::PARAM_STR);     // ExpDate
                    $stmt->bindValue(5, $cvv, PDO::PARAM_STR);         // cvv

                    // Execute the statement
                    if ($stmt->execute()) {
                        echo "Card details saved successfully!";
                    } else {
                        echo "Failed to save card details!";
                    }

                    // Close the statement
                    $stmt->closeCursor();
                } else {
                    echo "Failed to prepare statement!";
                }
            }
        }
        return null;
    }

    function place_orderdb(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve form data with null coalescing operator to handle unset keys
            $fullname = $_POST['name'] ?? '';
            $addres = $_POST['addres'] ?? '';
            $city = $_POST['city'] ?? '';
            $zip = $_POST['zip'] ?? '';
            $district = $_POST['district'] ?? '';
            $province = $_POST['province'] ?? ''; 
    
            // Get database connection
            $db = new DbConnector();
            $conn = $db->getConnection();
    
            // Fetch user_id from the user table (assuming there's only one user)
            $stmt = $conn->prepare("SELECT user_id FROM user WHERE user_id = ?"); // Use WHERE condition if needed
            $stmt->execute();
            $userId = $stmt->fetch(PDO::FETCH_ASSOC)['user_id']; // Extract user_id from the associative array
    
            // Prepare the SQL statement with placeholders
            $stmt = $conn->prepare("INSERT INTO place_order (user_id, FullName, Addres, City, Zip, District, Province) VALUES (?, ?, ?, ?, ?, ?, ?)");
    
            // Bind the parameters with correct values
            if ($stmt) {
                $stmt->bindValue(1, $userId, PDO::PARAM_INT);     // user_id
                $stmt->bindValue(2, $fullname, PDO::PARAM_STR);   // FullName
                $stmt->bindValue(3, $addres, PDO::PARAM_STR);     // Address
                $stmt->bindValue(4, $city, PDO::PARAM_STR);       // City
                $stmt->bindValue(5, $zip, PDO::PARAM_STR);        // Zip
                $stmt->bindValue(6, $district, PDO::PARAM_STR);   // District
                $stmt->bindValue(7, $province, PDO::PARAM_STR);   // Province
    
                // Execute the statement
                if ($stmt->execute()) {
                    echo "Order placed successfully!";
                } else {
                    echo "Failed to place order!";
                }
    
                // Close the statement
                $stmt->closeCursor();
            } else {
                echo "Failed to prepare statement!";
            }
        }
        return null;
    }
}
