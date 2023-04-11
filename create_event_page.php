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

    // $sql = "SELECT * FROM Events WHERE event_type = 'Public'";
    // $result = mysqli_query($connect, $sql);
    // $numRows = mysqli_num_rows($result);
    //need to remove this
    // echo $numRows;
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Create Event</title>

        <meta name="viewpoint" content="width=device-width">

        <!-- displays a nav based on the current user -->
        <?php
            if (isset($_SESSION["current_user_role"]))
            {
                require 'nav_bar.php';
            }
        ?>

    </head>

    <body>
        <form action="create_event.php" method="post">
            <h1>Create New Events</h1>

            <div class="login_form_text">

                <label for="new_event_name">Event Name: </label>
                <input type="text" id="new_event_name" name="new_event_name">

                <br><br>

                <label for="category">Category: </label>
                <input type="text" id="category" name="category">
                
                <br><br>

                <label for="description">Description (less than 100 words): </label>
                <input type="text" id="description" name="description">
                
                <br><br>

                <label for="start_time">Start Time: </label>
                <input type="text" id="start_time" name="start_time">
                
                <br><br>

                <button type="submit">Log in</button>
            </div>
        </form>
        <!-- </div> -->
        <!-- </div> -->

        

    </body>
</html>