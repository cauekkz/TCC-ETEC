<?php 
require("../../_inc/init.php");
require_once __DIR__ . '/../../_inc/filters/isLogged.php';

check_request_method($_SERVER['REQUEST_METHOD'], "GET");
$server_id;
if (isset($_GET['server_id'])) {
    $server_id = $_GET['server_id'];
} else {
    $res->set_status('error');
    $res->set_error_message("erro ao pegar avisos");
    $res->response();
    exit;
}
//dps se dar na telha fazer paginizado
$sql = "SELECT * FROM notice n where n.server_id = :server_id ORDER BY n.created_at DESC;";
$params = ['server_id' => $server_id];

$response = $db->execute_query($sql, $params);
if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message("erro ao pegar posts");
    $res->response();
    exit;
}
$res->set_response_data($response->results);
$res->response();






?>