<!-- 
    CHECK to see if the query runs fine for getting the list of rso
    
    NEED TO DO:
    - get info about rso event
    - get infor about private event

    AFTER THIS:
    - start working on a create_event file, where the input from this page would be used

 -->

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

    // NEED TO CHECK THIS QUERY
    if (isset($_SESSION["current_user_id"]))
    {
        $user_id_display = $_SESSION["current_user_id"];

        $rso_list_sql = "SELECT * FROM Rso R1 
                        WHERE R1.rso_id IN (SELECT M1.rso_id FROM Member_rso M1 WHERE M1.user_id = '$user_id_display')";
        $rso_list_result = mysqli_query($connect, $rso_list_sql);
    }
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

        <script src="new_event.js"></script>

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

                <label for="new_event_type">Event Type: </label>
				<select onchange="eventType(this)" id="new_event_type" name="new_event_type">
                    <option value="default">Choose An Event Type</option>
					<option value="public">Public Event</option>
					<option value="private">Private Event</option>
					<option value="rso">RSO Event</option>
				</select>
                
                <br><br>

                <!-- <div id="chose_public_event" style="display: none;">
                    <p>public_event</p>
                </div> -->

                <div id="chose_private_event" style="display: none;">
                    <!-- <p>private_event</p> -->
                    
                </div>

                <div id="chose_rso_event" style="display: none;">
                    <!-- <p>rso_event</p> -->
                    <label for="new_event_type">Event Type: </label>
                    <select id="rso" name="rso">
                        <option value="default">Choose An Rso</option>
                        <option value="public">Public Event</option>
                    </select>
                </div>

                <!-- depending on the event type ask for related input -->



                <label for="start_time">Start Time: </label>
                <input type="datetime-local" id="start_time" name="start_time">
                
                <br><br>

                <label for="end_time">End Time: </label>
                <input type="datetime-local" id="end_time" name="end_time">
                
                <br><br>

                <!-- get the location for the event -->



                <button type="submit">Log in</button>
            </div>
        </form>
        <!-- </div> -->
        <!-- </div> -->

        
        

    </body>
</html>