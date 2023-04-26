<?php

//Start session
session_start();

//Creating Constants to store Non Reoeating values
define('SITEURL', 'http://localhost:8080/proj%20try1/food-order-website/');
define('LOCALHOST', 'localhost:3307');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'food-order');


 $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error()); //DB connection
 $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());  //selecting DB