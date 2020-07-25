<?php

require_once("../config/config.php");

class Database {

    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PWD;
    private $dbname = DB_NAME;

    private $connection;
    private $error;
    private $stmt;
    private $dbconnected = false;

    public function __construct(){

        //Set Pdo Connection 
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        $options = array(
                    PDO::ATTR_PERSISTENT => true,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
                );
        try{

            $this->connection = new PDO ( $dsn, $this->user, $this->pass, $options );
            $this->dbconnected = true;
        } catch(PDOException $e){
            $this->error = $e->getMessage() . PHP_EOL;
            $this->dbconnected = false;
        }

    }

    public function getError(){
        return $this->error;
    }

    public function isConnected(){
        return $this->dbconnected;
    }

    // prepare statment with query 
    public function query($query){
        $this->stmt = $this->connection->prepare($query);
    }

    // execute the prepared statement 
    public function execute(){
        return $this->stmt->execute();
    }

    // Get result set as Array of Objects 
    public function resultSet(){
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Get record row count 
    public function rowCount(){
        return $this->stmt->rowCount();
    }

    // Get single record as object
    public function single(){
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    public function bind($param, $value, $type = null){
        if( is_null($type) ){
            switch(true){
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value);
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

}