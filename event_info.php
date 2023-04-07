<!-- 
    THING TO WORK ON THIS FILE:
    - displaying of map
    - displaying the date and time of the event
    - going back to the previous page
 -->

<?php
    echo "on the event_info page";
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

    // store the event_id
    // echo $_SERVER['QUERY_STRING'];
    $current_event_info = $_SERVER['QUERY_STRING'];

    $sql = "SELECT * FROM Events WHERE event_id='$current_event_info'";
    $result = mysqli_query($connect, $sql);

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
        <title>Public Events</title>

        <meta name="viewpoint" content="width=device-width">
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

                // $_SESSION["message_testing"] = "message working";
            }
        ?>

    </head>

    <body>
        <?php while ($info = mysqli_fetch_array($result)) {?>
            <!-- basic information of the current event -->
            <h1><?php echo $info['event_name']?></h1>
            <p>--the date and time would be displayed here--</p>
            <p><?php echo $info['event_description']?></p>

            

            <p>--map will be displayed here--</p>
            <h3>Comments:</h3>

            <!-- the user can add comments to the current event -->
            <form action="addComment.php" method="post">
                <!-- <label for="comment">Add Comments about this event</label> -->
                <textarea rows="4" cols="75" id="comment" name="comment"></textarea>
                <button class="comment_button" type="submit" name="add_comment" value="<?php echo $info['event_id']?>">Add Comment</button>
            </form>

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
        <?php }?>
        

        <!-- need to be done: return back to the page where the user was previously -->
        <!-- <a href=""></a> -->
    </body>

</html>