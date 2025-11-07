<?php
require("../../_inc/init.php");
require_once __DIR__ . '/../../_inc/filters/isLogged.php';
check_request_method($_SERVER['REQUEST_METHOD'], "GET");
$data = $_GET;

$event_id;
if(isset($_GET['id'])){
    $event_id = $data["id"];
} else {
    $res->set_status('error');
    $res->set_error_message("erro ao pegar posts");
    $res->response();
    exit;
}

$jwt = new JwtAuth();
$tokenJWT = $jwt->get_jwt_by_header();
$resultJWT = $jwt->validate_token($tokenJWT);


$sql = "SELECT * FROM event_participants WHERE event_id = :id";
$params = ["id"=>$event_id];
$response = $db->execute_query($sql, $params);

if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message($response->mensagem);
    $res->response();
    exit;
}
$res->set_response_data($response->results);

$res->response();