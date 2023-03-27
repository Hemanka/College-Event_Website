<?php 
    $username = $_POST["username"];
    $password = $_POST["password"];

    $db_servername = "localhost";
    $db_username = "root";
    $db_password = "password";
    $db_name = "college_event_db";

    $connect = new mysqli($db_servername, $db_username, $db_password, $db_name);
    if ($connect->connect_error)
    {
        die("Connection failed");
    }

    $sql = "SELECT * FROM Users U WHERE U.user_email = '$username'";
    $result = mysqli_query($connect, $sql);
    $info = mysqli_fetch_array($result);

    $connect->close();

    if (strcasecmp(($info["user_email"]), $username) == 0)
    {
        if (strcmp(($info["user_password"]), $password) == 0)
        {
            header("location: public_event.php");
        }
        else
        {
            header("location: login.php");
        }
    }
    else
    {
        header("location: login.php");
    }
?>