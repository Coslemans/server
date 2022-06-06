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


//$jwt = null;

$data = json_decode(file_get_contents("php://input"));


$jwt = HeaderParser::getBearerToken();
$userData = TokenManager::CheckToken($jwt);

if($userData != null)
{   
    $dt = new DateTime("now", new DateTimeZone('Europe/Bucharest'));
    $post = new Post();
    $post->Title = $data->title;
    $post->Description = $data->description;
    $post->CreationDate = $dt->format('Y-m-d H:i:s');
    $post->UserFK = $userData->userid;
    $postRepository = new PostRepository(new DatabaseService());

    $message = $postRepository->CreatePost($post);
    echo $message;
}
else
{
    //http_response_code(401);
    echo json_encode(array(
        "message" => "Access denied."
    ));
}