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
if($jwt == null)
    $jwt = "";
$userData = TokenManager::CheckToken($jwt);



if($userData != null)
{
    $postRepository = new PostRepository(new DatabaseService());
    $toUpdate = $postRepository->GetPost($data->ID);
    if($toUpdate->UserFK == $userData->userid)
    {
        $postID = $data->ID;
        
        $message = $postRepository->DeletePost($postID);
        echo $message;
    }
    else
    {
        //http_response_code(401);
        echo json_encode(array(
            "message" => "Access denied."
        ));
    }
}
else
{
    //http_response_code(401);
    echo json_encode(array(
        "message" => "Access denied."
    ));
}