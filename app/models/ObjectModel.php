<?php

namespace app\models;

use Flight;
use PDO;

class ObjectModel
{
    private $db;
    private $id;
    private $name;
    private $description;
    private $userId;
    private $categoryId;
    private $publishedDate;
    public function __construct()
    {
        $this->db = Flight::db();
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
    }
    public function setPublishedDate($publishedDate)
    {
        $this->publishedDate = $publishedDate;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function getUserId()
    {
        return $this->userId;
    }
    public function getCategoryId()
    {
        return $this->categoryId;
    }
    public function getPublishedDate()
    {
        return $this->publishedDate;
    }
    public function getAllObjects($userId)
    {
        $sql = "SELECT * FROM objects WHERE user_id != ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
    public function getObjectsByUserId($userId)
    {
        $sql = "SELECT * FROM objects WHERE user_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
    public function proposeExchange($userId1, $userId2, $objectId2, $objectId1)
    {
        try {
            $sql = "INSERT INTO exchanges(user1_id, user2_id, object1_id, object2_id, proposed_at) VALUES (?, ?, ?, ?, NOW())";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$userId1, $userId2, $objectId1, $objectId2]);
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }
    public function getUserIdById($id)
    {
        $sql = "SELECT user_id FROM objects WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetchColumn();
    }
    public function exchangeObjects($objectId1, $objectId2){
        try {
            $this->db->beginTransaction();

            // Récupérer les propriétaires
            $stmt = $this->db->prepare("SELECT user_id FROM objects WHERE id = ?");
            $stmt->execute([$objectId1]);
            $owner1 = $stmt->fetchColumn();

            $stmt->execute([$objectId2]);
            $owner2 = $stmt->fetchColumn();

            // Échanger
            $stmt = $this->db->prepare("UPDATE objects SET user_id = ? WHERE id = ?");
            $stmt->execute([$owner2, $objectId1]);
            $stmt->execute([$owner1, $objectId2]);

            $this->db->commit();
            return true;
        } catch (\PDOException $e) {
            $this->db->rollBack();
            return false;
        }
    }
    public function getAllPropositionsById($id) {
        $sql = "SELECT * FROM exchanges WHERE user1_id = ? OR user2_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id, $id]);
        return $stmt->fetchAll();
    }
}
