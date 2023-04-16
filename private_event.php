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
    
    if (isset($_SESSION["current_user_role"]))
    {
        // show all the private events to the super admin user
        if (strcasecmp($_SESSION["current_user_role"], "Super Admin") == 0)
        {
            
            $private_event_sql = "SELECT * FROM Events E1 WHERE E1.event_type = 'Private'";
            $private_event_result = mysqli_query($connect, $private_event_sql);
            $numRows = mysqli_num_rows($private_event_result);
        }
        // private events related to the current user is shown
        else
        {
            $private_page_uid = $_SESSION["current_user_id"];

            // to get the current user uni_id
            $user_sql = "SELECT * FROM Users U WHERE U.user_id = '$private_page_uid'";
            $user_result = mysqli_query($connect, $user_sql);
            $user_info = mysqli_fetch_array($user_result);

            // query to get the list of private events from the current user's university
            $private_event_sql = "SELECT * FROM Events E2 WHERE E2.uni_id = '$user_info[uni_id]' AND E2.event_type = 'Private'";
            // "SELECT * FROM Events E1 WHERE E1.event_type = 'Private'
            //                         AND E1.event_id IN (SELECT * FROM Events E2 WHERE E2.uni_id = '$user_info[uni_id]')";
            $private_event_result = mysqli_query($connect, $private_event_sql);
            // $numRows = mysqli_num_rows($private_event_result);
            if ($private_event_result == FALSE)
            {
                echo "empty";
            }
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Private Events</title>

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
    <div class ="info">
        <h1>Private event Information</h1>

        <div class="success_message">
            <?php if (isset($_SESSION['event_success_message'])) { ?>
                <p><?php echo $_SESSION['event_success_message'];?></p>
            <?php
                    unset($_SESSION['event_success_message']);
                }
            ?>
        </div>

        <?php while ($private_event_info = mysqli_fetch_array($private_event_result)) {?>
            <div class="events_list">
            <a href="event_info.php?<?php echo $private_event_info['event_id']?>">
                <div class="event_info">
                    <p>University: 
                        <?php 
                            $event_uni_id = $private_event_info['uni_id'];

                            $get_uniname_sql = "SELECT * FROM University Un WHERE Un.uni_id = '$event_uni_id'";
                            $get_uniname_result = mysqli_query($connect, $get_uniname_sql);
                            $get_uniname_info = mysqli_fetch_array($get_uniname_result);

                            echo $get_uniname_info['uni_name'];
                        ?>
                    </p>    
                    <h2 class="event_name"><?php echo $private_event_info['event_name']?></h2>
                    <p class="desciption"><?php echo $private_event_info['event_description']?></p>
                </div>
                <?php
                        $event_id = $private_event_info['event_id'];
                        $date_display_sql = "SELECT * FROM Events E1 WHERE E1.event_id='$event_id'";
                        $date_display_result = mysqli_query($connect, $date_display_sql);
                        $date_display_info = mysqli_fetch_array($date_display_result);

                        $current_event_date_info = date('j F Y', strtotime($date_display_info['event_date']));
                        $current_start_time_info = date('g:i A', strtotime($date_display_info['start_time']));
                        $current_end_time_info = date('g:i A', strtotime($date_display_info['end_time']));
                    ?>
                <div class="event_info time_info">
                <p>Date: <?php echo $current_event_date_info;?></p>
                        <p>Time: <?php echo $current_start_time_info;?> - <?php echo $current_end_time_info;?></p>    
                <!-- <p>--the date and time would be displayed here--</p> -->
                    <!-- <br> -->
                </div>
            </a>
            </div>
        <?php }?>
    </div>
    </body>
</html>