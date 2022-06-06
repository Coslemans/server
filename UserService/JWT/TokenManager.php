<?php

include_once "../JWT/TokenManager.php";
require "../vendor/autoload.php";
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

class TokenManager
{
    private static $secret_key ="parola_foarte_secreta";
    private static $issuer_claim = "SharePostsAPI";
    private static $audience_claim = "UserJWT";

    public static function CreateToken($id, $email)
    {
        $issuedat_claim = time();
        $notbefore_claim = $issuedat_claim + 10;
        $expire_claim = $issuedat_claim + 600;
        $token = array(

            "iss" => self::$issuer_claim,
            "aud" => self::$audience_claim,
            "iat" => $issuedat_claim,
            "nbf" => $notbefore_claim,
            "exp" => $expire_claim,
            "data" => array(
                "userid" => $id,
                "email" => $email
            ));

        $jwt = JWT::encode($token,self::$secret_key,'HS256');
        return array(
            "message" => "Successful login.",
            "jwt" => $jwt,
            "email" => $email
        );
    }

    public static function CheckToken($jwt)
    {
        try{
            $decoded = JWT::decode($jwt,new Key(self::$secret_key, 'HS256'));
            return $decoded->data;
        }catch (Exception $e)
        {
            return null;
        }

    }

}