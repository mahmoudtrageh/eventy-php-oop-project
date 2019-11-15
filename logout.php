<?php 
include 'fb-login.php';
session_start();
session_destroy();
unset($_SESSION['access_token']);
header('location:login.php');

?>