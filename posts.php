<?php
require('objects.php');
//require('configure.php');


session_start();
if(isset($_SESSION['loggedIn'])){
    echo 'logged in <br>';
    require('database.php');
    if (!empty($_GET['id'])){
        $postId = intval($_GET['id']);
        $query = "SELECT CONCAT(f_name, ' ', l_name) AS name,
                        title,
                         post_time,
                         text,
                         posts.id
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
        if ($post !== false){
            echo '<ul>';
            echo '<h2><a href="posts.php?id='. $post['id'] .'">' .$post['title'] . '</a></h2> ' ;
            echo $post['post_time'] . ' ';
            echo '<p>' . $post['text'] . '</p>';
            echo '</ul>';
            print_r($post);
        } else {
            echo 'Post does not exist';
            exit();
        }

    } else {
        echo 'No post id provided';
        exit();
    }

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
