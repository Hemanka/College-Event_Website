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

        <!-- <link rel="stylesheet" href = "style.css"/> -->

        <!-- <div>
            <nav>
                <a class="nav_text" href = "login.php">Login</a>
                <a class="nav_text" href = "rso_event.php">RSO Events</a>

                <a class="logout_text nav_text" href = "logout.php">Log out</a>
            </nav>
        </div> -->
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

                $_SESSION["message_testing"] = "message working";
            }
        ?>

    </head>

    <body>
        <h1>Public event Information</h1>
        <!-- success message for creating a event -->
        <!-- <?php if (isset($_SESSION["message_testing"])) {?>
            <p><?php echo $_SESSION["message_testing"];?><p>
            <br><br>
        <?php 
                unset($_SESSION["message_testing"]);
            }

        ?> -->

        <!-- <br> -->

        <table>
            <?php while ($info = mysqli_fetch_array($result)) {?>
                <tr>
                    <div class="event_info">
                        <!-- <td>
                            currently working on displaying the event info here 
                        <td> -->
                        <!-- <p>display the name of the event</p> -->
                        <h2><?php echo $info['event_name']?></h2>
                        <p>--the date and time would be displayed here--</p>
                        <p><?php echo $info['event_description']?></p>
                        <p>--map will be displayed here--</p>
                        <h3>Comments:</h3>
                        <!-- <br> -->
                        <form action="add_comment.php" method="post">
                            <!-- <label for="comment">Add Comments about this event</label> -->
                            <textarea rows="4" cols="75" id="comment" name="comment"></textarea>
                            <button class="comment_button" type="submit" name="button_val" value="<?php echo $info['event_id']?>">Add Comment</button>
                        </form>
                        <!-- display comment for the current event -->
                        <?php
                            $current_event_id = $info['event_id'];
                            $comment_sql = "SELECT * FROM Comments WHERE event_id=$current_event_id";
                            $comment_result = mysqli_query($connect, $comment_sql);

                            while ($comment_info = mysqli_fetch_array($comment_result)) {
                        ?>
                            <div class="display_comments">
                                <!-- display user's first and last name here -->
                                <!-- an option would to show the comments as 'comment 1' and so on -->
                                <p><?php echo $comment_info['comment_text']?></p>
                                    <?php
                                        if (strcasecmp(($comment_info['user_id']), ($_SESSION['current_user_id'])) == 0) {
                                    ?>
                                        <button onclick="window.location.href='deleteComment.php'">Delete Comment</button>
                                    <?php } ?>
                            </div>
                        <?php }?>
                        <br>
                        <br>
                    </div>
                </tr>
                <!-- <p>workinng <?php echo $info['event_name']?></p> -->
                <!-- <a  id="<?php echo $info['event_id']?>" href="event_info.php"><?php echo $info['event_name']?></a> -->

            <?php }?>
        </table>

    </body>
</html>