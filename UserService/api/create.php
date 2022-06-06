<?php
include_once "../Repository/UserRepository.php";
include_once "../Models/User.php";
include_once "../Models/DatabaseService.php";

header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$data = json_decode(file_get_contents("php://input"));
$userRepository = new UserRepository(new DatabaseService());
$user = new User();

$user->Name = $data->name;
$user->Email = $data->email;
$user->CreationDate = date('Y-m-d H:i:s');
$user->Password = password_hash($data->password, PASSWORD_BCRYPT);

$message = $userRepository->AddUser($user);

echo $message;


