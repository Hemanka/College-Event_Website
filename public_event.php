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
    $sql = "SELECT * FROM Events WHERE event_type = 'Public'
                                    AND event_id NOT IN (SELECT event_id FROM Approval)";
    $result = mysqli_query($connect, $sql);
    $numRows = mysqli_num_rows($result);
    //need to remove this
    // echo $numRows;
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
        <div class="info">
        <h1 class="page_title">Public event Information</h1>
        <!-- <a href = "create_rso_page.php">Create New RSO</a> -->
        <!-- <button onclick="displayApprovalForm()" id="approval_button" name="approval_button">Approval</button> -->

        <div class="success_message">
            <!-- <?php if (isset($_SESSION['rso_created_success_message'])) { ?>
                <p><?php echo $_SESSION['rso_created_success_message'];?></p>
            <?php
                    unset($_SESSION['rso_created_success_message']);
                }
            ?> -->

            <!-- need to show the message for success in creating a public event -->
            <?php if (isset($_SESSION['event_success_message'])) { ?>
                <p><?php echo $_SESSION['event_success_message'];?></p>
            <?php
                    unset($_SESSION['event_success_message']);
                }
            ?>
            
        </div>

        <?php while ($info = mysqli_fetch_array($result)) {?>
            <div class="events_list">
                <a href="event_info.php?<?php echo $info['event_id']?>">
                    <div class="event_info">
                        <h2 class="event_name"><?php echo $info['event_name']?></h2>
                        <!-- <p>Category: <?php echo $info['event_cat']?></p> -->
                        <p class="desciption"><?php echo $info['event_description']?></p>
                    </div>
                    <?php
                        $event_id = $info['event_id'];
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
                        <!-- <p><?php echo $info['event_description']?></p> -->
                        <!-- <br> -->
                    </div>
                </a>
            </div>
        
        <?php }?>
        </div>
    </body>
</html>