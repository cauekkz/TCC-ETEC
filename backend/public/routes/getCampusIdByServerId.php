<?php
require("../../_inc/init.php");
check_request_method($_SERVER['REQUEST_METHOD'], "GET");
if (empty($_GET["server_id"])) {
    $res->set_status("error");
    $res->set_error_message("Invalid Form");
    $res->response();
    exit;
}
$server_id = $_GET["server_id"];
$sql = "SELECT s.campus_id FROM server s
WHERE s.id = :server_id";
$params = ["server_id"=>$server_id];
$response = $db->execute_query($sql,$params);
if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message($response->mensagem);
    $res->response();
    exit;
}
$res->set_response_data($response->results);
$res->response();