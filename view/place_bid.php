<?php
// Prevent any output before JSON
error_reporting(0); // Suppress error messages
ini_set('display_errors', 0);

// Set JSON header
header('Content-Type: application/json');

require_once '../model/DbConnector.php';

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Validate input
        if (!isset($_POST['auction_id']) || !isset($_POST['bid_price']) || !isset($_POST['userid'])) {
            echo json_encode(['status' => 'error', 'message' => 'Missing required fields.']);
            exit();
        }

        $auction_id = $_POST['auction_id'];
        $bid_price = $_POST['bid_price'];
        $userid = $_POST['userid'];

        // Validate bid price is numeric and positive
        if (!is_numeric($bid_price) || $bid_price <= 0) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid bid price.']);
            exit();
        }

        $dsn = new DbConnector();
        $pdo = $dsn->getConnection();

        // Check if bid is higher than current highest bid
        $sqlCheck = "SELECT MAX(bid_price) as highest_bid FROM bid WHERE auction_id = ?";
        $stmtCheck = $pdo->prepare($sqlCheck);
        $stmtCheck->bindParam(1, $auction_id);
        $stmtCheck->execute();
        $result = $stmtCheck->fetch(PDO::FETCH_ASSOC);
        
        if ($result && $result['highest_bid'] && $bid_price <= $result['highest_bid']) {
            echo json_encode(['status' => 'error', 'message' => 'Your bid must be higher than the current highest bid.']);
            exit();
        }

        // Check if userid column exists in bid table
        $checkColumn = "SHOW COLUMNS FROM bid LIKE 'userid'";
        $columnExists = $pdo->query($checkColumn)->fetch();
        
        if ($columnExists) {
            // Insert the bid with userid
            $sql = "INSERT INTO bid (auction_id, bid_price, userid) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(1, $auction_id);
            $stmt->bindParam(2, $bid_price);
            $stmt->bindParam(3, $userid);
        } else {
            // Insert the bid without userid (for backward compatibility)
            $sql = "INSERT INTO bid (auction_id, bid_price) VALUES (?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(1, $auction_id);
            $stmt->bindParam(2, $bid_price);
        }

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Bid placed successfully.', 'new_bid' => $bid_price]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to place bid.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'An error occurred while placing the bid.']);
}
exit();
?>
