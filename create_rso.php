<!-- check for necessary conditions for creating an RSO -->
<!-- 
	TO-DO:
	- check if the success message would be displayed on the public event page
 -->
<?php
	session_start();
	// input taken from the user
	$new_rso_name = $_POST["new_rso_name"];
	$admin_user_email = $_POST["admin_user_email"];
	$first_user_email = $_POST["first_user_email"];
	$second_user_email = $_POST["second_user_email"];
	$third_user_email = $_POST["third_user_email"];
	$fourth_user_email = $_POST["fourth_user_email"];
	

	$valid_emails = TRUE;

	$db_servername = "localhost";
    $db_username = "root";
    $db_password = "password";
    $db_name = "college_event_db";

	$connect = new mysqli($db_servername, $db_username, $db_password, $db_name);
    if ($connect->connect_error)
    {
        die("Connection failed");
    }

	// the following codes check to see if email address provided are valid or not
	// and if the members are from the same uni
	$sql = "SELECT * FROM Users WHERE user_email = '$admin_user_email'";
	$result = mysqli_query($connect, $sql);
    $numRows = mysqli_num_rows($result);
	if ($numRows < 1)
	{
		$valid_emails = FALSE;
	}
	else
	{
		$info = mysqli_fetch_array($result);
		$rso_uni_id = $info['uni_id'];
		$this_rso_admin_id = $info['user_id'];
	}

	$sql = "SELECT * FROM Users WHERE user_email = '$first_user_email'";
	$result = mysqli_query($connect, $sql);
    $numRows = mysqli_num_rows($result);
	if ($numRows < 1)
	{
		$valid_emails = FALSE;
	}
	else
	{
		$info = mysqli_fetch_array($result);
		$first_user_id = $info['user_id'];
		if ($rso_uni_id != $info['uni_id'])
		{
			$valid_emails = FALSE;
		}
	}

	$sql = "SELECT * FROM Users WHERE user_email = '$second_user_email'";
	$result = mysqli_query($connect, $sql);
    $numRows = mysqli_num_rows($result);
	if ($numRows < 1)
	{
		$valid_emails = FALSE;
	}
	else
	{
		$info = mysqli_fetch_array($result);
		$second_user_id = $info['user_id'];
		if ($rso_uni_id != $info['uni_id'])
		{
			$valid_emails = FALSE;
		}
		
	}

	$sql = "SELECT * FROM Users WHERE user_email = '$third_user_email'";
	$result = mysqli_query($connect, $sql);
    $numRows = mysqli_num_rows($result);
	if ($numRows < 1)
	{
		$valid_emails = FALSE;
	}
	else
	{
		$info = mysqli_fetch_array($result);
		$third_user_id = $info['user_id'];
		if ($rso_uni_id != $info['uni_id'])
		{
			$valid_emails = FALSE;
		}
	}

	$sql = "SELECT * FROM Users WHERE user_email = '$fourth_user_email'";
	$result = mysqli_query($connect, $sql);
    $numRows = mysqli_num_rows($result);
	if ($numRows < 1)
	{
		$valid_emails = FALSE;
	}
	else
	{
		$info = mysqli_fetch_array($result);
		$fourth_user_id = $info['user_id'];
		if ($rso_uni_id != $info['uni_id'])
		{
			$valid_emails = FALSE;
		}
	}

	// display the error message on create rso page
	if ($valid_emails == FALSE)
	{
		$_SESSION['error_message'] = "Invalid email address provided. Please provide valid email addresses";
		// echo $_SESSION['error_message'];
		header("location: create_rso_page.php");
		die();
	}

	// check to see if an RSO with the give name already exists at the uni
	$check_sql = "SELECT * FROM Rso WHERE rso_name = '$new_rso_name'";
	$check_result = mysqli_query($connect, $check_sql);
	$check_numRows = mysqli_num_rows($check_result);

	// rso already exist at the member's university
	if ($check_numRows != 0)
	{
		$_SESSION['error_message'] = "An RSO with the given name '$new_rso_name' already exist at your University";
		header("location: create_rso_page.php");
		die();
	}

	// if the following code excutes, that mean the user can create an RSO
	$create_rso_sql = "INSERT INTO Rso(rso_name, rso_status, admin_id, uni_id) 
			             VALUE ('$new_rso_name', 'Active', '$this_rso_admin_id', '$rso_uni_id')";	
    $status = mysqli_query($connect, $create_rso_sql);

	$get_new_rso_id_sql = "SELECT * FROM Rso WHERE rso_name = '$new_rso_name'";
	$get_new_rso_id_result = mysqli_query($connect, $get_new_rso_id_sql);
	$get_new_rso_id_info = mysqli_fetch_array($get_new_rso_id_result);
	$new_rso_id = $get_new_rso_id_info['rso_id'];

	// the five give users are registed as the member of the newly created RSO
	$sql = "INSERT INTO Member_rso(rso_id, user_id) 
            VALUE ('$new_rso_id', '$this_rso_admin_id')";
    $status = mysqli_query($connect, $sql);

	$sql = "INSERT INTO Member_rso(rso_id, user_id) 
            VALUE ('$new_rso_id', '$first_user_id')";
    $status = mysqli_query($connect, $sql);

	$sql = "INSERT INTO Member_rso(rso_id, user_id) 
            VALUE ('$new_rso_id', '$second_user_id')";
    $status = mysqli_query($connect, $sql);

	$sql = "INSERT INTO Member_rso(rso_id, user_id) 
            VALUE ('$new_rso_id', '$third_user_id')";
    $status = mysqli_query($connect, $sql);

	$sql = "INSERT INTO Member_rso(rso_id, user_id) 
            VALUE ('$new_rso_id', '$fourth_user_id')";
    $status = mysqli_query($connect, $sql);

	// update the role of the admin of this rso to 'Admin' if they are not already an admin
	$update_role_sql = "UPDATE Users SET user_role='Admin' WHERE user_id = '$this_rso_admin_id'";
	$update_role_result = mysqli_query($connect, $update_role_sql); 

	$connect->close();

	// STILL NEED TO CHECK IF THIS WORKS
	$_SESSION['rso_created_success_message'] = "RSO Created Successfully";
	header("location: rso_event.php");
?>