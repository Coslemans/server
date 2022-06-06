<?php

interface IPostRepository
{
    public function CreatePost(Post $post);
    public function UpdatePost($post);
    public function DeletePost($id);
    public function GetPosts($userData);
    public function GetPost($id);

}