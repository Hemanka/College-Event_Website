<?php
	require 'create_table.php';

	$db_servername = "localhost";
    $db_username = "root";
    $db_password = "password";
    $db_name = "college_event_db";

    $connect = new mysqli($db_servername, $db_username, $db_password, $db_name);
    if ($connect->connect_error)
    {
        die("Connection failed");
    }

	$sql = "SELECT * FROM University";
	$result = mysqli_query($connect, $sql);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Registration Page</title>
        <meta name="viewpoint" content="width=device-width">

        <link rel="stylesheet" href = "style.css" />
    </head>

    <body>

		<!-- do this need a "require"? -->
		<?php ?>
			<form action="register_user.php" method="post">
			<h1>REGISTER</h1>
			<!-- may change/ create new css class -->
			<div class="login_form_text">

				<label for="user_fname">First name: </label>
				<input type="text" id="user_fname" name="user_fname">

				<br>
				<br>

				<label for="user_lname">Last name: </label>
				<input type="text" id="user_lname" name="user_lname">

				<br>
				<br>

				<label for="user_email">Email (will be used as username): </label>
				<input type="text" id="user_email" name="user_email">

				<br>
				<br>

				<label for="user_password">Password: </label>
				<input type="password" id="user_password" name="user_password">
				
				<br>
				<br>

				<label for="user_role">User Role: </label>
				<select id="user_role" name="user_role">
					<option value="student">Student<?php?></option>
					<option value="admin">Admin</option>
					<option value="super_admin">Super Admin</option>
				</select>
				
				<br>
				<br>

				<!-- the user needs to choose a university -->
				
				<label for="user_uni_name">User University: </label>
				<select id="user_uni_name" name="user_uni_name">
					<?php while ($info = mysqli_fetch_array($result)) {?>
						<option value="<?php echo $info['uni_name']?>"><?php echo $info['uni_name'];?></option>
					<?php }?>
				</select>

				<br>
				<br>

				<button type="submit">Register</button>
			</div>
		</form>

	</body>

</html>