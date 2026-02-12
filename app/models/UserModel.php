<?php 
namespace app\models;
session_start();
use Flight;
class UserModel {
    private $db;
    private $id;
    private $name;
    private $email;
    private $password;
    public function __construct()
    {
        $this->db = Flight::db();
    }
    public function setName($name) {
        $this->name = $name;
    }
    public function setEmail($email) {
        $this->email = $email;
    }
    public function setPassword($password) {
        $this->password = $password;
    }
    public function setId($id) {
        $this->id = $id;
    }
    public function getName() {
        return $this->name;
    }
    public function getEmail() {
        return $this->email;
    }
    public function getPassword() {
        return $this->password;
    }
    public function getId() {
        return $this->id;
    }
    public function login($username, $password) {
        $sql = "SELECT * FROM users WHERE email = ? OR name = ? AND password = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$username, $username, $password]);
        $user = $stmt->fetch();
        if($user) {
            $_SESSION['user_id'] = $user['id'];
            return true;
        }
        return false;
    }
    public function logout() {
        session_destroy();
    }
    public function getUserNameById($id) {
        $sql = "SELECT name FROM users WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetchColumn();
    }

}