<!-- <?php
    // session_start();

    // $db_servername = "localhost";
    // $db_username = "root";
    // $db_password = "password";
    // $db_name = "college_event_db";

    // $connect = new mysqli($db_servername, $db_username, $db_password, $db_name);
    // if ($connect->connect_error)
    // {
    //     die("Connection failed");
    // }

    // $current_user_id = $_SESSION["current_user_id"];

    // // query to get the current users uni_id
    // $current_sql = "SELECT * FROM Users WHERE user_id='$current_user_id'";
    // $current_result = mysqli_query($connect, $current_sql);
    // $current_info = mysqli_fetch_array($current_result);

    // $user_uni_id = $current_info['uni_id'];
    
    // // get the list of rso that user is not a member of
    // $rso_list_sql = "SELECT * FROM Rso R1 
    //                 WHERE R1.uni_id='$user_uni_id'
    //                         AND R1.rso_id NOT IN (SELECT M1.rso_id FROM Member_rso M1 WHERE M1.user_id='$current_user_id')";
    // $rso_list_result = mysqli_query($connect, $rso_list_sql);
?> -->

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
        $join_rso_id = $_POST['rso_to_join'];
        $current_user_id = $_SESSION["current_user_id"];

        // the current user joins that rso
        $join_rso_sql = "INSERT INTO Member_rso(rso_id, user_id) 
                     VALUE ('$join_rso_id', '$current_user_id')";
        $status = mysqli_query($connect, $join_rso_sql);

        $_SESSION['join_success_message'] = "RSO Created Successfully";
        header("location: rso_event.php");
        // echo "SUCCESS<br>";
        // unset($_POST['submit']);
    }
?>