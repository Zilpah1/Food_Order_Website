<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>
        <br><br>

        <?php 
        if (ISSET($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset ($_SESSION['add']);
        }
        if (ISSET($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset ($_SESSION['upload']);
        }
        ?>
        <br><br>

        <!-- Add category form starts -->
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Category title">
                    </td>
                </tr>

                <tr>
                    <td>Select Image: </td>
                    <td><input type="file" name="image"></td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes">Yes
                        <input type="radio" name="featured" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes">Yes
                        <input type="radio" name="active" value="No">No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>

            </table>
        </form>

        <?php 
        //Check whether submit button is clicked or not
        if (ISSET($_POST['submit'])) {
            //echo "Clicked";

            //1. Get the value from Category form
            $title = mysqli_real_escape_string($conn, $_POST['title']);

            //For radio input type, we need to check whether the button is selected or not
            if (ISSET($_POST['featured'])) {
                # get the value from form
                $featured = $_POST['featured'];
            }
            else {
                # set default value
                $featured = "No";
            }

            if (ISSET($_POST['active'])) {
                $active = $_POST['active'];
            }
            else {
                $active = "No";
            }

            //Check whether the image is selected or not and set the value for image name accordingly
            //print_r($_FILES['image']);
            //die(); //Break the code here

            if (ISSET($_FILES['image'] ['name'])) {
                # upload the image
                // To upload image we need image name, source path and destination path
                $image_name = $_FILES['image']['name'];

                //Upload image only if image name is selected
                if ($image_name != "")
            {
                    
                
                //Auto rename our image
                //Get the extension of our image(jpg, png, jf, etc)
                $ext = end(explode('.', $image_name));

                //Rename the image
                $image_name = "Food_Category_".rand(000, 999).'.'.$ext;

                $source_path = $_FILES['image']['tmp_name'];

                $destination_path = "../images/category/".$image_name;

                //Finally upload the image
                $upload = move_uploaded_file($source_path, $destination_path);

                //Check whether the image is uploaded or not
                //If the image is not uploaded, then we will stop the process and redirrect with error message
                if ($upload == false) {
                    # Set message
                    $_SESSION['upload'] = "<div class = 'error'>Failed to upload image</div>";
                    //Redirrect to add category page
                    header('location: '.SITEURL.'admin/add-category.php');
                    //Stop the process
                    die();
                }
            }



            }
            else {
                # don't upload image and set the image name value as blank
                $image_name = "";
            }

            //2. Create SQL query to insert Category into the database
            $sql = "INSERT INTO tbl_category SET
            title = '$title',
            image_name = '$image_name',
            featured = '$featured',
            active = '$active';";

            //3. Execute the query and save in database
            $res = mysqli_query($conn, $sql);

            //4. Check whether the query executed or not and data added or not
            if ($res == true) {
                #query executed and category added
                $_SESSION['add'] = "<div class = 'success'>Category added successfully</div>";
                //Redirrect to manage-category page
                header('location: '.SITEURL.'admin/manage-category.php');
            }
            else {
                #failed to add category
                $_SESSION['add'] = "<div class = 'error'>Failed to add category</div>";
                //Redirrect to manage-category page
                header('location: '.SITEURL.'admin/add-category.php');
            }




        }
        ?>

        <!-- Add category form ends -->
    </div>
</div>

<?php include('partials/footer.php'); ?>