<?php

class Wishlist{
    
    private $wishid;
    private $itemid;
    private $userid;

    public function setItemId($itemid){
        $this->itemid=$itemid;
    }
    public function setWishId($wishid){
        $this->wishid=$wishid;
    }
    public function setUserId($userid){
        $this->userid=$userid;
    }

    public function getwishlistid($con)
    {

        $sql = "SELECT itemid FROM wishlist WHERE userid=?";
        try {
            $pstmt = $con->prepare($sql);
            $pstmt->bindValue(1, $this->userid);
            $pstmt->execute();
            $itemids = $pstmt->fetchAll(PDO::FETCH_COLUMN);
            return $itemids;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function addtoWishlist($con){//wishlist inser funtion

        try {
            $sql="INSERT INTO wishlist(itemid,userid) VALUES (?,?)";
            $pstmt=$con->prepare($sql);
            $pstmt->bindParam(1,$this->itemid);
            $pstmt->bindParam(2,$this->userid);
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

    public function itemCount($con){
        try {
            $sql="SELECT * FROM wishlist WHERE userid=?";
            $pstmt=$con->prepare($sql);
            $pstmt->bindValue(1,$this->userid);
            $pstmt->execute();
            $count=$pstmt->rowCount();
            return $count;
        }  catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
       
    }

    public function wishlistItemDetails($con){
        try {
            $sql="SELECT * FROM wishlist w JOIN item i ON w.itemid=i.itemid WHERE w.userid=?";
            $pstmt=$con->prepare($sql);
            $pstmt->bindValue(1,$this->userid);
            $pstmt->execute();
            $rows=$pstmt->fetchAll(PDO::FETCH_ASSOC);
            return $rows;
        }  catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
       
    }

    public function removeItem($con){
        try {
            $sql="DELETE FROM wishlist WHERE wishid=?";
            $pstmt=$con->prepare($sql);
            $pstmt->bindValue(1,$this->wishid);
            $pstmt->execute();
            if($pstmt->rowCount()>0){
                return true;
            }
            else{
                return false;
            }
           
        }  catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

}


?>