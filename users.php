<?php
require('objects.php');
require('database.php');
session_start();

if (!isset($_GET['action']) && isset($_GET['id'])){

    $user = new User(loadUser($db,$_GET['id']));
    //$user->display();
    $userHtml = $user->display();


} elseif ($_GET['action'] == 'create'){
//create a new user if url specifies create action
    //get new user info from post
    //TODO sanitize user information and make sure it is complete
    //TODO check that email is valid
    $newUser = $_POST;
    //add file info for user profile picture
    $newUser['userimage'] = $_FILES['userimage']['name'];
    createUser($newUser,$_FILES['userimage']);
} elseif ($_GET['action'] == 'edit'){

    $user = new User($_SESSION['userData']);
    $viewedUser = new User(loadUser($db,$_GET['id']));
    echo $user->isAdmin();
    echo $user->getID();
    if ($_GET['id'] == $user->getID()){
        echo 'can edit this entry';
        $userHtml = $viewedUser->displayEditable();
    } else {
        echo 'cannot edit this entry';
        $userHtml = $viewedUser->display();
    }
} elseif ($_GET['action'] == 'update'){

}

function createUser($user,$userImage){

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
?>
<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Simple test blog</title>
  <meta name="description" content="A very simple blog">
  <meta name="author" content="Thomas Machin">

  <link rel="stylesheet" href="style.css">

  <!--[if lt IE 9]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
</head>
<body>
<?php
echo $userHtml;
 ?>
</body>
</html>
