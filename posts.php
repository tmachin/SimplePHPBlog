<?php
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

//if(isset($_SESSION['loggedIn'])){

    require('database.php');
    if (!empty($_GET['id'])){
        $postId = intval($_GET['id']);
        $query = "SELECT CONCAT(f_name, ' ', l_name) AS name,
                        title,
                         post_time,
                         text,
                         posts.id,
                         author_ID
                     FROM posts JOIN users ON posts.author_ID = users.id
                     WHERE posts.id = ?
                     ORDER BY post_time DESC";

        try {
            $results = $db->prepare($query);
            $results->bindParam(1, $postId);
            $results->execute();
        } catch (Exception $e){
            echo $e->getMessage();
            exit();
        }
        $post = $results->fetch(PDO::FETCH_ASSOC);
        if (!empty($_GET['action'])){
            $action = $_GET['action'];
        } else {
            $action ='read';
        }

        if ($post !== false && $action === 'read'){
            $post_object= new Post($post['id'],$post['title'],$post['name'],$post['author_ID'],$post['text'],$post['post_time']);
            $post_object->display($loggedIn);

        } else if ($post !== false && $action === 'edit') {
            $post_object= new Post($post['id'],$post['title'],$post['name'],$post['author_ID'],$post['text'],$post['post_time']);
            $post_object->displayEditable();

        } else if ($post !== false && $action === 'delete') {
            echo ' Delete this post? <br/>';
            echo '<a href="delete.php?id='. $post['id'] .'">Yes!</a>';

            $post_object= new Post($post['id'],$post['title'],$post['name'],$post['author_ID'],$post['text'],$post['post_time']);
            $post_object->display($loggedIn);

        } else {
            echo 'Post does not exist';
            exit();
        }

    } else {
        echo 'No post id provided';
        exit();
    }

?>
