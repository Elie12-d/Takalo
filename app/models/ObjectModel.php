<?php

namespace app\models;

use Flight;
use PDO;

class ObjectModel {
    private $db;
    private $id;
    private $name;
    private $description;
    private $userId;
    private $categoryId;
    private $publishedDate;
    public function __construct() {
        $this->db = Flight::db();
    }
    public function setName($name) {
        $this->name = $name;
    }
    public function setDescription($description) {
        $this->description = $description;
    }
    public function setUserId($userId) {
        $this->userId = $userId;
    }
    public function setId($id) {
        $this->id = $id;
    }
    public function setCategoryId($categoryId) {
        $this->categoryId = $categoryId;
    }
    public function setPublishedDate($publishedDate) {
        $this->publishedDate = $publishedDate;
    }
    public function getId() {
        return $this->id;
    }
    public function getName() {
        return $this->name;
    }
    public function getDescription() {
        return $this->description;
    }
    public function getUserId() {
        return $this->userId;
    }
    public function getCategoryId() {
        return $this->categoryId;
    }
    public function getPublishedDate() {
        return $this->publishedDate;
    }
    public function getAllObjects($userId) {
        $sql = "SELECT * FROM objects WHERE user_id != ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
    public function getObjectsByUserId($userId) {
        $sql = "SELECT * FROM objects WHERE user_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
    public function proposeExchange($objectId1, $objectId2, $userId1, $userId2) {
        // Flight::json([ 'message' => 'Proposition d\'échange envoyée avec succès.'.$userId1.' '.$userId2.' '.$objectId1.' '.$objectId2 ]);
        try {
            $sql = "INSERT INTO exchanges(user1_id, user2_id, object1_id, object2_id, proposed_at) VALUES (?, ?, ?, ?, NOW())";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(1, $userId1, PDO::PARAM_INT);
            $stmt->bindParam(2, $userId2, PDO::PARAM_INT);
            $stmt->bindParam(3, $objectId1, PDO::PARAM_INT);
            $stmt->bindParam(4, $objectId2, PDO::PARAM_INT);
            $stmt->execute();
        } catch (\PDOException $e) {
            return false;
        }
        return true;
    }
    public function getById($id) {
        $sql = "SELECT * FROM objects WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(1,$id);
         $stmt->execute();
        return $stmt->fetch();
    }
}