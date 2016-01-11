<?php
require('objects.php');
/*
* delete.php
* Delete the post supplied on with $_GET['id']
*
*
* @author
*/


session_start();
if(isset($_SESSION['loggedIn'])){
    echo 'logged in <br>';
    require('database.php');
    if (!empty($_GET['id'])){
        $postId = intval($_GET['id']);
        $query = "DELETE FROM posts
                WHERE id=:postid";
        try {
            $results = $db->prepare($query);
            $results->bindParam(':postid', $postId);
            $results->execute();
            header("Location: index.php");
            exit();
        } catch (Exception $e){
            echo $e->getMessage();
            exit();
        }
        //$post = $results->fetch(PDO::FETCH_ASSOC);


    } else {
        echo 'No post id provided';
        exit();
    }

} else {
    header("Location: index.php");
    exit();
}
?>
