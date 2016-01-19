<?php
require('objects.php');
session_start();

//create a new user if url specifies create action
if ($_GET['action'] == 'create'){
    //get new user info from post
    //TODO sanitize user information and make sure it is complete
    //TODO check that email is valid
    $newUser = $_POST;
    //add file info for user profile picture
    $newUser['userimage'] = $_FILES['userimage']['name'];
    createUser($newUser,$_FILES['userimage']);
}

function createUser($user,$userImage){
    require('database.php');
    $query = 'INSERT INTO users VALUES (null, :email , :password , :fName, :lName, :imageName, :admin) ';

    try {
        $results = $db->prepare($query);
        $results->execute(array(':email'=>$user['email'] ,
        ':password'=>password_hash($user['password'], PASSWORD_DEFAULT),
        ':fName'=>$user['fname'],
        ':lName'=>$user['lname'],
        ':imageName'=>$user['userimage'],
        ':admin'=>0));

    } catch (Exception $e){
        echo $e->getMessage();
        exit();
    }

            $filename = "./img/" . $userImage['name'];
            move_uploaded_file($userImage['tmp_name'], $filename);
            //once account is created, log the user in.
            // this should log the user in and make user data accessible to other functions
            //login the user by setting session loggedIn variable and userData

            session_start();
            $user = login($db,$user['email'], $user['password']);
            if ($user !== false) {
                $_SESSION['userData'] = $user;
                $_SESSION['loggedIn'] = true;
            } else {
                echo 'Login attempt failed';
            }

            header("Location: index.php");
            exit();


}
