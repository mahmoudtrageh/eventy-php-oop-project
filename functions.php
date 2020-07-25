<?php 

require_once('modules/Database.php');

                                   
function countItem($item, $table1, $item3) {
    $db = new Database();

    $db->query("SELECT COUNT($item) FROM $table1 WHERE status = '$item3'");
    return $db->resultSet();
}

function countItem5($item, $item1, $item2, $item3) {
    $db = new Database();
       
    $db->query("SELECT COUNT($item) FROM events WHERE status ='$item1' AND town='$item2' AND category='$item3'");
    return $db->resultSet();
         

}

function countItem3($item, $table1) {
    $db = new Database();

    $db->query("SELECT COUNT($item) FROM $table1");
    return $db->resultSet();
}


    function countItem2($item, $item2) {
               $db = new Database();
 
    $db->query("SELECT COUNT($item) FROM users_registered WHERE events_id ='$item2'");
    return $db->resultSet();
}

    function countItem4($item, $item4, $item5) {
             $db = new Database();
   
    $db->query("SELECT COUNT($item) FROM users_registered WHERE events_status ='$item4' AND reg_status='$item5'");
    return $db->resultSet();
         

}


function generateRandomString($length = 5) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$characterLength = strlen($characters);
		$randomString = '';
		for($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $characterLength - 1)];
		}
		return $randomString;
	}


?>
