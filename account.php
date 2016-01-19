<?php
require('objects.php');
session_start();

if ($_GET['action'] == 'create'){
    // var_dump($_POST);
    // var_dump($_FILES);
    $newUser = $_POST;
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
            //
            // if (!file_exists('./profiles/')) {
            //     mkdir('./profiles/', 0777, true);
            // }

            $filename = "./img/" . $userImage['name'];
            move_uploaded_file($userImage['tmp_name'], $filename);

            // login the user by storing the email address in the email session variable and setting
            // the loggedin variable
            session_start();
            $user = login($db,$user['email'], $user['password']);
            if ($user !== false) {
                $_SESSION['userData'] = $user;
                $_SESSION['loggedIn'] = true;
            } else {
                echo 'Login attempt failed';
            }
            // $_SESSION['loggedin'] = true;
            // //$_SESSION['email'] = $user[0];
            // $_SESSION['userData']
            header("Location: index.php");
            exit();


}
