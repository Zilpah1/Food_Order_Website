<?php 
//include constants file
include('config/constants.php');

//echo "Delete page!!!...";
//Check whether the id and image_name valu is set or not
if (ISSET($_GET['id']) AND ISSET($_GET['image_name'])) {
    # get the value and delete
    //echo "Get value and delete";
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    //Remove the image file if available
    if ($image_name != "") {
        # image is available, so remove it
        $path = "../images/category/".$image_name;
        //Remove the image
        $remove = unlink($path);

        //if failed to remove image then add an error message and stop process
        if ($remove==false) {

            # set session message
            $_SESSION['remove']= "<div class='error'>Failed to remove category message</div>";

            //Redirrect to manage category page with message
            header('location: '.SITEURL.'admin/manage-category.php');

            //stop the process
            die();
        }

    }

    //Delete data from database
    //SQL to delete data from database
    $sql = "DELETE FROM tbl_category WHERE id = $id;";

    //Execute the query
    $res = mysqli_query($conn, $sql);
    //check whether data is deleted from database or not
    if ($res == true) {
        # set success message and redirrect 
        $_SESSION['delete'] = "<div class = 'success'>Category deleted successfully</div>";
        //redirrect to manage category
        header('location:'.SITEURL.'admin/manage-category.php');
    }
    else {
        # set error message and redirrect
        $_SESSION['delete'] = "<div class = 'error'>Failed to delete Category</div>";
        //redirrect to manage category
        header('location:'.SITEURL.'admin/manage-category.php');

    }

    //Redirect to manage category page with message
}
else {
    //Redirrect to manage category page
    header('location: '.SITEURL.'admin/manage-category.php');

}
?>