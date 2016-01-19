<?php
/*
* update.php
* takes post values and get id number and updates appropriate post with
* title and text supplied
*
* @author: Thomas Machin
*/
//TODO move functionality into posts.php
require('objects.php');
session_start();

if(isset($_SESSION['loggedIn']) && isset($_POST['title'])) {

    require('database.php');
    $query = 'UPDATE posts
    SET title=:posttitle , text=:posttext
    WHERE id=:postid';

    try {
        $results = $db->prepare($query);
        $results->execute(array(':posttitle'=>$_POST['title'], ':posttext'=>$_POST['text'], ':postid'=>$_GET['id']));
        header("Location: index.php");
        exit();
    } catch (Exception $e){
        echo $e->getMessage();
        exit();
    }

} elseif(isset($_SESSION['loggedIn'])){
    ?>
    <form action="" method="POST">
        Title: <input type="text" name="title" placeholder="Post Title"/>
        <br>
        Post: <textarea type="text" name="text" placeholder="Post Body"> </textarea>
        <input type="submit" value="submit"/>
    </form>
    <?php
} else {
        header("Location: index.php");
        exit();
}

?>
