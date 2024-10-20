<?php
class MyOrders
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

    public function setItemid($itemid)
    {
        $this->itemid = $itemid;
    }

    public function confirmReceived($con)
    {
        try {
            $sql = "UPDATE orders SET order_status =? WHERE order_id = ?";
            $pstmt = $con->prepare($sql);
            $pstmt->bindValue(1, "1");
            $pstmt->bindValue(2, $this->orderid);
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
            $sql = "SELECT o.order_id,o.order_date,oi.quantity,i.itemid, i.itemname,i.coverimage, oi.price, o.order_status,o.trackingnum 
        FROM orders o
        JOIN order_item oi ON o.order_id = oi.order_id
        JOIN item i ON oi.item_id = i.itemid
        WHERE o.user_id =? AND o.confirm =?";
            $pstmt = $con->prepare($sql);
            $pstmt->bindValue(1, $this->userid);
            $pstmt->bindValue(2,"1");
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

    /*public function updateorderitem($con)
    {
        try {
            $sql = "UPDATE item SET status = ? WHERE itemid=?";
            $pstmt = $con->prepare($sql);
            $pstmt->bindValue(1,1);
            $pstmt->bindValue(2,$this->itemid);
            $pstmt->execute();
            if ($pstmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }*/


}
