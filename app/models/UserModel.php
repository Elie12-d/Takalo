<?php 
namespace app\models;
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
    public function getUsers() {
        // You could actually pull data from the database if you had one set up
        // $users = Flight::db()->fetchAll("SELECT * FROM users");
    }

}