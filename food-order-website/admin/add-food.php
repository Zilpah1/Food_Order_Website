<?php 
include('partials/menu.php')
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>

        <br><br>
        <?php
        if (ISSET($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }

        ?>

        <form action="" method="POST" enctype="multipart/form-data">

        <table class="tbl-30">
            <tr>
                <td>Title: </td>
                <td>
                    <input type="text" name="title" placeholder="Title of the food">
                </td>
            </tr>

            <tr>
                <td>Description: </td>
                <td>
                    <textarea name="description" cols="30" rows="5" placeholder="Description of the food"></textarea>
                </td>
            </tr>

            <tr>
                <td>Price: </td>
                <td><input type="number" name="price"></td>
            </tr>

            <tr>
                <td>Select Image: </td>
                <td>
                    <input type="file" name="image">
                </td>
            </tr>

            <tr>
                <td>Category: </td>
                <td>
                    <select name="category" >

                        <?php 
                        //create PHP code to display categories from database

                        //1. Create SQL to display all active categories from Db
                        $sql = "SELECT * FROM tbl_category WHERE active = 'Yes';";

                        //Execute the query
                        $res = mysqli_query($conn, $sql);

                        //Count the rows to check whether we have categories or not
                        $count = mysqli_num_rows($res);

                        //If count is greater than zero we have categories else we do not have categores
                        if ($count>0) {
                            # we have category
                            while($row=mysqli_fetch_assoc($res))
                            {
                                //Get the details of category
                                $id = $row['id'];
                                $title = $row['title'];
                                ?>

                                <option value="<?php echo $id; ?>"><?php echo $title; ?></option>

                                <?php
                            }
                        }
                        else {
                            # we do not have category
                            ?>
                            <option value="0">No category found</option>
                            <?php
                        }

                        //2.Display on dropdown
                        

                        ?>

                    </select>
                </td>
            </tr>

            <tr>
                <td>Featured: </td>
                <td>
                    <input type="radio" name = "featured" value="Yes">Yes
                    <input type="radio" name="featured" value="No">No
                </td>
            </tr>

            <tr>
                <td>Active: </td>
                <td>
                <input type="radio" name = "active" value="Yes">Yes
                <input type="radio" name="active" value="No">No
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                </td>
            </tr>
        </table>
        </form>

        <?php 
        //Check whether the button is clicked or not
        if (ISSET($_POST['submit'])) {
            # add food in the database
            # echo "clicked";

            //1. Get the data from form
            $title = mysqli_real_escape_string($conn, $_POST['title']);
            $description = mysqli_real_escape_string($conn, $_POST['description']);
            $price = mysqli_real_escape_string($conn, $_POST['price']);
            $category = mysqli_real_escape_string($conn, $_POST['category']);
            
            //Check whether radio button for featured and active aere checked or not
            if (isset($_POST['featured'])) {
                $featured = $_POST['featured'];

            }
            else {
                $featured = "No"; //setting the default value

            }

            if (ISSET($_POST['active'])) {
                $active = $_POST['active'];
            }
            else {
                $active = "No"; //Setting the default value
            }

            //2. Upload the image if selected
            //check whether the select image is clicked or not and upload the image only if the image is selected
            if (ISSET($_FILES['image']['name'])) {
                //Get the details of the selected image
                $image_name = $_FILES['image']['name'];

                //check whether the image is selected or not and upload image only if selected
                if ($image_name!="") {
                    # image is selected

                    //A. Rename the image
                    //get the extension of selected image(.jpg, .png, gif, etc) "Thee-zillah.jpg" thee-zillah jpg
                    $ext = end(explode('.', $image_name));

                    //Create new name for image
                    $image_name = "Food-Name-".rand(0000,9999).".".$ext; //New image name may be like "Food-Name-716.jpg"

                    //B. Upload the image
                    //get the src path and destination path

                    //Source path is the current location of the image 
                    $src = $_FILES['image']['tmp_name'];

                    //Destination path for the image to be uploaded
                    $dst = "../images/food/".$image_name;

                    //finally upload the food image
                    $upload = move_uploaded_file($src, $dst);

                    //check whether image uploaded or not
                    if ($upload == false) {
                        # failed to upload image
                        //redirrect to add-food page with error message
                        $_SESSION['upload'] = "<div class = 'error'>Failed to upload image</div>";
                        header('location:'.SITEURL."admin/add-food.php");
                        //stop the process
                        die();
                    }

                }
            }
            else {
                $image_name = ""; //setting default value as blank
            }

            //3. Insert into database

            //Create SQL query to save our add food
            //For numerical value we do not need to pass value inside quotes but for string value it is compulsory to add quotes
            $sql2 = "INSERT INTO tbl_food SET
            title = '$title',
            description = '$description',
            price = $price,
            image_name = '$image_name',
            category_id = $category,
            featured = '$featured',
            active = '$active'
            ;";

            //execute the query
            $res2 = mysqli_query($conn, $sql2);
            //check whether data is inserted or not
            //4. Redirect with message to manage food page

            if ($res2 == true) {
                # data inserted successfully
                $_SESSION['add'] = "<div class = 'success'>Food Added successfully</div>";
                header('location: '.SITEURL.'admin/manage-food.php');

            }
            else {
                //failed to insert data
                $_SESSION['add'] = "<div class = 'error'>Failed to add Food</div>";
                header('location: '.SITEURL.'admin/manage-food.php');
            }


        }
        ?>
    </div>
</div>

<?php 
include('partials/footer.php')
?>