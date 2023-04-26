<?php include('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>

        <br><br>

        <?php 
        if (ISSET($_SESSION['add'])) { //check whether session is set or not
            echo $_SESSION['add']; //dislpay session message if set
            unset ($_SESSION['add']); //remove session message
        }?>

        <form action="" method="POST">

        <table class="tbl-30">
            <tr>
                <td>Full Name: </td>
                <td><input type="text" name="full_name" placeholder="Enter your name"></td>
            </tr>

            <tr>
                <td>Username: </td>
                <td><input type="text" name="username" placeholder="Your Username"></td>
            </tr>

            <tr>
                <td>Password: </td>
                <td><input type="password" name="password" placeholder="Your Password"></td>
            </tr>

            <tr>
                <td colspan="2">
                <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                </td>
            </tr>
        </table>
        </form>
    </div>
</div>

<?php include('partials/footer.php');?>

<?php 
//Process the Data from form and save it on a Database
//Check whether the submit button is clicked or not

if (ISSET($_POST['submit'])) {
    //Button Clicked
    //echo "Button Clicked";

    //1. Get the data from form
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']); //password encryptiom with md5

    //2. SQL query to save the data in the database
    $sql = "INSERT INTO tbl_admin SET
    full_name='$full_name',
    username = '$username',
    password = '$password';";

   


    //3. Executing query and saving data in database
    $res = mysqli_query($conn, $sql) or die(mysqli_error());

    //4. Check whether data (query is executed) is inserted in database or not and display appropriate message
    if ($res == true){
        //Data is inserted
        //echo "Data inserted";
        //Create session variable to display message
        $_SESSION['add'] = "Admin added successfully";
        //redirect page to manage admin
        header("location:".SITEURL.'admin/manage-admin.php');

    }
    else{
        //failed to insert data
        //echo "Failed to insert data";
        //Create session variable to display message
        $_SESSION['add'] = "Failed to Add Admin";
        //redirect page to add admin
        header("location:".SITEURL.'admin/add-admin.php');
    }
    




}


?>