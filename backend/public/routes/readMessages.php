<?php
require("../../_inc/init.php");
require_once __DIR__ . '/../../_inc/filters/isLogged.php';
check_request_method($_SERVER['REQUEST_METHOD'], "PATCH");
//verificar se tem um array de ids
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['ids']) || !is_array($data['ids'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Parâmetro "ids" ausente ou inválido.']);
    exit;
}

$ids = $data['ids'];

$idsList = implode(',', array_map('intval', $ids));

$jwt = new JwtAuth();
$tokenJWT = $jwt->get_jwt_by_header();
$resultJWT = $jwt->validate_token($tokenJWT);
$user_id = $resultJWT['id'];

$sql = "UPDATE message SET is_read = TRUE WHERE id IN (:ids) AND receiver_id = :user_id";
$params = ["user_id" => $user_id,"ids"=>$idsList];
$response = $db->execute_non_query($sql, $params);
if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message($response->mensagem);
    $res->response();
    exit;
}
$res->response();
exit;


?>