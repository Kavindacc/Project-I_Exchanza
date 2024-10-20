<?php
require_once '../model/DbConnector.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $auction_id = $_POST['auction_id'];
    $bid_price = $_POST['bid_price'];
    $userid = $_POST['userid'];

    $dsn = new DbConnector();
    $pdo = $dsn->getConnection();

    $sql = "INSERT INTO bid (auction_id, bid_price, userid) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(1, $auction_id);
    $stmt->bindParam(2, $bid_price);
    $stmt->bindParam(3, $userid);


    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Bid placed successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to place bid.']);
    }
}
?>
