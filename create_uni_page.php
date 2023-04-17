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
        <title>Create University</title>
        <meta name="viewpoint" content="width=device-width">

        <!-- <link rel="stylesheet" href = "style.css" /> -->
        <?php 
            if (isset($_SESSION["current_user_role"]))
            {
                require 'nav_bar.php';
            }
        ?>
    </head>

    <body class="form_page">

        <div class="get_info_form">
            <!-- <div> -->
            <form class="create_form" action="create_uni.php" method="post">
                <h1 class="form_title">Create University</h1>
                
                <div class="form_content">

                    <div class="error_message">
                        <?php if (isset($_SESSION['uni_error_message'])) { ?>
                            <p class="error_message"><?php echo $_SESSION['uni_error_message'];?></p>
                        <?php
                                unset($_SESSION['uni_error_message']);
                            }
                        ?>
                    </div>

                    <div class="success_message">
                        <?php if (isset($_SESSION['uni_success_message'])) { ?>
                            <p class="success_message"><?php echo $_SESSION['uni_success_message'];?></p>
                        <?php
                                unset($_SESSION['uni_success_message']);
                            }
                        ?>
                    </div>

                    <label for="new_uni_name">University: </label>
                    <input type="text" id="new_uni_name" name="new_uni_name" required>

                    <br>
                    <br>

                    <label for="new_uni_description">University Desciption: </label>
                    <input type="text" id="new_uni_description" name="new_uni_description" required>

                    <br>
                    <br>

                    <label for="new_uni_email_domain">University Email Domain: </label>
                    <input type="text" id="new_uni_email_domain" name="new_uni_email_domain" required>
                    
                    <br>
                    <br>

                    <label for="new_uni_address">University Address: </label>
                    <input type="text" id="new_uni_address" name="new_uni_address" required>
                    
                    <br>
                    <br>

                    <button class="submit_button" type="submit">Log in</button>
                </div>
            </form>
        </div>

        

    </body>
</html>

