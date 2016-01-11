<?php
class Post
{
    private $id = 0;
    private $title = '';
    private $author = '';
    private $text = '';
    private $date = '';

    public function __construct($postId, $postTitle, $postAuthor, $postText, $postDate) {
        $this->id = $postId;
        $this->title = $postTitle;
        $this->author = $postAuthor;
        $this->text = $postText;
        $this->date = date('l jS \of F Y h:i:s A',$postDate);
    }

    public function display($loggedIn) {
        echo '<article class="post">
        <header><h1><a href="posts.php?id='. $this->id .'">' .$this->title . '</a></h1></header>' ;
        echo '<section>';
        echo '<h5>'.$this->author . ' -- ' . $this->date .'</h5>';
        echo '<p>'. $this->text . '</p>';
        echo '</section>';
        echo '<footer>';
        if ($loggedIn){
            echo '<a href="posts.php?id='.$this->id.'&action=edit">Edit post</a> | ';
            echo '<a href="posts.php?id='.$this->id.'&action=delete">Delete post </a>';
        }
        echo '</footer></article>';
    }

    public function displayEditable() {
        echo '<form action="update.php?id='.$this->id.'" method="POST" class="post edit">';
        echo '<label>Title:<input type="text" name="title" value="'.$this->title.'"/></label> ' ;
        echo $this->author . ' -- ' . $this->date .'<br>';
        echo '<label>Post Contents:<textarea name="text" rows="4" cols="50">'.$this->text.'</textarea></label>';
        echo '<button value="submit">Submit</button>';
    }

}

 ?>
