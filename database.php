<?php
require('configure.php');
try {
    $db = new PDO('mysql:host='.$DBhost.';dbname='.$DBname, $DBusername, $DBpassword);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //var_dump($db);
    //
    //exit();
} catch (Exception $e) {
    echo $e->getMessage();
    //echo "Sorry PDO connection problem";
    exit();
}

function login($db,$email, $password){
    $query = "SELECT    id,
                        email,
                        password,
                        f_name,
                        l_name,
                        image_name,
                        admin
            FROM users
            WHERE email = :email";

    try {
        
        $results = $db->prepare($query);
        $results->execute(array(':email'=>$email));
        $user = $results->fetch(PDO::FETCH_ASSOC);
        if (password_verify($password, $user['password'])) {
            unset($user['password']);
            return $user;
        } else {
            echo 'Invalid password.';
            return false;
        }

    } catch (Exception $e){
        echo $e->getMessage();
        return false;
    }


}

?>
