<?php
    // echo "<br>here";
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

    // echo "<br>here at least";

    // delete the current comment
    if (isset($_POST['delete_comment']))
    {
        // echo "<br>deleting...";
        $current_comment_id = $_POST['delete_comment'];
    
        // get the event_id, so the previous page could be displayed
        $sql = "SELECT * FROM Comments WHERE comment_id='$current_comment_id'";
        $result = mysqli_query($connect, $sql);   
        $info = mysqli_fetch_array($result);
    
        $current_event_id = $info['event_id'];
        
        // delete the comment
        $sql = "DELETE FROM Comments WHERE comment_id='$current_comment_id'";
        $result = mysqli_query($connect, $sql);
    
        header("location: event_info?$current_event_id#comment_section_starts");
    }
    else if (isset($_POST['edit_comment_button'])) 
    {
        // echo "<br>editing...";
        $current_comment_id = $_POST['edit_comment_button'];
        $_SESSION['edit_comment_id'] = $current_comment_id;
        $_SESSION['edit_comment'] = 'true';

        // get the event_id, so the previous page could be displayed
        $sql = "SELECT * FROM Comments WHERE comment_id='$current_comment_id'";
        $result = mysqli_query($connect, $sql);   
        $info = mysqli_fetch_array($result);
    
        $current_event_id = $info['event_id'];
        header("location: event_info?$current_event_id#comment_section_starts");
    }
    // edit the comment
    else if (isset($_POST['edit_comment_done'])) 
    {
        // echo "updating";
        // echo "at the right place";
        $new_comment_text = $_POST['edit_comment'];
        $current_comment_id = $_SESSION['edit_comment_id'];

        $sql = "SELECT * FROM Comments WHERE comment_id='$current_comment_id'";
        $result = mysqli_query($connect, $sql);   
        $info = mysqli_fetch_array($result);

        $comment_event_id = $info['event_id'];
        $comment_user_id = $info['user_id'];

        // // insert the new comment
        // $sql_insert = "INSERT INTO Comments(event_id, user_id, comment_text)
        //                 VALUE ($comment_event_id, $comment_user_id, '$new_comment_text')";
        // $result_insert = mysqli_query($connect, $sql_insert);

        // // delete the old comment
        // $sql_delete = "DELETE FROM Comments WHERE comment_id='$current_comment_id'";
        // $result_delete = mysqli_query($connect, $sql_delete);
        $sql_update_comment = "UPDATE Comments SET comment_text='$new_comment_text' WHERE comment_id='$current_comment_id'";
        $result_delete = mysqli_query($connect, $sql_update_comment);

        // get the event_id, so the previous page could be displayed
        unset($_SESSION['edit_comment_id']);
        unset($_SESSION['edit_comment']);
        // $sql = "SELECT * FROM Comments WHERE comment_id='$current_comment_id'";
        // $result = mysqli_query($connect, $sql);   
        // $info = mysqli_fetch_array($result);
    
        $current_event_id = $info['event_id'];
        header("location: event_info?$comment_event_id#comment_section_starts");
        // echo "editing....";
    }
    // echo "working...";
    // else
    // {
    //     echo "done editing";
    // }
    // else
    // {
    //     echo "something is wrong";
    // }

?>