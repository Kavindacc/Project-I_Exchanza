<?php

require '../model/user.php';
class Products extends User
{
    private $productname, $price, $colour, $description, $category, $subcategory, $condition, $userid, $size, $filePath;

    

    public function insertProduct($productname, $price, $colour, $description, $category, $subcategory, $size, $condition, $filePath, $userid)
    {
        $this->productname = $productname;
        $this->price = $price;
        $this->colour = $colour;
        $this->description = $description;
        $this->category = $category;
        $this->subcategory = $subcategory;
        $this->size = $size;
        $this->condition = $condition;
        $this->filePath = $filePath;
        $this->userid = $userid;

        try {
            $query = "INSERT INTO products(product_name, price, colour, description, category, subcategory, size, `condition`, image, userid) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$this->productname, $this->price, $this->colour, $this->description, $this->category, $this->subcategory, $this->size, $this->condition, $this->filePath, $this->userid]);
            if ($stmt->rowCount() > 0) {
                header("Location: ../view/thrift.php?success=Product Added.");//thrift page
                exit();
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function get($userid){

        $this->userid=$userid;

        try {
            $query="SELECT * FROM products WHERE userid=?";
            $stmt=$this->pdo->prepare($query);
            $stmt->execute([$this->userid]);
            if($stmt->rowCount()>0){
                $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
                return $rows;
            }
           
        } 
        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function delete($productid){
        $query = "DELETE FROM products WHERE product_id = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$productid]);
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            // Failed to delete product
        }
    }
}
