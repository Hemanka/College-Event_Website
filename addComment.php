<?php
    session_start();


    // store all the values that would be needed to insert the user's comment
    $current_event_id = $_POST['add_comment'];
    $current_user_comment_id = $_SESSION['current_user_id'];
    $comment = $_POST['comment'];
    $rating = $_POST['rating'];

    // connect to the database
    $db_servername = "localhost";
    $db_username = "root";
    $db_password = "password";
    $db_name = "college_event_db";

    $connect = new mysqli($db_servername, $db_username, $db_password, $db_name);
    if ($connect->connect_error)
    {
        die("Connection failed");
    }

    // get the current time and convert it to string
    $get_comment_time = new DateTime('America/New_York');
    $comment_time = $get_comment_time->format('Y-m-d H:i:s');
    
    // inserts the current user's comment to a event
    $sql = "INSERT INTO Comments(event_id, user_id, comment_time ,rating, comment_text)
            VALUE ($current_event_id, $current_user_comment_id, '$comment_time','$rating', '$comment')";
    $result = mysqli_query($connect, $sql);

    // return back to the page where the user was previously
    header("location: event_info?$current_event_id#comment_section_starts");

?>