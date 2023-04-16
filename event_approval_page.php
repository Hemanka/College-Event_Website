<?php
    session_start();
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

    // for displaying all the public events
    $sql = "SELECT * FROM Events WHERE event_id IN (SELECT event_id FROM Approval)";
    $result = mysqli_query($connect, $sql);

    $numRows = mysqli_num_rows($result);
    //need to remove this
    echo $numRows;
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Event Approval Page</title>

        <meta name="viewpoint" content="width=device-width">

        <!-- displays a nav based on the current user -->
        <?php 
            if (isset($_SESSION["current_user_role"]))
            {
                require 'nav_bar.php';
            }
        ?>

    </head>

    <body>
        <h1>Event Approval Page</h1>

        <?php if ($numRows > 0) { 
            // $get_approval_sql = "SELECT * FROM Events WHERE event_id";    
        ?>
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
        <?php } else {?>
            <p>No Events Need to be approved</p>
        <?php }?>
    </body>
</html>