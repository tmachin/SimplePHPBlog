<?php
require('objects.php');
require('database.php');
session_start();

if(isset($_SESSION['loggedIn']) && isset($_POST['title'])) {

    require('database.php');
    $query = 'INSERT INTO posts VALUES (null, :posttime , :posttitle , :posttext,1 ) ';

    try {
        $results = $db->prepare($query);
        $results->execute(array(':posttime'=> time(), ':posttitle'=>$_POST['title'], ':posttext'=>$_POST['text']));
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
