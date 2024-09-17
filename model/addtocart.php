<?php

class Cart
{

    private $cartid;
    private $itemid;
    private $userid;

    public function setItemId($itemid)
    {
        $this->itemid = $itemid;
    }
    public function setCartId($cartid)
    {
        $this->cartid = $cartid;
    }
    public function setUserId($userid)
    {
        $this->userid = $userid;
    }

    public function getCartId($con)
    {

        try {

            $sql = "SELECT item_id FROM addtocart WHERE user_id=?";
            $pstmt = $con->prepare($sql);
            $pstmt->bindValue(1, $this->userid);
            $pstmt->execute();
            $itemids = $pstmt->fetchAll(PDO::FETCH_COLUMN);
            return $itemids;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function cartItemCount($con){
        try {
            $sql="SELECT * FROM addtocart WHERE user_id=?";
            $pstmt=$con->prepare($sql);
            $pstmt->bindValue(1,$this->userid);
            $pstmt->execute();
            $count=$pstmt->rowCount();
            return $count;
        }  catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
       
    }

    public function cartItemDetails($con){
        try {
            $sql="SELECT * FROM addtocart a JOIN item i ON a.item_id=i.itemid WHERE a.user_id=?";
            $pstmt=$con->prepare($sql);
            $pstmt->bindValue(1,$this->userid);
            $pstmt->execute();
            $rows=$pstmt->fetchAll(PDO::FETCH_ASSOC);
            return $rows;
        }  catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
       
    }

}
