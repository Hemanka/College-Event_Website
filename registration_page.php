<?php
	require 'create_table.php';
	
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

    <body class="form_page">

		<!-- do this need a "require"? -->
		<!-- <?php ?> -->
		<div class="get_info_form">
			<form class="usersInfo" action="register_user.php" method="post">
				<h1 class="login_tag">Sign Up</h1>
				<!-- may change/ create new css class -->
				<div class="login_form_text">

					<div class="error_message">
                        <?php if (isset($_SESSION['sign_up_error_message'])) { ?>
                            <p><?php echo $_SESSION['sign_up_error_message'];?></p>
                        <?php
                                unset($_SESSION['sign_up_error_message']);
                            }
                        ?>
                    </div>

					<label for="user_fname">First name: </label>
					<input type="text" id="user_fname" name="user_fname">

					<br>
					<br>

					<label for="user_lname">Last name: </label>
					<input type="text" id="user_lname" name="user_lname">

					<br>
					<br>
					<!--  (will be used as username) -->

					<label for="user_email">Email: </label>
					<input type="text" id="user_email" name="user_email">

					<br>
					<br>

					<label for="user_password">Password: </label>
					<input type="password" id="user_password" name="user_password">
					
					<br>
					<br>

					<!-- <label for="user_role">User Role: </label>
					<select id="user_role" name="user_role">
						<option value="student">Student<?php?></option>
						<option value="admin">Admin</option>
						<option value="super_admin">Super Admin</option>
					</select>
					
					<br>
					<br> -->

					<!-- the user needs to choose a university -->
					
					<label for="user_uni_id">User University: </label>
					<select id="user_uni_id" name="user_uni_id">
						<?php while ($info = mysqli_fetch_array($result)) {?>
							<option value="<?php echo $info['uni_id']?>"><?php echo $info['uni_name'];?></option>
						<?php }?>
					</select>

					<br>
					<br>

					<button class="login_button" type="submit">Sign Up</button>
					<p class="option">or <u><a class="login_link" href="login.php">Login</a></u></p>
				</div>
			</form>
		</div>

	</body>

</html>