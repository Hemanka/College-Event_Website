<?php
    $servername = "localhost";
    $username = "root";
    $password = "password";

    $connect = mysqli_connect($servername, $username, $password);

    if (!$connect)
    {
        die("Connection failed");
    }

    $sql = "CREATE DATABASE IF NOT EXISTS college_event_db";
    $status = mysqli_query($connect, $sql);

    // mysqli_free_result($status);
    $connect->close();

    $dbname = "college_event_db";
    $connect = new mysqli($servername, $username, $password, $dbname);

    if ($connect->connect_error)
    {
        die("Connection failed");
    }

    $sql = "CREATE TABLE IF NOT EXISTS University(  uni_id INTEGER AUTO_INCREMENT,
                                                    uni_name CHAR(100) NOT NULL,
                                                    uni_address CHAR(100) NOT NULL,
                                                    uni_description CHAR(100) NOT NULL,
                                                    PRIMARY KEY(uni_id)
                                                    
    )";
    $status = mysqli_query($connect, $sql);

    $sql = "CREATE TABLE IF NOT EXISTS Users(   user_id INTEGER AUTO_INCREMENT,
                                                user_fname CHAR(100) NOT NULL,
                                                user_lname CHAR(100) NOT NULL,
                                                user_role CHAR(20) NOT NULL,
                                                uni_id INTEGER,
                                                user_email CHAR(100) NOT NULL,
                                                user_password CHAR(20) NOT NULL,
                                                PRIMARY KEY(user_id),
                                                FOREIGN KEY(uni_id) REFERENCES University(uni_id)
    )";
    $status = mysqli_query($connect, $sql);

    $sql = "CREATE TABLE IF NOT EXISTS Rso( rso_id INTEGER AUTO_INCREMENT,
                                            rso_name CHAR(100) NOT NULL,
                                            rso_status CHAR(100) NOT NULL,
                                            admin_id INTEGER NOT NULL,
                                            uni_id INTEGER NOT NULL,
                                            PRIMARY KEY(rso_id),
                                            FOREIGN KEY(uni_id) REFERENCES University(uni_id),
                                            FOREIGN KEY(admin_id) REFERENCES Users(user_id)

    )";
    $status = mysqli_query($connect, $sql);

    $sql = "CREATE TABLE IF NOT EXISTS Member_rso( member_id INTEGER AUTO_INCREMENT,
                                                    rso_id INTEGER,
                                                    user_id INTEGER,
                                                    PRIMARY KEY(member_id),
                                                    FOREIGN KEY(rso_id) REFERENCES Rso(rso_id),
                                                    FOREIGN KEY(user_id) REFERENCES Users(user_id)

    )";
    $status = mysqli_query($connect, $sql);

    // $sql = "CREATE TABLE IF NOT EXISTS Event_location(  loc_id INTEGER AUTO_INCREMENT,
    //                                                     latitude INTEGER NOT NULL,
    //                                                     longitude INTEGER NOT NULL,
    //                                                     PRIMARY KEY(loc_id)

    // )";
    // $status = mysqli_query($connect, $sql);


    // need to take care of the type of events
    // need to know the formate in which the location of the event would be stored
    $sql = "CREATE TABLE IF NOT EXISTS Events(  event_id INTEGER AUTO_INCREMENT,
                                                event_name CHAR(100) NOT NULL,
                                                event_description CHAR(100) NOT NULL,
                                                contact_number CHAR(10) NOT NULL,
                                                contact_email CHAR(100) NOT NULL,
                                                -- event_date DATE NOT NULL,
                                                -- start_time TIME NOT NULL,
                                                -- end_time TIME NOT NULL,
                                                -- loc_id INTEGER,
                                                -- latitude INTEGER NOT NULL,
                                                -- longitude INTEGER NOT NULL,
                                                event_type CHAR(10) NOT NULL,
                                                uni_id INTEGER,
                                                rso_id INTEGER,
                                                PRIMARY KEY(event_id),
                                                FOREIGN KEY(rso_id) REFERENCES Rso(rso_id),
                                                FOREIGN KEY(uni_id) REFERENCES University(uni_id)
                                                -- FOREIGN KEY(loc_id) REFERENCES Event_location(loc_id)

    )";
    $status = mysqli_query($connect, $sql);

    $sql = "CREATE TABLE IF NOT EXISTS Comments(    comment_id INTEGER AUTO_INCREMENT,
                                                    event_id INTEGER NOT NULL,
                                                    user_id INTEGER NOT NULL,
                                                    comment_text CHAR(100) NOT NULL,
                                                    PRIMARY KEY(comment_id),
                                                    FOREIGN KEY(event_id) REFERENCES Events(event_id),
                                                    FOREIGN KEY(user_id) REFERENCES University(uni_id)

    )";
    $status = mysqli_query($connect, $sql);



    // $sql = "CREATE TABLE IF NOT EXISTS Public_events(   public_event_id INTEGER AUTO_INCREMENT,
    //                                                     event_id INTEGER NOT NULL,
    //                                                     PRIMARY KEY(public_event_id),
    //                                                     FOREIGN KEY(event_id) REFERENCES Events(event_id)
    //                                             -- FOREIGN KEY(loc_id) REFERENCES Event_location(loc_id)

    // )";
    // $status = mysqli_query($connect, $sql);

    // $sql = "CREATE TABLE IF NOT EXISTS Private_events(  private_event_id INTEGER AUTO_INCREMENT,
    //                                                     event_id INTEGER NOT NULL,
    //                                                     PRIMARY KEY(private_event_id),
    //                                                     FOREIGN KEY(event_id) REFERENCES Events(event_id)
    //                                             -- FOREIGN KEY(loc_id) REFERENCES Event_location(loc_id)

    // )";
    // $status = mysqli_query($connect, $sql);

    // $sql = "CREATE TABLE IF NOT EXISTS Rso_events(  rso_event_id INTEGER AUTO_INCREMENT,
    //                                                 event_id INTEGER NOT NULL,
    //                                                 rso_id
    //                                                 PRIMARY KEY(private_event_id),
    //                                                 FOREIGN KEY(event_id) REFERENCES Events(event_id),
    //                                                 FOREIGN KEY(rso_id) REFERENCES Rso(rso_id)

    // )";
    // $status = mysqli_query($connect, $sql);

    // $sql = "CREATE TABLE IF NOT EXISTS Public_events(  public_event_id INTEGER AUTO_INCREMENT,
    //                                                     event_id INTEGER NOT NULL,
    //                                                     PRIMARY KEY(public_event_id),
    //                                                     FOREIGN KEY(event_id) REFERENCES Events(event_id)

    // )";
    // $status = mysqli_query($connect, $sql);

    // $sql = "CREATE TABLE IF NOT EXISTS Private_events(  private_event_id INTEGER AUTO_INCREMENT,
    //                                                     event_id INTEGER NOT NULL,
    //                                                     uni_id INTEGER NOT NULL,
    //                                                     PRIMARY KEY(private_id),
    //                                                     FOREIGN KEY(event_id) REFERENCES Events(event_id),
    //                                                     FOREIGN KEY(uni_id) REFERENCES University(uni_id)

    // )";
    // $status = mysqli_query($connect, $sql);

    // $sql = "CREATE TABLE IF NOT EXISTS Rso_events(      rso_event_id INTEGER AUTO_INCREMENT,
    //                                                     event_id INTEGER NOT NULL,
    //                                                     rso_id INTEGER NOT NULL,
    //                                                     PRIMARY KEY(private_id),
    //                                                     FOREIGN KEY(event_id) REFERENCES Events(event_id),
    //                                                     FOREIGN KEY(rso_id) REFERENCES Rso(rso_id)

    // )";
    // $status = mysqli_query($connect, $sql);

    // create a new table for each event type -- maybe, if needed

    // $sql = "INSERT INTO University(uni_name, uni_address, uni_description) 
    //         VALUE ('University of Central Florida', '4000 Central Florida Blvd, Orlando, Fl, 32816', 
    //                 'Home of Knights')";
    // $status = mysqli_query($connect, $sql);

    // $sql = "INSERT INTO University(uni_name, uni_address, uni_description) 
    //         VALUE ('University of Florida', 'Gainesville, Fl, 32611', 'Home of Gators')";
    // $status = mysqli_query($connect, $sql);

    // $sql = "INSERT INTO Users(user_fname, user_lname, user_role, uni_id, user_email, user_password) 
    //          VALUE ('John', 'Will', 'student', '1', 'john@knights.ucf.edu', 'john')";
    // $status = mysqli_query($connect, $sql);

    
    // $sql = "INSERT INTO Users(user_fname, user_lname, user_role, uni_id, user_email, user_password) 
    //          VALUE ('Josh', 'someone', 'admin', '1', 'josh@knights.ucf.edu', 'josh')";
    // $status = mysqli_query($connect, $sql);
    
    // $sql = "INSERT INTO Users(user_fname, user_lname, user_role, uni_id, user_email, user_password) 
    //          VALUE ('rando', 'Will', 'Super Admin', '1', 'rando@knights.ucf.edu', 'rando')";
    // $status = mysqli_query($connect, $sql);

    // $sql = "INSERT INTO Users(user_fname, user_lname, user_role, uni_id, user_email, user_password) 
    //           VALUE ('Sam', 'Will', 'Student', '2', 'sam@uf.edu', 'sam')";
    // $status = mysqli_query($connect, $sql);

    // // // will be using this
    // $sql = "INSERT INTO Events(event_name, event_description, contact_number, contact_email, event_type)
    //         VALUE ('Hackaton', 'You can build your new projects', '1112223333', 'josh@knights.ucf.edu', 'Public')";
    // $status = mysqli_query($connect, $sql);

    // $sql = "INSERT INTO Events(event_name, event_description, contact_number, contact_email, event_type)
    //         VALUE ('Hackaton 2', 'You can build your another new projects', '1112223333', 'josh@knights.ucf.edu', 'Public')";
    // $status = mysqli_query($connect, $sql);

    // $sql = "INSERT INTO Events(event_name, event_description, contact_number, contact_email, event_type, uni_id)
    //         VALUE ('Resume Building', 'It is never to early to build your resume. Learn the important things to include in your resume',
    //             '4412223333', 'rando@knights.ucf.edu', 'Private', '1')";
    // $status = mysqli_query($connect, $sql);

    // $sql = "INSERT INTO Events(event_name, event_description, contact_number, contact_email, event_type, uni_id)
    //         VALUE ('Advisor meeting', 'Plan you future semester',
    //             '4412228333', 'sam@uf.edu', 'Private', '2')";
    // $status = mysqli_query($connect, $sql);

    //------------------------------------------------------------------------------------------------------

    // would not be using this
    // $sql = "INSERT INTO Events(event_name, event_description, contact_number, contact_email, 
    //                             event_date, start_time, end_time, latitude, longitude)
    //         VALUE ('Hackaton', 'You can build your new projects', '1112223333', 'josh@knights.ucf.edu', 
    //                             'Public')";
    // $status = mysqli_query($connect, $sql);

    // $sql = "INSERT INTO Events(event_name, event_description, contact_number, contact_email)
    //         VALUE ('Hackaton', 'You can build your new projects', '1112223333', 'josh@knights.ucf.edu')";
    // $status = mysqli_query($connect, $sql);

    

    $connect->close();

    // this line needs to be removed
    echo "SUCCESS!";
?>