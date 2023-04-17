<?php
    session_start();

    if (!isset($_SESSION["current_user_id"]))
    {
        header("location: login.php");
    }

    // the approval id that contain the event_id that also needs to be deleted
    $event_approval_id = $_SERVER['QUERY_STRING'];

    $db_servername = "localhost";
    $db_username = "root";
    $db_password = "password";
    $db_name = "college_event_db";

    $connect = new mysqli($db_servername, $db_username, $db_password, $db_name);
    if ($connect->connect_error)
    {
        die("Connection failed");
    }

    $get_decline_event_id_sql = "SELECT * FROM Approval WHERE approval_id='$event_approval_id'";
    $get_decline_event_id_result = mysqli_query($connect, $get_decline_event_id_sql);
    $get_decline_event_id_info = mysqli_fetch_array($get_decline_event_id_result);

    $event_to_delete = $get_decline_event_id_info['event_id'];

    $event_is_approved_sql = "DELETE FROM Approval WHERE approval_id='$event_approval_id'";
    $event_is_approved_result = mysqli_query($connect, $event_is_approved_sql);

    $event_is_approved_sql = "DELETE FROM Events WHERE event_id='$event_to_delete'";
    $event_is_approved_result = mysqli_query($connect, $event_is_approved_sql);
    
    $_SESSION['event_success_message'] = "Event Declined Successfully";
    header("location: public_event.php");

    // echo "event is approved<br>";
?>