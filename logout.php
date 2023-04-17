<?php
    session_start();
    // unset($_SESSION["current_user_role"]);
    // unset($_SESSION["current_user_id"]);
    if (!isset($_SESSION["current_user_id"]))
    {
        header("location: login.php");
        die();
    }
    session_unset();

    $_SESSION["logout_success_message"] = "Logout Successfull!";
    header("location: login.php");
?>

<!-- <!DOCTYPE html>
<html>
    <head>
        <title>Login Page</title>

        <meta name="viewpoint" content="width=device-width">

        <style><?php include 'style.css'?></style>

        <div>
            <nav>
                <a class="nav_text logout_text" href="login.php">Log in</a>
            </nav>
        </div>
    </head> -->

    <!-- <body> -->
        <!-- <h1>Logout Successful</h1> -->
        <!-- <> -->
    <!-- </body> -->
<!-- </html> -->