<?php
    session_start();

    if (!isset($_SESSION["current_user_id"]))
    {
        header("location: login.php");
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Create RSO</title>
        <meta name="viewpoint" content="width=device-width">

        <!-- <link rel="stylesheet" href = "style.css" /> -->
        <?php 
            if (isset($_SESSION["current_user_role"]))
            {
                require 'nav_bar.php';
            }
        ?>
    </head>

    <body>
        <!-- <div class="info"> -->

        <form action="create_rso.php" method="post">
            <h1>Create New RSO</h1>
            
            <div class="login_form_text">

                <div class="error_message">
                    <?php if (isset($_SESSION['error_message'])) { ?>
                        <p><?php echo $_SESSION['error_message'];?></p>
                    <?php
                            unset($_SESSION['error_message']);
                        }
                    ?>
                </div>

                <label for="rso_name">RSO Name: </label>
                <input type="text" id="new_rso_name" name="new_rso_name" required>

                <br><br>

                <label>Please fill in the information needed to create an RSO</label>

                <br><br>

                <label for="admin_user_email">Admin Email address: </label>
                <input type="text" id="admin_user_email" name="admin_user_email" required>

                <br><br>

                <label for="first_user_email">First Member Email address: </label>
                <input type="text" id="first_user_email" name="first_user_email" required>
                
                <br><br>

                <label for="second_user_email">Second Member Email address: </label>
                <input type="text" id="second_user_email" name="second_user_email" required>
                
                <br><br>

                <label for="third_user_email">Third Member Email address: </label>
                <input type="text" id="third_user_email" name="third_user_email" required>
                
                <br><br>

                <label for="fourth_user_email">Fourth Member Email address: </label>
                <input type="text" id="fourth_user_email" name="fourth_user_email" required>

                <br><br>

                <button type="submit">Create RSO</button>
            </div>
        </form>
        <!-- </div> -->
        

    </body>
</html>