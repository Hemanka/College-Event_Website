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
                                                    uni_num_of_student INT NOT NULL
                                                    PRIMARY KEY(uni_id),
                                                    FOREIGN KEY(uni_location_id),
                                                    REFERENCES Uni_location
                                                    
    )";
    $status = mysqli_query($connect, $sql);

    $sql = "CREATE TABLE IF NOT EXISTS Users(   user_id INTEGER AUTO_INCREMENT,
                                                user_fname CHAR(100) NOT NULL,
                                                user_lname CHAR(100) NOT NULL,
                                                user_email CHAR(100) NOT NULL,
                                                user_password CHAR(20) NOT NULL,
                                                uni_id INTEGER
                                                PRIMARY KEY(user_id),
                                                FOREIGN KEY(uni_id) REFERENCES University
    )";
    $status = mysqli_query($connect, $sql);

    // $sql = "CREATE TABLE IF NOT EXISTS Users(   user_id INTEGER AUTO_INCREMENT,
    //                                             user_fname CHAR(100) NOT NULL,
    //                                             user_lname CHAR(100) NOT NULL,
    //                                             user_email CHAR(100) NOT NULL,
    //                                             user_password CHAR(20) NOT NULL,
    //                                             PRIMARY KEY(user_id),
    // )";
    // $status = mysqli_query($connect, $sql);

    // $sql = "CREATE TABLE IF NOT EXISTS Student( student_id INTEGER AUTO_INCREMENT,
    //                                             user_id INTEGER, 
    //                                             uni_id INTEGER,
    //                                             PRIMARY KEY(student_id),
    //                                             FOREIGN KEY(user_id) REFERENCES Users,
    //                                             FOREIGN KEY(uni_id) REFERENCES University

    // )";
    // $status = mysqli_query($connect, $sql);

    // $sql = "CREATE TABLE IF NOT EXISTS User_admin(  admin_id INTEGER AUTO_INCREMENT,
    //                                                 user_id INTEGER,
    //                                                 uni_id INTEGER,
    //                                                 PRIMARY KEY(admin_id),
    //                                                 FOREIGN KEY(user_id) REFERENCES Users,
    //                                                 FOREIGN KEY(uni_id) REFERENCES University
    // )";
    // $status = mysqli_query($connect, $sql);

    // $sql = "CREATE TABLE IF NOT EXISTS User_superadmin( superadmin_id INTEGER AUTO_INCREMENT,
    //                                                     user_id INTEGER
    //                                                     PRIMARY KEY(superadmin_id),
    //                                                     FOREIGN KEY(user_id) REFERENCES Users
    // )";
    // $status = mysqli_query($connect, $sql);

    $sql = "CREATE TABLE IF NOT EXISTS Rso( rso_id INTEGER AUTO_INCREMENT,
                                            rso_name CHAR(100) NOT NULL,
                                            rso_status CHAR(100) NOT NULL,
                                            uni_id INTEGER,
                                            PRIMARY KEY(rso_id),
                                            FOREIGN KEY(uni_id) REFERENCES University

    )";
    $status = mysqli_query($connect, $sql);

    $sql = "CREATE TABLE IF NOT EXISTS Member_rso( member_id INTEGER AUTO_INCREMENT,
                                                    rso_id INTEGER,
                                                    user_is INTEGER,
                                                    PRIMARY KEY(member_id),
                                                    FOREIGN KEY(rso_id) REFERENCES Rso

    )";
    $status = mysqli_query($connect, $sql);

    // need to know the formate in which the location of the event would be stored
    $sql = "CREATE TABLE IF NOT EXISTS Events(  event_id INTEGER AUTO_INCREMENT,
                                                event_name CHAR(100),
                                                event_description CHAR(100),
                                                contact_number INTEGER,
                                                contact_email CHAR(100),
                                                event_data DATE,
                                                event_location CHAR(100),
                                                PRIMARY KEY(event_id)

    )";
    $status = mysqli_query($connect, $sql);

    $sql = "CREATE TABLE IF NOT EXISTS private_events(  private_event INTEGER AUTO_INCREMENT,
                                                        event_id INTEGER,
                                                        uni_id INTEGER, 
                                                        PRIMARY KEY(private_event),
                                                        FOREIGN KEY(event_id) REFERENCES Events,
                                                        FOREIGN KEY(uni_id) REFERENCES University

    )";
    $status = mysqli_query($connect, $sql);

    $sql = "CREATE TABLE IF NOT EXISTS Rso_events(  rso_event INTEGER AUTO_INCREMENT,
                                                    event_id INTEGER,
                                                    rso_id INTEGER, 
                                                    PRIMARY KEY(rso_event),
                                                    FOREIGN KEY(event_id) REFERENCES Events,
                                                    FOREIGN KEY(rso_id) REFERENCES Rso

    )";
    $status = mysqli_query($connect, $sql);

    $connect->close();

    echo "SUCCESS!";
?>