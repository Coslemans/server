<?php
header("Access-Control-Allow-Origin: https://localhost:4200");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "../Repository/UserRepository.php";
include_once "../Models/User.php";
include_once "../Models/DatabaseService.php";
include_once "../JWT/TokenManager.php";



$email ='';
$password = '';

$data = json_decode(file_get_contents("php://input"));

$email = $data->email;
$password = $data->password;

$userRepository = new UserRepository(new DatabaseService());
$user = $userRepository->GetUser($email);

if($user != null)
{
    if(password_verify($password,$user->Password))
    {
        
        http_response_code(200);

        echo json_encode(TokenManager::CreateToken($user->ID,$user->Email));
        
    }
    else
    {
        //http_response_code(401);
        //echo json_encode(array(
        //   "message" => "Invalid password."
        //));
        echo null;
    }
}
else{
    //http_response_code(401);
    //echo json_encode(array(
    //   "message" => "Invalid username."
    //));
    echo null;
}