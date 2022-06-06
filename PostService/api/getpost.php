<?php
include_once "../Repository/PostRepository.php";
include_once "../Models/Post.php";
include_once "../Models/DatabaseService.php";
include_once "../JWT/TokenManager.php";
include_once "../JWT/HeaderParser.php";
header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$data = json_decode(file_get_contents("php://input"));

$postRepository = new PostRepository(new DatabaseService());

$jwt = HeaderParser::getBearerToken();

$userData = TokenManager::CheckToken($jwt);

echo json_encode($postRepository->GetPost($data->id));