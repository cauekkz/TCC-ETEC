<?php
require("../../_inc/init.php");
require_once "../../_inc/refreshToken.php";
require("../../_inc/jwt.php");


if (!isset($_COOKIE["refreshToken"])) {
    $res->set_status('error');
    $res->set_error_message("Logg in");
    $res->response();
    exit;
}
$refresh_token = $_COOKIE["refreshToken"] ?? null;

$user_id = RefreshToken::validate_token($refresh_token, $db)->user_id;
if (!$user_id) {
    $res->set_status('error');
    $res->set_error_message("Logg in");
    $res->response();
    exit;
}

$sql = "select id,name,email,password_hash,role from user where id = :id";
$params = ['id' => $user_id];
$response = $db->execute_query($sql, $params);

$user = $response->results[0];

$jwt = new JwtAuth();

$tokenJWT = $jwt->generate_token_user($user);

$res->set_response_data($tokenJWT);

$res->response();
