<?php
//TODO move functionality into posts.php
require('objects.php');
require('database.php');
session_start();

if(isset($_SESSION['loggedIn']) && isset($_POST['title'])) {
    //TODO sanitize post fields before sending to DB
    $query = 'INSERT INTO posts VALUES (null, :posttime , :posttitle , :posttext,:userID ) ';

    try {
        $results = $db->prepare($query);
        $results->execute(array(':posttime'=> time(), ':posttitle'=>$_POST['title'], ':posttext'=>$_POST['text'], ':userID'=>intval($_SESSION['userData']['id'])));
        header("Location: index.php");
        exit();
    } catch (Exception $e){
        echo $e->getMessage();
        exit();
    }

} elseif(isset($_SESSION['loggedIn'])){
    ?>
    <div class="newpost">
    <form action="" method="POST">
        <label>Title:</label><br>
        <input type="text" name="title" placeholder="Post Title"/>
        <br>
        <label>Post:</label><br>
        <textarea type="text" name="text" placeholder="Post Body" col="50" rows="20"> </textarea>
        <input type="submit" value="submit"/>
    </form>
    </div>
    <?php
} else {
        header("Location: index.php");
        exit();
}

?>
