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

    if (isset($_SESSION["current_user_id"]))
    {
        $current_user_id = $_SESSION["current_user_id"];

        // gets the list of rso events for every rso that user is part of 
        // $user_rso_sql = "SELECT * FROM Member_rso WHERE user_id = '$user_rso'";
        $user_rso_sql = "SELECT * FROM Events E1 WHERE E1.event_type = 'Rso' 
                            AND rso_id IN (SELECT M1.rso_id FROM Member_rso M1 WHERE M1.user_id = '$current_user_id')";
        $user_rso_result = mysqli_query($connect, $user_rso_sql);


        // the following query are for join rso form
        // $current_user_id = $_SESSION["current_user_id"];
        // query to get the current users uni_id
        $current_sql = "SELECT * FROM Users WHERE user_id='$current_user_id'";
        $current_result = mysqli_query($connect, $current_sql);
        $current_info = mysqli_fetch_array($current_result);

        $user_uni_id = $current_info['uni_id'];

        // get the list of rso that user is not a member of
        $rso_list_sql = "SELECT * FROM Rso R1 
                        WHERE R1.uni_id='$user_uni_id'
                                AND R1.rso_id NOT IN (SELECT M1.rso_id FROM Member_rso M1 WHERE M1.user_id='$current_user_id')";

        if (strcasecmp($_SESSION["current_user_role"], "Super Admin") == 0)
        {
            $rso_list_sql = "SELECT * FROM Rso R1 
                        WHERE R1.rso_id NOT IN (SELECT M1.rso_id FROM Member_rso M1 WHERE M1.user_id='$current_user_id')";
        }
        $rso_list_result = mysqli_query($connect, $rso_list_sql);

        // $user_part_of_rso_list_sql = "SELECT * FROM Member_rso M1 WHERE M1.user_id='$current_user_id'";
        $user_part_of_rso_list_sql = "SELECT * FROM Rso R1 
                                        WHERE R1.rso_id IN (SELECT M1.rso_id FROM Member_rso M1 WHERE M1.user_id='$current_user_id')";
        $user_part_of_rso_list_result = mysqli_query($connect, $user_part_of_rso_list_sql);

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

        <script src="new_event.js"></script>

    </head>

    <body>
        <div class="info">
            <!-- <a href="join_rso.php">Join RSO</a>
            <a href="leave_rso.php">Leave RSO</a> -->
            
        <!-- the h1 and the join and leave button would be in the same line -->
        <div class="header">
            <div class="title">
                <h1 class="page_title">RSO event Information</h1>
            </div>
            <div class="action_rso">
                <button onclick="displayJoinRso()" id="join_rso_button" name="join_rso_button">Join Rso</button>
                <button onclick="displayLeaveRso()" id="leave_rso_button" name="leave_rso_button">Leave Rso</button>
            </div>
        </div>
        <!-- form to join the rso -->
        <div id="join_rso_form" style="display: none;">
            <div class="join_or_leave">
            <form class="small_form" action="join_rso.php" method="post">
                <h3>Join RSO</h3>
                <!-- may change/ create new css class -->
                <!-- <div class="form_content"> -->
                    <!-- the user needs to choose a university -->
                    
                    <label for="rso_to_join">Choose the RSO you would like to join</label>
                    <select id="rso_to_join" name="rso_to_join" required>
                        <option value=""></option>
                        <?php while ($rso_list_info = mysqli_fetch_array($rso_list_result)) {?>
                            <option value="<?php echo $rso_list_info['rso_id']?>"><?php echo $rso_list_info['rso_name'];?></option>
                        <?php }?>
                    </select>

                    <br>
                    <br>

                <!-- </div> -->
                    <button class="join_or_leave_action_button" name='submit' type="submit">Join</button>
            </form>
            </div>
        </div>

        <!-- form to leave the rso -->
        <div id="leave_rso_form" style="display: none;">
            <!-- <p>display leave rso form</p> -->
            <div class="join_or_leave">
            <form class="small_form" action="leave_rso.php" method="post">
                <h3>Leave RSO</h3>
                <!-- may change/ create new css class -->
                <div class="login_form_text">
                    <!-- the user needs to choose a university -->
                    
                    <label for="rso_to_leave">Choose the RSO you would like to leave</label>
                    <select id="rso_to_leave" name="rso_to_leave" required>
                        <option value=""></option>
                        <?php while ($user_part_of_rso_list_info = mysqli_fetch_array($user_part_of_rso_list_result)) {?>
                            <option value="<?php echo $user_part_of_rso_list_info['rso_id']?>"><?php echo $user_part_of_rso_list_info['rso_name'];?></option>
                        <?php }?>
                    </select>

                    <br>
                    <br>

                    <button class="join_or_leave_action_button" name='submit' type="submit">Leave</button>
                </div>
            </form>
            </div>
        </div>

        <div id="rso_success_message_box" class="success_message">
            <?php if (isset($_SESSION['rso_created_success_message'])) { ?>
                <p><?php echo $_SESSION['rso_created_success_message'];?></p>
            <?php
                    unset($_SESSION['rso_created_success_message']);
                }
            ?>

            <?php if (isset($_SESSION['join_success_message'])) { ?>
                <p><?php echo $_SESSION['join_success_message'];?></p>
            <?php
                    unset($_SESSION['join_success_message']);
                }
            ?>

            <?php if (isset($_SESSION['leave_success_message'])) { ?>
                <p><?php echo $_SESSION['leave_success_message'];?></p>
            <?php
                    unset($_SESSION['leave_success_message']);
                }
            ?>

            <!-- need to show the message for success in creating a rso event -->
            <?php if (isset($_SESSION['event_success_message'])) { ?>
                <p><?php echo $_SESSION['event_success_message'];?></p>
            <?php
                    unset($_SESSION['event_success_message']);
                }
            ?>

        </div>

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
            <div class="events_list">
                <a href="event_info.php?<?php echo $user_rso_info['event_id']?>">
                    <div class="event_info">
                        <p>RSO Name: 
                            <?php 
                                $event_rso_id = $user_rso_info['rso_id'];

                                $get_rsoname_sql = "SELECT * FROM Rso R1 WHERE R1.rso_id = '$event_rso_id'";
                                $get_rsoname_result = mysqli_query($connect, $get_rsoname_sql);
                                $get_rsoname_info = mysqli_fetch_array($get_rsoname_result);

                                echo $get_rsoname_info['rso_name'];
                            ?>
                        </p>    
                        <h2 class="event_name"><?php echo $user_rso_info['event_name']?></h2>
                        <p class="desciption"><?php echo $user_rso_info['event_description']?></p>
                    </div>
                    <?php
                        $event_id = $user_rso_info['event_id'];
                        $date_display_sql = "SELECT * FROM Events E1 WHERE E1.event_id='$event_id'";
                        $date_display_result = mysqli_query($connect, $date_display_sql);
                        $date_display_info = mysqli_fetch_array($date_display_result);

                        $current_event_date_info = date('j F Y', strtotime($date_display_info['event_date']));
                        $current_start_time_info = date('g:i A', strtotime($date_display_info['start_time']));
                        $current_end_time_info = date('g:i A', strtotime($date_display_info['end_time']));
                    ?>
                    <div class="event_info time_info">
                        <!-- <p>--the date and time would be displayed here--</p> -->
                        <p>Date: <?php echo $current_event_date_info;?></p>
                        <p>Time: <?php echo $current_start_time_info;?> - <?php echo $current_end_time_info;?></p>
                    </div>
                </a>
            </div>
            <?php }?>
        <?php } else { ?>
            <!-- // this should be excuted if the no results found
            echo "something is wrong";}?> -->

            <p>No Upcoming events</p>
        <?php }?>
    </div>

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