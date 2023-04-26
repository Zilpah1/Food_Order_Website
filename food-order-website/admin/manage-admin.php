<?php include('partials/menu.php'); ?>

        <!-- Main Content section starts -->
        <div class = "main-content">
            <div class = "wrapper">
            <h1>Manage Admin</h1>
            <br/><br/>

            <?php 
            if (ISSET($_SESSION['add'])) {
                echo $_SESSION['add'];  //displaying session message
                unset ($_SESSION['add']); //removing session message
            }
            if (ISSET($_SESSION['delete']))
            {
                echo $_SESSION['delete'];
                unset ($_SESSION['delete']);
            }
            if (ISSET($_SESSION['update'])) {
                echo $_SESSION['update'];
                unset ($_SESSION['update']);
            }
            if (ISSET($_SESSION['user-not-found'])) {
                echo $_SESSION['user-not-found'];
                unset($_SESSION['user-not-found']);
            }
            if (ISSET($_SESSION['pwd-not-match'])) {
                echo $_SESSION['pwd-not-match'];
                unset ($_SESSION['pwd-not-match']);
            }
            if (ISSET($_SESSION['changed-pwd'])) {
                echo $_SESSION['changed-pwd'];
                unset ($_SESSION['changed-pwd']);
            }

            
            ?>
            <br><br>

            <!-- Button to add admin -->
            <a href="add-admin.php" class="btn-primary">Add Admin</a>

            <br/><br/><br/>
            <table class="tbl-full">
                <tr>
                    <th>S.N</th>
                    <th>Full Name</th>
                    <th>User Name</th>
                    <th>Actions</th>
                </tr>

                <?php 
                //Query to get all admins
                $sql = "SELECT * FROM tbl_admin";
                //Execute the query
                $res = mysqli_query($conn, $sql);
                //Check whether query is executed or not
                if ($res == true) {
                    #Count rows to chech whether we have data in a database or not
                    $count = mysqli_num_rows($res);  //function to get all rows in database

                    $sn = 1; //create a vriable and assign the value

                    //check num of rows
                    if ($count>0) {
                        # We have data in database
                        while($rows=mysqli_fetch_assoc($res))
                        {
                            //using while loop to get all data from db
                            //while loop will run as long as we have data in the database

                            //get individual data
                            $id = $rows['id'];
                            $full_name = $rows['full_name'];
                            $username = $rows['username'];

                            //Display the values in a table
                            ?>

                <tr>
                    <td><?php echo $sn++; ?> </td>
                    <td><?php echo $full_name; ?></td>
                    <td><?php echo $username; ?></td>
                    <td>
                        <a href="<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id;?>" class="btn-primary">Change Password</a>
                        <a href="<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id;?>" class="btn-secondary">Update Admin</a>
                        <a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id;?>" class="btn-danger">Delete Admin</a>
                    </td>
                </tr>



                            <?php

                        }
                    }
                    else {
                        # No data in database
                    }
                }

                ?>

               
            </table>
            </div>
        </div>
        <!-- Main Content section ends -->

       <?php include('partials/footer.php');?>