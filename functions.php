<?php 
                                   
function countItem($item, $table1, $item3) {
    
    global $con;
    
    $stm2 = $con->prepare("SELECT COUNT($item) FROM $table1 WHERE status = '$item3'");
    $stm2->execute();
    return $stm2->fetchColumn();
}

    function countItem5($item, $item1, $item2, $item3) {
    
    global $con;
            
    $stm5 = $con->prepare("SELECT COUNT($item) FROM events WHERE status ='$item1' AND town='$item2' AND category='$item3'");
    $stm5->execute();
    return $stm5->fetchColumn();
         

}

function countItem3($item, $table1) {
    
    global $con;
    
    $stm2 = $con->prepare("SELECT COUNT($item) FROM $table1");
    $stm2->execute();
    return $stm2->fetchColumn();
}


    function countItem2($item, $item2) {
    
    global $con;
            
    $stm5 = $con->prepare("SELECT COUNT($item) FROM users_registered WHERE events_id ='$item2'");
    $stm5->execute();
    return $stm5->fetchColumn();

}

    function countItem4($item, $item4, $item5) {
    
    global $con;
            
    $stm5 = $con->prepare("SELECT COUNT($item) FROM users_registered WHERE events_status ='$item4' AND reg_status='$item5'");
    $stm5->execute();
    return $stm5->fetchColumn();
         

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
