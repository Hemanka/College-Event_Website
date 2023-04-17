<!-- 
    THING TO WORK ON THIS FILE:
    - displaying of map
    - displaying the date and time of the event
    - going back to the previous page

    - need to provide this page: the event_id
 -->

<?php
    // echo "on the event_info page";
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

    // store the event_id
    $current_event_info = $_SERVER['QUERY_STRING'];

    $sql = "SELECT * FROM Events WHERE event_id='$current_event_info'";
    $result = mysqli_query($connect, $sql);
    $info = mysqli_fetch_array($result);

    if (isset($_SESSION['edit_comment']))
    {
        $current_edit_comment_id = $_SESSION['edit_comment_id'];
        $edit_comment_sql = "SELECT * FROM Comments WHERE comment_id='$current_edit_comment_id'";
        $edit_comment_result = mysqli_query($connect, $edit_comment_sql);   
        $edit_comment_info = mysqli_fetch_array($edit_comment_result);

        echo "<br>success";
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <!-- name of the event can be shown here -->
        <title>Event Info</title>

        <meta name="viewpoint" content="width=device-width">
        <?php 
            if (isset($_SESSION["current_user_role"]))
            {
                require 'nav_bar.php';
            }
        ?>

    </head>

    <body>
        <!-- <?php //while ($info = mysqli_fetch_array($result)) {?> -->
            <!-- basic information of the current event -->
        <div class="info">
            <div class="header">
                <div class="title">
                    <h1 class="page_title"><?php echo $info['event_name']?></h1>
                </div>

                <div class="action_rso">
                    <?php if (strcasecmp($info['event_type'], "Public") == 0) {?>
                        <a class="go_back" href="public_event.php"> Go Back</a>
                    <?php } else if (strcasecmp($info['event_type'], "Private") == 0) {?>
                        <a class="go_back" href="private_event.php"> Go Back</a>
                    <?php } else if (strcasecmp($info['event_type'], "Rso") == 0) {?>
                        <a class="go_back" href="rso_event.php"> Go Back</a>
                    <?php } else { /* this should never run*/ }?>

                    <?php 
                        $event_approval_sql = "SELECT * FROM Approval A1 WHERE A1.event_id='$current_event_info'";
                        if ($event_approval_result = mysqli_query($connect, $event_approval_sql))
                        {
                            $event_approval_info = mysqli_fetch_array($event_approval_result);
                    ?>
                            <!-- // echo "approval need<br>"; -->
                            <a class="go_back" href="event_approval.php?<?php echo $event_approval_info['approval_id']?>"> Approve </a>
                            <a class="go_back" href="event_decline.php?<?php echo $event_approval_info['approval_id']?>"> Decline</a>
                    <?php } ?>
                </div>
            </div>
            <!-- <> -->
            <!-- <p>--the date and time would be displayed here--</p> -->
            <!-- date and time of the event is displayed here -->
            <?php
                $get_date_sql = "SELECT *
                -- E1.start_time AS e_start_date, E1.end_time AS e_end_date
                                    FROM Events E1 WHERE E1.event_id='$current_event_info'";
                $get_date_result = mysqli_query($connect, $get_date_sql);
                $get_date_info = mysqli_fetch_array($get_date_result);

                // $start_time_info = new DateTime($get_date_info['start_time']);
                // $end_time_info = new DateTime($get_date_info['end_time']);
                $event_date_info = date('j F Y', strtotime($get_date_info['event_date']));
                $start_time_info = date('g:i A', strtotime($get_date_info['start_time']));
                $end_time_info = date('g:i A', strtotime($get_date_info['end_time']));
            ?>
            <p>Date: <?php echo $event_date_info;?></p>
            <p>Time: <?php echo $start_time_info;?> - <?php echo $end_time_info;?></p>

                
            
            <!-- description of the event is displayed -->
            <p>Description: <?php echo $info['event_description']?></p>

            <!-- <p>--map will be displayed here--</p> -->

            <!-- code to get the long and lat -->
            <?php
                // get the latitude and longitude of the current event
                $event_loc_id = $get_date_info['loc_id'];
                $get_loc_sql = "SELECT * FROM Event_location WHERE loc_id='$event_loc_id'";
                $get_loc_result = mysqli_query($connect, $get_loc_sql);
                $get_loc_info = mysqli_fetch_array($get_loc_result);

                $latitude = $get_loc_info['latitude'];
                $longitude = $get_loc_info['longitude'];


                // $temp_get_sql = "SELECT * FROM Events WHERE event_id='1'";
                // $temp_get_result = mysqli_query($connect, $temp_get_sql);

                // $temp_get_info = mysqli_fetch_array($temp_get_result);

                // echo $temp_get_info['latitude'];
                // echo "<br>";
                // echo $temp_get_info['longitude'];
                
            ?>
            <div id="event_info_map">
                <p>Location Name: <?php echo $get_loc_info['loc_name'];?></p>
                <iframe id="single_location" src="https://maps.google.com/maps?q=<?php echo $latitude;?>,<?php echo $longitude;?>&output=embed"></iframe>
            </div>

            <h3>Comments:</h3>

            <!-- the user can add comments to the current event -->
            <?php if (!isset($_SESSION['edit_comment'])) {?>
                <form action="addComment.php" method="post">
                    <!-- <label for="comment">Add Comments about this event</label> -->
                    <textarea rows="4" cols="75" id="comment" name="comment"></textarea>
                    <button class="comment_button" type="submit" name="add_comment" value="<?php echo $info['event_id']?>">Add Comment</button>
                </form>
            <?php }?>

            <!-- show comments that have been already made to this event -->
            <?php
                $current_event_id = $info['event_id'];
                $comment_sql = "SELECT * FROM Comments WHERE event_id=$current_event_id";
                $comment_result = mysqli_query($connect, $comment_sql);

                while ($comment_info = mysqli_fetch_array($comment_result)) {
            ?>
                <div class="display_comments">
                    <form action="deleteComment.php" method="post">
                        
                        <!-- display user's first and last name here -->
                        <!-- an option would to show the comments as 'comment 1' and so on -->
                        <!-- <div class=comment_text> -->
                        <!-- <?php echo "in the if stmt";?> -->
                        <?php if (isset($_SESSION['edit_comment']) && 
                                    (strcasecmp(($comment_info['comment_id']), ($_SESSION['edit_comment_id'])) == 0)) {?>
                            <!-- <?php echo "in the if stmt";?> -->
                            <textarea rows="3" cols="75" id="edit_comment" name="edit_comment"><?php echo $comment_info['comment_text']?></textarea>
                            <button type="submit" name="edit_comment_done" value="<?php echo $comment_info['comment_id']?>">Done</button>
                        <?php } else {?>
                            <p><?php echo $comment_info['comment_text']?></p>
                            
                            <!-- if the comment is by the current user than they can delete the comment -->
                            <?php
                                if (((strcasecmp(($comment_info['user_id']), ($_SESSION['current_user_id'])) == 0) || 
                                                    (strcasecmp($_SESSION["current_user_role"], "Super Admin") == 0)) &&
                                                    (!isset($_SESSION['edit_comment']))) {
                            ?>
                                <!-- edit and delete comments -->
                                <button type="submit" name="edit_comment_button" value="<?php echo $comment_info['comment_id']?>">Edit Comment</button>
                                <!-- <button onclick="window.location.href='deleteComment.php'">Delete Comment</button>-->
                                <button type="submit" name="delete_comment" value="<?php echo $comment_info['comment_id']?>">Delete Comment</button>
                            <?php } ?>
                        <?php } ?>
                        <!-- </div> -->
                    </form>
                </div>
            <?php }?>
        </div>
        <!-- <?php //}?> -->
        

        <!-- need to be done: return back to the page where the user was previously -->
        <!-- NEED TO CHANGE THE DISPLAY OF THE LINK TO LOOK MORE LIKE A BUTTON -->
        <!-- <?php if (strcasecmp($info['event_type'], "Public") == 0) {?>
            <a href="public_event.php"> Go Back</a>
        <?php } else if (strcasecmp($info['event_type'], "Private") == 0) {?>
            <a href="private_event.php"> Go Back</a>
        <?php } else if (strcasecmp($info['event_type'], "Rso") == 0) {?>
            <a href="rso_event.php"> Go Back</a>
        <?php } else { /* this should never run*/ }?> -->
        <!-- <a href=""></a> -->
    </body>

</html>