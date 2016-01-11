<?php
/*
* Some sort of blog like thing. Grab posts from DB, grab Author, display them together WEB 2.0!
*
*/
require('objects.php');
//require('configure.php');


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
    echo '<ul>';
    foreach ($posts as $post) {
        echo '<li class="post"><h2><a href="posts.php?id='. $post['id'] .'">' .$post['title'] . '</a></h2> ' ;
        echo $post['name'] . " -- " . date('l jS \of F Y h:i:s A',$post['post_time']) . ' ';
        echo '<p>' . $post['text'] . '</p>';
        echo '<a href="edit.php?id='.$post['id'].'">Edit post </a>';
        echo '<a href="delete.php?id='.$post['id'].'">Delete post </a></li>';
    }
    echo '</ul>';
    // //show posts
    // //$link = connectDB();
    // //$mysqli = new mysqli($DBhost, $DBusername, $DBpassword, $DBname);
    //
    // /* check connection */
    // if ($mysqli->connect_errno) {
    //     printf("Connect failed: %s\n", $mysqli->connect_error);
    //     exit();
    // }
    // $query = "SELECT CONCAT(f_name, ' ', l_name) AS name,
    //                 title,
    //                  post_time,
    //                  text
    //              FROM posts JOIN users ON posts.author_ID = users.id
    //              ORDER BY post_time DESC";
    // if ($result = $mysqli->query($query)) {
    //     printf("Select returned %d rows.\n", $result->num_rows);
    //
    //
    //     while($row = $result->fetch_array(MYSQLI_ASSOC)) {
    //         $post = new Post($row['title'],$row['name'],$row['text'],$row['post_time']);
    //         $post->display();
    //     }
    //     $result->close();
    // }
    echo "<a href='new.php'>Create new post</a>";


    //option to add new post
} elseif ($_POST['email']) {
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
?>
</body>
</html>
