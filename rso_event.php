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

    if (isset($_SESSION["current_user_id"]))
    {
        $user_rso = $_SESSION["current_user_id"];

        // gets the list of rso that user is part of 
        // $user_rso_sql = "SELECT * FROM Member_rso WHERE user_id = '$user_rso'";
        $user_rso_sql = "SELECT * FROM Events E1 WHERE E1.event_type = 'Rso' 
                            AND rso_id IN (SELECT M1.rso_id FROM Member_rso M1 WHERE M1.user_id = '$user_rso')";
        $user_rso_result = mysqli_query($connect, $user_rso_sql);

        // $user_rso_result_numRows = mysqli_num_rows($user_rso_result);

        // $temp_sql = "SELECT * FROM Member_rso M1 WHERE M1.user_id = '$user_rso'";
        // // if ($temp_sql != FALSE)
        // $temp_result  = mysqli_query($connect, $temp_sql);
        // if ($temp_result != FALSE)
        // {
        //     echo "working with something<br>";
        // }

        // $temp_info = mysqli_fetch_array($temp_result);
        // echo $temp_info['user_id'];
    }
    // for displaying all the public events
    // $numRows = mysqli_num_rows($result);
    //need to remove this
    // echo $numRows;
?>

<!DOCTYPE html>
<html>
<head>
        <title>Rso Events</title>

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
        <h1>RSO event Information</h1>

        <?php if (strcasecmp($_SESSION["current_user_role"], "Super Admin") == 0) {?>
            <?php 
                // $sa_rso_sql = "SELECT * FROM Events WHERE event_type = 'Rso'";
                // $sa_rso_result = mysqli_query($connect, $sa_rso_sql);
                
                $sa_rso_sql = "SELECT * FROM Events WHERE event_type = 'Rso'";
                $user_rso_result = mysqli_query($connect, $sa_rso_sql);
            ?>
        <?php } ?>
        <!-- else {?> -->

        <?php 
            $user_rso_result_numRows = mysqli_num_rows($user_rso_result);
            if ($user_rso_result_numRows != 0) {?>
            <?php while ($user_rso_info = mysqli_fetch_array($user_rso_result)) {?>
                <a href="event_info.php?<?php echo $user_rso_info['event_id']?>">
                    <div class="events_info">
                        <h2><?php echo $user_rso_info['event_name']?></h2>
                        <p>--the date and time would be displayed here--</p>
                        <p><?php echo $user_rso_info['event_description']?></p>
                        
                    </div>
                </a>
            <?php }?>
        <?php } else { ?>
            <!-- // this should be excuted if the no results found
            echo "something is wrong";}?> -->

            <p>No Upcoming events</p>
        <?php }?>

        <!-- <?php //}?> -->

        <!-- need to remove the code below  -->

        <!-- <?php while ($user_rso_info = mysqli_fetch_array($user_rso_result)) {?> -->
            <!-- <?php 
                $rso_event_id = $user_rso_info['rso_id'];
                $rso_event_sql = "SELECT * FROM Events WHERE rso_id = '$rso_event_id'";
                $rso_event_result = mysqli_query($connect, $rso_event_sql);
            ?>  -->

            <!-- display all the events for an rso -->
            <!-- <?php while ($rso_event_info = mysqli_fetch_array($rso_event_result)) {?>
                <a href="event_info.php?<?php echo $rso_event_info['event_id']?>">
                    <div class="events_info">
                        <h2><?php echo $rso_event_info['event_name']?></h2>
                        <p>--the date and time would be displayed here--</p>
                        <p><?php echo $rso_event_info['event_description']?></p>
                        
                    </div>
                </a>
            
            <?php }?> -->
        <!-- <?php }?> -->
    </body>
</html>