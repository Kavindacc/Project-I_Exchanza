<?php

class Item
{

    private $itemid;
    private $itemname;
    private $price;
    private $color;
    private $coverimage;
    private $otherimage;
    private $description;
    protected  $category;
    protected  $subcategory;
    private $condition;
    private $size;
    private  $quantity;
    protected $userid;

    public function __construct($itemname = null, $price = null, $color = null, $description = null, $category = null, $subcategory = null, $condition = null, $size = null, $coverimage = null, $otherimage = null, $quantity=null, $userid = null)
    {

        $this->itemname = $itemname;
        $this->price = $price;
        $this->color = $color;
        $this->coverimage = $coverimage;
        $this->otherimage = $otherimage;
        $this->description = $description;
        $this->category = $category;
        $this->subcategory = $subcategory;
        $this->condition = $condition;
        $this->size = $size;
        $this->quantity=$quantity;
        $this->userid = $userid;
    }

    public function setItemId($itemid)
    {
        $this->itemid = $itemid;
    }
    public function setItemName($itemname)
    {
        $this->itemname = $itemname;
    }
    public function setPrice($price)
    {
        $this->price = $price;
    }
    public function setCoverImage($coverimage)
    {
        $this->coverimage = $coverimage;
    }
    public function addItemForThrifting($con)
    {
        try {
            $sql = "INSERT INTO item(itemname, price, color, description, category, subcategory, `condition`, size, coverimage, otherimage,quantity, userid) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";
            $pstmt = $con->prepare($sql);
            $pstmt->bindValue(1, $this->itemname);
            $pstmt->bindValue(2, $this->price);
            $pstmt->bindValue(3, $this->color);
            $pstmt->bindValue(4, $this->description);
            $pstmt->bindValue(5, $this->category);
            $pstmt->bindValue(6, $this->subcategory);
            $pstmt->bindValue(7, $this->condition);
            $pstmt->bindValue(8, $this->size);
            $pstmt->bindValue(9, $this->coverimage);
            $pstmt->bindValue(10, $this->otherimage);
            $pstmt->bindValue(11,$this->quantity);
            $pstmt->bindValue(12, $this->userid);
            $pstmt->execute();

            if ($pstmt->rowCount() > 0) {
                $item_id = $con->lastInsertId();
                $sql = "INSERT INTO thrift (item_id, user_id)  VALUES (?,?)";
                $pstmt = $con->prepare($sql);
                $pstmt->bindValue(1, $item_id);
                $pstmt->bindValue(2, $this->userid);
                $pstmt->execute();
                if ($pstmt->rowCount() > 0) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function delete($con) //item delete function
    {
        try {
            $sql = "DELETE FROM item WHERE itemid = ?";
            $pstmt = $con->prepare($sql);
            $pstmt->bindValue(1, $this->itemid);
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

    public function updateitem($con) //update iteam details
    {
        try {
            $sql = "UPDATE item SET itemname=?, price=?,coverimage=? WHERE itemid=?";
            $pstmt = $con->prepare($sql);
            $pstmt->bindValue(1, $this->itemname);
            $pstmt->bindValue(2, $this->price);
            $pstmt->bindValue(3, $this->coverimage);
            $pstmt->bindValue(4, $this->itemid);
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
}
class Thrift extends Item
{

    public function __construct($userid = null)
    {
        $this->userid = $userid;
    }

    public function setCategory($category){
        $this->category=$category;
    }
    public function setSubCategory($subcategory){
        $this->subcategory=$subcategory;
    }
    public function getThriftItemsLogin($con)
    {
        try {
            $sql = "SELECT * FROM thrift t JOIN item i ON t.item_id = i.itemid WHERE t.user_id = ? AND i.category=? AND i.subcategory=?"; //change it
            $pstmt = $con->prepare($sql);
            $pstmt->bindValue(1, $this->userid);
            $pstmt->bindValue(2, $this->category);
            $pstmt->bindValue(3, $this->subcategory);
            $pstmt->execute();
            $rows = $pstmt->fetchAll(PDO::FETCH_ASSOC);
            return $rows;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    public function getThriftItems($con)
    {
        try {
            $sql = "SELECT * FROM thrift t JOIN item i ON t.item_id = i.itemid WHERE i.category=? AND i.subcategory=?"; //change it
            $pstmt = $con->prepare($sql);
            $pstmt->bindValue(1, $this->category);
            $pstmt->bindValue(2, $this->subcategory);
            $pstmt->execute();
            $rows = $pstmt->fetchAll(PDO::FETCH_ASSOC);
            return $rows;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
