<?php 
//Include constants.php for ULR
include('config/constants.php');
//1. Destroy the session
session_destroy(); //unsets $_SESSION['user']

//2. Redirrect to login page
header('location:'.SITEURL.'admin/login.php');
?>