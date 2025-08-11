<?php
require("../../_inc/init.php");

require_once __DIR__ . '/../../_inc/filters/isLogged.php';

check_request_method($_SERVER['REQUEST_METHOD'], "GET");

$jwt = new JwtAuth();
$tokenJWT = $jwt->get_jwt_by_header();
$resultJWT = $jwt->validate_token($tokenJWT);

$user_id = $resultJWT['id'];

$user_query_id = isset($_GET["user_id"])
    ? ($_GET["user_id"] === "mine" ? $user_id : $_GET["user_id"])
    : null;
if ($user_query_id === null) {
    $res->set_status("error");
    $res->set_error_message("Invalid Form");
    $res->response();
    exit;
}

$sql = "SELECT user.*, c.name as campus_name
FROM user 
INNER JOIN campus c ON user.campus_id = c.id 
WHERE user.id = :user_id
";
$params = ['user_id' => $user_query_id];
$response = $db->execute_query($sql, $params);


if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message($response->mensagem);
    $res->response();
    exit;
}
$data = [];
$data["user"] = $response->results[0];

$sql = "SELECT * FROM address WHERE user_id = :user_query_id";
$params = ['user_query_id' => $user_query_id];
$response = $db->execute_query($sql, $params);


if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message($response->mensagem);
    $res->response();
    exit;
}
if ($response->results == []) {
    $res->set_response_data($data);

    $res->response();
    exit;
}
$data["address"] = $response->results[0];

$sql = "SELECT COUNT(*) AS following_count FROM follower WHERE follower_id = :user_id";
$params = ['user_id' => $user_query_id];
$response = $db->execute_query($sql, $params);
if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message($response->mensagem);
    $res->response();
    exit;
}
$data["following_count"] = $response->results[0];

// Conta quantos usuários seguem o user (followers_count)
$sql = "SELECT COUNT(*) AS followers_count FROM follower WHERE followed_id = :user_id";
$params = ['user_id' => $user_query_id];
$response = $db->execute_query($sql, $params);
if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message($response->mensagem);
    $res->response();
    exit;
}
$data["followers_count"] = $response->results[0];


$res->set_response_data($data);
$res->response();
exit;
