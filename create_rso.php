<!-- check for necessary conditions for creating an RSO -->
<?php
	// input taken from the user
	$first_user_email = $_POST["first_user_email"];
	$second_user_email = $_POST["second_user_email"];
	$third_user_email = $_POST["third_user_email"];
	$fourth_user_email = $_POST["fourth_user_email"];

	$db_servername = "localhost";
    $db_username = "root";
    $db_password = "password";
    $db_name = "college_event_db";

    $connect = new mysqli($db_servername, $db_username, $db_password, $db_name);
    if ($connect->connect_error)
    {
        die("Connection failed");
    }

	// get all of the user emails
	$sql = "SELECT user_email FROM users";
	$result = mysqli_query($connect, $sql);
	$info = mysqli_fetch_array($result);

	$infoLength = count($info);

	for ($i = 0; $i < $infoLength; $i++)
	{
		$initial_query = "SELECT * FROM users WHERE user_email = '$info[$i]'";
		
		$result = mysqli_query($connect, $initial_query);

		if (mysqli_num_rows($result) > 0)
		{
			echo "Email already exists!";
		header("location:registration_page.php");
		}
	}

	$uni_id = $info['uni_id'];

	// $index = $_POST["user_email"];
	$initial_query = "SELECT * FROM users WHERE user_email = '$user_email'";

	$result = mysqli_query($connect, $initial_query);

	// if there already exists a User ID that is the same as the one trying to be inserted
	if (mysqli_num_rows($result) > 0)
	{
		echo "Email already exists!";
		header("location:registration_page.php");
	}

		$insert_query = "INSERT INTO Users (user_fname, user_lname, user_role, uni_id,
										   user_email, user_password)
										   VALUES ('$user_fname', '$user_lname', '$user_role',
												   '$uni_id', '$user_email', '$user_password')";

		$result = mysqli_query($connect, $insert_query);

		if ($result)
		{
			echo "<b> User account successfully registered!</b>";
		}
		else
		{
			echo "<b>Unable to register.</b>";
		}

	$connect->close();
?>