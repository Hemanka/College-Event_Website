<?php 
    require "create_table.php";
    session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Login Page</title>
        <meta name="viewpoint" content="width=device-width">

        <!-- <link rel="stylesheet" href = "style.css" /> -->
        <style><?php include 'style.css'?></style>

    </head>

    <body>

        <div class="user_info">
            <!-- <div> -->
            <form id="usersInfo" action="sign_in_user.php" method="post">
                <h1 class="login_tag">LOGIN</h1>

                <?php if (isset($_SESSION['login_error_message'])) { ?>
                    <p class="error_message"><?php echo $_SESSION['login_error_message'];?></p>
                <?php
                        unset($_SESSION['login_error_message']);
                    }
                ?>

                <div class="login_form_text">
                    <label for="username">Username: </label>
                    <input type="text" id="username" name="username" required>

                    <br>
                    <br>

                    <label for="password">Password: </label>
                    <input type="password" id="password" name="password" required>
                    
                    <br>
                    <br>

                    <button id="login_button" type="submit">Log in</button>
                </div>
            </form>
        <!-- </div> -->
        </div>

        

    </body>
</html>