<?php 
//Authorization - Access Control
//Check whether user is logged in or not
if (!ISSET($_SESSION['user'])) { //if session is not set
    # user is not logged in
    //Redirect to login page with message
    $_SESSION['no-login-message']="<div class='error text-center'>Please login to access admin Panel</div>";
    //redirrect to login page
    header('location: '.SITEURL.'admin/login.php');

}

?>
