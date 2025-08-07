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

$sql = "SELECT * FROM user WHERE id = :user_id";
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

$Address_id = $response->results[0]->address_id;
if ($Address_id == null) {

    $res->set_response_data($data);
    $res->response();
    exit;
}


$sql = "SELECT * FROM address WHERE id = :Address_id";
$params = ['Address_id' => $Address_id];
$response = $db->execute_query($sql, $params);


if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message($response->mensagem);
    $res->response();
    exit;
}
$data["address"] = $response->results[0];



$res->set_response_data($data);
$res->response();
exit;
