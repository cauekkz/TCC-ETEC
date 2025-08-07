<?php
require("../../_inc/init.php");
require("../../_inc/jwt.php");
require("../../_inc/refreshToken.php");

require_once __DIR__ . '/../../_inc/validation/loginValidator.php';

check_request_method($_SERVER['REQUEST_METHOD'], "POST");

$data = json_decode(file_get_contents('php://input'), true);
$errors = validate($data);

if (!empty($errors)) {
    $res->set_status("error");
    $res->set_error_message("Invalid Form");
    $res->set_response_data($errors);
    $res->response();
    exit;
}

$email = $data["email"];
$password = $data['password'];

$sql = "select id,name,email,password_hash,role from user where email = :email";
$params = ['email' => $email];
$response = $db->execute_query($sql, $params);

if (empty($response->results) && $response->mensagem != "success") {
    $res->set_status("error");
    $res->set_error_message("non-existent email");

    $res->response();
    exit;
}

$user = $response->results[0];

if (!password_verify($password, $user->password_hash)) {
    $res->set_status("error");
    $res->set_error_message("incorrect password");

    $res->response();
    exit;
}


$refreshToken = RefreshToken::generate_token();
$refreshToken->user_id = $user->id;
$resultSaveToken = RefreshToken::save_token($refreshToken, $db);

if (!$resultSaveToken) {
    $res->set_aditional_fields("warning", "refresh token not created");
} else {
    $twoWeeks = 60 * 60 * 24 * 14;
    setcookie('refreshToken', $refreshToken->token, time() + $twoWeeks, '/', '', false, false);
}


$jwt = new JwtAuth();
//yeh
$tokenJWT = $jwt->generate_token_user($user);

$res->set_response_data($tokenJWT);

$res->response();

exit;
