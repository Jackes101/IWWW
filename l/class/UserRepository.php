<?php

class userRepository{
    private $conn = null;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    public function getAllUsers(){
        $stmt = $this ->conn->prepare("SELECT * FROM users");
        $stmt -> execute();
        return $stmt->fetchAll();
    }

    public function getByEmail($email){
        $stmt = $this ->conn->prepare("SELECT * FROM users WHERE email LIKE  concat('%', :email, '%')");
        $stmt -> bindParam(":email", $email);
        $stmt -> execute();
        return $stmt->fetchAll();
    }
}