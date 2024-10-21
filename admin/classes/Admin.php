<?php
class Admin
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getTotalUsers()
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM user");
        return $stmt->fetch()['total'];
    }

    public function getTotalSales()
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM order_item");
        return $stmt->fetch()['total'];
    }

    public function getTotalEnquiries()
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM enquiries");
        return $stmt->fetch()['total'];
    }

    public function getTotalStores()
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM stores");
        return $stmt->fetch()['total'];
    }

    public function banUser($userId)
    {

        $stmt = $this->pdo->prepare("UPDATE user SET status = 'banned' WHERE userid = :userId");
        return $stmt->execute(['userId' => $userId]);
    }

    public function activateUser($userId)
    {
        $stmt = $this->pdo->prepare("UPDATE user SET status = 'active' WHERE userid = :userId");
        return $stmt->execute(['userId' => $userId]);
    }



    public function getUsers()
    {
        $stmt = $this->pdo->query("SELECT * FROM user");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCustomers()
    {
        $stmt = $this->pdo->query("SELECT * FROM users WHERE role = 'customer'");
        return $stmt->fetchAll();
    }

    public function getSellers()
    {
        $stmt = $this->pdo->query("SELECT store_id, user_id, store_name, created_at
                                   FROM stores
                                   ");
        return $stmt->fetchAll();
    }


    public function getMessages()
    {
        $stmt = $this->pdo->query("SELECT reviews.review_id, user.firstname AS username, reviews.review_text, reviews.rating 
                                   FROM reviews 
                                   JOIN user ON reviews.user_id = user.userid");
        return $stmt->fetchAll();
    }


    public function replyMessage($message_id, $reply)
    {
        $stmt = $this->pdo->prepare("UPDATE messages SET reply = :reply WHERE id = :id");
        $stmt->execute(['reply' => $reply, 'id' => $message_id]);
    }

    public function getSettings()
    {
        $stmt = $this->pdo->query("SELECT * FROM settings WHERE id = 1");
        return $stmt->fetch();
    }

    public function updateSettings($email, $phone, $address, $facebook_link, $instagram_link, $youtube_link)
    {
        $stmt = $this->pdo->prepare("UPDATE settings 
                                 SET email = :email, phone = :phone, address = :address, 
                                     facebook_link = :facebook, instagram_link = :instagram, youtube_link = :youtube 
                                 WHERE id = 1");
        $stmt->execute([
            'email' => $email,
            'phone' => $phone,
            'address' => $address,
            'facebook' => $facebook_link,
            'instagram' => $instagram_link,
            'youtube' => $youtube_link
        ]);
    }

    public function getOrders()
    {
        $sql = "SELECT order_id, user_id, order_status, order_date, trackingnum, fullname, confirm FROM orders";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEnquiries()
    {
        $sql = "SELECT * FROM enquiries";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEnquiryById($id)
    {
        $sql = "SELECT * FROM enquiries WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function deleteEnquiry($id)
    {
        $sql = "DELETE FROM enquiries WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }


    public function updateEnquiryStatus($id, $status)
    {
        $sql = "UPDATE enquiries SET status = :status WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }




    public function getPayments()
    {
        $stmt = $this->pdo->query("SELECT * FROM payments");
        return $stmt->fetchAll();
    }
    public function login($email, $password)
    {
        try {
            // Prepare SQL query with placeholders to prevent SQL injection
            $stmt = $this->pdo->prepare("SELECT * FROM admins WHERE email = :email");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            // Fetch the admin data
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            // If admin exists, verify the password
            if ($admin) {
                if ($password === $admin['password']) { // Check plaintext password directly
                    // Set session variables for admin
                    $_SESSION['admin_id'] = $admin['id'];
                    $_SESSION['email'] = $admin['email'];
                    return true;
                } else {
                    // Incorrect password
                    return false;
                }
            } else {
                // No admin found with that email
                return false;
            }
        } catch (PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    public function logout()
    {
        session_unset();
        session_destroy();
    }
}
