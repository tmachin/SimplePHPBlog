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
if(isset($_SESSION['loggedIn'])){
    echo 'logged in <br>';
    $loggedIn = true;
} else {
    echo 'not logged in <br>';
    $loggedIn = false;
}

require('database.php');
$query = "SELECT CONCAT(f_name, ' ', l_name) AS name,
                    title,
                     post_time,
                     text,
                     posts.id
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
        $post_object= new Post($post['id'],$post['title'],$post['name'],$post['text'],$post['post_time']);
        $post_object->display($loggedIn);
}


    //option to add new post
if (isset($_POST['email'])) {
    echo 'log in attempt';
    //log in if username is good
    $_SESSION['loggedIn'] = true;
} else {
    //display log in form
    ?>
    <form action="" method="POST">
        <input type="text" name="email" placeholder="email"/>
        <input type="submit" value="submit"/>
    </form>
    <?php

}
echo "<a href='new.php'>Create new post</a>";
echo '<br>';
echo "<a href='logout.php'>Log out</a>";
?>
</body>
</html>
