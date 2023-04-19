<?php
    session_start();

    if (!isset($_SESSION["current_user_id"]))
    {
        header("location: login.php");
    }

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
    $phone_number = $_POST['phone_number'];

    $overlap = FALSE;
    $numRows = 0;

    if (strcasecmp($new_event_type, 'rso') == 0)
    {
        $new_event_rso_id = $_POST['new_event_rso_id'];
        // echo $new_event_rso_id;
        // echo "<br>";
    }

    if (isset($_POST['uni_event']))
    {
        $new_event_uni = $_POST['uni_event'];
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
    $numRows = mysqli_num_rows($event_check_result);
    if ($numRows >= 1)
    {
        $_SESSION['error_message'] = "Event with the name '$new_event_name' already exist";
        header("location: create_event_page.php");
        die();
    }

    // gets the current events location id
    $event_check_sql = "SELECT * FROM Event_location WHERE latitude='$new_event_lat' AND longitude='$new_event_lng'";
    $event_check_result = mysqli_query($connect, $event_check_sql);
    $numRows = mysqli_num_rows($event_check_result);
    if ($numRows <= 0)
    {
        $_SESSION['error_message'] = "Invalid location choosen";
        header("location: create_event_page.php");
        die();
    }
    $event_check_info = mysqli_fetch_array($event_check_result);
    $loc_id = $event_check_info['loc_id'];

    // get the list of events that would be happending at the same place and on the same date as the new event
    $event_check_sql = "SELECT * FROM Events 
                        WHERE loc_id='$loc_id' AND event_date='$new_event_date'";
    if ($event_check_result = mysqli_query($connect, $event_check_sql))
    {
        $numRows = mysqli_num_rows($event_check_result);
    }
    
    if ($numRows > 0)
    {
        while ($event_check_info = mysqli_fetch_array($event_check_result))
        {
            if (((strtotime($new_event_end_time) - strtotime($event_check_info['start_time'])) > 0) &&
                    ((strtotime($event_check_info['end_time']) - strtotime($new_event_start_time)) > 0))
            {
                $event_name = $event_check_info['event_name'];
                $event_start_time = date('h:i a', strtotime($event_check_info['start_time']));
                $event_end_time = date('h:i a', strtotime($event_check_info['end_time']));


                $overlap = TRUE;
                $_SESSION['error_message'] = "The choosen time of your event overlaps with an existing event '$event_name'
                                                which start at '$event_start_time' and end at '$event_end_time'";
                break;
            }
        }
    }

    if ($overlap == TRUE)
    {
        header("location: create_event_page.php");
        die();
    }

    $user_id = $_SESSION["current_user_id"];
    $event_check_sql = "SELECT * FROM Users WHERE user_id='$user_id'";
    $event_check_result = mysqli_query($connect, $event_check_sql);
    $event_check_info = mysqli_fetch_array($event_check_result);
    $user_email_address = $event_check_info['user_email'];

    if (!isset($new_event_uni))
    {
        $new_event_uni = $event_check_info['uni_id'];
    }

    // event can be created/requested to be created successfully.
    if ((strcasecmp($new_event_type, 'Rso') == 0))
    {
        $sql = "INSERT INTO Events(event_name, event_cat, event_description, contact_number, contact_email, 
                                 event_date, start_time, end_time, loc_id, event_type, rso_id)
                VALUE ('$new_event_name', '$new_event_cat', '$new_event_description', '$phone_number', '$user_email_address', 
                     '$new_event_date', '$new_event_start_time', '$new_event_end_time', '$loc_id', 'Rso', '$new_event_rso_id')";
        $status = mysqli_query($connect, $sql);

        $_SESSION['event_success_message'] = "Event Created Successfully";
        header("location: rso_event.php");
    }
    else if ((strcasecmp($new_event_type, 'Private') == 0))
    {
        $sql = "INSERT INTO Events(event_name, event_cat, event_description, contact_number, contact_email, 
                                 event_date, start_time, end_time, loc_id, event_type, uni_id)
                VALUE ('$new_event_name', '$new_event_cat', '$new_event_description', '$phone_number', '$user_email_address', 
                     '$new_event_date', '$new_event_start_time', '$new_event_end_time', '$loc_id', 'Private', '$new_event_uni')";
        $status = mysqli_query($connect, $sql);

        $_SESSION['event_success_message'] = "Event Created Successfully";
        header("location: private_event.php");
    }
    else if ((strcasecmp($new_event_type, 'Public') == 0))
    {
        $sql = "INSERT INTO Events(event_name, event_cat, event_description, contact_number, contact_email, 
                                 event_date, start_time, end_time, loc_id, event_type)
                VALUE ('$new_event_name', '$new_event_cat', '$new_event_description', '$phone_number', '$user_email_address', 
                     '$new_event_date', '$new_event_start_time', '$new_event_end_time', '$loc_id', 'Public')";
        $status = mysqli_query($connect, $sql);

        if (strcasecmp($_SESSION["current_user_role"], 'Super Admin') != 0)
        {
            $get_event_id_sql  = "SELECT * FROM Events WHERE event_name='$new_event_name'";
            $get_event_id_result = mysqli_query($connect, $get_event_id_sql);
            $get_event_id_info = mysqli_fetch_array($get_event_id_result);
            $event_id  = $get_event_id_info['event_id'];

            $sql = "INSERT INTO Approval(event_id, request_user_id)
                    VALUE ('$event_id', '$user_id')";
            $status = mysqli_query($connect, $sql);
            $_SESSION['event_success_message'] = "Event Created Successfully. WAITING for Approval";
        }
        else
        {
            $_SESSION['event_success_message'] = "Event Created Successfully.";
        }

        header("location: public_event.php");
    }

?>