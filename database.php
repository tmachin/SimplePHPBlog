<?php
/*
* database.php
*
* creates DB connection
* and contains login()
*/
require('configure.php');
try {
    $db = new PDO('mysql:host='.$DBhost.';dbname='.$DBname, $DBusername, $DBpassword);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (Exception $e) {
    echo $e->getMessage();

    exit();
}
// attempt to log user in on success, returns user object. returns false on failed login
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
