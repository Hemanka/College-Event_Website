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
            <form class="usersInfo" action="sign_in_user.php" method="post">
                <h1 class="login_tag">LOGIN</h1>

                <div class="error_message">
                    <?php if (isset($_SESSION['login_error_message'])) { ?>
                        <p><?php echo $_SESSION['login_error_message'];?></p>
                    <?php
                            unset($_SESSION['login_error_message']);
                        }
                    ?>
                </div>



                <div class="success_message">

                    <?php if (isset($_SESSION['sign_up_success_message'])) { ?>
                        <p><?php echo $_SESSION['sign_up_success_message'];?></p>
                    <?php
                            unset($_SESSION['sign_up_success_message']);
                        }
                    ?>
                </div>

                <div class="login_form_text">
                    <label for="username">Username: </label>
                    <input type="text" id="username" name="username" required>

                    <br>
                    <br>

                    <label for="password">Password: </label>
                    <input type="password" id="password" name="password" required>
                    
                    <br>
                    <br>

                    <button class="login_button" type="submit">Log in</button>
                    <!-- <a href = "registration_page.php">Sign Up</a> -->
                    <p class="option">or <u><a class="login_link" href = "registration_page.php">Sign Up</a></u></p>
                </div>
            </form>
        <!-- </div> -->
        </div>

        

    </body>
</html>