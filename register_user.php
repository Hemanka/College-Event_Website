<!-- check for existing user id or email -->
<?php
	$can_insert = false;
	$index = $_POST["user_id"];
	$initial_query = "SELECT * FROM users WHERE user_id = $index";

	// variable from the video i saw, maybe it refers to the check_connection.php?
	// 						|
	// 						v
	$result = mysqli_query($connection, $initial_query);

	// if there already exists a User ID that is the same as the one trying to be inserted
	if (mysqli_num_rows($result) > 0)
	{
		echo "User ID already exists!";
		$can_insert = false;
	}
	else
	{
		$can_insert = true;
	}

	$index = $_POST["user_email"];
	$initial_query = "SELECT * FROM users WHERE user_email = $index";

	// variable from the video i saw, maybe it refers to the check_connection.php?
	// 						|
	// 						v
	$result = mysqli_query($connection, $initial_query);

	// if there already exists a User ID that is the same as the one trying to be inserted
	if (mysqli_num_rows($result) > 0)
	{
		echo "Email already exists!";
		$can_insert = false;
	}
	else
	{
		$can_insert = true;
	}

	// if can_insert is set to true, insert the user info
	if ($can_insert)
	{
		$user_id = $_POST["user_id"];
		$user_fname = $_POST["user_fname"];
		$user_lname = $_POST["user_lname"];
		$user_email = $_POST["user_email"];
		$user_password = $_POST["user_password"];
		$user_role = $_POST["user_role"];
		$uni_id = $_POST["uni_id"];

		$insert_query = "INSERT INTO user (user_id, user_fname, user_lname,
										   user_email, user_password, user_role, uni_id)
										   VALUES ('$user_id', '$user_fname', '$user_lname',
										   		   '$user_email', '$user_password', '$user_role',
												   '$uni_id',) ";

		$result = mysqli_query($connection, $insert_query);

		if ($result)
		{
			echo "<b> User account successfully registered!</b>";
		}
		else
		{
			echo "<b>Unable to register.</b>";
		}
	}
	// if we could not insert the info
	else
	{
		echo "<b>Duplicate User ID or Email.</b>";
	}
?>