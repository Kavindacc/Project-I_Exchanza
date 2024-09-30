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
        // Implement logic
        return 10; // Placeholder
    }

    public function getTotalFeedbacks()
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM messages");
        return $stmt->fetch()['total'];
    }

    public function getTotalEarnings()
    {
        $stmt = $this->pdo->query("SELECT SUM(amount) as total FROM payments");
        return $stmt->fetch()['total'];
    }

    public function getCustomers()
    {
        $stmt = $this->pdo->query("SELECT * FROM users WHERE role = 'customer'");
        return $stmt->fetchAll();
    }

    public function getSellers()
    {
        $stmt = $this->pdo->query("SELECT sellers.id, usern.name AS username, usern.email, sellers.variant 
                                   FROM usern 
                                   JOIN sellers ON usern.userid = sellers.user_id");
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

    public function updateSettings($contact_details, $social_media_links)
    {
        $stmt = $this->pdo->prepare("UPDATE settings SET contact_details = :contact_details, social_media_links = :social_media_links WHERE id = 1");
        $stmt->execute(['contact_details' => $contact_details, 'social_media_links' => $social_media_links]);
    }

    public function getPayments()
    {
        $stmt = $this->pdo->query("SELECT * FROM payments");
        return $stmt->fetchAll();
    }
    public function login($email, $password) {
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
}
