<?php
session_start();
class User
{

    protected $userid;
    protected $first_name;
    protected $last_name;
    protected $email;
    protected $gender;
    protected $country;
    protected $phone_num;
    protected $password;
    protected $otpnum;
    protected $status;

    function __construct($first_name = null, $last_name = null, $email = null, $gender = null, $country = null, $phone_num = null, $password = null)
    {
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email = $email;
        $this->gender = $gender;
        $this->country = $country;
        $this->phone_num = $phone_num;
        $this->password = $password;
    }

    function setOtpnum($otpnum)
    {
        $this->otpnum = $otpnum;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }
    function checkEmail($con)
    {
        try {
            $sql = "SELECT * FROM user WHERE email=?";
            $pstmt = $con->prepare($sql);
            $pstmt->bindValue(1, $this->email);
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

    function userRegister($con)
    {
        try {
            $sql = "INSERT INTO user (firstname, lastname , email , gender , country , phonenum, password , otpnum) VALUES (?,?,?,?,?,?,?,?)";
            $pstmt = $con->prepare($sql);
            $pstmt->bindValue(1, $this->first_name);
            $pstmt->bindValue(2, $this->last_name);
            $pstmt->bindValue(3, $this->email);
            $pstmt->bindValue(4, $this->gender);
            $pstmt->bindValue(5, $this->country);
            $pstmt->bindValue(6, $this->phone_num);
            $pstmt->bindValue(7, $this->password);
            $pstmt->bindValue(8, $this->otpnum);
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

    function checkOtp($con)
    {
        try {
            $sql = "SELECT otpnum  FROM user WHERE email=?";
            $pstmt = $con->prepare($sql);
            $pstmt->bindValue(1, $this->email);
            $pstmt->execute();
            $otp = $pstmt->fetch(PDO::FETCH_ASSOC);
            if ($otp) {
                return $otp['otpnum'];
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    function userActive($con, $status)
    {
        try {
            $sql = "UPDATE user SET status =? WHERE email=?";
            $pstmt = $con->prepare($sql);
            $pstmt->bindValue(1, $status);
            $pstmt->bindValue(2, $this->email);
            $pstmt->execute();
            if ($pstmt->rowCount() > 0) {
                return true;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    function userAuthentication($con)
    {

        try {
            $sql = "SELECT * FROM user WHERE email=?";
            $pstmt = $con->prepare($sql);
            $pstmt->bindValue(1, $this->email);
            $pstmt->execute();
            $row = $pstmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                if (password_verify($this->password, $row['password']) && $row['status'] == "active") {
                    $_SESSION['userid'] = $row['userid'];
                    $_SESSION['name'] = $row['firstname'] . ' ' . $row['lastname'];
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
    function saveEnquiry($con, $name, $email, $subject, $message)
    {
        try {
            $sql = "INSERT INTO enquiries (name, email, subject, message) VALUES (?, ?, ?, ?)";
            $pstmt = $con->prepare($sql);
            $pstmt->bindValue(1, $name);
            $pstmt->bindValue(2, $email);
            $pstmt->bindValue(3, $subject);
            $pstmt->bindValue(4, $message);
            $pstmt->execute();

            if ($pstmt->rowCount() > 0) {
                return true;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
class RegisteredCustomer extends User
{
    private $filepath;
    protected $itemid;

    public function __construct($userid = null)
    {
        $this->userid = $userid;
    }

    public function setFilepath($filepath)
    {
        $this->filepath = $filepath;
    }
    public function setUserid($userid)
    {
        $this->userid = $userid;
    }
    public function setItemId($itemid)
    {
        $this->itemid = $itemid;
    }

    function accountDetails($con)
    {
        try {
            $sql = "SELECT * FROM user WHERE userid=?";
            $pstmt = $con->prepare($sql);
            $pstmt->bindValue(1, $this->userid);
            $pstmt->execute();
            $row = $pstmt->fetch(PDO::FETCH_ASSOC);
            return $row;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    function verifyPassword($con) //change password function
    {

        try {
            $query = "SELECT password FROM user WHERE userid =?";
            $stmt = $con->prepare($query);
            $stmt->bindValue(1, $this->userid);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if (password_verify($this->password, $result['password'])) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    function changepassword($con) //password change function
    {

        try {
            $sql = "UPDATE user SET password=? WHERE userid =?";
            $stmt = $con->prepare($sql);
            $stmt->bindValue(1, $this->password);
            $stmt->bindValue(2, $this->userid);
            $stmt->execute();
            if ($stmt->rowcount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    function updateImg($con) //profile picture change function
    {
        try {

            $sql = "UPDATE user SET profilepic =? WHERE userid =?";
            $stmt = $con->prepare($sql);
            $stmt->bindValue(1, $this->filepath);
            $stmt->bindValue(2, $this->userid);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function browserProducts($con)
    {
        try {
            $sql = "SELECT * FROM item WHERE userid=?";
            $pstmt = $con->prepare($sql);
            $pstmt->bindValue(1, $this->userid);
            $pstmt->execute();
            if ($pstmt->rowCount() > 0) {
                return $pstmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function addToCart($con)
    {
        try {
            $sql = "INSERT INTO addtocart(item_id,user_id) VALUES (?,?)";
            $pstmt = $con->prepare($sql);
            $pstmt->bindValue(1, $this->itemid);
            $pstmt->bindValue(2, $this->userid);
            $pstmt->execute();
            if ($pstmt->rowCount() > 0) {
                $sql = "DELETE FROM wishlist WHERE itemid=?";
                $pstmt = $con->prepare($sql);
                $pstmt->bindValue(1, $this->itemid);
                $pstmt->execute();
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

class GeneralCustomer extends RegisteredCustomer
{

    private $reviewtext;
    private $rate;

    public function __construct($userid = null, $itemid = null, $reviewtext = null, $rate = null)
    {
        $this->userid = $userid;
        $this->itemid = $itemid;
        $this->reviewtext = $reviewtext;
        $this->rate = $rate;
    }

    public function setUserid($userid)
    {
        $this->userid = $userid;
    }

    public function setItemId($itemid)
    {
        $this->itemid = $itemid;
    }

    public function giveRating($con)
    {
        try {
            $sql = "INSERT INTO reviews (product_id, user_id, review_text, rating) VALUES (?, ?, ?, ?)";
            $pstmt = $con->prepare($sql);
            $pstmt->bindValue(1, $this->itemid);
            $pstmt->bindValue(2, $this->userid);
            $pstmt->bindValue(3, $this->reviewtext);
            $pstmt->bindValue(4, $this->rate);
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

    public function getRating($con)
    {
        try {
            $sql = "SELECT review_text, rating,user_id FROM reviews WHERE product_id = ?";
            $pstmt = $con->prepare($sql);
            $pstmt->bindValue(1, $this->itemid);
            $pstmt->execute();
            $rows = $pstmt->fetchAll(PDO::FETCH_ASSOC);
            return $rows;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function getusername($con)
    {
        try {
            $sql = "SELECT firstname, lastname FROM user WHERE userid=?";
            $pstmt = $con->prepare($sql);
            $pstmt->bindValue(1, $this->userid);
            $pstmt->execute();
            $rows = $pstmt->fetch(PDO::FETCH_ASSOC);
            $name = $rows['firstname'] . ' ' . $rows['lastname'];
            return $name;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
