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
                                                    uni_email_domain CHAR(30) NOT NULL,
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

    $sql = "CREATE TABLE IF NOT EXISTS Event_location(  loc_id INTEGER AUTO_INCREMENT,
                                                        loc_name CHAR(30) NOT NULL,
                                                        latitude REAL NOT NULL,
                                                        longitude REAL NOT NULL,
                                                        PRIMARY KEY(loc_id)
    )";
    $status = mysqli_query($connect, $sql);


    // need to take care of the type of events
    // need to know the formate in which the location of the event would be stored
    $sql = "CREATE TABLE IF NOT EXISTS Events(  event_id INTEGER AUTO_INCREMENT,
                                                event_name CHAR(100) NOT NULL,
                                                event_cat CHAR(100) NOT NULL,
                                                event_description CHAR(100) NOT NULL,
                                                contact_number CHAR(10) NOT NULL,
                                                contact_email CHAR(100) NOT NULL,
                                                event_date DATE NOT NULL,
                                                start_time TIME NOT NULL,
                                                end_time TIME NOT NULL,
                                                loc_id INTEGER,
                                                -- event_date DATE NOT NULL,
                                                -- start_time TIME NOT NULL,
                                                -- end_time TIME NOT NULL,
                                                -- start_time DATETIME NOT NULL,
                                                -- end_time DATETIME NOT NULL,
                                                -- start_time TIMESTAMP NOT NULL,
                                                -- end_time TIMESTAMP NOT NULL,
                                                -- long_lat POINT NOT NULL,
                                                -- loc_id INTEGER NOT NULL,
                                                -- latitude DECIMAL(10, 8) NOT NULL,
                                                -- longitude DECIMAL(10, 8) NOT NULL,
                                                event_type CHAR(10) NOT NULL,
                                                uni_id INTEGER,
                                                rso_id INTEGER,
                                                PRIMARY KEY(event_id),
                                                -- SPATIAL INDEX (long_lat),
                                                FOREIGN KEY(rso_id) REFERENCES Rso(rso_id),
                                                FOREIGN KEY(uni_id) REFERENCES University(uni_id),
                                                FOREIGN KEY(loc_id) REFERENCES Event_location(loc_id)

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

    $sql = "CREATE TABLE IF NOT EXISTS Approval(    approval_id INTEGER AUTO_INCREMENT,
                                                    event_id INTEGER NOT NULL,
                                                    request_user_id INTEGER NOT NULL,
                                                    PRIMARY KEY(approval_id),
                                                    FOREIGN KEY(event_id) REFERENCES Events(event_id),
                                                    FOREIGN KEY(request_user_id) REFERENCES Users(user_id)

    )";
    $status = mysqli_query($connect, $sql);

    // // uni_id = 1
    // $sql = "INSERT INTO University(uni_name, uni_address, uni_description, uni_email_domain) 
    //         VALUE ('University of Central Florida', '4000 Central Florida Blvd, Orlando, Fl, 32816', 
    //                 'Home of Knights', 'knights.ucf.edu')";
    // $status = mysqli_query($connect, $sql);

    // // uni_id = 2
    // $sql = "INSERT INTO University(uni_name, uni_address, uni_description, uni_email_domain) 
    //         VALUE ('University of Florida', 'Gainesville, Fl, 32611', 'Home of Gators', 'uf.edu')";
    // $status = mysqli_query($connect, $sql);

    // // user_id = 1 -- student
    // $sql = "INSERT INTO Users(user_fname, user_lname, user_role, uni_id, user_email, user_password) 
    //          VALUE ('John', 'Will', 'Student', '1', 'john@knights.ucf.edu', 'john')";
    // $status = mysqli_query($connect, $sql);

    // // user_id = 2
    // $sql = "INSERT INTO Users(user_fname, user_lname, user_role, uni_id, user_email, user_password) 
    //          VALUE ('Josh', 'someone', 'Admin', '1', 'josh@knights.ucf.edu', 'josh')";
    // $status = mysqli_query($connect, $sql);

    // // user_id = 3
    // $sql = "INSERT INTO Users(user_fname, user_lname, user_role, uni_id, user_email, user_password) 
    //          VALUE ('Olivia', 'Brown', 'Admin', '1', 'olivia@knights.ucf.edu', 'olivia')";
    // $status = mysqli_query($connect, $sql);

    // // user_id = 4 -- student
    // $sql = "INSERT INTO Users(user_fname, user_lname, user_role, uni_id, user_email, user_password) 
    //          VALUE ('Ethan', 'Jones', 'Student', '2', 'ethan@uf.edu', 'ethan')";
    // $status = mysqli_query($connect, $sql);

    // // user_id = 5 -- student
    // $sql = "INSERT INTO Users(user_fname, user_lname, user_role, uni_id, user_email, user_password) 
    //          VALUE ('Sana', 'Patel', 'Student', '2', 'sana@uf.edu', 'sana')";
    // $status = mysqli_query($connect, $sql);

    // // user_id = 6
    // $sql = "INSERT INTO Users(user_fname, user_lname, user_role, uni_id, user_email, user_password) 
    //          VALUE ('Jia', 'Ling', 'Admin', '2', 'jia@uf.edu', 'jia')";
    // $status = mysqli_query($connect, $sql);

    // // user_id = 7 -- super admin
    // $sql = "INSERT INTO Users(user_fname, user_lname, user_role, uni_id, user_email, user_password) 
    //          VALUE ('Junho', 'Park', 'Super Admin', '1', 'junho@knights.uf.edu', 'junho')";
    // $status = mysqli_query($connect, $sql);

    // // user_id = 8
    // $sql = "INSERT INTO Users(user_fname, user_lname, user_role, uni_id, user_email, user_password) 
    //          VALUE ('Priya', 'Singh', 'Admin', '1', 'priya@knights.uf.edu', 'priya')";
    // $status = mysqli_query($connect, $sql);

    // // user_id = 9
    // $sql = "INSERT INTO Users(user_fname, user_lname, user_role, uni_id, user_email, user_password) 
    //          VALUE ('Sean', 'Lee', 'Admin', '2', 'sean@uf.edu', 'sean')";
    // $status = mysqli_query($connect, $sql);

    // // user_id = 10 -- student
    // $sql = "INSERT INTO Users(user_fname, user_lname, user_role, uni_id, user_email, user_password) 
    //          VALUE ('Adam', 'Will', 'Student', '1', 'adam@uf.edu', 'adam')";
    // $status = mysqli_query($connect, $sql);

    // // rso_id = 1
    // $sql = "INSERT INTO Rso(rso_name, rso_status, admin_id, uni_id) 
    //         VALUE ('Robotics Club', 'Active', '2', '1')";
    // $status = mysqli_query($connect, $sql);

    // $sql = "INSERT INTO Member_rso(rso_id, user_id) 
    //         VALUE ('1', '2')";
    // $status = mysqli_query($connect, $sql);

    // // rso_id = 2
    // $sql = "INSERT INTO Rso(rso_name, rso_status, admin_id, uni_id) 
    //         VALUE ('Community Servies Club', 'Active', '3', '1')";
    // $status = mysqli_query($connect, $sql);

    // $sql = "INSERT INTO Member_rso(rso_id, user_id) 
    //         VALUE ('2', '3')";
    // $status = mysqli_query($connect, $sql);

    // // rso_id = 3
    // $sql = "INSERT INTO Rso(rso_name, rso_status, admin_id, uni_id) 
    //         VALUE ('Outdoors Club', 'Active', '8', '1')";
    // $status = mysqli_query($connect, $sql);

    // $sql = "INSERT INTO Member_rso(rso_id, user_id) 
    //         VALUE ('3', '8')";
    // $status = mysqli_query($connect, $sql);

    // // rso_id = 4
    // $sql = "INSERT INTO Rso(rso_name, rso_status, admin_id, uni_id) 
    //         VALUE ('Debate Club', 'Active', '6', '2')";
    // $status = mysqli_query($connect, $sql);

    // $sql = "INSERT INTO Member_rso(rso_id, user_id) 
    //         VALUE ('4', '6')";
    // $status = mysqli_query($connect, $sql);

    // // rso_id = 5
    // $sql = "INSERT INTO Rso(rso_name, rso_status, admin_id, uni_id) 
    //         VALUE ('Video Games Club', 'Active', '9', '2')";
    // $status = mysqli_query($connect, $sql);

    // $sql = "INSERT INTO Member_rso(rso_id, user_id) 
    //         VALUE ('5', '9')";
    // $status = mysqli_query($connect, $sql);

    // location 1 - student union 
    // $sql = "INSERT INTO Event_location(loc_name, latitude, longitude) 
    //         VALUE ('Student Union', '28.601720028286387', '-81.20040256091856')";
    // $status = mysqli_query($connect, $sql);

    // // location 2 - reflecting pond
    // $sql = "INSERT INTO Event_location(loc_name, latitude, longitude) 
    //         VALUE ('Reflecting Pond', '28.599782391875614', '-81.20200047811245')";
    // $status = mysqli_query($connect, $sql);

    // //  location 3 - lib
    // $sql = "INSERT INTO Event_location(loc_name, latitude, longitude) 
    //         VALUE ('John C. Hitt Library', '28.60042293324504', '-81.20148549399389')";
    // $status = mysqli_query($connect, $sql);

    // //  location 4 - flavet field
    // $sql = "INSERT INTO Event_location(loc_name, latitude, longitude) 
    //         VALUE ('Flavet Field', '29.64747289727294', '-82.35445858329476')";
    // $status = mysqli_query($connect, $sql);

    // // location 5 - sw recreation field complex
    // $sql = "INSERT INTO Event_location(loc_name, latitude, longitude) 
    //         VALUE ('SW Recreation Field Complex', '29.64043713776004', '-82.36449646745443')";
    // $status = mysqli_query($connect, $sql);


    // -----USING this format---
    // event_id = 1 - Public
    // $sql = "INSERT INTO Events(event_name, event_cat, event_description, contact_number, contact_email, 
    //                             event_date, start_time, end_time, loc_id, event_type)
    //         VALUE ('Hackaton', 'Social', 'You can build your new projects', '1112223333', 'josh@knights.ucf.edu', 
    //                 '2023-04-24', '09:00:00', '10:00:00' , '1', 'Public')";
    // $status = mysqli_query($connect, $sql);
    //     // 28.601720028286387, -81.20040256091856
    //     // 28.60161641, -81.20045620

    // // event_id = 2 - Public
    // $sql = "INSERT INTO Events(event_name, event_cat, event_description, contact_number, contact_email, 
    //                             event_date, start_time, end_time, loc_id, event_type)
    //         VALUE ('Spirit Splash', 'Social', 'Come with your friends to the reflection pond', '1142223333', 
    //                 'junho@knights.uf.edu', '2023-10-25', '10:00:00', '12:00:00', '2', 'Public')";
    // $status = mysqli_query($connect, $sql);

    // // event_id = 3 - Private: UCF
    // $sql = "INSERT INTO Events(event_name, event_cat, event_description, contact_number, contact_email, 
    //                             event_date, start_time, end_time, loc_id, event_type, uni_id)
    //         VALUE ('Resume Building', 'Academic', 'It is never to early to build your resume. Learn the important things to include in your resume',
    //             '4412223333', 'olivia@knights.ucf.edu', '2023-09-24', '12:00:00', '13:00:00', '3', 'Private', '1')";
    // $status = mysqli_query($connect, $sql);

    // // event_id = 4 - Private: UF
    // $sql = "INSERT INTO Events(event_name, event_cat, event_description, contact_number, contact_email, 
    //                             event_date, start_time, end_time, loc_id, event_type, uni_id)
    //         VALUE ('Sports Day', 'Sports', 'Plan you future semester', '4412228333', 'jia@uf.edu', 
    //                 '2023-05-24', '9:00:00', '10:00:00', '5', 'Private', '2')";
    // $status = mysqli_query($connect, $sql);

    // // event_id = 4 - Rso:1
    // $sql = "INSERT INTO Events(event_name, event_cat, event_description, contact_number, contact_email, 
    //                             event_date, start_time, end_time, loc_id, event_type, rso_id)
    //         VALUE ('General Body Meeting', 'Social', 'discuss this month active', '1112223333', 'josh@knights.ucf.edu', 
    //                 '2023-05-25', '9:00:00', '10:00:00', '3', 'Rso', '1')";
    // $status = mysqli_query($connect, $sql);

    
    
    
    
    
    
    //--------------------need to delete this later------------------
    // event_id = 5 - Rso: 1
    // $sql = "INSERT INTO Events(event_name, event_cat, event_description, contact_number, contact_email) 
    //                             event_date, start_time, end_time, loc_id, event_type)
    //         VALUE ('General Body meeting', 'Social', 'Discuss this month active', '1112223333', 'josh@knights.ucf.edu',
    //                  '2023-05-25', '9:00:00', '10:00:00', '3', 'Rso' )";
    // $status = mysqli_query($connect, $sql);


//     $sql = "INSERT INTO Events(event_name, event_description, contact_number, contact_email, event_type, rso_id)
//             VALUE ('General Body meeting', 'Discuss this month\'s active', '2228880011', 'josh@knights.ucf.edu', 'Private', '1')";
//     $status = mysqli_query($connect, $sql);

        // $sql = "INSERT INTO Events(event_name, event_description, contact_number, contact_email, start_time, end_time, long_lat, event_type)
//         VALUE ('Hackaton', 'You can build your new projects', '1112223333', 'josh@knights.ucf.edu', '2023-04-24 09:00:00', '2023-04-24 10:00:00' , POINT(28.601720028286387, -81.20040256091856), 'Public')";
// $status = mysqli_query($connect, $sql);

// $sql = "INSERT INTO Events(event_name, event_description, contact_number, contact_email, start_time, end_time, long_lat, event_type)
//         VALUE ('Hackaton', 'You can build your new projects', '1112223333', 'josh@knights.ucf.edu', '2023-04-24 09:00:00', '2023-04-24 10:00:00' , POINT(28.601720028286387, -81.20040256091856), 'Public')";
// $status = mysqli_query($connect, $sql);


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
    // echo "SUCCESS!";
?>