<?php
include_once "../Interfaces/IUserRepository.php";
include_once "../Models/User.php";
include_once "../Interfaces/IDatabase.php";
class UserRepository implements IUserRepository
{
    /** @var IDatabase */
    private  $_connContext;

    public function __construct($_connContext)
    {
        $this->_connContext = $_connContext;
    }

    /**
     * @param User $user
     */
    public function AddUser(User $user)
    {
        $query = "INSERT INTO t_user
             SET Name  = :fullname,
                 Email = :email,
                 Password = :password,
                 CreationDate = :CreationDate";

        $binding = $this->_connContext->getConnection()->prepare($query);

        $binding->bindParam(':fullname',$user->Name);
        $binding->bindParam(':email',$user->Email);
        $binding->bindParam(':password',$user->Password);
        $binding->bindParam(':CreationDate',$user->CreationDate);

        if($this->GetUser($user->Email)!= null)
        {
            //http_response_code(400);
            return json_encode(array("message" => "Utilizatorul este deja existent!"));
        }

        if($binding->execute())
        {

            //http_response_code(200);
            return json_encode(array("message" => "User creat cu succes!"));
        }
        else
        {

            //http_response_code(400);
            return json_encode(array("message" => "Utilizatorul nu a putut fi creat!"));
        }
    }

    public function UpdateUser($user)
    {
        // TODO: Implement UpdateUser() method.
    }

    public function DeleteUser($id)
    {
        // TODO: Implement DeleteUser() method.
    }
    /**
     * @param string $email
     * @return User
     */
    public function GetUser($email)
    {
        //$query = "SELECT * FROM T_User WHERE Email=:email LIMIT 1";
        $query = "SELECT * FROM t_user WHERE Email=:email LIMIT 1";
        $binding = $this->_connContext->getConnection()->prepare($query);

        $binding->bindValue(":email", $email,PDO::PARAM_STR);

        $binding->execute();
        $entryCount = $binding->rowCount();
        if($entryCount > 0)
        {
            $user = new User();

            $row = $binding->fetch(PDO::FETCH_ASSOC);

            $user->ID = $row['ID'];
            $user->Name = $row['Name'];
            $user->Email = $row['Email'];
            $user->Password = $row['Password'];
            $user->CreationDate = $row['CreationDate'];

            return $user;
        }
        else
            return null;

    }
    /**
     * @param int $id
     */
    public function GetUserByID($id)
    {
        $query = "SELECT * FROM t_user WHERE ID=:id LIMIT 1";

        $binding = $this->_connContext->getConnection()->prepare($query);

        $binding->bindParam("id", $id);

        $binding->execute();
        $entryCount = $binding->rowCount();

        if($entryCount > 0)
        {
            $user = new User();

            $row = $binding->fetch(PDO::FETCH_ASSOC);

            $user->ID = $row['ID'];
            $user->Name = $row['Name'];
            $user->Email = $row['Email'];
            $user->Password = $row['Password'];
            $user->CreationDate = $row['CreationDate'];

            return $user;
        }
        else
            return null;

    }
}