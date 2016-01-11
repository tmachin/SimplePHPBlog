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

    public function display() {
        echo '<hr>';
        echo '<li class="post"><h2><a href="posts.php?id='. $this->id .'">' .$this->title . '</a></h2> ' ;
        echo $this->title . '<br>';
        echo $this->author . ' -- ' . $this->date .'<br>';
        echo '<p>'. $this->text . '</p>';
        echo '<a href="posts.php?id='.$this->id.'&mode=edit">Edit post </a>';
        echo '<a href="posts.php?id='.$this->id.'&mode=delete">Delete post </a></li>';
        //echo '<hr>';
    }

}

 ?>
