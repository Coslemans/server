<?php

interface IUserRepository
{
    public function AddUser(User $user);
    public function UpdateUser($user);
    public function DeleteUser($id);
    public function GetUser($email);
}