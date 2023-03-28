<?php
    session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Public Events</title>

        <meta name="viewpoint" content="width=device-width">

        <!-- <link rel="stylesheet" href = "style.css"/> -->

        <!-- <div>
            <nav>
                <a class="nav_text" href = "login.php">Login</a>
                <a class="nav_text" href = "rso_event.php">RSO Events</a>

                <a class="logout_text nav_text" href = "logout.php">Log out</a>
            </nav>
        </div> -->
        <?php 
            // $_SESSION["current_user_role"] = "Student";
            if (isset($_SESSION["current_user_role"]))
            {
                if (strcasecmp($_SESSION["current_user_role"], "Student") == 0)
                {
                    require 'student_user_nav.php';
                }
                elseif (strcasecmp($_SESSION["current_user_role"], "Admin") == 0)
                {
                    require 'admin_user_nav.php';
                }
                else
                {
                    // nothing
                }
            }
        ?>

    </head>

    <body>
        <h1>Public event Information</h1>
    </body>
</html>