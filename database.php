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
                        f_name,
                        l_name,
                        image_name,
                        admin
            FROM users
            WHERE email = :email AND password = :password";

    try {
        //$results = $db->query($query);
        $results = $db->prepare($query);
        $results->execute(array(':email'=>$email, ':password'=>$password));
        $user = $results->fetch(PDO::FETCH_ASSOC);
        return $user;
    } catch (Exception $e){
        echo $e->getMessage();
        return false;
    }


}

?>
