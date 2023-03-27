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
                                            uni_id INTEGER NOT NULL,
                                            PRIMARY KEY(rso_id),
                                            FOREIGN KEY(uni_id) REFERENCES University(uni_id)

    )";
    $status = mysqli_query($connect, $sql);

    $sql = "CREATE TABLE IF NOT EXISTS Member_rso( member_id INTEGER AUTO_INCREMENT,
                                                    rso_id INTEGER,
                                                    user_id INTEGER,
                                                    PRIMARY KEY(member_id),
                                                    FOREIGN KEY(rso_id) REFERENCES Rso(rso_id),
                                                    FOREIGN KEY(user_id) REFERENCES University(uni_id)

    )";
    $status = mysqli_query($connect, $sql);

    // need to take care of the type of events
    // need to know the formate in which the location of the event would be stored
    $sql = "CREATE TABLE IF NOT EXISTS Events(  event_id INTEGER AUTO_INCREMENT,
                                                event_name CHAR(100),
                                                event_description CHAR(100),
                                                contact_number INTEGER,
                                                contact_email CHAR(100),
                                                event_date DATE,
                                                event_location CHAR(100),
                                                rso_id INTEGER,
                                                PRIMARY KEY(event_id),
                                                FOREIGN KEY(rso_id) REFERENCES Rso(rso_id)

    )";
    $status = mysqli_query($connect, $sql);

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

    $connect->close();

    // this line needs to be removed
    echo "SUCCESS!";
?>