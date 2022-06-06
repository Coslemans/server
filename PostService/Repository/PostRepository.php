<?php
include_once "../Interfaces/IPostRepository.php";
include_once "../Models/Post.php";
include_once "../Interfaces/IDatabase.php";
include_once "../Models/DTOs/PostDTO.php";
class PostRepository implements IPostRepository
{
    /** @var IDatabase */
    private $_connContext;

    public function __construct($_connContext)
    {
        $this->_connContext = $_connContext;
    }
    public function CreatePost(Post $post)
    {
        $query = "INSERT INTO t_post
            SET Title=:title,
                Description=:descriptions,
                UserFK=:user,
                CreationDate=:data";
        $binding = $this->_connContext->getConnection()->prepare($query);
        $binding->bindParam(":title", $post->Title);
        $binding->bindParam(":descriptions", $post->Description);
        $binding->bindParam(":user", $post->UserFK);
        $binding->bindParam(":data", $post->CreationDate);

        if($binding->execute())
        {
            //http_response_code(200);
            return json_encode(array("message" => "Postarea ".$post->Title." a fost creata!"));
        }
        else
        {
            //http_response_code(400);
            return json_encode(array("messsage" => "Postarea nu a putut fi creata!"));
        }
    }

    public function UpdatePost($post)
    {
        $query = "UPDATE t_post
            SET Title=:title 
                ,Description=:description
            WHERE ID=:id
        ";
        $binding = $this->_connContext->getConnection()->prepare($query);
        $binding->bindParam(":title", $post->Title);
        $binding->bindParam(":description", $post->Description);
        $binding->bindParam(":id", $post->ID);

        if($binding->execute())
        {
            //http_response_code(200);
            return json_encode(array("message" => "Postarea ".$post->Title." a fost editata cu succes!"));
        }
        else
        {
            //http_response_code(400);
            return json_encode(array("messsage" => "Postarea nu a putut fi editata!"));
        }
        
    }

    public function DeletePost($id)
    {
        $query = "DELETE FROM t_post WHERE ID=:id";
        $binding = $this->_connContext->getConnection()->prepare($query);
        $binding->bindParam("id", $id);
        if($binding->execute())
        {
            //http_response_code(200);
            return json_encode(array("message" => "Postarea a fost stearsa cu succes!"));
        }
        else
        {
            //http_response_code(400);
            return json_encode(array("messsage" => "Postarea nu a putut fi stearsa!"));
        }
    }

    public function GetPosts($userData)
    {
        $userID = 0;
        if($userData!=null)
            $userID = $userData->userid;
        $query = "SELECT t_post.ID as ID, Title, Description, t_post.CreationDate as CreationDate, t_post.UserFK as UserID, t_user.Name as User FROM `t_post` INNER JOIN t_user on t_post.UserFK = t_user.ID ORDER BY CreationDate DESC;";
        $binding = $this->_connContext->getConnection()->prepare($query);

        $binding->execute();
        $entryCount = $binding->rowCount();
        $posts = array();
        for($i=0; $i<$entryCount; $i++)
        {
            $row = $binding->fetch(PDO::FETCH_ASSOC);
            $posts[$i] = new PostDTO();
            $posts[$i]->Id = $row["ID"];
            $posts[$i]->Title = $row["Title"];
            $posts[$i]->Description = $row["Description"];
            $posts[$i]->CreationDate = $row["CreationDate"];
            $posts[$i]->User = $row["User"];
            $userFK = $row["UserID"];
            if($userFK == $userID)
                $posts[$i]->canEdit = true;
            else
                $posts[$i]->canEdit = false;
            //$posts[i]->Title = $row["Title"];
        }

        return json_encode($posts);
    }

    public function GetPost($id)
    {
        $query = "SELECT * FROM t_post WHERE ID=:id LIMIT 1";

        $binding = $this->_connContext->getConnection()->prepare($query);

        $binding->bindParam("id", $id);

        $binding->execute();
        $entryCount = $binding->rowCount();

        if($entryCount > 0)
        {
            $post = new Post();

            $row = $binding->fetch(PDO::FETCH_ASSOC);

            $post->Id = $row['ID'];
            $post->Title = $row['Title'];
            $post->Description = $row['Description'];
            $post->UserFK = $row['UserFK'];
            $post->CreationDate = $row['CreationDate'];

            return $post;
        }
        else
            return null;
    }
}