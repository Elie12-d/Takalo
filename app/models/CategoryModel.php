<?php

namespace app\models;

use Flight;

class CategoryModel
{
    private $db;
    private $id;
    private $name;
    private $status;
    private $description;
    public function __construct()
    {
        $this->db = Flight::db();
    }
    public function setStatus($status)
    {
        $this->status = $status;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function addCategory()
    {
        $sql = "INSERT INTO categories (name, description, status, created_at) VALUES (?, ?, 'enabled', CURDATE())";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$this->getName(), $this->getDescription()]);
    }
    public function deleteCategory()
    {
        $sql = "DELETE FROM categories WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$this->getId()]);
    }
    public function updateCategory(): bool
    {
        try {
            $sql = "UPDATE categories SET name = ?, description = ?, status = ? WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $success = $stmt->execute([
                $this->getName(),
                $this->getDescription(),
                $this->getStatus(),
                $this->getId()
            ]);
                return $success;
        } catch (\PDOException $e) {
            return false;
        }
    }
    public function getCategorieById($id)
    {
        $sql = "SELECT * FROM categories WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    public function getAllCategories()
    {
        $sql = "SELECT * FROM categories";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
}
