<!DOCTYPE html>
<html>
    <head>
        <title>Login Page</title>
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
        <?php require 'create_table.php'?>

        <form action="sign_in_user.php" method="post">
            <h1>LOGIN</h1>
            <div class="login_form_text">
                <label for="username">Username: </label>
                <input type="text" id="username" name="username">

                <br>
                <br>

                <label for="password">Password: </label>
                <input type="text" id="password" name="password">
                
                <br>
                <br>

                <button type="button">Log in</button>
            </div>>
        </form>

    </body>
</html>