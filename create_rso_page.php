<!DOCTYPE html>
<html>
    <head>
        <title>Create RSO</title>
        <meta name="viewpoint" content="width=device-width">

        <link rel="stylesheet" href = "style.css" />
    </head>

    <body>

        <form action="create_rso.php" method="post">
            <h1>Create New RSO</h1>

            <div class="login_form_text">
                <label for="rso_name">RSO Name: </label>
                <input type="text" id="new_rso_name" name="new_rso_name">

                <br>
                <br>

                <label>Please fill in the information of other 4 members in your RSO</label>

                <br>
                <br>

                <label for="first_user_email">Person 1 Email address: </label>
                <input type="text" id="first_user_email" name="first_user_email">
                
                <br>
                <br>

                <label for="second_user_email">Person 2 Email address: </label>
                <input type="text" id="second_user_email" name="second_user_email">
                
                <br>
                <br>

                <label for="third_user_email">Person 3 Email address: </label>
                <input type="text" id="third_user_email" name="third_user_email">
                
                <br>
                <br>

                <label for="fourth_user_email">Person 4 Email address: </label>
                <input type="text" id="fourth_user_email" name="fourth_user_email">
                
                <br>
                <br>

                <button type="submit">Create RSO</button>
            </div>
        </form>

        

    </body>
</html>