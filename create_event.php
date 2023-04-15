<?php
    session_start();

    $new_event_name = $_POST['new_event_name'];
    $new_event_date = $_POST['new_event_date'];
    $new_event_start_time = $_POST['start_time'];
    $new_event_end_time = $_POST['end_time'];
    $new_event_cat = $_POST['category'];
    $new_event_description = $_POST['description'];
    $new_event_type = $_POST['new_event_type'];
    $new_event_loc_name = $_POST['loc_name'];
    $new_event_lat = $_POST['latitude'];
    $new_event_lng = $_POST['longitude'];

    if (strcasecmp($new_event_type, 'rso') == 0)
    {
        $new_event_rso_id = $_POST['new_event_rso_id'];
        // echo $new_event_rso_id;
        // echo "<br>";
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

    // the name matches another event name
    $event_check_sql = "SELECT * FROM Events WHERE event_name='$new_event_name'";
    $event_check_result = mysqli_query($connect, $event_check_sql);
    $numRows = mysqli_num_rows($event_check_result);if ($numRows >= 1)
    {
        $_SESSION['error_message'] = "Event with the name '$new_event_name' already exist";
        header("location: create_event_page.php");
        die();
    }

    // gets the current events location id
    $event_check_sql = "SELECT * FROM Event_location WHERE latitude='$new_event_lat' AND longitude='$new_event_lng'";
    $event_check_result = mysqli_query($connect, $event_check_sql);
    $event_check_info = mysqli_fetch_array($event_check_result);
    $loc_id = $event_check_info['loc_id'];

    // check to see if the time overlaps


    // $numRows = mysqli_num_rows($event_check_result);

    if (strtotime($new_event_start_time) < strtotime($new_event_end_time))
    {
        echo "time not overlapping<br>";
    }
    else
    {
        echo "incorrect input<br>";
    }
    // echo ($new_event_end_time - $new_event_start_time);

    // $event_check_sql = "SELECT * FROM Events WHERE event_name='$new_event_name'";
    // $event_check_result = mysqli_query($connect, $event_check_sql);
    // $numRows = mysqli_num_rows($event_check_result);
?>