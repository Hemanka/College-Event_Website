<!-- check for necessary conditions for creating an RSO -->
<?php
	// input taken from the user
	$new_rso_name = $_POST["new_rso_name"];
	$first_user_email = $_POST["first_user_email"];
	$second_user_email = $_POST["second_user_email"];
	$third_user_email = $_POST["third_user_email"];
	$fourth_user_email = $_POST["fourth_user_email"];

	$db_servername = "localhost";
    $db_username = "root";
    $db_password = "password";
    $db_name = "college_event_db";
	
	function test_input($data)
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	// sees if email entered is a valid one
	function validateEmail($email)
	{
		$email = test_input($email);

		if (empty($email))
		{
			echo "Email is required";
			header("location:create_rso_page.php");
		}
		else if (!filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			echo "Invalid email format";
			header("location:create_rso_page.php");
		}
	}

    $connect = new mysqli($db_servername, $db_username, $db_password, $db_name);
    if ($connect->connect_error)
    {
        die("Connection failed");
    }

	// check for empty rso entry
	if (empty($new_rso_name))
	{
		echo "Must enter RSO name";
	}

	// check for duplicate RSO:
	// could make string all uppercase with strtoupper(str)
	$sql = "SELECT * FROM rso WHERE rso_name = '$new_rso_name'";
	$rso_result = mysqli_query($connect, $sql);
	$rso_info = mysqli_fetch_array($rso_result);

	if (mysqli_num_rows($rso_result) > 0)
	{
		echo "RSO already exists!";
		header("location:create_rso_page.php");
	}

	// check for valid emails
	validateEmail($first_user_email);
	validateEmail($second_user_email);
	validateEmail($third_user_email);
	validateEmail($fourth_user_email);

	// check for non-existant users:
	// get all of the current user emails
	$sql = "SELECT user_email FROM users";
	$result = mysqli_query($connect, $sql);
	$userEmailArray = mysqli_fetch_row($result);

	while ($email = mysqli_fetch_column($result, 1))
	{
		array_push($userEmailArray, $email);
	}

	$UEALength = count($userEmailArray);

	$uniIds = array();
	$userIds = array();

	for ($i = 0; $i < $UEALength; $i++)
	{
		// find current email in the user_email array
		$initial_query = "SELECT * FROM users WHERE user_email = '$info[$i]'";
		
		$result = mysqli_query($connect, $initial_query);

		// if the current email does not exist, display error msg and redirect to create_rso_page
		if (mysqli_num_rows($result) == 0)
		{
			echo "One or more emails entered do not exist!";
			header("location:create_rso_page.php");
		}

		// get uni_id and user_ids
		$emailArray = mysqli_fetch_array($result);

		array_push($uniIds, $emailArray["uni_id"]);
		array_push($userIds, $emailArray["user_id"]);

		// checks if each user entered go to the same university by comparing uni_ids
		if (!empty($uniIds) && $info[$i+1] != null)
		{
			if ($uniIds[$i] != $uniIds[$i+1])
			{
				echo "One or more emails are from different Universities!";
				header("location:create_rso_page.php");
			}
		}
	}

	// insert rso:
	$uni = $uniIds[0];
	$status = "active";
	$insert_query = "INSERT INTO rso (rso_name, rso_status, uni_id) 
					 VALUES ('$new_rso_name', '$status', $uni)";

	$result = mysqli_query($connect, $insert_query);

	if (!$result)
	{
		echo "<b>Unable to create RSO.</b>";
		header("location:create_rso_page.php");
	}

	// insert members using the newly created rso's id:
	$rsoId = $rso_info["rso_id"];

	$UIlength = count($userIds);

	for ($i = 0; $i < $UIlength; $i++)
	{
		$insert_query = "INSERT INTO member_rso (member_id rso_id user_id) VALUES ('$rsoId', '$userIds[$i]')";
		$result = mysqli_query($connect, $insert_query);

		if (!$result)
		{
			echo "Error adding user";
			header("location:create_rso_page.php");
		}
	}

	echo "<b>RSO successfully created!</b>";

	$connect->close();
?>