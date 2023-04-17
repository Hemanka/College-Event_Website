<?php
    if (!isset($_SESSION["current_user_id"]))
    {
        header("location: login.php");
    }

    $db_servername = "localhost";
    $db_username = "root";
    $db_password = "password";
    $db_name = "college_event_db";

    $connect = new mysqli($db_servername, $db_username, $db_password, $db_name);
    if ($connect->connect_error)
    {
        die("Connection failed");
    }

    // $nav_sql = "SELECT * FROM Users WHERE user_id = '$_SESSION["current_user_id"]'";
    // $nav_result = mysqli_query($connect, $sql);
    // $nav_info = mysqli_fetch_array($result);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Student Nav</title>
        <meta name="viewpoint" content="width=device-width">

        <!-- <link rel="stylesheet" href = "style.css" /> -->
        <style><?php include 'style.css'?></style>

        <div>
            <nav>
                <div>
                <a class="nav_text" href = "public_event.php">Public Events</a>
                <a class="nav_text" href = "private_event.php">Private Events</a>
                <a class="nav_text" href = "rso_event.php">RSO Events</a>
                <a class="nav_text" href = "create_rso_page.php">Create New RSO</a>

                <?php if ((strcasecmp($_SESSION["current_user_role"], "Admin") == 0) ||
                            (strcasecmp($_SESSION["current_user_role"], "Super Admin") == 0)) {?>
                    <a class="nav_text" href = "create_event_page.php">Create New Event</a>
                <?php }?>

                <?php if (strcasecmp($_SESSION["current_user_role"], "Super Admin") == 0) {?>
                    <a class="nav_text" href = "create_uni_page.php">Create New University</a>
                    <!-- <a class="nav_text" href = "event_approval_page.php">Event Approvals</a> -->
                <?php }?>
                </div>


                <div>
                <a class="nav_text logout_text" href = "logout.php">Log out</a>
                </div>
            </nav>
        </div>

    </head>
</html>