<?php

require_once('../auth/Database.php');

class User {
        
    private $db;   

    public function __construct(){
        $this->db = new Database();
    }

    // Get One Event 
    public function getUser($usermail, $password){
        $this->db->query("SELECT * FROM users where usermail = :usermail AND password = :password");
        $this->db->bind(':usermail', $usermail);
        $this->db->bind(':password', $password);
        return $this->db->single();
    }

    // Get record row count 
    public function rowCount(){
        return $this->db->rowCount();
    }


}