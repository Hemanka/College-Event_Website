<?php
    session_start();

    if (!isset($_SESSION["current_user_id"]))
    {
        header("location: login.php");
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

    $new_uni_name = $_POST['new_uni_name'];
    $new_uni_description = $_POST['new_uni_description'];
    $new_uni_email_domain = $_POST['new_uni_email_domain'];
    $new_uni_address = $_POST['new_uni_address'];

    // check to see if an university with the give name already exists
    $check_uni_exist_sql = "SELECT * FROM University WHERE uni_name='$new_uni_name'";
    $check_uni_exist_result = mysqli_query($connect, $check_uni_exist_sql);
    $check_uni_exist_numRows = mysqli_num_rows($check_uni_exist_result);

    if ($check_uni_exist_numRows > 0 )
    {
        $_SESSION['uni_error_message'] = "An University with the name '$new_uni_name' already exist";
        header("location: create_uni_page.php");
        die();
    }

    // check to see if the given email domain is being used by other registered university
    $check_uni_exist_sql = "SELECT * FROM University WHERE uni_email_domain='$new_uni_email_domain'";
    $check_uni_exist_result = mysqli_query($connect, $check_uni_exist_sql);
    $check_uni_exist_numRows = mysqli_num_rows($check_uni_exist_result);

    if ($check_uni_exist_numRows > 0 )
    {
        $check_uni_exist_info = mysqli_fetch_array($check_uni_exist_result);
        $uni_with_same_email_domain = $check_uni_exist_info['uni_name'];
        $_SESSION['uni_error_message'] = "The email domain '$new_uni_email_domain' is already being used by '$uni_with_same_email_domain'";
        header("location: create_uni_page.php");
        die();
    }    

    // the new university can be registered
    $create_new_uni_sql = "INSERT INTO University(uni_name, uni_address, uni_description, uni_email_domain) 
            VALUE ('$new_uni_name', '$new_uni_address', '$new_uni_description', '$new_uni_email_domain')";
    $status = mysqli_query($connect, $create_new_uni_sql);

    $_SESSION['uni_success_message'] = "University with the name '$new_uni_name' is created successfully";
    header("location: create_uni_page.php");
?>