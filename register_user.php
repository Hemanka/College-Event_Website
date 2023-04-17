<!-- check for existing user id or email -->
<?php
	session_start();

	// input taken from the user
	$user_fname = $_POST["user_fname"];
	$user_lname = $_POST["user_lname"];
	$user_email = $_POST["user_email"];
	$user_password = $_POST["user_password"];
	$uni_id = $_POST['user_uni_id'];
	// $user_role = $_POST["user_role"];
	// $uni_name = $_POST["user_uni_name"];

	$db_servername = "localhost";
    $db_username = "root";
    $db_password = "password";
    $db_name = "college_event_db";

    $connect = new mysqli($db_servername, $db_username, $db_password, $db_name);
    if ($connect->connect_error)
    {
        die("Connection failed");
    }

	// get the uni_id of where the user is trying to register
	// $sql = "SELECT * FROM UNIVERSITY WHERE uni_name = '$uni_name'";
	// $result = mysqli_query($connect, $sql);
	// $info = mysqli_fetch_array($result);

	// $uni_id = $info['uni_id'];
	// $uni_id = $_POST['user_uni_id'];

	// $index = $_POST["user_email"];
	$initial_query = "SELECT * FROM users WHERE user_email='$user_email'";

	$result = mysqli_query($connect, $initial_query);

	// if there already exists a User ID that is the same as the one trying to be inserted
	if (mysqli_num_rows($result) > 0)
	{
		$_SESSION['sign_up_error_message'] = "Email already exists.";
		header("location:registration_page.php");
		die();
	}

	$sql = "SELECT * FROM University WHERE uni_id = '$uni_id'";
	$result = mysqli_query($connect, $sql);
	$info = mysqli_fetch_array($result);
	$uni_name = $info['uni_name'];

	if (!str_contains(strtolower($user_email), strtolower($info['uni_email_domain'])))
	{
		$_SESSION['sign_up_error_message'] = "Your email domain does not match that of '$uni_name'";
		header("location:registration_page.php");
		die();
	}



	$insert_query = "INSERT INTO Users (user_fname, user_lname, user_role, uni_id,
										user_email, user_password)
										VALUES ('$user_fname', '$user_lname', 'Student',
												'$uni_id', '$user_email', '$user_password')";

	$result = mysqli_query($connect, $insert_query);

	// if ($result)
	// {
		// echo "<b> User account successfully registered!</b>";
	$_SESSION['sign_up_success_message'] = "Sign Up Successfull! Please Login.";
	header("location:login.php");
	die();
	// }
	// else
	// {
	// 	echo "<b>Unable to register.</b>";
	// }

	$connect->close();
?>