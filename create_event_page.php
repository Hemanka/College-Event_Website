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
                        WHERE R1.admin_id = '$user_id_display'";
                        //  R1.rso_id IN (SELECT M1.rso_id FROM Member_rso M1 WHERE M1.user_id = '$user_id_display')";
        $rso_list_result = mysqli_query($connect, $rso_list_sql);
        $rso_list_numRows = mysqli_num_rows($rso_list_result);
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
                <input type="text" id="new_event_name" name="new_event_name" required>

                <br><br>

                <label for="start_time">Start Time: </label>
                <input type="datetime-local" id="start_time" name="start_time" required>
                
                <br><br>

                <label for="end_time">End Time: </label>
                <input type="datetime-local" id="end_time" name="end_time" required>
                
                <br><br>

                <label for="category">Category: </label>
                <input type="text" id="category" name="category"  required>
                
                <br><br>

                <label for="description">Description (less than 100 words): </label>
                <input type="text" id="description" name="description" required>
                
                <br><br>

                <label for="new_event_type">Event Type: </label>
				<select onchange="eventType(this)" id="new_event_type" name="new_event_type" required>
                    <option value="">Choose An Event Type</option>
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

                <!-- show the list of the rso that the user can create the event for -->
                <div id="chose_rso_event" style="display: none;">
                    <?php if ($rso_list_numRows != 0) {?>
                        <!-- <p>rso_event</p> -->
                        <label for="new_event_type">RSO Name: </label>
                        <select id="rso" name="rso">
                            <option value="">Choose An Rso</option>
                            <!-- <option value="public">Public Event</option> -->

                            <?php while ($rso_list_info = mysqli_fetch_array($rso_list_result)) {?>
                                        <option value="<?php echo $rso_list_info['rso_name']?>"><?php echo $rso_list_info['rso_name'];?></option>
                            <?php } ?>
                        </select>
                    <?php } else {?>
                        <p>Sorry RSO can't be created.</p>
                    <?php } ?>

                    <br><br>
                </div>


                <!-- depending on the event type ask for related input -->

                <!-- 
                    get the location for the event 
                    NEED TO TAKE THE INPUT WITH THE HELP OF MAP
                -->
                
                <label for="latitude">latitude: </label>
                <input type="text" id="latitude" name="latitude" required>
                
                <br><br>

                <label for="longitude">longitude: </label>
                <input type="text" id="longitude" name="longitude" required>
                
                <br><br>
                
                <button type="submit">Create</button>
            </div>
        </form>
        <!-- </div> -->
        <!-- </div> -->

        
        

    </body>
</html>