<?php
/*
* Some sort of blog like thing. Grab posts from DB, grab Author, display them together
* @Author: Thomas Machin
*/
require('objects.php');
session_start();

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

//if user is logged in, load their userdata
if(isset($_SESSION['loggedIn'])){
    echo 'logged in <br>';
    $loggedIn = true;
    $user = new User($_SESSION['userData']);
    $user->display();
} else { //if not logged in, show create new user form
    echo 'not logged in <br>';
    $loggedIn = false;
    ?>
    <div class="createuser">
        <form enctype="multipart/form-data" action="users.php?action=create" method="POST">
            <fieldset>
                <label>Email address: <input type="text" name="email" placeholder="yourname@website.com"></input></label>
                <br/>
                <label>Password: <input type="password" name="password" placeholder="password"></input></label>
                <br/>
                <label>Profile picture: <input type="file" name="userimage"></input></label>
                <br/>
                <label>First name: <input type="text" name="fname" placeholder="First name"></input></label>
                <br/>
                <label>Last name: <input type="text" name="lname" placeholder="Last name"></input></label>
                <br/>
                <input type="submit" value="Submit" />
            </fieldset>
        </form>
    </div>
<?php
}
//Show all posts in DB
require('database.php');
$query = "SELECT CONCAT(f_name, ' ', l_name) AS name,
                    title,
                     post_time,
                     text,
                     posts.id as postID,
                     users.id as userID
                 FROM posts JOIN users ON posts.author_ID = users.id
                 ORDER BY post_time DESC";
try {
    $results = $db->query($query);
} catch (Exception $e){
    echo $e->getMessage();
    exit();
}
$posts = $results->fetchAll(PDO::FETCH_ASSOC);
foreach ($posts as $post) {
        //var_dump($post);
        $post_object= new Post($post['postID'],$post['title'],$post['name'], $post['userID'],$post['text'],$post['post_time']);
        $post_object->display($loggedIn);
}


if (isset($_POST['email'])) {
    echo 'log in attempt';
    //log in if username is good
    $user = login($db,$_POST['email'], $_POST['password']);
    if ($user !== false) {
        $_SESSION['userData'] = $user;
        $_SESSION['loggedIn'] = true;
    } else {
        echo 'Login attempt failed';
    }

} elseif (!isset($_SESSION['loggedIn'])) {
    //display log in form if user is not logged in
    ?>
    <div class="login">
        <form action="" method="POST">
            <input type="text" name="email" placeholder="email"/>
            <input type="password" name="password" placeholder="password"/>
            <input type="submit" value="submit"/>
        </form>
    </div>
    <?php

}
echo "<a href='new.php'>Create new post</a>";
echo '<br>';
echo "<a href='logout.php'>Log out</a>";
?>
</body>
</html>
