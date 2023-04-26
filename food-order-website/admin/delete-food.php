<?php 
//include constants page
include ('config/constants.php');
//echo "DELETE FOOD PAGE"

if (ISSET($_GET['id']) && ISSET($_GET['image_name'])) {  //Either use '&&' or 'AND'
    # Process to delete 
    //echo "Process to delete";

    //1. Get id and image name
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    //2. Remove the image if available
    //Check whether the image is available or not amd delete only if available
    if ($image_name != "") {
        # It has image and needs to remove from folder
        //Get the image path
        $path = "../images/food/".$image_name;

        //Remove image file from folder
        $remove = unlink($path);

        //check whether the image is removed or not
        if ($remove == false) {
            # failed to remove image
            $_SESSION['upload'] = "<div class = 'error'>Failed to remove image file.</div>";
            #Redirrect to manage food
            header('location: '.SITEURL.'admin/manage-food.php');
            //Stop the process of deleting food
            die();
        }
    }

    //3. Delete food from DB
    $sql = "DELETE FROM tbl_food WHERE id = $id;";
    //Execute the query
    $res = mysqli_query($conn, $sql);
    //Check whether the query executed or not and set session message respectively
    //4. Redirrect to manage food with session message
    if ($res==true) {
        # food deleted
        $_SESSION['delete'] = "<div class = 'success'>Food deleted successfully</div>";
        header('location: '.SITEURL.'admin/manage-food.php');
    }
    else {
        # failed to delete food
        $_SESSION['delete'] = "<div class = 'error'>Failed to delete Food.</div>";
        header('location: '.SITEURL.'admin/manage-food.php');

    }

    
}
else {
    # Redirrect to manage food page
    //echo "Redirrect";
    $_SESSION['unauthorize'] = "<div class='error'>Unauthorized Access.</div>";
    header('location: '.SITEURL.'admin/manage-food.php');
}
?>