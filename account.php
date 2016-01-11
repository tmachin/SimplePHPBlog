<?php
require('objects.php');
require('database.php');
session_start();

function save($user){
    $link = connectDB();

    if(!$link){
        echo mysqli_connect_error();
        return false;
    } else {
        echo 'Attempting to query DB<br>';

        $query = "INSERT INTO users SELECT null, '$user[0]', '$user[1]', '$user[2]', '$user[3]', '$user[4]', false;";
        $result = queryDB($link, $query);

        if(!$result){
            echo '<br>Unable to complete query<br>';
            echo 'That email may already be in our database. <br>';
            return false;
        } else {
            echo 'Query completed succesfully<br>';
            //when query is successful, move the file to its new location

            //check if profiles directory exists, and create it if it doesn't
            if (!file_exists('./profiles/')) {
                mkdir('./profiles/', 0777, true);
            }

            $filename = "./profiles/" . $user[4];
            move_uploaded_file($_FILES['userimage']['tmp_name'], $filename);

            //add first and last name overlay to image
            if (!addNameToImage($filename,$user[2]. " " .$user[3])){
                echo 'Error: Unable to save image with username overlay<br>';
            }

            // login the user by storing the email address in the email session variable and setting
            // the loggedin variable
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['email'] = $user[0];
            return true;
        }
    }
}
