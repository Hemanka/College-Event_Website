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
                                                    comment_time TIMESTAMP NOT NULL,
                                                    rating INTEGER NOT NULL,
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

    // uni_id = 1
    $sql = "INSERT INTO University(uni_id, uni_name, uni_address, uni_description, uni_email_domain) 
            VALUE ('1', 'University of Central Florida', '4000 Central Florida Blvd, Orlando, Fl, 32816', 
                    'Home of Knights', '@knights.ucf.edu')";
    $status = mysqli_query($connect, $sql);

    // uni_id = 2
    $sql = "INSERT INTO University(uni_id, uni_name, uni_address, uni_description, uni_email_domain) 
            VALUE ('2', 'University of Florida', 'Gainesville, Fl, 32611', 'Home of Gators', '@uf.edu')";
    $status = mysqli_query($connect, $sql);

    // user_id = 1 -- student
    $sql = "INSERT INTO Users(user_id, user_fname, user_lname, user_role, uni_id, user_email, user_password) 
             VALUE ('1', 'John', 'Will', 'Student', '1', 'john@knights.ucf.edu', 'john')";
    $status = mysqli_query($connect, $sql);

    // user_id = 2
    $sql = "INSERT INTO Users(user_id, user_fname, user_lname, user_role, uni_id, user_email, user_password) 
             VALUE ('2', 'Josh', 'someone', 'Admin', '1', 'josh@knights.ucf.edu', 'josh')";
    $status = mysqli_query($connect, $sql);

    // user_id = 3
    $sql = "INSERT INTO Users(user_id, user_fname, user_lname, user_role, uni_id, user_email, user_password) 
             VALUE ('3', 'Olivia', 'Brown', 'Admin', '1', 'olivia@knights.ucf.edu', 'olivia')";
    $status = mysqli_query($connect, $sql);

    // user_id = 4 -- student
    $sql = "INSERT INTO Users(user_id, user_fname, user_lname, user_role, uni_id, user_email, user_password) 
             VALUE ('4', 'Ethan', 'Jones', 'Student', '2', 'ethan@uf.edu', 'ethan')";
    $status = mysqli_query($connect, $sql);

    // user_id = 5 -- student
    $sql = "INSERT INTO Users(user_id, user_fname, user_lname, user_role, uni_id, user_email, user_password) 
             VALUE ('5', 'Sana', 'Patel', 'Student', '2', 'sana@uf.edu', 'sana')";
    $status = mysqli_query($connect, $sql);

    // user_id = 6
    $sql = "INSERT INTO Users(user_id, user_fname, user_lname, user_role, uni_id, user_email, user_password) 
             VALUE ('6', 'Jia', 'Ling', 'Admin', '2', 'jia@uf.edu', 'jia')";
    $status = mysqli_query($connect, $sql);

    // user_id = 7 -- super admin
    $sql = "INSERT INTO Users(user_id, user_fname, user_lname, user_role, uni_id, user_email, user_password) 
             VALUE ('7', 'Junho', 'Park', 'Super Admin', '1', 'junho@knights.ucf.edu', 'junho')";
    $status = mysqli_query($connect, $sql);

    // user_id = 8
    $sql = "INSERT INTO Users(user_id, user_fname, user_lname, user_role, uni_id, user_email, user_password) 
             VALUE ('8', 'Priya', 'Singh', 'Admin', '1', 'priya@knights.ucf.edu', 'priya')";
    $status = mysqli_query($connect, $sql);

    // user_id = 9
    $sql = "INSERT INTO Users(user_id, user_fname, user_lname, user_role, uni_id, user_email, user_password) 
             VALUE ('9', 'Sean', 'Lee', 'Admin', '2', 'sean@uf.edu', 'sean')";
    $status = mysqli_query($connect, $sql);

    // user_id = 10 -- student
    $sql = "INSERT INTO Users(user_id, user_fname, user_lname, user_role, uni_id, user_email, user_password) 
             VALUE ('10', 'Adam', 'Will', 'Student', '1', 'adam@knights.ucf.edu', 'adam')";
    $status = mysqli_query($connect, $sql);

    // user_id = 11 -- student
    $sql = "INSERT INTO Users(user_id, user_fname, user_lname, user_role, uni_id, user_email, user_password) 
             VALUE ('11', 'Bree', 'Ballard', 'Student', '1', 'bree@knights.ucf.edu', 'bree')";
    $status = mysqli_query($connect, $sql);

    $sql = "INSERT INTO Users(user_id, user_fname, user_lname, user_role, uni_id, user_email, user_password) 
             VALUE ('12', 'Jerome', 'Smith', 'Student', '1', 'Jerome@knights.ucf.edu', 'Jerome')";
    $status = mysqli_query($connect, $sql);

    $sql = "INSERT INTO Users(user_id, user_fname, user_lname, user_role, uni_id, user_email, user_password) 
             VALUE ('13', 'Orion', 'Blake', 'Student', '1', 'Orion@knights.ucf.edu', 'Orion')";
    $status = mysqli_query($connect, $sql);

    $sql = "INSERT INTO Users(user_id, user_fname, user_lname, user_role, uni_id, user_email, user_password) 
             VALUE ('14', 'Erica', 'Janet', 'Student', '2', 'Erica@uf.edu', 'Erica')";
    $status = mysqli_query($connect, $sql);

    $sql = "INSERT INTO Users(user_id, user_fname, user_lname, user_role, uni_id, user_email, user_password) 
             VALUE ('15', 'Sameel', 'Siddiqi', 'Student', '2', 'Sameel@uf.edu', 'Sameel')";
    $status = mysqli_query($connect, $sql);

    $sql = "INSERT INTO Users(user_id, user_fname, user_lname, user_role, uni_id, user_email, user_password) 
             VALUE ('16', 'Jeetsuki', 'Kun', 'Student', '2', 'Jeetsuki@uf.edu', 'Jeetsuki')";
    $status = mysqli_query($connect, $sql);

    $sql = "INSERT INTO Users(user_id, user_fname, user_lname, user_role, uni_id, user_email, user_password) 
             VALUE ('17', 'Junkook', 'Bee-tee-es', 'Student', '1', 'Junkook@knights.ucf.edu', 'Junkook')";
    $status = mysqli_query($connect, $sql);

    $sql = "INSERT INTO Users(user_id, user_fname, user_lname, user_role, uni_id, user_email, user_password) 
             VALUE ('18', 'Pegasus', 'Seiya', 'Student', '1', 'Pegasus@knights.ucf.edu', 'Pegasus')";
    $status = mysqli_query($connect, $sql);

    $sql = "INSERT INTO Users(user_id, user_fname, user_lname, user_role, uni_id, user_email, user_password) 
             VALUE ('19', 'Shiryu', 'Duragon', 'Super Admin', '2', 'Shiryu@uf.edu', 'Shiryu')";
    $status = mysqli_query($connect, $sql);

    $sql = "INSERT INTO Users(user_id, user_fname, user_lname, user_role, uni_id, user_email, user_password) 
             VALUE ('20', 'Altec', 'Lansing', 'Student', '1', 'Altec@knights.ucf.edu', 'Altec')";
    $status = mysqli_query($connect, $sql);

    // rso_id = 1
    $sql = "INSERT INTO Rso(rso_id, rso_name, rso_status, admin_id, uni_id) 
            VALUE ('1', 'Robotics Club', 'Active', '2', '1')";
    $status = mysqli_query($connect, $sql);

    $sql = "INSERT INTO Member_rso(member_id, rso_id, user_id) 
            VALUE ('1', '1', '2')";
    $status = mysqli_query($connect, $sql);

    $sql = "INSERT INTO Member_rso(member_id, rso_id, user_id) 
            VALUE ('2', '1', '1')";
    $status = mysqli_query($connect, $sql);

    $sql = "INSERT INTO Member_rso(member_id, rso_id, user_id) 
            VALUE ('3', '1', '3')";
    $status = mysqli_query($connect, $sql);

    $sql = "INSERT INTO Member_rso(member_id, rso_id, user_id) 
            VALUE ('4', '1', '8')";
    $status = mysqli_query($connect, $sql);

    $sql = "INSERT INTO Member_rso(member_id, rso_id, user_id) 
            VALUE ('5', '1', '10')";
    $status = mysqli_query($connect, $sql);

    // rso_id = 2
    $sql = "INSERT INTO Rso(rso_id, rso_name, rso_status, admin_id, uni_id) 
            VALUE ('2', 'Community Servies Club', 'Active', '3', '1')";
    $status = mysqli_query($connect, $sql);

    $sql = "INSERT INTO Member_rso(member_id, rso_id, user_id) 
            VALUE ('6', '2', '3')";
    $status = mysqli_query($connect, $sql);

    $sql = "INSERT INTO Member_rso(member_id, rso_id, user_id) 
            VALUE ('7', '2', '1')";
    $status = mysqli_query($connect, $sql);

    $sql = "INSERT INTO Member_rso(member_id, rso_id, user_id) 
            VALUE ('8', '2', '11')";
    $status = mysqli_query($connect, $sql);

    $sql = "INSERT INTO Member_rso(member_id, rso_id, user_id) 
            VALUE ('9', '2', '12')";
    $status = mysqli_query($connect, $sql);

    $sql = "INSERT INTO Member_rso(member_id, rso_id, user_id) 
            VALUE ('10', '2', '13')";
    $status = mysqli_query($connect, $sql);

    // rso_id = 3
    $sql = "INSERT INTO Rso(rso_id, rso_name, rso_status, admin_id, uni_id) 
            VALUE ('3', 'Video Games Club', 'Active', '8', '1')";
    $status = mysqli_query($connect, $sql);

    $sql = "INSERT INTO Member_rso(member_id, rso_id, user_id) 
            VALUE ('11', '3', '8')";
    $status = mysqli_query($connect, $sql);

    $sql = "INSERT INTO Member_rso(member_id, rso_id, user_id) 
            VALUE ('12', '3', '17')";
    $status = mysqli_query($connect, $sql);

    $sql = "INSERT INTO Member_rso(member_id, rso_id, user_id) 
            VALUE ('13', '3', '18')";
    $status = mysqli_query($connect, $sql);

    $sql = "INSERT INTO Member_rso(member_id, rso_id, user_id) 
            VALUE ('14', '3', '20')";
    $status = mysqli_query($connect, $sql);

    $sql = "INSERT INTO Member_rso(member_id, rso_id, user_id) 
            VALUE ('15', '3', '1')";
    $status = mysqli_query($connect, $sql);

    // rso_id = 4
    $sql = "INSERT INTO Rso(rso_id, rso_name, rso_status, admin_id, uni_id) 
            VALUE ('4', 'Debate Club', 'Active', '6', '2')";
    $status = mysqli_query($connect, $sql);

    $sql = "INSERT INTO Member_rso(member_id, rso_id, user_id) 
            VALUE ('16', '4', '6')";
    $status = mysqli_query($connect, $sql);

    $sql = "INSERT INTO Member_rso(member_id, rso_id, user_id) 
            VALUE ('17', '4', '4')";
    $status = mysqli_query($connect, $sql);

    $sql = "INSERT INTO Member_rso(member_id, rso_id, user_id) 
            VALUE ('18', '4', '5')";
    $status = mysqli_query($connect, $sql);

    $sql = "INSERT INTO Member_rso(member_id, rso_id, user_id) 
            VALUE ('19', '4', '14')";
    $status = mysqli_query($connect, $sql);

    $sql = "INSERT INTO Member_rso(member_id, rso_id, user_id) 
            VALUE ('20', '4', '15')";
    $status = mysqli_query($connect, $sql);

    // rso_id = 5
    $sql = "INSERT INTO Rso(rso_id, rso_name, rso_status, admin_id, uni_id) 
            VALUE ('5', 'Outdoors Club', 'Active', '9', '2')";
    $status = mysqli_query($connect, $sql);

    $sql = "INSERT INTO Member_rso(member_id, rso_id, user_id) 
            VALUE ('20', '5', '9')";
    $status = mysqli_query($connect, $sql);

    $sql = "INSERT INTO Member_rso(member_id, rso_id, user_id) 
            VALUE ('21', '5', '4')";
    $status = mysqli_query($connect, $sql);

    $sql = "INSERT INTO Member_rso(member_id, rso_id, user_id) 
            VALUE ('22', '5', '5')";
    $status = mysqli_query($connect, $sql);

    $sql = "INSERT INTO Member_rso(member_id, rso_id, user_id) 
            VALUE ('23', '5', '6')";
    $status = mysqli_query($connect, $sql);

    $sql = "INSERT INTO Member_rso(member_id, rso_id, user_id) 
            VALUE ('24', '5', '16')";
    $status = mysqli_query($connect, $sql);

    $sql = "INSERT INTO Member_rso(member_id, rso_id, user_id) 
            VALUE ('25', '5', '14')";
    $status = mysqli_query($connect, $sql);

    // location 1 - student union 
    $sql = "INSERT INTO Event_location(loc_id, loc_name, latitude, longitude) 
            VALUE ('1', 'Student Union', '28.601720028286387', '-81.20040256091856')";
    $status = mysqli_query($connect, $sql);

    // location 2 - reflecting pond
    $sql = "INSERT INTO Event_location(loc_id, loc_name, latitude, longitude) 
            VALUE ('2', 'Reflecting Pond', '28.599782391875614', '-81.20200047811245')";
    $status = mysqli_query($connect, $sql);

    //  location 3 - lib
    $sql = "INSERT INTO Event_location(loc_id, loc_name, latitude, longitude) 
            VALUE ('3', 'John C. Hitt Library', '28.60042293324504', '-81.20148549399389')";
    $status = mysqli_query($connect, $sql);

    //  location 4 - flavet field
    $sql = "INSERT INTO Event_location(loc_id, loc_name, latitude, longitude) 
            VALUE ('4', 'Flavet Field', '29.64747289727294', '-82.35445858329476')";
    $status = mysqli_query($connect, $sql);

    // location 5 - sw recreation field complex
    $sql = "INSERT INTO Event_location(loc_id, loc_name, latitude, longitude) 
            VALUE ('5', 'SW Recreation Field Complex', '29.64043713776004', '-82.36449646745443')";
    $status = mysqli_query($connect, $sql);


    // -----USING this format---
    // event_id = 1 - Public
    $sql = "INSERT INTO Events(event_id, event_name, event_cat, event_description, contact_number, contact_email, 
                                event_date, start_time, end_time, loc_id, event_type)
            VALUE ('1', 'Hackaton', 'Social', 'You can build your new projects', '1112223333', 'josh@knights.ucf.edu', 
                    '2023-04-24', '09:00:00', '10:00:00' , '1', 'Public')";
    $status = mysqli_query($connect, $sql);
        // 28.601720028286387, -81.20040256091856
        // 28.60161641, -81.20045620

    // event_id = 2 - Public
    $sql = "INSERT INTO Events(event_id, event_name, event_cat, event_description, contact_number, contact_email, 
                                event_date, start_time, end_time, loc_id, event_type)
            VALUE ('2', 'Spirit Splash', 'Social', 'Come with your friends to the reflection pond', '1142223333', 
                    'junho@knights.uf.edu', '2023-10-25', '10:00:00', '12:00:00', '2', 'Public')";
    $status = mysqli_query($connect, $sql);

    $sql = "INSERT INTO Events(event_id, event_name, event_cat, event_description, contact_number, contact_email, 
                                event_date, start_time, end_time, loc_id, event_type)
            VALUE ('17', 'Movie Night', 'Social', 'Join us on this fun event where we watch movie and have fun', '1142223333', 
                    'junho@knights.ucf.edu', '2023-10-20', '20:00:00', '23:00:00', '1', 'Public')";
    $status = mysqli_query($connect, $sql);

    $sql = "INSERT INTO Events(event_id, event_name, event_cat, event_description, contact_number, contact_email, 
                                event_date, start_time, end_time, loc_id, event_type)
            VALUE ('20', 'Career Fair', 'Academic', 'Join us at the SU where you could network with other companies', '1142223333', 
                    'junho@knights.ucf.edu', '2023-10-26', '20:00:00', '23:00:00', '1', 'Public')";
    $status = mysqli_query($connect, $sql);
    

    // event_id = 3 - Private: UCF
    $sql = "INSERT INTO Events(event_id, event_name, event_cat, event_description, contact_number, contact_email, 
                                event_date, start_time, end_time, loc_id, event_type, uni_id)
            VALUE ('3', 'Resume Building', 'Academic', 'It is never to early to build your resume. Learn the important things to include in your resume',
                '4412223333', 'olivia@knights.ucf.edu', '2023-09-24', '12:00:00', '13:00:00', '3', 'Private', '1')";
    $status = mysqli_query($connect, $sql);

    $sql = "INSERT INTO Events(event_id, event_name, event_cat, event_description, contact_number, contact_email, 
                                event_date, start_time, end_time, loc_id, event_type, uni_id)
            VALUE ('4', 'Free Coffee and Study Space', 'Social', 'There would be free Coffee and study space for you to prepare for the finals',
                '4412223333', 'olivia@knights.ucf.edu', '2023-04-18', '9:00:00', '15:00:00', '3', 'Private', '1')";
    $status = mysqli_query($connect, $sql);

    $sql = "INSERT INTO Events(event_id, event_name, event_cat, event_description, contact_number, contact_email, 
                                event_date, start_time, end_time, loc_id, event_type, uni_id)
            VALUE ('5', 'Free Coffee and Study Space', 'Social', 'There would be free Coffee and study space for you to prepare for the finals',
                '4412223333', 'olivia@knights.ucf.edu', '2023-04-19', '12:00:00', '16:00:00', '3', 'Private', '1')";
    $status = mysqli_query($connect, $sql);

    $sql = "INSERT INTO Events(event_id, event_name, event_cat, event_description, contact_number, contact_email, 
                                event_date, start_time, end_time, loc_id, event_type, uni_id)
            VALUE ('15', 'Open Table Small Group', 'Social', 'We divide into small groups and get to know each other',
                '1112223333', 'josh@knights.ucf.edu', '2023-04-19', '12:00:00', '16:00:00', '1', 'Private', '1')";
    $status = mysqli_query($connect, $sql);

    $sql = "INSERT INTO Events(event_id, event_name, event_cat, event_description, contact_number, contact_email, 
                                event_date, start_time, end_time, loc_id, event_type, uni_id)
            VALUE ('18', 'Jenga Battle', 'Social', 'Join us for this fun jenga battle',
                '1112223333', 'josh@knights.ucf.edu', '2023-04-19', '12:00:00', '16:00:00', '1', 'Private', '1')";
    $status = mysqli_query($connect, $sql);

     $sql = "INSERT INTO Events(event_id, event_name, event_cat, event_description, contact_number, contact_email, 
                                event_date, start_time, end_time, loc_id, event_type, uni_id)
            VALUE ('19', 'Study Abroad Fair', 'Academic', 'Join us on this informational section, where we learn about the study abroad program',
                '1142223333', 'junho@knights.ucf.edu', '2023-04-19', '12:00:00', '16:00:00', '1', 'Private', '1')";
    $status = mysqli_query($connect, $sql);

    // event_id = 4 - Private: UF
    $sql = "INSERT INTO Events(event_id, event_name, event_cat, event_description, contact_number, contact_email, 
                                event_date, start_time, end_time, loc_id, event_type, uni_id)
            VALUE ('6', 'Sports Day', 'Sports', 'Plan you future semester', '4412228333', 'jia@uf.edu', 
                    '2023-05-24', '9:00:00', '10:00:00', '5', 'Private', '2')";
    $status = mysqli_query($connect, $sql);

    $sql = "INSERT INTO Events(event_id, event_name, event_cat, event_description, contact_number, contact_email, 
                                event_date, start_time, end_time, loc_id, event_type, uni_id)
            VALUE ('14', 'Birthday Bash', 'Social', 'Stop by the field and grab a cupcake and join us for some games at the field', '4412228333', 'jia@uf.edu', 
                    '2023-04-19', '16:00:00', '19:00:00', '4', 'Private', '2')";
    $status = mysqli_query($connect, $sql);

    // event_id = 5 - Rso:1
    $sql = "INSERT INTO Events(event_id, event_name, event_cat, event_description, contact_number, contact_email, 
                                event_date, start_time, end_time, loc_id, event_type, rso_id)
            VALUE ('7', 'General Body Meeting', 'Social', 'discuss this month active', '1112223333', 'josh@knights.ucf.edu', 
                    '2023-05-25', '9:00:00', '10:00:00', '3', 'Rso', '1')";
    $status = mysqli_query($connect, $sql);

    $sql = "INSERT INTO Events(event_id, event_name, event_cat, event_description, contact_number, contact_email, 
                                event_date, start_time, end_time, loc_id, event_type, rso_id)
            VALUE ('8', 'Beach CleanUp and Social', 'Social', 'We meet up at SU and head to our location. Join us for this fun event', '4412223333', 'olivia@knights.ucf.edu', 
                    '2023-04-22', '9:00:00', '18:00:00', '1', 'Rso', '2')";
    $status = mysqli_query($connect, $sql);

    $sql = "INSERT INTO Events(event_id, event_name, event_cat, event_description, contact_number, contact_email, 
                                event_date, start_time, end_time, loc_id, event_type, rso_id)
            VALUE ('9', 'End of Year Party', 'Social', 'Join us on this fun event, where we celebrate your journey semester', '4412224933', 'priya@knights.ucf.edu', 
                    '2023-04-20', '17:00:00', '19:00:00', '2', 'Rso', '3')";
    $status = mysqli_query($connect, $sql);

    $sql = "INSERT INTO Events(event_id, event_name, event_cat, event_description, contact_number, contact_email, 
                                event_date, start_time, end_time, loc_id, event_type, rso_id)
            VALUE ('10', 'Game Night', 'Social', 'Join us on this fun event, where we celebrate your journey semester', '4412224933', 'priya@knights.ucf.edu', 
                    '2023-04-18', '18:00:00', '20:00:00', '1', 'Rso', '3')";
    $status = mysqli_query($connect, $sql);

    $sql = "INSERT INTO Events(event_id, event_name, event_cat, event_description, contact_number, contact_email, 
                                event_date, start_time, end_time, loc_id, event_type, rso_id)
            VALUE ('11', 'General Body Meeting', 'Social', 'Discuss our plan for the upcoming competition and chill at the field', '4992223333', 'jia@uf.edu', 
                    '2023-04-25', '18:00:00', '20:00:00', '4', 'Rso', '4')";
    $status = mysqli_query($connect, $sql);

    $sql = "INSERT INTO Events(event_id, event_name, event_cat, event_description, contact_number, contact_email, 
                                event_date, start_time, end_time, loc_id, event_type, rso_id)
            VALUE ('12', 'Club Hangout', 'Social', 'Come and join us for this fun event, where we hangout and chill after the finals', '4992223533', 'sean@uf.edu', 
                    '2023-05-05', '18:00:00', '20:00:00', '4', 'Rso', '5')";
    $status = mysqli_query($connect, $sql);

    $sql = "INSERT INTO Events(event_id, event_name, event_cat, event_description, contact_number, contact_email, 
                                event_date, start_time, end_time, loc_id, event_type, rso_id)
            VALUE ('13', 'Board Game Night', 'Social', 'Come and join us for this fun event, where we hangout and chill after the stressful weeks of finals', '4412224933', 'priya@knights.ucf.edu', 
                    '2023-05-05', '18:00:00', '20:00:00', '1', 'Rso', '3')";
    $status = mysqli_query($connect, $sql);

    $sql = "INSERT INTO Events(event_id, event_name, event_cat, event_description, contact_number, contact_email, 
                                event_date, start_time, end_time, loc_id, event_type, rso_id)
            VALUE ('16', 'Mario Kart Jeopardy', 'Social', 'Come and join us for this fun event, where we hangout and chill after the stressful weeks of finals', '4412224933', 'priya@knights.ucf.edu', 
                    '2023-04-21', '16:00:00', '17:00:00', '1', 'Rso', '3')";
    $status = mysqli_query($connect, $sql);

    
    
    
    
    
    
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