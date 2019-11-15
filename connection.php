<?php
// start connection to data base
$dsn = 'mysql:host=sql104.epizy.com;dbname=epiz_22846734_eventy';
$user = 'epiz_22846734';
$pass = 'fVtbknT3ZfvHyiX';
$option = array (
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
);

try {
    $con = new PDO($dsn, $user, $pass, $option);
    $con -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}

catch(PDOException $e) {
    echo 'failed to connect' . $e->getMessage();
}
?>
