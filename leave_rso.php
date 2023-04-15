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
    if (isset($_POST['submit']))
    {
        // echo "in this file<br>";
        $leave_rso_id = $_POST['rso_to_leave'];
        $current_user_id = $_SESSION["current_user_id"];

        // the current user joins that rso
        $leave_rso_sql = "DELETE FROM Member_rso M1 WHERE M1.rso_id='$leave_rso_id' AND M1.user_id='$current_user_id'";
        $status = mysqli_query($connect, $leave_rso_sql);

        $rso_status_sql = "SELECT * FROM Member_rso M1 WHERE M1.rso_id = '$leave_rso_id'";
        $rso_status_result = mysqli_query($connect, $rso_status_sql);
        $numRows = mysqli_num_rows($rso_status_result);

        if ($numRows < 5)
        {
            $update_sql = "UPDATE Rso SET rso_status='Inactive' WHERE rso_id='$leave_rso_id'";
            $status = mysqli_query($connect, $update_sql);
        }
        
        $_SESSION['leave_success_message'] = "RSO Lefted Successfully";
        header("location: rso_event.php");
        // echo "SUCCESS<br>";
        // unset($_POST['submit']);
    }
?>