<!DOCTYPE html>
<html>
    <head>
        <title>Registration Page</title>
        <meta name="viewpoint" content="width=device-width">

        <link rel="stylesheet" href = "style.css" />

        <div>
            <nav>
                <a class="nav_text" href = "public_event.php">Events</a>
                <a class="nav_text" href = "rso_event.php">RSO Events</a>
            </nav>
        </div>

    </head>

    <body>

		<!-- do this need a "require"? -->
		<?php ?>
			<form action="register_user.php" method="post">
			<h1>REGISTER</h1>
			<!-- may change/ create new css class -->
			<div class="login_form_text">
				
				<label for="user_id">User ID: </label>
				<input type="text" id="user_id" name="user_id">

				<br>
				<br>

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

				<label for="password">Password: </label>
				<input type="text" id="password" name="password">
				
				<br>
				<br>

				<label for="user_role">User ID: </label>
				<select id="user_role" name="user_role" form="user_role">
					<option value="student">Student</option>
					<option value="admin">Admin</option>
					<option value="super_admin">Super Admin</option>
				</select>

				<br>
				<br>

				<button type="button">Register</button>
			</div>>
		</form>

	</body>

</html>