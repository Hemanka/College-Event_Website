<?php
    session_start();

    if (!isset($_SESSION["current_user_id"]))
    {
        header("location: login.php");
    }

    // the approval id that contain the event_id that is being approved
    $event_approval_id = $_SERVER['QUERY_STRING'];
    // echo "event is approved<br>";

    $db_servername = "localhost";
    $db_username = "root";
    $db_password = "password";
    $db_name = "college_event_db";

    $connect = new mysqli($db_servername, $db_username, $db_password, $db_name);
    if ($connect->connect_error)
    {
        die("Connection failed");
    }

    $event_is_approved_sql = "DELETE FROM Approval WHERE approval_id='$event_approval_id'";
    $event_is_approved_result = mysqli_query($connect, $event_is_approved_sql);
    
    $_SESSION['event_success_message'] = "Event Approved Successfully";
    header("location: public_event.php");

    // echo "event is approved<br>";
?>