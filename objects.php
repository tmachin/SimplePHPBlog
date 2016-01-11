<?php
class Post
{
    private $title = '';
    private $author = '';
    private $text = '';
    private $date = '';

    public function __construct($postTitle, $postAuthor, $postText, $postDate) {
        $this->title = $postTitle;
        $this->author = $postAuthor;
        $this->text = $postText;
        $this->date = date('l jS \of F Y h:i:s A',$postDate);
    }

    public function display() {
        echo '<hr>';
        echo $this->title . '<br>';
        echo $this->author . ' -- ' . $this->date .'<br>';
        echo $this->text . '<br>';
        echo '<hr>';
    }

}

 ?>
