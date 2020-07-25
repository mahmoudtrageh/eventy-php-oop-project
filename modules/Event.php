<?php

require_once('Database.php');

class Event {

    private $db;    
    public $event_start;
    public $my_current;
    public $event_finish;

    public function __construct(){
        $this->db = new Database();
    }

    // Get all Events
    public function getEvents(){
        $this->db->query("SELECT * from events");
        return $this->db->resultSet();
    }

    // Get One Event 
    public function getEventById($id){
        $this->db->query("SELECT * FROM events where id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    // Get Events by status
    public function getEventByStatus($status){
        $this->db->query("SELECT * FROM events where status = :status");
        $this->db->bind(':status', $status);
        return $this->db->resultSet();
    }


      // Get Events by status
    public function getEventsHome($status, $town, $category){
        $this->db->query("SELECT * FROM events WHERE status = :status AND town = :town AND category = :category");
        $this->db->bind(':status', $status);
        $this->db->bind(':town', $town);
        $this->db->bind(':category', $category);
        return $this->db->resultSet();
    }

   // Get Events by status
    public function getEventsHomeAll($town, $category){
        $this->db->query("SELECT * FROM events WHERE town = :town AND category = :category");
        $this->db->bind(':town', $town);
        $this->db->bind(':category', $category);
        return $this->db->resultSet();
    }



    // calculate time 
    public function calculateTime($param1, $param2){

        $event_day = date("d", strtotime($param1));
        $event_month = date("m", strtotime($param1)) * 30;

        $finish_day = date("d", strtotime($param2));
        $finish_month = date("m", strtotime($param2)) * 30;
            
        $this->event_start = $event_month + $event_day;
            
        $event_finish = $finish_month + $finish_day;

        $current_day = date('d'); 

        $current_month = date('m') * 30; 
            
        $this->my_current = $current_month + $current_day;

        return $this->my_current;
        return $this->event_start;
        return $this->event_finish;
    }

      // Get record row count 
    public function rowCount(){
        return $this->db->rowCount();
    }


}