<?php

require_once 'DbConnector.php';
class Auction
{
    private $pdo;

    public function __construct()
    {
        $db = new DbConnector();
        $this->pdo = $db->getConnection();
    }

    public function getOngoingAuctions()
    {
        $current_time = date("Y-m-d H:i:s");
        $sql = "SELECT * FROM item i JOIN auction a ON i.itemid  = a.itemid  WHERE a.start_time <= :current_time AND a.end_time >= :current_time";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['current_time' => $current_time]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUpcomingAuctions()
    {
        $current_time = gmdate("Y-m-d\TH:i:s\Z");
        $sql = "SELECT * FROM item i JOIN auction a ON i.itemid = a.itemid WHERE a.start_time > :current_time";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['current_time' => $current_time]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFinishedAuctions()
    {
        $current_time = date("Y-m-d H:i:s");
        $sql = "SELECT * FROM item i JOIN auction a ON i.itemid = a.itemid WHERE a.end_time < :current_time";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['current_time' => $current_time]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
