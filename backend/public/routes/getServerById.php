<?php
require("../../_inc/init.php");
check_request_method($_SERVER['REQUEST_METHOD'], "GET");
$data = $_GET;
if (empty($data['serverId'])  || !is_numeric($data['serverId'])) {
    $errors[] = 'invalid ID Server';
    $res->set_status("error");
    $res->set_error_message("Invalid Form");
    $res->set_response_data($errors);
    $res->response();
    exit;
}
$serverId = $data["serverId"];
$sql = "SELECT * FROM server WHERE id = :id";
$params = ["id"=>$serverId];

$response = $db->execute_query($sql,$params);

if ($response->status != 'success' || empty($response->results)) {
    $res->set_status('error');
    $res->set_error_message("servidor inexistente");
    $res->response();
    exit;
}
$res->set_response_data($response->results);

$res->response();
