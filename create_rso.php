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

	// check for duplicate RSO:
	$sql = "SELECT * FROM rso WHERE rso_name = '$new_rso_name'";
	$rso_result = mysqli_query($connect, $sql);
	$info = mysqli_fetch_array($result);

	if (mysqli_num_rows($result) > 0)
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
	$info = mysqli_fetch_array($result);

	$infoLength = count($info);

	for ($i = 0; $i < $infoLength; $i++)
	{
		// find current email in the user_email array
		$initial_query = "SELECT * FROM users WHERE user_email = '$info[$i]'";
		
		$result = mysqli_query($connect, $initial_query);

		// if the current email does not exists, display error msg and redirect to create_rso_page
		if (mysqli_num_rows($result) == 0)
		{
			echo "Email does not exist!";
			header("location:create_rso_page.php");
		}

		// SELECT user_email, uni_id FROM users WHERE user_email = (SELECT uni_id FROM users where )
	}

	// insert rso:
	// dont know how to get uni_id
	$status = "active";
	$insert_query = "INSERT INTO rso (rso_name, rso_status, uni_id) VALUES ('$new_rso_name', '$status', $uni_id)";

	$result = mysqli_query($connect, $insert_query);

	if ($result)
	{
		echo "<b> RSO successfully created!</b>";
	}
	else
	{
		echo "<b>Unable to create RSO.</b>";
	}

	// insert members using the newly created rso's id

	$connect->close();
?>