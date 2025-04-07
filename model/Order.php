<?php

class Orders
{
    private $userid;
    private $itemid;
    private $orderid;

    public function __construct($userid = null)
    {
        $this->userid = $userid;
    }

    public function setOrderId($orderid)
    {
        $this->orderid = $orderid;
    }

    public function confirmOrder($con, $trackingnum)
    {
        try {
            $sql = "UPDATE orders SET trackingnum =?,confirm=? WHERE order_id = ?";
            $pstmt = $con->prepare($sql);
            $pstmt->bindValue(1, $trackingnum);
            $pstmt->bindValue(2, "1");
            $pstmt->bindValue(3, $this->orderid);
            $pstmt->execute();
            if ($pstmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function getOrderDetails($con)
    {
        try {
            $sql = "SELECT o.order_id,o.order_date,oi.quantity, i.itemname,oi.price,u.firstname,u.lastname ,o.confirm
        FROM orders o
        JOIN order_item oi ON o.order_id = oi.order_id
        JOIN item i ON oi.item_id = i.itemid
        JOIN user u ON o.user_id = u.userid
        WHERE i.userid = ?";
            $pstmt = $con->prepare($sql);
            $pstmt->bindValue(1, $this->userid);
            $pstmt->execute();
            if ($pstmt->rowCount() > 0) {
                $rows = $pstmt->fetchAll(PDO::FETCH_ASSOC);
                return $rows;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function delete($con)
    {
        try {
            $sql="DELETE FROM orders WHERE order_id=?";
            $pstmt=$con->prepare($sql);
            $pstmt->bindValue(1,$this->orderid);
            $pstmt->execute();
            if($pstmt->rowCount()>0){
                return true;
            }
            else{
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
