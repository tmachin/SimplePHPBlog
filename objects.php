<?php
class Post
{
    private $id = 0;
    private $title = '';
    private $author = '';
    private $text = '';
    private $date = '';

    public function __construct($postId, $postTitle, $postAuthor, $postAuthorID, $postText, $postDate) {
        $this->id = $postId;
        $this->title = $postTitle;
        $this->author = $postAuthor;
        $this->authorID = $postAuthorID;
        $this->text = $postText;
        $this->date = date('l jS \of F Y h:i:s A',$postDate);
    }

    public function getID(){
        return $this->id;
    }

    public function display($loggedIn) {
        echo '<article class="post">
        <header><h1><a href="posts.php?id='. $this->id .'">' .$this->title . '</a></h1></header>' ;
        echo '<section>';
        //echo '<h5>'.$this->author . ' -- ' . $this->date .'</h5>';
        echo '<h5><a href="users.php?id='.$this->authorID.'">'. $this->author . '</a> -- ' . $this->date .'</h5>';
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
        echo '<a href="users.php?id='.$this->authorID.'">'. $this->author . '</a> -- ' . $this->date .'<br>';
        echo '<label>Post Contents:<textarea name="text" rows="4" cols="50">'.$this->text.'</textarea></label>';
        echo '<button value="submit">Submit</button>';
    }

}

class User
{
    private $id = 0;
    private $email = '';
    //private $password = '';
    private $userimage = '';
    private $fname = '';
    private $lname = '';
    private $admin = false;

    public function __construct($userData) {

        $this->id = $userData['id'];
        $this->email = $userData['email'];
        //$this->password = $userPassword;
        $this->userimage = $userData['image_name'];
        $this->fname = $userData['f_name'];
        $this->lname = $userData['l_name'];
        $this->admin = $userData['admin'];
    }

    public function getID(){
        return $this->id;
    }

    public function isAdmin(){
        if ($this->admin == 1){
            return true;
        } else {
            return false;
        }

    }
    public function display(){
        echo '<div class="userinfo">';
        echo 'User:' . $this->id . ' -- ' . $this->fname . ' ' . $this->lname. ' <br/>';
        echo 'email:' . $this->email . '<br/>';
        //echo 'password: ' . $this->password;
        echo '<img src="img/'.$this->userimage.'" alt="'.$this->fname . ' ' . $this->lname.'"/><br/>';
        echo 'Admin Status:' . $this->admin . '<br/>';
        echo '</div>';

    }

    public function displayEditable() {
        $userHtml = '';
        $userHtml .= '<div class="userinfo">';

        $userHtml .= '<form action="user.php?id='.$this->id.'&action=update" method="POST" class="user edit">';
        $userHtml .= '<label>Name:<input type="text" name="title" value="'. $this->fname . ' ' . $this->lname. '"/></label> ' ;
        $userHtml .= 'email:' . $this->email . '<br/>';
        $userHtml .= '<img src="img/'.$this->userimage.'" alt="'.$this->fname . ' ' . $this->lname.'"/><br/>';
        $userHtml .= 'Admin Status:' . $this->admin . '<br/>';
        $userHtml .= '</div>';
        $userHtml .= '<button value="submit">Submit</button>';
        return $userHtml;
    }


}

 ?>
