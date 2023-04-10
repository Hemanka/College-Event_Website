<?php
    session_start();

    $db_servername = "localhost";
    $db_username = "root";
    $db_password = "password";
    $db_name = "college_event_db";

    $connect = new mysqli($db_servername, $db_username, $db_password, $db_name);
    if ($connect->connect_error)
    {
        die("Connection failed");
    }

    // for displaying all the public events
    $sql = "SELECT * FROM Events WHERE event_type = 'Public'";
    $result = mysqli_query($connect, $sql);
    $numRows = mysqli_num_rows($result);
    //need to remove this
    echo $numRows;
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Public Events</title>

        <meta name="viewpoint" content="width=device-width">

        <!-- displays a nav based on the current user -->
        <?php 
            // $_SESSION["current_user_role"] = "Student";
            if (isset($_SESSION["current_user_role"]))
            {
                require 'nav_bar.php';
                // if (strcasecmp($_SESSION["current_user_role"], "Student") == 0)
                // {
                //     require 'student_user_nav.php';
                // }
                // elseif (strcasecmp($_SESSION["current_user_role"], "Admin") == 0)
                // {
                //     require 'admin_user_nav.php';
                // }
                // else
                // {
                //     // nothing
                // }
            }
        ?>

    </head>

    <body>
        <h1>Public event Information</h1>

        <?php while ($info = mysqli_fetch_array($result)) {?>
            <a href="event_info.php?<?php echo $info['event_id']?>">
                <div class="events_info">
                    <h2><?php echo $info['event_name']?></h2>
                    <p>--the date and time would be displayed here--</p>
                    <p><?php echo $info['event_description']?></p>
                    <!-- <br> -->
                </div>
            </a>
        
        <?php }?>
    </body>
</html>