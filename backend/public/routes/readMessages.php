<?php
require("../../_inc/init.php");
require_once __DIR__ . '/../../_inc/filters/isLogged.php';
check_request_method($_SERVER['REQUEST_METHOD'], "PATCH");


$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['ids']) || !is_array($data['ids']) || empty($data['ids'])) {
    http_response_code(400);
    echo json_encode(['error' => 'É necessário um array de IDs para ler mensagens']);
    exit;
}

$ids = $data['ids'];

$jwt = new JwtAuth();
$tokenJWT = $jwt->get_jwt_by_header();
$resultJWT = $jwt->validate_token($tokenJWT);
$user_id = $resultJWT['id'];
$placeholders = [];
$params = ["user_id" => $user_id];

foreach ($ids as $index => $id) {

    $key = ":id_{$index}";
    $placeholders[] = $key;
    $params[$key] = (int) $id;
}

$ids_placeholder_string = implode(', ', $placeholders);


$sql = "UPDATE message SET is_read = TRUE WHERE id IN ({$ids_placeholder_string}) AND receiver_id = :user_id";

$response = $db->execute_non_query($sql, $params);

if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message("erro ao ler mensagens");
    $res->response();
    exit;
}

$res->response();
exit;