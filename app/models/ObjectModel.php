<?php

namespace app\models;

use Flight;

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
    public function exchangeObject($myObjectId, $otherObjectId) {
        $sql = "INSERT INTO exchanges (user1_id, user2_id, object1_id, object2_id, proposed_at) VALUES (?, ?, ?, ?, NOW())";
        
    }
}